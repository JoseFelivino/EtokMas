<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class transaction_detailsseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaction_details')->insert([
            ['transaction_header_id'=>'1','gold_id'=>1, 'quantity'=>1, 'price' => 2030000, 'created_at' => \Carbon\Carbon::parse('2022-02-03 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'1','gold_id'=>9, 'quantity'=>1, 'price' => 1470000, 'created_at' => \Carbon\Carbon::parse('2022-02-03 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'1','gold_id'=>19, 'quantity'=>1, 'price' => 1410000, 'created_at' => \Carbon\Carbon::parse('2022-02-03 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'1','gold_id'=>27, 'quantity'=>1, 'price' => 1610000, 'created_at' => \Carbon\Carbon::parse('2022-02-03 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            
            ['transaction_header_id'=>'2','gold_id'=>2, 'quantity'=>1, 'price' => 1960000, 'created_at' => \Carbon\Carbon::parse('2022-02-04 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'2','gold_id'=>10, 'quantity'=>1, 'price' => 2250000, 'created_at' => \Carbon\Carbon::parse('2022-02-04 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'2','gold_id'=>20, 'quantity'=>1, 'price' => 1960000, 'created_at' => \Carbon\Carbon::parse('2022-02-04 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'2','gold_id'=>28, 'quantity'=>1, 'price' => 7650000, 'created_at' => \Carbon\Carbon::parse('2022-02-04 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            
            ['transaction_header_id'=>'3','gold_id'=>3, 'quantity'=>1, 'price' => 2450000, 'created_at' => \Carbon\Carbon::parse('2022-02-05 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            
            ['transaction_header_id'=>'4','gold_id'=>4, 'quantity'=>1, 'price' => 450000, 'created_at' => \Carbon\Carbon::parse('2022-02-06 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            
            ['transaction_header_id'=>'5','gold_id'=>5, 'quantity'=>1, 'price' => 2025000, 'created_at' => \Carbon\Carbon::parse('2022-02-08 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'5','gold_id'=>11, 'quantity'=>1, 'price' => 300000, 'created_at' => \Carbon\Carbon::parse('2022-02-08 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'5','gold_id'=>17, 'quantity'=>1, 'price' => 3600000, 'created_at' => \Carbon\Carbon::parse('2022-02-08 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'5','gold_id'=>25, 'quantity'=>1, 'price' => 4500000, 'created_at' => \Carbon\Carbon::parse('2022-02-08 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'5','gold_id'=>33, 'quantity'=>1, 'price' => 7000000, 'created_at' => \Carbon\Carbon::parse('2022-02-08 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            
            ['transaction_header_id'=>'6','gold_id'=>6, 'quantity'=>1, 'price' => 2100000, 'created_at' => \Carbon\Carbon::parse('2022-02-09 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'6','gold_id'=>12, 'quantity'=>1, 'price' => 2100000, 'created_at' => \Carbon\Carbon::parse('2022-02-09 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'6','gold_id'=>18, 'quantity'=>1, 'price' => 3640000, 'created_at' => \Carbon\Carbon::parse('2022-02-09 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'6','gold_id'=>26, 'quantity'=>1, 'price' => 9000000, 'created_at' => \Carbon\Carbon::parse('2022-02-09 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['transaction_header_id'=>'6','gold_id'=>34, 'quantity'=>1, 'price' => 4900000, 'created_at' => \Carbon\Carbon::parse('2022-02-09 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            
            ['transaction_header_id'=>'7','gold_id'=>35, 'quantity'=>1, 'price' => 7000000, 'created_at' => \Carbon\Carbon::parse('2022-02-10 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            
            ['transaction_header_id'=>'8','gold_id'=>36, 'quantity'=>1, 'price' => 3750000, 'created_at' => \Carbon\Carbon::parse('2022-02-11 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            
            ['transaction_header_id'=>'9','gold_id'=>7, 'quantity'=>1, 'price' => 585000, 'created_at' => \Carbon\Carbon::parse('2022-02-15 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            
            ['transaction_header_id'=>'10','gold_id'=>8, 'quantity'=>1, 'price' => 1820000, 'created_at' => \Carbon\Carbon::parse('2022-02-16 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            
        ]);
    }
}
