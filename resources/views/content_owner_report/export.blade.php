<html>
<table>
    <thead>
        <tr>
            <th>Mã</th>
            <th>Đơn vị quản lý nội dung</th>
            <th>Số điện thoại</th>
            <th>Tỉnh/Thành</th>
            <th>Quận/Huyện</th>
            <th>Tổng tiền</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($content_owners as $content_owner)
            <tr>
                <td>{{ $content_owner->id }}</td>
                <td>{{ $content_owner->name }}</td>
                <td>{{ $content_owner->phone }}</td>
                <td>{{ $content_owner->province }}</td>
                <td>{{ $content_owner->province }}</td>
                <td>{{ number_format($content_owner->total_money, 0, '.', '.') }} VNĐ</td>
            </tr>
        @endforeach
    </tbody>
</table>


</html>
