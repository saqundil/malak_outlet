<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Application Country Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may specify the country-specific settings for your application.
    | This includes currency, locale, phone format, and address formats.
    |
    */

    'country' => [
        'name' => 'المملكة الأردنية الهاشمية',
        'name_en' => 'Hashemite Kingdom of Jordan',
        'code' => 'JO',
        'capital' => 'عمان',
        'capital_en' => 'Amman',
    ],

    'currency' => [
        'name' => 'الدينار الأردني',
        'name_en' => 'Jordanian Dinar',
        'code' => 'JOD',
        'symbol' => 'د.أ',
        'decimal_places' => 3, // JOD typically uses 3 decimal places
        'format' => ':amount :symbol',
    ],

    'phone' => [
        'country_code' => '+962',
        'format' => '+962 X XXXX XXXX',
        'mobile_codes' => ['77', '78', '79'],
        'landline_codes' => ['2', '3', '4', '5', '6', '7'],
    ],

    'shipping' => [
        'free_shipping_threshold' => 50, // JOD
        'domestic_fee' => 3, // JOD
        'remote_areas_fee' => 5, // JOD
        'delivery_time' => [
            'major_cities' => '1-2 أيام عمل',
            'other_areas' => '2-4 أيام عمل',
        ],
    ],

    'tax' => [
        'vat_rate' => 0.16, // 16% VAT in Jordan
        'vat_number' => '', // Company VAT number
    ],

    'address' => [
        'format' => ':street, :city, :country',
        'postal_code_required' => true,
    ],

    'business' => [
        'company_name' => 'مالك أوت لت',
        'company_name_en' => 'Malak Outlet',
        'address' => 'عمان، المملكة الأردنية الهاشمية',
        'phone' => '+962-6-234-5678',
        'mobile' => '+962-79-000-0000',
        'whatsapp' => '+962-79-004-3581',
        'email' => 'support@malakoutlet.com',
        'website' => 'https://malakoutlet.com',
    ],
];
