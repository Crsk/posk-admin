<?php

require_once 'Conexion.php';

class Clientes {

  public static function ingresar($rut, $nombres, $apellidos, $email, $telefono_fijo, $celular, $canal_ingreso_id, $razon_social_id, $fecha_ingreso, $sucursal_id, $estado_cliente_id){
    try {
      $conexion = new Conexion();
      $sql = "INSERT INTO clientes (rut, nombres, apellidos, email, telefono_fijo,celular, canal_ingreso_id, razon_social_id, fecha_ingreso, sucursal_id, estado_cliente_id)  VALUES (?,?,?,?,?,?,?,?,?,?,?)";
      $consulta = $conexion->prepare($sql);
      $consulta->bindParam(1,$rut);
      $consulta->bindParam(2,$nombres);
      $consulta->bindParam(3,$apellidos);
      $consulta->bindParam(4,$email);
      $consulta->bindParam(5,$telefono_fijo);
      $consulta->bindParam(6,$celular);
      $consulta->bindParam(7,$canal_ingreso_id);
      $consulta->bindParam(8,$razon_social_id);
      $consulta->bindParam(9,$fecha_ingreso);
      $consulta->bindParam(10,$sucursal_id);
      $consulta->bindParam(11,$estado_cliente_id);
      $consulta->execute();
      $conexion = null;
    } catch (\Exception $e) {

    }
  }

  public function ingresarDireccion($comuna,$cliente,$direccion,$referencia,$tipo_direccion) {
    try {
      $conexion = new Conexion();
      $sql = "INSERT INTO cliente_direccion (comuna_id,cliente_id,direccion,referencia,direccion_tipo_id) VALUES(?,?,?,?,?)";
      $consulta = $conexion->prepare($sql);
      $consulta->bindParam(1,$comuna);
      $consulta->bindParam(2,$cliente);
      $consulta->bindParam(3,$direccion);
      $consulta->bindParam(4,$referencia);
      $consulta->bindParam(5,$tipo_direccion);
      $consulta->execute();
    } catch (\Exception $e) {

    }

  }

  public static function obtener() {
    try {
      $conexion = new Conexion();
      $sql = "SELECT c.id, c.nombres, c.apellidos, c.celular, c.email, c.rut, c.celular
      cd.direccion FROM clientes as c
      INNER JOIN cliente_direccion as cd ON(cd.cliente_id = c.id)
      INNER JOIN direccion_tipo as dt ON(cd.direccion_tipo_id = dt.id)";
      $consulta = $conexion->prepare($sql);
      $consulta->execute();
      $registros = $consulta->fetchAll(PDO::FETCH_OBJ);
      return $registros;
    } catch (\Exception $e) {
    }
  }

  public static function obtenerClientes() {
    try {
      $conexion = new Conexion();
      $sql = "SELECT nombres, email, rut, celular, apellidos, id FROM clientes ORDER BY id  DESC ";
      $consulta = $conexion->prepare($sql);
      $consulta->execute();
      $cliente = $consulta->fetchAll(PDO::FETCH_OBJ);
      return $cliente;
    } catch (\Exception $e) {

    }
  }

  public static function obtenerAllClientes(){
    try {
      $conexion = new Conexion();
      $sql = "SELECT cl.nombres as nombres, cl.email as email, cl.rut as rut, cl.celular, cl.apellidos, cl.id FROM clientes as cl
      INNER JOIN cliente_usuario as cu ON(cu.cliente_id = cl.id)
      INNER JOIN usuarios as usr ON(usr.id = cu.usuario_id)
      ORDER BY cl.id  DESC";
      $consulta = $conexion->prepare($sql);
      $consulta->execute();
      $registros = $consulta->fetchAll(PDO::FETCH_OBJ);
      return $registros;
    } catch (\Exception $e) {

    }

  }


  public static function obtenerClientesPorEjecutivo($correoEjecutivo) {
    try {
      $conexion = new Conexion();
      $sql = "SELECT cl.nombres as nombres, cl.email as email, cl.rut as rut, cl.celular, cl.apellidos, cl.id FROM clientes as cl
      INNER JOIN cliente_usuario as cu ON(cu.cliente_id = cl.id)
      INNER JOIN usuarios as usr ON(usr.id = cu.usuario_id)
      WHERE usr.email = ?
      ORDER BY cl.id  DESC ";
      $consulta = $conexion->prepare($sql);
      $consulta->bindParam(1,$correoEjecutivo);
      $consulta->execute();
      $cliente = $consulta->fetchAll(PDO::FETCH_OBJ);
      return $cliente;
    } catch (\Exception $e) {

    }
  }

