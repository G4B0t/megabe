<?php namespace App\Controllers;
use App\Models\m_cliente;
use App\Models\m_persona;
use App\Models\m_empleado;
use App\Controllers\BaseController;
use App\Controllers\administracion_1;
use \CodeIgniter\Exceptions\PageNotFoundException;

use App\Models\m_marca;
use App\Models\m_subcategoria;
use App\Models\m_categoria;

class User extends BaseController {

    public function login(){
    
        

        $data = [

                ];
            
            $this->_loadDefaultView( 'Iniciar Sesion',$data,'index','header-inner-pages');

    }

    public function login_post(){

        $cliente = new m_cliente();
        $empleado = new m_empleado();
        $session = session();
       

        if($this->validate('logins')){
            $emailUser = $this->request->getPost('email');
            $contrasena = $this->request->getPost('password');
            $checkAdmin = $this->request->getPost('empleadoCheck');
            if($checkAdmin == '1'){
                $es_user = 'empleado';
                $usuario = $this->verifyUser($contrasena,$emailUser,$es_user);
                if($usuario != null){
                    $newdata = [
                        'persona'  => $usuario->id_persona,
                        'empleado' => $usuario->id
                    ];
                    $session->set($newdata);
                    return redirect()->to('/administracion')->with('message', 'Inicio de Sesion exitoso!');
                }else{
                    return redirect()->to('/login')->with('message', 'Usuario o Contrasena incorrecto');
                }
            }else{
                $es_user = 'cliente';
                $usuario = $this->verifyUser($contrasena,$emailUser,$es_user);
                if($usuario){
                    $newdata = [
                        'persona'  => $usuario->id_persona,
                        'cliente'  => $usuario->id
                    ];
                    $session->set($newdata);
                    return redirect()->to('/home')->with('message', 'Inicio de Sesion exitoso!');
                    
                }else{
                    return redirect()->to('/login')->with('message', 'Usuario o Contrasena incorrecto');
                }
            }
        }else{
            return redirect()->to('/login')->with('message', 'No ingreso el Usuario o Contraseña');
        }
    }

    public function verifyUser($contrasena,$emailUser,$es_user){
        helper("user");

        $cliente = new m_cliente();
        $empleado = new m_empleado();
       
        if($es_user == 'cliente'){
            $usuario_cliente = $cliente->asObject()->orWhere('email',$emailUser)->orWhere('usuario',$emailUser)->first();
            if($usuario_cliente != null){
                if(verificarPassword($contrasena,$usuario_cliente->contrasena)){
                    return $usuario_cliente;
                }else{
                    return false;
                }
            }else{
               return false;
            }
        }else if($es_user == 'empleado'){
            $usuario_empleado = $empleado->asObject()->orWhere('email',$emailUser)->orWhere('usuario',$emailUser)->first();
            if($usuario_empleado !=null){
                if(verificarPassword($contrasena,$usuario_empleado->contrasena)){
                    return $usuario_empleado;
                }else{
                    return false;
                }
            }
            else{
                return false;
            }
        }
    }
    public function logout(){
        $session = session();
        $session->destroy();

        return redirect()->to('/')->with('message', 'Sesion Cerrada!');
    } 

    public function configuracion(){
        $cliente = new m_cliente();
        $validation =  \Config\Services::validation();
        $sesion = session();
        $id_persona = $sesion->cliente;
        
        $user = $cliente->getFullCliente($id_persona);

        $data = [
            'validation'=>$validation,
            'cliente' => $user
        ];
        
        $this->_loadDefaultView( 'Perfil',$data,'editar','header-inner-pages');
    }

