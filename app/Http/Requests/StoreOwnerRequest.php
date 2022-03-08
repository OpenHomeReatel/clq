<?php

namespace App\Http\Requests;

use App\Models\Owner;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreOwnerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('owner_create');
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
            
            'email' => [
                'required',
                'unique:owners',
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
            'source' => [
                'required',
            ],
            'projects' => [
              
                'array',
                'nullable',
            ],
            'alternate_mobile' => [
                'numeric',
                'nullable',
            ],
              'files' => [
                'array',
            ],
        ];
    }
}

