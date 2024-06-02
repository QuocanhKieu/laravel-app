<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{asset('admins/index3.html')}}" class="brand-link">
        <img src="{{asset('admins/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('admins/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ Auth::user()->name ?? 'Guest' }}
                </a>
            </div>
        </div>
        @guest
            <!-- Show login button -->
            <a href="{{ route('login') }}" class="btn btn-primary loginButton">Login</a>
        @else
            <!-- Show logout button -->
            <form action="{{ route('logout') }}" method="post">
                @csrf
                <button type="submit" onclick="return confirm('Are you sure you want to logout?')" class="btn btn-primary logoutButton">Logout</button>
            </form>

        @endguest


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->
{{--                <li class="nav-item has-treeview menu-open">--}}
{{--                    <a href="#" class="nav-link active">--}}
{{--                        <i class="nav-icon fas fa-tachometer-alt"></i>--}}
{{--                        <p>--}}
{{--                            Starter Pages--}}
{{--                            <i class="right fas fa-angle-left"></i>--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                    <ul class="nav nav-treeview">--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="#" class="nav-link active">--}}
{{--                                <i class="far fa-circle nav-icon"></i>--}}
{{--                                <p>Active Page</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                        <li class="nav-item">--}}
{{--                            <a href="#" class="nav-link">--}}
{{--                                <i class="far fa-circle nav-icon"></i>--}}
{{--                                <p>Inactive Page</p>--}}
{{--                            </a>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </li>--}}
                <li class="nav-item">
                    <a href="{{route('categories')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Danh Mục Sản Phẩm
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('brands')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                             Brands
                        </p>
                    </a>
                </li>
{{--                <li class="nav-item">--}}
{{--                    <a href="{{route('menus')}}" class="nav-link">--}}
{{--                        <i class="nav-icon fas fa-th"></i>--}}
{{--                        <p>--}}
{{--                             Menus--}}
{{--                        </p>--}}
{{--                    </a>--}}
{{--                </li>--}}
                <li class="nav-item">
                    <a href="{{route('products')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                             Sản Phẩm
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('orders')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                             Đơn Hàng
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('products')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                             Đánh Giá
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('products')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                             Người Dùng
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('products')}}" class="nav-link">
                        <i class="nav-icon fas fa-th"></i>
                        <p>
                            Mã Giảm Giá
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
