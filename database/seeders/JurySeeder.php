<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class JurySeeder extends Seeder
{
    public function run(): void
    {
        //Direction
        $jury1 = User::create([
            'name'              =>  'Jury1',
            'email'             =>  'jury1@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  1,
            'password'          =>  Hash::make('password'),
        ]);
        $jury1->assignRole('JURY');

        $jury2 =    User::create([
            'name'              =>  'Jury2',
            'email'             =>  'jury2@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  1,
            'password'          =>  Hash::make('password'),
        ]);
        $jury2->assignRole('JURY');

        // Scriptwriting
        $jury3 = User::create([
            'name'              =>  'Jury3',
            'email'             =>  'jury3@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  2,
            'password'          =>  Hash::make('password'),
        ]);
        $jury3->assignRole('JURY');

        $jury4 = User::create([
            'name'              =>  'Jury4',
            'email'             =>  'jury4@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  2,
            'password'          =>  Hash::make('password'),
        ]);
        $jury4->assignRole('JURY');

        // Editing & Subtitling
        $jury5 = User::create([
            'name'              =>  'Jury5',
            'email'             =>  'jury5@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  3,
            'password'          =>  Hash::make('password'),
        ]);
        $jury5->assignRole('JURY');

        $jury6 = User::create([
            'name'              =>  'Jury6',
            'email'             =>  'jury6@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  3,
            'password'          =>  Hash::make('password'),
        ]);
        $jury6->assignRole('JURY');

        // Cinematography
        $jury7 = User::create([
            'name'              =>  'Jury7',
            'email'             =>  'jury7@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  4,
            'password'          =>  Hash::make('password'),
        ]);
        $jury7->assignRole('JURY');

        $jury8 = User::create([
            'name'              =>  'Jury8',
            'email'             =>  'jury8@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  4,
            'password'          =>  Hash::make('password'),
        ]);
        $jury8->assignRole('JURY');

        // Animation, VFX, XR, AR
        $jury9 = User::create([
            'name'              =>  'Jury9',
            'email'             =>  'jury9@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  5,
            'password'          =>  Hash::make('password'),
        ]);
        $jury9->assignRole('JURY');

        $jury10 = User::create([
            'name'              =>  'Jury10',
            'email'             =>  'jury10@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  5,
            'password'          =>  Hash::make('password'),
        ]);
        $jury10->assignRole('JURY');

        // Music Composition
        $jury11 = User::create([
            'name'              =>  'Jury11',
            'email'             =>  'jury11@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  6,
            'password'          =>  Hash::make('password'),
        ]);
        $jury11->assignRole('JURY');

        $jury12 = User::create([
            'name'              =>  'Jury12',
            'email'             =>  'jury12@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  6,
            'password'          =>  Hash::make('password'),
        ]);
        $jury12->assignRole('JURY');

        // Playback Singing
        $jury13 = User::create([
            'name'              =>  'Jury13',
            'email'             =>  'jury13@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  7,
            'password'          =>  Hash::make('password'),
        ]);
        $jury13->assignRole('JURY');

        $jury14 = User::create([
            'name'              =>  'Jury14',
            'email'             =>  'jury14@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  7,
            'password'          =>  Hash::make('password'),
        ]);
        $jury14->assignRole('JURY');

        // Sound Recording
        $jury15 = User::create([
            'name'              =>  'Jury15',
            'email'             =>  'jury15@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  8,
            'password'          =>  Hash::make('password'),
        ]);
        $jury15->assignRole('JURY');

        $jury16 = User::create([
            'name'              =>  'Jury16',
            'email'             =>  'jury16@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  8,
            'password'          =>  Hash::make('password'),
        ]);
        $jury16->assignRole('JURY');

        // Acting
        $jury17 = User::create([
            'name'              =>  'Jury17',
            'email'             =>  'jury17@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  9,
            'password'          =>  Hash::make('password'),
        ]);
        $jury17->assignRole('JURY');

        $jury18 = User::create([
            'name'              =>  'Jury18',
            'email'             =>  'jury18@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  9,
            'password'          =>  Hash::make('password'),
        ]);
        $jury18->assignRole('JURY');

        // Art Direction
        $jury19 = User::create([
            'name'              =>  'Jury19',
            'email'             =>  'jury19@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  10,
            'password'          =>  Hash::make('password'),
        ]);
        $jury19->assignRole('JURY');

        $jury20 = User::create([
            'name'              =>  'Jury20',
            'email'             =>  'jury20@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  10,
            'password'          =>  Hash::make('password'),
        ]);
        $jury20->assignRole('JURY');

        // Voice Over/Dubbing
        $jury21 = User::create([
            'name'              =>  '21',
            'email'             =>  'jury21@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  11,
            'password'          =>  Hash::make('password'),
        ]);
        $jury21->assignRole('JURY');

        $jury22 = User::create([
            'name'              =>  'Jury22',
            'email'             =>  'jury22@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  11,
            'password'          =>  Hash::make('password'),
        ]);
        $jury22->assignRole('JURY');

        // Hair & Make-Up
        $jury23 = User::create([
            'name'              =>  'Jury23',
            'email'             =>  'jury23@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  12,
            'password'          =>  Hash::make('password'),
        ]);
        $jury23->assignRole('JURY');

        $jury24 = User::create([
            'name'              =>  'Jury24',
            'email'             =>  'jury24@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  12,
            'password'          =>  Hash::make('password'),
        ]);
        $jury24->assignRole('JURY');

        // Hair & Make-Up
        $jury25 = User::create([
            'name'              =>  'Jury25',
            'email'             =>  'jury25@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  13,
            'password'          =>  Hash::make('password'),
        ]);
        $jury25->assignRole('JURY');

        $jury26 = User::create([
            'name'              =>  'Jury26',
            'email'             =>  'jury26@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  3,
            'cmot_category_id'  =>  13,
            'password'          =>  Hash::make('password'),
        ]);
        $jury26->assignRole('JURY');
    }
}
