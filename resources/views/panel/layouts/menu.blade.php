<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"> {{ Request::user()->fullName() }}</strong>
                             </span> <span class="text-muted text-xs block">{{ trans('access.'.Request::user()->access_level) }}<b class="caret"></b></span> </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="{{route('panel/me')}}">پروفایل</a></li>
                        <li><a href="{{route('logout')}}">خروج</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    PT
                </div>
            </li>
            @if(Request::user()->isAdmin())
            <li class="{{ SeebBlade::isActive(false,route('dashboard'), 'active','') }}">
                <a href="{{ route('dashboard') }}"><i class="fa fa-th-large"></i> <span class="nav-label">پیشخوان</span></a>
            </li>
            @endif


            <li class="{{ SeebBlade::isActive(false,route('shows/new'), 'active','') }}">
                <a href="{{ route('shows/new') }}"><i class="fa fa-plus"></i> <span class="nav-label">ساخت برنامه جدید</span> </a>
            </li>

            @if(Request::user()->isAdmin())
            <li>
                <a href="{{route('shows/pending')}}"><i class="fa fa-user-md"></i> <span class="nav-label"> در انتظار تایید</span> </a>
            </li>
            @endif

            <li class="{{ SeebBlade::isActive(false,route('shows/list'), 'active','') }}">
                <a href="#"><i class="fa fa-th-large"></i> <span class="nav-label">برنامه ها</span> </a>
                <ul class="nav nav-second-level {{ SeebBlade::isActive(false,route('shows/list'), 'collapse in','') }}">
                    <li class="{{ SeebBlade::isActive(false,route('shows/list',['cat_id' => 1]), 'active','') }}">
                        <a href="{{ route('shows/list',['cat_id' => 1]) }}"><span class="nav-label">کنسرت</span> </a>
                    </li>
                    <li class="{{ SeebBlade::isActive(false,route('shows/list',['cat_id' => 2]), 'active','') }}">
                        <a href="{{ route('shows/list',['cat_id' => 2]) }}"><span class="nav-label">تئاتر</span> </a>
                    </li>
                    <li class="{{ SeebBlade::isActive(false,route('shows/list',['cat_id' => 3]), 'active','') }}">
                        <a href="{{ route('shows/list',['cat_id' => 3]) }}"><span class="nav-label">همایش</span> </a>
                    </li>
                </ul>
            </li>

            @if(Request::user()->isAdmin())
            <li class="{{ SeebBlade::isActive(false,route('users/list'), 'active','') }}">
                <a href="{{route('users/list')}}"><i class="fa fa-users"></i> <span class="nav-label">کاربران</span> </a>
            </li>
            @endif
            <li><a href="{{route('scenes/list')}}"><i class="fa fa-user-md"></i> <span class="nav-label">سالن‌ها</span> </a></li>

            <li class="{{ SeebBlade::isActive(true,route('orders/mine'), 'active','') }}">
                <a href="{{route('orders/mine')}}"><i class="fa fa-users"></i> <span class="nav-label">بلیط های مهمان</span> </a>
            </li>

            <li class="{{ SeebBlade::isActive(true,route('orders/list'), 'active','') }}">
                <a href="{{ route('orders/list') }}"><i class="fa fa-ticket"></i> <span class="nav-label">فاکتور ها</span> </a>
            </li>
            @if(Request::user()->isAdmin())
            <li class="{{ SeebBlade::isActive(false,route('payments/list'), 'active','') }}">
                <a href="{{ route('payments/list') }}"><i class="fa fa-dollar "></i> <span class="nav-label">پرداخت‌ها</span> </a>
            </li>
            <li>
                <a href="{{route('reports/general')}}"><i class="fa fa-mail-reply"></i> <span class="nav-label">گزارش کلی</span> </a>
            </li>
            @endif
            @if(Request::user()->access_level == 10 && false)
                <li>
                <a href="#"><i class="fa fa-arrows"></i> <span class="nav-label">تنظیمات</span> </a>
            </li>
            @endif









        </ul>

    </div>
</nav>