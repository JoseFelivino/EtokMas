<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class shelvesseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('shelves')->insert([
            ['name' => 'rak1','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'rak2','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'rak3','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'rak4','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name' => 'rak5','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
    ]);
    
    }
}
