<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        {
            DB::table('user')->insert([
                'name' => 'Gabriel Barbosa',
                'user_type' =>  'C',
                'email' => 'user@fakemail.br',
                'password' => Hash::make('123456'),
            ]);
            DB::table('level')->insert([
                'name' => 'Baby',
                'min_score' =>  0,
            ]);

            DB::table('level')->insert([
                'name' => 'Child',
                'min_score' =>  800,
            ]);

            DB::table('level')->insert([
                'name' => 'Teen',
                'min_score' =>  2000,
            ]);

            DB::table('level')->insert([
                'name' => 'Major',
                'min_score' =>  3500,
            ]);

            DB::table('level')->insert([
                'name' => 'Senior',
                'min_score' =>  5000,
            ]);
            DB::table('bank')->insert([
                'user_id' => 1,
                'code' =>  701,
            ]);
            DB::table('customer')->insert([
                'user_id' => 2,
                'bank_id' =>  1,
                'balance' => 230,
                'level_id' => 1,
            ]);
            DB::table('option')->insert([
                'level_id' => 1,
                'name' =>  'Poupança',
                'option_type' => "F",
            ]);
    
            DB::table('option')->insert([
                'level_id' => 2,
                'name' =>  'Tesouro',
                'option_type' => "F",
            ]);
    
            DB::table('option')->insert([
                'level_id' => 3,
                'name' =>  'Fundos de Investimentos',
                'option_type' => "V",
            ]);
    
            DB::table('option')->insert([
                'level_id' => 4,
                'name' =>  'Ações',
                'option_type' => "V",
            ]);
    
            DB::table('option')->insert([
                'level_id' => 4,
                'name' =>  'Fundos Imobiliários',
                'option_type' => "V",
            ]);
    
            DB::table('option')->insert([
                'level_id' => 5,
                'name' =>  'Criptomoedas',
                'option_type' => "V",
            ]);
    
            DB::table('option')->insert([
                'level_id' => 5,
                'name' =>  'Stablecoins',
                'option_type' => "V",
            ]);
        }
    }
}
