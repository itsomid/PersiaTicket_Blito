<?php

namespace App\Console\Commands;

use App\Classes\Seeb\Vendors\SeebTiwall;
use App\Models\Show;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class RefreshExternalShows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seeb:ext-shows {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refreshes external shows with their corresponding API.';

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
        $this->info("Detecting shows...");
        $shows = Show::whereStatus('enabled')->where('source_id',"<>",1)->get();
        $this->info(count($shows)." shows found.");
        if (($this->option('force') || $this->confirm('Do you wish to continue?'))) {
            $bar = $this->output->createProgressBar(count($shows));
            foreach ($shows as $show)
            {
                switch ($show->source_id) {
                    case 2:
                        //Tiwall
                        $st = new SeebTiwall();

                        try {
                            $st->importShow($show->source_details['urn'], $show->category_id, $show->city_id);
                        } catch (\Exception $e)
                        {

                        }

                        break;
                }
                $bar->advance();
            }
            $bar->finish();
        }
        \Log::debug("Refreshed ".count($shows)." external shows at ".Carbon::now()->toDateTimeString());
    }
}
