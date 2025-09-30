<?php

namespace App\Models;

use App\Models\Cart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    // Harga setelah diskon otomatis
    public function getFinalPriceAttribute()
    {
        if (!$this->discount || !$this->discount->is_active) {
            return $this->price;
        }

        $now = now();
        if ($now->lt($this->discount->start_date) || $now->gt($this->discount->end_date)) {
            return $this->price;
        }

        if ($this->discount->discount_type === 'percentage') {
            $discountAmount = $this->price * ($this->discount->value / 100);
        } else {
            $discountAmount = $this->discount->value;
        }

        return max($this->price - $discountAmount, 0); // harga minimal 0
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function productImages()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function productDiscount()
    {
        return $this->hasMany(ProductDiscount::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
