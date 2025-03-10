<?php

use App\Http\Controllers\TwoFactorAuthController;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\RegisteredUserController;
use Laravel\Fortify\Http\Controllers\PasswordResetLinkController;
use Laravel\Fortify\Http\Controllers\NewPasswordController;
use Laravel\Fortify\Http\Controllers\ConfirmablePasswordController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticatedSessionController;
use Laravel\Fortify\Http\Controllers\TwoFactorAuthenticationController;
use Laravel\Fortify\Http\Controllers\ProfileInformationController;
use Laravel\Fortify\Http\Controllers\ProfilePhotoController;
use Laravel\Fortify\Http\Controllers\PasswordController;
use Laravel\Fortify\Http\Controllers\EmailVerificationNotificationController;
use Laravel\Fortify\Http\Controllers\EmailVerificationPromptController;
use Laravel\Fortify\Http\Controllers\VerifyEmailController;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

Route::feeds();
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::get("sitemap.xml" , function () {
    $SitemapGenerator = Sitemap::create(config()->get('app.url'));
    foreach( \App\post::where('status',0)->orderBy('updated_at','desc')->get() as $post ) {
        $SitemapGenerator
            ->add( Url::create(route("post", $post->slug))
                ->setLastModificationDate(Carbon::parse($post->updated_at))
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
            );

    }

    $SitemapGenerator->add( Url::create(route("default",))
        ->setLastModificationDate(Carbon::today())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
    );
    $SitemapGenerator->add( Url::create(route("about"))
        ->setLastModificationDate(Carbon::today())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)
    );
    $SitemapGenerator->add( Url::create(route("contact"))
        ->setLastModificationDate(Carbon::today())
        ->setChangeFrequency(Url::CHANGE_FREQUENCY_NEVER)
    );
    if ( File::exists(resource_path('sitemap.xml')) )
        File::delete(resource_path('sitemap.xml'));
    $SitemapGenerator->writeToFile(resource_path('sitemap.xml'));
    return response(file_get_contents(resource_path('sitemap.xml')), 200, [
        'Content-Type' => 'application/xml'
    ]);
});


Route::group(['middleware' => 'firewall.all'], function () {
    Route::get('/', 'PageController@index')->name("default");
    Route::get('/about', 'PageController@about')->name('about');
    Route::get('/contact', 'PageController@contact')->name('contact');
    Route::post('/contact', 'PageController@send')->name('send');
    Route::post('/comment/{id}', 'PageController@comment')->name('send_comment')->where("id", "[0-9A-Za-z\-]+");
    Route::get('/archive', 'PageController@index')->name('archive');
    Route::get('/archive/{tagId}', 'PageController@index')->name('archiveByTag')->where('tagId', "[0-9A-Za-z\-]+");
    Route::get('/post/{slug}', 'PageController@post')->name('post')->where('slug', "[0-9A-Za-z\-]+");
    Route::get('/adminhome', 'HomeController@index')->name('admin');
    
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('admin_login');
    Route::post('login', [AuthenticatedSessionController::class, 'store'])->name('admin_login_post');
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('get-logout');
    Route::post('register', [RegisteredUserController::class, 'store'])->middleware('honeypot');
    Route::get('two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create'])->name('two-factor.login');
    Route::post('two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store']);
    Route::get("recupForm",function(){
        return view("auth.recup-code");
    })->name("recupForm");

    Route::group(['prefix'=>'api'],function(){
        Route::post('comment', 'ApiController@PostComment')->name('api_comment');
        Route::get('comment/{id}', 'ApiController@GetComment')->name('api_comment_get')->where("id", "[0-9]+");
        Route::post('contact', 'ApiController@PostContact')->name('api_contact');
    });

});

