<!DOCTYPE html>
<html>

@include('panel.layouts.header')

<body class="gray-bg rtls">

<div class="middle-box text-center loginscreen animated fadeInDown">

    <div>
        <div>

            <h1 class="logo-name">بلیتو</h1>

        </div>
        <h3>فراموشی گذرواژه</h3>
        <p>برای بازنشانی رمز عبور، ایمیل خود را وارد نمایید
        </p>
        <form class="m-t" role="form" method="post" action="{{ url('/password/email') }}">
            {{ csrf_field() }}
            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <input type="email" name="email" dir="ltr" class="form-control" placeholder="آدرس ایمیل" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <button type="submit" class="btn btn-primary block full-width m-b">ارسال ایمیل</button>

        </form>
    </div>
</div>

<!-- Mainly scripts -->
<script src="/seeb-pnl/js/jquery-2.1.1.js"></script>
<script src="/seeb-pnl/js/bootstrap.min.js"></script>




</body>

</html>





