<?php

use App\Models\Menu;
use App\Models\Admin\Staff;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Rules\SettingsImageValidation;

if (!function_exists('get_max_fileupload_size')) {
    function get_max_fileupload_size($maxUploadSize = null)
    {
        $maxAllowedServerSize = (int) ini_get('upload_max_filesize') * 1024;

        $mediaLibraryAllowedSize = config('media-library.max_file_size', 10000000000000) / 1024;

        $appConfiguredMaxSize = ($mediaLibraryAllowedSize < $maxAllowedServerSize) ? $mediaLibraryAllowedSize : $maxAllowedServerSize;

        if (!$maxUploadSize) {
            return $appConfiguredMaxSize;
        }

        if ($maxUploadSize < $appConfiguredMaxSize) {
            return $maxUploadSize;
        }

        return $appConfiguredMaxSize;
    }

    function get_general_site_settings($key = null, $type = 'type')
    {
        $settings = collect([
            'site_title' => ['value' => 'Demo', 'type' => 'text', 'rules' => 'required|string|max:255'],
            'meta_tag' => ['value' => 'Demo', 'type' => 'text', 'rules' => 'string|max:255'],
            'copyright_text' => ['value' => 'All Rights Reserved.', 'type' => 'text', 'rules' => 'string|max:255'],
            'phone_number' => ['value' => '+1 (123) 456 7890', 'type' => 'text', 'rules' => 'required|string|max:255'],
            'contact_us_email' => ['value' => 'info@companyname.com', 'type' => 'email', 'rules' => 'required|email|max:255'],
            'information_email' => ['value' => 'info@companyname.com', 'type' => 'email', 'rules' => 'required|email|max:255'],
            'address' => ['value' => 'Address Comes Here Lorem Ipsum dolor 123', 'type' => 'text', 'rules' => 'required|string|max:255'],
            'facebook_url' => ['value' => '', 'type' => 'text', 'rules' => 'string|max:255'],
            'twitter_url' => ['value' => '', 'type' => 'text', 'rules' => 'string|max:255'],
            'youtube_url' => ['value' => '', 'type' => 'text', 'rules' => 'string|max:255'],
            'instagram_url' => ['value' => '', 'type' => 'text', 'rules' => 'string|max:255'],
            'pinterest_url' => ['value' => '', 'type' => 'text', 'rules' => 'string|max:255'],
            'logo_full' => ['value' => '/frontend/images/logo.png', 'type' => 'file', 'rules' => ['bail', 'required', (new SettingsImageValidation)->mimes(['svg']), 'max:3000']],
            'logo_small' => ['value' => '/frontend/images/logo.png', 'type' => 'file', 'rules' => ['bail', 'required', new SettingsImageValidation, 'max:3000']],
        ]);

        if ($key && $type) {
            return $settings[$key][$type] ?? null;
        }

        return $settings;
    }
}

if (!function_exists('vite')) {
    function vite($resource, $buildDirectory = 'tallAdmin')
    {
        return app(Vite::class)($resource, $buildDirectory);
    }
}

if (!function_exists('viteCssPath')) {
    function viteCssPath(string $resource, $buildDirectory = 'tallAdmin')
    {
        return Str::of(vite($resource, $buildDirectory))->after('href="')->before('" />')->toString();
    }
}

if (!function_exists('viteJsPath')) {
    function viteJsPath(string $resource, $buildDirectory = 'tallAdmin')
    {
        return Str::of(vite($resource, $buildDirectory))->after('src="')->before('">')->toString();
    }
}

if (!function_exists('get_menu')) {
    function get_menu($name)
    {
        return Menu::getMenuByName($name);
    }
}


if (!function_exists('auth_staff')) {
    function auth_staff()
    {
        /** @var Staff $staff */
        $staff = Auth::user();

        return $staff;
    }
}
