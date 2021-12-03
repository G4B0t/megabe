<?php namespace App\Controllers;

use App\Models\m_empleado;
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
use App\Models\m_detalle_transferencia;
use App\Models\m_transferencia;

use App\Models\m_persona;
use App\Models\m_rol;
use App\Models\m_empleado_rol;

class Administracion_3 extends BaseController{

    public function index(){

        $this->_loadDefaultView( '','','index');
    }

    public function nueva_transferencia_envio(){
        $transferencia = new m_transferencia();
        $empleado = new m_empleado();

        $session = session();
		$id_persona = $session->persona;
        $almacenero = $empleado->getAlmacen($id_persona);

        $pedido_vigente = $transferencia->getPedidoVigente($almacenero->id);

        if($pedido_vigente != null){
            $this->show_items($pedido_vigente->id);
        }
        else{
            echo 'No';
            $cDate = date('Y-m-d H:i:s');
            $body = ['id_empleado1' => $almacenero->id,
                    'id_almacen_origen' =>$almacenero->id_almacen,
                    'fecha_envio' => $cDate
                    ];
            
            if($transferencia->insert($body)){
                $id_transferencia = $transferencia->getInsertID();
                $this->show_items($id_transferencia);
            }
        }
       
    }
    public function agregar_item_envio($id_transferencia){
        $transferencia = new m_transferencia();
        $detalle_transferencia = new m_detalle_transferencia();

        $id_item = $this->request->getPost('item_id');
        $cantidad= $this->request->getPost('cantidad');

        $pedido = $transferencia->getByID($id_transferencia); 
        $detalle = $detalle_transferencia->getDetalle($pedido->id,$id_item);
        if($pedido == null){
            return redirect()->to('/administracion')->with('message', 'No hay transferencia aun.');
        }
        $body = ['id_item' => $id_item,
                'id_transferencia' =>$id_transferencia,
                'cantidad'=>$cantidad
                ];
        if($detalle == null){
            if($detalle_transferencia->insert($body)){
                return redirect()->to('/administracion/ver_pedido_trasferencia/'.$id_transferencia)->with('message', 'Item agregado con exito a la Transferencia.');
            }
            return redirect()->to('/administracion/ver_pedido_trasferencia/'.$id_transferencia)->with('message', 'No se pudo crear la nueva Transferencia.');
        }
        else{
            $old_cantidad = $detalle->cantidad;
            $new_cantidad = $old_cantidad+$cantidad;
            $update_body = ['cantidad'=>$new_cantidad];
            if($detalle_transferencia->update($detalle->id, $update_body)){
                return redirect()->to('/administracion/ver_pedido_trasferencia/'.$id_transferencia)->with('message', 'Se aumento con exito el producto.');
            }
            return redirect()->to('/administracion/ver_pedido_trasferencia/'.$id_transferencia)->with('message', 'No se pudo actualizar la cantidad de producto.');
        }
        
    }
    public function ver_carrito_envio($id_transferencia){
        $transferencia = new m_transferencia();
        $detalle_transferencia = new m_detalle_transferencia();
        $almacen = new m_almacen();

        $detalles = $detalle_transferencia->getFullDetalle($id_transferencia);
        if( $detalles != null){
            $pedido = $transferencia->getById($id_transferencia);
            $almacenes_destino = $almacen->getOtros($pedido->id_almacen_origen);
            $restricciones = ['detalle_transferencia.id_transferencia' => $id_transferencia,'detalle_transferencia.estado_sql'=> 1];
            $data = [
                'detalle_transferencia' => $detalle_transferencia->asObject()
                ->select('detalle_transferencia.*, item.nombre as item_nombre, item.codigo as item_codigo')
                ->join('item','item.id = detalle_transferencia.id_item')
                ->join('transferencia','transferencia.id = detalle_transferencia.id_transferencia')
                ->where($restricciones)
                ->paginate(10,'detalle_transferencia'),
                'pager' => $detalle_transferencia->pager,

                'id_transferencia' => $pedido->id,

                'almacen' => $almacenes_destino,

                'transferencia' =>$pedido
            ];

            $this->_loadDefaultView( 'Detalle de Transferencia',$data,'detalle_transferencia');
        }else{

             return redirect()->to('/administracion/show_items/'.$id_transferencia)->with('message', 'Su pedido esta vacio');
        }

    }
    
