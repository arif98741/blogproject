<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <img src="#" alt=""
             class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">@lang('Blog')</span>
        <br>
        <span style="font-size: 14px;">Ariful Islam(administrator)</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                @php

                    $dashboardRoutes = [
                      'admin.dashboard',
                    ];

                @endphp

                <li class="nav-item @if(route_exist_in_sidebar($dashboardRoutes)) menu-is-opening menu-open @else @endif">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link ">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            @lang('Dashboard')

                        </p>
                    </a>
                </li>
                @php

                    $postRoutes = [
                      'admin.media.create',
                      'admin.media.edit',
                      'admin.media.index',
                    ];

                @endphp
                <li class="nav-item @if(route_exist_in_sidebar($postRoutes)) menu-is-opening menu-open @else @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-images"></i>
                        <p>
                            @lang('Media')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview"
                        @if(route_exist_in_sidebar($postRoutes)) style="display: block" @else @endif>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-plus nav-icon"></i>
                                <p>@lang('Add Media')</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-plus nav-icon"></i>
                                <p>@lang('Media List')</p>

                            </a>
                        </li>
                    </ul>
                </li>
                @php

                    $postRoutes = [
                      'admin.post.create',
                      'admin.post.edit',
                      'admin.post.index',
                    ];

                @endphp
                <li class="nav-item @if(route_exist_in_sidebar($postRoutes)) menu-is-opening menu-open @else @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-pen"></i>
                        <p>
                            @lang('Post')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview"
                        @if(route_exist_in_sidebar($postRoutes)) style="display: block" @else @endif>
                        <li class="nav-item">
                            <a href="{{ route('admin.post.create') }}" class="nav-link">
                                <i class="far fa-plus nav-icon"></i>
                                <p>@lang('Add Post')</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.post.index') }}" class="nav-link">
                                <i class="far fa-plus nav-icon"></i>
                                <p>@lang('Post List')</p>

                            </a>
                        </li>
                    </ul>
                </li>


                @php

                    $categoryRoutes = [
                      'admin.category.create',
                      'admin.category.edit',
                      'admin.category.index',
                    ];

                @endphp
                <li class="nav-item @if(route_exist_in_sidebar($categoryRoutes)) menu-is-opening menu-open @else @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            @lang('Categories')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" @if(route_exist_in_sidebar($categoryRoutes)) style="display: block" @else @endif>
                        <li class="nav-item">
                            <a href="{{ route('admin.category.create') }}" class="nav-link">
                                <i class="far fa-plus nav-icon"></i>
                                <p>@lang('Add Categories')</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.category.index') }}" class="nav-link">
                                <i class="far fa-plus nav-icon"></i>
                                <p>@lang('Category List')</p>

                            </a>
                        </li>
                    </ul>
                </li>
                @php

                    $tagRoutes = [
                      'admin.tag.create',
                      'admin.tag.edit',
                      'admin.tag.index',
                    ];

                @endphp
                <li class="nav-item @if(route_exist_in_sidebar($tagRoutes)) menu-is-opening menu-open @else @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tags"></i>
                        <p>
                            @lang('Tag')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" @if(route_exist_in_sidebar($tagRoutes)) style="display: block" @else @endif>
                        <li class="nav-item">
                            <a href="{{ route('admin.tag.create') }}" class="nav-link">
                                <i class="far fa-plus nav-icon"></i>
                                <p>@lang('Add Tag')</p>

                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.tag.index') }}" class="nav-link">
                                <i class="far fa-plus nav-icon"></i>
                                <p>@lang('Tag List')</p>

                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item @if(route_exist_in_sidebar([])) menu-is-opening menu-open @else @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-play"></i>
                        <p>
                            @lang('Sliders')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" @if(route_exist_in_sidebar([])) style="display: block" @else @endif>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-plus nav-icon"></i>
                                <p>@lang('Add Tag')</p>

                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item @if(route_exist_in_sidebar([])) menu-is-opening menu-open @else @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-th-list"></i>
                        <p>
                            @lang('Menu Builder')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" @if(route_exist_in_sidebar([])) style="display: block" @else @endif>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-plus nav-icon"></i>
                                <p>@lang('Add Tag')</p>

                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item @if(route_exist_in_sidebar([])) menu-is-opening menu-open @else @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-ad"></i>
                        <p>
                            @lang('Advertisement ')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" @if(route_exist_in_sidebar([])) style="display: block" @else @endif>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-plus nav-icon"></i>
                                <p>@lang('Add Tag')</p>

                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item @if(route_exist_in_sidebar([])) menu-is-opening menu-open @else @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            @lang('Authors')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" @if(route_exist_in_sidebar([])) style="display: block" @else @endif>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-plus nav-icon"></i>
                                <p>@lang('Add Tag')</p>

                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item @if(route_exist_in_sidebar([])) menu-is-opening menu-open @else @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>
                            @lang('Setting')
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview" @if(route_exist_in_sidebar([])) style="display: block" @else @endif>
                        <li class="nav-item">
                            <a href="#" class="nav-link">
                                <i class="far fa-plus nav-icon"></i>
                                <p>@lang('Add Tag')</p>

                            </a>
                        </li>

                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ url('/loggout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>
                            @lang('Logout')
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
