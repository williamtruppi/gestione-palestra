<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExampleMail extends Mailable
{
    use Queueable, SerializesModels;

    public $nome;
    public $testo;
    public $subject;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($nome, $testo, $subject)
    {
        $this->nome = $nome;
        $this->testo = $testo;
        $this->subject = $subject;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('email')
            ->subject($this->subject)
            ->with([
                'nome' => $this->nome,
                'testo' => $this->testo,
            ]);

    }
}
