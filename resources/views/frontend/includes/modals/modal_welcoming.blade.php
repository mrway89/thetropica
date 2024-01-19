<div class="modal fade" id="welcoming" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered home-welcome-modal" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <button type="button" class="close btn-closemodal" data-dismiss="modal"><p>&times;</p></button>
                @if ($popup->url)
                <a href="{{ $popup->url }}">
                @endif
                    <img src="{{ asset($popup->image) }}" class="img-fluid home-welcome-modal-img" alt="">
                @if ($popup->url)
                </a>
                @endif
            </div>
        </div>
    </div>
</div>
