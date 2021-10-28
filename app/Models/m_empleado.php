<?php namespace App\Models;

use CodeIgniter\Model;

class m_empleado extends Model
{
    protected $table = 'empleado';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_persona','id_almacen',
                                'usuario','contrasena','email','caja',
                                'fecha_ingreso','estado_sql'];

    public function getAll(){
        return $this->asArray()
        ->select('empleado.*,persona.nombre as trabajador')
        ->join('persona','persona.id = empleado.id_persona')
        ->first();
    }

    public function getOne($id){

        return $this->asArray()
        ->select('empleado.*')
        ->where('id',$id)
        ->first();
    }
    
    public function getCajeroGeneral(){
        return $this->asObject()
        ->select('empleado.*,CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullname')
        ->join('persona','empleado.id_persona=persona.id')
        ->where('caja','Caja General')
        ->first();
    }

    public function getContador($id){

        return $this->asObject()
        ->select('empleado.*,CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullname')
        ->join('persona','empleado.id_persona=persona.id')
        ->where('empleado.id',$id)
        ->first();
    }

    public function getAlmacenCental($id_empleado){
        $restriccion = ['empleado.caja'=>'Central', 'empleado.id'=>$id_empleado];
        return $this->asObject()
        ->select('empleado.*,CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullname')
        ->join('persona','empleado.id_persona=persona.id')
        ->where($restriccion)
        ->first();
    }

    public function getAlmacen($id_persona){
        $restriccion = ['empleado.id_persona'=>$id_persona];
        return $this->asObject()
        ->select('empleado.id,empleado.id_almacen,almacen.direccion')
        ->join('almacen','almacen.id=empleado.id_almacen')
        ->where($restriccion)
        ->first();
    }

    function getFullEmpleado($id){
        return $this->asObject()
        ->select('empleado.*, CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullName,persona.foto')
        ->join('persona','persona.id = empleado.id_persona')
        ->where('empleado.id',$id)
        ->first();
    }
}
