<?php namespace App\Controllers;
use App\Models\m_categoria;
use App\Models\m_subcategoria;
use App\Controllers\BaseController;
use \CodeIgniter\Exceptions\PageNotFoundException;
use App\Models\m_transferencia;

class Transferencia extends BaseController {

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

        $transferencia = new m_transferencia();

        $data = [
            'transferencia' => $transferencia->asObject()
            ->select('transferencia.*,CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullname, A.direccion as origen, B.direccion as destino')
            ->join('empleado','empleado.id = transferencia.id_empleado1')
            ->join('persona','persona.id = empleado.id_persona')
            ->join('almacen A','A.id = transferencia.id_almacen_origen')
            ->join('almacen B','B.id = transferencia.id_almacen_destino')
            ->orderBy('fecha_envio', 'DESC')
            ->paginate(10, 'transferencia'),
            'pager' => $transferencia->pager
        ];

        $this->_loadDefaultView( 'Listado de Transferencias',$data,'index');
    }

    public function new(){

       $categoria = new m_categoria();
       
       $validation =  \Config\Services::validation();
       $this->_loadDefaultView('Crear Subcategoria',['validation'=>$validation, 'subcategoria'=> new m_subcategoria(),
                                'categoria' => $categoria->asObject()->findAll()],'new');


    }

    public function create(){

        $subcategoria = new m_subcategoria();

       
        if($imagefile = $this->request->getFile('foto')) {
            $foto = "";
            if ($imagefile->isValid() && ! $imagefile->hasMoved())
                {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/subcategorias', $foto);
                }
            
        }

        if($this->validate('subcategorias')){
            $id = $subcategoria->insert([
                'nombre' =>$this->request->getPost('nombre'),
                'descripcion' =>$this->request->getPost('descripcion'),
                'id_categoria' =>$this->request->getPost('id_categoria'),
                'foto' => $foto,
                'estado_sql' =>'1'
            ]);

            return redirect()->to("/subcategoria")->with('message', 'Subcategoria creado con éxito.');

        }
        
        return redirect()->back()->withInput();
    }

    public function edit($id = null){

        $categoria = new m_categoria();
        $subcategoria = new m_subcategoria();

        if ($subcategoria->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  

        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Modificar Subcategoria',['validation'=>$validation,'subcategoria'=> $subcategoria->asObject()->find($id),
                                            'categoria' => $categoria->asObject()->findAll()],'edit');
    }

    public function update($id = null){

        $subcategoria = new m_subcategoria();

        if ($subcategoria->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  


        $foto = $subcategoria->getByID($id);

        if($imagefile = $this->request->getFile('foto')) {
           
            if($foto == $imagefile->getName()){
                if($this->validate('subcategorias')){
                    $subcategoria->update($id, [
                        'nombre' =>$this->request->getPost('nombre'),
                        'descripcion' =>$this->request->getPost('descripcion'),
                        'id_categoria' =>$this->request->getPost('id_categoria'),
                        'estado_sql' =>'1'              
                    ]);
    
                return redirect()->to('/subcategoria')->with('message', 'SubCategoria editado con éxito.');
                }
                return redirect()->back()->withInput();
           }else{
                if ($imagefile->isValid() && ! $imagefile->hasMoved())
                {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/subcategorias', $foto);
                }
                
                if($this->validate('subcategorias')){
                    $subcategoria->update($id, [
                        'nombre' =>$this->request->getPost('nombre'),
                        'descripcion' =>$this->request->getPost('descripcion'),
                        'id_categoria' =>$this->request->getPost('id_categoria'),
                        'foto' => $foto,
                        'estado_sql' =>'1'              
                    ]);
    
                return redirect()->to('/subcategoria')->with('message', 'Sub Categoria editado con éxito.');
                }                
            }
        }

    }

    public function delete($id = null){

        $subcategoria = new m_subcategoria();

        if ($subcategoria->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
            
        } 
        try
        {
            $subcategoria->delete($id);
            return redirect()->to('/subcategoria')->with('message', 'Subcategoria eliminada con éxito.');
        }
        catch (\Exception $e)
        {
            return redirect()->to('/subcategoria')->with('message', 'No se puede eliminar el registro.');
        }
       
    }

    public function show($id = null){
        
        $subcategoria = new m_subcategoria();

        if ($subcategoria->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }   

        var_dump($subcategoria->asObject()->find($id)->id);

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
        echo view("dashboard/transferencia/$view",$data);
        echo view("dashboard/templates/footer");
    }

}