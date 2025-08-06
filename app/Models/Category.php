<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'is_active',
        'parent_id',
        'image',
        'is_deleted',
        'edit_by',
    ];

    /**
     * الفئة الرئيسية (الأب)
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * الفئات الفرعية (الأبناء)
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * المستخدم الذي عدّل
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'edit_by');
    }

    /**
     * المنتجات في هذه الفئة
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    /**
     * المنتجات النشطة في هذه الفئة
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

    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeChildren($query)
    {
        return $query->whereNotNull('parent_id');
    }

    // Helper methods
    public function isParent()
    {
        return $this->children()->count() > 0;
    }

    public function hasChildren()
    {
        return $this->isParent();
    }

    public function isChild()
    {
        return !is_null($this->parent_id);
    }

    public function getDescendants()
    {
        $descendants = collect();
        foreach ($this->children as $child) {
            $descendants->push($child);
            $descendants = $descendants->merge($child->getDescendants());
        }
        return $descendants;
    }

    public function getBreadcrumb()
    {
        $breadcrumb = collect();
        $current = $this;
        
        while ($current) {
            $breadcrumb->prepend($current);
            $current = $current->parent;
        }
        
        return $breadcrumb;
    }

    public function discounts()
    {
        return $this->belongsToMany(Discount::class, 'discount_category');
    }
    
}
