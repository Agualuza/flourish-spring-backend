<?php

use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            DB::table('customer')->insert([
                'user_id' => 2,
                'bank_id' =>  1,
                'balance' => 230,
                'level_id' => 1,
            ]);
        }
    }
}
