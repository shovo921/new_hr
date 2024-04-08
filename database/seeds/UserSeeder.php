<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Super Admin',
            'mobile_no'=>'01675923371',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
            'type'=>'system',
            'created_at'=>Carbon::now()
        ]);
    }
}
