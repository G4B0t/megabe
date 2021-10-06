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
    function getCentral(){
        return $this->asObject()
        ->select('almacen.*')
        ->first();
    }

    function getAlmacen($id_empleado){
        return $this->asObject()
        ->select('almacen.*')
        ->join('empleado','empleado.id_almacen = almacen.id')
        ->where('empleado.id',$id_empleado)
        ->first();
    }

    public function getOtros($id_almacen_origen){
        
        return $this->asObject()
        ->select('almacen.*')
        ->whereNotIn('id', [$id_almacen_origen])
        ->findAll();
        
    }
}
