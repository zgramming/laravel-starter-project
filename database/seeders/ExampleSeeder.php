<?php

namespace Database\Seeders;

use App\Models\Example;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ExampleSeeder extends Seeder
{
    private $data = [
        [
            'code'=>'ZR',
            'name'=>'Zeffry Reynando',
            'description'=> 'Deskripsi Zeffry Reynando',
            'birth_date' => '1999-04-04',
            'current_money' => 100000,
            'profile_image'=>null,
            'hobby'=> ['mandi','makan','tidur'],
        ],
        [
            'code'=>'SH',
            'name'=>'Syarif H',
            'description'=> 'Deskripsi Syarif H',
            'birth_date' => '1999-04-05',
            'current_money' => 300000,
            'profile_image'=>null,
            'hobby'=> ['minum','makan','tidur'],
        ],[
            'code'=>'HAHM',
            'name'=>'Helmi H',
            'description'=> 'Deskripsi Helmi H',
            'birth_date' => '1999-04-06',
            'current_money' => 200000,
            'profile_image'=>null,
            'hobby'=> ['belanja','makan','tidur'],
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         foreach ($this->data as $key => $value){
             Example::create($value);
         }
    }
}
