<?php
class MainModel extends Model{

  function __construct(){
    self::$tablename = 'bitacora';
  }
    public function getAllRequisicion()
  {
    $sql = "SELECT IdBitacora FROM ".self::$tablename;
    return Executor::doit($sql);
  }
  public function getNoAutorizada()
  {
    $sql = "SELECT IdBitacora FROM ".self::$tablename." WHERE Estado='NO AUTORIZADO'";
    return Executor::doit($sql);
  }
  public function getAutorizada()
  {
    $sql = "SELECT IdBitacora FROM ".self::$tablename." WHERE Estado='AUTORIZADO'";
    return Executor::doit($sql);
  }
    public function getAtendida()
  {
    $sql = "SELECT IdBitacora FROM ".self::$tablename." WHERE Estatus='ATENDIDA'";
    return Executor::doit($sql);
  }
  public function folioReq()
  {
    $sql="SELECT if (((DATEDIFF(FechaEntrega, DATE(now()))+1) > 0) and ((DATEDIFF(FechaEntrega, DATE(now()))+1) < 4),
    concat('La requisición ', Foliorequisicion,' expira en ',(DATEDIFF(FechaEntrega, DATE(now()))+1),' dias')
    ,if((Cancelar = 'Si'),concat('Se solicita eliminar la requisición ',Foliorequisicion),'0')) as dato
    FROM ".self::$tablename." WHERE Num_estado = 0 or Cancelar = 'Si'";
    return Executor::doit($sql);
  }
  public function DatoUser($ID,$tupla)
  {
    $sql = "SELECT s.IdUsuario,s.Nombre_User,s.IdDepartamento,d.nombreDepto,
      concat(s.Nombre_User,' ',s.Apellidos_User) as nombre
      FROM usuarios s INNER JOIN departamento as d ON s.IdDepartamento=d.idDepart WHERE $tupla = '{$ID}'";
    return Executor::doit($sql);
  }
}