    public function show_items_filtrado($id_transferencia){
        $item = new m_item();
        $transferencia = new m_transferencia();
        $empleado = new m_empleado();

        $session = session();
		$id_persona = $session->persona;
        $almacenero = $empleado->getAlmacen($id_persona);
		
		$condiciones = ['item.estado_sql' => '1','item_almacen.id_almacen'=>$almacenero->id_almacen];
        $pedido = $transferencia->getById($id_transferencia);

        $filtro = $this->request->getPost('filtro');
        $array = [
			'marca.nombre' => $filtro, 
			'item.codigo' => $filtro, 
			'item.descripcion' => $filtro, 
			'subcategoria.nombre' => $filtro, 
			'categoria.nombre' =>$filtro,
		];

        if($pedido==null){
            return redirect()->to('/administracion')->with('message', 'No existe el pedido aun!.');
        }
		$data = [
			'item' => $item->asObject()
            ->select('item.*,marca.id AS marcaId, 
					marca.nombre AS marca, subcategoria.id AS subcategoriaID, 
					subcategoria.nombre AS subcategoria, categoria.id AS categoriaID, 
					categoria.nombre AS categoria, item_almacen.stock as stock_alma')
			->join('marca','item.id_marca = marca.id')
			->join('subcategoria','marca.id_subcategoria = subcategoria.id')
			->join('categoria','subcategoria.id_categoria = categoria.id')
            ->join('item_almacen','item.id = item_almacen.id_item')
			->where($condiciones)
            ->like('item.nombre', $filtro)
			->orlike($array)
            ->paginate(10,'item'),

            'pager' =>$item->pager,

            'id_transferencia' =>$pedido->id,

            'almacen' => $almacenero->direccion
        ];

		$this->_loadDefaultView( 'Listado para Envio',$data,'productos_transferencia');

    }
    public function show_items($id_transferencia){
        $item = new m_item();
        $transferencia = new m_transferencia();
        $empleado = new m_empleado();

        $session = session();
		$id_persona = $session->persona;
        $almacenero = $empleado->getAlmacen($id_persona);
		
		$condiciones = ['item.estado_sql' => '1','item_almacen.id_almacen'=>$almacenero->id_almacen];
        $pedido = $transferencia->getById($id_transferencia);

        if($pedido==null){
            return redirect()->to('/administracion')->with('message', 'No existe el pedido aun!.');
        }
		$data = [
			'item' => $item->asObject()
            ->select('item.*,marca.id AS marcaId, 
					marca.nombre AS marca, subcategoria.id AS subcategoriaID, 
					subcategoria.nombre AS subcategoria, categoria.id AS categoriaID, 
					categoria.nombre AS categoria, item_almacen.stock as stock_alma')
			->join('marca','item.id_marca = marca.id')
			->join('subcategoria','marca.id_subcategoria = subcategoria.id')
			->join('categoria','subcategoria.id_categoria = categoria.id')
            ->join('item_almacen','item.id = item_almacen.id_item')
			->where($condiciones)
            ->paginate(10,'item'),

            'pager' =>$item->pager,

            'id_transferencia' =>$pedido->id,

            'almacen' => $almacenero->direccion
        ];

		$this->_loadDefaultView( 'Listado para Envio',$data,'productos_transferencia');

    }
    public function delete_linea($id){
        $detalle_transferencia= new m_detalle_transferencia();
        $pedido = $detalle_transferencia->getByDetalle($id);

        if ($detalle_transferencia->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        $detalle_transferencia->update($id, [
            'estado_sql' =>'0'              
        ]);       
        return redirect()->to('/administracion/ver_pedido_trasferencia/'.$pedido->id)->with('message', 'Producto eliminado del detalle.');
    }
    public function confirm_transferencia($id_transferencia){
        $transferencia = new m_transferencia();
        $item_almacen = new m_item_almacen();
        $almacen = new m_almacen();
        $detalle_transferencia = new m_detalle_transferencia();

        $detalles = $detalle_transferencia->getFullDetalle($id_transferencia);
        $id_almacen_destino =  $this->request->getPost('id_almacen_destino');
        $transfe = $transferencia->getById($id_transferencia);
        

        foreach($detalles as $key =>$m){
            $item_origen = $item_almacen->getStocks($transfe->id_almacen_origen,$m->id_item);
            $stock_origen = ($item_origen->stock) - ($m->cantidad);

            if($stock_origen < 0){
                return redirect()->to('/administracion/ver_pedido_trasferencia/'.$id_transferencia)->with('message', 'ERROR!! Verifique existencia de stock en ALMACEN!');
            }  

            $prov = $item_almacen->update($item_origen->id,['stock'=>$stock_origen]);
            if(!$prov){
                return redirect()->back()->withInput()->with('message', 'No se pudo confirmar el ENVIO!');
            }
        }

        if ($transferencia->find($id_transferencia) == null){
            throw PageNotFoundException::forPageNotFound();
        }  
        $cDate = date('Y-m-d H:i:s');
        $body_transferencia = ['fecha_envio' =>$cDate, 'estado_sql'=>1,'id_almacen_destino'=> $id_almacen_destino];
                if($transferencia->update($id_transferencia,$body_transferencia)){
                    $this->ver_enviados();
                }
    }
    public function ver_enviados(){
        $transferencia = new m_transferencia();
        $detalle_transferencia = new m_detalle_transferencia();
        $empleado = new m_empleado();
        $empleado_rol = new m_empleado_rol();
        $generales = new m_generales();

        $session = session();
		$id_persona = $session->persona;
        $almacenero = $empleado->getAlmacen($id_persona);
        $admin = $empleado_rol->getAdmin($almacenero->id);
        $gen = $generales->asObject()->first();

        $pedido_transferencia = $transferencia->getFirst($almacenero->id);

        if($pedido_transferencia == NULL){
            return redirect()->to('/administracion')->with('message', 'NO hay transferencias de ENVIO');
        }

        $condiciones = ['transferencia.estado_sql' => 1,'fecha_envio >=' =>$gen->gestion.'-01-01','fecha_envio <=' =>$gen->gestion.'-12-31'];
        $restricciones = ['detalle_transferencia.estado_sql'=> '1','id_transferencia' => $pedido_transferencia->id];
        $data = [
            'transferencia' => $transferencia->asObject()
            ->select('transferencia.*,A.direccion,B.direccion as destino, CONCAT(persona.nombre, " ", persona.apellido_paterno) AS empleado_nombre1')
            ->join('almacen A','A.id=transferencia.id_almacen_origen')
            ->join('almacen B','B.id=transferencia.id_almacen_destino')
            ->join('empleado','empleado.id = transferencia.id_empleado1')
            ->join('persona','persona.id = empleado.id_persona')
            ->where($condiciones)
            ->orderBy('fecha_envio','DESC')
            ->paginate(10,'transferencia'),
            'pagers' => $transferencia->pager,

            'detalle_transferencia' => $detalle_transferencia->asObject()
            ->select('detalle_transferencia.*, item.nombre as item_nombre, item.codigo as item_codigo')
            ->join('item','item.id = detalle_transferencia.id_item')
            ->where($restricciones)
            ->paginate(10,'detalle_transferencia'),
            'pager' => $detalle_transferencia->pager,

            'id' => $pedido_transferencia->id
        ];

        $this->_loadDefaultView( 'Envios desde: '.$almacenero->direccion,$data,'enviados');
    }
    public function detalles_transferencias($id_trasnferencia){

        $transferencia = new m_transferencia();
        $detalle_transferencia = new m_detalle_transferencia();
        $empleado = new m_empleado();
        $generales = new m_generales();

        $session = session();
		$id_persona = $session->persona;
        $almacenero = $empleado->getAlmacen($id_persona);
        $gen = $generales->asObject()->first();

        $pedido_transferencia = $transferencia->getById($id_trasnferencia);

        $condiciones = ['transferencia.estado_sql' => 1,'fecha_envio >=' =>$gen->gestion.'-01-01','fecha_envio <=' =>$gen->gestion.'-12-31'];
        $restricciones = ['detalle_transferencia.estado_sql'=> '1','id_transferencia' => $pedido_transferencia->id];
        $data = [
            'transferencia' => $transferencia->asObject()
            ->select('transferencia.*,A.direccion,B.direccion as destino, CONCAT(persona.nombre, " ", persona.apellido_paterno) AS empleado_nombre1')
            ->join('almacen A','A.id=transferencia.id_almacen_origen')
            ->join('almacen B','B.id=transferencia.id_almacen_destino')
            ->join('empleado','empleado.id = transferencia.id_empleado1')
            ->join('persona','persona.id = empleado.id_persona')
            ->orderBy('fecha_envio','DESC')
            ->where($condiciones)
            ->paginate(10,'transferencia'),
            'pagers' => $transferencia->pager,

            'detalle_transferencia' => $detalle_transferencia->asObject()
            ->select('detalle_transferencia.*, item.nombre as item_nombre, item.codigo as item_codigo')
            ->join('item','item.id = detalle_transferencia.id_item')
            ->where($restricciones)
            ->paginate(10,'detalle_transferencia'),
            'pager' => $detalle_transferencia->pager,

            'id' => $pedido_transferencia->id

        ];

        $this->_loadDefaultView( 'Envios desde: '.$almacenero->direccion,$data,'enviados');
    }

    public function ver_recepcion_transferencia(){
        $transferencia = new m_transferencia();
        $detalle_transferencia = new m_detalle_transferencia();
        $empleado = new m_empleado();
        $generales = new m_generales();

        $session = session();
		$id_persona = $session->persona;
        $almacenero = $empleado->getAlmacen($id_persona);
        $gen = $generales->asObject()->first();

        $pedido_transferencia = $transferencia->getByEmpleado($almacenero->id_almacen);
        if($pedido_transferencia ==null || $pedido_transferencia->id_almacen_destino == null){
            return redirect()->to('/administracion')->with('message', 'No hay mas Transferencias Enviadas a este Almacen!');
        }
        
        $condiciones = ['transferencia.id_almacen_destino' => $almacenero->id_almacen, 'transferencia.estado_sql' => 1,
                        'fecha_envio >=' =>$gen->gestion.'-01-01','fecha_envio <=' =>$gen->gestion.'-12-31',
                        'transferencia.id_empleado2' => null];
        $restricciones = ['detalle_transferencia.estado_sql'=> '1','detalle_transferencia.id_transferencia' => $pedido_transferencia->id];
        $data = [
            'transferencia' => $transferencia->asObject()
            ->select('transferencia.*,almacen.direccion, CONCAT(persona.nombre, " ", persona.apellido_paterno) AS empleado_nombre2')
            ->join('almacen','almacen.id = transferencia.id_almacen_origen')
            ->join('empleado','empleado.id = transferencia.id_empleado1')
            ->join('persona','persona.id = empleado.id_persona')
            ->where($condiciones)
            ->paginate(10,'transferencia'),
            'pagers' => $transferencia->pager,

            'detalle_transferencia' => $detalle_transferencia->asObject()
            ->select('detalle_transferencia.*, item.nombre as item_nombre, item.codigo as item_codigo')
            ->join('item','item.id = detalle_transferencia.id_item')
            ->where($restricciones)
            ->paginate(10,'detalle_transferencia'),
            'pager' => $detalle_transferencia->pager,

            'id' => $pedido_transferencia->id,

            'id_empleado2' =>$almacenero->id
        ];
       $this->_loadDefaultView( 'Listado para Recepcion',$data,'recibidos');

    }

    public function ver_detalle_recepcion($id_transferencia){
        $transferencia = new m_transferencia();
        $detalle_transferencia = new m_detalle_transferencia();
        $empleado = new m_empleado();
        $generales = new m_generales();

        $session = session();
		$id_persona = $session->persona;
        $almacenero = $empleado->getAlmacen($id_persona);
        $gen = $generales->asObject()->first();

        $pedido_transferencia = $transferencia->getById($id_transferencia);
        if($pedido_transferencia ==null){
            return redirect()->to('/administracion')->with('message', 'No hay Transferencias Enviadas a este Almacen!');
        }

        $condiciones = ['transferencia.id_almacen_destino' => $almacenero->id_almacen, 'transferencia.estado_sql' => 1,
                        'fecha_envio >=' =>$gen->gestion.'-01-01','fecha_envio <=' =>$gen->gestion.'-12-31',
                        'transferencia.id_empleado2' => null];
        $restricciones = ['detalle_transferencia.estado_sql'=> '1','detalle_transferencia.id_transferencia' => $pedido_transferencia->id];
        $data = [
            'transferencia' => $transferencia->asObject()
            ->select('transferencia.*, almacen.direccion, CONCAT(persona.nombre, " ", persona.apellido_paterno) AS empleado_nombre2')
            ->join('almacen','almacen.id = transferencia.id_almacen_origen')
            ->join('empleado','empleado.id = transferencia.id_empleado1')
            ->join('persona','persona.id = empleado.id_persona')
            ->where($condiciones)
            ->paginate(10,'transferencia'),
            'pagers' => $transferencia->pager,

            'detalle_transferencia' => $detalle_transferencia->asObject()
            ->select('detalle_transferencia.*, item.nombre as item_nombre, item.codigo as item_codigo')
            ->join('item','item.id = detalle_transferencia.id_item')
            ->where($restricciones)
            ->paginate(10,'detalle_transferencia'),
            'pager' => $detalle_transferencia->pager,

            'id' => $pedido_transferencia->id,

            'id_empleado2' => $almacenero->id
        ];
       
        $this->_loadDefaultView( 'Listado para Recepcion',$data,'recibidos');
    }

    public function confirmar_recepcion($id_transferencia){
        $transferencia = new m_transferencia();
        $empleado = new m_empleado();
        $detalle_transferencia = new m_detalle_transferencia();
        $item_almacen = new m_item_almacen();
        $almacen = new m_almacen();

        $detalles = $detalle_transferencia->getFullDetalle($id_transferencia);
        $transfe = $transferencia->getById($id_transferencia);

        $session = session();
		$id_persona = $session->persona;
        $almacenero = $empleado->getAlmacen($id_persona);

        foreach($detalles as $key =>$m){
            $item_destino = $item_almacen->getStocks($transfe->id_almacen_destino,$m->id_item);
            $stock_destino = ($item_destino->stock) + ($m->cantidad);
            $prov = $item_almacen->update($item_destino->id,['stock'=>$stock_destino]);
            if(!$prov){
                return redirect()->back()->withInput()->with('message', 'No se pudo confirmar el ENVIO!');
            }
        }

        $cDate = date('Y-m-d H:i:s');
        $body = ['id_empleado2' => $almacenero->id,
                'fecha_recibido' => $cDate
                ];

        if ($transferencia->find($id_transferencia) == null){
            throw PageNotFoundException::forPageNotFound();
        }  
        if($transferencia->update($id_transferencia,$body)){
            return redirect()->to('/administracion')->with('message', 'Transferencia RECIBIDA!!');
        }

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