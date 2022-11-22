<?php

namespace App\Service;

use Dompdf\Dompdf;
use Dompdf\Options;

class PDFService
{
    private $domPDF;
    public function __construct()
    {
        $this->domPDF = new Dompdf();

        $options = new Options();
        $options->set('defaultFont', 'Courier');

        $this->domPDF->setOptions($options);
    }

    public function showPDF($html)
    {
        $this->domPDF->loadHtml($html);

        // (Optional) Setup the paper size and orientation
        $this->domPDF->setPaper('A4', 'landscape');

        // Render the HTML as PDF
        $this->domPDF->render();

        // Output the generated PDF to Browser
        $this->domPDF->stream("details.pdf", [
            'Attachement' => false
        ]);
    }

    public function generateBinaryPDF($html)
    {
        $this->domPDF->loadHtml($html);
        $this->domPDF->setPaper('A4', 'landscape');
        $this->domPDF->output();
    }
}
