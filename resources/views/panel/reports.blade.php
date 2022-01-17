@include('panel.layouts.header')
@include('panel.layouts.menu')

<div id="page-wrapper" class="gray-bg" >
    @include('panel.layouts.search-navbar')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-10">
            <h2>گزارشات</h2>
        </div>
        <div class="col-lg-2" >

        </div>
        <style>
            .amar-kol-m {width: 100%;
            padding: 50px;
            float: right;
                background: #FFFFFF;
            }
            .amar-kol-m div{float: right;width: 50%;
            height: 80px;direction: rtl;
             }
            .amar-kol-m div strong:nth-child(1){float: right;margin-right: 20px}
            .amar-kol-m div strong:nth-child(2){float: left;margin-left: 20px}

        </style>
        @if($message == 'general')

            <form action="" method="post">
                {{ csrf_field() }}

                    <div class="col-lg-11 fil-req">
                        <label class="col-sm-2 control-label">تهیه کننده</label>
                        <div class="col-sm-3">
                            <select class="form-control m-b" name="producer">
                                    <option value="-1" {{ !isset($producer) ? 'selected=selected' : ''}}>همه</option>
                                @foreach(\App\User::where('access_level','>=',5)->get() as $user)
                                    <option value="{{ $user->id }}" {{ isset($producer) ? ($user->id == $producer->id)? 'selected=selected' : '' : '' }}>{{ $user->fullName() }}</option>
                                @endforeach
                            </select>
                        </div>
                        <label class="col-sm-2 control-label">سرویس دهنده </label>
                        <div class="col-sm-3">
                            <select class="form-control m-b" name="source" >
                                <option value="-1" {{ !isset($source) ? 'selected=selected' : ''}}>همه</option>
                                @foreach(\App\Models\Source::all() as $asource)
                                    <option value="{{ $asource->id }}" {{ isset($source) ? ($source->id == $asource->id)? 'selected=selected' : '' : '' }}>{{ $asource->title }}</option>
                                @endforeach
                            </select>
                        </div>
                        <button class="btn btn-primary" style="float: left;margin-bottom: 20px;">فیلتر</button>
                    </div>
            </form>
        @endif

        <div class="col-lg-12" style="padding: 50px">
            <div class="amar-kol-m">
                <div><strong>نام رویداد</strong><strong>{{ number_format($total_sale) }} تومان</strong></div>
                <div><strong>میزان فروش کل</strong><strong>{{ number_format($total_sale) }} تومان</strong></div>
                <div><strong>تعداد کل بلیت‌ها</strong><strong>{{ number_format($total_seats) }}</strong></div>
                <div><strong>تعداد بلیت‌های فروش رفته</strong><strong>{{ number_format($total_sold_seats) }}</strong></div>

                @if($message == 'general')
                    <div><strong>تعداد بلیت‌های فروش رفته(وبسایت)</strong><strong>{{ isset($website_totalSold) ? $website_totalSoldSeats : '0'}}</strong></div>
                    <div><strong>میزان فروش رفته(وبسایت)</strong><strong>{{ isset($website_totalSold) ?  number_format($website_totalSold) : '0' }} تومان </strong></div>
                    <div><strong>تعداد بلیت‌های فروش رفته(اندروید)</strong><strong>{{ isset($android_totalSold) ? $android_totalSoldSeats : '0' }}</strong></div>
                    <div><strong>میزان فروش رفته(اندروید)</strong><strong>{{  isset($android_totalSold) ? number_format($android_totalSold) : '0' }} تومان </strong></div>
                    <div><strong>تعداد بلیت‌های فروش رفته(ios)</strong><strong>{{  isset($ios_totalSold) ? $ios_totalSoldSeats : '0' }}</strong></div>
                    <div><strong>میزان فروش رفته(ios)</strong><strong>{{  isset($ios_totalSold) ?  number_format($ios_totalSold) : '0' }} تومان </strong></div>
                @elseif($message == 'single')
                    <div><strong>تعداد بلیت‌های فروش رفته(وبسایت)</strong><strong>{{ isset($website_totalSold) ? count($website_totalSold['tickets']) : '0'}}</strong></div>
                    <div><strong>میزان فروش رفته(وبسایت)</strong><strong>{{ isset($website_totalSold) ?  number_format($website_totalSold['price']) : '0' }} تومان </strong></div>
                    <div><strong>تعداد بلیت‌های فروش رفته(اندروید)</strong><strong>{{ isset($android_totalSold) ? count($android_totalSold['tickets']) : '0' }}</strong></div>
                    <div><strong>میزان فروش رفته(اندروید)</strong><strong>{{  isset($android_totalSold) ? number_format($android_totalSold['price']) : '0' }} تومان </strong></div>
                    <div><strong>تعداد بلیت‌های فروش رفته(ios)</strong><strong>{{  isset($ios_totalSold) ? count($ios_totalSold['tickets']) : '0' }}</strong></div>
                    <div><strong>میزان فروش رفته(ios)</strong><strong>{{  isset($ios_totalSold) ?  number_format($ios_totalSold['price']) : '0' }} تومان </strong></div>
                @endif
                <div><strong>تعداد کل نمایش‌های فعال</strong><strong>{{ $shows_count }}</strong></div>
                <div><strong>تعداد تهیه کنندکان</strong><strong>{{ $producers_count }}</strong></div>
                <div><strong>تعداد کاربران</strong><strong>{{ $users_count }}</strong></div>



            </div>
            <div id="container" style="float: left;width: 100%"></div>


        </div>


    </div>



    </div>

</div>
@include('panel.layouts.footer')

<script type="text/javascript">

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
                text: 'نمودار فروش',
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
                categories: {!! $chart_dates !!}
            },
            yAxis: {
                title: {
                    text: 'فروش'
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
                data: {!! $chart_prices !!},

            }]
        });
    });
</script>