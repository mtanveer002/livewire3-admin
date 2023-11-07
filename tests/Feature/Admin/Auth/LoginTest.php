<?php

namespace Tests\Feature\Admin\Auth;

use App\Http\Livewire\Admin\Auth\LoginController;
use App\Models\Admin\Staff;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class LoginTest extends TestCase
{
    use WithLogin;

    /**
     * test_login_screen_can_be_rendered
     */
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('admin.login'));

        $response->assertStatus(200);
    }

    /**
     * test_staff_can_login_with_valid_credentials
     */
    public function test_staff_can_login_with_valid_credentials(): void
    {
        /** @var \App\Models\Staff */
        $staff = Staff::factory()->create();

        $response = Livewire::test(LoginController::class)
            ->set('email', $staff->email)
            ->set('password', 'password')
            ->call('login');

        $response->assertStatus(200);
        $this->assertAuthenticated('admin');
        $response->assertRedirect(route('admin.dashboard'));
    }

    /**
     * test_staff_can_not_login_with_invalid_credentials
     */
    public function test_staff_can_not_login_with_invalid_credentials(): void
    {
        /** @var \App\Models\Staff */
        $staff = Staff::factory()->create();

        $response = Livewire::test(LoginController::class)
            ->set('email', $staff->email)
            ->set('password', 'wrongpassword')
            ->call('login');

        $response->assertStatus(200);
        $response->assertHasErrors('email');
        $this->assertGuest('admin');
    }
}
