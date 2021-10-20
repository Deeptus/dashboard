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
    protected $uploads;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $cart, $uploads)
    {
        $this->data = $data;
        $this->cart = $cart;
        $this->uploads = $uploads;
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
        foreach ($this->uploads as $key => $file) {
            $email = $email->attach(public_path() . '/' . Storage::url($file['path']), [
                'as' => $file['original_name']
            ]);
        }
        return $email;
    }
}
