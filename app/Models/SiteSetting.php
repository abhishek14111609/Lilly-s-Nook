<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'key',
        'value',
    ];

    public $timestamps = false;

    public static function getValue(string $key, ?string $default = null): ?string
    {
        $value = static::query()->where('key', $key)->value('value');

        return $value !== null ? (string) $value : $default;
    }

    public static function setValue(string $key, ?string $value): void
    {
        static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
    }

    public static function getJson(string $key, array $default = []): array
    {
        $value = static::getValue($key);

        if ($value === null || trim($value) === '') {
            return $default;
        }

        $decoded = json_decode($value, true);

        return is_array($decoded) ? $decoded : $default;
    }

    public static function setJson(string $key, array $value): void
    {
        static::setValue($key, json_encode($value, JSON_UNESCAPED_SLASHES));
    }
}
