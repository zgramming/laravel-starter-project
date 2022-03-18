<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{

    private array $datas = [
        [
            'app_modul_id'=> 1,
            'code'=> 'STG00001',
            'name'=> 'Management User',
            'route'=> 'setting/user',
            'order'=> 1,
            'icon_name'=> null,
            'status'=> 'active',
        ],
        [
            'app_modul_id'=> 1,
            'code'=> 'STG00002',
            'name'=> 'Management Group User',
            'route'=> 'setting/user-group',
            'order'=> 2,
            'icon_name'=> null,
            'status'=> 'active',
        ],
        [
            'app_modul_id'=> 1,
            'code'=> 'STG00003',
            'name'=> 'Menu',
            'route'=> 'setting/menu',
            'order'=> 3,
            'icon_name'=> null,
            'status'=> 'active',
        ],
        [
            'app_modul_id'=> 1,
            'code'=> 'STG00004',
            'name'=> 'Modul',
            'route'=> 'setting/modul',
            'order'=> 4,
            'icon_name'=> null,
            'status'=> 'active',
        ],
        [
            'app_modul_id'=> 1,
            'code'=> 'STG00005',
            'name'=> 'Access Menu',
            'route'=> 'setting/access-menu',
            'order'=> 5,
            'icon_name'=> null,
            'status'=> 'active',
        ],
        [
            'app_modul_id'=> 1,
            'code'=> 'STG00006',
            'name'=> 'Access Modul',
            'route'=> 'setting/access-modul',
            'order'=> 6,
            'icon_name'=> null,
            'status'=> 'active',
        ],
        [
            'app_modul_id'=> 1,
            'code'=> 'STG00007',
            'name'=> 'Master Data',
            'route'=> 'setting/master-category',
            'order'=> 7,
            'icon_name'=> null,
            'status'=> 'active',
        ],
        [
            'app_modul_id'=> 1,
            'code'=> 'STG00008',
            'name'=> 'Management Parameter',
            'route'=> 'setting/parameter',
            'order'=> 8,
            'icon_name'=> null,
            'status'=> 'active',
        ],
        [
            'app_modul_id'=> 1,
            'code'=> 'STG00009',
            'name'=> 'Example / Dokumentasi',
            'route'=> 'setting/example',
            'order'=> 9,
            'icon_name'=> null,
            'status'=> 'active',
        ],

        /// Dokumen
        [
            'app_modul_id'=> 2,
            'code'=> 'DKM00001',
            'name'=> 'Format Penomoran',
            'route'=> 'dokumen/format-penomoran',
            'order'=> 1,
            'icon_name'=> null,
            'status'=> 'active',
        ],
        [
            'app_modul_id'=> 2,
            'code'=> 'DKM00002',
            'name'=> 'Format Dokumen',
            'route'=> 'dokumen/format-dokumen',
            'order'=> 2,
            'icon_name'=> null,
            'status'=> 'active',
        ],
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->datas as $key => $value) {
            Menu::create($value);
        }
    }
}
