<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class HolidayPeticionManager extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The datas for email.
     *
     * @var Datas
     */
    public $datas;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct( array $datas)
    {
        $this->datas = $datas;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('fuenrob@gmail.com')
                    ->markdown('emails.holiday.manager')
                    ->with([
                        'datas' => $this->datas,
                    ]);
    }
}
