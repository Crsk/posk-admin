<?php
require_once 'Conexion.php';

class Boletas {

  public static function obtenerTodo() {
    try {
      $conexion = new Conexion();
      $sql = "SELECT * FROM boletas";
      $consulta = $conexion->prepare($sql);
      $consulta->execute();
      return $consulta->fetchAll(PDO::FETCH_OBJ);
    } catch (\Exception $e) {
    }
  }
}
