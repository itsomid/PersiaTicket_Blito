<?php

use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $promotion = new Promotion();
        $promotion->code = "nowruz97";
        $promotion->constant_discount = 1750;
        $promotion->percent_discount = 0.12;
        $promotion->status = 'enabled';
        $promotion->usage_count = -1;
        $promotion->until_date = Carbon::now()->addDays(20);
        $promotion->save();

        $promotion2 = new Promotion();
        $promotion2->code = "simorgh";
        $promotion2->constant_discount = 0;
        $promotion2->percent_discount = 0.50;
        $promotion2->until_date = Carbon::now()->addDays(25);
        $promotion2->show_id = 3;
        $promotion2->usage_count = 3;
        $promotion2->status = 'enabled';
        $promotion2->save();
    }
}
