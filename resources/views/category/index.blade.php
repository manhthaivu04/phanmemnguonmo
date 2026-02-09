@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Quản lý Danh mục</h2>
    <a href="{{ route('category.create') }}" class="btn btn-primary mb-3">Thêm mới</a>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tên</th>
                <th>Danh mục cha</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $cat)
            <tr>
                <td>{{ $cat->id }}</td>
                <td>{{ $cat->name }}</td>
                <td>
                    @if($cat->parent)
                    {{ $cat->parent->name }}
                    @else
                    <span class="text-muted">-- Gốc --</span>
                    @endif
                </td>
                <td>
                    @if($cat->is_active)
                    <span class="badge bg-success">Hiển thị</span>
                    @else
                    <span class="badge bg-secondary">Ẩn</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('category.edit', $cat->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    <a href="{{ route('category.delete', $cat->id) }}" onclick="return confirm('Bạn có chắc muốn xóa?')"
                        class="btn btn-danger btn-sm">Xóa</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $categories->links() }}
</div>
@endsection