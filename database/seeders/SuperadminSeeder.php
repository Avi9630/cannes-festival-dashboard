<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class SuperadminSeeder extends Seeder
{
    public function run(): void
    {
        //Create SUPERADMIN 
        $superadmin = User::create([
            'name'      =>  'Shankar',
            'email'     =>  'shankar@gmail.com',
            'mobile'    =>  '9999999999',
            'role_id'   =>  1,
            'password'  =>  Hash::make('password'),
        ]);
        $superadmin->assignRole('SUPERADMIN');

        //Create ADMIN
        $admin = User::create([
            'name'      =>  'Avinash kumar',
            'email'     =>  'avinash_kumar@sislinfotech.com',
            'mobile'    =>  '0000000000',
            'role_id'   =>  2,
            'password'  =>  Hash::make('password'),
        ]);
        $admin->assignRole('ADMIN');
    }
}
