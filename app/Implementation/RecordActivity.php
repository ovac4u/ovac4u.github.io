<?php
namespace App\Implementation;

trait RecordActivity
{
    /**
     * Basically like writing a boot method on the model
     * This method is automatically fired when the model that implements it
     * creates a record.
     */
    protected static function bootRecordActivity()
    {
        static::created(function ($order) {
            $order->recordActivity('created');
        });
    }

    /**
     * This method actually does the saving of the record
     */
    protected function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'type' => $this->getActivityType($event),
            'description' => auth()->user()->first_name . 'created an other with on' . now(),
            'title' => 'Order created'
        ]);
    }

    /**
     * The type of activity to be recorded on the activities table.
     * @return string
     * Eg: 'created_order', 'updated_order';
     */
    protected function getActivityType($event)
    {
        $type = strtolower((new \ReflectionClass($this))->getShortName());
        return $event . '_' . $type;
    }

    /**
     * Get the activities of the class that will implement this trait
     * @return \Illiminate\Database\Relashionship\MorphMany
     */
    public function activity()
    {
        return $this->morphMany(\App\Activity::class, 'trackable');
    }
}
