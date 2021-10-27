<?php namespace App\Controllers;
;
use App\Controllers\BaseController;
use App\Controllers\Administracion_1;
use \CodeIgniter\Exceptions\PageNotFoundException;
use CodeIgniter\I18n\Time;

use App\Models\m_item;
use App\Models\m_detalle_venta;
use App\Models\m_pedido_venta;
use App\Models\m_auxiliar;
use App\Models\m_cliente;

use App\Models\m_subcategoria;
use App\Models\m_categoria;
use App\Models\m_marca;

class Detalle_Venta extends BaseController {

    public function index(){

        $admin = new Administracion_1();
		$sesion = $admin->sesiones();
        if($sesion['rol'] != 'Cliente'){
            if($sesion['rol'] == 'Normal'){
                return redirect()->to('/')->with('message', 'Necesita logearse!');
            }else{
                return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
            }
           
        }

        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();
        $cliente = new m_cliente();

        $session = session();
        $id_cliente = $session->cliente;
        
        if($pedido = $pedido_venta->getPedido($id_cliente)){
            $condiciones = ['estado' => '0', 'estado_sql' => '1', 'id_cliente' => $id_cliente];
            $restricciones = ['detalle_venta.estado_sql'=> '1','id_pedido_venta' => $pedido['id']];

            $detalles = $detalle_venta->getFullDetalle($pedido['id']);
            $total = 0;
            foreach($detalles as $key => $m){
                $total += $m->total;
            }
            
            $data = [
                'detalle_venta' => $detalle_venta->asObject()
                ->select('detalle_venta.*, item.nombre as item_nombre, item.codigo as item_codigo,pedido_venta.moneda')
                ->join('item','item.id = detalle_venta.id_item')
                ->join('pedido_venta','pedido_venta.id = detalle_venta.id_pedido_venta')
                ->where($restricciones)
                ->paginate(10,'detalle_venta'),
                'pager' => $detalle_venta->pager,

                'total' => $total,

                'id_pedido' => $pedido['id'],

                'cliente' => $cliente->asArray()
                ->select('cliente.*, CONCAT(persona.nombre, " ", persona.apellido_paterno) nombre_cliente')
                ->join('persona','cliente.id_persona = persona.id')
                ->where('cliente.id',$id_cliente)
                ->first()
            ];

            $this->_loadDefaultView( 'Detalle de Pedido',$data,'index');
        }else{

             return redirect()->to('/pedido_venta')->with('message', 'SU CARRITO ESTA VACIO');
        }

       /* if($this->comprobarFecha()){
            echo "Pedido vigente";

        }
        else{
            $pedido_venta = new m_pedido_venta();
            $id_pedido_vigente = $pedido_venta->getPedido();
            $this->delete($id_pedido_vigente['id']);
            
            echo "F: ".$this->create();;
        }*/
        
    }

