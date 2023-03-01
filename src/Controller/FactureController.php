<?php

namespace App\Controller;

use Dompdf\Dompdf;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\html;

class FactureController extends AbstractController
{
    #[Route('/bookin', name: 'app_facture')]
    public function generatePdf(): Response
    {
            $html = $this->renderView('pdf/document.html.twig', [
            'title' => 'My PDF Document',
            'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
        ]);
                // Create a new Dompdf instance

            $dompdf = new Dompdf();

                   // Load the HTML content into Dompdf
            $dompdf->loadHtml($html);

             // Set the paper size and orientation (optional)
            $dompdf->setPaper('A4', 'landscape');

             // Render the PDF
            $dompdf->render();

            // Generate the response with the PDF content
            $response = new Response();
            $response->setContent($dompdf->output());
            $response->headers->set('Content-Type', 'application/pdf');
            $response->headers->set('Content-Disposition', 'attachment; filename="document.pdf"');

            return $this->render('facture/index.html.twig', [
            'controller_name' => 'FactureController',
        ]);
    }
}
