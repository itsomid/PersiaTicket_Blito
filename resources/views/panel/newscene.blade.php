@include('panel.layouts.header')
@include('panel.layouts.menu')
<style type="text/css">
    #map{ width:10)%; height: 400px; }
</style>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDkL9w6tZ4wNRlKxq1rtSs5tbzEB2PC1Ss"></script>
<div id="page-wrapper" class="gray-bg" >
    <input type="hidden" value="{{isset($scene) ? $scene->id : null}}" class="sceneid">
    @include('panel.layouts.search-navbar')
    <div class="col-lg-12"><a href="{{ route('scenes/list') }}" class="fa fa-arrow-left icon back-icon"></a> </div>
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-10">
            <h2>سالن جدید</h2>
        </div>

        <div class="col-lg-12 json">
            <div class="alert alert-danger" style="display: none">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <strong>پر کردن تمام فیلد ها اجباریست</strong>
            </div>
        </div>
        <div class="col-lg-12 form-group">

            <div class="plan-row">
                <strong>نام سالن</strong>
                <div class="col-sm-7">
                    <input type="text" value="{{ is_null($scene)? '' : $scene->name }}" name="" class="form-control sName">
                </div>


            </div>
            <div class="plan-row">
                <strong>نام شهر</strong>
                <div class="col-sm-7">
                    <select name="" class="form-control sCity">
                        @foreach(\App\Models\City::all() as $city)
                            <option value="{{$city->id}}" >{{ $city->name }}</option>
                        @endforeach

                    </select>
                </div>


            </div>
            <div class="plan-row">
                <strong> ادرس </strong>
                <div class="col-sm-7">
                    <input type="text" value="{{ is_null($scene)? '' : $scene->address }}" name="" class="form-control sAddress">
                </div>
            </div>
            <div class="plan-row">
                <strong>گوگل مپ</strong>
                <div class="col-sm-7">

                    <div id="map"></div>

                        <input type="hidden" id="lat" value="{{ is_null($scene)? '' : $scene->location[0] }}" readonly="yes"><br>
                        <input type="hidden" id="lng" value="{{ is_null($scene)? '' : $scene->location[1] }}" readonly="yes">


                    <script type="text/javascript" >
                        //map.js

                        //Set up some of our variables.
                        var map; //Will contain map object.
                        var marker = false; ////Has the user plotted their location marker?

                        //Function called to initialize / create the map.
                        //This is called when the page has loaded.
                        function initMap() {

                            //The center location of our map.
                            var centerOfMap = new google.maps.LatLng({{ is_null($scene)? '35.6892' : $scene->location[0] }}, {{ is_null($scene)? '51.3890' : $scene->location[1] }});

                            //Map options.
                            var options = {
                                center: centerOfMap, //Set center.
                                zoom: 7 //The zoom value.
                            };

                            //Create the map object.
                            map = new google.maps.Map(document.getElementById('map'), options);

                            //Listen for any clicks on the map.
                            google.maps.event.addListener(map, 'click', function(event) {
                                //Get the location that the user clicked.
                                var clickedLocation = event.latLng;
                                //If the marker hasn't been added.
                                if(marker === false){
                                    //Create the marker.
                                    marker = new google.maps.Marker({
                                        position: clickedLocation,
                                        map: map,
                                        draggable: true //make it draggable
                                    });
                                    //Listen for drag events!
                                    google.maps.event.addListener(marker, 'dragend', function(event){
                                        markerLocation();
                                    });
                                } else{
                                    //Marker has already been added, so just change its location.
                                    marker.setPosition(clickedLocation);
                                }
                                //Get the marker's location.
                                markerLocation();
                            });
                        }


                        function markerLocation(){
                            //Get location.
                            var currentLocation = marker.getPosition();

                            document.getElementById('lat').value = currentLocation.lat(); //latitude
                            document.getElementById('lng').value = currentLocation.lng(); //longitude
                        }

                        google.maps.event.addDomListener(window, 'load', initMap);

                    </script>

                </div>
            </div>
            <div class="plan-row">
                <strong> شماره تماس</strong>
                <div class="col-sm-7">
                    <input type="text" value="{{ is_null($scene)? '' : $scene->phone }}" name="" class="form-control sPhone">
                </div>
            </div>

            <div class="plan-row">
                <strong>  اپلود عکس پلان</strong>
                <div class="col-sm-7">
                    <input type="file" value="" name="" id="imgInp" class="form-control sPhoto">
                </div>


            </div>
            <div class="plan-row plan-img"><p id="b64" style="display: none"></p>
                <strong>  اپلود عکس پلان</strong>
                <div class="img-w col-sm-7"><img id="blah" src="{{is_null($scene)? "" : $scene->plans[0]->image_url}}" />
                    @isset($scene)
                        @foreach($scene->zones as $key => $zone)
                    <div class="place-here sel-{{$key+1}} ui-draggable ui-draggable-handle" style="left: {{$zone->x * 100}}%; top: {{$zone->y * 100}}%"><i style="background: #{{ $colors[$key] }}">{{$key+1}}</i><i></i></div>
                        @endforeach
                    @endisset
                </div>
                <span class="add-place btn btn-primary">افزودن جایگاه</span>
                <div class="x-y" style="display: none">
                    <p></p>
                    @isset($scene)
                        @foreach($scene->zones as $key => $zone)
                            <div id="pos-x-{{$key+1}}">{{$zone->x}}</div><div id="pos-y-{{$key+1}}">{{$zone->y}}</div>
                        @endforeach
                    @endisset
                </div>



            </div>








            <div class="place-chiar-int-div">
                @isset($scene)

                    @foreach($scene->zones as $key => $zone)
                        <div class="one-place-color-item  sel-{{$key+1}}" style="background: #{{ $colors[$key] }}"><div class="deleat-pfa btn btn-danger  sel-{{$key+1}} ">حذف جایگاه</div>
                    <div class="plan-row"><strong class="palce-title-st">نام جایگاه</strong></div>
                    <div class="plan-row "><input type="text" value="{{$zone->name}}" name="" class="small-in-put input-style-cus place-title"> </div>
                            @foreach($zone->rows as $key2 => $row)
                    <div class="radif-fa plan-row">

                        <div class="plan-row ">
                            <div class="tit-test">ردیف</div>    <div class="chair-int-cont-fa ">
                                <div class="but-a space-create-a"></div>
                                <div class="but-a chair-create-a">صندلی</div>
                                <input type="text" value="" name="" class="small-in-put end-in input-style-cus mar-top">
                                <div class="words-mar">تا</div>
                                <input type="text" value="" name="" class="small-in-put start-than input-style-cus mar-top">
                                <div class="words-mar">از</div>

                            </div>
                        </div>

                        <input type="text" value="{{$row->row}}" name="" class="small-in-put input-style-cus row-tit">
                        <div class="del-chair-created-in-row fa fa-close icon"></div> <div class="big-in-div input-style-cus">



                            @foreach($row->seats as $seat)

                                @for($i=0; $i < $seat->space_to_left; $i++)
                                    <div class="c-space-int">  </div>
                                @endfor
                                    <div class="c-chair-int">{{$seat->column}}</div>
                                    @for($i=0; $i < $seat->space_to_right; $i++)
                                        <div class="c-space-int">  </div>
                                    @endfor
                            @endforeach

                        </div>

                    </div>
                            @endforeach
                    <div class="add-new-radif  btn btn-primary fa fa-plus icon"></div><div class="remove-new-radif  btn btn-danger fa fa-minus icon"></div>

                        </div>

                    @endforeach
                @endisset
            </div>





        </div>

        <div class="col-lg-2">
            <a href="#"  class="btn btn-primary save-new-scen" style="float: left;margin-bottom: 20px;">ذخیره</a>
        </div>

    </div>

