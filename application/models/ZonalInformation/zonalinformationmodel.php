<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class zonalinformationmodel extends CI_Model
{

    protected $table = 'zonalvalue';
    function __construct()
    {
        parent::__construct();
    }


    public function get_count()
    {
        return $this->db->count_all('zonalvalue');
    }

    // Get Pending Zonal Information at CO End
    //Newly Added
    public function get_PendingZonalDetailsCo($select_offset)
    {
        $this->db->select('*');
        $this->db->distinct();
        $this->db->from('dagwise_zone_info');
        $this->db->where('flag', '0');
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        $this->db->limit(500, $select_offset);
        $this->db->order_by("dag_no", "asc");
        return $this->db->get()->result_array();
    }


    public function viewZonalDagWiseCO($start, $length, $order, $search_val, $dist_code, $subdiv_code, $cir_code, $village_code, $flag)
    {
        $searchByCol_1 = $search_val;
        $village_code = $village_code;
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($searchByCol_1)) {
            $this->db->like('dag_no', $searchByCol_1);
        }
        if (!empty($village_code)) {
            $this->db->where('unique_village_code', $village_code);
        }

        $this->db->select('*');
        $this->db->where('flag', $flag);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('dag_no !=', '');
        $this->db->order_by('unique_village_code', 'asc');
        $this->db->limit($length, $start);
        $query = $this->db->get('dagwise_zone_info');
        if ($query->num_rows() > 0) {
            $data['data_results'] = $query->result();
            if (!empty($searchByCol_1)) {
                $this->db->like('dag_no', $searchByCol_1);
            }
            if (!empty($village_code)) {
                $this->db->where('unique_village_code', $village_code);
            }
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('dag_no !=', '');
            $this->db->where('flag', $flag);
            $data['total_records'] = $this->db->count_all_results('dagwise_zone_info');
            return $data;
        }
    }

    //Get Dag Number against the selected village at LM End
    public function getPendingDag($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $select_village)
    {

        // $dagPending = $this->db->query("SELECT dag_no, vill_townprt_code, patta_no, patta_type_code,land_class_code FROM chitha_basic  WHERE dag_no  NOT IN (SELECT dag_no  FROM dagwise_zone_info WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$circle_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_code = '$select_village') AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$circle_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_townprt_code = '$select_village'");



        $dagPending = $this->db->query("SELECT cb.dag_no, cb.vill_townprt_code, cb.patta_no, cb.patta_type_code, cb.land_class_code
            FROM chitha_basic cb
            LEFT JOIN dagwise_zone_info dz
            ON cb.dag_no = dz.dag_no
                AND dz.dist_code = '$dist_code'
                AND dz.subdiv_code = '$subdiv_code'
                AND dz.cir_code = '$circle_code'
                AND dz.mouza_pargona_code = '$mouza_code'
                AND dz.lot_no = '$lot_no'
                AND dz.vill_code = '$select_village'

            WHERE cb.dist_code = '$dist_code'
                AND cb.subdiv_code = '$subdiv_code'
                AND cb.cir_code = '$circle_code'
                AND cb.mouza_pargona_code = '$mouza_code'
                AND cb.lot_no = '$lot_no'
                AND cb.vill_townprt_code = '$select_village'
                AND dz.dag_no IS NULL  AND cb.dag_no  NOT IN (SELECT dag_no  FROM chitha_dag_all_flag_details_final WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$circle_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_townprt_code = '$select_village' AND (is_eroded ='7' OR is_sad ='3'))");

        return $dagPending->result_array();
    }


    // Get Already Filled Dag Number against the selected village by LM
    public function getUpdatedDag($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $select_village)
    {

        $updatedDag = $this->db->query("SELECT chitha_basic.dag_no, chitha_basic.vill_townprt_code, chitha_basic.patta_no,chitha_basic.land_class_code, chitha_basic.patta_type_code, dagwise_zone_info.flag, dagwise_zone_info.subclass_id, dagwise_zone_info.zone_id,dagwise_zone_info.unique_village_code  FROM chitha_basic JOIN dagwise_zone_info ON dagwise_zone_info.dag_no = chitha_basic.dag_no AND dagwise_zone_info.dist_code = chitha_basic.dist_code AND dagwise_zone_info.subdiv_code = chitha_basic.subdiv_code AND dagwise_zone_info.cir_code = chitha_basic.cir_code AND dagwise_zone_info.mouza_pargona_code = chitha_basic.mouza_pargona_code AND dagwise_zone_info.lot_no = chitha_basic.lot_no AND dagwise_zone_info.vill_code = chitha_basic.vill_townprt_code WHERE chitha_basic.dag_no IN (SELECT dag_no  FROM dagwise_zone_info  WHERE flag<'2' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$circle_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_code = '$select_village') AND chitha_basic.dist_code = '$dist_code' AND chitha_basic.subdiv_code = '$subdiv_code' AND chitha_basic.cir_code = '$circle_code' AND chitha_basic.mouza_pargona_code = '$mouza_code' AND chitha_basic.lot_no = '$lot_no' AND chitha_basic.vill_townprt_code = '$select_village'");

        return $updatedDag->result_array();
    }


    // Get Reverted Dag Number against the selected village by LM
    public function getRevertedDag($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $select_village)
    {

        $revertedDag = $this->db->query("SELECT chitha_basic.dag_no, chitha_basic.vill_townprt_code, chitha_basic.patta_no, chitha_basic.land_class_code, chitha_basic.patta_type_code, dagwise_zone_info.flag, dagwise_zone_info.subclass_id, dagwise_zone_info.zone_id, dagwise_zone_info.unique_village_code FROM chitha_basic JOIN dagwise_zone_info ON dagwise_zone_info.dag_no = chitha_basic.dag_no AND dagwise_zone_info.dist_code = chitha_basic.dist_code AND dagwise_zone_info.subdiv_code = chitha_basic.subdiv_code AND dagwise_zone_info.cir_code = chitha_basic.cir_code AND dagwise_zone_info.mouza_pargona_code = chitha_basic.mouza_pargona_code AND dagwise_zone_info.lot_no = chitha_basic.lot_no AND dagwise_zone_info.vill_code = chitha_basic.vill_townprt_code  WHERE chitha_basic.dag_no IN (SELECT dag_no  FROM dagwise_zone_info WHERE flag='2' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$circle_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_code = '$select_village') AND chitha_basic.dist_code = '$dist_code' AND chitha_basic.subdiv_code = '$subdiv_code' AND chitha_basic.cir_code = '$circle_code' AND chitha_basic.mouza_pargona_code = '$mouza_code' AND chitha_basic.lot_no = '$lot_no' AND chitha_basic.vill_townprt_code = '$select_village'");

        return $revertedDag->result_array();
    }



    //Function created for displaying the village name from location Table
    public function getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $select_village)
    {

        $village = $this->db->query("select loc_name AS village from  location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$select_village' and lot_no='$lot_no'");
        return $village->result();
    }

    public function getVillageType($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $select_village)
    {

        $villtype = $this->db->query("select rural_urban AS villtype from  location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$select_village' and lot_no='$lot_no'");
        return $villtype->result();
    }
    // getting unique village id 

    public function getVillageUUID($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $select_village)
    {

        $uniqueVill = $this->db->query("select uuid from  location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and "
            . " vill_townprt_code='$select_village' and lot_no='$lot_no'");
        return $uniqueVill->result();
    }

    public function getPattaType()
    {

        $patta_types = $this->db->query("select type_code,patta_type from patta_code where jamabandi='y'");

        return $patta_types->result();
    }

    //function created for displaying the circle name from Location table
    public function getCircleName($dist_code, $subdiv_code, $circle_code)
    {

        $circle = $this->db->query("select loc_name AS circle from   location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='00' and "
            . " vill_townprt_code='00000' and lot_no='00'");
        return $circle->result();
    }


    // Get the  Distinct Land Subclass Class from subclass_master
    public function getSubclass()
    {

        $this->db->select('subclass_code,subclass_name');
        $this->db->distinct();
        $this->db->from('subclass_master');
        $this->db->order_by("subclass_code", "asc");
        return $this->db->get()->result_array();
    }

    // Get the  Distinct Zone Type against the Dag number from zonal_master Table
    public function getZone()
    {

        $this->db->select('zone_code,zone_name');
        $this->db->distinct();
        $this->db->from('zonal_master');
        $this->db->order_by("zone_code", "asc");
        return $this->db->get()->result_array();
    }

    //update Zonal Detail Status
    public function zonalstatus($data1, $dag_no, $vill_code)
    {

        return $this->db->set($data1)->where('dag_no', $dag_no)->where('vill_code', $vill_code)->update('dagwise_zone_info');
    }
    // Approve/Reject zonal Details By CO
    public function statusCo($data1, $dag_no, $village_uuid)
    {

        $where = array('dag_no' => $dag_no, 'unique_village_code' => $village_uuid);

        return $this->db->set($data1)->where($where)->update('dagwise_zone_info');
    }


    // Delete Dag No from dagwise_zone_info when Rejected by CO
    public function rejectCo($dag_no, $village_uuid)
    {
        $where = array('dag_no' => $dag_no, 'unique_village_code' => $village_uuid);
        return $this->db->where($where)->delete('dagwise_zone_info');
    }

    // ReUpdate zonal Details By LM
    public function reUpdateLM($data1, $dag_no, $village_uuid)
    {

        $where = array('dag_no' => $dag_no, 'unique_village_code' => $village_uuid);
        return $this->db->set($data1)->where($where)->update('dagwise_zone_info');
    }

    public function getAllZonalDetailsDagWise($zonalValueDetailsSearchArr)
    {
        $sql = "select * from dagwise_zone_info where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code = ? and lot_no = ? and vill_code  = ?  and dag_no =?";
        $query = $this->db->query(
            $sql,
            array(
                $zonalValueDetailsSearchArr['dist_code'],
                $zonalValueDetailsSearchArr['subdiv_code'],
                $zonalValueDetailsSearchArr['cir_code'],
                $zonalValueDetailsSearchArr['mouza_pargona_code'],
                $zonalValueDetailsSearchArr['lot_no'],
                $zonalValueDetailsSearchArr['vill_code'],
                $zonalValueDetailsSearchArr['dag_no'],
            )
        );
        $zonal_value_detals = $query->result();
        // $sql = "select * from dagwise_zone_info where dag_no = ?";
        // $query = $this->db->query($sql, array($zonal_value_detals[0]->dag_no));
        return ['zonal_value_detals' => $zonal_value_detals];
    }
    /////////////30-06-22////////////    
    public function getPendingZone($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $select_village, $village_type)
    {

        if ($village_type == 'U') {
            $zonePending = $this->db->query("SELECT zone_code, zone_name FROM zonal_master  WHERE (is_urban = '1' OR is_urban = '2') AND zone_code  NOT IN (SELECT zone_code  FROM villagewise_zone_info WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$circle_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_code = '$select_village')");
        } elseif ($village_type == 'R') {
            $zonePending = $this->db->query("SELECT zone_code, zone_name FROM zonal_master  WHERE (is_urban = '0' OR is_urban = '2') AND zone_code  NOT IN (SELECT zone_code  FROM villagewise_zone_info WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$circle_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_code = '$select_village')");
        } else {
            $zonePending = $this->db->query("SELECT zone_code, zone_name FROM zonal_master  WHERE  zone_code  NOT IN (SELECT zone_code  FROM villagewise_zone_info WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$circle_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_code = '$select_village')");
        }
        return $zonePending->result_array();
    }


    public function getSubclassVillageWise($village_type)
    {
        if ($village_type == 'U') {
            $subclassPending = $this->db->query("SELECT subclass_code, subclass_name FROM subclass_master  WHERE is_urban = '2' OR is_urban = '1'");
        } elseif ($village_type == 'R') {
            $subclassPending = $this->db->query("SELECT subclass_code, subclass_name FROM subclass_master  WHERE is_urban = '0' OR is_urban = '2'");
        } else {
            $subclassPending = $this->db->query("SELECT subclass_code, subclass_name FROM subclass_master ");
        }
        return $subclassPending->result_array();
    }
    public function get_ZoneWisedetails()
    {

        $zoneWiseDetails = $this->db->query("SELECT zone_code,subclass_code,land_rate FROM villagewise_zone_info  WHERE  flag = '0'  GROUP BY zone_code,subclass_code,land_rate");

        return $zoneWiseDetails->result_array();
    }

    // Get VillageWise Pending Zonal Information at CO End
    public function get_VillageWiseZonalDetailsCo($flag)
    {
        $this->db->select('vill_code,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,unique_village_code');
        $this->db->from('villagewise_zone_info');
        $this->db->where('flag', $flag);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        $this->db->group_by('vill_code,dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,unique_village_code');
        $this->db->order_by('vill_code', 'asc');
        return $this->db->get()->result_array();
    }

    public function getZoneName($d)
    {
        $CI = &get_instance();
        $query = "Select zone_name from zonal_master where zone_code='$d'";
        return $CI->db->query($query)->row()->zone_name;
    }
    public function getRevertedZone($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $select_village)
    {
        $this->db->select('zone_code,revert_remarks');
        $this->db->from('villagewise_zone_info');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('vill_code', $select_village);
        $this->db->where('flag', '2');
        $this->db->group_by('zone_code,revert_remarks');
        $this->db->order_by('zone_code', 'asc');
        return $this->db->get()->result_array();
    }


    // Approve/Reject VillageWise zonal Details By CO
    public function villageWiseStatusCo($data1, $where)
    {

        $this->db->set($data1)->where($where)->update('villagewise_zone_info');
        return $this->db->trans_status();
    }

    // Delete VillageWise Zonal Details when Rejected by CO
    public function villageWiseRejectCo($where)
    {
        return $this->db->where($where)->delete('villagewise_zone_info');
    }

    public function getAllzoneDetailsVillageWise($zoneDetailsSearchArr)
    {
        $villagewise_zone_info = $this->db->query("select * from villagewise_zone_info  where unique_village_code = '$zoneDetailsSearchArr' and flag !='3' order by id asc")->result();
        return ['villagewise_zone_info' => $villagewise_zone_info];
    }

    public function getVillageForZonalUpdationJSON($distCode, $subdivcode, $circode, $mouzacode, $lotno)
    {
        $village = $this->db->query("select distinct loc_name,vill_townprt_code from location where "
            . "dist_code =?  and "
            . " subdiv_code=? and cir_code=? and mouza_pargona_code=? and "
            . " vill_townprt_code!='00000' and nc_btad is NULL and lot_no=?", array($distCode, $subdivcode, $circode, $mouzacode, $lotno));

        return $village->result();
    }
    public function getAllZonalDetailsZoneWise($zoneDetailsSearchArr)
    {
        $sql = "select * from villagewise_zone_info where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code = ? and lot_no = ? and vill_code  = ?  and zone_code =?";
        $query = $this->db->query(
            $sql,
            array(
                $zoneDetailsSearchArr['dist_code'],
                $zoneDetailsSearchArr['subdiv_code'],
                $zoneDetailsSearchArr['cir_code'],
                $zoneDetailsSearchArr['mouza_pargona_code'],
                $zoneDetailsSearchArr['lot_no'],
                $zoneDetailsSearchArr['vill_code'],
                $zoneDetailsSearchArr['zone_code']
            )
        );
        $villagewise_zone_info = $query->result();
        return ['villagewise_zone_info' => $villagewise_zone_info];
    }

    // ReUpdate zonal Details By LM
    public function VillageWiseRevert($data1, $vill_code)
    {

        return $this->db->set($data1)->where('unique_village_code', $vill_code)->update('villagewise_zone_info');
    }
    // ==========VillageWise Zonal Update End==========//  
    //get all village uuid------------for search---//
    public function getVillageUUIDList($dist_code, $subdiv_code, $circle_code, $flag)
    {

        $uniqueVill = $this->db->query("select unique_village_code as village_uuid from  dagwise_zone_info where dist_code ='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and flag = '$flag' group by unique_village_code");
        return $uniqueVill->result();
    }

    //end------    


    // update settlement Basic table
    public function updateDagwiiseZoneInfoByCO($dagNo, $vill_uuid, $data)
    {
        $this->db->where('dag_no', $dagNo);
        $this->db->where('unique_village_code', $vill_uuid);
        $this->db->set('modified_at', 'NOW()', FALSE);
        $this->db->update('dagwise_zone_info', $data);
        return $this->db->trans_status();
    }


    // Update Zonal Details Dag CO
    public function updateDagDetailsByCO($updateData, $where)
    {
        return $this->db->set($updateData)->where($where)->update('dagwise_zone_info');
    }





    // /////////////////Get Pending Dag LM ///////////////////


    public function getPendingZonalDagLM($start, $length, $order, $search_val, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code)
    {
        $searchByCol_1 = $search_val;
        $village_code = $village_code;
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($searchByCol_1)) {
            $this->db->like('dag_no', $searchByCol_1);
        }


        // New Test

        $this->db->select('dag_no, vill_townprt_code, patta_no, patta_type_code, land_class_code');
        $this->db->where("dag_no NOT IN (SELECT dag_no FROM dagwise_zone_info WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' AND mouza_pargona_code = '$mouza_pargona_code' AND lot_no = '$lot_no' AND vill_code = '$village_code')");
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('vill_townprt_code', $village_code);
        $this->db->limit($length, $start);
        $query = $this->db->get('chitha_basic');

        if ($query->num_rows() > 0) {
            $data['data_results'] = $query->result();
            if (!empty($searchByCol_1)) {
                $this->db->like('dag_no', $searchByCol_1);
            }
            $this->db->where("dag_no NOT IN (SELECT dag_no FROM dagwise_zone_info WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' AND mouza_pargona_code = '$mouza_pargona_code' AND lot_no = '$lot_no' AND vill_code = '$village_code')");
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('vill_townprt_code', $village_code);
            $data['total_records'] = $this->db->count_all_results('chitha_basic');
            return $data;
        }

        // Test ENd
    }



    public function getUpdatedZonalDagLM($start, $length, $order, $search_val, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code, $flag)
    {
        $searchByCol_1 = $search_val;

        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($searchByCol_1)) {
            $this->db->like('dag_no', $searchByCol_1);
        }


        $this->db->select('*');
        $this->db->where('flag <', $flag);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('vill_code', $village_code);
        $this->db->order_by('dag_no', 'asc');
        $this->db->limit($length, $start);
        $query = $this->db->get('dagwise_zone_info');
        if ($query->num_rows() > 0) {
            $data['data_results'] = $query->result();
            if (!empty($searchByCol_1)) {
                $this->db->like('dag_no', $searchByCol_1);
            }

            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('vill_code', $village_code);
            $this->db->where('flag <', $flag);
            $data['total_records'] = $this->db->count_all_results('dagwise_zone_info');
            return $data;
        }
    }


    // Get Reverted Dag Details atb LM End
    public function getRevertedZonalDagLM($start, $length, $order, $search_val, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $village_code, $flag)
    {
        $searchByCol_1 = $search_val;

        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        if (!empty($searchByCol_1)) {
            $this->db->like('dag_no', $searchByCol_1);
        }


        $this->db->select('*');
        $this->db->where('flag', $flag);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_pargona_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('vill_code', $village_code);
        $this->db->order_by('dag_no', 'asc');
        $this->db->limit($length, $start);
        $query = $this->db->get('dagwise_zone_info');
        if ($query->num_rows() > 0) {
            $data['data_results'] = $query->result();
            if (!empty($searchByCol_1)) {
                $this->db->like('dag_no', $searchByCol_1);
            }

            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('mouza_pargona_code', $mouza_pargona_code);
            $this->db->where('lot_no', $lot_no);
            $this->db->where('vill_code', $village_code);
            $this->db->where('flag', $flag);
            $data['total_records'] = $this->db->count_all_results('dagwise_zone_info');
            return $data;
        }
    }


    public function getVillagebyCircle($dist_code, $subdiv_code, $circle_code)
    {

        $uniqueVill = $this->db->query("select * from  location where dist_code ='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code!='00' and lot_no!='00' and vill_townprt_code!='00000' ");
        return $uniqueVill->result_array();
    }

    public function getVillagebyLot($dist_code, $subdiv_code, $circle_code, $mouza_pargona_code, $lot_no)
    {

        $uniqueVill = $this->db->query("select loc_name,uuid from  location where dist_code ='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code!='00000' ");
        return $uniqueVill->result_array();
    }


    public function getZonalValueDetails($village_uuid, $zone_id, $subclass_id)
    {
        $zonalValue = $this->db->select('*')
            ->where('unique_village_code', $village_uuid)
            ->where('zone_code', $zone_id)
            ->where('subclass_code', $subclass_id)
            ->get('villagewise_zone_info');

        return $zonalValue->result();
    }


    public function getZoneSubclassDetails($dag_no, $village_uuid)
    {

        $zoneDetails = $this->db->query("select zone_id,subclass_id,flag from  dagwise_zone_info where dag_no = '$dag_no' and  unique_village_code = '$village_uuid' ");
        return $zoneDetails->row();
    }



    public function bulkRejectDagwiseCO($dagNo, $vill_uuid)
    {
        $this->db->where('dag_no', $dagNo);
        $this->db->where('unique_village_code', $vill_uuid);
        $this->db->delete('dagwise_zone_info');
        return $this->db->trans_status();
    }







    public function viewZonalDetailsADC($start, $length, $order, $dist_code, $village_code, $flag)
    {
        // $searchByCol_1 = $search_val;
        $village_code = $village_code;
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        if (!empty($village_code)) {
            $this->db->where('unique_village_code', $village_code);
        }

        $this->db->select('*');
        $this->db->where('flag', $flag);
        $this->db->where('dist_code', $dist_code);
        $this->db->order_by('unique_village_code', 'asc');
        $this->db->limit($length, $start);
        $query = $this->db->get('villagewise_zone_info');
        if ($query->num_rows() > 0) {
            $data['data_results'] = $query->result();
            if (!empty($village_code)) {
                $this->db->where('unique_village_code', $village_code);
            }
            $this->db->where('dist_code', $dist_code);
            $this->db->where('flag', $flag);
            $data['total_records'] = $this->db->count_all_results('villagewise_zone_info');
            return $data;
        }
    }



    public function getAdcVillageUUIDList($dist_code, $flag)
    {

        $uniqueVill = $this->db->query("select distinct cir_code,lot_no, unique_village_code  from  villagewise_zone_info where dist_code ='$dist_code' and flag = '$flag'");
        return $uniqueVill->result_array();
    }


    // Approve/Revert VillageWise zonal Details By CO
    public function villageWiseStatusADC($data1, $where)
    {

        $this->db->set($data1)->where($where)->update('villagewise_zone_info');
        return $this->db->trans_status();
    }



    public function getPendingZoneDetailsVillageWise($zoneDetailsSearchArr)
    {
        $villagewise_zone_info = $this->db->query("select * from villagewise_zone_info  where unique_village_code = '$zoneDetailsSearchArr' and flag ='0' order by id asc")->result();
        return ['villagewise_zone_info' => $villagewise_zone_info];
    }


    public function getRevertedZoneDetailsVillageWise($zoneDetailsSearchArr)
    {
        $villagewise_zone_info = $this->db->query("select * from villagewise_zone_info  where unique_village_code = '$zoneDetailsSearchArr' and flag ='2' order by id asc")->result();
        return ['villagewise_zone_info' => $villagewise_zone_info];
    }


    public function getAdcZoneList($adcPending)
    {

        $uniqueZone = $this->db->query("select distinct zone_code,zone_name  from  villagewise_zone_info where flag ='$adcPending'");
        return $uniqueZone->result_array();
    }

    public function viewZonalDetailsUploadReportADC($start, $length, $order, $dist_code)
    {
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        $this->db->select('*');
        $this->db->where_in('is_active', ['E', 'A', 'R']);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code !=', '00');
        $this->db->where('cir_code !=', '00');
        $this->db->where('report_by', 'CO');
        $this->db->order_by('cir_code', 'asc');
        $this->db->limit($length, $start);
        $query = $this->db->get('uploaded_report');
        if ($query->num_rows() > 0) {
            $data['data_results'] = $query->result();
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code !=', '00');
            $this->db->where('cir_code !=', '00');
            $this->db->where_in('is_active', ['E', 'A', 'R']);
            $this->db->where('report_by', 'CO');
            $data['total_records'] = $this->db->count_all_results('uploaded_report');
            return $data;
        }
    }


    public function viewZonalDetailsUploadReportDC($start, $length, $order, $dist_code)
    {
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        $this->db->select('*');
        $this->db->where_in('is_active', ['E', 'A', 'R']);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code =', '00');
        $this->db->where('cir_code =', '00');
        $this->db->where('report_by', 'ADC');
        $this->db->order_by('cir_code', 'asc');
        $this->db->limit($length, $start);
        $query = $this->db->get('uploaded_report');
        if ($query->num_rows() > 0) {
            $data['data_results'] = $query->result();
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code =', '00');
            $this->db->where('cir_code =', '00');
            $this->db->where_in('is_active', ['E', 'A', 'R']);
            $this->db->where('report_by', 'ADC');
            $data['total_records'] = $this->db->count_all_results('uploaded_report');
            return $data;
        }
    }




    public function viewZonalDetailsUploadReportCO($start, $length, $order, $dist_code, $subdiv_code, $cir_code)
    {
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        $this->db->select('*');
        $this->db->where_in('is_active', ['E', 'A', 'R']);
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('report_by', 'LM');
        $this->db->order_by('lot_no', 'asc');
        $this->db->limit($length, $start);
        $query = $this->db->get('uploaded_report');
        if ($query->num_rows() > 0) {
            $data['data_results'] = $query->result();
            $this->db->where('dist_code', $dist_code);
            $this->db->where('subdiv_code', $subdiv_code);
            $this->db->where('cir_code', $cir_code);
            $this->db->where('report_by', 'LM');
            $this->db->where_in('is_active', ['E', 'A', 'R']);
            $data['total_records'] = $this->db->count_all_results('uploaded_report');
            return $data;
        }
    }


    public function getAllMissingZoneSubclassVillageWise($zoneDetailsSearchArr)
    {
        $sql = "SELECT a.zone_code, b.subclass_code, a.zone_name, b.subclass_name FROM zonal_master a CROSS JOIN subclass_master b except (select zone_code, subclass_code, zone_name, subclass_name from villagewise_zone_info where unique_village_code = '$zoneDetailsSearchArr')";
        $villagewise_zone_info = $this->db->query($sql)->result();
        return ['villagewise_zone_info' => $villagewise_zone_info];
    }



    public function addMissingZonalSubclass($insertion_data_for_missing_details_arr)
    {
        //insertion of villagewise_zone_info  details
        foreach ($insertion_data_for_missing_details_arr as $insertion_data) {
            $tstatus2 = $this->db->insert('villagewise_zone_info', $insertion_data);
            if (
                $tstatus2 != 1
            ) {
                log_message("error", "#LSU002, Error in insert, table 'villagewise_zone_info' with data :");
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LSU002'];
            }
        }
    }


    public function getCircleNameList($dist_code, $flag)
    {
        $this->db->select('subdiv_code, cir_code');
        $this->db->from('villagewise_zone_info');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('flag', $flag);
        $this->db->group_by('subdiv_code, cir_code');
        $data = $this->db->get();
        return $data;
    }


    public function getMouzaNameList($dist_code, $flag)
    {
        $sql = "select subdiv_code, cir_code,mouza_pargona_code from villagewise_zone_info
                    where dist_code ='$dist_code' and flag ='$flag' group by(subdiv_code, cir_code,mouza_pargona_code)";
        $villagewise_zone_info = $this->db->query($sql);
        return $villagewise_zone_info;
    }


    public function getZonalDetailsRevertedByAdc($zoneDetailsSearchArr)
    {
        $villagewise_zone_info = $this->db->query("select * from villagewise_zone_info  where unique_village_code = '$zoneDetailsSearchArr' and flag ='4' order by id asc")->result();
        return ['villagewise_zone_info' => $villagewise_zone_info];
    }


    public function updateZonalValueAdc($updateData, $where)
    {

        $this->db->set($updateData)->where($where)->update('villagewise_zone_info');
        return $this->db->trans_status();
    }


    public function uploadedZonalReportDetailsByCo($dist_code)
    {

        // $query = $this->db->query("select * from uploaded_report  where dist_code = '$dist_code' and subdiv_code !='00' and cir_code !='00'   and  is_active in ('E','A','R') and uploaded_subdiv_adc is null and uploaded_circle_adc is null")->result();
        // $query = $this->db->query("select distinct(dist_code,subdiv_code,cir_code,date_upload,report_by,report_name) from uploaded_report  where dist_code = '$dist_code' and subdiv_code !='00' and cir_code !='00'   and  is_active in ('E','A','R') and uploaded_subdiv_adc is null and uploaded_circle_adc is null and report_by ='CO'")->result();
        $query = $this->db->query("select dist_code,subdiv_code,cir_code,date_upload,report_by,report_name from uploaded_report  where dist_code = '$dist_code' and subdiv_code !='00' and cir_code !='00'   and  is_active in ('E','A','R') and uploaded_subdiv_adc is null and uploaded_circle_adc is null and report_by ='CO' group by dist_code,subdiv_code,cir_code,date_upload,report_by,report_name")->result();

        return $query;
    }

    public function uploadedZonalReportDetailsByADC($subdiv_code_co, $cir_code_co)
    {

        $query = $this->db->query("select * from uploaded_report  where uploaded_subdiv_adc = '$subdiv_code_co' and  uploaded_circle_adc = '$cir_code_co'");
        return $query;
    }
}
