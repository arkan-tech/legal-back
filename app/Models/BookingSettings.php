<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookingSettings extends Model
{
    use HasFactory;

    protected $table = 'booking-settings';

    protected $fillable = [
        'key',
        'value',
    ];

    public static function getSetting($key)
    {
        return self::where('key', $key)->value('value');
    }

    public static function setSetting($key, $value)
    {
        $setting = self::where('key', $key)->first();
        if ($setting) {
            $setting->value = $value;
            $setting->save();
        } else {
            self::create([
                'key' => $key,
                'value' => $value,
            ]);
        }
    }
}
