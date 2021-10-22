<?php namespace App\Models;

use CodeIgniter\Model;

class m_transferencia extends Model
{
    protected $table = 'transferencia';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_almacen_destino', 'id_almacen_origen'
                                ,'id_empleado1','id_empleado2','fecha_envio'
                                ,'fecha_recibido'
                                ,'estado_sql'];


    public function getById($id){
        return $this->asObject()
        ->select('transferencia.*')
        ->where('id',$id)
        ->first();
    }

    public function getByDetalle($id_detalle){
        $restriccion = ['detalle_transferencia.id' => $id_detalle, 'detalle_transferencia.estado_sql'=>1];
        return $this->asObject()
        ->select('transferencia.*')
        ->join('detalle_transferencia','detalle_transferencia.id_transferencia = transferencia.id')
        ->where($restrccion)
        ->first();
    }

    public function getFirst($id_empleado){
        return $this->asObject()
        ->where('id_empleado1',$id_empleado)
        ->first();
    }
    public function  getPrimero(){
        return $this->asObject()
        ->first();
    }
   
    public function getByEmpleado($id_almacen_destino){
        $restriccion = ['transferencia.id_almacen_destino'=>$id_almacen_destino, 'transferencia.estado_sql'=>1];
        return $this->asObject()
        ->select('transferencia.*')
        ->where($restriccion)
        ->first();
    }

    public function getByDestino($id_almacen_destino){
        $restriccion = ['id_almacen_destino'=>$id_almacen_destino, 'estado_sql'=>1];
        return $this->asObject()
        ->select('transferencia.*')
        ->where($restriccion)
        ->findAll();
    }

}