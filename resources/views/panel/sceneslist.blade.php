@include('panel.layouts.header')
@include('panel.layouts.menu')

<div id="page-wrapper" class="gray-bg" >
    @include('panel.layouts.search-navbar')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-10">
            <h2>سالن ها</h2>
        </div>
        <div class="col-lg-2">
            <a href="{{route('newScene')}}"  class="btn btn-primary" style="float: left;margin-bottom: 20px;">ساخت سالن جدید</a>
        </div>

        <div class="col-lg-12">
            <table class="footable table table-stripped toggle-arrow-tiny">
                <thead>
                <tr>
                    <th> نام سالن </th>
                    <th>شهر</th>
                    <th> تعداد صندلی </th>
                    <th> تعداد جایگاه </th>
                    <th> تاریخ ساخت </th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                @foreach($scenes as $scene)
                    <tr>
                        <td>{{ $scene->name }}</td>
                        <td>{{ $scene->city }}</td>
                        <td>{{ $scene->seats_count }}</td>
                        <td>{{ $scene->zones()->count() }}</td>
                        <td>{{ \SeebBlade::prettyDate($scene->created_at) }}</td>
                        <td>
                            @if($scene->showtimes()->count() == 0)
                                <a class="btn btn-sm btn-danger deleat-sce" data="{{route('scenes/delete',['id' => $scene->id])}}">حذف</a>
                            @endif
                            <a href="{{route('scene/edit',['id' => $scene->id])}}" class="btn btn-sm btn-primary" >کپی</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



    </div>

</div>
@include('panel.layouts.footer')
<script >


    $( "body" ).delegate( ".deleat-sce", "click", function() {
        var txt;
        var r = confirm("مطمئن هستید؟");
        if (r == true) {
            window.location = $(this).attr('data');
        } else {

        }
        // $(this).parents('div.price-row').remove();
    });
</script>
