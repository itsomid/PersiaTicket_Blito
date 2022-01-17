<?php

use Illuminate\Database\Seeder;
use \App\Models\City;
class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        City::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        City::create(['name' => 'تهران', 'country_code' => 'IR']);
        City::create(['name' => 'اصفهان', 'country_code' => 'IR']);
        City::create(['name' => 'شیراز', 'country_code' => 'IR']);
        City::create(['name' => 'مشهد', 'country_code' => 'IR']);
    }
}
