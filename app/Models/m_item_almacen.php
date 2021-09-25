<?php namespace App\Models;

use CodeIgniter\Model;

class m_item_almacen extends Model
{
    protected $table = 'item_almacen';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_almacen','id_item','stock'];

    public function getOne($id_item,$id_almacen){

        $restric = ['id_item'=>$id_item,'id_almacen'=>$id_almacen];
        return $this->asArray()
        ->select('item_almacen.*')
        ->where($restric)
        ->first();
    }

    public function getItems($id_almacen){
        $restric = ['id_almacen'=>$id_almacen];
        return $this->asObject()
        ->select('item_almacen.*')
        ->where($restric)
        ->findAll();
    }

    public function getAlmacenes($id_item){
        $restric = ['id_item'=>$id_item];
        return $this->asObject()
        ->select('item_almacen.*')
        ->where($restric)
        ->findAll();
    }
}
