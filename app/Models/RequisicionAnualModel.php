<?php
class RequisicionAnualModel extends Model{
public $IdPrograma;
public $Fecha;
public $IdDepartamento;
public $IdPartida;
public $Articulo;
public $UnidadMedida;
public $PU;
public $Ene,$Feb,$Mar,$Abr,$May,$Jun,$Jul,$Ago,$Sep,$Oct,$Nov,$Dic;
public $IdUsuario;
public $IdMaterial;
public $TotalArticulo;
public $Partida;
public $Proyectos;

  public function __construct(){
    self::$tablename = 'programa_anual_requisiciones';
    $this->IdPrograma='';
    $this->Fecha=DATE;
    $this->IdDepartamento='';
    $this->IdPartida='';
    $this->Articulo='';
    $this->UnidadMedida='';
    $this->PU='';
    $this->Ene='0';$this->Feb='0';$this->Mar='0';$this->Abr='0';
    $this->May='0';$this->Jun='0';$this->Jul='0';$this->Ago='0';
    $this->Sep='0';$this->Oct='0';$this->Nov='0';$this->Dic='0';
    $this->IdUsuario='';
    $this->IdMaterial='';
    $this->TotalArticulo=0;
    $this->IdProyecto='';
    $this->IdMeta='';
    $this->Anio='';
    $this->Partida='';
    $this->Proyectos='';
  }
  public function add(){
    $sql="INSERT INTO ".self::$tablename." (IdPrograma_anual, Fecha, IdDepartamento, IdPartida, IdProyecto, IdMeta, IdMaterial, Articulo, UnidadMedida, PU, Ene, Feb, Mar, Abr, May, Jun, Jul, Ago, Sep, Oct, Nov, Dic, TotalArticulo, IdUsuario, Anio)
    VALUES ('0', '{$this->Fecha}', '{$this->IdDepartamento}', '{$this->IdPartida}', '{$this->IdProyecto}', '{$this->IdMeta}', '{$this->IdMaterial}', '{$this->Articulo}', '{$this->UnidadMedida}', '{$this->PU}', '{$this->Ene}', '{$this->Feb}', '{$this->Mar}', '{$this->Abr}', '{$this->May}',
    '{$this->Jun}','{$this->Jul}', '{$this->Ago}', '{$this->Sep}', '{$this->Oct}', '{$this->Nov}', '{$this->Dic}', '{$this->TotalArticulo}', '{$this->IdUsuario}', '{$this->Anio}')";
    return Executor::doit($sql);
  }
  public function update(){
    $sql="UPDATE ".self::$tablename." SET IdPartida='{$this->IdPartida}', IdMaterial='{$this->IdMaterial}', Articulo='{$this->Articulo}', UnidadMedida='{$this->UnidadMedida}', PU='{$this->PU}', Ene='{$this->Ene}', Feb='{$this->Feb}', Mar='{$this->Mar}', Abr='{$this->Abr}', May='{$this->May}', Jun='{$this->Jun}',
    Jul='{$this->Jul}', Ago='{$this->Ago}', Sep='{$this->Sep}', Oct='{$this->Oct}', Nov='{$this->Nov}', Dic='{$this->Dic}', TotalArticulo='{$this->TotalArticulo}' WHERE IdPrograma_anual='{$this->IdPrograma}'";
    return Executor::doit($sql) ;
  }

  public function addDetalle($Id){
    $sql="INSERT INTO cantidameses_inicial_pr (IdInicial, IdRequisicionAnual, Ene, Feb, Mar, Abr, May, Jun, Jul, Ago, Sep, Oct, Nov, Dic, Anio)
    VALUES ('0', '{$Id}', '{$this->Ene}', '{$this->Feb}', '{$this->Mar}', '{$this->Abr}', '{$this->May}','{$this->Jun}','{$this->Jul}','{$this->Ago}',
      '{$this->Sep}','{$this->Oct}', '{$this->Nov}', '{$this->Dic}', '{$this->Anio}')";
    return Executor::doit($sql);
  }
  public function updateDetalle(){
    $sql="UPDATE cantidameses_inicial_pr SET Ene='{$this->Ene}', Feb='{$this->Feb}', Mar='{$this->Mar}', Abr='{$this->Abr}', May='{$this->May}', Jun='{$this->Jun}',
    Jul='{$this->Jul}', Ago='{$this->Ago}', Sep='{$this->Sep}', Oct='{$this->Oct}', Nov='{$this->Nov}', Dic='{$this->Dic}' WHERE IdRequisicionAnual='{$this->IdPrograma}'";
    return Executor::doit($sql);
  }

 public function delete(){
     $sql="DELETE FROM programa_anual_requisiciones WHERE IdPrograma_anual = '{$this->IdPrograma}'";
     return Executor::doit($sql);
 }

