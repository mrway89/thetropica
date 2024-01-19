<!DOCTYPE html>
<html>
    <head>
        @include('frontend/includes/head')
        @yield('custom_css')
        <style>
            #loading_wrapper {
                width: 100vw;
                height: 100vh;
                top: 0;
                left: 0;
                position: fixed;
                display: none;
                background-color: rgba(255, 255, 255, 0.75);
                z-index: 2000;
                text-align: center;
            }
            #loading-image {
                position: absolute;
                top: 50%;
                left: 50%;
                z-index: 100;
                transform: translate(-50%, -50%);
            }
        </style>
    </head>
    <body>
    <div class="wrapper">
        @include('frontend/includes/header')
        @yield('content')
        @yield('footer')
    </div>
    <div id="loading_wrapper">
        <img id="loading-image" src="{{ asset("assets/img/loading.gif") }}" alt="Loading..." />
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('assets/js/sweetalert.js')}}"></script>
    <script src="{{ asset('assets/js/scrolloverflow.min.js')}}"></script>
    <script>
        function openNav() {
            var element = document.getElementById("mySidenav");
            element.classList.toggle("w-100");
        }
    </script>
    <script>
    $(function() {
        @if (Session::has('success'))
        swal("Success", "{{ Session::get('success') }}", "success");
        @endif

        @if (Session::has('error'))
        swal("Error", "{{ Session::get('error') }}", "error");
        @endif


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    </script>
    <!-- Facebook Pixel Code -->
    <script>
      !function(f,b,e,v,n,t,s)
      {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
      n.callMethod.apply(n,arguments):n.queue.push(arguments)};
      if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
      n.queue=[];t=b.createElement(e);t.async=!0;
      t.src=v;s=b.getElementsByTagName(e)[0];
      s.parentNode.insertBefore(t,s)}(window, document,'script',
      'https://connect.facebook.net/en_US/fbevents.js');
      fbq('init', '164998714929567');
      fbq('track', 'PageView');
    </script>
    <noscript>
      <img height="1" width="1" style="display:none" 
           src="https://www.facebook.com/tr?id=164998714929567&ev=PageView&noscript=1"/>
    </noscript>
    <!-- End Facebook Pixel Code -->
    @include('frontend.purchase.includes.transaction_script')
    @yield('custom_js')
    </body>
</html>
