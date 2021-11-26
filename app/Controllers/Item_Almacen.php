<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Controllers\Administracion_1;
use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\m_item_almacen;

class Item_Almacen extends BaseController {

    public function index(){

        $item_almacen = new m_item_almacen();

        $data = [
            'item_almacen' => $item_almacen->asObject()
            ->select('item_almacen.*,item.nombre,item.codigo,item.stock as total, almacen.direccion')
            ->join('item','item_almacen,id_item = item.id')
            ->join('almacen','item_almacen.id_almacen = almacen.id')
            ->orderBy('nombre','ASC')
            ->orderBy('direccion','ASC')
            ->paginate(9,'item_almacen'),
            'pager' => $item_almacen->pager
        ];

        $this->_loadDefaultView( 'Listado Items por Almacen',$data,'index');
    }

    public function create(){

        $item_almacen = new m_item_almacen();
        $filtro = $this->request->getPost('filtro');

        $array = [
			'item.codigo' => $filtro, 
			'item.descripcion' => $filtro
		];
        $restricciones = ['item_almacen.estado_sql' => 1];
        $data = [
            'item_almacen' => $item_almacen->asObject()
            ->select('item_almacen.*,item.nombre,item.codigo,item.descripcion,item.stock as total,almacen.direccion')
            ->join('item','item_almacen,id_item = item.id')
            ->join('almacen','item_almacen.id_almacen = almacen.id')
            ->where($restricciones)
            ->like('item.nombre', $filtro)
			->orlike($array)
            ->paginate(9,'item_almacen'),
            'pager' => $item_almacen->pager
        ];
        $this->_loadDefaultView( 'Filtrado de Item en Almacenes',$data,'index');
    }


    private function _loadDefaultView($title,$data,$view){

     
        $administracion = new administracion_1();
        $sesion = $administracion->sesiones();

        $dataHeader =[
            'title' => $title,
            'tipo'=> 'header-inner-pages',

            'rol' => $sesion['rol'],

			'log' => $sesion['log'],

            'central'=>$sesion['almacen'],
            
            'vista' => 'administracion'

        ];

        echo view("dashboard/templates/header",$dataHeader);
        echo view("dashboard/item_almacen/$view",$data);
        echo view("dashboard/templates/footer");
    }

}