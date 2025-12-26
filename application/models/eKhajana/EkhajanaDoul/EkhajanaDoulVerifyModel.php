<?php
class EkhajanaDoulVerifyModel extends CI_Model {

    public function getMouzadarDoulVerifyReport($dist_code,$subdiv_code,$cir_code)
    {
        $query = $this->db->query("select * from ekhajana_mouzadar_doul_verification where dist_code=? and subdiv_code=? and cir_code=? and co_remarks is null",array($dist_code,$subdiv_code,$cir_code));
        if($query->num_rows() == 0)
        {
            return [];
        }else{
            return $query->result();
        }
    }


}
?>

