<?php

namespace AporteWeb\Dashboard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Storage;

class NewRegisteredClient extends Mailable
{
    use Queueable, SerializesModels;

    protected $client;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($client) {
        $this->client = $client;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        // ini_set('max_execution_time', 0);
        $email = $this->view('Dashboard::emails.new_registered_client')
            ->with([
                'client' => $this->client,
            ])
            ->subject('Nuevo cliente registrado');
        /*foreach ($this->purchase->attached as $file) {
            $email = $email->attach(public_path() . '/' . Storage::url($file));
        }*/
        return $email;

    }
}
