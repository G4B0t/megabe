<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ValidarCodControl extends CI_Controller {
	
function __construct()
    {
        parent::__construct();
 		//$this->->model('m_Numalet');
    }

	public function index()
	{
		$this->load->view('header');
		$this->load->view('validarCodControl');
		$this->load->view('footer');
	}

	public function do_upload()
	{
		if(!empty($_FILES))
		{
			$config['upload_path'] = './assets/uploads/txt/';
			$config['allowed_types'] = 'txt';
			$this->load->library('upload',$config);

			if(!$this->upload->do_upload("txtFile"))
			{
				//error upload
				$this->load->view('header');
				$this->load->view('validarCodControl');
				$this->load->view('footer');
				echo json_encode("error");
			}
			else
			{
				//succes upload
				$this->load->model('CodigoControlV7');
				$file_name = $this->upload->data()["file_name"];
				$file_dir = './assets/uploads/txt/'.$file_name;
				$file = fopen($file_dir, "r");
				$text = "";

				while(!feof($file))
				{

					$parm = explode('|', fgets($file));

					if($parm[0] && $parm[1] && $parm[2] && $parm[3] && $parm[4] && $parm[5])
					{
						//mostrar solo los codigos de control resultantes
						$text = $text.$this->CodigoControlV7->generar($parm[0],$parm[1],$parm[2],str_replace("/","",$parm[3]),round(str_replace(",",".",$parm[4])),$parm[5])."\n";


						//mostrar los datos ingresados y su resultado
						//$text = $text.$parm[0]."|".$parm[1]."|".$parm[2]."|".str_replace("/","",$parm[3])."|".round(str_replace(",",".",$parm[4]))."|".$parm[5]."|".$this->CodigoControlV7->generar($parm[0],$parm[1],$parm[2],str_replace("/","",$parm[3]),round(str_replace(",",".",$parm[4])),$parm[5])."\n";
						
						//mostrar solo los campos en la posicion x
						//$text = $text.$parm[10]."\n";
					}
					
				}
				fclose($file);
				$file_dir = './assets/downloads/txt/'.'_resultado_'.$file_name;
				$fileResult = fopen($file_dir, "a");
				fwrite($fileResult,$text);
				$this->load->view('header');
				$this->load->view('validarCodControl');
				$this->load->view('footer');
				echo ("|".$text."|".$file_dir."|");
			}
		}
		
		
		

			
	}

}