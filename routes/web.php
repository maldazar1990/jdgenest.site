<?php

use App\Http\Controllers\TwoFactorAuthController;
use Illuminate\Support\Facades\Auth;
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

Route::feeds();


if (!function_exists("crawlerDetect")) {
    function crawlerDetect($USER_AGENT)
    {
        $crawlers = array(
            'Google' => 'Google',
            'MSN' => 'msnbot',
            'Rambler' => 'Rambler',
            'Yahoo' => 'Yahoo',
            'AbachoBOT' => 'AbachoBOT',
            'accoona' => 'Accoona',
            'AcoiRobot' => 'AcoiRobot',
            'ASPSeek' => 'ASPSeek',
            'CrocCrawler' => 'CrocCrawler',
            'Dumbot' => 'Dumbot',
            'FAST-WebCrawler' => 'FAST-WebCrawler',
            'GeonaBot' => 'GeonaBot',
            'Gigabot' => 'Gigabot',
            'Lycos spider' => 'Lycos',
            'MSRBOT' => 'MSRBOT',
            'Altavista robot' => 'Scooter',
            'AltaVista robot' => 'Altavista',
            'ID-Search Bot' => 'IDBot',
            'eStyle Bot' => 'eStyle',
            'Scrubby robot' => 'Scrubby',
            'Facebook' => 'facebookexternalhit',
        );
        // to get crawlers string used in function uncomment it
        // it is better to save it in string than use implode every time
        // global $crawlers
        $crawlers_agents = implode('|', $crawlers);
        if (strpos($crawlers_agents, $USER_AGENT) === false)
            return false;
        else {
            return TRUE;
        }
    }
}
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
    
    Route::get('login', [AuthenticatedSessionController::class, 'create']);
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('logout', [AuthenticatedSessionController::class, 'destroy'])->name('get-logout');
    Route::post('register', [RegisteredUserController::class, 'store'])->middleware('honeypot');
    
    // Two-factor authentication routes
    Route::get('email/verify', [EmailVerificationPromptController::class, '__invoke'])->name('verification.notice');
    Route::get('email/verify/{id}/{hash}', [VerifyEmailController::class, '__invoke'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('email/verification-notification', [EmailVerificationNotificationController::class, 'store'])->middleware(['throttle:6,1'])->name('verification.send');
    
});

