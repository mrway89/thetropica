@extends('frontend/purchase/includes/purchase_layout')
@section('purchase_content')
<div class="col-lg-3 col-md-3 hidden-768">
	<form>
		<select id="select-shoppingguide" class="custom-select select-shoppingguide w-100 mb-5">
			@foreach ($posts as $i=>$item)
			<option value='{{ $i }}'>{{ $item->{'title_' . $language} }}</option>
			@endforeach
		</select>
	</form>
</div>
<ul class="nav nav-tabs d-none" id="tab-shoppingguide">
	@foreach ($posts as $i=>$item)
	<li class="{{ $i == 0 ? 'active' : '' }}"><a href="#content-{{ $i }}" data-toggle="tab">{{ $item->{'title_' . $language} }}</a></li>
	@endforeach
</ul>
<div class="tab-content tab-shoppingguide">
	@foreach ($posts as $i=>$item)
		<div class="tab-pane {{ $i == 0 ? 'active' : '' }}" id="content-{{ $i }}">
			{!! $item->{'content_' . $language} !!}
		</div>
	@endforeach
</div>
@endsection
