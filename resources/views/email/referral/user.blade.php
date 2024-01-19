@extends('email.template.master')
@section('content')
    <table width="100%" style="font-size: 14px!important;">
        <tr>
            <td style="padding: 0;" align="center" valign="middle">
                <br>
                <br>
                Talasi Family says hi!
                <br>
                <br>
                We invite you to join the family
                <br><br>
                Please copy paste the URL below
                <br>
                <br>
                <br>
                <br>
                <span style="border:1px solid #000; padding: 5px">{{ route('frontend.login', ['ref' => $user->referralCode()]) }}</span>
                <br>
                <br>
                <br>
                <br>
                or click join
                <br>
                <br>
                <br>
                <a href="{{ route('frontend.login', ['ref' => $user->referralCode()]) }}" style="padding:10px; margin:0 10px;background:#228aca;color:#fff;border-radius: 4px;">Join</a>
                <br><br><br>
            </td>
        </tr>
        <tr><td><br /><br /></td></tr>
        <tr><td style="text-align:center;"></td></tr>
        <tr><td><br /><br /></td></tr>
    </table>
@endsection