Route::group(['prefix' => 'admin', 'middleware' => ["role:admin,user","searchbot",'firewall.all']], function () {
        Route::get('two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'create']);
        Route::post('two-factor-challenge', [TwoFactorAuthenticatedSessionController::class, 'store']);
        Route::post('user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'store']);
        Route::delete('user/two-factor-authentication', [TwoFactorAuthenticationController::class, 'destroy']);
        Route::post('/2fa-confirm', [TwoFactorAuthController::class, 'confirm'])->name('twofactorconfirm');


        Route::group(['prefix' => 'tags'], function () {
            Route::get('/', 'TagsController@index')->name('admin_tags');
            Route::get('/ajax', 'TagsController@ajax')->name('admin_tags_ajax');
            Route::post('/insert', 'TagsController@store')->name('admin_tags_insert');
            Route::post('/update/{id}', 'TagsController@update')->name('admin_tags_update')->where("id", "[0-9A-Za-z\-]+");
            Route::get('/delete/{id}', 'TagsController@destroy')->name('admin_tags_delete')->where("id", "[0-9A-Za-z\-]+");
            Route::get('/create', 'TagsController@create_tags')->name('admin_tags_create');
            Route::get('/{id}', 'TagsController@edit')->name('admin_tags_edit');

        });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/', 'UsersController@current')->name('admin_user');
            Route::get('/index', 'UsersController@index')->name('admin_user_list');
            Route::get('/create', 'UsersController@create')->name('admin_user_create');
            Route::post('/store', 'UsersController@store')->name('admin_user_store');
            Route::get('/delete/{id}', 'UsersController@delete')->name('admin_user_delete')->where("id", "[0-9A-Za-z\-]+");
            Route::get('/edit/{id}', 'UsersController@edit')->name('admin_user_edit')->where("id", "[0-9A-Za-z\-]+");
            Route::post('/{id}', 'UsersController@update')->name('admin_user_update')->where("id", "[0-9A-Za-z\-]+");
        });

        Route::group(["prefix" => "posts"], function () {
            Route::get('/', 'PostController@index')->name('admin_posts');
            Route::get('/create', 'PostController@create')->name('admin_posts_create');
            Route::get('/ajax/{title}', 'PostController@ajax')->name('admin_posts_ajax')->where("title", "[0-9A-Za-z\-]+");
            Route::post('/insert', 'PostController@store')->name('admin_posts_insert');
            Route::get('/{id}', 'PostController@edit')->name('admin_posts_edit');
            Route::post('/update/{id}', 'PostController@update')->name('admin_posts_update')->where("id", "[0-9A-Za-z\-]+");
            Route::get('/delete/{id}', 'PostController@destroy')->name('admin_posts_delete')->where("id", "[0-9A-Za-z\-]+");
        });
        Route::group(["prefix" => "infos", "middleware" => "role:admin"], function () {
            Route::get('/', 'InfosController@index')->name('admin_infos');
            Route::get('/create', 'InfosController@create')->name('admin_infos_create');
            Route::post('/insert', 'InfosController@store')->name('admin_infos_insert');
            Route::get('/{id}', 'InfosController@edit')->name('admin_infos_edit');
            Route::post('/update/{id}', 'InfosController@update')->name('admin_infos_update')->where("id", "[0-9A-Za-z\-]+");
            Route::get('/delete/{id}', 'InfosController@destroy')->name('admin_infos_delete')->where("id", "[0-9A-Za-z\-]+");
        });

        Route::group(["prefix" => "options", "middleware" => "role:admin"], function () {
            Route::get('/', 'OptionsController@index')->name('admin_options');
            Route::get('/create', 'OptionsController@create')->name('admin_options_create');
            Route::post('/insert', 'OptionsController@store')->name('admin_options_insert');
            Route::get('/{id}', 'OptionsController@edit')->name('admin_options_edit')->where("id", "[0-9A-Za-z\-]+");
            Route::post('/update/{id}', 'OptionsController@update')->name('admin_options_update')->where("id", "[0-9A-Za-z\-]+");
            Route::get('/delete/{id}', 'OptionsController@destroy')->name('admin_options_delete')->where("id", "[0-9A-Za-z\-]+");
            Route::post('/insertMenu', 'OptionsController@menu')->name('admin_options_menu');
            Route::get('/modifyMenu', 'OptionsController@modifyMenu')->name('admin_options_menu_index');
        });
        Route::group(["prefix" => "files"], function () {
            Route::get('/', 'FileController@index')->name('admin_files');
            Route::get('/ajax', 'FileController@ajax')->name('admin_files_ajax');
            Route::get('/delete', 'FileController@delete')->name('admin_files_delete');
            Route::get('/create', 'FileController@create')->name('admin_files_create');
            Route::post('/store', 'FileController@store')->name('admin_files_store');

        });

        Route::group(["prefix" => "message", "middleware" => "role:admin"], function () {
            Route::get('/', 'MessageController@index')->name('admin_msg');
            Route::get('/show/{id}', 'MessageController@show')->name('admin_msg_show')->where("id", "[0-9A-Za-z\-]+");
            Route::get('/delete/{id}', 'MessageController@destroy')->name('admin_msg_delete')->where("id", "[0-9A-Za-z\-]+");
            Route::post('/deleteall', 'MessageController@deleteAll')->name('admin_msg_delete_all');
            Route::get('/ban/{id}', 'MessageController@ban')->name('admin_msg_ban')->where("id", "[0-9A-Za-z\-]+");

        });

        Route::group(["prefix" => "comment", "middleware" => "role:admin"], function () {
            Route::get('/', 'CommentController@index')->name('admin_comment');
            Route::get('/delete/{id}', 'CommentController@destroy')->name('admin_comment_delete')->where("id", "[0-9A-Za-z\-]+");
            Route::get('/ban/{id}', 'CommentController@ban')->name('admin_comment_ban')->where("id", "[0-9A-Za-z\-]+");
            Route::post('/deleteall', 'CommentController@deleteAll')->name('admin_comment_delete_all');

        });

        Route::group(["prefix" => "ipban", "middleware" => "role:admin"], function () {
            Route::get('/', 'IpBanController@index')->name('admin_ipban');
            Route::get('/delete/{id}', 'IpBanController@destroy')->name('admin_ipban_delete')->where("id", "[0-9A-Za-z\-]+");
            Route::post('/deleteall', 'IpBanController@deleteAll')->name('admin_ipban_delete_all');

        });


});


?>
