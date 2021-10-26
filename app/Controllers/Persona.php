<?php namespace App\Controllers;
use App\Models\m_persona;
use App\Controllers\BaseController;
use \CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\m_subcategoria;
use App\Models\m_categoria;
use App\Models\m_marca;

class Persona extends BaseController {

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

        $persona = new m_persona();

        $data = [
            'persona' => $persona->asObject()
            ->select('persona.*')
            ->paginate(10,'persona'),
            'pager' => $persona->pager
        ];

        $this->_loadDefaultView( 'Listado de personas',$data,'index');
    }

    public function new(){       
       $validation =  \Config\Services::validation();
       $this->_loadDefaultView('Nueva Persona',['validation'=>$validation, 'persona'=> new m_persona()],'new');
    }

    public function create(){

        $persona = new m_persona();
        $foto = "";
        if($imagefile = $this->request->getFile('foto')) {
            
            if ($imagefile->isValid() && ! $imagefile->hasMoved())
                {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/personas', $foto);
                }
            
        }

        if($this->validate('personas')){
            $id = $persona->insert([
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
                'foto' => $foto,
                'estado_sql' =>'1'
            ]);

            return redirect()->to("/persona")->with('message', 'Persona creada con éxito.');

        }
        
        return redirect()->back()->withInput();
    }

    public function edit($id = null){

        $persona = new m_persona();

        if ($persona->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Modificar Persona',['validation'=>$validation,'persona'=> $persona->asObject()->find($id)],'edit');
    }

    public function update($id = null){

        $persona = new m_persona();

        if ($persona->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $foto = "";

        if($imagefile = $this->request->getFile('foto')) {
            
            if ($imagefile->isValid() && ! $imagefile->hasMoved())
                {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/personas', $foto);
                }
            
        }

        if($this->validate('personas')){
            $persona->update($id, [
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
                'foto' => $foto,
                'estado_sql' =>'1'              
            ]);

            return redirect()->to('/persona')->with('message', 'Persona editad con éxito.');

        }

        return redirect()->back()->withInput();
    }

    public function delete($id = null){

        $persona = new m_persona();

        if ($persona->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        
        $persona->delete($id);

        return redirect()->to('/persona')->with('message', 'Persona eliminada con éxito.');
    }

    public function show($id = null){
        
        $persona = new m_persona();

        if ($persona->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }   

        var_dump($persona->asObject()->find($id)->id);

    }

    private function _loadDefaultView($title,$data,$view){

        $categoria = new m_categoria();
		$subcategoria = new m_subcategoria();
		$marca = new m_marca();

        $admin = new Administracion_1();
		$sesion = $admin->sesiones();
    
        $dataHeader =[
            'title' => $title,
            'tipo'=>'header-inner-pages',

            'rol' => $sesion['rol'],

			'log' => $sesion['log'],

            'vista'=>'administracion',
            
            'central' => true
        ];

        echo view("dashboard/templates/header",$dataHeader);
        echo view("dashboard/persona/$view",$data);
        echo view("dashboard/templates/footer");
    }

}