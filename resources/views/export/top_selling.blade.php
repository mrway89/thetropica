<html>
    <tr>
        <td>No</td>
        <th>Product</th>
        <th>Quantity Sold</th>
        <th>Value</th>
    </tr>
    @foreach($datas as $data)
        <tr>
            <td>{{$no++}}</td>
            <td><a href="{{ route('AdminProductsControllerGetEdit', $data->id) }}">{{ ucwords($data->product->full_name) }}</a></td>
            <td>{{ $data->count }}</td>
            <td>{{ currency_format($data->total_order) }}</td>
        </tr>
    @endforeach
</html>
