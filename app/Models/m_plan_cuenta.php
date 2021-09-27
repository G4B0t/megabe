<?php namespace App\Models;

use CodeIgniter\Model;

class m_plan_cuenta extends Model
{
    protected $table = 'plan_cuenta';
    protected $primaryKey = 'id';
    protected $allowedFields = ['codigo_cuenta', 'nombre_cuenta','tipo_cuenta',
                                'grupo','id_cuenta_padre','debe','haber',
                                'saldo','estado_sql'];

    public function getBancos(){
        $restricciones = ['grupo'=>'D'];
        $name = ['nombre_cuenta' => 'Banco'];

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
        $restricciones = ['grupo' => 'D','nombre_cuenta'=>'Mercaderia en Almacen'];
        return $this->asArray()
            ->select('plan_cuenta.*')
            ->where($restricciones)
            ->first();
     }
     public function getCajaGeneral(){
        $restricciones = ['grupo' => 'D','nombre_cuenta'=>'Caja General'];
        return $this->asObject()
            ->select('plan_cuenta.*')
            ->where($restricciones)
            ->first();
     }


}
