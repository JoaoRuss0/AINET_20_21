<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OrderClosed extends Mailable
{
    use Queueable, SerializesModels;

    public $order;
    public $items;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($encomenda, $items)
    {
        $this->order = $encomenda;
        $this->items = $items;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
        ->from('noreply@magicshirts.pt')
        ->subject("Order closed")
        ->markdown('emails.order-closed');
    }
}
