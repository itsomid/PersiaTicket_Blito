@include('panel.layouts.header')
@include('panel.layouts.menu')

<div id="page-wrapper" class="gray-bg" >
    <div class="user-create user-edit" >
        <div class="p-window">

            <div class="row">
                <form role="form" enctype="multipart/form-data" action="" method="post">

                    <div class="row">

                        <label class="pop-title">
                           قیمت صندلی های انتخاب شده
                        </label>
                    </div>
                    <div class="form-group"> <input name="update-price"  type="number" placeholder="قیمت" class="form-control update-price" value=""></div>


                    <span class="btn btn-sm btn-primary pull-right update-tickets" >ذخیره</span>
                    <a href="#" class="btn btn-sm btn-warning close-popup">لغو</a>
                </form>
            </div>
        </div></div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-7">
            <h2>بلیت‌های نمایش {{ $showtime->show->title }}</h2>

        </div>
        <div class="col-lg-5">
            <a href="#"  class="user-create btn btn-primary  show-popup" style="float: left;margin-bottom: 20px;">قیمت دهی</a>
            <a href="#"  class="user-create btn btn-danger disable-chiars " style="float: left;margin-left: 20px;">غیرقابل فروش</a>
            <a href="#"  class="user-create btn btn-warning mine-ticket" style="float: left;margin-left: 20px;">رزرو دستی</a>
        </div>
        <style>.panel-body{padding: 0 15px;}.nav-tabs li.active {background: #FFFFFF}.dl-horizontal dt , .dl-horizontal dd {width: auto;font-size: 20px}</style>

        <div class="col-lg-12">
            <div class="row "> <div class="col-lg-5">
                    <dl class="dl-horizontal">
                        <dt>سالن اجرا:</dt><dd>{{ $showtime->show->scene->name }}</dd>
                        <dt> تاریخ اجرا:</dt> <dd>{{ \SeebBlade::prettyDate($showtime->datetime) }}</dd>
                    </dl>
                </div></div>
            <div class="row m-t-sm">
                <div class="col-lg-12">
                    <div class="panel blank-panel">
                        <div class="panel-heading">
                            <div class="panel-options">


                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab-1" data-toggle="tab" aria-expanded="true"> کل بلیت ها </a></li>
                                    <li class=""><a href="#tab-2" data-toggle="tab" aria-expanded="false">فروخته شده</a></li>
                                    <li class=""><a href="#tab-3" data-toggle="tab" aria-expanded="false"> فروش نرفته </a></li>
                                    <li class=""><a href="#tab-4" data-toggle="tab" aria-expanded="false"> غیرقابل فروش </a></li>


                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-1">
                                    <table class="footable table table-stripped toggle-arrow-tiny">
                                        <thead>
                                        <tr>
                                            <th>شناسه بلیت</th>
                                            <th>خریدار</th>
                                            <th>جایگاه</th>
                                            <th>ردیف</th>
                                            <th>صندلی</th>
                                            <th>قیمت بلیت</th>
                                            <th>وضعیت</th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($all as $ticket)
                                        <tr>
                                            <td>{{ $ticket->uid }}</td>
                                            <td>{{ (is_null($ticket->order)) ? "-": $ticket->order->user->fullName()}}</td>
                                            <td>{{ $ticket->ticket_info["zone"] }}</td>
                                            <td>{{ $ticket->ticket_info["row"] }}</td>
                                            <td>{{ $ticket->ticket_info["seat"] }}</td>
                                            <td>{{ $ticket->price }}</td>
                                            <td>{{ trans('ticketstatus.'.$ticket->status) }}</td>

                                        </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>
                                <div class="tab-pane " id="tab-2">
                                    <table class="footable table table-stripped toggle-arrow-tiny">
                                        <thead>
                                        <tr>
                                            <th>شناسه بلیت</th>
                                            <th>خریدار</th>
                                            <th>جایگاه</th>
                                            <th>ردیف</th>
                                            <th>صندلی</th>
                                            <th>قیمت بلیت</th>
                                            <th>وضعیت</th>




                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sold as $ticket)
                                            <tr>
                                                <td>{{ $ticket->uid }}</td>
                                                <td>{{ (is_null($ticket->order)) ? "-": $ticket->order->user->fullName()}}</td>
                                                <td>{{ $ticket->ticket_info["zone"] }}</td>
                                                <td>{{ $ticket->ticket_info["row"] }}</td>
                                                <td>{{ $ticket->ticket_info["seat"] }}</td>
                                                <td>{{ $ticket->price }}</td>
                                                <td>{{ trans('ticketstatus.'.$ticket->status) }}</td>

                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>

                                </div>

                                <div class="tab-pane " id="tab-3">
                                    <table class="footable table table-stripped toggle-arrow-tiny">
                                        <thead>
                                        <tr>
                                            <th>شناسه بلیت</th>
                                            <th>خریدار</th>
                                            <th>جایگاه</th>
                                            <th>ردیف</th>
                                            <th>صندلی</th>
                                            <th>قیمت بلیت</th>
                                            <th>وضعیت</th>
                                            <th>عملیات</th>



                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($notSold as $ticket)
                                            <tr class="forosh-nrfte">
                                                <td>{{ $ticket->uid }}</td>
                                                <td>{{ (is_null($ticket->order)) ? "-": $ticket->order->user->fullName()}}</td>
                                                <td>{{ $ticket->ticket_info["zone"] }}</td>
                                                <td>{{ $ticket->ticket_info["row"] }}</td>
                                                <td>{{ $ticket->ticket_info["seat"] }}</td>
                                                <td>{{ $ticket->price }}</td>
                                                <td>{{ trans('ticketstatus.'.$ticket->status) }}</td>
                                                <td><input type="checkbox" name="{{ $ticket->id }}" class="up-checks mineTick dontSell"> </td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>

                                </div>

                                <div class="tab-pane " id="tab-4">
                                    <table class="footable table table-stripped toggle-arrow-tiny">
                                        <thead>
                                        <tr>
                                            <th>شناسه بلیت</th>
                                            <th>خریدار</th>
                                            <th>جایگاه</th>
                                            <th>ردیف</th>
                                            <th>صندلی</th>
                                            <th>قیمت بلیت</th>
                                            <th>وضعیت</th>
                                            <th>عملیات</th>



                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($disabled as $ticket)
                                            <tr>
                                                <td>{{ $ticket->uid }}</td>
                                                <td>{{ (is_null($ticket->order)) ? "-": $ticket->order->user->fullName()}}</td>
                                                <td>{{ $ticket->ticket_info["zone"] }}</td>
                                                <td>{{ $ticket->ticket_info["row"] }}</td>
                                                <td>{{ $ticket->ticket_info["seat"] }}</td>
                                                <td>{{ $ticket->price }}</td>
                                                <td>{{ trans('ticketstatus.'.$ticket->status) }}</td>
                                                <td><input type="checkbox" name="{{ $ticket->id }}" class="up-checks mineTick disTick"> </td>
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
@include('panel.layouts.footer')
    <script>
        $(document).ready(function () {
            $('.disable-chiars').click(function(){
                var disChair = "" ;
                if ($('.dontSell:checked').length > 0 ) {
                var txt;
                var r = confirm("مطمئن هستید؟");
                if (r == true) {

                    $('.forosh-nrfte td input.dontSell:checked').each(function () {
                        //disChair.push($(this).attr('name'));
                        disChair +=  $(this).attr('name') + ","
                            });
                    disChair = disChair.substring(0,disChair.length - 1) ;
                    $.post("{{route('disable/tickets',['showtime_uid' => $showtime->uid])}}",
                        {
                            tickets: disChair,
                            _token: "{{ csrf_token() }}"
                        },
                        function(data,status){
                            //alert("Data: " + data.result + "\nStatus: " + status);
                            var resCome =  data.result ;
                            if (resCome == true){
                                alert('با موفقیت انجام شد');
                                location.reload();
                            }else {
                                alert('خطا')
                            }

                    });

                    } else {

                }



                }else{
                    alert('هیج صندلی انتخاب نشده')
                }








            });
            $('.update-tickets').click(function(){
                var updateChairs = "";
                if ($('.disTick:checked').length > 0 ) {
                var price = $('.update-price').val();
                $('.disTick:checked').each(function () {
                    updateChairs += $(this).attr('name') + ':' +  price + ",";
                });
                updateChairs = updateChairs.substring(0,updateChairs.length - 1) ;

                $.post("{{route('enable/tickets',['showtime_uid' => $showtime->uid])}}",
                    {
                        tickets: updateChairs,
                        _token: "{{ csrf_token() }}"
                    },
                    function(data,status){
                        //alert("Data: " + data.result + "\nStatus: " + status);
                        var resCome =  data.result ;
                        if (resCome == true){
                            alert('با موفقیت انجام شد');
                            location.reload();
                        }else {
                            alert('خطا')
                        }

                    });




                }else{
                    alert('هیج صندلی انتخاب نشده')
                }


            });










            $('.mine-ticket').click(function(){
                var mineTicket = "";
               if ($('.mineTick:checked').length > 0 ) {
                   $('.mineTick:checked').each(function () {
                       mineTicket += $(this).attr('name') + ",";
                   });
                   mineTicket = mineTicket.substring(0, mineTicket.length - 1);

                   $.post("{{route('setmine/tickets',['showtime_uid' => $showtime->uid])}}",
                       {
                           tickets: mineTicket,
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


               }else{
                   alert('هیج صندلی انتخاب نشده')
               }

            });












        });

    </script>