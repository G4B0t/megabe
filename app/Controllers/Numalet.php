<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Numalet extends CI_Controller {
function __construct()
    {
        parent::__construct();
 		$this->load->model('NumerosEnLetras');
        $this->load->model('CifrasEnLetras');
    }

	public function index()
	{
		$this->load->view('header');
		$this->load->view('Numalet');
		$this->load->view('footer');
	}

	public function convertir()
	{
		$numero = $_POST['numero'];
		$literal1 = $this->NumerosEnLetras->Convertir($numero,'Bolivianos',true);
		$parte1=explode('(',$literal1);
		$parte2=explode(')',$parte1[1]);
		$parentesis= $parte2[0];
		echo json_encode($parentesis);
	}
	
	public function convertir2()
	{
		$numero = $_POST['numero'];
		echo json_encode($this->CifrasEnLetras->convertirBolivianosEnLetras($numero));
	}
}