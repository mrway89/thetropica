<!doctype html>
<html lang="en">

<head>
    <title>Talasi - Under Maintenance</title>
    <link rel="shortcut icon" href="{{ asset('components/shared/images/favicon.png') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert.css')}}">
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />

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
    <div class="wrapper">
        <nav class="navbar navbar-expand-md fixed-top px-5 headerzindex d-none d-md-flex bg-transparent">
            <div class="container-fluid">
                <div class="d-flex w-50 order-0">
                    <a class="navbar-brand brandlogwhite mr-1" href="{{ route('frontend.home') }}">
                        <img src="{{ asset('assets/img/logo.png') }}" class="img-logo" alt="">
                    </a>
                </div>
            </div>
        </nav>
        <div class="section fp-table d-flex align-items-center" id="comming-soon">
            <div class="fp-tableCell w-100">
                <div class="col-12 ">
                    <div class="row justify-content-center commingsoon ">
                        <div class="col-md-6 text-center text-white ">
                            <h1>We Are Coming Soon!</h1>
                            <p>We are working on a new and exciting product that you'll really like! Enter your email address below to be
                                the first to know when we launch it.
                            </p>
                            <form action="{{ route('frontend.upcoming.subscribe') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="input-group group-subscribe rounded-0 mb-3">
                                    <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" class="form-control txt-subs rounded-0" placeholder="Insert your email address here" aria-label="" aria-describedby="basic-addon2" name="email" required>
                                    <div class="input-group-append">
                                        <button type="submit" class="btn btn-subs rounded-0" type="button">Subscribe</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/js/fullpage.min.js')}}"></script>
    <script src="{{ asset('assets/js/sweetalert.js')}}"></script>

    <script>
   $(document).ready(function() {

        @if (Session::has('success'))
        swal("Thank You", "{{ Session::get('success') }}", "success");
        @endif

        @if (Session::has('error'))
        swal("Thank You", "{{ Session::get('error') }}", "warning");
        @endif
		$('#fullpage').fullpage({
			//options here
			anchors: ['1', '2', '3', '4', '5', '6','7'],
			autoScrolling:true,
			scrollHorizontally: true,
			normalScrollElements: 'footer'
		});

		//methods
		$.fn.fullpage.setAllowScrolling(true);
	});
    </script>
</body>

</html>
