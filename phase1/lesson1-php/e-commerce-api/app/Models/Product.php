<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'stock_quantity',
        'active',
        'sku',
        'attributes',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'active' => 'boolean',
        'attributes' => 'array',
    ];

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function (Product $product) {
            $product->slug = $product->slug ?? Str::slug($product->name);

            // إنشاء SKU تلقائي إذا لم يتم تحديده
            if (empty($product->sku)) {
                $product->sku = strtoupper(substr($product->name, 0, 3) . rand(10000, 99999));
            }
        });
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the order items for the product.
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
