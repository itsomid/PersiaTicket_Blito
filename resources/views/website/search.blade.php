@extends('landing.master')
@section('header')
    Home Page
@endsection
@section('content')


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


        <Select name="select" id="sss"  readonly  class="selcet-city">
            <option id="selected"  value="1"  selected>شهر مورد نظر</option>
        </Select>

        <div id="select" style="position:absolute; left:0; right:0; top:0px; bottom:0;"></div>

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







    <div class="home-shows">
        <div class="shows-tab">
            <span class="all active">همه</span>
            @foreach($categories as $category)
                <span class="{{$category->slug}}" >{{$category->name}}</span>
            @endforeach
        </div>

<div class="tags">
    <strong>فیلتر:</strong>
    @foreach($genres as $genre)
    <span class="genre_{{$genre->id}}" >{{$genre->title}}</span>
        @endforeach

</div>

        @if(session('cityid') == null)
            لطفا شهر را انتخاب کنید.

        @elseif(session('cityid')=='1')
                @foreach($categories as $category)
                    @foreach($category->shows as $show)
                        @if($show->city_id == 1)
                            <a href="{{ route('website/get/show',['uid'=>$show->uid]) }}"
                               class="h-show {{ $category->slug }}
                                       <?php
                                          foreach ($showhasgenres as $showhasgenre)
                                              if ($show->title == $showhasgenre->title ){
                                                      foreach ($showhasgenre->genres as $genre)
                                                      echo "genre_".$genre->pivot->genre_id." " ;
                                                  }


                                       ?>">
                                <img src="{{$show->thumb_url}}">
                                <div>
                                    <span class="h-name">{{$show->title}}</span>
                                    <strong>{{ $show->scene["name"] }}<i class="fa map-pin"></i> </strong>

                                    @if($show->from_date == $show->to_date)
                                        <span class="h-date"> {{\SeebBlade::prettyDateWithFormat($show->from_date,'d MMM')}}</span>
                                    @else
                                        <span class="h-date"> {{\SeebBlade::prettyDateWithFormat($show->from_date,'d MMM')}} تا {{\SeebBlade::prettyDateWithFormat($show->to_date,'d MMM ')}}</span>
                                    @endif
                                </div>
                            </a>
                        @endif
                    @endforeach
                @endforeach

                @elseif(session('cityid')=='2')
                        @foreach($categories as $category)
                            @foreach($category->shows as $show)
                                @if($show->city_id == 2)
                                    <a href="{{ route('website/get/show',['uid'=>$show->uid]) }}"
                                       class="h-show {{ $category->slug }}">
                                        <img src="{{$show->tumb_url}}">
                                        <div>
                                            <span class="h-name">{{$show->title}}</span>
                                            <strong>{{ $show->scene["name"] }}<i class="fa map-pin"></i> </strong>
                                            @if($show->from_date == $show->to_date)
                                                <span class="h-date"> {{\SeebBlade::prettyDateWithFormat($show->from_date,'d MMM')}}</span>
                                            @else
                                                <span class="h-date"> {{\SeebBlade::prettyDateWithFormat($show->from_date,'d MMM')}} تا {{\SeebBlade::prettyDateWithFormat($show->to_date,'d MMM ')}}</span>
                                            @endif
                                        </div>
                                    </a>
                                @endif
                            @endforeach
                        @endforeach

                        @elseif(session('cityid')=='3')
                            @foreach($categories as $category)
                                @foreach($category->shows as $show)
                                    @if($show->city_id == 3)
                                        <a href="{{ route('website/get/show',['uid'=>$show->uid]) }}"
                                           class="h-show {{ $category->slug }}">
                                            <img src="{{$show->thumb_url}}">
                                            <div>
                                                <span class="h-name">{{$show->title}}</span>
                                                <strong>{{ $show->scene["name"] }}<i class="fa map-pin"></i> </strong>
                                                @if($show->from_date == $show->to_date)
                                                    <span class="h-date"> {{\SeebBlade::prettyDateWithFormat($show->from_date,'d MMM')}}</span>
                                                @else
                                                    <span class="h-date"> {{\SeebBlade::prettyDateWithFormat($show->from_date,'d MMM')}} تا {{\SeebBlade::prettyDateWithFormat($show->to_date,'d MMM ')}}</span>
                                                @endif
                                            </div>
                                        </a>
                                    @endif
                                @endforeach
                            @endforeach
                        @endif
    </div>

    <div class="view apps" style="top: 57px;">
        <div class="text-view-apps">
            <strong>جای پرشیاتیکت در گوشی شما خالی است. همین حالا آن را دانلود کنید!</strong>
            <a href="#" class="appstore"> </a>
            <a href="#" class="bazar"> </a>
            <a href="#" class="google"> </a>
        </div>
        <img src="/img/pixelhomescreen.png" style="right: 90px;">
        <img src="/img/iphonehomescreen.png" style="top: 130px;">
    </div>

@stop