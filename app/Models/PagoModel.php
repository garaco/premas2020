<?php
require_once EXECUTOR;
class PagoModel extends Model
{

  function __construct(){
    self::$tablename = 'solicitudpago';
  }

  public function AllPago($ord){
    $sql="SELECT Id, Proveedor, Concepto, FORMAT(Monto, 2) AS Monto, Revisado, DATE_FORMAT(FechaSolicitud,'%d/%m/%Y') AS FechaSolicitud, AutorizadoPago, DATE_FORMAT(FechaAutorizado,'%d/%m/%Y') AS FechaAutorizado, estado, Comentario, ComentarioCapt, DATE_FORMAT(FechaPago,'%d/%m/%Y') AS FechaPago From ".self::$tablename." ORDER BY {$ord} DESC";
    return Executor::doit($sql);

  }
  public function update($Id,$estado,$campo){
    $sql="UPDATE ".self::$tablename." SET ".$campo." = '{$estado}' WHERE Id='{$Id}'";
    return Executor::doit($sql);

  }
    ////////////////////////////////////// usuario 3 ///////////////////////////////////////////////////
  public function updateSF($Id,$estado,$fecha){
    $sql="UPDATE ".self::$tablename." SET FechaPago = '{$fecha}',estado = '{$estado}' WHERE Id='{$Id}'";
    return Executor::doit($sql);

  }
    ////////////////////////////////////// usuario 2 ///////////////////////////////////////////////////
  public function updateComentary($Id,$estado,$fecha,$comentario){
    $sql="UPDATE ".self::$tablename." SET FechaAutorizado = '{$fecha}',AutorizadoPago = '{$estado}', Comentario='{$comentario}' WHERE Id='{$Id}'";
    return Executor::doit($sql);

  }
  ////////////////////////////////////// usuario 1 ///////////////////////////////////////////////////
    public function updatePago($Id,$proveedor,$concepto,$monto,$revisado,$fecha,$comentario){
    $sql="UPDATE ".self::$tablename." SET Proveedor = '{$proveedor}', Concepto = '{$concepto}', Monto = '{$monto}', Revisado = '{$revisado}', FechaSolicitud = '{$fecha}',ComentarioCapt = '{$comentario}' WHERE Id='{$Id}'";
    return Executor::doit($sql);

  }
   public function add($proveedor,$concepto,$monto,$revisado,$fecha){
     $sql="INSERT INTO ".self::$tablename." ( Id, Proveedor, Concepto, Monto, Revisado, FechaSolicitud, AutorizadoPago, FechaAutorizado, Comentario, estado, FechaPago) VALUES
     ( '0','{$proveedor}','{$concepto}','{$monto}','{$revisado}','{$fecha}','NO','0000-00-00',' ','PENDIENTE','0000-00-00')";
     return Executor::doit($sql);
   }
   // ==================== busqueda por estado =============================
   public function search($campo,$concepto){
     $sql="SELECT Id,Proveedor, Concepto, FORMAT(Monto, 2) AS Monto, Revisado, DATE_FORMAT(FechaSolicitud,'%d/%m/%Y') AS FechaSolicitud, AutorizadoPago, DATE_FORMAT(FechaAutorizado,'%d/%m/%Y') AS FechaAutorizado, estado, Comentario, ComentarioCapt, DATE_FORMAT(FechaPago,'%d/%m/%Y') AS FechaPago  FROM ".self::$tablename." where $campo like'%{$concepto}%' ORDER BY Id DESC";
     return Executor::doit($sql);
   } 
   // ===================== busqueda por ID, Proveedor o por concepto =========
     public function searchIPC($campo,$campo2,$campo3,$concepto){
     $sql="SELECT Id,Proveedor, Concepto, FORMAT(Monto, 2) AS Monto, Revisado, DATE_FORMAT(FechaSolicitud,'%d/%m/%Y') AS FechaSolicitud, AutorizadoPago, DATE_FORMAT(FechaAutorizado,'%d/%m/%Y') AS FechaAutorizado, estado, Comentario, ComentarioCapt, DATE_FORMAT(FechaPago,'%d/%m/%Y') AS FechaPago  FROM ".self::$tablename." where $campo like'%{$concepto}%' OR $campo2 like'%{$concepto}%' OR $campo3 like'%{$concepto}%' ORDER BY Id DESC";
     return Executor::doit($sql);
   }
    // ================  busqueda  fecha =============================
     public function getAllDate($datoDesde,$datoHasta){
   $sql = "SELECT Id, Proveedor, Concepto, FORMAT(Monto, 2) AS Monto, Revisado, DATE_FORMAT(FechaSolicitud,'%d/%m/%Y') AS FechaSolicitud, AutorizadoPago, DATE_FORMAT(FechaAutorizado,'%d/%m/%Y') AS FechaAutorizado, estado, Comentario, ComentarioCapt, DATE_FORMAT(FechaPago,'%d/%m/%Y') AS FechaPago From " .self::$tablename. "  WHERE FechaSolicitud BETWEEN '{$datoDesde}' AND '{$datoHasta}' ORDER BY Id DESC";
   return Executor::doit($sql);
 }
 // ================  busqueda por estado y fecha =============================
   public function getEstadoFecha($estado,$desde,$hasta)
  {
    $sql = "SELECT Proveedor, Concepto, FORMAT(Monto, 2) AS Monto, Revisado, DATE_FORMAT(FechaSolicitud,'%d/%m/%Y') AS FechaSolicitud, AutorizadoPago, DATE_FORMAT(FechaAutorizado,'%d/%m/%Y') AS FechaAutorizado, estado, Comentario, ComentarioCapt, DATE_FORMAT(FechaPago,'%d/%m/%Y') AS FechaPago From " .self::$tablename. " WHERE AutorizadoPago = '{$estado}' AND FechaAutorizado BETWEEN '{$desde}' AND '{$hasta}' ORDER BY Id DESC" ;
    return Executor::doit($sql);
  }
  // =========== consulta para paginacion ===================================
  public function Pago($ord,$ini,$fin){
    $sql="SELECT Id, Proveedor, Concepto, FORMAT(Monto, 2) AS Monto, Revisado, DATE_FORMAT(FechaSolicitud,'%d/%m/%Y') AS FechaSolicitud, AutorizadoPago, DATE_FORMAT(FechaAutorizado,'%d/%m/%Y') AS FechaAutorizado, estado, Comentario, ComentarioCapt, DATE_FORMAT(FechaPago,'%d/%m/%Y') AS FechaPago From ".self::$tablename." ORDER BY {$ord} DESC limit {$ini},{$fin}";
    return Executor::doit($sql);

  }
  public function getCount(){
  $sql="SELECT * FROM ".self::$tablename;
  return Executor::doit($sql);
}
   public function del($Id){
     $sql="DELETE FROM ".self::$tablename." WHERE Id= '{$Id}'";
     return Executor::doit($sql);
   }

}
