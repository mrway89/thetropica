@foreach ($details as $detail)
<option value="{{ Crypt::encryptString($detail->id) }}">{{ $detail->product->full_name }}</option>
@endforeach
