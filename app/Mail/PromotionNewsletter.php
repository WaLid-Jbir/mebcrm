<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PromotionNewsletter extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $name;
    public $title;
    public $coupon;
    public $remise;
    public $lien;
    
    public function __construct($name,$title,$coupon,$remise,$lien)
    {
        $this->name = $name;
        $this->title = $title;
        $this->coupon = $coupon;
        $this->remise = $remise;
        $this->lien = $lien;
    }

    public function build()
    {
        return $this->view('email.promotion-newsletter', ['name' => $this->name, 'title' => $this->title, 'excerpt' => $this->coupon, 'remise' => $this->remise, 'lien' => $this->lien])->subject('Les dernières produits et offres spéciales de MonExpertBudget');
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
