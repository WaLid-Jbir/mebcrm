<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProduitNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $title;
    public $content;
    public $image;
    
    public function __construct($title,$content,$image)
    {
        $this->title = $title;
        $this->content = $content;
        $this->image = $image;
    }

    public function build()
    {
        return $this->view('email.produit-newsletter', ['title' => $this->title, 'excerpt' => $this->content, 'image' => $this->image])->subject('Les dernières produits et offres spéciales de MonExpertBudget');
    }

    // /**
    //  * Get the message envelope.
    //  *
    //  * @return \Illuminate\Mail\Mailables\Envelope
    //  */
    // public function envelope()
    // {
    //     return new Envelope(
    //         subject: 'Newsletter Mail',
    //     );
    // }

    // /**
    //  * Get the message content definition.
    //  *
    //  * @return \Illuminate\Mail\Mailables\Content
    //  */
    // public function content()
    // {
    //     return new Content(
    //         view: 'view.name',
    //     );
    // }

    // /**
    //  * Get the attachments for the message.
    //  *
    //  * @return array
    //  */
    // public function attachments()
    // {
    //     return [];
    // }
}
