
<?php
require('Modelo/PastelesModel.php');
require('fpdf.php');

class PDF extends FPDF
{
// Tabla coloreada
function GenerarReporte()
{
    //FONDO
    $this->Image('assets/img/fondo_reporte.jpg','0','0','216','280','JPG');

    //Titulo del reporte
    $consultas=new PastelesModel();
    $datosPasteles=$consultas->buscarPasteles();

    //PARA TITULO
    $this->SetFont('Arial','',18);
    $this->SetTextColor(20);
    $this->setXY(10,20);
    $this->Cell(45,10,"Reporte de pasteles");
    $this->Ln();

    // Colores, ancho de línea y fuente en negrita
    $this->SetFont('Arial','',11);
    $this->SetFillColor(70,167,62);
    $this->SetTextColor(255);
    $this->SetDrawColor(191, 191, 201);
    $this->SetLineWidth(.1);
    $this->SetFont('','B');
    $this->setXY(10,40);

    $this->Cell(10,8,'No',1,0,'C',true);
    $this->Cell(10,8,'Cod',1,0,'C',true);
    $this->Cell(35,8,'Nombre',1,0,'C',true);
    $this->Cell(35,8,utf8_decode('Descripción'),1,0,'C',true);    
    $this->Cell(25,8,'Prep. por',1,0,'C',true);
    $this->Cell(22,8,utf8_decode('F. creación'),1,0,'C',true);
    $this->Cell(22,8,'F. ven',1,0,'C',true);    
    $this->Cell(35,8,'Ingredientes',1,0,'C',true);    
    $this->Ln();

    // Restauración de colores y fuentes
    $this->SetDrawColor(191, 191, 201);
    $this->SetFillColor(225, 228, 242);
    $this->SetTextColor(0);
    $this->SetFont('Arial','',10);

    $this->SetX(10);

    $this->SetWidths(array(10,10,35,35,25,22,22,35));
    $contador=1;
    if($datosPasteles){
        foreach($datosPasteles as $DP){            
            $ingredientes = $consultas->buscarIngredientes($DP['id_pastel']);
            $ingredientesText="";
            foreach($ingredientes as $I){
                $ingredientesText.=$I['nombre']."/";
            }
            $this->Row(array($contador, $DP['id_pastel'],$DP['nombre'],$DP['descripcion'],$DP['preparado_por'],$DP['fecha_creacion'],$DP['fecha_vencimiento'],$ingredientesText));
            $contador++;
        }
    }
    $this->SetFont('Arial','B',10);
    $this->SetTextColor(20);
    $this->setXY(115,250);
    $this->Cell(50,6,utf8_decode("Pastelería Ajuchán: rudyajuchansec32@gmail.com"));
}
var $widths;
var $aligns;

function SetWidths($w)
{
    //Set the array of column widths
    $this->widths=$w;
}

function SetAligns($a)
{
    //Set the array of column alignments
    $this->aligns=$a;
}

function Row($data)
{
    //Calculate the height of the row
    $nb=0;
    for($i=0;$i<count($data);$i++)
        $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
    $h=4*$nb;
    //Issue a page break first if needed
    $this->CheckPageBreak($h);
    //Draw the cells of the row
    for($i=0;$i<count($data);$i++)
    {
        $w=$this->widths[$i];       
        $a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
        //Save the current position
        $x=$this->GetX();
        $y=$this->GetY();
        //Draw the border
        $this->Rect($x,$y,$w,$h);
        //Print the text
        $this->MultiCell($w,4,utf8_decode($data[$i]),0,$a);        
        //Put the position to the right of the cell
        $this->SetXY($x+$w,$y);
    }
    //Go to the next line
    $this->Ln($h);
}

function CheckPageBreak($h)
{
    //If the height h would cause an overflow, add a new page immediately
    if($this->GetY()+$h>$this->PageBreakTrigger)
        $this->AddPage($this->CurOrientation);
}

function NbLines($w,$txt)
{
    //Computes the number of lines a MultiCell of width w will take
    $cw=&$this->CurrentFont['cw'];
    if($w==0)
        $w=$this->w-$this->rMargin-$this->x;
    $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
    $s=str_replace("\r",'',$txt);
    $nb=strlen($s);
    if($nb>0 and $s[$nb-1]=="\n")
        $nb--;
    $sep=-1;
    $i=0;
    $j=0;
    $l=0;
    $nl=1;
    while($i<$nb)
    {
        $c=$s[$i];
        if($c=="\n")
        {
            $i++;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
            continue;
        }
        if($c==' ')
            $sep=$i;
        $l+=$cw[$c];
        if($l>$wmax)
        {
            if($sep==-1)
            {
                if($i==$j)
                    $i++;
            }
            else
                $i=$sep+1;
            $sep=-1;
            $j=$i;
            $l=0;
            $nl++;
        }
        else
            $i++;
    }
    return $nl;
}

}

?>