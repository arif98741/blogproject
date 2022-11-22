@extends('back.layout.layout')
@section('title','Add Category')
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                    class="fa fa-home"></i>&nbsp;@lang('Home')</a>
                        </li>
                        <li class="breadcrumb-item"><a href="{{ route('admin.category.index') }}">@lang('Category') </a></li>
                        <li class="breadcrumb-item active">@lang('Add Category')</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('admin.category.index') }}" class="btn btn-primary btn-sm float-sm-right">@lang('Back to
                        categories')</a>
                </div>
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <div class="col-md-8 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <form id="categoryFormSubmit" class="forms-sample"
                          action="{{ route('admin.category.store') }}"
                          enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('post')
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="">@lang('Category Title')</label>
                                    <input name="category_name" id="category_name"
                                           type="text" class="form-control">
                                </div>

                                <div class="form-group">
                                    <label for="">@lang('Category Thumbanil')</label>
                                    <input name="image" id="imgFile"
                                           type="file" class="form-control">
                                    <img id="imgPreview" style="width: 150px; height: 150px; " class="d-none mt-3"
                                         src="#" alt="your image"/>
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

        <script src="{{ asset('assets/back/plugins/dropzone/min/dropzone.min.js') }}"></script>
        <script>

            function readURL(input) {
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
            });

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
                            $('#imgFile').val('');
                            $('#imgPreview').addClass('d-none');
                            toastr.success(data.success);
                        }
                    },
                    error: function (e) {
                        let errors = e.responseJSON.errors;
                        Object.keys(errors).forEach(key => {
                            toastr.error(errors[key][0]);
                        });
                    },
                    complete: function () {
                        form.find('input').each(function (e, data) {
                            $('#category_name').val('');
                        });

                        $('.btn-save').text('Save');
                    }
                });
            });
        </script>

    @endpush

@endsection
