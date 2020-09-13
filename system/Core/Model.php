<?php
defined('BASEPATH') or exit('ERROR403');

abstract class Model
{
  public $id;
  public static $tablename;

  public function signIn($user)
  {
    $sql = "SELECT * FROM " .self::$tablename. " WHERE Usuario = '{$user}'";
    return Executor::doit($sql);
  }

  public function getAll($ord){
    $sql = "SELECT * FROM " .self::$tablename. " ORDER BY {$ord} ASC";
    return Executor::doit($sql);
  }

  public function getLimit($ord,$ini=0,$fin=0){
    $sql = "SELECT * FROM " .self::$tablename. " ORDER BY {$ord} DESC";
    return Executor::doit($sql);
  }

  public function getById($field,$id){
    $sql = "SELECT * FROM " .self::$tablename. " WHERE {$field} = '{$id}' ";
    return Executor::doit($sql);

  }
  public function getSearch($field1,$field2,$date){
    $sql = "SELECT * FROM " .self::$tablename. " WHERE {$field1} LIKE '%{$date}%' OR {$field2} LIKE '%{$date}%'";
    return Executor::doit($sql);

  }
  public function getCount(){
  $sql="SELECT * FROM ".self::$tablename;
  return Executor::doit($sql);
}
  public function obtener(){
       $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo,a.Estatus, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe  ORDER BY a.IdBitacora DESC" ;
   return Executor::doit($sql);
 }
 /////////////////////////////// Busqueda por Requisicion  //////////////////////////
  public function getSearchRe($field1,$field2,$date){
       $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo,a.Estatus, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , a.Archivo,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE {$field1} LIKE '%{$date}%' OR {$field2} LIKE '%{$date}%'";
    return Executor::doit($sql);

  }
  //////////////////////////////// Busqueda por estado ////////////////////////////
    public function obtener2($id,$field){
       $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
   a.Concepto, FORMAT(a.Costo, 2) AS Costo,a.Estatus, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , a.Archivo,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno
   FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
   INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe WHERE '{$field}' = {$id}";
   return Executor::doit($sql);
}
    public function getRequisicion($id){
       $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,
   a.Concepto, FORMAT(d.Costo, 2) AS Costo,d.Proyecto,d.Partida,d.Unidad,d.Descripcion,d.Cantidad
   FROM bitacora as a INNER JOIN requisicion_detalle as d ON a.{$id}=d.IDbitacora ";
   return Executor::doit($sql);
}
  public function user($user)
  {
    $sql = "SELECT Usuario,Correo FROM usuarios WHERE Usuario = '{$user}'";
    return Executor::doit($sql);
  }
  public function AddUser($username,$password,$tipoUser,$pass_alt='')
  {
     $sql = "INSERT INTO usuarios (IdUsuario, Usuario, Nombre_User, Apellidos_User, Password, Password_alt,Tipo) VALUES ('0', $username , '-' , '-' , $password , AES_ENCRYPT('{$pass_alt}','fantasma') , $tipoUser)";
     return Executor::doit($sql);
  }
  public function UpdateUser($useractual,$username,$password,$tipoUser,$pass_alt)
  {
     $sql="UPDATE usuarios SET Usuario ='{$username}', Password= '{$password}', Password_alt = AES_ENCRYPT('{$pass_alt}','fantasma') WHERE  Usuario ='{$useractual}'";
    return Executor::doit($sql);
  }
   // Para eliminar los registros de los materiales de la requisicion de la tabla requisicion_detalle_tem
   public function deleteMateriales($Tabla,$Tupla,$ID)
   {
     $sql="DELETE FROM $Tabla WHERE $Tupla ='{$ID}'";
     return Executor::doit($sql);
   }
   // Para eliminar los datos general de la requisicion de la tabla requisiciones
   public function deleteRequisicion($Tabla,$Tupla,$ID)
   {
     $sql="DELETE FROM $Tabla WHERE $Tupla='{$ID}'";
     return Executor::doit($sql);
   }

  public function LastId($Tabla,$Id){
    $sql="SELECT * FROM $Tabla ORDER BY $Id DESC LIMIT 1";
    $last=Executor::doit($sql);
    foreach ($last as $a ) { $last=$a[$Id];}
    return $last;
   }
   public static function getClassName(){
       return get_called_class();
   }

public static function many($query, $aclass = ''){
       if($aclass == '')
           $aclass = self::getClassName();

  $cnt = 0;
  $array = array();

  while($r = $query->fetch_array()){
    $array[$cnt] = new $aclass;
    $cnt2=1;
    foreach ($r as $key => $v) {
      if($cnt2>0 && $cnt2%2==0){
        $array[$cnt]->$key = $v;
      }
      $cnt2++;
    }
    $cnt++;
  }
  return $array;
}

public static function one($query, $aclass = ''){
       if($aclass == '')
           $aclass = self::getClassName();

       $found = null;
  $data = new $aclass;
  while($r = $query->fetch_array()){
    $cnt=1;
    foreach ($r as $key => $v) {
      if($cnt>0 && $cnt%2==0){
        $data->$key = $v;
      }
      $cnt++;
    }

    $found = $data;
    break;
  }
  return $found;
}
}
