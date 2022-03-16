<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AppGroupUserSeeder::class);
        $this->call(ExampleSeeder::class);
        $this->call(MasterCategorySeeder::class);
        $this->call(MasterDataSeeder::class);
        \App\Models\User::factory(1)->create();

    }
}
