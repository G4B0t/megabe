<?php namespace App\Models;

use CodeIgniter\Model;

class m_anulacion extends Model
{
    protected $table = 'anulacion';
    protected $primaryKey = 'id';
    protected $allowedFields = ['motivo','id_factura','estado_sql','fecha'];

    public function getAll()
    {
       return $this->Object()
       ->select('anulacion.*,factura_venta.total')
       ->join('factura_venta','anulacion.id_factura = factura_venta.id')
       ->where('anulacion.estado_sql',1)
       ->findAll();
    }

}