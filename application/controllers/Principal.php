<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Principal extends CI_Controller
{
	private $datos;
	public function __construct()
	{	
		parent::__construct();
		$this->load->helper('url');	
		$this->cabeceras_css=array(
				base_url('assets/bootstrap/css/bootstrap.min.css'),
				base_url("assets/fa/css/font-awesome.min.css"),
				base_url("assets/dist/css/AdminLTE.min.css"),
				base_url("assets/dist/css/skins/skin-blue.min.css"),
			);
		$this->cabecera_script=array(
				base_url('assets/plugins/jQuery/jquery-2.2.3.min.js'),
				base_url('assets/bootstrap/js/bootstrap.min.js'),
				base_url('assets/dist/js/app.min.js'),
				base_url('assets/plugins/slimscroll/slimscroll.min.js'),
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
			$this->datos['menu']="Index";
			$this->datos['opcion']="Index";
			$this->datos['titulo']="Hergo | Inventarios";
		
				    
			$this->datos['cabeceras_css']= $this->cabeceras_css;
			$this->datos['cabeceras_script']= $this->cabecera_script;
					
			$this->load->view('plantilla/head.php',$this->datos);
			$this->load->view('plantilla/header.php',$this->datos);
			$this->load->view('plantilla/menu.php',$this->datos);
			$this->load->view('plantilla/container.php',$this->datos);
			$this->load->view('plantilla/footer.php',$this->datos);
						

	}
	
	public function verlogin()
	{
		
		?>
		<pre>
		<?php 
			print_r($this->session->userdata);
		?>
		</pre>
		<?php 

	}
	public function tabla()
	{
		$datos['cabeceras_css']= $this->cabeceras_css;
		$datos['cabeceras_script']= $this->cabecera_script;
		$datos['cabeceras_css'][]=base_url('assets\plugins\datatables\dataTables.bootstrap.css');
		$datos['cabeceras_script'][]=base_url('assets\plugins\datatables\jquery.dataTables.min.js');
		$datos['cabeceras_script'][]=base_url('assets\plugins\datatables\dataTables.bootstrap.min.js');
		$this->load->view('plantilla/head.php',$datos);
		$this->load->view('plantilla/header.php',$datos);
		$this->load->view('plantilla/menu.php',$datos);
		$this->load->view('prueba.php',$datos);
		$this->load->view('plantilla/footer.php',$datos);
	}
	public function prueba()
	{
		$datos['cabeceras_css']= $this->cabeceras_css;
		$datos['cabeceras_script']= $this->cabecera_script;
		$datos['cabeceras_css'][]=base_url('assets\plugins\fileInput\css\fileinput.min.css');
		$datos['cabeceras_script'][]=base_url('assets\plugins\fileInput\js\fileinput.min.js');
		$datos['cabeceras_script'][]=base_url('assets\plugins\fileInput\js\locales\es.js');
		
		$this->load->view('plantilla/head.php',$datos);
		$this->load->view('plantilla/header.php',$datos);
		$this->load->view('plantilla/menu.php',$datos);
		$this->load->view('up/upload.php',$datos);
		$this->load->view('plantilla/footer.php',$datos);
	}
	public function subir_imagen()
	{

		//$ruta= dirname(getcwd()) . PHP_EOL; //ruta de la carpeta en el servidor sin hergo
		$ruta= getcwd();
		$ruta=trim($ruta);
		$carpetaAdjunta=$ruta."/assets/imagenes/";
		//die($carpetaAdjunta);
		// Contar envían por el plugin
		$Imagenes =count(isset($_FILES['imagenes']['name'])?$_FILES['imagenes']['name']:0);
		$infoImagenesSubidas = array();
		
		for($i = 0; $i < $Imagenes; $i++) {


		  // El nombre y nombre temporal del archivo que vamos para adjuntar
		  $nombreArchivo=isset($_FILES['imagenes']['name'][$i])?$_FILES['imagenes']['name'][$i]:null;
		  $nombreTemporal=isset($_FILES['imagenes']['tmp_name'][$i])?$_FILES['imagenes']['tmp_name'][$i]:null;
		  
		  $rutaArchivo=$carpetaAdjunta.$nombreArchivo;

		  move_uploaded_file($nombreTemporal,$rutaArchivo);
		  
		  $infoImagenesSubidas[$i]=array("caption"=>"$nombreArchivo","height"=>"120px","url"=>"http://localhost/hergo/up/borrar.php","key"=>$nombreArchivo);
		  $ImagenesSubidas[$i]="<img  height='120px'  src='http://localhost/hergo/imagenes/$rutaArchivo' class='file-preview-image'>";
		  }
		$arr = array("file_id"=>0,"overwriteInitial"=>true,"initialPreviewConfig"=>$infoImagenesSubidas,
		       "initialPreview"=>$ImagenesSubidas);
		//echo json_encode($arr);
	}
}