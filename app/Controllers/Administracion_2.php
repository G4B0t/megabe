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

class Administracion_2 extends BaseController{

    public function index(){

        $this->_loadDefaultView( '','','index');
    }
    public function confirmar_compra($id_pedido){
        $pedido_compra = new m_pedido_compra();
        $detalle_compra = new m_detalle_compra();
        $item = new m_item();
        $item_almacen = new m_item_almacen();
        $almacen = new m_almacen();
        $empleado = new m_empleado();

        $session = session();
        $id_empleado = $session->empleado;
        $almacenero = $empleado->getAlmacenCental($id_empleado);

        helper("user");
        $contrasena = $this->request->getPost('password');
        if(verificarPassword($contrasena,$almacenero->contrasena)){
                if($almacenero->caja=='Central'){
                    $compra = $pedido_compra->getById($id_pedido);
                    $detalles = $detalle_compra->getFullDetalle($compra->id);
                    $almacen_central = $almacen->getOne($almacenero->id_almacen);

                    $total = 0;
                    
                    foreach($detalles as $key => $m){
                        $its = $item->asObject()->where(['id'=>$m->id_item])->first();
                        $it_als = $item_almacen->asObject()->where(['id_item' => $m->id_item,'id_almacen'=>$almacenero->id_almacen])->first();

                        $cantidad = $m->cantidad;
                        $stock = $its->stock;
                        $stock_alma=$it_als->stock;

                        $new_stock = $stock + $cantidad;
                        $new_stock_alma = $stock_alma + $cantidad;

                        $item->update($its->id,['stock'=>$new_stock]);
                        $item_almacen->update($it_als->id,['stock'=>$new_stock_alma]);

                        $total += $m->total;
                    }
                    $body = ['estado'=>1,
                            'total'=>$total];  
                    
                    if($pedido_compra->update($compra->id,$body)){
                            return redirect()->to('/administracion')->with('message', 'Pedido Compra CONFIRMADO!');                   
                        }
                    else{
                        return redirect()->to('/administracion')->with('message', 'No se pudo confirmar la Compra');
                    }
                    
            }
                else{
                    return redirect()->to('/administracion')->with('message', 'No tiene el Rol de Almacen Central');
                }
        
        }else{
            return redirect()->to('/administracion/ver_carrito/'.$id_pedido)->with('message', 'Contraseña Incorrecta');
        }
    }

    public function new_compra(){
        $session = session();
        $id_empleado = $session->empleado;

        $pedido_compra = new m_pedido_compra();
        // getting current date 

        $pedido_vigente = $pedido_compra->getPedidoVigente($id_empleado);

        if($pedido_vigente != null){
            $this->ver_items($pedido_vigente->id);

        }else{
            $cDate = date('Y-m-d H:i:s');
            $id = $pedido_compra->insert([
                    'id_empleado' => $id_empleado,
                    'estado' =>'0',
                    'fecha' =>$cDate
                ]);
            $id_pedido = $pedido_compra->getInsertID();
            $this->ver_items($id_pedido);
        }
    }

