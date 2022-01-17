@include('panel.layouts.header')
@include('panel.layouts.menu')

    <div id="page-wrapper" class="gray-bg">
        @include('panel.layouts.search-navbar')
        <div class="wrapper wrapper-content animated fadeInRight">
            <div class="col-lg-10">
                <h2>پرداخت‌ها</h2>
            </div>
            <table class="footable table table-stripped toggle-arrow-tiny">
                <thead>
                <tr>
                    <th>شماره تراکنش</th>
                    <th>کاربر</th>
                    <th>تاریخ</th>
                    <th>مبلغ</th>
                    <th>شماره پیگیری</th>
                    <th>فاکتور</th>
                    <th>وضعیت</th>

                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                 <tr>
                    <td>{{$payment->uid}}</td>
                    <td>{{$payment->user->fullName()}}</td>
                    <td>{{ SeebBlade::prettyDate($payment->updated_at) }}</td>
                     <td>{{ $payment->amount }}</td>
                     <td>{{ property_exists($payment->details(),'reference_id')? $payment->details()->reference_id : "-" }}</td>
                    <td>
                        @if(is_null($payment->order))
                            -
                        @else
                            {{ $payment->order->uid }}
                        @endif
                    </td>
                    <td>{{ trans('status.'.$payment->status) }}</td>
                </tr>
                @endforeach

                </tbody>
            </table>
        </div>
    </div>

@include('panel.layouts.footer')
