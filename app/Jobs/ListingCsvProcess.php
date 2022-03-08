<?php

namespace App\Jobs;

use App\Models\Listing;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ListingCsvProcess
{
    
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    public $header;
    public $data;

    public function __construct($data, $header)
    {
        $this->data = $data;
        $this->header = $header;
    }

    public function handle()
    {
        foreach ($this->data as $listing) {
            $listingFields = array_combine($this->header, $listing);
            
            $listing = Listing::create($listingFields);

            if(isset($listingFields['thumbnail'])) {
                $listing->addMediaFromUrl($listingFields['thumbnail'])->toMediaCollection('thumbnail');
            }

            if(isset($listingFields['images'])) {
                foreach (explode(',', $listingFields['images']) ?? [] as $imageUrl) {
                   $listing->addMediaFromUrl(trim($imageUrl))->toMediaCollection('images');
                }
            }

        }
    }
}