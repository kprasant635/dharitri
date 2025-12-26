<?php

class DataTable_Model extends CI_Model 
{
    
    public function get_Omut($start, $length, $order, $dir, $clause) 
    {
        $db=  $this->session->userdata('db');
		if($order !=null) {
            $this->db->order_by($order, $dir);
        }
        return $this->db
            ->where($clause)
            ->limit($length,$start)
            ->get(" petition_basic");
    }

    public function get_total_Omut($clause) 
    {
		$db=  $this->session->userdata('db');
        $query = $this->db->select("COUNT(*) as num")->where($clause)->get(" petition_basic");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
    }

    public function get_Cert_Application($start, $length, $order, $dir, $clause) 
    {
        $db=  $this->session->userdata('db');
		if($order !=null) {
            $this->db->order_by($order, $dir);
        }
        return $this->db
            ->where($clause)
            ->limit($length,$start)
            ->get(" cert_application");
    }

    public function get_total_Cert_Application($clause) 
    {
        $db=  $this->session->userdata('db');
		$query = $this->db->select("COUNT(*) as num")->where($clause)->get(" cert_application");
        $result = $query->row();
        if(isset($result)) return $result->num;
        return 0;
    }

}

?>