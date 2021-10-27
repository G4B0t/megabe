<?php namespace App\Controllers;
use App\Models\m_empleado;
use App\Models\m_persona;
use App\Controllers\BaseController;
use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\m_almacen;

use App\Controllers\Administracion_1;

use App\Models\m_rol;
use App\Models\m_empleado_rol;

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
            ->select('empleado.*,CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullname, rol.nombre as rol')
            ->join('empleado_rol','empleado_rol.id_empleado = empleado.id')
            ->join('rol','empleado_rol.id_rol = rol.id')
            ->join('persona','persona.id = empleado.id_persona')
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
        ->findAll();
        
        $almacenes = $almacen->asObject()->findAll();

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Crear Empleado',['validation'=>$validation, 'empleado'=> new m_empleado(),
                                'persona' => $personas, 'almacen'=>$almacenes, 'rol' => $rol->getCasiTodos()],'new');

    }

     public function create(){

        helper("user");
        $empleado = new m_empleado();
        $rol_empleado = new m_rol_empleado();
        $cDate = date('Y-m-d H:i:s');

        if($this->validate('empleados')){
            /*if($empleado->insert([
                'usuario' =>$this->request->getPost('usuario'),
                'contrasena' =>hashPassword($this->request->getPost('contrasena')),
                'email' =>$this->request->getPost('email'),
                'fecha_ingreso' =>  $cDate,
                ])){*/
                    $body_rol_empleado = ['id_rol'=>$this->request->getPost('rol'),'id_empleado'=>$id];
                    if($rol_empleado->insert($body_rol_empleado)){
                        return redirect()->to("/empleados/roles")->with('message', 'Empleado registrado con éxito.');
                    }
                //} 
        }
        else{
            return redirect()->back()->withInput();
        }
    }

    public function edit($id = null){

        $persona = new m_persona();
        $cliente = new m_cliente();

        if ($cliente->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Modificar Cliente',['validation'=>$validation,'cliente'=> $cliente->asObject()->find($id),
                                            'persona' => $persona->asObject()->getAll()],'edit');
    }


    public function update($id = null){

        helper("user");

        if($this->validate('clientes')){
            $cliente->update($id, [
                'nit' =>$this->request->getPost('nit'),
                'razon_social' =>$this->request->getPost('razon_social'),
                'id_persona' =>$this->request->getPost('id_persona'),
                'usuario' =>$this->request->getPost('usuario'),
                'contrasena' =>hashPassword($this->request->getPost('contrasena')),
                'email' =>$this->request->getPost('email'),
            ]);

            return redirect()->to('/cliente')->with('message', 'Cliente editado con éxito.');

        }
       
    }

    public function delete($id = null){

        $item = new m_item();

        if ($item->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        
        $item->delete($id);

        return redirect()->to('/item')->with('message', 'Item eliminada con éxito.');
    }

    public function show($id = null){
        
        $item = new m_item();

        if ($item->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }   

        var_dump($item->asObject()->find($id)->id);

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