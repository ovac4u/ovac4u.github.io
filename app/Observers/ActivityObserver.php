<?php

namespace App\Observers;

use App\Contracts\RecordsActivityInterface;

class ActivityObserver
{
    /**
     * Handle the records activity interface "created" event.
     *
     * @param  \App\RecordsActivityInterface  $recordsActivityInterface
     * @return void
     */
    public function created(RecordsActivityInterface $recordsActivityInterface)
    {
        $this->recordActivity($recordsActivityInterface, __FUNCTION__);
    }

    /**
     * Handle the records activity interface "updated" event.
     *
     * @param  \App\RecordsActivityInterface  $recordsActivityInterface
     * @return void
     */
    public function updated(RecordsActivityInterface $recordsActivityInterface)
    {
        $this->recordActivity($recordsActivityInterface, __FUNCTION__);
    }

    /**
     * Handle the records activity interface "deleted" event.
     *
     * @param  \App\RecordsActivityInterface  $recordsActivityInterface
     * @return void
     */
    public function deleted(RecordsActivityInterface $recordsActivityInterface)
    {
        $this->recordActivity($recordsActivityInterface, __FUNCTION__);
    }

    /**
     * Handle the records activity interface "restored" event.
     *
     * @param  \App\RecordsActivityInterface  $recordsActivityInterface
     * @return void
     */
    public function restored(RecordsActivityInterface $recordsActivityInterface)
    {
        $this->recordActivity($recordsActivityInterface, __FUNCTION__);
    }

    /**
     * Handle the records activity interface "force deleted" event.
     *
     * @param  \App\RecordsActivityInterface  $recordsActivityInterface
     * @return void
     */
    public function forceDeleted(RecordsActivityInterface $recordsActivityInterface)
    {
        $this->recordActivity($recordsActivityInterface, __FUNCTION__);
    }

    /**
     * Check if a given activity can be tracked on the given model.
     *
     * @param  RecordsActivityInterface $model
     * @param  string                   $activity  The activity name
     * @return bool
     */
    protected function activityExists(RecordsActivityInterface $model, string $activity): bool
    {
        return property_exists($model, 'records') && is_array($model->records) && in_array($activity, $model->records);
    }

    /**
     * Record the activity
     * @param  RecordsActivityInterface $model
     * @param  string $activity
     * @return void
     */
    protected function recordActivity(RecordsActivityInterface $model, string $activity)
    {
        if ($this->activityExists($model, $activity)) {
            $model->recordActivity($model->activityCreatedBy(), $model->activityTitle($activity), $model->activityDescription($activity));
        }
    }
}
