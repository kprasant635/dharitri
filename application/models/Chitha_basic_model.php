<?php
class Chitha_basic_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }
    // public function get_chitha_basic($dag_no_int)
    // {
    //     return $this->db->get_where('chitha_basic', array('dag_no_int' => $dag_no_int))->row_array();
    // }
    // public function get_all_chitha_basic()
    // {
    //     $this->db->order_by('dag_no_int', 'desc');
    //     return $this->db->get('chitha_basic')->result_array();
    // }
    public function add_dag_pattadar($params)
    {
        // $this->session->set_userdata('dagpattadar',$params);
        if (!$this->session->userdata('dagpattadar')) {
            $this->session->set_userdata('dagpattadar', array());
            $dagpattadar = $this->session->userdata('dagpattadar');
            $dagpattadar[] = $params;
            $this->session->set_userdata('dagpattadar', $dagpattadar);
        } else {
            $dagpattadar = $this->session->userdata('dagpattadar');
            $dagpattadar[] = $params;
            $this->session->set_userdata('dagpattadar', $dagpattadar);
        }

    }
    public function add_chitha_pattadar($params)
    {
        if (!$this->session->userdata('pattadar')) {
            $this->session->set_userdata('pattadar', array());
            $pattadar = $this->session->userdata('pattadar');
            $pattadar[] = $params;
            $this->session->set_userdata('pattadar', $pattadar);
        } else {
            $pattadar = $this->session->userdata('pattadar');
            $pattadar[] = $params;
            $this->session->set_userdata('pattadar', $pattadar);
        }
    }
    // public function update_chitha_basic($dag_no_int, $params)
    // {
    //     $this->db->where('dag_no_int', $dag_no_int);
    //     return $this->db->update('chitha_basic', $params);
    // }
    public function insert_table($table, $params)
    {
        if ($table == 'chitha_basic') {
            if(!in_array($params['patta_type_code'],['1001','2001','0213','0209'])){
                if (empty($params['dag_local_tax']) || empty($params['dag_revenue'])) {
                    return 0;
                }
                if(empty($params['patta_no'])){
                    return 0;
                }
            }
            if (empty($params['land_class_code']) || empty($params['patta_type_code'])) {
                return 0;
            }
        }
        $this->db->insert($table, $params);
        //echo $this->db->last_query();
        // echo "<br>";
        // if($table == 'chitha_rmk_ordbasic')
        if ($this->db->affected_rows() >= 1) {
            // return 1;
            return $this->db->affected_rows();
        } else {
            log_message('error',"INSERTT-".$table."#######".$this->db->last_query());
            return 0;
        }
    }
    public function update_table($table, $params, $where)
    {
        if ($table == 'chitha_basic') {
            $sqlPattaTypeAllowed = "SELECT type_code FROM patta_code WHERE jamabandi='n'";
            $patta_array         = array_column(
                $this->db->query($sqlPattaTypeAllowed)->result_array(),
                'type_code'
            );
            // var_dump($params);die;

            if (
                isset($params['patta_type_code']) &&
                !in_array($params['patta_type_code'], $patta_array)
            ) {
                if (
                    (isset($params['dag_local_tax'], $params['dag_revenue']) &&
                    (empty($params['dag_local_tax']) || empty($params['dag_revenue'])))
                    || (isset($params['patta_no']) && empty($params['patta_no']))
                ) {
                    return 0;
                }
            }

            if ((isset($params['land_class_code']) && empty($params['land_class_code']))) {
                    // echo "EMPTY";
                    return 0;
            }

        }
        if (isset($where['patta_no'])) {
            $pattaNo = trim($where['patta_no']);
            $this->db->where("TRIM(patta_no) = " . $this->db->escape($pattaNo), null, false);
            unset($where['patta_no']);
        }
        $this->db->where($where);
        $this->db->update($table, $params);
        // echo $this->db->last_query();
        // if($table == 'chitha_rmk_ordbasic')
        if ($this->db->affected_rows() >= 1) {
            // return 1;
            return $this->db->affected_rows();
        } else {
            log_message('error',"UPDATEE-".$table."#######".$this->db->last_query());
            return 0;
        }
    }
    // public function update_table($table, $params, $where)
    // {
    //     if ($table == 'chitha_basic') {
    //         $sqlPattaTypeAllowed = "SELECT type_code FROM patta_code WHERE jamabandi='n'";
    //         $patta_array         = array_column(
    //             $this->db->query($sqlPattaTypeAllowed)->result_array(),
    //             'type_code'
    //         );
    //         // var_dump($params);die;

    //         if (
    //             isset($params['patta_type_code']) &&
    //             !in_array($params['patta_type_code'], $patta_array)
    //         ) {
    //             if (
    //                 (isset($params['dag_local_tax'], $params['dag_revenue']) &&
    //                 (empty($params['dag_local_tax']) || empty($params['dag_revenue'])))
    //                 || (isset($params['patta_no']) && empty($params['patta_no']))
    //             ) {
    //                 return 0;
    //             }
    //         }

    //         if ((isset($params['land_class_code']) && empty($params['land_class_code']))) {
    //                 // echo "EMPTY";
    //                 return 0;
    //         }

    //     }
    //     if (isset($where['patta_no'])) {
    //         $pattaNo = trim($where['patta_no']);
    //         $this->db->where("TRIM(patta_no) = " . $this->db->escape($pattaNo), null, false);
    //         unset($where['patta_no']);
    //     }
    //     $this->db->where($where);
    //     $this->db->update($table, $params);
    //     // echo $this->db->last_query();
    //     // if($table == 'chitha_rmk_ordbasic')
    //     if ($this->db->affected_rows() >= 1) {
    //         // return 1;
    //         return $this->db->affected_rows();
    //     } else {
    //         log_message('error',"UPDATEE-".$table."#######".$this->db->last_query());
    //         return 0;
    //     }
    // }
    public function maxpdarIdCheck($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,$patta_no)
    {

      $pattadars_in_chitha_pattadar = $pattadars_in_jama_pattadar = $pattadars_in_chithaDag_pattadar = 0;
      $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where
              dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and  patta_type_code=? and TRIM(patta_no)::varchar=trim(?)",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,(string)$patta_no));
      // echo $this->db->last_query();
      if($pattadars_in_chitha_pattadar->num_rows()>0){
          $pattadars_in_chitha_pattadar=$pattadars_in_chitha_pattadar->row()->cp;
      }
      $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and TRIM(patta_no)=trim(?)",array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code,(string)$patta_no));
      if($pattadars_in_jama_pattadar->num_rows()>0){
          $pattadars_in_jama_pattadar=$pattadars_in_jama_pattadar->row()->jp;
      }
      // echo $this->db->last_query();
      $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and  TRIM(patta_no)=trim(?)", array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$patta_type_code, (string) $patta_no));
      if ($pattadars_in_chithaDag_pattadar->num_rows() > 0) {
          $pattadars_in_chithaDag_pattadar = $pattadars_in_chithaDag_pattadar->row()->dp;
      }
      // echo $this->db->last_query();
      // log_message('error', "###############" . $this->db->last_query());
      if ($pattadars_in_chitha_pattadar > $pattadars_in_jama_pattadar) {
          if ($pattadars_in_chithaDag_pattadar > $pattadars_in_chitha_pattadar) {
              $pdar_id = $pattadars_in_chithaDag_pattadar;
          } else {
              $pdar_id = $pattadars_in_chitha_pattadar;
          }
      } elseif ($pattadars_in_chithaDag_pattadar > $pattadars_in_jama_pattadar) {
          $pdar_id = $pattadars_in_chithaDag_pattadar;
      } else {
          $pdar_id = $pattadars_in_jama_pattadar;
      }
      if ($pdar_id == null) {
          $pdar_id = 1;
      }
      return $pdar_id;
    }
}
