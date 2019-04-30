<?php

namespace App\Implementation;

use App\Observers\ActivityObserver;

trait RecordsActivity
{
    /**
     * Basically like writing a boot method on the model
     * This method is automatically fired when the model that implements it
     * creates a record.
     */
    protected static function bootRecordsActivity()
    {
        static::observe(ActivityObserver::class);
    }

    /**
     * This method actually does the saving of the record
     */
    public function recordActivity($user_id, $title = 'N/A', $description = 'N/A')
    {
        $this->activities()->create(compact('user_id', 'title', 'description') + ['type' => get_class($this)]);
    }

    /** 
     * Get the activities of the class that will implement this trait
     * @return \Illiminate\Database\Relashionship\MorphMany
     */
    public function activities()
    {
        return $this->morphMany(\App\Activity::class, 'trackable');
    }

    /**
     * Get the activity/event title for the given event.
     *
     * @param  string   $activity   The activity event that was automatically tracked
     * @return string               A title to give to the event.
     */
    public function activityTitle(string $event) : string
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return $event . '_' . $type;
    }

    /**
     * Get the description of the activity/event that has been created.
     *
     * @param  string   $activity   The activity event that was automatically tracked
     * @return string               A description of the event/activity to record
     */
    public function activityDescription(string $event) : string
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return $event . '_' . $type;
    }
}
