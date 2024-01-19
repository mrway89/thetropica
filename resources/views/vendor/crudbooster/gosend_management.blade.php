<!-- First, extends to the CRUDBooster Layout -->
@extends('crudbooster::admin_template')
@section('content')
<div class="row clearfix">
    @if ($order->cart->courier_type_id)
    @if ($order->payment_status !== 0 )
        <div class="col-lg-12">
            <div class='panel panel-default'>
                <div class="panel-heading">
                    <h4>Gosend Track</h4>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-12 table-responsive">
                            @if ($order->status == 'paid' || $order->status == 'sent')
                                <a href="#" onclick="checkGosend('{{ $order->order_code }}')" class="btn btn-success mr-2">Refresh Status</a>
                                <a href="#" onclick="reBookGosend('{{ $order->order_code }}')" class="btn btn-info mr-2">Re-Book</a>
                                <a href="#" onclick="cancelGosend('{{ $order->order_code }}')" class="btn btn-warning">Cancel</a>
                            @endif
                            @php
                                $gosend = $order->gosendStatus()->first();
                                $gosendJson = json_decode($gosend->data);
                            @endphp
                            @if ($gosendJson)
                            <table class="table table-striped mt-5">
                                <thead>
                                    <tr>
                                        <th class="text-left">Status</th>
                                        <th class="text-left">Gosend Code</th>
                                        <th>Live Tracking</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="text-left">
                                            {{ ucwords($gosend->status) }}
                                        </td>
                                        <td class="text-left">
                                            {{$gosend->gojek_code}}
                                        </td>
                                        <td>
                                            <a href="{{$gosendJson->liveTrackingUrl}}" target="_blank" class="btn btn-primary">Live Tracking <i class="fa fa-arrow-circle-o-right"></i></a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                                @if ($gosendJson->driverId)
                                <hr>
                                <div class="row">
                                    <div class="col-md-4 col-xs-offset-4">
                                        <center><h4>DRIVER INFO</h4><center>
                                        <img src="{{ $gosendJson->driverPhoto }}" class="mt-3" alt="" style="width:250px;">
                                        <p class="mt-3">
                                            Name : {{ $gosendJson->driverName }}
                                        </p>
                                        <p>
                                            Phone : {{ $gosendJson->driverPhone }}
                                        </p>
                                    </div>
                                </div>
                                @endif

                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endif
    <div class="col-lg-12">
      <div class='panel panel-default'>
            <div class="panel-heading">
                <h4>Order Detail</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    {{-- <div class="col-sm-12">
                        <a href="#" class="btn btn-raised btn-primary pull-right" style="margin-right:5px;">
                            <i class="fa fa-download margin-r-5"></i>&nbsp;Generate Location
                        </a>
                        <a href="#" class="btn btn-raised btn-info pull-right" style="margin-right:5px;">
                            <i class="fa fa-download margin-r-5"></i>&nbsp;Generate Invoice
                        </a>
                        <a href="#" class="btn btn-raised btn-danger pull-right" style="margin-right: 5px;">
                            <i class="fa fa-download margin-r-5"></i> Generate Delivery Label
                        </a>
                        <a href="javascript:void(0);" class="btn btn-raised btn-success pull-right" style="margin-right:5px;">
                            <i class="fa fa-print"></i>
                        </a>
                    </div> --}}
                </div>
                <div class="row clearfix" style="margin-top:20px;">
                    <div class="col-md-12">
                        <img height='50px;' src="{{ asset('assets/img/logo.png') }}" alt="Talasi">
                        <h4 class="float-md-right">
                            # <strong>{{ $order->order_code }}</strong>
                        </h4>
                    </div>
                </div>
                <hr>

                <div class="row mt-3" style="margin-top:20px;">
                    <div class="col-md-4 col-sm-4">
                        @if($order->cart->address->name)
                        <address>
                            <strong><a href="#">{{ $order->cart->address->name }}</a></strong><br />
                            {{ $order->cart->address->address }}<br />
                            {{ $order->cart->address->subdistrict }}, {{ $order->cart->address->city }}<br />
                            {{ $order->cart->address->province }} {{ $order->cart->address->postal_code }}<br />
                            Phone: {{ $order->cart->address->phone_number }}
                        </address>
                        @else
                        <b>Deleted Address</b>
                        @endif
                    </div>
                    <div class="col-md-4 col-sm-4">
                        {{-- <p>Payment Method:
                          @if ($order->payment_method == 'bank_transfer')
                          <b>Bank Transfer</b>
                          @endif
                          @if ($order->payment_method == 'credit_card')
                          <b>Credit Card</b>
                          @endif
                          @if ($order->payment_method == 'cstore')
                          <b>Convenience Store</b>
                          @endif
                        </p> --}}

                        {{-- @if ($order->payment_method == 'bank_transfer')
                        @if ($midtrans->permata_va_number)
                        <p>Payment Bank: <img src="{{ asset('assets/img/bank_permata.png') }}" class="img-fluid img-thumbnail" alt="" style="height:30px;"></p>
                        @endif
                        @if ($midtrans->va_numbers)
                        @if ($midtrans->va_numbers[0]->bank == 'bni')
                        <p>Payment Bank: <img src="{{ asset('assets/img/bank_bni.jpg') }}" class="img-fluid img-thumbnail" alt="" style="height:30px;"></p>
                        @else
                        <p>Payment Bank: <img src="{{ asset('assets/img/bank_bca.jpg') }}" class="img-fluid img-thumbnail" alt="" style="height:30px;"></p>
                        @endif
                        @endif
                        @if ($midtrans->biller_code)
                        <p>Payment Bank: <img src="{{ asset('assets/img/bank_mandiri.png') }}" class="img-fluid img-thumbnail" alt="" style="height:30px;"></p>
                        @endif
                        @endif --}}

                        @if ($order->status == 'paid')
                            @if ($order->cart->courier_type_id !== 'sameday')
                            @if ($order->cart->courier_type_id !== 'instant')
                                <div class="row">
                                    <div class="col-md-4 form-horizontal">
                                        <label for="">No. Resi</label>
                                        <input type="text" name="no_resi" id="no_resi" class="form-control">
                                    </div>
                                    <div class="col-md-4 form-horizontal">
                                        <label for="">Delivery Date</label>
                                        <input type="text" name="delivery_date" id="delivery_date" class="form-control datetimepicker" readonly>
                                    </div>
                                </div><br>

                            @endif
                            @endif
                        @endif

                        {{-- @if($order->status == 'pending')
                        <button class="btn btn-raised btn-info btn-action" data-status="1"><i class="fa fa-check margin-r-5"></i> Set as Paid</button>
                        @endif
                        @if($order->status == 'paid')
                        <button class="btn btn-raised btn-success btn-action" data-status="2"><i class="fa fa-check margin-r-5"></i> Set on Delivery</button>
                        @endif
                        @if($order->status == 'sent')
                        <button class="btn btn-raised btn-success btn-action" data-status="3"><i class="fa fa-check margin-r-5"></i> Set as Completed</button>
                        @endif --}}
                        {{-- <button class="btn btn-raised btn-danger btn-action" data-status="4"><i class="fa fa-times margin-r-5"></i> Cancel</button> --}}
                    </div>
                    <div class="col-md-4 col-sm-4 text-right">
                        <p>
                            <strong>Order Date: </strong>
                            {{ $order->created_at->format('d M Y, H:i:s') }}
                        </p>
                        <p style="margin-top:10px;">
                            <strong>Order Status: </strong>
                            <span class="badge badge-{{ $order->status }}"><i class="fa fa-hourglass" style="margin-right:5px;" title="Processing"></i>{{ $order->status }}</span>
                        </p>
                    </div>
                </div>
                <hr>

                <div class="row" style="margin-top:50px;">
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table id="mainTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th></th>
                                        <th>Product</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->details as $index=>$detail)
                                    <tr>
                                        <td class="align-middle">{{$index+1}}</td>
                                        <td class="align-middle">
                                            @if($detail->product->cover())
                                            <img width="75" src="{{ asset($detail->product->cover->url) }}" />
                                            @else
                                            <img src="{{ asset('assets/img/default-image.png') }}" />
                                            @endif
                                        </td>
                                        @php

                                            if(!empty($detail->confirm_result)){

                                                $confirm_loketcom = json_decode($detail->confirm_result);
                                                if($confirm_loketcom->status){
                                                    $confirm_label = '<span class="label label-warning">Confirmed By Loket.com</span>';
                                                }else{
                                                    $confirm_label = '<span class="label label-error">Not Confirmed yet By Loket.com</span>';
                                                }
                                            }

                                        @endphp
                                        <td class="align-middle">{{ $detail->product->name }} {{ $confirm_label }}</td>
                                        <td class="align-middle">{{ $detail->quantity }}</td>
                                        <td class="align-middle">{{ currency_format($detail->price) }}</td>
                                        <td class="align-middle">{{ currency_format($detail->price * $detail->quantity) }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <hr>
                <div class="row">
                    <div class="col-md-4">
                        @if ($order->payment_status == 1)
                        <strong>Customer Payment</strong> <br>
                        <div class="row mt-3">
                            <div class="col-md-8">
                              <ul class="list-group">
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                      Payment Date
                                      <span class="badge badge-completed">
                                      {{ Carbon\Carbon::parse($order->created_at)->format('j F Y - H:i') }}
                                      </span>
                                  </li>
                              </ul>
                            </div>
                        </div>
                        @else
                        <strong>Customer Payment</strong> <br>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <ul class="list-group">
                                    <li class="list-group-item d-flex justify-content-between align-items-center text-center">
                                        Customer have not pay the bills.
                                    </li>
                                </ul>
                            </div>
                        </div>
                        @endif
                    </div>
                    <div class="col-md-4">
                      <strong>Courier</strong> <br>
                      <div class="row mt-3">
                          <div class="col-md-8">
                              <ul class="list-group">
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                      Courier Selected
                                      <span class="badge badge-pending">
                                      {{ strtoupper($order->cart->courier_type_id) }}
                                      </span>
                                  </li>
                                  @if ($order->status == 'sent' || $order->status == 'completed')
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                      No. Resi
                                      <span class="badge badge-pending">
                                      {{ strtoupper($order->no_resi) }}
                                      </span>
                                  </li>
                                  <li class="list-group-item d-flex justify-content-between align-items-center">
                                      Delivery Date
                                      <span class="badge badge-pending">
                                      {{ $order->delivery_date }}
                                      </span>
                                  </li>
                                  @endif
                              </ul>
                          </div>
                      </div>
                    </div>
                    <div class="col-md-4 text-right">
                        <p class="text-right">
                            <b>Sub-total:</b>
                            {{ currency_format($order->subtotal) }}
                        </p>
                        <p class="text-right">Discount: {{ $order->voucher_value ? '- ' . currency_format($order->voucher_value) : '-' }}</p>
                        <p class="text-right">Courier: {{ $order->total_shipping_cost ? currency_format($order->total_shipping_cost) : '-' }}</p>
                        <hr>
                        <h3 class="text-right">{{ currency_format($order->grand_total) }}</h3>
                    </div>
                </div>
                <hr>

                @if (! empty($order->notes))
                <div class="row">
                    <div class="col-md-12">
                        <strong>Notes</strong> <br>
                        <p>
                            {{$order->notes}}
                        </p>
                    </div>
                </div>
                <hr>
                @endif
            </div>
        </div>
    </div>
    <div class="col-lg-12">
      <div class='panel panel-default'>
          <div class="panel-heading">
              <h4>Order Log</h4>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-xs-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="text-left">Status</th>
                                    <th class="text-left">Notes</th>
                                    <th>By</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->logs as $index => $log)
                                    <tr>
                                        <td class="text-left">
                                            {{ ucwords($log->status) }}
                                        </td>
                                        <td class="text-left">
                                            {{$log->notes}}
                                        </td>
                                        <td>
                                            <span class="label label-default">{{$log->admin_id}}</span>
                                        </td>
                                        <td>{{$log->created_at->format('d M Y H:i:s')}}</td>
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
    <img id="loading-image" src="{{ asset("assets/img/loading.gif") }}" alt="Loading..." />
