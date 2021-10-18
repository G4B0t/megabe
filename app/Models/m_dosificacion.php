<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class m_dosificacion extends CI_Model {


function getPaged($page, $rows, $nro_autorizacion,$nro_factura,$llave,$leyenda,$fecha_limite_emision,$fecha_activacion, $activo, $estado_sql, $sortBy, $sortDirection) 
    {
        $offset = ($page-1)*$rows;
        $result = array();
        
        $total = $this->db->query("SELECT count(*) as count from dosificacion where nro_autorizacion like '%$nro_autorizacion%' and nro_factura like '%$nro_factura%' and llave like '%$llave%' and leyenda like '%$leyenda%' '$fecha_limite_emision' '$fecha_activacion%' and activa like '%$activo' and estado_sql = 1")->row()->count;
        

        $result['Total'] = $total;

        $data = $this->db->query(
            "SELECT * from dosificacion where nro_autorizacion like '%$nro_autorizacion%' and nro_factura like '%$nro_factura%' and llave like '%$llave%' and leyenda like '%$leyenda%' '$fecha_limite_emision' '$fecha_activacion' and activa like '%$activo' and estado_sql = 1 order by $sortBy $sortDirection limit $offset, $rows"
        )->result_array();
        
        $result['List'] = $data;

        return $result;
    }
    function add($data)
    {   
        $this->db->query("UPDATE dosificacion SET activa = 0 where activa = 1");
        $this->db->query("INSERT INTO dosificacion (nro_autorizacion, nro_factura, llave, leyenda, fecha_limite_emision, fecha_activacion, activa, estado_sql) VALUES ($data[nro_autorizacion], $data[nro_factura], '$data[llave]', '$data[leyenda]', '$data[fecha_limite_emision]', NOW(), $data[activa], 1)");
        return $this->db->affected_rows() > 0;
    }
    function upd($data, $id)
    {
        return $this->db->update('dosificacion', $data, array('id' => $id));

    }

}