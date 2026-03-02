<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'name',
        'price',
        'sale_price',
        'stock',
        'description',
        'image',
        'is_active',
        'is_delete',
    ];

    // Quan hệ với Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    // Scope chỉ lấy sản phẩm chưa bị xóa
    public function scopeActive($query)
    {
        return $query->where('is_delete', 0);
    }
}