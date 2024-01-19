@extends('crudbooster::admin_template')
@section('content')

@push('head')
<link rel="stylesheet" href="{{ asset('assets/css/multi-select.css') }}">
<style type="text/css">
    .ms-selectable .search-input,
    .ms-selection .search-input {
        width: 100%;
        padding: 5px 15px;
        font-size: 15px;
        border: 1px solid;
        border-bottom: none;
        border-top-left-radius: 5px;
        border-top-right-radius: 5px;
    }

    .ms-selectable .search-input::placeholder,
    .ms-selection .search-input::placeholder {
        color: #ccc;
    }

    .ms-container .ms-list {
        border: 1px solid;
        border-bottom-left-radius: 5px;
        border-bottom-right-radius: 5px;
        border-top-left-radius: 0px;
        border-top-right-radius: 0px;
    }

    .ms-elem-selectable {
        background: #eee;
    }

    .ms-container {
        width: auto !important
    }

    .ms-container .ms-selectable li.ms-elem-selectable, .ms-container .ms-selection li.ms-elem-selection {
        border-bottom: 1px solid #000;
    }

    .ms-container .ms-list {
        /* -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        -ms-box-shadow: none !important;
        box-shadow: none !important;
        -webkit-border-radius: 0 !important;
        -moz-border-radius: 0 !important;
        -ms-border-radius: 0 !important;
        border-radius: 0 !important */
        height: 500px;
    }

    .ms-container .ms-list.ms-focus {
        -webkit-box-shadow: none !important;
        -moz-box-shadow: none !important;
        -ms-box-shadow: none !important;
        box-shadow: none !important
    }

    .ms-elem-selectable span {
        font-weight: bold;
    }

    .ms-container .ms-selectable,
    .ms-container .ms-selection {
        min-width: 250px !important;
        min-height: 500px;
    }

    .ms-container .ms-selectable li.ms-hover,
    .ms-container .ms-selection li.ms-hover {
        color: #fff !important;
        background-color: #dd4b39 !important
    }

    .ms-container .ms-selectable li.ms-elem-selectable,
    .ms-container .ms-selectable li.ms-elem-selection,
    .ms-container .ms-selection li.ms-elem-selectable,
    .ms-container .ms-selection li.ms-elem-selection {
        padding: 9px 15px 6px 15px !important
    }

    .ms-container .ms-optgroup-label {
        padding: 5px 0 0 8px !important
    }

    .ms-elem-selection.ms-selected {
        color: #fff !important;
        background-color: #dd4b39 !important
    }
</style>
@endpush

@push('bottom')
<script src="{{ asset('assets/js/jquery.multi-select.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.quicksearch/2.4.0/jquery.quicksearch.min.js"></script>
<script type="text/javascript">
$(function () {

    $('#select_products').multiSelect({
        selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Search Products'>",
        selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Search Products'>",
        afterInit: function(ms){
            var that = this,
                $selectableSearch = that.$selectableUl.prev(),
                $selectionSearch = that.$selectionUl.prev(),
                selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable:not(.ms-selected)',
                selectionSearchString = '#'+that.$container.attr('id')+' .ms-elem-selection.ms-selected';

            that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
            .on('keydown', function(e){
            if (e.which === 40){
                that.$selectableUl.focus();
                return false;
            }
            });

            that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
            .on('keydown', function(e){
            if (e.which == 40){
                that.$selectionUl.focus();
                return false;
            }
            });
        },
        afterSelect: function(){
            this.qs1.cache();
            this.qs2.cache();
        },
        afterDeselect: function(){
            this.qs1.cache();
            this.qs2.cache();
        }
    });


    $('body').on('click', '#saveHomeProduct', function() {
        var values = {
            'product': $('#select_products').val(),
            'id': $('[name=id]').val(),
            '_token': '{{ csrf_token() }}'
        };

        var selected = $('#select_products').val();

        $.ajax({
            url: "{{ route('AdminHomeCategoryProductsControllerPostSaveProduct') }}",
            type: "POST",
            data: values,
            success: function(response) {
                if (response.status) {
                    location.reload();
                } else {
                    swal("Error", response.message['product'][0], "error");
                }
            }
        });
    });
});
</script>
@endpush
<div class='row'>
    <div class="col-sm-12">
        <div class="panel panel-primary ">
            <div class="panel-heading">
                <strong>Home Category Products</strong> <span id='menu-saved-info' style="display:none" class='pull-right text-success'><i class='fa fa-check'></i> Image Saved !</span>
            </div>
            <form method='post' id="form" action='{{CRUDBooster::mainpath("add-save")}}'>
                <div class="panel-body clearfix">
                    <div role="tabpanel" class="tab-pane" id="products">
                            <div class="mt-5">
                                <input type="hidden" value="{{ $category->id }}" name="id">
                                <select id="select_products" class="ms" multiple="multiple" name="product[]">
                                    @foreach ($products as $product)
                                    <option value="{{ $product->id }}" {{(collect(old('product'))->contains($product->id)) ? 'selected' : ''}} {{ (in_array($product->id, $selected->toArray())) ? 'selected' : '' }}>{{ $product->name }}</option>
                                    @endforeach
                                </select>
                                <button type="button" class="btn btn-raised btn-success mt-4 pull-right" id="saveHomeProduct" style="margin-top:30px;">Save</button>
                            </div>
                        </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
