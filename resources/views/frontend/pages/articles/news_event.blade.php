@extends('frontend/layouts/main')

@section('custom_css')
<link href="{{ asset('assets/plugins/slick/slick.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/slick/slick-theme.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/plugins/raterater/raterater.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/css/style-ricko.css') }}" rel="stylesheet" />
@endsection

@section('content')

<div class="content-area">
    <div class="container container-product pt-mb-0 pt-3">
		<div class="row">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-md-0 mt-2">
               <div class="row">                    
                    <div class="col-lg-12 col-md-5 hidden-768">
                    <label class="sort-by">News : </lable>
                        
                    </div>
                  
                </div>    
				<div class="container">
					<div class="row">
						 @foreach ($posts as $rows)                         
						<div class="col-lg-4 col-sm-3 mb-4">
							<div class="card card-margin"><br />
                                @php
                                 $imagesc = DB::table('images')->where('type', 'news')->where('item_id', $rows->id)->first();
                                 $small_desc = substr($rows->{'content_' . $language}, 0, 100);
                                @endphp
								<div class="card-header mb-2 no-border">
									<img src="{{ asset($imagesc->url) }}" width="320px" height="180px" />
								</div>
								<div class="card-body pt-0">
									<div class="widget-49">
										<div class="widget-49-title-wrapper">
											<div class="widget-49-date-primary">
												<span class="widget-49-date-day">{{ $rows->created_at->format('d') }}</span>
												<span class="widget-49-date-month">{{ $rows->created_at->format('M') }}</span>
											</div>
											<div class="widget-49-meeting-info">
												<span class="widget-49-pro-title">{{ $rows->{'title_' . $language} }}</span>
											</div>
										</div>
										<p>
											{!! $small_desc !!} ...
                                        </p>
										<div class="widget-49-meeting-action">
											<a href="{{ route('frontend.news_detail', $rows->slug) }}" class="btn btn-sm btn-flash-border-primary">Read More</a>
										</div>
									</div>
								</div>
							</div>
						</div>
						@endforeach
					</div>
				</div>
				
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                        {{ $posts->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>

@include('frontend/includes/modals/modal_detail_product')
@include('frontend/includes/modals/modal_reviews')
@endsection

@section('footer')
@include('frontend/includes/footer_scrollspy')
@endsection


