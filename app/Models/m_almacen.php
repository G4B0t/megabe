<?php namespace App\Models;

use CodeIgniter\Model;

class m_almacen extends Model
{
    protected $table = 'almacen';
    protected $primaryKey = 'id';
    protected $allowedFields = ['foto','longitud','latitud','telefono','direccion','estado_sql'];

    function getOne($id){
        return $this->asObject()
        ->select('almacen.*')
        ->where('id',$id)
        ->first();
    }

}
