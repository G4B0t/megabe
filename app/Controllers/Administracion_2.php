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

class Administracion_2 extends BaseController{

    public function index(){

        $this->_loadDefaultView( '',$data,'index');
    }
    public function guardar_comprobante($id){
        echo "Guardado: ".$id;
    }

    public function new_detalle(){
        echo 'new';
    }
    public function edit_detalle($id){
        echo "ID: ".$id;
    }
    public function delete_detalle($id){
        echo "Borrar";
    }
    public function ver_comprobante($id){

        $comprobante = new m_comprobante();
        $plan_cuenta = new m_plan_cuenta();
        $detalle_comprobante = new m_detalle_comprobante();

        $comprobante_creado = $comprobante->getById($id);
        $data = ['comprobante' => $comprobante_creado,
                
                'detalle_comprobante'=> $detalle_comprobante->asObject()
                ->select('detalle_comprobante.*,detalle_comprobante.id as id_detalle,plan_cuenta.nombre_cuenta,plan_cuenta.codigo_cuenta')
                ->join('plan_cuenta','detalle_comprobante.id_cuenta = plan_cuenta.id')
                ->where('detalle_comprobante.id_comprobante',$comprobante_creado->id)
                ->paginate(10,'detalle_comprobante'),
                'pager' => $detalle_comprobante->pager,

                ];
        $this->_loadDefaultView( 'Comprobante #'.$id,$data,'comprobantes');
    }
    public function comprobante(){
        $session = session();

        $comprobante = new m_comprobante();
        $empleado = new m_empleado();

        $id_empleado = $session->empleado;
        $cDate = date('Y-m-d H:i:s');

        $contador = $empleado->getContador($id_empleado);
        
        $body = ['fecha' =>  $cDate,
                'beneficiario'=>$contador->fullname,
                'glosa' => '',
                'tipo_respaldo' => ''
                ];
        $comprobante->insert($body);
        $id = $comprobante->getInsertID();

        return redirect()->to('/administracion/ver_comprobante/'.$id)->with('message', 'Generando Nuevo Comprobante');
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

			'log' => $sesion['log']
        ];

        echo view("dashboard/templates/header",$dataHeader);
        echo view("administracion/$view",$data);
        echo view("dashboard/templates/footer");
    }
}