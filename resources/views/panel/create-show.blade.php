@include('panel.layouts.header')
@include('panel.layouts.menu')

<div class="chair-div-fa">

    <div class="res_back"></div>
    <div class="chair-prices-con">
        <label class="col-sm-1 control-label " style="padding: 10px;">قیمت صندلی</label>
        <div class="col-sm-3"><input type="number" class="form-control grid-chair-price"></div>
        تومان

        <span class="btn btn-info save-price" style="margin-right: 30px">ثبت قیمت</span>

        <span class="btn btn-warning disable-chair"
              style="margin-right: 50px">تعریف صندلی به عنوان غیر قابل فروش</span>

        <span class="btn btn-default select-all-ch-this" style="margin-right: 50px;">انتخاب همه</span>
    </div>
    <div class="chair-info">
        <div class="int-ch">
            <div class="chair-all">کل صندلی ها: <span>0</span></div>
            <div class="chair-select"> انتخاب شده: <span>0</span></div>
            <!-- <div class="chair-have"> باقی مانده: <span>0</span></div> -->
        </div>
        <div class="ct-buts">

            <span class="btn btn-default close-ch-s ">انصراف</span>
            <span class="btn btn-primary save-price close-ch-s ">ذخیره</span>


        </div>

    </div>

</div>
<div id="page-wrapper" class="gray-bg postion-st">
    <div class="col-lg-12"><a href="{{ route('shows/list',['cat_id' => 1]) }}"
                              class="fa fa-arrow-left icon back-icon"></a></div>
    <div class="wrapper wrapper-content animated fadeInRight postion-st">
        <div class="ibox-content postion-st">

            <div class="panel blank-panel">
                <div class="panel-heading">
                    @isset($show)
                    @else
                        <div class="panel-options">
                            <ul class="nav nav-tabs">
                                <li class="{{ session('activeTab') == 0 ? 'active' : '' }}"><a href="#tab-1"
                                                                                               data-toggle="tab"
                                                                                               aria-expanded="true">ساخت
                                        برنامه</a></li>
                                <li class="{{ session('activeTab') == 1 ? 'active' : ''}}"><a href="#tab-2"
                                                                                              data-toggle="tab"
                                                                                              aria-expanded="false">اضافه
                                        کردن از منابع دیگر</a></li>

                            </ul>
                        </div>
                    @endisset
                </div>

                <div class="panel-body">

                    <div class="tab-content">
                        <div class="tab-pane {{ session('activeTab') == 0 ? 'active' : '' }}" id="tab-1">


                            <div class="col-sm-12">
                                <div class="row">
                                    @isset($show)
                                        <h2>ویرایش برنامه
                                            <small> شماره {{$show->id}}</small>
                                        </h2>

                                    @else
                                        <h2>تعریف برنامه</h2>
                                    @endisset
                                </div>
                            </div>

                            <form method="post" enctype="multipart/form-data" method="post" id="myForm"
                                  class="form-horizontal" action="{{ route('shows/save') }}">
                                @isset($show)

                                    <input type="hidden" value="{{$show->id}}" name="show_id">
                                @endif
                                @if(session('newError'))
                                    <div>
                                        @foreach(session('newError') as $error)
                                            <div class="alert alert-danger">
                                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                                <strong>{{$error}}</strong>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">نام برنامه</label>
                                    <div class="col-sm-6">
                                        <input name="title" type="text" class="form-control"
                                               value="{{!is_null($show)? $show->title: old('title')}}">
                                    </div>
                                </div>
                                @if(false)
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">زیر عنوان</label>
                                        <div class="col-sm-6"><input name="subtitle" type="text" class="form-control"
                                                                     value="{{!is_null($show)? $show->subtitle: old('subtitle')}}">
                                        </div>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">ژانر</label>
                                    <div class="col-sm-6 janr-check ">
                                        <select class="form-control m-b " style="margin-right: 0px;" name="genres[]"
                                                multiple>
                                            @foreach(App\Models\Genre::all() as $genre)
                                                <option value="{{ $genre->id }}" {{ !is_null($show)? ((in_array($genre->id, $show->genreIds())) ? ' selected="selected"' : '') : '' }}>{{ $genre->title }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @if(false)
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">کلید واژه ها</label>
                                        <div class="col-sm-6"><input name="" type="text" class="form-control" value="">
                                        </div>
                                    </div>
                                @endif
                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label"
                                                               for="description">توضیحات</label>
                                    <div class="col-sm-8"><textarea name="description"
                                                                    class="form-control textarea-dir jqte-test">{{ !is_null($show)? $show->description: old('description') }}</textarea>

                                    </div>
                                </div>


                                <div class="hr-line-dashed"></div>
                                @if(false)
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">هنرمند</label>
                                        <div class="col-sm-6"><input name="artist_name" type="text" class="form-control"
                                                                     value="{{!is_null($show)? $show->artist_name: old('artist_name')}}">
                                        </div>
                                    </div>
                                @endif

                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <div class="form-group input-margin">
                                        <label class="col-sm-2 control-label">دسته بندی</label>
                                        <div class="col-sm-4"><select class="form-control m-b"
                                                                      style="margin-right: 8px;" name="category_id">
                                                @foreach(\App\Models\Category::all() as $category)
                                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">رنگ پس زمینه</label>
                                    <div class="col-sm-3">
                                        <div class="color-pal">
                                            <div class="color-pal-cus" style="background: #E9B85C">#E9B85C</div>
                                            <div class="color-pal-cus" style="background: #FAD1AA">#FAD1AA</div>
                                            <div class="color-pal-cus" style="background: #EA7F3E">#EA7F3E</div>
                                            <div class="color-pal-cus" style="background: #F1D04B">#F1D04B</div>
                                            <div class="color-pal-cus" style="background: #F67355">#F67355</div>
                                            <div class="color-pal-cus" style="background: #F04427">#F04427</div>
                                            <div class="color-pal-cus" style="background: #D64936">#D64936</div>
                                            <div class="color-pal-cus" style="background: #BA1A0F">#BA1A0F</div>
                                            <div class="color-pal-cus" style="background: #F9B0B1">#F9B0B1</div>
                                            <div class="color-pal-cus" style="background: #EB98BC">#EB98BC</div>
                                            <div class="color-pal-cus" style="background: #F77378">#F77378</div>
                                            <div class="color-pal-cus" style="background: #C62564">#C62564</div>
                                            <div class="color-pal-cus" style="background: #B46B6B">#B46B6B</div>
                                            <div class="color-pal-cus" style="background: #E5265F">#E5265F</div>
                                            <div class="color-pal-cus" style="background: #75838C">#75838C</div>
                                            <div class="color-pal-cus" style="background: #9F91D0">#9F91D0</div>
                                            <div class="color-pal-cus" style="background: #635875">#635875</div>
                                            <div class="color-pal-cus" style="background: #70D5D8">#70D5D8</div>
                                            <div class="color-pal-cus" style="background: #64DBFC">#64DBFC</div>
                                            <div class="color-pal-cus" style="background: #00BAFC">#00BAFC</div>
                                            <div class="color-pal-cus" style="background: #2C9BD1">#2C9BD1</div>
                                            <div class="color-pal-cus" style="background: #537B9D">#537B9D</div>
                                            <div class="color-pal-cus" style="background: #2D8AA0">#2D8AA0</div>
                                            <div class="color-pal-cus" style="background: #8FB9E2">#8FB9E2</div>
                                            <div class="color-pal-cus" style="background: #64BCCE">#64BCCE</div>
                                            <div class="color-pal-cus" style="background: #B0DCC9">#B0DCC9</div>
                                            <div class="color-pal-cus" style="background: #C4CC9D">#C4CC9D</div>
                                            <div class="color-pal-cus" style="background: #8CA853">#8CA853</div>
                                            <div class="color-pal-cus" style="background: #6DD227">#6DD227</div>
                                            <div class="color-pal-cus" style="background: #1ED6BD">#1ED6BD</div>
                                            <div class="color-pal-cus" style="background: #407B57">#407B57</div>
                                            <div class="color-pal-cus" style="background: #B1AFB0">#B1AFB0</div>
                                            <div class="color-pal-cus" style="background: #C8C4B3">#C8C4B3</div>
                                            <div class="color-pal-cus" style="background: #A99A7B">#A99A7B</div>
                                            <div class="color-pal-cus" style="background: #8F5C2E">#8F5C2E</div>
                                            <div class="color-pal-cus" style="background: #B1532E">#B1532E</div>
                                            <div class="color-pal-cus" style="background: #BB7952">#BB7952</div>
                                        </div>
                                        <input name="color" type="text" class="form-control colorcat"
                                               value="{{!is_null($show)? $show->background_color: old('background_color')}}">
                                        <input type='text' class="basic"/>

                                    </div>
                                </div>

                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label">تاریخ شروع</label>
                                    <div class="col-sm-10">
                                        <div class="row">
                                            <div class="col-md-4"><input name="from_date" type="text" id="pcal1"
                                                                         class="pdate form-control"
                                                                         value="{{!is_null($show)? \SeebBlade::prettyDateWithFormat($show->from_date,'y/M/d', 'fa_IR') : old('from_date')}}"
                                                                         placeholder="شروع برنامه">
                                            </div>
                                            <label class="col-sm-2 control-label">تاریخ پایان</label>
                                            <div class="col-md-4">
                                                <input type="text" name="to_date" id="pcal2"
                                                       value="{{!is_null($show)? \SeebBlade::prettyDateWithFormat($show->to_date,'y/M/d', 'fa_IR') : old('to_date')}}"
                                                       class="pdate form-control"><br>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="hr-line-dashed"></div>

                                @isset($show)
                                @else
                                    <div class="form-group sans-have">
                                        <div class="row">
                                            <label class="label-title "> سانس ها </label>

                                            <a href="#" class="add-sans fa fa-plus icon add-close col-sm-2"
                                               style="float: right"></a>
                                        </div>
                                        <div class="col-sm-10 sana-div-fa">
                                            @isset($show)
                                                @if(false)
                                                    @foreach($show->showtimes as $key => $showtime)
                                                        <div class="row">
                                                            <label class="col-sm-1 control-label">{{$key+1}}.</label>
                                                            <div class="col-md-3"><input id="timepicker{{$key+1}}"
                                                                                         type="text"
                                                                                         name="showtime_time-{{$key+1}}"
                                                                                         placeholder="12:30"
                                                                                         class="form-control"
                                                                                         value="{{!is_null($show)? \SeebBlade::prettyDateWithFormat($showtime->datetime,'hh:mm a', 'en_IR') : '' }}"
                                                                ></div>

                                                            <label class="col-sm-1 control-label">در تاریخ</label>
                                                            <div class="col-md-3"><input name="showtime_date-{{$key+1}}"
                                                                                         type="text" id="pcal{{$key+3}}"
                                                                                         class="pdate form-control"
                                                                                         value="{{!is_null($show)? \SeebBlade::prettyDateWithFormat($showtime->datetime,'y/M/d', 'fa_IR') : '' }}"
                                                                ><br>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @endif

                                            @else
                                                <div class="row">
                                                    <label class="col-sm-1 control-label"> 1.</label>
                                                    <label class="col-sm-3 control-label">در تاریخ و ساعت</label>
                                                    <div class="col-md-6" style="margin-bottom: 20px;">
                                                        <input type="text" id="pcal3"
                                                               class="pdate form-control pwt-datepicker-input-element"
                                                               name="showtime_date-1"></div>
                                                    <br><br><br>
                                                    <label class="col-sm-1 control-label">.</label>

                                                    <label class="col-sm-3 control-label">فروش از تاریخ و ساعت</label>
                                                    <div class="col-md-6"><input type="text" id="pcal10001"
                                                                                 class="pdate form-control pwt-datepicker-input-element"
                                                                                 name="startshowtime_date-1"><br>
                                                    </div>
                                                </div>


                                            @endisset
                                        </div>
                                    </div>
                                @endif

                                <div class="row">
                                    <h2 class="col-sm-12">تصاویر</h2>
                                    <img style="margin: 20px;" src="{{ is_null($show)? "" : $show->thumb_url}}">
                                    <img style="margin: 20px;" src="{{ is_null($show)? "" : $show->main_image_url}}">
                                    <span class="col-sm-4 btn btn-primary show-cover up">انتخاب عکس</span>


                                    <div class="cover-popup">

                                        <div class="container ">
                                            <div class="imageBox">
                                                <div class="thumbBox"></div>
                                                <div class="spinner" style="display: none">لطفا صبر کنید...</div>
                                            </div>
                                            <div class="action">
                                                <input type="file" id="file" style="float:left; width: 250px"
                                                       name="cover">
                                                <span id="btnCrop">برش</span>
                                                <span id="btnZoomIn" class="fa fa-search-plus icon"></span>
                                                <span id="btnZoomOut" class="fa  fa-search-minus icon"></span>
                                            </div>
                                            <input name="thumb" type="hidden" value="" class="img1">
                                            <input name="cover" type="hidden" value="" class="img2">
                                            <div class="cropped">
                                                <div style="margin: 20px;"><span href="#"
                                                                                 class="btn btn-danger dl-crop-img">حذف</span>
                                                </div>


                                            </div>
                                        </div>

                                    </div>
                                </div>


                                <div class="hr-line-dashed"></div>

                                <div class="form-group">

                                    <label class="col-sm-1 control-label">شهر</label>
                                    <div class="col-sm-5"><select class="form-control m-b" name="city_id">
                                            @foreach(\App\Models\City::all() as $city)
                                                <option value="{{ $city->id }}">{{ $city->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <label class="col-sm-1 control-label">سالن</label>
                                    <div class="col-sm-5"><select class="form-control m-b salon"
                                                                  name="scene" {{ !is_null($show) ? 'disabled' : ''}}>
                                            @foreach(\App\Models\Scene::whereSourceId(1)->get() as $scene)
                                                <option value="{{ $scene->id }}" {{ is_null($show) ? '' : $show->scene->id == $scene->id ? ' selected="selected"' : '' }}>{{ $scene->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>


                                <div class="row">

                                    @isset($show)
                                        @if($show->source_id == 1)

                                            @foreach($show->showtimes as $showtime)
                                                <div class="col-sm-12">
                                                    <h2 style="padding: 20px;">بلیت‌های
                                                        سانس {{ \SeebBlade::prettyDate($showtime->datetime) }}</h2>
                                                    <table class="footable table table-stripped toggle-arrow-tiny">
                                                        <thead>
                                                        <tr>
                                                            <th>‍‍جایگاه</th>
                                                            <th>کل صندلی ها</th>
                                                            <th>صندلی‌های قیمت‌گذاری شده</th>
                                                            <th>صندلی‌های غیرقابل فروش</th>
                                                            <th>صندلی‌های باقی‌مانده</th>
                                                            <th>ارزش صندلی‌ها</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>

                                                        @foreach($showtime->seatDetails()['zones'] as $zone)
                                                            <tr>
                                                                <td>{{ $zone['name'] }}</td>
                                                                <td>{{ $zone['seats_count'] }}</td>
                                                                <td>{{ $zone['priced_count'] }}</td>
                                                                <td>{{ $zone['disabled_count'] }}</td>
                                                                <td>{{ $zone['seats_count'] - ($zone['disabled_count'] + $zone['priced_count']) }}</td>
                                                                <td>{{ number_format($zone['worth']) }}</td>
                                                            </tr>
                                                        @endforeach

                                                        </tbody>

                                                    </table>
                                                </div>
                                            @endforeach
                                        @endif
                                    @else

                                        <div class="col-sm-12">
                                            <h2 style="padding: 20px;">بلیت‌ها</h2>
                                            <table class="footable table table-stripped toggle-arrow-tiny">
                                                <thead>
                                                <tr>
                                                    <th>‍‍جایگاه</th>
                                                    <th>کل صندلی ها</th>
                                                    <th>صندلی‌های قیمت‌گذاری شده</th>
                                                    <th>صندلی‌های غیرقابل فروش</th>
                                                    <th>صندلی‌های باقی‌مانده</th>
                                                    <th>ارزش صندلی‌ها</th>
                                                </tr>
                                                </thead>
                                                <tbody class="tabAddHere">

                                                </tbody>

                                            </table>
                                        </div>

                                    @endisset

                                    <div class="col-sm-12">
                                        <div class="form-group input-margin">

                                            <div class="col-sm-12">
                                                <span class="btn btn-primary  col-sm-4 disable-show-chair {{ !is_null($show) ? 'hidden':'' }}">ثبت صندلی</span>
                                            </div>

                                            <div class="col-sm-12 final-grid-price">
                                                <input class="array-seat" name="priced_seats"
                                                       value="{{ old('priced_seats')  }}" type="hidden"/>
                                                <input class="array-dis" name="disabled_seats"
                                                       value="{{ old('disabled_seats') }}" type="hidden"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                    <div class="form-group">

                                        <label class="col-sm-2 control-label">آیا برنامه بدون صندلی است ؟</label>
                                        <div class="col-sm-1">
                                            <select class="form-control m-b " name="auto_selection">
                                                <option value="0" {{is_null($show) ? '' :$show->auto_selection == 0 ? 'selected="selected"':''}}>خیر</option>
                                                <option value="1" {{is_null($show) ? '' :$show->auto_selection == 1 ? 'selected="selected"':''}}>بله</option>
                                            </select>
                                        </div>
                                        {{--<div class="col-sm-8 " style="padding-top: 6px">--}}
                                            {{--<label> <input type="checkbox" name="auto_selection"> بله </label>--}}
                                        {{--</div>--}}

                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-2 control-label"
                                               for="description">آیا برنامه فقط به صورت رزرو و رایگان است ؟</label>
                                        <div class="col-sm-1">
                                            <select class="form-control m-b " name="freeReserve">
                                                <option value="0" {{is_null($show) ? '' : $show->free == 0 ? 'selected="selected"':''}}>خیر</option>
                                                <option value="1" {{is_null($show) ? '' : $show->free == 1 ? 'selected="selected"':''}}>بله</option>

                                            </select>
                                        </div>

                                    </div>

                                <div class="hr-line-dashed"></div>
                                <div class="form-group"><label class="col-sm-2 control-label"
                                                               for="description">قوانین</label>
                                    <div class="col-sm-8"><textarea name="rules"
                                                                    class="form-control textarea-dir jqte-test">{{ is_null($show)? "" : $show->terms_of_service }} </textarea>

                                    </div>
                                </div>


                                <div class="form-group sans-have">
                                    <div class="row">
                                        <label class="col-sm-3 label-title ">تهیه کننده</label>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-10">
                                            <label class="col-sm-1 control-label">تهیه کننده</label>
                                            <div class="col-sm-5">
                                                @if(Auth::user()->access_level == 10)
                                                    <select class="form-control m-b" name="admin_id">
                                                        @foreach(\App\User::where('access_level', '>=',5)->get() as $user)
                                                            <option value="{{$user->id}}">{{$user->fullName()}}</option>
                                                        @endforeach
                                                    </select>
                                                @else
                                                    <select class="form-control m-b" name="admin_id">

                                                        <option value="{{Auth::user()->id}}">{{Auth::user()->fullName()}}</option>

                                                    </select>
                                                @endif
                                            </div>
                                            <!-- <label class="col-sm-2 control-label">نام و نام خانوادگی</label>
                                            <div class="form-group col-md-4"><input type="text" placeholder="" class="form-control"></div>
                                            <label class="col-sm-2 control-label">شماره تماس</label>
                                            <div class="form-group  col-md-4"><input type="text" placeholder="" class="form-control"></div>
                                            <label class="col-sm-2 control-label">شماره شناسنامه</label>
                                            <div class="form-group  col-md-4"><input type="text" placeholder="" class="form-control"></div>
                                           !-->
                                        </div>
                                    </div>
                                </div>


                                <div class="hr-line-dashed"></div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label"
                                           for="description">مجوز</label>
                                    <div class="col-sm-8">
                                        <input type="file" name="license_file" id="liin">
                                        <div style="display: none" id="li"></div>
                                    </div>

                                </div>



                                <div class="hr-line-dashed"></div>
                                <div class="row">
                                    <label class="col-sm-3 label-title ">اسپانسر</label>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label"
                                                               for="description">۱. نام و لوگو شرکت برگزارکننده</label>

                                    <div class="col-sm-8">

                                        <input name="logo1" type="hidden" id="logo1i">
                                        <input name="logo2" type="hidden" id="logo2i">
                                        <input name="license" type="hidden" id="licensei">


                                        <input type="text"
                                               value="{{ is_null($show)? "" : (count($show->sponsors) > 0 ? $show->sponsors[0]['name'] : '' ) }}"
                                               name="sponsor1-name" style="margin-bottom: 20px;">
                                        <br>
                                        <input type="file" name="sp1" id="sp1">
                                        <div style="display: none" id="sponsor1-logo"></div>

                                        <br>
                                        <img width="100px"
                                             src="{{ is_null($show)? "" : (count($show->sponsors) > 0 ? $show->sponsors[0]['logo_url'] : '' ) }}"/>
                                    </div>
                                </div>
                                <div class="form-group"><label class="col-sm-2 control-label" for="description">۲. نام و
                                        لوگو اسپانسر</label>
                                    <div class="col-sm-8">
                                        <input type="text"
                                               value="{{ is_null($show)? "" : (count($show->sponsors) > 1 ? $show->sponsors[1]['name'] : '' ) }}"
                                               name="sponsor2-name" style="margin-bottom: 20px;">
                                        <br>
                                        <input type="file" name="sp2" id="sp2">
                                        <div style="display: none" id="sponsor2-logo"></div>


                                        <br>
                                        <img width="100px"
                                             src="{{ is_null($show)? "" : (count($show->sponsors) > 1 ? $show->sponsors[1]['logo_url'] : '' ) }}"/>
                                    </div>
                                </div>

                                @if(Auth::user()->access_level == 10)
                                    <div class="form-group">
                                        <div class="form-group input-margin">
                                            <label class="col-sm-2 control-label">وضعیت</label>
                                            <div class="col-sm-4">
                                                <select class="form-control m-b " style="margin-right: 8px;"
                                                        name="status">
                                                    <option value="disabled" {{ is_null($show) ? '' : $show->status == 'disabled' ? ' selected="selected"' : '' }}>{{ trans('showstatus.disabled') }}</option>
                                                    <option value="enabled"{{ is_null($show) ? '' : $show->status == 'enabled' ? ' selected="selected"' : '' }}>{{ trans('showstatus.enabled') }}</option>
                                                    <option value="finished"{{ is_null($show) ? '' : $show->status == 'finished' ? ' selected="selected"' : '' }}>{{ trans('showstatus.finished') }}</option>
                                                    <option value="canceled"{{ is_null($show) ? '' : $show->status == 'canceled' ? ' selected="selected"' : '' }}>{{ trans('showstatus.canceled') }}</option>
                                                    <option value="pending"{{ is_null($show) ? '' : $show->status == 'pending' ? ' selected="selected"' : '' }}>{{ trans('showstatus.pending') }}</option>
                                                    <option value="hidden"{{ is_null($show) ? '' : $show->status == 'hidden' ? ' selected="selected"' : '' }}>{{ trans('showstatus.hidden') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="form-group input-margin">
                                            <label class="col-sm-2 control-label">وضعیت بلیط</label>
                                            <div class="col-sm-4">
                                                <select class="form-control m-b " style="margin-right: 8px;"
                                                        name="ticket_status">
                                                    <option value="none" {{ is_null($show) ? '' : $show->ticket_status == 'none' ? ' selected="selected"' : '' }}>
                                                        هیچ
                                                    </option>
                                                    <option value="renewed"{{ is_null($show) ? '' : $show->ticket_status == 'renewed' ? ' selected="selected"' : '' }}>
                                                        تمدید شد
                                                    </option>
                                                    <option value="soon"{{ is_null($show) ? '' : $show->ticket_status == 'soon' ? ' selected="selected"' : '' }}>
                                                        به زودی
                                                    </option>
                                                    <option value="sold_out"{{ is_null($show) ? '' : $show->ticket_status == 'sold_out' ? ' selected="selected"' : '' }}>
                                                        اتمام بلیت
                                                    </option>

                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                @endif


                                <div class="form-group">
                                    <div class="col-sm-12 col-sm-offset-2 send-ev">
                                        <a class="btn btn-danger"
                                           href="{{ route('shows/list', ['category_id' => 1]) }}">بیخیال</a>
                                        {{--<span class="btn btn-primary create-show-send">ثبت و ذخیره</span>--}}
                                        <input type="submit" class="btn btn-primary create-show-send">ثبت و ذخیره</input>

                                    </div>
                                </div>
                            </form>


                        </div>
                        <div class="tab-pane {{ session('activeTab') == 1 ? 'active' : '' }}" id="tab-2">

                            <form action="{{route('shows/import')}}" method="post">
                                {{ csrf_field() }}
                                @if(session('importError'))
                                    <div class="alert alert-danger">
                                        <strong>{{session('importError')}}</strong>
                                    </div>
                                @endif
                                <div class="form-group">


                                    <label class="col-sm-2 control-label">منبع</label>
                                    <div class="col-sm-10">
                                        <select class="form-control m-b" name="source_id">
                                            @foreach(\App\Models\Source::where('id','>',1)->get() as $source)
                                                <option value="{{$source->id}}">{{$source->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">دسته بندی</label>
                                    <div class="col-sm-10">
                                        <select class="form-control m-b" name="category_id">
                                            @foreach(\App\Models\Category::all() as $category)
                                                <option value="{{$category->id}}">{{$category->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">شهر</label>
                                    <div class="col-sm-10">
                                        <select class="form-control m-b" name="city_id">
                                            @foreach(\App\Models\City::all() as $city)
                                                <option value="{{$city->id}}">{{$city->name}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>
                                <label class="col-sm-1 control-label">شهر</label>
                                <div class="col-sm-5"><select class="form-control m-b" name="city_id">
                                        @foreach(\App\Models\City::all() as $city)
                                            <option value="{{ $city->id }}">{{ $city->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                {{--                                @if(Auth::user()->access_level == 10)--}}
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">تهیه کننده (مدیر)</label>
                                    <div class="col-sm-10">
                                        <select class="form-control m-b" name="admin_id">
                                            @foreach(\App\User::where('access_level', '>=',5)->get() as $user)
                                                <option value="{{$user->id}}">{{$user->fullName()}}</option>
                                            @endforeach
                                        </select>

                                    </div>
                                </div>


                                <div class="col-sm-12">
                                    <label class="col-sm-2 control-label">رنگ پس زمینه</label>
                                    <div class="col-sm-6">
                                        <div class="color-pal">
                                            <div class="color-pal-cus" style="background: #E9B85C">#E9B85C</div>
                                            <div class="color-pal-cus" style="background: #FAD1AA">#FAD1AA</div>
                                            <div class="color-pal-cus" style="background: #EA7F3E">#EA7F3E</div>
                                            <div class="color-pal-cus" style="background: #F1D04B">#F1D04B</div>
                                            <div class="color-pal-cus" style="background: #F67355">#F67355</div>
                                            <div class="color-pal-cus" style="background: #F04427">#F04427</div>
                                            <div class="color-pal-cus" style="background: #D64936">#D64936</div>
                                            <div class="color-pal-cus" style="background: #BA1A0F">#BA1A0F</div>
                                            <div class="color-pal-cus" style="background: #F9B0B1">#F9B0B1</div>
                                            <div class="color-pal-cus" style="background: #EB98BC">#EB98BC</div>
                                            <div class="color-pal-cus" style="background: #F77378">#F77378</div>
                                            <div class="color-pal-cus" style="background: #C62564">#C62564</div>
                                            <div class="color-pal-cus" style="background: #B46B6B">#B46B6B</div>
                                            <div class="color-pal-cus" style="background: #E5265F">#E5265F</div>
                                            <div class="color-pal-cus" style="background: #75838C">#75838C</div>
                                            <div class="color-pal-cus" style="background: #9F91D0">#9F91D0</div>
                                            <div class="color-pal-cus" style="background: #635875">#635875</div>
                                            <div class="color-pal-cus" style="background: #70D5D8">#70D5D8</div>
                                            <div class="color-pal-cus" style="background: #64DBFC">#64DBFC</div>
                                            <div class="color-pal-cus" style="background: #00BAFC">#00BAFC</div>
                                            <div class="color-pal-cus" style="background: #2C9BD1">#2C9BD1</div>
                                            <div class="color-pal-cus" style="background: #537B9D">#537B9D</div>
                                            <div class="color-pal-cus" style="background: #2D8AA0">#2D8AA0</div>
                                            <div class="color-pal-cus" style="background: #8FB9E2">#8FB9E2</div>
                                            <div class="color-pal-cus" style="background: #64BCCE">#64BCCE</div>
                                            <div class="color-pal-cus" style="background: #B0DCC9">#B0DCC9</div>
                                            <div class="color-pal-cus" style="background: #C4CC9D">#C4CC9D</div>
                                            <div class="color-pal-cus" style="background: #8CA853">#8CA853</div>
                                            <div class="color-pal-cus" style="background: #6DD227">#6DD227</div>
                                            <div class="color-pal-cus" style="background: #1ED6BD">#1ED6BD</div>
                                            <div class="color-pal-cus" style="background: #407B57">#407B57</div>
                                            <div class="color-pal-cus" style="background: #B1AFB0">#B1AFB0</div>
                                            <div class="color-pal-cus" style="background: #C8C4B3">#C8C4B3</div>
                                            <div class="color-pal-cus" style="background: #A99A7B">#A99A7B</div>
                                            <div class="color-pal-cus" style="background: #8F5C2E">#8F5C2E</div>
                                            <div class="color-pal-cus" style="background: #B1532E">#B1532E</div>
                                            <div class="color-pal-cus" style="background: #BB7952">#BB7952</div>

                                            <input name="color" type="text" class="form-control colorcat"
                                                   value="{{!is_null($show)? $show->background_color: old('background_color')}}">
                                            <input type='text' class="basic"/></div>


                                    </div>
                                </div>


                                <div class="form-group">
                                    <label class="col-sm-2 control-label">لینک به صفحه اصلی رویداد</label>
                                    <div class="col-sm-6">
                                        <input type="text" class="form-control" name="url" value="{{ old('url') }}">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">ثبت</button>
                                </div>
                            </form>

                        </div>


                    </div>

                </div>

            </div>


        </div>
    </div>
</div>


<script type="text/javascript">


    window.onload = function () {

        $('.jqte-test').jqte();
        var jqteStatus = true;
        $(".status").click(function () {
            jqteStatus = jqteStatus ? false : true;
            $('.jqte-test').jqte({"status": jqteStatus})
        });


        $('#timepicker1').timepicki();
        var i = 0;
        $("body").delegate("span.dl-crop-img", "click", function () {
            $(".dl-crop-img").fadeOut();

            $('div.img-croped-fa').remove();
            i = 0;
            if (i <= 1) {
                $(".thumbBox").css({
                    'height': '600px'
                })
            } else {
                $(".thumbBox").css({
                    'height': '400px'
                })
            }

        });
        var up = false;
        var options =
            {
                imageBox: '.imageBox',
                thumbBox: '.thumbBox',
                spinner: '.spinner',
                imgSrc: 'avatar.png'
            }
        var cropper;
        document.querySelector('#file').addEventListener('change', function () {
            up = true;
            var reader = new FileReader();
            reader.onload = function (e) {
                options.imgSrc = e.target.result;
                cropper = new cropbox(options);
            }
            reader.readAsDataURL(this.files[0]);

        })
        document.querySelector('#btnCrop').addEventListener('click', function () {


            if (i < 2) {
                i++;

                var img = cropper.getDataURL();
                if (i == 1) {
                    $(".dl-crop-img").fadeIn();

                    $('.img1').val(img);
                } else {
                    $('.img2').val(img);
                }
                document.querySelector('.cropped').innerHTML += '<div class="img-croped-fa">' +
                    ' <img src="' + img + '">' +
                    '</div>';
                if (i == 1 && up == true) {
                    $(".thumbBox").css({
                        'width': '100%',
                        'left': '0',
                        'right': '0'
                    })
                }
            }
        })
        document.querySelector('#btnZoomIn').addEventListener('click', function () {
            cropper.zoomIn();
        })
        document.querySelector('#btnZoomOut').addEventListener('click', function () {
            cropper.zoomOut();
        })
    };
</script>

@include('panel.layouts.footer')

<script type="text/javascript">

    $('#pcal1').pDatepicker({
        format: 'YYYY/MM/DD',
        initialValue: true,
        initialValueType: 'persian',
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: true
            }
        }
    });
    $('#pcal2').pDatepicker({
        format: 'YYYY/MM/DD',
        initialValue: true,
        initialValueType: 'persian',
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: true
            }
        }
    });
    $('#pcal10001').pDatepicker({
        format: 'YYYY/MM/DD HH:mm',
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: true
            }
        }
    });
    $('#pcal3').pDatepicker({
        format: 'YYYY/MM/DD HH:mm',
        timePicker: {
            enabled: true,
            meridiem: {
                enabled: true
            }
        }
    });


</script>
{{--<script>--}}

    {{--function readFilwe() {--}}

        {{--if (this.files && this.files[0]) {--}}

            {{--var FRt = new FileReader();--}}

            {{--FRt.addEventListener("load", function (e) {--}}
                {{--$('#logo1i').val(e.target.result)--}}

            {{--});--}}
            {{--FRt.readAsDataURL(this.files[0]);--}}
        {{--}--}}
    {{--}--}}


    {{--function readFilee() {--}}

        {{--if (this.files && this.files[0]) {--}}

            {{--var FRe = new FileReader();--}}

            {{--FRe.addEventListener("load", function (e) {--}}
                {{--$('#logo2i').val(e.target.result)--}}

            {{--});--}}
            {{--FRe.readAsDataURL(this.files[0]);--}}
        {{--}--}}
    {{--}--}}

    {{--function li() {--}}

        {{--if (this.files && this.files[0]) {--}}

            {{--var FRl = new FileReader();--}}

            {{--FRl.addEventListener("load", function (e) {--}}
                {{--$('#licensei').val(e.target.result)--}}

            {{--});--}}
            {{--FRl.readAsDataURL(this.files[0]);--}}
        {{--}--}}
    {{--}--}}

    {{--document.getElementById("sp1").addEventListener("change", readFilwe);--}}
    {{--document.getElementById("sp2").addEventListener("change", readFilee);--}}
    {{--document.getElementById("liin").addEventListener("change", li);--}}


    {{--$(".create-show-send").click(function () {--}}
        {{--$('.pop-loading').fadeIn();--}}


        {{--var dataF = $("#myForm").serialize();--}}


        {{--dataF['_token'] = "{{ csrf_token() }}";--}}

        {{--$.post("{{route('shows/save')}}",--}}
            {{--dataF,--}}
            {{--function (data, status) {--}}
                {{--console.log(data)--}}
                {{--if (data.result == true) {--}}
                    {{--$('.pop-loading').fadeOut();--}}
                    {{--alert('با موفقیت ثبت شد');--}}
                    {{--window.location.href = "{{route('shows/list', ['category_id' => 1])}}";--}}
                {{--} else {--}}
                    {{--$('.pop-loading').fadeOut();--}}
                    {{--$('.alert-danger strong').fadeIn();--}}
                    {{--$('.alert-danger strong').text(data.errors);--}}
                    {{--alert(data.errors);--}}
                    {{--// console.log(data +" = "+ data.errors);--}}

                {{--}--}}

            {{--});--}}

    {{--});--}}

{{--</script>--}}

{{--<script type="application/javascript">--}}


    {{--$(".basic").spectrum({--}}
        {{--color: "#f00",--}}
        {{--change: function (color) {--}}
            {{--$(".colorcat").val(color.toHexString());--}}
        {{--}--}}
    {{--});--}}


    {{--$(document).ready(function () {--}}

        {{--$(document).ready(function () {--}}

            {{--$('.select-all-ch-this').click(function () {--}}
                {{--$('.selected-view-of-chair span').addClass('ui-selected')--}}
            {{--});--}}


            {{--$("body").delegate(".color-pal-cus", "click", function () {--}}
                {{--$('.colorcat').val($(this).text())--}}
            {{--});--}}


            {{--var selectedScene = 0;--}}
            {{--selectedScene = $('.salon option:selected').val();--}}

            {{--$.ajax({--}}
                {{--url: "{{route('scene/get')}}/" + selectedScene, success: function (result) {--}}

                    {{--$(".res_back").html(result);--}}
                {{--}--}}
            {{--});--}}

            {{--$(".salon").change(function () {--}}
                {{--var salonId = $('.salon option:selected').val();--}}
                {{--selectedScene = salonId;--}}

                {{--$.ajax({--}}
                    {{--url: "{{route('scene/get')}}/" + salonId, success: function (result) {--}}
                        {{--$(".res_back").html(result);--}}

                        {{--con();--}}

                    {{--}--}}
                {{--});--}}

            {{--});--}}

        {{--});--}}
    {{--});--}}
{{--</script>--}}