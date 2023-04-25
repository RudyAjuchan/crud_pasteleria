<?php
require('invoice.php');
require("letras.php");
$pdf = new PDF_Invoice( 'P', 'mm', 'A4' );
$pdf->AddPage();
$pdf->Image('http://http://ubereatsgt2.ibx.lat//sistema_zapateria/assets/img/logo_fact.png',10,10,50);
$pdf->addSociete( utf8_decode("Sistema Zapatería"),
                  "1ra calle 2-35 zona 5 Chimaltenango\n" .
                  "Venta de zapatos\n".
                  "Todo tipo de calzado\n");
$pdf->fact_dev( "No. 00001",'Recibo serie " B"' );
$pdf->addDate(date("d/m/y"));
$pdf->addClient("CL01");
$pdf->addPageNumber("1");
$pdf->addClientAdresse(utf8_decode("Nombre: Rudy Misael Ajuchán\nDirección: 1ra calle 8-25 zona 5 sumpango\nTelefono: 2930-2039\nNIT: 9568439-5"));
$pdf->addReglement("Verificar al recibir la factura");
$pdf->addEcheance(date("d/m/y"));
$cols=array( utf8_decode("CÓDIGO")    => 16,
             utf8_decode("DESCRIPCIÓN")  => 85,
             "CANTIDAD"     => 22,
             "P. UNITARIO"      => 33,
             "TOTAL" => 34);
$pdf->addCols( $cols);
$cols=array( utf8_decode("CÓDIGO")    => 'C',
             utf8_decode("DESCRIPCIÓN")  => 'L',
             "CANTIDAD"     => 'C',
             "P. UNITARIO"      => 'R',
             "TOTAL" => 'R');
$pdf->addLineFormat( $cols);
$y    = 109;
$line=array( utf8_decode("CÓDIGO")    => '1',
             utf8_decode("DESCRIPCIÓN")  => utf8_decode('Laptop asus vivobook core i5 8va HDD 1T 8GB ram 8h autonomía'),
             "CANTIDAD"     => '1',
             "P. UNITARIO"      => 'Q. 5000',
             "TOTAL" => 'Q. 5000');
$size = $pdf->addLine( $y, $line );
$y   += $size + 2;
$line=array( utf8_decode("CÓDIGO")    => '1',
             utf8_decode("DESCRIPCIÓN")  => utf8_decode('Laptop asus vivobook core i5 8va HDD 1T 8GB ram 8h autonomía'),
             "CANTIDAD"     => '1',
             "P. UNITARIO"      => 'Q. 5000',
             "TOTAL" => 'Q. 5000');
$size = $pdf->addLine( $y, $line );

$pdf->RoundedRect(10, 257, 120, 20, 4, '13', 'DF');
$pdf->setXY(52,260);
$pdf->SetFont('Arial','B',12);
$pdf->Write(1,"Cifras en letras");
$pdf->setXY(12,266);
$pdf->SetFont('Arial','',11);

//conversion a letras
$totalpagar=1990.15;
$v=new CifrasEnLetras(); 
$letra=($v->convertirEurosEnLetras($totalpagar));
//fin conversion
$pdf->Write(1,utf8_decode($letra));

$pdf->setXY(150 ,258);
$pdf->RoundedRect(148, 257, 50, 20, 4, '13', 'DF');
$pdf->Line(167,277,167,257);
$pdf->setXY(149,261);
$pdf->SetFont('Arial','',8);
$pdf->Write(1,"total sin iva");
$pdf->setXY(149,266);
$pdf->Write(1,"iva");
$pdf->setXY(149,271);
$pdf->Write(1,"total a pagar");

$pdf->setXY(170,261);
$pdf->Write(1,"Q. 100.00");
$pdf->setXY(170,266);
$pdf->Write(1,"Q. 100.00");
$pdf->setXY(170,271);
$pdf->Write(1,"Q. 100.00");
$pdf->Output();
?>