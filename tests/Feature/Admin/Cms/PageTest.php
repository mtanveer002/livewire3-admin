<?php

namespace Tests\Feature\Admin\Cms;

use App\Http\Livewire\Admin\Cms\Page\PageCreateController;
use App\Http\Livewire\Admin\Cms\Page\PageShowController;
use App\Models\Page;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class PageTest extends TestCase
{
    use WithLogin;

    public function test_guest_users_cannot_see_pages_listing_page()
    {
        $response = $this->get(
            route('admin.cms.pages.index')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    public function test_authorized_user_can_see_pages_listing_page()
    {
        $this->loginStaff(true);

        $response = $this->get(
            route('admin.cms.pages.index')
        );

        $response->assertOk();
    }

    public function test_authorized_user_cannot_create_page_with_invalid_data()
    {
        $this->loginStaff(true);

        $response = Livewire::test(PageCreateController::class)
            ->set('page.title', '')
            ->call('save');

        $response->assertOk();
        $response->assertHasErrors([
            'page.title',
        ]);
    }

    public function test_authorized_user_can_create_page_with_valid_data()
    {
        $user = $this->loginStaff(true);

        $response = Livewire::actingAs($user)
            ->test(PageCreateController::class)
            ->set('page.title', 'test')
            ->set('page.is_published', true)
            ->call('save');

        $response->assertOk();

        $this->assertCount(1, Page::query()->whereTitle('test')->published()->get());
    }

    public function test_authorized_user_cannot_update_page_with_invalid_data()
    {
        $user = $this->loginStaff(true);

        $page = Page::factory()
            ->count(1)
            ->create()
            ->first();

        $response = Livewire::actingAs($user)
            ->test(PageShowController::class, [
                'page' => $page,
            ])
            ->set('page.title', '')
            ->call('save');

        $response->assertOk();
        $response->assertHasErrors([
            'page.title',
        ]);
    }

    public function test_authorized_user_can_update_page_with_valid_data()
    {
        $user = $this->loginStaff(true);

        $page = Page::factory()
            ->count(1)
            ->create()
            ->first();

        $response = Livewire::actingAs($user)
            ->test(PageShowController::class, [
                'page' => $page,
            ])
            ->set('page.title', 'test title')
            ->set('page.is_published', false)
            ->call('save');

        $response->assertOk();

        $this->assertCount(1, Page::query()->whereTitle('test title')->notPublished()->get());
    }

    public function test_authorized_user_delete_page()
    {
        $user = $this->loginStaff(true);

        $page = Page::factory()
            ->count(1)
            ->create()
            ->first();

        Livewire::actingAs($user)
            ->test(PageShowController::class, [
                'page' => $page,
            ])
            ->call('delete');

        $this->assertSoftDeleted($page);
    }
}
