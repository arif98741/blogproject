@extends('back.layout.layout')
@section('title','Category List')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                    class="ti-home"></i>&nbsp;Home</a>
                        </li>
                        <li class="breadcrumb-item active">Category List</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('admin.category.create') }}" class="btn btn-primary btn-sm float-sm-right">Add New</a>
                </div>
            </div>
        </div>
    </section>


    <div class="container-fluid">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Category List</h4>

                    <div class="table-responsive pt-3">
                        <table class="table table-bordered mb-4">
                            <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Image</th>
                                <th>Created at</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($categories as $key=> $category)

                                @php
                                    $key = ++$key;
                                @endphp

                                <tr>

                                    <td>{{ $category->category_name }}
                                    </td>
                                    <td><img src="{{ asset($category->imgpath) }}" alt=""></td>
                                    <td>{{ \Carbon\Carbon::make($category->created_at)->format('h:iA, Y-m-d') }}</td>
                                    <td class="text-center"><span class="badge badge-success">Approved</span></td>
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
                                                   href="{{ route('admin.category.edit', $category->id) }}">Edit</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                                @if(property_exists($category,'childs'))


                                    @foreach($category->childs as $childCatKey => $childCat)

                                        @php

                                            $childCatKey = ++$childCatKey;
                                            $childCatKey += $key;
                                        @endphp
                                        <tr>

                                            <td>{{ $category->category_name }}/{{ $childCat->category_name }}</td>
                                            <td><img src="{{ asset($childCat->imgpath) }}" alt=""></td>
                                            <td>{{ \Carbon\Carbon::make($childCat->created_at)->format('h:iA, Y-m-d') }}</td>
                                            <td class="text-center"><span
                                                    class="badge badge-success">Active</span>
                                            </td>
                                            <td class="text-center">
                                                <div class="dropdown custom-dropdown">
                                                    <a class="dropdown-toggle" href="#" role="button"
                                                       id="dropdownMenuLink1"
                                                       data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                             height="24"
                                                             viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                             stroke-width="2" stroke-linecap="round"
                                                             stroke-linejoin="round"
                                                             class="feather feather-more-horizontal">
                                                            <circle cx="12" cy="12" r="1"></circle>
                                                            <circle cx="19" cy="12" r="1"></circle>
                                                            <circle cx="5" cy="12" r="1"></circle>
                                                        </svg>
                                                    </a>

                                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink1">
                                                        <a class="dropdown-item"
                                                           href="{{ route('admin.category.edit', $childCat->id) }}">Edit</a>
                                                        <a class="dropdown-item"
                                                           href="javascript:void(0);">Delete</a>
                                                    </div>
                                                </div>

                                            </td>
                                        </tr>

                                        @if(property_exists($childCat,'childs'))

                                            @foreach($childCat->childs as $secondChildKey => $secondChild)

                                                @php

                                                    $secondChildKey = ++$secondChildKey;
                                                    $secondChildKey += $childCatKey;
                                                    $key = $secondChildKey;
                                                @endphp
                                                <tr>

                                                    <td>{{ $category->category_name }}
                                                        /{{ $childCat->category_name }}
                                                        /{{ $secondChild->category_name }}</td>
                                                    <td><img src="{{ asset($secondChild->imgpath) }}" alt=""></td>
                                                    <td>{{ \Carbon\Carbon::make($secondChild->created_at)->format('h:iA, Y-m-d') }}</td>
                                                    <td class="text-center"><span
                                                            class="badge badge-success">Active</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="dropdown custom-dropdown">
                                                            <a class="dropdown-toggle" href="#" role="button"
                                                               id="dropdownMenuLink1"
                                                               data-toggle="dropdown" aria-haspopup="true"
                                                               aria-expanded="false">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="24"
                                                                     height="24"
                                                                     viewBox="0 0 24 24" fill="none"
                                                                     stroke="currentColor"
                                                                     stroke-width="2" stroke-linecap="round"
                                                                     stroke-linejoin="round"
                                                                     class="feather feather-more-horizontal">
                                                                    <circle cx="12" cy="12" r="1"></circle>
                                                                    <circle cx="19" cy="12" r="1"></circle>
                                                                    <circle cx="5" cy="12" r="1"></circle>
                                                                </svg>
                                                            </a>

                                                            <div class="dropdown-menu"
                                                                 aria-labelledby="dropdownMenuLink1">
                                                                <a class="dropdown-item"
                                                                   href="{{ route('admin.category.edit', $secondChild->id) }}">Edit</a>
                                                                <a class="dropdown-item"
                                                                   href="javascript:void(0);">Delete</a>
                                                            </div>
                                                        </div>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                            </tbody>
                        </table>
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
