<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\SharedExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Listing;
use App\Models\Project;
use App\Models\Owner;
use App\Models\Contact;

class ExportExcelController extends Controller {

    public function listings() 
    {
        // abort_if(auth()->user()->isSales(), 403);
        
        $listings = Listing::filterByAuth()->get()->map(function ($listing) {
            return [
                'id' => $listing->id,
                'ref' => $listing->ref,
                'title' => $listing->title,
                'type' => $listing->type,
                'purpose' => $listing->purpose,
                'location' => $listing->location,
                'emirate' => $listing->emirate,
                'community' => $listing->community,
                'price' => $listing->price,
                'beds' => $listing->beds,
                'baths' => $listing->baths,
                'plot_area' => $listing->plot_area,
                'area' => $listing->area,
                'developer' => $listing->developer,
                'note' => $listing->note,
                'description' => $listing->description,
                'state' => $listing->state,
                'owner_id' => !auth()->user()->isSales() ? $listing->owner->full_name : '',
                'user_id' => $listing->user->full_name,
                'project_id' => optional($listing->project)->name,
                'images' => $listing->images->map(function ($image) {
                    return $image->url;
                })->join(', '),
                'created_at' => $listing->created_at->toDateString()
            ];
        });

        $columns = [
            'id', 'ref', 'title', 'type', 'purpose', 'location', 'emirate', 'community', 'price', 'beds',
            'baths', 'plot_area', 'area', 'developer', 'note', 'description', 'state', 'owner', 'assign to', 'images', 'Created At'
        ];

        return Excel::download(new SharedExcelExport($listings, $columns), 'listings.xlsx');
    }

    public function projects() {
        $projects = Project::all()->map(function ($project) {
            return [
        'id' => $project->id,
        'ref' => $project->ref,
        'title' => $project->title,
        'name' => $project->name,
        'type' => $project->type,
        'purpose' => $project->purpose,
        'location' => $project->location,
        'emirate' => $project->emirate,
        'community' => $project->community,
        'price' => $project->price,
        'plotarea' => $project->plotarea,
        'area' => $project->area,
        'developer' => $project->developer,
        'note' => $project->note,
        'description' => $project->description,
        'state' => $project->state,
        'floor_number' => $project->floor_number,
        'owner' => $project->owner->full_name,
        'user' => $project->user->full_name,
        'image' => $project->thumbnail->getUrl(),
        'created_at' => $project->created_at->toDateString()
            ];
        });

        $columns = [
            'id', 'ref', 'title', 'name', 'type', 'purpose', 'location', 'emirate', 'community', 'price', 'plotarea',
            'area', 'developer', 'note', 'description', 'state', 'floor_number', 'owner', 'assign to', 'images', 'Created At'
        ];

        return Excel::download(new SharedExcelExport($projects, $columns), 'projects.xlsx');
    }

    public function contacts() {
        $contacts = Contact::all()->map(function ($contact) {
            return [
        'id' => $contact->id,
        'ref' => $contact->ref,
        'salutation' => $contact->salutation,
        'firstname' => $contact->firstname,
        'lastname' => $contact->lastname,
        'email' => $contact->email,
        'nationality' => $contact->nationality,
        'status' => $contact->status,
        'user_id' => $contact->user_id,
        'mobile' => $contact->mobile,
        'alternate_mobile' => $contact->alternate_mobile,
        'created_at' => $contact->created_at
            ];
        });

        $columns = [
            'id', 'ref', 'salutation', 'firstname', 'lastname', 'email', 'nationality', 'status', 'user_id',
            'mobile', 'alternate_mobile', 'created_at',
        ];

        return Excel::download(new SharedExcelExport($contacts, $columns), 'contacts.xlsx');
    }

    public function owners() {
        $owners = Owner::all()->map(function ($owner) {
            return [
        'id' => $owner->id,
        'ref' => $owner->ref,
        'salutation' => $owner->salutation,
        'firstname' => $owner->firstname,
        'lastname' => $owner->lastname,
        'email' => $owner->email,
        'nationality' => $owner->nationality,
        'user_id' => $owner->user_id,
        'mobile' => $owner->mobile,
        'alternate_mobile' => $owner->alternate_mobile,
        'created_at' => $owner->created_at
            ];
        });

        $columns = [
            'id', 'ref', 'salutation', 'firstname', 'lastname', 'email', 'nationality', 'user_id',
            'mobile', 'alternate_mobile', 'created_at',
        ];

        return Excel::download(new SharedExcelExport($owners, $columns), 'owners.xlsx');
    }

}
