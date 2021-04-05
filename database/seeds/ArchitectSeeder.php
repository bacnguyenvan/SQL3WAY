<?php

use Illuminate\Database\Seeder;

class ArchitectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       $faker = Faker\Factory::create('vi_VN');

        for($i = 0 ; $i < 500 ; $i ++ ){
        	DB::table('architect')->insert([
        		'name' => $faker->name,
        		'birthday' => rand(1960,2000),
        		'sex' => rand(0,1),
        		'place' => $faker->city,
        		'address' => $faker->address,
        	]);
        }
    }
}
