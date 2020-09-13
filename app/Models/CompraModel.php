<?php
/**
 *
 */
class CompraModel extends Model
{

	function __construct()
	{
		self::$tablename = 'ordencompra';
	}
	public function addOrdenCompra($IDproveedor,$Num_compra,$FechaPedido,$FechaEntrega,$Iva,$ImporteTotal)
	{
		$sql = "INSERT INTO ".self::$tablename." (IDcompra, IDproveedor, Num_compra, FechaPedido, FechaEntrega, Iva, ImporteTotal,Num_estado)
				 VALUES ('0','{$IDproveedor}','{$Num_compra}','{$FechaPedido}','{$FechaEntrega}','{$Iva}','{$ImporteTotal}','0')";
		return Executor::doit($sql);
	}
	public function addCompra_detalle($IDcompra,$Cantidad,$IdDescripcion,$IDrequisicion,$IDdep,$PrecioUnitario,$ImporteParcial)
	{
		$sql = "INSERT INTO compra_detalle_descripcion (IDdetalleDescripcion, IDcompra, Cantidad, Descripcion, IDrequisicion, IDdep, Precio_unitario, Importe_parcial,Num_estado)
				VALUES('0','{$IDcompra}','{$Cantidad}','{$IdDescripcion}','{$IDrequisicion}','{$IDdep}','{$PrecioUnitario}','{$ImporteParcial}','0')";
		return Executor::doit($sql);
	}
	// public function addCompra_detalle_descripcion($Descripcion,$IDrequisicion,$IDcompra)
	// {
	// 	$sql = "INSERT INTO Compra_detalle_descripcion (IDdetalleDescripcion,Descripcion,IDrequisicion,IDcompra)
	// 			VALUES ('0','{$Descripcion}','{$IDrequisicion}','{$IDcompra}')";
	// 	return Executor::doit($sql);
	// }
	public function area_solicitante($id)
	{
		$sql="SELECT  d.* FROM bitacora as b INNER JOIN departamento as d ON b.IdDep = d.idDepart WHERE b.IdBitacora='{$id}'";
		return Executor::doit($sql);
	}
		public function MaterialRequesicion($id)
	{
		$sql="SELECT  m.IDmaterial,m.Existencia, m.Concepto,rd.Cantidad FROM requisicion_detalle as rd INNER JOIN materiales as m ON rd.Descripcion = m.IDmaterial WHERE rd.IDbitacora='{$id}'";
		return Executor::doit($sql);
	}
	public function GetAllCompra()
	{
		$sql = "SELECT P.Nombre, C.IDcompra, C.Num_compra, DATE_FORMAT(C.FechaPedido,'%d/%m/%Y') as FechaPedido, DATE_FORMAT(C.FechaEntrega,'%d/%m/%Y') as FechaEntrega, C.ImporteTotal FROM ".self::$tablename." as C INNER JOIN proveedores as P ON C.IDproveedor = P.IdProveedor ORDER BY C.IDcompra DESC";
		return Executor::doit($sql);
	}
	public function GetAllCompraPDF($id)
	{
		$sql = "SELECT P.Nombre, C.IDcompra, C.Num_compra, DATE_FORMAT(C.FechaPedido,'%d/%m/%Y') as FechaPedido, DATE_FORMAT(C.FechaEntrega,'%d/%m/%Y') as FechaEntrega, C.Iva, C.ImporteTotal FROM ".self::$tablename." as C INNER JOIN proveedores as P ON C.IDproveedor = P.IdProveedor WHERE C.IDcompra='{$id}' ORDER BY C.IDcompra DESC";
		return Executor::doit($sql);
	}
	public function GetAllCompraExcel(){
		$sql="SELECT
				P.Nombre,
				P.ActComercial,
				P.RFC,
				P.Domicilio,
				C.IDcompra,
				C.Num_compra,
				DATE_FORMAT(C.FechaPedido,'%d/%m/%Y') as FechaPedido,
				DATE_FORMAT(C.FechaEntrega,'%d/%m/%Y') as FechaEntrega,
				C.ImporteTotal
				FROM ordencompra as C
				INNER JOIN proveedores as P ON C.IDproveedor = P.IdProveedor ORDER BY C.IDcompra DESC";
		return Executor::doit($sql);
	}
	public function GetCompra_detallePDF($id)
	{
		$sql="SELECT C.Cantidad, C.Precio_unitario, C.Importe_parcial,
			(SELECT bi.Foliorequisicion FROM bitacora AS bi WHERE bi.IdBitacora=C.IDrequisicion) AS Folio,
			(SELECT d.nombreDepto FROM departamento AS d WHERE d.idDepart=C.IDdep) AS departamento,
			(SELECT M.Concepto FROM materiales AS M WHERE M.IDmaterial=C.Descripcion) AS Descripcion,
			(SELECT Me.Medida FROM materiales AS Me WHERE Me.IDmaterial=C.Descripcion) AS Medida
			FROM compra_detalle_descripcion AS C WHERE C.IDcompra='{$id}'";
		return Executor::doit($sql);
	}
	public function FoliosRequisicion()
	{
		$Anio=date('Y');
		$sql="SELECT bi.IdBitacora,bi.IdDep,bi.Foliorequisicion,bi.FechaEntrega,(SELECT nombreDepto FROM departamento AS dep WHERE bi.IdDep = dep.idDepart) AS departamento,(SELECT sum(rd.Cantidad) FROM requisicion_detalle as rd WHERE rd.IDbitacora=bi.IdBitacora) as NumMaterialRd,(SELECT sum(cdd.Cantidad) FROM compra_detalle_descripcion as cdd where cdd.IDrequisicion=bi.IdBitacora) as NumMaterialOC  FROM bitacora AS bi WHERE bi.Estado='AUTORIZADO' AND YEAR(bi.FechaRecepcion)=$Anio";
		return Executor::doit($sql);
	}
	public function NumOrdenCompra()
	{
		$sql="SELECT IDcompra, Num_compra FROM ordencompra WHERE Num_estado = '0' AND FechaEntrega <= CURDATE()";
		return Executor::doit($sql);
	}
	// funcion para obtener el id del material de la tabla compra_detalle_descripcion
	public function MaterialOC($idRequisicion){
		$sql="SELECT rd.Proyecto,rd.Meta,rd.Cantidad,FORMAT(rd.Costo, 2) AS Costo, m.Concepto,m.Medida,p.Codigo,rd.Descripcion,rd.IdRequisicionDetalle,rd.Num_estado,CASE WHEN cdd.Descripcion is NULL THEN 0 ELSE 1 end as flag FROM requisicion_detalle as rd  INNER JOIN materiales as m ON m.IDmaterial=rd.Descripcion INNER JOIN partidas as p ON p.IdPartida=rd.Partida LEFT JOIN compra_detalle_descripcion as cdd ON rd.Descripcion= cdd.Descripcion where rd.IDbitacora='{$idRequisicion}'";
		return Executor::doit($sql);
	}

