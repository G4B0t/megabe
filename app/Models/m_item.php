<?php namespace App\Models;

use CodeIgniter\Model;

class m_item extends Model
{
    protected $table = 'item';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre', 'descripcion','id_subcategoria','codigo',
                                'fecha_expiracion','stock','precio_unitario',
                                'marca','foto','estado_sql'];

   public function getByID($id = null)
    {
        if ($id === null) {
            return $this->findAll();
        }

        return $this->asArray()
            ->where(['id' => $id])
            ->first();
    }

    public function getOne($id = null)
    {
        if ($id === null) {
            return $this->findAll();
        }

        return $this->asObject()
            ->where(['id' => $id])
            ->first();
    }

}
