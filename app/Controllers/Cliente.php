<?php namespace App\Controllers;
use App\Models\m_cliente;
use App\Models\m_persona;
use App\Controllers\BaseController;
use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\m_marca;
use App\Models\m_subcategoria;
use App\Models\m_categoria;
use App\Models\m_item;

use App\Controllers\Administracion_1;

use App\Models\m_empleado;
use App\Models\m_rol;
use App\Models\m_empleado_rol;

class Cliente extends BaseController {

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

        $cliente = new m_cliente();

        $data = [
            'cliente' => $cliente->asObject()
            ->select('cliente.*,persona.nombre as cliente')
            ->join('persona','persona.id = cliente.id_persona')
            ->paginate(10,'cliente'),
            'pager' => $cliente->pager
        ];

        $this->_loadDefaultView( 'Listado de Clientes',$data,'index');
    }

    public function new(){

       $cliente = new m_cliente();
       $persona = new m_persona();
       
       $validation =  \Config\Services::validation();
       $this->_loadDefaultView('Crear Cliente',['validation'=>$validation, 'cliente'=> new m_cliente(),
                                'persona' => $persona->getAll()],'new');

    }

     public function create(){

        helper("user");
        $cliente = new m_cliente();

        if($this->validate('clientes')){
            $id = $cliente->insert([
                'nit' =>$this->request->getPost('nit'),
                'razon_social' =>$this->request->getPost('razon_social'),
                'id_persona' =>$this->request->getPost('id_persona'),
                'usuario' =>$this->request->getPost('usuario'),
                'contrasena' =>hashPassword($this->request->getPost('contrasena')),
                'email' =>$this->request->getPost('email')
            ]);

            return redirect()->to("/cliente")->with('message', 'Item creado con éxito.');

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
        echo view("dashboard/cliente/$view",$data);
        echo view("dashboard/templates/footer");
    }

}