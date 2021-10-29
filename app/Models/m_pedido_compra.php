<?php namespace App\Models;

use CodeIgniter\Model;

class m_pedido_compra extends Model
{
    protected $table = 'pedido_compra';
    protected $primaryKey = 'id';
    protected $allowedFields = ['estado', 'id_empleado','moneda','tipo_pago','fecha','total','estado_sql'];

    
     function getAll(){
        return $this->asArray()
        ->select('pedido_compra.*, empleado.usuario as empleado')
        ->join('empleado','empleado.id = pedido_compra.id_empleado')
        ->first();
    }

    function getPedidoVigente($id_empleado){
        $condicion = ['estado_sql' => 1, 'id_empleado' => $id_empleado, 'estado' => 0];
        return $this->asObject()
        ->select('pedido_compra.*')
        ->where($condicion)
        ->first();
    }

    function getPedidoConfir($id_pedido){
        $condiciones = ['estado' => '1', 'estado_sql' => '1', 'id' => $id_pedido];
        return $this->asArray()
        ->select('pedido_compra.*')
        ->where($condiciones)
        ->first();
    }

    function getById($id_pedido){
        $condiciones = ['estado_sql' => '1', 'id' => $id_pedido];
        return $this->asObject()
        ->select('pedido_compra.*')
        ->where($condiciones)
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

    function getByDetalle($id_detalle){
        $condiciones = ['pedido_compra.estado_sql' => '1', 'detalle_compra.id' => $id_detalle];
        return $this->asObject()
        ->select('pedido_compra.*')
        ->join('detalle_compra','detalle_compra.id_pedido_compra = pedido_compra.id')
        ->where($condiciones)
        ->first();
    }                       
}