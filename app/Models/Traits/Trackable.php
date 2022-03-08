<?php

namespace App\Models\Traits;

use App\Models\User;
use Illuminate\Support\Str;
use App\Notifications\ActivityRecorded;
use Illuminate\Support\Facades\Notification;

trait Trackable 
{
    protected static function bootTrackable()
    {
        $admins = User::onlyAdmins()->onlyAdmins()->get();

        static::created(function($record) use ($admins) {
            $parts = explode('\\', get_class($record));
            $model = end($parts);
            Notification::send($admins, new ActivityRecorded($model, $record, auth()->user(), 'create'));
        });

        static::updated(function($record) use ($admins) {
            $parts = explode('\\', get_class($record));
            $model = end($parts);
            Notification::send($admins, new ActivityRecorded($model, $record, auth()->user(), 'update'));
        });

        static::deleted(function($record) use ($admins) {
            $parts = explode('\\', get_class($record));
            $model = end($parts);
            Notification::send($admins, new ActivityRecorded($model, $record, auth()->user(), 'delete'));
        });
    }
}
