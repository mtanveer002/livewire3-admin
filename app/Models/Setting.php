<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

/**
 * @property-read \Illuminate\Database\Eloquent\Collection $media
 */
class Setting extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'key',
        'value',
    ];

    public static function getKeyValues(): Collection
    {
        try {
            $dbSettings = static::with('media')
                ->get()
                ->pluck('value', 'key');

            return get_general_site_settings()
                ->map(fn ($setting, $key) => $dbSettings->get($key, $setting['value']));
        } catch (\Throwable $th) {
            return \collect();
        }
    }

    protected function value(): Attribute
    {
        return Attribute::make(
            /** @phpstan-ignore-next-line */
            get: fn ($value) => get_general_site_settings($this->key) == 'file' ? ($this->media->first()?->getFullUrl() ?? '') : $value,
        );
    }
}
