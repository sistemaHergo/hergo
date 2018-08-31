<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Reportes_model extends CI_Model  ////////////***** nombre del modelo 
{
	public function __construct()
	{	
		parent::__construct();
		$this->load->helper('date');
		date_default_timezone_set("America/La_Paz");
	}
	public function retornar_tabla($tabla)
	{
		$sql="SELECT * from $tabla";
		
		$query=$this->db->query($sql);		
		return $query;
	}
	public function retornarArticulos() {
		$sql="SELECT idArticulos, CodigoArticulo,Descripcion
		FROM hergo2.articulos_activos
		WHERE SUBSTRING(CodigoArticulo,1,2)<>'SR'";
		$query=$this->db->query($sql);		
		return $query;
	}
	public function retornarClientes3() {
		$sql="SELECT f.`cliente`, c.`nombreCliente`, c.`documento`
			FROM factura f
				INNER JOIN clientes c ON c.`idCliente` = f.`cliente`
				WHERE YEAR(f.`fechaFac`) BETWEEN (YEAR(NOW())-2) AND YEAR(NOW())
				GROUP BY f.`cliente`
				ORDER BY c.`nombreCliente`";
		$query=$this->db->query($sql);		
		return $query;
	}
	public function clientesFacturasPendientes() {
		$sql="SELECT f.`cliente` idCliente, c.`nombreCliente`, c.`documento`
		FROM pago p
			LEFT JOIN pago_factura pf ON p.`idPago` = pf.`idPago`
			left join factura f on f.`idFactura` = pf.`idFactura`
			INNER JOIN clientes c ON c.`idCliente`= f.`cliente`
		WHERE 
			f.`pagada` <>1 
			and f.`anulada` = 0 
			and p.`anulado` = 0
			group by f.`cliente`
			order by c.`nombreCliente` 
		";
		$query=$this->db->query($sql);		
		return $query;
	}
	public function retornar_tablaMovimiento($tipo)
    {
        $sql="SELECT * from tmovimiento where operacion='$tipo'";

		$query=$this->db->query($sql);
		return $query;
    }
	public function mostrarNEporFac($ini=null,$fin=null,$alm="") ///********* nombre de la funcion mostrar
	{ //cambiar la consulta
		$sql="SELECT e.nmov n,e.idEgresos,t.sigla, e.fechamov, c.nombreCliente, SUM(d.total) total,  e.estado,e.fecha, CONCAT(u.first_name,' ', u.last_name) autor, a.almacen, m.sigla monedasigla			FROM egresos e
			INNER JOIN egredetalle d
			ON e.idegresos=d.idegreso
			INNER JOIN tmovimiento t 
			ON e.tipomov = t.id 
			INNER JOIN clientes c 
			ON e.cliente=c.idCliente
			INNER JOIN users u 
			ON u.id=e.autor 
			INNER JOIN almacenes a 
			ON a.idalmacen=e.almacen 
			INNER JOIN moneda m 
			ON e.moneda=m.id 
            INNER JOIN tipocambio tc
            ON e.tipocambio=tc.id
			WHERE
			e.`estado`<>1
			AND t.id = 7
			AND e.fechamov 
			BETWEEN '$ini' AND '$fin'
			AND e.almacen LIKE '%$alm'
			GROUP BY e.idegresos
			ORDER BY c.nombreCliente";
		
		$query=$this->db->query($sql);		
		return $query;
	}
	public function mostrarFacturasPendientesPago($cliente="", $almacen="")
	{ 
		$sql="SELECT  idFactura, idPago, lote , nFac, almacen, fecha, CONCAT(glosaFactura, ' ',glosaPago) glosa, 
		totalFactura, IFNULL(SUM(monto),0) totalPago , totalFactura-IFNULL(SUM(monto),0) saldo, nombreCliente
		FROM 
		(
			SELECT 
				f.`idFactura`, f.`lote` lote, f.`almacen`, f.`fechaFac` fecha,f.`nFactura` nFac,f.`cliente` cliente, 
				f.`total` totalFactura, f.`glosa` glosaFactura, f.`pagada` , pf.`monto`,IFNULL(p.`anulado`,0) pagoAnulado, p.`idPago`, p.`glosa` glosaPago, c.`nombreCliente`
			FROM factura f
			LEFT JOIN pago_factura pf ON f.`idFactura` = pf.`idFactura`
			LEFT JOIN pago p ON p.`idPago` = pf.`idPago` 
			INNER JOIN clientes c ON f.`cliente` = c.`idCliente`
			WHERE 
				f.`anulada` = 0 
				AND f.`pagada` <>1 
				AND f.`almacen` LIKE '%$almacen'
				AND f.`cliente` LIKE '%$cliente'
		
		) tbl
		WHERE pagoAnulado = 0
		GROUP BY idFactura
		ORDER BY nombreCliente, fecha";
		
		$query=$this->db->query($sql);		
		return $query;
	}
	public function mostrarListaPrecios() ///********* nombre de la funcion mostrar
	{ //cambiar la consulta
		$sql="SELECT CodigoArticulo, Descripcion, unidad.Sigla, precio.precio AS Bolivianos, precio.precio/6.96 AS Dolares
			FROM articulos
			INNER JOIN unidad ON unidad.idUnidad=articulos.idUnidad
			INNER JOIN precio ON precio.idArticulo=articulos.idArticulos
			ORDER BY CodigoArticulo";
		
		$query=$this->db->query($sql);		
		return $query;
	}
	public function mostrarSaldos() ///********* nombre de la funcion mostrar
	{ //cambiar la consulta
		$sql="SELECT * FROM hergo2.articulos_activos
		WHERE SUBSTRING(CodigoArticulo,1,2)<>'SR'";
		$query=$this->db->query($sql);		
		return $query;
	}
	public function mostrarFacturacionClientes($ini=null,$fin=null,$alm="") ///********* nombre de la funcion mostrar
	{ //cambiar la consulta
		$sql="SELECT clientes.nombreCliente, SUM(total) AS total
			FROM factura
			INNER JOIN clientes ON clientes.idCliente = factura.cliente
			WHERE fechaFac BETWEEN '$ini' AND '$fin'
			AND factura.almacen LIKE '%$alm'
			AND factura.anulada = 0
			GROUP BY clientes.nombreCliente
			ORDER BY total DESC";
		
		$query=$this->db->query($sql);		
		return $query;
	}
	public function mostrarVentasLineaMes($ini=null,$fin=null,$alm="") ///********* nombre de la funcion mostrar
	{ //cambiar la consulta
		$sql="	SELECT linea.Sigla, linea.Linea, sum(facturadetalle.facturaCantidad*facturadetalle.facturaPUnitario) as total
				from facturadetalle
				inner join articulos on articulos.idArticulos = facturadetalle.articulo
				inner join linea on linea.idLinea=articulos.idLinea
				inner join factura on factura.idFactura=facturadetalle.idFactura
				where fechaFac between '$ini' and '$fin'
				and factura.anulada = 0
				and factura.almacen LIKE '%$alm'
				group by linea
				order by sigla";
		
		$query=$this->db->query($sql);		
		return $query;
	}
	public function mostrarLibroVentas($ini=null,$fin=null,$alm="") ///********* nombre de la funcion mostrar
	{ //cambiar la consulta
		$sql="SELECT fechaFac, nFactura, df.autorizacion, anulada, c.documento, c.nombreCliente,
		IF(f.`anulada`=1,0,f.`total`) sumaDetalle,
		IF(anulada = 1 , 0 , ROUND ((f.total*13/100),2))  AS debito, 
		IFNULL(codigoControl, 0) AS codigoControl , df.manual
		FROM factura AS f
		INNER JOIN datosfactura AS df ON df.idDatosFactura=f.lote
		INNER JOIN clientes AS c ON c.idCliente = f.cliente
		WHERE fechaFac BETWEEN '$ini' AND '$fin'
		AND f.almacen LIKE '$alm'
		ORDER BY  df.manual, nFactura
		";
		
		$query=$this->db->query($sql);		
		return $query;
	}
	public function mostrarLibroVentasTotales($ini=null,$fin=null,$alm="") 
	{ //cambiar la consulta
		$sql="SELECT IFNULL(NULL, 'TotalFacturas') AS titulo,COUNT(anulada) AS resultado
		FROM factura AS f
		WHERE fechaFac BETWEEN '$ini' AND '$fin'
		AND f.almacen LIKE '%$alm'
		UNION
		/*validas*/
		SELECT IFNULL(NULL, 'validas') as titulo,COUNT(anulada) AS resultado
		FROM factura AS f
		WHERE fechaFac BETWEEN '$ini' AND '$fin'
		AND f.almacen LIKE '%$alm'
		AND anulada=0
		union
		/*anuladas*/
		SELECT IFNULL(NULL, 'anuladas') ,COUNT(anulada) AS anuladogffg
		FROM factura AS f
		WHERE fechaFac BETWEEN '$ini' AND '$fin'
		AND f.almacen LIKE '%$alm'
		AND anulada=1
		union
		/*contar manual*/
		SELECT IFNULL(NULL, 'manuales') ,COUNT(df.manual)
		FROM factura AS f
		INNER JOIN datosfactura AS df ON df.idDatosFactura=f.lote
		WHERE fechaFac BETWEEN '$ini' AND '$fin'
		AND f.almacen LIKE '%$alm'
		AND df.manual=1
		union
		/*contar computarizadas*/
		SELECT IFNULL(NULL, 'computarizadas') ,COUNT(df.manual)
		FROM factura AS f
		INNER JOIN datosfactura AS df ON df.idDatosFactura=f.lote
		WHERE fechaFac BETWEEN '$ini' AND '$fin'
		AND f.almacen LIKE '%$alm'
		AND df.manual=0
		union
		/*Suma Total*/
		SELECT IFNULL(NULL, 'Total') ,ROUND ((SUM(fd.facturaPUnitario*fd.facturaCantidad)),2) AS sumaTotal
		FROM factura AS f
		INNER JOIN datosfactura AS df ON df.idDatosFactura=f.lote
		INNER JOIN facturadetalle AS fd ON fd.idFactura=f.idFactura
		WHERE fechaFac BETWEEN '$ini' AND '$fin'
		AND f.almacen LIKE '%$alm'
		AND anulada=0
		union
		/*Suma Debito*/
		SELECT IFNULL(NULL, 'debito') ,ROUND ((SUM(fd.facturaPUnitario*fd.facturaCantidad)*13/100),2) AS debito
		FROM factura AS f
		INNER JOIN datosfactura AS df ON df.idDatosFactura=f.lote
		INNER JOIN clientes AS c ON c.idCliente = f.cliente
		INNER JOIN facturadetalle AS fd ON fd.idFactura=f.idFactura
		WHERE fechaFac BETWEEN '$ini' AND '$fin'
		AND f.almacen LIKE '%$alm'
		AND anulada=0
		 ";
		
		$query=$this->db->query($sql);		
		return $query;
	}
	public function mostrarDiarioIngresos($ini=null,$fin=null,$alm="",$tin="") 
	{ //cambiar la consulta
		$sql="SELECT alm.almacen, i.fechamov, i.tipomov,t.sigla, i.nmov, i.ordcomp, i.ningalm, p.nombreproveedor, 
		a.CodigoArticulo, a.Descripcion, u.Unidad,  id.cantidad, id.punitario, id.total, i.obs
		from ingresos i
		inner join provedores p
		on p.idproveedor=i.proveedor
		inner join ingdetalle id
		on id.idIngreso= i.idIngresos
		inner join articulos a
		on a.idArticulos= id.articulo
		inner join unidad u
		on u.idUnidad=a.idUnidad
		inner join tmovimiento t
		on t.id= i.tipomov
		inner join almacenes alm
		on alm.idalmacen = i.almacen
		where i.fechamov BETWEEN '$ini' AND '$fin'
		and i.tipomov like '%$tin' AND i.almacen LIKE '%$alm'
		order by alm.almacen, i.nmov, id.articulo";
		
		$query=$this->db->query($sql);		
		return $query;
	}
	public function mostrarKardexIndividual($art="",$alm="") 
	{ 
		if ($alm=="") {
			$sql="call hergo2.testKardexGeneral($art);";
		} else {
			$sql="call hergo2.testKardex2($art,$alm);";
		}
		$query=$this->db->query($sql);		
		return $query;
	}
	public function kardexIndividualCliente($cliente,$almacen="",$ini,$fin) {
		$sql="SELECT * FROM 
		(	SELECT    c.`idCliente`, c.`nombreCliente`,'$ini' fecha, '-' numDocumento, '1' almacen,  'SALDO INICIAL' detalle,  
					IFNULL((SELECT ROUND(SUM(`ed`.`total`), 2) `saldoTotalNE`
					FROM`egresos` `e`
						INNER JOIN `egredetalle` `ed` ON `ed`.`idegreso` = `e`.`idegresos`
					WHERE
						`e`.`fechamov` < '$ini'
						AND `e`.`estado` <> 1
						AND `e`.`anulado` = 0
						AND `e`.`almacen` LIKE '%$almacen'
						AND `e`.`cliente` = '$cliente'
					GROUP BY e.`cliente`),0) saldoNE, 

					IFNULL((SELECT ROUND(SUM(`f`.`total`), 2) `saldoTotalFactura`
					FROM `factura` `f`
					WHERE
						`f`.`fechaFac` < '$ini'
						AND `f`.`anulada` = 0
						AND `f`.`almacen` LIKE '%$almacen'
						AND `f`.`cliente` = '$cliente'
					GROUP BY f.`cliente`),0) saldoTotalFactura, 

					IFNULL((SELECT ROUND(SUM(`pf`.`monto`), 2) AS `saldoTotalPago`
					FROM `pago_factura` `pf`
						INNER JOIN `pago` `p` ON `p`.`idPago` = `pf`.`idPago` AND `p`.`anulado` = 0
						INNER JOIN `factura` `f` ON `f`.`idFactura` = `pf`.`idFactura`	AND `f`.`anulada` = 0
					WHERE
						`p`.`fechaPago` < '$ini'
						AND `p`.`almacen` LIKE '%$almacen'
						AND f.cliente = '$cliente'
					GROUP BY f.cliente),0) saldoTotalPago
				FROM clientes c
				WHERE c.`idCliente` = '$cliente'
			UNION ALL
				SELECT c.`idCliente`, c.`nombreCliente`, f.fechaFac, f.nFactura, f.almacen,     
					IFNULL(f.glosa,'') detalle, 
					0 , ROUND(f.`total`,2) saldoTotalFactura, 0
				FROM factura f  
					INNER JOIN clientes c ON c.`idCliente` = f.`cliente`
				WHERE  f.`fechaFac` BETWEEN '$ini' AND '$fin'
					AND f.`anulada` = 0
					AND f.almacen LIKE '%$almacen'
					AND c.`idCliente` = '$cliente'
			UNION ALL
				SELECT c.`idCliente`, c.`nombreCliente`,  e.`fechamov`, e.`nmov`, e.`almacen`, e.`obs`, ROUND(SUM(ed.`total`),2) saldoTotalNE , 0 , 0 
				FROM egresos e
					INNER JOIN egredetalle ed ON ed.`idegreso` = e.`idegresos`
					INNER JOIN clientes c ON c.`idCliente` = e.`cliente`
				WHERE  e.`fechamov` BETWEEN '$ini' AND '$fin'
					AND e.`estado` <> 1
					AND e.`anulado` = 0
					AND e.almacen LIKE '%$almacen'
					AND e.`cliente` = '$cliente'
			UNION ALL 
				SELECT c.`idCliente`, c.`nombreCliente`, p.`fechaPago`, p.`numPago`, p.`almacen`, 
					CONCAT('Fac. ',f.`lote`,'-',f.nFactura,', ',p.`glosa`) glosa,
					0 , 0, ROUND(pf.`monto`,2) saldoTotalPago
				FROM pago_factura pf
					INNER JOIN pago p ON p.`idPago` = pf.`idPago` AND p.`anulado` = 0
					INNER JOIN factura f ON f.`idFactura` = pf.`idFactura` AND f.`anulada` = 0
					INNER JOIN clientes c ON c.`idCliente` = f.`cliente`
				WHERE   p.`fechaPago` BETWEEN '$ini' AND '$fin'
					AND p.almacen LIKE '%$almacen'
					AND c.`idCliente` = '$cliente'
		) kardexClientes
		ORDER BY fecha";
		$query=$this->db->query($sql);		
		return $query;
	}
	public function mostrarEstadoVentasCosto($alm="")
	{ 
		$sql="SELECT 
		sigla, linea, idArticulo,  
		IF(codigo IS NULL, '', descrip) descrip, 
		IF(codigo IS NULL, '', unidad) unidad, 
		IF(codigo IS NULL, '', costo) costo, 
		IF(codigo IS NULL, '', ppVenta) ppVenta, 
		IF(codigo IS NULL, '', saldo) saldo,
		IF(codigo IS NULL, '', cantidadVendida) cantidadVendida,
		saldoValorado, totalCosto, totalVentas, utilidad, 
		CASE
			WHEN codigo IS NULL AND sigla IS NULL THEN 'TOTAL GENERAL'
			WHEN codigo IS NULL THEN CONCAT('TOTAL ', linea)
			ELSE codigo
		END codigo
		FROM(
		SELECT sigla, linea, 
		idArticulo idArticulo, codigo, descrip, unidad, costo, ppVenta, saldo,
		SUM(saldoValorado) saldoValorado, cantidadVendida, SUM(totalCosto) totalCosto, SUM(totalVentas) totalVentas, SUM(utilidad) utilidad
		FROM
		(
		SELECT l.`Sigla` sigla, l.`Linea` linea, idArticulo, a.`CodigoArticulo` codigo, a.`Descripcion` descrip, u.`Unidad` unidad, a.`costoPromedioPonderado` costo, IFNULL(ppVenta,0) ppVenta , saldo,
		(a.`costoPromedioPonderado` * saldo) saldoValorado, cantidadVendida, (cantidadVendida * a.`costoPromedioPonderado`) totalCosto, (cantidadVendida * IFNULL(ppVenta,0)) totalVentas,
		((cantidadVendida * IFNULL(ppVenta,0)) - (cantidadVendida * a.`costoPromedioPonderado`)) utilidad
		FROM (
		SELECT *
		FROM
		(
		SELECT sa.idArticulo , sa.saldo, sa.`facturado` cantidadVendida 
		FROM saldoarticulos sa
		WHERE sa.`idAlmacen` LIKE '%$alm'
		) sal
		LEFT JOIN ( SELECT * FROM (
			SELECT fd.articulo , (SUM(fd.`facturaPUnitario` * fd.facturaCantidad) ) / SUM(fd.`facturaCantidad`)  ppVenta
			FROM factura f
			INNER JOIN facturadetalle fd ON fd.`idFactura` = f.`idFactura`
			INNER JOIN articulos a ON a.idArticulos = fd.articulo
			WHERE YEAR(f.`fechaFac`)=YEAR(NOW()) AND f.`anulada` = 0 AND f.`almacen` LIKE '%$alm'
			GROUP BY fd.articulo
			)tbl) ppv ON ppv.articulo = idArticulo
		) todo
		INNER JOIN articulos a ON a.`idArticulos` = idArticulo
		INNER JOIN unidad u ON u.`idUnidad`= a.`idUnidad`
		INNER JOIN linea l ON l.`idLinea` = a.`idLinea`
		ORDER BY l.`Sigla`, a.`CodigoArticulo`
		) tbl
		GROUP BY sigla, codigo WITH ROLLUP
		)roll		
		";
		$query=$this->db->query($sql);		
		return $query;
	}
	public function mostrarSaldosActualesItems($alm="",$linea="")
	{ 
		if ($alm >0) {
			$sql = "SELECT 
			IF(codigo IS NULL,'',codigo) codigo, 
			IF(codigo IS NULL,'',descripcion) descripcion, 
			IF(codigo IS NULL AND linea IS NULL,'TOTAL GENERAL: ',IF(codigo IS NULL,CONCAT('TOTAL ',linea), almacen)) almacen, 
			IF(codigo IS NULL,'',costo) costo, 
			IF(codigo IS NULL,'',saldo) saldo, 
			IF(codigo IS NULL,'',remision) remision, 
			IF(codigo IS NULL,'',saldoAlm) saldoAlm, 
			vTotal, linea, 
			IF(codigo IS NULL,'',unidad) unidad
			FROM (
			SELECT 
			IF(alm.almacen IS NULL,'',a.`CodigoArticulo`) codigo, 
			IF(a.`CodigoArticulo`IS NULL,'',a.`Descripcion`) descripcion,
			IF(l.`Linea` IS NULL,'TOTAL ',alm.`almacen`)almacen, 
			a.`costoPromedioPonderado` costo, 
			SUM((sa.`saldo` +  sa.`notaEntrega`)) saldo,
			SUM(sa.`notaEntrega`) remision, 
			SUM(`saldo`) saldoAlm,
			SUM((sa.`saldo` * a.costoPromedioPonderado)) vTotal,
			IF(alm.`almacen` IS NULL,'',l.Linea) linea, u.`Unidad`
			FROM saldoarticulos sa
			INNER JOIN articulos a ON a.`idArticulos` = sa.`idArticulo`
			INNER JOIN almacenes alm ON alm.idalmacen = sa.idAlmacen
			INNER JOIN linea l ON l.idLinea = a.idLinea
			INNER JOIN unidad u ON u.`idUnidad` = a.`idUnidad`
			WHERE sa.`idAlmacen` = $alm
			GROUP BY    l.`Linea` ASC, a.`CodigoArticulo` ASC WITH ROLLUP
			) tbl";
		} else {
		$sql="SELECT 	sigla,
		IF(almacen IS NULL,'', linea) linea,  
		IF(almacen IS NULL,'', codigo) codigo,  
		IF(almacen IS NULL,'', costo) costo, 
		IF(almacen IS NULL,'', saldo) saldo, 
		IF(almacen IS NULL,'', remision) remision, 
		IF(almacen IS NULL,'', saldoAlm)saldoAlm, 
		vTotal, 
		IF(almacen IS NULL,'', descripcion) descripcion, 
		IF(almacen IS NULL,'', unidad) unidad,  
		CASE
			WHEN sigla IS NULL AND codigo IS NULL AND almacen IS NULL THEN CONCAT('TOTAL GENERAL')
			WHEN codigo IS NULL AND almacen IS NULL THEN CONCAT('TOTAL ', linea)
			WHEN almacen IS NULL THEN CONCAT('TOTAL ', codigo)
			ELSE almacen
		END almacen
		FROM( 
			SELECT 
			l.`Sigla` sigla, u.unidad,
			a.`CodigoArticulo` codigo, 
			a.`Descripcion` descripcion,
			alm.almacen almacen, 
			a.`costoPromedioPonderado` costo, 
			SUM((sa.`saldo` +  sa.`notaEntrega`)) saldo, 
			SUM(sa.`notaEntrega`) remision, 
			SUM(sa.`saldo`) saldoAlm,
			SUM((sa.`saldo` * a.costoPromedioPonderado)) vTotal,
			l.`Linea` linea
			FROM saldoarticulos sa
			INNER JOIN articulos a ON a.`idArticulos` = sa.`idArticulo`
			INNER JOIN almacenes alm ON alm.idalmacen = sa.idAlmacen
			INNER JOIN linea l ON l.idLinea = a.idLinea
			INNER JOIN unidad u ON u.idUnidad = a.idUnidad
			GROUP BY  l.`Sigla`, a.`CodigoArticulo` ASC, alm.almacen ASC WITH ROLLUP
		)tbl";
		}		
		
		$query=$this->db->query($sql);		
		return $query;
	}

}
