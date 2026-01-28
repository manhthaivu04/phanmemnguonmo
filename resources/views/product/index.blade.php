<!DOCTYPE html>
<html>
<head><title>Danh sách sản phẩm</title></head>
<body>
    <h1>Danh sách sản phẩm mẫu</h1>
    <ul>
        <li>Sản phẩm A - <a href="{{ route('product.detail', ['id' => 'SPA']) }}">Xem chi tiết</a></li>
        <li>Sản phẩm B - <a href="{{ route('product.detail', ['id' => 'SPB']) }}">Xem chi tiết</a></li>
    </ul>
    
    <a href="{{ route('product.add') }}">
        <button>Thêm mới sản phẩm</button>
    </a>
</body>
</html>