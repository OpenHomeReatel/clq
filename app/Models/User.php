<?php

namespace App\Models;

use \DateTimeInterface;
use Carbon\Carbon;
use Hash;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable {

    use SoftDeletes;
    use Notifiable;
    use HasFactory;

    public const IS_TEAM_LEADER_SELECT = [
        '1' => 'Yes',
        '0' => 'No',
    ];

    public $table = 'users';
    protected $hidden = [
        'remember_token',
        'password',
    ];
     protected $appends = [
        'profile',
    ];

    protected $dates = [
        'email_verified_at',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        
        'firstname',
        'lastname',
        'email',
        'email_verified_at',
        'password',
        'mobile',
        'is_team_leader',
        'team_id',
        'remember_token',
        'created_at',
        'updated_at',
        'deleted_at',
    ];
 
    public function getIsAdminAttribute() {
        return $this->roles()->where('id', 1)->exists();
    }

    public function getEmailVerifiedAtAttribute($value) {
        return $value ? Carbon::createFromFormat('Y-m-d H:i:s', $value)->format(config('panel.date_format') . ' ' . config('panel.time_format')) : null;
    }

    public function setEmailVerifiedAtAttribute($value) {
        $this->attributes['email_verified_at'] = $value ? Carbon::createFromFormat(config('panel.date_format') . ' ' . config('panel.time_format'), $value)->format('Y-m-d H:i:s') : null;
    }

    public function setPasswordAttribute($input) {
        if ($input) {
            $this->attributes['password'] = app('hash')->needsRehash($input) ? Hash::make($input) : $input;
        }
    }

    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPassword($token));
    }

    public function roles() {
        return $this->belongsToMany(Role::class);
    }

     public function getProfileAttribute()
    {
        try {
            $file = $this->getMedia('profile')->last();
            if ($file) {
                $file->url       = $file->getUrl();
                $file->thumbnail = $file->getUrl('thumb');
                $file->preview   = $file->getUrl('preview');
            }
    
            return $file;
        } catch (\Exception $ex) {
            return null;
        }
    }
   
    public function team() {
        return $this->belongsTo(Team::class, 'team_id');
    }

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }

    public function getFullNameAttribute() {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function scopeOnlyAdmins($query) {
        return $query->whereHas('roles', function ($query) {
                    return $query->where('title', Role::ROLE_ADMIN);
                });
    }

    public function scopeOnlyListings($query) {
        return $query->whereHas('roles', function ($query) {
            return $query->where('title', Role::ROLE_LISTINGS);
        });
    }
 
    public function scopeOnlySales($query) {
        return $query->whereHas('roles', function ($query) {
            return $query->where('title', Role::ROLE_SALES);
        });
    }

    public function getUnreadNotificationsFormatted() {
        return $this->unreadNotifications->map(function ($notification) {
                    return [
                'create' => 'New ' . $notification->data['model'] . ' N°: ' . $notification->data['record']['ref'] . ' has been created by ' . $notification->data['causer']['firstname'] . ' ' . $notification->data['causer']['lastname'],
                'update' => 'The ' . $notification->data['model'] . ' N°: ' . $notification->data['record']['ref'] . ' has been updated by ' . $notification->data['causer']['firstname'] . ' ' . $notification->data['causer']['lastname'],
                'delete' => 'The ' . $notification->data['model'] . ' N°: ' . $notification->data['record']['ref'] . ' has been deleted by ' . $notification->data['causer']['firstname'] . ' ' . $notification->data['causer']['lastname'],
                    ][$notification->data['action']];
                });
    }

    public function isLeader() {
        return (bool) $this->is_team_leader;
    }

    public function isAdmin() {
        return $this->roles->contains('title', 'Admin');
    }

    public function isSales() {
        return $this->roles->contains('title', 'sales');
    }

    public function isListings() {
        return $this->roles->contains('title', 'listings');
    }

   public function getTeamIds() {
        return $this->team->users()->select('id')->pluck('id')->values()->all();
    }

    public function canDeleteListing($listing) {
        if ($this->isListings()) {
            return $this->isLeader() ? in_array($listing->user_id, $this->getTeamIds()) : $listing->user_id == $this->id;
        }

        return true;
    }

    public function canEditListing($listing) {
        if ($this->isListings()) {
            return $this->isLeader() ? in_array($listing->user_id, $this->getTeamIds()) : $listing->user_id == $this->id;
        }

        return true;
    }

    public function canManageContact($contact) {
        if ($this->isSales()) {
            return $this->isLeader() 
                ? in_array($contact->user_id, $this->getTeamIds()) 
                : $contact->user_id == $this->id || $contact->created_by == $this->id;
        }

        return true;
    }
     public function canManageContactAssignto($contact) {
        if ($this->isSales()) {
            return $this->isLeader() 
                ? in_array($contact->user_id, $this->getTeamIds()) 
                : $contact->user_id == $this->id && $contact->created_by == $this->id;
        }

        return true;
    }
    public function canManageContactisbasic($contact) {
        if ($this->isSales() || $this->isAdmin()) {
            return $this->isLeader() 
                ? in_array($contact->user_id, $this->getTeamIds()) 
                : $contact->status == 'Basic';
        }

        return true;
    }

    public function canDeleteProject($project) {
        if ($this->isListings()) {
            return $this->isLeader() ? in_array($project->user_id, $this->getTeamIds()) : $project->user_id == $this->id;
        }

        return true;
    }

    public function canEditProject($project) {
        if ($this->isListings()) {
            return $this->isLeader() ? in_array($project->user_id, $this->getTeamIds()) : $project->user_id == $this->id;
        }

        return true;
    }

    public function canManageOwner($owner) {
        if ($this->isSales()) {
            return $this->isLeader() ? in_array($owner->assign_id, $this->getTeamIds()) : $owner->assign_id == $this->id;
        }

        return true;
    }

}
