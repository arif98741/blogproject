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
                          action="{{ route('admin.slider.update',$slider->id) }}"
                          enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">@lang('Slider Title')</label>
                                    <input name="title" id="title"
                                           value="{{ !empty(old('title')) ? old('title') : $slider->title  }}"
                                           type="text" class="form-control">
                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                            <p class="text-red">{{ $errors->first('title') }}</p> </span>
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label for="">Slider Type</label>
                                    <select name="slider_type_id" id="" class="form-control">
                                        <option value="">Select Type</option>
                                        @foreach($slider_types as $slider_type)
                                            <option
                                                value="{{ $slider_type->id }}"
                                                @if($slider_type->id == $slider->slider_type_id) selected @endif>{{ $slider_type->type_name }}</option>
                                        @endforeach
                                    </select>
                                    @if ($errors->has('slider_type_id'))
                                        <span class="help-block">
                                            <p class="text-red">{{ $errors->first('slider_type_id') }}</p> </span>
                                    @endif
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
                                        <input id="thumbnail" class="form-control" value="{{ asset($slider->image) }}"
                                               required type="text"
                                               name="image">
                                        @if ($errors->has('image'))
                                            <span class="help-block">
                                            <p class="text-red">{{ $errors->first('image') }}</p> </span>
                                        @endif
                                    </div>
                                    <div id="image_preview" style="margin-top:15px;max-height:100px;">
                                        <img style="width: 60px; height: 60px;" src="{{ asset($slider->image) }}"
                                             alt="">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Status</label>
                                    <select name="status" id="" class="form-control">
                                        <option value="1" @if($slider->status == 1) selected @endif>Active</option>
                                        <option value="0" @if($slider->status == 0) selected @endif>Not Active</option>
                                    </select>
                                    @if ($errors->has('status'))
                                        <span class="help-block">
                                            <p class="text-red">{{ $errors->first('status') }}</p> </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-save  mr-2">@lang('Update')</button>
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
            $('#slider_thumbnail_filemanager').filemanager('image');

        </script>

    @endpush

@endsection
