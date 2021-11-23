<?php namespace App\Models;

use CodeIgniter\Model;

class m_subcategoria extends Model
{
    protected $table = 'subcategoria';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre','descripcion','foto','venta_esperada','id_categoria','estado_sql'];

    public function getByID($id = null)
    {
        $condiciones = ['id' => $id,'estado_sql' => '1'];
        return $this->asArray()
            ->select('subcategoria.*')
            ->where($condiciones)
            ->first();
    }
}
