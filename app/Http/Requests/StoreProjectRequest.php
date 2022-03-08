<?php

namespace App\Http\Requests;

use App\Models\Project;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProjectRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('project_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'min:3',
                'max:100',
                'required',
            ],
            
            'community' => [
                'string',
                'min:0',
                'max:100',
                'required',
            ],
            'description' => [
                'required',
            ],
            'developer' => [
                'string',
                'required',
            ],
            'emirate' => [
                'string',
                'required',
            ],
            'state' => [
                'string',
                'nullable',
            ],
            
            
           
            'title' => [
                'string',
                'required',
            ],
            'property_type' => [
                'array',
                'nullable',
            ],
            
            'floor_number' => [
                'nullable',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'owner_id' => [
                'nullable',
                'integer',
            ],
            'thumbnail' => [
                'required',
            ],
             'files' => [
                'array',
            ],
        ];
    }
}

