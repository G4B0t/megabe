<?php namespace App\Models;

use CodeIgniter\Model;

class m_cliente extends Model
{
    protected $table = 'cliente';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nit', 'id_persona','razon_social'
                                ,'usuario','email','contrasena','estado_sql'];

    function getAll(){
        return $this->asArray()
        ->select('cliente.*,CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullName')
        ->join('persona','persona.id = cliente.id_persona')
        ->findAll();
    }

    function getTodos(){
        return $this->asObject()
        ->select('cliente.id, cliente.id_persona,CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullName')
        ->join('persona','persona.id = cliente.id_persona')
        ->findAll();
    }

    function getOne($id){
        return $this->asObject()
        ->select('cliente.*, CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullName')
        ->join('persona','persona.id = cliente.id_persona')
        ->where('cliente.id',$id)
        ->first();
    }

    function getCliente($id){
        return $this->asArray()
        ->select('cliente.*, CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullName')
        ->join('persona','persona.id = cliente.id_persona')
        ->where('cliente.id',$id)
        ->first();
    }

}