    public function nuevo(){

        $cliente = new m_cliente();
        $persona = new m_persona();
        
        $validation =  \Config\Services::validation();
        $this->_loadDefaultView('Crear Cliente',['validation'=>$validation, 'cliente'=> new m_cliente(),
                                 'persona' => new m_persona()],'nuevoUser','header-inner-pages');
     }
    public function crear(){
        helper("user");
        $cliente = new m_cliente();
        $persona = new m_persona();
        
        $db = \Config\Database::connect();

        $email = $this->request->getPost('email');
        if($this->validate('clientes') && $this->validate('personas')){
            
            $foto = "";
            if($imagefile = $this->request->getFile('foto')) {
            
                if ($imagefile->isValid() && ! $imagefile->hasMoved())
                    {
                        $foto = $imagefile->getRandomName();
                        $imagefile->move(WRITEPATH.'uploads/clientes', $foto);
                }
            }

            
            if($persona->insert([
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
                    
                if($cliente->insert([
                    'nit' =>$this->request->getPost('nit'),
                    'razon_social' =>$this->request->getPost('razon_social'),
                    'id_persona' =>$id_persona,
                    'usuario' =>$this->request->getPost('usuario'),
                    'contrasena' =>hashPassword($this->request->getPost('contrasena')) ,
                    'email'=>$this->request->getPost('email') 
                ])){
                    return redirect()->to("/")->with('message', 'Nuevo Usuario Creado Con éxito.');
                }  
            }
        }
        return redirect()->back()->withInput()->with('message', 'No se pudo registrar');
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
                                                    'persona' => $persona->getPersona($es_cliente['id'])],'editar','header-inner-pages');
    }

    public function actualizar($id){
        helper("user");

        $cliente = new m_cliente();
        $persona = new m_persona();


       if ($cliente->find($id) == null)
        {
            throw PageNotFoundException::forPageNotFound();
        }  
        $user = $cliente->getOne($id);

        $usuario = $this->request->getPost('usuario');
        $clave = $this->request->getPost('contrasena');
        $clave_confirm = $this->request->getPost('confirm_contrasena');
        $correo = $this->request->getPost('email');

        
        if($usuario != $user->usuario){
            if($this->validate('cliente_user')){
                        
                $cliente->update($id, ['usuario' => $usuario]);
    
                return redirect()->to('/user/configuracion')->with('message', 'Actualizacion de Datos exitosa!');          
            }
            else{
                return redirect()->back()->withInput();
            }
        }
        if($correo != $user->email){
            if($this->validate('cliente_email')){
                        
                $cliente->update($id, ['email' => $correo]);
    
                return redirect()->to('/user/configuracion')->with('message', 'Actualizacion de Datos exitosa!');          
            }
            else{
                return redirect()->back()->withInput();
            }
        }
        
        if($clave != '' && $clave_confirm != ''){
            if($clave == $clave_confirm){
                if($this->validate('cliente_password')){
                            
                    $cliente->update($id, ['contrasena' => hashPassword($clave)]);
        
                    return redirect()->to('/user/configuracion')->with('message', 'Actualizacion de Datos exitosa!');          
                }
                else{
                    return redirect()->back()->withInput();
                }
            }else{
                return redirect()->back()->withInput()->with('message', 'Las contraseñas no coinciden');
            }
        }

        $foto = "";
        
        /*if($imagefile = $this->request->getFile('foto')) {
            
            if ($imagefile->isValid() && ! $imagefile->hasMoved())
                {
                    $foto = $imagefile->getRandomName();
                    $imagefile->move(WRITEPATH.'uploads/clientes', $foto);
                }          
        }*/
        //
       
    }

    private function _loadDefaultView($title,$data,$view,$tipo){

        $categoria = new m_categoria();
		$subcategoria = new m_subcategoria();
		$marca = new m_marca();

        $administracion = new administracion_1();
        $sesion = $administracion->sesiones();

        $rol[] = (object) array('nombre' => $sesion['rol']);
        
        $dataHeader =[
            'title' => $title,
            'tipo' => $tipo,

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
            'rol' => $rol,

			'log' => $sesion['log'],

            'central'=>$sesion['almacen'],

            'vista'=> ''
        ];

        echo view("dashboard/templates/header",$dataHeader);
        echo view("dashboard/user/$view",$data);
        echo view("dashboard/templates/footer");
    }

}