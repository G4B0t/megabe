<?php namespace App\Models;

use CodeIgniter\Model;

class m_detalle_comprobante extends Model
{
    protected $table = 'detalle_comprobante';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_comprobante', 'id_cuenta','codigo_cuenta',
                                'debe','haber','estado_sql'];

    public function getByID($id){
        return $this->asObject()
            ->select('detalle_comprobante.*')
            ->where(['id' => $id])
            ->first();
    }

    public function getDetalles($id_comprobante){
        $restricciones = ['detalle_comprobante.id_comprobante' => $id_comprobante,'detalle_comprobante.estado_sql'=>1];
        return $this->asObject()
            ->where($restricciones)
            ->findAll();
    }

    public function getAll(){
        return $this->asObject()
            ->select('detalle_comprobante.*, plan_cuenta.id_cuenta_padre')
            ->join('plan_cuenta','detalle_comprobante.id_cuenta = plan_cuenta.id')
            ->findAll();
    }
}
