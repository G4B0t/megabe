<?php namespace App\Controllers;

use App\Models\m_marca;
use App\Models\m_subcategoria;
use App\Models\m_categoria;
use App\Models\m_item;

use App\Controllers\BaseController;
use App\Controllers\Administracion_1;

use App\Models\m_cliente;
use App\Models\m_empleado;
use App\Models\m_persona;
use App\Models\m_rol;
use App\Models\m_empleado_rol;

class Home extends BaseController
{
	public function index()
	{
		$marca = new m_marca();
		$categoria = new m_categoria();
		$subcategoria = new m_subcategoria();
		$data = [
			'subcategoria' => $subcategoria->asObject()
            ->select('subcategoria.*,categoria.nombre as categoria')
            ->join('categoria','categoria.id = subcategoria.id_categoria')
            ->findAll(),

			'marca' => $marca->asObject()
			->select('marca.*,subcategoria.nombre as subcategoria')
            ->join('subcategoria','subcategoria.id = marca.id_subcategoria')
            ->findAll(),

			'categoria' => $categoria->asObject()
            ->select('categoria.*')
            ->findAll()
        ];

		$this->_loadDefaultView( '',$data,'index','');

	}

	function imagen($nombre, $foto){

			$name = WRITEPATH.'uploads/'.$nombre.'/'.$foto;

			$fp = fopen($name, 'rb');

			// envía las cabeceras correctas
			header("Content-Type: image/png");
			header("Content-Length: " . filesize($name));

			// vuelca la imagen y detiene el script
			fpassthru($fp);
			exit;

	}

