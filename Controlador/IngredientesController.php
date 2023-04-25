<?php
require 'Controlador.php';

class IngredientesController extends Controlador{
    public function listar(){
        $consultas=$this->modelo('IngredientesModel');
        $filas=$consultas->buscarIngredientes();
        echo json_encode($filas);
        return true;
            
    }

    public function guardar(){
        $consultas=$this->modelo('IngredientesModel');
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $fecha_ingreso = $_POST['fIngreso'];
        $fecha_vencimiento = $_POST['fVencimiento'];
        $mensaje=$consultas->insertarIngrediente($nombre, $descripcion, $fecha_ingreso, $fecha_vencimiento);
        echo json_encode($mensaje);
        return true;
    }

    public function eliminar(){
        $consultas=$this->modelo('IngredientesModel');
        $datos=$_POST['id_ingrediente'];
        $consultas->eliminarIngrediente($datos);
        echo json_encode("Eliminado");        
        return true;
    }

    public function actualizar(){
        $consultas=$this->modelo('IngredientesModel');
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $fecha_ingreso = $_POST['fIngreso'];
        $fecha_vencimiento = $_POST['fVencimiento'];
        $id_ingrediente = $_POST['id_ingrediente'];
        $mensaje=$consultas->actualizarIngrediente($nombre, $descripcion, $fecha_ingreso, $fecha_vencimiento, $id_ingrediente);
        echo json_encode($mensaje);
        return true;
    }
}
?>