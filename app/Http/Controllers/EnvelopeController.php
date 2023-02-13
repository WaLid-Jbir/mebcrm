<?php

namespace App\Http\Controllers;

use App\Models\Adherant;
use DocuSign\eSign\Client\ApiClient;
use Illuminate\Support\Facades\Mail;
use DocuSign\Rest\Client;

class EnvelopeController extends Controller
{
    public $args;

    public function createEnvelopeAndSendEmail($id)
    {

        $prospect=Adherant::findOrFail($id);
        
        
        // Create a new envelope in Docusign
        $docusign = new ApiClient();
        $envelopeDefinition = [
            "status" => "sent",
            "emailSubject" => "Sign this document",
            "documents" => [
                [
                    "documentId" => "1",
                    "name" => $prospect->envolopes->name,
                    "fileExtension" => "pdf",
                    "documentBase64" => base64_encode(file_get_contents(public_path('contracts/'.$prospect->envolopes->name)))
                ]
            ],
            "recipients" => [
                "signers" => [
                    [
                        "email" => $prospect->email,
                        "name" => $prospect->nom .' '. $prospect->prenom,
                        "recipientId" => $prospect->id,
                        "tabs" => [
                            "signHereTabs" => [
                                [
                                    "xPosition" => "100",
                                    "yPosition" => "100",
                                    "documentId" => "1",
                                    "pageNumber" => "1"
                                ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        $envelope_api = new \DocuSign\eSign\Api\EnvelopesApi($docusign);
        $envelope = $envelope_api->createEnvelope(env('DOCUSIGN_ACCOUNT_ID'), $envelopeDefinition);
        $envelopeId = $envelope->getEnvelopeId();

        // Generate a unique URL for the envelope
        $baseUrl = "https://demo.docusign.net/signing/";
        $url = $baseUrl . "envelope/" . $envelopeId;

        dd($url);

        // Send the URL to the recipient's email
        // $recipientEmail = "recipient@example.com";
        // Mail::to($recipientEmail)->send(new EnvelopeUrl($url));
    }
}