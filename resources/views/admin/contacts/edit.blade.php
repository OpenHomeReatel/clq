@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.contact.title_singular') }}
    </div>
    <div class="card-body">
        <form method="POST" action="{{ route("admin.contacts.update", [$contact->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            @if(!auth()->user()->isSales())
            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required" for="firstname">{{ trans('cruds.contact.fields.firstname') }}</label>
                    <input  class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}" type="text" name="firstname" id="firstname" value="{{ old('firstname', $contact->firstname) }}" required>
                    @if($errors->has('firstname'))
                    <div class="invalid-feedback">
                        {{ $errors->first('firstname') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contact.fields.firstname_helper') }}</span>
                </div>
                <div class="form-group col-md">
                    <label class="required" for="lastname">{{ trans('cruds.contact.fields.lastname') }}</label>
                    <input  class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" type="text" name="lastname" id="lastname" value="{{ old('lastname', $contact->lastname) }}" required>
                    @if($errors->has('lastname'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lastname') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contact.fields.lastname_helper') }}</span>
                </div>
            </div>
            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required" for="email">{{ trans('cruds.contact.fields.email') }}</label>
                    <input  class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $contact->email) }}" required>
                    @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contact.fields.email_helper') }}</span>
                </div>
                <div class="form-group col-md">
                    <label class="required" for="nationality">{{ trans('cruds.contact.fields.nationality') }}</label>
                    <input  class="form-control {{ $errors->has('nationality') ? 'is-invalid' : '' }}" type="text" name="nationality" id="nationality" value="{{ old('nationality', $contact->nationality) }}" required>
                    @if($errors->has('nationality'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nationality') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contact.fields.nationality_helper') }}</span>
                </div>
            </div>
            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required">{{ trans('cruds.contact.fields.salutation') }}</label>
                    <select  class="form-control {{ $errors->has('salutation') ? 'is-invalid' : '' }}" name="salutation" id="salutation" required>
                        <option value disabled {{ old('salutation', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Contact::SALUTATION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('salutation', $contact->salutation) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('salutation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('salutation') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contact.fields.salutation_helper') }}</span>
                </div>
                <div class="form-group col-md">
                    <div class="form-group col-md">
                        <label >{{ trans('cruds.contact.fields.source') }}</label>
                        <select  class="form-control {{ $errors->has('source') ? 'is-invalid' : '' }}" name="source" id="source" >
                            <option value disabled {{ old('source', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                            @foreach(App\Models\Contact::SOURCE_SELECT as $key => $label)
                            <option value="{{ $key }}" {{ old('source', $contact->source) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @if($errors->has('source'))
                        <div class="invalid-feedback">
                            {{ $errors->first('source') }}
                        </div>
                        @endif
                        <span class="help-block">{{ trans('cruds.contact.fields.source_helper') }}</span>
                    </div>
                    <span class="help-block">{{ trans('cruds.contact.fields.source_helper') }}</span>
                </div>
            </div>

            @endif
            @if(auth()->user()->canManageContactAssignto($contact))
            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required">{{ trans('cruds.contact.fields.status') }}</label>
                    <select  class="form-control  {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status" required>
                        <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Contact::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $contact->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contact.fields.status_helper') }}</span>
                </div>
                @endif
                @if(!auth()->user()->canManageContactisbasic($contact))
                <div class="form-group col-md">
                    <label class="required">{{ trans('cruds.contact.fields.lead_status') }}</label>
                    <select  class="form-control  {{ $errors->has('lead_status') ? 'is-invalid' : '' }}" name="lead_status" id="lead_status">
                        <option value disabled {{ old('lead_status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Contact::LEAD_STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('lead_status', $contact->lead_status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('lead_status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lead_status') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contact.fields.status_helper') }}</span>
                </div>   
            </div>

            @endif
            @if(!auth()->user()->isSales())
            <div class="row g-2">
                <div class="form-group col-md">
                    <label for="user_id">{{ trans('cruds.contact.fields.user') }}</label>
                    <select  class="form-control  {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id">
                        @foreach($users as $id => $entry)
                        <option value="{{ $id }}" {{ (old('user_id') ? old('user_id') : $contact->user->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('user'))
                    <div class="invalid-feedback">
                        {{ $errors->first('user') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contact.fields.user_helper') }}</span>
                </div> 
                <div class="form-group col-md">
                    <label class="required" for="mobile">{{ trans('cruds.contact.fields.mobile') }}</label>
                    <input  class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', $contact->mobile) }}" required>
                    @if($errors->has('mobile'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mobile') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contact.fields.mobile_helper') }}</span>
                </div>
                <div class="form-group col-md">
                    <label  for="alternate_mobile">{{ trans('cruds.contact.fields.alternate_mobile') }}</label>
                    <input  class="form-control {{ $errors->has('alternate_mobile') ? 'is-invalid' : '' }}" type="text" name="alternate_mobile" id="alternate_mobile" value="{{ old('alternate_mobile', $contact->alternate_mobile) }}" >
                    @if($errors->has('alternate_mobile'))
                    <div class="invalid-feedback">
                        {{ $errors->first('alternate_mobile') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.contact.fields.alternate_mobile_helper') }}</span>
                </div>
                @endif   
            </div>




    </div>



    <div class="form-group">
        <button class="btn btn-danger" type="submit">
            {{ trans('global.save') }}
        </button>
    </div>

</form>
</div>
</div>



@endsection
@section('scripts')
<script>
    window.onbeforeunload = function () {
        return 'Your changes will be lost!';
    };
</script>
@endsection