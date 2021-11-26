<?php namespace App\Controllers;
use App\Models\m_empleado;
use App\Models\m_persona;
use App\Controllers\BaseController;
use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\m_almacen;

use App\Controllers\Administracion_1;

use App\Models\m_rol;
use App\Models\m_empleado_rol;
use App\Models\m_plan_cuenta;

class Empleado extends BaseController {

    public function index(){

        $admin = new Administracion_1();
		$sesion = $admin->sesiones();
        $admin = '';
        foreach($sesion['rol'] as $key =>$m){
            $admin = $m->nombre;
        }
        if($admin != 'Administrador'){
           return redirect()->to('/administracion')->with('message', 'No cumple con su funcion.');
        }

        $empleado = new m_empleado();
        

        $data = [
            'empleado' => $empleado->asObject()
            ->select('empleado.*,CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullname, rol.nombre as rol, almacen.direccion as almacen')
            ->join('empleado_rol','empleado_rol.id_empleado = empleado.id')
            ->join('rol','empleado_rol.id_rol = rol.id')
            ->join('persona','persona.id = empleado.id_persona')
            ->join('almacen','almacen.id = empleado.id_almacen')
            ->whereNotIn('rol.nombre',['Administrador'])
            ->orderBy('fullName','ASC')
            ->paginate(10,'empleado'),
            'pager' => $empleado->pager
        ];

        $this->_loadDefaultView( 'Listado de Empleados',$data,'index');
    }

    public function new(){

        $empleado = new m_empleado();
        $persona = new m_persona();
        $almacen = new m_almacen();
        $rol = new m_rol();

        $roles = $rol->getCasiTodos();
        $personas = $persona->asObject()
        ->select('id, CONCAT(nombre, " ", apellido_paterno) AS fullName')
        ->whereNotIn('id',function ($persona) {
                        return $persona->select('empleado.id_persona')->from('empleado');
                    })
        ->whereNotIn('id',function ($persona) {
                        return $persona->select('cliente.id_persona')->from('cliente');
                    })
        ->whereNotIn('id',function ($persona) {
                        return $persona->select('proveedor.id_persona')->from('proveedor');
                    })           
        ->findAll();
        
        $almacenes = $almacen->asObject()->findAll();

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Crear Empleado',['validation'=>$validation, 'empleado'=> new m_empleado(),
                                'persona' => $personas, 'almacen'=>$almacenes, 'rol' => $rol->getCasiTodos()],'new');

    }

     public function create(){

        helper("user");
        $empleado = new m_empleado();
        $empleado_rol = new m_empleado_rol();
        $rol = new m_rol();
        
        $cDate = date('Y-m-d H:i:s');
        $role =  $this->request->getPost('rol');
        $almacen = $this->request->getPost('id_almacen');

        $caja = 'Almacen '.$almacen;
        if($role == 3){
            $caja = 'CAJA 2';
        }
        if($almacen == 1 && $role == 4){
            $caja = 'Central';
        }
        if( $role == 5){

            $caja = 'CAJA 1 CENTRAL';
        }
        
        if($this->validate('empleados')){
            $body_empleado = [
                            'id_persona'=> $this->request->getPost('id_persona'),
                            'id_almacen' => $almacen,
                            'usuario' =>$this->request->getPost('usuario'),
                            'contrasena' =>hashPassword($this->request->getPost('contrasena')),
                            'email' =>$this->request->getPost('email'),
                            'caja' => $caja,
                            'fecha_ingreso' =>  $cDate
            ];
            if($empleado->insert($body_empleado)){
                    $id_empleado = $empleado->getInsertID();
                    $body_rol_empleado = ['id_rol'=>$this->request->getPost('rol'),'id_empleado'=>$id_empleado];

                    if($empleado_rol->insert($body_rol_empleado)){
                        return redirect()->to("/empleado")->with('message', 'Empleado registrado con exito!');  
                    }
                }
                else{
                    return redirect()->back()->withInput()->with('message', 'No se pudo registrar al Empleado!');
                }
            
        }
        else{
            return redirect()->back()->withInput();
        }
    }  

    public function edit($id = null){

        $persona = new m_persona();
        $empleado = new m_empleado();
        $rol = new m_rol();
        $almacen = new m_almacen();

        if ($empleado->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        $validation =  \Config\Services::validation();

        $data = ['validation'=>$validation,
                'empleado'=> $empleado->asObject()->find($id),
                'almacen' => $almacen->asObject()->findAll(),
                'rol' => $rol->getCasiTodos()];

        
        $this->_loadDefaultView('Modificar Empleado',$data,'edit');
    }


    public function update($id){
        $empleado = new m_empleado();
        $empleado_rol = new m_empleado_rol();

        if ($empleado->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        helper("user");
        $role = $this->request->getPost('rol');
        $almacen = $this->request->getPost('id_almacen'); 
        $empleado_rol = new m_empleado_rol();

        $caja = 'Almacen '.$almacen;
        if($role == 3){
            $caja = 'CAJA 2';
        }
        if($almacen == 1 && $role == 4){
            $caja = 'Central';
        }
        if( $role == 5){

            $caja = 'CAJA 1 CENTRAL';
        }

        $emple_rol = $empleado_rol->getByEmpleado($id);
        foreach($emple_rol as $key => $m){
            $id_emple_rol = $m->id;
        }

       if($empleado->update($id, [
                'id_almacen' =>$almacen,
                'caja' => $caja
            ])){
                if($empleado_rol->update($id_emple_rol,['id_rol' => $role])){
                    return redirect()->to('/empleado')->with('message', 'Rol de Empleado modificado con éxito.');
                }
                else{
                    return redirect()->back()->withInput()->with('message', 'No se pudo modificar el Rol del Empleado.');
                }
            }
        else{
            return redirect()->back()->withInput()->with('message', 'No se pudo modificar al Empleado.');
        } 
       
    }

    public function delete($id = null){

        $empleado = new m_empleado();

        if ($empleado->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        
        $empleado->update($id,['estado_sql'=>0]);

        return redirect()->to('/empleado')->with('message', 'Empleado eliminada con éxito.');
    }

    public function updateCaja($id = null){

        $empleado = new m_empleado();

        if ($empleado->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        
       if($empleado->update($id,['caja'=>$this->request->getPost('cajas')])){
            return redirect()->to('/empleado')->with('message', 'Asignacion de CAJA completado.');
        }
        else{
            return redirect()->back()->withInput()->with('message', 'No se pudo asignar CAJA al Empleado.');
        }       
    }

    public function modificar_caja($id_empleado){
        $plan_cuenta = new m_plan_cuenta();
        $cajas = $plan_cuenta->getCajas();
        $empleado = new m_empleado();


        $data = [
            'empleado' =>$empleado->asObject()->find($id_empleado),

            'cajas' =>  $cajas
        ];
        $this->_loadDefaultView( 'Asignar CAJA',$data,'_form_Caja');
        
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
        echo view("dashboard/empleado/$view",$data);
        echo view("dashboard/templates/footer");
    }

}