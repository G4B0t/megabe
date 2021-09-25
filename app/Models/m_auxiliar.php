<?php namespace App\Models;

use CodeIgniter\Model;

class m_auxiliar extends Model
{
    protected $table = 'auxiliar';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre','descripcion','referencia','valor'];

    public function getRestriccionPedido()
    {
       return $this->asArray()
       ->select('auxiliar.*')
       ->where('nombre','Restriccion Pedido')
       ->first();
    }

}