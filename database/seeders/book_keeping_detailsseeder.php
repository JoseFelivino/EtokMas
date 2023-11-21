<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class book_keeping_detailsseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book_keeping_details')->insert([
            //already kept in bookkeeping
            ['book_keeping_header_id'=>1, 'gold_id'=>1, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-03 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>1, 'gold_id'=>2, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-04 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>1, 'gold_id'=>3, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-05 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>1, 'gold_id'=>4, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-06 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>1, 'gold_id'=>4, 'quantity' => 1, 'isAddition' => true, 'created_at' => \Carbon\Carbon::parse('2022-02-07 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            
            ['book_keeping_header_id'=>2, 'gold_id'=>5, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-08 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>2, 'gold_id'=>6, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-09 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>2, 'gold_id'=>7, 'quantity' => 1, 'isAddition' => true, 'created_at' => \Carbon\Carbon::parse('2022-02-12 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>2, 'gold_id'=>8, 'quantity' => 1, 'isAddition' => true, 'created_at' => \Carbon\Carbon::parse('2022-02-13 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 

            ['book_keeping_header_id'=>3, 'gold_id'=>9, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-03 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>3, 'gold_id'=>10, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-04 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>3, 'gold_id'=>10, 'quantity' => 1, 'isAddition' => true, 'created_at' => \Carbon\Carbon::parse('2022-02-05 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            
            ['book_keeping_header_id'=>4, 'gold_id'=>19, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-03 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>4, 'gold_id'=>20, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-04 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>4, 'gold_id'=>20, 'quantity' => 1, 'isAddition' => true, 'created_at' => \Carbon\Carbon::parse('2022-02-05 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            
            ['book_keeping_header_id'=>5, 'gold_id'=>27, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-03 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>5, 'gold_id'=>28, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-04 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            
            
            //not in yet
            
            ['book_keeping_header_id'=>null, 'gold_id'=>7, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-15 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>null, 'gold_id'=>8, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-16 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>null, 'gold_id'=>8, 'quantity' => 1, 'isAddition' => true, 'created_at' => \Carbon\Carbon::parse('2022-02-17 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            
            ['book_keeping_header_id'=>null, 'gold_id'=>11, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-08 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>null, 'gold_id'=>12, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-09 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>null, 'gold_id'=>12, 'quantity' => 1, 'isAddition' => true, 'created_at' => \Carbon\Carbon::parse('2022-02-10 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            
            ['book_keeping_header_id'=>null, 'gold_id'=>17, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-08 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>null, 'gold_id'=>18, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-09 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            
            ['book_keeping_header_id'=>null, 'gold_id'=>25, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-08 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>null, 'gold_id'=>26, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-09 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            
            ['book_keeping_header_id'=>null, 'gold_id'=>33, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-08 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>null, 'gold_id'=>34, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-09 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>null, 'gold_id'=>35, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-10 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['book_keeping_header_id'=>null, 'gold_id'=>36, 'quantity' => 1, 'isAddition' => false, 'created_at' => \Carbon\Carbon::parse('2022-02-11 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 

           ]);
    }
}
