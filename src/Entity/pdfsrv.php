<?php
namespace App\Entity;

use Dompdf\Dompdf;
use Dompdf\Options;

class pdfsrv
{
    private $dompdf;

    public function __construct()
    {
        $this->dompdf = new Dompdf();
        $pdfopt = new Options();
        $pdfopt->set('defaultFont', 'Garamond');
        $this->dompdf->setOptions($pdfopt);
    }

    public function showpdf($html, $data)
    {
        $htmlWithData = $this->replaceDataInHtml($html, $data);
        $this->dompdf->loadHtml($htmlWithData);
        $this->dompdf->render();

        return $this->dompdf->output();
    }

    private function replaceDataInHtml($html, $data)
    {
        foreach ($data as $key => $value) {
            $placeholder = "{{" . $key . "}}";
            $html = str_replace($placeholder, $value, $html);
        }

        return $html;
    }
}
