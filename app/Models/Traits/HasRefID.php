<?php

namespace App\Models\Traits;

use Illuminate\Support\Str;

trait HasRefID 
{
    protected static function bootHasRefID()
    {
        static::creating(function($model) {
            $ref = rand(pow(10, 5), pow(10, 6)- 1);
            while(self::query()->where('ref', $ref)->exists()) {
                $ref = rand(pow(10, 5), pow(10, 6)- 1);
            }
            $model->ref = $ref;
        });
    }

    public function getRefAttribute()
    {
        return $this->modelPrefix() . '-' . $this->attributes['ref'];
    }
}
