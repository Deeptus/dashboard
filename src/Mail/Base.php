<?php

namespace AporteWeb\Dashboard\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Schema;
use App\Models\Purchase;

class Base extends Mailable
{
    use Queueable, SerializesModels;

    private $layout = null;
    private $data   = [];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($layout, $data, $components)
    {
        $this->layout     = $layout;
        $this->data       = $data;
        $this->components = $components;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        //dd(['hasta aqui', $this->data]);
        $body = $this->layout->body;
        if (array_key_exists('client', $this->data) && $this->data['client']) {
            foreach ($this->data['client']->getAttributes() as $var_key => $var_value) {
                $body = str_replace("_client_" . $var_key . "_", $var_value, $body);
            }
        }
        if (array_key_exists('purchase', $this->data) && $this->data['purchase']) {
            // dd(Purchase::find($this->data['purchase']->id));
            // Not working
            // $columns = $this->data['purchase']->getAttributes();
            $columns = Schema::getColumnListing($this->data['purchase']->getTable());
            foreach ($columns as $column_name) {
                $body = str_replace("_purchase_" . $column_name . "_", $this->data['purchase']->{$column_name}, $body);
            }
        }
        foreach ($this->components as $var_key => $var_value) {
            $body = str_replace($var_key, $var_value, $body);
        }
        $this->image_logo_cid = \Swift_DependencyContainer::getInstance()
            ->lookup('mime.idgenerator')
            ->generateId();
        $this->withSwiftMessage(function (\Swift_Message $swift) {
            $image = \Swift_Image::fromPath('images/logo-email-header.png');
            $swift->embed($image->setId($this->image_logo_cid));
        });
        $this->subject($this->layout->subject);
        return $this->markdown('Dashboard::emails.base', [
            'image_logo_cid' => $this->image_logo_cid,
            'body' => $body
        ]);
    }
}
