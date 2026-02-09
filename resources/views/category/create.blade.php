@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Thêm mới Danh mục</h3>
    <form action="{{ route('category.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Tên danh mục</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Danh mục cha</label>
            <select name="parent_id" class="form-control">
                <option value="">-- Là danh mục gốc --</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label>Hình ảnh</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1" checked>
            <label class="form-check-label">Kích hoạt</label>
        </div>

        <button type="submit" class="btn btn-success">Lưu lại</button>
        <a href="{{ route('category.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection