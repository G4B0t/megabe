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

class Administracion_4 extends BaseController{
    public function index(){
        $pedido_venta = new m_pedido_venta();

            $data =[
                'ventas' => $pedido_venta->asObject()
                ->select('marca.nombre as name, sum(detalle_venta.cantidad) as y')
                ->join('detalle_venta','pedido_venta.id = detalle_venta.id_pedido_venta')
                ->join('item','item.id = detalle_venta.id_item')
                ->join('marca','item.id_marca = marca.id')
                ->join('subcategoria','marca.id_subcategoria = subcategoria.id')
                ->join('categoria','subcategoria.id_categoria = categoria.id')
                ->where(['pedido_venta.fecha BETWEEN CAST("21-02-01" AS DATE) AND CAST("2021-10-18" AS DATE) AND pedido_venta.estado = 2'])
                ->groupBy('marca.nombre')
                ->findAll()
            ];
        
       
        $this->_loadDefaultView( 'Cuadro de MANDO', $data,'cuadro_mando');
    }


    private function _loadDefaultView($title,$data,$view){

        $administracion = new administracion_1();
        $sesion = $administracion->sesiones();

        $dataHeader =[
            'title' => $title,
            'tipo'=>'header-inner-pages',
            
            'rol' => $sesion['rol'],

			'log' => $sesion['log'],

            'central'=>$sesion['almacen'],
            
            'vista' => 'administracion'
        ];

        echo view("dashboard/templates/header",$dataHeader);
        echo view("administracion/$view",$data);
        echo view("dashboard/templates/footer");
    }
}