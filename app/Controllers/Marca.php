<?php namespace App\Controllers;
use App\Controllers\BaseController;
use App\Controllers\Administracion_1;
use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\m_subcategoria;
use App\Models\m_categoria;
use App\Models\m_marca;

use App\Models\m_persona;
use App\Models\m_empleado;
use App\Models\m_rol;
use App\Models\m_empleado_rol;

class Marca extends BaseController {

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

        $marca = new m_marca();

        $data = [
            'marca' => $marca->asObject()
            ->select('marca.*,subcategoria.nombre as subcategoria')
            ->join('subcategoria','subcategoria.id = marca.id_subcategoria')
            ->paginate(10,'marca'),
            'pager' => $marca->pager
        ];

        $this->_loadDefaultView( 'Listado de marcas',$data,'index');
    }

    public function new(){

       $subcategoria = new m_subcategoria();
       
       $validation =  \Config\Services::validation();
       $this->_loadDefaultView('Crear Marca',['validation'=>$validation, 'marca'=> new m_marca(),
                                'subcategoria' => $subcategoria->asObject()->findAll()],'new');


    }

    public function create(){

        $marca = new m_marca();

        if($this->validate('marcas')){
            $id = $marca->insert([
                'nombre' =>$this->request->getPost('nombre'),
                'descripcion' =>$this->request->getPost('descripcion'),
                'id_subcategoria' =>$this->request->getPost('id_subcategoria'),
                'estado_sql' =>'1'
            ]);

            return redirect()->to("/marca")->with('message', 'Marca creado con éxito.');

        }
        
        return redirect()->back()->withInput();
    }

    public function edit($id = null){

        $marca = new m_marca();
        $subcategoria = new m_subcategoria();

        if ($marca->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Modificar Marca',['validation'=>$validation,'marca'=> $marca->asObject()->find($id),
                                            'subcategoria' => $subcategoria->asObject()->findAll()],'edit');
    }

    public function update($id = null){

        $marca = new m_marca();

        if ($marca->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $foto = $marca->getByID($id);
        if($this->validate('marcas')){
                $marca->update($id, [
                    'nombre' =>$this->request->getPost('nombre'),
                    'descripcion' =>$this->request->getPost('descripcion'),
                    'id_subcategoria' =>$this->request->getPost('id_subcategoria'),
                    'estado_sql' =>'1'              
                ]);

                return redirect()->to('/marca')->with('message', 'Marca editado con éxito.');
                }
            return redirect()->back()->withInput(); 
            }

    public function delete($id){

        $marca = new m_marca();

        if ($marca->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        
        $marca->update($id, ['estado_sql'=>0]);

        return redirect()->to('/marca')->with('message', 'Marca eliminada con éxito.');
    }


    private function _loadDefaultView($title,$data,$view){

        $categoria = new m_categoria();
		$subcategoria = new m_subcategoria();
		$marca = new m_marca();

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
        echo view("dashboard/marca/$view",$data);
        echo view("dashboard/templates/footer");
    }

}