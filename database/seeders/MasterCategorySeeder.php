<?php

namespace Database\Seeders;

use App\Models\MasterCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MasterCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $datas =  [
            [
            'code' => 'testing',
            'name' => "Kategori Testing",
            'description'=>'Deskripsi Kategori Testing',
            'status'=>'active',
           ],
        ];

        foreach($datas as $key => $value){
            MasterCategory::create($value);
        }
    }
}
