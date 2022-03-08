<?php

namespace App\Jobs;

use App\Models\Owner;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class OwnerCsvProcess
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
        foreach ($this->data as $owner) {
            try {
                $ownerData = array_combine($this->header,$owner);
                $ownerData['projects'] = json_decode($ownerData['projects']);
                Owner::create($ownerData);
            } catch (\Exception $exception) { }
        }
    }
}