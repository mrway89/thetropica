@extends('email.template.master')
@section('content')
    <div style="width: 600px;text-align: left;margin:auto;">
        <br>
        @if ($type == 'admin')
            @if ($order->status == 'pending')
            <p><strong>Halo Admin, You got new order!</strong></p>
            @else
            <p><strong>Halo Admin, You have new order updated!</strong></p>
            @endif
        @else
            @if ($order->status == 'pending')
            <p style="text-align: center;"><strong>Halo {{ $order->user->name }}</strong>. Terima kasih telah melalukan pembelian melalui The Tropical Spa. Harap segera melakukan pembayaran
                @if($order->payment_method == 'gopay')
                15 Menit
                @else
                1x24 jam
                @endif
                sebelum system kami membatalkan pesanan anda</p><br>
            @endif

            @if ($order->status == 'paid')
                <p style="text-align: center;"><strong>Halo {{ $order->user->name }}</strong>. Terima kasih telah melalukan pembayaran untuk pesanan anda. Tim The Tropical Spa akan segera memproses pesanan anda. Anda dapat memantau pesanan ada pada halaman Transaction History di profile anda pada website kami. Terima Kasih.</p><br>
            @endif

            @if ($order->status == 'sent')
            <p style="text-align: center;"><strong>Halo {{ $order->user->name }}</strong>. Pesanan anda sedang dalam proses pengiriman dengan No. Resi <b>{{ $order->no_resi }}</b>. Anda dapat memantau pesanan ada pada halaman Transaction History di profile anda pada website kami. Terima Kasih.</p><br>
            @endif

            @if ($order->status == 'completed')
            <p style="text-align: center;"><strong>Halo {{ $order->user->name }}</strong>. Pesanan anda telah selesai. Terima kasih atas pesanan ada, dan jangan lupa untuk berbelanja kembali di The Tropical Spa.</p><br>
            @endif

            @if ($order->status == 'failed')
            <p style="text-align: center;"><strong>Halo {{ $order->user->name }}</strong>. Pesanan anda dibatalkan/digagalkan oleh sistem kami karena telah melewati jangka waktu pembayaran. Silahkan berbelanja kembali di The Tropical Spa. Terima Kasih</p><br>
            @endif
        @endif
    </div>
    @if ($order->status == 'pending')
        @if ($order->payment_method == 'virtual_account' || $order->payment_method == 'cvs')
        <table style="width: 600px;border: 1px solid grey;padding: 30px;margin:auto;">
            <tbody>
                <tr>
                    <td style="font-size:20px;">
                        @if ($order->payment_method == 'virtual_account')
                        <center><b>Rekening Virtual Account</b></center><br>
                        @endif
                        @if ($order->payment_method == 'cvs')
                        <center><b>Kode Pembayaran</b></center><br>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="font-size:27px;">
                        @if($order->payment_method == 'virtual_account')
                            @if ($order->response->vacctNo)
                                <center><b style="padding:10px;border:1px solid black;">{{ $order->response->vacctNo }}</b></center>
                            @endif
                        @endif
                        @if($order->payment_method == 'cvs')
                            @if ($order->response->payNo)
                                <center><b style="padding:10px;border:1px solid black;">{{ $order->response->payNo }}</b></center>
                            @endif
                        @endif
                    </td>
                </tr>
            </tbody>
        </table>
        @endif
    @endif

    @if ($type == 'admin')
    <table style="width: 600px;border: 1px solid grey;padding: 30px;margin:auto;">
        <tbody>
            <tr>
                <td style="font-size:20px;">
                    <center><b>Status</b></center><br>
                </td>
            </tr>
            <tr>
                <td style="font-size:27px;">
                    <center><b style="padding:10px;border:1px solid black;">{{ strtoupper($order->status) }}</b></center>
                </td>
            </tr>
        </tbody>
    </table>
    @endif

    <table style="width: 600px;border: 1px solid grey;padding: 30px;font-size: 14px!important;margin:auto; margin-bottom:20px;">
        <tbody>
        <tr>
            <th align="left" colspan="3">Barang Pesanan</th>
            <th align="right">Total Harga</th>
        </tr>
        @foreach ($order->details as $detail)
            <tr>
                <td width="100px">
                    <img width="100px" src="{{ asset($detail->product->cover->url) }}" />
                </td>
                <td colspan="2">
                    <strong>{{ $detail->product->name }}</strong>
                    <p>
                        {{ currency_format($detail->price) }}<br />
                        Qty: {{ $detail->quantity }}
                    </p>
                </td>
                <td valign="middle" align="right">
                    {{ currency_format($detail->price * $detail->quantity) }}
                </td>
            </tr>
        @endforeach
        <tr><td colspan="4"><hr /></td></tr>
        <tr>
            <td colspan="4" width="100%">
                <table width="100%" cellpadding="0" cellspacing="0" border="0">
                    @if ($order->voucher_value)
                    <tr>
                        <td width="70%" valign="middle" align="right"><strong>Discount</strong></td>
                        <td width="30%" valign="middle" align="right">- {{ currency_format($order->voucher_value) }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td width="70%" valign="middle" align="right"><strong>Kurir</strong></td>
                        <td width="30%" valign="middle" align="right">{{ currency_format($order->total_shipping_cost) }}</td>
                    </tr>
                    <tr>
                        <td width="70%" valign="middle" align="right"><strong>Total</strong></td>
                        <td width="30%" valign="middle" align="right">{{ currency_format($order->grand_total) }}</td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td colspan="4"><hr /></td></tr>
        <tr>
            <td colspan="4" valign="top">
                <table cellspacing="0" cellpadding="0" border="0" width="100%">
                    <tr>
                        <td width="50%">
                            <strong>ALAMAT PENGIRIMAN</strong>
                            <p>
                                {{ $order->cart->address->name }}<br />
                                {{ $order->cart->address->address }}, {{ $order->cart->address->subdistrict }}<br />
                                {{ $order->cart->address->city }}, {{ $order->cart->address->province }}<br />
                                Indonesia, {{ $order->cart->address->postal_code }}<br />
                                {{ $order->cart->address->phone_number }}
                            </p>
                        </td>
                        <td width="50%">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr><td colspan="4"><hr /></td></tr>
        <tr>
            <td colspan="4">
                <strong>METODE PEMBAYARAN</strong>
                <p>
                    @if($order->payment_method == 'virtual_account')
                        Bank Transfer
                        @switch($order->bank)
                            @case('bca')
                                <b>(Bank BCA)</b>
                                @break
                            @case('bni')
                                <b>(Bank BNI)</b>
                                @break
                            @case('mandiri')
                                <b>(Bank Mandiri)</b>
                                @break
                            @case('permata')
                                <b>(Bank Permata)</b>
                                @break
                            @case('bri')
                                <b>(Bank BRI)</b>
                                @break
                            @default
                        @endswitch
                    @endif

                    @if($order->payment_method == 'cvs')
                        @switch($order->bank)
                            @case('indomaret')
                                <b>(Indomaret)</b>
                                @break
                            @case('alfamart')
                                <b>(Alfamart)</b>
                                @break
                            @default
                        @endswitch
                    @endif

                    @if($order->payment_method == 'gopay')
                        Gopay
                    @endif
                </p>
            </td>
        </tr>
       </tbody>
    </table>
    {{-- @if($order->payment_method_id == 1)
    <div style="width: 600px;font-size:14px!important;margin:auto;">Harap mengkonfirmasi pembayaran anda setelah transfer ke salah satu bank yang terdaftar. Agar Tim Talasi dapat mengecek pembayaran dan memproses pesanan kamu dengan segera.</div>
    <table width="100%" style="font-size: 14px!important;">
        <tr><td><br /><br /></td></tr>
        <tr>
            <td style="padding: 0;" align="center" valign="middle">
                <a href="
                {{ route('frontend.account.payment') }}?order_code={{ $order->order_code }}&&amount={{ $order->total_after_disc }}&&bank={{ $order->payment_bank }}
                "><button style="background: #E85B51;color: #fff;border-radius: 20px;border: none;display: inline-block;padding: 10px 20px;margin-bottom: 5px;cursor: pointer">KONFIRMASI PEMBAYARAN</button></a>
            </td>
        </tr>
        <tr><td><br /><br /></td></tr>
        <tr><td style="text-align:center;">Untuk informasi lebih lanjut hubungi 0812-8404-0717 atau email ke cot.bisnis@gmail.com.</td></tr>
        <tr><td><br /><br /></td></tr>
    </table>
    @else
    <div style="width: 600px;font-size:14px!important;margin:auto;margin-top:20px;margin-bottom:20px;">Terima kasih atas pembayaran anda. Tim kami akan menghubungi dan segera memproses pesanan anda.</div>
    @endif --}}
@endsection
