<!doctype html>
<html lang="en">

<head>
    <title>Talasi - Page Not Found</title>
    <link rel="shortcut icon" href="{{ asset('components/shared/images/favicon.png') }}" />
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
        crossorigin="anonymous">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
    <style>
        .holder {
            width: 300px;
            height: 300px;
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            margin: auto;
            text-align: center;
            font-size: 12px;
            color: #999999;
        }

        .holder span {
            margin-top: 10px;
            display: block;
        }
    </style>
</head>

<body>
    <div class="holder">
        <img src="{{asset('assets/img/logo.png')}}" width="100%" />
        <span>
            we are sorry but the page you are looking does not exist<br />
            you may have mistyped or the page has been removed by our system.
        </span>
        <br />
        <a href="{{ route('frontend.home') }}">Back to Home</a>
    </div>
</body>

</html>
