<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Followup extends Model implements HasMedia {

    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;

    //use \App\Models\Traits\HasRefID;
    //use \App\Models\Traits\Trackable;

    public const ACTIVITY_SELECT = [
        'call' => 'Call',
        'meeting' => 'Meeting',
        'viewing' => 'Viewing',
    ];

    public $table = 'followups';
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        'activity',
        'contact_id',
        'note',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function contact() {
        return $this->belongsTo(Contact::class, 'contact_id');
    }

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }

}
