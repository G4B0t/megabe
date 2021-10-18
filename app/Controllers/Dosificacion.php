<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class dosificacion extends CI_Controller {
function __construct()
    {
        parent::__construct();
 		$this->load->model('m_dosificacion');
    }

	public function index()
	{
		$this->load->view('header');
		$this->load->view('adm_dosificacion');
		$this->load->view('footer');
	}

	public function get() {
		$page = isset($_REQUEST['pageNumber']) ? intval($_REQUEST['pageNumber']) : 1;
        $rows = isset($_REQUEST['pageSize']) ? intval($_REQUEST['pageSize']) : 10;

        $nroFac = isset($_REQUEST['nro_factura']) ? $_REQUEST['nro_factura'] : '';
        $nroAut = isset($_REQUEST['nro_autorizacion']) ? $_REQUEST['nro_autorizacion'] : '';
        $llave = isset($_REQUEST['llave']) ? $_REQUEST['llave'] : '';
        $leyenda = isset($_REQUEST['leyenda']) ? $_REQUEST['leyenda'] : '';
        if (isset($_REQUEST['fecha_limite_emision'])) {
            $fechaL = ($_REQUEST['fecha_limite_emision'] != '') ? ' and fecha_limite_emision = '.$_REQUEST['fecha_limite_emision'].' ' : '';
        }else{$fechaL = ''; }
        if (isset($_REQUEST['fecha_activacion'])) {
            $fechaA = ($_REQUEST['fecha_activacion'] != '') ? ' and fecha_activacion = '.$_REQUEST['fecha_activacion'].' ' : '';
        }else{$fechaA = ''; }
        
        $activo = isset($_REQUEST['activo']) ? $_REQUEST['activo'] : '';
        $estado_sql = isset($_REQUEST['estado_sql']) ? $_REQUEST['estado_sql'] : '';

        $sortBy = isset($_REQUEST['sortBy']) ? $_REQUEST['sortBy'] : 'nro_autorizacion';
        $sortDirection = isset($_REQUEST['sortDirection']) ? $_REQUEST['sortDirection'] : 'ASC';

		echo json_encode($this->m_dosificacion->getPaged($page, $rows, $nroAut, $nroFac, $llave, $leyenda, $fechaL, $fechaA, $activo, $estado_sql, $sortBy, $sortDirection), JSON_NUMERIC_CHECK);
	}
    public function save() {
        $data = array();
        $data['nro_autorizacion'] = $_REQUEST['nro_autorizacion'];
        $data['nro_factura'] = $_REQUEST['nro_factura'];
        $data['fecha_limite_emision'] = $_REQUEST['fecha_limite_emision'];
        //$data['fecha_activacion'] = $_REQUEST['fecha_activacion'];
        $data['llave'] = $_REQUEST['llave'];
        $data['leyenda'] = $_REQUEST['leyenda'];
        $data['activa'] = $_REQUEST['activa'];
        //$data['estado_sql'] = $_REQUEST['estado_sql'];

        $error = !$this->m_dosificacion->add($data);
        $msg = "Se agrego el encuestador correctamente.";
        if ($error)
            $msg = "Ocurrio un error al agregar el encuestador."; 

        echo json_encode(array('hasError' => $error, 'message' => $msg));
    }
    
	public function edit() {
        $data = array();
        $id = $_REQUEST['id'];
        $data['nro_autorizacion'] = $_REQUEST['nro_autorizacion'];
        $data['nro_factura'] = $_REQUEST['nro_factura'];
        $data['fecha_limite_emision'] = $_REQUEST['fecha_limite_emision'];
        $data['llave'] = $_REQUEST['llave'];
        $data['leyenda'] = $_REQUEST['leyenda'];
        $data['activa'] = $_REQUEST['activa'];

        $error = !$this->m_dosificacion->upd($data, $id);
        $msg = "Se modifico el encuestador correctamente.";
        if ($error)
            $msg = "Ocurrio un error al modificar el encuestador."; 

        echo json_encode(array('hasError' => $error, 'message' => $msg));
    }

    public function del($id) {
        $data = array();
        $data['estado_sql'] = 0;
        $error = !$this->m_dosificacion->upd($data, $id);
        $msg = "Se borro el registro correctamente.";
        if ($error)
            $msg = "Ocurrio un error al borrar el registro."; 

        echo json_encode(array('hasError' => $error, 'message' => $msg));
    }
}

