<?php

namespace App\Http\Requests;

use App\Models\Followup;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreFollowupRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('followup_create');
    }

    public function rules()
    {
        return [
            'activity' => [
                'required',
            ],
           
            'note' => [
                'required',
                'string',
            ],
        ];
    }
}