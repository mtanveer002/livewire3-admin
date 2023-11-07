<?php

namespace App\Services\Admin;

use App\Menu\Menu;
use App\Menu\MenuItem;
use Illuminate\Support\Collection;

class MenuService
{
    public static function menu(string $name): Menu
    {
        return (new self)->get($name);
    }

    public function get(string $name): Menu
    {
        /** @var \App\Menu\Menu */
        $menu = $this->getMenuList()->where('name', $name)->first();

        return $menu;
    }

    private function getMenuList(): Collection
    {
        return collect([
            /**
             * Main Sidebar Menu
             */
            Menu::make('main')
                ->addItem(function (MenuItem $item) {
                    $item->name('Dashboard')
                        ->handle('admin.dashboard')
                        // ->permission('admin:dashboard')
                        ->icon('chart-square-bar')
                        ->route('admin.dashboard');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Cms')
                        ->handle('admin.cms')
                        // ->permission('cms')
                        ->icon('document')
                        ->route('admin.cms.menu.index');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('System')
                        ->handle('admin.system')
                        // ->permission('system')
                        ->icon('cog')
                        ->route('admin.system.staff.index');
                }),

            /**
             * System Menu
             */
            Menu::make('system')
                ->addItem(function (MenuItem $item) {
                    $item->name('Staff')
                        ->handle('admin.system.staff')
                        ->route('admin.system.staff.index')
                        // ->permission('system:manage-staff')
                        ->icon('identification');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Settings')
                        ->handle('admin.system.settings')
                        ->route('admin.system.settings')
                        // ->permission('system:settings')
                        ->icon('cog');
                }),

            /**
             * CMS Menu
             */
            Menu::make('cms')

                ->addItem(function (MenuItem $item) {
                    $item->name('Menu')
                        ->handle('admin.cms.menu')
                        ->route('admin.cms.menu.index')
                        // ->permission('cms:manage-menus')
                        ->icon('menu');
                })
                ->addItem(function (MenuItem $item) {
                    $item->name('Pages')
                        ->handle('admin.cms.pages')
                        ->route('admin.cms.pages.index')
                        // ->permission('cms:manage-pages')
                        ->icon('collection');
                }),
        ]);
    }
}
