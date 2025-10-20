<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JordanCity extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en', 
        'delivery_cost',
        'is_active',
        'delivery_days',
        'notes'
    ];

    protected $casts = [
        'delivery_cost' => 'decimal:2',
        'is_active' => 'boolean',
        'delivery_days' => 'integer'
    ];

    /**
     * Scope for active cities only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Get formatted delivery cost
     */
    public function getFormattedDeliveryCostAttribute()
    {
        return number_format($this->delivery_cost, 2) . ' د.أ';
    }

    /**
     * Get delivery info text
     */
    public function getDeliveryInfoAttribute()
    {
        $days = $this->delivery_days == 1 ? 'يوم واحد' : $this->delivery_days . ' أيام';
        return "التوصيل خلال {$days} - {$this->formatted_delivery_cost}";
    }

    /**
     * Relationship with orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class, 'jordan_city_id');
    }

    /**
     * Get the display name (Arabic by default)
     */
    public function getDisplayNameAttribute()
    {
        return $this->name_ar ?: $this->name_en;
    }
}
