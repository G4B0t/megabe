<?php namespace App\Controllers;

use App\Models\m_persona;
use App\Controllers\BaseController;
use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Controllers\Administracion_1;

use App\Models\m_proveedor;

class Proveedor extends BaseController {

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

        $proveedor = new m_proveedor();

        $data = [
            'proveedor' => $proveedor->asObject()
            ->select('proveedor.*, CONCAT(persona.nombre, " ", persona.apellido_paterno) AS proveedor, item.nombre as item')
            ->join('persona','persona.id = proveedor.id_persona')
            ->join('item','item.id_proveedor = proveedor.id')
            ->paginate(10,'proveedor'),
            'pager' => $proveedor->pager
        ];
        $this->_loadDefaultView( 'Listado de Proveedores',$data,'index');
    }

    public function new(){

       $proveedor = new m_proveedor();
       $persona = new m_persona();

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
      
       $validation =  \Config\Services::validation();
       $this->_loadDefaultView('Crear Proveedor',['validation'=>$validation, 'proveedor'=> new m_proveedor(),
                                'persona' => $personas],'new');

    }

     public function create(){

        $proveedor = new m_proveedor();

        if($this->validate('proveedores')){
            if($id = $proveedor->insert([
                    'id_persona' =>$this->request->getPost('id_persona'),
                    'nombre_empresa' =>$this->request->getPost('nombre_empresa'),
                    'direccion' =>$this->request->getPost('direccion'),
                    'contacto' =>$this->request->getPost('contacto')
                ])){

                return redirect()->to("/proveedor")->with('message', 'Proveedor creado con éxito');

            }else{
                return redirect()->to("/proveedor")->with('message', 'No se pudo registrar el Proveedor');
            }

        }
        return redirect()->back()->withInput();        
    }

    public function edit($id = null){

        $persona = new m_persona();
        $proveedor = new m_proveedor();

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

        if ($proveedor->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Modificar Proveedor',['validation'=>$validation,'proveedor'=> $proveedor->asObject()->find($id),
                                            'persona' => $personas],'edit');
    }


    public function update($id = null){

        $proveedor = new m_proveedor();

        helper("user");

        if($this->validate('proveedores')){
            $proveedor->update($id, [
                'id_persona' =>$this->request->getPost('id_persona'),
                'nombre_empresa' =>$this->request->getPost('nombre_empresa'),
                'direccion' =>$this->request->getPost('direccion'),
                'contacto' =>$this->request->getPost('contacto')
            ]);

            return redirect()->to('/proveedor')->with('message', 'Proveedor editado con éxito.');

        }else{
            return redirect()->back()->withInput();
        }
       
    }

    public function delete($id = null){

        $proveedor = new m_proveedor();

        if ($proveedor->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        
        $proveedor->update($id,['estado_sql' => 0]);

        return redirect()->to('/proveedor')->with('message', 'Proveedor eliminado con éxito.');
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
        echo view("dashboard/proveedor/$view",$data);
        echo view("dashboard/templates/footer");
    }

}