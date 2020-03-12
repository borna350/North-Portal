<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ExpenseCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $data, $isUpdate;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $isUpdate)
    {
        $this->data = $data;
        $this->isUpdate = $isUpdate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.expense.notify')->subject('Expense')->with(['data' => $this->data, 'isUpdate' => $this->isUpdate]);
    }
}
