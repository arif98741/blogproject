@extends('back.layout.layout')
@section('title','Post List')
@section('content')
    <div class="content-header">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                            class="fa fa-home"></i>&nbsp;Home</a>
                </li>
                <li class="breadcrumb-item active">Post</li>
            </ol>
        </nav>

    </div>

    <div class="container-fluid">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Post</h4>

                    <div class="table-responsive pt-3">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th> Post Name</th>
                                <th>Image</th>
                                <th>Author</th>
                                <th>Description</th>
                                <th>Category</th>
                                <th>Tags</th>
                                <th>Status</th>
                                <th>Created_at</th>
                                <th>Deleted</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($posts as $key=> $post)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>{{ $post->title }}</td>
                                    <td><img style="height: 100px; width: 100px;"
                                             src="{{ asset($post->thumbnail_image) }}" alt=""></td>

                                    <td>{{ $post->user->name }}</td>
                                    <td>{{ $post->meta_title }}  </td>
                                    <td>

                                        @foreach($post->categories as $key=>$category)
                                            <label for="" class="badge badge-info" style="min-width: 50px"><i
                                                    class="fas fa-folder"></i>&nbsp;{{ $category->category_name }}
                                            </label>
                                            @if($key%2==1)
                                                <br>
                                            @endif
                                            &nbsp;
                                        @endforeach
                                    </td>
                                    <td>

                                        @foreach($post->tags as $key=>$tag)
                                            <label for="" class="badge badge-info" style="min-width: 50px"><i
                                                    class="fas fa-tag"></i>&nbsp;{{ $tag->tag_name }}</label>&nbsp;
                                            @if($key%2==1)
                                                <br>
                                            @endif
                                            &nbsp;
                                        @endforeach
                                    </td>

                                    <td>
                                        @if($post->status =='published')
                                            @php $postStatus = 'success'; @endphp
                                        @elseif($post->status =='pending')
                                            @php $postStatus = 'warning'; @endphp
                                        @elseif($post->status =='draft')
                                            @php $postStatus = 'dark'; @endphp
                                        @elseif($post->status =='deleted')
                                            @php $postStatus = 'danger'; @endphp

                                        @elseif($post->status =='need_modification')
                                            @php $postStatus = 'info'; @endphp
                                        @else
                                            @php $postStatus = 'info'; @endphp
                                        @endif
                                        <label for="" class="badge badge-{{ $postStatus }}"> {{ $post->status }}</label>&nbsp;
                                    </td>
                                    <td>
                                        {{ date('d-m-Y',strtotime( $post->created_at )) }}
                                    </td>
                                    <td>
                                        @if($post->deleted_at !=null)
                                            <span class="text-green text-center d-block m-0"><i class="fa fa-check"></i></span>
                                            <br>
                                            <span
                                                class="m-0">  {{ date('d-m-Y',strtotime( $post->deleted_at )) }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($post->deleted_at == null)
                                            <a href="{{ route('admin.post.edit',$post->id) }}"
                                               class="btn-sm btn btn-primary"><i class="fa fa-pencil-alt"></i></a>

                                            <form style="display: inline-block" class=""
                                                  action="{{ route('admin.post.destroy',$post->id) }}"
                                                  method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button onclick="return(confirm('are you sure to delete? after delete this will gone to trash and you can restore it again'))"
                                                        class="btn btn-danger btn-sm" type="submit"><i
                                                        class="fa fa-trash-alt"></i></button>
                                            </form>
                                        @else

                                            <a class="btn btn-sm btn-info"
                                               href="{{ route('admin.post.restore',$post->id) }}"><i
                                                    class="fa fa-undo"></i>&nbsp;Restore</a>
                                        @endif

                                    </td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>
                        {{ $posts->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

        $('.delete-user').click(function (e) {

            e.preventDefault() // Don't post the form, unless confirmed
            if (confirm('Are you sure?')) {
                // Post the form
                $(e.target).closest('form').submit() // Post the surrounding form
            }
        });
    </script>
@endsection
