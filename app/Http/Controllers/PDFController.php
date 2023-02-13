<?php

namespace App\Http\Controllers;

use App\Mail\MebMail;
use App\Models\Adherant;
use App\Models\Envolope;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;
use App\Models\Prospect;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str; 

class PDFController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */


    public function index($id)
    {
        $prospect=Adherant::findOrFail($id);

        //send id to fillPDFFile() func

        $prospect_id = $prospect->id;

        $filePath = public_path("model.pdf");
        $outputFilePath = public_path('contracts/'.'MonExpertBudget-'.$prospect->nom.'-'.str_replace(['-',':',' '], '', $prospect->updated_at).'.'."pdf");
        $pdf_name = 'MonExpertBudget-'.$prospect->nom.'-'.str_replace(['-',':',' '], '', $prospect->updated_at).'.'."pdf";
        //dd($pdf_name);
        $this->fillPDFFile($filePath, $outputFilePath, $prospect_id);

        // Create Envolope in DB.
        if(Envolope::where('adherant_id', $prospect_id)->exists() == false){
            Envolope::create([
                'name' => $pdf_name,
                'adherant_id' => $prospect_id,
            ]);
        }

        //Mail::to($prospect->email)->send(new MebMail($outputFilePath));

        return response()->file($outputFilePath);
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    public function fillPDFFile($file, $outputFilePath, $id)
    {
        // $id=1;
        $prospect=Adherant::findOrFail($id);

        $fpdi = new FPDI;
        
        $count = $fpdi->setSourceFile($file);
        

        $template = $fpdi->importPage(1);
        $size = $fpdi->getTemplateSize($template);
        $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
        $fpdi->useTemplate($template);

        $fpdi->SetFont("helvetica", "", 7);
        $fpdi->SetTextColor(0,0,0);
        $left = 123;
        $top = 7;
        $text = Str::ucfirst('Reference: '). str_replace(['-',':',' '], '', $prospect->created_at);
        $fpdi->Text($left,$top,$text);
        
        if(($prospect->civilite)=='mme'){
            
            $fpdi->SetFont("helvetica", "B", 15);
            $fpdi->SetTextColor(0,0,0);
            $left = 78.7;
            $top = 77.7;
            $text = 'X';
            $fpdi->Text($left,$top,$text);
        }
        else{ 
            $fpdi->SetFont("helvetica", "B", 15);
            $fpdi->SetTextColor(0,0,0);
            $left = 43.2;
            $top = 77.7;
            $text = 'X';
            $fpdi->Text($left,$top,$text);
        }
        
        $fpdi->SetFont("helvetica", "B", 10);
        $fpdi->SetTextColor(0,0,0);
        $left = 37;
        $top = 89;
        $text = Str::ucfirst($prospect->nom);
        $fpdi->Text($left,$top,$text);

        $fpdi->SetFont("helvetica", "B", 10);
        $fpdi->SetTextColor(0,0,0);
        $left = 122;
        $top = 89;
        $text = Str::ucfirst($prospect->prenom);
        $fpdi->Text($left,$top,$text);
            
        $fpdi->SetFont("helvetica", "B", 10);
        $fpdi->SetTextColor(0,0,0);
        $left = 40;
        $top = 99.5;
        $text = Str::ucfirst($prospect->adresse);
        $fpdi->Text($left,$top,$text);

        $fpdi->SetFont("helvetica", "B", 10);
        $fpdi->SetTextColor(0,0,0);
        $left = 45;
        $top = 107;
        $text = Str::ucfirst($prospect->zip);
        $fpdi->Text($left,$top,$text);

        $fpdi->SetFont("helvetica", "B", 10);
        $fpdi->SetTextColor(0,0,0);
        $left = 43;
        $top = 117;
        $text = Str::ucfirst($prospect->telephone);
        $fpdi->Text($left,$top,$text);

        $fpdi->SetFont("helvetica", "B", 10);
        $fpdi->SetTextColor(0,0,0);
        $left = 103;
        $top = 117;
        $text = Str::ucfirst($prospect->fixe);
        $fpdi->Text($left,$top,$text);
        
        $fpdi->SetFont("helvetica", "B", 10);
        $fpdi->SetTextColor(0,0,0);
        $left = 40;
        $top = 129;
        $text = Str::lcfirst($prospect->email);
        $fpdi->Text($left,$top,$text);
        
        $fpdi->SetFont("helvetica", "B", 10);
        $fpdi->SetTextColor(0,0,0);
        $left = 45;
        $top = 152.7;
        $text = Str::ucfirst($prospect->civilite.' '.$prospect->nom.' '.$prospect->prenom,);
        $fpdi->Text($left,$top,$text);
        
        $fpdi->SetFont("helvetica", "B", 10);
        $fpdi->SetTextColor(0,0,0);
        $left = 74;
        $top = 247;
        $text = '180 EUR';
        $fpdi->Text($left,$top,$text);

        //Extract number from text
        $infob = $prospect->infobank->prelevement;
        $info_int = (int) filter_var($infob, FILTER_SANITIZE_NUMBER_INT);
        
        $fpdi->SetFont("helvetica", "B", 10);
        $fpdi->SetTextColor(0,0,0);
        $left = 133;
        $top = 247;
        $text = $info_int;
        $fpdi->Text($left,$top,$text);
        
        $fpdi->SetFont("helvetica", "B", 10);
        $fpdi->SetTextColor(0,0,0);
        $left = 38;
        $top = 258.4;
        $text = 'Paris';
        $fpdi->Text($left,$top,$text);
        
        $fpdi->SetFont("helvetica", "B", 10);
        $fpdi->SetTextColor(0,0,0);
        $left = 94;
        $top = 258.4;
        $text = Str::ucfirst($prospect->updated_at->format('d/m/Y'));
        $fpdi->Text($left,$top,$text);
        
        
        for ($i=2; $i<=$count; $i++) {

            $template = $fpdi->importPage($i);
            $size = $fpdi->getTemplateSize($template);
            $fpdi->AddPage($size['orientation'], array($size['width'], $size['height']));
            $fpdi->useTemplate($template);
        }


        return $fpdi->Output($outputFilePath, 'F');

    }

}