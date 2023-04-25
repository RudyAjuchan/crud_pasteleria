<?php
require 'Conexion.php';

class IngredientesModel{
    function buscarIngredientes(){
        $modelo= new Conexion();
        $conexion=$modelo->obtener_conexion();
        $sql="select * from ingrediente";
        $estado=$conexion->prepare($sql);
        $estado->execute();

        while($result = $estado->fetch()){
            $rows[]=$result;
        }
        if(!isset($rows)){
            $rows=null;
        }
        return $rows;
    }

    public function insertarIngrediente($nombre, $descripcion, $fecha_ingreso, $fecha_vencimiento){
        $modelo= new Conexion();
        $conexion=$modelo->obtener_conexion();
        $sql="insert into ingrediente(nombre, descripcion, fecha_ingreso, fecha_vencimiento) values(:nombre, :descripcion, :fecha_ingreso, :fecha_vencimiento)";
        $estado=$conexion->prepare($sql);
        $estado->bindParam(':nombre',$nombre);
        $estado->bindParam(':descripcion',$descripcion);
        $estado->bindParam(':fecha_ingreso',$fecha_ingreso);
        $estado->bindParam(':fecha_vencimiento',$fecha_vencimiento);

        if(!$estado){
            return 'Error al guardar';
        }else{
            $estado->execute();
            return 'Datos guardados con exito';
        }
    }

    public function eliminarIngrediente($id_ingrediente){
        $modelo= new Conexion();
        $conexion=$modelo->obtener_conexion();
        $sql="delete from ingrediente where id_ingrediente=:id_ingrediente";
        $estado=$conexion->prepare($sql);
        $estado->bindParam(':id_ingrediente',$id_ingrediente);

        if(!$estado){
            return 'Error al eliminar';
        }else{
            $estado->execute();
            return 'Datos eliminado';
        }
    }

    public function actualizarIngrediente($nombre, $descripcion, $fecha_ingreso, $fecha_vencimiento, $id_ingrediente){
        $modelo= new Conexion();
        $conexion=$modelo->obtener_conexion();
        $sql="update ingrediente set nombre=:nombre, descripcion=:descripcion, fecha_ingreso=:fecha_ingreso, fecha_vencimiento=:fecha_vencimiento where id_ingrediente=:id_ingrediente";
        $estado=$conexion->prepare($sql);
        $estado->bindParam(':nombre',$nombre);
        $estado->bindParam(':descripcion',$descripcion);
        $estado->bindParam(':fecha_ingreso',$fecha_ingreso);
        $estado->bindParam(':fecha_vencimiento',$fecha_vencimiento);
        $estado->bindParam(':id_ingrediente',$id_ingrediente);
        if(!$estado){
            return 'Error al guardar';
        }else{
            $estado->execute();
            return 'Datos actualizados con exito';
        }
    }
}
?>