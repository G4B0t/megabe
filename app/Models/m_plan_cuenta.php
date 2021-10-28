<?php namespace App\Models;

use CodeIgniter\Model;

class m_plan_cuenta extends Model
{
    protected $table = 'plan_cuenta';
    protected $primaryKey = 'id';
    protected $allowedFields = ['codigo_cuenta', 'nombre_cuenta','tipo_cuenta',
                                'grupo','id_cuenta_padre','debe','haber',
                                'saldo','estado_sql'];


    public function getCajas(){
        $restricciones = ['grupo'=>'D'];
        $name = ['nombre_cuenta' => 'CAJA'];

        return $this->asObject()
            ->select('plan_cuenta.*')
            ->where($restricciones)
            ->like($name)
            ->whereNotIn('plan_cuenta.nombre_cuenta',['CAJA 1 CENTRAL'])
            ->findAll();
     }
                            
    public function getBancos(){
        $restricciones = ['grupo'=>'D'];
        $name = ['nombre_cuenta' => 'BANCO'];

        return $this->asObject()
            ->select('plan_cuenta.*')
            ->where($restricciones)
            ->like($name)
            ->findAll();
     }

     public function getCaja($caja){
        $restricciones = ['grupo'=>'D','nombre_cuenta' => $caja];

        return $this->asObject()
            ->select('plan_cuenta.*')
            ->where($restricciones)
            ->first();
     }

     public function getOne($id_cuenta){

        $restricciones = ['id' => $id_cuenta];
        return $this->asArray()
            ->select('plan_cuenta.*')
            ->where($restricciones)
            ->first();
     }

     public function getHaber(){
        $restricciones = ['grupo' => 'D','nombre_cuenta'=>'VENTAS'];
        return $this->asArray()
            ->select('plan_cuenta.*')
            ->where($restricciones)
            ->first();
     }
     public function getCajaGeneral(){
        $restricciones = ['grupo' => 'D','nombre_cuenta'=>'CAJA 1 CENTRAl'];
        return $this->asObject()
            ->select('plan_cuenta.*')
            ->where($restricciones)
            ->first();
     }

     public function getCuentas(){
        $restricciones = ['grupo' => 'D'];
        return $this->asObject()
            ->select('plan_cuenta.*')
            ->where($restricciones)
            ->findAll();
     }

     public function getByID( $id_cuenta){
        $restricciones = ['id' => $id_cuenta];
        return $this->asObject()
            ->select('plan_cuenta.*')
            ->where($restricciones)
            ->first();
     }

     public function getAll(){
        return $this->asObject()
        ->findAll();
     }


}
