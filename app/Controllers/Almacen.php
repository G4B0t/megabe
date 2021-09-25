<?php namespace App\Controllers;
use App\Models\m_almacen;
use App\Controllers\BaseController;
use \CodeIgniter\Exceptions\PageNotFoundException;

class Almacen extends BaseController {

    public function index(){

        $almacen = new m_almacen();

        $data = [
            'almacen' => $almacen->asObject()
            ->select('almacen.*')
            ->paginate(10,'almacen'),
            'pager' => $almacen->pager
        ];

        $this->_loadDefaultView( 'Listado de Almacenes',$data,'index');
    }

    public function new(){

       
        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Crear Almacen',['validation'=>$validation, 'almacen'=> new m_almacen()],'new');
 

    }

    public function create(){

        $almacen = new m_almacen();
        $foto = "";
        if($imagefile = $this->request->getFile('foto')) {
            
            if ($imagefile->isValid() && ! $imagefile->hasMoved())
                {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/almacenes', $foto);
                }
            
        }

        if($this->validate('almacenes')){
            $id = $almacen->insert([
                'telefono' =>$this->request->getPost('telefono'),
                'direccion' =>$this->request->getPost('direccion'),
                'latitud' =>$this->request->getPost('latitud'),
                'longitud' =>$this->request->getPost('longitud'),
                'foto' => $foto,
                'estado_sql' =>'1'
            ]);

            return redirect()->to("/almacen")->with('message', 'Almacen creado con éxito.');

        }
        
        return redirect()->back()->withInput();
    }

    public function edit($id = null){

        $almacen = new m_almacen();

        if ($almacen->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        echo "Sesión: ".session('message');

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Modificar Almacen',['validation'=>$validation,'almacen'=> $almacen->asObject()->find($id)],'edit');
    }

    public function update($id = null){

        $almacen = new m_almacen();

        if ($almacen->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $foto = "";

        if($imagefile = $this->request->getFile('foto')) {
            
            if ($imagefile->isValid() && ! $imagefile->hasMoved())
                {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/almacenes', $foto);
                }
            
        }

        if($this->validate('almacenes')){
            $almacen->update($id, [
                'telefono' =>$this->request->getPost('telefono'),
                'direccion' =>$this->request->getPost('direccion'),
                'latitud' =>$this->request->getPost('latitud'),
                'longitud' =>$this->request->getPost('longitud'),
                'foto' => $foto,
                'estado_sql' =>'1'          
            ]);

            return redirect()->to('/almacen')->with('message', 'Almacen editado con éxito.');

        }

        return redirect()->back()->withInput();
    }

    public function delete($id = null){

        $almacen = new m_almacen();

        if ($almacen->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        
        $almacen->delete($id);

        return redirect()->to('/almacen')->with('message', 'Almacen eliminada con éxito.');
    }

    public function show($id = null){
        
        $almacen = new m_almacen();

        if ($almacen->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }   

        var_dump($almacen->asObject()->find($id)->id);

    }

    private function _loadDefaultView($title,$data,$view,$tipo){

        $dataHeader =[
            'title' => $title
            'tipo' => 'header-inner-pages'
        ];

        echo view("dashboard/templates/header",$dataHeader);
        echo view("dashboard/almacen/$view",$data);
        echo view("dashboard/templates/footer");
    }

}