<?php namespace App\Models;

use CodeIgniter\Model;

class m_persona extends Model
{
    protected $table = 'persona';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nombre','apellido_paterno','apellido_materno','nro_ci','direccion_particular','direccion_trabajo','telefono_particular','telefono_trabajo',
                                'zona_vivienda','latitud_vivienda','longitud_vivienda','celular1','celular2','lugar_residencia','ocupacion','foto','estado_sql'];

    function getAll(){
        return $this->asObject()
        ->select('persona.*,CONCAT(persona.nombre, " ", persona.apellido_paterno) AS fullName')
        ->findAll();
    }

    function getPersona($id){
        return $this->asArray()
        ->select('persona.*')
        ->join('cliente','persona.id = cliente.id_persona')
        ->where('cliente.id',$id)
        ->first();
    }

    function getCliente($id_persona){
        $condiciones=['cliente.id_persona' => $id_persona];
        return $this->asArray()
        ->select('cliente.*')
        ->join('cliente','persona.id = cliente.id_persona')
        ->where($condiciones)
        ->first();
    }

    function getEmpleado($id_persona){
        $condiciones=['empleado.id_persona' => $id_persona];
        return $this->asArray()
        ->select('empleado.*')
        ->join('empleado','persona.id = empleado.id_persona')
        ->where($condiciones)
        ->first();
    }

}
