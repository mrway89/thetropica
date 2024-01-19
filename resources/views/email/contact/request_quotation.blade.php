@extends('email.template.master')
@section('content')
    <table width="100%" style="font-size: 14px!important;">
        <tr>
            <td style="padding: 0;" align="center" valign="middle">
                Hello {{ $name }}!<br>
                Thank You for requesting quotation for {{ ucwords($quotation->project->title) }}, {{ ucwords($quotation->project->provider->name) }} will directly contact you soon.
                <br><br>
                If you are having any issues with your account. Please don't be hesistate to contact us by replying this email.<br><br>
            </td>
        </tr>
        <tr><td><br /><br /></td></tr>
        <tr><td style="text-align:center;"></td></tr>
        <tr><td><br /><br /></td></tr>
    </table>
@endsection
