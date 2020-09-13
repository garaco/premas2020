<?php

class ConfiguracionModel extends Model
{
	public $IdConfiguracion;
	public $Descripcion;
	public $Inicio;
	public $Final;
	Public $Usuario;
	Public $table;
	public $sql;

	function __construct()
	{
		self::$tablename = 'config_tiempo';
		$this->IdConfiguracion='';
		$this->Descripcion='';
		$this->FechaInicio=DATE;
		$this->FechaFinal=DATE;
		$this->Usuario='';
		$this->Anio='';
		$this->table='';
		$this->sql='';
	}
	public function add(){
	$sql = "INSERT INTO " .self::$tablename." (IdConfiguracion, IdUsario, Descripcion, FechaInicio, FechaFinal, Anio)
					VALUES ('0', '{$this->Usuario}', '{$this->Descripcion}', '{$this->FechaInicio}', '{$this->FechaFinal}', '{$this->Anio}')";
    return Executor::doit($sql);
	}
	public function update(){
		$sql="UPDATE " .self::$tablename." SET Descripcion='{$this->Descripcion}', FechaInicio='{$this->FechaInicio}', FechaFinal='{$this->FechaFinal}', Anio='{$this->Anio}' WHERE IdConfiguracion='{$this->IdConfiguracion}'";
		return Executor::doit($sql);
	}
	public function getSQL(){
		$sql = "SELECT IdConfiguracion,IdUsario, Descripcion, DATE_FORMAT(FechaInicio,'%d/%m/%Y') as FechaInicio,
		DATE_FORMAT(FechaFinal,'%d/%m/%Y') as FechaFinal,	IF(DATEDIFF(FechaFinal, NOW())+1>0,DATEDIFF(FechaFinal, NOW())+1,0) as Dias FROM " .self::$tablename." ";
		return Executor::doit($sql);
	}
	public function getAnio(){
		$sql="SELECT * FROM config_tiempo group by Anio";
		return Executor::doit($sql);
	}
	public function getId($field,$id){
    $sql = "SELECT * FROM " .self::$tablename. " WHERE {$field} = '{$id}' ";
    $query=Executor::doit($sql);
    return self::one($query,'ConfiguracionModel');
  }
	public function getDatas(){
		$sql = "SHOW COLUMNS FROM $this->table ";
		$query=Executor::doit($sql);
    return self::many($query,'ConfiguracionModel');
	}
	public function getAllData(){
		$sql = "SELECT * FROM $this->table ";
		$query=Executor::doit($sql);
		return self::many($query,'ConfiguracionModel');
	}

	public function addTables(){
		$sql = "$this->sql";
		return Executor::doit($sql);
	}

	public function getCostos(){
    $sql="select a.Articulo,a.IdDepartamento,
      (a.Ene+a.Feb+a.Mar+a.Abr+a.May+a.Jun+a.Jul+a.Ago+a.Sep+a.Oct+a.Nov+a.Dic) as Cantidad,
      FORMAT((select Cantidad*a.PU),2) as Total,
      (Select p.Concepto from partidas as p where p.IdPartida = a.IdPartida) as Partida,
			(Select m.Concepto from metas as m where m.IdMetas = a.IdMeta) as Metas,
			(Select SUBSTRING_INDEX(pr.Concepto, '(', 1) from proyecto as pr where pr.IdProyecto = a.IdProyecto) as Proyectos,
      (Select d.nombreDepto from departamento as d where a.IdDepartamento = d.idDepart) as Dep
      from programa_anual_requisiciones as a
			inner join cantidameses_inicial_pr as c on c.IdRequisicionAnual = a.IdPrograma_anual
			where a.Anio = YEAR(NOW()) order by a.IdDepartamento, a.IdProyecto, a.IdPartida";
      return Executor::doit($sql);
  }

	public function getConsumido(){
		$sql="select a.Articulo,a.IdDepartamento,
      ((a.Ene+a.Feb+a.Mar+a.Abr+a.May+a.Jun+a.Jul+a.Ago+a.Sep+a.Oct+a.Nov+a.Dic) -
			(c.Ene+c.Feb+c.Mar+c.Abr+c.May+c.Jun+c.Jul+c.Ago+c.Sep+c.Oct+c.Nov+c.Dic) )
			as Cantidad,
      FORMAT((select Cantidad*a.PU),2) as Total,
      (Select p.Concepto from partidas as p where p.IdPartida = a.IdPartida) as Partida,
			(Select m.Concepto from metas as m where m.IdMetas = a.IdMeta) as Metas,
			(Select SUBSTRING_INDEX(pr.Concepto, '(', 1) from proyecto as pr where pr.IdProyecto = a.IdProyecto) as Proyectos,
      (Select d.nombreDepto from departamento as d where a.IdDepartamento = d.idDepart) as Dep
      from programa_anual_requisiciones as a
			inner join cantidameses_inicial_pr as c on c.IdRequisicionAnual = a.IdPrograma_anual
			where a.Anio = YEAR(NOW()) order by a.IdDepartamento, a.IdProyecto, a.IdPartida";
			return Executor::doit($sql);
	}

	public function DatoUser($ID,$tupla)
	{
		$sql = "SELECT s.IdUsuario,s.Nombre_User,s.IdDepartamento,d.nombreDepto FROM usuarios s INNER JOIN departamento as d ON s.IdDepartamento=d.idDepart WHERE $tupla = '{$ID}'";
		return Executor::doit($sql);
	}
}
 ?>