</div>
@endsection

@push('head')
<style>
.badge-pending {
  background-color: #00c0ef;
}
.badge-paid {
  background-color: #00a65a;
}
.badge-sent {
  background-color: #3c8dbc;
}
.badge-completed {
  background-color: #00a65a;
}

hr {
    border-top: 1px solid #999;
}

.mt-3 {
  margin-top: 20px;
}

#mainTable img {
  background: white;
  box-shadow: 1px 1px 1px #eee;
  border-radius: 5px;
}

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

.form-control[disabled], .form-control[readonly], fieldset[disabled] .form-control {
    background-color: #fff;
    opacity: 1;
}

.mr-2 {
    margin-right: 10px;
}

.mt-5 {
    margin-top:30px;
}
</style>

@if ($order->status == 'paid')
<link rel="stylesheet" href="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/datepicker/datepicker3.css') }}">
@endif
@endpush

@push('bottom')
@if ($order->status == 'paid')
<script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/datepicker/bootstrap-datepicker.js') }}"></script>
@endif
<script type="text/javascript">
// MODAL
 var i_modal={
    confirmModalCallBack:false,
    confirmModal:function(param) {
        var temp='',
            title=typeof param.title=='undefined'?"Confirmation":param.title,
            buttonYes=typeof param.buttonYes=='undefined'?"Save changes":param.buttonYes,
            buttonNo=typeof param.buttonNo=='undefined'?"Cancel":param.buttonNo,
            text=typeof param.text=='undefined'?"Are you sure to perform this action?":param.text;

            i_modal.confirmModalCallBack=typeof param.action=='function'?param.action:false;
        temp='<div class="modal fade" id="i-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">';
            temp+='<div class="modal-dialog"><div class="modal-content">';
                temp+='<div class="modal-header">';
                    temp+='<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>';
                    temp+='<h4 class="modal-title" id="myModalLabel">'+title+' Form</h4>';
                temp+='</div>';
                temp+='<div class="modal-body">'+text+'</div>';
                temp+='<div class="modal-footer">';
                    temp+='<button type="button" class="btn btn-default" data-dismiss="modal">'+buttonNo+'</button>';
                    temp+='<button type="button" id="i-confirm-btn-yes" class="btn btn-primary">'+buttonYes+'</button>';
                temp+='</div>';
            temp+='</div>';
        temp+='</div>';
        $(".content-wrapper").append(temp);
        $("#i-modal").modal({
            backdrop: 'static',
            keyboard: false
        });
    }
}

