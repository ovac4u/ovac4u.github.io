<?php

namespace App;

use App\Implementation\InternationalizePhone;
use App\Implementation\VerifiesPhone;
use Illuminate\Database\Eloquent\Model;

class UserPhone extends Model
{
    use InternationalizePhone;
    use VerifiesPhone;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['phone', 'country'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = ['verified_at' => 'date'];

    /**
     * User-Phone relationship
     *
     * @return Builder
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Set the given phone number as the fefault
     * phone number for the user that owns it.
     *
     * @return self
     */
    public function setAsDefault()
    {
        //Get the user using the relationship, then set and save
        //the phone number as the user's default phone number.
        $this->user()->update(['default_phone_id' => $this->id]);

        return $this;
    }

    /**
     * Unset the given  phone number as the default
     * phone number for the user that owns it.
     *
     * @return self
     */
    public function unsetAsDefault()
    {
        //If the current phone number is the default user's phone
        //number, we will set the user's default to null.
        if ($this->isDefaultPhone()) {
            $this->user->update(['default_phone_id' => null]);
        }

        return $this;
    }

    /**
     * Checks if the given phone model has been
     * set as the user's default phone number
     *
     * @return boolean
     */
    public function isDefaultPhone()
    {
        return $this->id === $this->user->default_phone_id;
    }
}