 public function deleteDetalle(){

     $sql="DELETE FROM cantidameses_inicial_pr WHERE IdRequisicionAnual = '{$this->IdPrograma}'";
     return Executor::doit($sql);
 }
  public function getUserReq($IdUsuario=0,$anio=0){
    $sql="select a.*,
      (a.Ene+a.Feb+a.Mar+a.Abr+a.May+a.Jun+a.Jul+a.Ago+a.Sep+a.Oct+a.Nov+a.Dic) as Cantidad,
      FORMAT((select Cantidad*a.PU),2) as Total,
      (Select p.Concepto from partidas as p where p.IdPartida = a.IdPartida) as Partida,
			(Select m.Concepto from metas as m where m.IdMetas = a.IdMeta) as Metas,
			(Select SUBSTRING_INDEX(pr.Concepto, '(', 1) from proyecto as pr where pr.IdProyecto = a.IdProyecto) as Proyectos,
      (Select d.nombreDepto from departamento as d where a.IdDepartamento = d.idDepart) as Dep
      from programa_anual_requisiciones as a where a.IdUsuario = '$IdUsuario' and a.Anio = '{$anio}' order by a.IdPrograma_anual desc";
      $query = Executor::doit($sql);
      return self::many($query,'RequisicionAnualModel');
  }

  public function getReqDep($IdUsuario=0,$anio=0,$IdProy=0){
    $sql="select a.*,
      (a.Ene+a.Feb+a.Mar+a.Abr+a.May+a.Jun+a.Jul+a.Ago+a.Sep+a.Oct+a.Nov+a.Dic) as Cantidad,
      FORMAT((select Cantidad*a.PU),2) as Total,
      (Select p.Concepto from partidas as p where p.IdPartida = a.IdPartida) as Partida,
			(Select m.Concepto from metas as m where m.IdMetas = a.IdMeta) as Metas,
			(Select SUBSTRING_INDEX(pr.Concepto, '(', 1) from proyecto as pr where pr.IdProyecto = a.IdProyecto) as Proyectos,
      (Select d.nombreDepto from departamento as d where a.IdDepartamento = d.idDepart) as Dep
      from programa_anual_requisiciones as a where IdUsuario = '$IdUsuario' and a.Anio = '{$anio}'
      and a.IdProyecto = '{$IdProy}' order by a.IdPrograma_anual desc";
      $query = Executor::doit($sql);
      return self::many($query,'RequisicionAnualModel');
  }

  public function getUserReqAll($IdDep=0,$anio=0){
    $sql="select a.*,
      (a.Ene+a.Feb+a.Mar+a.Abr+a.May+a.Jun+a.Jul+a.Ago+a.Sep+a.Oct+a.Nov+a.Dic) as Cantidad,
      FORMAT((select Cantidad*a.PU),2) as Total,
      (Select p.Concepto from partidas as p where p.IdPartida = a.IdPartida) as Partida,
			(Select m.Concepto from metas as m where m.IdMetas = a.IdMeta) as Metas,
			(Select SUBSTRING_INDEX(pr.Concepto, '(', 1) from proyecto as pr where pr.IdProyecto = a.IdProyecto) as Proyectos,
      (Select d.nombreDepto from departamento as d where a.IdDepartamento = d.idDepart) as Dep
      from programa_anual_requisiciones as a where a.IdDepartamento = '{$IdDep}' and a.Anio = '{$anio}' order by a.IdPrograma_anual desc";
      $query = Executor::doit($sql);
      return self::many($query,'RequisicionAnualModel');
  }

  public function getUserReqInicial($IdUsuario=0,$anio=0){
      $sql="select a.IdPrograma_anual, p.*, a.Articulo,a.UnidadMedida,a.PU,
      (p.Ene+p.Feb+p.Mar+p.Abr+p.May+p.Jun+p.Jul+p.Ago+p.Sep+p.Oct+p.Nov+p.Dic) as Cantidad,
      FORMAT((select Cantidad*a.PU),2) as Total,
      (Select p.Concepto from partidas as p where p.IdPartida = a.IdPartida) as Partida,
      (Select m.Concepto from metas as m where m.IdMetas = a.IdMeta) as Metas,
      (Select SUBSTRING_INDEX(pr.Concepto, '(', 1) from proyecto as pr where pr.IdProyecto = a.IdProyecto) as Proyectos,
      (Select d.nombreDepto from departamento as d where a.IdDepartamento = d.idDepart) as Dep
      from programa_anual_requisiciones as a
      inner join cantidameses_inicial_pr as p on (p.IdRequisicionAnual = a.IdPrograma_anual)
        where a.IdUsuario='{$IdUsuario}' and a.Anio='{$anio}' order by a.IdPrograma_anual desc";
        $query = Executor::doit($sql);
        return self::many($query,'RequisicionAnualModel');
    }

