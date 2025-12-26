<?php
class NcServiceModel extends CI_Model {
    public function __construct() {
        parent::__construct();
    }
    function getDistCode($case_no){
        $query = "SELECT dist_code FROM settlement_basic WHERE case_no = '$case_no'";
        $data = $this->db->query($query)->row();
        if($data){
            $data = $data->dist_code;
        }else{
            $data = NULL;
        }
        return $data;

    }


    // get all proceedings
    public function getProceeding($case_no)
    {
        $proceeding_data = $this->db->select()
            ->where('case_no',$case_no)
            ->get('settlement_proceeding');

        return $proceeding_data->result();
    }

    // get all applicant
    public function getAllApplicant($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_applicant');

        return $applicants->result();
    }

    // get all settlement basic
    public function getSettlementBasic($case)
    {
        $basic = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_basic');

        return $basic->row_array();
    }

    // get all applicant owners
    public function getAllApplicantOwners($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'O')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all applicant buyers
    public function getAllApplicantBuyers($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'B')
            ->order_by('is_applicant', 'desc')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // get all settlement dag
    public function getSettlementDag($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->result();
    }

    // get all settlement dag row
    public function getSettlementDagRow($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->row_array();
    }

    // get all settlement ap lm note
    public function getSettlementApLmNote($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_ap_lmnote');

        return $lmnotes->result();
    }

    // get all settlement proceeding
    public function getSettlementProceeding($case)
    {
        $proceedings = $this->db->select()
            ->where('case_no',$case)
            ->order_by('proceeding_id', 'desc')
            ->get('settlement_proceeding');

        return $proceedings->result();
    }

    // get all settlement proceeding
    public function getDocuments($case)
    {
        $applicaiton_no = $this->utilityclass->getApplidFromCaseNo($case);
        $proceedings = $this->db->select()
            ->where('case_no in (\''.$applicaiton_no.'\', \''.$case.'\')')
            ->get('supportive_document');

        return $proceedings->result();
    }

    // get all applicant encroacher
    public function getAllApplicantEncroacher($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'EN')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    // count all applicant encroacher
    public function countAllApplicantEncroacher($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('pdar_type', 'EN')
            ->get('settlement_applicant');
        return $applicants->num_rows();
    }


