<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            DB::table('user')->insert([
                'name' => 'Banco Flourish',
                'user_type' =>  'B',
                'email' => 'bank@fakemail.br',
                'password' => Hash::make('123456'),
            ]);
            DB::table('user')->insert([
                'name' => 'Gabriel Barbosa',
                'type' =>  'C',
                'email' => 'user@fakemail.br',
                'password' => Hash::make('123456'),
            ]);
        }
    }
}
