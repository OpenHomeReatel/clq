@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.listing.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" novalidate action="{{ route("admin.listings.store") }}" enctype="multipart/form-data" class="row g-3">
            @csrf
            <div class="form-group col-md-6">
                <label class="required" for="title">{{ trans('cruds.listing.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', '') }}" required>
                @if($errors->has('title'))
                <div class="invalid-feedback">
                    {{ $errors->first('title') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.title_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label class="required">{{ trans('cruds.listing.fields.type') }}</label>
                <select class="form-control {{ $errors->has('type') ? 'is-invalid' : '' }}" name="type" id="type" required>
                    <option value disabled {{ old('type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Listing::TYPE_SELECT as $key => $label)
                    <option value="{{ $key }}" {{ old('type', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('type'))
                <div class="invalid-feedback">
                    {{ $errors->first('type') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.type_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label class="required">{{ trans('cruds.listing.fields.purpose') }}</label>
                <select onchange="yesnoCheck(this);" class="form-control {{ $errors->has('purpose') ? 'is-invalid' : '' }}" name="purpose" id="purpose" required>
                    <option value disabled {{ old('purpose', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Listing::PURPOSE_SELECT as $key => $label)
                    <option value="{{ $key }}" {{ old('purpose', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('purpose'))
                <div class="invalid-feedback">
                    {{ $errors->first('purpose') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.purpose_helper') }}</span>
            </div>
            
            <div id="ifYes" class="form-group col-md-6" style="display: none ;">
                <label>{{ trans('cruds.listing.fields.rent_pricing_duration') }}</label>
                <select class="form-control {{ $errors->has('rent_pricing_duration') ? 'is-invalid' : '' }}" name="rent_pricing_duration" id="rent_pricing_duration">
                    <option value disabled {{ old('rent_pricing_duration', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Listing::PRICING_DURATION_SELECT as $key => $label)
                    <option value="{{ $key }}" {{ old('rent_pricing_duration', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('rent_pricing_duration'))
                <div class="invalid-feedback">
                    {{ $errors->first('rent_pricing_duration') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.rent_pricing_duration_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label class="required" for="emirate">{{ trans('cruds.listing.fields.emirate') }}</label>
                <input class="form-control {{ $errors->has('emirate') ? 'is-invalid' : '' }}" type="text" name="emirate" id="emirate" value="{{ old('emirate', '') }}" required>
                @if($errors->has('emirate'))
                <div class="invalid-feedback">
                    {{ $errors->first('emirate') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.emirate_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label class="required" for="community">{{ trans('cruds.listing.fields.community') }}</label>
                <input class="form-control {{ $errors->has('community') ? 'is-invalid' : '' }}" type="text" name="community" id="community" value="{{ old('community', '') }}" required>
                @if($errors->has('community'))
                <div class="invalid-feedback">
                    {{ $errors->first('community') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.community_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label class="required" for="price">{{ trans('cruds.listing.fields.price') }}</label>
                <input class="form-control {{ $errors->has('price') ? 'is-invalid' : '' }}" type="number" name="price" id="price" value="{{ old('price', '') }}" step="0.01" required>
                @if($errors->has('price'))
                <div class="invalid-feedback">
                    {{ $errors->first('price') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.price_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label class="required" for="beds">{{ trans('cruds.listing.fields.beds') }}</label>
                <select id="beds" name="beds" class="form-control form-control-lg {{ $errors->has('beds') ? 'is-invalid' : '' }}">
                    <option value="">Any</option>
                    <option value="studio">Studio</option>
                    @foreach(range(1, 20) as $val)
                    <option {!! request('beds') == $val ? 'selected' : '' !!} value="{{ $val }}">{{ $val }}</option>
                    @endforeach
                </select>
                @if($errors->has('beds'))
                <div class="invalid-feedback">
                    {{ $errors->first('beds') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.beds_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label class="required" for="baths">{{ trans('cruds.listing.fields.baths') }}</label>
                <input class="form-control {{ $errors->has('baths') ? 'is-invalid' : '' }}" type="number" name="baths" id="baths" value="{{ old('baths', '') }}" step="1" required>
                @if($errors->has('baths'))
                <div class="invalid-feedback">
                    {{ $errors->first('baths') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.baths_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label for="plotarea">Plot Area Size</label>
                <input class="form-control {{ $errors->has('plotarea_size') ? 'is-invalid' : '' }}" type="number" name="plotarea_size" id="plotarea_size" value="{{ old('plotarea_size', '') }}" step="0.01" >
                @if($errors->has('plotarea_size'))
                <div class="invalid-feedback">
                    {{ $errors->first('plotarea_size') }}
                </div>
                @endif
                <span class="help-block"></span>
            </div> 
            <div class="form-group col-md-6">
                <label>Plot Area Size Postfix </label>
                <input class="form-control {{ $errors->has('plotarea_size_postfix') ? 'is-invalid' : '' }}" type="text" name="plotarea_size_postfix" id="plotarea_size_postfix" value="{{ old('plotarea_size_postfix', '') }}">
                @if($errors->has('plotarea_size_postfix'))
                <div class="invalid-feedback">
                    {{ $errors->first('plotarea_size_postfix') }}
                </div>
                @endif
                <span class="help-block"></span>
            </div>
            <div class="form-group col-md-6">
                <label class="required" for="area">Area Size</label>
                <input class="form-control {{ $errors->has('area_size') ? 'is-invalid' : '' }}" type="number" name="area_size" id="area_size" value="{{ old('area_size', '') }}" step="0.01" required>
                @if($errors->has('area_size'))
                <div class="invalid-feedback">
                    {{ $errors->first('area_size') }}
                </div>
                @endif
                <span class="help-block"></span>
            </div>
            <div class="form-group col-md-6">
                <label class="required" for="area_size_postfix">Area Size Postfix</label>
                <input class="form-control {{ $errors->has('area_size_postfix') ? 'is-invalid' : '' }}" type="text" name="area_size_postfix" id="area_size_postfix" value="{{ old('area_size_postfix', '') }}"  required>
                @if($errors->has('area_size_postfix'))
                <div class="invalid-feedback">
                    {{ $errors->first('area_size_postfix') }}
                </div>
                @endif
                <span class="help-block"></span>
            </div>
           
            <div class="form-group col-md-6">
                <label for="developer">{{ trans('cruds.listing.fields.developer') }}</label>
                <input class="form-control {{ $errors->has('developer') ? 'is-invalid' : '' }}" type="text" name="developer" id="developer" value="{{ old('developer', '') }}">
                @if($errors->has('developer'))
                <div class="invalid-feedback">
                    {{ $errors->first('developer') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.developer_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label for="note">Private {{ trans('cruds.listing.fields.note') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                <div class="invalid-feedback">
                    {{ $errors->first('note') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.note_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label class="required" for="description">{{ trans('cruds.listing.fields.description') }}</label>
                <textarea  maxlength="300" class="form-control ckeditor {{ $errors->has('description') ? 'is-invalid' : '' }}" name="description" id="description" required>{{ old('description') }}</textarea>

                @if($errors->has('description'))
                <div class="invalid-feedback">
                    {{ $errors->first('description') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.description_helper') }}</span>

            </div>
            <div id="charNum"></div>
            <div class="form-group col-md-6">
                <label class="required">{{ trans('cruds.listing.fields.state') }}</label>
                <select class="form-control {{ $errors->has('state') ? 'is-invalid' : '' }}" name="state" id="state" required>
                    <option value disabled {{ old('state', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Listing::STATE_SELECT as $key => $label)
                    <option value="{{ $key }}" {{ old('state', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('state'))
                <div class="invalid-feedback">
                    {{ $errors->first('state') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.state_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label class="required" for="owner_id">Landlord</label>
                <select class="form-control select2 {{ $errors->has('owner') ? 'is-invalid' : '' }}" name="owner_id" id="owner_id" required>
                    @foreach($owners as $id => $entry)
                    <option value="{{ $id }}" {{ old('owner_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('owner'))
                <div class="invalid-feedback">
                    {{ $errors->first('owner') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.owner_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label class="required" for="user_id">{{ trans('cruds.listing.fields.user') }}</label>
                <select class="form-control select2 {{ $errors->has('user') ? 'is-invalid' : '' }}" name="user_id" id="user_id" required>
                    @foreach($users as $id => $entry)
                    <option value="{{ $id }}" {{ old('user_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('user'))
                <div class="invalid-feedback">
                    {{ $errors->first('user') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.user_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label class="" for="project_id">Project</label>
                <select class="form-control select2 {{ $errors->has('project') ? 'is-invalid' : '' }}" name="project_id" id="project_id" >
                    @foreach($projects as $id => $entry)
                    <option value="{{ $id }}" {{ old('project_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('project'))
                <div class="invalid-feedback">
                    {{ $errors->first('project') }}
                </div>
                @endif

            </div>
            <div class="form-group col-md-6">
                <label for="thumbnail" class="required">{{ trans('cruds.listing.fields.thumbnail') }}</label>
                <div class="needsclick dropzone {{ $errors->has('thumbnail') ? 'is-invalid' : '' }}" id="thumbnail-dropzone" required>
                </div>
                @if($errors->has('thumbnail'))
                <div class="invalid-feedback">
                    {{ $errors->first('thumbnail') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.thumbnail_helper') }}</span>
            </div>
            <div class="form-group col-md-6">
                <label for="images">{{ trans('cruds.listing.fields.images') }}</label>
                <div class="needsclick dropzone {{ $errors->has('images') ? 'is-invalid' : '' }}" id="images-dropzone">
                </div>
                @if($errors->has('images'))
                <div class="invalid-feedback">
                    {{ $errors->first('images') }}
                </div>
                @endif
                <span class="help-block">{{ trans('cruds.listing.fields.images_helper') }}</span>
            </div>
            <div class="form-group col-md-12">
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
            <div class="form-group col-md-12">
                <button class="btn btn-success" type="submit">
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
    url: '{{ route('admin.listings.storeMedia') }}',
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
            @if (isset($listing) && $listing->thumbnail)
                    var file = {!! json_encode($listing->thumbnail) !!}
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
    url: '{{ route('admin.listings.storeMedia') }}',
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
            @if (isset($listing) && $listing->images)
                    var files = {!! json_encode($listing->images) !!}
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
            xhr.open('POST', '{{ route('admin.listings.storeCKEditorImages') }}', true);
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
            data.append('crud_id', '{{ $listing->id ?? 0 }}');
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
    url: '{{ route('admin.listings.storeMedia') }}',
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
            @if (isset($listing) && $listing->files)
                    var files =
            {!! json_encode($listing->files) !!}
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
<script>
    function yesnoCheck(that) {
    if (that.value == "rent") {
    alert("Display Rent Pricing Duration ?");
    document.getElementById("ifYes").style.display = "block";
    } else {
    document.getElementById("ifYes").style.display = "none";
    }
    }
</script>

<script>
window.onbeforeunload = function() {
  return 'Your changes will be lost!';
};
</script>
@endsection
