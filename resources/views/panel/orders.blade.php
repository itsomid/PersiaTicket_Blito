@include('panel.layouts.header')
@include('panel.layouts.menu')

<div id="page-wrapper" class="gray-bg" >
    @include('panel.layouts.search-navbar')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-10">
            <h2>فاکتورها</h2>
        </div>







        <div class="user-create user-edit" >
            <div class="p-window">
                <div class="row">
                    <form role="form" enctype="multipart/form-data" action="{{route('orders/resend')}}" method="post">
                        <input type="hidden" name="_token" value="UjnIl5uG2BDtJ6VLe9i4qoHKtKJA1Qfum8OsTx4L">
                        <div class="row">

                            <label class="pop-title">
                                ارسال مجدد سفارش

                            </label>
                        </div>
                        <div class="form-group">
                            {{ csrf_field() }}
                            <input name="order_uid" class="order-uid" type="hidden" value="">
                            <input name="email_address" type="text" placeholder="آدرس ایمیل"  value="" class="forminwid user-send-email" style="width: 100%">

                        </div>



                        <span class="btn btn-sm btn-primary pull-right resend-factor">ذخیره</span>
                        <a href="#" class="btn btn-sm btn-warning close-popup" style="width: 50px">لغو</a>
                    </form>
                </div>
            </div></div>












        <div class="col-lg-12">
            @foreach($orders as $order)
                <div class="ibox row">
                    <div class="ibox-title">
                        <table class="footable table table-stripped toggle-arrow-tiny orders-table">
                            <thead >
                            <tr>
                                <th>شماره فاکتور</th>
                                <th>نام برنامه</th>
                                <th class="onecol">شهر</th>
                                <th>سانس</th>
                                <th>خریدار</th>
                                <th> وضعیت پرداخت</th>

                                <th> مبلغ کل</th>
                                <th>وضعیت</th>
                                <th class="onecol">عملیات</th>

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
                                        {{ SeebBlade::prettyDate($order->tickets[0]->showtime->datetime)}}
                                    </td>

                                @else
                                    <td>-</td>
                                    <td>-</td>
                                    <td>-</td>
                                @endif

                                <td>{{ $order->user->fullName() }}
                                    <input type="hidden" value="{{ $order->user->email }}" class="user-email">
                                    <input type="hidden" value="{{ $order->id }}" class="id">

                                </td>

                                @if($order->payments()->count() == 0)
                                    <td>پرداخت نشده</td>
                                @else
                                    <td>{{ property_exists($order->payments()->first()->details(),'reference_id')? $order->payments()->first()->details()->reference_id :'' }}<br><small>{{ SeebBlade::prettyDateWithFormat($order->payments()->first()->created_at,'dd/MM/yyyy در ساعت HH:mm:ss')}}</small></td>
                                @endif

                                <td>
                                    {{ number_format($order->price) }} تومان
                                </td>
                                <td>
                                    {{trans('orderstatus.'.$order->status)}}
                                </td>
                                @if(false)
                                <td>

                                    <a href="#" class="user-create btn btn-sm btn-primary show-popup factor-send" style="width: 100%">
                                        ارسال مجدد
                                    </a>

                                </td>
                                @endif
                                <td>
                                    @if($order->status == 'approved')
                                    <a href="{{ route('orders/download', ['uid' => $order->uid]) }}" class="btn btn-primary" target="_blank">دانلود</a>
                                    @endif
                                    @if($order->status != 'canceled')
                                        <a href="{{ route('orders/cancel', ['id' => $order->id]) }}" class="btn btn-danger" target="_blank">لغو</a>
                                    @endif

                                </td>

                                <td>
                                    <span href="#" class="btn btn-sm btn-warning collapse-link" style="width: 100%">
                                        <i class="fa fa-chevron-down"></i>
                                    </span>
                                </td>
                            </tr>


                            </tbody>
                        </table>

                    </div>
                    <div class="ibox-content" style="display: none;">

                        <table class="table orders-ch-list">
                            <thead>
                            <tr>
                                <th>شناسه بلیت</th>
                                <th>سالن اجرا</th>
                                <th>تاریخ اجرا</th>
                                <th>جایگاه</th>
                                <th>ردیف</th>
                                <th>صندلی</th>
                                <th>قیمت بلیط</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($order->tickets as $ticket)
                                <tr>
                                    <td>{{$ticket->uid}}</td>
                                    <td>{{$ticket->showtime->show->scene->name }}</td>
                                    <td>{{\SeebBlade::prettyDate($ticket->showtime->datetime) }}</td>
                                    <td>{{$ticket->ticket_info['zone']}}</td>
                                    <td>{{$ticket->ticket_info['row']}}</td>
                                    <td>{{$ticket->ticket_info['seat']}}</td>
                                    <td>{{$ticket->price}}</td>
                                </tr>
                            @endforeach

                            </tbody>
                        </table>

                    </div>
                </div>
            @endforeach


            @if(count($orders) == 0)
                <div class="ibox row">فاکتوری وجود ندارد</div>
                @else
                    {{ $orders->links() }}
            @endif


        </div>



</div>

</div>
@include('panel.layouts.footer')
<script>
    var uEmail = "";
    var id    = "";
    $('.factor-send').click(function(){
        uEmail = $(this).parents('tr').find('input.user-email').val() ;
        id = $(this).parents('tr').find('input.id').val() ;
        $('.user-send-email').val(uEmail)
    });
    $('.resend-factor').click(function(){
alert(uEmail + "" + id);



            $.post("{{route('orders/resend')}}",
                {
                    email: uEmail,
                    order_id  : id ,
                    _token: "{{ csrf_token() }}"
                },
                function (data, status) {
                    //alert("Data: " + data.result + "\nStatus: " + status);
                    var resCome = data.result;
                    if (resCome == true) {
                        alert('با موفقیت انجام شد');
                        location.reload();
                    } else {
                        alert('خطا')
                    }

                });







    });

</script>