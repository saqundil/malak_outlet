<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // Contact Information
            [
                'key' => 'contact_address',
                'value' => "الأردن - عمان\nشفابدران - دوار التطبيقية\nمجمع التطبيقية التجاري",
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'العنوان',
                'description' => 'عنوان المتجر الرئيسي',
                'order' => 1
            ],
            [
                'key' => 'contact_phone',
                'value' => '+962 79 004 35 81',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'رقم الهاتف',
                'description' => 'رقم الهاتف الرئيسي للمتجر',
                'order' => 2
            ],
            [
                'key' => 'contact_phone_hours',
                'value' => "متاح من السبت إلى الخميس\n9 صباحاً - 9 مساءً",
                'type' => 'textarea',
                'group' => 'contact',
                'label' => 'ساعات عمل الهاتف',
                'description' => 'أوقات توفر خدمة الهاتف',
                'order' => 3
            ],
            [
                'key' => 'contact_email_info',
                'value' => 'info@malak-outlet.com',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'البريد الإلكتروني - معلومات',
                'description' => 'البريد الإلكتروني للاستفسارات العامة',
                'order' => 4
            ],
            [
                'key' => 'contact_email_support',
                'value' => 'support@malak-outlet.com',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'البريد الإلكتروني - دعم',
                'description' => 'البريد الإلكتروني للدعم التقني',
                'order' => 5
            ],
            [
                'key' => 'contact_email_response_time',
                'value' => 'نرد خلال 24 ساعة',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'وقت الرد على البريد الإلكتروني',
                'description' => 'الوقت المتوقع للرد على الرسائل',
                'order' => 6
            ],
            [
                'key' => 'contact_whatsapp',
                'value' => '+962 79 004 35 81',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'رقم الواتساب',
                'description' => 'رقم الواتساب للدعم السريع',
                'order' => 7
            ],
            [
                'key' => 'contact_whatsapp_description',
                'value' => 'للدعم السريع والاستفسارات',
                'type' => 'text',
                'group' => 'contact',
                'label' => 'وصف الواتساب',
                'description' => 'وصف خدمة الواتساب',
                'order' => 8
            ],

            // Business Hours
            [
                'key' => 'business_hours',
                'value' => json_encode([
                    'saturday_wednesday' => ['label' => 'السبت - الأربعاء', 'hours' => '9:00 صباحاً - 9:00 مساءً'],
                    'thursday' => ['label' => 'الخميس', 'hours' => '9:00 صباحاً - 6:00 مساءً'],
                    'friday' => ['label' => 'الجمعة', 'hours' => 'مغلق', 'closed' => true]
                ]),
                'type' => 'json',
                'group' => 'business',
                'label' => 'ساعات العمل',
                'description' => 'ساعات عمل المتجر',
                'order' => 1
            ],
            [
                'key' => 'whatsapp_24_7',
                'value' => 'خدمة العملاء متاحة عبر الواتساب 24/7',
                'type' => 'text',
                'group' => 'business',
                'label' => 'خدمة الواتساب 24/7',
                'description' => 'ملاحظة حول توفر الواتساب',
                'order' => 2
            ],

            // Site Information
            [
                'key' => 'site_name',
                'value' => 'متجر ملاك',
                'type' => 'text',
                'group' => 'general',
                'label' => 'اسم الموقع',
                'description' => 'اسم المتجر',
                'order' => 1
            ],
            [
                'key' => 'site_description',
                'value' => 'أفضل متجر للأحذية والأكسسوارات',
                'type' => 'text',
                'group' => 'general',
                'label' => 'وصف الموقع',
                'description' => 'وصف مختصر للمتجر',
                'order' => 2
            ]
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
