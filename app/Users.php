<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Crypt;
use Laravel\Fortify\Contracts\TwoFactorAuthenticationProvider;
use Laravel\Fortify\TwoFactorAuthenticatable;

/**
 * App\Users
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $password
 * @property string|null $adress
 * @property string|null $phone
 * @property string|null $presentation
 * @property string|null $jobTitle
 * @property string|null $firstName
 * @property string|null $lastName
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $image
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Infos> $infos
 * @property-read int|null $infos_count
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\post> $posts
 * @property-read int|null $posts_count
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Role> $roles
 * @property-read int|null $roles_count
 * @method static \Illuminate\Database\Eloquent\Builder|Users newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Users newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Users query()
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereAdress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereJobTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users wherePhone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users wherePresentation($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereRole($role)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereUpdatedAt($value)
 * @property string|null $two_factor_secret
 * @property string|null $two_factor_recovery_codes
 * @property string|null $two_factor_confirmed_at
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereTwoFactorConfirmedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereTwoFactorRecoveryCodes($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Users whereTwoFactorSecret($value)
 * @mixin \Eloquent
 */
class Users extends Authenticatable
{
    use GetImage;
    use HasRoles;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'two_factor_recovery_codes',
        'two_factor_secret',
        'password', 'remember_token',
    ];


    public function name ()  {
        return \Attribute::make(
            get: fn ($value) => Crypt::decryptString($value),
            set: fn ($value) => Crypt::encryptString($value),
        );
    }

    public function email ()  {
        return \Attribute::make(
            get: fn ($value) => Crypt::decryptString($value),
            set: fn ($value) => Crypt::encryptString($value),
        );
    }

    public function password ()  {
        return \Attribute::make(
            get: fn ($value) => Crypt::decryptString($value),
            set: fn ($value) => Crypt::encryptString($value),
        );
    }

    public function roles(){
        return $this->belongsToMany(Role::class);
    }

    public function posts()
    {
        return $this->hasMany('App\post');
    }

    public function imageClass(): BelongsTo
    {
        return $this->belongsTo(\App\Image::class);
    }

    public function infos(){
        return $this->hasMany('App\Infos');
    }

    public function confirmTwoFactorAuth($code)
    {
        $codeIsValid = app(TwoFactorAuthenticationProvider::class)
            ->verify(decrypt($this->two_factor_secret), $code);

        if ($codeIsValid) {
            $this->two_factor_confirmed_at = \carbon()->now();
            $this->save();

            return true;
        }

        return false;
    }
}
