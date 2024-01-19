<!-- First you need to extend the CB layout -->
@extends('crudbooster::admin_template')
@section('content')

<div class="row" style="margin-bottom: 20px;">
    <div class="col-md-12">
        <div id="reportrange" class="pull-right form-inline">
            <div class="input-group">
                {{-- {{ dd($date_start) }} --}}
                <span class="form-control" id="dashboard_date">{{ $date_start->format('d M Y') }} - {{ $date_end->format('d M Y') }}</span>
                <div class="input-group-addon">
                    <i class="fas fa-calendar-alt"></i>&nbsp;<b class="caret"></b>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="dashboard-content">
    <div class="ajax">
        @include('vendor.crudbooster.includes.summary')
        @include('vendor.crudbooster.includes.transactions')
        @include('vendor.crudbooster.includes.scripts')

        <div class="row clearfix">
            <div class="col-md-12 col-lg-12">
                <div class="card visitors-map box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Puchase Value <small>Value of Purchase: {{ $date_start->format('d F Y') }} - {{ $date_end->format('d F Y') }}</small></h3>
                    </div>
                    <div class="box-body">
                        <div class="chart">
                            <canvas id="salesValueChart" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row clearfix" id="print_this_chart">
            <div class="col-lg-12 col-md-12">
                <div class="card product-report box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Analytics Report <small>Number of Visitors: {{ $date_start->format('d F Y') }} - {{ $date_end->format('d F Y') }}, updated every 60 minutes</small></h3>
                        <a href="#" class="btn btn-info pull-right" id="print_cart"><i class="fa fa-download"></i> Export</a>
                    </div>
                    <div class="box-body">
                        <div class="chart" id="analytic_data">
                            <!-- Sales Chart Canvas -->
                            <canvas id="visitorChart" style="height: 450px;"></canvas>
                        </div>
                    </div>
                </div>
            </div>

        </div>


        <div class="row clearfix">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Top 10 Customers <small>Based On Total Value</small></h3>
                        <a href="#" class="btn btn-info pull-right" id="export_top_cust" data-start="{{ $date_start->format('Y-m-d') }}" data-end="{{ $date_end->format('Y-m-d') }}"><i class="fa fa-download"></i> Export</a>
                    </div>
                    <div class="body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Order</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($top_customer as $index => $customer)
                                <tr>
                                    <th scope="row">{{ $index+1 }}</th>
                                    <td><a href="{{ route('AdminMemberManagementControllerGetEdit', $customer->user->id) }}">{{ $customer->user->name }} - {{ $customer->user->email }}</a></td>
                                    <td>{{ $customer->count }}</td>
                                    <td>{{ currency_format($customer->total_order) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Top 10 Selling Product <small>Based On Total Value</small></h3>
                        <a href="#" class="btn btn-info pull-right" id="export_top_sell" data-start="{{ $date_start->format('Y-m-d') }}" data-end="{{ $date_end->format('Y-m-d') }}"><i class="fa fa-download"></i> Export</a>
                    </div>
                    <div class="body table-responsive" id="top_sell_div">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Quantity Sold</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($top_products as $index => $product)
                                <tr>
                                    <th scope="row">{{ $index+1 }}</th>
                                    <td><a href="{{ route('AdminProductsControllerGetEdit', $product->id) }}">{{ ucwords($product->product->full_name) }}</a></td>
                                    <td>{{ $product->count }}</td>
                                    <td>{{ currency_format($product->total_order) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


        <div class="row clearfix">
            <div class="col-xl-6 col-lg-6 col-md-6">
                <div class="card box box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title">Most Views Product</h3>
                        <a href="#" class="btn btn-info pull-right" id="export_top_view"><i class="fa fa-download"></i> Export</a>
                    </div>
                    <div class="body table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Product</th>
                                    <th>Value</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($top_product as $index => $product)
                                <tr>
                                    <th scope="row">{{ $index+1 }}</th>
                                    <td><a href="{{ route('AdminProductsControllerGetEdit', $product->id) }}">{{ ucwords($product->full_name) }}</a></td>
                                    <td>{{ numbering_format($product->view) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
<div id="loading_wrapper">
    <img id="loading-image" src="{{ asset('assets/img/loading.gif') }}" alt="Loading..." />
</div>
@endsection

@push('head')
<style>
#loading_wrapper {
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    position: fixed;
    display: none;
    background-color: rgba(255, 255, 255, 0.75);
    z-index: 2000;
    text-align: center;
}
#loading-image {
    position: absolute;
    top: 50%;
    left: 50%;
    z-index: 100;
    transform: translate(-50%, -50%);
}

.flex-row {
  display: -webkit-box;
  display: -webkit-flex;
  display: -ms-flexbox;
  display:         flex;
  flex-wrap: wrap;
}
.flex-row > [class*='col-'] {
  display: flex;
  flex-direction: column;
}

</style>
<script>
function ready(fn) {
    if (document.readyState != 'loading'){
        fn();
    } else if (document.addEventListener) {
        document.addEventListener('DOMContentLoaded', fn);
    } else {
        document.attachEvent('onreadystatechange', function() {
        if (document.readyState != 'loading')
            fn();
        });
    }
}
</script>
@endpush
@push('bottom')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/g/filesaver.js"></script>
<script type="text/javascript">
function loadingStart() {
    $('#loading_wrapper').show();
}

function loadingEnd() {
    $('#loading_wrapper').hide();
}

$(function () {
    "use strict";

    $('#reportrange').daterangepicker({
        ranges   : {
            'Today'       : [moment(), moment()],
            'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month'  : [moment().startOf('month'), moment()],
            'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Current Year': [moment().startOf('year'), moment()],
            'All Time'    : [moment('2018-01-01 00:00:00'), moment()]
        },
        startDate: moment().startOf('month'),
        endDate  : moment()
    }, function (start, end) {
        var url     = '{{ url()->current() }}?ds='+start.format('YYYY-MM-D')+'&de='+end.format('YYYY-MM-D');
        var text    = start.format('D MMM YYYY')+' - '+end.format('D MMM YYYY');
        $("#reportrange").find('span').html(text);
        loadingStart();

        jQuery.ajax({
            url: url,
            success: function(data,status,jqXHR) {
                loadingEnd();
                data = jQuery(data).find( '.ajax' );
                jQuery('#dashboard-content').html(data).fadeIn('fast', function () {
                });
            }
        });
    });



    $('body').on('click', '#export_top_sell', function(e){
        e.preventDefault();

        var start   = $(this).data('start');
        var end     = $(this).data('end');
        var data = {
            'start' : start,
            'end'   : end,
        }

        $.ajax({
            type: 'POST',
            url: "{{route('AdminCuoponsControllerPostExportTopSelling')}}",
            data: data,
            success: function (respond) {
                var a = document.createElement("a");
                a.href = respond.url;
                document.body.appendChild(a);
                a.click();
            }
        });
    });


    $('body').on('click', '#export_top_cust', function(e){
        e.preventDefault();

        var start   = $(this).data('start');
        var end     = $(this).data('end');
        var data = {
            'start' : start,
            'end'   : end,
        }

        $.ajax({
            type: 'POST',
            url: "{{route('AdminCuoponsControllerPostExportTopCustomer')}}",
            data: data,
            success: function (respond) {
                var a = document.createElement("a");
                a.href = respond.url;
                document.body.appendChild(a);
                a.click();
            }
        });
    });


    $('body').on('click', '#export_top_view', function(e){
        e.preventDefault();

        var start   = $(this).data('start');
        var end     = $(this).data('end');
        var data = {
            'start' : start,
            'end'   : end,
        }

        $.ajax({
            type: 'POST',
            url: "{{route('AdminCuoponsControllerPostExportTopView')}}",
            data: data,
            success: function (respond) {
                var a = document.createElement("a");
                a.href = respond.url;
                document.body.appendChild(a);
                a.click();
            }
        });
    });




    $('body').on('click', '#print_cart', function(e){
        e.preventDefault();
        var canvas = document.getElementById("visitorChart");
        canvas.toBlob(function(blob) {
            saveAs(blob, "visitor_analytics.png");
        });
    });




});
</script>
@endpush
