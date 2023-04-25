<?php
require 'Controlador.php';

class Reporte extends Controlador{

    public function pasteles(){
        session_start();
        ob_start();
            require 'assets/fpdf/PastelesReporte.php';
            $pdf = new PDF('P','mm','letter');
            $pdf->AliasNbPages();
            $pdf->SetFont('Arial','',14);
            $pdf->AddPage();
            $pdf->GenerarReporte();            
            $pdf->Output();
        ob_end_flush();
    }
}
?>