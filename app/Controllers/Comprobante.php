<?php namespace App\Controllers;
use App\Models\m_comprobante;
use App\Models\m_detalle_comprobante;
use App\Controllers\BaseController;
use App\Controllers\Administracion_1;
use \CodeIgniter\Exceptions\PageNotFoundException;

class Comprobante extends BaseController {

    public function index(){

        $admin = new Administracion_1();
		$sesion = $admin->sesiones();
        $admin = '';
        foreach($sesion['rol'] as $key =>$m){
            $admin = $m->nombre;
        }
        if($admin != 'Contador'){
           return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }

        $comprobante = new m_comprobante();

        $data = [
            'comprobante' => $comprobante->asObject()
            ->select('comprobante.*')
            ->paginate(10,'comprobante'),
            'pager' => $comprobante->pager
        ];

        $this->_loadDefaultView( 'Listado de Comprobantes',$data,'index');
    }

    public function new(){

       
       $validation =  \Config\Services::validation();
       $this->_loadDefaultView('Crear Categoria',['validation'=>$validation, 'categoria'=> new m_categoria()],'new','');


    }

    
    public function edit($id = null){

        $comprobante = new m_comprobante();
        $detalle_comprobante = new m_detalle_comprobante();

        if ($comprobante->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        } 
        $restriccion = ['detalle_comprobante.id_comprobante' => $id,'detalle_comprobante.estado_sql' => 1];
        $condicion = ['id' => $id, 'estado_sql' =>1];

        $detalles = $detalle_comprobante->asObject()->getDetalles($id);
        $debe = 0;$haber = 0; 
        foreach($detalles as $key => $m){
            $debe += $m->debe;
            $haber += $m->haber;
        }

        $total = (object)['debe'=>$debe,'haber'=>$haber];

        $data = [
            'detalle_comprobante' => $detalle_comprobante->asObject()
            ->select('detalle_comprobante.*,plan_cuenta.nombre_cuenta, plan_cuenta.codigo_cuenta')
            ->join('plan_cuenta','detalle_comprobante.id_cuenta = plan_cuenta.id')
            ->where($restriccion)
            ->paginate(10,'detalle_comprobante'),

            'pager' => $detalle_comprobante->pager,

            'comprobante' =>$comprobante->asObject()->where($condicion)->first(),

            'total' => $total 
        ];

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Visualizar Comprobante #'.$id,$data,'edit');
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
        echo view("dashboard/comprobante/$view",$data);
        echo view("dashboard/templates/footer");
    }
        

}