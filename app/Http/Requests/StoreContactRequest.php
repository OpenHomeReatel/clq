<?php

namespace App\Http\Requests;

use App\Models\Contact;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreContactRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('contact_create');
    }

    public function rules()
    {
        return [
            'ref' => [
                'string',
                'nullable',
            ],
            'firstname' => [
                'string',
                'required',
            ],
            'lastname' => [
                'string',
                'required',
            ],
            'email' => [
                'required',
                'unique:contacts',
            ],
            'nationality' => [
                'string',
                'required',
            ],
            'salutation' => [
                'required',
            ],
            'source' => [
                'required',
            ],
            'status' => [
                'required',
            ],
            'lead_status' => [
                'nullable',
            ],
            'mobile' => [
                'numeric',
                'required',
            ],
            
        ];
    }
}

