<?php namespace App\Models;

use CodeIgniter\Model;

class m_detalle_venta extends Model
{
    protected $table = 'detalle_venta';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_item', 'id_pedido_venta','cantidad'
                                ,'precio_unitario','descuento','total','estado_sql'];

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
        $condiciones = ['id_item' => $id_item,'id_pedido_venta' => $id_pedido,'estado_sql'=>'1'];
        return $this->asArray()
            ->select('detalle_venta.*')
            ->where($condiciones)
            ->first();
    }

    public function getFullDetalle($id_pedido)
    {
        $condiciones = ['detalle_venta.id_pedido_venta' => $id_pedido,'detalle_venta.estado_sql'=>'1'];
        return $this->asObject()
            ->select('detalle_venta.*,item.nombre')
            ->join('item','detalle_venta.id_item = item.id')
            ->where($condiciones)
            ->findAll();
    }

}
