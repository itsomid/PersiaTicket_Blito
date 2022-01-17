@include('panel.layouts.header')
@include('panel.layouts.menu')

<div id="page-wrapper" class="gray-bg" >
    @include('panel.layouts.search-navbar')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-10">
            <h2>نمایش های در حال انتظار</h2>
        </div>
        <div class="col-lg-2">
            <a href="#"  class="btn btn-primary" style="float: left;margin-bottom: 20px;"></a>
        </div>

        <div class="col-lg-12">
            <table class="footable table table-stripped toggle-arrow-tiny">
                <thead>
                <tr>
                    <th>کد نمایش</th>
                    <th>نام برنامه</th>
                    <th>تاریخ شروع</th>
                    <th>تاریخ پایان</th>
                    <th>شهر سالن</th>
                    <th>تهیه کننده</th>
                    <th>تعداد سانس‌ها</th>
                    <th>وضعیت</th>
                    <th>مشاهده</th>
                </tr>
                </thead>
                <tbody>

                @foreach($shows as $show)
                    <tr>
                        <td>{{ $show->uid }}</td>
                        <td>{{ $show->title }}</td>
                        <td>{{ \SeebBlade::prettyDateWithFormat($show->from_date ,'y/M/d')}}</td>
                        <td>{{ \SeebBlade::prettyDateWithFormat($show->to_date ,'y/M/d')}}</td>
                        <td>{{ $show->scene->name }} - {{ $show->city->name }}</td>
                        <td>{{$show->admin->fullName()}}</td>
                        <td>{{$show->allShowtimes()->count() }}</td>
                        <td><a href="{{ route('shows/show',['uid' => $show->uid]) }}" class="btn btn-sm btn-circle" > نمایش</a> </td>
                        <td><a href="{{route('shows/approve',['uid'=> $show->uid])}}" target="_blank" class="btn btn-sm btn-primary" > تایید</a> </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



    </div>

</div>
@include('panel.layouts.footer')
