<?php

use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       {
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
