<?php
require_once '../vendor/autoload.php';
use Dompdf\Dompdf; 
// Reference the Dompdf namespace 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $html = $_POST['html'] ?? '';
    $confirmationNumber = $_POST['confirmationNumber'] ?? '';
    try {
        // Instantiate the dompdf class 
        $dompdf = new Dompdf();

        // Load HTML content 
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 
        $dompdf->setPaper('letter', 'portrait');

        // Render the HTML as PDF 
        $dompdf->render();

        // Output the generated PDF
        $pdfContent = $dompdf->output();

        // Send the generated PDF as a response
        header('Content-Type: application/pdf');
        $filename = "BookingConfirmation#" . $confirmationNumber;
        header('Content-Disposition: attachment; filename=$filename');
        echo $pdfContent;
        exit();
    } catch (\Exception $e) {
        echo 'Error generating PDF: ' . $e->getMessage();
    }
}
?>