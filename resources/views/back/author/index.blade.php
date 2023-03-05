@extends('back.layout.layout')
@section('title','Author List')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-left">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}"><i
                                    class="fa fa-home"></i>&nbsp;Home</a>
                        </li>
                        <li class="breadcrumb-item active">Author List</li>
                    </ol>
                </div>
                <div class="col-sm-6">
                    <a href="{{ route('admin.category.create') }}" class="btn btn-primary btn-sm float-sm-right">Add
                        New</a>
                </div>
            </div>
        </div>
    </section>


    <div class="container-fluid">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Author List</h4>

                    {{--                    tree structure start--}}
                    <style>
                        ul, li {
                            list-style: none;
                            margin: 0;
                            padding: 0;
                        }

                        ul.treeRoot > li ul,
                        ul.treeRoot > li ul {
                            padding-left: 20px;
                        }

                        ul.treeRoot li {
                            border-left: 1px solid #000;
                        }

                        ul.treeRoot ul li,
                        ul.treeRoot li {
                            border-left: 1px solid #000;
                            padding-left: 20px;
                            position: relative;
                            font-size: 16px;
                            line-height: 24px;
                        }

                        ul.treeRoot ul li:last-child:after,
                        ul.treeRoot li:last-child:after {
                            position: absolute;
                            content: "";
                            display: inline-block;
                            top: 12px;
                            width: 1px;
                            left: -1px;
                            bottom: 0;
                            background: #fff
                        }

                        ul.treeRoot ul li:before,
                        ul.treeRoot li:before {
                            height: 1px;
                            background: #000;
                            width: 15px;
                            left: 0;
                            top: 11px;
                            display: inline-block;
                            content: "";
                            position: absolute;
                        }

                        .treeRoot li ul {
                            display: none;
                        }

                        .treeRoot li ul.activeSubMenu {
                            display: block;
                        }
                    </style>

                    <ul class="treeRoot d-none">
                        <li class="hasSubMenu"><span>Root</span>
                            <ul class="activeSubMenu">
                                <li class="hasSubMenu"><span><i class="fa fa-folder"></i>&nbsp;Branch1</span>
                                    <ul>
                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch1-sub2</span></li>
                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch1-sub3</span></li>
                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch1-sub4</span></li>
                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch1-sub5</span></li>
                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch1-sub6</span></li>
                                    </ul>
                                </li>
                                <li><span><i class="fa fa-folder"></i>&nbsp;Branch2</span></li>
                                <li class="hasSubMenu"><span><i class="fa fa-folder"></i>&nbsp;Branch3</span>
                                    <ul>
                                        <li><span><i class="fa fa-folder"></i>Branch3-sub1</span></li>
                                        <li class="hasSubMenu"><span><i class="fa fa-folder"></i>Branch3-sub2</span>
                                            <ul>
                                                <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub1</span></li>
                                                <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub2</span></li>
                                                <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub3</span></li>
                                                <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub4</span></li>
                                                <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub5</span></li>
                                                <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub6</span></li>
                                                <li class="hasSubMenu"><span><i class="fa fa-folder"></i>&nbsp;Branch Demo</span>
                                                    <ul>
                                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub1</span>
                                                        </li>
                                                        <li class="hasSubMenu"><span><i class="fa fa-folder"></i>Branch3-sub2</span>
                                                            <ul>
                                                                <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub1</span>
                                                                </li>
                                                                <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub2</span>
                                                                </li>
                                                                <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub3</span>
                                                                </li>
                                                                <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub4</span>
                                                                </li>
                                                                <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub5</span>
                                                                </li>
                                                                <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub6</span>
                                                                </li>
                                                            </ul>
                                                        </li>
                                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub3</span>
                                                        </li>
                                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub4</span>
                                                        </li>
                                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub5</span>
                                                        </li>
                                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub6</span>
                                                        </li>
                                                    </ul>
                                                </li>
                                            </ul>
                                        </li>
                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub3</span></li>
                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub4</span></li>
                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub5</span></li>
                                        <li><span><i class="fa fa-folder"></i>&nbsp;Branch3-sub6</span></li>
                                    </ul>
                                </li>
                            </ul>

                        </li>
                    </ul>
                    {{--tree structure end--}}

                    <div class="table-responsive pt-3 ">
                        <table class="table table-bordered mb-4">
                            <thead>
                            <tr>
                                <th>Author Name</th>
                                <th>Image</th>
                                <th>Created at</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Action</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($categories as $key=> $category)

                                @if($key == 0)
                                    @php continue; @endphp
                                @endif

                                @php
                                    $key = ++$key;
                                @endphp

                                <tr>

                                    <td><strong>{{ $category->category_name }}</strong>
                                    </td>
                                    <td><img src="{{ asset($category->imgpath) }}" alt=""></td>
                                    <td>{{ \Carbon\Carbon::make($category->created_at)->format('h:iA, Y-m-d') }}</td>
                                    <td class="text-center">
                                        <span class="badge badge-success">Approved</span>
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
                                                   href="{{ route('admin.category.edit', $category->id) }}">Edit</a>
                                                <a class="dropdown-item" href="javascript:void(0);">Delete</a>
                                            </div>
                                        </div>

                                    </td>
                                </tr>

                                @if($category->count() >0)

                                    @foreach($category->childs as $childCatKey => $childCat)

                                        @php

                                            $childCatKey = ++$childCatKey;
                                            $childCatKey += $key;
                                        @endphp
                                        <tr>

                                            <td>
                                                <strong>{{ $category->category_name }}</strong>/<strong>{{ $childCat->category_name }}</strong>
                                            </td>
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


                                        @if($childCat->count() >0)

                                            @foreach($childCat->childs as $secondChildKey => $secondChild)

                                                @php

                                                    $secondChildKey = ++$secondChildKey;
                                                    $secondChildKey += $childCatKey;
                                                    $key = $secondChildKey;
                                                @endphp
                                                <tr>

                                                    <td><strong>{{ $category->category_name }}</strong>
                                                        /<strong>{{ $childCat->category_name }}</strong>
                                                        /<strong>{{ $secondChild->category_name }}</strong></td>
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
    @push('extra-script')
        <script>
            $("ul.treeRoot li span").on("click", function () {
                if ($(this).parent().hasClass("hasSubMenu")) {
                    if ($(this).parent().find("ul").hasClass("activeSubMenu")) {
                        $(this).parent().find("ul").removeClass("activeSubMenu");
                        $(this).parent().find("ul li span i").removeClass("fa-folder");
                        $(this).find("i").removeClass("fa-folder");
                    } else {
                        $(this).parent().find("ul").addClass("activeSubMenu");
                        $(this).parent().find("ul li span i").addClass("fa-folder-open");
                        $(this).find("i").addClass("fa-folder-open");
                    }
                }
            });
        </script>
    @endpush
@endsection
