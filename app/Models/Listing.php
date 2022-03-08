<?php

namespace App\Models;

use \DateTimeInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Hash;

class Listing extends Model implements HasMedia {

    use SoftDeletes;
    use InteractsWithMedia;
    use HasFactory;
    use \App\Models\Traits\HasRefID;
    use \App\Models\Traits\Trackable;

    public function modelPrefix() {
        return strtolower($this->type);
    }

    public const PURPOSE_SELECT = [
        'Sale' => 'Sale',
        'Rent' => 'Rent',
    ];
     public const PRICING_DURATION_SELECT = [
        'Yearly' => 'Yearly',
        'Monthly' => 'Monthly',
    ];
    public const STATE_SELECT = [
        'Hot' => 'Hot',
        'Signature' => 'Signature',
        'Basic' => 'Basic',
    ];
    
    public const TYPE_SELECT = [
        'Villa' => 'Villa',
        'Apartment' => 'Apartment',
        'Studio' => 'Studio',
        'Townhouse' => 'Townhouse',
        'Office' => 'Office',
        'Plot' => 'Plot',
    ];

    
    
    public $table = 'listings';
    protected $appends = [
        'thumbnail',
        'images',
    ];
    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at',
    ];
    protected $fillable = [
        'title',
        'type',
        'purpose',
        'rent_pricing_duration',
        'emirate',
        'community',
        'price',
        'beds',
        'baths',
        'plotarea_size',
        'area_size',
        'plotarea_size_postfix',
        'area_size_postfix',
        'developer',
        'note',
        'description',
        'state',
        
        'owner_id',
        'user_id',
        'project_id',
        'ref',
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

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function scopeWherePriceBetween($query, $min = null, $max = null) {
        if ($min && !$max) {
            return $query->where('price', '>=', $min);
        }

        if ($max && !$min) {
            return $query->where('price', '<=', $max);
        }

        return $query->when($min && $max, function ($query) use ($min, $max) {
                    $query->whereBetween('price', [$min, $max]);
                });
    }

    public function scopeWhereSearch($query, $filters) {
        return $query->when(isset($filters['purpose']) && $filters['purpose'], function ($query) use ($filters) {
                            return $query->where('purpose', $filters['purpose']);
                        })
                        ->when(isset($filters['location']) && $filters['location'], function ($query) use ($filters) {
                            return $query->where('location', $filters['location']);
                        })
                        ->when(isset($filters['community']) && $filters['community'], function ($query) use ($filters) {
                            return $query->where('community', $filters['community']);
                        })
                        ->when(isset($filters['beds']) && $filters['beds'], function ($query) use ($filters) {
                            return $query->where('beds', $filters['beds']);
                        })
                        ->when(isset($filters['baths']) && $filters['baths'], function ($query) use ($filters) {
                            return $query->where('baths', $filters['baths']);
                        })
                        ->when(isset($filters['type']) && $filters['type'], function ($query) use ($filters) {
                            return $query->where('type', $filters['type']);
                        });
    }

    public function getThumbnailAttribute() {
        $file = $this->getMedia('thumbnail')->last();
        if ($file) {
            $file->url = $file->getUrl();
            $file->thumbnail = $file->getUrl('thumb');
            $file->preview = $file->getUrl('preview');
            $file->absolute_path = str_replace(env('APP_URL'), '', $file->getUrl());
        }

        return $file;
    }

    public function getImagesAttribute() {
        $files = $this->getMedia('images');
        $files->each(function ($item) {
            $item->url = $item->getUrl();
            $item->thumbnail = $item->getUrl('thumb');
            $item->preview = $item->getUrl('preview');
            $item->absolute_path = str_replace(env('APP_URL'), '', $item->getUrl());
        });

        return $files;
    }

    protected function serializeDate(DateTimeInterface $date) {
        return $date->format('Y-m-d H:i:s');
    }

    public function scopeFilterByAuth($query) {
        if (auth()->user()->isSales() && auth()->user()->isLeader()) {
            return $query->whereIn('user_id', auth()->user()->getTeamIds());
        }

        if (auth()->user()->isSales()) {
            return $query->where('user_id', auth()->id());
        }
    }

    public function getFilesAttribute() {
        return $this->getMedia('files');
    }

}
