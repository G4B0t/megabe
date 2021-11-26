<?php namespace App\Controllers;
use App\Models\m_pedido_venta;
use App\Models\m_detalle_venta;
use App\Models\m_item;

use App\Models\m_subcategoria;
use App\Models\m_categoria;
use App\Models\m_marca;


use App\Controllers\BaseController;
use App\Controllers\Administracion_1;
use \CodeIgniter\Exceptions\PageNotFoundException;

class Pedido_Venta extends BaseController {

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

        $session = session();
        $id_cliente = $session->cliente;

        $id_pedido_vigente = $pedido_venta->getPedido($id_cliente);
        $condiciones = ['pedido_venta.estado_sql' => '1', 'pedido_venta.id_cliente' => $id_cliente];

        $restricciones = ['detalle_venta.estado_sql'=> '1','id_pedido_venta' =>$id_pedido_vigente['id']];
        $data = [
            'pedido_venta' => $pedido_venta->asObject()
            ->select('pedido_venta.*, auxiliar.nombre as estado_ref')
            ->join('auxiliar','auxiliar.valor = pedido_venta.estado')
            ->where($condiciones)
            ->paginate(10,'pedido_venta'),
            
            'pagers' => $pedido_venta->pager,

            'detalle_venta' => $detalle_venta->asObject()
            ->select('detalle_venta.*, item.nombre as item_nombre, item.codigo as item_codigo')
            ->join('item','item.id = detalle_venta.id_item')
            ->where($restricciones)
            ->paginate(10,'detalle_venta'),

            'pager' => $detalle_venta->pager
        ];

        $this->_loadDefaultView( 'Listado de Pedidos',$data,'index');
    }

    public function create(){

        $pedido_venta = new m_pedido_venta();
        // getting current date 
        $cDate = date('Y-m-d H:i:s');
            $id = $pedido_venta->insert([
                'estado' =>'0',
                'fecha' =>$cDate
            ]);
    }

    public function mostrando($id){

        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();
        $session = session();
        $id_cliente = $session->cliente;
        $condiciones = ['estado >=' => '0', 'estado_sql' => '1', 'id_cliente' => $id_cliente];
        $data = [
            'pedido_venta' => $pedido_venta->asObject()
            ->select('pedido_venta.*, auxiliar.nombre as estado_ref')
            ->join('auxiliar','auxiliar.valor = pedido_venta.estado')
            ->where($condiciones)
            ->paginate(10,'pedido_venta'),
            'pagers' => $pedido_venta->pager,

            'detalle_venta' => $detalle_venta->asObject()
            ->select('detalle_venta.*, item.nombre as item_nombre, item.codigo as item_codigo')
            ->join('item','item.id = detalle_venta.id_item')
            ->where('id_pedido_venta', $id)
            ->paginate(10,'detalle_venta'),
            'pager' => $detalle_venta->pager,
        ];

        $this->_loadDefaultView( 'Listado de Pedidos',$data,'index');
    }

    public function actualizarVigente($id){
        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();

        $pedido = $pedido_venta->getPedido($id);
        $detalles = $detalle_venta->getFullDetalle($id);
        $total = 0;
        foreach($detalles as $key => $m){
            $total += $m->total;
        }        
        if($pedido_venta->update($id,['total'=>$total])){

            return redirect()->to('/pedido_venta')->with('message', 'Se actualizo con exito.');

        }else{
            return redirect()->to('/pedido_venta')->with('message', 'No se pudo actualizar el pedido.');
        }
    }


    public function delete($id = null){
        $pedido_venta = new m_detalle_venta();

        if ($pedido_venta->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        $pedido_venta->update($id, [
            'estado_sql' =>'0'              
        ]);       
        return redirect()->to('/administracion')->with('message', 'Pedido Cancelado.');
    }
    private function _loadDefaultView($title,$data,$view){

        $categoria = new m_categoria();
		$subcategoria = new m_subcategoria();
		$marca = new m_marca();

        $admin = new Administracion_1();
		$sesion = $admin->sesiones();
        $vista='';
        $central = false;
        
        $rol[] = (object) array('nombre' => $sesion['rol']);
        $dataHeader =[
            'title' => $title,
            'tipo'=>'header-inner-pages',
            
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

            'vista'=>$vista,
            
            'central' => $central
        ];

        echo view("dashboard/templates/header",$dataHeader);
        echo view("dashboard/pedido_venta/$view",$data);
        echo view("dashboard/templates/footer");
    }

}