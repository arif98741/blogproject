@extends('back.layout.layout')
@section('title','Slider List')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                    class="fa fa-home"></i>&nbsp;Home</a>
                        </li>
                        <li class="breadcrumb-item active">Slider List</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('admin.slider.create') }}" class="btn btn-primary btn-sm float-sm-right">Add
                        New</a>
                </div>
            </div>
        </div>
    </section>


    <div class="container-fluid">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Slider List</h4>


                    <div class="table-responsive pt-3 ">
                        <table class="table table-bordered mb-4">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Slider Name</th>
                                <th>Image</th>
                                <th>Updated at</th>
                                <th>Created at</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($sliders as $key=> $slider)

                                <tr>
                                    <td>{{ ++$key }}</td>
                                    <td><strong>{{ $slider->title }}</strong>
                                    </td>
                                    <td><img src="{{ asset($slider->image) }}" style="width: 70px; height: 70px;"
                                             alt=""></td>
                                    <td>{{ \Carbon\Carbon::make($slider->updated_at)->format('h:iA, Y-m-d') }}</td>
                                    <td>{{ \Carbon\Carbon::make($slider->created_at)->format('h:iA, Y-m-d') }}</td>
                                    <td class="text-center">
                                        @if($slider->status == 1)
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-warning">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="dropdown custom-dropdown">
                                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink1"
                                               data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                     viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                     stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                     class="feather feather-more-horizontal">
                                                    <circle cx="12" cy="12" r="1"></circle>
                                                    <circle cx="19" cy="12" r="1"></circle>
                                                    <circle cx="5" cy="12" r="1"></circle>
                                                </svg>
                                            </a>

                                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                                <a class="dropdown-item"
                                                   href="{{ route('admin.slider.edit', $slider->id) }}">Edit</a>
                                                <form method="POST"
                                                      action="{{ route('admin.slider.destroy',$slider->id) }}">
                                                    @csrf
                                                    @method('DELETE')

                                                    <input type="submit" class="btn delete-slider"
                                                           value="Delete slider">

                                                </form>
                                            </div>
                                        </div>

                                    </td>
                                </tr>

                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>

    </script>
    @push('extra-script')

        ...
        // Mayank Pandeyz's solution for confirmation customized for this implementation
        <script>
            $('.delete-slider').click(function (e) {
                e.preventDefault() // Don't post the form, unless confirmed
                if (confirm('Are you sure to delete?')) {
                    // Post the form
                    $(e.target).closest('form').submit() // Post the surrounding form
                }
            });
        </script>
    @endpush
@endsection
