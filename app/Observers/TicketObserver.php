<?php

namespace App\Observers;

use App\Models\Showtime;
use App\Models\Ticket;
use Vinkla\Hashids\Facades\Hashids;

class TicketObserver
{
    /**
     * Listen to the Ticket created event.
     *
     * @param  Ticket $ticket
     * @return void
     */
    public function created(Ticket $ticket)
    {
        if($ticket->code == '')
        {
            $ticket->code = Hashids::connection('ticket_code')->encode($ticket->id);
            $ticket->save();
        }
    }
    /**
     * Listen to the Ticket updated event.
     *
     * @param  Ticket $ticket
     * @return void
     */
    public function updated(Ticket $ticket)
    {
        \Log::info("ticket $ticket->id updated");
        $cacheKey = Showtime::cacheKey($ticket->showtime_id);
        \Cache::forget($cacheKey);
    }

}