<?php
class Conexion{
 public function obtener_conexion(){
     $user='root';
     $host='localhost';
     $pass='';
     $db='pasteleria';
     $conexion= new PDO("mysql:host=$host;dbname=$db",$user,$pass);
     return $conexion;
 }
}
?>