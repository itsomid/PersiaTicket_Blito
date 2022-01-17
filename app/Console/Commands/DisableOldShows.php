<?php

namespace App\Console\Commands;

use App\Models\Show;
use App\Models\Showtime;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DisableOldShows extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seeb:show-cleanup {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Disables old shows without an incoming showtime';

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
        $shows = Show::whereStatus('enabled')->where('to_date', '<', Carbon::now()->toDateTimeString())->get();

        $this->info(count($shows)." shows found.");
        if (($this->option('force') || $this->confirm('Do you wish to continue?'))) {
            $bar = $this->output->createProgressBar(count($shows));
            foreach ($shows as $show)
            {
                $show->status = 'disabled';
                $show->save();
                $bar->advance();
            }
            $bar->finish();
        }
        \Log::debug("Cleaned up ".count($shows)." expired shows at ".Carbon::now()->toDateTimeString());
        $this->info("Detecting showtimes...");
        $showtimes = Showtime::whereStatus('enabled')->where('datetime', '<', Carbon::now()->toDateTimeString())->get();

        $this->info(count($shows)." showtimes found.");
        if (($this->option('force') || $this->confirm('Do you wish to continue?'))) {
            $bar = $this->output->createProgressBar(count($shows));
            foreach ($showtimes as $showtime)
            {
                $showtime->status = 'disabled';
                $showtime->save();
                $bar->advance();
            }
            $bar->finish();
        }
        \Log::debug("Cleaned up ".count($showtimes)." expired showtimes at ".Carbon::now()->toDateTimeString());
        $this->info(count($showtimes)." showtimes affected.");

    }
}
