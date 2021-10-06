<?php namespace App\Controllers;
use App\Models\m_plan_cuenta;
use App\Controllers\BaseController;
use App\Controllers\Administracion_1;
use \CodeIgniter\Exceptions\PageNotFoundException;

class Plan_Cuenta extends BaseController {


public function index(){
    $plan_cuenta = new m_plan_cuenta();
    
    $data = [
        'plan_cuenta' => $plan_cuenta->asObject()
        ->where('plan_cuenta.estado_sql',1)
        ->orderBy('codigo_cuenta', 'ASC')
        ->paginate(10,'plan_cuenta'),
        'pager' => $plan_cuenta->pager
    ];

    $this->_loadDefaultView( 'Listado de Plan de Cuentas',$data,'index');

}

public function new(){
    $plan_cuenta = new m_plan_cuenta();
       
    $validation =  \Config\Services::validation();
    $this->_loadDefaultView('Crear Plan Cuenta',['validation'=>$validation, 'plan_cuenta'=> new m_plan_cuenta(),
                             'cuenta_padre' => $plan_cuenta->asObject()->findAll()],'new');
     
}

public function create(){
    $plan_cuenta = new m_plan_cuenta();
    if($this->validate('plan_cuentas')){
        $id = $plan_cuenta->insert([
            'codigo_cuenta' =>$this->request->getPost('codigo_cuenta'),
            'nombre_cuenta' =>$this->request->getPost('nombre_cuenta'),
            'tipo_cuenta' =>$this->request->getPost('tipo_cuenta'),
            'grupo' =>$this->request->getPost('grupo'),
            'id_cuenta_padre' =>$this->request->getPost('id_cuenta_padre'),
            'debe' =>$this->request->getPost('debe'),
            'haber' => $this->request->getPost('haber'),
            'saldo' => $this->request->getPost('saldo'),
            'estado_sql' =>'1'
        ]);

        return redirect()->to("/plan_cuenta")->with('message', 'Plan Cuenta creado con éxito.');

    }
        
    return redirect()->back()->withInput();
}

public function edit($id = null){
    $plan_cuenta = new m_plan_cuenta();

    if ($plan_cuenta->find($id) == null)
    {
        throw PageNotFoundException::forPageNotFound();
    }  

    $validation =  \Config\Services::validation();
    $this->_loadDefaultView('Modificar Plan de Cuenta',['validation'=>$validation,'plan_cuenta'=> $plan_cuenta->asObject()->find($id),
                                        'cuenta_padre' => $plan_cuenta->asObject()->findAll()],'edit');
       
}

public function update($id = null){
    $plan_cuenta = new m_plan_cuenta();

        if ($plan_cuenta->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
    if($this->validate('plan_cuentas')){
        $plan_cuenta->update($id, [
            'codigo_cuenta' =>$this->request->getPost('codigo_cuenta'),
            'nombre_cuenta' =>$this->request->getPost('nombre_cuenta'),
            'tipo_cuenta' =>$this->request->getPost('tipo_cuenta'),
            'grupo' =>$this->request->getPost('grupo'),
            'id_cuenta_padre' =>$this->request->getPost('id_cuenta_padre'),
            'debe' =>$this->request->getPost('debe'),
            'haber' => $this->request->getPost('haber'),
            'saldo' => $this->request->getPost('saldo'),
            'estado_sql' =>'1'              
        ]);

    return redirect()->to('/plan_cuenta')->with('message', 'Plan Cuenta editado con éxito.');
    }         
    return redirect()->back()->withInput();   
        
}

public function delete($id = null){
    $plan_cuenta = new m_plan_cuenta();

    if ($plan_cuenta->find($id) == null)
    {
        throw PageNotFoundException::forPageNotFound();
    }  
    
    $plan_cuenta->update($id, ['estado_sql'=>0]);

    return redirect()->to('/plan_cuenta')->with('message', 'Plan Cuenta eliminada con éxito.');
       
}

public function show($id = null){
    $plan_cuenta = new m_plan_cuenta();

    if ($plan_cuenta->find($id) == null)
    {
        throw PageNotFoundException::forPageNotFound();
    }   

    var_dump($plan_cuenta->asObject()->find($id)->id);
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
        echo view("dashboard/plan_cuenta/$view",$data);
        echo view("dashboard/templates/footer");
    }






}