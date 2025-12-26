<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class LandShareModel extends CI_Model
{

    // Get cities
    function getCity()
    {

        $response = array();

        // Select record
        $this->db->select('*');
        $q = $this->db->get('city');
        $response = $q->result_array();

        return $response;
    }

    public function getVillageForZonalUpdationJSON($distCode, $subdivcode, $circode, $mouzacode, $lotno)
    {
        $village = $this->db->query("select distinct loc_name,vill_townprt_code from location where "
        . "dist_code =?  and "
        . " subdiv_code=? and cir_code=? and mouza_pargona_code=? and "
        . " vill_townprt_code!='00000' and lot_no=?", array($distCode, $subdivcode, $circode, $mouzacode, $lotno));

        return $village->result();
    }

    //Get Dag Number against the selected village at LM End

    public function getPendingLandShareDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $select_village)
    {
        $dagPending = $this->db->query("SELECT dag_no, vill_townprt_code, dag_area_b, dag_area_k, dag_area_lc, patta_no, patta_type_code FROM chitha_basic WHERE patta_no !='0' AND patta_no !='00' AND dag_no  NOT IN (SELECT dag_no  FROM land_share_details WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$circle_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_townprt_code = '$select_village') AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$circle_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_townprt_code = '$select_village' ORDER BY dag_no ASC");

        return $dagPending->result_array();
    }

    // Get Already Filled Dag Number against the selected village by LM
    public function getUpdatedLandShareDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $select_village)
    {

        $updatedDag = $this->db->query("SELECT chitha_basic.dag_no, chitha_basic.dag_area_b, chitha_basic.dag_area_k, chitha_basic.dag_area_lc, chitha_basic.patta_no, chitha_basic.patta_type_code, land_share_details.flag FROM chitha_basic JOIN land_share_details ON land_share_details.dag_no = chitha_basic.dag_no AND land_share_details.dist_code = chitha_basic.dist_code AND land_share_details.subdiv_code = chitha_basic.subdiv_code AND land_share_details.cir_code = chitha_basic.cir_code AND land_share_details.mouza_pargona_code = chitha_basic.mouza_pargona_code AND land_share_details.lot_no = chitha_basic.lot_no AND land_share_details.vill_townprt_code = chitha_basic.vill_townprt_code WHERE chitha_basic.dag_no IN (SELECT dag_no  FROM land_share_details WHERE flag < '2' AND dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$circle_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_townprt_code = '$select_village') AND chitha_basic.dist_code = '$dist_code' AND chitha_basic.subdiv_code = '$subdiv_code' AND chitha_basic.cir_code = '$circle_code' AND chitha_basic.mouza_pargona_code = '$mouza_code' AND chitha_basic.lot_no = '$lot_no' AND chitha_basic.vill_townprt_code = '$select_village'");

        return $updatedDag->result_array();
    }

    // Get Reverted Land Share Dag Number against the selected village by LM
    public function getRevertedLandShareDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $select_village)
    {

        $revertedDag = $this->db->query("SELECT chitha_basic.dag_no, chitha_basic.dag_area_b, chitha_basic.dag_area_k, chitha_basic.dag_area_lc, chitha_basic.patta_no, chitha_basic.patta_type_code FROM chitha_basic JOIN land_share_details ON land_share_details.dag_no = chitha_basic.dag_no AND land_share_details.dist_code = chitha_basic.dist_code AND land_share_details.subdiv_code = chitha_basic.subdiv_code AND land_share_details.cir_code = chitha_basic.cir_code AND land_share_details.mouza_pargona_code = chitha_basic.mouza_pargona_code AND land_share_details.lot_no = chitha_basic.lot_no AND land_share_details.vill_townprt_code = chitha_basic.vill_townprt_code  WHERE chitha_basic.dag_no IN (SELECT dag_no  FROM land_share_details WHERE flag = 2 AND vill_townprt_code ='$select_village') AND chitha_basic.dist_code = '$dist_code' AND chitha_basic.subdiv_code = '$subdiv_code' AND chitha_basic.cir_code = '$circle_code' AND chitha_basic.mouza_pargona_code = '$mouza_code' AND chitha_basic.lot_no = '$lot_no' AND chitha_basic.vill_townprt_code = '$select_village'");

        return $revertedDag->result_array();
    }


    public function getVillageDagNumber($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $postData)
    {

        $dagList = array();

        $dagList = $this->db->query("SELECT dag_no FROM chitha_basic  WHERE  dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' AND mouza_pargona_code = '$mouza_pargona_code' AND lot_no = '$lot_no' AND vill_townprt_code = '$postData'");

        $dagList->result_array();

        return $dagList;
    }


    public function getLandDetails($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_code)
    {

        $sql = "select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? ";
        $query = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_code));
        return $query->result();
    }

    public function getAllLandShareDetailsDagWise($landShareDetailsSearchArr)
    {
        $sql = "select * from land_share_details where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code  = ?  and dag_no =?";
        $query = $this->db->query(
            $sql,
            array(
                $landShareDetailsSearchArr['dist_code'],
                $landShareDetailsSearchArr['subdiv_code'],
                $landShareDetailsSearchArr['cir_code'],
                $landShareDetailsSearchArr['mouza_pargona_code'],
                $landShareDetailsSearchArr['lot_no'],
                $landShareDetailsSearchArr['vill_townprt_code'],
                $landShareDetailsSearchArr['dag_no'],
            )
        );
        $land_share_details = $query->result();
        $sql = "select * from land_share_indivisual_details where land_share_details_id = ?";
        $query = $this->db->query($sql, array($land_share_details[0]->id));
        $land_share_indivisual_details = $query->result();
        return ['land_share_details' => $land_share_details, 'land_share_indivisual_details' => $land_share_indivisual_details];
    }

    // Get Land Share Pattadar Name in Land Share Add Form
    public function getAllLandShareDetailsDagWiseForAdd($chithaPattadarDetailsSearchArr)
    {
        $sql = "select * from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code  = ?  and dag_no =? and patta_no=?";
        $query = $this->db->query(
            $sql,
            array(
                $chithaPattadarDetailsSearchArr['dist_code'],
                $chithaPattadarDetailsSearchArr['subdiv_code'],
                $chithaPattadarDetailsSearchArr['cir_code'],
                $chithaPattadarDetailsSearchArr['mouza_pargona_code'],
                $chithaPattadarDetailsSearchArr['lot_no'],
                $chithaPattadarDetailsSearchArr['vill_townprt_code'],
                $chithaPattadarDetailsSearchArr['dag_no'],
                $chithaPattadarDetailsSearchArr['patta_no']
            )
        );
        $chitha_basic_details = $query->result();
        $sql = "select * from chitha_dag_pattadar  join chitha_pattadar on chitha_pattadar.pdar_id = chitha_dag_pattadar.pdar_id and  chitha_pattadar.patta_no = chitha_dag_pattadar.patta_no and chitha_pattadar.patta_type_code = chitha_dag_pattadar.patta_type_code and chitha_pattadar.dist_code = chitha_dag_pattadar.dist_code and chitha_pattadar.subdiv_code = chitha_dag_pattadar.subdiv_code and chitha_pattadar.cir_code = chitha_dag_pattadar.cir_code and chitha_pattadar.mouza_pargona_code = chitha_dag_pattadar.mouza_pargona_code and chitha_pattadar.lot_no = chitha_dag_pattadar.lot_no and chitha_pattadar.vill_townprt_code = chitha_dag_pattadar.vill_townprt_code   where chitha_dag_pattadar.dist_code = ? and chitha_dag_pattadar.subdiv_code = ? and chitha_dag_pattadar.cir_code = ? and chitha_dag_pattadar.mouza_pargona_code = ? and chitha_dag_pattadar.lot_no = ? and chitha_dag_pattadar.vill_townprt_code  = ?  and chitha_dag_pattadar.dag_no =? and chitha_pattadar.patta_no =? and (chitha_dag_pattadar.p_flag != '1' or chitha_dag_pattadar.p_flag is null or chitha_dag_pattadar.p_flag = '0')";
        $query = $this->db->query(
            $sql,
            array(
                $chitha_basic_details[0]->dist_code,
                $chitha_basic_details[0]->subdiv_code,
                $chitha_basic_details[0]->cir_code,
                $chitha_basic_details[0]->mouza_pargona_code,
                $chitha_basic_details[0]->lot_no,
                $chitha_basic_details[0]->vill_townprt_code,
                $chitha_basic_details[0]->dag_no,
                $chitha_basic_details[0]->patta_no,
            )
        );
        $chitha_pattadar_indivisual_details = $query->result();
        return ['chitha_basic' => $chitha_basic_details, 'chitha_pattadar' => $chitha_pattadar_indivisual_details];
    }
    // Get LAnd Share Pattadar Name in Land Share Add form End


    //getting all the master table gender list 
    public function getAllGenderList()
    {
        $sql = "Select * from master_gender";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        return json_encode($query->result());
    }

    //getting all the master table caste list 
    public function getAllCasteList()
    {
        $sql = "Select * from master_caste";
        $query = $this->db->query($sql);
        //echo $this->db->last_query();
        return json_encode($query->result());
    }

    //insertion of land share details and land share pattadar indivisual details 
    public function addLandShareAndIndivisualDetails($insertion_data_for_land_share_details, $insertion_data_for_indivisual_details_arr)
    {
        //for ignoring the last inserted id warning in respose
        error_reporting(0);
        $this->db->trans_begin();
        //insertion in land share details
        $tstatus1 = $this->db->insert('land_share_details', $insertion_data_for_land_share_details);
        if ($tstatus1 != 1) {
            $this->db->trans_rollback();
            log_message("error", "#LSU001, Error in insert, table 'land_share_details' with data :" . json_encode($insertion_data_for_land_share_details));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LSU001'];
        }
        //insertion of land share indivisual details
        $land_share_inserted_id = $this->db->insert_id();
        $t_land_share_indivisual_details_ins_arr = array();
        foreach ($insertion_data_for_indivisual_details_arr as $insertion_data_for_indivisual_details) {
            $insertion_data_for_indivisual_details['land_share_details_id'] =  $land_share_inserted_id;
            $tstatus2 = $this->db->insert('land_share_indivisual_details', $insertion_data_for_indivisual_details);
            if (
                $tstatus2 != 1
            ) {
                $this->db->trans_rollback();
                log_message("error", "#LSU002, Error in insert, table 'land_share_indivisual_details' with data :" . json_encode($insertion_data_for_indivisual_details));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LSU002'];
            }
            //creating a new array for t land share indivisual details
            $land_share_indivisual_inserted_id = $this->db->insert_id();
            unset($insertion_data_for_indivisual_details['land_share_details_id']);
            $insertion_data_for_indivisual_details['land_share_indivisual_details_id'] =  $land_share_indivisual_inserted_id;
            array_push($t_land_share_indivisual_details_ins_arr, $insertion_data_for_indivisual_details);
        }
        //insertion of t land share details
        $tstatus1 = $this->db->insert('t_land_share_details', $insertion_data_for_land_share_details);
        if ($tstatus1 != 1) {
            $this->db->trans_rollback();
            log_message("error", "#LSU003, Error in insert, table 't_land_share_details' with data :" . json_encode($insertion_data_for_land_share_details));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LSU003'];
        }

        //insertion of t land share indivisual details 
        $t_land_share_inserted_id = $this->db->insert_id();
        foreach ($t_land_share_indivisual_details_ins_arr as $insertion_data_for_indivisual_details) {
            $insertion_data_for_indivisual_details['t_land_share_details_id'] =  $t_land_share_inserted_id;
            $tstatus2 = $this->db->insert('t_land_share_indivisual_details', $insertion_data_for_indivisual_details);
            if (
                $tstatus2 != 1
            ) {
                $this->db->trans_rollback();
                log_message("error", "#LSU004, Error in insert, table 't_land_share_indivisual_details' with data :" . json_encode($insertion_data_for_indivisual_details));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LSU004'];
            }
        }
        //checkeing all transaction status 
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            log_message("error", "#LSU005, Transaction Status Error In land share Tables");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LSU005'];
        } else {
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'land share Details Added Successfully!'];
        }
    }

    // getting unique village id 
    public function getVillageUUID($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_code)
    {

        $sql = "select uuid from location where dist_code = ? and subdiv_code = ? and cir_code = ? 
                and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code  = ?";
        $query = $this->db->query($sql, array($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $vill_code, '0000'));
        $result = $query->result();

        if (
            count($result) != 0
        ) {
            return $result[0]->uuid;
        } else {
            return 0;
        }
    }

    // Reupdate Land Share Detals By LM
    public function ReupdateLandShareAndPattadarDetails(
        $updation_data_for_land_share_details,
        $new_pattadar_insert_data_in_updation_arr,
        $update_data_for_pattadar_details_arr,
        $existing_pattadar_arr_in_update
    ) {
        error_reporting(0);
        $this->db->trans_begin();
        //***********************updating-main-tables*******************/
        //geting existing id form land share details table 
        $land_share_details_existing = $this->db->select("*")->from('land_share_details')
        ->where(
            [
                'dist_code' => $updation_data_for_land_share_details['dist_code'],
                'subdiv_code' => $updation_data_for_land_share_details['subdiv_code'],
                'cir_code' => $updation_data_for_land_share_details['cir_code'],
                'mouza_pargona_code' => $updation_data_for_land_share_details['mouza_pargona_code'],
                'lot_no' => $updation_data_for_land_share_details['lot_no'],
                'vill_townprt_code' => $updation_data_for_land_share_details['vill_townprt_code'],
                'dag_no' => $updation_data_for_land_share_details['dag_no'],
            ]
        )
            ->get()->row();
        $land_share_existing_id = $land_share_details_existing->id;
        //update data in land share details
        $this->db->where('id', $land_share_existing_id)->update('land_share_details', $updation_data_for_land_share_details);
        if ($this->db->affected_rows() != 1) {
            //if no updation made
            $this->db->trans_rollback();
            log_message("error", "#LSU001U, Error in update, table 'land_share_details' with data :" . json_encode($updation_data_for_land_share_details));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LSU001U'];
        }
        //deletion of existing old encreacher which are not present in updation 
        $sql = "select id from land_share_indivisual_details where land_share_details_id = ?";
        $query = $this->db->query($sql, array($land_share_existing_id));
        $existing_pattadar_ids_obj = $query->result();
        $existing_pattadar_ids_arr = array();
        foreach ($existing_pattadar_ids_obj as $existing_pattadar_id) {
            array_push($existing_pattadar_ids_arr, $existing_pattadar_id->id);
        }
        $existting_pattadar_ids_to_be_deleted = array_diff($existing_pattadar_ids_arr, $existing_pattadar_arr_in_update);
        foreach ($existting_pattadar_ids_to_be_deleted as $existting_enc_id_to_be_deleted) {
            $this->db->where('id', $existting_enc_id_to_be_deleted)->delete('land_share_indivisual_details');
            if ($this->db->affected_rows() != 1) {
                //if no updation made
                $this->db->trans_rollback();
                log_message("error", "#LSU001R, Error in delete, table 'land_share_indivisual_details' with id " . $existting_enc_id_to_be_deleted);
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LSU001R'];
            }
        }
        $new_t_pattadar_insert_data_in_updation_arr = array();
        //update all the modifed existing encroacher
        foreach ($update_data_for_pattadar_details_arr as $update_data_for_pattadar_details) {
            $enc_id = $update_data_for_pattadar_details['existing_id'];
            unset($update_data_for_pattadar_details['existing_id']);

            $update_data_for_pattadar_details['land_share_details_id'] =  $land_share_existing_id;
            $this->db->where('id', $enc_id)->update('land_share_indivisual_details', $update_data_for_pattadar_details);
            if ($this->db->affected_rows() != 1) {
                //if no updation made
                $this->db->trans_rollback();
                log_message("error", "#LSU009U, Error in update(existing), table 'land_share_indivisual_details' with data :" . json_encode($updation_data_for_land_share_details));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LSU009U'];
            }

            unset($update_data_for_pattadar_details['land_share_details_id']);
            $update_data_for_pattadar_details['land_share_indivisual_details_id'] = $enc_id;
            array_push($new_t_pattadar_insert_data_in_updation_arr, $update_data_for_pattadar_details);
        }
        //insert all the new encroachers        
        foreach ($new_pattadar_insert_data_in_updation_arr as $new_pattadar_insert_data_in_updation) {
            $new_pattadar_insert_data_in_updation['land_share_details_id'] =  $land_share_existing_id;
            $tstatus4 = $this->db->insert('land_share_indivisual_details', $new_pattadar_insert_data_in_updation);
            if (
                $tstatus4 != 1
            ) {
                $this->db->trans_rollback();
                log_message("error", "#LSU005U, Error in insert(new) on updation, table 'land_share_indivisual_details' with data :" . json_encode($new_pattadar_insert_data_in_updation));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LSU005U'];
            }
            //creatng a new enc insert array for t land bank encroacher details 
            unset($new_pattadar_insert_data_in_updation['land_share_details_id']);
            $new_pattadar_insert_data_in_updation['land_share_indivisual_details_id'] = $this->db->insert_id();
            array_push($new_t_pattadar_insert_data_in_updation_arr, $new_pattadar_insert_data_in_updation);
        }
        //return $new_t_pattadar_insert_data_in_updation_arr;
        //***********************updating-transcation-tables*******************/
        //insertion in t_land_share_details, t_land_share_indivisual_details 
        $tstatus1 = $this->db->insert('t_land_share_details', $updation_data_for_land_share_details);
        if ($tstatus1 != 1) {
            $this->db->trans_rollback();
            log_message("error", "#LSU001U, Error in insert on updation, table 't_land_share_details' with data :" . json_encode($updation_data_for_land_share_details));
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LSU001U'];
        }

        $t_land_bank_inserted_id = $this->db->insert_id();
        //inserting new pattadar in t_land_share_indivisual_details
        foreach ($new_t_pattadar_insert_data_in_updation_arr as $new_pattadar_insert_data_in_updation) {
            $new_pattadar_insert_data_in_updation['t_land_share_details_id'] =  $t_land_bank_inserted_id;
            $tstatus2 = $this->db->insert('t_land_share_indivisual_details', $new_pattadar_insert_data_in_updation);
            if (
                $tstatus2 != 1
            ) {
                $this->db->trans_rollback();
                log_message("error", "#LSU002U, Error in insert(new) on updation, table 't_land_share_indivisual_details' with data :" . json_encode($new_pattadar_insert_data_in_updation));
                return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LSU002U'];
            }
        }
        //***************************************************************************/        
        if ($this->db->trans_status() == FALSE) {
            $this->db->trans_rollback();
            log_message("error", "#LSU0010U, Transaction Status Error In Land Share Tables on Updation");
            return ['result' => false, 'msg' => 'Some error occured, Error-Code : #LSU0010U'];
        } else {
            $this->db->trans_commit();
            return ['result' => true, 'msg' => 'Land Share Details Updated Successfully!'];
        }
    }
    // LM ReUpdate End
    // --------------------------CO Methods Begin----------------------------

    // Get Pending Land Share Detailsat CO End
    // Newly Added
    public function get_PendingLandShareDetailsCo($select_offset)
    {
        $this->db->select('*');
        $this->db->distinct();
        $this->db->from('land_share_details');
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        $this->db->where('flag', '0');
        $this->db->limit(500, $select_offset);
        $this->db->order_by("dag_no", "asc");
        return $this->db->get()->result_array();
    }

    // Approve Land Share Details by CO against a Dag No and Unique Village Code
    public function LandShareApprove($data1, $dag_no, $village_uuid)
    {
        $where = array('dag_no' => $dag_no, 'village_uuid' => $village_uuid);
        return $this->db->set($data1)->where($where)->update('land_share_details');
    }

    // Revert Land Share Details By CO against a Dag No and Unique Village Code
    public function LandShareRevert($data1,$dag_no, $village_uuid)
    {
        $where = array('dag_no' => $dag_no, 'village_uuid' => $village_uuid);
        return $this->db->set($data1)->where($where)->update('land_share_details');
    }

    // Reject Land Share Details by CO against a Dag No and Unique Village Code
    public function LandShareReject($dag_no, $village_uuid)
    {
        $where = array('dag_no' => $dag_no, 'village_uuid' => $village_uuid);
        return $this->db->where($where)->delete('land_share_details');
    }

    // Get All Land Share Information against a Dag No and Unique Village Code at CO View Modal
    public function getAllLandShareDetailsCoSide($landShareDetailsSearchArr)
    {
        $sql = "select * from land_share_details where  village_uuid  = ?  and dag_no =?";
        $query = $this->db->query(
            $sql,
            array(
                $landShareDetailsSearchArr['village_uuid'],
                $landShareDetailsSearchArr['dag_no'],
            )
        );
        $land_share_details = $query->result();
        $sql = "select * from land_share_indivisual_details where land_share_details_id = ?";
        $query = $this->db->query($sql, array($land_share_details[0]->id));
        $land_share_indivisual_details = $query->result();
        return ['land_share_details' => $land_share_details, 'land_share_indivisual_details' => $land_share_indivisual_details];
    }

    // --------------------------CO Methods End----------------------------

}
