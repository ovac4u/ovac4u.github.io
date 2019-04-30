<?php

namespace App;

use App\Implementation\InternationalizePhone;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Carbon;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Passport\HasApiTokens;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements MustVerifyEmail, JWTSubject
{
    use Notifiable;
    use HasApiTokens;
    use LaratrustUserTrait;
    use InternationalizePhone;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'password',
        'username',
        'country',
        'email',
        'dob',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setDobAttribute($date)
    {
        return Carbon::parse($date);
    }

    /**
     * User/Account relationship.
     *
     * @return
     */
    public function accounts()
    {
        return $this->hasMany(LinkedSocialAccount::class);
    }

    /**
     * Full name accessor.
     *
     * @return string The full name of the user.
     */
    public function getNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * User-Phones relationship
     *
     * @return Builder
     */
    public function phones()
    {
        return $this->hasMany(UserPhone::class);
    }

    /**
     * User-Phone relationship (Default phone)
     *
     * @return Builder
     */
    public function defaultPhone()
    {
        return $this->belongsTo(UserPhone::class);
    }

    /**
     * Accessor for retrieving the user's default phone number
     *
     * @return string|null   The user's default phone number.
     */
    public function getPhoneAttribute()
    {
        return optional($this->defaultPhone)->phone;
    }

    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

    /**
     * Get the full name for the authenticated user
     *
     * @return string The user's full name.
     */
    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * Retrieve the user by the given phone number.
     *
     * @param  string $number User's phone number
     * @return User|null
     */
    public static function byDefaultPhone(string $number):  ? User
    {
        $phone = UserPhone::where('phone', (string) phone($number)->formatE164())->whereNotNull('verified_at')->first();

        if ($phone && $phone->isDefaultPhone()) {
            return $phone->user;
        }

        return null;
    }

    /**
     * Generate a short lived 2fa token
     *
     * @return int
     */
    public function get2faToken() : int
    {
        return (int) cache()->remember(
            __METHOD__ . "[$this->id]",
            config('payplux.phone.user_2fa_ttl'),
            function () {
                return mt_rand(100000, 999999);
            }
        );
    }
}
