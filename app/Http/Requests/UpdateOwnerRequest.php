<?php

namespace App\Http\Requests;

use App\Models\Owner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOwnerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('owner_edit');
    }

    public function rules()
    {
        return [
            'firstname' => [
                'string',
                'min:3',
                'max:100',
                'required',
            ],
            'salutation' => [
                'required',
            ],
            'lastname' => [
                'string',
                'min:3',
                'max:100',
                'required',
            ],
             'emirate_id_number' => [
               
                'nullable',
            ],
             'source' => [
                'required',
            ],
            'email' => [
                'required',
                'unique:owners,email,' . request()->route('owner')->id,
            ],
            'nationality' => [
                'string',
                'nullable',
            ],
            'assign_id' => [
                'required',
                'integer',
            ],
            'mobile' => [
                'numeric',
                'required',
            ],
            'alternate_mobile' => [
                'numeric',
                'nullable',
            ],
             'projects' => [
              
                'array',
                'nullable',
            ],
            'files' => [
                'array',
            ],
        ];
    }
}

