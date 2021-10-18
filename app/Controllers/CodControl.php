<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class CodControl extends CI_Controller {
function __construct()
    {
        parent::__construct();
 		//$this->load->model('m_Numalet');
        $this->load->model('CodigoControlV7');
    }

	public function index()
	{
		$this->load->view('header');
		$this->load->view('CodControl');
		$this->load->view('footer');
	}

	public function generar()
	{
		$nroAut = $_POST['nroAut'];
		$nroFact = $_POST['nroFact'];
		$NitCi = $_POST['NitCi'];
		$fecha = $_POST['fecha'];
		$monto = $_POST['monto'];
		$llave = $_POST['llave'];
		echo json_encode($this->CodigoControlV7->generar($nroAut,$nroFact,$NitCi,$fecha,$monto,$llave));
	}

	public function generar2(){
		$result = $this->db->query("SELECT id, llave, nro_autorizacion from dosificacion where activa = 1")->result_array();
		//echo json_encode($result[0]['nro_autorizacion']);
		$nroAut = $result[0]['nro_autorizacion'];
		$nroFact = $_POST['nroFact'];
		$NitCi = $_POST['NitCi'];
		$fecha = $_POST['fecha'];
		$monto = $_POST['monto'];

		$llave = $result[0]['llave'];
		$codControl = $this->CodigoControlV7->generar($nroAut,$nroFact,$NitCi,$fecha,$monto,$llave);
		$datos['id']=$result[0]['id'];
		$datos['cod_control']=$codControl;
		echo json_encode($datos);
	}
}