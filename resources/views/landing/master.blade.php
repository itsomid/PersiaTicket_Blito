<!doctype html>
<html lang="en" >
<head>
    <title>@yield('header')</title>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="manifest" href="site.webmanifest">
    <link rel="apple-touch-icon" href="icon.png">
    <link rel="stylesheet" type="text/css" href="/website/css/bootstrap.min.css ">
    <link href="/website/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/website/css/style.css">
    <link rel="stylesheet" href="/website/css/main.css">
    <meta name="enamad" content="197672"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>window.jQuery || document.write('<script src={{asset('website/js/vendor/jquery-3.2.1.min.js')}}><\/script>')</script>
    <script src="/website/js/plugins.js"></script>
    <script src="/website/js/main.js"></script>
    <script src="/website/js/bootstrap.min.js"></script>
    <script src="/website/js/jquery.session.js"></script>

    <script>




        $(document).on('click','#select',function(){
            $('#myModal').modal();

        });


        $(document).on('click','.option',function(){

            var option_text = $(this).text();

            $('#selected').text(option_text).val(option_text);
            $('.city-se strong').text(option_text);
            $('#myModal').modal('hide');
        });


        $(document).on('click','#select',function(){
            $('#myModal').fadeIn();

        });


        $(document).on('click','.option',function(){
            var option_text = $(this).text();
            $('#selected').text(option_text).val($(this).attr('data'));
            var nafise = option_text + '<i class="fa fa-angle-down"></i>' ;
            $('.city-se strong').html(nafise);
            $('#myModal').fadeOut('');
            var cityID = $(this).attr('data') ;


            $.ajax({

                url: "{{route('website/home/city')}}",
                type: "post",
                data: {
                    id: cityID,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                dataType: "json",

                statusCode: {
                    410: function () {
                        console.log("-1-1-1-1 WE GOT 404!");
                    },
                    200: function () {
                        console.log('200')
                    },
                    406: function () {
                        console.log("-1-1-1-1 WE GOT 200!");
                    }
                },
                success: function (data) {
                    console.log(data);

                },
                error: function (response) {
//                    alert('Error'+response);
                }
            });

            location.reload();
        });

    </script>

</head>

<body style="background-color: #f8f8f8;">
@include('landing.nav')
<div >
    @yield('content')
</div>


@include('landing.footer')
</body>
</html>