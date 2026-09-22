<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'category_id',
        'name',
        'slug',
        'description',
        'price',
        'price_type',
        'location',
        'city',
        'status',
        'is_verified',
        'is_featured',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'is_verified' => 'boolean',
            'is_featured' => 'boolean',
        ];
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function privateRequests()
    {
        return $this->hasMany(PrivateRequest::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
}