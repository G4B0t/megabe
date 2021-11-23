<?php namespace App\Models;

use CodeIgniter\Model;

class m_marca extends Model
{
    protected $table = 'marca';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre','descripcion','venta_esperada','id_subcategoria','foto','estado_sql'];

    public function getByID($id = null)
    {
        $condiciones = ['id' => $id,'estado_sql' => '1'];
        return $this->asArray()
            ->select('marca.*')
            ->where($condiciones)
            ->first();
    }

}