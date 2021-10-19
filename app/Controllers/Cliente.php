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

    public function nuevo(){

        $cliente = new m_cliente();
        $persona = new m_persona();
        
        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Crear Cliente',['validation'=>$validation, 'cliente'=> new m_cliente(),
                                 'persona' => new m_persona()],'nuevoUser');
     }
    public function crear(){
        helper("user");
        $cliente = new m_cliente();
        $persona = new m_persona();

        if($this->validate('clientes') && $this->validate('personas')){
            $foto = "";
            if($imagefile = $this->request->getFile('foto')) {
            
                if ($imagefile->isValid() && ! $imagefile->hasMoved())
                    {
                        $foto = $imagefile->getRandomName();
                        $imagefile->move(WRITEPATH.'uploads/clientes', $foto);
                }
            }   
            if($id_persona = $persona->insert([
                'nombre' =>$this->request->getPost('nombre'),
                'apellido_paterno' =>$this->request->getPost('apellido_paterno'),
                'apellido_materno' =>$this->request->getPost('apellido_materno'),
                'nro_ci' =>$this->request->getPost('nro_ci'),
                'direccion_particular' =>$this->request->getPost('direccion_particular'),
                'direccion_trabajo' =>$this->request->getPost('direccion_trabajo'),
                'telefono_particular' =>$this->request->getPost('telefono_particular'), 
                'telefono_trabajo' =>$this->request->getPost('telefono_trabajo'),
                'zona_vivienda' =>$this->request->getPost('zona_vivienda'),
                'latitud_vivienda' =>$this->request->getPost('latitud_vivienda'),
                'longitud_vivienda' =>$this->request->getPost('longitud_vivienda'),
                'celular1' =>$this->request->getPost('celular1'),
                'celular2' =>$this->request->getPost('celular2'),
                'lugar_residencia' =>$this->request->getPost('lugar_residencia'),
                'ocupacion' =>$this->request->getPost('ocupacion'),
                'foto' => $foto
            ])){
                $id_persona = $persona->getInsertID();
                    
                $id = $cliente->insert([
                    'nit' =>$this->request->getPost('nit'),
                    'razon_social' =>$this->request->getPost('razon_social'),
                    'id_persona' =>$id_persona,
                    'usuario' =>$this->request->getPost('usuario'),
                    'contrasena' =>hashPassword($this->request->getPost('contrasena')),
                    'email' =>$this->request->getPost('email')
                ]);
                return redirect()->to("/pedido_venta")->with('message', 'Nuevo Usuario Creado Con éxito.');  
            }
        }
        
        return redirect()->back()->withInput();
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

    public function editar($id = null){

        $cliente = new m_cliente();
        $persona = new m_persona();

        

        $es_cliente = $persona->getCliente($id);

        if ($cliente->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Modificar Cliente',['validation'=>$validation,'cliente'=> $cliente->asObject()->find($id),
                                                    'persona' => $persona->getPersona($es_cliente['id'])],'editar');
    }



    public function actualizar($id = null){
        helper("user");

        $cliente = new m_cliente();
        $persona = new m_persona();


       if ($cliente->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $foto = "";

        if($imagefile = $this->request->getFile('foto')) {
            
            if ($imagefile->isValid() && ! $imagefile->hasMoved())
                {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/clientes', $foto);

                    if($this->validate('cliente_password')){
                        $id_persona = $persona->getPersona($id);
                        $persona->update( $id_persona['id'],['foto' => $foto]);
                        $cliente->update($id, [
                            'contrasena' =>hashPassword($this->request->getPost('contrasena')),
                        ]);
            
                        return redirect()->to('/user/configuracion')->with('message', 'Actualizacion de Datos exitosa!');          
                    }
                }          
        }
        return redirect()->back()->withInput();
       
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

        $categoria = new m_categoria();
		$subcategoria = new m_subcategoria();
		$marca = new m_marca();

        $persona = new m_persona();
		$role = new m_rol();
		$empleado_rol = new m_empleado_rol();

        $admin = new Administracion_1();
		$sesion = $admin->sesiones();
        $rol[] = (object) array('nombre' => 'Normal');
        $dataHeader =[
            'title' => $title,
            'tipo'=> 'header-inner-pages',

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

            'rol' =>$rol,

			'log' => $sesion['log'],

            'vista'=>''
        ];

        echo view("dashboard/templates/header",$dataHeader);
        echo view("dashboard/cliente/$view",$data);
        echo view("dashboard/templates/footer");
    }

}