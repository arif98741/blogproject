@extends('back.layout.layout')
@section('title','Post List')
@section('content')
    <div class="content-header">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                            class="ti-home"></i>&nbsp;Home</a>
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
                                <th>Status</th>
                                <th>Created_at</th>
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
                                        <label for="" class="badge badge-success"> {{ $post->status }}</label>&nbsp;
                                    </td>
                                    <td>
                                        {{ date('d-m-Y',strtotime( $post->created_at )) }}
                                    </td>
                                    <td><a href="{{ route('admin.post.edit',$post->id) }}"
                                           class="btn-sm btn btn-primary"><i class="fa fa-pencil-alt"></i></a>

                                        <form style="display: inline-block" class="d-none"
                                              action="{{ route('admin.post.destroy',$post->id) }}"
                                              method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return(confirm('are you sure to delete?'))"
                                                    class="btn btn-danger btn-sm" type="submit"><i
                                                    class="fa fa-trash-alt"></i></button>
                                        </form>

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
