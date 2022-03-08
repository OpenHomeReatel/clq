<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Exports\SharedExcelExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\Listing;
use App\Models\Project;
use App\Models\Contact;
use App\Models\Owner;

class ExportCSVController extends Controller {

    public function listings() {
        abort_if(auth()->user()->isSales(), 403);

        $listings = Listing::all()->map(function ($listing) {
            return [
        'id' => $listing->id,
        'ref' => $listing->ref,
        'title' => $listing->title,
        'type' => $listing->type,
        'purpose' => $listing->purpose,
        'emirate' => $listing->emirate,
        'community' => $listing->community,
        'price' => $listing->price,
        'beds' => $listing->beds,
        'baths' => $listing->baths,
        'plot_area_size' => $listing->plotarea_size,
        'plot_area_size_postfix' => $listing->plotarea_size_postfix,
        'area_size' => $listing->area_size,
        'area_size_postfix' => $listing->area_size_postfix,
        'developer' => $listing->developer,
        'note' => $listing->note,
        'description' => $listing->description,
        'state' => $listing->state,
        'owner_id' => $listing->owner->full_name,
        'user_id' => $listing->user->full_name,
        'project_id' => optional($listing->project)->name,
        'images' => $listing->images->map(function ($image) {
            return $image->url;
        })->join(', '),
        'created_at' => $listing->created_at->toDateString()
            ];
        });

        $columns = [
            'id', 'ref', 'title', 'type', 'purpose', 'emirate', 'community', 'price', 'beds',
            'baths', 'plot_area_size', 'plot_area_size_postfix', 'area_size', 'area_size_postfix',
            'developer', 'note', 'description', 'state', 'owner', 'assign to', 'project', 'images', 'Created At'
        ];

        return Excel::download(new SharedExcelExport($listings, $columns), 'listings.csv');
    }

    public function projects() {
        $projects = Project::all()->map(function ($project) {
            return [
        'id' => $project->id,
        'ref' => $project->ref,
        'title' => $project->title,
        'name' => $project->name,
        'property_type' => $project->property_type,
        'emirate' => $project->emirate,
        'community' => $project->community,
        'developer' => $project->developer,
        'note' => $project->note,
        'description' => $project->description,
        'state' => $project->state,
        'floor_number' => $project->floor_number,
        'owner' => optional($project->owner)->full_name,
        'image' => $project->thumbnail->getUrl(),
        'created_at' => $project->created_at->toDateString()
            ];
        });

        $columns = [
            'id', 'ref', 'title', 'name', 'property type', 'emirate', 'community',
            'developer', 'note', 'description', 'state', 'floor_number', 'owner', 'image', 'Created At'
        ];

        return Excel::download(new SharedExcelExport($projects, $columns), 'projects.csv');
    }

    public function contacts() {
        $contacts = Contact::all()->map(function ($contact) {
            return [
        'id' => $contact->id,
        'ref' => $contact->ref,
        'salutation' => $contact->salutation,
        'firstname' => $contact->firstname,
        'lastname' => $contact->lastname,
        'source' => $contact->source,
        'email' => $contact->email,
        'nationality' => $contact->nationality,
        'status' => $contact->status,
        'lead_status' => $contact->lead_status,
        'user_id' => $contact->user_id,
        'mobile' => $contact->mobile,
        'alternate_mobile' => $contact->alternate_mobile,
        'created_at' => $contact->created_at
            ];
        });

        $columns = [
            'id', 'ref', 'salutation', 'firstname', 'lastname', 'source', 'email', 'nationality', 'status', 'lead_status', 'user_id',
            'mobile', 'alternate_mobile', 'created_at',
        ];

        return Excel::download(new SharedExcelExport($contacts, $columns), 'contacts.csv');
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
        'source' => $owner->source,
        'projects' => $owner->projects,
        'nationality' => $owner->nationality,
        'mobile' => $owner->mobile,
        'alternate_mobile' => $owner->alternate_mobile,
        'created_at' => $owner->created_at,
        'user_id' => $owner->assign_id
            ];
        });

        $columns = [
            'id', 'ref', 'salutation', 'firstname', 'lastname', 'email', 'source','projects', 'nationality',
            'mobile', 'alternate_mobile', 'created_at','assign_id',
        ];

        return Excel::download(new SharedExcelExport($owners, $columns), 'owners.csv');
    }

    public function leads() {

        $contacts = Contact::all()->map(function ($contact) {
            return [
        'id' => $contact->id,
        'ref' => $contact->ref,
        'salutation' => $contact->salutation,
        'firstname' => $contact->firstname,
        'lastname' => $contact->lastname,
        'email' => $contact->email,
        'nationality' => $contact->nationality,
        'status' => $contact->status == 'Open Lead',
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

        return Excel::download(new SharedExcelExport($contacts, $columns), 'contacts.csv');
    }

}
