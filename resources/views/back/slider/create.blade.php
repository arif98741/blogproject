@extends('back.layout.layout')
@section('title','Add Slider')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                    class="fa fa-home"></i>&nbsp;@lang('Home')</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.slider.index') }}">@lang('Slider') </a>
                        </li>
                        <li class="breadcrumb-item active">@lang('Add Slider')</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('admin.slider.index') }}" class="btn btn-primary btn-sm float-sm-right">@lang('Back to
                        sliders')</a>
                </div>
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form id="categoryFormSubmit" class="forms-sample"
                          action="{{ route('admin.slider.store') }}"
                          enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">@lang('Slider Title')</label>
                                    <input name="title" id="title" value="{{ old('title') }}"
                                           type="text" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Slider Type</label>
                                    <input name="type" id="type" value="{{ old('type') }}"
                                           type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <div class="input-group">
                                       <span class="input-group-btn">
                                         <a id="slider_thumbnail_filemanager" data-input="thumbnail"
                                            data-preview="image_preview" class="btn btn-dark"
                                            style="border-radius: 0px;">
                                           <i class="fa fa-picture-o"></i> @lang('Slider image')
                                         </a>
                                       </span>
                                        <input id="thumbnail" class="form-control" type="text"
                                               name="thumbnail_path">
                                    </div>
                                    <div id="image_preview" style="margin-top:15px;max-height:100px;"></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="1">Active</option>
                                        <option value="0">Not Active</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-save  mr-2">@lang('Save')</button>
                        <button class="btn btn-info ">@lang('Back')</button>
                    </form>


                </div>
            </div>
        </div>
    </div>

    @push('extra-css')
        <link rel="stylesheet" href="{{ asset('assets/back/plugins/dropzone/min/dropzone.min.css') }}">

    @endpush
    @push('extra-script')

        <script src="{{ asset('assets/back/plugins/summernote/summernote-bs4.min.js')}}"></script>
        <script src="{{ asset('assets/back/plugins/select2/js/select2.full.min.js')}}"></script>
        <script src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js')}}"></script>
        <script src="{{ asset('assets/back/plugins/dropzone/min/dropzone.min.js') }}"></script>
        <script>

            /*function readURL(input) {
                if (input.files && input.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function (e) {
                        $('#imgPreview').attr('src', e.target.result)
                            .removeClass('d-none');
                    }

                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#imgFile").change(function () {
                readURL(this);
            });*/
            $('#slider_thumbnail_filemanager').filemanager('image');

        </script>

    @endpush

@endsection
