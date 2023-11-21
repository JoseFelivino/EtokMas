<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class pawn_transaction_statusesseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('pawn_transaction_statuses')->insert([ 
            ['status'=>'done','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['status'=>'undone','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')]
        ]); 
    }
}
