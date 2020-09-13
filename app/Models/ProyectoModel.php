<?php
require_once EXECUTOR;
class ProyectoModel extends Model
{

  function __construct(){
    self::$tablename = 'proyecto';
  }
   public function add($Id,$Num,$Concepto){
     $sql="INSERT INTO ".self::$tablename." (IdProyecto,Num, Concepto) VALUES ('0', '{$Num}', '{$Concepto}')";
     return Executor::doit($sql);
   }
   public function update($Id,$Codigo,$Concepto){
     $sql="UPDATE ".self::$tablename." SET Num='{$Codigo}', Concepto='{$Concepto}' WHERE IdProyecto='{$Id}'";
     return Executor::doit($sql);
   }

   public function del($Id){
     $sql="DELETE FROM ".self::$tablename." WHERE IdProyecto = '{$Id}'";
     return Executor::doit($sql);
   }
}