function checkGosend(ordercode) {
    loadingStart();
    var data = {
        'order_code'  : ordercode,
    }
    $.ajax({
        url: '{{route('AdminOrdersControllerPostCheckGosend')}}',
        method: 'POST',
        data: data,
        success: function(response) {
            location.reload();
            if (response.status) {
            } else {
                // toastr.success(response.message);
            }
        }
    });

}
function cancelGosend(ordercode) {
    loadingStart();
    var data = {
        'order_code'  : ordercode,
    }
    $.ajax({
        url: '{{route('AdminOrdersControllerPostCancelGosend')}}',
        method: 'POST',
        data: data,
        success: function(response) {
            location.reload();
            if (response.status) {
            } else {
                // toastr.success(response.message);
            }
        }
    });

}
function reBookGosend(ordercode) {
    loadingStart();
    var data = {
        'order_code'  : ordercode,
    }
    $.ajax({
        url: '{{route('AdminOrdersControllerPostBookGosend')}}',
        method: 'POST',
        data: data,
        success: function(response) {
            location.reload();
            if (response.status) {
            } else {
                // toastr.success(response.message);
            }
        }
    });

}

$(function(){
    $(document).on("click","#i-confirm-btn-yes", function () {
        if(i_modal.confirmModalCallBack)i_modal.confirmModalCallBack();
        $("#i-modal").modal('hide');
    });
});

