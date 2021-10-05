<?php namespace App\Models;

use CodeIgniter\Model;

class m_transferencia extends Model
{
    protected $table = 'transferencia';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_almacen_destino', 'id_almacen_origen'
                                ,'id_empleado1','id_empleado2','fecha_envio'
                                ,'fecha_recibido'
                                ,'estado_sql'];


    public function getOne($id){
        return $this->asObject()
        ->where('id',$id);
    }

}