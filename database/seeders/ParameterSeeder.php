<?php

namespace Database\Seeders;

use App\Models\Parameter;
use Illuminate\Database\Seeder;

class ParameterSeeder extends Seeder
{

    private array $datas = [
        [
            'id' => 1,
            'code' => "MIN_PACAR",
            'name' => "Minimal Jumlah Pacar",
            'value' => 1,
            'status' => 'active',
        ],
        [
            'id' => 2,
            'code' => "MAX_PACAR",
            'name' => "Maximal Jumlah Pacar",
            'value' => 10,
            'status' => 'active',
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
            Parameter::create($value);
        }
    }
}
