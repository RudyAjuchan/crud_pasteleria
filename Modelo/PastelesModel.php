<?php
require 'Conexion.php';

class PastelesModel{
    function buscarIngredientes($id_pastel){
        $modelo= new Conexion();
        $conexion=$modelo->obtener_conexion();
        $sql="SELECT i.id_ingrediente, i.nombre FROM pastel_ingrediente pi
        INNER JOIN ingrediente i ON pi.id_ingrediente=i.id_ingrediente
        INNER JOIN pastel p ON pi.id_pastel=p.id_pastel
        WHERE pi.id_pastel=:id_pastel;";
        $estado=$conexion->prepare($sql);
        $estado->bindParam(':id_pastel',$id_pastel);
        $estado->execute();

        while($result = $estado->fetch()){
            $rows[]=$result;
        }
        if(!isset($rows)){
            $rows=null;
        }
        return $rows;
    }
    function buscarPasteles(){
        $modelo= new Conexion();
        $conexion=$modelo->obtener_conexion();
        $sql="select * from pastel";
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

    public function insertarPastel($nombre, $descripcion, $preparado_por, $fecha_creado, $fecha_vencimiento){
        $modelo= new Conexion();
        $conexion=$modelo->obtener_conexion();
        $sql="insert into pastel(nombre, descripcion, preparado_por, fecha_creacion, fecha_vencimiento) values(:nombre, :descripcion, :preparado_por, :fecha_creado, :fecha_vencimiento)";
        $estado=$conexion->prepare($sql);
        $estado->bindParam(':nombre',$nombre);
        $estado->bindParam(':descripcion',$descripcion);
        $estado->bindParam(':preparado_por',$preparado_por);
        $estado->bindParam(':fecha_creado',$fecha_creado);
        $estado->bindParam(':fecha_vencimiento',$fecha_vencimiento);

        if(!$estado){
            return 'Error al guardar';
        }else{
            $estado->execute();
            return $conexion->lastInsertId();
        }
    }
    public function InsertarMaestroDetalle($id_pastel, $id_ingrediente){
        $modelo= new Conexion();
        $conexion=$modelo->obtener_conexion();
        $sql="insert into pastel_ingrediente(id_pastel, id_ingrediente) values(:id_pastel, :id_ingrediente)";
        $estado=$conexion->prepare($sql);
        $estado->bindParam(':id_pastel',$id_pastel);
        $estado->bindParam(':id_ingrediente',$id_ingrediente);

        if(!$estado){
            return 'Error al guardar';
        }else{
            $estado->execute();
            return 'Datos guardados';
        }
    }
    public function agregarActualizarMaestroDetalle($id_pastel, $id_ingrediente){
        $modelo= new Conexion();
        $conexion=$modelo->obtener_conexion();
        $sql="insert into pastel_ingrediente(id_pastel, id_ingrediente) values(:id_pastel, :id_ingrediente)";
        $estado=$conexion->prepare($sql);
        $estado->bindParam(':id_pastel',$id_pastel);
        $estado->bindParam(':id_ingrediente',$id_ingrediente);

        if(!$estado){
            return 'Error al guardar';
        }else{
            $estado->execute();
            return 'Datos guardados';
        }
    }

    public function eliminarPastel($id_pastel){
        $modelo= new Conexion();
        $conexion=$modelo->obtener_conexion();
        $sql="delete from pastel where id_pastel=:id_pastel";
        $estado=$conexion->prepare($sql);
        $estado->bindParam(':id_pastel',$id_pastel);

        if(!$estado){
            return 'Error al eliminar';
        }else{
            $estado->execute();
            return 'Datos eliminado';
        }
    }
    public function borrarActualizarMaestroDetalle($id_pastel, $id_ingrediente){
        $modelo= new Conexion();
        $conexion=$modelo->obtener_conexion();
        $sql="delete from pastel_ingrediente where id_pastel=:id_pastel and id_ingrediente=:id_ingrediente;";
        $estado=$conexion->prepare($sql);
        $estado->bindParam(':id_pastel',$id_pastel);
        $estado->bindParam(':id_ingrediente',$id_ingrediente);

        if(!$estado){
            return 'Error al eliminar';
        }else{
            $estado->execute();
            return 'Datos eliminado';
        }
    }

    public function actualizarPastel($nombre, $descripcion, $preparado_por, $fecha_creado, $fecha_vencimiento, $id_pastel){
        $modelo= new Conexion();
        $conexion=$modelo->obtener_conexion();
        $sql="update pastel set nombre=:nombre, descripcion=:descripcion, preparado_por=:preparado_por, fecha_creacion=:fecha_creado, fecha_vencimiento=:fecha_vencimiento where id_pastel=:id_pastel";
        $estado=$conexion->prepare($sql);
        $estado->bindParam(':nombre',$nombre);
        $estado->bindParam(':descripcion',$descripcion);
        $estado->bindParam(':preparado_por',$preparado_por);
        $estado->bindParam(':fecha_creado',$fecha_creado);
        $estado->bindParam(':fecha_vencimiento',$fecha_vencimiento);
        $estado->bindParam(':id_pastel',$id_pastel);
        if(!$estado){
            return 'Error al guardar';
        }else{
            $estado->execute();
            return 'Datos actualizados con exito';
        }
    }
}
?>