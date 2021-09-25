<?php namespace App\Controllers;

use App\Models\m_marca;
use App\Models\m_cliente;
use App\Models\m_empleado;
use App\Models\m_subcategoria;
use App\Models\m_categoria;
use App\Controllers\BaseController;
use App\Controllers\Administracion_1;

use App\Models\m_pedido_venta;
use App\Models\m_detalle_venta;
use App\Models\m_item;
use App\Models\m_factura_venta;

use App\Models\m_plan_cuenta;
use App\Models\m_comprobante;
use App\Models\m_detalle_comprobante;
use App\Models\m_item_almacen;
use App\Models\m_generales;

use App\Models\m_persona;
use App\Models\m_rol;
use App\Models\m_empleado_rol;

class Administracion extends BaseController{

    public function index(){



    }

    public function retiro_caja(){

    }

    public function deposito_caja(){

    }
    private function _loadDefaultView($title,$data,$view){

        $sesion = $this->sesiones();

        $dataHeader =[
            'title' => $title,
            'tipo'=>'header-inner-pages',
            
            'rol' => $sesion['rol'],

			'log' => $sesion['log']
        ];

        echo view("dashboard/templates/header",$dataHeader);
        echo view("administracion/$view",$data);
        echo view("dashboard/templates/footer");
    }
}