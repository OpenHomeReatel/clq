<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Project extends Model implements HasMedia {

    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;
    
    use \App\Models\Traits\HasRefID;
    use \App\Models\Traits\Trackable;
    
    public $table = 'projects';
    
    public function modelPrefix() {
        return 'project';
    }

    public const PROPERTY_TYPE_SELECT = [
        'Villa' => 'Villa',
        'Townhouse' => 'Townhouse',
        'Penthouse' => 'Penthouse',
        'Beach house' => 'Beach House',
        'Apartment' => 'Apartment',
        'Studio' => 'Studio',
        'Plot' => 'Plot',
        'Office' => 'Office',
    ];

    protected $casts = [
        'property_type' => 'array',
    ];
    
    protected $appends = [
        'thumbnail',
        'files',
    ];
    
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    
    protected $fillable = [
        'ref',
        'name',
        'community',
        'description',
        'developer',
        'emirate',
        'state',
        'note',
        'title',
        'property_type',
        'floor_number',
        'owner_id',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function registerMediaConversions(Media $media = null): void {
        $this->addMediaConversion('thumb')->fit('crop', 50, 50);
        $this->addMediaConversion('preview')->fit('crop', 120, 120);
    }

    public function owner() {
        return $this->belongsTo(Owner::class, 'owner_id');
    }

    public function getThumbnailAttribute() {
        $file = $this->getMedia('thumbnail')->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview = $file->getUrl('preview');
        }

        return $file;
    }

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }

    public function getFilesAttribute() {
        return $this->getMedia('files');
    }
}
