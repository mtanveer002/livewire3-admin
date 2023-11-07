<?php

namespace Database\Seeders;

use App\Models\Menu;
use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = collect([
            'header', 'navigation', 'footer',
        ])
            ->map(
                fn ($name) => Menu::query()
                    ->firstOrCreate(compact('name'))
            )
            ->pluck('id', 'name');

        collect([
            1 => [
                'menu' => 'header',
                'title' => 'Test',
                'link' => '/test',
                'order' => 0,
            ],

            7 => [
                'menu' => 'navigation',
                'title' => 'Test',
                'link' => '/test',
                'order' => 0,
            ],

            20 => [
                'menu' => 'footer',
                'title' => 'Terms & Conditions',
                'link' => '/terms-conditions',
                'order' => 0,
            ],
            21 => [
                'menu' => 'footer',
                'title' => 'Privacy Policy',
                'link' => '/privacy-policy',
                'order' => 1,
            ],
        ])
            ->map(fn ($item, $key) => MenuItem::firstOrCreate(['id' => $key], [
                'menu_id' => $menus[$item['menu']],
                'title' => $item['title'],
                'link' => $item['link'],
            ]));
    }
}
