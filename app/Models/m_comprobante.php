<?php namespace App\Models;

use CodeIgniter\Model;

class m_comprobante extends Model
{
    protected $table = 'comprobante';
    protected $primaryKey = 'id';
    protected $allowedFields = ['tipo_respaldo','id_factura',
                                'fecha','beneficiario','glosa',
                                'estado_sql'];

    public function getFactura($id_factura){
        $restricciones = ['id_factura' => $id_factura];
        return $this->asArray()
        ->select('factura_venta.*')
        ->where($restricciones)
        ->first();
    }
}