<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $permissions = [
            //USER
            'create-user',
            'edit-user',
            'view-user',
            'delete-user',
            'list-user',

            //FIXED 
            'create-role',
            'edit-role',
            'view-role',
            'delete-role',
            'list-role',
            'create-permission',
            'edit-permission',
            'view-permission',
            'delete-permission',
            'list-permission',
            //FIXED END

            "nfa-feature",
            "nfa-non-feature",
            "nfa-best-book",
            "nfa-best-film-critic",
        ];
        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]); //'guard_name' => 'web', 
        }
    }
}
