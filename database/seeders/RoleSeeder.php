<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;
use App\Models\Admin;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // 1. Create Super Admin Role
        $superAdmin = Role::updateOrCreate(
            ['name' => 'Super Admin'],
            ['permissions' => ['*']] // Wildcard
        );

        // 2. Create Editor Role
        $editor = Role::updateOrCreate(
             ['name' => 'Editor'],
             ['permissions' => [
                'product.view', 'product.create', 'product.edit', 'product.delete',
                'mitra.view', 'mitra.create', 'mitra.edit',
                'portfolio.view', 'portfolio.create', 'portfolio.edit',
                'message.view', 'message.delete',
            ]]
        );

        // 3. Assign first admin to Super Admin
        $admin = Admin::where('email', 'admin@gmail.com')->first();
        if ($admin) {
            $admin->update(['role_id' => $superAdmin->id]);
        }
    }
}
