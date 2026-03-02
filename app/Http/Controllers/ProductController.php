<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Hiển thị danh sách
    public function index(Request $request)
    {
        $query = Product::active()->with('category');

        // Tìm kiếm (nếu có)
        if ($request->has('keyword') && $request->keyword != '') {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        $products = $query->orderBy('id', 'desc')->paginate(10);
        return view('product.index', compact('products'));
    }

    // Form thêm mới
    public function create()
    {
        // Lấy danh mục để hiển thị Select box (chỉ lấy danh mục chưa xóa)
        $categories = Category::where('is_delete', 0)->get();
        return view('product.create', compact('categories'));
    }

    // Lưu sản phẩm
    public function store(Request $request)
    {
        // Validate dữ liệu
        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            // sale_price phải nhỏ hơn hoặc bằng price (lte: less than or equal)
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'sale_price.lte' => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc.',
        ]);

        $data = $request->all();

        // Xử lý upload ảnh
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        }

        Product::create($data);

        return redirect()->route('product.index')->with('success', 'Thêm sản phẩm thành công');
    }

    // Form chỉnh sửa
    public function edit($id)
    {
        $product = Product::active()->findOrFail($id);
        $categories = Category::where('is_delete', 0)->get();
        return view('product.edit', compact('product', 'categories'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, $id)
    {
        $product = Product::active()->findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ], [
            'sale_price.lte' => 'Giá khuyến mãi phải nhỏ hơn hoặc bằng giá gốc.',
        ]);

        $data = $request->all();

        // Xử lý ảnh
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/products'), $imageName);
            $data['image'] = 'images/products/' . $imageName;
        } else {
            $data['image'] = $product->image; // Giữ ảnh cũ
        }

        // Checkbox is_active
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $product->update($data);

        return redirect()->route('product.index')->with('success', 'Cập nhật sản phẩm thành công');
    }

    // Xóa mềm
    public function destroy($id)
    {
        $product = Product::active()->findOrFail($id);
        $product->update(['is_delete' => 1]);

        return redirect()->route('product.index')->with('success', 'Đã xóa sản phẩm');
    }
}