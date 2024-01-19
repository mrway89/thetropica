
<div class="accordion" id="payment-method">
    @foreach ($payments as $payment)
        @if ($payment->payment_method == 'virtual_account')
            <div class="card">
                <div class="card-header bg-white d-flex" id="va_{{ $payment->bank }}" data-toggle="collapse" data-target="#{{ $payment->payment_method }}_{{ $payment->bank }}-area" aria-expanded="true" aria-controls="va_bca-area">
                    <img src="{{ asset('assets/img/bank/' . $payment->bank . '.png') }}" class="img-bank-logo mr-3" alt="">
                    <div class="bank-text-area">
                        <p class="bold-700 mb-0">{{ strtoupper($payment->bank) }}</p>
                        <p class="mb-0">Virtual Account</p>
                </div>
                </div>

                <div id="{{ $payment->payment_method }}_{{ $payment->bank }}-area" class="collapse" aria-labelledby="v{{ $payment->payment_method }}_{{ $payment->bank }}_bca" data-parent="#payment-method">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="left">
                                <p>{{ strtoupper($payment->bank) }} Virtual Account</p>
                            </div>
                            <div class="right">
                                <img src="{{ asset('assets/img/bank/' . $payment->bank . '.png') }}" class="img-bank-logo object-top" alt="">
                            </div>
                        </div>
                        <a href="{{ route('frontend.cart.payment.va', $payment->bank) }}">
                            <button class="checkout btn-send-about w-100 mt-3 mb-2 process_loading">PAY</button>
                        </a>
                    </div>
                </div>
            </div>
        @endif
        @if ($payment->payment_method == 'cvs')
            <div class="card">
                <div class="card-header bg-white d-flex" id="va_{{ $payment->bank }}" data-toggle="collapse" data-target="#{{ $payment->payment_method }}_{{ $payment->bank }}-area" aria-expanded="true" aria-controls="va_bca-area">
                    <img src="{{ asset('assets/img/bank/' . $payment->bank . '.png') }}" class="img-bank-logo mr-3" alt="">
                    <div class="bank-text-area">
                        <p class="bold-700 mb-0">{{ strtoupper($payment->bank) }}</p>
                        <p class="mb-0">Convenience Store</p>
                </div>
                </div>

                <div id="{{ $payment->payment_method }}_{{ $payment->bank }}-area" class="collapse" aria-labelledby="v{{ $payment->payment_method }}_{{ $payment->bank }}_bca" data-parent="#payment-method">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="left">
                                <p>{{ strtoupper($payment->bank) }}</p>
                            </div>
                            <div class="right">
                                <img src="{{ asset('assets/img/bank/' . $payment->bank . '.png') }}" class="img-bank-logo object-top" alt="">
                            </div>
                        </div>
                        <a href="{{ route('frontend.cart.payment.cvs', $payment->bank) }}">
                            <button class="checkout btn-send-about w-100 mt-3 mb-2 process_loading">PAY</button>
                        </a>
                    </div>
                </div>
            </div>
        @endif
        @if ($payment->payment_method == 'cc')
            <div class="card">
                <div class="card-header bg-white d-flex" id="va_{{ $payment->bank }}" data-toggle="collapse" data-target="#{{ $payment->payment_method }}_{{ $payment->bank }}-area" aria-expanded="true" aria-controls="va_bca-area">
                    <img src="{{ asset('assets/img/icon-footer/credit-card.png') }}" class="img-bank-logo mr-3" alt="">
                    <div class="bank-text-area">
                        <p class="bold-700 mb-0">Visa/Mastercard</p>
                        <p class="mb-0">Credit Card</p>
                </div>
                </div>

                <div id="{{ $payment->payment_method }}_{{ $payment->bank }}-area" class="collapse" aria-labelledby="v{{ $payment->payment_method }}_{{ $payment->bank }}_bca" data-parent="#payment-method">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="left">
                                <p>Credit Card</p>
                            </div>
                            <div class="right">
                                <img src="{{ asset('assets/img/icon-footer/credit-card.png') }}" class="img-bank-logo object-top" alt="">
                            </div>
                        </div>
                        <a href="{{ route('frontend.cart.payment.cc') }}">
                            <button class="checkout btn-send-about w-100 mt-3 mb-2 process_loading">PAY</button>
                        </a>
                    </div>
                </div>
            </div>
        @endif
    @endforeach
</div>
