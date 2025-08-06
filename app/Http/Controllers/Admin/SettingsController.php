<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Services\SettingsService;

class SettingsController extends Controller
{
    /**
     * Display the settings management page
     */
    public function index()
    {
        $settings = Setting::orderBy('group')->orderBy('order')->get()->groupBy('group');
        
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Update settings
     */
    public function update(Request $request)
    {
        try {
            foreach ($request->settings as $key => $value) {
                $setting = Setting::where('key', $key)->first();
                
                if ($setting) {
                    // Handle different types
                    if ($setting->type === 'json' && is_array($value)) {
                        $value = json_encode($value);
                    }
                    
                    $setting->update(['value' => $value]);
                }
            }
            
            // Clear cache
            SettingsService::clearCache();
            
            return redirect()->back()->with('success', 'تم تحديث الإعدادات بنجاح');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث الإعدادات: ' . $e->getMessage());
        }
    }

    /**
     * Contact settings specifically
     */
    public function contact()
    {
        $contactSettings = Setting::where('group', 'contact')->orderBy('order')->get();
        $businessSettings = Setting::where('group', 'business')->orderBy('order')->get();
        
        return view('admin.settings.contact', compact('contactSettings', 'businessSettings'));
    }

    /**
     * Update contact settings
     */
    public function updateContact(Request $request)
    {
        $request->validate([
            'contact_address' => 'required|string',
            'contact_phone' => 'required|string',
            'contact_phone_hours' => 'required|string',
            'contact_email_info' => 'required|email',
            'contact_email_support' => 'required|email',
            'contact_email_response_time' => 'required|string',
            'contact_whatsapp' => 'required|string',
            'contact_whatsapp_description' => 'required|string',
            'whatsapp_24_7' => 'required|string',
        ]);

        try {
            foreach ($request->except(['_token', '_method']) as $key => $value) {
                SettingsService::set($key, $value, 'text', strpos($key, 'whatsapp_24_7') !== false ? 'business' : 'contact');
            }

            return redirect()->back()->with('success', 'تم تحديث معلومات التواصل بنجاح');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'حدث خطأ أثناء تحديث المعلومات: ' . $e->getMessage());
        }
    }
}
