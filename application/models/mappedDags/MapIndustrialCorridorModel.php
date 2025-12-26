<?php
class MapIndustrialCorridorModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();

    }


    // check mapped location
    public function checkMappedLocation($d,$s,$c,$m,$l,$v)
    {
        return $this->db->select()
            ->where('dist_code', $d)
            ->where('subdiv_code', $s)
            ->where('cir_code', $c)
            ->where('mouza_pargona_code', $m)
            ->where('lot_no', $l)
            ->where('vill_townprt_code', $v)
            ->get('mapping_of_industrial_corridor')
            ->num_rows();
    }

    // get mapped location details
    public function getMappedLocation($d,$s,$c,$m,$l,$v)
    {
        return $this->db->select()
            ->where('dist_code', $d)
            ->where('subdiv_code', $s)
            ->where('cir_code', $c)
            ->where('mouza_pargona_code', $m)
            ->where('lot_no', $l)
            ->where('vill_townprt_code', $v)
            ->get('mapping_of_industrial_corridor')
            ->row();
    }


    // check mapped Dags
    public function checkMappedDags($mappedId,$dagNo,$dagNoInt)
    {
        return $this->db->select()
            ->where('mapped_id', $mappedId)
            ->where('dag_no', $dagNo)
            ->where('dag_no_int', $dagNoInt)
            ->get('mapping_of_industrial_corridor_dags')
            ->num_rows();
    }



    // count mapped location by co
    public function countMappedLocationByCo($d,$s,$c,$user_code)
    {
        return $this->db->select()
            ->where('dist_code', $d)
            ->where('subdiv_code', $s)
            ->where('cir_code', $c)
            ->where('u_code', $user_code)
            ->get('mapping_of_industrial_corridor')
            ->num_rows();
    }


    // get mapped location list by co
    public function getMappedLocationByCo($d,$s,$c,$user_code)
    {
        return $this->db->select()
            ->where('dist_code', $d)
            ->where('subdiv_code', $s)
            ->where('cir_code', $c)
            ->where('u_code', $user_code)
            ->get('mapping_of_industrial_corridor')
            ->result();
    }


    // count mapped location details by co
    public function countMappedLocationDetailsById($mId,$d,$s,$c,$user_code)
    {
        return $this->db->select()
            ->where('id', $mId)
            ->where('dist_code', $d)
            ->where('subdiv_code', $s)
            ->where('cir_code', $c)
            ->where('u_code', $user_code)
            ->get('mapping_of_industrial_corridor')
            ->num_rows();
    }


    // get mapped location details by co
    public function getMappedLocationDetailsById($mId,$d,$s,$c,$user_code)
    {
        return $this->db->select()
            ->where('id', $mId)
            ->where('dist_code', $d)
            ->where('subdiv_code', $s)
            ->where('cir_code', $c)
            ->where('u_code', $user_code)
            ->get('mapping_of_industrial_corridor')
            ->row();
    }


    // get mapped location details by co
    public function getMappedLocationDetailsByIdOnly($mId)
    {
        return $this->db->select()
            ->where('id', $mId)
            ->get('mapping_of_industrial_corridor')
            ->row();
    }

    // count mapped location details by co
    public function countMappedLocationDetailsByIdOnly($mId)
    {
        return $this->db->select()
            ->where('id', $mId)
            ->get('mapping_of_industrial_corridor')
            ->num_rows();
    }


    // get mapped location list by co
    public function getMappedDagsListByLocationId($mId)
    {
        return $this->db->select()
            ->where('mapped_id', $mId)
            ->where('status', 1)
            ->get('mapping_of_industrial_corridor_dags')
            ->result();
    }




}