@extends('back.layout.layout')
@section('title',$title)
@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                    class="ti-home"></i>&nbsp;Home</a>
                        </li>
                        <li class="breadcrumb-item "><a href="{{ route('admin.post.index') }}">Posts</a></li>
                        <li class="breadcrumb-item active">{{ $title }}</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('admin.post.index') }}" class="btn btn-primary btn-sm float-sm-right">Back to
                        Posts</a>
                </div>
            </div>
        </div>
    </section>
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form id="postFormSubmit" class="forms-sample" action="{{ route('admin.post.store') }}"
                      enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('post')

                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Title</label>
                                        <input name="title" type="text" id="title" class="form-control"
                                               value="{{ old('title') }}"
                                               placeholder="Title">
                                        @if ($errors->has('title'))
                                            <span class="help-block">
                                            <p class="text-red">{{ $errors->first('title') }}</p> </span>
                                        @endif
                                    </div>

                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Slug</label>
                                        <input name="slug" type="text" id="slug" class="form-control"
                                               value="{{ old('slug') }}"
                                               placeholder="slug">
                                        @if ($errors->has('slug'))
                                            <span class="help-block">
                                            <p class="text-red">{{ $errors->first('slug') }}</p> </span>
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
                                                  placeholder="Enter text here">{{ old('description') }}</textarea>
                                        @if ($errors->has('text'))
                                            <span class="help-block">
                                            <p
                                                class="text-red">{{ $errors->first('text') }}</p> </span>
                                        @endif
                                    </div>
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleInputUsername1">Meta Title</label>
                                        <input type="text" name="meta_title" id="meta_title"
                                               value="{{ old('meta_title') }}" class="form-control">
                                        @if ($errors->has('meta_title'))
                                            <span class="help-block">
                                            <p class="text-red">{{ $errors->first('meta_title') }}</p> </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="">Meta Keywords</label>
                                        <input name="meta_keywords" value="{{ old('meta_keywords') }}"
                                               id="meta_keywords" cols="30" rows="2"
                                               class="form-control">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="">Meta Description</label>
                                        <textarea name="meta_description" id="meta_description" cols="30" rows="2"
                                                  class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">

                            <div class="form-group">
                                <label>Categories</label>
                                <ul>
                                    @foreach($categories as $key1=> $category)
                                        <li>
                                            <div class="form-group">
                                                <input type="checkbox" value="{{ $category[0]->id }}"
                                                       name="categories_id[]"
                                                       class="form-check-input" id="exampleCheck1">
                                                <label class="form-check-label"
                                                       for="exampleCheck1">{{ $category[0]->category_name }}</label>
                                            </div>
                                        </li>

                                        @if(property_exists($category[0],'childs'))

                                            <ul>
                                                @foreach($category[0]->childs as $key2=> $secondChild)
                                                    <li>
                                                        <div class="form-group">
                                                            <input type="checkbox" value="{{ $secondChild->id }}"
                                                                   name="categories_id[]"
                                                                   class="form-check-input" id="exampleCheck1">
                                                            <label class="form-check-label"
                                                                   for="exampleCheck1">{{ $secondChild->category_name }}</label>
                                                        </div>
                                                    </li>



                                                    @if(property_exists($secondChild,'childs'))

                                                        <ul>
                                                            @foreach($secondChild->childs as $key2=> $thirdChild)
                                                                <li>
                                                                    <div class="form-group">
                                                                        <input type="checkbox"
                                                                               value="{{ $thirdChild->id }}"
                                                                               name="categories_id[]"
                                                                               class="form-check-input"
                                                                               id="exampleCheck1">
                                                                        <label class="form-check-label"
                                                                               for="exampleCheck1">{{ $thirdChild->category_name }}</label>
                                                                    </div>
                                                                </li>


                                                                @if(property_exists($thirdChild,'childs'))

                                                                    <ul>
                                                                        @foreach($thirdChild->childs as $key3=> $fourthChild)
                                                                            <li>
                                                                                <div class="form-group">
                                                                                    <input type="checkbox"
                                                                                           value="{{ $fourthChild->id }}"
                                                                                           name="categories_id[]"
                                                                                           class="form-check-input"
                                                                                           id="exampleCheck1">
                                                                                    <label class="form-check-label"
                                                                                           for="exampleCheck1">{{ $fourthChild->category_name }}</label>
                                                                                </div>
                                                                            </li>

                                                                        @endforeach
                                                                    </ul>

                                                                @endif

                                                            @endforeach
                                                        </ul>

                                                    @endif

                                                @endforeach
                                            </ul>

                                        @endif
                                    @endforeach
                                </ul>

                                @if ($errors->has('status'))
                                    <span class="help-block">
                                            <p class="text-red">{{ $errors->first('status') }}</p> </span>
                                @endif
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>Tags</label>
                                        <select name="tags[]" class="form-control" id="tags" multiple>
                                            @foreach($tags as $key=> $tag)
                                                <option value="{{ $tag->id }}">{{ $tag->tag_name }}</option>
                                            @endforeach
                                        </select>
                                        @if ($errors->has('tag'))
                                            <span class="help-block">
                                            <p class="text-red">{{ $errors->first('tag') }}</p> </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Author</label>

                                        <select class="form-control" readonly="">

                                            <option
                                                value="#"> {{ \Illuminate\Support\Facades\Auth::user()->name }}</option>


                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>


                    <button type="submit" class="btn btn-success btn-save mr-2">Save</button>
                    <a href="{{ route('admin.post.index') }}" class="btn btn-info">Back</a>
                </form>

            </div>
        </div>

    </div>

    @push('extra-css')
        <link rel="stylesheet" href="{{ asset('assets/back/plugins/summernote/summernote.min.css')}}">
        <link rel="stylesheet" href="{{ asset('assets/back/plugins/select2/css/select2.min.css')}}">
        <style>
            ul {
                list-style: none;
            }

            ul li {
                list-style: none;
            }

            .form-group {
                margin-bottom: 5px;
            }

            .select2-container--default .select2-selection--multiple .select2-selection__choice {
                background-color: #007bff;

            }
        </style>
    @endpush
    @push('extra-script')

        <script src="{{ asset('assets/back/plugins/summernote/summernote-bs4.min.js')}}"></script>
        <script src="{{ asset('assets/back/plugins/select2/js/select2.full.min.js')}}"></script>
        <script>
            $(document).ready(function () {

                $('#tags').select2();
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
                    //    e.preventDefault(); // avoid to execute the actual submit of the form.

                    const form = $(this);
                    const url = form.attr('action');
                    let formData = new FormData(this);


                    $('.btn-save').text('Saving');
                    /* $.ajax({
                         type: "POST",
                         url: url,
                         contentType: false,
                         processData: false,
                         data: formData, // serializes the form's elements.
                         success: function (data, textStatus, xhr) {

                             if (xhr.status === 200) {
                                 form.find('input').each(function (e, data) {
                                     $('#title').val('');
                                     $('#meta_title').val('');
                                     $('#meta_description').val('');
                                     $('#meta_keywords').val('');

                                     $('#summernote').summernote('reset');
                                 });
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
                     });*/
                });


                $('#title').keyup(function () {
                    let text = $(this).val();
                    text = text.toLowerCase()
                        .replace(/ /g,'-')
                        .replace(/[-]+/g, '-')
                        .replace(/[^\w-]+/g,'');
                    $("#slug").val(text);
                });

            });
        </script>
    @endpush
@endsection
