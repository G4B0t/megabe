<?php namespace App\Controllers;
use App\Models\m_item;
use App\Models\m_item_almacen;
use App\Models\m_almacen;
use App\Controllers\BaseController;
use App\Controllers\Administracion_1;
use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\m_subcategoria;
use App\Models\m_categoria;
use App\Models\m_marca;
use App\Models\m_pedido_venta;
use App\Models\m_detalle_venta;
use App\Models\m_generales;

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
            ->orderBy('marca','ASC')
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
    public function crear_item_almacen($id_item){
        $almacen = new m_almacen();
        $item_almacen = new m_item_almacen();
        $almacenes = $almacen->asObject()->findAll();

        foreach($almacenes as $key => $m){
            $item_almacen->insert(['id_almacen'=>$m->id,
                                    'id_item'=>$id_item,
                                    'stock'=>0]);
        }
        
    }
    public function create(){

        $item = new m_item();
        $categoria = new m_categoria();
        $subcategoria = new m_subcategoria();
        $marca = new m_marca();

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
                        'precio_unitario' =>$this->request->getPost('precio_unitario'),
                        'precio_compra' =>$this->request->getPost('precio_compra'),
                        'venta_esperada' =>$this->request->getPost('venta_esperada'),
                        'punto_reorden' =>$this->request->getPost('punto_reorden'),
                        'foto' => $foto,
                        'estado_sql' =>'1'
                    ])){
                    $id_item = $item->getInsertID();
                    $this->crear_item_almacen($id_item);
                       
                    $items = $item->asObject()->findAll();

                    $cats = $categoria->asObject()->findAll();
                    $subcats = $subcategoria->asObject()->findAll();
                    $marcs = $marca->asObject()->findAll();

                    foreach($marcs as $key => $b){
                        $sum_it =0;
                        foreach($items as $key => $c){
                            if($c->id_marca == $b->id){
                                $sum_it += $c->venta_esperada;
                            }
                        }
                        $marca->update($b->id,['venta_esperada' =>$sum_it]);
                    }
                    $marcs = $marca->asObject()->findAll();
                    foreach($subcats as $key => $a){
                        $sum_mar =0;
                        foreach($marcs as $key => $b){
                            if($b->id_subcategoria == $a->id){
                                $sum_mar += $b->venta_esperada;
                            }
                        }
                        $subcategoria->update($a->id,['venta_esperada' =>$sum_mar]);
                    }
                    $subcats = $subcategoria->asObject()->findAll();
                    foreach($cats as $key => $a){
                        $sum_subc =0;
                        foreach($subcats as $key => $b){
                            if($b->id_categoria == $a->id){
                                $sum_subc += $b->venta_esperada;
                            }
                        }
                        $categoria->update($a->id,['venta_esperada' =>$sum_subc]);
                    }
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
                    'precio_unitario' =>$this->request->getPost('precio_unitario'),
                    'precio_compra' =>$this->request->getPost('precio_compra'),
                    'venta_esperada' =>$this->request->getPost('venta_esperada'),
                    'punto_reorden' =>$this->request->getPost('punto_reorden'),
                    'estado_sql' =>'1'
                ])){
                    $id_item = $item->getInsertID();
                    $this->crear_item_almacen($id_item);
                    $items = $item->asObject()->findAll();

                    $cats = $categoria->asObject()->findAll();
                    $subcats = $subcategoria->asObject()->findAll();
                    $marcs = $marca->asObject()->findAll();

                    foreach($marcs as $key => $b){
                        $sum_it =0;
                        foreach($items as $key => $c){
                            if($c->id_marca == $b->id){
                                $sum_it += $c->venta_esperada;
                            }
                        }
                        $marca->update($b->id,['venta_esperada' =>$sum_it]);
                    }
                    $marcs = $marca->asObject()->findAll();
                    foreach($subcats as $key => $a){
                        $sum_mar =0;
                        foreach($marcs as $key => $b){
                            if($b->id_subcategoria == $a->id){
                                $sum_mar += $b->venta_esperada;
                            }
                        }
                        $subcategoria->update($a->id,['venta_esperada' =>$sum_mar]);
                    }
                    $subcats = $subcategoria->asObject()->findAll();
                    foreach($cats as $key => $a){
                        $sum_subc =0;
                        foreach($subcats as $key => $b){
                            if($b->id_categoria == $a->id){
                                $sum_subc += $b->venta_esperada;
                            }
                        }
                        $categoria->update($a->id,['venta_esperada' =>$sum_subc]);
                    }
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
        $categoria = new m_categoria();
        $subcategoria = new m_subcategoria();
        $marca = new m_marca();

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
                    $items = $item->asObject()->findAll();

                    $cats = $categoria->asObject()->findAll();
                    $subcats = $subcategoria->asObject()->findAll();
                    $marcs = $marca->asObject()->findAll();
    
                    foreach($marcs as $key => $b){
                        $sum_it =0;
                        foreach($items as $key => $c){
                            if($c->id_marca == $b->id){
                                $sum_it += $c->venta_esperada;
                            }
                        }
                        $marca->update($b->id,['venta_esperada' =>$sum_it]);
                    }
                    $marcs = $marca->asObject()->findAll();
                    foreach($subcats as $key => $a){
                        $sum_mar =0;
                        foreach($marcs as $key => $b){
                            if($b->id_subcategoria == $a->id){
                                $sum_mar += $b->venta_esperada;
                            }
                        }
                        $subcategoria->update($a->id,['venta_esperada' =>$sum_mar]);
                    }
                    $subcats = $subcategoria->asObject()->findAll();
                    foreach($cats as $key => $a){
                        $sum_subc =0;
                        foreach($subcats as $key => $b){
                            if($b->id_categoria == $a->id){
                                $sum_subc += $b->venta_esperada;
                            }
                        }
                        $categoria->update($a->id,['venta_esperada' =>$sum_subc]);
                    }
                    
                return redirect()->to('/item')->with('message', 'Item editado con éxito.');
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

                $items = $item->asObject()->findAll();

                $cats = $categoria->asObject()->findAll();
                $subcats = $subcategoria->asObject()->findAll();
                $marcs = $marca->asObject()->findAll();

                foreach($marcs as $key => $b){
                    $sum_it =0;
                    foreach($items as $key => $c){
                        if($c->id_marca == $b->id){
                            $sum_it += $c->venta_esperada;
                        }
                    }
                    $marca->update($b->id,['venta_esperada' =>$sum_it]);
                }
                $marcs = $marca->asObject()->findAll();
                foreach($subcats as $key => $a){
                    $sum_mar =0;
                    foreach($marcs as $key => $b){
                        if($b->id_subcategoria == $a->id){
                            $sum_mar += $b->venta_esperada;
                        }
                    }
                    $subcategoria->update($a->id,['venta_esperada' =>$sum_mar]);
                }
                $subcats = $subcategoria->asObject()->findAll();
                foreach($cats as $key => $a){
                    $sum_subc =0;
                    foreach($subcats as $key => $b){
                        if($b->id_categoria == $a->id){
                            $sum_subc += $b->venta_esperada;
                        }
                    }
                    $categoria->update($a->id,['venta_esperada' =>$sum_subc]);
                }
                
                return redirect()->to('/item')->with('message', 'Item editado con éxito.');
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
    public function filtrar_item(){
        $item = new m_item();
        $filtro = $this->request->getPost('filtro');

		$array = [
			'marca.nombre' => $filtro, 
			'item.codigo' => $filtro, 
			'item.descripcion' => $filtro 
		];

		$condiciones = ['item.estado_sql' => '1'];

		$data = [
            'item' => $item->asObject()
            ->select('item.*,marca.nombre as marca, proveedor.nombre_empresa AS proveedor')
            ->join('marca','marca.id = item.id_marca')
            ->join('proveedor','item.id_proveedor = proveedor.id')
            ->join('persona','persona.id = proveedor.id_persona')
            ->where($condiciones)
			->like('item.nombre', $filtro)
			->orlike($array)
            ->orderBy('marca','ASC')
            ->paginate(10,'item'),
            'pager' => $item->pager
        ];

        $this->_loadDefaultView( 'Listado de productos',$data,'index');
    }

    public function show($id){
        
        $item = new m_item();
        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();
        $generales = new m_generales();

        if ($item->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }   
        
        $total=0;

        $detalles = $detalle_venta->asObject()->join('pedido_venta','pedido_venta.id = detalle_venta.id_pedido_venta')
                                                ->where(['detalle_venta.estado_sql'=>1,'pedido_venta.estado'=>3])->findAll();
        foreach ($detalles as $key => $m){
            if($m->id_item == $id){
                $total += $m->cantidad;
            }
        }

        $restriccion = ['detalle_venta.id_item' => $id, 'pedido_venta.estado'=>3];
        $data = [
                'item' => $item->asObject()
                ->select('item.*,marca.nombre as marca, proveedor.nombre_empresa AS proveedor')
                ->join('marca','marca.id = item.id_marca')
                ->join('proveedor','item.id_proveedor = proveedor.id')
                ->join('persona','persona.id = proveedor.id_persona')
                ->first(),

                'ventas'=> $pedido_venta->asObject()
                ->select('pedido_venta.fecha, detalle_venta.cantidad')
                ->join('detalle_venta','pedido_venta.id = detalle_venta.id_pedido_venta')
                ->where($restriccion)
                ->orderBy('fecha','ASC')
                ->paginate(10,'ventas'),

                'pager' =>$pedido_venta->pager,

                'total'=> $total,

                'generales' => $generales->asObject()->first()
        ];
        
        $this->_loadDefaultView( 'Kardex',$data,'kardex');
    }
    public function filtrar_kardex($id){
        $item = new m_item();
        $generales = new m_generales();
        $pedido_venta = new m_pedido_venta();
        $detalle_venta = new m_detalle_venta();

        $fecha_inicio= $this->request->getPost('start');
        $fecha_fin= $this->request->getPost('end');

        $total=0;

        $detalles = $detalle_venta->asObject()->join('pedido_venta','pedido_venta.id = detalle_venta.id_pedido_venta')
                                                ->where(['detalle_venta.estado_sql'=>1,'pedido_venta.estado'=>3])->findAll();
        foreach ($detalles as $key => $m){
            if($m->id_item == $id){
                $total += $m->cantidad;
            }
        }

        $restriccion = ['pedido_venta.fecha >=' =>$fecha_inicio.'-01','pedido_venta.fecha <=' =>$fecha_fin.'-12',
                        'detalle_venta.id_item' => $id, 'pedido_venta.estado'=>3];

        $data = [
                'item' => $item->asObject()
                ->select('item.*,marca.nombre as marca, proveedor.nombre_empresa AS proveedor')
                ->join('marca','marca.id = item.id_marca')
                ->join('proveedor','item.id_proveedor = proveedor.id')
                ->join('persona','persona.id = proveedor.id_persona')
                ->first(),
            
                'ventas'=> $pedido_venta->asObject()
                ->select('pedido_venta.fecha, detalle_venta.cantidad')
                ->join('detalle_venta','pedido_venta.id = detalle_venta.id_pedido_venta')
                ->where($restriccion)
                ->orderBy('fecha','ASC')
                ->paginate(10,'ventas'),
            
                'pager' =>$pedido_venta->pager,
            
                'total'=> $total,

                'generales' => $generales->asObject()->first()
        ];
        $this->_loadDefaultView( 'Kardex',$data,'kardex');
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