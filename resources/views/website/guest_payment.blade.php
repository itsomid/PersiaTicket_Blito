@extends('landing.master')
@section('header')
قوانین بلیتو
@endsection
@section('content')


    <div class="gust_buy_ticket">
        <div class="form_g">
            <div class="g_send_al">کد فعال سازی برای شما ارسال شده</div>
            <p>{{$mobile}}</p>
<div class="al_div">

    <strong class="al_g ture_g">با موفقیت فعال شد</strong>
    <strong class="al_g false_g">کد وارد شده اشتباه است</strong>

</div>

                <input type="text" maxlength="5" class="g_code" name="">
            <span class="active_g_num" >تایید</span> <span   class="re">ارسال مجدد</span>

        </div>

    </div>


    <script>

            $.ajax({
                url: "{{route('website/login')}}",
                type: "POST",
                data: {
                    mobile : '{{$mobile}}',
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


                },
                error: function (e) {

                }
            });

            $('.active_g_num').click(function () {
                var g_code = $('.g_code').val() ;
                $.ajax({
                    url: "{{route('website/login/continue')}}",
                    type: "POST",
                    data: {
                        code : g_code ,
                        mobile : '{{$mobile}}',
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
                        },
                        400: function () {

                        }
                    },
                    success: function (data) {
                        $('.al_g').fadeOut(0);
                        $('.ture_g').fadeIn();
                        location.reload();
                    },
                    error: function (e) {
                        $('.al_g').fadeOut(0);
                        $('.false_g').fadeIn();
                    }
                });
            });





            $('.re').click(function () {
                $.ajax({
                    url: "{{route('website/login')}}",
                    type: "POST",
                    data: {
                        mobile : '{{$mobile}}',
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

                        $('.al_g').fadeOut(0);
                        $('.ture_g').text('ارسال شد')
                        $('.ture_g').fadeIn();
                    },
                    error: function (e) {
                        $('.al_g').fadeOut(0);
                        $('.false_g').text('خطا در ارسال')
                        $('.false_g').fadeIn();
                    }
                });
            });


    </script>

@endsection