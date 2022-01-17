@include('panel.layouts.header')
@include('panel.layouts.menu')
<div id="page-wrapper" class="gray-bg">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-12"><a href="{{ route('shows/list',['cat_id' => 1]) }}" class="fa fa-arrow-left icon back-icon"></a> </div>
        <div class="ibox-content">

            <div class="row">

                <div class="col-lg-12">
                    <div class="m-b-md">
                        <a href="{{ route('shows/edit',['show_uid' => $show->uid]) }}" class="btn btn-white btn-xs pull-right">ویرایش برنامه</a>
                        <h2>{{ $show->title }}</h2>
                        <div class="event-img">
                            <img class="img-responsive cover-img" src="{{$show->main_image_url}}" />
                            <img class="img-responsive th-img" src="{{$show->thumb_url}}" />
                        </div>

                    </div>
                    <dl class="dl-horizontal">
                        <dt>وضعیت:</dt> <dd><span class="label label-primary">{{ trans('showstatus.'.$show->status) }}</span></dd>
                    </dl>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5">
                    <dl class="dl-horizontal">
                        <dt>کد نمایش:</dt><dd>{{ $show->id }}</dd>
                        <dt>تهیه کننده:</dt> <dd>{{ $show->admin->fullName() }}</dd>
                        <dt>شهر:</dt> <dd>{{ $show->city->name }}</dd>
                    </dl>
                </div>
                <div class="row">

                </div>
                <div class="col-lg-7" id="cluster_info">
                    <dl class="dl-horizontal">

                        <dt>تاریخ شروع:</dt> <dd>{{ SeebBlade::prettyDateWithFormat($show->from_date, 'dd MMM yyyy') }}</dd>
                        <dt>تاریخ پایان:</dt> <dd> {{ SeebBlade::prettyDateWithFormat($show->to_date, 'dd MMM yyyy') }}</dd>

                        @if(false)
                            <dt>برچسب ها:</dt>
                                <dd class="project-people">
                                    <ul class="tag-list" style="padding: 0">
                                        <li><a href=""><i class="fa fa-tag"></i> اهنگ</a></li>
                                        <li><a href=""><i class="fa fa-tag"></i>خواننده</a></li>
                                        <li><a href=""><i class="fa fa-tag"></i>هیجان</a></li>
                                        <li><a href=""><i class="fa fa-tag"></i>موزیک</a></li>
                                    </ul>
                                </dd>
                        @endif
                    </dl>
                </div>
            </div>
            <div class="row" style="display: none">
                <div class="col-lg-12">
                    <dl class="dl-horizontal">
                        <dt>وضعیت:</dt>
                        <dd>
                            <div class="progress progress-striped active m-b-sm">
                                <div style="width: 60%;" class="progress-bar"></div>
                            </div>
                            <small>تا پایان این برنامه <strong>۱۴ روز</strong> باقی مانده است</small>
                        </dd>
                    </dl>
                </div>
            </div>
            <div class="row m-t-sm">
                <div class="col-lg-12">
                    <div class="panel blank-panel">
                        <div class="panel-heading">
                            <div class="panel-options">


                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#tab-1" data-toggle="tab" aria-expanded="true">سانس ها</a></li>
                                    <li class=""><a href="#tab-2" data-toggle="tab" aria-expanded="false">تخفیف ها</a></li>
                                    <li class=""><a href="#tab-3" data-toggle="tab" aria-expanded="false">جزییات</a></li>
                                    <li class=""><a href="#tab-4" data-toggle="tab" aria-expanded="false">گزارشات</a></li>
                                    @if(false)
                                    <li class=""><a href="#tab-2" data-toggle="tab" aria-expanded="false">تخفیف ها</a></li>
                                        @endif
                                </ul>
                            </div>
                        </div>

                        <div class="panel-body">

                            <div class="tab-content">
                                <div class="tab-pane active" id="tab-1">

                                    <table class="footable table table-stripped toggle-arrow-tiny">
                                        <thead>
                                        <tr>
                                            <th>روز</th>
                                            <th>تاریخ</th>
                                            <th>سانس</th>
                                            <th>بلیت ها</th>
                                            <th>فروخته شده</th>
                                            <th>باقی مانده</th>
                                            <th>مبلغ کل</th>
                                            <th>مبلغ فروش رفته</th>
                                            <th>وضعیت</th>
                                            <th>گزارش سانس</th>
                                            <th></th>

                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($show->allShowtimes as $showtime)

                                            <tr>
                                                <td>{{ SeebBlade::prettyDateWithFormat($showtime->datetime,'EEE') }}</td>
                                                <td>{{ SeebBlade::prettyDateWithFormat($showtime->datetime,'dd MMM yyyy') }}</td>
                                                <td>{{ SeebBlade::prettyDateWithFormat($showtime->datetime,'HH:mm') }}</td>
                                                <td>{{ SeebBlade::persianDigits($showtime->tickets()->count())}}</td>
                                                <td>{{ SeebBlade::persianDigits($showtime->tickets()->count() - $showtime->remaining_seats)}}</td>
                                                <td>{{ SeebBlade::persianDigits($showtime->remaining_seats)}}</td>
                                                <td>{{ SeebBlade::persianDigits($showtime->tickets()->sum('price')) }} تومان</td>
                                                <td>{{ SeebBlade::persianDigits($showtime->tickets()->sum('price') - $showtime->tickets()->whereIn('tickets.status',['available','reserved'])->sum('price'))}} تومان</td>
                                                <td>
                                                    {{ trans('showstatus.'.$showtime->status) }}
                                                </td>
                                                <td>
                                                    <a href="{{route('reports/show',['uid'=>$showtime->uid])}}" >گزارش</a>
                                                </td>
                                                <td>
                                                    @if($showtime->status == 'enabled')
                                                    <a href="{{ route('showtime/set-status', ['uid' => $showtime->uid,'status' => 'disabled']) }}" class="btn btn-sm btn-danger">‌غیرفعال‌سازی</a>
                                                    @else
                                                        <a href="{{ route('showtime/set-status', ['uid' => $showtime->uid,'status' => 'enabled']) }}" class="btn btn-sm btn-success">فعال‌سازی</a>
                                                    @endif
                                                    <a href="{{ route('showtime/tickets', ['showtime_uid' => $showtime->uid]) }}" class="btn btn-sm btn-primary"> بلیت ها</a>
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>
                                    </table>

                                </div>
                                <div class="tab-pane" id="tab-2">
                                    <a href="#" class="create-offer btn btn-primary show-popup" style="float: left">کد تخفیف جدید</a>
                                    <table class="footable table table-stripped toggle-arrow-tiny">
                                        <thead>
                                        <tr>
                                            <th>کد</th>
                                            <th>میزان تخفیف ثابت (تومان)</th>
                                            <th>میزان تخفیف (درصد)</th>
                                            <th>سانس</th>
                                            <th>تاریخ شروع</th>
                                            <th>تاریخ انقضا</th>
                                            <th>تعداد استفاده</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($promotions as $promotion)

                                            <tr>
                                                <td>{{ $promotion->code }}</td>
                                                <td>{{ number_format($promotion->constant_discount) }}</td>
                                                <td>{{ $promotion->percent_discount * 100 }}</td>
                                                <td>
                                                    @isset($promotion->showtime)
                                                    {{  \SeebBlade::prettyDate($promotion->showtime->datetime)}}

                                                        @else
                                                    -
                                                    @endisset

                                                </td>

                                                <td>{{ \SeebBlade::prettyDate($promotion->since_date) }}</td>
                                                <td>{{ \SeebBlade::prettyDate($promotion->until_date) }}</td>
                                                <td>
                                                    @if($promotion->usage_count == -1)
                                                        نامحدود
                                                        @else
                                                        {{ $promotion->usage_count }}
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach

                                        </tbody>

                                    </table>

                                </div>







                                <div class="tab-pane joz-list-show" id="tab-3">

                                    <div class="row">
                                        <div class="col-sm-3">نام برنامه</div>
                                        <div class="col-sm-9">{{ $show->title }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">ژانر</div>
                                        <div class="col-sm-9">{{ implode(',',array_map(function($o){ return $o['title'];},$show->genres->toArray())) }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">توضیحات</div>
                                        <div class="col-sm-9">{{ $show->description }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">وضعیت</div>
                                        <div class="col-sm-9">{{ trans('showstatus.'.$show->status) }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">دسته بندی</div>
                                        <div class="col-sm-9">{{ $show->category->name }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">رنگ پس زمینه</div>
                                        <div class="col-sm-9"><span style="background-color: #{{$show->background_color }}; padding:5px;margin-left: 10px;">  </span>{{ $show->background_color }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">شهر</div>
                                        <div class="col-sm-9">{{ $show->city->name }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">سالن</div>
                                        <div class="col-sm-9">{{ $show->scene->name }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">قوانین</div>
                                        <div class="col-sm-9">{{ $show->terms_of_service }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">تهیه کننده</div>
                                        <div class="col-sm-9">{{ $show->admin->fullName() }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">مجوز</div>
                                        <div class="col-sm-9"><a href="{{asset($show->license_url)}}" target="_blank">دریافت</a></div>
                                    </div>

                                </div>







                                <div class="tab-pane" id="tab-4">


                                    <div id="container" style="float: left"></div>
                                    <div class="amar-joz">
                                        <div>
                                            <strong>فروش کل</strong>
                                            <strong>{{ number_format($report['total_sale']) }} تومان</strong>
                                        </div>
                                        <div>
                                            <strong>تعداد کل بلیت‌ها</strong>
                                            <strong>{{number_format($report['total_seats'])}}</strong>
                                        </div>
                                        <div>
                                            <strong>تعداد کل بلیت‌های فروش رفته</strong>
                                            <strong>{{ number_format($report['total_sold_seats']) }}</strong>
                                        </div>
                                    </div>

                                </div>




                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="user-create create-offer" >

            <div class="p-window">


                <div class="row">
                    <form role="form">
                        <div class="form-group col-sm-6"><label class="col-sm-12">درصد تخفیف</label> <input type="number" max="1.0" min="0.0" step="0.01" class="form-control col-sm-3 percentDiscount number"></div>
                        <div class="form-group col-sm-6"><label class="col-sm-12">کد تخفیف</label> <input type="text" placeholder="کد تخفیف" class="form-control code"></div>
                        <div class="form-group col-sm-6"><label class="col-sm-12"> زمان شروع تخفیف</label> <input type="text"  class="form-control offerStart pl1"></div>
                        <div class="form-group col-sm-6"><label class="col-sm-12">زمان پایان تخفیف</label> <input type="text"  class="form-control offerEnd pl2"></div>
                        <div class="form-group col-sm-6"><label class="col-sm-12">سانس</label> <select class="form-control m-b showtimeuid" >
                                @foreach($show->allShowtimes as $showtime)
                                    <option value="{{$showtime->uid}}">{{\SeebBlade::prettyDate($showtime->datetime)}}</option>
                                @endforeach
                            </select></div>
                        <div class="form-group col-sm-12"><label class="col-sm-12"> میزان تخفیف (تومان) </label> <input type="text" placeholder="۵۰۰۰۰" class="form-control constantDiscount"></div>

                        <div class="form-group col-sm-12"><input type="checkbox" class="col-sm-1 mahdod-offer" style="float: right"><label class="col-sm-5">نامحدود</label></div>

                        <div class="form-group show-mahdod" ><label class="col-sm-12"> محدودیت استفاده </label> <input type="number"  class="form-control usageCount"></div>


                        <div class="form-group"><input type="hidden" class="showuid" value="{{ $show->uid }}"></div>


                        <span class="btn btn-sm btn-primary pull-right add-offer-info">ذخیره</span>
                        <a href="#" class="btn-sm btn btn-warning close-popup" style="float: left">انصراف</a>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
</div>


@include('panel.layouts.footer')

<script type="text/javascript">

    $( '.pl1 ').pDatepicker({
        format: 'YYYY/MM/DD HH:mm',
    timePicker: {
        enabled: true,
            meridiem: {
            enabled: true
        }
    }
    });
    $( '.pl2' ).pDatepicker({
        format: 'YYYY/MM/DD HH:mm',
    timePicker: {
        enabled: true,
            meridiem: {
            enabled: true
        }
    }
    });

    $('.add-offer-info').click(function () {
        var code = $('.code').val()
        var percentDiscount = $('.percentDiscount').val()
        var offerStart = $('.offerStart').val()
        var offerEnd = $('.offerEnd').val()
        var showuid = $('.showuid').val()
        var showtimeuid = $('.showtimeuid').val()
        var constantDiscount = $('.constantDiscount').val()
        var usageCount = $('.usageCount').val()
        //alert(code + ' ' + percentDiscount + ' ' + offerStart + ' ' + offerEnd + ' ' + showuid + ' ' + constantDiscount + ' ' + usageCount )
        if($( ".mahdod-offer:checked" )){

        }
        $.post("{{route('promotions/add')}}",
            {
                show_uid: showuid,
                code : code ,
                since_date : offerStart ,
                until_date : offerEnd,
                constant_discount : constantDiscount ,
                percent_discount: percentDiscount * 100,
                usage_count: usageCount,
                showtime_uid : showtimeuid,
                _token: "{{ csrf_token() }}"
            },
            function (data, status) {
                var resCome = data.result;
                if (resCome == true) {
                    alert('با موفقیت انجام شد');
                    location.reload();
                } else {
                    alert(data.message)
                }

            });

    });

    $( ".mahdod-offer" ).change(function() {
$('.show-mahdod').fadeToggle();
        })
        .change();




    $(function () {
        Highcharts.setOptions({
            chart: {
                style: {
                    fontSize: '12px',
                    fontFamily: 'Tahoma',
                    textAlign:'right'
                }
            }
        });
        $('#container').highcharts({
            credits: {
                enabled: false
            },
            title: {
                text: 'فروش',
                x: -20,
                style: {
                    fontWeight: 'bold'
                }
            },
            subtitle: {
                text: '',
                x: -20
            },
            xAxis: {
                categories: {!! $report_dates !!}
            },
            yAxis: {
                title: {
                    text: 'تومان'
                },
                plotLines: [{
                    value: 0,
                    width: 1,
                    color: '#808080'
                }]
            },
            legend: {
                rtl: true
            },
            tooltip: {
                valueSuffix: ' تومان',
                crosshairs: true,
                shared: true,
                useHTML: true
            },
            series: [{
                name: 'فروش',
                data: {!! $report_prices !!},

            }]
        });
    });
</script>