<?php

namespace Tests\Feature\Admin\Cms;

use App\Http\Livewire\Admin\Cms\Menu\MenuItemBuilder;
use App\Models\Menu;
use Database\Seeders\MenuSeeder;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class MenuTest extends TestCase
{
    use WithLogin;

    public $parentMenuId = 1;

    public function test_guest_user_view_menu_listing_page()
    {
        $response = $this->get(
            route('admin.cms.menu.index')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    public function test_authorized_user_view_menu_listing_page()
    {
        $this->loginStaff(true);

        $response = $this->get(
            route('admin.cms.menu.index')
        );

        $response->assertOk();
    }

    public function test_guest_user_view_menu_builder_listing_page()
    {
        $this->seed(MenuSeeder::class);

        $response = $this->get(
            route('admin.cms.menu.builder', ['menu' => $this->parentMenuId])
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    public function test_authorized_user_view_menu_builder_listing_page()
    {
        $this->loginStaff(true);

        $this->seed(MenuSeeder::class);

        $response = $this->get(
            route('admin.cms.menu.builder', ['menu' => $this->parentMenuId])
        );

        $response->assertOk();
    }

    public function test_authorized_user_cannot_create_menu_item_builder_with_invalid_data()
    {
        $user = $this->loginStaff(true);

        $response = Livewire::actingAs($user)
            ->test(MenuItemBuilder::class)
            ->set('menuItem.title', '')
            ->set('menuItem.link', '')
            ->call('save');

        $response->assertOk();

        $response->assertHasErrors([
            'menuItem.title',
            'menuItem.link',
        ]);
    }

    public function test_authorized_user_can_create_menu_item_builder_with_valid_data()
    {
        $user = $this->loginStaff(true);

        $menu = Menu::factory()->create()->first();

        $response = Livewire::actingAs($user)
            ->test(MenuItemBuilder::class, [
                'menu' => $menu,
            ])
            ->set('menuItem.title', 'Test')
            ->set('menuItem.link', '/test')
            ->call('save');

        $response->assertOk();
    }
}