    public function confirmarPedido($id_pedido){

        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();
        $cliente = new m_cliente();
        
        $session = session();
        $id_cliente = $session->cliente;

        $detalles = $detalle_venta->getFullDetalle($id_pedido);

         if($detalles == null){
            return redirect()->to('/detalle_venta')->with('message', 'CARRITO VACIO');
        }

        $total = 0;
        foreach($detalles as $key => $m){
            $total += $m->total;
            }
        if($pedido_venta->update(
            $id_pedido,[
                'estado' => '1',
                'total'=>$total
            ]
        )){
            $body = [
                'razon_social' => $this->request->getPost('razon_social'),
                'nit' => $this->request->getPost('nit')
            ];
           if($cliente->update($id_cliente,$body)){

            return redirect()->to('/pedido_venta')->with('message', 'DATOS DE FACTURA CONFIRMADOS');
           }
           else{

            return redirect()->to('/pedido_venta')->with('message', 'No se pudo confirmar datos de FACTURA');
           }
        }else{

            return redirect()->to('/detalle_venta')->with('message', 'No se pudo confirmar datos');
        }
	}

   
    public function comprobarFecha(){

        $auxiliar = new m_auxiliar();
        $pedido_venta = new m_pedido_venta();
        $id_pedido_vigente = $pedido_venta->getPedido();

        $myvalue = $id_pedido_vigente['fecha'];

        $datetime = new Time($myvalue);

        $date = $datetime->format('Y-m-d');
        $time = $datetime->format('H:i:s');
          
        // getting current date 
        $cDate = strtotime(date('Y-m-d H:i:s'));
        
        // Getting the value of old date + 24 hours
        $timestamp = strtotime($date . ' ' . $time); //1373673600
        $restriccion = $auxiliar->getRestriccionPedido();
        $horas = $restriccion['valor'] * 3600; 
        $oldDate = $timestamp+$horas; // transformando a segundos las horas estimadas
        $prueba=date('Y-m-d H:i:s');
        if($oldDate > $cDate)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function carrito($id_item){
        $detalle_venta = new m_detalle_venta();
        $pedido_venta = new m_pedido_venta();
        $cliente = new m_cliente();
        $item = new m_item();

        $session = session();
        $id_cliente = $session->cliente;

        $pedido = $pedido_venta->getPedido($id_cliente);
        if($pedido!=null){
            $detalle = $detalle_venta->getDetalle($pedido['id'],$id_item);
            $cantidad = $this->request->getPost('cantidad');
            $nuevaCantidad = $detalle['cantidad'] + $cantidad;
            $total = $detalle['total'] + ($detalle['precio_unitario']* $cantidad);

            $nuevo_detalle = [
                'cantidad' =>$nuevaCantidad,
                'total' =>$total 
            ];
            if($detalle == null){
                $cantidad = $this->request->getPost('cantidad');
                $product = $item->getOne($id_item);
                $pu = $product->precio_unitario;
                $total = $pu * $cantidad;
                $nuevo_detalle = ['id_pedido_venta'=>$pedido['id'],
                    'id_item'=>$product->id,
                    'cantidad' =>$cantidad,
                    'precio_unitario'=>$product->precio_unitario,
                    'total' =>$total 
                ]; 
                if($detalle_venta->insert($nuevo_detalle)){
                    return redirect()->to('/detalle_venta')->with('message', 'Nuevo Producto Agregado con EXITO!');
                }
            }else{
                if($detalle_venta->update($detalle['id'],$nuevo_detalle)){

                $detalles = $detalle_venta->getFullDetalle($pedido['id']);
                $total = 0;
                foreach($detalles as $key => $m){
                    $total += $m->total;
                }

                $condiciones = ['detalle_venta.estado_sql'=>'1','id_pedido_venta'=> $pedido['id']];
                $data = [
                    'detalle_venta' => $detalle_venta->asObject()
                    ->select('detalle_venta.*, item.nombre as item_nombre, item.codigo as item_codigo, pedido_venta.moneda')
                    ->join('item','item.id = detalle_venta.id_item')
                    ->join('pedido_venta','pedido_venta.id = detalle_venta.id_pedido_venta')
                    ->where($condiciones)
                    ->paginate(10,'detalle_venta'),
                    'pager' => $detalle_venta->pager,

                    'cliente' => $cliente->asArray()
                                ->select('cliente.*, CONCAT(persona.nombre, " ", persona.apellido_paterno) nombre_cliente')
                                ->join('persona','cliente.id_persona = persona.id')
                                ->where('cliente.id',$id_cliente)
                                ->first(),

                    'total' => $total,

                    'id_pedido'=>$pedido['id']

                    ];

                $this->_loadDefaultView( 'Detalle de Pedido #'.$pedido['id'],$data,'index');
                }
                else{
                    return redirect()->to('/detalle/$id_item')->with('message', 'No se pudo agregar producto al carrito.');
                }  
            }     
        }
        else{
            $cDate = date('Y-m-d H:i:s');
            $body=['fecha'=>$cDate,
                    'estado'=>0,
                    'id_cliente'=>$id_cliente];
            if($pedido_venta->insert($body)){
                $cantidad = $this->request->getPost('cantidad');
                $product = $item->getOne($id_item);
                $pu = $product->precio_unitario;
                $total = $pu * $cantidad;
                $pedido = $pedido_venta->getInsertID();
                $nuevo_detalle = ['id_pedido_venta'=>$pedido,
                    'id_item'=>$product->id,
                    'cantidad' =>$cantidad,
                    'precio_unitario'=>$product->precio_unitario,
                    'total' =>$total 
                ];  
                if($detalle_venta->insert($nuevo_detalle)){
                    $detalles = $detalle_venta->getFullDetalle($pedido);
                    $total = 0;
                    foreach($detalles as $key => $m){
                        $total += $m->total;
                    }
                    $condiciones = ['detalle_venta.estado_sql'=>'1','id_pedido_venta'=> $pedido['id']];
                    $data = [
                        'detalle_venta' => $detalle_venta->asObject()
                        ->select('detalle_venta.*, item.nombre as item_nombre, item.codigo as item_codigo, pedido_venta.moneda')
                        ->join('item','item.id = detalle_venta.id_item')
                        ->join('pedido_venta','pedido_venta.id = detalle_venta.id_pedido_venta')
                        ->where($condiciones)
                        ->paginate(10,'detalle_venta'),
                        'pager' => $detalle_venta->pager,

                        'cliente' => $cliente->asArray()
                                    ->select('cliente.*, CONCAT(persona.nombre, " ", persona.apellido_paterno) nombre_cliente')
                                    ->join('persona','cliente.id_persona = persona.id')
                                    ->where('cliente.id',$id_cliente)
                                    ->first(),

                        'total' => $total,

                        'id_pedido'=>$pedido
                        ];
                 return redirect()->to('/detalle_venta')->with('message', 'Producto Agregado con Exito!');
                }
            }
           
        }          
    }

    public function update($id = null){
        $detalle_venta = new m_detalle_venta();

        if ($detalle_venta->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $detalle_venta->update($id, [
            'cantidad' =>$this->request->getPost('estado'),
            'precio' =>$this->request->getPost('moneda'),
            'descuento' =>$this->request->getPost('tipo_pago'),
            'total' =>$this->request->getPost('total')      
        ]);   
       
    }

    public function delete($id = null){
       
        $detalle_venta = new m_detalle_venta();

        if ($detalle_venta->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        $detalle_venta->update($id, [
            'estado_sql' =>'0'              
        ]);       
        return redirect()->to('/detalle_venta')->with('message', 'Producto eliminado del detalle.');
    }

    private function _loadDefaultView($title,$data,$view){
        $categoria = new m_categoria();
		$subcategoria = new m_subcategoria();
		$marca = new m_marca();
		
		$admin = new Administracion_1();
		$sesion = $admin->sesiones();
        $vista='';
        if($sesion['rol']=='Administrador'){
            $vista='cliente';
        }
        $rol[] = (object) array('nombre' => $sesion['rol']);
        $dataHeader =[
            'title' => $title,
            'tipo' =>'header-inner-pages',

			'categoria' => $categoria->asObject()
            ->select('categoria.*')
            ->paginate(10,'categoria'),

			'subcategoria' => $subcategoria->asObject()
            ->select('subcategoria.*')
            ->join('categoria','categoria.id = subcategoria.id_categoria')
            ->paginate(10,'subcategoria'),

			'marca' => $marca->asObject()
			->select('marca.*')
            ->join('subcategoria','subcategoria.id = marca.id_subcategoria')
            ->paginate(10,'marca'),

            'rol' => $rol,

			'log' => $sesion['log'],

            'vista'=>$vista
        ];

        echo view("dashboard/templates/header",$dataHeader);
        echo view("dashboard/detalle_venta/$view",$data);
        echo view("dashboard/templates/footer");
    }

}