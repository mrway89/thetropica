<!DOCTYPE html>
<html>
    <head>
        @include('template/includes/head')
        @yield('custom_css')
    </head>
    <body>
    <div class="wrapper">
        @include('template/includes/header')
        
        @yield('content')
        @yield('footer')
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/jquery.min.js')}}"></script>
    <script src="{{ asset('assets/js/bootstrap.min.js')}}"></script>
    <script src="{{ asset('assets/js/owl.carousel.min.js')}}"></script>
    <script src="{{ asset('assets/js/sweetalert.js')}}"></script>
    <script>
        function openNav() {
            var element = document.getElementById("mySidenav");
            element.classList.toggle("w-100");
        }
    </script>
    @yield('custom_js')
    </body>
</html>