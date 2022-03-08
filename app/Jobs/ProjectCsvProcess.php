<?php

namespace App\Jobs;

use App\Models\Project;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ProjectCsvProcess
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
        foreach ($this->data as $project) {
            try {
                $projectFields = array_combine($this->header, $project);
                $projectFields['property_type'] = json_decode($projectFields['property_type']);
                $project = Project::create($projectFields);
                
                if(isset($projectFields['thumbnail'])) {
                    $project->addMediaFromUrl($projectFields['thumbnail'])->toMediaCollection('thumbnail');
                }
            } catch (\Exception $exception) { }
        }
    }
}