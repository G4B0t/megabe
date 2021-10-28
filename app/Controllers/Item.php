<?php namespace App\Controllers;
use App\Models\m_item;
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

class Item extends BaseController {

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

        $item = new m_item();

        $data = [
            'item' => $item->asObject()
            ->select('item.*,marca.nombre as marca')
            ->join('marca','marca.id = item.id_marca')
            ->join('proveedor','item.id_proveedor = proveedor.id')
            ->paginate(10,'item'),
            'pager' => $item->pager
        ];

        $this->_loadDefaultView( 'Listado de productos',$data,'index');
    }

    public function new(){

       $marca = new m_marca();
       
       $validation =  \Config\Services::validation();
       $this->_loadDefaultView('Crear item',['validation'=>$validation, 'item'=> new m_item(),
                                'marca' => $marca->asObject()->findAll()],'new');


    }

    public function create(){

        $item = new m_item();
        $foto = "";
        if($imagefile = $this->request->getFile('foto')) {
            
            if ($imagefile->isValid() && ! $imagefile->hasMoved())
                {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/productos', $foto);
                }
            
        }

        if($this->validate('items')){
            $id = $item->insert([
                'nombre' =>$this->request->getPost('nombre'),
                'descripcion' =>$this->request->getPost('descripcion'),
                'id_marca' =>$this->request->getPost('id_marca'),
                'codigo' =>$this->request->getPost('codigo'),
                'stock' =>$this->request->getPost('stock'),
                'precio_unitario' =>$this->request->getPost('precio_unitario'),
                'foto' => $foto,
                'estado_sql' =>'1'
            ]);

            return redirect()->to("/item")->with('message', 'Item creado con éxito.');

        }
        
        return redirect()->back()->withInput();
    }

    public function edit($id = null){

        $marca = new m_marca();
        $item = new m_item();

        if ($item->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Modificar Item',['validation'=>$validation,'item'=> $item->asObject()->find($id),
                                            'marca' => $marca->asObject()->findAll()],'edit');
    }

    public function update($id = null){

        $item = new m_item();

        if ($item->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $foto = $item->getByID($id);
        
        if($imagefile = $this->request->getFile('foto')) {
           
            if($foto != $imagefile->getName()){
                if ($imagefile->isValid() && ! $imagefile->hasMoved())
                {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/productos', $foto);
                }
               
                if($this->validate('items')){
                    $item->update($id, [
                        'nombre' =>$this->request->getPost('nombre'),
                        'descripcion' =>$this->request->getPost('descripcion'),
                        'id_marca' =>$this->request->getPost('id_marca'),
                        'codigo' =>$this->request->getPost('codigo'),
                        'stock' =>$this->request->getPost('stock'),
                        'precio_unitario' =>$this->request->getPost('precio_unitario'),
                        'foto' => $foto,
                        'estado_sql' =>'1'              
                    ]);
    
                return redirect()->to('/item')->with('message', 'Item editad con éxito.');
                }         
                return redirect()->back()->withInput();   
           }else{
            if($this->validate('items')){
                $item->update($id, [
                    'nombre' =>$this->request->getPost('nombre'),
                    'descripcion' =>$this->request->getPost('descripcion'),
                    'id_subcategoria' =>$this->request->getPost('id_subcategoria'),
                    'codigo' =>$this->request->getPost('codigo'),
                    'fecha_expiracion' =>$this->request->getPost('fecha_expiracion'),
                    'stock' =>$this->request->getPost('stock'),
                    'precio_unitario' =>$this->request->getPost('precio_unitario'), 
                    'marca' =>$this->request->getPost('marca'),
                    'estado_sql' =>'1'              
                ]);

                return redirect()->to('/item')->with('message', 'Item editad con éxito.');
                }
            return redirect()->back()->withInput();

  
            }
        }
    }

    public function delete($id = null){

        $item = new m_item();

        if ($item->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        
        $item->update($id, ['estado_sql'=>0]);

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
        echo view("dashboard/item/$view",$data);
        echo view("dashboard/templates/footer");
    }

}