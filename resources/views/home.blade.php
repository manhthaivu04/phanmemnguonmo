@extends('layouts.app')

@section('content')
<div class="container text-center mt-5">

    <h1 class="mb-4">Chào mừng đến với trang chủ</h1>

    <div class="d-flex justify-content-center gap-3">
        <a href="{{ route('product.index') }}" class="btn btn-primary">
            Xem danh sách sản phẩm
        </a>

        <a href="{{ route('category.index') }}" class="btn btn-success">
            Quản lý Danh mục
        </a>
    </div>

</div>
@endsection