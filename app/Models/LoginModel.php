<?php
/**
*
*/
class LoginModel extends Model
{

  function __construct(){
    self::$tablename = 'usuarios';
  }
   public function add(){
   }
   public function update(){
   }
   public function des_decrypt($user,$clave){
     $sql="select AES_DECRYPT(Password_alt,'$clave') as pass from usuarios where Usuario = '$user'";
     return Executor::doit($sql);
   }
}
