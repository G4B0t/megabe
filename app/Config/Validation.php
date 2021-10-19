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

	public $personas =[
		'nombre' => 'required|max_length[20]',
		'apellido_paterno'=>'required|max_length[20]',
		'nro_ci'=>'required|max_length[20]|is_unique[persona.nro_ci]'
	];
	public $empleados =[
		'usuario' => 'required|min_length[3]|max_length[20]|is_unique[empleado.usuario]',
		'email' => 'required|min_length[8]|max_length[50]',
		'contrasena' => 'required|min_length[2]|max_length[20]'
	];
	public $clientes =[
		'usuario' => 'required|min_length[4]|max_length[20]|is_unique[cliente.usuario]',
		'email' => 'required|valid_email',
		'contrasena' => 'required|min_length[6]|max_length[20]'
	];
	public $cliente_password =[
		'contrasena' => 'min_length[2]|max_length[20]'
	
	];
	public $empleado_password =[
		'contrasena' => 'min_length[2]|max_length[20]'	
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
