<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PdfController extends AbstractController
{
    #[Route('/pdf/{totalPrix}/{userEmail}/{userNom}/{userPrenom}/{userAdress}/{userVille}/{userZipCode}', name: 'app_pdf')]
    public function generatePdf($totalPrix, $userEmail, $userNom, $userPrenom, $userAdress, $userVille, $userZipCode): Response
    {
        $html = $this->renderView('pdf/templatePdf.html.twig', [
            'totalPrix' => $totalPrix,
            'userEmail' => $userEmail,
            'userNom' => $userNom,
            'userPrenom' => $userPrenom,
            'userAdress' => $userAdress,
            'userVille' => $userVille,
            'userZipCode' => $userZipCode

            // Optional: Pass any data needed for rendering
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
