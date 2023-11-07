<?php

namespace Tests\Feature\Admin;

use App\Http\Livewire\Admin\System\Settings\SettingsController;
use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Livewire\Livewire;
use Tests\TestCase;
use Tests\WithLogin;

class SettingTest extends TestCase
{
    use WithLogin;

    public function test_guest_user_cannot_view_setting_page()
    {
        $response = $this->get(
            route('admin.system.settings')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    public function test_authorized_user_can_view_setting_page()
    {
        $this->loginStaff(true);

        $response = $this->get(
            route('admin.system.settings')
        );

        $response->assertOk();
    }

    public function test_authorized_user_can_update_settings_with_valid_data()
    {
        $user = $this->loginStaff(true);

        $email = Str::random().'@gmail.com';
        $info_email = Str::random().'@gmail.com';

        $response = Livewire::actingAs($user)
            ->test(SettingsController::class)
            ->set('settings.site_title', 'Test')
            ->set('settings.meta_tag', 'Test')
            ->set('settings.copyright_text', 'Test')
            ->set('settings.phone_number', 'Test')
            ->set('settings.contact_us_email', $email)
            ->set('settings.information_email', $info_email)
            ->set('settings.address', 'Test')
            ->set('settings.facebook_url', 'Test')
            ->set('settings.twitter_url', 'Test')
            ->set('settings.pinterest_url', 'Test')
            ->set('settings.youtube_url', 'Test')
            ->set('settings.instagram_url', 'Test')
            ->set('settings.hidden', 'Test')
            ->set('settings.logo_full', UploadedFile::fake()->create('avatar.svg', 10))
            ->set('settings.logo_small', UploadedFile::fake()->image('avatar.jpg'))
            ->call('update');

        $response->assertOk();

        $this->assertEquals(15, Setting::count());
    }

    public function test_authorized_user_cannot_update_settings_with_invalid_data()
    {
        $user = $this->loginStaff(true);

        $response = Livewire::actingAs($user)
            ->test(SettingsController::class)
            ->set('settings.site_title', '')
            ->set('settings.meta_tag', '')
            ->set('settings.copyright_text', '')
            ->set('settings.phone_number', '')
            ->set('settings.contact_us_email', '')
            ->set('settings.information_email', '')
            ->set('settings.address', '')
            ->set('settings.facebook_url', '')
            ->set('settings.twitter_url', '')
            ->set('settings.pinterest_url', '')
            ->set('settings.youtube_url', '')
            ->set('settings.instagram_url', '')
            ->set('settings.hidden', '')
            ->set('settings.logo_full', null)
            ->set('settings.logo_small', null)
            ->call('update');

        $response->assertOk();

        $response->assertHasErrors([
            'settings.site_title',
            'settings.contact_us_email',
            'settings.information_email',
            'settings.logo_full',
            'settings.logo_small',
        ]);
    }
}
