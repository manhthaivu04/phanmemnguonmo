<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        // Chỉ lấy danh mục chưa bị xóa (is_delete = 0)
        $categories = Category::active()->with('parent')->paginate(10);
        return view('category.index', compact('categories'));
    }

    public function create()
    {
        // Lấy danh sách để chọn làm cha (chỉ lấy active)
        $categories = Category::active()->get();
        return view('category.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->all();
        
        // Xử lý upload ảnh nếu có (Code giả định, bạn có thể tùy chỉnh theo helper của project)
        if ($request->hasFile('image')) {
            $imageName = time().'.'.$request->image->extension();  
            $request->image->move(public_path('images/categories'), $imageName);
            $data['image'] = 'images/categories/' . $imageName;
        }

        Category::create($data);

        return redirect()->route('category.index')->with('success', 'Thêm danh mục thành công');
    }

    public function edit($id)
    {
        $category = Category::active()->findOrFail($id);
        // Lấy danh sách cha, loại trừ chính nó để tránh chọn chính nó ngay tại UI
        $categories = Category::active()->where('id', '!=', $id)->get();
        
        return view('category.edit', compact('category', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $category = Category::active()->findOrFail($id);

        $request->validate([
            'name' => 'required|max:255',
            'parent_id' => 'nullable|exists:categories,id',
        ]);

        $parentId = $request->input('parent_id');

        // --- LOGIC CHỐNG VÒNG LẶP ---
        if ($parentId) {
            // 1. Không được chọn chính nó
            if ($parentId == $id) {
                return back()->withErrors(['parent_id' => 'Không thể chọn chính danh mục này làm danh mục cha.']);
            }

            // 2. Không được chọn con cháu của nó làm cha
            // Hàm kiểm tra xem parentId có phải là con cháu của id hiện tại không
            if ($this->isDescendant($parentId, $id)) {
                return back()->withErrors(['parent_id' => 'Không thể chọn danh mục con/cháu làm danh mục cha (Gây vòng lặp).']);
            }
        }

        $data = $request->all();

        // Giữ lại ảnh cũ nếu không up ảnh mới
        if ($request->hasFile('image')) {
             // Code xử lý upload ảnh...
             $imageName = time().'.'.$request->image->extension();  
             $request->image->move(public_path('images/categories'), $imageName);
             $data['image'] = 'images/categories/' . $imageName;
        } else {
            $data['image'] = $category->image;
        }

        // Checkbox is_active nếu không tích sẽ không gửi lên, cần set default
        $data['is_active'] = $request->has('is_active') ? 1 : 0;

        $category->update($data);

        return redirect()->route('category.index')->with('success', 'Cập nhật thành công');
    }

    public function destroy($id)
    {
        $category = Category::active()->findOrFail($id);
        
        // Xóa mềm: Set is_delete = 1
        $category->update(['is_delete' => 1]);

        // Logic bổ sung: Cập nhật các con của nó về parent_id = null hoặc xóa theo (tùy nghiệp vụ)
        // Ở đây ta set các con về null để tránh lỗi dữ liệu
        Category::where('parent_id', $id)->update(['parent_id' => null]);

        return redirect()->route('category.index')->with('success', 'Đã xóa danh mục');
    }

    /**
     * Hàm đệ quy kiểm tra xem $checkId có phải là con cháu của $rootId không
     */
    private function isDescendant($checkId, $rootId)
    {
        $category = Category::find($checkId);
        
        if (!$category || !$category->parent_id) {
            return false;
        }

        if ($category->parent_id == $rootId) {
            return true;
        }

        return $this->isDescendant($category->parent_id, $rootId);
    }
}