@extends('landing.master')
@section('header')
          | بلیتو    {{$show->title}}
@endsection
@section('content')

    <div class="event-single" >
        @if(0)
        <img src="{{$show->main_image_url}}" class="bg-event" >

        <div class="timeline-ev">
            <a href="{{route('website/home')}}">برنامه‌ها</a>

            <span class="ev-name">{{$show->title}}</span>
        </div>
        @endif

        <div class="event-info">
            <img src="{{$show->thumb_url}}" >
            <div class="info-data">
                {{--<h1>{{$show->title}}</h1>--}}
                @if(\Auth::check())
                    @if(in_array($show->uid,$favorite_uid))
                        <strong>{{$show->title}}<i class="like_i fa fa-heart"></i></strong>
                    @else
                        <strong>{{$show->title}}<i class="like_i fa fa-heart-o"></i></strong>
                    @endif
                @endif
                @if($show->from_date == $show->to_date)
                    <span class="h-date"> {{\SeebBlade::prettyDateWithFormat($show->from_date,'d MMM')}}</span>

                @else
                    <span class="h-date"> {{\SeebBlade::prettyDateWithFormat($show->from_date,'d MMM')}} تا {{\SeebBlade::prettyDateWithFormat($show->to_date,'d MMM ')}}</span>
                @endif

                <span class="scene-name">{{$show->scene["name"]}}</span>

                <a class="s-buy" href="{{ route('website/get/store',['uid'=>$show->uid]) }}">خرید بلیت</a>

            </div>
        </div>

        <div class="ev-dir min-event-content">
            <div class="ev_content">
                {!!  $show->description !!}
            </div>

        </div>
    </div>


    <script type="text/javascript">

        $(document).ready(function () {

            var show_uid = "{{$show->uid}}";
            $('.like_i').click(function () {
                if ($(this).hasClass( "fa-heart-o" )){

                    $.ajax({
                        url: "{{route('website/favorite')}}",
                        type: "post",
                        data: {
                            show_uid: show_uid,
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

                            $('.like_i').removeClass('fa-heart-o');
                            $('.like_i').addClass('fa-heart');
                        },
                        error: function (e) {

                        }
                    });

                }else {

                    $.ajax({
                        url: "{{route('website/favorite/dislike',['uid' => $show->uid])}}",
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
                            $('.like_i').removeClass('fa-heart');
                            $('.like_i').addClass('fa-heart-o');
                        },
                        error: function
                            (e) {

                        }
                    });


                }
            });


        })

    </script>
@stop