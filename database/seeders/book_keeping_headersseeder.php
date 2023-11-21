<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class book_keeping_headersseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('book_keeping_headers')->insert([
            ['shelf_id'=>1, 'scale_weight'=>106.2,'calculation_weight'=>108.75,'from_date'=>\Carbon\Carbon::parse('2022-02-01 1:00:00'),'to_date'=>\Carbon\Carbon::parse('2022-02-07 1:00:00'), 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['shelf_id'=>1, 'scale_weight'=>105.4,'calculation_weight'=>105.6,'from_date'=>\Carbon\Carbon::parse('2022-02-07 1:00:01'),'to_date'=>\Carbon\Carbon::parse('2022-02-14 1:00:00'), 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['shelf_id'=>2, 'scale_weight'=>56.7,'calculation_weight'=>57.5,'from_date'=>\Carbon\Carbon::parse('2022-02-01 1:00:00'),'to_date'=>\Carbon\Carbon::parse('2022-02-07 1:00:00'), 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['shelf_id'=>3, 'scale_weight'=>121.8,'calculation_weight'=>122.3,'from_date'=>\Carbon\Carbon::parse('2022-02-01 1:00:00'),'to_date'=>\Carbon\Carbon::parse('2022-02-07 1:00:00'), 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
            ['shelf_id'=>4, 'scale_weight'=>295.1,'calculation_weight'=>294.6,'from_date'=>\Carbon\Carbon::parse('2022-02-01 1:00:00'),'to_date'=>\Carbon\Carbon::parse('2022-02-07 1:00:00'), 'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')], 
           ]);
    }
}
