<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class customersseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('customers')->insert([
            ['name'=>'Budiman', 'phone_number'=>'081284222265', 'dob'=>\Carbon\Carbon::parse('2000-07-30'), 'email'=>'Budiman@gmail.com','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Michelle', 'phone_number'=>'088228427590', 'dob'=>\Carbon\Carbon::parse('2000-08-10'), 'email'=>'Mipanzu@gmail.com','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Angel', 'phone_number'=>'088295844300', 'dob'=>\Carbon\Carbon::parse('1997-05-15'), 'email'=>'Angelline@gmail.com','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Dasdas', 'phone_number'=>'081290306635', 'dob'=>\Carbon\Carbon::parse('1992-01-12'), 'email'=>'Dasdas@gmail.com','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Liping', 'phone_number'=>'081281281281', 'dob'=>\Carbon\Carbon::parse('1976-01-12'), 'email'=>'Liping@gmail.com','created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')]
    ]);
    }
}
