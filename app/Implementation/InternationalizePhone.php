<?php

namespace App\Implementation;

/**
 * Save a valid international version of any phone number.
 */
trait InternationalizePhone
{
    /**
     * Hook into the lifecircle of the model consuming this trait.
     *
     * @return void
     */
    public static function bootInternationalizePhone()
    {

        /**
         * In hthe case where the phone number is dirty, we are going to internationalize
         * the phone number using the the country attribute from either the form
         * request of the model values from the table
         */
        static::saving(function ($model) {
            if ($model->isDirty('phone')) {

                //Get the country from either the input or the model values.
                $country = ($model->attributes['country'] ?? $model->country);

                //Set the phone number to the internationalized version of itself.
                $model->phone = (string) phone($model->phone, $country)->formatE164();
            }
        });
    }
}
