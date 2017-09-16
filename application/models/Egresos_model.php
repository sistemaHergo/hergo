<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Egresos_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('date');
		date_default_timezone_set("America/La_Paz");
	}
	public function mostrarEgresos($id=null,$ini=null,$fin=null,$alm="",$tin="")
	{
		if($id==null) //no tiene id de entrada
        {
		  $sql="
			SELECT e.nmov n,e.idEgresos,t.sigla,t.tipomov, e.fechamov, c.nombreCliente, sum(d.total) total,  e.estado,e.fecha, CONCAT(u.first_name,' ', u.last_name) autor, e.moneda, a.almacen, m.sigla monedasigla, e.obs, e.anulado, e.plazopago, e.clientePedido,c.idcliente,c.documento
			FROM egresos e
			INNER JOIN egredetalle d
			on e.idegresos=d.idegreso
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
			WHERE e.fechamov 
			BETWEEN '$ini' AND '$fin' and e.almacen like '%$alm' and t.id like '%$tin'
			Group By e.idegresos
			ORDER BY e.idEgresos DESC	
            ";

        }
        else/*REVISAR!!!!!!!!!!!!!!!!!!SELECT i.nmov n,i.idIngresos,t.sigla,t.tipomov,t.id as idtipomov, i.fechamov, p.nombreproveedor,p.idproveedor, i.nfact,
                (SELECT FORMAT(SUM(d.total),2) from ingdetalle d where  d.idIngreso=i.idIngresos) total, i.estado,i.fecha, CONCAT(u.first_name,' ', u.last_name) autor, i.moneda, m.id as idmoneda, a.almacen, a.idalmacen, m.sigla monedasigla, i.ordcomp,i.ningalm, i.obs, i.anulado,i.tipocambio
            FROM ingresos i*/
        {            
             $sql="
            SELECT e.nmov n,e.idEgresos,t.sigla,t.tipomov, e.fechamov,t.id as idtipomov, c.nombreCliente,c.idcliente, sum(d.total) total,  e.estado,e.fecha, CONCAT(u.first_name,' ', u.last_name) autor, e.moneda, a.almacen, a.idalmacen, m.sigla monedasigla, m.id as idmoneda, e.obs, e.anulado, e.plazopago, e.clientePedido,c.documento
            FROM egresos e
            INNER JOIN egredetalle d
            on e.idegresos=d.idegreso
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
            WHERE idEgresos=$id
            ORDER BY e.idEgresos DESC
            LIMIT 1   
            ";
        }

		$query=$this->db->query($sql);
		return $query;
	}
	public function mostrarDetalle($id)//lista todos los detalles de un egreso
	{
		$sql="SELECT a.CodigoArticulo, a.Descripcion, e.cantidad, FORMAT(e.punitario,3) punitario1, e.punitario, e.total total, e.descuento, e.idingdetalle, e.idegreso, u.Sigla, (e.cantidad-e.cantFact) cantidadReal, e.cantFact
		FROM egredetalle e
		INNER JOIN articulos a
		ON e.articulo = a.idArticulos
        INNER JOIN unidad u
        ON a.idUnidad=u.idUnidad
 		WHERE e.idegreso=$id";

		$query=$this->db->query($sql);
		return $query;
	}
    public function retornarEgreso($id)
    {
        $sql="SELECT *
        FROM egresos e        
        WHERE e.idEgresos=$id";     

        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $fila=$query->row();
            return $fila;
        }
        else
        {

            return false;
        }
    }
    public function mostrarDetalleFacturas($id)//lista todos los detalles de un egreso
    {
        $sql="SELECT a.CodigoArticulo, a.Descripcion, e.cantidad, FORMAT(e.punitario,3) punitario1, e.punitario, e.total total, e.descuento, e.idingdetalle, e.idegreso, u.Sigla, (e.cantidad-e.cantFact) cantidadReal
        FROM egredetalle e
        INNER JOIN articulos a
        ON e.articulo = a.idArticulos
        INNER JOIN unidad u
        ON a.idUnidad=u.idUnidad
        WHERE e.idegreso=$id
        and e.cantidad-cantFact>0"; //esta linea omite mostrar registros con la cantidad de facturas completa

        $query=$this->db->query($sql);
        return $query;
    }
    public function ObtenerDetalle($id)//obtiene por idingdetalle // deberia ser egredetalle
    {
        $sql="SELECT a.CodigoArticulo, a.Descripcion, e.cantidad, FORMAT(e.punitario,3) punitario1,e.punitario, e.total total, e.descuento, e.idingdetalle, e.idegreso, u.Sigla,(e.cantidad-e.cantFact) cantidadReal
        FROM egredetalle e
        INNER JOIN articulos a
        ON e.articulo = a.idArticulos
        INNER JOIN unidad u
        ON a.idUnidad=u.idUnidad
        WHERE e.idingdetalle=$id
        and e.cantidad-cantFact>0"; //esta linea omite mostrar registros con la cantidad de facturas completa

        $query=$this->db->query($sql);
        return $query;
    }
    /*public function mostrarEgresosDetalle($id=null,$ini=null,$fin=null,$alm="",$tin="")
    {       
        $sql="SELECT *
                FROM (SELECT i.nmov n,i.idIngresos, i.fechamov, p.nombreproveedor, i.nfact, CONCAT(u.first_name,' ', u.last_name) autor, i.fecha,t.tipomov,a.almacen, m.sigla monedasigla, i.ordcomp,i.ningalm FROM ingresos i INNER JOIN tmovimiento t ON i.tipomov = t.id INNER JOIN provedores p ON i.proveedor=p.idproveedor INNER JOIN users u ON u.id=i.autor INNER JOIN almacenes a ON a.idalmacen=i.almacen INNER JOIN moneda m ON i.moneda=m.id WHERE i.fechamov BETWEEN '$ini' AND '$fin' and i.almacen like '%$alm' and t.id like '%$tin' ORDER BY i.idIngresos DESC) tabla
                INNER JOIN ingdetalle id
                ON tabla.idIngresos=id.idIngreso
                INNER JOIN articulos ar
                ON ar.idArticulos=id.articulo                
                ";
        die($sql);
        $query=$this->db->query($sql);
        return $query;
    }*/
	public function guardarmovimiento_model($datos)
    {

		$almacen_ne=$datos['almacen_ne'];
    	$tipomov_ne=$datos['tipomov_ne'];
    	$fechamov_ne=$datos['fechamov_ne'];
    	$fechapago_ne=$datos['fechapago_ne'];
    	$moneda_ne=$datos['moneda_ne'];
    	$idCliente=$datos['idCliente'];
    	$pedido_ne=$datos['pedido_ne'];
    	$obs_ne=$datos['obs_ne'];
    
        $tipocambio=$this->retornarTipoCambio();

        
        $gestion= date("Y", strtotime($fechamov_ne));
       // echo $almacen_imp;
    	$autor=$this->session->userdata('user_id');
		$fecha = date('Y-m-d H:i:s');
        $nummov=$this->retornarNumMovimiento($tipomov_ne,$gestion,$almacen_ne);
    	$sql="INSERT INTO egresos (almacen,tipomov,nmov,fechamov,cliente,moneda,obs,tipocambio,autor,fecha,plazopago,clientePedido) VALUES('$almacen_ne','$tipomov_ne','$nummov','$fechamov_ne','$idCliente','$moneda_ne','$obs_ne','$tipocambio','$autor','$fecha','$fechapago_ne','$pedido_ne')";
    	$query=$this->db->query($sql);
    	$idEgreso=$this->db->insert_id();
    	if($idEgreso>0)/**Si se guardo correctamente se guarda la tabla*/
    	{
            
    		foreach ($datos['tabla'] as $fila) {
    			//print_r($fila);
    			$idArticulo=$this->retornar_datosArticulo($fila[0]);    			
                $totalbs=$fila[6];
                $punitariobs=$fila[5];
                $totaldoc=$fila[4];
    			if($idArticulo)
    			{
    				$sql="INSERT INTO egredetalle(idegreso,nmov,articulo,moneda,cantidad,punitario,total,descuento) VALUES('$idEgreso','0','$idArticulo','$moneda_ne','$fila[2]','$fila[3]','$fila[5]','$fila[4]')";
    				$this->db->query($sql);
    			}
    		}
    		//return true;
            return $idEgreso;
    	}
    	else
    	{
    		return false;
    	}
    }
    public function retornarNumMovimiento($tipo,$gestion,$almacen)
    {
        $sql="SELECT nmov from egresos WHERE YEAR(fechamov)= '$gestion' and almacen='$almacen' and tipomov='$tipo' ORDER BY nmov DESC LIMIT 1";
        
        $resultado=$this->db->query($sql);
        if($resultado->num_rows()>0)
        {
            $fila=$resultado->row();
            return ($fila->nmov)+1;
        }
        else
        {

            return 1;
        }
    }
    public function retornarTipoCambio()/*retorna el ultimo tipo de cambio*/
    {
        //$sql="SELECT nmov from ingresos WHERE YEAR(fechamov)= '$gestion' and almacen='$almacen' and tipomov='$tipo' ORDER BY nmov DESC LIMIT 1";
        $sql="SELECT id from tipocambio ORDER BY id DESC LIMIT 1";

        $resultado=$this->db->query($sql);
        if($resultado->num_rows()>0)
        {
            $fila=$resultado->row();
            return ($fila->id);
        }
        else
        {
            return 1;
        }
    }
   // public function retornarValorTipoCambio()/*retorna el ultimo tipo de cambio*/
  /*  {
        //$sql="SELECT nmov from ingresos WHERE YEAR(fechamov)= '$gestion' and almacen='$almacen' and tipomov='$tipo' ORDER BY nmov DESC LIMIT 1";
        $sql="SELECT * from tipocambio ORDER BY id DESC LIMIT 1";

        $resultado=$this->db->query($sql);
        if($resultado->num_rows()>0)
        {
            $fila=$resultado->row();
            return ($fila->tipocambio);
        }
        else
        {
            return 1;
        }
    }*/
     public function retornar_datosArticulo($dato)
    {
    	$sql="SELECT idArticulos from articulos where CodigoArticulo='$dato' LIMIT 1";
    	$query=$this->db->query($sql);
    	if($query->num_rows()>0)
    	{
    		$fila=$query->row();
    		return $fila->idArticulos;
    	}
    	else
    	{

    		return false;
    	}
    }
    public function retornar_facturas($id_egreso)
    {
        $sql="SELECT f.nFactura
            from factura_egresos fe
            inner join factura f
            on fe.idFactura=f.idFactura
            where fe.idegresos=$id_egreso
            Group by fe.idFactura";
        $query=$this->db->query($sql);
        $res=$query->result_array();
        return $res;
    }
	public function actualizarmovimiento_model($datos)
    {
        

        $idegreso=$datos['idegreso'];
        $tipomov_ne=$datos['tipomov_ne'];
        $fechapago_ne=$datos['fechapago_ne'];
        $moneda_ne=$datos['moneda_ne'];
        $idCliente=$datos['idCliente'];
        $pedido_ne=$datos['pedido_ne'];
        $obs_ne=$datos['obs_ne'];
       
        

        $autor=$this->session->userdata('user_id');
        $fecha = date('Y-m-d H:i:s');

        //$idtipocambio=$this->retornaridtipocambio($idingresoimportacion);
        $tipocambio=$this->retornarValorTipoCambio();
        $tipocambioid=$tipocambio->id;
        $tipocambiovalor=$tipocambio->tipocambio;
        //$sql="UPDATE ingresos SET almacen='$almacen_imp',tipomov='$tipomov_imp',fechamov='$fechamov_imp',proveedor='$proveedor_imp',moneda='$moneda_imp',nfact='$nfact_imp',ningalm='$ningalm_imp',ordcomp='$ordcomp_imp',obs='$obs_imp',fecha='$fecha',autor='$autor' where idIngresos='$idingresoimportacion'";
        $sql="UPDATE egresos SET tipomov='$tipomov_ne',plazopago='$fechapago_ne',moneda='$moneda_ne',cliente='$idCliente',clientePedido='$pedido_ne',obs='$obs_ne',fecha='$fecha',autor='$autor' where idEgresos='$idegreso'";
        $query=$this->db->query($sql);

        $sql="DELETE FROM egredetalle where idegreso='$idegreso'";

        $this->db->query($sql);
       /* echo "<pre>";
        print_r($datos['tabla']);
        echo "</pre>";*/
       // die($tipocambiovalor);
        foreach ($datos['tabla'] as $fila)
        {
            $idArticulo=$this->retornar_datosArticulo($fila[0]);
            if($idArticulo)
            {
               // $sql="INSERT INTO ingdetalle(idIngreso,articulo,moneda,cantidad,punitario,total) VALUES('$idingresoimportacion','$idArticulo','$moneda_imp','$fila[2]','$fila[3]','$fila[4]')";
                $totalbs=$fila[5];
                $punitariobs=$fila[3];
                //$totaldoc=$fila[4];
                if($moneda_ne==2) //convertimos en bolivianos si la moneda es dolares
                {
                    $totalbs=$totalbs*$tipocambiovalor;
                    //echo $totalbs." ";
                    $punitariobs=$punitariobs*$tipocambiovalor;
                   // echo $punitariobs." ";
                    $totaldoc=$totaldoc*$tipocambiovalor;
                   // echo $totaldoc." ";
                }
         
                $sql="INSERT INTO egredetalle(idegreso,nmov,articulo,cantidad,punitario,total,descuento) VALUES('$idegreso','0','$idArticulo','$fila[2]','$punitariobs','$totalbs','$fila[4]')";
                $this->db->query($sql);
            }
        }
        return true;

    }
    public function retornarValorTipoCambio($id=null)/*retorna el ultimo tipo de cambio*/
    {
        //$sql="SELECT nmov from ingresos WHERE YEAR(fechamov)= '$gestion' and almacen='$almacen' and tipomov='$tipo' ORDER BY nmov DESC LIMIT 1";
        if($id==null)//si es null retorna el ultimo tipo de cambio
            $sql="SELECT * from tipocambio ORDER BY id DESC LIMIT 1";
        else//si no retorna segun el id
            $sql="SELECT * from tipocambio where id = '$id' ORDER BY id DESC LIMIT 1";
        //die($sql);
        $resultado=$this->db->query($sql);
        if($resultado->num_rows()>0)
        {
            $fila=$resultado->row();
            return ($fila);
        }
        else
        {
            return 1;
        }
    }
    public function puedeeditar($id)
    {
       
        $sql="SELECT estado from egresos where idegresos = '$id'"; 
        
        $resultado=$this->db->query($sql);
        if($resultado->num_rows()>0)
        {
            $fila=$resultado->row();

            if($fila->estado==0) // no esta facturado???
                return true;
            else
                return false;
        }
        else
        {            
            return false;
        }
    }
    public function retornarsaldoarticulo_model($id,$idAlmacen)
    {
        // quitar desc de la consulta para los ultimos datos de la tabla costoarticulo
        $sql="SELECT c.*
            FROM costoarticulos c
            WHERE c.idArticulo=$id AND c.idAlmacen=$idAlmacen
            ORDER By c.idtabla desc 
            limit 1 
            ";
 
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {                   
            return $query;    
        }
        else
        {
            return false;
        }        
    }
    
    public function retornarpreciorticulo_model($idArticulo)
    {
        // quitar desc de la consulta para los ultimos datos de la tabla costoarticulo
        $sql="SELECT *
            FROM precio p
            WHERE p.idArticulo=$idArticulo             
            limit 1 
            ";
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {                   
            return $query;    
        }
        else
        {
            return false;
        }        
    }
    public function ListarparaFacturacion($ini,$fin,$alm,$tipo)
    {
        /*$inicio=date('Y-m-d', strtotime($ini));
        $final=date('Y-m-d', strtotime($fin));*/
 
      /*  $this->db->select("e.nmov n,e.idEgresos,t.sigla,t.tipomov, e.fechamov, c.nombreCliente, sum(d.total) total,  e.estado,e.fecha, CONCAT(u.first_name,' ', u.last_name) autor, e.moneda, a.almacen, m.sigla monedasigla, e.obs, e.anulado, e.plazopago, e.clientePedido");
        $this->db->from("egresos e");
        $this->db->join("egredetalle d","e.idegresos=d.idegreso");
        $this->db->join("tmovimiento t","e.tipomov=t.id");
        $this->db->join("clientes c","e.cliente=c.idCliente");
        $this->db->join("users u","u.id=e.autor");
        $this->db->join("almacenes a","a.idalmacen=e.almacen");
        $this->db->join("moneda m","e.moneda=m.id");
        $this->db->where("e.fechamov BETWEEN '$ini' and '$fin'",NULL,FALSE);
        if($alm>0)
            $this->db->where("e.almacen",$alm);            
        if($tipo>0)
        {

            $this->db->where("e.tipomov",$tipo);
        }
        else
        {
            $this->db->where("e.tipomov",6);   
            $this->db->where("e.tipomov",7);
        }
        $query = $this->db->get();*/
        $sql="
            SELECT e.nmov n,e.idEgresos,t.sigla,t.tipomov, e.fechamov, c.nombreCliente, sum(d.total) total,  e.estado,e.fecha, CONCAT(u.first_name,' ', u.last_name) autor, e.moneda, a.almacen, m.sigla monedasigla, e.obs, e.anulado, e.plazopago, e.clientePedido,c.idcliente
            FROM egresos e
            INNER JOIN egredetalle d
            on e.idegresos=d.idegreso
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
            WHERE e.fechamov 
            BETWEEN '$ini' AND '$fin' and (e.estado=0 or e.estado=2) and e.anulado!=1";        
        if($alm>0)         
            $sql.=" and e.almacen=$alm";                
        if($tipo>0)
        {

            $sql.=" and e.tipomov=$tipo";
        }
        else
        {
            $sql.=" and (e.tipomov=6 or e.tipomov=7)";                        
        }
            $sql.=" Group By e.idegresos
            ORDER BY e.idEgresos DESC";
        
        $query=$this->db->query($sql);
        if($query->num_rows() > 0 )
            return $query->result();
        else
            return false;
    }
    public function actualizarCantFact($idIngDetalle,$cantFacturado)
    {
         $sql="UPDATE egredetalle
            set cantFact=cantFact+$cantFacturado
            WHERE idingdetalle=$idIngDetalle          
            ";
        $query=$this->db->query($sql);        
    }
    public function evaluarFacturadoTotal($idEgreso)
    {
        $sql="SELECT * from egredetalle where idegreso=$idEgreso and (cantidad-cantFact >0)";
        $query=$this->db->query($sql);
        return $query->result();
    }
     public function actualizarEstado($idEgreso,$estado)
    {
         $sql="UPDATE egresos
            set estado=$estado
            WHERE idEgresos=$idEgreso          
            ";
        $query=$this->db->query($sql);        
    }
}
