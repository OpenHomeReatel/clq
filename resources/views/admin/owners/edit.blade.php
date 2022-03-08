@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.owner.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.owners.update", [$owner->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required">{{ trans('cruds.owner.fields.salutation') }}</label>
                    <select class="form-control {{ $errors->has('salutation') ? 'is-invalid' : '' }}" name="salutation" id="salutation" required>
                        <option value disabled {{ old('salutation', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Owner::SALUTATION_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('salutation', $owner->salutation) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('salutation'))
                    <div class="invalid-feedback">
                        {{ $errors->first('salutation') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.owner.fields.salutation_helper') }}</span>
                </div>
            </div>
            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required" for="firstname">{{ trans('cruds.owner.fields.firstname') }}</label>
                    <input class="form-control {{ $errors->has('firstname') ? 'is-invalid' : '' }}" type="text" name="firstname" id="firstname" value="{{ old('firstname', $owner->firstname) }}" required>
                    @if($errors->has('firstname'))
                    <div class="invalid-feedback">
                        {{ $errors->first('firstname') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.owner.fields.firstname_helper') }}</span>
                </div>

                <div class="form-group col-md">
                    <label class="required" for="lastname">{{ trans('cruds.owner.fields.lastname') }}</label>
                    <input class="form-control {{ $errors->has('lastname') ? 'is-invalid' : '' }}" type="text" name="lastname" id="lastname" value="{{ old('lastname', $owner->lastname) }}" required>
                    @if($errors->has('lastname'))
                    <div class="invalid-feedback">
                        {{ $errors->first('lastname') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.owner.fields.lastname_helper') }}</span>
                </div>
            </div>
            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required" for="email">{{ trans('cruds.owner.fields.email') }}</label>
                    <input class="form-control {{ $errors->has('email') ? 'is-invalid' : '' }}" type="email" name="email" id="email" value="{{ old('email', $owner->email) }}" required>
                    @if($errors->has('email'))
                    <div class="invalid-feedback">
                        {{ $errors->first('email') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.owner.fields.email_helper') }}</span>
                </div>
                <div class="form-group col-md">
                    <label for="emirate_id_number">{{ trans('cruds.owner.fields.emirate_id_number') }}</label>
                    <input class="form-control {{ $errors->has('emirate_id_number') ? 'is-invalid' : '' }}" type="text" name="emirate_id_number" id="emirate_id_number" value="{{ old('emirate_id_number', $owner->emirate_id_number) }}">
                    @if($errors->has('emirate_id_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('emirate_id_number') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.owner.fields.emirate_id_number_helper') }}</span>
                </div>
            </div>
            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required">{{ trans('cruds.owner.fields.source') }}</label>
                    <select  class="form-control{{ $errors->has('source') ? 'is-invalid' : '' }}" name="source" id="source" required>
                        <option value disabled {{ old('source', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                        @foreach(App\Models\Owner::SOURCE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('source', $owner->source) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('source'))
                    <div class="invalid-feedback">
                        {{ $errors->first('source') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.owner.fields.source_helper') }}</span>
                </div>
                <div class="form-group col-md">
                    <label for="nationality">{{ trans('cruds.owner.fields.nationality') }}</label>
                    <input class="form-control {{ $errors->has('nationality') ? 'is-invalid' : '' }}" type="text" name="nationality" id="nationality" value="{{ old('nationality', $owner->nationality) }}">
                    @if($errors->has('nationality'))
                    <div class="invalid-feedback">
                        {{ $errors->first('nationality') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.owner.fields.nationality_helper') }}</span>
                </div>
            </div>
            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required" for="assign_id">{{ trans('cruds.owner.fields.assign') }}</label>
                    <select class="form-control  {{ $errors->has('assign') ? 'is-invalid' : '' }}" name="assign_id" id="assign_id" required>
                        @foreach($assigns as $id => $entry)
                        <option value="{{ $id }}" {{ (old('assign_id') ? old('assign_id') : $owner->assign->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('assign'))
                    <div class="invalid-feedback">
                        {{ $errors->first('assign') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.owner.fields.assign_helper') }}</span>
                </div>
                <div class="form-group col-md">
                <label for="projects">{{ trans('cruds.user.fields.projects') }}</label>
                
                <select class="form-control select2 {{ $errors->has('projects') ? 'is-invalid' : '' }}" name="projects[]" id="projects" multiple required>
                    
                      @foreach($projects as $key => $label)
                        <option value="{{ $label }}" {{ old('projects') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach 
                </select>
               
                @if($errors->has('projects'))
                    <div class="invalid-feedback">
                        {{ $errors->first('projects') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.user.fields.projects_helper') }}</span>
            </div>
                <div class="form-group col-md">
                    <label class="required" for="mobile">{{ trans('cruds.owner.fields.mobile') }}</label>
                    <input class="form-control {{ $errors->has('mobile') ? 'is-invalid' : '' }}" type="text" name="mobile" id="mobile" value="{{ old('mobile', $owner->mobile) }}" required>
                    @if($errors->has('mobile'))
                    <div class="invalid-feedback">
                        {{ $errors->first('mobile') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.owner.fields.mobile_helper') }}</span>

                </div>   
                <div class="form-group col-md">
                    <label for="alternate_mobile">{{ trans('cruds.owner.fields.alternate_mobile') }}</label>
                    <input class="form-control {{ $errors->has('alternate_mobile') ? 'is-invalid' : '' }}" type="text" name="alternate_mobile" id="alternate_mobile" value="{{ old('alternate_mobile', $owner->alternate_mobile) }}" >
                    @if($errors->has('alternate_mobile'))
                    <div class="invalid-feedback">
                        {{ $errors->first('alternate_mobile') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.owner.fields.alternate_mobile_helper') }}</span>
                </div>
            </div>
            <div class="row g-2">

                <div class="form-group col-md">
                    <label for="files">Files</label>
                    <div class="needsclick dropzone {{ $errors->has('files') ? 'is-invalid' : '' }}" id="files-dropzone">
                    </div>
                    @if($errors->has('files'))
                    <div class="invalid-feedback">
                        {{ $errors->first('files') }}
                    </div>
                    @endif
                    <span class="help-block"></span>
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
    var uploadedFilesMap = {}
    Dropzone.options.filesDropzone = {
    url: '{{ route('admin.owners.storeMedia') }}',
            maxFilesize: 20, // MB
            addRemoveLinks: true,
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
            size: 2
            },
            success: function (file, response) {
            $('form').append('<input type="hidden" name="files[]" value="' + response.name + '">')
                    uploadedFilesMap[file.name] = response.name
            },
            removedfile: function (file) {
            file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
            name = file.file_name
            } else {
            name = uploadedFilesMap[file.name]
            }
            $('form').find('input[name="files[]"][value="' + name + '"]').remove()
            },
            init: function () {
            @if (isset($owner) && $owner->files)
                    var files =
            {!! json_encode($owner->files) !!}
            for (var i in files) {
            var file = files[i]
                    this.options.addedfile.call(this, file)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="files[]" value="' + file.file_name + '">')
            }
            @endif
            },
            error: function (file, response) {
            if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
            } else {
            var message = response.errors.file
            }
            file.previewElement.classList.add('dz-error')
                    _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
                    _results = []
                    for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
                    _results.push(node.textContent = message)
            }

            return _results
            }
    }
</script>

@endsection
@section('scripts')
<script>
    window.onbeforeunload = function() {
    return 'Your changes will be lost!';
    };
</script>
@endsection