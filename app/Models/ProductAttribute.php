<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'input_type',
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
     * القيم المرتبطة بهذا الخاصية
     */
    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }
}
