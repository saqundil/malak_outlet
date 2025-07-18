<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'slug', 'description', 'is_active', 'parent_id', 'image'];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Scope for active categories
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // Scope for main categories (no parent)
    public function scopeMain($query)
    {
        return $query->whereNull('parent_id');
    }

    // Scope for subcategories (has parent)
    public function scopeSubcategories($query)
    {
        return $query->whereNotNull('parent_id');
    }

    // Relationship: Parent category
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relationship: Child categories
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    // Relationship: All descendants (recursive)
    public function descendants()
    {
        return $this->children()->with('descendants');
    }

    // Relationship: All ancestors (going up the tree)
    public function ancestors()
    {
        $ancestors = collect();
        $parent = $this->parent;
        
        while ($parent) {
            $ancestors->push($parent);
            $parent = $parent->parent;
        }
        
        return $ancestors;
    }

    // Check if this category is a root category (no parent)
    public function isRoot()
    {
        return is_null($this->parent_id);
    }

    // Check if this category has children
    public function hasChildren()
    {
        return $this->children()->count() > 0;
    }

    // Get the depth level of this category in the tree
    public function getDepthLevel()
    {
        return $this->ancestors()->count();
    }

    // Get breadcrumb path
    public function getBreadcrumb()
    {
        $breadcrumb = $this->ancestors()->reverse();
        $breadcrumb->push($this);
        return $breadcrumb;
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