	public function datoGeneralOrd_Com($id)
	{
		$sql="SELECT IDcompra, Num_compra, FechaPedido, FechaEntrega,(SELECT p.Nombre FROM proveedores AS p WHERE p.IdProveedor=c.IDproveedor) AS NombreProveedor FROM ordencompra AS c WHERE c.Num_estado = 0 AND c.IDcompra = '{$id}'";
		return Executor::doit($sql);
	}
	public function GetCompra_detalle($id)
	{
		$sql="SELECT C.IDdetalleDescripcion, C.Cantidad,C.Descripcion ,C.Precio_unitario, C.Importe_parcial, C.Num_estado,
			(SELECT bi.Foliorequisicion FROM bitacora AS bi WHERE bi.IdBitacora=C.IDrequisicion) AS Folio,
			(SELECT d.nombreDepto FROM departamento AS d WHERE d.idDepart=C.IDdep) AS departamento,
			(SELECT M.Concepto FROM materiales AS M WHERE M.IDmaterial=C.Descripcion) AS DescripcionMaterial,
			(SELECT Me.Medida FROM materiales AS Me WHERE Me.IDmaterial=C.Descripcion) AS Medida
			FROM compra_detalle_descripcion AS C WHERE C.IDcompra='{$id}' AND C.Num_estado = '0'";
		return Executor::doit($sql);
	}
	public function getNumEstado($id)
	{
		$sql="SELECT Num_estado FROM compra_detalle_descripcion WHERE IDcompra='{$id}'";
		return Executor::doit($sql);
	}
	public function updateNumEstado($Tabla,$Tupla,$id)
	{
		$sql="UPDATE $Tabla SET Num_estado='1' WHERE $Tupla = '{$id}'";
		return Executor::doit($sql);
	}
	public function UltimoRegitro(){
     $sql="SELECT IF(count(*)=0,1,count(*)) as id FROM ordencompra";
     return Executor::doit($sql);
   }
	 public function DatoUser($ID,$tupla)
 	{
 		$sql = "SELECT s.IdUsuario,s.Nombre_User,s.IdDepartamento,d.nombreDepto FROM usuarios s INNER JOIN departamento as d ON s.IdDepartamento=d.idDepart WHERE $tupla = '{$ID}'";
 		return Executor::doit($sql);
 	}
 	public function relacionRBS(){
 		$Anio=date('Y');
 		$sql="SELECT  b.Foliorequisicion,o.Num_compra,o.FechaPedido, a.NombreArea ,CONCAT(ja.Subfijo,ja.Nombre,' ',ja.A_paterno,' ', ja.A_materno) as solicitante, b.Concepto, p.Codigo
 			from ordencompra as o
			INNER JOIN compra_detalle_descripcion as cdd ON cdd.IDcompra=o.IDcompra
			INNER JOIN bitacora as b ON b.IdBitacora=cdd.IDrequisicion
			INNER JOIN jefe_area as ja ON b.IdSolicitante=ja.IdJefe
			INNER JOIN area as a ON a.IdArea=ja.IdArea
			INNER JOIN materiales as m ON m.IDmaterial=cdd.Descripcion
			INNER JOIN partidas as p ON p.IdPartida= m.IdPartidas
			WHERE YEAR(o.FechaPedido)=$Anio
			GROUP BY o.Num_compra";
 		return Executor::doit($sql);
 	}
}

 ?>
