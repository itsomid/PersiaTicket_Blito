@include('panel.layouts.header')
@include('panel.layouts.menu')

    <div id="page-wrapper" class="gray-bg">
        @include('panel.layouts.search-navbar')
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-success pull-right">کل</span>
                            <h5>میزان کل فروش</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ number_format($total_sales) }}</h1>
                            <small>تومان</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-info pull-right">کل</span>
                            <h5>فاکتورها</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ number_format($orders_count) }}</h1>
                            <small>فاکتور</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-primary pull-right">کل</span>
                            <h5>کاربران</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ number_format($users_count) }}</h1>
                            <small>کاربر</small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <span class="label label-danger pull-right">کل</span>
                            <h5>کاربران فعال</h5>
                        </div>
                        <div class="ibox-content">
                            <h1 class="no-margins">{{ number_format($active_users_count) }}</h1>
                            <small>کاربر فعال</small>
                        </div>
                    </div>
                </div>
            </div>


<br>
            <div class="row">
                <div class="col-lg-12">
                    <div class="ibox float-e-margins">
                        <div class="ibox-title">
                            <h5>برنامه های در حال برگزاری</h5>

                        </div>
                        <div class="ibox-content">
                            <table class="table table-hover no-margins">
                                <thead>
                                <tr>
                                    <th>کد برنامه</th>
                                    <th>نام برنامه</th>
                                    <th>سانس</th>
                                    <th>بلیط فروخته شده</th>
                                    <th>فروش</th>
                                    <th>نمایش</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($showtimes as $showtime)
                                <tr>
                                    <td><small>{{$showtime->show->uid}}</small></td>
                                    <td><small>{{$showtime->show->title}}</small></td>
                                    <td>{{\SeebBlade::prettyDate($showtime->datetime)}}</td>
                                    <td>{{$showtime->tickets()->whereStatus('sold')->count()}}</td>
                                    <td class="text-navy"> {{number_format($showtime->tickets()->whereStatus('sold')->sum('price'))}} </td>
                                    <td><a href="{{ route('shows/show',['uid' => $showtime->show->uid]) }}" class="btn btn-sm btn-primary"> نمایش</a></td>
                                </tr>
                                @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">

                </div>
            </div>

        </div>

    </div>


@include('panel.layouts.footer')