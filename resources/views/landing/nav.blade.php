@include('website.userlogin')
<header>
    <menu>

        <div class="m-logo">
            <a href="{{route('website/home')}}">

                <img src="{{asset('/website/img/logo.svg')}}" class="logo_small"/>

            </a>
        </div>
        @if(\Auth::check() == false)
            <div class="m-login">
                <a href="#" class="m-register m-singin"> ورود / عضویت </a>

            </div>
        @endif
        @if(\Auth::check())
        <div class="iflogin">
            @if(\Auth::user()->fullName() == " ")
                <div class="pro_link" >
                    @if(is_null(\Auth::user()->avatar_url))
                        <img src="/website/img/login.png" />
                    @else
                        <img src="{{\Auth::user()->avatar_url}}">
                    @endif
                    <span>{{ \Auth::user()->mobile }}</span>
                @else
            <div class="pro_link" >
                @if(is_null(\Auth::user()->avatar_url))
                    <img src="/website/img/login.png" />
                @else
                    <img src="{{\Auth::user()->avatar_url}}">
                @endif

                @endif
            <div class="m_op">
                    <a  href="{{route('website/profile')}}"  >پروفایل</a>
                <a href="{{route('website/logout')}}"  >خروج</a>
            </div>
            </div>

        </div>
        @endif
            @if(0)
            <div class="search-div">
                @if(session('cityid')== null)
                    <?php $city_name = ""?>
                @elseif(session('cityid')== 1)
                    <?php $city_name = "تهران"?>
                @elseif(session('cityid')== 2)
                    <?php $city_name = "اصفهان"?>
                @elseif(session('cityid')== 3)
                    <?php $city_name = "شیراز"?>
                @endif
                <input class="search-input" type="text" id="search" placeholder="نام برنامه یا هنرمند را در {{$city_name}} جستجو کنید"/></input>
                <div class="search_res">
                </div>
                <span class="search-icon"></span>

            </div>
            @endif

    </menu>
</header>

<script type="text/javascript">

    $("#search").focusin(function(){
       $('.search_res').fadeIn(0);
    });
    $("#search").focusout(function(){
       $('.search_res').fadeOut("slow");
    });


    $('#search').on('keyup',function(){

        $value = $(this).val();

        $.ajax({

            type : 'get',

            url : "{{route('website/search')}}",

            data:{'search':$value},

            success:function(data){

                if (data == 0){
                    $('.search_res').text('موردی یافت نشد')

                }else {
                    $('.search_res').html(data);
                }
            }

        });



    })

</script>

<script type="text/javascript">

    $.ajaxSetup({ headers: { 'csrftoken' : '{{ csrf_token() }}' } });

</script>

