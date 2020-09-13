<?php
class RBSModel extends Model{
public $resul;
  public function __construct(){
    self::$tablename = 'bitacora';
  }
  // Guarda los datos en la tabla bitacora
     public function addBitacora($Id,$folio,$recepcion,$dep,$solicitante,$estado,$costo,$concepto,$FechaEntrega){
     $sql="INSERT INTO ".self::$tablename." ( IdBitacora,Foliorequisicion, FechaRecepcion, IdDep, IdSolicitante, Costo, FechaAutorizacion, Estado, FechaAatencion, Concepto, FechaEntrega, Num_estado) VALUES
     ('{$Id}','{$folio}', '{$recepcion}', '{$dep}', '{$solicitante}','{$costo}','0000-00-00','{$estado}','0000-00-00','{$concepto}', '{$FechaEntrega}', '0')";
     return Executor::doit($sql);
   }
   // Guarda los datos en la tabla requisiciones
    public function addRequisicion($ID,$folio,$recepcion,$fechaLimite,$FechaEntrega,$dep,$solicitante,$concepto,$costo){
     $sql="INSERT INTO requisiciones ( IdRequisicion, ForlioRequisicion, FechaRecepcion, FechaLimite, FechaEntrega, idDepart, Idjefe, Concepto, Costo) VALUES
     ('{$ID}','{$folio}', '{$recepcion}','{$fechaLimite}', '{$FechaEntrega}', '{$dep}', '{$solicitante}','{$concepto}','{$costo}')";
     return Executor::doit($sql);
   }
   // ========== consulta para el departamento recursos materiales ======================
  public function getJoinAll_RM(){
    $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
    a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus, DATE_FORMAT(a.FechaEntrega,'%d/%m/%Y') as FechaEntrega
    FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
    INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe ORDER BY a.IdBitacora DESC";
    return Executor::doit($sql);
  }
  //============================== consulta para cada area y departamento ============================
   public function getJoinAll($field){
    $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion, DATE_FORMAT(a.FechaReporte,'%d/%m/%Y') as FechaReporte, a.IdDep, a.IdSolicitante,a.Comentario,
    a.Concepto, FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaAutorizacion,'%d/%m/%Y') as FechaAutorizacion, a.Estado, DATE_FORMAT(a.FechaAatencion,'%d/%m/%Y') as FechaAatencion , d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno,a.Estatus, DATE_FORMAT(a.FechaEntrega,'%d/%m/%Y') as FechaEntrega
    FROM " .self::$tablename. " as a INNER JOIN departamento as d ON a.IdDep=d.idDepart
    INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe INNER JOIN area as ar ON ar.IdArea = s.IdArea
   WHERE d.idDepart = '{$field}' ORDER BY a.IdBitacora DESC";
    return Executor::doit($sql);
  }
    public function UltimoRegitroBitacora(){
     $sql="SELECT * FROM ".self::$tablename." ORDER BY IdBitacora DESC limit 1";
     return Executor::doit($sql);
   }
    public function UltimoRegitroRequi(){
     $sql="SELECT * FROM requisiciones ORDER BY IdRequisicion DESC limit 1";
     return Executor::doit($sql);
   }
   // almacena los materiales de cada requisicion
    public function DetalleRBS($Table,$keyprimary,$IDbitacora,$Proyecto,$Meta,$Partida,$Unidad,$Descripcion,$Costo,$cantidad,$FechaEntrega){
     $sql="INSERT INTO ".$Table." (".$keyprimary.", IDbitacora, Proyecto, Meta, Partida, Unidad, Descripcion, Costo, Cantidad, Num_estado, FechaEntrega) VALUES ('0','{$IDbitacora}','{$Proyecto}','{$Meta}','{$Partida}','{$Unidad}','{$Descripcion}','{$Costo}','{$cantidad}','0','{$FechaEntrega}')";
     return Executor::doit($sql);
   }

   public function getSQL(){
     $sql = "SELECT IdConfiguracion,IdUsario, FechaFinal, Descripcion,
     IF(DATEDIFF(FechaFinal, NOW())+1>0,DATEDIFF(FechaFinal, NOW())+1,0) as Dias
     FROM config_tiempo";
     return Executor::doit($sql);
   }

   public function getMaterial($id){
    $sql = "SELECT m.IDmaterial, m.Concepto FROM materiales as m INNER JOIN Partidas as p ON m.IdPartidas=p.IdPartida WHERE m.IdPartidas = $id ORDER BY m.IDmaterial ASC";
    return Executor::doit($sql);

   }
   // funcion para obtener los articulos de acuerdo a la partida seleccionada, esto para cada usuario
   public function getMaterialUser($idPartida,$IdUsuario,$idMeta,$idProyecto)
   {
    $sql="SELECT IdMaterial, Articulo FROM programa_anual_requisiciones WHERE IdPartida='{$idPartida}' AND IdUsuario='{$IdUsuario}' AND IdMeta='{$idMeta}' and IdProyecto='{$idProyecto}'";
     return Executor::doit($sql);
   }
    public function getMedidaCosto($id){
    $sql = "SELECT Medida, Precio FROM materiales WHERE IDmaterial= $id ORDER BY IDmaterial ASC";
     return Executor::doit($sql);
   }
   ///////////////////////////////////// consulta para generar pdf /////////////////////////////////////////
    public function DatoMateriales($id){
    $sql = "SELECT rd.Proyecto,rd.Meta,rd.Cantidad,FORMAT(rd.Costo, 2) AS Costo, m.Concepto,m.Medida,p.Codigo,rd.Descripcion,rd.IdRequisicionDetalle,rd.Num_estado,
      (SELECT pro.Num FROM proyecto as pro WHERE pro.IdProyecto=rd.Proyecto) as NumProyecto,
      (SELECT met.Num FROM metas as met WHERE met.IdMetas=rd.Meta) as NumMeta
     FROM requisicion_detalle as rd INNER JOIN
      materiales as m ON m.IDmaterial=rd.Descripcion INNER JOIN
      partidas as p ON p.IdPartida=rd.Partida

      where rd.IDbitacora='{$id}' ";
     return Executor::doit($sql);
   }
    public function DatoGeneral($id){
    $sql = "SELECT a.IdBitacora, a.Foliorequisicion, DATE_FORMAT(a.FechaRecepcion,'%d/%m/%Y') as FechaRecepcion,a.Concepto,FORMAT(a.Costo, 2) AS Costo, DATE_FORMAT(a.FechaEntrega,'%d/%m/%Y') as FechaEntrega,d.nombreDepto,s.Subfijo,s.Nombre,s.A_paterno,s.A_materno FROM bitacora as a INNER JOIN departamento as d ON a.IdDep=d.idDepart INNER JOIN jefe_area as s ON a.IdSolicitante=s.IdJefe where a.IdBitacora='{$id}' ";
     return Executor::doit($sql);
   }
   public function DatoDirector()
   {
     $sql= "SELECT Subfijo, Nombre, A_paterno,A_materno FROM jefe_area as ja INNER JOIN area as ar ON ar.Responsable = ja.IdJefe INNER JOIN departamento as a ON a.idDepart=ja.IdDep where a.nombreDepto='DIRECCION GENERAL'";
     return Executor::doit($sql);
   }
  public function DatoUser($ID,$tupla)
  {
    $sql = "SELECT s.IdUsuario,s.Usuario,s.Nombre_User,s.IdDepartamento,d.nombreDepto FROM usuarios s INNER JOIN departamento as d ON s.IdDepartamento=d.idDepart WHERE $tupla = '{$ID}'";
    return Executor::doit($sql);
  }
