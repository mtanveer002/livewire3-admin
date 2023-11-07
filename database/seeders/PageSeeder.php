<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $pages = [
            [
                'id' => Page::HOME_PAGE_ID,
                'title' => 'Home',
                'template' => 'home',
            ],
            [
                'id' => 2,
                'title' => 'About Us',
                'template' => 'about-us',
            ],
            [
                'id' => 4,
                'title' => 'Privacy Policy',
                'template' => 'privacy-policy',
            ],
            [
                'id' => 5,
                'title' => 'Terms & conditions',
                'template' => 'terms-conditions',
            ]
        ];
        foreach ($pages as $page) {
            $content = view("vendor/laravel-grapesjs/templates/{$page['template']}")->render();

            Page::firstOrCreate(
                [
                    'id' => $page['id'],
                ],
                [
                    'id' => $page['id'],
                    'title' => $page['title'],
                    'slug' => Str::slug($page['title']),
                    'header_white' => $page['header_white'] ?? 0,
                    'gjs_data' => [
                        'components' => json_encode([$content]),
                        'html' => $content,
                    ],
                ]
            );
        }
    }
}
