<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ActivityRecorded extends Notification
{
    public $model;
    public $record;
    public $causer;
    public $action;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($model, $record, $causer, $action)
    {
        $this->model = $model;
        $this->record = $record;
        $this->causer = $causer;
        $this->action = $action;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'model' => $this->model,
            'record' => $this->record,
            'causer' => $this->causer,
            'action' => $this->action
        ];
    }
}
