@extends('email.template.master')
@section('content')
    <table width="100%" style="font-size: 14px!important;">
        <tr>
            <td style="padding: 0;" align="center" valign="middle">
                @if ($type == 'admin')
                Halo Admin, there is an e-ticket successfully sent to user<br>
                @else
                Halo {{ $order->order->user->name }}</strong>. Terima kasih telah melakukan transaksi melalui Talasi. Berikut link untuk mengunduh E-Tiket anda. Terima Kasih.<br>
                @endif
                <br><br>
                <a href="{{ $loket->result->evoucher_url }}" style="padding:10px; margin:0 10px;background:#228aca;color:#fff;border-radius: 4px;">Download E-Ticket</a>
                <br><br>
                If you are having any issues. Please don't be hesistate to contact us by replying to info@talasi.co.id, WhatsApp message to +62 811 999 5388 or call us at +62 361 285 479<br><br>
            </td>
        </tr>
        <tr><td><br /><br /></td></tr>
        <tr><td style="text-align:center;"></td></tr>
        <tr><td><br /><br /></td></tr>
    </table>
@endsection
