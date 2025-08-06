<?php

namespace App\Services;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class ImageUploadService
{
    /**
     * Upload product images
     */
    public function uploadProductImages(Product $product, array $images): void
    {
        foreach ($images as $index => $image) {
            $this->uploadSingleImage($product, $image, $index === 0);
        }
    }

    /**
     * Upload a single product image
     */
    public function uploadSingleImage(Product $product, UploadedFile $image, bool $isPrimary = false): ProductImage
    {
        $path = $this->storeImage($image);
        
        return ProductImage::create([
            'product_id' => $product->id,
            'image_path' => $path,
            'is_primary' => $isPrimary
        ]);
    }

    /**
     * Store image file and return path
     */
    private function storeImage(UploadedFile $image): string
    {
        $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $path = $image->storeAs('products', $filename, 'public');
        
        return '/storage/' . $path;
    }

    /**
     * Delete image from storage
     */
    public function deleteImage(ProductImage $image): bool
    {
        // Remove the image from storage
        $imagePath = str_replace('/storage/', '', $image->image_path);
        Storage::disk('public')->delete($imagePath);
        
        // Delete the database record
        return $image->delete();
    }

    /**
     * Delete all product images
     */
    public function deleteProductImages(Product $product): void
    {
        foreach ($product->images as $image) {
            $this->deleteImage($image);
        }
    }

    /**
     * Optimize image (future enhancement)
     */
    private function optimizeImage(string $path): void
    {
        // Future: Add image optimization logic
        // Can use libraries like Intervention Image for resizing, compression, etc.
    }

    /**
     * Generate thumbnail (future enhancement)
     */
    private function generateThumbnail(string $path): string
    {
        // Future: Add thumbnail generation logic
        return $path;
    }
}
