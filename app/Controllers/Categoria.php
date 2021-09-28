<?php namespace App\Controllers;
use App\Models\m_categoria;
use App\Controllers\BaseController;
use App\Controllers\Administracion_1;
use \CodeIgniter\Exceptions\PageNotFoundException;

class Categoria extends BaseController {

    public function index(){

        $categoria = new m_categoria();

        $data = [
            'categoria' => $categoria->asObject()
            ->select('categoria.*')
            ->paginate(10,'categoria'),
            'pager' => $categoria->pager
        ];

        $this->_loadDefaultView( 'Listado de Categorias',$data,'index','');
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

    private function _loadDefaultView($title,$data,$view,$tipo){

        $administracion = new administracion_1();
        $sesion = $administracion->sesiones();

        $dataHeader =[
            'title' => $title,
            'tipo' => $tipo,

            'rol' => $sesion['rol'],

			'log' => $sesion['log']
        ];

        echo view("dashboard/templates/header",$dataHeader);
        echo view("dashboard/categoria/$view",$data);
        echo view("dashboard/templates/footer");
    }

}