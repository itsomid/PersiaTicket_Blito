@extends('landing.master')
@section('header')
    بلیتو
@endsection
@section('content')
    @if(session('cityid')== null)
        {{ session()->put('cityid','1') }}

    @endif
    {{--@if(!is_null($cover))--}}
        {{--<div class="slider" style="background: url('{{$cover->main_image_url}}');background-size: 100% 50vh;    background-repeat: no-repeat;">--}}
            {{--<div class="item">--}}

                {{--<div class="s-title">{{$cover->title}}<strong>--}}
                        {{--@if($cover->from_date == $cover->to_date)--}}
                            {{--<span class="h-date" style="display: none"> {{\SeebBlade::prettyDateWithFormat($cover->from_date,'d MMM')}}</span>--}}
                        {{--@else--}}
                            {{--<span class="h-date" style="display: none"> {{\SeebBlade::prettyDateWithFormat($cover->from_date,'d MMM')}}--}}
                                {{--تا {{\SeebBlade::prettyDateWithFormat($cover->to_date,'d MMM ')}}</span>--}}
                        {{--@endif--}}
                    {{--</strong>--}}
                {{--</div>--}}
                {{--<div class="slider-btn">--}}
                    {{--<a href="{{ route('website/get/show',['uid'=>$cover->uid]) }}" class="s-buy">خرید بلیت</a></div>--}}
                {{--</div>--}}

            {{--</div>--}}
            {{--@endif--}}


        <div class="slider" style="background-color: #000;">
            <img alt="blito" src="/images/blito-cover2.jpg" style="width: 70%">
            {{--<div class="item">--}}

                {{--<div class="s-title">#بی_برنامه_نمونید<strong>--}}

                    {{--</strong>--}}
                {{--</div>--}}
                {{--<div class="slider-btn">--}}
                {{--</div>--}}
            {{--</div>--}}

        </div>

            @if (session('login'))
                <script>
                    $('.m-singin').ready(function () {
                        $('.none').fadeOut(0);
                        $('.pop-window').fadeIn();
                        $('.get-num').fadeIn();
                    });
                </script>
            @endif

            @if(0)
                <div class="shows-fliter">
                    <strong>برنامه‌های شهر</strong>

                    <div class="city-se"><strong>
                            @if(session('cityid')== null)شهر
                            @elseif(session('cityid')== 1)تهران
                            @elseif(session('cityid')== 2)اصفهان
                            @elseif(session('cityid')== 3)شیراز
                            @endif
                            <i class="fa fa-angle-down"></i></strong>
                    </div>


                    <Select name="select" id="sss" readonly class="selcet-city">
                        <option id="selected" value="1" selected>شهر مورد نظر</option>
                    </Select>

                    <div id="select" style="position:absolute; left:45%; right:45%; top:0px; bottom:0;"></div>

                    <div id="myModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">شهر مورد نظر خود را انتخاب کنید</h4>
                                </div>
                                <div class="modal-body">
                                    @foreach($cities as $city)
                                        <div class="btn btn-primary option" data="{{$city->id}}">{{$city->name}}</div>

                                    @endforeach
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">بستن</button>
                                </div>

                            </div>
                        </div>
                    </div>

                </div>



            @endif


            <div class="container">
                <div class="home-shows ">

                        <div class="shows-tab">
                         <span class="all active">همه</span>
                            @foreach($categoryhasgenre as $category)
                                <span class="{{$category->id}}">{{$category->name}}</span>
                            @endforeach
                        </div>
                        {{--<div class="tags_sh_fa">--}}
                            {{--<span class="show_wl_tags ">فیلتر<i class="fa fa-filter"></i></span>--}}
                        {{--</div>--}}
                        <div class="tags">

                            @foreach($categoryhasgenre as $category)
                                @foreach($category->genres as $genre)
                                    <span class="genre_{{$genre->id}} {{$category->id}} ">{{$genre->title}}</span>
                                @endforeach
                            @endforeach

                        </div>

                        @if(session('cityid') == null)
                            لطفا شهر را انتخاب کنید.
                        @endif


                        <div class="shows_empty noalert-w">
                            <img src="/website/img/no/noEvent.png" class="alert_img">
                            <span>   برنامه ای جهت نمایش وجود ندارد</span>
                        </div>

                    @foreach($shows as $show)

                        {{--@if($show->city_id == session('cityid'))--}}

                        <a
                                @if($show->ticket_status == "none" || $show->ticket_status == "renewed")
                                href="{{ route('website/get/show',['uid'=>$show->uid]) }}"
                                @else
                                href="#"
                                @endif
                                class="h-show
                   <?php
                                foreach ($showhasgenres as $showhasgenre)
                                    if ($show->title == $showhasgenre->title) {
                                        foreach ($showhasgenre->genres as $genre)
                                            echo "genre_" . $genre->pivot->genre_id . " ";
                                    }

                                ?> {{ $show->category_id }}
                                @if($show->ticket_status == "none")
                                @elseif($show->ticket_status == "renewed")
                                        renew
@elseif($show->ticket_status == "soon")
                                        soon
@elseif($show->ticket_status == "sold_out")
                                        soldout
@endif
                                        "
                                style="background:
                                @if($show->background_color != null)
                                        #{{$show->background_color }}
                                @else
                                        #ccc
                                @endif
                                        ">

                            <div class="show-details">
                                <div class="show_img">
                                    <div style="background: url('{{$show->thumb_url}}') no-repeat; "></div>

                                </div>
                                {{--<img src="{{$show->thumb_url}}" class="show_img">--}}
                                <div class="show-details-txt">

                                    <div style="display: flex; align-items: center;     flex-direction: row-reverse;     justify-content: space-around;">
                                        <strong>
                                            {{--<i class="fa map-pin"></i>--}}
                                            ︎{{ $show->scene["name"] }}
                                        </strong>
                                        @if($show->from_date == $show->to_date)
                                            <span class="h-date"> {{\SeebBlade::prettyDateWithFormat($show->from_date,'d MMM')}}</span>
                                        @else
                                            <span class="h-date" > {{\SeebBlade::prettyDateWithFormat($show->from_date,'d MMM')}}
                                تا {{\SeebBlade::prettyDateWithFormat($show->to_date,'d MMM ')}}</span>
                                        @endif

                                    </div>

                                    <span class="h-name">{{$show->title}}</span>

                                    <span href="#" class="btn btn-persia tick_show_buy">خرید بلیط</span>
                                </div>
                            </div>
                            {{--<span class="bg_show"></span>--}}
                        </a>
                        {{--@endif--}}

                    @endforeach
                </div>
                {{--<div class="text-center">--}}
                {{--{{$shows->links()}}--}}
                {{--</div>--}}

            </div>


@stop