</div>

@include('panel.layouts.footer')
<script>


    $( "body" ).delegate( ".save-new-scen", "click", function() {
        $('.pop-loading').fadeIn();

        var sName     = $('.sName').val();
        var sAddress  = $('.sAddress').val();
        var lat      = $('#lat').val();
        var lng      = $('#lng').val();
        var sPhone    = $('.sPhone').val();
        var sPhoto    = $('#b64').text();
        var scity    = $('.sCity option:selected').text();
        var placeHere = $( ".place-here" ).length;
        var scenceId = $('.sceneid').val();
        var scAfter = null ;

        var errorInput = true ;
        if (lat == "" || lng == ""){

            $('.alert-danger').append('<br>محل سالن را از روی نقشه انتخاب کنید')
        }
        if(sName == "" || sAddress == "" || sPhone == ""  ){
            $('.alert-danger').fadeIn();
            $('.pop-loading').fadeOut();
        }else {

            $('.alert-danger').fadeOut();
            $('.pop-loading').fadeOut();
            var zones = []
            //alert(scenceId);

            if (scenceId == "") {
                scAfter = null;
            }else{
                scAfter = scenceId;
            }

            //alert(scAfter)
            for (var p = 1; p <= placeHere; p++) {


                //chairsShow.push(p);
                var rows = [];

                var htd = [];
                $('.sel-' + p).find('.radif-fa').each(function () {
                    htd = [];
                    $(this).find('.big-in-div div').each(function () {
                        htd.push($(this).text());

                    });
                    var rowTit = $(this).find('.row-tit').val();
                    rows.push({
                        title: rowTit,
                        seats: htd
                    })


                });


                var xPlace = $('#pos-x-' + p).text();
                var yPlace = $('#pos-y-' + p).text();
                var placeTitle = $('.sel-' + p).find('.place-title').val();
                zones.push({
                    title: placeTitle,
                    x: xPlace,
                    y: yPlace,
                    rows: rows
                })
            }

            var result = {
                scene: {
                    sceneId : scAfter ,
                    sceneName: sName,
                    sceneAddress: sAddress,
                    scenelat: lat,
                    scenelng: lng,
                    scenePhone: sPhone,
                    scenePhoto: sPhoto,
                    sceneCity: scity
                },
                zones: zones
            };
            $.ajax({
                url: "{{route('scenes/save')}}",
                type: "POST",
                data:{
                    data: result,
                    _token: "{{csrf_token()}}"
                },
                error: function (data) {
                    alert('با موفقیت انجام شد');
                    window.location.href = "{{route('scenes/list')}}";
                },
                success: function (data) {
                    window.location.href = "{{route('scenes/list')}}";
                }

            });

        }

    });

</script>


<script>
    $.getScript("/js/plan-select.js")
</script>

