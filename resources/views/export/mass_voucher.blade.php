<html>
    <tr>
        <td>No</td>
        <td>Voucher Code</td>
        <td>Start Date</td>
        <td>End Date</td>
        <td>Type</td>
        <td>Amount</td>
        <td>Minimum Transaction</td>
    </tr>
    @foreach($datas as $data)
        <tr>
            <td>{{$no++}}</td>
            <td>{{$data->code}}</td>
            <td>{{$data->start_date}}</td>
            <td>{{$data->end_date}}</td>
            <td>{{$data->type}}</td>
            <td>{{$data->discount}}</td>
            <td>{{$data->min_amount}}</td>
        </tr>
    @endforeach
</html>
