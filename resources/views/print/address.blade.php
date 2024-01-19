
<html>
<head>
    <title>Print Address</title>
    <style>
        @font-face {
            font-family: 'museo_sans';
            src: url('{{asset('assets/fonts/museosans_500-webfont.eot')}}');
            src: url('{{asset('assets/fonts/museosans_500-webfont.eot')}}') format('embedded-opentype'),
                url('{{asset('assets/fonts/museosans_500-webfont.woff2')}}') format('woff2'),
                url('{{asset('assets/fonts/museosans_500-webfont.woff')}}') format('woff'),
                url('{{asset('assets/fonts/museosans_500-webfont.ttf')}}') format('truetype'),
                url('{{asset('assets/fonts/museosans_500-webfont.svg')}}') format('svg');
            font-weight: normal;
            font-style: normal;

        }

        @font-face {
            font-family: 'museo_sans';
            src: url('{{asset('assets/fonts/museosans_500_italic-webfont.eot')}}');
            src: url('{{asset('assets/fonts/museosans_500_italic-webfont.eot')}}') format('embedded-opentype'),
                url('{{asset('assets/fonts/museosans_500_italic-webfont.woff2')}}') format('woff2'),
                url('{{asset('assets/fonts/museosans_500_italic-webfont.woff')}}') format('woff'),
                url('{{asset('assets/fonts/museosans_500_italic-webfont.ttf')}}') format('truetype'),
                url('{{asset('assets/fonts/museosans_500_italic-webfont.svg')}}') format('svg');
            font-weight: normal;
            font-style: italic;
        }
        @page {
            size: 16.5cm 20.5cm;
            font-family: 'museo_sans';
            padding: 0;
            margin:0;
        }

        body {font-family: 'museo_sans', Arial, Helvetica, sans-serif;padding:0;margin:0;}
        table {
            margin:1.4cm auto 0 2.6cm;
            /* background: red; */
            /*width:100%;*/
        }

        table tr td {
            width:11.8cm;
            height:7.8cm;
            border-width: 1px;
            border-style: solid;
            border-color: transparent;
            text-align: center;
            font-size:12px;
            /* background:green; */
        }

        table tr {
            bottom: 24.5mm;

        }

        table tr td div {
            /* padding:0 0.1%; */
        }
    </style>
</head>
<body>
    <table id="skel" cellspacing="0">
        @foreach($products as $index=>$product)
                <tr>
                    <td>
                        @if($product != 0)
                        <div style="border:1px solid #fff; border-radius:50%; width: 100%; {{ $index % 2 ? 'margin-top: 95px' : '' }}">
                            <div style="clear: both;width: 100%;text-align: left;">
                                <div style="padding:5mm; 2.5mm;">
                                    <div style="margin-bottom:30px;">
                                        <img src="{{ $logo }}" alt="" height="50">
                                    </div>
                                    <div>
                                        <strong>Ship to:</strong>
                                        <p>
                                            <strong>{{ $product->cart->address->name }}</strong><br />
                                            {{ $product->cart->address->address }} <br>
                                            {{ $product->cart->address->city }}, {{ $product->cart->address->province }} {{ $product->cart->address->postal_code }}<br />
                                            Phone: {{ $product->cart->address->phone_number }}
                                        </p>
                                    </div>
                                    <div style="">
                                        <p style="font-size: 11px;">
                                            <br>
                                            <strong>PT. Talasi Bumi Tabanan</strong><br>
                                            Jl. Wira No. 8, Sanur, Denpasar, Bali 80228<br>
                                            <b>t</b> 0361 285 479 <span style="margin: 0px 5px";>•</span> <b>e</b> info@talasi.co.id <span style="margin: 0px 5px";>•</span> www.talasi.co.id
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                        @endif
                    </td>
                </tr>
        @endforeach
    </table>
</body>
</html>
