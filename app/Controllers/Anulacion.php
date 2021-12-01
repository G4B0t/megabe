<?php namespace App\Controllers;
use App\Models\m_anulacion;
use App\Models\m_factura_venta;
use App\Models\m_comprobante;
use App\Models\m_empleado;
use App\Models\m_generales;
use App\Models\m_item;
use App\Models\m_item_almacen;
use App\Models\m_detalle_comprobante;
use App\Models\m_detalle_venta;
use App\Models\m_pedido_venta;
use App\Models\m_plan_cuenta;
use App\Controllers\BaseController;
use \CodeIgniter\Exceptions\PageNotFoundException;
use App\Controllers\Administracion_1;

class Anulacion extends BaseController {

    public function index(){
        $generales = new m_generales();
        $admin = new Administracion_1();
        $gen = $generales->asObject()->first();
		$sesion = $admin->sesiones();
        $admin = '';
        foreach($sesion['rol'] as $key =>$m){
            $admin = $m->nombre;
        }
        if($admin != 'Administrador'){
           return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }

        $anulacion = new m_anulacion();
        $condiciones = ['anulacion.estado_sql' => 1, 'factura_venta.estado_sql' => 0, 'fecha >=' =>$gen->gestion.'-01-01','fecha <=' =>$gen->gestion.'-12-31'];
        $data = [
            'anulacion' => $anulacion->asObject()
                        ->select('anulacion.*,factura_venta.total,factura_venta.beneficiario')
                        ->join('factura_venta','anulacion.id_factura = factura_venta.id')
                        ->where($condiciones)
                        ->paginate(10,'anulacion'),
            'pager' => $anulacion->pager
        ];

        $this->_loadDefaultView( 'Listado de Facturas Anuladas',$data,'index');
    }

