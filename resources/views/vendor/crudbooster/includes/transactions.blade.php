
<div class="row clearfix">
    <div class="col-lg-8 col-md-8">
        <div class="card product-report box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Transaction Report <small>Number of Purchase: {{ $date_start->format('d F Y') }} - {{ $date_end->format('d F Y') }}</small></h3>
            </div>
            <div class="box-body">
                <div class="chart">
                    <!-- Sales Chart Canvas -->
                    <canvas id="salesChart" style="height: 450px;"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 col-md-12">
        <div class="card tasks_report box box-solid">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Order Status</h3>
            </div>
            <div class="box-body">
                <ul class="country-state list-unstyled">
                    <li class="m-b-20">
                        <h4><a href="{{ route('AdminOrdersControllerGetIndex') }}">Waiting Payment</a></h4>
                        <small>{{ $total_order_waiting }} Orders</small>
                        <div class="pull-right">
                        {{ $total_order>0 ? ceil($total_order_waiting / $total_order * 100) : '0'}}%
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="{{ $total_order_waiting }}" aria-valuemin="0" aria-valuemax="{{ $total_order }}" style="width:{{ $total_order>0 ? ceil($total_order_waiting / $total_order * 100) : '0'}}%;">
                                <span class="sr-only">{{ $total_order>0 ? ceil($total_order_waiting / $total_order * 100) : '0'}}% Complete</span>
                            </div>
                        </div>
                    </li>
                    <li class="m-b-20">
                        <h4><a href="{{ route('AdminOrderPaidControllerGetIndex') }}">Payment Accepted</a></h4>
                        <small>{{ $total_order_payment }} Orders</small>
                        <div class="pull-right">
                            {{ $total_order>0 ? ceil($total_order_payment / $total_order * 100) : '0'}}%
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{ $total_order_payment }}" aria-valuemin="0" aria-valuemax="{{ $total_order }}" style="width:{{ $total_order>0 ? ceil($total_order_payment / $total_order * 100) : '0'}}%;">
                                <span class="sr-only">{{ $total_order>0 ? ceil($total_order_payment / $total_order * 100) : '0'}}% Complete</span>
                            </div>
                        </div>
                    </li>
                    <li class="m-b-20">
                        <h4><a href="{{ route('AdminOrderOnDeliveryControllerGetIndex') }}">Order On Delivery</a></h4>
                        <small>{{ $total_order_shipped }} Orders</small>
                        <div class="pull-right">
                            {{ $total_order>0 ? ceil($total_order_shipped / $total_order * 100) : '0'}}%
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-primary" role="progressbar" aria-valuenow="{{ $total_order_shipped }}" aria-valuemin="0" aria-valuemax="{{ $total_order }}" style="width:{{ $total_order>0 ? ceil($total_order_shipped / $total_order * 100) : '0'}}%;">
                                <span class="sr-only">{{ $total_order>0 ? ceil($total_order_shipped / $total_order * 100) : '0'}}% Complete</span>
                            </div>
                        </div>
                    </li>
                    <li class="m-b-20">
                        <h4><a href="{{ route('AdminOrderCompletedControllerGetIndex') }}">Completed Order</a></h4>
                        <small>{{ $total_order_complete }} Orders</small>
                        <div class="pull-right">
                            {{ $total_order>0 ? ceil($total_order_complete / $total_order * 100) : '0'}}%
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="{{ $total_order_complete }}" aria-valuemin="0" aria-valuemax="{{ $total_order }}" style="width:{{ $total_order>0 ? ceil($total_order_complete / $total_order * 100) : '0'}}%;">
                                <span class="sr-only">{{ $total_order>0 ? ceil($total_order_complete / $total_order * 100) : '0'}}% Complete</span>
                            </div>
                        </div>
                    </li>
                    <li class="m-b-20">
                        <h4><a href="{{ route('AdminOrderFailedControllerGetIndex') }}">Failed Order</a></h4>
                        <small>{{ $total_order_failed }} Orders</small>
                        <div class="pull-right">
                            {{ $total_order>0 ? ceil($total_order_failed / $total_order * 100) : '0'}}%
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="{{ $total_order_failed }}" aria-valuemin="0" aria-valuemax="{{ $total_order }}" style="width:{{ $total_order>0 ? ceil($total_order_failed / $total_order * 100) : '0'}}%;">
                                <span class="sr-only">{{ $total_order>0 ? ceil($total_order_failed / $total_order * 100) : '0'}}% Complete</span>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
