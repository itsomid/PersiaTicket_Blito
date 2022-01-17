@include('panel.layouts.header')
@include('panel.layouts.menu')

<div id="page-wrapper" class="gray-bg">
    @include('panel.layouts.search-navbar')
    <div class="col-lg-12"><a href="#" class="fa fa-arrow-left icon back-icon"></a> </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="ibox-content">
            @include('panel.usereditmodal',['user' => $user])
            <div class="row">

                <div class="col-sm-12">
                    <div class="m-b-md">
                        <a href="#" class="user-edit btn btn-white btn-xs pull-right show-popup">ویرایش پروفایل</a>
                        <h2>{{ $user->fullName() }}</h2>


                    </div>

                </div>

            </div>
            <div class="row">
                <div class="col-sm-2">
                    <img class="img-responsive user-img " src="{{ asset($user->avatar_url) }}" />

                </div>
                <div class="col-sm-10">
                    <dl class="dl-horizontal user-names-rtl">

                          <dt>وضعیت:</dt> <dd><span class="label label-primary">{{ trans('userstatus.'.$user->status) }}</span></dd>
                        <br>

                        <dt> نام کاربری :</dt> <dd>{{ $user->email }}</dd>
                        <dt> شماره موبایل:</dt> <dd>{{$user->mobile}}</dd>
                        <dt>  تاریخ عضویت:</dt> <dd>{{ \SeebBlade::prettyDate($user->created_at) }} </dd>
                    </dl>
                </div>
                <div class="row">

                </div>

            </div>

            <div class="row m-t-sm">
                <div class="col-lg-12">
                    <div class="panel blank-panel">
                        <div class="panel-heading">
                            <div class="panel-options">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab-1" data-toggle="tab" aria-expanded="true">فاکتور ها</a></li>
                                    <li class=""><a href="#tab-2" data-toggle="tab" aria-expanded="false">پرداخت‌ها</a></li>

                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="tab-content">
                                <div class="tab-pane" id="tab-1">

                                    @foreach($user->orders as $order)
                                        <div class="ibox row">
                                            <div class="ibox-title">
                                                <table class="footable table table-stripped toggle-arrow-tiny">
                                                    <thead >
                                                    <tr>
                                                        <th>شماره فاکتور</th>
                                                        <th>نام برنامه</th>
                                                        <th>شهر</th>
                                                        <th>سانس</th>
                                                        <th>ساعت</th>
                                                        <th>تعداد</th>
                                                        <th>شناسه پرداخت</th>
                                                        <th>تاریخ</th>
                                                        <th>قیمت</th>
                                                        <th>وضعیت فاکتور</th>
                                                        <th>مشاهده</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>

                                                    <tr>
                                                        <td>{{ $order->uid }}</td>

                                                        @if($order->tickets()->count() > 0)
                                                            <td>
                                                                {{ $order->tickets[0]->showtime->show->title}}
                                                            </td>
                                                            <td>
                                                                {{ $order->tickets[0]->showtime->show->city->name}}
                                                            </td>
                                                            <td>
                                                                {{ SeebBlade::prettyDateWithFormat($order->tickets[0]->showtime->datetime,'EEE, dd MMM yyyy')}}
                                                            </td>
                                                            <td>
                                                                {{ SeebBlade::prettyDateWithFormat($order->tickets[0]->showtime->datetime,'HH:mm')}}
                                                            </td>
                                                        @else
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                            <td>-</td>
                                                        @endif
                                                        <td>{{ $order->user->fullName() }}</td>

                                                        @if($order->payments()->count() == 0)
                                                            <td>پرداخت نشده</td>
                                                            <td>-</td>
                                                        @else
                                                            <td>{{ property_exists($order->payments()->first()->details(),'reference_id') ? $order->payments()->first()->details()->reference_id : ""}}</td>
                                                            <td>{{ SeebBlade::prettyDateWithFormat($order->payments()->first()->created_at,'dd/MM/yyyy در ساعت HH:mm:ss')}}</td>
                                                        @endif

                                                        <td>7676676</td>
                                                        <td>پرداخت شد</td>

                                                        <td>
                                                            <a href="#" class="btn btn-sm btn-primary collapse-link" style="width: 100%">
                                                                <i class="fa fa-chevron-down"></i>
                                                            </a>
                                                        </td>
                                                    </tr>


                                                    </tbody>
                                                </table>

                                            </div>
                                            <div class="ibox-content" style="display: none;">

                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>شناسه بلیت</th>
                                                        <th>جایگاه</th>
                                                        <th>ردیف</th>
                                                        <th>صندلی</th>
                                                        <th>قیمت</th>
                                                        <th>عملیات</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($order->tickets as $ticket)
                                                        <tr>
                                                            <td>{{$ticket->uid}}</td>
                                                            <td>{{$ticket->ticket_info['zone']}}</td>
                                                            <td>{{$ticket->ticket_info['row']}}</td>
                                                            <td>{{$ticket->ticket_info['seat']}}</td>
                                                            <td>{{$ticket->price}}</td>
                                                            <td><a href="{{ route('orders/download', ['uid' => $ticket->order->uid]) }}" class="btn btn-info">دانلود بلیت</a> </td>

                                                        </tr>
                                                    @endforeach
                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                                <div class="tab-pane active" id="tab-2">
                                    <table class="footable table table-stripped toggle-arrow-tiny">
                                        <thead>
                                        <tr>
                                            <th>شماره تراکنش</th>
                                            <th>کاربر</th>
                                            <th>تاریخ</th>
                                            <th>مبلغ</th>
                                            <th>شماره پیگیری</th>
                                            <th>فاکتور</th>
                                            <th>وضعیت</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($user->payments as $payment)
                                            <tr>
                                                <td>{{$payment->uid}}</td>
                                                <td>{{$payment->user->fullName()}}</td>
                                                <td>{{ SeebBlade::prettyDate($payment->updated_at) }}</td>
                                                <td>{{ $payment->amount }}</td>

                                                <td>{{ property_exists($payment->details(),'reference_id')?  $payment->details()->reference_id : "-"  }}</td>
                                                <td>
                                                    @if(is_null($payment->order))
                                                        -
                                                    @else
                                                        {{ $payment->order->uid }}
                                                    @endif
                                                </td>
                                                <td>{{ trans('status.'.$payment->status) }}</td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>


                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


@include('panel.layouts.footer')
