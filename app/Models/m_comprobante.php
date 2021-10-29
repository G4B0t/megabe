<?php namespace App\Models;

use CodeIgniter\Model;

class m_comprobante extends Model
{
    protected $table = 'comprobante';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_empleado','tipo_respaldo','id_factura',
                                'fecha','beneficiario','glosa',
                                'estado_sql'];

    public function getFactura($id_factura){
        $restricciones = ['id_factura' => $id_factura, 'estado_sql'=>1];
        return $this->asArray()
        ->select('factura_venta.*')
        ->where($restricciones)
        ->first();
    }

    public function getById($id){
        $restricciones = ['id' => $id,'estado_sql'=>0];
        return $this->asObject()
        ->where($restricciones)
        ->first();
    }

    public function getVigente($id){
        $restricciones = ['id_empleado' => $id,'estado_sql'=>0];
        return $this->asObject()
        ->where($restricciones)
        ->first();
    }
}