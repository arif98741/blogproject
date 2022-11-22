@extends('back.layout.layout')
@section('title','Edit Slider')
@section('content')
    <div class="content-header">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                            class="fa fa-home"></i>&nbsp;@lang('Home')</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('admin.slider.index') }}">@lang('Sliders') </a></li>
                <li class="breadcrumb-item active" aria-current="page">@lang('Edit Slider')</li>
            </ol>
        </nav>

    </div>
    <div class="container-fluid">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form id="categoryFormSubmit" class="forms-sample"
                          action="{{ route('admin.slider.update',$category->id) }}"
                          enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('put')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">Slider Title</label>
                                    <input name="category_name"
                                           value="{{ (!empty(old('category_name'))) ? old('category_name') : $category->category_name }}"
                                           id="category_name"
                                           type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">Image</label>
                                    <input type="file" name="image">
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-success btn-save  mr-2">Save</button>
                        <button class="btn btn-info ">Back</button>
                    </form>


                </div>
            </div>
        </div>
    </div>

    @push('extra-css')
        <link rel="stylesheet" href="{{ asset('assets/back/plugins/dropzone/min/dropzone.min.css') }}">
    @endpush
    @push('extra-script')
        <script src="{{ asset('assets/back/plugins/dropzone/min/dropzone.min.js') }}"></script>
        <script>


            $("#categoryFormSubmit").submit(function (e) {
                e.preventDefault(); // avoid to execute the actual submit of the form.

                const form = $(this);
                const url = form.attr('action');


                $('.btn-save').text('Saving');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: form.serialize(), // serializes the form's elements.
                    success: function (data, textStatus, xhr) {

                        if (xhr.status === 200) {
                            toastr.success(data.success);
                            setTimeout(function () {
                                 window.location.href = '{{ route('admin.slider.index') }}';
                            }, 1000);
                        }
                    },
                    error: function (e) {
                        let errors = e.responseJSON.errors;
                        Object.keys(errors).forEach(key => {
                            toastr.error(errors[key][0]);
                        });
                    },
                    complete: function () {
                        $('.btn-save').text('Save');
                    }
                });
            });
        </script>
    @endpush

@endsection
