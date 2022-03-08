<?php

namespace App\Jobs;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Bus\Batchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class ContactCsvProcess
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
        
        foreach ($this->data as $contact) {
           
            try {
                $contactData = array_combine($this->header,$contact);
                Contact::create($contactData);
            } catch (\Exception $exception) { }
        }
        /*
        foreach ($this->data as $contact) {
            $contact = array_combine($this->header, $contact);
            
            $contact = Contact::create($contact);

            if(isset($contact['thumbnail'])) {
                $contact->addMediaFromUrl($contact['thumbnail'])->toMediaCollection('thumbnail');
            }

            if(isset($contact['images'])) {
                foreach (explode(',', $contact['images']) ?? [] as $imageUrl) {
                   $contact->addMediaFromUrl(trim($imageUrl))->toMediaCollection('images');
                }
            }
 

        }* 
 */
    }
}