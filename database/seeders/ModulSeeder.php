<?php

namespace Database\Seeders;

use App\Models\Modul;
use Illuminate\Database\Seeder;

class ModulSeeder extends Seeder
{
    private array $datas = [
        [
            'id' => 1,
            'code' => 'STG',
            'name' => "Setting",
            'order' => 99,
            'pattern' => 'setting/*',
            'icon_name' => null,
            'status' => 'active',
        ]
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->datas as $key => $value) {
            Modul::create($value);
        }
    }
}
