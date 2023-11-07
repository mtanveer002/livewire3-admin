<?php

namespace Database\Seeders;

use App\Models\Admin\Staff;
use Illuminate\Database\Seeder;

class DefaultAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Staff::firstOrCreate(
            [
                'email' => 'admin@admin.com',
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => bcrypt('12345678'),
                'is_admin' => true,
            ]
        );
    }
}
