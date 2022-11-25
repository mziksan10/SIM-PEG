<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
               'username'=>'admin',
               'email'=>'admin@simpeg.piksi.ac.id',
                'role'=>'admin',
               'password'=> Hash::make('piksi301@)@@'),
            ],
        ];
        foreach ($user as $key => $value) {
            User::create($value);
        }
    }
}
