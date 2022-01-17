<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketsReady extends Mailable
{
    use Queueable, SerializesModels;

    public $pdf;
    public $order;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order)
    {
        $this->order = $order;
        $html = view('ticket',['tickets' => $order->tickets])->render();
        $pdf = \App::make('snappy.pdf.wrapper');
        $pdf->loadHTML($html);
        $this->pdf = $pdf->inline()->content();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.ticketsready')->subject('بلیت‌های شما')->with(['showtime' => $this->order->tickets[0]->showtime])->attachData($this->pdf, 'Tickets.pdf', [
            'mime' => 'application/pdf',
        ]);
    }
}
