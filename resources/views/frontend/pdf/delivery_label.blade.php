
@extends('crudbooster::admin_template')
@section('content')
<div class="row clearfix">
    <div class="col-lg-12">
      <div class='panel panel-default'>
            <div class="panel-heading">
                <h4>Order Detail</h4>
            </div>
            <div class="panel-body">
                <form target="_blank" method="post" action="{{ route('AdminOrdersControllerPostPrintAddress') }}">
                    <input type="hidden" name="_token" value="{{csrf_token()}}" />
                    <input type="hidden" name="result" value="" />
                    <input type="hidden" name="id" value="{{ $order->id }}" />

                    <div class="generate-delivery-holder">
                        <center><h4>Preview Delivery Label</h4></center>
                        <div class="generate-delivery clearfix">
                            @for($i=0;$i<2;$i++)
                                <div class="col-xs-12 box-holder" id="{{ $i == 0 ? '1' : '0' }}">
                                    @if($i==0)
                                        <div class="row">
                                            <div class="col-xs-6">
                                                <p>
                                                    {{ $order->cart->address->first_name }} {{ $order->cart->address->last_name }}<br />
                                                    {{ $order->cart->address->address }}<br />
                                                    {{ is_null($order->cart->address->subdistrict) ? '' : $order->cart->address->subdistrict.', ' }}{{ $order->cart->address->city }}<br />
                                                    {{ $order->cart->address->province }} {{ $order->cart->address->postal_code }}<br />
                                                    +62 {{ $order->cart->address->phone_number }}
                                                </p>
                                            </div>
                                            <div class="col-xs-6">
                                                    {{--  @if($order->is_multiple_address)
                                                        <strong>{{ $order->dropshipper_name }}</strong><br />
                                                        {!! $order->dropshipper_address !!}
                                                    @else
                                                        <strong>ClothtoWear</strong>
                                                        {!! $from->value !!}
                                                    @endif  --}}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endfor
                        </div>
                        <br />
                        <center>
                            <input class="btn btn-success" id="btn-submit-preview" type="submit" value="Generate" />
                        </center>
                    </div>
                </form>
            </div>
      </div>
    </div>
</div>
@endsection


@push('bottom')
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".generate-delivery").sortable({
            start: function(event, ui) {
                oldIndex = ui.item.index();
            },
            stop: function(event, ui) {
                var newIndex = ui.item.index();
                var movingForward = newIndex > oldIndex;
                var nextIndex = newIndex + (movingForward ? -1 : 1);

                var items = $('.generate-delivery > div');

                // Find the element to move
                var itemToMove = items.get(nextIndex);
                if (itemToMove) {

                    // Find the element at the index where we want to move the itemToMove
                    var newLocation = $(items.get(oldIndex));

                    // Decide if it goes before or after
                    if (movingForward) {
                        $(itemToMove).insertBefore(newLocation);
                    } else {
                        $(itemToMove).insertAfter(newLocation);
                    }
                }
            }
        });

        $("#btn-submit-preview").click(function () {
            var result  = $(".generate-delivery").sortable('toArray');
            result      = result.join(',');
            $("input[name='result']").val(result);
        });
    });
</script>
@endpush

@push('head')
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<style>
    .generate-delivery-holder .box-holder {
        height: 300px;
        border: 1px solid black;
        padding: 10px 2%;
    }
</style>
@endpush
