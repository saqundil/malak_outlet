<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user() && auth()->user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'sale_price' => ['nullable', 'numeric', 'min:0', 'lt:price'],
            'sku' => ['required', 'string', Rule::unique('products', 'sku')->ignore($productId)],
            'stock_quantity' => ['required', 'integer', 'min:0'],
            'category_id' => ['required', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'weight' => ['nullable', 'numeric', 'min:0'],
            'dimensions' => ['nullable', 'string', 'max:255'],
            'materials' => ['nullable', 'string', 'max:500'],
            'country_of_origin' => ['nullable', 'string', 'max:255'],
            'warranty_period' => ['nullable', 'string', 'max:255'],
            'suitable_age' => ['nullable', 'string', 'max:255'],
            'pieces_count' => ['nullable', 'integer', 'min:1'],
            'standards' => ['nullable', 'string', 'max:500'],
            'battery_type' => ['nullable', 'string', 'max:255'],
            'washable' => ['nullable', 'boolean'],
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ];
    }

    /**
     * Get custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'name' => 'اسم المنتج',
            'description' => 'وصف المنتج',
            'price' => 'السعر',
            'sale_price' => 'سعر البيع',
            'sku' => 'رقم المنتج',
            'stock_quantity' => 'كمية المخزون',
            'category_id' => 'الفئة',
            'brand_id' => 'العلامة التجارية',
            'weight' => 'الوزن',
            'dimensions' => 'الأبعاد',
            'materials' => 'المواد',
            'country_of_origin' => 'بلد المنشأ',
            'warranty_period' => 'فترة الضمان',
            'suitable_age' => 'العمر المناسب',
            'pieces_count' => 'عدد القطع',
            'standards' => 'المعايير',
            'battery_type' => 'نوع البطارية',
            'washable' => 'قابل للغسيل',
            'images' => 'الصور',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'اسم المنتج مطلوب',
            'name.max' => 'اسم المنتج يجب أن يكون أقل من 255 حرف',
            'price.required' => 'السعر مطلوب',
            'price.numeric' => 'السعر يجب أن يكون رقم',
            'price.min' => 'السعر يجب أن يكون أكبر من صفر',
            'sale_price.lt' => 'سعر البيع يجب أن يكون أقل من السعر الأساسي',
            'sku.required' => 'رقم المنتج مطلوب',
            'sku.unique' => 'رقم المنتج موجود مسبقاً',
            'stock_quantity.required' => 'كمية المخزون مطلوبة',
            'stock_quantity.integer' => 'كمية المخزون يجب أن تكون رقم صحيح',
            'stock_quantity.min' => 'كمية المخزون يجب أن تكون صفر أو أكثر',
            'category_id.required' => 'الفئة مطلوبة',
            'category_id.exists' => 'الفئة المحددة غير موجودة',
            'brand_id.exists' => 'العلامة التجارية المحددة غير موجودة',
            'images.*.image' => 'الملف يجب أن يكون صورة',
            'images.*.mimes' => 'الصورة يجب أن تكون من نوع: jpeg, png, jpg, gif, webp',
            'images.*.max' => 'حجم الصورة يجب أن يكون أقل من 2 ميجابايت',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'is_active' => $this->boolean('is_active', true),
            'is_featured' => $this->boolean('is_featured', false),
            'washable' => $this->boolean('washable', false),
        ]);
    }
}
