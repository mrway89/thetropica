@extends('email.template.master')
@section('content')
    <table width="100%" style="font-size: 14px!important;">
        <tr>
            <td style="padding: 0;" align="center" valign="middle">
                Hello Admin!<br>
                <br><br>
                You have a new contact Message from user<br>
                <br><br>
                Name: {{ $name }} <br>
                Company: {{ $company or '-' }} <br>
                Email: {{ $email }} <br>
                Phone: {{ $phone }} <br>
                Fax: {{ $fax or '-' }} <br>
                Address: {{ $address }} <br>
                City: {{ $city }} <br>
                Country: {{ $country }} <br><br><br>
                Message: <br>
                {{ $content }} <br>
                <br><br>
            </td>
        </tr>
        <tr><td><br /><br /></td></tr>
        <tr><td style="text-align:center;"></td></tr>
        <tr><td><br /><br /></td></tr>
    </table>
@endsection
