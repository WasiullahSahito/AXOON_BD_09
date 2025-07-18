<?php
namespace App\Mail;

use App\Models\Order; // Import the Order model
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderPlaced extends Mailable
{
    use Queueable, SerializesModels;

    public $order; // Declare a public property to hold the Order instance

    /**
     * Create a new message instance.
     */
    public function __construct(Order $order) // Type-hint the Order model
    {
        $this->order = $order; // Assign the passed Order to the public property
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Order Has Been Placed! - Order #' . $this->order->id, // Use the order ID in the subject
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.orders.placed', // Use 'markdown' for a Markdown email, specify the path to your Blade template
            with: [
                'order' => $this->order, // Pass the order object to the view
            ],
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
