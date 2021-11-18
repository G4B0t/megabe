<?php namespace App\Models;

use CodeIgniter\Model;

class m_item extends Model
{
    protected $table = 'item';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion','id_marca','codigo',
                               'stock','precio_unitario','precio_compra',
                                'id_proveedor','venta_esperada','punto_reorden',
                                'marca','foto','estado_sql'];

   public function getByID($id = null)
    {
        if ($id === null) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['id' => $id])
            ->first();
    }

    public function getOne($id = null)
    {
        return $this->asObject()
            ->where(['id' => $id])
            ->first();
    }
    public function getItem($id){
        return $this->asObject()
            ->where(['id' => $id])
            ->first();
    }

}
