@extends('landing.master')
@section('header')
    اطلاعات پرداخت
@endsection
@section('content')




    <style>body {
            background: #1a2d41
        }</style>

    {{--@if($order->status != 'canceled')--}}

    {{--<a href="{{ route('orders/cancel', ['id' => $order->id]) }}" target="_blank" class="btn-persia buy-btn">لغو</a>--}}
    {{--@endif--}}


    <div class="event-single">

        <img src="{{$order->show->main_image_url}}" class="bg-event">
        <div class="timeline-ev">
            <a href="{{route('website/home')}}">برنامه‌ها</a>

            <a href="{{ route('website/get/show',['uid'=>$order->show->uid]) }}">{{$order->show->title}}</a>
            <span class="ev-name">خرید بلیت</span>
        </div>


        <div class="event-info">
            <img src="{{$order->show->thumb_url}}">
            <div class="info-data">
                <strong>{{$order->show->title}}</strong>
                <span>

                    @if($order->show->from_date == $order->show->to_date)
                        <span class="h-date"> {{\SeebBlade::prettyDateWithFormat($order->show->from_date,'d MMM')}}</span>
                    @else
                        <span class="h-date"> {{\SeebBlade::prettyDateWithFormat($order->show->from_date,'d MMM')}}
                            تا {{\SeebBlade::prettyDateWithFormat($order->show->to_date,'d MMM ')}}</span>
                    @endif
                </span>
                <span>{{$order->show->scene["name"]}}</span>
                <a href="{{route('website/get/show',['uid'=>$order->show->uid])}}" class="btn-persia show_dt_btn">جزییات
                    برنامه</a>
            </div>
        </div>


        <style>.buy-row {
            }

            .dt-info-tickt {
                width: 450px;
            }</style>
        <div class="ev-dir">
            <div class="buy-fa">
                <div class="buy-row timelineBuy pay_res_time">
                    <div class="step  act-st step1">
                        <i class="fa fa-check"></i>
                        <strong>انتخاب سانس</strong>
                    </div>
                    <div class="step act-st step2">
                        <i>2</i>
                        <strong>انتخاب جایگاه</strong>
                    </div>
                    <div class="step  act-st step3">
                        <i>3</i>
                        <strong>انتخاب صندلی</strong>
                    </div>
                    <div class="step act-st step4">
                        <i>4</i>
                        <strong>رزرو موقت</strong>
                    </div>
                    <div class="step act-st step6">
                        <i>5</i>
                        <strong>پرداخت</strong>
                    </div>
                    <div class="step act-st step5">
                        <i>6</i>
                        <strong>دریافت بلیت</strong>
                    </div>
                </div>

                <div class="buy-row ticket-review" style="display: block">

                    @if($order->tickets()->count() > 0)
                        <strong class="show-tit">    {{$order->tickets[0]->showtime->show->title}}</strong>
                        <span>{{$order->tickets[0]->showtime->show->scene->name}}</span>

                        <div class="dt-info-tickt pay_result_info">

                            <strong>سانس</strong>
                            <span class="f_re_sans"
                                  style="width: 55%">{{ SeebBlade::prettyDateWithFormat($order->tickets[0]->showtime->datetime,'H:mm')}}</span>

                            <strong>تاریخ</strong>

                            <span class="f_re_date">{{ SeebBlade::prettyDateWithFormat($order->tickets[0]->showtime->datetime,'EEEE dd MMM')}}</span>
                        </div>
                    @endif
                    <div class="hr"></div>
                        <div>
                    <div class="dt-info-tickt pay_result_info">
                        <strong>شماره فاکتور</strong>
                        <span class="f_re_date"> {{ $order->uid }}</span>

                    </div>
                    <div class="tickets-buy-s">
                        <div class="orders-back">
                            @if($order->status == 'approved')
                                <a href="{{ route('website/order/pdf',['uid'=>$order->uid]) }}" target="_blank"
                                   class="btn-persia dl-btn">دانلود</a>

                            @elseif($result == 0)
                                <div class="after_pay_error">
                                    <strong>پرداخت ناموفق بود </strong><br><br><br>
                                    <strong>شماره پیگیری</strong>
                                    @if($payment)
                                        @if(property_exists($payment->payment_info,'reference_id'))

                                            <span class="f_re_sans">{{$payment->payment_info->reference_id}}</span>
                                        @else
                                            <span class="f_re_sans">موجود نیست</span>
                                        @endif
                                    @else
                                        <span class="f_re_sans">موجود نیست</span>
                                    @endif

                                </div>
                            @endif
                        </div>
                    </div>

                </div>


            </div>

        </div>



@endsection