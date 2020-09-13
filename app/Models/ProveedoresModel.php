<?php
require_once EXECUTOR;
class ProveedoresModel extends Model
{

  function __construct(){
    self::$tablename = 'proveedores';
  }
   public function add($Nombre,$RFC,$Domicilio,$Email,$Telefono,$comercial){
     $sql="INSERT INTO ".self::$tablename." (IdProveedor, Nombre, RFC, Domicilio, Email, Telefono, ActComercial) VALUES ('0', '{$Nombre}', '{$RFC}', '{$Domicilio}', '{$Email}', '{$Telefono}', '{$comercial}')";
     return Executor::doit($sql);
   }
   public function update($Id,$Nombre,$RFC,$Domicilio,$Email,$Telefono,$comercial){
     $sql="UPDATE ".self::$tablename." SET Nombre='{$Nombre}', Domicilio='{$Domicilio}', Email='{$Email}', Telefono='{$Telefono}', ActComercial='{$comercial}' WHERE IdProveedor='{$Id}'";
     return Executor::doit($sql);
   }

   public function del($Id){
     $sql="DELETE FROM ".self::$tablename." WHERE IdProveedor = '{$Id}'";
     return Executor::doit($sql);
   }
   public function Allproveedor()
   {
    $sql= "SELECT * FROM ".self::$tablename;
    return Executor::doit($sql);
   }
}
