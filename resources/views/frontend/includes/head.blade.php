<meta charset="UTF-8">
<title>{{ $head_title ? $head_title : ucwords(Request::segment(1)) . ' - The Tropical Spa' }}</title>
<script>
    var path = "{{ asset('') }}";
</script>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="id">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="robots" content="index, follow"/>
<meta name="root_url" content="{{url('/')}}/" />

<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="{{ asset('assets/css/style.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('assets/css/font-awesome/css/font-awesome.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/owl.theme.default.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/sweetalert.css')}}">
<link rel='shortcut icon' type='image/x-icon' href='{{ asset($favicon) }}' />
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />

{{-- meta --}}
<meta content="{{ $head_meta_title ? $head_meta_title : ucwords(Request::segment(1)) . ' - Talasi' }}" name="title" />
<meta content="{{ $head_keyword ? $head_keyword : $default_keyword }}" name="keywords" />
<meta content="{{ $head_description ? $head_description : $default_description }}" name="description" />
<meta content="Dotcomsolution.co.id" name="author" />
<meta name="geo.placename" content="Indonesia">
<meta name="geo.country" content="ID">
<meta name="language" content="Indonesian">
<meta name="lat" content="-6.2729318" />
<meta name="lng" content="106.846599" />

<!-- Open Graph data -->
<meta property="og:title" content="{{ $head_title ? $head_title : ucwords(Request::segment(1)) . ' - Talasi'  }}" />
<meta property="og:type" content="article" />
<meta property="og:url" content="{{ url()->current() }}" />
<meta property="og:image" content="{{ $head_image ? $head_image : asset('assets/img/logo.png') }}" />
<meta property="og:description" content="{{  $head_description ? $head_description : $default_description  }}" />
<meta property="og:site_name" content="The Tropical Spa" />

<!-- Twitter Card data -->
<meta name="twitter:card" content="summary">
<meta name="twitter:site" content="Talasi">
<meta name="twitter:title" content="{{ $head_title ? $head_title : ucwords(Request::segment(1)) . ' - Talasi' }}">
<meta name="twitter:description" content="{{ $head_description ? $head_description : $default_description }}">
<meta name="twitter:creator" content="Dotcomsolution.co.id">
<meta name="twitter:image" content="{{ $head_image ? $head_image : asset('assets/img/logo.png') }}">
<meta name="google-site-verification" content="IwioPSm-7aMSRa5oSp7krSKn5zndb6XaajCmkz-mUl4" />

@yield('meta_facebook')


<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-69504Z7TC0"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-69504Z7TC0');
</script>
