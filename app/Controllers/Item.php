<?php namespace App\Controllers;
use App\Models\m_item;
use App\Controllers\BaseController;
use App\Controllers\Administracion_1;
use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\m_subcategoria;
use App\Models\m_categoria;
use App\Models\m_marca;

use App\Models\m_persona;
use App\Models\m_proveedor;
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
            ->select('item.*,marca.nombre as marca, proveedor.nombre_empresa AS proveedor')
            ->join('marca','marca.id = item.id_marca')
            ->join('proveedor','item.id_proveedor = proveedor.id')
            ->join('persona','persona.id = proveedor.id_persona')
            ->paginate(10,'item'),
            'pager' => $item->pager
        ];

        $this->_loadDefaultView( 'Listado de productos',$data,'index');
    }

    public function new(){

       $marca = new m_marca();
       $proveedor = new m_proveedor();
       
       $validation =  \Config\Services::validation();
       $this->_loadDefaultView('Crear item',['validation'=>$validation, 'item'=> new m_item(),
                                'marca' => $marca->asObject()->findAll(),'proveedor'=>$proveedor->getAll()],'new');


    }

    public function create(){

        $item = new m_item();

        if($this->validate('items')){
            $foto = "";
            if($imagefile = $this->request->getFile('foto')) {
            
                if ($imagefile->isValid() && ! $imagefile->hasMoved())
                    {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/productos', $foto);

                    if($item->insert([
                        'nombre' =>$this->request->getPost('nombre'),
                        'descripcion' =>$this->request->getPost('descripcion'),
                        'id_marca' =>$this->request->getPost('id_marca'),
                        'id_proveedor'=>$this->request->getPost('id_proveedor'),
                        'codigo' =>$this->request->getPost('codigo'),
                        'stock' =>$this->request->getPost('stock'),
                        'precio_unitario' =>$this->request->getPost('precio_unitario'),
                        'precio_compra' =>$this->request->getPost('precio_compra'),
                        'venta_esperada' =>$this->request->getPost('precio_compra'),
                        'punto_reorden' =>$this->request->getPost('punto_reorden'),
                        'foto' => $foto,
                        'estado_sql' =>'1'
                    ])){
                        return redirect()->to("/item")->with('message', 'Item creado con éxito.');
                    }else{
                        return redirect()->back()->withInput()->with('message', '#1: Error al crear el Item');
                    }
                }           
            }
            else{
                if($item->insert([
                    'nombre' =>$this->request->getPost('nombre'),
                    'descripcion' =>$this->request->getPost('descripcion'),
                    'id_marca' =>$this->request->getPost('id_marca'),
                    'id_proveedor'=>$this->request->getPost('id_proveedor'),
                    'codigo' =>$this->request->getPost('codigo'),
                    'stock' =>$this->request->getPost('stock'),
                    'precio_unitario' =>$this->request->getPost('precio_unitario'),
                    'precio_compra' =>$this->request->getPost('precio_compra'),
                    'venta_esperada' =>$this->request->getPost('venta_esperada'),
                    'punto_reorden' =>$this->request->getPost('punto_reorden'),
                    'estado_sql' =>'1'
                ])){
                    return redirect()->to("/item")->with('message', 'Item creado con éxito.');
                }
                else{
                    return redirect()->back()->withInput()->with('message', '#2: Error al Crear el item.');
                }               
            }      
        }
        return redirect()->back()->withInput();
       
    }

    public function edit($id = null){

        $marca = new m_marca();
        $item = new m_item();
        $proveedor = new m_proveedor();

        if ($item->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Modificar Item',['validation'=>$validation,'item'=> $item->asObject()->find($id),
                                            'marca' => $marca->asObject()->findAll(),'proveedor' =>$proveedor->getAll()],'edit');
    }

    public function update($id = null){

        $item = new m_item();

        if ($item->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $foto = '';
        
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
                        'precio_compra' =>$this->request->getPost('precio_compra'),
                        'venta_esperada' =>$this->request->getPost('venta_esperada'),
                        'punto_reorden' =>$this->request->getPost('punto_reorden'),
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
                    'id_marca' =>$this->request->getPost('id_marca'),
                    'codigo' =>$this->request->getPost('codigo'),
                    'stock' =>$this->request->getPost('stock'),
                    'precio_unitario' =>$this->request->getPost('precio_unitario'), 
                    'precio_compra' =>$this->request->getPost('precio_compra'),
                    'venta_esperada' =>$this->request->getPost('venta_esperada'),
                    'punto_reorden' =>$this->request->getPost('punto_reorden'),
                    'id_proveedor' =>$this->request->getPost('id_proveedor'),
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