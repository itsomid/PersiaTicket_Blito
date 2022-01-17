@extends('landing.master')
@section('header')
    خرید بلیت | {{$show->title}}
@endsection
@section('content')

    <style>
        menu {
            background-color: rgba(0, 0, 0, 0.5);
        }
    </style>

    <div class="loading-fa">
        <div class="pop-loading">
    <span><div class="bounce_1"></div>
    <div class="bounce_2"></div>
    <div class="bounce_3"></div></span></div>
    </div>
    <div class="event-single">
        <img src="{{$show->main_image_url}}" class="bg-event">
        <div class="timeline-ev">
            <a href="{{route('website/home')}}">برنامه‌ها</a>

            <a href="{{ route('website/get/show',['uid'=>$show->uid]) }}">{{$show->title}}</a>
            <span class="ev-name">خرید بلیت</span>
        </div>


        <div class="event-info">
            <img src="{{$show->thumb_url}}">
            <div class="info-data">
                <strong>{{$show->title}}</strong>
                <span>
                    @if($show->from_date == $show->to_date)
                        <span class="h-date"> {{\SeebBlade::prettyDateWithFormat($show->from_date,'d MMM')}}</span>
                    @else
                        <span class="h-date"> {{\SeebBlade::prettyDateWithFormat($show->from_date,'d MMM')}}
                            تا {{\SeebBlade::prettyDateWithFormat($show->to_date,'d MMM ')}}</span>
                    @endif
                </span>
                <span>{{$show->scene["name"]}}</span>
                <a href="{{route('website/get/show',['uid'=>$show->uid])}}" class="btn-persia show_dt_btn">جزییات
                    برنامه</a>
            </div>
        </div>

        <div class="ev-dir">
            <div class="buy-fa">
                <div class="buy-row timelineBuy fix-timeline" id="fix-timeline">
                    <div class="step  act-st step1">
                        <i class="fa fa-check"></i>
                        <strong>انتخاب سانس</strong>
                    </div>
                    <div class="step step2">
                        <i>2</i>
                        <strong>انتخاب جایگاه</strong>
                    </div>
                    <div class="step step3">
                        <i>3</i>
                        <strong>انتخاب صندلی</strong>
                    </div>
                    <div class="step step4">
                        <i>4</i>
                        <strong>رزرو موقت</strong>
                    </div>
                    <div class="step step6">
                        <i>5</i>
                        <strong>پرداخت</strong>
                    </div>
                    <div class="step step5">
                        <i>6</i>
                        <strong>دریافت بلیت</strong>
                    </div>
                </div>
                <div class="buy-row busSans buy-t-v">
                    <span class="r-tit">لطفا روز مورد نظر خود را انتخاب نمایید.</span>
                    @foreach($days as $key => $showtimes)
                        <span class="sans-{{$key}} sans-{{$key}}-date ticket-date ticket-sans">{{\SeebBlade::prettyDateWithFormat($showtimes[0]->datetime,'EEEE dd MMM y')}}</span>
                    @endforeach
                    <div class="sans-hide">
                        <span class="r-tit">لطفا سانس مورد نظر خود را انتخاب کنید.</span>
                        @foreach($days as $key => $showtimes)
                            @foreach($showtimes as $showtime)
                                <span class="{{$showtime->uid}} sans-{{$key}} ticket-sans  ticket-final-sans"
                                      data-id="{{$showtime->uid}}">{{\SeebBlade::prettyDateWithFormat($showtime->datetime,'H:mm')}}</span>
                            @endforeach
                        @endforeach
                    </div>
                </div>

                <div class="buy-row buyPlace buy-t-v" id="buy_ch_scroll">
                    <span class="r-tit ">لطفا جایگاه مورد نظر خود را انتخاب کنید.</span>
                    <div class="autosec-fa">
                        <div class="autosec-title">
                            <div>قیمت هر صندلی</div>
                            <div class="price-chair"><span>20000</span> تومان</div>
                        </div>
                        <input class="chair-number" type="number" value="0" min="1" max="20">
                        <div class="chair-have-max"> تعداد صندلی های باقی مانده <span></span> عدد میباشد</div>
                    </div>

                    <div class="tabs_tiwall"></div>
                    <div class="price-cat" style="display: none;"></div>
                    <div class="plan-img-fa">
                        <img class="plan-img-c" width="200px" src="">

                    </div>
                    <div class="ex-p">
                        <div class="chair-list-footer">
                            <span>شما میتوانید با تغییر جایگاه،‌ به صورت همزمان از چندجایگاه صندلی انتخاب نمایید.</span>
                            <div class="ch-f-price">
                                <div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="buy-row buyChair buy-t-v">
                    <span class="r-tit autosecnone">لطفا صندلی های مورد نظر خود را انتخاب کنید.</span>
                    <div class="chair-info-tick autosecnone">
                        <span><i style="background: #19a162"></i>قابل خرید</span>
                        <span><i style="background: #fa000f"></i>فروخته شده</span>
                        <span><i style="background: #cddd26"></i>  رزرو موقت</span>
                        <span><i style="background: #E86C1C"></i>انتخاب شما</span>

                    </div>
                    <div class="view-scroll autosecnone">
                        <div class="chair-list">

                        </div>


                    </div>

                    <div class="chair-list-footer ">
                        <span class="autosecnone">شما میتوانید با تغییر جایگاه،‌ به صورت همزمان از چندجایگاه صندلی انتخاب نمایید.</span>
                        <div class="ch-f-price">
                            <div>
                                <strong><span class="chiar-int-se">0</span>صندلی</strong>
                                <strong>بهای نهایی : <span class="chiar-int-se-price">0</span> تومان</strong>
                            </div>

                        </div>
                    </div>

                </div>
                <div class="buy-row buyFinal  buy-t-v">
                    <span>با آغاز روند خرید بلیت، به مدت پانزده دقیقه بلیت‌ها رزرو موقت شده و با پرداخت بهای آن‌ها، نهایی می‌گردند.
                        <br>
                        از کارت *هر* بانک که رمز اینترنتی (رمز دوم) آن را فعال نموده باشید می‌توانید بهره ببرید.</span>
                    @if(\Auth::check())
                        شماره تلفن  {{$user->mobile}}
                        <input type="hidden" class="gust_num" value="{{$user->mobile}}">
                    @else
                        <div class="mobile-in"><strong>شماره تماس :</strong><input type="text"
                                                                                   class="gust_num phone-format"></div>
                    @endif

                    <p class="btn-persia disable_res" style="cursor: pointer; left: 20px;">خرید</p>
                </div>

                <div class="buy-row ticket-review">
                    <span class="back_to"><i class="fa fa-arrow-right"></i>بازگشت</span>
                    <strong class="show-tit">{{$show->title}}</strong>
                    <div class="timer_res">
                        <span>مهلت پایان رزرو صندلی های شما</span>
                        <strong class="countdown">10:00</strong>
                    </div>


                    <span class="fi-place">{{$show->scene["name"]}}</span>
                    <div class="dt-info-tickt">

                        <strong>سانس</strong>
                        <span class="f_re_sans"></span>
                        {{--                       <span>{{\SeebBlade::prettyDateWithFormat($showtimes[0]->datetime,'H:M')}}</span>--}}
                        <strong>تاریخ</strong>
                        <span class="f_re_date"></span>
                        {{--                        <span>{{\SeebBlade::prettyDateWithFormat($showtimes[0]->datetime,'dd MMM')}}</span>--}}


                    </div>
                    <div class="hr"></div>

                    <div class="tickets-buy-s">
                        <div class="orders-back">

                        </div>

                        <div class="one-ticket-re f-price">
                            <div class="colm-tickt clt-row autosecnone auto-int">

                            </div>
                            <div class="colm-tickt clt-row ">

                                <strong>هزینه قابل پرداخت :</strong>
                                <span class="order-f-price"></span>
                                <strong>تومان</strong>
                            </div>
                            <div class="colm-tickt clt-row offer-code">
                                <strong class="ok_offer"></strong>
                                <input type="text" value="">
                                <span class="choose-offer ">اعمال</span>
                                <b>کد وارد شده اشتباه است</b>

                            </div>


                        </div>
                        <a href="#" class="btn-persia buy-btn getway">پرداخت</a>
                        <div class="gust_num gust-text-l">
                            <strong>شما با شماره </strong>
                            <span class="gust_num"></span>
                            <strong>در حال خرید هستید</strong>

                        </div>
                    </div>

                </div>


            </div>

        </div>

    </div>

    <style class="style">

    </style>

    <script>
        // console.log(localStorage)
        // localStorage.setItem('','');
        if (localStorage.getItem('test')) {
            //     alert('set')
        } else {
            //  alert('not set')
        }


        window.onscroll = function () {
            mysFunction()
        };
        var header = document.getElementById("fix-timeline");

        function mysFunction() {

            if (window.pageYOffset + 600 > $(document).height() - 473) {
                header.classList.remove("fix-t");
                header.classList.add("fix-t-footer");
            } else {
                header.classList.remove("fix-t-footer");
            }

        }


        var showTimeuid = '';
        var seats_have = '';
        var finalData = '';
        var tabs_twall = '';
        var gust = $('input.gust_num').val();
        var auto_selection = false;
        if (auto_selection == false) {
            $('.autosec-fa').fadeOut(0);
        }

        function onSeatSelectionChange(data) {

            finalData = JSON.parse(data);
            if (finalData.count == 0) {
                $('.reserve-btn').addClass('disable_res')
                $('.reserve-btn').removeClass('reserve-btn');
            } else {
                $('.disable_res').addClass('reserve-btn')
                $('.disable_res').removeClass('disable_res');
            }

            seats_have = finalData.seats;
            // console.log(finalData)
            $('.ch-f-price div').css({
                'background': '#555961',
                'text-align': 'center',
                'padding': '15px',
                'border-radius': '10px'
            })
            $('.ex-p .ch-f-price div').text(finalData.summary)

        }

        var source_id = {{ $show->source_id }};
        var login = {{ \Auth::guest() ? "false" : "true" }};
        var tickets_have = [];
        var remaining_seats = 0;
        $('.ticket-final-sans').click(function () {
            $('.step2').addClass('act-st');


            showTimeuid = $(this).attr('data-id');
            //  alert($(this).attr('data-id'));
            $('.buyPlace').fadeIn();
            $('.loading-fa').fadeIn();
            $([document.documentElement, document.body]).animate({
                scrollTop: $(".buyPlace").offset().top
            }, 1000);


            $.ajax({
                url: "{{route('website/seatmap/'.($show->source_id == 1? 'internal' : 'external'))}}" + '/' + $(this).attr('data-id'),
                success: function (result) {
                    // console.log(result);
                    if (source_id > 1) {


                        $('.step3').addClass('act-st');

                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#buy_ch_scroll").offset().top
                        }, 1000);
                        $('.buyPlace .r-tit').text('لطفا جایگاه و صندلی های مورد نظر خود را انتخاب کنید.');
                        $('.ex-p').fadeIn();
                        $('.buyFinal').fadeIn();
                        $('.buyChair').fadeOut();
                        $('.loading-fa').fadeOut();
                        $('.plan-img-fa').css({'float': 'none', 'margin-left': '0'});
                        $('.plan-img-fa').html(result.data.html);
                        $('.style').html(result.data.css);
                        var tabs_id = '';
                        var tabs_title = '';


                        $(".tabs_tiwall").html('');
                        jQuery.each(result.data.sections, function (index, ord) {
                            tabs_id = result.data.sections[index].id;
                            tabs_title = result.data.sections[index].title;

                            if (index == 0) {
                                $(".tabs_tiwall").append('<span class="' + tabs_id + ' active_tiwall">' + tabs_title + '</span>');
                            } else {
                                $(".tabs_tiwall").append('<span class="' + tabs_id + ' ">' + tabs_title + '</span>');
                            }


                        });
                        // console.log(result.data.sections);
                        //console.log(result.data.section);

                    } else {

                        $('.loading-fa').fadeOut();
                        tickets_have = [];
                        console.log(result);
                        if (!result.auto_selection) {

                            $('.autosec-fa').fadeOut(0);

                            $(".price-cat").html("<strong class='p-pin-all'>همه</strong>");
                            var data = result;


                            var chairHtml = "";

                            for (i = 0; i < data.zones.length; i++) {
                                chairHtml += '<div class="place_fa place_fa_' + i + '">';
                                jQuery.each(data.zones[i].rows, function (i, row) {
                                    chairHtml += '<div class="chair-row-tick " id="' + row.id + '"  ><div class="rowid">' + row.row + '.</div>';
                                    jQuery.each(row.seats, function (i, seat) {
                                        var thisPrice = '';
                                        if (seat.tickets[0].price == 0) {
                                            thisPrice = 'غیرقابل فروش';
                                        } else {
                                            thisPrice = seat.tickets[0].price + ' تومان ';
                                        }

                                        tickets_have.push(seat.tickets[0]);

                                        chairHtml += '<span pcf="' + seat.tickets[0].price + '" uidTick="' + seat.tickets[0].uid + '" class="ticket-chair ticket-buy ticket-' + seat.tickets[0].status + '" style="margin-left: ' + parseFloat(parseFloat(seat.space_to_left) * (25 + 6) + 3) + 'px; margin-right: ' + parseFloat(parseFloat(seat.space_to_right) * (25 + 6) + 3) + 'px "><i>' + thisPrice + '</i>' + seat.column + '</span>'
                                    });
                                    chairHtml += '</div>';

                                });
                                chairHtml += '</div>';
                            }
                            $('.chair-list').html(chairHtml);


                            jQuery.each(data.price_classes, function (i, val) {
                                $(".price-cat").append("<strong class='pc-" + val + "'>  " + val + " تومان</strong>");
                            });
                            $('.plan-img-c').attr('src', data.zones[0].zone.plan.image_url);
                            jQuery.each(data.zones, function (i, zone) {
                                var price_classes = "";
                                jQuery.each(zone.price_classes, function (i, pc) {
                                    price_classes += " pc-" + pc;
                                });
                                $(".plan-img-fa").append('<span id="' + i + '" class="' + price_classes + ' p-pin" style="left: ' + zone.zone.x * 100 + '% ;top: ' + zone.zone.y * 100 + '%;">' + zone.remaining + '<br>' + 'صندلی' + ' </span>');
                            });


                            $("body").delegate(".p-pin", "click", function () {


                                $('.step3').addClass('act-st');

                                if ($(this).hasClass('act_p_click')) {

                                    $(this).removeClass('act_p_click');
                                } else {
                                    $('.act_p_click').removeClass('act_p_click');
                                    $(this).addClass('act_p_click');

                                    var s_active = $(this).attr('id');
                                    localStorage.setItem('pinp', s_active[0]);
                                }

                                var pin_id = $(this).attr('id');
                                $('.place_fa').fadeOut(0);
                                $('.place_fa_' + pin_id).fadeIn(0);
                                $('.buyChair').fadeIn();
                                $('.buyFinal').fadeIn();
                                $([document.documentElement, document.body]).animate({
                                    scrollTop: $(".buyChair").offset().top
                                }, 1000);


                            });
                        } else {
                            auto_selection = true;
                            remaining_seats = result[0].remaining_seats;
                            $('.chair-have-max span').text(remaining_seats);
                            if (remaining_seats <= 5) {
                                $('.chair-number').attr('max', remaining_seats)
                            }
                            $('.buyPlace .r-tit').text('لطفا تعداد صندلی های مورد نظر خود را انتخاب کنید.');
                            $('.price-chair span').text(result.price);
                            $('.autosec-fa').fadeIn(0);
                            $('.autosecnone').fadeOut(0);
                            $('.buyFinal,.chair-list-footer ,.buyChair').fadeIn(0);
                            $(".chair-number").bind('keyup mouseup', function () {

                                $(this).val(parseInt($(this).val()));
                                var price = parseInt($('.price-chair span').text());
                                var chair_int = parseInt($(this).val());

                                if (chair_int <= 5) {
                                    $('.chiar-int-se').text(chair_int);
                                    $('.chiar-int-se-price').text(price * chair_int);
                                    $('.order-f-price').text(price * chair_int)
                                } else {

                                    chair_int = 5;
                                    $(this).val(chair_int);
                                    $('.chiar-int-se').text(chair_int);
                                    $('.chiar-int-se-price').text(price * chair_int);
                                    $('.order-f-price').text(price * chair_int)
                                }


                                if (chair_int == 0) {
                                    $('.reserve-btn').addClass('disable_res')
                                    $('.reserve-btn').removeClass('reserve-btn');
                                } else {
                                    $('.disable_res').addClass('reserve-btn')
                                    $('.disable_res').removeClass('disable_res');
                                }

                            });

                        }

                    }
                }
            });

        });
        var order_re = '';
        var final_price_order = 0;
        var order_uid = '';
        var tickets_buy = [];
        var ticket_pc = 0;
        var orders = [];
        var res_ajax = [];
        $("body").delegate(".ticket-available", "click", function () {


            if ($(this).hasClass("ticket-yours")) {
                $(this).removeClass('ticket-yours');
                var num_now = parseInt($('.chiar-int-se').text()) - 1;
                $('.chiar-int-se').text(num_now);

            } else {
                var chair_selected = $('.chair-list span.ticket-yours').length;
                ticket_pc = parseInt(ticket_pc + parseInt($(this).attr('pcf')));
                var tick_uid = $(this).attr('uidTick');
                tickets_buy.push(tick_uid);
                $('.chiar-int-se').text(chair_selected + 1);
                $('.chiar-int-se-price').text(ticket_pc);

                $(this).addClass('ticket-yours');
            }


            if ($('.chair-list span.ticket-yours').length == 0) {
                $('.reserve-btn').addClass('disable_res')
                $('.reserve-btn').removeClass('reserve-btn');
            } else {
                $('.disable_res').addClass('reserve-btn')
                $('.disable_res').removeClass('disable_res');
            }
        });
        $("body").delegate(".ticket-yours", "click", function () {
            var uidDeleat = $(this).attr('uidTick');
            var pcDeleat = $(this).attr('pcf');
            ticket_pc = ticket_pc - pcDeleat;
            $('.chiar-int-se-price').text(ticket_pc);
            tickets_buy = $.grep(tickets_buy, function (value) {
                return value != uidDeleat;
            });
        });
        var isLogin = true;


        $(".phone-format").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                return false;
            }
            var curchr = this.value.length;
            var curval = $(this).val();
            if (curchr == 1 && curval == 0) {
                $(this).removeClass('red_border');

            } else if (curchr == 2 && curval == 9) {
                $(this).removeClass('red_border')

            } else if (curchr == 9) {
                $(this).removeClass('red_border')
                $(this).attr('maxlength', '11');
            } else if (curchr > 2) {
                $(this).removeClass('red_border')
            } else {
                $(this).val("")
                $(this).addClass('red_border');


            }


        });


        $("body").delegate(".reserve-btn", "click", function () {
            localStorage.setItem('mobile', $('input.gust_num').val());
            $('.f_re_date').text($('.ticket-sans-checked').text());
            $('.f_re_sans').text($('.ticket-date-checked').text());


            if (auto_selection) {
                var ticket_number = $('.chair-number').val();

                if (ticket_number <= remaining_seats) {
                    if (login) {

                        var showtime_id = $('.ticket-final-sans').attr('data-id');
                        var ticket_number = $('.chair-number').val();
                        $.ajax({
                            url: "{{route('website/reserve/internal/chairless')}}",
                            type: "POST",
                            data: {

                                _token: "{{ csrf_token() }}",
                                showtime_id: showtime_id,
                                ticket_number: ticket_number
                            },
                            statusCode: {
                                410: function () {
                                    console.log("-1-1-1-1 WE GOT 404!");
                                },
                                200: function () {

                                },
                                406: function () {
                                    console.log("-1-1-1-1 WE GOT 200!");
                                }
                            },
                            success: function (data) {


                                $('.loading-fa').fadeOut();
                                res_ajax = data;
                                orders = data;
                                // alert(data.redirect_url);

                                $('.loading-fa').fadeOut(1000);
                                $('.buy-t-v').fadeOut();
                                $('.ticket-review').fadeIn();


                                $('.auto-int').fadeIn(0);
                                $('.auto-int').html(
                                    '<strong>تعداد صندلی :</strong>' +
                                    '<span>' + $('.chair-number').val() + '</span>' +
                                    '<strong>عدد</strong>'
                                );
                            },
                            error: function (e) {
                                // alert(e);
                            }
                        });
                    } else {
                        if ($('input.gust_num').val().length === 0 || $('input.gust_num').val().length < 11) {
                            alert('شماره خود را وارد نمایید');
                        } else {
                            var showtime_id = $('.ticket-final-sans').attr('data-id');
                            var ticket_number = $('.chair-number').val();

                            $('.step4').addClass('act-st');
                            //  $("html, body").animate({ scrollTop: $(document).height() - 300 }, 100);
                            $('span.gust_num').text($('input.gust_num').val());
                            $('.loading-fa').fadeIn();
                            $('.loading-fa').fadeOut(1000);
                            $('.buy-t-v').fadeOut();
                            $('.ticket-review').fadeIn();

                            order_re = '';
                            final_price_order = 0;
                            var local_ticket = [];
                            jQuery.each(tickets_have, function (i, tickets) {
                                jQuery.each(tickets_buy, function (x, ticket) {
                                    if (tickets.uid == ticket) {
                                        local_ticket.push(tickets);
                                        order_re += ' <div class="one-ticket-re">\n' +
                                            '<div class="uid_need" style="display: none">' + tickets.uid + '</div>' +
                                            '<div class="colm-tickt clt-row">' + parseInt(x + 1) + '</div>\n' +
                                            '<div class="colm-tickt clt-place">' + tickets.ticket_info.zone + '</div>\n' +
                                            '<div class="colm-tickt clt-radif">ردیف ' + tickets.ticket_info.row + '</div>\n' +
                                            '<div class="colm-tickt clt-chair">صندلی ' + tickets.ticket_info.seat + '</div>\n' +
                                            '<div class="colm-tickt clt-price">' + tickets.price + '</div>\n' +
                                            '<div class="colm-tickt clt-pt">تومان</div>\n' +
                                            '<div class="colm-tickt clt-deleat fa fa-close"></div>\n' +
                                            '</div>';
                                        final_price_order = final_price_order + parseInt(tickets.price)
                                    }
                                });
                            });
                        }
                    }
                }

                {{--var ticket_number = $('.chair-number').val();--}}
                {{----}}
                {{--if (ticket_number <= remaining_seats) {--}}
                {{--if (login) {--}}
                {{--var showtime_id = $('.ticket-final-sans').attr('data-id');--}}
                {{--ticket_number = $('.chair-number').val();--}}
                {{--$.ajax({--}}
                {{--url: "{{route('website/reserve/internal/chairless')}}",--}}
                {{--type: "POST",--}}
                {{--data: {--}}

                {{--_token: "{{ csrf_token() }}",--}}
                {{--showtime_id: showtime_id,--}}
                {{--ticket_number: ticket_number--}}
                {{--},--}}
                {{--statusCode: {--}}
                {{--410: function () {--}}
                {{--console.log("-1-1-1-1 WE GOT 404!");--}}
                {{--},--}}
                {{--200: function () {--}}
                {{--}--}}
                {{--}--}}

                {{--});--}}
                {{--console.log(local_ticket);--}}
                {{--localStorage.setItem('tickets', JSON.stringify(local_ticket));--}}
                {{--$('.order-f-price').text(final_price_order);--}}
                {{--$('.orders-back').html(order_re);--}}
                {{--if ($('.chair-number').val() == 0) {--}}
                {{--} else {--}}
                {{--$('.order-f-price').text($('.chiar-int-se-price').text());--}}

                {{--}--}}
                {{--} else {--}}
                {{--if ($('input.gust_num').val().length === 0 || $('input.gust_num').val().length < 11) {--}}
                {{--alert('شماره خود را وارد نمایید');--}}
                {{--} else {--}}
                {{--$('span.gust_num').text($('input.gust_num').val());--}}

                {{--var showtime_id = $('.ticket-final-sans').attr('data-id');--}}
                {{--var ticket_number = $('.chair-number').val();--}}
                {{--$.ajax({--}}
                {{--url: "{{route('website/reserve/internal/chairless')}}",--}}
                {{--type: "POST",--}}
                {{--data: {--}}

                {{--_token: "{{ csrf_token() }}",--}}
                {{--showtime_id: showtime_id,--}}
                {{--ticket_number: ticket_number,--}}
                {{--mobile: $('input.gust_num').val()--}}
                {{--},--}}
                {{--statusCode: {--}}
                {{--410: function () {--}}
                {{--console.log("-1-1-1-1 WE GOT 404!");--}}
                {{--},--}}
                {{--200: function () {--}}

                {{--},--}}
                {{--406: function () {--}}
                {{--console.log("-1-1-1-1 WE GOT 200!");--}}
                {{--}--}}
                {{--},--}}
                {{--success: function (data) {--}}
                {{--console.log(data);--}}
                {{--$('.loading-fa').fadeOut();--}}
                {{--res_ajax = data;--}}
                {{--orders = data;--}}
                {{--// alert(data.redirect_url);--}}

                {{--$('.loading-fa').fadeOut(1000);--}}
                {{--$('.buy-t-v').fadeOut();--}}
                {{--$('.ticket-review').fadeIn();--}}
                {{--$('.ticket-review').fadeIn();--}}

                {{--$('.auto-int').fadeIn(0);--}}
                {{--$('.auto-int').html(--}}
                {{--'<strong>تعداد صندلی :</strong>' +--}}
                {{--'<span>' + $('.chair-number').val() + '</span>' +--}}
                {{--'<strong>عدد</strong>'--}}
                {{--);--}}
                {{--},--}}
                {{--error: function (e) {--}}
                {{--// alert(e);--}}
                {{--}--}}
                {{--});--}}


                {{--}--}}

                {{--}--}}
                {{--} --}}
                {{--else {--}}
                {{--alert('تعداد صندلی انتخاب شده از ظرفیت باقی مانده بیشتر است');--}}

                {{--}--}}

            } else {
                if (login) {
                    if (source_id > 1) {

                        if ($('input.gust_num').val().length === 0 || $('input.gust_num').val().length < 11) {
                            alert('شماره خود را وارد نمایید');

                        } else {
                            $('.step4').addClass('act-st');
                            //$("html, body").animate({ scrollTop: $(document).height() - 300 }, 100);
                            $('span.gust_num').text($('input.gust_num').val());
                            $('.loading-fa').fadeIn();
                            $('.loading-fa').fadeOut(1000);
                            $('.buy-t-v').fadeOut();
                            $('.ticket-review').fadeIn();
                            $('.ticket-review').fadeIn();
                            order_re = '';
                            var Fsplit = finalData.seats.split(",")

                            $.ajax({
                                url: "{{route('website/reserve/'.($show->source_id == 1? 'internal' : 'external'))}}",
                                type: "POST",
                                data: {
                                    seats: seats_have,
                                    showtime_uid: showTimeuid,
                                    _token: "{{ csrf_token() }}"
                                },
                                statusCode: {
                                    410: function () {
                                        console.log("-1-1-1-1 WE GOT 404!");
                                    },
                                    200: function () {

                                    },
                                    406: function () {
                                        console.log("-1-1-1-1 WE GOT 200!");
                                    }
                                },
                                success: function (data) {
                                    res_ajax = data;
                                    // console.log(data);
                                },
                                error: function (e) {
                                    // alert(e);
                                }
                            });

                            jQuery.each(Fsplit, function (p, tick) {

                                order_re += ' <div class="one-ticket-re ">\n' +
                                    '<div class="uid_need" style="display: none"></div>                            ' +
                                    '<div class="colm-tickt clt-row">' + parseInt(parseInt(p) + 1) + '</div>\n' +
                                    '                            <div class="colm-tickt clt-radif">ردیف ' + Fsplit[p] + '</div>\n' +
                                    '                          ' +
                                    '                        </div>';


                            });
                            $('.order-f-price').text(finalData.total_price);
                            $('.orders-back').html(order_re);
                            $('.orders-back').addClass('tiwall_tick')
                        }

                    } else {
                        $('.timer_res').fadeIn();
                        var timer2 = "10:00";
                        var interval = setInterval(function () {
                            var timer = timer2.split(':');
                            var minutes = parseInt(timer[0], 10);
                            var seconds = parseInt(timer[1], 10);
                            --seconds;
                            minutes = (seconds < 0) ? --minutes : minutes;
                            if (minutes < 0) clearInterval(interval);
                            seconds = (seconds < 0) ? 59 : seconds;
                            seconds = (seconds < 10) ? '0' + seconds : seconds;
                            if (seconds == 0 && minutes == 0) {
                                $('.countdown').html('0:00');
                                $('.re_send').fadeIn();

                            } else {
                                timer2 = minutes + ':' + seconds;
                                $('.countdown').html(minutes + ':' + seconds);

                            }


                        }, 1000);

                        $('.step4').addClass('act-st');
                        // $("html, body").animate({ scrollTop: $(document).height() - 300 }, 100);
                        $('span.gust_num').text($('input.gust_num').val());
                        $('.loading-fa').fadeIn();
                        $('.loading-fa').fadeOut(1000);
                        $('.buy-t-v').fadeOut();
                        $('.ticket-review').fadeIn();
                        $.ajax({
                            url: "{{route('website/reserve/'.($show->source_id == 1? 'internal' : 'external'))}}",
                            type: "POST",
                            data: {
                                mobile: $('input.gust_num').val(),
                                ticket_uids: tickets_buy,
                                _token: "{{ csrf_token() }}"
                            },
                            statusCode: {
                                410: function () {
                                    console.log("-1-1-1-1 WE GOT 404!");
                                },
                                200: function () {

                                },
                                406: function () {
                                    console.log("-1-1-1-1 WE GOT 200!");
                                }
                            },
                            success: function (data) {
                                // console.log(data)
                                orders = data
                            },
                            error: function (e) {
                                // alert(e);
                            }
                        });

                        order_re = '';
                        final_price_order = 0;
                        jQuery.each(tickets_have, function (i, tickets) {
                            jQuery.each(tickets_buy, function (x, ticket) {
                                if (tickets.uid == ticket) {
                                    order_re += ' <div class="one-ticket-re">\n' +
                                        '<div class="uid_need" style="display: none">' + tickets.uid + '</div>                            ' +
                                        '<div class="colm-tickt clt-row">' + parseInt(x + 1) + '</div>\n' +
                                        '                            <div class="colm-tickt clt-place">' + tickets.ticket_info.zone + '</div>\n' +
                                        '                            <div class="colm-tickt clt-radif">ردیف ' + tickets.ticket_info.row + '</div>\n' +
                                        '                            <div class="colm-tickt clt-chair">صندلی ' + tickets.ticket_info.seat + '</div>\n' +
                                        '                            <div class="colm-tickt clt-price">' + tickets.price + '</div>\n' +
                                        '                            <div class="colm-tickt clt-pt">تومان</div>\n' +
                                        '                            \n' +
                                        '                        </div>';
                                    final_price_order = final_price_order + parseInt(tickets.price)
                                }
                            });
                        });
                        $('.order-f-price').text(final_price_order);
                        $('.orders-back').html(order_re);
                        //alert($('.chair-number').val());
                        if ($('.chair-number').val() == 0) {
                        } else {
                            $('.order-f-price').text($('.chiar-int-se-price').text());

                        }

                    }
                } else {
                    if (source_id > 1) {

                        if ($('input.gust_num').val().length === 0) {
                            alert('شماره خود را وارد نمایید');
                        } else {
                            $('.step4').addClass('act-st');
                            //  $("html, body").animate({ scrollTop: $(document).height() - 300 }, 100);
                            $('span.gust_num').text($('input.gust_num').val());
                            $('.loading-fa').fadeIn();
                            $('.loading-fa').fadeOut(1000);
                            $('.buy-t-v').fadeOut();
                            $('.ticket-review').fadeIn();
                            $('.ticket-review').fadeIn();
                            order_re = '';
                            var Fsplit = finalData.seats.split(",")

                            // alert(Fsplit)
                            jQuery.each(Fsplit, function (p, tick) {

                                order_re += ' <div class="one-ticket-re  ">\n' +
                                    '<div class="uid_need" style="display: none"></div>                            ' +
                                    '<div class="colm-tickt clt-row">' + parseInt(parseInt(p) + 1) + '</div>\n' +
                                    '                            <div class="colm-tickt clt-radif">ردیف ' + Fsplit[p] + '</div>\n' +
                                    '                          ' +
                                    '                        </div>';


                            });
                            $('.order-f-price').text(finalData.total_price);
                            $('.orders-back').html(order_re);
                            $('.orders-back').addClass('tiwall_tick')
                        }

                    } else {
                        if ($('input.gust_num').val().length === 0 || $('input.gust_num').val().length < 11) {
                            alert('شماره خود را وارد نمایید');

                        } else {
                            $('.step4').addClass('act-st');
                            //  $("html, body").animate({ scrollTop: $(document).height() - 300 }, 100);
                            $('span.gust_num').text($('input.gust_num').val());
                            $('.loading-fa').fadeIn();
                            $('.loading-fa').fadeOut(1000);
                            $('.buy-t-v').fadeOut();
                            $('.ticket-review').fadeIn();

                            order_re = '';
                            final_price_order = 0;
                            var local_ticket = [];
                            jQuery.each(tickets_have, function (i, tickets) {
                                jQuery.each(tickets_buy, function (x, ticket) {
                                    if (tickets.uid == ticket) {
                                        local_ticket.push(tickets);
                                        order_re += ' <div class="one-ticket-re">\n' +
                                            '<div class="uid_need" style="display: none">' + tickets.uid + '</div>' +
                                            '<div class="colm-tickt clt-row">' + parseInt(x + 1) + '</div>\n' +
                                            '<div class="colm-tickt clt-place">' + tickets.ticket_info.zone + '</div>\n' +
                                            '<div class="colm-tickt clt-radif">ردیف ' + tickets.ticket_info.row + '</div>\n' +
                                            '<div class="colm-tickt clt-chair">صندلی ' + tickets.ticket_info.seat + '</div>\n' +
                                            '<div class="colm-tickt clt-price">' + tickets.price + '</div>\n' +
                                            '<div class="colm-tickt clt-pt">تومان</div>\n' +
                                            '<div class="colm-tickt clt-deleat fa fa-close"></div>\n' +
                                            '</div>';
                                        final_price_order = final_price_order + parseInt(tickets.price)


                                    }
                                });

                            });
                            // console.log(local_ticket);
                            localStorage.setItem('tickets', JSON.stringify(local_ticket));
                            $('.order-f-price').text(final_price_order);
                            $('.orders-back').html(order_re);
                            if ($('.chair-number').val() == 0) {
                            } else {
                                $('.order-f-price').text($('.chiar-int-se-price').text());

                            }
                        }
                    }
                }
            }

        });

        $('.getway').click(function () {
            // if (auto_selection) {
            jQuery.each(orders, function (x, orduid) {
                order_uid = orders.uid;

            });

            if (login) {

                $('.loading-fa').fadeIn();
                if (source_id > 1) {

                    $.ajax({
                        url: "{{route('website/confirm/'.($show->source_id == 1? 'internal' : 'external'))}}" + '/' + res_ajax.uid,
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        statusCode: {
                            410: function () {
                                console.log("-1-1-1-1 WE GOT 404!");
                            },
                            200: function () {

                            },
                            406: function () {
                                console.log("-1-1-1-1 WE GOT 200!");
                            }
                        },
                        success: function (data) {
                            console.log(data);
                            $('.loading-fa').fadeOut();
                            // alert(data.redirect_url);
                            window.location.replace(data.redirect_url);
                        },
                        error: function (e) {
                            // alert(e);
                        }
                    });

                } else {


                    $('.loading-fa').fadeIn();
                    $.ajax({
                        url: "{{route('website/confirm/'.($show->source_id == 1? 'internal' : 'external'))}}" + "/" + order_uid,
                        type: "POST",
                        data: {

                            ticket_uids: tickets_buy,
                            _token: "{{ csrf_token() }}"
                        },
                        statusCode: {
                            410: function () {
                                console.log("-1-1-1-1 WE GOT 404!");
                            },
                            200: function () {

                            },
                            406: function () {
                                console.log("-1-1-1-1 WE GOT 200!");
                            }
                        },
                        success: function (data) {
                            // console.log(data);
                            //     alert(data.redirect_url);
                            $('.loading-fa').fadeOut();
                            window.location.replace(data.redirect_url);
                        },
                        error: function (e) {
                            console.log(e);

                        }
                    });
                }
            }
            else {
                if (source_id > 1) {

                    $('.loading-fa').fadeIn();
                    $.ajax({
                        url: "{{route('website/guest-reserve/'.($show->source_id == 1? 'internal' : 'external'))}}",
                        type: "POST",
                        data: {
                            mobile: $('input.gust_num').val(),
                            seats: seats_have,
                            showtime_uid: showTimeuid,
                            chairless: auto_selection,
                            _token: "{{ csrf_token() }}"
                        },
                        statusCode: {
                            410: function () {
                                console.log("-1-1-1-1 WE GOT 404!");
                            },
                            200: function () {

                            },
                            406: function () {
                                console.log("-1-1-1-1 WE GOT 200!");
                            }
                        },
                        success: function (data) {
                            // console.log(data);
                            $('.loading-fa').fadeOut();
                            //    alert(data.redirect_url);
                            window.location.replace(data.redirect_url);
                        },
                        error: function (e) {
                            alert(e);
                        }
                    });

                } else {

                    $('.loading-fa').fadeIn();
                    var showtime_id = $('.ticket-final-sans').attr('data-id');
                    var ticket_number = $('.chair-number').val();

                    $.ajax({
                        url: "{{route('website/guest-reserve/'.($show->source_id == 1? 'internal' : 'external'))}}",
                        type: "POST",
                        data: {
                            mobile: $('input.gust_num').val(),
                            showtime_id: showtime_id,
                            ticket_number: ticket_number,
                            ticket_uids: tickets_buy,
                            chairless: auto_selection,
                            _token: "{{ csrf_token() }}"
                        },
                        statusCode: {
                            410: function () {
                                console.log("-1-1-1-1 WE GOT 404!");
                            },
                            200: function () {

                            },
                            406: function () {
                                console.log("-1-1-1-1 WE GOT 200!");
                            }
                        },
                        success: function (data) {

                            // console.log(data);
                            $('.loading-fa').fadeOut();
                            //  alert(data.redirect_url);
                            window.location.replace(data.redirect_url);
                        },
                        error: function (e) {

                            console.log(e);
                        }
                    });
                }
            }


        });

        $("body").delegate(".choose-offer", "click", function () {
            var offer_code = $('.offer-code input ').val();
            var price = $('.order-f-price').text();
            var show_uid = "{{$show->uid}}";
            var showtime_id = $('.ticket-sans-checked').attr('data-id');


            $.ajax({
                url: "{{route('website/promotion')}}",
                type: "POST",
                data: {
                    promo_code: offer_code,
                    showtime_id: showtime_id,
                    show_uid: show_uid,
                    price: price,
                    _token: "{{ csrf_token() }}"
                },
                statusCode: {
                    410: function () {
                        console.log("-1-1-1-1 WE GOT 404!");
                    },
                    200: function () {


                    },
                    406: function () {
                        console.log("-1-1-1-1 WE GOT 200!");
                    }
                },
                success: function (data) {
                    // console.log(data);
                    $('.ok_offer').fadeIn();
                    $('.offer-code').html('        <strong class="ok_offer"></strong>\n' +
                        ' <input type="text" value="' +
                        +data.discount +
                        ' تومان تخفیف">\n' +
                        '<i class="fa fa-check"></i>');
                    // alert(data.final_price);
                    $('.offer-code b').fadeOut();
                },
                error: function (e) {
                    $('.offer-code b').fadeIn();
                }
            });

        });

        $("body").delegate(".back_to", "click", function () {
            $('.buy-row').fadeIn();
            $('.ticket-review').fadeOut();
            //$('.buyChair').fadeOut();

        });

        $("body").delegate(".clt-deleat", "click", function () {
            var deleat_order = $(this).parents('.one-ticket-re').find('.uid_need').text();
            var price_deleat = parseInt($(this).parents('.one-ticket-re').find('.clt-price').text());
            var price_show = parseInt($('.order-f-price').text());
            var f_p = price_show - price_deleat;
            $('.order-f-price').text(f_p);


            $(this).parents('.one-ticket-re').remove();
            jQuery.each(tickets_buy, function (index, ord) {
                if (ord == deleat_order) {


                    tickets_buy = tickets_buy.splice(index, 1);

                    // alert(tickets_buy)
                }
            });


        });
                @if(0)
        var local = localStorage;
        // console.log(localStorage);
        if (local.date) {

            $('.ticket-date').removeClass('ticket-date-checked');
            $('.' + local.date + '-date').addClass('ticket-date-checked');
            $('.sans-hide').fadeIn('');
        }
        if (local.sans) {
            $('.ticket-sans').removeClass('ticket-sans-checked');
            $('.' + local.sans).addClass('ticket-sans-checked');
            $('.buyPlace').fadeIn();
            //$('.loading-fa').fadeIn();
            $([document.documentElement, document.body]).animate({
                scrollTop: $(".buyPlace").offset().top
            }, 1000);
            $.ajax({
                url: "{{route('website/seatmap/'.($show->source_id == 1? 'internal' : 'external'))}}" + '/' + local.sans,
                success: function (result) {

                    if (source_id > 1) {
                        $('.step3').addClass('act-st');
                        $([document.documentElement, document.body]).animate({
                            scrollTop: $("#buy_ch_scroll").offset().top
                        }, 1000);
                        $('.buyPlace .r-tit').text('لطفا جایگاه و صندلی های مورد نظر خود را انتخاب کنید.');
                        $('.ex-p').fadeIn();
                        $('.buyFinal').fadeIn();
                        $('.buyChair').fadeOut();
                        $('.loading-fa').fadeOut();
                        $('.plan-img-fa').css({'float': 'none', 'margin-left': '0'});
                        $('.plan-img-fa').html(result.data.html);
                        $('.style').html(result.data.css);
                        var tabs_id = '';
                        var tabs_title = '';


                        $(".tabs_tiwall").html('');
                        jQuery.each(result.data.sections, function (index, ord) {
                            tabs_id = result.data.sections[index].id;
                            tabs_title = result.data.sections[index].title;

                            if (index == 0) {
                                $(".tabs_tiwall").append('<span class="' + tabs_id + ' active_tiwall">' + tabs_title + '</span>');
                            } else {
                                $(".tabs_tiwall").append('<span class="' + tabs_id + ' ">' + tabs_title + '</span>');
                            }


                        });
                        // console.log(result.data.sections);
                        //console.log(result.data.section);

                    } else {


                        tickets_have = [];
                        $(".price-cat").html("<strong class='p-pin-all'>همه</strong>");
                        var data = result;


                        var chairHtml = "";

                        for (i = 0; i < data.zones.length; i++) {
                            chairHtml += '<div class="place_fa place_fa_' + i + '">';
                            jQuery.each(data.zones[i].rows, function (i, row) {
                                chairHtml += '<div class="chair-row-tick " id="' + row.id + '"  ><div class="rowid">' + row.row + '.</div>';
                                jQuery.each(row.seats, function (i, seat) {
                                    var thisPrice = '';
                                    if (seat.tickets[0].price == 0) {
                                        thisPrice = 'غیرقابل فروش';
                                    } else {
                                        thisPrice = seat.tickets[0].price + ' تومان ';
                                    }

                                    tickets_have.push(seat.tickets[0]);
                                    chairHtml += '<span pcf="' + seat.tickets[0].price + '" uidTick="' + seat.tickets[0].uid + '" class="ticket-chair ticket-buy ticket-' + seat.tickets[0].status + '" style="margin-left: ' + parseFloat(parseFloat(seat.space_to_left) * (25 + 6) + 3) + 'px; margin-right: ' + parseFloat(parseFloat(seat.space_to_right) * (25 + 6) + 3) + 'px "><i>' + thisPrice + '</i>' + seat.column + '</span>'
                                });
                                chairHtml += '</div>';

                            });
                            chairHtml += '</div>';
                        }

                        $('.chair-list').html(chairHtml);


                        jQuery.each(data.price_classes, function (i, val) {
                            $(".price-cat").append("<strong class='pc-" + val + "'>  " + val + " تومان</strong>");
                        });
                        $('.plan-img-c').attr('src', data.zones[0].zone.plan.image_url);
                        jQuery.each(data.zones, function (i, zone) {
                            var price_classes = "";
                            jQuery.each(zone.price_classes, function (i, pc) {
                                price_classes += " pc-" + pc;
                            });
                            $(".plan-img-fa").append('<span id="' + i + '" class="' + price_classes + ' p-pin ' + price_classes + 'cu cu-class" style="left: ' + zone.zone.x * 100 + '% ;top: ' + zone.zone.y * 100 + '%;">' + zone.remaining + '<br>' + 'صندلی' + ' </span>');
                        });

                        $("body").delegate(".p-pin", "click", function () {


                            $('.step3').addClass('act-st');

                            if ($(this).hasClass('act_p_click')) {

                                $(this).removeClass('act_p_click');
                            } else {
                                $('.act_p_click').removeClass('act_p_click');
                                $(this).addClass('act_p_click');

                                var s_active = $(this).attr('id');
                                localStorage.setItem('pinp', s_active[0]);
                            }

                            var pin_id = $(this).attr('id');
                            $('.place_fa').fadeOut(0);
                            $('.place_fa_' + pin_id).fadeIn(0);
                            $('.buyChair').fadeIn();
                            $('.buyFinal').fadeIn();
                            $([document.documentElement, document.body]).animate({
                                scrollTop: $(".buyChair").offset().top
                            }, 1000);


                        });
                    }
                }

            });
        }

        if (local.mobile) {
            $('input.gust_num').val(local.mobile);
            $('span.gust_num').text(local.mobile);
        }

        if (local.pin) {
            $('.buyChair').fadeIn(0);
            $('.loading-fa').fadeIn(0);

            function explode() {
                $('.place_fa_' + local.pinp).fadeIn(0);
                $('.' + local.pin).addClass('active-pin');
                $('.buyFinal').fadeIn(0);
                // $('.cu-class').fadeOut(0);
                // $('.'+local.pinp+'cu').fadeIn(0);
                // $('.'+local.pinp+'cu').addClass('act_p_click');


                if (local.tickets) {
                    $('.buy-row').fadeOut(0);
                    $('.ticket-review').fadeIn();
                    $('.loading-fa').fadeOut(1000);
                }
                $('.loading-fa').fadeOut(1000);
                var json_tickets = JSON.parse(local.tickets);

                $('.f_re_date').text($('.ticket-sans-checked').text());
                $('.f_re_sans').text($('.ticket-date-checked').text());
                jQuery.each(json_tickets, function (x, tickets) {
                    order_re += ' <div class="one-ticket-re">\n' +
                        '<div class="uid_need" style="display: none">' + tickets.uid + '</div>' +
                        '<div class="colm-tickt clt-row">' + parseInt(x + 1) + '</div>\n' +
                        '<div class="colm-tickt clt-place">' + tickets.ticket_info.zone + '</div>\n' +
                        '<div class="colm-tickt clt-radif">ردیف ' + tickets.ticket_info.row + '</div>\n' +
                        '<div class="colm-tickt clt-chair">صندلی ' + tickets.ticket_info.seat + '</div>\n' +
                        '<div class="colm-tickt clt-price">' + tickets.price + '</div>\n' +
                        '<div class="colm-tickt clt-pt">تومان</div>\n' +
                        '<div class="colm-tickt clt-deleat fa fa-close"></div>\n' +
                        '</div>';
                    final_price_order = final_price_order + parseInt(tickets.price)
                });


                $('.order-f-price').text(final_price_order);
                $('.orders-back').html(order_re);
            }

            setTimeout(explode, 2000);
        }


        @endif


    </script>
    <style>
        /*#hall{*/
        /*width: 100% !important;*/
        /*padding: 0!important;*/
        /*}*/
        /*@media screen and (max-width: 800px) {*/
        /*h6.scene {*/
        /*width: 100% !important;*/
        /*}*/
        /*#hall .row{*/
        /*margin-right: -15px !important;*/
        /*margin-left: -15px !important;*/
        /*}*/
        /*}*/

    </style>

@stop