    public function getUserReqAllInicial($IdDep=0,$anio=0){
      $sql="select a.IdPrograma_anual, p.*, a.Articulo,a.UnidadMedida,a.PU,
        (p.Ene+p.Feb+p.Mar+p.Abr+p.May+p.Jun+p.Jul+p.Ago+p.Sep+p.Oct+p.Nov+p.Dic) as Cantidad,
        FORMAT((select Cantidad*a.PU),2) as Total,
        (Select p.Concepto from partidas as p where p.IdPartida = a.IdPartida) as Partida,
  			(Select m.Concepto from metas as m where m.IdMetas = a.IdMeta) as Metas,
  			(Select SUBSTRING_INDEX(pr.Concepto, '(', 1) from proyecto as pr where pr.IdProyecto = a.IdProyecto) as Proyectos,
        (Select d.nombreDepto from departamento as d where a.IdDepartamento = d.idDepart) as Dep
        from programa_anual_requisiciones as a
  			inner join cantidameses_inicial_pr as p on (p.IdRequisicionAnual = a.IdPrograma_anual)
        where a.IdDepartamento = '{$IdDep}' and a.Anio = '{$anio}' order by a.IdPrograma_anual desc";
       $query = Executor::doit($sql);
       return self::many($query,'RequisicionAnualModel');
    }


  public function getByIdReq($id,$field){
    $sql = "SELECT * FROM " .self::$tablename. " WHERE {$field} = '{$id}' ";
    $query = Executor::doit($sql);
    return self::one($query,'RequisicionAnualModel');

  }

  public function getSQL(){
    $sql = "SELECT IdConfiguracion,IdUsario, FechaFinal, Descripcion,Anio,
    IF(DATEDIFF(FechaFinal, NOW())+1>0,DATEDIFF(FechaFinal, NOW())+1,0) as Dias
    FROM config_tiempo ";
    return Executor::doit($sql);
    // return self::one($query,'RequisicionAnualModel');
  }
    // Para obtener el idProyecto  por cada usuario
  public function getIdProyecto($id,$idmeta,$Anio){
    $sql = "SELECT paa.IdProyecto,(SELECT SUBSTRING_INDEX(Concepto, '(', 1) FROM proyecto as pr WHERE paa.IdProyecto=pr.IdProyecto ) as concepto,(SELECT pr.Num FROM proyecto as pr WHERE paa.IdProyecto=pr.IdProyecto) as enum FROM ".self::$tablename." as paa WHERE IdUsuario=$id and IdMeta=$idmeta and Anio='{$Anio}' and  IdProyecto is not null GROUP BY IdProyecto";
    return Executor::doit($sql);
  }
      // Para obtener el IdMeta  por cada usuario
  public function getIdMeta($id,$Anio){
    $sql = "SELECT paa.IdMeta, (SELECT Concepto FROM metas as m WHERE paa.IdMeta=m.IdMetas) as concepto, (SELECT m.Num FROM metas as m WHERE paa.IdMeta=m.IdMetas) as EnumMeta FROM ".self::$tablename." as paa WHERE paa.IdUsuario=$id and paa.Anio='{$Anio}' and paa.IdMeta is not null GROUP BY paa.IdMeta";
    return Executor::doit($sql);
  }
  // Para obtener el id de la partida y su codigo por cada usuario
  public function getIdPartida($id,$anio,$idProyecto){
    $sql = "SELECT r_a.IdPartida,(SELECT P.Codigo FROM partidas AS P WHERE P.IdPartida=r_a.IdPartida) AS Codigo FROM ".self::$tablename."  AS r_a WHERE r_a.IdUsuario = '{$id}' and r_a.anio='2020' and r_a.IdProyecto='{$idProyecto}' GROUP BY r_a.IdPartida";
    return Executor::doit($sql);
  }
  // funcion para obtener el numero total del material (ya no se utiliza)
  public function getTotalArticulo($IdUsuario,$IdMaterial)
  {
    $sql="SELECT TotalArticulo FROM ".self::$tablename." WHERE IdMaterial='{$IdMaterial}' AND IdUsuario='{$IdUsuario}'";
    return Executor::doit($sql);
  }
  public function getMesMaterial($IdUsuario,$IdMaterial,$IdMeta,$idProyecto,$mes)
  {
    $sql="SELECT $mes FROM ".self::$tablename." WHERE IdMaterial='{$IdMaterial}' AND IdMeta='{$IdMeta}' AND IdProyecto='{$idProyecto}' AND IdUsuario='{$IdUsuario}'";
    return Executor::doit($sql);
  }
// ya no se va a utilizar(checar)
  public function updateTotalArt($IdMaterial,$IdUsuario,$TotalArticulo)
  {
    $sql="UPDATE ".self::$tablename." SET TotalArticulo='{$TotalArticulo}' WHERE IdMaterial='{$IdMaterial}' AND IdUsuario='{$IdUsuario}'";
    return Executor::doit($sql);
  }
  // actualiza el total del material si el mes de la fecha en que solicito la req es menor al de la fecha actual.
    public function updateMesArt($IdMaterial,$IdUsuario,$TotalArticulo,$IdMeta,$idProyecto,$mes)
  {
    $sql="UPDATE ".self::$tablename." SET $mes ='{$TotalArticulo}' WHERE IdMaterial='{$IdMaterial}' AND IdMeta='{$IdMeta}' AND IdProyecto='{$idProyecto}' AND IdUsuario='{$IdUsuario}'";
    return Executor::doit($sql);
  }

