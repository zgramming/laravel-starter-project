<?php

namespace Database\Seeders;

use App\Models\AccessModul;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AccessModulSeeder extends Seeder
{
    protected array $datas = [
        [
            'app_group_user_id'=> 1,
            'app_modul_id'=> 1,
        ],
        [
            'app_group_user_id'=> 1,
            'app_modul_id'=> 2,
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
            AccessModul::create($value);
        }
    }
}
