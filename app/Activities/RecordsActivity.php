<?php

namespace App\Activities;

use App\Models\Activity;
use ReflectionClass;

/**
 * Trait RecordsActivity
 *
 * @package App\Activities
 */
trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        foreach (static::getModelEvents() as $event) {
            static::$event(function ($model) use ($event) {
                $model->recordActivity($event);
            });
        }
    }

    /**
     * @return array
     */
    protected static function getModelEvents()
    {
        if (isset(static::$recordEvents)) {
            return static::$recordEvents;
        }

        return [
            'created',
            'deleted',
            'updated'
        ];
    }

    /**
     * @param $event
     * @param  null  $date
     * @throws \ReflectionException
     */
    public function recordActivity($event, $date = null)
    {
        if (auth()->check()) {
            $actor = auth()->user();

            $this->activity()->create([
                'name' => $this->getActivityName($event),
                'user_id' => $actor->id,
                'subject_id' => $this->id,
                'subject_type' => get_class($this),
                'division_id' => $actor->member->division_id,
                'created_at' => $date ?? now(),
                'updated_at' => $date ?? now(),
            ]);
        }
    }

    /**
     * @return mixed
     */
    public function activity()
    {
        return $this->morphOne(Activity::class, 'subject')
            ->orderBy('created_at', 'desc');
    }

    /**
     * @param $action
     * @return string
     * @throws \ReflectionException
     */
    protected function getActivityName($action)
    {
        $name = strtolower((new ReflectionClass($this))->getShortName());

        return "{$action}_{$name}";
    }
}
