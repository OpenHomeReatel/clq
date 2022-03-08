<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use SoftDeletes;
    use HasFactory;
 use \App\Models\Traits\Trackable;
    public const TYPE_SELECT = [
        'General Riminder'   => 'General Reminder',
        'Property Viewing'   => 'Property Viewing',
        'Call'               => 'Call',
        'Send Documents'     => 'Send Documents',
        'Meeting'            => 'Meetings',
        'Email'              => 'Email',
        'Payment Collection' => 'Payment Collection',
        'Cheque Submission'  => 'Cheque Submission',
    ];

    public const STATUS_SELECT = [
        'Not Started'            => 'Not Started',
        'In Progress'            => 'In Progress',
        'Waiting For Documents'  => 'Waiting For Documents',
        'Waiting For Approvals'  => 'Waiting For Approvals',
        'Completed-Successful'   => 'Completed-Successful',
        'Completed-Unsuccessful' => 'Completed-Unsuccessful',
        'Escalated to Manager'   => 'Escalated to Manager',
    ];

    public $table = 'tasks';

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $fillable = [
        'type',
        'status',
        'note',
        'date',
        'time',
        'user_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function getDateAttribute($value)
    {
        return $value ? Carbon::parse($value)->format(config('panel.date_format')) : null;
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = $value ? Carbon::createFromFormat(config('panel.date_format'), $value)->format('Y-m-d') : null;
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function serializeDate(DateTimeInterface $date)
    {
        return $date->format('Y-m-d H:i:s');
    }
}
