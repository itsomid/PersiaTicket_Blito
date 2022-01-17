@extends('landing.master')
@section('header')
    @if(!$user->first_name == "")
  حساب کاربری  | {{$user->first_name}}
        @elseif(!$user->last_name=="")
        حساب کاربری  | {{$user->last_name}}
        @else
        حساب کاربری  | {{$user->mobile}}
    @endif
@endsection
@section('content')
    <style>body {
            background: #f8f8f8;
        }

        menu {
            background: #ec6a30
        }</style>
    <div class="loading-fa">
        <div class="pop-loading" >
    <span><div class="bounce_1"></div>
    <div class="bounce_2"></div>
    <div class="bounce_3"></div></span></div>
    </div>
    <div class="user-content">
        <div class="user-menu">

            <a href="#" class="my-account-in active-m"><span class="my-account-in"></span>حساب کاربری</a>
            <a href="#" class="my-tickts-v "><span></span> بلیت های من</a>
            <a href="#" class="my_fav"><span></span>علاقه مندی های من</a>

        </div>


        <div class="user-view my_fav">
            @foreach($user->favorites as $fav)
                <a href="{{route('website/get/show',['uid'=>$fav->uid])}}" class="h-show h_fav">
                    <img src="{{$fav->thumb_url}}" class="show_bg_img">
                    <img src="{{$fav->thumb_url}}" class="show_img">
                        <div>
                            <span class="h-name">{{$fav->title}}</span>
                            <strong style="width:100%;"><i class="fa fa-pin" style="float: right;"></i>{{$fav->scene["name"]}}</strong>

                                @if($fav->from_date == $fav->to_date)
                                    <span class="h-date h-d-mytick" > {{\SeebBlade::prettyDateWithFormat($fav->from_date,'d MMM')}}</span>
                                @else
                                    <span class="h-date h-d-mytick"> {{\SeebBlade::prettyDateWithFormat($fav->from_date,'d MMM')}} تا {{\SeebBlade::prettyDateWithFormat($fav->to_date,'d MMM ')}}</span>
                                @endif
                                    <span href="#" class="btn btn-persia tick_show_buy" style="text-align: center">خرید بلیط</span>


                        </div>

                </a>


            @endforeach
            @if(count($user->favorites) == 0)
                <div class="noalert">

                    <img src="/website/img/no/noFav.png" class="alert_img fav-al" >
                    <span>علاقه مندی جهت نمایش وجود ندارد </span>
                </div>
            @endif
        </div>


        <div class="user-view my-tickts-v">
            <div class="mytickets">

                @foreach($orders as $order)
                    @if($order->status == "approved")
                        <div class="h-show my_tickets_o">

                            <img src="{{$order->show->thumb_url}}" class="show_bg_img">
                            <img src="{{$order->show->thumb_url}}" class="show_img">
                            <div>

                                <span class="h-name">{{$order->tickets[0]->showtime->show->title}}</span>
                                <strong><i class="fa fa-pin" style="float: right"></i>{{$order->tickets[0]->showtime->show->scene["name"]}}</strong>


                                <div class="my-tick-dt my_ticket_once">
                                    <a href="{{ route('website/order/pdf',['uid'=>$order->uid]) }}" class="h-date">دانلود بلیط</a>
                                    <div><span>بلیت</span>{{count($order->tickets)}}  </div>
                                    <div> <span>تومان</span>{{$order->price}}</div>
                                    <div>{{\SeebBlade::prettyDateWithFormat($order->created_at,'d MMM F Y')}}</div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                @if(count($orders) == 0)
                        <div class="noalert">

                            <img src="/website/img/no/no-ticket.png" class="alert_img" >
                            <span>بلیتی جهت نمایش وجود ندارد </span>
                        </div>
                    @endif
            </div>
        </div>


        <div class="user-view my-account-in">
            @if(session()->has('message'))
                <span class="alert_res">اطلاعات شما با موفقیت بروز رسانی شد.</span>
            @elseif(session()->has('error'))
                <span class="alert_resw">{{session()->get('error')}}</span>
            @endif
            <div class="user-account">
                <form enctype="multipart/form-data" action="{{route('website/profile/update')}}" method="POST">
                    @if(is_null($user->avatar_url))
                        <img src="/website/img/login.png" />
                    @else
                        <img src="{{asset($user->avatar_url) }}" />
                    @endif
                    {{ csrf_field() }}
                    <div><input type="file" name="avatar"><span>عکس پروفایل</span></div>
                    <div><input type="text" value="{{isset($user)? $user->mobile : old('mobile')}}" name="mobile"><span>شماره تلفن</span></div>
                    <div><input type="text" value="{{$user->first_name}}" name="first_name"><span>نام</span></div>
                    <div><input type="text" value="{{$user->last_name}}" name="last_name"><span>نام خانوادگی</span></div>
                    <div><input type="text" value="{{$user->email}}" name="email"><span>ایمیل</span></div>
                    <button type="submit" class="btn-persia save-useer-info">ذخیره</button>
                </form>
            </div>
        </div>

    </div>
@stop