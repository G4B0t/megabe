<?php namespace App\Models;

use CodeIgniter\Model;

class m_proveedor extends Model
{
    protected $table = 'proveedor';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre_empresa', 'id_persona','direccion'
                                ,'contacto','estado_sql'];

    public function getOne($id){
        $condicion = ['id' => $id];
        return $this->asObject()
                ->select('proveedor.*')
                ->where($condicion)
                ->first();
    }

    public function getAll(){
        return $this->asObject()
                ->select('proveedor.*, CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullName')
                ->join('persona','persona.id = proveedor.id_persona')
                ->findAll();
    }

    public function getByItem($id_item){
        $condicion = ['item.id' => $id_item];
        return $this->asObject()
                ->select('proveedor.*,CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullName')
                ->join('persona','persona.id = proveedor.id_persona')
                ->join('item','item.id_proveedor = proveedor.id')
                ->where($condicion)
                ->first();
    }
}
