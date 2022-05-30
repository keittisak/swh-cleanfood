<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-1">
<!-- Brand Logo -->
<div class="brand-link text-center text-sm">
        {{--  <img src="{{ asset('img/49035_face-2.jpg') }}" alt="User Avatar" class="brand-image img-circle elevation-3"
        style="opacity: .8">  --}}

    {{--  <span class="brand-text font-weight-light">NAVIGATION</span>  --}}
    <span class="brand-text font-weight-light">{{ strtoupper('Sweet Home Cleanfood') }}</span>
</div>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column nav-legacy nav-compact nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
        <li class="nav-item">
            <a href="{{route('dashboard')}}" class="nav-link {{ Request::is('backoffice/dashboard') ? 'active':''}}">
                <i class="nav-icon fas fa-chart-line"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{route('orders.create')}}" class="nav-link {{ Request::is('backoffice/orders/create') ? 'active':''}}">
                <i class="nav-icon fas fa-cart-plus"></i>
                <p>สร้างออเดอร์</p>
            </a>
        </li>
        <li class="nav-item has-treeview {{ Request::is('backoffice/orders') || Request::is('backoffice/orders/details') || Request::is('backoffice/orders/details/confirm') ? 'menu-open':''}}">
            <a href="{{route('orders.index')}}" class="nav-link">
                <i class="nav-icon  fas fa-clipboard-check"></i>
                <p>
                ระบบการจัดการออเดอร์
                <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item ">
                    <a href="{{route('orders.index')}}" class="nav-link {{ Request::is('backoffice/orders') ? 'active':''}}">
                        <i class="fa fa-angle-right ml-3 mr-2"></i>
                        <p>1.ตรวจสอบออเดอร์</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('orders.details.index')}}" class="nav-link {{ Request::is('backoffice/orders/details') ? 'active':''}}">
                        <i class="fa fa-angle-right ml-3 mr-2"></i>
                        <p>2.ตรวจสอบรายการอาหาร</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('orders.details.confirm')}}" class="nav-link {{ Request::is('backoffice/orders/details/confirm') ? 'active':''}}">
                        <i class="fa fa-angle-right ml-3 mr-2"></i>
                        <p>3.การจัดการอาหาร</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item has-treeview {{ Request::is('backoffice/products') || Request::is('backoffice/products/*') || Request::is('backoffice/courses') ||  Request::is('backoffice/courses/*')    ? 'menu-open':''}}">
            <a href="{{route('orders.index')}}" class="nav-link">
                <i class="nav-icon fas fa-fish"></i>
                <p>
                ระบบการจัดการสินค้า
                <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item ">
                    <a href="{{route('products.index')}}" class="nav-link {{ Request::is('backoffice/products') ? 'active':''}}">
                        <i class="fa fa-angle-right ml-3 mr-2"></i>
                        <p>สินค้า</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('products.menu.index')}}" class="nav-link {{ Request::is('backoffice/products/menu') ? 'active':''}}">
                        <i class="fa fa-angle-right ml-3 mr-2"></i>
                        <p>เมนูอาหาร</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('courses.index')}}" class="nav-link {{ Request::is('backoffice/courses') ? 'active':''}}">
                        <i class="fa fa-angle-right ml-3 mr-2"></i>
                        <p>คอร์สอาหาร</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{route('orders.history')}}" class="nav-link {{ Request::is('backoffice/orders/history') ? 'active':''}}">
                <i class="nav-icon fas fa-history"></i>
                <p>ประวัติการสั่งซื้อ</p>
            </a>
        </li>
        <li class="nav-item has-treeview {{ Request::is('backoffice/reports/*')?'menu-open':'' }}">
            <a href="{{route('orders.index')}}" class="nav-link">
                <i class="nav-icon far fa-file-alt"></i>
                <p>
                รายงาน
                <i class="right fa fa-angle-left"></i>
                </p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item ">
                    <a href="{{route('reports.sales')}}" class="nav-link {{ Request::is('backoffice/reports/sales') ? 'active':''}}">
                        <i class="fa fa-angle-right ml-3 mr-2"></i>
                        <p>รายงานการขาย</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('reports.products')}}" class="nav-link {{ Request::is('backoffice/reports/products') ? 'active':''}}">
                        <i class="fa fa-angle-right ml-3 mr-2"></i>
                        <p>รายงานการขายอาหาร</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('reports.end-course.data')}}" class="nav-link {{ Request::is('backoffice/reports/end-course') ? 'active':''}}">
                        <i class="fa fa-angle-right ml-3 mr-2"></i>
                        <p>รายงานวันครบกำหนดคอร์ส</p>
                    </a>
                </li>
            </ul>
        </li>
        <li class="nav-item">
            <a href="{{route('users.index')}}" class="nav-link {{ Request::is('backoffice/users') ? 'active':''}}">
                <i class="nav-icon fas fa-users-cog"></i>
                <p>ผู้ใช้งาน</p>
            </a>
        </li>
    </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
</aside>