<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'customer_name',
        'customer_email',
        'status',
        'subtotal',
        'shipping_cost',
        'tax_amount',
        'total_amount',
        'payment_method',
        'payment_status',
        'shipping_address',
        'jordan_city_id',
        'city_name',
        'phone',
        'notes',
        'shipped_at',
        'delivered_at',
        'cancelled_at',
        'cancellation_reason',
        'is_deleted',
        'edit_by',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'cancelled_at' => 'datetime',
        'is_deleted' => 'boolean',
    ];

    /**
     * العلاقة مع المستخدم
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * المستخدم الذي عدّل الطلب
     */
    public function editor()
    {
        return $this->belongsTo(User::class, 'edit_by');
    }

    /**
     * العناصر المرتبطة بالطلب
     */
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the delivery city
     */
    public function jordanCity()
    {
        return $this->belongsTo(JordanCity::class);
    }

    /**
     * Generate a unique order number
     */
    public static function generateOrderNumber()
    {
        do {
            $orderNumber = 'ORD-' . date('Y') . '-' . str_pad(rand(1, 9999), 4, '0', STR_PAD_LEFT);
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Check if order can be cancelled
     */
    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'confirmed']) && !$this->is_deleted;
    }

    /**
     * Check if order can be edited
     */
    public function canBeEdited()
    {
        return $this->status === 'pending' && !$this->is_deleted;
    }

    /**
     * Get the order status in Arabic
     */
    public function getStatusArabicAttribute()
    {
        $statuses = [
            'pending' => 'في الانتظار',
            'confirmed' => 'مؤكد',
            'processing' => 'قيد التحضير',
            'shipped' => 'تم الشحن',
            'delivered' => 'تم التسليم',
            'cancelled' => 'ملغي',
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    /**
     * Get the payment status in Arabic
     */
    public function getPaymentStatusArabicAttribute()
    {
        $statuses = [
            'pending' => 'في الانتظار',
            'paid' => 'مدفوع',
            'failed' => 'فشل الدفع',
            'refunded' => 'مسترد',
        ];

        return $statuses[$this->payment_status] ?? $this->payment_status;
    }

    /**
     * Get the status badge CSS class
     */
    public function getStatusBadgeClassAttribute()
    {
        $classes = [
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'processing' => 'bg-purple-100 text-purple-800',
            'shipped' => 'bg-indigo-100 text-indigo-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
        ];

        return $classes[$this->status] ?? 'bg-gray-100 text-gray-800';
    }
}