    public function ver_items($id_pedido){
        $item = new m_item();
        $pedido_compra = new m_pedido_compra();
		
		$condiciones = ['item.estado_sql' => '1'];
        $pedido = $pedido_compra->getById($id_pedido);
        if($pedido==null){
            return redirect()->to('/administracion')->with('message', 'No se pudo crear el nuevo Pedido.');
        }
		$data = [
			'item' => $item->asObject()
            ->select('item.*,marca.id AS marcaId, 
					marca.nombre AS marca, subcategoria.id AS subcategoriaID, 
					subcategoria.nombre AS subcategoria, categoria.id AS categoriaID, 
					categoria.nombre AS categoria')
			->join('marca','item.id_marca = marca.id')
			->join('subcategoria','marca.id_subcategoria = subcategoria.id')
			->join('categoria','subcategoria.id_categoria = categoria.id')
			->where($condiciones)
            ->paginate(10,'item'),
            'pager'=>$item->pager,

            'id_pedido' =>$id_pedido
        ];

		$this->_loadDefaultView( 'Listado',$data,'productos_compra');
    }

    public function ver_items_filtrado($id_pedido){
        $item = new m_item();
        $pedido_compra = new m_pedido_compra();
		
		$condiciones = ['item.estado_sql' => '1'];
        $pedido = $pedido_compra->getById($id_pedido);
        $filtro = $this->request->getPost('filtro');
        $array = [
			'marca.nombre' => $filtro, 
			'item.codigo' => $filtro, 
			'item.descripcion' => $filtro, 
			'subcategoria.nombre' => $filtro, 
			'categoria.nombre' =>$filtro,
		];

        if($pedido==null){
            return redirect()->to('/administracion')->with('message', 'No se pudo crear el nuevo Pedido.');
        }
		$data = [
			'item' => $item->asObject()
            ->select('item.*,marca.id AS marcaId, 
					marca.nombre AS marca, subcategoria.id AS subcategoriaID, 
					subcategoria.nombre AS subcategoria, categoria.id AS categoriaID, 
					categoria.nombre AS categoria')
			->join('marca','item.id_marca = marca.id')
			->join('subcategoria','marca.id_subcategoria = subcategoria.id')
			->join('categoria','subcategoria.id_categoria = categoria.id')
			->where($condiciones)
            ->like('item.nombre', $filtro)
			->orlike($array)
            ->paginate(10,'item'),

            'id_pedido' =>$id_pedido
        ];

		$this->_loadDefaultView( 'Listado',$data,'productos_compra');
    }

    public function agregar_linea($id_pedido){
        $pedido_compra = new m_pedido_compra();
        $detalle_compra = new m_detalle_compra();
        $item = new m_item();

        $cantidad = $this->request->getPost('cantidad');
        $id_item = $this->request->getPost('item_id');
        $producto = $item->getOne($id_item);

        $total = ($producto->precio_compra)*$cantidad;
        
        $pedido = $pedido_compra->getById($id_pedido);
        
        if($pedido ==null){
            return redirect()->to('/administracion/ver_items/'.$id_pedido)->with('message', 'El Pedido no existe! :c');
        }
        $detalle = $detalle_compra->getDetalle($id_pedido,$producto->id);
       
        if($detalle == null){
            $new_detalle = ['id_pedido_compra'=>$pedido->id,
                            'id_item'=>$id_item,
                            'cantidad'=>$cantidad,
                            'precio_unitario'=>$producto->precio_compra,
                            'total'=> $total
                            ];               
            if($detalle_compra->insert($new_detalle)){
                 $this->mostrar_linea($pedido->id);
            }else{
               return redirect()->to('/administracion/ver_items/'.$id_pedido)->with('message', 'No se pudo agregar el producto.');
            }
        }else{
            $old_cantidad = $detalle['cantidad'];
            $old_total = $detalle['total'];
            $new_cantidad = $old_cantidad + $cantidad;
            $precio_u = $detalle['precio_unitario'];
            $new_total = $new_cantidad * $precio_u;
            $new_detalle = ['id_pedido_compra'=>$pedido->id,
                            'id_item'=>$id_item,
                            'cantidad'=>$new_cantidad,
                            'precio_unitario'=>$producto->precio_compra,
                            'total'=> $new_total
                            ];               
            if($detalle_compra->update($detalle['id'],$new_detalle)){
                 $this->mostrar_linea($pedido->id);
            }else{
                return redirect()->to('/administracion/ver_items/'.$id_pedido)->with('message', 'No se pudo agregar el producto.');
            }
        }
        
    }
    public function mostrar_linea($id_pedido){
        $pedido_compra = new m_pedido_compra();
        $detalle_compra = new m_detalle_compra();

        if($pedido = $pedido_compra->getById($id_pedido)){

            $restricciones = ['detalle_compra.estado_sql'=> '1','id_pedido_compra' => $pedido->id];

            $detalles = $detalle_compra->getFullDetalle($pedido->id);
            $total = 0;
            foreach($detalles as $key => $m){
                $total += $m->total;
            }
            
            $data = [
                'detalle_compra' => $detalle_compra->asObject()
                ->select('detalle_compra.*, item.nombre as item_nombre, item.codigo as item_codigo,pedido_compra.moneda')
                ->join('item','item.id = detalle_compra.id_item')
                ->join('pedido_compra','pedido_compra.id = detalle_compra.id_pedido_compra')
                ->where($restricciones)
                ->paginate(10,'detalle_compra'),
                'pager' => $detalle_compra->pager,

                'total' => $total,

                'id_pedido' => $pedido->id
            ];

            $this->_loadDefaultView( 'Detalle de Pedido',$data,'detalle_compras');
        }else{

             return redirect()->to('/administracion/ver_items/'.$id_pedido)->with('message', 'SU CARRITO ESTA VACIO');
        }

    }

    public function borrar_linea($id){
       
        $detalle_compra = new m_detalle_compra();
        $pedido_compra = new m_pedido_compra();
        $pedido = $pedido_compra->getByDetalle($id);

        if ($detalle_compra->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        $detalle_compra->update($id, [
            'estado_sql' =>'0'              
        ]);       
        return redirect()->to('/administracion/ver_carrito/'.$pedido->id)->with('message', 'Producto eliminado del detalle.');
    }

    public function confirmar_entrega($id_pedido){
        $pedido_venta = new m_pedido_venta();

        if($pedido_venta->update($id_pedido,['estado'=>'3'])){
            return redirect()->to('/administracion/ver_pagados')->with('message', 'Pedido Entregado!');
        }
        else{
            return redirect()->to('/administracion/detalle_pagados/'.$id_pedido)->with('message', 'No se pudo confirmar entrega!');
        }
        
    }

    public function mostrar_detalle($id_pedido){

        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();
        $empleado = new m_empleado();
        $plan_cuenta = new m_plan_cuenta();

        $id_pedido = $pedido_venta->getPedidoPagado($id_pedido);

        $condiciones = ['pedido_venta.estado' => '2', 'pedido_venta.estado_sql' => 1];
        $restricciones = ['detalle_venta.estado_sql'=> '1','id_pedido_venta' => $id_pedido['id']];

       
        $data = [
            'pedido' => $pedido_venta->asObject()
            ->select('pedido_venta.*, persona.nombre as cliente_nombre, cliente.id as id_cliente')
            ->join('cliente','cliente.id = pedido_venta.id_cliente')
            ->join('persona','persona.id = cliente.id_persona')
            ->where($condiciones)
            ->paginate(10,'pedido_venta'),
            'pagers' => $pedido_venta->pager,

            'detalle_venta' => $detalle_venta->asObject()
            ->select('detalle_venta.*, item.nombre as item_nombre, item.codigo as item_codigo')
            ->join('item','item.id = detalle_venta.id_item')
            ->where($restricciones)
            ->paginate(10,'detalle_venta'),
            'pager' => $detalle_venta->pager,

            'id' => $id_pedido['id']
        ];
        $this->_loadDefaultView( 'Listado de Pagados',$data,'pagados');
    }

    public function listar(){
        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();
        $plan_cuenta = new m_plan_cuenta();
        $empleado = new m_empleado();

        $id_primer_pedido = $pedido_venta->getPrimer();
        $condiciones = ['pedido_venta.estado' => '2', 'pedido_venta.estado_sql' => 1];
        $restricciones = ['detalle_venta.estado_sql'=> '1','id_pedido_venta' => $id_primer_pedido['id']];

    
        $data = [
            'pedido' => $pedido_venta->asObject()
            ->select('pedido_venta.*, persona.nombre as cliente_nombre, cliente.id as id_cliente')
            ->join('cliente','cliente.id = pedido_venta.id_cliente')
            ->join('persona','persona.id = cliente.id_persona')
            ->where($condiciones)
            ->paginate(10,'pedido_venta'),
            'pagers' => $pedido_venta->pager,

            'detalle_venta' => $detalle_venta->asObject()
            ->select('detalle_venta.*, item.nombre as item_nombre, item.codigo as item_codigo')
            ->join('item','item.id = detalle_venta.id_item')
            ->where($restricciones)
            ->paginate(10,'detalle_venta'),
            'pager' => $detalle_venta->pager,

            'id' => $id_primer_pedido['id']
            
        ];
        $this->_loadDefaultView( 'Pedidos para Entregar',$data,'pagados');
    }

    public function guardar_comprobante($id){
        $comprobante = new m_comprobante();
        $detalle_comprobante = new m_detalle_comprobante();

        $comprobante_creado = $comprobante->getById($id);
        $debe = 0;$haber = 0; 
        $detalles = $detalle_comprobante->asObject()->getDetalles($comprobante_creado->id);

        if($detalles ==null){
            return redirect()->back()->withInput()->with('message', 'Necesita agregar cuentas para CONFIRMAR el comprobante');
        }
        foreach($detalles as $key => $m){
            $debe += $m->debe;
            $haber += $m->haber;
        }
        $body = ['glosa' =>$this->request->getPost('glosa'),
                'tipo_respaldo' => $this->request->getPost('tipo_respaldo'),
                'estado_sql' => 1
                ];
        if($debe == $haber){
            if($this->validate('comprobantes')){
                $comprobante->update($comprobante_creado->id,$body);
                return redirect()->to('/administracion')->with('message', 'Comprobante Guardado');
            }else{
                return redirect()->back()->withInput();
            }
        }
        else{
            return redirect()->to('/administracion/ver_comprobante/'.$comprobante_creado->id)->with('message', 'Los valores en DEBE y HABER no coinciden');
        }
    }

    public function new_detalle($id_comprobante){
       $detalle_comprobante = new m_detalle_comprobante();
        
        $checkBox = $this->request->getPost('myCheckbox');
        $monto = $this->request->getPost('monto');
        if($checkBox == 'debe'){
            $detalle = ['id_comprobante' => $id_comprobante,
                    'id_cuenta' => $this->request->getPost('cuentas'),
                    'debe' => $monto,
                    'haber'=> '0'
                    ];
            if($detalle_comprobante->insert($detalle)){
                return redirect()->to('/administracion/ver_comprobante/'.$id_comprobante)->with('message', 'Partida DEBE agregada');
            }
        }else if($checkBox == 'haber'){
            $detalle = ['id_comprobante' => $id_comprobante,
                    'id_cuenta' => $this->request->getPost('cuentas'),
                    'debe' => '0',
                    'haber'=> $monto
                    ];
            if($detalle_comprobante->insert($detalle)){
                return redirect()->to('/administracion/ver_comprobante/'.$id_comprobante)->with('message', 'Partida HABER agregada');
            }
        }else{
            return redirect()->to('/administracion/ver_comprobante/'.$id_comprobante)->with('message', 'No se pude agregar la partida');
        }   
    }
    public function edit_detalle($id){
        $detalle_comprobante = new m_detalle_comprobante();

        $checkBox = $this->request->getPost('myCheckbox');
        $detalle_comprob = $detalle_comprobante->getByID($id);
        $monto = $this->request->getPost('monto');
        if($checkBox == 'debe'){
            $detalle = [
                    'id_cuenta' => $this->request->getPost('cuentas'),
                    'debe' => $monto,
                    'haber'=> '0'
                    ];
            if($detalle_comprobante->update($id,$detalle)){
                return redirect()->to('/administracion/ver_comprobante/'.$detalle_comprob->id_comprobante)->with('message', 'Partida DEBE editada');
            }
        }else if($checkBox == 'haber'){
            $detalle = [
                    'id_cuenta' => $this->request->getPost('cuentas'),
                    'debe' => '0',
                    'haber'=> $monto
                    ];
            if($detalle_comprobante->update($id,$detalle)){
                return redirect()->to('/administracion/ver_comprobante/'.$detalle_comprob->id_comprobante)->with('message', 'Partida HABER editada');
            }
        }else{
            return redirect()->to('/administracion/ver_comprobante/'.$detalle_comprob->id_comprobante)->with('message', 'No se pudo editar la partida');
        }  

    }
    public function delete_detalle($id){
        $detalle_comprobante = new m_detalle_comprobante();

        $detalle_comprob = $detalle_comprobante->getByID($id);
        
        if($detalle_comprobante->update($id,['estado_sql'=>0])){
            return redirect()->to('/administracion/ver_comprobante/'.$detalle_comprob->id_comprobante)->with('message', 'Partida Eliminada');
        }else{
            return redirect()->to('/administracion/ver_comprobante/'.$detalle_comprob->id_comprobante)->with('message', 'No se pudo eliminar la partida');
        }
    }
    public function ver_comprobante($id){

        $comprobante = new m_comprobante();
        $plan_cuenta = new m_plan_cuenta();
        $detalle_comprobante = new m_detalle_comprobante();

        $comprobante_creado = $comprobante->getById($id);
        $debe = 0;$haber = 0; 
        $detalles = $detalle_comprobante->asObject()->getDetalles($comprobante_creado->id);
        
        foreach($detalles as $key => $m){
            $debe += $m->debe;
            $haber += $m->haber;
        }

        $total = (object)['debe'=>$debe,'haber'=>$haber];

        $cuentas = $plan_cuenta->getCuentas();
        $restricciones = ['detalle_comprobante.id_comprobante'=>$comprobante_creado->id,'detalle_comprobante.estado_sql'=>1];

        $validation =  \Config\Services::validation();
        $data = ['comprobante' => $comprobante_creado,
                
                'detalle_comprobante'=> $detalle_comprobante->asObject()
                ->select('detalle_comprobante.*,detalle_comprobante.id as id_detalle,plan_cuenta.nombre_cuenta,plan_cuenta.codigo_cuenta')
                ->join('plan_cuenta','detalle_comprobante.id_cuenta = plan_cuenta.id')
                ->where( $restricciones)
                ->paginate(10,'detalle_comprobante'),
                'pager' => $detalle_comprobante->pager,

                'cuentas' => $cuentas,

                'total' => $total,

                'validation'=>$validation

                ];
        $this->_loadDefaultView( 'Comprobante #'.$id,$data,'comprobantes');
    }
    public function nuevo_comprobante(){
        $session = session();

        $comprobante = new m_comprobante();
        $empleado = new m_empleado();

        $id_empleado = $session->empleado;
        $cDate = date('Y-m-d H:i:s');

        $contador = $empleado->getContador($id_empleado);
        $comprobante_vigente = $comprobante->getVigente($contador->id);

        if($comprobante_vigente != null){
            return redirect()->to('/administracion/ver_comprobante/'.$comprobante_vigente->id)->with('message', 'Comprobante sin TERMINAR!');
        }
        else{
            $body = [
                    'id_empleado' => $contador->id,
                    'fecha' =>  $cDate,
                    'beneficiario'=>$contador->fullname,
                    'glosa' => '',
                    'tipo_respaldo' => ''
                    ];
            $comprobante->insert($body);
            $id = $comprobante->getInsertID();

            return redirect()->to('/administracion/ver_comprobante/'.$id)->with('message', 'Generando Nuevo Comprobante');
        }
    }
    public function reportes(){

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