<div class="row">
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-users"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Total New Users</span>
                <span class="info-box-number">{{ numbering_format($total_user) }}</span>
            </div>
        </div>
    </div>
    <div class="clearfix visible-sm-block"></div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-green fa-layers fa-fw">
                <i class="fa fa-line-chart"></i>
                <i class="fa-inverse fas fa-dollar-sign" data-fa-transform="shrink-11 left-4 up-4"></i>
            </span>

            <div class="info-box-content">
                <span class="info-box-text">Total Sales</span>
                <span class="info-box-number">{{ currency_format($total_sales) }}</span>
            </div>
        </div>
    </div>
    <div class="clearfix visible-sm-block"></div>
    <div class="col-md-4 col-sm-4 col-xs-12">
        <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-shopping-bag"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Total Order</span>
                <span class="info-box-number">{{ numbering_format($total_order) }}</span>
                <small style="font-style: italic">{{ numbering_format($total_order_success) }} (paid order)</small>
            </div>
        </div>
    </div>
</div>
