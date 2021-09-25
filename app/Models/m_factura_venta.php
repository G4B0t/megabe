<?php namespace App\Models;

use CodeIgniter\Model;

class m_factura_venta extends Model
{
    protected $table = 'factura_venta';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_comprobante', 'id_pedido_venta'
                                ,'nit_empresa'
                                ,'nro_factura','autorizacion'
                                ,'fecha_emision','nit_cliente'
                                ,'beneficiario','total','codigo_control'
                                ,'fecha_limite','codigo_qr','observaciones'
                                ,'estado_sql'];


    public function getFactura($id){
       
        $llave=['id'=>$id];
        return $this->asArray()
        ->select('factura_venta.*')
        ->where($llave)
        ->first();
    }
}