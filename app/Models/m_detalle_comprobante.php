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
            ->where(['id' => $id])
            ->first();
    }

}
