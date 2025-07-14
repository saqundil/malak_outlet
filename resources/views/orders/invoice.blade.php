<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>فاتورة رقم {{ $order->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 14px;
            line-height: 1.6;
            color: #333;
            direction: rtl;
        }
        
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            background: white;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        
        .logo {
            text-align: right;
        }
        
        .logo h1 {
            color: #2563eb;
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        
        .logo p {
            color: #6b7280;
            font-size: 12px;
        }
        
        .invoice-info {
            text-align: left;
        }
        
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
        }
        
        .invoice-number {
            color: #6b7280;
            font-size: 14px;
        }
        
        .details-section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        
        .customer-info, .order-info {
            width: 48%;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-item {
            margin-bottom: 8px;
            display: flex;
        }
        
        .info-label {
            font-weight: bold;
            color: #6b7280;
            min-width: 80px;
            margin-left: 10px;
        }
        
        .info-value {
            color: #1f2937;
        }
        
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        
        .items-table th,
        .items-table td {
            padding: 12px;
            text-align: right;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .items-table th {
            background-color: #f9fafb;
            font-weight: bold;
            color: #1f2937;
        }
        
        .items-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .total-section {
            margin-top: 20px;
            border-top: 2px solid #e5e7eb;
            padding-top: 20px;
        }
        
        .total-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        
        .total-row.final {
            font-size: 18px;
            font-weight: bold;
            color: #1f2937;
            border-top: 1px solid #d1d5db;
            padding-top: 10px;
            margin-top: 15px;
        }
        
        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-confirmed {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .status-shipped {
            background-color: #e0e7ff;
            color: #3730a3;
        }
        
        .status-delivered {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div class="logo">
                <h1>متجر ملاك</h1>
                <p>أفضل متجر للألعاب والمنتجات الترفيهية</p>
                <p>عمان، المملكة الأردنية الهاشمية</p>
                <p>هاتف: +962 79 000 0000</p>
            </div>
            <div class="invoice-info">
                <div class="invoice-title">فاتورة</div>
                <div class="invoice-number"># {{ $order->order_number }}</div>
            </div>
        </div>

        <!-- Details Section -->
        <div class="details-section">
            <div class="customer-info">
                <div class="section-title">معلومات العميل</div>
                <div class="info-item">
                    <span class="info-label">الاسم:</span>
                    <span class="info-value">{{ $order->user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">البريد:</span>
                    <span class="info-value">{{ $order->user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">الهاتف:</span>
                    <span class="info-value">{{ $order->phone }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">العنوان:</span>
                    <span class="info-value">{{ $order->shipping_address }}</span>
                </div>
            </div>
            
            <div class="order-info">
                <div class="section-title">معلومات الطلب</div>
                <div class="info-item">
                    <span class="info-label">التاريخ:</span>
                    <span class="info-value">{{ $order->created_at->format('Y/m/d') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">الوقت:</span>
                    <span class="info-value">{{ $order->created_at->format('H:i') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">الحالة:</span>
                    <span class="info-value">
                        <span class="status-badge status-{{ $order->status }}">
                            {{ $order->status_arabic }}
                        </span>
                    </span>
                </div>
                <div class="info-item">
                    <span class="info-label">الدفع:</span>
                    <span class="info-value">{{ $order->payment_method == 'cod' ? 'الدفع عند الاستلام' : 'دفع إلكتروني' }}</span>
                </div>
            </div>
        </div>

        <!-- Items Table -->
        <table class="items-table">
            <thead>
                <tr>
                    <th>المنتج</th>
                    <th>السعر</th>
                    <th>الكمية</th>
                    <th>المجموع</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->items as $item)
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ number_format($item->product_price, 2) }} ر.س</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->total_price, 2) }} ر.س</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <!-- Total Section -->
        <div class="total-section">
            <div class="total-row">
                <span>المجموع الفرعي:</span>
                <span>{{ number_format($order->subtotal, 2) }} ر.س</span>
            </div>
            <div class="total-row">
                <span>الشحن:</span>
                <span>{{ number_format($order->shipping_cost, 2) }} ر.س</span>
            </div>
            <div class="total-row">
                <span>ضريبة القيمة المضافة (15%):</span>
                <span>{{ number_format($order->tax_amount, 2) }} ر.س</span>
            </div>
            <div class="total-row final">
                <span>المجموع الإجمالي:</span>
                <span>{{ number_format($order->total_amount, 2) }} ر.س</span>
            </div>
        </div>

        @if($order->notes)
        <div style="margin-top: 30px;">
            <div class="section-title">ملاحظات</div>
            <p style="color: #6b7280; font-style: italic;">{{ $order->notes }}</p>
        </div>
        @endif

        <!-- Footer -->
        <div class="footer">
            <p>شكراً لتسوقكم معنا في متجر ملاك</p>
            <p>للاستفسارات: support@malak-outlet.com | +962 79 000 0000</p>
            <p>تم إنشاء هذه الفاتورة في {{ now()->format('Y/m/d H:i') }}</p>
        </div>
    </div>
</body>
</html>
