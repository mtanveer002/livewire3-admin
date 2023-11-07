<?php

namespace Tests\Feature\Admin\Dashboard;

use Tests\TestCase;
use Tests\WithLogin;

class DashboardTest extends TestCase
{
    use WithLogin;

    public function test_guest_users_cannot_view_dashboard_page()
    {
        $response = $this->get(
            route('admin.dashboard')
        );

        $response->assertRedirect(
            route('admin.login')
        );
    }

    public function test_authorized_users_can_view_dashboard_page()
    {
        $this->loginStaff(true);

        $response = $this->get(
            route('admin.dashboard')
        );

        $response->assertOk();
    }
}
