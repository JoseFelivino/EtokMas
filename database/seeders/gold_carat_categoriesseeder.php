<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class gold_carat_categoriesseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('gold_carat_categories')->insert([
            ['carat'=>'6', 'price'=>'350000', 'fee'=>15000,'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['carat'=>'8', 'price'=>'450000', 'fee'=>20000,'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['carat'=>'16', 'price'=>'700000', 'fee'=>30000,'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['carat'=>'17', 'price'=>'750000', 'fee'=>35000,'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['carat'=>'21', 'price'=>'800000', 'fee'=>50000,'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
        ]);
    }
}
