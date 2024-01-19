@extends('email.template.master')
@section('content')
    <table width="100%" style="font-size: 14px!important;">
        <tr>
            <td style="padding: 0;" align="center" valign="middle">
                Welcome to The Tropical Spa.<br>
                {{-- @if ($type == 'verify') --}}
                <br>
                Click the link button below to {{ $type == 'verify' ? 'verify your account.' : 'reset your password.' }}
                <br><br>
                <br><br>
                @if ($type == 'verify')
                <a href="{{ route('frontend.verification', encrypt($verification_code)) }}" style="padding:10px; margin:0 10px;background:#228aca;color:#fff;border-radius: 4px;">Verify Account</a>
                @else
                <a href="{{ route('frontend.forgot.verification', encrypt($verification_code)) }}" style="padding:10px; margin:0 10px;background:#228aca;color:#fff;border-radius: 4px;">Reset Password</a>
                @endif
                {{-- @endif --}}
                <br><br><br>
            </td>
        </tr>
        <tr><td><br /><br /></td></tr>
        <tr><td style="text-align:center;"></td></tr>
        <tr><td><br /><br /></td></tr>
    </table>
@endsection