function loadingStart() {
    $('#loading_wrapper').show();
}

function loadingEnd() {
    $('#loading_wrapper').hide();
}

$(document).ready(function () {

  $("body").on('click', '.btn-action', function () {
      var statusID    = $(this).data('status');
      var orderID     = '{{ $order->id }}';
      var text        = '';
      var ship        = '';
      var noResi      = $('#no_resi').val();
      var deliveryD   = $('#delivery_date').val();

      if(statusID == 4) {
          text = 'Are you sure want to cancel this order?';
      } else if(statusID == 1) {
          text = 'Are you sure want to update this order to PAID?';
      } else if(statusID == 2) {
          text = 'Are you sure want to update this order to SENT?'
      } else if(statusID == 3) {
          text = 'Are you sure want to update this order to COMPLETED?';
      }

      if (statusID == 2) {
          if (noResi == '') {
            swal("Error", 'Please Input No. Resi First', "error");
            return false;
          }
          if (deliveryD == '') {
            swal("Error", 'Please Input Delivery Date First', "error");
            return false;
          }
      }

      i_modal.confirmModal({
        title: 'Update Progress',
        buttonYes: 'Yes',
        text: text,
        action: function(value){
          var data = {
              'order_id'  : orderID,
              'status_id' : statusID,
              'no_resi' : noResi,
              'delivery_date' : deliveryD,
          }
          loadingStart();
          $.ajax({
              url: '{{route('AdminOrdersControllerPostSaveOrder')}}',
              method: 'POST',
              data: data,
              success: function(response) {
                  if (response.status) {
                      location.reload();
                  } else {
                      // toastr.success(response.message);
                  }
              }
          });
        }
    });
  });

});
</script>
@endpush
