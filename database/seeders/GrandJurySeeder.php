<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GrandJurySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Direction
        $jury1 = User::create([
            'name'              =>  'Grand Jury Direction',
            'email'             =>  'gjury1@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  4,
            'cmot_category_id'  =>  1,
            'password'          =>  Hash::make('password'),
        ]);
        $jury1->assignRole('GRANDJURY');
        // Scriptwriting
        $jury2 =    User::create([
            'name'              =>  'Grand Jury Script Writing',
            'email'             =>  'gjury2@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  4,
            'cmot_category_id'  =>  2,
            'password'          =>  Hash::make('password'),
        ]);
        $jury2->assignRole('GRANDJURY');

        // Editing & Subtitling
        $jury3 = User::create([
            'name'              =>  'Grand Jury Editing & Subtitling',
            'email'             =>  'gjury3@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  4,
            'cmot_category_id'  =>  3,
            'password'          =>  Hash::make('password'),
        ]);
        $jury3->assignRole('GRANDJURY');

        // Cinematography
        $jury4 = User::create([
            'name'              =>  'Grand Jury Cinematography',
            'email'             =>  'gjury4@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  4,
            'cmot_category_id'  =>  4,
            'password'          =>  Hash::make('password'),
        ]);
        $jury4->assignRole('GRANDJURY');

        // Animation, VFX, XR, AR
        $jury5 = User::create([
            'name'              =>  'Grand Jury Animation',
            'email'             =>  'gjury5@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  4,
            'cmot_category_id'  =>  5,
            'password'          =>  Hash::make('password'),
        ]);
        $jury5->assignRole('GRANDJURY');

        // Music Composition
        $jury6 = User::create([
            'name'              =>  'Grand Jury Music Composition',
            'email'             =>  'gjury6@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  4,
            'cmot_category_id'  =>  6,
            'password'          =>  Hash::make('password'),
        ]);
        $jury6->assignRole('GRANDJURY');

        // Playback Singing
        $jury7 = User::create([
            'name'              =>  'Grand Jury Playback Singing',
            'email'             =>  'gjury7@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  4,
            'cmot_category_id'  =>  7,
            'password'          =>  Hash::make('password'),
        ]);
        $jury7->assignRole('GRANDJURY');

        // Sound Recording
        $jury8 = User::create([
            'name'              =>  'Grand Jury Sound Recording',
            'email'             =>  'gjury8@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  4,
            'cmot_category_id'  =>  8,
            'password'          =>  Hash::make('password'),
        ]);
        $jury8->assignRole('GRANDJURY');

        // Acting
        $jury9 = User::create([
            'name'              =>  'Grand Jury Acting',
            'email'             =>  'gjury9@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  4,
            'cmot_category_id'  =>  9,
            'password'          =>  Hash::make('password'),
        ]);
        $jury9->assignRole('GRANDJURY');

        // Art Direction
        $jury10 = User::create([
            'name'              =>  'Grand Art Direction',
            'email'             =>  'gjury10@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  4,
            'cmot_category_id'  =>  10,
            'password'          =>  Hash::make('password'),
        ]);
        $jury10->assignRole('GRANDJURY');

        // Voice Over/Dubbing
        $jury11 = User::create([
            'name'              =>  'Grand Voice Over/Dubbing',
            'email'             =>  'gjury11@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  4,
            'cmot_category_id'  =>  11,
            'password'          =>  Hash::make('password'),
        ]);
        $jury11->assignRole('GRANDJURY');

        // Hair & Make-Up
        $jury12 = User::create([
            'name'              =>  'Grand Voice Hair & Make-Up',
            'email'             =>  'gjury12@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  4,
            'cmot_category_id'  =>  12,
            'password'          =>  Hash::make('password'),
        ]);
        $jury12->assignRole('GRANDJURY');

        // Costume Design
        $jury13 = User::create([
            'name'              =>  'Grand Voice Costume Design',
            'email'             =>  'gjury13@gmail.com',
            'mobile'            =>  rand(1111111111, 9999999999),
            'role_id'           =>  4,
            'cmot_category_id'  =>  13,
            'password'          =>  Hash::make('password'),
        ]);
        $jury13->assignRole('GRANDJURY');
    }
}
