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
		'descripcion' => 'min_length[3]|max_length[5000]'
	];
	public $subcategorias =[
		'nombre' => 'required|min_length[3]|max_length[255]',
		'descripcion' => 'min_length[3]|max_length[5000]'
	];
	public $categorias =[
		'nombre' => 'required|min_length[3]|max_length[255]',
		'descripcion' => 'min_length[3]|max_length[5000]'
	];
	public $almacenes =[
		'direccion' => 'required|min_length[6]|max_length[255]',
		'telefono' => 'required|min_length[7]|max_length[18]'
	];

	public $personas =[
		'nombre' => 'required|min_length[3]|max_length[20]',
	];
	public $empleados =[
		'usuario' => 'required|min_length[3]|max_length[20] |required| is_unique[empleado.usuario]',
		'email' => 'required|min_length[8]|max_length[50] |required| is_unique[empleado.email]',
		'contrasena' => 'required|min_length[2]|max_length[20]'
	];
	public $clientes =[
		'usuario' => 'required|min_length[3]|max_length[20] |required|is_unique[cliente.usuario]',
		'email' => 'required|min_length[8]|max_length[50] | required|is_unique[cliente.email]',
		'contrasena' => 'required|min_length[2]|max_length[20]'
	];
	public $cliente_password =[
		'contrasena' => 'required|min_length[2]|max_length[20]'
	
	];
	public $empleado_password =[
		'contrasena' => 'required|min_length[2]|max_length[20]'	
	];
	public $logins =[
		'password' => 'required|min_length[2]|max_length[20]',
		'email' => 'required|min_length[2]|max_length[20]'	
	];
	
	/**
	 * Specifies the views that are used to display the
	 * errors.
	 *
	 * @var array<string, string>
	 */
	public $templates = [
		'list'   => 'CodeIgniter\Validation\Views\list',
		'single' => 'CodeIgniter\Validation\Views\single',
	];

	//--------------------------------------------------------------------
	// Rules
	//--------------------------------------------------------------------
}
