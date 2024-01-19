@extends('email.template.master')
@section('content')
    <table width="100%" style="font-size: 14px!important;">
        <tr>
            <td style="padding: 0;" align="center" valign="middle">
                Hello {{ $name }}!<br>
                You have new request quotation {{ ucwords($quotation->project->title) }}<br><br>
                From: {{ ucwords($quotation->name) }}<br><br>
                Email: {{ $quotation->email }}<br><br>
                Phone: {{ $quotation->phone }}<br><br>
                Proposed Date: {{ \Carbon\Carbon::parse($quotation->proposed_date)->format('d F Y') }}<br><br>
                Message:<br>
                {{ $quotation->message }}
                <br><br>
                You can check your service provider page on your user profile for more info.<br><br>
            </td>
        </tr>
        <tr><td><br /><br /></td></tr>
        <tr><td style="text-align:center;"></td></tr>
        <tr><td><br /><br /></td></tr>
    </table>
@endsection
