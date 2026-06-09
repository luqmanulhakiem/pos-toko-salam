<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ["name" => "admin"],
            ["name" => "kasir"]
        ];

        foreach ($roles as $value) {
            Role::create([
                "name" => $value['name']
            ]);
        }
    }
}
