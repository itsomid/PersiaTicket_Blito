<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;

class GetTiwallShows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seeb:tiwall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Latest Events from Tiwall';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // add some shows from Tiwall
        $sT = new \App\Classes\Seeb\Vendors\SeebTiwall();
        $message = "Tiwall - Retrieving Theaters at ".Carbon::now()->toDateTimeString();
        \Log::info($message);
        $this->info($message);
        $categoryLists = $sT->retrieveCategoryList('drama');
        for ($i = 0; $i < count($categoryLists->data); $i++)
        {
            $twShow = $categoryLists->data[$i];
            try
            {
                $sT->importShow($twShow->urn,2);
            }catch (\Exception $exception)
            {
            }

        }
        $message = "Tiwall - ".count($categoryLists->data)." Theaters retrieved at ".Carbon::now()->toDateTimeString();
        \Log::info($message);
        $this->info($message);
        $message = "Tiwall - Retrieving Concerts at ".Carbon::now()->toDateTimeString();
        \Log::info($message);
        $this->info($message);
        $categoryLists = $sT->retrieveCategoryList('concert');
        for ($i = 0; $i < count($categoryLists->data); $i++)
        {
            $twShow = $categoryLists->data[$i];
            try {
                $this->info("retrieving ".$twShow->urn);
                $sT->importShow($twShow->urn,1);
            }catch (\Exception $exception)
            {
                $this->info("error retrieving ".$twShow->urn. " $exception");
            }

        }

        $message = "Tiwall - ".count($categoryLists->data)." Concerts retrieved at ".Carbon::now()->toDateTimeString();
        \Log::info($message);
        $this->info($message);
        $message = "Tiwall - Retrieving Conferences at ".Carbon::now()->toDateTimeString();
        \Log::info($message);
        $this->info($message);
        $categoryLists = $sT->retrieveCategoryList('conference');
        for ($i = 0; $i < count($categoryLists->data); $i++)
        {
            $twShow = $categoryLists->data[$i];
            try{
                $sT->importShow($twShow->urn,3);
            }catch (\Exception $exception)
            {

            }

        }
        $message = "Tiwall - ".count($categoryLists->data)." Conferences retrieved at ".Carbon::now()->toDateTimeString();
        \Log::info($message);
        $this->info($message);
        $this->info('Done :)');
        \Artisan::call('cache:clear');

        return;
    }
}
