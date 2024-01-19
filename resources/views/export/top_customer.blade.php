<html>
    <tr>
        <td>No</td>
        <th>Name</th>
        <th>Order</th>
        <th>Value</th>
    </tr>
    @foreach($datas as $data)
        <tr>
            <td>{{$no++}}</td>
            <td><a href="{{ route('AdminMemberManagementControllerGetEdit', $data->user->id) }}">{{ $data->user->name }} - {{ $data->user->email }}</a></td>
            <td>{{ $data->count }}</td>
            <td>{{ currency_format($data->total_order) }}</td>
        </tr>
    @endforeach
</html>
