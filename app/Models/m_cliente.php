<?php namespace App\Models;

use CodeIgniter\Model;

class m_cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nit', 'id_persona','razon_social'
                                ,'usuario','contrasena','estado_sql'];

    function getAll(){
        return $this->asArray()
        ->select('cliente.*, persona.nombre as cliente')
        ->join('persona','persona.id = cliente.id_persona')
        ->findAll();
    }

    function getCliente($id){
        return $this->asArray()
        ->select('persona.id ')
        ->join('persona','persona.id = cliente.id_persona')
        ->where('cliente.id',$id)
        ->first();
    }
}
