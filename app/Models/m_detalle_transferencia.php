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
        ->where('id',$id);
    }

}