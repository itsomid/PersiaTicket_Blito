<!DOCTYPE html>
<html>

@include('panel.layouts.header')

<body class="gray-bg rtls">

<div class="middle-box text-center loginscreen animated fadeInDown">

    <div>
        <div>

            <h1 class="logo-name">بیلتو</h1>

        </div>
        <h3>بازنشانی گذرواژه</h3>
        <p>برای بازنشانی گذرواژه، ایمیل خود و گذرواژه جدید خود را وارد نمایید
        </p>
        <form class="m-t" role="form" method="post" action="{{ url('/password/reset') }}">
            {{ csrf_field() }}

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                <label for="email" class="control-label">آدرس ایمیل:</label>
                <input type="email" name="email" dir="ltr" class="form-control" placeholder="آدرس ایمیل" value="{{ old('email') }}" required autofocus>
                @if ($errors->has('email'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
                <label for="password" class="control-label">رمز عبور جدید:</label>
                <input type="password" name="password" dir="ltr" class="form-control" required autofocus>
                @if ($errors->has('password'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="form-group {{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                <label for="password_confirmation" class="control-label">تکرار رمز عبور جدید:</label>
                <input type="password" name="password_confirmation" dir="ltr" class="form-control" required autofocus>
                @if ($errors->has('password_confirmation'))
                    <span class="help-block">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                    </span>
                @endif
            </div>
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            <button type="submit" class="btn btn-primary block full-width m-b">ذخیره</button>

        </form>
    </div>
</div>

<!-- Mainly scripts -->
<script src="/seeb-pnl/js/jquery-2.1.1.js"></script>
<script src="/seeb-pnl/js/bootstrap.min.js"></script>




</body>

</html>





