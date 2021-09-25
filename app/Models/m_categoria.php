<?php namespace App\Models;

use CodeIgniter\Model;

class m_categoria extends Model
{
    protected $table = 'categoria';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre','descripcion','foto','estado_sql'];

    public function getByID($id = null)
    {
        $condiciones = ['id' => $id,'estado_sql' => '1'];
        return $this->asArray()
            ->select('categoria.*')
            ->where($condiciones)
            ->first();
    }

}