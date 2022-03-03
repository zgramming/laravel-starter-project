<?php

namespace Database\Seeders;

use App\Models\MasterData;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterDataSeeder extends Seeder
{
    private $datas = [];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach($this->datas as $k => $v){
            MasterData::create($v);
        }
    }
}
