<?php

namespace Tests\Feature\Admin\Auth;

use App\Http\Livewire\Admin\Auth\PasswordResetController;
use App\Models\Admin\Staff;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    public function test_forgot_password_screen_can_be_rendered(): void
    {
        $response = $this->get(route('admin.password-reset'));

        $response->assertStatus(200);
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        $staff = Staff::factory()->create();

        $response = Livewire::test(PasswordResetController::class)
            ->set('email', $staff->email)
            ->call('sendResetEmail');

        $response->assertStatus(200);
    }

    public function test_reset_passwod_notification_can_be_sent(): void
    {
        $email = Str::random().'@gmail.com';

        $current_password = Str::random(16);

        $current_password_hash = Hash::make($current_password);

        $staff = Staff::factory()->create([
            'email' => $email,
            'password' => $current_password_hash,
        ]);

        $response = Livewire::test(PasswordResetController::class)
            ->set('email', $staff->email)
            ->call('sendResetEmail');

        $response->assertStatus(200);
    }
}
