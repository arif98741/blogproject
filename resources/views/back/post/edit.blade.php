@extends('back.layout.layout')
@section('title','Edit Post')
@section('content')
    <div class="content-header">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                            class="ti-home"></i>&nbsp;Home</a>
                </li>
                <li class="breadcrumb-item"><a href="{{ route('admin.post.index') }}">Post</a></li>
                <li class="breadcrumb-item active" aria-current="page">Edit Post</li>
            </ol>
        </nav>

    </div>
    <div class="container">

        <div class="card">
            <div class="card-body">
                <form id="postFormSubmit" class="forms-sample" action="{{ route('admin.post.update',$post->id) }}"
                      enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('put')

                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input name="title" type="text" id="title" class="form-control"
                                               value="{{ (!empty(old('title')))  ? old('title') : $post->title }}"
                                               placeholder="Title">
                                        @if ($errors->has('title'))
                                            <span class="help-block">
                                            <p class="text-red">{{ $errors->first('title') }}</p> </span>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Feature Image</label>
                                        <input type="file" id="feature_image" name="feature_image">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Description</label>
                                        <textarea name="description" id="summernote" cols="30" rows="5"
                                                  class="form-control"
                                                  placeholder="Enter text here">{{ (!empty(old('description')))  ? old('description') : $post->description }}</textarea>
                                        @if ($errors->has('description'))
                                            <span class="help-block">
                                            <p class="text-red">{{ $errors->first('description') }}</p> </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Meta Title</label>
                                        <input type="text" name="meta_title" id="meta_title"
                                               value="{{ (!empty(old('meta_title')))  ? old('meta_title') : $post->meta_title }}"
                                               class="form-control">
                                        @if ($errors->has('meta_title'))
                                            <span class="help-block">
                                            <p class="text-red">{{ $errors->first('meta_title') }}</p> </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" cols="30" rows="2"
                                                  class="form-control">{{ (!empty(old('meta_description')))  ? old('meta_description') : $post->meta_description }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Meta Keywords</label>
                                        <textarea name="meta_description" id="meta_description" cols="30" rows="2"
                                                  class="form-control">{{ (!empty(old('meta_keywords')))  ? old('meta_keywords') : $post->meta_keywords }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="form-group">
                                <label>Categories</label>
                                @foreach($categories as $key=> $category)
                                    <div class="form-group form-check">
                                        <input type="checkbox" value="{{ $category->id }}" name="categories[]"
                                               class="form-check-input" id="exampleCheck1">
                                        <label class="form-check-label"
                                               for="exampleCheck1">{{ $category->category_name }}</label>
                                    </div>
                                @endforeach
                                @if ($errors->has('status'))
                                    <span class="help-block">
                                            <p class="text-red">{{ $errors->first('status') }}</p> </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" id="status" class="form-control">
                                    @foreach($post_statuses as $key=> $post_status)

                                        <option value="{{ $post_status }}"
                                                @if($post_status == 'published') selected @endif>{{ $post_status }}</option>
                                    @endforeach

                                </select>
                                @if ($errors->has('status'))
                                    <span class="help-block">
                                            <p class="text-red">{{ $errors->first('status') }}</p> </span>
                                @endif
                            </div>
                        </div>
                    </div>


                    <button type="submit" class="btn btn-success btn-save mr-2">Update</button>
                    <button class="btn btn-info">Back</button>
                </form>

            </div>
        </div>

    </div>

    @push('extra-css')
        <link rel="stylesheet" href="{{ asset('assets/back/plugins/summernote/summernote.min.css')}}"></link>
    @endpush
    @push('extra-script')

        <script src="{{ asset('assets/back/plugins/summernote/summernote-bs4.min.js')}}"></script>
        <script>
            $(document).ready(function () {

                // Define function to open filemanager window
                const lfm = function (options, cb) {
                    const route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
                    window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=1200,height=600');

                    window.SetUrl = cb;
                };

                // Define LFM summernote button
                const LFMButton = function (context) {
                    const ui = $.summernote.ui;
                    const button = ui.button({
                        contents: '<i class="note-icon-picture"></i> ',
                        tooltip: 'Insert image with filemanager',
                        click: function () {

                            lfm({type: 'image', prefix: '/filemanager'}, function (lfmItems, path) {

                                lfmItems.forEach(function (lfmItem) {

                                    context.invoke('insertImage', lfmItem.url);
                                });
                            });

                        }
                    });
                    return button.render();
                };

                $('#summernote').summernote({
                    height: "200px",
                    placeholder: "Write your blog here. You can insert text, image, video, hyperlink here",
                    fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather', 'Times New Roman'],
                    dialogsInBody: true,
                    buttons: {
                        lfm: LFMButton
                    },
                    lineHeights: ['0.2', '0.3', '0.4', '0.5', '0.6', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
                    toolbar: [
                        ['popovers', ['lfm']],
                        ['style', ['style']],
                        ['fontsize', ['fontsize']],
                        ['para', ['ul', 'ol', 'paragraph', 'h1']],
                        ['style', ['bold', 'italic', 'underline', 'clear']],
                        ['font', ['strikethrough', 'superscript', 'subscript']],
                        ['color', ['color']],
                        ['height', ['height']],
                        ['insert', ['link', 'video', 'table', 'hr']],
                        ['misc', ['fullscreen', 'codeview', 'undo', 'redo']],
                        ['view', ['help']]

                    ],
                    spellCheck: true,
                    popover: {
                        air: [
                            ['color', ['color']],
                            ['font', ['bold', 'underline', 'clear']]
                        ]
                    }
                });

                //post form submit
                $("#postFormSubmit").submit(function (e) {
                    e.preventDefault(); // avoid to execute the actual submit of the form.

                    const form = $(this);
                    const url = form.attr('action');
                    let formData = new FormData(this);


                    $('.btn-save').text('Saving');
                    $.ajax({
                        type: "POST",
                        url: url,
                        contentType: false,
                        processData: false,
                        data: formData, // serializes the form's elements.
                        success: function (data, textStatus, xhr) {

                            if (xhr.status === 200) {
                                toastr.success('Data updated successfully');
                                setTimeout(function () {
                                    window.location.href = '{{ route('admin.post.index') }}';
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
            });
        </script>
    @endpush
@endsection
