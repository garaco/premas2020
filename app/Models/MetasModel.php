<?php
require_once EXECUTOR;
class MetasModel extends Model
{

  function __construct(){
    self::$tablename = 'metas';

  }
   public function add($Id,$Num,$Concepto){
     $sql="INSERT INTO ".self::$tablename." (IdMetas,Num, Concepto) VALUES ('0', '{$Num}', '{$Concepto}')";
     return Executor::doit($sql);
   }
   public function update($Id,$Codigo,$Concepto){
     $sql="UPDATE ".self::$tablename." SET Num='{$Codigo}', Concepto='{$Concepto}' WHERE IdMetas='{$Id}'";
     return Executor::doit($sql);
   }

   public function del($Id){
     $sql="DELETE FROM ".self::$tablename." WHERE IdMetas= '{$Id}'";
     return Executor::doit($sql);
   }
}
