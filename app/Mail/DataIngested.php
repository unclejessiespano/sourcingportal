<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DataIngested extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        protected $date,
        protected $markdown_table_percentPastDueSuppliers,
        protected $markdown_table_percentCommitsSuppliers,
        protected $lineChanges,
        protected $summary
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
            subject: 'Data Ingested',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.dataingested',
            with:[
                'date'=>$this->date,
                'table_percentPastDueSuppliers'=>$this->markdown_table_percentPastDueSuppliers,
                'table_percentCommitsSuppliers'=>$this->markdown_table_percentCommitsSuppliers,
                'lineChanges'=>$this->lineChanges,
                'summary'=>$this->summary
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
