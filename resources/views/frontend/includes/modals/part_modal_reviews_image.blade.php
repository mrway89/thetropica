<div class="slider-for mb-4">
    @foreach ($images as $image)
        <div class="items">
            <img src="{{asset($image->url)}}" alt="">

            <div class="star-rating d-flex justify-content-start mb-4 position-relative">
                <div class="ofrate"></div>
                <div class="rateview-sm" data-id="1" data-rating="{{ $image->review->rating }}"></div>
                <div class="info-rate pl-2">oleh <b>{{ ucwords($image->user->name) }}</b> <small>{{ \Carbon\Carbon::parse($image->created_at)->format('d M Y H:i') }}</small></div>
            </div>
        </div>
    @endforeach
    </div>
<div class="slider-nav">
    @foreach ($images as $image)
        <div class="items"><img src="{{asset($image->url)}}" alt=""></div>
    @endforeach
</div>
