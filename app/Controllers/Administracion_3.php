<?php namespace App\Controllers;

use App\Models\m_marca;
use App\Models\m_cliente;
use App\Models\m_empleado;
use App\Models\m_subcategoria;
use App\Models\m_categoria;
use App\Controllers\BaseController;
use App\Controllers\Administracion_1;

use App\Models\m_pedido_compra;
use App\Models\m_detalle_compra;
use App\Models\m_factura_compra;

use App\Models\m_pedido_venta;
use App\Models\m_detalle_venta;
use App\Models\m_item;
use App\Models\m_factura_venta;

use App\Models\m_plan_cuenta;
use App\Models\m_comprobante;
use App\Models\m_detalle_comprobante;
use App\Models\m_item_almacen;
use App\Models\m_almacen;
use App\Models\m_generales;

use App\Models\m_persona;
use App\Models\m_rol;
use App\Models\m_empleado_rol;

class Administracion_3 extends BaseController{

    public function index(){

        $this->_loadDefaultView( '','','index');
    }

    public function nueva_transferencia_envio(){

    }
    public function ver_transferencia_recibos(){

    }
    public function armar_pedido_transferencia(){

    }
    public function agregar_item_envio(){

    }
    public function ver_carrito_envio(){

    }
    public function confirmar_trasnfe_envio(){

    }
    
    private function _loadDefaultView($title,$data,$view){

    $administracion = new administracion_1();
    $sesion = $administracion->sesiones();

    $dataHeader =[
        'title' => $title,
        'tipo'=>'header-inner-pages',
        
        'rol' => $sesion['rol'],

        'log' => $sesion['log'],

        'central'=>$sesion['almacen']
    ];

    echo view("dashboard/templates/header",$dataHeader);
    echo view("administracion/$view",$data);
    echo view("dashboard/templates/footer");
}
}