Route::group(['prefix' => 'admin', 'middleware' => ["role:admin,user",'firewall.all']], function () {

        Route::post('user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store'])->name('two-factor.enable');
        Route::delete('user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy'])->name('two-factor.disable');
        Route::post('/2fa-confirm', [TwoFactorAuthController::class, 'confirm'])->name('twofactorconfirm');
        Route::group(['prefix' => 'tags'], function () {
            Route::get('/', 'TagsController@index')->name('admin_tags');
            Route::get('/ajax', 'TagsController@ajax')->name('admin_tags_ajax');
            Route::get('/title', 'TagsController@isUnique')->name('admin_tags_isUnique');
            Route::post('/insert', 'TagsController@store')->name('admin_tags_insert');
            Route::post('/update/{id}', 'TagsController@update')->name('admin_tags_update')->where("id", "[0-9A-Za-z\-]+");
            Route::get('/delete/{id}', 'TagsController@destroy')->name('admin_tags_delete')->where("id", "[0-9A-Za-z\-]+");
            Route::get('/create', 'TagsController@create_tags')->name('admin_tags_create');
            Route::get('/{id}', 'TagsController@edit')->name('admin_tags_edit');

        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'UsersController@current')->name('admin_user');
            Route::get('/delete/{id}', 'UsersController@delete')->name('admin_user_delete')->where("id", "[0-9A-Za-z\-]+");
            Route::get('/edit/{id}', 'UsersController@edit')->name('admin_user_edit')->where("id", "[0-9A-Za-z\-]+");
            Route::post('/{id}', 'UsersController@update')->name('admin_user_update')->where("id", "[0-9A-Za-z\-]+");
        });

        Route::group(["prefix" => "posts"], function () {
            Route::get('/', 'PostController@index')->name('admin_posts');
            Route::get('/create', 'PostController@create')->name('admin_posts_create');
            Route::get('/ajax/{title}', 'PostController@ajax')->name('admin_posts_ajax')->where("title", "[0-9A-Za-z\-]+");
            Route::get('/title', 'PostController@isUnique')->name('admin_posts_unique');
            Route::post('/insert', 'PostController@store')->name('admin_posts_insert');
            Route::get('/{id}', 'PostController@edit')->name('admin_posts_edit');
            Route::post('/update/{id}', 'PostController@update')->name('admin_posts_update')->where("id", "[0-9A-Za-z\-]+");
        });
        Route::group(["prefix" => "infos", "middleware" => "role:admin"], function () {
            Route::get('/', 'InfosController@index')->name('admin_infos');
            Route::get('/create', 'InfosController@create')->name('admin_infos_create');
            Route::get('/title', 'InfosController@isUnique')->name('admin_info_unique');
            Route::post('/insert', 'InfosController@store')->name('admin_infos_insert');
            Route::get('/{id}', 'InfosController@edit')->name('admin_infos_edit');
            Route::post('/update/{id}', 'InfosController@update')->name('admin_infos_update')->where("id", "[0-9A-Za-z\-]+");
        });

        Route::group(["prefix" => "options", "middleware" => "role:admin"], function () {
            Route::get('/', 'OptionsController@index')->name('admin_options');
            Route::get('/create', 'OptionsController@create')->name('admin_options_create');
            Route::post('/insert', 'OptionsController@store')->name('admin_options_insert');
            Route::get('/{id}', 'OptionsController@edit')->name('admin_options_edit')->where("id", "[0-9A-Za-z\-]+");
            Route::post('/update/{id}', 'OptionsController@update')->name('admin_options_update')->where("id", "[0-9A-Za-z\-]+");
        });
        Route::group(["prefix" => "files"], function () {
            Route::get('/', 'FileController@index')->name('admin_files');
            Route::get('/ajax', 'FileController@ajax')->name('admin_files_ajax');
            Route::get('/title', 'FileController@isUnique')->name('admin_files_unique');
            Route::get('/hash', 'FileController@md5Exist')->name('admin_files_unique');
            Route::get('/create', 'FileController@create')->name('admin_files_create');
            Route::post('/store', 'FileController@store')->name('admin_files_store');
        });

        Route::group(["prefix" => "message", "middleware" => "role:admin"], function () {
            Route::get('/', 'MessageController@index')->name('admin_msg');
            Route::get('/show/{id}', 'MessageController@show')->name('admin_msg_show')->where("id", "[0-9A-Za-z\-]+");

        });

        Route::group(["prefix" => "comment", "middleware" => "role:admin"], function () {
            Route::get('/', 'CommentController@index')->name('admin_comment');
            Route::get('/{post_id}', 'CommentController@commentByPost')->name('admin_comment_by_post')->where("post_id", "[0-9A-Za-z\-]+");
        });

        Route::group(["prefix" => "ipban", "middleware" => "role:admin"], function () {
            Route::get('/', 'IpBanController@index')->name('admin_ipban');
        });


});


?>
