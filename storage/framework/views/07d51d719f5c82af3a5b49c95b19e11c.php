<!DOCTYPE html>
<html dir="rtl" lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كود التحقق من البريد الإلكتروني</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8fafc;
            margin: 0;
            padding: 20px;
            direction: rtl;
            text-align: right;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }
        .header {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header p {
            margin: 10px 0 0 0;
            opacity: 0.9;
            font-size: 16px;
        }
        .content {
            padding: 40px 30px;
            text-align: center;
        }
        .greeting {
            font-size: 18px;
            color: #374151;
            margin-bottom: 20px;
        }
        .otp-container {
            background: linear-gradient(135deg, #fef3c7 0%, #fed7aa 100%);
            border: 2px dashed #f97316;
            border-radius: 12px;
            padding: 30px;
            margin: 30px 0;
            text-align: center;
        }
        .otp-label {
            font-size: 16px;
            color: #92400e;
            margin-bottom: 10px;
            font-weight: 600;
        }
        .otp-code {
            font-size: 36px;
            font-weight: bold;
            color: #ea580c;
            font-family: 'Courier New', monospace;
            letter-spacing: 8px;
            margin: 0;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.1);
        }
        .instructions {
            background-color: #f3f4f6;
            border-left: 4px solid #f97316;
            padding: 20px;
            margin: 30px 0;
            border-radius: 8px;
        }
        .instructions h3 {
            color: #374151;
            margin: 0 0 15px 0;
            font-size: 18px;
        }
        .instructions ul {
            color: #6b7280;
            margin: 0;
            padding-left: 20px;
        }
        .instructions li {
            margin-bottom: 8px;
            line-height: 1.5;
        }
        .warning {
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
            text-align: center;
        }
        .footer {
            background-color: #f9fafb;
            padding: 30px;
            text-align: center;
            border-top: 1px solid #e5e7eb;
        }
        .footer p {
            color: #6b7280;
            margin: 5px 0;
            font-size: 14px;
        }
        .logo {
            margin-bottom: 15px;
            display: inline-block;
        }
        .logo img {
            max-width: 120px;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(255,255,255,0.3);
            background-color: rgba(255,255,255,0.1);
            padding: 8px;
            transition: transform 0.3s ease;
        }
        .logo img:hover {
            transform: scale(1.05);
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
                border-radius: 8px;
            }
            .header, .content, .footer {
                padding: 20px;
            }
            .otp-code {
                font-size: 28px;
                letter-spacing: 4px;
            }
            .logo img {
                max-width: 100px;
                padding: 6px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <img src="https://malakoutlet-production.up.railway.app/images/malak.png" 
                     alt="شعار ملاك أوت ليت - Malak Outlet Logo">
            </div>
            <h1>Malak Outlet</h1>
            <p>مرحباً بك في متجرنا الإلكتروني</p>
        </div>
        
        <div class="content">
            <div class="greeting">
                <?php if($userName): ?>
                    <strong>مرحباً <?php echo e($userName); ?>!</strong>
                <?php else: ?>
                    <strong>مرحباً بك!</strong>
                <?php endif; ?>
            </div>
            
            <p style="color: #6b7280; font-size: 16px; line-height: 1.6;">
                شكراً لك لإنشاء حساب جديد في Malak Outlet. لإتمام عملية التسجيل، يرجى استخدام كود التحقق التالي:
            </p>
            
            <div class="otp-container">
                <div class="otp-label">كود التحقق الخاص بك:</div>
                <div class="otp-code"><?php echo e($otp); ?></div>
            </div>
            
            <div class="instructions">
                <h3>كيفية استخدام الكود:</h3>
                <ul>
                    <li>ادخل الكود في صفحة التحقق</li>
                    <li>الكود صالح لمدة <strong>10 دقائق فقط</strong></li>
                    <li>لا تشارك هذا الكود مع أي شخص آخر</li>
                    <li>إذا لم تطلب هذا الكود، يرجى تجاهل هذا البريد</li>
                </ul>
            </div>
            
            <div class="warning">
                ⚠️ هذا الكود سينتهي خلال 10 دقائق من وقت الإرسال
            </div>
        </div>
        
        <div class="footer">
            <p><strong>Malak Outlet</strong></p>
            <p>متجرك الموثوق للتسوق الإلكتروني</p>
            <p>إذا كانت لديك أي أسئلة، لا تتردد في التواصل معنا</p>
            <p style="margin-top: 15px; font-size: 12px; color: #9ca3af;">
                تم إرسال هذا البريد تلقائياً، يرجى عدم الرد عليه
            </p>
        </div>
    </div>
</body>
</html>
<?php /**PATH C:\wamp64\www\Malak_E_commers\malak_outlet\resources\views/emails/verify-otp.blade.php ENDPATH**/ ?>