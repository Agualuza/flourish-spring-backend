<?php

use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            DB::table('bank')->insert([
                'user_id' => 1,
                'code' =>  701,
            ]);
        }
    }
}
