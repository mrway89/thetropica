@foreach ($product->images as $i => $img)
	<div class="modal fade" id="thumbnailModal{{ $i }}" tabindex="-1" role="dialog" aria-labelledby="thumbnailModalLabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-lg" role="document">
			<div class="modal-content">
				<div class="modal-body p-0">
					<button type="button" class="close btn-closemodal" data-dismiss="modal"><p>&times;</p></button>
					<img src="{{ asset($img->url) }}" class="w-100" alt="">
				</div>
			</div>
		</div>
	</div>
@endforeach