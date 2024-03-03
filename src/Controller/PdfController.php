<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PdfController extends AbstractController
{
    #[Route('/pdf/{totalPrix}', name: 'app_pdf')]
    public function generatePdf($totalPrix): Response
    {
        $html = $this->renderView('pdf/templatePdf.html.twig', [
            'totalPrix' => $totalPrix, // Optional: Pass any data needed for rendering
        ]);
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        $response = new Response($dompdf->output());
        $response->headers->set('Content-Type', 'application/pdf');

        return $response;
    }
}
