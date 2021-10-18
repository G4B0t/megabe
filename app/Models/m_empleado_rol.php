<?php namespace App\Models;

use CodeIgniter\Model;

class m_empleado_rol extends Model
{
    protected $table = 'empleado_rol';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_empleado','id_rol','horario','estado_sql'];

    public function getByEmpleado($id_empleado)
    {
        $condiciones = ['empleado_rol.id_empleado' => $id_empleado,'empleado_rol.estado_sql' => 1];
        return $this->asObject()
            ->select('rol.nombre')
            ->join('rol','empleado_rol.id_rol=rol.id')
            ->where($condiciones)
            ->findAll();
    }

    public function getOneRol($id_empleado)
    {
        $condiciones = ['empleado_rol.id_empleado' => $id_empleado,'empleado_rol.estado_sql' => 1];
        return $this->asArray()
            ->select('empleado_rol.*')
            ->where($condiciones)
            ->first();
    }

    public function getByRol($id_rol)
    {
        $condiciones = ['id_rol' => $id_rol,'estado_sql' => '1'];
        return $this->asArray()
            ->select('empleado_rol.*')
            ->where($condiciones)
            ->findAll();
    }
}
