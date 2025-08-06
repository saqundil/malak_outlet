<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'image',
        'is_active',
        'is_deleted',
        'edit_by',
    ];

    /**
     * المستخدم الذي عدّل
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'edit_by');
    }

    /**
     * المنتجات التابعة لهذه العلامة التجارية
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * المنتجات النشطة التابعة لهذه العلامة التجارية
     */
    public function activeProducts()
    {
        return $this->hasMany(Product::class)->active();
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('is_deleted', false);
    }
}
