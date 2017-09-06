<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Facturas extends CI_Controller
{
	private $datos;
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		//$this->load->model("ingresos_model");
		$this->load->model("egresos_model");
		$this->load->model("cliente_model");
		$this->load->model("Facturacion_model");
		$this->load->model("DatosFactura_model");
		$this->load->model("FacturaDetalle_model");
		$this->load->model("FacturaEgresos_model");
		$this->load->helper('date');
		$this->load->helper('cookie');
		date_default_timezone_set("America/La_Paz");

		$this->cabeceras_css=array(
				base_url('assets/bootstrap/css/bootstrap.min.css'),
				base_url("assets/fa/css/font-awesome.min.css"),
				base_url("assets/dist/css/AdminLTE.min.css"),
				base_url("assets/dist/css/skins/skin-blue.min.css"),
				base_url("assets/hergo/estilos.css"),
				base_url('assets/plugins/table-boot/css/bootstrap-table.css'),
				base_url('assets/plugins/table-boot/plugin/select2.min.css'),
				base_url('assets/sweetalert/sweetalert.css'),

			);
		$this->cabecera_script=array(
				base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'),
				base_url('assets/bootstrap/js/bootstrap.min.js'),
				base_url('assets/dist/js/app.min.js'),
				base_url('assets/plugins/validator/bootstrapvalidator.min.js'),
				base_url('assets/plugins/table-boot/js/bootstrap-table.js'),
				base_url('assets/plugins/table-boot/js/bootstrap-table-es-MX.js'),
				base_url('assets/plugins/table-boot/js/bootstrap-table-export.js'),
				base_url('assets/plugins/table-boot/js/tableExport.js'),
				base_url('assets/plugins/table-boot/js/bootstrap-table-filter.js'),
				base_url('assets/plugins/table-boot/plugin/select2.min.js'),
				base_url('assets/plugins/table-boot/plugin/bootstrap-table-select2-filter.js'),
        		base_url('assets/plugins/daterangepicker/moment.min.js'),
        		base_url('assets/plugins/slimscroll/slimscroll.min.js'),
        		base_url('assets/sweetalert/sweetalert.min.js'),

			);
		$this->datos['nombre_usuario']= $this->session->userdata('nombre');
			if($this->session->userdata('foto')==NULL)
				$this->datos['foto']=base_url('assets/imagenes/ninguno.png');
			else
				$this->datos['foto']=base_url('assets/imagenes/').$this->session->userdata('foto');
	}
	
	public function index()
	{
		if(!$this->session->userdata('logeado'))
			redirect('auth', 'refresh');

			$this->datos['menu']="Facturas";
			$this->datos['opcion']="Consultar Facturas";
			$this->datos['titulo']="Consultar Facturas";

			$this->datos['cabeceras_css']= $this->cabeceras_css;
			$this->datos['cabeceras_script']= $this->cabecera_script;

	        /*************DATERANGEPICKER**********/
	        $this->datos['cabeceras_css'][]=base_url('assets/plugins/daterangepicker/daterangepicker.css');
	        $this->datos['cabeceras_script'][]=base_url('assets/plugins/daterangepicker/daterangepicker.js');
	        $this->datos['cabeceras_script'][]=base_url('assets/plugins/daterangepicker/locale/es.js');
			/**************FUNCION***************/
			$this->datos['cabeceras_script'][]=base_url('assets/hergo/funciones.js');
			$this->datos['cabeceras_script'][]=base_url('assets/hergo/facturasConsulta.js');
			$this->datos['cabeceras_script'][]=base_url('assets/hergo/NumeroALetras.js');
			/**************INPUT MASK***************/
			$this->datos['cabeceras_script'][]=base_url('assets/plugins/inputmask/inputmask.js');
			$this->datos['cabeceras_script'][]=base_url('assets/plugins/inputmask/inputmask.numeric.extensions.js');
            $this->datos['cabeceras_script'][]=base_url('assets/plugins/inputmask/jquery.inputmask.js');

            
            //$this->datos['almacen']=$this->ingresos_model->retornar_tabla("almacenes");
            //$this->datos['tipoingreso']=$this->ingresos_model->retornar_tablaMovimiento("-");

			//$this->datos['ingresos']=$this->ingresos_model->mostrarIngresos();

			$this->load->view('plantilla/head.php',$this->datos);
			$this->load->view('plantilla/header.php',$this->datos);
			$this->load->view('plantilla/menu.php',$this->datos);
			$this->load->view('plantilla/headercontainer.php',$this->datos);
			$this->load->view('Facturas/Facturas.php',$this->datos);
			$this->load->view('plantilla/footcontainer.php',$this->datos);
			$this->load->view('plantilla/footer.php',$this->datos);
	}

	public function EmitirFactura()
	{
		if(!$this->session->userdata('logeado'))
			redirect('auth', 'refresh');

			$this->datos['menu']="Facturas";
			$this->datos['opcion']="Emitir Facturas";
			$this->datos['titulo']="Emitir Facturas";

			$this->datos['cabeceras_css']= $this->cabeceras_css;
			$this->datos['cabeceras_script']= $this->cabecera_script;

	        /*************DATERANGEPICKER**********/
	        $this->datos['cabeceras_css'][]=base_url('assets/plugins/daterangepicker/daterangepicker.css');
	        $this->datos['cabeceras_script'][]=base_url('assets/plugins/daterangepicker/daterangepicker.js');
	        $this->datos['cabeceras_script'][]=base_url('assets/plugins/daterangepicker/locale/es.js');
			/**************FUNCION***************/
			$this->datos['cabeceras_script'][]=base_url('assets/hergo/funciones.js');
			$this->datos['cabeceras_script'][]=base_url('assets/hergo/facturas.js');
			$this->datos['cabeceras_script'][]=base_url('assets/hergo/NumeroALetras.js');
			/**************INPUT MASK***************/
			$this->datos['cabeceras_script'][]=base_url('assets/plugins/inputmask/inputmask.js');
			$this->datos['cabeceras_script'][]=base_url('assets/plugins/inputmask/inputmask.numeric.extensions.js');
            $this->datos['cabeceras_script'][]=base_url('assets/plugins/inputmask/jquery.inputmask.js');
            /**************EDITABLE***************/
			$this->datos['cabeceras_script'][]=base_url('assets/plugins/table-boot/plugin/bootstrap-table-editable.js');
			$this->datos['cabeceras_css'][]=base_url('assets/plugins/table-boot/plugin/bootstrap-editable.css');
			$this->datos['cabeceras_script'][]=base_url('assets/plugins/table-boot/plugin/bootstrap-editable.js');
            
            //$this->datos['almacen']=$this->ingresos_model->retornar_tabla("almacenes");
            //$this->datos['tipoingreso']=$this->ingresos_model->retornar_tablaMovimiento("-");

			//$this->datos['ingresos']=$this->ingresos_model->mostrarIngresos();
            $this->datos["fecha"]=date('Y-m-d');
			$this->load->view('plantilla/head.php',$this->datos);
			$this->load->view('plantilla/header.php',$this->datos);
			$this->load->view('plantilla/menu.php',$this->datos);
			$this->load->view('plantilla/headercontainer.php',$this->datos);
			$this->load->view('Facturas/emitirFactura.php',$this->datos);
			$this->load->view('plantilla/footcontainer.php',$this->datos);
			$this->load->view('plantilla/footer.php',$this->datos);
			/*borrar cookie facturacion*/
			
			if( isset( $_COOKIE['factsistemhergo'] ) ) {			     
			     delete_cookie("factsistemhergo");
			}
			
	}
	public function MostrarTablaConsultaFacturacion()
	{
		if($this->input->is_ajax_request() && $this->input->post('ini')&& $this->input->post('fin'))
        {
        	$ini = addslashes($this->security->xss_clean($this->input->post('ini')));
        	$fin = addslashes($this->security->xss_clean($this->input->post('fin')));
        	$alm = addslashes($this->security->xss_clean($this->input->post('alm')));
        	$tipo = addslashes($this->security->xss_clean($this->input->post('tipo')));
			
			$tabla=$this->FacturaEgresos_model->Listar($ini,$fin,$alm,$tipo);
			
			echo json_encode($tabla);
		}
		else
		{
			die("PAGINA NO ENCONTRADA");
		}
	}
	public function MostrarTablaFacturacion()
	{
		if($this->input->is_ajax_request() && $this->input->post('ini')&& $this->input->post('fin'))
        {
        	$ini = addslashes($this->security->xss_clean($this->input->post('ini')));
        	$fin = addslashes($this->security->xss_clean($this->input->post('fin')));
        	$alm = addslashes($this->security->xss_clean($this->input->post('alm')));
        	$tipo = addslashes($this->security->xss_clean($this->input->post('tipo')));
			
			$tabla=$this->egresos_model->ListarparaFacturacion($ini,$fin,$alm,$tipo);
			
			echo json_encode($tabla);
		}
		else
		{
			die("PAGINA NO ENCONTRADA");
		}
	}

	public function retornarTabla2()
	{
		
		
		if($this->input->is_ajax_request() && $this->input->post('idegreso') )
        {
        	$idegreso= addslashes($this->security->xss_clean($this->input->post('idegreso')));
        	$egresoDetalle=FALSE;
        	/***Retornar idcliente***/
			//$datosEgreso=$this->egresos_model->mostrarEgresos($idegreso);
        	//$fila=$datosEgreso->row();
        	//$idcliente=$fila->idcliente; 
        	/************************/
	      /*  if( isset( $_COOKIE['factsistemhergo'] ) ) 
	        {	
	        	$cookie=json_decode($this->desencriptar(get_cookie('factsistemhergo')));  
							
	        	if($cookie->cliente==$idcliente)// es el mismo cliente que ya se agrego en la tabla?
	        	{
	        		if(!in_array($idegreso, $cookie->egresos))
	        		{
	        			//no existe en el array entonces agregarlo	        			
	        			array_push($cookie->egresos,$idegreso);
	        			$egresoDetalle=$this->egresos_model->mostrarDetalle($idegreso)->result();
	        			$mensaje="Registro agregado correctamente";
	        			//return $egresoDetalle;
	        		}
	        		else
	        		{
	        			//existe entonces no se puede agregar el detalle	        			
	        			$egresoDetalle=FALSE;//return FALSE;
	        			$mensaje="Ya se agrego este registro";
	        		}	        		
	        	}
	        	else
	        	{
	        		//es otro cliente no hacer nada	        		
	        		$egresoDetalle=FALSE;//return FALSE;
	        		$mensaje="No se pueden agregar registros de otro cliente";
	        	}
			}	
			else
			{
				//no existe cookie entonces crear nuevo
				//si no existe la tabla 2 esta vacia y no se selecciono ningun egreso, 
				$egresoDetalle=$this->egresos_model->mostrarDetalle($idegreso)->result();
				$mensaje="Se agrego el primer registro en la tabla correctamente";
				$obj= new stdclass();
				$obj->egresos= array($idegreso);
				$obj->cliente=$idcliente;
				$cookie=$obj;
			}*/
			//$cookienew=json_encode($cookie);
			//$cookienew=$this->encriptar($cookienew);
			//set_cookie('factsistemhergo',$cookienew,'3600'); 	
			$egresoDetalle=$this->egresos_model->mostrarDetalleFacturas($idegreso)->result();
			$mensaje="Datos cargados correctamente";
			$obj2=new stdclass();
			$obj2->detalle=$egresoDetalle;
			$obj2->mensaje=$mensaje;
			echo json_encode($obj2);
		}
		else
		{
			die("PAGINA NO ENCONTRADA");
		}
	}
	public function eliminarElementoTabla3()
	{		
		if($this->input->is_ajax_request() && $this->input->post('idegresoDetalle'))
        {
        	$idegresoDetalle= addslashes($this->security->xss_clean($this->input->post('idegresoDetalle')));
        	if( isset( $_COOKIE['factsistemhergo'] ) ) // existe cookies?
	        {	
        		$cookie=json_decode((get_cookie('factsistemhergo'))); 
        		$egresosnew = array();
        		foreach ($cookie->egresos as $fila) {
        			if($fila!=$idegresoDetalle)
        				array_push($egresosnew,$fila);
        		}
        		$cookie->egresos=$egresosnew;
        	}
        	$cookienew=json_encode($cookie);
        	set_cookie('factsistemhergo',$cookienew,'3600'); 
        	echo json_encode("");
        }
		else
		{
			die("PAGINA NO ENCONTRADA");
		}
	}
	public function eliminarTodosElementoTabla3()
	{
		if( isset( $_COOKIE['factsistemhergo'] ) ) {			     
			     delete_cookie("factsistemhergo");
			}
			echo json_encode("");
	}
	public function retornarTabla3()
	{			
		if($this->input->is_ajax_request() && $this->input->post('idegresoDetalle') )
        {
        	$idegresoDetalle= addslashes($this->security->xss_clean($this->input->post('idegresoDetalle')));
        	$idegreso= addslashes($this->security->xss_clean($this->input->post('idegreso')));
        	$egresoDetalle=FALSE;
        	/***Retornar idcliente***/
			$datosEgreso=$this->egresos_model->mostrarEgresos($idegreso);//para obtener el cliente
        	$fila=$datosEgreso->row();
        	$idcliente=$fila->idcliente; 
        	$cliente=$fila->nombreCliente; 
        	$clienteNit=$fila->documento;
        	$clientePedido=$fila->clientePedido;
        	
        	/************************/
	        if( isset( $_COOKIE['factsistemhergo'] ) ) // existe cookies?
	        {	
	        	//$cookie=json_decode($this->desencriptar(get_cookie('factsistemhergo')));  
	        	$cookie=json_decode((get_cookie('factsistemhergo')));  
							
	        	if($cookie->cliente==$idcliente)// es el mismo cliente que ya se agrego en la tabla?
	        	{
	        		if(!in_array($idegresoDetalle, $cookie->egresos))
	        		{
	        			//no existe en el array entonces agregarlo	        			
	        			array_push($cookie->egresos,$idegresoDetalle);
	        			$egresoDetalle=$this->egresos_model->ObtenerDetalle($idegresoDetalle)->result();
	        			$mensaje="Registro agregado correctamente";
	        			
	        			//return $egresoDetalle;
	        		}
	        		else
	        		{
	        			//existe entonces no se puede agregar el detalle	        			
	        			$egresoDetalle=FALSE;//return FALSE;
	        			$mensaje="Ya se agrego este registro";
	        			$cook=$cookie;
	        		}	        		
	        	}
	        	else
	        	{
	        		//es otro cliente no hacer nada	        		
	        		$egresoDetalle=FALSE;//return FALSE;
	        		$mensaje="No se pueden agregar registros de otro cliente";
	        		
	        	}
			}	
			else
			{
				//no existe cookie entonces crear nuevo
				//si no existe la tabla 2 esta vacia y no se selecciono ningun egreso, 
				$egresoDetalle=$this->egresos_model->ObtenerDetalle($idegresoDetalle)->result();
				$mensaje="Se agrego el primer registro en la tabla correctamente";

				$obj= new stdclass();
				$obj->egresos= array($idegresoDetalle);//solo agrega el unico egreso al ser el primero
				$obj->cliente=$idcliente;


				$cookie=$obj;
			}
			$cookienew=json_encode($cookie);
			//$cookienew=$this->encriptar($cookienew);
			set_cookie('factsistemhergo',$cookienew,'3600'); 	
		
			$obj2=new stdclass();
			$obj2->detalle=$egresoDetalle;
			$obj2->mensaje=$mensaje;
			$obj2->cliente=$cliente;
			$obj2->clienteNit=$clienteNit;
			$obj2->clientePedido=$clientePedido;
			
			echo json_encode($obj2);
		}
		else
		{
			die("PAGINA NO ENCONTRADA");
		}
	}
	public function retornarTabla3Array()
	{			
		if($this->input->is_ajax_request() && $this->input->post('rows') )
        {

        	$datos= ($this->security->xss_clean($this->input->post('rows')));
        	$datos=json_decode($datos);  
        	$datosRetornar=array();
			/******verificamos si existe cookie*****/
	        	if( isset( $_COOKIE['factsistemhergo'] ) ) // existe cookies?
	        	{
	        		//$cookie=json_decode($this->desencriptar(get_cookie('factsistemhergo')));  
		        	$cookie=json_decode((get_cookie('factsistemhergo')));  
	        	}
	        	else
	        	{
	        		$cookie= new stdclass();
					$cookie->egresos= array();//solo agrega el unico egreso al ser el primero
					$cookie->cliente=0;
	        	}
	        	
	        	/************************/
        	foreach ($datos as $fila) 
        	{
        		$idegresoDetalle= $fila->idingdetalle;
        		$idegreso= $fila->idegreso;
        		$egresoDetalle=FALSE;
	        	/***Retornar idcliente***/
				$datosEgreso=$this->egresos_model->mostrarEgresos($idegreso);//para obtener el cliente
	        	$fila=$datosEgreso->row();
	        	$idcliente=$fila->idcliente; 
	        	$cliente=$fila->nombreCliente; 
	        	$clienteNit=$fila->documento;
	        	$clientePedido=$fila->clientePedido;
	        	$idCliente=$fila->idcliente;
	        	
		      
	        	//$cookie=json_decode($this->desencriptar(get_cookie('factsistemhergo')));  
	        	//$cookie=json_decode((get_cookie('factsistemhergo')));  
				
				if($cookie->cliente==$idcliente || $cookie->cliente==0)// es el mismo cliente que ya se agrego en la tabla?
	        	{
	        		if(!in_array($idegresoDetalle, $cookie->egresos))
	        		{
	        			//no existe en el array entonces agregarlo	        			
	        			array_push($cookie->egresos,$idegresoDetalle);
	        			$egresoDetalle=$this->egresos_model->ObtenerDetalle($idegresoDetalle)->result();
	        			$mensaje="Registro agregado correctamente";
	        			$cookie->cliente=$idcliente;
	        		//	var_dump($datosRetornar);
	        		//	var_dump($egresoDetalle);
	        			array_push($datosRetornar,$egresoDetalle);
	        			//return $egresoDetalle;
	        		}
	        		else
	        		{
	        			//existe entonces no se puede agregar el detalle	        			
	        			//$egresoDetalle=FALSE;//return FALSE;
	        			$mensaje="Algunos registros ya se agregaron";
	        			//$datosRetornar=$egresoDetalle;
	        		}	        		
	        	}
	        	else
	        	{
	        		//es otro cliente no hacer nada	        		
	        		$egresoDetalle=FALSE;//return FALSE;
	        		$mensaje="No se pueden agregar registros de otro cliente";
	        		$datosRetornar=$egresoDetalle;
	        	}	
        	}
        	$cookienew=json_encode($cookie);
				//$cookienew=$this->encriptar($cookienew);
        	
			set_cookie('factsistemhergo',$cookienew,'3600'); 
        	        		
		
			$obj2=new stdclass();
			$obj2->detalle=$datosRetornar;
			$obj2->mensaje=$mensaje;
			$obj2->cliente=$cliente;
			$obj2->clienteNit=$clienteNit;
			$obj2->clientePedido=$clientePedido;
			$obj2->idCliente=$idCliente;
			//$obj2->array=$datosRetornar;
			
			echo json_encode($obj2);
		}
		else
		{
			die("PAGINA NO ENCONTRADA");
		}
	}
	private function encriptar($cadena){
	    $key='SistemaHergo';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
	    $encrypted = base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, md5($key), $cadena, MCRYPT_MODE_CBC, md5(md5($key))));
	    return $encrypted; //Devuelve el string encriptado
	 
	}
	 
	private function desencriptar($cadena){
	     $key='SistemaHergo';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
	     $decrypted = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($cadena), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
	    return $decrypted;  //Devuelve el string desencriptado
	}
	public function tipoCambio()
	{
		$tipoCambio=$this->egresos_model->retornarValorTipoCambio();
		$obj2=new stdclass();
		$obj2->tipoCambio=$tipoCambio->tipocambio;	
		echo json_encode($obj2);
	}
	public function guardarFactura()
	{
		if($this->input->is_ajax_request())
        {
        	if( isset( $_COOKIE['factsistemhergo'] ) ) // existe cookies?
        	{        	
	        	$cookie=json_decode((get_cookie('factsistemhergo')));  	        	
	        	$cliente=$this->cliente_model->obtenerCliente($cookie->cliente);
        	}
        	$datosFactura=$this->DatosFactura_model->obtenerUltimoLote();   
        	$ultimaFactura=$this->Facturacion_model->obtenerRegistro();
        //	var_dump($datosFactura);
        //	die();
        	$factura=new stdclass();
        	//$factura->idFactura=0
        	$factura->lote=$datosFactura->lote;
        	$factura->almacen=$this->session->userdata('idalmacen');
        	$factura->nFactura=intval($ultimaFactura->nFactura)+1;
        	$factura->fechaFac= addslashes($this->security->xss_clean($this->input->post('fechaFac')));
        	$factura->cliente=$cliente->idCliente;
        	$factura->moneda= addslashes($this->security->xss_clean($this->input->post('moneda')));
        	$factura->total= addslashes($this->security->xss_clean($this->input->post('total')));
        	$factura->glosa=addslashes($this->security->xss_clean($this->input->post('observaciones')));;
        	$factura->pagada=0;
        	$factura->anulada=0;
        	$factura->codigoControl="";
        	$factura->qr="";
        	$factura->tipoCambio=$this->egresos_model->retornarTipoCambio();
        	$factura->ClienteFactura=$cliente->nombreCliente;
        	$factura->ClienteNit=$cliente->documento;
        	$factura->autor=$this->session->userdata('user_id');
        	$factura->fecha=date('Y-m-d H:i:s');        	
        	$tabla= ($this->security->xss_clean($this->input->post('tabla')));
        	$tabla=json_decode($tabla);
        	
        	$idFactura=$this->Facturacion_model->guardar($factura);
        	//$idFactura=1;

        	if($idFactura>0) //se registro correctamente => almacenar la tabla
        	{
				$detalle=array();
				$facturaEgreso=array();
	        	foreach ($tabla as $fila) 
	        	{

	        		$idArticulo=$this->egresos_model->retornar_datosArticulo($fila->CodigoArticulo);
	        		/**********************PReparar tabla detalle*************/
	        		$registro = array(
	        			'idFactura' => $idFactura,
	        			'articulo'=>$idArticulo,
	        			'moneda'=>$factura->moneda,
	        			'facturaCantidad'=>$fila->cantidadReal,
	        			'facturaPUnitario'=>$fila->punitario,
	        			'nMovimiento'=>"",
	        			'movTipo'=>"",
	        			'ArticuloNombre'=>$fila->Descripcion,
	        			'ArticuloCodigo'=>$fila->CodigoArticulo,
	        			 );	
	        		array_push($detalle, $registro);   
	        		$factura_egresoRegistro=array(
	        			'idegresos'=>$fila->idegreso,
	        			'idFactura'=>$idFactura,
	        			);	
	        		array_push($facturaEgreso, $factura_egresoRegistro);
	        		$this->egresos_model->actualizarCantFact($fila->idEgreDetalle,$fila->cantidadReal);
	        		$this->actualizarEstado($fila->idegreso);
	        	}
	        	$this->FacturaDetalle_model->guardar($detalle);
	        	$this->FacturaEgresos_model->guardarArray($facturaEgreso);

	        	echo 1;
        	}
        	else
        	{
        		echo 0;
        	}

        	//var_dump($factura);

        	
        }
		else
		{
			die("PAGINA NO ENCONTRADA");
		}
	}
	public function sessionver()
	{
		var_dump($this->session);
	}
	public function actualizarEstado($idEgreso)//cambia el estado si esta pendiente o facturado
	{
		$estado=0;
		$cantidad=$this->egresos_model->evaluarFacturadoTotal($idEgreso); //si es 0 facturado total si no parcial
		if(count($cantidad)==0)//Facturado
			$estado=1;
		else
			$estado=2;
		$this->egresos_model->actualizarEstado($idEgreso,$estado);
		echo $estado;
	}
	public function mostrarDetalleFactura()
	{
		if($this->input->is_ajax_request())
        {
        	$idFactura= addslashes($this->security->xss_clean($this->input->post('idFactura')));
			$obj=new stdclass();
			$obj->data1=$this->Facturacion_model->obtenerFactura($idFactura);
			$obj->data2=$this->Facturacion_model->obtenerDetalleFactura($idFactura);
			echo json_encode($obj);
		}
		else
		{
			die("PAGINA NO ENCONTRADA");
		}
	}
	public function anularFactura()
	{
		if($this->input->is_ajax_request())
        {
        	$idFactura= addslashes($this->security->xss_clean($this->input->post('idFactura')));			
			$this->Facturacion_model->anularFactura($idFactura);
			echo json_encode(1);
		}
		else
		{
			die("PAGINA NO ENCONTRADA");
		}
	}
}