  public function getCountMat($user,$anio){
  $sql="SELECT count(*) as contador, IdProyecto, IdMeta FROM ".self::$tablename." WHERE  IdDepartamento = '{$user}' and Anio = '{$anio}'";
  return Executor::doit($sql);
  }

  public function getExistence($IdMaterial,$IdProyecto,$user,$anio){
    $sql="SELECT count(*) as contador FROM ".self::$tablename."
    WHERE  IdMaterial = '{$IdMaterial}' and IdProyecto = '{$IdProyecto}' and IdDepartamento = '{$user}' and Anio = '{$anio}'";
    return Executor::doit($sql);
  }

  public function getAnio(){
		$sql="SELECT * FROM config_tiempo group by Anio";
		return Executor::doit($sql);
	}

  public function getProyectos($IdUsuario=0,$Anio=0){
		$sql="SELECT *,(SELECT CONCAT((Select m.Num from metas as m where m.IdMetas = p.IdMetas
    ),', ', LPAD(p.Num,2,'0')) FROM proyecto as p WHERE p.IdProyecto = v.IdProyecto ) as nProyecto,
    (SELECT p.Concepto FROM proyecto as p WHERE p.IdProyecto = v.IdProyecto ) as sProyecto,
    (SELECT CONCAT(REPLACE(p.Concepto,'(','-'),'-') FROM proyecto as p WHERE p.IdProyecto = v.IdProyecto ) as Proy
    FROM valida as v
    inner join usuarios as u on (v.IdDepartamento = u.IdDepartamento)
    where u.IdUsuario = '{$IdUsuario}' and v.anio = '{$Anio}' ";
    return Executor::doit($sql);
	}

  public function getProyectosDep($IdUsuario=0,$Anio=0){
		$sql="SELECT (select IdUsuario from programa_anual_requisiciones where IdDepartamento = v.IdDepartamento   order by IdUsuario desc limit 1 ) as IdUsuario,v.*,
    (SELECT CONCAT((Select m.Num from metas as m where m.IdMetas = p.IdMetas
    ),', ', LPAD(p.Num,2,'0')) FROM proyecto as p WHERE p.IdProyecto = v.IdProyecto ) as nProyecto,
    (SELECT p.Concepto FROM proyecto as p WHERE p.IdProyecto = v.IdProyecto ) as sProyecto,
    (SELECT CONCAT(REPLACE(p.Concepto,'(','-'),'-') FROM proyecto as p WHERE p.IdProyecto = v.IdProyecto ) as Proy
    FROM valida as v
    inner join usuarios as u on (v.IdDepartamento = u.IdDepartamento)
    where u.IdDepartamento = '{$IdUsuario}' and v.anio = '{$Anio}' GROUP BY v.IdProyecto";
    return Executor::doit($sql);
	}

  public function getProyecOne($IdProyecto=0,$Anio=0){
    $sql="SELECT *,
  (SELECT p.Num FROM proyecto as p WHERE p.IdProyecto = v.IdProyecto ) as nProyecto,
    (SELECT p.Concepto FROM proyecto as p WHERE p.IdProyecto = v.IdProyecto ) as sProyecto
    FROM valida as v
    inner join usuarios as u on (v.IdDepartamento = u.IdDepartamento)
    where v.IdProyecto= '{$IdProyecto}' and v.anio = '{$Anio}' GROUP BY v.IdProyecto";
    return Executor::doit($sql);
  }

  public function getIdUserxDep($dep){
    $sql="select IdUsuario from programa_anual_requisiciones where IdDepartamento = {$dep} order by IdUsuario desc limit 1";
    return Executor::doit($sql);
  }

  public function UpdateDate(){
		$sql="call actualizar_programa({$this->IdUsuario}, {$this->Anio})";
    return Executor::doit($sql);
	}

}
