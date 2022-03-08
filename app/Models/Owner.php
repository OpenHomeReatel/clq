<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use \App\Models\Traits\Trackable;




class Owner extends Model implements HasMedia {

    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    use \App\Models\Traits\HasRefID;
    use \App\Models\Traits\Trackable;

    public function modelPrefix() {
        return 'owner';
    }
     protected $casts = [
        'projects' => 'array',
    ];
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
        'DATA' => 'DATA',
        'Other' => 'Other',
    ];
    public const SALUTATION_SELECT = [
        'Mr' => 'MR',
        'Miss' => 'Miss',
        'Dr' => 'Dr',
        'Mrs' => 'Mrs',
    ];

    public $table = 'owners';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        'ref',
        'firstname',
        'salutation',
        'emirate_id_number',
        'lastname',
        'email',
        'source',
        'nationality',
        'assign_id',
        'mobile',
        'projects',
        'alternate_mobile',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function assign() {
        return $this->belongsTo(User::class, 'assign_id');
    }

    public function listings() {
        return $this->hasMany(Listing::class, 'owner_id');
    }

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }

    public function getFullNameAttribute() {
        return $this->firstname . ' ' . $this->lastname ;
    }
    public function getFullNameIDAttribute() {
        return $this->firstname . ' ' . $this->lastname . ' || ' . $this->id;
    }

    public function isLeader() {
        return (bool) $this->is_team_leader;
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

    public function scopeFilterByAuth($query) {
        if (auth()->user()->isListings() && auth()->user()->isLeader()) {
            return $query->whereIn('assign_id', auth()->user()->getTeamIds());
        }

        if (auth()->user()->isListings()) {
            return $query->where('assign_id', auth()->id());
        }
    }

    public function getFilesAttribute() {
        return $this->getMedia('files');
    }
    
  

}
