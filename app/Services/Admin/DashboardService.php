<?php

namespace App\Services\Admin;

use App\Models\Admin\Staff;

class DashboardService
{
    /**
     * Get required data for dashboard
     *
     * @return array<mixed>
     */
    public function getData()
    {
        return [
            'totalUsers' => $this->getUsersCount(),
        ];
    }

    public function getUsersCount(): int
    {
        return Staff::count();
    }
}
