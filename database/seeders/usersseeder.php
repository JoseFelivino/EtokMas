<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
class usersseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            ['name'=>'Brainli','email'=>'Brennllp@gmail.com','password'=>\Illuminate\Support\Facades\Hash::make('awdawdawd'),'address'=>'Jl. Kavling Polri, No.101',  'dob'=>\Carbon\Carbon::parse('2003-01-09'), 'role_id'=>1,'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Brainli','email'=>'Brainli506@gmail.com','password'=>\Illuminate\Support\Facades\Hash::make('awdawdawd'),'address'=>'Jl. Kavling Polri, No.101',  'dob'=>\Carbon\Carbon::parse('2003-01-09'), 'role_id'=>2,'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'calvin','email'=>'cafaus.05@gmail.com','password'=>\Illuminate\Support\Facades\Hash::make('123123123'), 'address'=>'Riviera timur, No.80',  'dob'=>\Carbon\Carbon::parse('2001-06-24'), 'role_id'=>1,'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Jose','email'=>'Jose@gmail.com','password'=>\Illuminate\Support\Facades\Hash::make('akupadamu'),'address'=>'Jl. Jelambar Utama X , No.30',  'dob'=>\Carbon\Carbon::parse('2000-01-01'), 'role_id'=>1,'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
            ['name'=>'Abong','email'=>'Bongs@gmail.com','password'=>\Illuminate\Support\Facades\Hash::make('likeyu'),'address'=>'Jalan Sungai Limboto, No.10',  'dob'=>\Carbon\Carbon::parse('2000-07-30'), 'role_id'=>2,'created_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s'),'updated_at' => \Carbon\Carbon::now()->format('Y-m-d H:i:s')],
           ]);
    }
}
