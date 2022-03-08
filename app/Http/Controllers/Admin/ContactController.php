<?php

namespace App\Http\Controllers\Admin;

use App\Jobs\ContactCsvProcess;
use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyContactRequest;
use App\Http\Requests\StoreContactRequest;
use App\Http\Requests\UpdateContactRequest;
use App\Models\Contact;
use App\Models\User;
use App\Models\Followup;

use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ContactController extends Controller {

    public function index() 
    {
        abort_if(Gate::denies('contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contacts = Contact::query()
                ->filterByAuth()
                ->with(['user'])
                ->get();
        $users = User::all();
        
        return view('admin.contacts.index', compact('contacts', 'users'));
    }

    public function create()
    {
        abort_if(Gate::denies('contact_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $users = User::onlySales()->get()->pluck('full_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.contacts.create', compact('users'));
    }

    public function store(StoreContactRequest $request)
    {
        $contact = Contact::create($request->all());

        return redirect()->route('admin.contacts.index');
    }

    public function edit(Contact $contact)
    {
        abort_if(
            !auth()->user()->canManageContact($contact) || Gate::denies('contact_edit'), 
            Response::HTTP_FORBIDDEN, 
            '403 Forbidden'
        );

        $users = User::onlySales()->get()->pluck('full_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $contact->load('user');

        return view('admin.contacts.edit', compact('users', 'contact'));
    }

    public function update(UpdateContactRequest $request, Contact $contact) 
    {
        abort_if(
            !auth()->user()->canManageContact($contact) || Gate::denies('contact_edit'), 
            Response::HTTP_FORBIDDEN, 
            '403 Forbidden'
        );

        if(auth()->id() == $contact->created_by) {
            $contact->update($request->only('status', 'lead_status'));
        } elseif(auth()->id() == $contact->user_id) {
            $contact->update($request->only('lead_status'));
        } else {
            $contact->update($request->all());
        }


        return redirect()->route('admin.contacts.index');
    }

    public function show(Contact $contact) 
    {
            abort_if(
            !auth()->user()->canManageContact($contact) || Gate::denies('contact_show'), 
            Response::HTTP_FORBIDDEN, 
            '403 Forbidden'
        );

        $contact->load('user', 'followups');

        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact) 
    {
        abort_if(
            !auth()->user()->canManageContact($contact) || Gate::denies('contact_delete'), 
            Response::HTTP_FORBIDDEN, 
            '403 Forbidden'
        );

        $contact->delete();

        return back();
    }

    public function massDestroy(MassDestroyContactRequest $request) {
        Contact::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function upload_csv_records(Request $request) {
        if ($request->has('csv')) {
            $chunks = array_chunk(file($request->csv), 100);
            $header = [];

            foreach ($chunks as $key => $chunk) {
                $data = array_map('str_getcsv', $chunk);
                if ($key == 0) {
                    $header = $data[0];
                    unset($data[0]);
                }
                dispatch(new ContactCsvProcess($data, $header));
            }
        }

        return back();
    }

    public function massAssignUser(Request $request)
    {
        if($selectedContactsIds = explode(',', $request->input('selected_contacts_id'))) {
            Contact::whereIn('id', $selectedContactsIds)->update([
                'user_id' => $request->input('user_id')
            ]);
        }

        return back();
    }
    
    public function leads() 
    {
        abort_if(Gate::denies('contact_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $contacts = Contact::query()
                ->filterByAuth()
                ->where('status', 'open lead')
                ->with(['user'])
                ->get();
     $users = User::all();
        return view('admin.contacts.leads', compact('contacts','users'));
    }
    
    public function multi_update(UpdateContactRequest $request, Contact $contact){
         abort_if(
            !auth()->user()->canManageContact($contact) || Gate::denies('contact_edit'), 
            Response::HTTP_FORBIDDEN, 
            '403 Forbidden'
        );
        if (is_array(request('item'))){
            
            foreach(request('item')as $contact->id){
              $person_update= Contact::find($contact->id);
              $person_update->user_id= $request->user_id;
              $person_update->save();
            }
        }
    }

    

   
}
