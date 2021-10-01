<?php namespace App\Models;

use CodeIgniter\Model;

class m_pedido_venta extends Model
{
    protected $table = 'pedido_venta';
    protected $primaryKey = 'id';
    protected $allowedFields = ['estado', 'id_empleado','id_cliente'
                                ,'moneda','tipo_pago','fecha','total','estado_sql'];

    function getAll(){
        return $this->asArray()
        ->select('pedido_venta.*, empleado.usuario as empleado as subcategoria')
        ->join('subcategoria','subcategoria.id = item.id_subcategoria')
        ->first();
    }

    function getPedido($id_cliente){
        $condiciones = ['estado' => '0', 'estado_sql' => '1', 'id_cliente' => $id_cliente];
        return $this->asArray()
        ->select('pedido_venta.*')
        ->where($condiciones)
        ->first();
    }

    function getPedidoConfir($id_pedido){
        $condiciones = ['estado' => '1', 'estado_sql' => '1', 'id' => $id_pedido];
        return $this->asArray()
        ->select('pedido_venta.*')
        ->where($condiciones)
        ->first();
    }

    function getPedidoPagado($id_pedido){
        $condiciones = ['estado_sql' => '1', 'id' => $id_pedido];
        return $this->asArray()
        ->select('pedido_venta.*')
        ->where($condiciones)
        ->first();
    }

    function getById($id_pedido){
        $condiciones = ['estado_sql' => '1', 'id' => $id_pedido];
        return $this->asObject()
        ->select('pedido_venta.*')
        ->where($condiciones)
        ->first();
    }

    function getByDetalle($id_detalle){
        $condiciones = ['pedido_venta.estado_sql' => '1', 'detalle_venta.id' => $id_detalle];
        return $this->asObject()
        ->select('pedido_venta.*')
        ->join('detalle_venta','detalle_venta.id_pedido_venta = pedido_venta.id')
        ->where($condiciones)
        ->first();
    }

    public function getFirst()
    {
        $condiciones = ['estado' => '1', 'estado_sql' => '1'];
        return $this->asArray()
        ->select('pedido_venta.*')
        ->where($condiciones)
        ->first();
    }
    public function getPrimer()
    {
        $condiciones = ['estado' => '2', 'estado_sql' => '1'];
        return $this->asArray()
        ->select('pedido_venta.*')
        ->where($condiciones)
        ->first();
    }
    public function getPagado()
    {
        $condiciones = ['estado' => '2', 'estado_sql' => '1'];
        return $this->asArray()
        ->select('pedido_venta.*')
        ->where($condiciones)
        ->first();
    }

}
