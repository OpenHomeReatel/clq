@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.followup.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.contacts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            ID
                        </th>
                        <td>
                            {{ $followup->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Activity
                        </th>
                        <td>
                             {{ App\Models\Followup::ACTIVITY_SELECT[$followup->activity] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                           Contact 
                        </th>
                        <td>
                            {{ $followup->contact->firstname ?? '' }} {{ $followup->contact->lastname ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            Note
                        </th>
                        <td>
                            {!! $followup->note !!}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.contacts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
