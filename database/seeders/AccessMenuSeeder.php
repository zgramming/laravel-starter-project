<?php

namespace Database\Seeders;

use App\Models\AccessMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Str;

class AccessMenuSeeder extends Seeder
{
    protected array $datas = [
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 1,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 2,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 3,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 4,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 5,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 6,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 7,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 8,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 9,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 10,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 11,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 12,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 13,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
        [
            'app_group_user_id' => 1,
            'app_modul_id'=> 1,
            'app_menu_id'=> 14,
            'allowed_access'=> ['view','add','delete','edit','print','approve'],
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->datas as $key => $value){
            $value['id'] = Str::uuid();
            AccessMenu::create($value);
        }
    }
}