    // get applicant encroacher
    public function getApplicantEncroacher($case,$id)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where('id', $id)
            ->where('pdar_type', 'EN')
            ->get('settlement_applicant');
        return $applicants->row();
    }


    // get all applicant riotee nok
    public function getAllApplicantRioteeNok($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->where_in('pdar_type', ['P','GP','GGP'])
            ->get('settlement_applicant');
        return $applicants->result();
    }

    public function getVillageList($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no){
        //$db=  $this->session->userdata('db');
        $village = $this->db->query("select loc_name AS village, vill_townprt_code AS vill_code from   location where dist_code ='$dist_code'  and "
            . " subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and "
            . " vill_townprt_code <> '00000' and lot_no='$lot_no'");
        return $village->result();
    }

    ///for co settlements
    function getSettlementBasicCo($case_no){
        $query = "SELECT * FROM settlement_basic WHERE case_no = '$case_no'";
        $data = $this->db->query($query)->row();
        return $data;
    }

    function getSettlementDagDetails($case_no){
        $query = "SELECT * FROM settlement_dag_details WHERE case_no = '$case_no'";
        $data = $this->db->query($query)->row();
        return $data;
    }

    // getting the VLB encroacher details -js- 29-aug-22
    public function getEncroacherDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_townprt_code, $dag_no){
        $vlb = $this->db->select()
            ->WHERE('dist_code', $dist_code)
            ->WHERE('subdiv_code', $subdiv_code)
            ->WHERE('cir_code', $circle_code)
            ->WHERE('mouza_pargona_code', $mouza_code)
            ->WHERE('lot_no', $lot_no)
            ->WHERE('vill_townprt_code', $vill_townprt_code)
            ->WHERE('dag_no', $dag_no)
            ->GET('c_land_bank_details');
        if ($vlb->num_rows() > 0) {
            return $vlb->row();
        } else {
            return FALSE;
        }
    }
    public function getEncroacherInDag($end_id){
        $enc_details = $this->db->select()
            ->WHERE('c_land_bank_details_id', $end_id)
            ->GET('c_land_bank_encroacher_details');
        if ($enc_details->num_rows() > 0) {
            return $enc_details->result();
        } else {
            return FALSE;
        }
    }


    public function fetchEncroacher($end_id){
        $enc_details = $this->db->select()
            ->WHERE('id', $end_id)
            ->GET('c_land_bank_encroacher_details');
        return $enc_details->result();
    }

    public function getDags($case_no){
        $dags = $this->db->select()
            ->where('case_no',$case_no)
            ->get('settlement_dag_details');
        return $dags->result();
    }

    public function getOwners($case){
        $owners = $this->db->select()
            ->where('case_no', $case)
            ->where('pdar_type', 'O')
            ->get('settlement_applicant');
        return $owners->result();
    }

    public function getBuyers($case){
        $buyers = $this->db->select()
            ->where('case_no', $case)
            ->where('pdar_type', 'B')
            ->get('settlement_applicant');
        return $buyers->result();
    }

    public function getNrToSettlement($service_code)
    {

        $this->db->select('*');
        $this->db->from('settlement_basic');
        $this->db->where('service_code', $service_code);
        $this->db->where('pending_officer', MB_CIRCLE_OFFICER);
        $this->db->where_in('status', 'Y');
        // $this->db->where($array);
        $this->db->where('dist_code', $this->session->userdata('dist_code'));
        $this->db->where('subdiv_code', $this->session->userdata('subdiv_code'));
        $this->db->where('cir_code', $this->session->userdata('cir_code'));
        return $this->db->get()->result_array();
    }

    function getUrban($case_no){
        $query = "SELECT is_urban FROM settlement_dag_details WHERE case_no = '$case_no'";
        $data = $this->db->query($query)->row();
        return $data;
    }
    // get all settlement reservation
    public function getSettlementReservation($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->where('is_deleted != 1')
            ->get('settlement_reservation');

        return $lmnotes->result();
    }

    // get all settlement dag row for premium
    public function getSettlementDagPremium($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details');

        return $dags->result();
    }
    // get all settlement tenant lm note
    public function getSettlementTenantLmNote($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->order_by('id', 'DESC')
            ->limit(1)
            ->get('settlement_ap_lmnote');
        return $lmnotes->result();
    }
    // get all (B,O,EN,P,GP,GGP) applicant
    public function getAllNomineeDetail($case)
    {
        $applicants = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_nominee');
        return $applicants->result();
    }
    // get all settlement proceeding
    public function getAdditionalProperty($case)
    {
        $property = $this->db->select()
            ->where('case_no = \''.$case.'\' or applid = \''.$case.'\'')
            ->get('settlement_additional_property');

        return $property->result();
    }

    // get all owners and owner father from chitha_pattadar
    public function getAllOwnersChithaoldNotInUse($case)
    {
        $location = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details')->row();

        $condition = "subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' 
        and patta_no ='$location->patta_no' and patta_type_code='$location->patta_type_code'";
        
        // $sql= "select string_agg(cp.pdar_name || ' (' || cp.pdar_father || ')',',') as owners from chitha_pattadar cp join chitha_dag_pattadar cdp on
        // cp.subdiv_code =cdp.subdiv_code and cp.cir_code =cdp.cir_code 
        // and cp.mouza_pargona_code =cdp.mouza_pargona_code and cdp.lot_no=cp.lot_no 
        // and cp.vill_townprt_code = cdp.vill_townprt_code and cp.patta_type_code = cdp.patta_type_code 
        // and cp.patta_no = cdp.patta_no and cp.pdar_id = cdp.pdar_id
        // where cdp.subdiv_code ='$location->subdiv_code' and cdp.cir_code ='$location->cir_code' and cdp.mouza_pargona_code='$location->mouza_pargona_code' and cdp.lot_no='$location->lot_no' and cdp.vill_townprt_code ='$location->vill_townprt_code' 
        // and cp.patta_no ='$location->patta_no' and cdp.dag_no='$location->dag_no' and (cdp.p_flag is null or cdp.p_flag='0')
        // group by cdp.dist_code , cdp.subdiv_code , cdp.cir_code , cdp.mouza_pargona_code , cdp.lot_no , cdp.vill_townprt_code , cdp.patta_type_code , cdp.patta_no, cdp.dag_no";

        $sql= "select string_agg(cp.pdar_name || ' (' || cp.pdar_father || ')',',') as owners from (select pdar_name,pdar_father,pdar_id from chitha_pattadar where $condition) cp join ( select pdar_id from chitha_dag_pattadar where $condition and dag_no='$location->dag_no' and (p_flag is null or p_flag='0')) cdp on
        cp.pdar_id = cdp.pdar_id";

        // echo $sql; die;
        // $sql= "select string_agg(cp.pdar_name || ' (' || cp.pdar_father || ')',',') as owners from chitha_pattadar cp join chitha_dag_pattadar cdp on cp.subdiv_code =cdp.subdiv_code and cp.cir_code =cdp.cir_code and cp.mouza_pargona_code =cdp.mouza_pargona_code and cdp.lot_no=cp.lot_no and cp.vill_townprt_code = cdp.vill_townprt_code and cp.patta_type_code = cdp.patta_type_code and cp.patta_no = cdp.patta_no and cp.pdar_id = cdp.pdar_id where cdp.subdiv_code ='01' and cdp.cir_code ='03' and cdp.mouza_pargona_code='01' and cdp.lot_no='09' and cdp.vill_townprt_code ='10004' and cp.patta_no ='129' and cdp.dag_no='3' and (cdp.p_flag is null or cdp.p_flag='0') group by cdp.dist_code , cdp.subdiv_code , cdp.cir_code , cdp.mouza_pargona_code , cdp.lot_no , cdp.vill_townprt_code , cdp.patta_type_code , cdp.patta_no, cdp.dag_no";

        $ownersName = $this->db->query($sql);
        if ($ownersName->num_rows() > 0) {
            return $ownersName->row();
        }else{
            return null;
        }
    }

    public function getAllOwnersChithabackup($case)
    {
        $location = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details')->row();

        $condition = "subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' 
        and patta_no ='$location->patta_no' and patta_type_code='$location->patta_type_code'";
        $st=microtime(true);
       
        $sql= "select ''''||string_agg(pdar_id::varchar,''',''')||'''' as pdar_ids from chitha_dag_pattadar where $condition and dag_no='$location->dag_no' and (p_flag is null or p_flag='0')" ;
        $result_data = $this->db->query($sql)->row();
      
        $sql= "select string_agg(pdar_name || ' (' || pdar_father || ')',',') as owners from chitha_pattadar where $condition and  pdar_id in ($result_data->pdar_ids)";

        $ownersName = $this->db->query($sql);
        log_message('error', 'getAllOwnersChitha: time taken='.(microtime(true) - $st));
        if ($ownersName->num_rows() > 0) {
            return $ownersName->row();
        }else{
            $this->session->set_flashdata('message', "#ERRP00255: Pattadar's not found for case no : ".$case);
            redirect(base_url() . "index.php/home");
            return false;
            // return null;
        }       
    }

    // public function getAllOwnersChitha($case)
    // {
    //     $location = $this->db->select()
    //         ->where('case_no',$case)
    //         ->get('settlement_dag_details')->row();

    //     $condition = "subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' 
    //     and patta_no ='$location->patta_no' and patta_type_code='$location->patta_type_code'";
    //     $st=microtime(true);

    //     $sqlcheck= "select * from chitha_dag_pattadar where $condition and dag_no='$location->dag_no' and (p_flag is null or p_flag='0')" ;
    //     $result_check = $this->db->query($sqlcheck);
    //     if ($result_check->num_rows() > 0) {

       
    //         $sql= "select ''''||string_agg(pdar_id::varchar,''',''')||'''' as pdar_ids from chitha_dag_pattadar where $condition and dag_no='$location->dag_no' and (p_flag is null or p_flag='0')" ;
    //         $result_data = $this->db->query($sql)->row();
          
    //         $sql= "select string_agg(pdar_name || ' (' || pdar_father || ')',',') as owners from chitha_pattadar where $condition and  pdar_id in ($result_data->pdar_ids)";

    //         $ownersName = $this->db->query($sql);
    //         log_message('error', 'getAllOwnersChitha: time taken='.(microtime(true) - $st));
    //         if ($ownersName->num_rows() > 0) {
    //             return $ownersName->row();
    //         }else{
    //             // return null;
    //             $this->session->set_flashdata('message', "#ERRP00256: Pattadar's not found for case no : ".$case);
    //             redirect(base_url() . "index.php/home");
    //             return false;
    //         }
    //     }
    //     else{
    //         // return null;
    //         $this->session->set_flashdata('message', "#ERRP00255: Pattadar's not found for case no : ".$case);
    //         redirect(base_url() . "index.php/home");
    //         return false;
    //     }  
    // }
    

    public function getAllOwnersChitha($case)
    {
        $location = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details')->row();

        $condition = "subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' 
        and trim(patta_no) ='$location->patta_no' and patta_type_code='$location->patta_type_code'";

        $st=microtime(true);

        $sqlcheck= "select * from chitha_dag_pattadar where $condition and trim(dag_no)=trim('$location->dag_no') and (p_flag is null or p_flag='0')" ;
        $result_check = $this->db->query($sqlcheck);
        if ($result_check->num_rows() > 0) {

       
            $sql= "select ''''||string_agg(pdar_id::varchar,''',''')||'''' as pdar_ids from chitha_dag_pattadar where $condition and trim(dag_no)=trim('$location->dag_no') and (p_flag is null or p_flag='0')" ;
            $result_data = $this->db->query($sql)->row();
          
            $sql= "select string_agg(pdar_name || ' (' || pdar_father || ')',',') as owners from chitha_pattadar where $condition and  pdar_id in ($result_data->pdar_ids)";

            $ownersName = $this->db->query($sql);
            log_message('error', 'getAllOwnersChitha: time taken='.(microtime(true) - $st));
            if ($ownersName->num_rows() > 0) {
                return $ownersName->row();
            }else{
                // return null;
                $this->session->set_flashdata('message', "#ERRP00256: Pattadar's not found for case no : ".$case);
                redirect(base_url() . "index.php/home");
                return false;
            }
        }
        else{

            //check chitha and update dag_details
            //get patta_no from chitha_basic
            $sql = "select patta_type_code, trim(patta_no) as patta_no from chitha_basic where subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' and trim(dag_no)=trim('$location->dag_no')";
            
            $data = $this->db->query($sql);
            if ($data->num_rows()<=0)
            {
                $this->session->set_flashdata('message', "#ERRP00256: Dag not found for case no : ".$case);
                redirect(base_url() . "index.php/home");
                return false;
            }
            $data = $data->row();

            //if applicant's patta_type and chitha_patta_type matching and patta_nos are not matching
            if ($data->patta_type_code == $location->patta_type_code && $data->patta_no!=$location->patta_no)
            {
                $sql = "select  pdar_id from settlement_applicant where case_no='$case' and pdar_type='O'";
                $pdars = $this->db->query($sql)->result();

                                
                $sqlcheck= "select string_agg(pdar_id::text,',') as chitha_pdar_ids from chitha_dag_pattadar where subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' and trim(dag_no)=trim('$location->dag_no') and (p_flag is null or p_flag='0')" ;
                $chitha_pdars = $this->db->query($sqlcheck)->row()->chitha_pdar_ids;
                $chitha_pdar_arr = explode(',', $chitha_pdars);
                // var_dump($chitha_pdars); die;
                
                foreach($pdars as $p)
                {
                    //if applicant's pdar_id and chitha_pdar_id matching
                    if (!in_array($p->pdar_id, $chitha_pdar_arr))
                    {
                        $this->session->set_flashdata('message', "#ERRP00256: Pattadars not found for case no : ".$case);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                }

                //coming here means applicant's pdar_id and chitha pdar_id are matching so we can update patta_no
                $update_arrya=[
                    'patta_no' => $data->patta_no
                ];
                $this->db->where('case_no',$case);
                $this->db->update('settlement_applicant',$update_arrya);
                if ($this->db->affected_rows()<=0)
                {
                    $this->session->set_flashdata('message', "#ERRP00256: Pattadars not found for case no : ".$case);
                    redirect(base_url() . "index.php/home");
                    return false;
                } 
                $this->db->where('case_no',$case);
                $this->db->update('settlement_dag_details',$update_arrya);
                if ($this->db->affected_rows()<=0)
                {
                    $this->session->set_flashdata('message', "#ERRP00256: Pattadars not found for case no : ".$case);
                    redirect(base_url() . "index.php/home");
                    return false;
                } 

                $condition = "subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' 
                    and trim(patta_no) ='$data->patta_no' and patta_type_code='$location->patta_type_code'";
                $sqlcheck= "select * from chitha_dag_pattadar where $condition and trim(dag_no)=trim('$location->dag_no') and (p_flag is null or p_flag='0')" ;
                $result_check = $this->db->query($sqlcheck);
                if ($result_check->num_rows() > 0) {
               
                    $sql= "select ''''||string_agg(pdar_id::varchar,''',''')||'''' as pdar_ids from chitha_dag_pattadar where $condition and trim(dag_no)=trim('$location->dag_no') and (p_flag is null or p_flag='0')" ;
                    $result_data = $this->db->query($sql)->row();
                  
                    $sql= "select string_agg(pdar_name || ' (' || pdar_father || ')',',') as owners from chitha_pattadar where $condition and  pdar_id in ($result_data->pdar_ids)";

                    $ownersName = $this->db->query($sql);
                    log_message('error', 'getAllOwnersChitha: time taken='.(microtime(true) - $st));
                    if ($ownersName->num_rows() > 0) {
                        return $ownersName->row();
                    }else{
                        // return null;
                        $this->session->set_flashdata('message', "#ERRP00256: Pattadar's not found for case no : ".$case);
                        redirect(base_url() . "index.php/home");
                        return false;
                    }
                }
            }
        
            // return null;
            $this->session->set_flashdata('message', "#ERRP00275500: Pattadar's not found for case no : ".$case);
            redirect(base_url() . "index.php/home");
            return false;
        }  
    }


    // public function getAllOwnersChithaBulk($case)
    // {
    //     $location = $this->db->select()
    //         ->where('case_no',$case)
    //         ->get('settlement_dag_details')->row();

    //     $condition = "subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' 
    //     and patta_no ='$location->patta_no' and patta_type_code='$location->patta_type_code'";
    //     $st=microtime(true);

    //     $sqlcheck= "select * from chitha_dag_pattadar where $condition and dag_no='$location->dag_no' and (p_flag is null or p_flag='0')" ;
    //     $result_check = $this->db->query($sqlcheck);
    //     if ($result_check->num_rows() > 0) {


    //         $sql= "select ''''||string_agg(pdar_id::varchar,''',''')||'''' as pdar_ids from chitha_dag_pattadar where $condition and dag_no='$location->dag_no' and (p_flag is null or p_flag='0')" ;
    //         $result_data = $this->db->query($sql)->row();

    //         // $result_data = null;
    //         if(!empty($result_data) && isset($result_data->pdar_ids) && $result_data->pdar_ids != null){

    //             $sql= "select string_agg(pdar_name || ' (' || pdar_father || ')',',') as owners from chitha_pattadar where $condition and  pdar_id in ($result_data->pdar_ids)";

    //             $ownersName = $this->db->query($sql);
    //             log_message('error', 'getAllOwnersChitha: time taken='.(microtime(true) - $st));
    //             if ($ownersName->num_rows() > 0) {
    //                 $json = [
    //                     'responseType' => 2,
    //                     'message' => null,
    //                     'data' => $ownersName->row()
    //                 ];

    //                 return $json;
    //             }else{
    //                 $json = [
    //                     'responseType' => 3,
    //                     'message' => '#ERRP0025521: Failed to generate Pattadars not found for case no=='.$case,
    //                 ];
    //                 return $json;
    //             }
    //         }else{
    //             $json = [
    //                 'responseType' => 3,
    //                 'message' => '#ERRP0025522: Failed to generate Pattadars not found for case no=='.$case,
    //             ];
    //             return $json;
    //         }
    //     }
    //     else{


    //         $json = [
    //             'responseType' => 3,
    //             'message' => '#ERRP0025523: Failed to generate Pattadars not found for case no=='.$case,
    //         ];
    //         return $json;
    //     }
    // }

    public function getAllOwnersChithaBulk($case)
    {
        $location = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details')->row();

        $condition = "subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' 
        and patta_no ='$location->patta_no' and patta_type_code='$location->patta_type_code'";
        $st=microtime(true);

        $sqlcheck= "select * from chitha_dag_pattadar where $condition and dag_no='$location->dag_no' and (p_flag is null or p_flag='0')" ;
        $result_check = $this->db->query($sqlcheck);
        if ($result_check->num_rows() > 0) {


            $sql= "select ''''||string_agg(pdar_id::varchar,''',''')||'''' as pdar_ids from chitha_dag_pattadar where $condition and dag_no='$location->dag_no' and (p_flag is null or p_flag='0')" ;
            $result_data = $this->db->query($sql)->row();

            // $result_data = null;
            if(!empty($result_data) && isset($result_data->pdar_ids) && $result_data->pdar_ids != null){

                $sql= "select string_agg(pdar_name || ' (' || pdar_father || ')',',') as owners from chitha_pattadar where $condition and  pdar_id in ($result_data->pdar_ids)";

                $ownersName = $this->db->query($sql);
                log_message('error', 'getAllOwnersChitha: time taken='.(microtime(true) - $st));
                if ($ownersName->num_rows() > 0) {
                    $json = [
                        'responseType' => 2,
                        'message' => null,
                        'data' => $ownersName->row()
                    ];

                    return $json;
                }else{
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRP0025521: Failed to generate Pattadars not found for case no=='.$case,
                    ];
                    return $json;
                }
            }else{
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRP0025522: Failed to generate Pattadars not found for case no=='.$case,
                ];
                return $json;
            }
        }
        else{

            //check chitha and update dag_details
            //get patta_no from chitha_basic
            $sql = "select patta_type_code, trim(patta_no) as patta_no from chitha_basic where subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' and trim(dag_no)='$location->dag_no'";
            
            $data = $this->db->query($sql);
            if ($data->num_rows()<=0)
            {
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRP0025524: Failed to generate Pattadars not found for case no=='.$case,
                ];
                return $json;
            }
            $data = $data->row();

            //if applicant's patta_type and chitha_patta_type matching and patta_nos are not matching
            if ($data->patta_type_code == $location->patta_type_code && $data->patta_no!=$location->patta_no)
            {
                $sql = "select  pdar_id from settlement_applicant where case_no='$case' and pdar_type='O'";
                $pdars = $this->db->query($sql)->result();

                                
                $sqlcheck= "select string_agg(pdar_id::text,',') as chitha_pdar_ids from chitha_dag_pattadar where subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' and trim(dag_no)='$location->dag_no' and (p_flag is null or p_flag='0')" ;
                $chitha_pdars = $this->db->query($sqlcheck)->row()->chitha_pdar_ids;
                $chitha_pdar_arr = explode(',', $chitha_pdars);
                // var_dump($chitha_pdars); die;
                
                foreach($pdars as $p)
                {
                    //if applicant's pdar_id and chitha_pdar_id matching
                    if (!in_array($p->pdar_id, $chitha_pdar_arr))
                    {
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRP0025525: Failed to generate Pattadars not found for case no=='.$case,
                        ];
                        return $json;
                    }
                }

                //coming here means applicant's pdar_id and chitha pdar_id are matching so we can update patta_no
                $update_arrya=[
                    'patta_no' => $data->patta_no
                ];
                $this->db->where('case_no',$case);
                $this->db->update('settlement_applicant',$update_arrya);
                if ($this->db->affected_rows()<=0)
                {
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRP0025526: Failed to generate Pattadars not found for case no=='.$case,
                    ];
                    return $json;
                } 
                $this->db->where('case_no',$case);
                $this->db->update('settlement_dag_details',$update_arrya);
                if ($this->db->affected_rows()<=0)
                {
                    $json = [
                        'responseType' => 3,
                        'message' => '#ERRP0025527: Failed to generate Pattadars not found for case no=='.$case,
                    ];
                    return $json;
                } 

                $condition = "subdiv_code ='$location->subdiv_code' and cir_code ='$location->cir_code' and mouza_pargona_code='$location->mouza_pargona_code' and lot_no='$location->lot_no' and vill_townprt_code ='$location->vill_townprt_code' 
                    and trim(patta_no) ='$data->patta_no' and patta_type_code='$location->patta_type_code'";
                $sqlcheck= "select * from chitha_dag_pattadar where $condition and trim(dag_no)='$location->dag_no' and (p_flag is null or p_flag='0')" ;
                $result_check = $this->db->query($sqlcheck);
                if ($result_check->num_rows() > 0) {
               
                    $sql= "select ''''||string_agg(pdar_id::varchar,''',''')||'''' as pdar_ids from chitha_dag_pattadar where $condition and trim(dag_no)='$location->dag_no' and (p_flag is null or p_flag='0')" ;
                    $result_data = $this->db->query($sql)->row();
                  
                    $sql= "select string_agg(pdar_name || ' (' || pdar_father || ')',',') as owners from chitha_pattadar where $condition and  pdar_id in ($result_data->pdar_ids)";

                    $ownersName = $this->db->query($sql);
                    log_message('error', 'getAllOwnersChitha: time taken='.(microtime(true) - $st));
                    if ($ownersName->num_rows() > 0) {
                        return $ownersName->row();
                    }else{
                        $json = [
                            'responseType' => 3,
                            'message' => '#ERRP0025528: Failed to generate Pattadars not found for case no=='.$case,
                        ];
                        return $json;
                    }
                }
            }


            $json = [
                'responseType' => 3,
                'message' => '#ERRP0025523: Failed to generate Pattadars not found for case no=='.$case,
            ];
            return $json;
        }
    }


    public function validationOfLandOwners($applicants)
    { 
        $json = null;
        $chitha_arr_owner = [];
        $applicant_applied_array = [];
        $patta_type_code_array = ['0202', '0204', '0221', '0229', '0230', '0231'];  
        
        foreach($applicants as $row) {  
    
            if($row->pdar_type == 'B' && $row->is_applicant == 1){
    
                $dag_no          = $row->dag_no;
                $patta_no        = $row->patta_no; 
                $patta_type_code = $row->patta_type_code;
                $dist_code       = $row->dist_code; 
                $subdiv_code     = $row->subdiv_code; 
                $cir_code        = $row->cir_code;
                $mouza_code      = $row->mouza_pargona_code; 
                $lot_code        = $row->lot_no; 
                $vill_code       = $row->vill_townprt_code;
    
                if(!in_array($patta_type_code, $patta_type_code_array))
                {
                    log_message('error', '#ERR742: AP cases not allowed for this patta_type_code '.$patta_type_code);
                    $json = [
                        'responseType' => 3,
                        'message'      => '#ERR742: Issue in patta_type_code. Kindly contact system administrator',
                    ];
                    return $json;
                }
    
                //check in chitha for owner detail
                $resOwner = $this->db->query("SELECT A.pdar_id, A.pdar_name, A.pdar_father, 
                        A.patta_type_code, A.patta_no
                        FROM chitha_pattadar A LEFT JOIN chitha_dag_pattadar B ON
                        A.dist_code=B.dist_code AND A.subdiv_code=B.subdiv_code AND 
                        A.cir_code=B.cir_code AND A.mouza_pargona_code=B.mouza_pargona_code AND 
                        B.lot_no=A.lot_no AND A.vill_townprt_code=B.vill_townprt_code
                        AND B.patta_type_code=A.patta_type_code AND A.patta_no=B.patta_no
                        AND A.pdar_id=B.pdar_id
                        WHERE B.dist_code=? AND B.subdiv_code=? AND B.cir_code=? AND 
                        B.mouza_pargona_code=? AND B.lot_no=? AND B.vill_townprt_code=? AND
                        B.dag_no=? AND B.p_flag!=? AND B.patta_type_code=? AND B.patta_no=?
                        GROUP BY A.pdar_id, A.pdar_name, A.pdar_father, A.patta_type_code, A.patta_no", 
                            array($dist_code, $subdiv_code, $cir_code, $mouza_code, 
                            $lot_code, $vill_code, $dag_no, '1', $patta_type_code, $patta_no));
                // log_message('error', '#ERR763: Chitha Data == '.$this->db->last_query());
    
                if($resOwner->num_rows() <= 0){
                    log_message('error', '#ERR768: No detail found '.$this->db->last_query());
                    $json = [
                        'responseType' => 3,
                        'message'      => '#ERR768: Selected land owner(s) by applied applicant with chitha details are mismatched',
                    ];
                    return $json;
                }
                foreach($resOwner->result() as $owner) {
                    $chitha_arr_owner[] = trim($owner->pdar_id.'_'.trim($owner->pdar_name));
                }
            }           
    
            //check for pdar_id and pdar_name applied by applicants
            if($row->pdar_type == 'O' && $row->is_applicant != 1)
            {
                $applicant_applied_array[] = trim($row->pdar_id.'_'.trim($row->pdar_name));
            }  
        }
    
        // log_message('error', '#ERR787: Chitha owner array '.json_encode($chitha_arr_owner));
        // log_message('error', '#ERR789: Applied owner array '.json_encode($applicant_applied_array));
    
        $chitha_owner_array  = $chitha_arr_owner;
        $applied_owner_array = $applicant_applied_array;
    
        foreach($applied_owner_array as $arr){
    
            if(!in_array($arr, $chitha_owner_array))
            {
                log_message('error', '#ERR797: Mismatched Data ================');
                log_message('error', '#ERR797: Chitha Owner Data '.$chitha_owner_array);
                log_message('error', '#ERR797: Applied Owner Data '.$applied_owner_array);
                $json = [
                    'responseType' => 3,
                    'message'      => '#ERR797: Selected land owner(s) by applied applicant with chitha details are mismatched',
                ];
                return $json;
            }
        }
    }

    public function getRioteeList($d,$s,$c,$m,$l,$v,$dag,$khatian_no)
    {
      $get_riotees = $this->db->select()
          ->where('dist_code',$d)
          ->where('subdiv_code',$s)
          ->where('cir_code',$c)
          ->where('mouza_pargona_code',$m)
          ->where('lot_no',$l)
          ->where('vill_townprt_code',$v)
          ->where('dag_no',$dag)
          ->where('khatian_no',$khatian_no)

          ->get('chitha_tenant');

      return $get_riotees->result();
  }

  // get main buyer applicant
  public function getMainApplicant($case)
  {
      $applicants = $this->db->select()
          ->where('case_no',$case)
          ->where('pdar_type', 'B')
          ->where('is_applicant', '1')
          ->get('settlement_applicant');
      return $applicants->result();
  }

  public function getJsonDataFromBackup($case_no)
    {
        $sql = $this->db->query("SELECT data FROM settlement_backup_json WHERE case_no = ? AND status = ?", array($case_no, 'I'));
        if($sql->num_rows() > 0){
            return $sql->row();
        }
        else
        {
            return false;
        }
    }

    // get all settlement deleted dags
    public function getDeletedDags($case)
    {
        $dags = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_dag_details_deleted');

        return $dags->result();
    }

    public function getSettlementVgrReservation($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->get('settlement_vgr_pgr_reservation');
        return $lmnotes->row();
    }

    // get all settlement reservation roadside
    public function getSettlementReservationRoad($case)
    {
        $lmnotes = $this->db->select()
            ->where('case_no',$case)
            ->where('is_deleted', 0)
            ->where('type', 'R')
            ->get('settlement_reservation');

        return $lmnotes->result();
    }

    public function getClusterCases($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $service_code)
    {
        return $sqlProcessedCount = $this->db->query('select * from settlement_basic  where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and service_code = ? and status in (\'AA\', \'D\', \'F\') AND pending_officer IN (\'CO\')', array($dist_code, $subdiv_code, $cir_code, (string)$mouza_pargona_code, $lot_no, $vill_townprt_code, $service_code,));
    }

    public function getForwardedFromCO($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $service_code)
    {
        return $forwardFromCoSql = $this->db->query('select * from settlement_basic  where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and service_code = ? AND pending_officer NOT IN (\'LM\', \'SK\', \'CO\') AND status NOT IN (\'D\', \'F\')', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $service_code));
        // echo $this->db->last_query();
    }

    public function getNoticeData($case_no)
    {
        return $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ? order by id desc limit 1', array($case_no, 'GN'));
    }

    public function getNoticeDataReservation($case_no)
    {
        return $this->db->query('select * from settlement_notice where case_no = ? and notice_type = ? order by id desc limit 1', array($case_no, 'GNR'));
    }

    public function getVillageClusters($dist_code, $subdiv_code, $cir_code, $status, $service_code)
    {
        $sql = $this->db->query('select dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code from settlement_basic  where dist_code = ? and subdiv_code = ? and cir_code = ? and status = ? and service_code = ? group by dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_townprt_code', array($dist_code, $subdiv_code, $cir_code, $status, $service_code));

        if($sql->num_rows() <= 0)
        {
            return false;
        }

        //*******getting the cases in the cluster  */

        $result = $sql->result();

        $clusterList = array();

        foreach($result as $re)
        {
            $clusterCases = $this->getClusterCases($re->dist_code, $re->subdiv_code, $re->cir_code, $re->mouza_pargona_code, $re->lot_no, $re->vill_townprt_code,  $service_code);

            $getForwardedFromCO = $this->getForwardedFromCO($re->dist_code, $re->subdiv_code, $re->cir_code, $re->mouza_pargona_code, $re->lot_no, $re->vill_townprt_code,  $service_code);

            $url = API_LINK_MB2.'getCaseCountByVillage/'.$re->dist_code.'/'.$re->subdiv_code.'/'.$re->cir_code.'/'.$re->mouza_pargona_code.'/'.$re->lot_no.'/'.$re->vill_townprt_code.'/'.$service_code;

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'GET',
                CURLOPT_HTTPHEADER => array(
                    'Cookie: ci_session=p7qii4c6rijf4sujchqe2h8vc87u41lb'
                ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $total_application = 0;
            if($response != null)
            {
                $apiToalCase = json_decode($response);
                $total_application = (int)$apiToalCase[0]->total;
                $total_processed = (int)$clusterCases->num_rows() + (int)$getForwardedFromCO->num_rows();
            }

            $clusterList[] = (object)[
                'dist_code' => $re->dist_code,
                'subdiv_code' => $re->subdiv_code,
                'cir_code' => $re->cir_code,
                'mouza_pargona_code' => $re->mouza_pargona_code,
                'lot_no' => $re->lot_no,
                'vill_townprt_code' => $re->vill_townprt_code,
                'total_api_case' => $total_application,
                'total_clustered' => $total_processed,
                'mouza_name' => $this->utilityclass->getMouzaName($re->dist_code, $re->subdiv_code,$re->cir_code, $re->mouza_pargona_code),
                'lot_name' => $this->utilityclass->getLotName($re->dist_code, $re->subdiv_code,$re->cir_code, $re->mouza_pargona_code, $re->lot_no),
                'village_name' => $this->utilityclass->getVillageName($re->dist_code, $re->subdiv_code,$re->cir_code, $re->mouza_pargona_code, $re->lot_no, $re->vill_townprt_code),

                'completed_out_of' => $total_processed.'/'.$total_application,
            ];
        }

        return $clusterList;
    }

    public function getTotalVgrReservationInDag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no)
    {
        $message = array();

        $totalChitaLessa = $this->db->query('select SUM(dag_area_b*100 + dag_area_k*20 + dag_area_lc) AS chitha_total_lessa from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no))->row()->chitha_total_lessa;
        

        $sqlReservation = $this->db->query("select  string_agg(CONCAT('''', case_no, ''''), ',') as case_nos from settlement_vgr_pgr_reservation where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no));

        if($sqlReservation->num_rows() > 0)
        {
            $reservCaseNos = $sqlReservation->row()->case_nos;

            if($reservCaseNos != null)
            {
                $getTotalReservArea = $this->db->query("SELECT SUM(b.s_dag_area_b*100 + b.s_dag_area_k*20 + b.s_dag_area_lc) AS reserve_total_lessa FROM settlement_dag_details b join settlement_basic a on b.case_no = a.case_no WHERE a.case_no in ($reservCaseNos) and a.status != ?", array('D'));

                if($getTotalReservArea->num_rows() <= 0)
                {
                    $message = array(
                        'responseType' => 0,
                        'msg' => '<h5 class="text-danger text-center"><b>Reservation dag not found in chitha!</b></h5>'
                    );
                }
                else
                {
                    $getTotalReservArea = $getTotalReservArea->row()->reserve_total_lessa;

                    if($getTotalReservArea > $totalChitaLessa)
                    {
                        $message = array(
                            'responseType' => 0,
                            'msg' => '<h5 class="text-danger text-center"><b>Chitha area exceed for reservation location!</b></h5>'
                        );
        
                    }
                    else
                    {
                        $message = array(
                            'responseType' => 2,
                        );
                    }
                }
            }
            else
            {
                if($totalChitaLessa <= 0)
                {
                    $message = array(
                        'responseType' => 0,
                        'msg' => '<h5 class="text-danger text-center"><b>Chitha area exceed for reservation location!</b></h5>'
                    );
    
                }
                else
                {
                    $message = array(
                        'responseType' => 2,
                    );
                }
            }
           
        }
        else
        {
            if($totalChitaLessa <= 0)
            {
                $message = array(
                    'responseType' => 0,
                    'msg' => '<h5 class="text-danger text-center"><b>Chitha area exceed for reservation location!</b></h5>'
                );

            }
            else
            {
                $message = array(
                    'responseType' => 2,
                );
            }
        }

        return $message;
    }

    public function getTotalVgrReservationInDagSubmitCheck($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $total_applied_lessa)
    {
        $message = array();

        $totalChitaLessa = $this->db->query('select SUM(dag_area_b*100 + dag_area_k*20 + dag_area_lc) AS chitha_total_lessa from chitha_basic where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?', array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no))->row()->chitha_total_lessa;
        

        $sqlReservation = $this->db->query("select  string_agg(CONCAT('''', case_no, ''''), ',') as case_nos from settlement_vgr_pgr_reservation where dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and dag_no = ?", array($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no));

        if($sqlReservation->num_rows() > 0)
        {
            $reservCaseNos = $sqlReservation->row()->case_nos;

            if($reservCaseNos != null)
            {
                $getTotalReservArea = $this->db->query("SELECT SUM(b.s_dag_area_b*100 + b.s_dag_area_k*20 + b.s_dag_area_lc) AS reserve_total_lessa FROM settlement_dag_details b join settlement_basic a on b.case_no = a.case_no WHERE a.case_no in ($reservCaseNos) and a.status != ?", array('D'));

                if($getTotalReservArea->num_rows() <= 0)
                {
                    $message = array(
                        'responseType' => 0,
                        'msg' => '<h5 class="text-danger text-center"><b>Reservation dag not found in chitha!</b></h5>'
                    );
                }
                else
                {
                    $getTotalReservArea = $getTotalReservArea->row()->reserve_total_lessa;
    
                    if($getTotalReservArea + $total_applied_lessa > $totalChitaLessa)
                    {
                        $message = array(
                            'responseType' => 0,
                            'msg' => '<h5 class="text-danger text-center"><b>Chitha area exceed for reservation location!</b></h5>'
                        );
        
                    }
                    else
                    {
                        $message = array(
                            'responseType' => 2,
                        );
                    }
                }   
            }
            else
            {
                if($total_applied_lessa > $totalChitaLessa)
                {
                    $message = array(
                        'responseType' => 0,
                        'msg' => '<h5 class="text-danger text-center"><b>Chitha area exceed for reservation location!</b></h5>'
                    );
    
                }
                else
                {
                    $message = array(
                        'responseType' => 2,
                    );
                }
            }
           
        }
        else
        {
            // $getTotalReservArea = $getTotalReservArea->row()->reserve_total_lessa;

            if($total_applied_lessa > $totalChitaLessa)
            {
                $message = array(
                    'responseType' => 0,
                    'msg' => '<h5 class="text-danger text-center"><b>Chitha area exceed for reservation location!</b></h5>'
                );

            }
            else
            {
                $message = array(
                    'responseType' => 2,
                );
            }
        }

        return $message;
    }

}