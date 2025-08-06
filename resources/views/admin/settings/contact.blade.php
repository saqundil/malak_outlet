@extends('layouts.main')

@section('title', 'إدارة معلومات التواصل - لوحة الإدارة')

@section('content')
<div class="min-h-screen bg-gray-100" dir="rtl">
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">إدارة معلومات التواصل</h1>
                <p class="text-gray-600">تحديث معلومات الاتصال وساعات العمل الخاصة بالمتجر</p>
            </div>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('admin.settings.contact.update') }}" method="POST">
                @csrf
                @method('PUT')

                <!-- Contact Information -->
                <div class="bg-white rounded-lg shadow-lg p-6 mb-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-6">معلومات التواصل</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Address -->
                        <div class="md:col-span-2">
                            <label for="contact_address" class="block text-sm font-medium text-gray-700 mb-2">العنوان</label>
                            <textarea name="contact_address" id="contact_address" rows="3" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="عنوان المتجر الكامل">{{ \App\Services\SettingsService::get('contact_address') }}</textarea>
                        </div>

                        <!-- Phone -->
                        <div>
                            <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                            <input type="text" name="contact_phone" id="contact_phone" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ \App\Services\SettingsService::get('contact_phone') }}"
                                   placeholder="+962 XX XXX XX XX">
                        </div>

                        <!-- Phone Hours -->
                        <div>
                            <label for="contact_phone_hours" class="block text-sm font-medium text-gray-700 mb-2">ساعات عمل الهاتف</label>
                            <textarea name="contact_phone_hours" id="contact_phone_hours" rows="2" 
                                      class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                      placeholder="أوقات توفر خدمة الهاتف">{{ \App\Services\SettingsService::get('contact_phone_hours') }}</textarea>
                        </div>

                        <!-- Email Info -->
                        <div>
                            <label for="contact_email_info" class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني - معلومات</label>
                            <input type="email" name="contact_email_info" id="contact_email_info" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ \App\Services\SettingsService::get('contact_email_info') }}"
                                   placeholder="info@example.com">
                        </div>

                        <!-- Email Support -->
                        <div>
                            <label for="contact_email_support" class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني - دعم</label>
                            <input type="email" name="contact_email_support" id="contact_email_support" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ \App\Services\SettingsService::get('contact_email_support') }}"
                                   placeholder="support@example.com">
                        </div>

                        <!-- Email Response Time -->
                        <div>
                            <label for="contact_email_response_time" class="block text-sm font-medium text-gray-700 mb-2">وقت الرد على البريد الإلكتروني</label>
                            <input type="text" name="contact_email_response_time" id="contact_email_response_time" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ \App\Services\SettingsService::get('contact_email_response_time') }}"
                                   placeholder="نرد خلال 24 ساعة">
                        </div>

                        <!-- WhatsApp -->
                        <div>
                            <label for="contact_whatsapp" class="block text-sm font-medium text-gray-700 mb-2">رقم الواتساب</label>
                            <input type="text" name="contact_whatsapp" id="contact_whatsapp" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ \App\Services\SettingsService::get('contact_whatsapp') }}"
                                   placeholder="+962 XX XXX XX XX">
                        </div>

                        <!-- WhatsApp Description -->
                        <div>
                            <label for="contact_whatsapp_description" class="block text-sm font-medium text-gray-700 mb-2">وصف خدمة الواتساب</label>
                            <input type="text" name="contact_whatsapp_description" id="contact_whatsapp_description" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ \App\Services\SettingsService::get('contact_whatsapp_description') }}"
                                   placeholder="للدعم السريع والاستفسارات">
                        </div>

                        <!-- WhatsApp 24/7 Note -->
                        <div class="md:col-span-2">
                            <label for="whatsapp_24_7" class="block text-sm font-medium text-gray-700 mb-2">ملاحظة الواتساب 24/7</label>
                            <input type="text" name="whatsapp_24_7" id="whatsapp_24_7" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ \App\Services\SettingsService::get('whatsapp_24_7') }}"
                                   placeholder="خدمة العملاء متاحة عبر الواتساب 24/7">
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="bg-white rounded-lg shadow-lg p-6">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">حفظ التغييرات</h3>
                            <p class="text-sm text-gray-600">سيتم تحديث معلومات التواصل في جميع أنحاء الموقع</p>
                        </div>
                        <div class="space-x-3 space-x-reverse">
                            <a href="{{ route('contact') }}" 
                               class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                                معاينة الصفحة
                            </a>
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                حفظ التغييرات
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
