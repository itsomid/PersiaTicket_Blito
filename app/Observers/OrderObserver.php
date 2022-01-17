<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Showtime;
use App\Models\Ticket;
use Vinkla\Hashids\Facades\Hashids;

class OrderObserver
{
    /**
     * Listen to the Order created event.
     *
     * @param  Order $order
     * @return void
     */
    public function created(Order $order)
    {
        $order->status = "pending";
        $order->save();
    }
    /**
     * Listen to the Order updated event.
     *
     * @param  Order $order
     * @return void
     */
    public function updated(Order $order)
    {

    }

}