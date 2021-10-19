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
        
       
        $this->_loadDefaultView( 'Grafica de Torta', $data,'pie_chart');
    }
    public function generar_balance_general(){
        $plan_cuenta = new m_plan_cuenta();
        $data =['cuentas' => $plan_cuenta->asObject()
                        ->select('plan_cuenta.*')
                        ->whereNotIn('plan_cuenta.nombre_cuenta',['INGRESOS'])
                        ->paginate(10,'cuentas'),

                'pagers'=>$plan_cuenta->pager

        ];

        $this->_loadDefaultView( 'Balance General', $data,'balance_general');
    }
    public function cuadro_mando_item($id){
        $item = new m_item();

        $data = ['item'=>$item->asObject()
                    ->select('item.id,item.nombre,item.venta_esperada, sum(detalle_venta.cantidad) AS cantidad,((sum(detalle_venta.cantidad)/item.venta_esperada)*100) AS promedio')
                    ->join('marca','marca.id = item.id_marca')
                    ->join('subcategoria','subcategoria.id = marca.id_subcategoria')
                    ->join('categoria','categoria.id = subcategoria.id_categoria') 
                    ->join('detalle_venta','item.id = detalle_venta.id_item')
                    ->where('marca.id',$id)
                    ->groupBy('item.nombre,item.id,item.venta_esperada')
                    ->paginate(10,'item'),
                'pagers'=>$item->pager
        ];
        $this->_loadDefaultView( 'Cuadro de MANDO: Item', $data,'cuadro_mando/items');

    }
    public function cuadro_mando_marca($id){
        $marca = new m_marca();

        $data = ['marca'=>$marca->asObject()
                    ->select('marca.id,marca.nombre,marca.venta_esperada, sum(detalle_venta.cantidad) AS cantidad,((sum(detalle_venta.cantidad)/marca.venta_esperada)*100) AS promedio')
                    ->join('subcategoria','subcategoria.id = marca.id_subcategoria')
                    ->join('categoria','categoria.id = subcategoria.id_categoria') 
                    ->join('item','marca.id = item.id_marca')
                    ->join('detalle_venta','item.id = detalle_venta.id_item')
                    ->where('subcategoria.id',$id)
                    ->groupBy('marca.nombre,marca.id,marca.venta_esperada')
                    ->paginate(10,'marca'),
                'pagers'=>$marca->pager
        ];
        $this->_loadDefaultView( 'Cuadro de MANDO: Marca', $data,'cuadro_mando/marcas');
    }
    public function cuadro_mando_subcategoria($id){
        $subcategoria = new m_subcategoria();

        $data = ['subcategoria'=>$subcategoria->asObject()
                    ->select('subcategoria.id,subcategoria.nombre,subcategoria.venta_esperada, sum(detalle_venta.cantidad) AS cantidad,((sum(detalle_venta.cantidad)/subcategoria.venta_esperada)*100) AS promedio')
                    ->join('categoria','categoria.id = subcategoria.id_categoria')
                    ->join('marca','subcategoria.id = marca.id_subcategoria')
                    ->join('item','marca.id = item.id_marca')
                    ->join('detalle_venta','item.id = detalle_venta.id_item')
                    ->where('categoria.id',$id)
                    ->groupBy('subcategoria.nombre,subcategoria.id,subcategoria.venta_esperada')
                    ->paginate(10,'subcategoria'),
                'pagers'=>$subcategoria->pager
        ];
        $this->_loadDefaultView( 'Cuadro de MANDO: Subcategoria', $data,'cuadro_mando/subcategorias');
    }
    public function cuadro_mando_categoria(){
        $categoria = new m_categoria();

        $data = ['categoria'=>$categoria->asObject()
                    ->select('categoria.id,categoria.nombre,categoria.venta_esperada, sum(detalle_venta.cantidad) AS cantidad,((sum(detalle_venta.cantidad)/categoria.venta_esperada)*100) AS promedio')
                    ->join('subcategoria','categoria.id = subcategoria.id_categoria')
                    ->join('marca','subcategoria.id = marca.id_subcategoria')
                    ->join('item','marca.id = item.id_marca')
                    ->join('detalle_venta','item.id = detalle_venta.id_item')
                    ->groupBy('categoria.nombre,categoria.id,categoria.venta_esperada')
                    ->paginate(10,'categoria'),
                'pagers'=>$categoria->pager
        ];
        $this->_loadDefaultView( 'Cuadro de MANDO: Categoria', $data,'cuadro_mando/categorias');
    }
    public function nueva_gestion(){
        $generales = new m_generales();
        $comprobante = new m_comprobante();
        $detalle_comprobante = new m_detalle_comprobante();
        $plan_cuenta = new m_plan_cuenta();
        $empleado = new m_empleado();

        $db = \Config\Database::connect();

        $session = session();
        $id_empleado = $session->empleado;
        $contador = $empleado->getContador($id_empleado);

        $cuentas = $plan_cuenta->getCuentas();

        $gestion = $this->request->getPost('gestion');
        $cDate = date('Y-m-d H:i:s');
        echo $gestion;
        
        if($db->query('UPDATE generales SET balAper = 1, gestion = "'.$gestion.'" WHERE nombre_empresa = "MEGABE"')){
            
            if($db->query('TRUNCATE TABLE detalle_comprobante;
                            DELETE FROM comprobante WHERE 1; ALTER TABLE comprobante AUTO_INCREMENT = 1;')){
                $body_comprobante = [
                    'tipo_respaldo'=>'Comprobante',
                    'fecha'=>$cDate,
                    'beneficiario'=>$contador->fullname,
                    'glosa'=>'Inicio de Gestion'
                ];
                    if($comprobante->insert($body_comprobante)){
                        $id_comprobante = $comprobante->getInsertID();
                        foreach($cuentas as $key => $m){
                            $body_detalle = [
                                'id_comprobante'=>$id_comprobante,
                                'id_cuenta' => $m->id,
                                'debe' => $m->debe,
                                'haber'=>$m->haber
                            ];
                            $detalle_comprobante->insert($body_detalle);
                        }
                        return redirect()->to('/administracion')->with('message', 'Inicio de Gestion Completado');
                    }
            }
        }
        return redirect()->to('/administracion')->with('message', 'No se pudo realizar el Inicio de Gestion');
    }
    public function iniciar_gestion(){
        $generales = new m_generales();

        $data = ['general' =>$generales->asObject()->first()];
        $this->_loadDefaultView( 'Inicio de Gestion', $data,'inicio_gestion');
    }

    public function cerrar_comprobante(){
        $generales = new m_generales();

        $general = $generales->asObject()->first();
        $db = \Config\Database::connect();
        $query = $db->query('DROP TABLE IF EXISTS comprobante_'.$general->gestion);
        if($query!=null){
            $query2 = $db->query('CREATE TABLE comprobante_'.$general->gestion.' LIKE comprobante;');
            if($query2!=null) {
                $query3 = $db->query('INSERT INTO comprobante_'.$general->gestion.' SELECT * FROM comprobante;');
            } else {
                return redirect()->to('/administracion')->with('message', 'No se pudo realizar el Cierre de Gestion');
            }
        }
    }
    public function cerrar_detalle_comprobante(){
        $generales = new m_generales();

        $general = $generales->asObject()->first();
        $db = \Config\Database::connect();
        $query= $db->query('DROP TABLE IF EXISTS detalle_comprobante_'.$general->gestion);
        if($query!=null){
            $query2 = $db->query('CREATE TABLE detalle_comprobante_'.$general->gestion.' LIKE detalle_comprobante;');
            if($query2!=null) {
                $query3 = $db->query('INSERT INTO detalle_comprobante_'.$general->gestion.' SELECT * FROM detalle_comprobante;');
            } else {
                return redirect()->to('/administracion')->with('message', 'No se pudo realizar el Cierre de Gestion');
            }
        }
    }
    public function cerrar_gestion(){
        $generales = new m_generales();

        $general = $generales->asObject()->first();
        $db = \Config\Database::connect();
        $query = $db->query('DROP TABLE IF EXISTS plan_cuenta_'.$general->gestion);
        if($query!=null){
            $query2 = $db->query('CREATE TABLE plan_cuenta_'.$general->gestion.' LIKE plan_cuenta;');
            if($query2!=null) {
                $query3 = $db->query('INSERT INTO plan_cuenta_'.$general->gestion.' SELECT * FROM plan_cuenta;');
                $this->cerrar_detalle_comprobante();
                $this->cerrar_comprobante();
                $db->query('UPDATE generales
                            SET balAper = 0
                            WHERE nombre_empresa = "MEGABE"');
                        
                return redirect()->to('/administracion')->with('message', 'Se ha completado el Cierre de Gestion');
            } else {
                return redirect()->to('/administracion')->with('message', 'No se pudo realizar el Cierre de Gestion');
            }
        }
        
    }
    public function sumar_recursivo($id_cuenta, $debe, $haber,$d,$h){
        $plan_cuenta = new m_plan_cuenta();
        
        $cuenta = $plan_cuenta->getByID($id_cuenta);
        $d = $cuenta->debe + $debe;
        $h = $cuenta->haber + $haber; 
    
        $plan_cuenta->update($cuenta->id,['debe'=>$d,'haber'=>$h]);
            if($cuenta->id_cuenta_padre!= null){
                $this->sumar_recursivo($cuenta->id_cuenta_padre,$debe, $haber,$d,$h);
            }
    }
    public function plan_cuenta_mayorizar(){
       
        $detalle_comprobante = new m_detalle_comprobante();
        $plan_cuenta = new m_plan_cuenta();

        $cuentas = $plan_cuenta->getAll();
        foreach($cuentas as $key => $m){
            $plan_cuenta->update($m->id,['debe'=>0,'haber'=>0]);
        }
        $detalles = $detalle_comprobante->getAll();
        $d = 0;
        $h = 0;
        foreach ($detalles as $key =>$m){
            $id = $m->id_cuenta;
            $debe = $m->debe;
            $haber = $m->haber;
            
            $this->sumar_recursivo($id,$debe,$haber,$d,$h);            
         }
        
        $data = [
            'plan_cuenta' => $plan_cuenta->asObject()
                            ->select('plan_cuenta.*')
                            ->paginate(10,'plan_cuenta'),
            'pagers' => $plan_cuenta->pager,
            
        ];

        $this->_loadDefaultView( 'Mayorizacion de Plan de Cuentas', $data,'mayorizacion');
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