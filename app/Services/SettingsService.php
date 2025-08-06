<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    /**
     * Cache duration in minutes
     */
    private const CACHE_DURATION = 60;

    /**
     * Get a setting value by key
     */
    public static function get($key, $default = null)
    {
        return Cache::remember("setting_{$key}", self::CACHE_DURATION, function () use ($key, $default) {
            return Setting::get($key, $default);
        });
    }

    /**
     * Get all settings for a group
     */
    public static function getGroup($group)
    {
        return Cache::remember("settings_group_{$group}", self::CACHE_DURATION, function () use ($group) {
            return Setting::getGroup($group);
        });
    }

    /**
     * Get contact information
     */
    public static function getContactInfo()
    {
        return Cache::remember('contact_info', self::CACHE_DURATION, function () {
            return [
                'address' => Setting::get('contact_address'),
                'phone' => Setting::get('contact_phone'),
                'phone_hours' => Setting::get('contact_phone_hours'),
                'email_info' => Setting::get('contact_email_info'),
                'email_support' => Setting::get('contact_email_support'),
                'email_response_time' => Setting::get('contact_email_response_time'),
                'whatsapp' => Setting::get('contact_whatsapp'),
                'whatsapp_description' => Setting::get('contact_whatsapp_description'),
                'whatsapp_url' => 'https://wa.me/' . str_replace(['+', ' '], '', Setting::get('contact_whatsapp', '')),
            ];
        });
    }

    /**
     * Get business hours
     */
    public static function getBusinessHours()
    {
        return Cache::remember('business_hours', self::CACHE_DURATION, function () {
            return [
                'hours' => Setting::get('business_hours', []),
                'whatsapp_24_7' => Setting::get('whatsapp_24_7'),
            ];
        });
    }

    /**
     * Set a setting value
     */
    public static function set($key, $value, $type = 'text', $group = 'general')
    {
        $result = Setting::set($key, $value, $type, $group);
        
        // Clear cache
        Cache::forget("setting_{$key}");
        Cache::forget("settings_group_{$group}");
        Cache::forget('contact_info');
        Cache::forget('business_hours');
        
        return $result;
    }

    /**
     * Clear all settings cache
     */
    public static function clearCache()
    {
        $settings = Setting::all();
        foreach ($settings as $setting) {
            Cache::forget("setting_{$setting->key}");
        }
        
        Cache::forget('contact_info');
        Cache::forget('business_hours');
        
        // Clear group caches
        $groups = Setting::distinct('group')->pluck('group');
        foreach ($groups as $group) {
            Cache::forget("settings_group_{$group}");
        }
    }
}
