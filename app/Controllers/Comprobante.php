<?php namespace App\Controllers;
use App\Models\m_comprobante;
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
        if($admin != 'Administrador'){
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

    public function create(){

        $categoria = new m_categoria();
        
        $foto = "";
        if($imagefile = $this->request->getFile('foto')) {
            
            if ($imagefile->isValid() && ! $imagefile->hasMoved())
                {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/categorias', $foto);
                }
            
        }

        if($this->validate('categorias')){
            $id = $categoria->insert([
                'nombre' =>$this->request->getPost('nombre'),
                'descripcion' =>$this->request->getPost('descripcion'),
                'foto' => $foto,
                'estado_sql' =>'1'
            ]);

            return redirect()->to("/categoria")->with('message', 'Categoria creado con éxito.');

        }
        
        return redirect()->back()->withInput();
    }

    public function edit($id = null){

        $categoria = new m_categoria();

        if ($categoria->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        echo "Sesión: ".session('message');

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Modificar Categoria',['validation'=>$validation,
                                'categoria'=> $categoria->asObject()->find($id),],'edit','');
    }

    public function update($id = null){

        $categoria = new m_categoria();

        if ($categoria->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $foto = $categoria->getByID($id);
        
        if($imagefile = $this->request->getFile('foto')) {

            if($foto == $imagefile->getName()){

                if($this->validate('categorias')){
                    $categoria->update($id, [
                        'nombre' =>$this->request->getPost('nombre'),
                        'descripcion' =>$this->request->getPost('descripcion'),
                        'estado_sql' =>'1'              
                    ]);
    
                return redirect()->to('/categoria')->with('message', 'Categoria editada con éxito.');
                }
                return redirect()->back()->withInput();

     
           }else{
                   
                if ($imagefile->isValid() && ! $imagefile->hasMoved())
                {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/categorias', $foto);
                }
                
                if($this->validate('categorias')){
                    $categoria->update($id, [
                        'nombre' =>$this->request->getPost('nombre'),
                        'descripcion' =>$this->request->getPost('descripcion'),
                        'foto'=>$foto,
                        'estado_sql' =>'1'              
                    ]);
    
                return redirect()->to('/categoria')->with('message', 'Categoria editada con éxito.');
                }    
                return redirect()->back()->withInput();  
               
            }
        }
    }

    public function delete($id = null){

        $categoria = new m_categoria();

        if ($categoria->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
       
        try
        {
            $categoria->delete($id);
            return redirect()->to('/categoria')->with('message', 'Categoria eliminada con éxito.');
        }
        catch (\Exception $e)
        {
            return redirect()->to('/categoria')->with('message', 'No se puede eliminar el registro.');
        }
       
    }

    public function show($id = null){
        
        $categoria = new m_categoria();

        if ($categoria->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }   

        var_dump($categoria->asObject()->find($id)->id);

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