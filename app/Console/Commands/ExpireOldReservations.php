<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ExpireOldReservations extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seeb:res-cleanup {--force}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Expires reservations without a payment in 15 minutes';

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
        //

        $this->info("Detecting orders...");
        $ticket_count = 0;
        $orders = Order::whereStatus('pending')->where('updated_at', '<', Carbon::now()->subMinutes(10)->toDateTimeString())->get();
        $this->info(count($orders)." orders found.");
        if (($this->option('force') || $this->confirm('Do you wish to continue?'))) {
            $bar = $this->output->createProgressBar(count($orders));
            foreach ($orders as $order)
            {
                $this->info('handling order #'.$order->id."($order->uid)");
                $tickets = $order->tickets()->where('status','=','reserved')->get();
                /** @var Ticket $ticket */
                foreach ($tickets as $ticket)
                {
                    $ticket->order_id = null;
                    $ticket->reserved_at = null;
                    $ticket->status = 'available';
                    $ticket->reserved_by_user_id = null;
                    $ticket->save();
                    $ticket_count++;
                }
                $bar->advance();
            }
            $bar->finish();
        }
        \Log::debug("Cleaned up $ticket_count tickets on ".count($orders)." orders at ".Carbon::now()->toDateTimeString());
        $this->info("$ticket_count tickets affected.");


    }

}
