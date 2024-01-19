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
			<div class="blog-single gray-bg">
					<div class="container">
						<div class="row align-items-start">
							<div class="col-lg-8 m-15px-tb">
							@foreach ($post as $rows)
							   @php
                                 $imagesc = DB::table('images')->where('type', 'news')->where('item_id', $rows->id)->first();
                                @endphp
								<article class="article">
									<div class="article-img">
										<img src="{{ asset($imagesc->url) }}" class="img_art"  title="{{ $rows->{'title_' . $language} }}" alt="{{ $rows->{'title_' . $language} }}">
									</div>
									<div class="article-title">
										<!--<h6><a href="#">Lifestyle</a></h6>-->
										<h2>{{ $rows->{'title_' . $language} }}</h2>
										<div class="media">											
											<div class="media-body">
												<label>Admin</label>
												<span>{{ $rows->created_at->format('d') }} {{ $rows->created_at->format('M') }} {{ $rows->created_at->format('Y') }}</span>
											</div>
										</div>
									</div>
									<div class="article-content">
										<p>{!! $rows->{'content_' . $language} !!}</p>
									</div>
								</article>
							@endforeach
								<!--<div class="contact-form article-comment">
									<h4>Leave a Reply</h4>
									<form>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<input name="Name" id="name" placeholder="Name *" class="form-control" type="text">
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<input name="Email" id="email" placeholder="Email *" class="form-control" type="email">
												</div>
											</div>
											<div class="col-md-12">
												<div class="form-group">
													<textarea name="message" id="message" placeholder="Your message *" rows="4" class="form-control"></textarea>
												</div>
											</div>
											<div class="col-md-12">
												<div class="send">
													<button class="px-btn theme"><span>Submit</span> <i class="arrow"></i></button>
												</div>
											</div>
										</div>
									</form>
								</div>-->
							</div>
							<div class="col-lg-4 m-15px-tb blog-aside">								
								
								<!-- Latest Post -->
								<div class="widget widget-latest-post">
									<div class="widget-title">
										<h3>Latest Post</h3>
									</div>
									<div class="widget-body">
									@foreach ($latests as $rw)
									    @php
											$imag = DB::table('images')->where('type', 'news')->where('item_id', $rw->id)->first();
										@endphp
										<div class="latest-post-aside media">
											<div class="lpa-left media-body">
												<div class="lpa-title">
													<h5><a href="#">{{ $rw->{'title_' . $language} }}</a></h5>
												</div>
												<div class="lpa-meta">
													<a class="name" href="#">
														Admin
													</a>
													<a class="date" href="#">
													{{ $rw->created_at->format('d') }} {{ $rw->created_at->format('M') }} {{ $rw->created_at->format('Y') }}
													</a>
												</div>
											</div>											
										</div>
										@endforeach
									</div>
								</div>
								<!-- End Latest Post -->
								
							</div>
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


