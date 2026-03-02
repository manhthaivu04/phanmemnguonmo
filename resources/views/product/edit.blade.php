@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Cập nhật Sản phẩm: {{ $product->name }}</h3>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- Laravel update thường dùng POST nhưng route là post/update/{id} nên không cần @method('PUT') --}}

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Tên sản phẩm <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
            </div>

            <div class="col-md-6 mb-3">
                <label>Danh mục</label>
                <select name="category_id" class="form-control">
                    <option value="">-- Chọn danh mục --</option>
                    @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4 mb-3">
                <label>Giá gốc <span class="text-danger">*</span></label>
                <input type="number" name="price" class="form-control" value="{{ $product->price }}" min="0" required>
            </div>

            <div class="col-md-4 mb-3">
                <label>Giá khuyến mãi</label>
                <input type="number" name="sale_price" class="form-control" value="{{ $product->sale_price }}" min="0">
            </div>

            <div class="col-md-4 mb-3">
                <label>Tồn kho <span class="text-danger">*</span></label>
                <input type="number" name="stock" class="form-control" value="{{ $product->stock }}" min="0" required>
            </div>

            <div class="col-md-12 mb-3">
                <label>Mô tả</label>
                <textarea name="description" class="form-control" rows="3">{{ $product->description }}</textarea>
            </div>

            <div class="col-md-12 mb-3">
                <label>Hình ảnh hiện tại</label><br>
                @if($product->image)
                <img src="{{ asset($product->image) }}" width="100" class="mb-2">
                @endif
                <input type="file" name="image" class="form-control">
            </div>

            <div class="col-md-12 mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                        {{ $product->is_active ? 'checked' : '' }}>
                    <label class="form-check-label">Kích hoạt hiển thị</label>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="{{ route('product.index') }}" class="btn btn-secondary">Hủy</a>
    </form>
</div>
@endsection