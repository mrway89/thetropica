@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')
<div class="section fp-table mb-0 pb-0 fp-product" id="product-1">
    <div class="fp-tableCell">
        <div class="container-fluid">
            <div class="row justify-content-center">
                <div class="col-md-12 ">

                    <div class="row">
                        @foreach ($experiences as $i => $experience)

                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 pl-lg-5 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 mt-0 box-brand box-category" id="cate-{{ $i+1 }}">
                            <div class="overlaybg" style="background-image: url({{ asset($experience->image) }})"></div>
                            <div class="overlay"></div>
                            <div class="row justify-content-center ">
                                <div class="col-md-10 text-center brand">
                                    <h1>{{ $experience->{'title_' . $language} }}</h1>
                                    <h5>{{ $experience->{'subtitle_' . $language} }}</h5>
                                    <div class="desc-brand mb-3">
                                        <p>
                                            {{ $experience->{'content_' . $language} }}
                                        </p>
                                    </div>

                                    <a href="{{ $experience->link }}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">Let's Go</button></a>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        {{-- <div class="col-lg-4 col-md-4 col-sm-12 col-12 pl-lg-5 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 box-brand box-category" id="cate-2">
                            <div class="overlaybg" style="background-image: url({{asset('assets/img/bence-balla-schottner-k3PN_7R3FcA-unsplash.png')}})"></div>
                            <div class="overlay"></div>
                            <div class="row justify-content-center">
                                <div class="col-md-10 text-center brand">
                                    <h1>Factory Visit</h1>
                                    <h5>The One and Only Spirit of Bali </h5>
                                    <div class="desc-brand mb-3">
                                        <p>Starling is our line of fine sotju distilled
                                            at the hills of Bali at our own Wanagiri
                                            Estate Tabanan after years of meticulous search for the perfect
                                            tasting Spirit of Bali from hand picked and natural ingredients.
                                            Our passion for perfection to create The Spirit of Bali is our
                                            homage to showcase the best of nature luxuriously.
                                        </p>
                                    </div>
                                    <a href="{{url('frontend/experience/factory-visit')}}"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">Let's Go</button></a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 pl-lg-5 pr-lg-5 pl-md-4 pr-lg-4 pl-3 pr-3 box-brand box-category" id="cate-3">
                            <div class="overlaybg" style="background-image: url({{asset('assets/img/bence-balla-schottner-k3PN_7R3FcA-unsplash.png')}})"></div>
                            <div class="overlay"></div>
                            <div class="row justify-content-center">
                                <div class="col-md-10 text-center brand">
                                    <h1>Camp with Us</h1>
                                    <h5>Feel Nature's Freshness </h5>
                                    <div class="desc-brand mb-3">
                                        <p>To-ye, sanskrit for water, is our fine of pure liquified natural product for you to
                                            Feel Nature's Freshness from Face Mist, Foot Mist, Traditional Oil and Room Mist.
                                            Our ingredients are extracted from the origin and extracted with state of the art technologies to capture nature's best.
                                                To-ye is a unique way to experience nature's best kept secret.
                                        </p>
                                    </div>
                                    <a href="#"><button class="btn-border-white px-3 py-2 pointer btn-letsgo d-none">Let's Go</button></a>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('footer')
@include('frontend/includes/footer')
@endsection

@section('custom_js')
<script src="{{ asset('assets/js/fullpage.min.js')}}"></script>
<script>
        $(document).ready(function() {
            $('#fullpage').fullpage({
                //options here
                anchors: ['1', '2', '3', '4', '5', '6'],
                autoScrolling:true,
                scrollHorizontally: true,
                // normalScrollElements: 'footer'
            });

        // 	//methods
            $.fn.fullpage.setAllowScrolling(true);
        });
        $(document).on('click', '#moveTo1', function(){
          fullpage_api.moveTo('page1', 1);
        });

        $(document).on('click', '#moveTo2', function(){
          fullpage_api.moveTo('page2', 2);
        });
        $("#cate-1").mouseenter(function() {
            $('.box-category').find(".overlaybg").removeClass('active');
            $('.box-category').find(".overlay").addClass('active');
            $('#cate-1').find(".overlaybg").addClass('active');
            $('#cate-1').find(".overlay").removeClass('active');
            $('#cate-1').find(".brand").css({'color':'#fff'});
            $('#cate-1').find(".btn-letsgo").removeClass('d-none');
            $('.headerzindex').addClass('active');
            $('.headerzindex').addClass('navbg-transparent');
            $('.headerzindex').addClass('border-bottom-0');
        });
        $("#cate-1").mouseleave(function() {
            $('.box-category').find(".overlaybg").removeClass('active');
            $('.box-category').find(".overlay").removeClass('active');
            $('#cate-1').find(".overlaybg").removeClass('active');
            $('#cate-1').find(".brand").css({'color':'#212529'});
            $('#cate-1').find(".btn-letsgo").addClass('d-none');
            $('.headerzindex').removeClass('active');
            $('.headerzindex').removeClass('navbg-transparent');
            $('.headerzindex').removeClass('border-bottom-0');
        });

        $("#cate-2").mouseenter(function() {
            $('.box-category').find(".overlaybg").removeClass('active');
            $('.box-category').find(".overlay").addClass('active');
            $('#cate-2').find(".overlaybg").addClass('active');
            $('#cate-2').find(".overlay").removeClass('active');
            $('#cate-2').find(".brand").css({'color':'#fff'});
            $('#cate-2').find(".btn-letsgo").removeClass('d-none');
            $('.headerzindex').addClass('active');
            $('.headerzindex').addClass('navbg-transparent');
            $('.headerzindex').addClass('border-bottom-0');
        });
        $("#cate-2").mouseleave(function() {
            $('.box-category').find(".overlaybg").removeClass('active');
            $('.box-category').find(".overlay").removeClass('active');
            $('#cate-2').find(".overlaybg").removeClass('active');
            $('#cate-2').find(".brand").css({'color':'#212529'});
            $('#cate-2').find(".btn-letsgo").addClass('d-none');
            $('.headerzindex').removeClass('active');
            $('.headerzindex').removeClass('navbg-transparent');
            $('.headerzindex').removeClass('border-bottom-0');
        });

        $("#cate-3").mouseenter(function() {
            $('.box-category').find(".overlaybg").removeClass('active');
            $('.box-category').find(".overlay").addClass('active');
            $('#cate-3').find(".overlaybg").addClass('active');
            $('#cate-3').find(".overlay").removeClass('active');
            $('#cate-3').find(".brand").css({'color':'#fff'});
            $('#cate-3').find(".btn-letsgo").removeClass('d-none');
            $('.headerzindex').addClass('active');
            $('.headerzindex').addClass('navbg-transparent');
            $('.headerzindex').addClass('border-bottom-0');
        });
        $("#cate-3").mouseleave(function() {
            $('.box-category').find(".overlaybg").removeClass('active');
            $('#cate-3').find(".overlaybg").removeClass('active');
            $('#cate-3').find(".overlaybg").removeClass('active');
            $('#cate-3').find(".brand").css({'color':'#212529'});
            $('#cate-3').find(".btn-letsgo").addClass('d-none');
            $('.headerzindex').removeClass('active');
            $('.headerzindex').removeClass('navbg-transparent');
            $('.headerzindex').removeClass('border-bottom-0');
        });

    </script>
@endsection