    public function new(){
        $generales = new m_generales();
        $gen = $generales->asObject()->first();
        
        $restriccion = ['estado_sql'=>1,'fecha_emision >=' =>$gen->gestion.'-01-01','fecha_emision <=' =>$gen->gestion.'-12-31'];
        $anulacion = new m_anulacion;
        $factura_venta = new m_factura_venta();
        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Crear Anulacion de Factura',['validation'=>$validation, 
                                                            'anulacion'=> $anulacion,
                                                            'factura_venta'=>$factura_venta->asObject()->where($restriccion)->orderBY('nro_factura','ASC')->findAll()],'new');
    }

    public function create(){
        helper("user");

        $anulacion = new m_anulacion();
        $empleado = new m_empleado();
        $generales = new m_generales();
        $item = new m_item();
        $item_almacen = new m_item_almacen();
        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();
        $plan_cuenta = new m_plan_cuenta();
        $comprobante = new m_comprobante();
        $detalle_comprobante = new m_detalle_comprobante();
        $factura_venta = new m_factura_venta();
        
        $session = session();
        $id_empleado = $session->empleado;
        $emple = $empleado->getOne($id_empleado);
        $gen = $generales->asObject()->first();

        $empl  = $empleado->getFullEmpleado($session->empleado);
        $password = $this->request->getPost('password');
        if($empl->rol != 'Administrador'){
            return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }
        
        if(verificarPassword($password,$empl->contrasena)){

            $cDate = date('Y-m-d H:i:s'); 
            $tipo_respaldo = 'Comprobante';
            $glosa = 'Anulacion de Factura de Venta';
            $id_factura = $this->request->getPost('id_factura');
            $pedido = $pedido_venta->getById($id_factura);
            $detalles = $detalle_venta->getFullDetalle($pedido->id);
            $caja_general = $plan_cuenta->getCajaGeneral();
            
            $cuenta_haber = $plan_cuenta->getCaja_Venta($id_factura);
            $cuenta_debe = $plan_cuenta->getCuenta_Generales($gen->cuenta_ventas);
            $factura = $factura_venta->asObject()->where(['id_pedido_venta'=>$id_factura])->first();

            $total = $pedido->total;    

            if($this->validate('anulaciones')){
                if($anulacion->insert([
                    'motivo' =>$this->request->getPost('motivo'),
                    'id_factura' =>$id_factura,
                    'fecha' =>$cDate,
                    'estado_sql' => 1 
                ])){
                    $body_comprobante = ['id_empleado'=>$emple['id'],
                                        'id_factura'=>$this->request->getPost('id_factura'),
                                        'fecha' => $cDate,
                                        'tipo_respaldo' => $tipo_respaldo,
                                        'glosa' => $glosa,
                                        'beneficiario' => $factura->beneficiario,
                                        'estado_sql'=>1
                                        ];
                    if($comprobante->insert($body_comprobante)){
                        $id_comp = $comprobante->getInsertID();
                        $body_debe = ['id_comprobante'=>$id_comp,
                                            'id_cuenta'=>$cuenta_debe->id,
                                            'debe'=>$total,
                                            'haber'=>'0',
                                            'estado_sql'=>1                   
                        ];
                        $body_haber =['id_comprobante'=>$id_comp,
                                        'id_cuenta'=>$cuenta_haber->id,
                                        'debe'=>'0',
                                        'haber'=>$total,
                                        'estado_sql'=>1                   
                        ];
                        if($detalle_comprobante->insert($body_debe) && $detalle_comprobante->insert($body_haber)){

                            foreach($detalles as $key => $m){
                                $it = $item->getOne($m->id_item);
                                $it_alm = $item_almacen->getOne($m->id_item,$emple['id_almacen']);
                    
                                $stoc = $it->stock;
                                $al_stoc = $it_alm['stock'];
                                $cantid = $m->cantidad;
                                $new_stock = $stoc + $cantid;
                                $nuevo_alm = $al_stoc + $cantid;
                    
                                if($it != null && $it_alm != null){
                                    $item->update($it->id,['stock' => $new_stock]);
                                    $item_almacen->update($it_alm['id'],['stock'=>$nuevo_alm]);
                                }
                                $detalle_venta->update($m->id,['estado_sql'=>0]);
                            }
                            if($factura_venta->update($factura->id,['estado_sql' => 0]) && $pedido_venta->update($pedido->id,['estado_sql' =>0])){
                                return redirect()->to("/anulacion")->with('message', 'Factura #'.$id_factura.' anulada!');
                            }else{
                                return redirect()->to("/anulacion")->with('message', '#2 No se puede.');
                            }     
                        }
                    }else{
                        return redirect()->to("/anulacion")->with('message', '#1 No se puede.');
                    }                
                }else{
                    return redirect()->to("/anulacion")->with('message', 'No se completar la Anulacion de la Factura #'.$id_factura);
                }
            }
            
        }else{
            return redirect()->back()->withInput()->with('message', 'Contraseña Incorrecta.');
        }
    }

    public function filtrado_anulacion(){
        
        $anulacion = new m_anulacion();
        $filtro = $this->request->getPost('filtro');
        $data = [
            'anulacion' => $anulacion->asObject()
                        ->select('anulacion.*,factura_venta.total,factura_venta.beneficiario')
                        ->join('factura_venta','anulacion.id_factura = factura_venta.id')
                        ->where('anulacion.estado_sql',1)
                        ->paginate(10,'anulacion'),
            'pager' => $anulacion->pager
        ];

        $this->_loadDefaultView( 'Listado de Facturas Anuladas',$data,'index');
    }

    private function _loadDefaultView($title,$data,$view){

        $administracion = new Administracion_1();
        $sesion = $administracion->sesiones();
        $dataHeader =[
            'title' => $title,
            'tipo'=> 'header-inner-pages',

            'rol' => $sesion['rol'],

			'log' => $sesion['log'],

            'vista'=>'administracion'
        ];


        echo view("dashboard/templates/header",$dataHeader);
        echo view("administracion/anulacion/$view",$data);
        echo view("dashboard/templates/footer");
    }

}