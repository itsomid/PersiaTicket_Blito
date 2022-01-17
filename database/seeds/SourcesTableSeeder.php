<?php

use Illuminate\Database\Seeder;

class SourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Source::create([
            'title' => 'Persia Ticket',
            'owner_id' => 1
        ]);
        \App\Models\Source::create([
            'title' => 'Tiwall',
            'owner_id' => 1
        ]);
    }
}
