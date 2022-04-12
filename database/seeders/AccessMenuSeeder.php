<?php

namespace Database\Seeders;

use App\Models\AccessMenu;
use App\Models\Menu;
use App\Models\UserGroup;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AccessMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = UserGroup::where("code", "=", "superadmin")->first();
        $menus = Menu::all();

        foreach ($menus as $key => $value) {
            AccessMenu::create([
                "id" => Str::uuid(),
                "app_group_user_id" => $superadmin->id,
                "app_menu_id" => $value->id,
                "app_modul_id" => $value->app_modul_id,
                "allowed_access" => ["view", "add", "delete", "edit", "print", "approve"],
            ]);
        }
    }
}
