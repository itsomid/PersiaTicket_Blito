@include('panel.layouts.header')
@include('panel.layouts.menu')

<div id="page-wrapper" class="gray-bg">
    @include('panel.layouts.search-navbar')
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="col-lg-10">
            <h2>کدهای تخفیف</h2>
        </div>
        <table class="footable table table-stripped toggle-arrow-tiny">
            <thead>
            <tr>

            </tr>
            </thead>
            <tbody>
            @foreach($promotions as $promotion)
            {{ $promotion->code }}
            @endforeach
            </tbody>
        </table>
    </div>
</div>

@include('panel.layouts.footer')
