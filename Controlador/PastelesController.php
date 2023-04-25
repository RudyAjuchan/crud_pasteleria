<?php
require 'Controlador.php';

class PastelesController extends Controlador{
    public function listar(){
        $consultas=$this->modelo('PastelesModel');
        $filas=$consultas->buscarPasteles();
        echo json_encode($filas);
        return true;
            
    }

    public function buscarIngredientes(){
        $consultas=$this->modelo('PastelesModel');
        $id_pastel=$_POST['id_pastel'];
        $filas=$consultas->buscarIngredientes($id_pastel);
        echo json_encode($filas);
        return true;
            
    }

    public function guardar(){
        $consultas=$this->modelo('PastelesModel');
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $preparado_por = $_POST['preparado_por'];
        $fecha_creado = $_POST['fCreado'];
        $fecha_vencimiento = $_POST['fVencimiento'];
        $id_pastel=$consultas->insertarPastel($nombre, $descripcion, $preparado_por, $fecha_creado, $fecha_vencimiento);

        //Para detalle
        $datos=json_decode(stripslashes($_POST['carrito']),true);        
        foreach($datos as $fila){            
            $mensaje=$consultas->InsertarMaestroDetalle($id_pastel, $fila['id']);
        }
        echo json_encode($mensaje);
        return true;
    }

    public function eliminar(){
        $consultas=$this->modelo('PastelesModel');
        $datos=$_POST['id_pastel'];
        $consultas->eliminarPastel($datos);
        echo json_encode("Eliminado");        
        return true;
    }

    public function actualizar(){
        $consultas=$this->modelo('PastelesModel');
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $preparado_por = $_POST['preparado_por'];
        $fecha_creado = $_POST['fCreado'];
        $fecha_vencimiento = $_POST['fVencimiento'];
        $id_pastel = $_POST['id_pastel'];
        $mensaje=$consultas->actualizarPastel($nombre, $descripcion, $preparado_por, $fecha_creado, $fecha_vencimiento, $id_pastel);

        //Para detalle
        $agregar=json_decode(stripslashes($_POST['agregar']),true);        
        foreach($agregar as $ag){            
            $mensaje=$consultas->agregarActualizarMaestroDetalle($id_pastel, $ag['id']);
        }

        $borrar=json_decode(stripslashes($_POST['borrar']),true);        
        foreach($borrar as $br){            
            $mensaje=$consultas->borrarActualizarMaestroDetalle($id_pastel,$br['id']);
        }
        echo json_encode($mensaje);
        return true;
    }
}
?>