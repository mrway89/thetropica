<html>
    <tr>
        <td>No</td>
        <th>Product</th>
        <th>Value</th>
    </tr>
    @foreach($datas as $data)
        <tr>
            <td>{{$no++}}</td>
            <td><a href="{{ route('AdminProductsControllerGetEdit', $data->id) }}">{{ $data->name }}</a></td>
            <td>{{ numbering_format($data->view) }}</td>
        </tr>
    @endforeach
</html>
