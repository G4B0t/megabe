<?php namespace App\Controllers;
use App\Models\m_cliente;
use App\Models\m_empleado;
use App\Controllers\BaseController;
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

        return redirect()->to('/home')->with('message', 'Sesion Cerrada!');
    } 

    public function configuracion(){
        $data = [
            'usuario' => 'gabozki'
        ];
  
          $this->_loadDefaultView( 'Perfil',$data,'_configuracion','header-inner-pages');
    }

    private function _loadDefaultView($title,$data,$view,$tipo){

        $categoria = new m_categoria();
		$subcategoria = new m_subcategoria();
		$marca = new m_marca();


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

            'rol' => 'Normal',

            'log' => 'login',

            'vista'=> 'home'
        ];

        echo view("dashboard/templates/header",$dataHeader);
        echo view("dashboard/user/$view",$data);
        echo view("dashboard/templates/footer");
    }

}