<table width="100%" style="font-size: 14px;width: 100%!important;" xmlns="http://www.w3.org/1999/html">
    <tr>
        <td>
            <div style="background: #ff5656;color: #fff;height: 45px;width:90%!important;clear:both;padding:10px 5%;">
                <span style="float: left;margin-top: 15px">&copy; The Tropical Spa {{ date('Y') }}.&nbsp;&nbsp;</span>
                <span style="float: right">
                    {{-- @if(isset($socials))
                        @foreach($socials as $social)
                            <a href="http://{{ $social['url'] }}">
                            <img width="40px" style="margin-right: 10px;" src="{{ $message->embed(asset('assets/uploads/social-media/'.$social['image'])) }}" />
                        </a>
                        @endforeach
                    @endif --}}
                </span>
            </div>
        </td>
    </tr>
</table>
