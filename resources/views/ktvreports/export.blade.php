<html>
<table>
    <thead>
        <tr>
            <th>Mã</th>
            <th>Đơn vị kinh doanh</th>
            <th>Tỉnh</th>
            <th>Quận/Huyện</th>
            <th>Số điện thoại</th>
            <th>Số lần sử dụng bài hát</th>
            <th>Tổng tiền</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($ktv_reports as $ktv_report)
            <tr>
                <td>{{ $ktv_report->id }}</td>
                <td>{{ $ktv_report->ktv_name }}</td>
                <td>{{ $ktv_report->province }}</td>
                <td>{{ $ktv_report->district }}</td>
                <td>{{ $ktv_report->phone }}</td>
                <td>{{ $ktv_report->total_times }}</td>
                <td>{{ number_format($ktv_report->total_money, 0, '.', '.') }} VNĐ</td>
            </tr>
        @endforeach
    </tbody>
</table>


</html>