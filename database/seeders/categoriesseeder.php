<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class categoriesseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            ['name'=>'Kalung','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Cincin','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Gelang','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Anting','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Liontin','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')]
    ]);
    }
}
