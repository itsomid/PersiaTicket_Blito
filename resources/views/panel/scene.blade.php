<script>

    $( ".scroll-handel" ).selectable({
        filter : "span.item"
    });



        $( ".plan-grid" ).change(function() {



        var slgrid = $(".plan-grid option:selected").attr('class').split(' ')[0];


        $('.save-price').removeClass('ui-selectee');

        $('.view-chair').removeClass('selected-view-of-chair');
        $('.view-chair').hide();
        $('.' + slgrid).addClass('selected-view-of-chair');
        $('.' + slgrid).show('slow');

    });

</script>
<div  id="selectable">
    <div class="info-dir-chair">
        <label class="col-lg-2 control-label ">انتخاب جایگاه صندلی </label>
        <div class="col-sm-3">
            <select class="form-control m-b plan-grid" name="">
                @foreach($scene->zones as $zone)
                <option class="zone-{{$zone->id}}">{{$zone->name}}</option>
                @endforeach
            </select>

        </div>



    </div>
<div class="scroll-handel">
    @foreach($scene->zones as $key=>$zone)

            <div class="{{$zone->name}} zone-{{$zone->id}}  view-chair  {{ $key == 0 ? "selected-view-of-chair" : "hide-view" }}" >



                <div class="chair-div" >
                    @foreach($zone->rows as $row)
                        {{--{{ $row->seats()->count()*38 + $row->seats()->selectRaw('SUM(`space_to_left`) + SUM(`space_to_right`) as spaces')->first()['spaces']*25+4  }}--}}
                        <div class="chair-row " style="">
                            <b>{{$row->row}}</b>
                            @foreach($row->seats as $seat)
                                <span style="margin-right: {{ 4 + $seat->space_to_right * 33 }}px !important; margin-left: {{ 4 + $seat->space_to_left * 33 }}px !important" class='item' data='{{ $seat->id }}'>{{ $seat->column }}<i>-</i></span>
                            @endforeach


                        </div>
                        <br>
                    @endforeach


                </div>
            </div>
        @endforeach
</div>
</div>