	public function filtrado(){
		$item = new m_item();
		
		$filtro = $this->request->getPost('filtro');

		$array = [
			'marca.nombre' => $filtro, 
			'item.codigo' => $filtro, 
			'item.descripcion' => $filtro, 
			'subcategoria.nombre' => $filtro, 
			'categoria.nombre' =>$filtro,
		];

		$condiciones = ['item.estado_sql' => '1'];

		$data = [
			'item' => $item->asObject()
            ->select('item.*,marca.id AS marcaId, 
				marca.nombre AS marca, subcategoria.id AS subcategoriaID, 
				subcategoria.nombre AS subcategoria, categoria.id AS categoriaID, 
				categoria.nombre AS categoria')
			->join('marca','item.id_marca = marca.id')
			->join('subcategoria','marca.id_subcategoria = subcategoria.id')
			->join('categoria','subcategoria.id_categoria = categoria.id')
			->where($condiciones)
			->like('item.nombre', $filtro)
			->orlike($array)
            ->findAll()
        ];

		$this->_loadDefaultView( 'Filtrado por: '.$filtro,$data,'productos','header-inner-pages');

	}

	public function listarTodo(){

		$item = new m_item();
		
		$condiciones = ['item.estado_sql' => '1'];

		$data = [
			'item' => $item->asObject()
            ->select('item.*,marca.id AS marcaId, 
					marca.nombre AS marca, subcategoria.id AS subcategoriaID, 
					subcategoria.nombre AS subcategoria, categoria.id AS categoriaID, 
					categoria.nombre AS categoria')
			->join('marca','item.id_marca = marca.id')
			->join('subcategoria','marca.id_subcategoria = subcategoria.id')
			->join('categoria','subcategoria.id_categoria = categoria.id')
			->where($condiciones)
            ->findAll(),
        ];

		$this->_loadDefaultView( 'Tienda',$data,'productos','header-inner-pages');

	}

	public function listaHome($id_categoria, $id_subcategoria){

		$item = new m_item();
		$subcategoria = new m_subcategoria();

		$nombre_subcat = $subcategoria->getByID($id_subcategoria);

		$condiciones = ['item.estado_sql' => '1','subcategoria.id' => $id_subcategoria,'categoria.id' => $id_categoria];

		$data = [
			'item' => $item->asObject()
            ->select('item.*,marca.id AS marcaId, 
				marca.nombre AS marca, subcategoria.id AS subcategoriaID, 
				subcategoria.nombre AS subcategoria, categoria.id AS categoriaID, 
				categoria.nombre AS categoria')
			->join('marca','item.id_marca = marca.id')
			->join('subcategoria','marca.id_subcategoria = subcategoria.id')
			->join('categoria','subcategoria.id_categoria = categoria.id')
			->where($condiciones)
            ->findAll()
        ];

		$this->_loadDefaultView( 'Categoria elegida: '.$nombre_subcat['nombre'],$data,'productos','header-inner-pages');

	}

	public function detalle($id_item){

		$item = new m_item();

		$producto = $item->getByID($id_item);

		

		$nombre = $producto['nombre'];
		
		$data = [
			'item'=>$item->asObject()
			->where(['id' => $id_item])
			->first()
        ];

		$session = session();
        $id_cliente = $session->cliente;

        if($id_cliente==null){
			return redirect()->to('/productos')->with('message', 'Necesita Iniciar Sesion');
		}
		$this->_loadDefaultView( $nombre ,$data,'detalle','header-inner-pages');

	}

	public function menuCategoria($id_categoria){

		$item = new m_item();
		$categoria = new m_categoria();


		$name = $categoria->getByID($id_categoria);

		$condiciones = ['item.estado_sql' => '1','categoria.id' => $id_categoria];

		$data = [
			'item' => $item->asObject()
            ->select('item.*,marca.id AS marcaId, 
				marca.nombre AS marca, subcategoria.id AS subcategoriaID, 
				subcategoria.nombre AS subcategoria, categoria.id AS categoriaID, 
				categoria.nombre AS categoria')
			->join('marca','item.id_marca = marca.id')
			->join('subcategoria','marca.id_subcategoria = subcategoria.id')
			->join('categoria','subcategoria.id_categoria = categoria.id')
			->where($condiciones)
            ->findAll()
        ];

		$this->_loadDefaultView( 'Categoria elegida: '.$name['nombre'],$data,'productos','header-inner-pages');
	}

	public function menuSubcategoria($id_subcategoria){
		$item = new m_item();
		$subcategoria = new m_subcategoria();

		$name = $subcategoria->getByID($id_subcategoria);

		$condiciones = ['item.estado_sql' => '1','subcategoria.id' => $id_subcategoria];

		$data = [
			'item' => $item->asObject()
            ->select('item.*,marca.id AS marcaId, 
				marca.nombre AS marca, subcategoria.id AS subcategoriaID, 
				subcategoria.nombre AS subcategoria, categoria.id AS categoriaID, 
				categoria.nombre AS categoria')
			->join('marca','item.id_marca = marca.id')
			->join('subcategoria','marca.id_subcategoria = subcategoria.id')
			->join('categoria','subcategoria.id_categoria = categoria.id')
			->where($condiciones)
            ->findAll()
        ];

		$this->_loadDefaultView( 'Subcategoria elegida: '.$name['nombre'],$data,'productos','header-inner-pages');
	}

	public function menuMarca($id_marca){
		$item = new m_item();
		$marca = new m_marca();

		$name = $marca->getByID($id_marca);

		$condiciones = ['item.estado_sql' => '1','marca.id' => $id_marca];

		$data = [
			'item' => $item->asObject()
            ->select('item.*,marca.id AS marcaId, 
				marca.nombre AS marca, subcategoria.id AS subcategoriaID, 
				subcategoria.nombre AS subcategoria, categoria.id AS categoriaID, 
				categoria.nombre AS categoria')
			->join('marca','item.id_marca = marca.id')
			->join('subcategoria','marca.id_subcategoria = subcategoria.id')
			->join('categoria','subcategoria.id_categoria = categoria.id')
			->where($condiciones)
            ->findAll()
        ];

		$this->_loadDefaultView( 'Marca elegida: '.$name['nombre'],$data,'productos','header-inner-pages');
	}
	
	private function _loadDefaultView($title,$data,$view,$tipo){
		$session = session();

		$categoria = new m_categoria();
		$subcategoria = new m_subcategoria();
		$marca = new m_marca();

		$persona = new m_persona();
		$role = new m_rol();
		$empleado_rol = new m_empleado_rol();
		
		$admin = new Administracion_1();
		$sesion = $admin->sesiones();

		$rol[] = (object) array('nombre' => $sesion['rol']);
		
        $dataHeader =[
            'title' => $title,
			'tipo' => $tipo,

			'categoria' => $categoria->asObject()
            ->select('categoria.*')
            ->findAll(),

			'subcategoria' => $subcategoria->asObject()
            ->select('subcategoria.*')
            ->join('categoria','categoria.id = subcategoria.id_categoria')
            ->findAll(),

			'marca' => $marca->asObject()
			->select('marca.*')
            ->join('subcategoria','subcategoria.id = marca.id_subcategoria')
            ->findAll(),

			'rol' => $rol,

			'log' => $sesion['log'],

			'central'=>'',

			'vista' =>''
        ];
		
		echo view("dashboard/templates/header",$dataHeader);
        echo view("/$view",$data);
        echo view("dashboard/templates/footer");
    }
}
