@include('panel.layouts.header')
@include('panel.layouts.menu')

<div id="page-wrapper" class="gray-bg">

    @include('panel.layouts.search-navbar')

    <div class="wrapper wrapper-content animated fadeInRight">
        @include('panel.usereditmodal',['id' => null])
        <div class="col-lg-10">
            <h2>کاربران</h2>
        </div>
        <div class="col-lg-2">
            <a href="#" id="popup-open-btn" class="user-create btn btn-primary show-popup" style="float: left;margin-bottom: 20px;">کاربر جدید</a>

        </div>
        <table class="footable table table-stripped toggle-arrow-tiny">
            <thead>
            <tr>
                <th>کد کاربری</th>
                <th>نام و نام خانوادگی</th>
                <th>تاریخ ثبت نام</th>
                <th>ایمیل</th>
                <th>تعداد بلیت</th>
                <th>موبایل</th>
                <th>سطح دسترسی</th>
                <th>ویرایش</th>


            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{$user->id}}</td>
                    <td>{{$user->first_name}} {{$user->last_name}}</td>
                    <td>{{ \SeebBlade::prettyDateWithFormat($user->created_at,'dd MMM yyyy') }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->tickets()->count() }}</td>
                    <td>{{ $user->mobile }}</td>
                    <td>{{ trans('access.'.$user->access_level) }}</td>
                    <td><a href="{{route('users/show', ['id' => $user->id])}}" class="btn btn-sm btn-primary" >مشاهده</a> </td>
                </tr>
            @endforeach

            </tbody>
        </table>
    </div>
</div>

@include('panel.layouts.footer')
@if(!is_null(session('error')))
    <script type="text/javascript">
        $(window).on('load',function(){
            $('#popup-open-btn').click();
        });
    </script>
@endif