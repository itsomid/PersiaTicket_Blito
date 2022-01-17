@include('panel.layouts.header')
<style>body {background: #ffffff}</style>
    <div class="middle-box text-center loginscreen animated fadeInDown">
        <div>
            <div>

                <h1 class="logo-name"><img src="{{asset('/website/img/logo_dark.svg')}}"></h1>

            </div>
            <h3>پنل مدیریت</h3>

            <form method="post" class="m-t" role="form" action="{{route('panel/login')}}">
                {{ csrf_field() }}
                <div class="form-group"  >
                    <input type="email" name="email" class="form-control" placeholder="نام کاربری" required="">
                {{--@if ($errors->has('email'))--}}
                    {{--<span class="help-block">--}}
                          {{--<strong>{{ $errors->first('email') }}</strong>--}}
                    {{--</span>--}}
                {{--@endif--}}
                </div>
                <div class="form-group" >
                    <input type="password" name="password" class="form-control" placeholder="رمز عبور" required="">
                    {{--@if ($errors->has('password'))--}}
                        {{--<span class="help-block">--}}
                                        {{--<strong>{{ $errors->first('password') }}</strong>--}}
                    {{--</span>--}}
                    {{--@endif--}}
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">ورود</button>

                @if(false)
                <a href="{{ route('password.request') }}"><small>بازیابی رمز عبور</small></a>
                @endif
                <br><br>

            </form>
            <p class="m-t"> <small></small> </p>
        </div>
    </div>

</div>
