<?php

use Illuminate\Database\Seeder;

class LevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
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
        }
    }
}
