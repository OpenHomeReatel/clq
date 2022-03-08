@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.project.title_singular') }}
    </div>

    <div class="card-body">
        <form enctype="multipart/form-data" method="POST" novalidate action="{{ route("admin.projects.store") }}" >
            @csrf
            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required" for="name">{{ trans('cruds.project.fields.name') }}</label>
                    <input class="form-control {{ $errors->has('name') ? 'is-invalid' : '' }}" type="text" name="name" id="name" value="{{ old('name', '') }}" required>
                    @if($errors->has('name'))
                    <div class="invalid-feedback">
                        {{ $errors->first('name') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.name_helper') }}</span>
                </div>
                <div class="form-group col-md">
                    <label class="required" for="title">{{ trans('cruds.project.fields.title') }}</label>
                    <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                    @if($errors->has('title'))
                    <div class="invalid-feedback">
                        {{ $errors->first('title') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.title_helper') }}</span>
                </div>

            </div>
            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required">{{ trans('cruds.project.fields.property_type') }}</label>
                    <select class="form-control  select2 {{ $errors->has('property_type') ? 'is-invalid' : '' }}" name="property_type[]" id="property_type" required multiple="">
                        <option value disabled {{ old('property_type', null) === null ? 'selected' : '' }}></option>
                        @foreach(App\Models\Project::PROPERTY_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('property_type') == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('property_type'))
                    <div class="invalid-feedback">
                        {{ $errors->first('property_type') }}
                    </div>
                    @endif
                    <span  class="help-block">{{ trans('cruds.project.fields.property_type_helper') }}</span>
                </div>
                <div class="form-group col-md">
                    <label class="required" for="developer">{{ trans('cruds.project.fields.developer') }}</label>
                    <input class="form-control {{ $errors->has('developer') ? 'is-invalid' : '' }}" type="text" name="developer" id="developer" value="{{ old('developer', '') }}" required>
                    @if($errors->has('developer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('developer') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.developer_helper') }}</span>
                </div>
            </div>
            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required" for="emirate">{{ trans('cruds.project.fields.emirate') }}</label>
                    <input class="form-control {{ $errors->has('emirate') ? 'is-invalid' : '' }}" type="text" name="emirate" id="emirate" value="{{ old('emirate', '') }}" required>
                    @if($errors->has('emirate'))
                    <div class="invalid-feedback">
                        {{ $errors->first('emirate') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.emirate_helper') }}</span>
                </div>
                <div class="form-group col-md">
                    <label for="state">{{ trans('cruds.project.fields.state') }}</label>
                    <input class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" type="text" name="state" id="state" value="{{ old('state', '') }}">
                    @if($errors->has('state'))
                    <div class="invalid-feedback">
                        {{ $errors->first('state') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.state_helper') }}</span>
                </div>

            </div>

            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required" for="community">{{ trans('cruds.project.fields.community') }}</label>
                    <input class="form-control {{ $errors->has('community') ? 'is-invalid' : '' }}" type="text" name="community" id="community" value="{{ old('community', '') }}" required>
                    @if($errors->has('community'))
                    <div class="invalid-feedback">
                        {{ $errors->first('community') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.community_helper') }}</span>
                </div>

                <div class="form-group col-md">
                    <label for="floor_number">{{ trans('cruds.project.fields.floor_number') }}</label>
                    <input class="form-control {{ $errors->has('floor_number') ? 'is-invalid' : '' }}" type="number" name="floor_number" id="floor_number" value="{{ old('floor_number', '') }}" step="1">
                    @if($errors->has('floor_number'))
                    <div class="invalid-feedback">
                        {{ $errors->first('floor_number') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.floor_number_helper') }}</span>
                </div>    
            </div>
            <div class="row g-2">
                <div class="form-group col-md">
                    <label  for="owner_id">{{ trans('cruds.project.fields.owner') }}</label>
                    <select class="form-control select2 {{ $errors->has('owner') ? 'is-invalid' : '' }}" name="owner_id" id="owner_id">
                        @foreach($owners as $id => $entry)
                        <option value="{{ $id }}" {{ old('owner_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('owner'))
                    <div class="invalid-feedback">
                        {{ $errors->first('owner') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.owner_helper') }}</span>
                </div>


            </div>
            <div class="row g-2">
                <div class="form-group col-md">
                    <label for="note">Private Note</label>
                    <textarea class="form-control ckeditor {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                    @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.note_helper') }}</span>
                </div>

                <div class="form-group col-md">
                    <label class="required" for="description">{{ trans('cruds.project.fields.description') }}</label>
                    <textarea class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" required>{{ old('description') }}</textarea>
                    @if($errors->has('description'))
                    <div class="invalid-feedback">
                        {{ $errors->first('description') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.description_helper') }}</span>
                </div>
            </div>

            <div class="row g-2">
                <div class="form-group col-md">
                    <label class="required" for="thumbnail">{{ trans('cruds.project.fields.thumbnail') }}</label>
                    <div class="needsclick dropzone {{ $errors->has('thumbnail') ? 'is-invalid' : '' }}" id="thumbnail-dropzone">
                    </div>
                    @if($errors->has('thumbnail'))
                    <div class="invalid-feedback">
                        {{ $errors->first('thumbnail') }}
                    </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.project.fields.thumbnail_helper') }}</span>
                </div> 
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
    Dropzone.options.thumbnailDropzone = {
    url: '{{ route('admin.projects.storeMedia') }}',
            maxFilesize: 30, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            maxFiles: 1,
            addRemoveLinks: true,
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
            size: 30,
                    width: 10000,
                    height: 10000
            },
            success: function (file, response) {
            $('form').find('input[name="thumbnail"]').remove()
                    $('form').append('<input type="hidden" name="thumbnail" value="' + response.name + '">')
            },
            removedfile: function (file) {
            file.previewElement.remove()
                    if (file.status !== 'error') {
            $('form').find('input[name="thumbnail"]').remove()
                    this.options.maxFiles = this.options.maxFiles + 1
            }
            },
            init: function () {
            @if (isset($project) && $project->thumbnail)
                    var file = {!! json_encode($project->thumbnail) !!}
            this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="thumbnail" value="' + file.file_name + '">')
                    this.options.maxFiles = this.options.maxFiles - 1
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
<script>
    var uploadedImagesMap = {}
    Dropzone.options.imagesDropzone = {
    url: '{{ route('admin.projects.storeMedia') }}',
            maxFilesize: 100, // MB
            acceptedFiles: '.jpeg,.jpg,.png,.gif',
            addRemoveLinks: true,
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
            size: 100,
                    width: 10000,
                    height: 10000
            },
            success: function (file, response) {
            $('form').append('<input type="hidden" name="images[]" value="' + response.name + '">')
                    uploadedImagesMap[file.name] = response.name
            },
            removedfile: function (file) {
            console.log(file)
                    file.previewElement.remove()
                    var name = ''
                    if (typeof file.file_name !== 'undefined') {
            name = file.file_name
            } else {
            name = uploadedImagesMap[file.name]
            }
            $('form').find('input[name="images[]"][value="' + name + '"]').remove()
            },
            init: function () {
            @if (isset($project) && $project->images)
                    var files = {!! json_encode($project->images) !!}
            for (var i in files) {
            var file = files[i]
                    this.options.addedfile.call(this, file)
                    this.options.thumbnail.call(this, file, file.preview)
                    file.previewElement.classList.add('dz-complete')
                    $('form').append('<input type="hidden" name="images[]" value="' + file.file_name + '">')
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
<script>
    $(document).ready(function () {
    function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
    return {
    upload: function() {
    return loader.file
            .then(function (file) {
            return new Promise(function(resolve, reject) {
            // Init request
            var xhr = new XMLHttpRequest();
            xhr.open('POST', '{{ route('admin.projects.storeCKEditorImages') }}', true);
            xhr.setRequestHeader('x-csrf-token', window._token);
            xhr.setRequestHeader('Accept', 'application/json');
            xhr.responseType = 'json';
            // Init listeners
            var genericErrorText = `Couldn't upload file: ${ file.name }.`;
            xhr.addEventListener('error', function() { reject(genericErrorText) });
            xhr.addEventListener('abort', function() { reject() });
            xhr.addEventListener('load', function() {
            var response = xhr.response;
            if (!response || xhr.status !== 201) {
            return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
            }

            $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');
            resolve({ default: response.url });
            });
            if (xhr.upload) {
            xhr.upload.addEventListener('progress', function(e) {
            if (e.lengthComputable) {
            loader.uploadTotal = e.total;
            loader.uploaded = e.loaded;
            }
            });
            }

            // Send request
            var data = new FormData();
            data.append('upload', file);
            data.append('crud_id', '{{ $project->id ?? 0 }}');
            xhr.send(data);
            });
            })
    }
    };
    }
    }

    var allEditors = document.querySelectorAll('.ckeditor');
    for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
            allEditors[i], {
    extraPlugins: [SimpleUploadAdapter]
    }
    );
    }
    });</script>
<script>
    var uploadedFilesMap = {}
    Dropzone.options.filesDropzone = {
    url: '{{ route('admin.projects.storeMedia') }}',
            maxFilesize: 30, // MB
            addRemoveLinks: true,
            headers: {
            'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            params: {
            size: 200
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
            @if (isset($project) && $project->files)
                    var files =
            {!! json_encode($project->files) !!}
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