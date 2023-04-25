<?php
require 'Controlador.php';
Class Page extends Controlador{
    public function aux(){
        $this->vista2('pag_principal');
    }
    public function inicio(){
        $this->vista2('pag_inicio');
    }
    public function ingrediente(){
        $this->vista2('pag_ingredientes');
    }
    public function pastel(){
        $this->vista2('pag_pasteles');
    }
}
?>