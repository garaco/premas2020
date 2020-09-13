<?php
/**
 *
 */
class UsuariosModel extends Model
{

	function __construct()
	{
		self::$tablename = 'usuarios';
	}
	public function add($Usuario,$Nombre_User,$mail,$Apellidos_User,$Password,$pass_alt,$tipo,$IdDepartamento)
	{
	$sql = "INSERT INTO " .self::$tablename." (IdUsuario,Usuario,Nombre_User,Correo,Apellidos_User,Password,Password_alt,Tipo,IdDepartamento) VALUES
			('0','{$Usuario}','{$Nombre_User}','{$mail}','{$Apellidos_User}','{$Password}',AES_ENCRYPT('{$pass_alt}','fantasma'),'{$tipo}','$IdDepartamento') ";
    return Executor::doit($sql);
	}
	public function update($Id,$Usuario,$Nombre_User,$mail,$Apellidos_User,$Password,$pass_alt,$tipo,$IdDepartamento){
	$sql = "UPDATE " .self::$tablename." SET Usuario='{$Usuario}', Nombre_User='{$Nombre_User}', Correo='{$mail}', Apellidos_User='{$Apellidos_User}', Password='{$Password}',
	Password_alt=AES_ENCRYPT('{$pass_alt}','fantasma'), Tipo='{$tipo}', IdDepartamento='{$IdDepartamento}' WHERE IdUsuario='{$Id}'";
	return Executor::doit($sql);
	}
	public function getJoinAll(){
    $sql = "SELECT u.*, (SELECT d.nombreDepto FROM departamento as d where d.idDepart = u.IdDepartamento) as dep
		FROM " .self::$tablename." as u WHERE Usuario<>'Zara_G'";
    return Executor::doit($sql);
  }
	public function getUser($Id){
		$sql = "select u.*, d.nombreDepto, AES_DECRYPT(u.Password_alt,'fantasma') as pass,
				(select a.IdArea from area as a where a.IdArea = d.idArea ) as IdArea,
				(select a.NombreArea from area as a where a.IdArea = d.idArea ) as Area,
				(select j.IdJefe from jefe_area as j where j.IdJefe = d.idDepart) as Idjefe,
				(select concat(j.Subfijo,' ',j.Nombre,' ',j.A_paterno,' ',j.A_materno)  from jefe_area as j where j.IdJefe = d.idDepart) as jefe
				from usuarios as u
				left join departamento as d on ( d.idDepart = u.IdDepartamento )
				where u.IdUsuario = {$Id}";
		return Executor::doit($sql);
	}
  	public function getDatoUser($id){
    $sql = "SELECT * FROM " .self::$tablename." WHERE IdUsuario='{$id}'";
    return Executor::doit($sql);
  }
  public function delete($id)
  {
  	$sql="DELETE FROM ".self::$tablename." WHERE IdUsuario='{$id}' ";
  	return Executor::doit($sql);
  }
  public function DeptoArea($id)
  {
    $sql="SELECT COUNT(idArea) as totalArea FROM departamento WHERE idArea='{$id}'";
    return Executor::doit($sql);
  }
  public function CountDep($tipo)
  {
    $sql="SELECT COUNT(IdDepartamento) as num, (SELECT d.idDepart FROM departamento as d WHERE d.idDepart=us.IdDepartamento) as numdep FROM usuarios as us WHERE us.Tipo='{$tipo}' AND us.IdDepartamento != 'NULL'";
    return Executor::doit($sql);
  }
  public function getCount(){
  	$sql="SELECT * FROM ".self::$tablename." WHERE Tipo!='Normal'";
  	return Executor::doit($sql);
	}
	public function DatoUser($ID,$tupla)
  {
    $sql = "SELECT s.IdUsuario,s.Nombre_User,s.IdDepartamento,d.nombreDepto FROM usuarios s INNER JOIN departamento as d ON s.IdDepartamento=d.idDepart WHERE $tupla = '{$ID}'";
    return Executor::doit($sql);
  }
 public function dateDeptoManto($idDep)
  {
    $sql="SELECT *, (SELECT nombreDepto FROM departamento WHERE idDepart = IdDep) AS Departamento
     FROM jefe_area where IdDep='{$idDep}'";
    return Executor::doit($sql);
  }

}
 ?>
