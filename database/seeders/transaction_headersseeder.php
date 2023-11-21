<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class transaction_headersseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('transaction_headers')->insert([ 
            ['customer_Id'=>'1','user_Id'=>'1','created_at' => \Carbon\Carbon::parse('2022-02-03 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['customer_Id'=>'2','user_Id'=>'2','created_at' => \Carbon\Carbon::parse('2022-02-04 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['customer_Id'=>'3','user_Id'=>'1','created_at' => \Carbon\Carbon::parse('2022-02-05 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['customer_Id'=>'4','user_Id'=>'2','created_at' => \Carbon\Carbon::parse('2022-02-06 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['customer_Id'=>'5','user_Id'=>'1','created_at' => \Carbon\Carbon::parse('2022-02-08 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['customer_Id'=>'1','user_Id'=>'2','created_at' => \Carbon\Carbon::parse('2022-02-09 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['customer_Id'=>'2','user_Id'=>'1','created_at' => \Carbon\Carbon::parse('2022-02-10 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['customer_Id'=>'3','user_Id'=>'2','created_at' => \Carbon\Carbon::parse('2022-02-11 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['customer_Id'=>'4','user_Id'=>'2','created_at' => \Carbon\Carbon::parse('2022-02-15 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['customer_Id'=>'5','user_Id'=>'2','created_at' => \Carbon\Carbon::parse('2022-02-16 1:00:00'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
        ]);
    }
}
