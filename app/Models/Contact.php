<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;
use App\Models\User;
class Contact extends Model {

    use SoftDeletes;
    use HasFactory;

    use \App\Models\Traits\HasRefID;
    use \App\Models\Traits\Trackable;

    public function modelPrefix() {
        return 'contact';
    }

    public const SOURCE_SELECT = [
        'Company Website' => 'Company Website',
        'Whatsapp' => 'Whatsapp',
        'Personal Referral' => 'Personal Referral',
        'Bank Referral' => 'Bank Referral',
        'Client Referral ' => 'Client Referral',
        'Open House' => 'Open House',
        'Direct Call ' => 'Direct Call ',
        'Walk-in' => 'Walk-in',
        'Exhibition Stand' => 'Exhibition Stand',
        'Walk-in' => 'Walk-in',
        'Existing Client' => 'Existing Client',
        'Email Campaign' => 'Email Campaign',
        'SMS Campaign' => 'SMS Campaign',
        'Word of Mouth' => 'Word of Mouth',
        'Cold Call' => 'Cold Call',
        'Google' => 'Google',
        'Facebook' => 'Facebook',
        'Instagram' => 'Instagram',
        'Dubizzle' => 'Dubizzle',
        'Property Finder' => 'Property Finder',
        'Other Portal' => 'Other Portal',
        'Youtube' => 'Youtube',
        'Linkedin' => 'Linkedin',
        'Twitter' => 'Twitter',
        'Bayut.com' => 'Bayut.com',
        'Developer' => 'Developer',
        'Other' => 'Other',
    ];
    public const STATUS_SELECT = [
        'Open lead' => 'Open Lead',
        'Basic' => 'Basic',
    ];
    public const LEAD_STATUS_SELECT = [
        'Cold' => 'Cold',
        'Warm' => 'Warm',
        'Hot' => 'Hot',
    ];
    public const SALUTATION_SELECT = [
        'Mr' => 'Mr',
        'Miss' => 'Miss',
        'Dr' => 'Dr',
        'Mrs' => 'Mrs',
    ];

    public $table = 'contacts';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        'ref',
        'firstname',
        'lastname',
        'email',
        'nationality',
        'salutation',
        'source',
        'status',
        'lead_status',
        'user_id',
        'assign_to',
        'mobile',
        'alternate_mobile',
        'created_at',
        'created_by',
        'updated_at',
        'deleted_at',
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }

    public function followups() {
        return $this->hasMany(Followup::class, 'contact_id');
    }
   
    public function scopeFilterByAuth($query) 
    {
        if (auth()->user()->isSales() && auth()->user()->isLeader()) {
            return $query->where(function ($query) {
                $query
                    ->whereIn('user_id', auth()->user()->getTeamIds())
                    ->orWhere('created_by' , auth()->id());
            });
        }

        if (auth()->user()->isSales()) {
            return $query->where(function ($query) {
                $query
                    ->where('user_id' , auth()->id())
                    ->orWhere('created_by' , auth()->id());
            });    
        }
    }

    public function getFullNameAttribute()
    {
        return $this->firstname.' '.$this->lastname;
    }
    
    public function CreatedBy()
    {
        $createdby = DB::table('users')->where('id', $this->created_by)->first();
        $createdbyfullname = $createdby->firstname.' '.$createdby->lastname;
        return $createdbyfullname ;
    }

}
