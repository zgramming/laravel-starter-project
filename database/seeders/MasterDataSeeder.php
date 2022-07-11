<?php

namespace Database\Seeders;

use App\Models\MasterData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas = [];
        foreach($datas as $k => $v){
            MasterData::create($v);
        }
    }
}
