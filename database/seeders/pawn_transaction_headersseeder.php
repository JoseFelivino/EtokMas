<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class pawn_transaction_headersseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pawn_transaction_headers')->insert([

            [
                'user_id'=>1,
            'customer_id'=>5,
             'item_price' => 1200000,
             'pawn_transaction_status_id'=>1,
            'deadline_date'=>\Carbon\Carbon::now()->endOfWeek()->format('Y-m-d H:i:s'),
              'loan_price' => 600000,
             'return_price' => 604800,
             'interest_total'=>0.8,
             'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],

            [
                'user_id'=>1,
            'customer_id'=>3,
             'item_price' => 9600000,
             'pawn_transaction_status_id'=>2,
            'deadline_date'=>\Carbon\Carbon::now()->endOfMonth()->format('Y-m-d H:i:s'),
              'loan_price' => 4800000,
             'return_price' => 4876800,
             'interest_total'=>1.6,
             'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],

            [
                'user_id'=>4,
            'customer_id'=>4,
             'item_price' => 1200000,
             'pawn_transaction_status_id'=>2,
            'deadline_date'=>\Carbon\Carbon::now()->endOfMonth()->format('Y-m-d H:i:s'),
              'loan_price' => 600000,
             'return_price' => 604800,
             'interest_total'=>0.8,
             'created_at' => \Carbon\Carbon::yesterday()->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],

            [
                'user_id'=>4,
            'customer_id'=>2,
             'item_price' => 9600000,
             'pawn_transaction_status_id'=>2,
            'deadline_date'=>\Carbon\Carbon::now()->endOfWeek()->format('Y-m-d H:i:s'),
              'loan_price' => 4800000,
             'return_price' => 4876800,
             'interest_total'=>1.6,
             'created_at' => \Carbon\Carbon::yesterday()->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],

            [
                'user_id'=>4,
            'customer_id'=>1,
             'item_price' => 4000000,
             'pawn_transaction_status_id'=>2,
            'deadline_date'=>\Carbon\Carbon::now()->endOfMonth()->format('Y-m-d H:i:s'),
              'loan_price' => 2000000,
             'return_price' => 2024000,
             'interest_total'=>1.2,
             'created_at' => \Carbon\Carbon::yesterday()->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],

            [
                'user_id'=>4,
            'customer_id'=>2,
             'item_price' => 9600000,
             'pawn_transaction_status_id'=>2,
            'deadline_date'=>\Carbon\Carbon::now()->format('Y-m-d H:i:s'),
              'loan_price' => 4800000,
             'return_price' => 4944000,
             'interest_total'=>3,
             'created_at' => \Carbon\Carbon::now()->subDays(15)->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],

            [
                'user_id'=>4,
            'customer_id'=>1,
             'item_price' => 4000000,
             'pawn_transaction_status_id'=>1,
            'deadline_date'=>\Carbon\Carbon::now()->addDays(1)->format('Y-m-d H:i:s'),
              'loan_price' => 2000000,
             'return_price' => 2044000,
             'interest_total'=>2.2,
             'created_at' => \Carbon\Carbon::now()->subDays(10)->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')
            ],

            [
                'user_id'=>3,
            'customer_id'=>2,
             'item_price' => 900000,
             'pawn_transaction_status_id'=>2,
            'deadline_date'=>\Carbon\Carbon::now()->addDays(2)->format('Y-m-d H:i:s'),
              'loan_price' => 400000,
             'return_price' => 405600,
             'interest_total'=>1.4,
             'created_at' => \Carbon\Carbon::now()->subDays(5)->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()
            ],

            [
                'user_id'=>3,
            'customer_id'=>2,
             'item_price' => 21000000,
             'pawn_transaction_status_id'=>2,
            'deadline_date'=>\Carbon\Carbon::now()->addDays(7)->format('Y-m-d H:i:s'),
              'loan_price' => 10000000,
             'return_price' => 10360000,
             'interest_total'=>3.6,
             'created_at' => \Carbon\Carbon::now()->subDays(11)->format('Y-m-d H:i:s'),
            'updated_at' => \Carbon\Carbon::now()
            ],            

           ]);
    }
}
