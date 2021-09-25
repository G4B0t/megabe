<?php namespace App\Models;

use CodeIgniter\Model;

class m_almacen extends Model
{
    protected $table = 'almacen';
    protected $primaryKey = 'id';
    protected $allowedFields = ['foto','longitud','latitud','telefono','direccion','estado_sql'];

    function getOne(){
        return $this->asArray()
        ->select('almacen.*,empleado.nombre as empleado')
        ->join('empleado','empleado.id = almacen.id_empleado')
        ->first();
    }

}
