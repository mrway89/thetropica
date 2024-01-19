<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta content="text/html;charset=utf-8" http-equiv="content-type">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro' rel='stylesheet' type='text/css'>
    <style>

        body{font-family: 'Source Sans Pro', sans-serif;padding:0;margin:0;}
        a{text-decoration: none;color:inherit}
        .header-title {border: 2px solid #E85B51;color: #000;font-size: 18px!important;font-weight: bold;padding: 10px 30px;border-radius: 20px;display: inline-block}
        img {vertical-align: middle}
        .gmailfix {
            display:none;
            display:none!important;
        }
    </style>
</head>
<body>
<div class="gmailfix" style="white-space:nowrap; font:15px courier; line-height:0;">
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
</div>
<center>
    <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td align="center">@include("email.template.header-email")</td>
        </tr>
        <tr>
            <td align="center" valign="top">@yield('content')</td>
        </tr>
        <tr>
            <td align="center" valign="top">@include("email.template.footer-email")</td>
        </tr>
    </table>
</center>
</body>
</html>
