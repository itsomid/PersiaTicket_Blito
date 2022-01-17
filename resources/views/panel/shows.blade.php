@include('panel.layouts.header')
@include('panel.layouts.menu')

    <div id="page-wrapper" class="gray-bg">
        @include('panel.layouts.search-navbar')
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="col-lg-10">
                <h2>{{ $category->name }} ها</h2>
            </div>
            <table class="footable table table-stripped toggle-arrow-tiny">
                <thead>
                <tr>
                    <th><a href="?sortby=id" class="dir-a" id="1" >کد نمایش</a> </th>
                    <th><a href="?sortby=title" class="dir-a" id="2"  >نام برنامه</a> </th>
                    <th><a href="?sortby=from_date" class="dir-a" id="3"  >تاریخ شروع</a> </th>
                    <th><a href="?sortby=to_date" class="dir-a" id="4"  >تاریخ پایان</a> </th>
                    <th><a href="?sortby=city_id" class="dir-a" id="5"  >شهر سالن</a> </th>
                    <th><a href="?sortby=admin_id" class="dir-a" id="6"  >تهیه کننده</a> </th>
                    <th><a href="?sortby=source_id" class="dir-a" id="7"  >منبع</a> </th>
                    <th><a href="?sortby=status" class="dir-a" id="8"  >وضعیت</a> </th>
                    @if(Auth::user()->access_level == 10)
                    <th><a href="?sortby=#" class="dir-a" id="9"  >کاور</a> </th>
                    @endif
                    <th><a href="?sortby=#" class="dir-a" id="10"  >مشاهده</a> </th>
                </tr>
                </thead>
                <tbody>
                @foreach($shows as $show)
                 <tr>
                    <td>{{$show->uid}}</td>
                    <td>{{$show->title}}</td>
                    <td>{{ SeebBlade::prettyDateWithFormat($show->from_date, 'dd MMM yyyy') }}</td>
                     <td>{{ SeebBlade::prettyDateWithFormat($show->to_date, 'dd MMM yyyy') }}</td>
                    <td>{{ $show->city->name }}</td>
                    <td>{{ $show->admin->fullName() }}</td>
                    <td>{{ $show->source->title }}</td>
                    <td>{{ trans('showstatus.'.$show->status) }}</td>
                     @if(Auth::user()->access_level == 10)
                    <td>
                        @if($show->is_cover == 0)
                            <a href="{{ route('shows/set/cover',['id'=>$show->uid]) }}" class="btn btn-sm " >  کاور بشه</a>
                        @elseif($show->is_cover == 1)
                            <span class="btn btn-danger" > کاور است</span>
                        @endif
                    </td>
                     @endif
                    <td><a href="{{ route('shows/show', ['id' => $show->uid]) }}" class="btn btn-sm btn-primary"  > نمایش</a> </td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

@include('panel.layouts.footer')

<script type="text/javascript">
    $(document).ready(function () {
    $('.dir-a').click(function () {
        $('.dir-a').removeClass('active_th_a');
        $(this).addClass('active_th_a');
        var sort_id = $('.active_th_a').attr('id') ;
        // alert('omid sort id = '+ sort_id) ;



    });
    });
</script>
