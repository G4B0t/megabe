<?php

namespace Config;

use CodeIgniter\Validation\CreditCardRules;
use CodeIgniter\Validation\FileRules;
use CodeIgniter\Validation\FormatRules;
use CodeIgniter\Validation\Rules;

class Validation
{
	//--------------------------------------------------------------------
	// Setup
	//--------------------------------------------------------------------

	/**
	 * Stores the classes that contain the
	 * rules that are available.
	 *
	 * @var string[]
	 */
	public $ruleSets = [
		Rules::class,
		FormatRules::class,
		FileRules::class,
		CreditCardRules::class,
	];

	public $items =[
		'nombre' => 'required|min_length[3]|max_length[255]',
		'descripcion' => 'required'
	];
	public $subcategorias =[
		'nombre' => 'min_length[3]|max_length[255]',
		'descripcion' => 'min_length[3]|max_length[5000]'
	];
	public $categorias =[
		'nombre' => 'min_length[3]|max_length[255]',
		'descripcion' => 'min_length[3]|max_length[5000]'
	];
	public $almacenes =[
		'direccion' => 'min_length[6]|max_length[255]',
		'telefono' => 'min_length[7]|max_length[18]'
	];
	public $plan_cuentas =[
		'nombre_cuenta' => 'min_length[1]|max_length[70]',
		'codigo_cuenta' => 'min_length[1]|max_length[18]'
	];
	public $proveedores =[
		'nombre_empresa' => 'required|min_length[3]|max_length[20]',
		'direccion' => 'required|min_length[4]|max_length[50]',
		'contacto' => 'required|min_length[3]|max_length[15]'
	];
	public $comprobantes =[
		'glosa' => 'required|min_length[3]|max_length[50]',
		'tipo_respaldo' => 'required|min_length[3]|max_length[50]'
	];

	public $personas =[
		'nombre' => 'required|max_length[20]',
		'apellido_paterno'=>'required|max_length[20]',
		'nro_ci'=>'required|max_length[20]|is_unique[persona.nro_ci]'
	];
	public $empleados =[
		'usuario' => 'required|min_length[3]|max_length[20]|is_unique[empleado.usuario]',
		'email' => 'required|valid_email|is_unique[empleado.email]',
		'contrasena' => 'required|min_length[3]|max_length[20]',
		'id_almacen' =>'required',
		'rol' => 'required'
	];
	public $clientes =[
		'usuario' => 'required|min_length[3]|max_length[20]|is_unique[cliente.usuario]',
		'email' => 'required|valid_email|is_unique[cliente.email]',
		'contrasena' => 'required|min_length[6]|max_length[20]'
	];
	public $empleado_password =[
		'contrasena' => 'min_length[2]|max_length[20]'
	];
	public $empleado_user =[
		'usuario' => 'min_length[4]|max_length[20]|is_unique[empleado.usuario]'
	];
	public $empleado_email =[
		'email' => 'valid_email|is_unique[empleado.email]'
	];
	public $cliente_password =[
		'contrasena' => 'min_length[2]|max_length[20]'
	];
	public $cliente_user =[
		'usuario' => 'min_length[4]|max_length[20]|is_unique[cliente.usuario]'
	];
	public $cliente_email =[
		'email' => 'valid_email|is_unique[cliente.email]'
	];
	public $logins =[
		'password' => 'min_length[2]|max_length[20]',
		'email' => 'min_length[2]|max_length[20]'	
	];
	
	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		//'list'   => 'CodeIgniter\Validation\Views\list',
		'list'   => 'App\Views\personalizacion\validacion',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
}
