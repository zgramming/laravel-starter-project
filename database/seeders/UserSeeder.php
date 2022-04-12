<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [
            [
                "id" => 1,
                'username' => 'superadmin',
                'name' => "Super Admin",
                'email' => "superadmin@gmail.com",
                'email_verified_at' => now(),
                'password' => "superadmin", // password
                'remember_token' => Str::random(10),
                'app_group_user_id' => 1,
                'status' => 'active',
            ],
        ];

        foreach($datas as $key => $value){
            User::create($value);
        }
    }
}
