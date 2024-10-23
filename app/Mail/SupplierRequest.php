<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SupplierRequest extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected $supplier,
        protected $markdown_table_commitsNeeded,
        protected $markdown_table_dueThisWeek,
        protected $lineChanges,
        protected $commitsNeeded,
        protected $dueThisWeek
    )
    {
        //
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Help Needed',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.supplierrequest',
            with:[
                'supplier'=>$this->supplier,
                'table_commitsNeeded'=>$this->markdown_table_commitsNeeded,
                'table_dueThisWeek'=>$this->markdown_table_dueThisWeek,
                'lineChanges'=>$this->lineChanges,
                'commitsNeeded'=>$this->commitsNeeded,
                'dueThisWeek'=>$this->dueThisWeek
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