// consulta para obtener el id del usuario, esto para cuando el admin desea crear una requisicion de un departamento
  public function IdUsuario($idDep)
  {
    $sql="SELECT u.IdUsuario FROM jefe_area as j_A INNER JOIN usuarios as u on j_A.IdDep=u.IdDepartamento WHERE j_A.IdJefe='{$idDep}' ORDER BY u.IdUsuario DESC";
    return Executor::doit($sql);
  }
  // consultas para las requisiciones guardadas en la tabla requisiciones
  public function getAllGuardadas($Id,$Tupla)
  {
  $sql = "SELECT IdRequisicion, ForlioRequisicion,FechaRecepcion, FechaLimite, Concepto, FORMAT(Costo, 2) AS Costo, FechaEntrega, DATEDIFF(FechaLimite, FechaRecepcion) as Dias, idDepart, Idjefe FROM requisiciones WHERE $Tupla='{$Id}' ORDER BY FechaRecepcion DESC";
    return Executor::doit($sql);
  }
  // para obtener los datos de los materiales de la requisicion guardada
  public function getMaterialesTem($ID)
  {
    $sql="SELECT * FROM requisicion_detalle_tem WHERE IDbitacora = '{$ID}'";
    return Executor::doit($sql);
  }
  // // para obtener el material de acuerdo al num de requisicion y la partida
  //   public function getMaterialTem($ID,$Partida)
  // {
  //   $sql="SELECT Cantidad, Descripcion FROM requisicion_detalle_tem WHERE IDbitacora = '{$ID}' AND Partida='{$Partida}'";
  //   return Executor::doit($sql);
  // }
  // para actualizar el costo total de la requisicon
  public function updateCostoTotal($Id,$costo)
   {
     $sql="UPDATE requisiciones SET Costo='{$costo}' WHERE IdRequisicion='{$Id}'";
     return Executor::doit($sql);
   }
  // Para actualizar los materiales de la requisicion guardada en la tabla requisicion_detalle_tem
  public function updateRequiGuardada($Id,$IDbitacora,$Proyecto,$Meta,$Partida,$Unidad,$Descripcion,$Costo,$Cantidad)
   {
     $sql="UPDATE requisicion_detalle_tem SET IDbitacora='{$IDbitacora}',Proyecto ='{$Proyecto}', Meta ='{$Meta}', Partida ='{$Partida}', Unidad ='{$Unidad}', Descripcion ='{$Descripcion}', Costo ='{$Costo}', Cantidad ='{$Cantidad}' WHERE IdRequisicionDetalleTem = '{$Id}'";
     return Executor::doit($sql);
   }

   // Para verificar si existe la requisicion en la tabla bitacora
   public function exitRequisicion($ID)
   {
     $sql="SELECT IdBitacora FROM ".self::$tablename." WHERE IdBitacora='{$ID}'";
     return Executor::doit($sql);
   }
   // Para verificar si existe los materiales de la requisicion en la tabla requisicion_detalle
   public function exitMaterialesReq($ID)
   {
     $sql="SELECT IDbitacora FROM requisicion_detalle WHERE IDbitacora='{$ID}'";
     return Executor::doit($sql);
   }

   // Funcion para Cuando se entrega el material Num_estado pasa a 1, el cual significa que ya fue entregado
   public function updateNum_estado($ID,$fecha)
   {
    $sql="UPDATE requisicion_detalle SET Num_estado='1', FechaEntrega='{$fecha}' WHERE IdRequisicionDetalle='{$ID}'";
    return Executor::doit($sql);
   }
   //
   public function Num_estadoMaterial($ID)
   {
     $sql="SELECT Num_estado FROM requisicion_detalle WHERE IDbitacora='{$ID}'";
     return Executor::doit($sql);
   }

   //cancelar requisicon
   public function Cancelar($IdReq)
   {
     $sql="UPDATE bitacora SET Cancelar='Si' WHERE IdBitacora= '{$IdReq}';";
     return Executor::doit($sql);
   }

   public function getAnio(){
    $sql="SELECT * FROM config_tiempo group by Anio";
    return Executor::doit($sql);
  }
  public function CountProgramaAnual($iduser)
  {
    $sql="SELECT COUNT(*) as 'total' FROM programa_anual_requisiciones WHERE IdUsuario='{$iduser}'";
    return Executor::doit($sql);
  }
  // funcion para obtener los datos del estado de los materiales de la requisicion, de la tabla requisicion_detalle
  public function EstadoMaterial($IdBitacora)
  {
  $sql="SELECT COUNT(Num_estado) as estado0,
        (SELECT COUNT(Num_estado) from requisicion_detalle where IDbitacora='{$IdBitacora}' and Num_estado=1 )  as estado1,
        (SELECT COUNT(*) from requisicion_detalle where IDbitacora='{$IdBitacora}' ) as countrow
        from requisicion_detalle where IDbitacora='{$IdBitacora}' and Num_estado=0 ";
    return Executor::doit($sql);
  }
  public function datoResponsableArea($id){
    $sql="SELECT b.Foliorequisicion,CONCAT(ja.Subfijo,ja.Nombre,' ',ja.A_paterno,' ',ja.A_materno) as solicitante, a.NombreArea,
        (SELECT CONCAT(jas.Subfijo,jas.Nombre,' ',jas.A_paterno,' ',jas.A_materno) FROM jefe_area as jas WHERE jas.IdJefe=a.Responsable) as Responsable
        FROM bitacora as b
        INNER JOIN jefe_area as ja ON b.IdSolicitante=ja.IdJefe
        INNER JOIN area as a ON a.IdArea=ja.IdArea
        WHERE b.IdBitacora={$id}";
        return Executor::doit($sql);
  }
}
