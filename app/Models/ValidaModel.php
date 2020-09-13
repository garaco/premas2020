<?php
require_once EXECUTOR;
class ValidaModel extends Model{
  public $Idvalida;
  public $IdDepartamento;
  public $IdProyecto;
  public $IdMeta;

  function __construct(){
    self::$tablename = 'valida';
    $this->Idvalida='';
    $this->IdDepartamento='';
    $this->IdProyecto='';
    $this->IdMeta='';
    $this->anio='';
  }
   public function add(){
     $sql="INSERT INTO ".self::$tablename." (IdValida, IdDepartamento, IdProyecto, IdMeta, anio) VALUES
     ('0', '{$this->IdDepartamento}', '{$this->IdProyecto}', '{$this->IdMeta}', '{$this->anio}')";
     return Executor::doit($sql);
   }
   public function update(){
     $sql="UPDATE ".self::$tablename." SET IdDepartamento='{$this->IdDepartamento}', IdProyecto='{$this->IdProyecto}', IdMeta=$this->IdMeta,
      anio = '{$this->anio}'  WHERE IdValida='{$this->Idvalida}'";
     return Executor::doit($sql);
   }
   public function del(){
     $sql="DELETE FROM ".self::$tablename." WHERE IdValida= '{$this->Idvalida}'";
     return Executor::doit($sql);
   }
   public function getValida(){
     $sql="SELECT v.*,d.nombreDepto,m.Concepto as meta,p.Concepto as proyecto FROM valida as v
        LEFT JOIN departamento  as d on (d.idDepart = v.IdDepartamento)
        LEFT JOIN metas as m on (m.IdMetas = v.IdMeta)
        LEFT JOIN proyecto as p on (p.IdProyecto = v.IdProyecto)";
     return Executor::doit($sql);
   }
   public function getValidaId(){
     $sql="SELECT v.*,d.nombreDepto,m.Concepto as meta,p.Concepto as proyecto FROM valida as v
        LEFT JOIN departamento  as d on (d.idDepart = v.IdDepartamento)
        LEFT JOIN metas as m on (m.IdMetas = v.IdMeta)
        LEFT JOIN proyecto as p on (p.IdProyecto = v.IdProyecto)
        where v.IdValida = '{$this->Idvalida}'";
     return Executor::doit($sql);
   }
}
