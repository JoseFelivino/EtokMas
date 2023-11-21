<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class goldseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gold')->insert([
            ['name'=>'Anting Hati','weight'=>2.9, 'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>1 , 'img_path' => '/images/gold/Anting-Hati.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Cincin Bunga Bulat','weight'=>2.8, 'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>1 , 'img_path' => '/images/gold/cincin-bunga-bulat.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Cincin Kotak Mata Hitam ','weight'=>5.75,'user_id'=>1,'gold_carat_category_id'=>4,'shelf_id'=>1, 'img_path' => '/images/gold/cincin-kotak-matahitam.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Cincin Cartier','weight'=>3.5,'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>1, 'img_path' => '/images/gold/cincin-kuning-cartier.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Cincin Mata Awan','weight'=>1.5, 'user_id'=>1,'gold_carat_category_id'=>2,'shelf_id'=>1 , 'img_path' => '/images/gold/cincin-mata-awan.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Cincin Mata Biru ','weight'=>3,'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>1, 'img_path' => '/images/gold/Cincin-mata-biru.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Cincin Kupu-Kupu','weight'=>1.3,'user_id'=>1,'gold_carat_category_id'=>2,'shelf_id'=>1, 'img_path' => '/images/gold/Cincin-kupukupu.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Cincin Mata Hitam Bulat','weight'=>2.6, 'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>1 , 'img_path' => '/images/gold/cincin-mata-hitam-bulat.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],

            ['name'=>'Cincin Mata Kupu-kupu ','weight'=>4.2,'user_id'=>1,'gold_carat_category_id'=>1,'shelf_id'=>2, 'img_path' => '/images/gold/cincin-mata-kupu.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Cincin Mata Putih','weight'=>3,'user_id'=>1,'gold_carat_category_id'=>4,'shelf_id'=>2, 'img_path' => '/images/gold/cincin-mata-putih.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Cincin Mata Satu','weight'=>1, 'user_id'=>1,'gold_carat_category_id'=>1,'shelf_id'=>2 , 'img_path' => '/images/gold/cincin-mata-satu.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Cincin Mata Full ','weight'=>2,'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>2, 'img_path' => '/images/gold/Cincin-Mata.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Cincin Batu Putih Full','weight'=>4,'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>2, 'img_path' => '/images/gold/cincin-mata22.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Cincin Polos ','weight'=>1.3,'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>2, 'img_path' => '/images/gold/cincinpolos.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Bangle Huruf T','weight'=>2.2, 'user_id'=>1,'gold_carat_category_id'=>2,'shelf_id'=>2,'img_path' => '/images/gold/gelang-bangle-huruft.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Rantai Biji Double','weight'=>2.8, 'user_id'=>1,'gold_carat_category_id'=>4,'shelf_id'=>2,'img_path' => '/images/gold/gelang-biji-double.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],

            ['name'=>'Gelang Biji Sambung','weight'=>8, 'user_id'=>1,'gold_carat_category_id'=>2,'shelf_id'=>3,'img_path' => '/images/gold/gelang-biji.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Biji Lada','weight'=>5.2, 'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>3,'img_path' => '/images/gold/gelang-biji2.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Bola Mata','weight'=>4.7, 'user_id'=>1,'gold_carat_category_id'=>1,'shelf_id'=>3,'img_path' => '/images/gold/gelang-bola-mata.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Bunga','weight'=>2.8, 'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>3,'img_path' => '/images/gold/gelang-bunga.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Cartier Warna','weight'=>4.4, 'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>3,'img_path' => '/images/gold/gelang-cartier-warna.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Hitam','weight'=>7, 'user_id'=>1,'gold_carat_category_id'=>4,'shelf_id'=>3,'img_path' => '/images/gold/Gelang-Hitam.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Ikan','weight'=>2.3, 'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>3,'img_path' => '/images/gold/gelang-ikan.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Kupu-Kupu','weight'=>4, 'user_id'=>1,'gold_carat_category_id'=>2,'shelf_id'=>3,'img_path' => '/images/gold/gelang-kupukupu.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],

            ['name'=>'Gelang Patah-patah','weight'=>10, 'user_id'=>1,'gold_carat_category_id'=>2,'shelf_id'=>4,'img_path' => '/images/gold/gelang-patah-patah.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Putih Aurel','weight'=>12, 'user_id'=>1,'gold_carat_category_id'=>4,'shelf_id'=>4,'img_path' => '/images/gold/gelang-putih-aurel.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Serut','weight'=>2.3, 'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>4,'img_path' => '/images/gold/gelang-serut.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Sisik Naga','weight'=>17, 'user_id'=>1,'gold_carat_category_id'=>2,'shelf_id'=>4,'img_path' => '/images/gold/gelang-sisik-naga.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Sisik Naga Jepret','weight'=>11.7, 'user_id'=>1,'gold_carat_category_id'=>2,'shelf_id'=>4,'img_path' => '/images/gold/gelang-sisik-naga2.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Sisik Naga Polos','weight'=>5, 'user_id'=>1,'gold_carat_category_id'=>2,'shelf_id'=>4,'img_path' => '/images/gold/gelang-sisik-naga3.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Tiga-Satu','weight'=>4, 'user_id'=>1,'gold_carat_category_id'=>2,'shelf_id'=>4,'img_path' => '/images/gold/gelang-tiga-satu.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang Tinju','weight'=>6.8, 'user_id'=>1,'gold_carat_category_id'=>4,'shelf_id'=>4,'img_path' => '/images/gold/gelang-tinju-putih.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
         
            ['name'=>'Kalung Bebek','weight'=>2.8, 'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>5,'img_path' => '/images/gold/kalung-bebek.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Kalung Bola','weight'=>10, 'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>5,'img_path' => '/images/gold/kalung-bola.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Kalung Gelang Delapan','weight'=>7, 'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>5,'img_path' => '/images/gold/kalung-gelang-delapan.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Kalung Liontin Roda','weight'=>10, 'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>5,'img_path' => '/images/gold/kalung-liontin-roda.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Kalung Love','weight'=>5, 'user_id'=>1,'gold_carat_category_id'=>4,'shelf_id'=>5,'img_path' => '/images/gold/kalung-love-putih.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Kalung Mata','weight'=>3.2, 'user_id'=>1,'gold_carat_category_id'=>2,'shelf_id'=>5,'img_path' => '/images/gold/Kalung-mata.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Kalung Set','weight'=>8, 'user_id'=>1,'gold_carat_category_id'=>3,'shelf_id'=>5,'img_path' => '/images/gold/kalungset.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Liontin Mata Merah','weight'=>3, 'user_id'=>1,'gold_carat_category_id'=>4,'shelf_id'=>5,'img_path' => '/images/gold/liontin-mata-merah.jpeg', 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
           ]);
    }
}
