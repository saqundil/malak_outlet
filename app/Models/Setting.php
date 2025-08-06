<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
        'order',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get setting value by key
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->where('is_active', true)->first();
        
        if (!$setting) {
            return $default;
        }

        // Handle different value types
        switch ($setting->type) {
            case 'json':
                return json_decode($setting->value, true);
            case 'boolean':
                return (bool) $setting->value;
            case 'integer':
                return (int) $setting->value;
            case 'float':
                return (float) $setting->value;
            default:
                return $setting->value;
        }
    }

    /**
     * Set setting value by key
     */
    public static function set($key, $value, $type = 'text', $group = 'general')
    {
        // Convert value based on type
        switch ($type) {
            case 'json':
                $value = json_encode($value);
                break;
            case 'boolean':
                $value = $value ? '1' : '0';
                break;
        }

        return static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'is_active' => true
            ]
        );
    }

    /**
     * Get all settings for a group
     */
    public static function getGroup($group)
    {
        return static::where('group', $group)
            ->where('is_active', true)
            ->orderBy('order')
            ->get()
            ->pluck('value', 'key')
            ->toArray();
    }
}
