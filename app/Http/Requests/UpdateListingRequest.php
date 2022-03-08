<?php

namespace App\Http\Requests;

use App\Models\Listing;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateListingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('listing_edit');
    }

    public function rules()
    {
        return [
            'title' => [
                'string',
                'required',
            ],
            'type' => [
                'required',
            ],
            'purpose' => [
                'required',
            ],
             'rent_pricing_duration' => [
                'nullable',
                'string',
            ],
           
            'emirate' => [
                'string',
                'required',
            ],
            'community' => [
                'string',
                'required',
            ],
            'price' => [
                'required',
            ],
            'beds' => [
                'required',
                'string',
                
            ],
            'baths' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'plotarea_size' => [
                'numeric',
               
            ],
            'area_size' => [
                'numeric',
                'required',
            ],
             'plotarea_size_postfix' => [
                'string',
                
            ],
            'area_size_postfix' => [ 
                'string',
                'required',
            ],
            'developer' => [
                'string',
                'nullable',
            ],
            'description' => [
                'required',
            ],
            'state' => [
                'string',
                'required',
            ],
            'owner_id' => [
                'required',
                'integer',
            ],
            'images' => [
                'array',
            ],
            'files' => [
                'array',
            ],
        ];
    }
}

