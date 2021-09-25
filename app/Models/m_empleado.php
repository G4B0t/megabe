<?php namespace App\Models;

use CodeIgniter\Model;

class m_empleado extends Model
{
    protected $table = 'empleado';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_persona','id_almacen',
                                'usuario','contrasena','cargo','caja',
                                'fecha_ingreso','estado_sql'];

    function getAll(){
        return $this->asArray()
        ->select('empleado.*,persona.nombre as trabajador')
        ->join('persona','persona.id = empleado.id_persona')
        ->first();
    }

    function getOne($id){

        return $this->asArray()
        ->select('empleado.*')
        ->where('id',$id)
        ->first();
    }
    
}
