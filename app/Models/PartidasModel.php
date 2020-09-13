<?php
require_once EXECUTOR;
class PartidasModel extends Model
{

  function __construct(){
    self::$tablename = 'partidas';
  }
   public function add($Id,$Codigo,$Concepto){
     $sql="INSERT INTO ".self::$tablename." (IdPartida, Codigo, Concepto) VALUES ('0', '{$Codigo}', '{$Concepto}')";
     return Executor::doit($sql);
   }
   public function update($Id,$Codigo,$Concepto){
     $sql="UPDATE ".self::$tablename." SET Codigo='{$Codigo}', Concepto='{$Concepto}' WHERE IdPartida='{$Id}'";
     return Executor::doit($sql);
   }

   public function del($Id){
     $sql="DELETE FROM ".self::$tablename." WHERE IdPartida = '{$Id}'";
     return Executor::doit($sql);
   }
}
