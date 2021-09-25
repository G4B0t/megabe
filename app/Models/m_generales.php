<?php namespace App\Models;

use CodeIgniter\Model;

class m_generales extends Model
{
    protected $table = 'generales';
    protected $allowedFields = ['nit_empresa','nombre_empresa',
                                'direccion','contacto'];


    public function getEmpresa(){
        return $this->asArray()
        ->select('generales.*')
        ->first();
    }
}