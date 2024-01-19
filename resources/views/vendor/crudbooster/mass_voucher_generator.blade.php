<!-- First, extends to the CRUDBooster Layout -->

@extends('crudbooster::admin_template')
@section('content')
<!-- Your html goes here -->
<div class='panel panel-default'>
    <div class='panel-heading'>Generator Form</div>
    <div class='panel-body'>
        <form method='post' action='{{route('AdminMassVoucherGeneratorControllerPostSave')}}' class="form-horizontal">
            {{ csrf_field() }}
            <div class="box-body" id="parent-form-area">
                <div class="form-group header-group-0 " id="form-group-quota" style="">
                    <label class="control-label col-sm-2">Number of Vouchers
                    <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-5">
                        <input type="number" step="1" title="voucher_num" required="" class="form-control" name="voucher_num" id="quota" value="">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-type" style="">
                    <label class="control-label col-sm-2">Type
                    <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <div class="col-sm-5">
                        <div class=" ">
                            <label class="radio-inline">
                            <input type="radio" name="type" value="total"> Total Only
                            </label>
                        </div>
                        <div class=" ">
                            <label class="radio-inline">
                            <input type="radio" name="type" value="shipping"> Shipping Only
                            </label>
                        </div>

                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group form-datepicker header-group-0 " id="form-group-start_date" style="">
                    <label class="control-label col-sm-2">Start Date
                    <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-5">
                        <div class="input-group">
                            <span class="input-group-addon open-datetimepicker"><a><i class="fa fa-calendar "></i></a></span>
                            <input type="text" title="Start Date" readonly="" required="" class="form-control notfocus input_date" name="start_date"
                                id="start_date" value="">
                        </div>
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group form-datepicker header-group-0 " id="form-group-end_date" style="">
                    <label class="control-label col-sm-2">End Date
                    <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-5">
                        <div class="input-group">
                            <span class="input-group-addon open-datetimepicker"><a><i class="fa fa-calendar "></i></a></span>
                            <input type="text" title="End Date" readonly="" required="" class="form-control notfocus input_date" name="end_date" id="end_date"
                                value="">
                        </div>
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-limit_per_user" style="">
                    <label class="control-label col-sm-2">Limit Per User
                    <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-5">
                        <input type="number" step="1" title="Limit Per User" required="" class="form-control" name="limit_per_user" id="limit_per_user"
                            value="">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-quota" style="">
                    <label class="control-label col-sm-2">Quota
                    <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-5">
                        <input type="number" step="1" title="Quota" required="" class="form-control" name="quota" id="quota" value="">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-unit" style="">
                    <label class="control-label col-sm-2">Unit
                        <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <div class="col-sm-5">


                        <div class=" ">
                            <label class="radio-inline">
                                <input type="radio" name="unit" value="percentage"> Percentage
                            </label>
                        </div>
                        <div class=" ">
                            <label class="radio-inline">
                                <input type="radio" name="unit" value="Amount"> Amount
                            </label>
                        </div>

                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-discount" style="">
                    <label class="control-label col-sm-2">Discount
                        <span class="text-danger" title="This field is required">*</span>
                    </label>
                    <br>
                    {{-- <small>* if voucher is percentage put 1-100 value</small> --}}

                    <div class="col-sm-5">
                        <input type="number" step="1" title="Discount" required="" class="form-control" name="discount" id="discount" value="">
                        <div class="text-danger"></div>
                        <p class="help-block">* if voucher is percentage please put mumber between 1-100</p>
                    </div>
                </div>
                <div class="form-group header-group-0 " id="form-group-min_amount" style="">
                    <label class="control-label col-sm-2">Min. Transaction Amount
                    <span class="text-danger" title="This field is required">*</span>
                    </label>

                    <div class="col-sm-5">
                        <input type="number" step="1" title="Min. Transaction Amount" required="" class="form-control" name="min_amount" id="min_amount"
                            value="">
                        <div class="text-danger"></div>
                        <p class="help-block"></p>
                    </div>
                </div>
            </div>

            <!-- etc .... -->
            <input type='submit' class='btn btn-primary' value='Save changes' />

        </form>
    </div>
    <div class='panel-footer'>
    </div>
</div>
@endsection

@push('bottom')

    @if (App::getLocale() != 'en')
        <script src="{{ asset ('vendor/crudbooster/assets/adminlte/plugins/datepicker/locales/bootstrap-datepicker.'.App::getLocale().'.js') }}"
                charset="UTF-8"></script>
    @endif
    <script type="text/javascript">
        var lang = '{{App::getLocale()}}';
        $(function () {
            $('.input_date').datepicker({
                format: 'yyyy-mm-dd',
                @if (in_array(App::getLocale(), ['ar', 'fa']))
                rtl: true,
                @endif
                language: lang
            });

            $('.open-datetimepicker').click(function () {
                $(this).next('.input_date').datepicker('show');
            });

        });

    </script>
@endpush
