<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CitiesTableSeeder::class);
        $this->call(CategoriesTableSeeder::class);
        $this->call(SourcesTableSeeder::class);
//        $this->call(SceneSeeder::class);
//        $this->call(ShowSeeder::class);
        //$this->call(TestDataSeeder::class);

    }
}
