<?php namespace App\Models;

use CodeIgniter\Model;

class m_detalle_transferencia extends Model
{
    protected $table = 'detalle_transferencia';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_item', 'id_transferencia','cantidad'
                                ,'estado_sql'];


    public function getOne($id){
        return $this->asObject()
        ->where('id',$id)
        ->first();
    }

    public function getDetalle($id_transferencia, $id_item){
        $restriccion = ['id_transferencia'=>$id_transferencia,'id_item'=>$id_item];
        return $this->asObject()
        ->where($restriccion)
        ->first();
    }

    public function getFullDetalle($id_transferencia){
        $restriccion = ['id_transferencia' => $id_transferencia,'estado_sql'=> 1];
        return $this->asObject()
        ->where($restriccion)
        ->findAll();
    }

}