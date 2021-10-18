<?php

namespace AporteWeb\Dashboard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class ContactMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $data;
    protected $cart;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $cart)
    {
        $this->data = $data;
        $this->cart = $cart;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        // ini_set('max_execution_time', 0);
        $email = $this->view('Dashboard::emails.contact-message')
            ->with([
                'data' => $this->data,
                'cart' => $this->cart,
            ]);
        if ($this->data['type'] == 'budget') {
            $email = $email->subject('Mensaje de presupuesto');
        }
        if ($this->data['type'] == 'contact-message') {
            $email = $email->subject('Mensaje de contacto');
        }
        /*foreach ($this->purchase->attached as $file) {
            $email = $email->attach(public_path() . '/' . Storage::url($file));
        }*/
        return $email;
    }
}
