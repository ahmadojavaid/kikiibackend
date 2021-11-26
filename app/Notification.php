<?php

namespace App;

use DateTimeInterface;
use Illuminate\Notifications\DatabaseNotification;

class Notification extends DatabaseNotification
{
    /**
     * Prepare a date for array / JSON serialization.
     *
     * @param  \DateTimeInterface  $date
     * @return string
     */
    protected function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::parse($value)->diffForHumans(null, false, true);
    }
}