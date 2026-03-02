@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Quản lý Sản phẩm</h2>

    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('product.create') }}" class="btn btn-primary">Thêm mới</a>

        <form action="{{ route('product.index') }}" method="GET" class="d-flex">
            <input type="text" name="keyword" class="form-control me-2" placeholder="Tìm tên sản phẩm..."
                value="{{ request('keyword') }}">
            <button class="btn btn-outline-success" type="submit">Tìm</button>
        </form>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Ảnh</th>
                <th>Tên sản phẩm</th>
                <th>Danh mục</th>
                <th>Giá gốc</th>
                <th>Giá KM</th>
                <th>Kho</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $pro)
            <tr>
                <td>{{ $pro->id }}</td>
                <td>
                    @if($pro->image)
                    <img src="{{ asset($pro->image) }}" width="50" height="50" style="object-fit: cover;">
                    @else
                    <span class="text-muted">No IMG</span>
                    @endif
                </td>
                <td>{{ $pro->name }}</td>
                <td>{{ $pro->category ? $pro->category->name : '---' }}</td>
                <td>{{ number_format($pro->price) }} đ</td>
                <td>
                    @if($pro->sale_price)
                    <span class="text-danger">{{ number_format($pro->sale_price) }} đ</span>
                    @else
                    -
                    @endif
                </td>
                <td>{{ $pro->stock }}</td>
                <td>
                    @if($pro->is_active)
                    <span class="badge bg-success">Hiện</span>
                    @else
                    <span class="badge bg-secondary">Ẩn</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('product.edit', $pro->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="{{ route('product.delete', $pro->id) }}" onclick="return confirm('Bạn có chắc muốn xóa?')"
                        class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
</div>
@endsection