<?php

namespace Database\Seeders;

use App\Models\Example;
use Illuminate\Database\Seeder;

class ExampleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $timestamp = [
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s'),
        ];
        $data = [
            [
                'code' => 'ZR',
                'name' => 'Zeffry Reynando',
                'description' => 'Deskripsi Zeffry Reynando',
                'birth_date' => '1999-04-04',
                'current_money' => 100000,
                'profile_image' => null,
                'hobby' => json_encode(['mandi', 'makan', 'tidur']),
                ...$timestamp
            ],
            [
                'code' => 'SH',
                'name' => 'Syarif H',
                'description' => 'Deskripsi Syarif H',
                'birth_date' => '1999-04-05',
                'current_money' => 300000,
                'profile_image' => null,
                'hobby' => json_encode(['minum', 'makan', 'tidur']),
                ...$timestamp
            ], [
                'code' => 'HAHM',
                'name' => 'Helmi H',
                'description' => 'Deskripsi Helmi H',
                'birth_date' => '1999-04-06',
                'current_money' => 200000,
                'profile_image' => null,
                'hobby' => json_encode(['belanja', 'makan', 'tidur']),
                ...$timestamp
            ],
        ];

        Example::insert($data);
    }
}