  public static function obtenerClientesPorEjecutivoId($correoEjecutivo) {
    try {
      $conexion = new Conexion();
      $sql = "SELECT cl.nombres as nombres, cl.email as email, cl.rut as rut, cl.celular, cl.apellidos, cl.id FROM clientes as cl
      INNER JOIN cliente_usuario as cu ON(cu.cliente_id = cl.id)
      INNER JOIN usuarios as usr ON(usr.id = cu.usuario_id)
      WHERE usr.id = ?
      ORDER BY cl.id  DESC ";
      $consulta = $conexion->prepare($sql);
      $consulta->bindParam(1,$correoEjecutivo);
      $consulta->execute();
      $cliente = $consulta->fetchAll(PDO::FETCH_OBJ);
      return $cliente;
    } catch (\Exception $e) {

    }
  }


  public static function obtenerUsandoRut($rut) {
    try {
      $conexion = new Conexion();
      $sql = "SELECT * FROM clientes WHERE rut = ?";
      $consulta = $conexion->prepare($sql);
      $consulta->bindParam(1,$rut);
      $consulta->execute();
      $cliente = $consulta->fetch(PDO::FETCH_OBJ);
      return $cliente;
    } catch (\Exception $e) {
      console.log('error');
    }
  }

  public static function obtenerUsandoId($id) {
    try {
      $conexion = new Conexion();
      $sql = "SELECT * FROM clientes WHERE id = ?";
      $consulta = $conexion->prepare($sql);
      $consulta->bindParam(1,$id);
      $consulta->execute();
      $cliente = $consulta->fetch(PDO::FETCH_OBJ);
      return $cliente;
    } catch (\Exception $e) {
      console.log('error');
    }
  }


  public static function obtenerPorEmail($email){
    try {
      $conexion = new Conexion();
      $sql = "SELECT c.nombres, c.email , c.rut, c.celular, c.apellidos, c.id,
      c.telefono_fijo, c.celular, ci.nombre as canal_ingreso, rs.nombre as razon
      FROM clientes as c
      LEFT JOIN canal_ingreso as ci ON(c.canal_ingreso_id = ci.id)
      LEFT JOIN razon_social as rs ON(c.razon_social_id = rs.id)
      WHERE email = ?";
      $consulta = $conexion->prepare($sql);
      $consulta->bindParam(1,$email);
      $consulta->execute();
      $registro = $consulta->fetch(PDO::FETCH_OBJ);
      return $registro;
    } catch (\Exception $e) {
    }
  }

  public static function obtenerCanalesIngreso() {
    try {
      $conexion = new Conexion();
      $sql = "SELECT nombre, id FROM canal_ingreso ORDER BY id DESC";
      $consulta = $conexion->prepare($sql);
      $consulta->execute();
      $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
      return $registro;
    } catch (\Exception $e) {
    }
  }

  public static function obtenerRazonesSociales() {
    try {
      $conexion = new Conexion();
      $sql = "SELECT * FROM razon_social";
      $consulta = $conexion->prepare($sql);
      $consulta->execute();
      $registro = $consulta->fetchAll(PDO::FETCH_OBJ);
      $conexion = null;
      return $registro;
    } catch (\Exception $e) {
    }
  }

  public static function obtenerSucursales() {
    try {
      $conexion = new Conexion();
      $sql = "SELECT * FROM sucursales";
      $consulta = $conexion->prepare($sql);
      $consulta->execute();
      $registro = $consulta->fetch(PDO::FETCH_OBJ);
      return $registro;
    } catch (\Exception $e) {
    }
  }

  public static function obtenerEstadosCliente() {
    try {
      $conexion = new Conexion();
      $sql = "SELECT * FROM estado_cliente";
      $consulta = $conexion->prepare($sql);
      $consulta->execute();
      $registro = $consulta->fetch(PDO::FETCH_OBJ);
      return $registro;
    } catch (\Exception $e) {
    }
  }

