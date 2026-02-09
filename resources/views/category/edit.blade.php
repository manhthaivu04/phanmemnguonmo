@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Cập nhật Danh mục: {{ $category->name }}</h3>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Tên danh mục</label>
            <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
        </div>

        <div class="mb-3">
            <label>Danh mục cha</label>
            <select name="parent_id" class="form-control">
                <option value="">-- Là danh mục gốc --</option>
                @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                    {{ $cat->name }}
                </option>
                @endforeach
            </select>
            <small class="text-muted">Không thể chọn chính nó hoặc các danh mục con của nó.</small>
        </div>

        <div class="mb-3">
            <label>Mô tả</label>
            <textarea name="description" class="form-control">{{ $category->description }}</textarea>
        </div>

        <div class="mb-3">
            <label>Hình ảnh hiện tại</label><br>
            @if($category->image)
            <img src="{{ asset($category->image) }}" width="100">
            @endif
            <input type="file" name="image" class="form-control mt-2">
        </div>

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="is_active" value="1"
                {{ $category->is_active ? 'checked' : '' }}>
            <label class="form-check-label">Kích hoạt</label>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('category.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection