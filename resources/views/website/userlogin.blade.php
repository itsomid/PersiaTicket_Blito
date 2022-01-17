<div class="loading-fa">
    <div class="pop-loading">
    <span><div class="bounce_1"></div>
    <div class="bounce_2"></div>
    <div class="bounce_3"></div></span></div>
</div>
<div class="pop-window" >
    <div class="popup">

        <span class="fa fa-close pop-close"></span>

        <div  class="form-gp">
            <form id="get_code" class="active-phone none">
                <strong class="popTit"><i class="fa fa-check-square-o "></i>تایید شماره همراه </strong>
                <label class="lg-pop">لطفا کد تایید که به شماره <strong class="your_num"></strong> پیامک شده است را وارد نمایید.</label>
                {!! Recaptcha::render() !!}
                <input type="text" name="" placeholder="*****" class="code" style="text-align: center;direction: ltr" >
                <div class="lg-pop error-pop">کد وارد شده اشتباه است</div>
                <span  class="set_user_info" > ثبت </span>
                <span class="btn-g-r change-num">تغییر شماره همراه</span>
                <span class="btn-g-r send_again">دریافت مجدد</span>
            </form>








            <form id="get_phone" class="get-num none">
                <strong class="popTit"><i class="fa fa-user-circle-o "></i>حساب کاربری</strong>
                <label class="lg-pop">لطفا شماره همراه خود را برای دریافت کد تایید وارد نمایید.</label>

                <input type="text" name="" class="user_number" value="09" style="text-align: center;direction: ltr"   >


                <div class="lg-pop error-pop num_w">شماره وارد شده اشتباه است</div>

                <span  class="send-code">ورود</span>
            </form>




            <form class="f-register none">
                <strong class="popTit"><i class="fa fa-smile-o "></i> ثبت نام</strong>
                <label>نام</label>
                <input type="text" name="first_name" class="first_name">
                <label>نام خانوادگی</label>
                <input type="text" name="last_name" class="last_name">
                <label>ایمیل</label>
                <input type="email" name="email" class="email" required >
                <div class="lg-pop error-pop num_w email_em">ایمیل نمی تواند خالی باشد</div>
                <span class="final_reg">ثبت</span>
            </form>


        </div>
    </div>

</div>
<script type="text/javascript">
    $(document).ready(function () {
        var is_new = true ;


        $('.send_again').click(function () {
            var u_num = $('.user_number').val();

            $.ajax({
                url: "{{route('website/login')}}",
                type: "POST",
                data: {
                    mobile : u_num,
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
                    $('.your_num').text(u_num)
                    $('.error-pop').fadeIn();
                    $('.error-pop').text('مجددا ارسال شد');
                    $('.error-pop').css({'color':'#15a33d !important'});
                    console.log(data.is_new);
                    is_new = data.is_new;
                    $('.none').fadeOut(0);
                    $(this).parents('.get-num').fadeOut(0);
                    $('.active-phone').fadeIn();

                },
                error: function (e) {

                }
            });

        });





        $('.final_reg').click(function () {
            var u_num = $('.user_number').val();
            var first_name = $('.first_name').val();
            var last_name = $('.last_name').val();
            var email = $('.email').val();
if (email == "") {
$('.email_em').fadeIn();
}else{
            $.ajax({
                url: "{{route('website/profile/new')}}",
                type: "POST",
                data: {

                    mobile :u_num,
                    first_name : first_name ,
                    last_name : last_name,
                    email : email ,
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

                    $('.none').fadeOut(0);

                    $('.form-gp').html('ثبت شد');
                    location.reload();


                },
                error: function (e) {
                    $('.error-pop').fadeIn();
                }
            });
        }
        });

        ////******* Get Code *******////

        $('.set_user_info').click(function () {
            var u_num = $('.user_number').val();
            var code = $('.code').val();

            $.ajax({
                url: "{{route('website/login/continue')}}",
                type: "POST",
                data: {
                    code : code,
                    mobile :u_num,
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
                    $('.none').fadeOut(0);
                    $('.pop-window').fadeIn();
                    if (is_new){
                        $('.f-register').fadeIn();
                    }else {
                        $('.form-gp').html('وارد شدید');
                        location.reload();
                    }
                    console.log(data);
                },
                error: function (e) {
                    $('.error-pop').fadeIn();
                }
            });

        });
        $('#get_code').keydown(function (evt) {

            if (evt.keyCode == 13) {
                var u_num = $('.user_number').val();
                var code = $('.code').val();
                $.ajax({
                    url: "{{route('website/login/continue')}}",
                    type: "POST",
                    data: {
                        code : code,
                        mobile :u_num,
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
                        $('.none').fadeOut(0);
                        $('.pop-window').fadeIn();
                        if (is_new){
                            $('.f-register').fadeIn();
                        }else {
                            $('.form-gp').html('وارد شدید');

                            location.reload();
                        }
                        console.log(data);

                    },
                    error: function (e) {
                        ('.error-pop').fadeIn();
                    }

                });
            }
        });
        $('.m-singin').click(function () {
            $('.none').fadeOut(0);
            $('.pop-window').fadeIn();
            $('.get-num').fadeIn();
        });

        $('.pop-close').click(function () {
            $(this).parents('.pop-window').fadeOut();
        });

        ////******* Get phone *******////
        $('.send-code').click(function () {



           $('.loading-fa').fadeIn();
            var u_num = $('.user_number').val();
            $.ajax({
                url: "{{route('website/login')}}",
                type: "POST",
                data: {
                    mobile: u_num,
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
                    $('.loading-fa').fadeOut();
                    $('.your_num').text(u_num)
                    $('.error-pop').fadeOut();
                    console.log(data.is_new);
                    is_new = data.is_new;
                    $('.none').fadeOut(0);
                    $(this).parents('.get-num').fadeOut(0);
                    $('.active-phone').fadeIn();

                },
                error: function (e) {
                    $('.loading-fa').fadeOut();
                        $('.num_w').fadeIn()
                }
            });
        });



        $('.change-num').click(function () {
            $(this).parents('.active-phone').fadeOut(0);
            $('.send-code').parents('.get-num').fadeIn(0);
        });


    });


</script>