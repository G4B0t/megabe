<?php namespace App\Models;

use CodeIgniter\Model;

class m_rol extends Model
{
    protected $table = 'rol';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre','descripcion','estado_sql'];

    public function getRol($id)
    {
        $condiciones = ['empleado_rol.id_rol' => $id,'rol.estado_sql' => '1'];
        return $this->asArray()
            ->select('rol.*')
            ->join('empleado_rol','rol.id = empleado_rol.id_rol')
            ->where($condiciones)
            ->first();
    }
    
}
