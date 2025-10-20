<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'is_primary',
        'is_deleted',
        'edit_by',
    ];

    /**
     * Get the full URL for the image with proper encoding
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image_path) {
            return null;
        }
        
        $imagePath = 'storage/' . $this->image_path;
        $imageUrl = asset($imagePath);
        
        // Encode spaces and special characters for URL compatibility
        return str_replace(' ', '%20', $imageUrl);
    }

    /**
     * العلاقة مع المنتج
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * المستخدم الذي عدّل
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'edit_by');
    }
}
