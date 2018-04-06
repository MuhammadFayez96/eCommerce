<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar .right-side">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-right image">
                <img src="{{asset('storage/uploads/images/avatars/admin-avatar-default.png') }}" class="img-circle"
                     alt="User Image">
            </div>
            <div class="pull-right info">
                <a href="#"><i class="fa fa-circle text-success"></i> Muhammad Fayez</a>
            </div>
        </div>

        <ul class="sidebar-menu">
            <li class="treeview">
                <a href="{{route('admin.home')}}">
                    <i class="fa fa-dashboard"></i>
                    <span>Main Page</span>
                </a>
            </li>
            {{--<li class="treeview">--}}
            {{--<a href="#">--}}
            {{--<i class="fa fa-pie-chart"></i>--}}
            {{--<span>Settings</span>--}}
            {{--</a>--}}
            {{--</li>--}}
            <li class="treeview">
                <a href="{{route('admin.users.getIndex')}}">
                    <i class="fa fa-user"></i> <span>Users</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{route('admin.addresses.getIndex')}}">
                    <i class="fa fa-book"></i>
                    <span>Address</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{route('admin.roles.getIndex')}}">
                    <i class="fa fa-tasks"></i>
                    <span>Roles</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{route('admin.menus.getIndex')}}">
                    <i class="fa fa-bars"></i>
                    <span>Menus</span>
                </a>
            </li>
            <li class="treeview">
                <a href="{{route('admin.categories.getIndex')}}">
                    <i class="fa fa-clipboard"></i>
                    <span>Categories</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{route('admin.options.getIndex')}}">
                    <i class="fa fa-filter"></i>
                    <span>Options</span>
                </a>
            </li>


            <li class="treeview">
                <a href="{{route('admin.products.getIndex')}}">
                    <i class="fa fa-product-hunt"></i>
                    <span>Products</span>
                </a>
            </li>

            <li class="treeview">
                <a href="{{route('admin.boughts.getIndex')}}">
                    <i class="fa fa-product-hunt"></i>
                    <span>Boughts</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
