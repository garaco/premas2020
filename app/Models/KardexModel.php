<?php

class KardexModel extends Model
{
	public $IdKardex;
	public $IdUsuario;
	public $Accion;
	public $Catalogo;
	public $Descripcion;

	function __construct()
	{
		self::$tablename = 'kardex';
		$this->IdKardex='';
		$this->IdUsuario='';
		$this->Accion='';
		$this->Catalogo='';
		$this->Descripcion='';
		$this->Fecha=DATE;
	}
	public function add()
	{
	$sql = "INSERT INTO " .self::$tablename." (IdKardex, IdUsuario, Accion, Catalogo, Fecha, Descripcion)
		VALUES ('0', '{$this->IdUsuario}', '{$this->Accion}', '{$this->Catalogo}', '{$this->Fecha}', '{$this->Descripcion}')";
    return Executor::doit($sql);
	}
	public function getSQL(){
		$sql = "SELECT k.*, DATE_FORMAT(k.Fecha,'%d/%m/%y') as Fechas,
		(SELECT u.Nombre_User FROM usuarios as u WHERE u.IdUsuario = k.IdUsuario ) as Usuario
		FROM " .self::$tablename." as k";
		return Executor::doit($sql);

	}
}
 ?>
