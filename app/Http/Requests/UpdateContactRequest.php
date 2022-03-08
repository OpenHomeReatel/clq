<?php

namespace App\Http\Requests;

use App\Models\Contact;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateContactRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('contact_edit');
    }

    public function rules()
    {
        return [
            'firstname' => [
                'sometimes',
                'string',
                'required',
            ],
            'lastname' => [
                'sometimes',
                'string',
                'required',
            ],
            'email' => [
                'sometimes',
                'required',
                'unique:contacts,email,' . request()->route('contact')->id,
            ],
            'nationality' => [
                'sometimes',
                'string',
                'required',
            ],
            'salutation' => [
                'sometimes',
                'required',
            ],
            'source' => [
                'sometimes',
                'required',
            ],
            'status' => [
                'sometimes',
                'required',
            ],
            'mobile' => [
                'sometimes',
                'numeric',
                'required',
            ],
            'alternate_mobile' => [
                'sometimes',
                'numeric',
            ],
        ];
    }
}

