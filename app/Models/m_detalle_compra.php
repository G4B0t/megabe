<?php namespace App\Models;

use CodeIgniter\Model;

class m_detalle_compra extends Model
{
    protected $table = 'detalle_compra';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_item', 'id_pedido_compra','cantidad'
                                ,'precio_unitario','total','estado_sql'];

    public function getByID($id = null)
    {
        if ($id === null) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['id' => $id])
            ->first();
    }

    public function getDetalle($id_pedido,$id_item)
    {
        $condiciones = ['id_item' => $id_item,'id_pedido_compra' => $id_pedido,'estado_sql'=>'1'];
        return $this->asArray()
            ->select('detalle_compra.*')
            ->where($condiciones)
            ->first();
    }

    public function getFullDetalle($id_pedido)
    {
        $condiciones = ['id_pedido_compra' => $id_pedido,'estado_sql'=>'1'];
        return $this->asObject()
            ->select('detalle_compra.*')
            ->where($condiciones)
            ->findAll();
    }


}
