@extends('email.template.master')
@section('content')
    <table width="100%" style="font-size: 14px!important;">
        <tr>
            <td style="padding: 0;" align="center" valign="middle">
                @if ($type == 'admin')
                    Hello Admin,
                    <br>
                        <img src="{{ secure_asset($coupon->images) }}" alt="">
                    <br><br>
                    A User has been redeemed a manual coupon.
                @else
                    Hello {{ $user->name }},
                    <br><br>
                    Thanks for exchanging your points to coupon.
                    <br><br>
                    <img src="{{ secure_asset($coupon->images) }}" alt="">
                    <br><br>
                    Our Team will contact you soon, to process, Thank You.
                @endif

            </td>
        </tr>
        <tr><td><br /><br /></td></tr>
        <tr><td style="text-align:center;"></td></tr>
        <tr><td><br /><br /></td></tr>
    </table>
@endsection
