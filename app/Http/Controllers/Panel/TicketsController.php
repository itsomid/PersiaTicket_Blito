<?php

namespace App\Http\Controllers\Panel;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Showtime;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketsController extends Controller
{
    public function ticketsForShow($showtime_uid)
    {
        $showtime = Showtime::findByUID($showtime_uid);


        $sold = $showtime->tickets()->where('status','sold')->get();
        $disabled = $showtime->tickets()->where('status','disabled')->get();
        $notSold = $showtime->tickets()->whereIn('status',['available','reserved'])->get();
        return view('panel.tickets', ['all' => $showtime->tickets, 'disabled' => $disabled, 'notSold' => $notSold,'sold'=> $sold, 'showtime' => $showtime]);
    }

    public function setDisabled($showtime_uid, Request $request)
    {
        $tickets = explode(',',$request->input('tickets'));

        foreach ($tickets as $ticket_id)
        {
            $ticket = Ticket::find($ticket_id);
            if($ticket->status == 'available'){
                $ticket->status = 'disabled';
                $ticket->save();
            }
        }
        return ['result' => true]; //response()->redirectToRoute('showtime/tickets',['showtime_uid' => $showtime_uid]);
    }
    public function setMine($showtime_uid, Request $request)
    {
        $user = $request->user();
        $tickets = explode(',',$request->input('tickets'));
        $order = Order::createOrderForTickets($tickets,$user,true);
        $payment = new Payment();
        $payment->order_id = $order->id;
        $payment->amount = 0;
        $payment->user_id = $user->id;
        $payment->setDetails(['scheme' => 'persiaticket','own' => true,'reference_id' => '-']);
        $payment->save();
        $payment->setPaid();
        return ['result' => true];
    }
    public function setEnabledWithPrice($showtime_uid, Request $request)
    {
        $tickets = explode(',',$request->input('tickets'));

        foreach ($tickets as $ticket_comp)
        {
            $comp = explode(':',$ticket_comp);
            $ticket = Ticket::find($comp[0]);
            if($ticket->status == 'disabled'){
                $ticket->status = 'available';
                $ticket->price = $comp[1];
                $ticket->save();
            }
        }
        return ['result' => true]; //response()->redirectToRoute('showtime/tickets',['showtime_uid' => $showtime_uid]);
    }
}

