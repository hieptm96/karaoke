<html>
<table>
    <thead>
        <tr>
            <th>Mã</th>
            <th>Đơn vị quản lý nội dung</th>
            <th>Tỉnh</th>
            <th>Quận/Huyện</th>
            <th>Số điện thoại</th>
            <th>Tổng tiền</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($content_owners as $content_owner)
            <tr>
                <td>{{ $content_owner['id'] }}</td>
                <td>{{ $ktv_report['name'] }}</td>
                <td>{{ $ktv_report['province'] }}</td>
                <td>{{ $ktv_report['province'] }}</td>
                <td>{{ $ktv_report['phone'] }}</td>
                <td>{{ number_format($ktv_report->total_money, 0, '.', '.') }} VNĐ</td>
            </tr>
        @endforeach
    </tbody>
</table>


</html>
