<?php

namespace Database\Seeders;

use App\Models\AccessModul;
use App\Models\Modul;
use App\Models\UserGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AccessModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $modul = Modul::all();
        $superadmin = UserGroup::where("code", "=", "superadmin")->first();

        foreach ($modul as $key => $value) {
            AccessModul::create([
                "id" => Str::uuid(),
                "app_group_user_id" => $superadmin->id,
                "app_modul_id" => $value->id,
            ]);
        }
    }
}
