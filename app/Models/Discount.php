<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function getFormattedValueAttribute()
    {
        if ($this->discount_type === 'percentage') {
            return $this->value . '%';
        }

        if ($this->discount_type === 'fixed') {
            return 'Rp' . number_format($this->value, 0, ',', '.');
        }

        return $this->value;
    }

    protected static function booted()
    {
        static::retrieved(function ($discount) {
            if ($discount->end_date && now()->gt($discount->end_date) && $discount->is_active) {
                $discount->update(['is_active' => 0]);
            }
        });
    }

    public function productDiscounts()
    {
        return $this->hasOne(ProductDiscount::class);
    }
}