  public static function obtenerDetallePorId($id){
    try {
      $conexion = new Conexion();
      $sql = "SELECT c.nombres, c.email , c.rut, c.celular, c.apellidos, c.id, c.razon_social_id,
      c.telefono_fijo, ci.nombre as canal_ingreso, rs.nombre as razon, u.nombres as ejecutivo,
      ec.nombre as estado, c.canal_ingreso_id
      FROM clientes as c
      LEFT JOIN canal_ingreso as ci ON(c.canal_ingreso_id = ci.id)
      LEFT JOIN razon_social as rs ON(c.razon_social_id = rs.id)
      LEFT JOIN cliente_usuario as cu ON(cu.cliente_id= c.id)
      LEFT JOIN usuarios as u ON(cu.usuario_id = u.id)
      LEFT JOIN estado_cliente AS ec ON(ec.id = c.estado_cliente_id)
      WHERE c.id = ?;";
      $consulta = $conexion->prepare($sql);
      $consulta->bindParam(1,$id);
      $consulta->execute();
      $registros = $consulta->fetch(PDO::FETCH_OBJ);
      return $registros;
    } catch (\Exception $e) {

    }
  }

  public static function obtenerDetallePorRut($rut){
    try {
      $conexion = new Conexion();
      $sql = "SELECT c.nombres, c.email , c.rut, c.celular, c.apellidos, c.id, c.razon_social_id,
      c.telefono_fijo, ci.nombre as canal_ingreso, rs.nombre as razon, u.nombres as ejecutivo,
      ec.nombre as estado, c.canal_ingreso_id
      FROM clientes as c
      LEFT JOIN canal_ingreso as ci ON(c.canal_ingreso_id = ci.id)
      LEFT JOIN razon_social as rs ON(c.razon_social_id = rs.id)
      LEFT JOIN cliente_usuario as cu ON(cu.cliente_id= c.id)
      LEFT JOIN usuarios as u ON(cu.usuario_id = u.id)
      LEFT JOIN estado_cliente AS ec ON(ec.id = c.estado_cliente_id)
      WHERE c.rut = ?;";
      $consulta = $conexion->prepare($sql);
      $consulta->bindParam(1,$rut);
      $consulta->execute();
      $registros = $consulta->fetch(PDO::FETCH_OBJ);
      return $registros;
    } catch (\Exception $e) {

    }
  }

  public static function obtenerCantidadClientes(){
    try {
      $conexion = new Conexion();
      $sql = "SELECT count(id) as total FROM clientes";
      $consulta = $conexion->prepare($sql);
      $consulta->execute();
      $registro = $consulta->fetch(PDO::FETCH_OBJ);
      return $registro;
    } catch (\Exception $e) {

    }

  }

  public function actualizarCliente($rut,$razonSocial,$nombres,$apellidos,$correo,$telefono,$celular,$canalIngreso,$clienteId){
    try {
      $conexion = new Conexion();
      $sql = "UPDATE clientes SET rut = ?,razon_social_id = ?, nombres = ?, apellidos = ?, email = ?,
      telefono_fijo = ?, celular = ?, canal_ingreso_id = ? WHERE id = ?;";
      $consulta = $conexion->prepare($sql);
      $consulta->bindParam(1,$rut);
      $consulta->bindParam(2,$razonSocial);
      $consulta->bindParam(3,$nombres);
      $consulta->bindParam(4,$apellidos);
      $consulta->bindParam(5,$correo);
      $consulta->bindParam(6,$telefono);
      $consulta->bindParam(7,$celular);
      $consulta->bindParam(8,$canalIngreso);
      $consulta->bindParam(9,$clienteId);
      $consulta->execute();
    } catch (\Exception $e) {

    }
  }

  public function obtenerClientePorEjecutivo($cliente,$ejecutivo){
    try {
      $conexion = new Conexion();
      $sql = "SELECT id FROM cliente_usuario AS cu WHERE cu.cliente_id = ? AND cu.usuario_id = ?;";
      $consulta = $conexion->prepare($sql);
      $consulta->bindParam(1,$cliente);
      $consulta->bindParam(2,$ejecutivo);
      $consulta->execute();
      $registros = $consulta->fetch(PDO::FETCH_OBJ);
      return $registros;
    } catch (\Exception $e) {

    }

  }

}
