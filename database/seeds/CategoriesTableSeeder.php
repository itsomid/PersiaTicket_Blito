<?php

use App\Models\Category;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $categories = ['کنسرت','تئاتر','همایش'];
        $slugs = ['concert','theater','event'];

        foreach ($categories as $key => $category)
        {
            $cat = new Category();
            $cat->name = $category;
            $cat->slug = $slugs[$key];
            $cat->save();
        }


        $genres = [
            ['راک',1],
            ['پاپ',1],
            ['سنتی',1],
            ['نواحی',1],
            ['کلاسیک',1],
            ['تلفیقی',1],
            ['نمایش عروسکی',2],
            ['کودک',1],
            ['الکترونیک',1],
            ['کمدی',2],
            ['تراژدی',2],
            ['اجتماعی',2],
        ];

        foreach ($genres as $genre)
        {
            $gen = new Genre();
            $gen->title = $genre[0];
            $gen->category_id = $genre[1];
            $gen->save();
        }
    }
}
