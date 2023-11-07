<?php

namespace App\Providers;

use Exception;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Livewire\Testing\TestableLivewire;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        $this->setCustomConfig();
    }

    public function setCustomConfig(): void
    {
        $config = Setting::getKeyValues();
        $logo_full = $config['logo_full'] ?? '';

        try {
            if (Str::endsWith($logo_full, '.svg')) {
                /** @var null|\Spatie\MediaLibrary\MediaCollections\Models\Media */
                $media = Setting::query()
                    ->where('key', 'logo_full')
                    ->first()
                    ?->media
                    ->first();

                if ($media) {
                    $config['logo_full_svg'] = Storage::disk($media->disk)
                        ->get($media->getPathRelativeToRoot());
                } else {
                    $config['logo_full_svg'] = file_get_contents("http://webserver{$logo_full}");
                }
            }
        } catch (Exception $ex) {
        }

        Config::set('custom', $config->toArray());
    }
}
