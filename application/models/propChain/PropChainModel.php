<?php

class PropChainModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('propChain/PropChainCommonModel');
    }
    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', true);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', true);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', true);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', true);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', true);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', true);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', true);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', true);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', true);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', true);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', true);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', true);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', true);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', true);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', true);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', true);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', true);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', true);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', true);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', true);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', true);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', true);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', true);
        }
    }
    public function getPattaNo($district_code, $subdivision_code, $circle_code, $mouza_code, $lot_code, $village_code, $dag_no)
    {
        // $this->dbswitch();
        $district = $this->db->query("Select patta_no, dag_no, patta_type_code from chitha_basic where dist_code='$district_code' and subdiv_code='$subdivision_code' and "
            . "cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_No='$lot_code' "
            . "and vill_townprt_code='$village_code' and dag_no='$dag_no' order by length(patta_no),patta_no");

        return $district->row();
    }

    public function getLandType($class_code)
    {
        $query = $this->db->query("select class_code_cat from landclass_code where class_code='$class_code'");
        return $query->row()->class_code_cat;
    }

    public function getMutCaseData($case_no, $vill_code)
    {
        // $this->dbswitch();
        $case_data = $this->db->query("select patta_type_code, dag_no, patta_no from field_mut_dag_details where case_no='$case_no' and vill_townprt_code = '$vill_code'"); // and patta_no >= '$l'

        return $case_data->row();
    }

    public function getMutCaseDataRec($case_no, $vill_code)
    {
        // $this->dbswitch();

        $this->db->select(array('dag_no', 'patta_type_code', 'patta_no'));
        $case_data = $this->db->get_where('t_reclassification', array('case_no' => $case_no));

        return $case_data->row();
    }

    public function getMutCaseDataMisc($case_no, $vill_code)
    {
        // $this->dbswitch();

        $this->db->select(array('dag_no', 'patta_type_code', 'patta_no'));
        $case_data = $this->db->get_where('misc_case_basic', array('misc_case_no' => $case_no));

        return $case_data->row();
    }

    public function getCaseDataConv($case_no)
    {
        // $this->dbswitch();

        $this->db->select(array('dag_no', 'patta_type_code', 'patta_no'));
        $case_data = $this->db->get_where('petition_dag_details', array('case_no' => $case_no));

        return $case_data->row();
    }

    public function getMutCaseDataOfc($case_no)
    {
        // $this->dbswitch();

        $this->db->select('petition_no');
        $get_petition_no = $this->db->get_where('petition_basic', array('case_no' => $case_no));

        // var_dump($get_petition_no->row()->petition_no);
        // die;
        $petition_no = intval($get_petition_no->row()->petition_no);
        $this->db->select(array('dag_no', 'patta_type_code', 'patta_no'));
        $case_data = $this->db->get_where('petition_dag_details', array('petition_no' => $petition_no));

        return $case_data->row();
    }

    public function getCaseDataACPP($case_no)
    {
        // $this->dbswitch();

        $this->db->select(array('dag_no', 'patta_type_code', 'patta_no'));
        $case_data = $this->db->get_where('allotment_pet_dag', array('case_no' => $case_no));

        return $case_data->row();
    }

    public function getLegacyCaseData($case_no)
    {
        // $this->dbswitch();
        $case_data = $this->db->query("select patta_type_code, dag_no, patta_no from t_legacyupdation where case_no='$case_no'");

        return $case_data->row();
    }

    public function getCaseDataFpartBL($case_no)
    {
        // $this->dbswitch();
        $data = $this->db->get_where('t_chitha_col8_order', array('case_no' => $case_no))->row();

        $case_data = $this->getPattaNo($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code, $data->dag_no);

        return $case_data;
    }

    public function getCaseDataOpartBL($case_no)
    {
        // $this->dbswitch();
        $this->db->select(array('dag_no', 'patta_type_code', 'patta_no'));
        $case_data = $this->db->get_where('t_chitha_rmk_infavor_of', array('ord_no' => $case_no))->row();

        return $case_data;
    }

    public function getApCancelCaseData($case_no)
    {
        // $this->dbswitch();
        $this->db->select(array('dag_no', 'patta_type_code', 'patta_no'));
        $case_data = $this->db->get_where('apcancel_dag_details', array('case_no' => $case_no))->row();

        return $case_data;
    }

    public function getPattadars($d, $s, $c, $m, $l, $v, $pattano, $dag)
    {
        // $this->dbswitch();
        $query = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_add1,p.pdar_add2,p.pdar_add3,p.pdar_guard_reln,d.p_flag from chitha_pattadar p join chitha_dag_pattadar d
        on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code and p.lot_no = d.lot_no
        and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and p.pdar_id = d.pdar_id and p.patta_no = d.patta_no and p.patta_type_code = d.patta_type_code
        where p.dist_code='$d' and p.subdiv_code='$s' and p.cir_code='$c' and p.mouza_pargona_code='$m'
        and p.vill_townprt_code='$v' and d.lot_no='$l'
        and d.dag_no='$dag' and TRIM(p.patta_no)='$pattano' order by p.pdar_id";


        // echo $query;
        log_message('error','PATTADARQUERY--'.$query);
        // die;
        return $this->db->query($query)->result();
    }

    public function getLandArea($dist, $subdiv, $cir, $mouza, $lot, $vill, $patta_no, $dag_no)
    {
        // $this->dbswitch();
        $this->db->select(array('dag_area_b', 'dag_area_k', 'dag_area_lc', 'dag_area_g'));
        $case_data = $this->db->get_where('chitha_basic', array('dist_code' => $dist, 'subdiv_code' => $subdiv, 'cir_code' => $cir, 'mouza_pargona_code' => $mouza, 'lot_no' => $lot, 'vill_townprt_code' => $vill, 'dag_no' => $dag_no, 'patta_no' => $patta_no));

        return $case_data->row();
    }

    public function getLandArea2($case_no)
    {
        // $this->dbswitch();
        $this->db->select(array('dag_area_b', 'dag_area_k', 'dag_area_lc', 'dag_area_g'));
        $case_data = $this->db->get_where('petition_dag_details', array('case_no' => $case_no));

        return $case_data->row();
    }

    public function createPropBtn($property_id, $property_data, $propertysignature, $propertysignerkey, $dag_no)
    {
        // $button = '<a href="#!" id="' . $dag_no . '" property-id="' . $property_id . '" prop-data="' . base64_encode(json_encode($property_data)) . '" prop-sign="' . $propertysignature . '" prop-sign-key="' . $propertysignerkey . '" class="btn btn-info text-white create_prop_btn" onclick="return createPropertyChain(' . $dag_no . ');"><i class="fa fa-upload" style="margin:2px;" ></i>&nbsp;Create Property Chain for Dag ' . $dag_no . '</a>';
        // <a href="#!" title="" id="preview" name="preview" class="modal-show btn bg-success text-white">Preview</a>
        // $button = '<a href="#!" id="' . $dag_no . '" property-id="' . $property_id . '" prop-data="' . base64_encode(json_encode($property_data)) . '" prop-sign="' . $propertysignature . '" prop-sign-key="' . $propertysignerkey . '" class="btn btn-info text-white create_prop_btn" ><i class="fa fa-upload" style="margin:2px;" ></i>&nbsp;Create Property Chain for Dag ' . $dag_no . '</a>';
        // echo "<pre>";
        // var_dump(base64_encode(json_encode($property_data, JSON_PRETTY_PRINT)));
        // die;
        // $button = '<a href="#!" id="dsc_sign_btn_id" property-id="' . $property_id . '" prop-data="' . base64_encode(json_encode($property_data, JSON_PRETTY_PRINT)) . '" dag-no="' . $dag_no . '" class="modal-show-dsc btn btn-info text-white create_prop_btn"><i class="fa fa-upload" style="margin:2px;" ></i>&nbsp;Create Property Chain for Dag ' . $dag_no . '</a>';

        $button = '<a href="#!" id="dsc_sign_btn_id" property-id="' . $property_id . '" prop-data="' . base64_encode(json_encode(json_decode(json_encode($property_data)))) . '" dag-no="' . $dag_no . '" class="modal-show-dsc btn btn-info text-white create_prop_btn"><i class="fa fa-upload" style="margin:2px;" ></i>&nbsp;Sign Property Chain for Dag ' . $dag_no . '</a>';

        


        return $button;
    }

    public function updateMapBtn($property_id, $property_data, $propertysignature, $propertysignerkey, $dag_no)
    {
        $button = '<a href="#!" id="' . $dag_no . '" property-id="' . $property_id . '" prop-data="' . base64_encode(json_encode($property_data)) . '" prop-sign="' . $propertysignature . '" prop-sign-key="' . $propertysignerkey . '" class="btn btn-info text-white create_prop_btn" onclick="return updateMap(' . $dag_no . ');"><i class="fa fa-upload" style="margin:2px;" ></i>&nbsp;Update Map for Dag ' . $dag_no . '</a>';

        return $button;
    }

    // public function getPropCreateBtn($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $patta_no, $patta_type_code, $bigha, $katha, $lessa)
    // {
    //     $this->dbswitch();
    //     $getPattadars = $this->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

    //     $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code;

    //     $property_id = LOC_TYPE_RURAL . '-' . $vill_townprt_code . '-' . $patta_no . '-' . $dag_no . '-' . $location_id;

    //     $landclass_code = $this->getLandClassCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

    //     $pattadar_chain = array();
    //     foreach ($getPattadars as $pdars) {
    //         $nestedData = array(
    //             'pdarid' => $pdars->pdar_id,
    //             'pdarname' => $pdars->pdar_name,
    //             'pdarfather' => $pdars->pdar_father,
    //             'pdarstrikeout' => $pdars->p_flag
    //         );

    //         $pattadar_chain[] = $nestedData;
    //     }

    //     $property_data = array(
    //         'location' => $location_id,
    //         'dagno' => $dag_no,
    //         'pattano' => $patta_no,
    //         'pattatype' => $patta_type_code,
    //         'landclass' => $landclass_code,
    //         'bigha' => $bigha,
    //         'katha' => $katha,
    //         'lessa' => $lessa,
    //         'pid' => $pattadar_chain
    //     );

    //     $propertysignature = "base64 encoded signature";
    //     $propertysignerkey = "base64 encoded public key";

    //     // create a button to push new property to property chain
    //     $prop_chain_button = $this->PropChainModel->createPropBtn($property_id, $property_data, $propertysignature, $propertysignerkey, $dag_no);

    //     return $prop_chain_button;
    // }

    public function getPropCreateBtn($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $patta_no, $patta_type_code, $bigha, $katha, $lessa, $ganda, $revenue, $local_tax, $ulpin, $old_ulpin)
    {
        // $this->dbswitch();
        $getPattadars = $this->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

        $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code;

        $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $vill_townprt_code, $patta_no, $dag_no, $ulpin);
        $landclass_code = $this->getLandClassCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

        // $dag_revenue = $this->getDagRevenue($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

        // $revenue = $dag_revenue->dag_revenue;
        // $local_tax = $dag_revenue->dag_local_tax;

        // $old_ulpin = ""; // send old upin empty

        $property_data = $this->blockchainutilityclass->getCreatePropArray($getPattadars, $location_id, $patta_no, $dag_no, $landclass_code, $patta_type_code, $bigha, $katha, $lessa, $ulpin, $old_ulpin, $revenue, $local_tax, $ganda);
        // echo "<pre>";

        // var_dump($property_data);
        // die;
        // $property_data = array(
        //     'ulpin' => $ulpin,
        //     'old_ulpin' => $old_ulpin,
        //     'location' => $location_id,
        //     'dagno' => $dag_no,
        //     'pattano' => $patta_no,
        //     'pattatype' => $patta_type_code,
        //     'landclass' => $landclass_code,
        //     'revenue' => $revenue,
        //     'localtax' => $local_tax,
        //     'bigha' => $bigha,
        //     'katha' => $katha,
        //     'lessa' => $lessa,
        //     'ganda' => $ganda,
        //     'pid' => $getPattadars
        // );

        $propertysignature = "base64 encoded signature";
        $propertysignerkey = "base64 encoded public key";

        // create a button to push new property to property chain
        $prop_chain_button = $this->PropChainModel->createPropBtn($property_id, $property_data, $propertysignature, $propertysignerkey, $dag_no);

        return $prop_chain_button;
    }

    public function getMapUpdateBtn($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $patta_no, $patta_type_code, $bigha, $katha, $lessa, $ganda, $revenue, $local_tax)
    {
        // $this->dbswitch();
        $getPattadars = $this->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

        $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code;

        $property_id = LOC_TYPE_RURAL . '-' . $vill_townprt_code . '-' . $patta_no . '-' . $dag_no . '-' . $location_id;

        $landclass_code = $this->getLandClassCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

        $property_data = array(
            'location' => $location_id,
            'dagno' => $dag_no,
            'pattano' => $patta_no,
            'pattatype' => $patta_type_code,
            'landclass' => $landclass_code,
            'revenue' => $revenue,
            'localtax' => $local_tax,
            'bigha' => $bigha,
            'katha' => $katha,
            'lessa' => $lessa,
            'ganda' => $ganda,
            'pid' => $getPattadars,
        );

        $propertysignature = "base64 encoded signature";
        $propertysignerkey = "base64 encoded public key";

        // create a button to push new property to property chain
        $prop_chain_button = $this->PropChainModel->updateMapBtn($property_id, $property_data, $propertysignature, $propertysignerkey, $dag_no);

        return $prop_chain_button;
    }

    public function getLandClassCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no)
    {
        // $this->dbswitch();
        $this->db->select('land_class_code');
        $landclass = $this->db->get_where('chitha_basic', array('dist_code' => $dist_code, 'subdiv_code' => $subdiv_code, 'cir_code' => $cir_code, 'mouza_pargona_code' => $mouza_pargona_code, 'lot_no' => $lot_no, 'vill_townprt_code' => $vill_townprt_code, 'patta_no' => $patta_no, 'dag_no' => $dag_no));

        return $landclass->row()->land_class_code;
    }

    public function updateCmpFlag($case_no, $flag)
    {
        // $this->dbswitch();
        $get_service = explode('/', $case_no);
        $service_type = $get_service[4];
        // var_dump($service_type, $flag);
        // die;
        if ($service_type == 'FMUT' || $service_type == 'FPART' || $service_type == 'FMUT-BL') {
            $q = "update field_mut_basic set chitha_chain_cmp_flag='$flag' where case_no='$case_no' ";
        } elseif ($service_type == 'OMUT' || $service_type == 'OPART' || $service_type == 'CONV' || $service_type == 'OMUT-BL' || $service_type == 'CONV-BL' || $service_type == 'OMUTC' || $service_type == 'OPARTC') {
            $q = "update petition_basic set chitha_chain_cmp_flag='$flag' where case_no='$case_no' ";
        } elseif ($service_type == 'RECLASS') {
            $q = "update t_reclassification set chitha_chain_cmp_flag='$flag' where case_no='$case_no' ";
        } elseif ($service_type == 'MiNC' || $service_type == 'MiND') {
            $q = "update misc_case_basic set chitha_chain_cmp_flag='$flag' where misc_case_no='$case_no' ";
        } elseif ($service_type == 'ACPP' || $service_type == 'STPP') {
            $q = "update allotment_cert_basic set chitha_chain_cmp_flag='$flag' where case_no='$case_no' ";
        } elseif ($service_type == 'LDU') {
            $q = "update t_legacyupdation set chitha_chain_cmp_flag='$flag' where case_no='$case_no' ";
        } elseif ($service_type == 'FPART-BL') {
            $q = "update t_chitha_col8_order set chitha_chain_cmp_flag='$flag' where case_no='$case_no' ";
        } elseif ($service_type == 'OPART-BL') {
            $q = "update t_chitha_rmk_ordbasic set chitha_chain_cmp_flag='$flag' where case_no='$case_no' ";
        } elseif ($service_type == 'NR') {
            $q = "update t_chitha_rmk_ordbasic set chitha_chain_cmp_flag='$flag' where case_no='$case_no' ";
        }

        $result = $this->db->query($q);

        return $result;
    }

    public function getMismatchCount($mutation_type, $dist_code, $subdiv_code, $cir_code)
    {
        // $this->dbswitch();
        $define_date = define_date;
        $year_no = year_no;

        return $this->db->query("select count(*) as count from   field_mut_basic where order_passed is null and is_dispose is null and date_entry>='$define_date' and chitha_chain_cmp_flag='N' and mut_type='$mutation_type' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->row()->count;
    }

    public function getMismatchCases($mutation_type)
    {
        // $this->dbswitch();
        $define_date = define_date;
        $year_no = year_no;
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        return $this->db->query("select * from   field_mut_basic where order_passed is null and is_dispose is null and date_entry>='$define_date' and chitha_chain_cmp_flag='N' and mut_type='$mutation_type' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code'")->result();
    }

    public function getUserChainTransactions($user_code)
    {
        // $this->dbswitch();
        // $result = $this->db->get_where('prop_chain_transaction', array('user_code' => $user_code));
        // $query = "select distinct(property_id), * from prop_chain_transaction where user_code='$user_code' order by datetime desc";
        $query = "select distinct on (property_id) * from prop_chain_transaction where user_code='$user_code' order by property_id, datetime desc nulls last";

        $result = $this->db->query($query);

        return $result->result();
    }

    public function getPatnPdar($case_no)
    {
        // $this->dbswitch();

        $this->db->select('pdar_id', 'pdar_name');
        $query = $this->db->get_where('field_part_petitioner', array('case_no' => $case_no));

        return $query->result();
    }

    public function getPetnPdar($case_no)
    {
        // $this->dbswitch();

        $this->db->select('pdar_id,pet_name');
        $query = $this->db->get_where('field_mut_petitioner', array('case_no' => $case_no));
        $masterArray = array();
        foreach ($query->result() as $key => $value) {
            $masterArray[$key]['pdar_id'] = $value->pdar_id;
            $masterArray[$key]['pdar_name'] = $value->pet_name;
        }
        return $masterArray;
    }

    public function getOfcMutPdar($case_no)
    {
        // $this->dbswitch();
        // petitioner and petition_pattadar
        $petition_no = $this->getPetitionNoOfc($case_no);

        $this->db->select('pet_name');
        $petitioner = $this->db->get_where('petitioner', array('petition_no' => $petition_no))->result();

        $this->db->select('pdar_id', 'pdar_name');
        $petition_pdar = $this->db->get_where('petition_pattadar', array('petition_no' => $petition_no))->result();

        return array_merge($petitioner, $petition_pdar);

        // $this->db->select()
    }

    public function getOfcPatnPdar($case_no)
    {
        // $this->dbswitch();
        // petitioner and petition_pattadar
        $petition_no = $this->getPetitionNoOfc($case_no);

        $this->db->select('pdar_id', 'pdar_name');
        $petitioner = $this->db->get_where('petitioner_part', array('petition_no' => $petition_no))->result();

        return $petitioner;
    }

    public function getPetitionNoOfc($case_no)
    {
        // $this->dbswitch();

        $this->db->select('petition_no');
        $query = $this->db->get_where('petition_basic', array('case_no' => $case_no));

        return $query->row()->petition_no;
    }

    public function getOccupPdar($case_no)
    {
        // $this->dbswitch();

        $this->db->select('pdar_id,pdar_name');
        $query = $this->db->get_where('field_mut_pattadar', array('case_no' => $case_no));

        return $query->result();
    }

    public function chainTransactionInsert($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag, $patta, $land_class_code, $patta_type_code, $property_id, $transaction_id, $certmnemonic, $case_no, $user_code, $ulpin)
    {
        // $this->dbswitch();

        $transaction_data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag,
            'patta_no' => $patta,
            'land_class_code' => $land_class_code,
            'patta_type_code' => $patta_type_code,
            'property_id' => $property_id,
            'transaction_id' => $transaction_id,
            'datetime' => date('Y-m-d H:i:s'),
            'reference_id' => $certmnemonic . ':' . $case_no,
            'ip_address' => $this->input->ip_address(),
            'user_code' => $user_code,
            'ulpin' => $ulpin,
        );
        $transaction_insert = $this->db->insert('prop_chain_transaction', $transaction_data);

        return $transaction_insert;
    }

    public function chainTransactionInsertBulk($bulk_data)
    {
        // $this->dbswitch();

        try {
            $this->db->insert_batch('prop_chain_transaction', $bulk_data);

            return $this->db->affected_rows();
        } catch (Exception $e) {
            log_message('error', '#Bulk insert exception. Message: ' . $e->getMessage() . 'error-code: ' . $e->getCode());
        }
    }

    public function get_transaction_array($data)
    {
        $transaction_data = array(
            'dist_code' => $data->dist_code,
            'subdiv_code' => $data->subdiv_code,
            'cir_code' => $data->cir_code,
            'mouza_pargona_code' => $data->mouza_pargona_code,
            'lot_no' => $data->lot_no,
            'vill_townprt_code' => $data->vill_townprt_code,
            'dag_no' => $data->dag,
            'patta_no' => $data->patta,
            'land_class_code' => $data->land_class_code,
            'patta_type_code' => $data->patta_type_code,
            'property_id' => $data->property_id,
            'transaction_id' => $data->transaction_id,
            'datetime' => date('Y-m-d H:i:s'),
            'reference_id' => $data->certmnemonic . ':' . $data->case_no,
            'ip_address' => $this->input->ip_address(),
            'user_code' => $data->user_code,
            'ulpin' => $data->ulpin,
        );

        return $transaction_data;
    }

    public function insertUlpinDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $patta_no, $dag_no, $patta_type_code, $land_class_code, $old_ulpin, $new_ulpin)
    {
        // $this->dbswitch();
        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $circle_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_code,
            'patta_no' => $patta_no,
            'dag_no' => $dag_no,
            'patta_type_code' => $patta_type_code,
            'land_class_code' => $land_class_code,
            'old_ulpin' => $old_ulpin,
            'new_ulpin' => $new_ulpin,
            'datetime' => date('Y-m-d H:i:s'),
        );

        $insert = $this->db->insert('ulpin_details', $data);

        return $insert;
    }

    // public function updateUlpinDetails

    // public function chainChithaUlpinCheckProcess($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no, $dag_area_b, $dag_area_k, $dag_area_lc, $dag_area_g, $patta_type_code)
    // {
    //     $office_code = $this->session->userdata('cir_code');
    //     $user_code = $this->session->userdata('user_code');

    //     $locationId = $this->blockchainutilityclass->generateLocId($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

    //     $pattadars = $this->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

    //     $gisCode = $this->blockchainutilityclass->generateGisCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

    //     ////////////////////////////////////////// check and get ulpin (START) //////////////////////////////////////////////////////
    //     //First check in the database
    //     $checkUlpin = $this->getUlpin($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

    //     if ($checkUlpin->ulpin == null || $checkUlpin->ulpin == '') {
    //         //then if ULPIN not found in db call the get ulpin API
    //         $checkUlpin2 = $this->blockchainutilityclass->checkUlpin($gisCode, ASSAM_STATE_CODE, $dag_no);
    //         // var_dump($gisCode, ASSAM_STATE_CODE,  $dag_no, $checkUlpin2);
    //         // die;
    //         $data['ulpinCheck'] = $checkUlpin2['success'];
    //         $data['ulpinMsg'] = $checkUlpin2['message'];

    //         if ($data['ulpinCheck'] == 1) {
    //             $data['ulpin'] = $checkUlpin2['ulpin'];
    //         } else {
    //             $data['ulpin'] = "";
    //         }
    //     } elseif (isset($checkUlpin->ulpin) && ($checkUlpin->ulpin != null || $checkUlpin->ulpin != '')) {
    //         $data['ulpinCheck'] = 1;
    //         // $data['ulpinMsg'] = "<b><h4 class = 'bg-green text-white text-center' style='padding:4px;'><span><i class='fa fa-check'></i></span> Ulpin found for the property.</h4></b>";
    //         $data['ulpinMsg'] = "Ulpin found for the property.";

    //         $data['ulpin'] = $checkUlpin->ulpin;
    //         if ($checkUlpin->old_ulpin == null) {
    //             $data['old_ulpin'] = "";
    //         } else {
    //             $data['old_ulpin'] = $checkUlpin->old_ulpin;
    //         }
    //     } else {
    //         $data['ulpinCheck'] = 0;
    //         // $data['ulpinMsg'] = "<p><b><h4 class = 'bg-danger text-white text-center' style='padding:4px;'><span><i class='fa fa-warning'></i></span> Something went wrong.</h4></b></p>";
    //         $data['ulpinMsg'] = "Something went wrong.";

    //         $data['ulpin'] = "";
    //     }

    //     /////////////////////////////////////////// check and get ulpin (END) ///////////////////////////////////////////////////////////

    //     $checkPropAndChitha = $this->blockchainutilityclass->checkPropAndChitha($user_code, $office_code, $locationId, $patta_no, $dag_no, $pattadars, $dag_area_b, $dag_area_k, $dag_area_lc, $dag_area_g, $data['ulpin']);

    //     $revenue_details = $this->getDagRevenue($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

    //     $revenue = $revenue_details->dag_revenue;
    //     $local_tax = $revenue_details->dag_local_tax;

    //     // if property does not exists call property create button
    //     if ($checkPropAndChitha['compareFlag'] == 'NE') {

    //         $get_old_ulpin = $this->get_old_ulpin($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);
    //         if ($get_old_ulpin->old_ulpin == null || $get_old_ulpin->old_ulpin == "") {
    //             $old_ulpin = "";
    //         } else {
    //             $old_ulpin = $get_old_ulpin->old_ulpin;
    //         }
    //         $createChainPropBtn = $this->getPropCreateBtn(
    //             $dist_code,
    //             $subdiv_code,
    //             $cir_code,
    //             $mouza_pargona_code,
    //             $lot_no,
    //             $vill_townprt_code,
    //             $dag_no,
    //             $patta_no,
    //             $patta_type_code,
    //             $dag_area_b,
    //             $dag_area_k,
    //             $dag_area_lc,
    //             $dag_area_g,
    //             $revenue,
    //             $local_tax,
    //             $data['ulpin'],
    //             $old_ulpin
    //         );

    //         $data['createPropChainBtn'] = $createChainPropBtn;
    //     }

    //     if (isset($checkPropAndChitha['oldulpin'])) {
    //         $data['old_ulpin'] = $checkPropAndChitha['oldulpin'];
    //     }

    //     $data['revenue'] = $revenue;
    //     $data['local_tax'] = $local_tax;
    //     $data['chithaPropChainCmpFlag'] = $checkPropAndChitha['compareFlag'];
    //     $data['compareFlagMsg'] = $checkPropAndChitha['message'];

    //     $ulpinFlag = $data['ulpinCheck'];
    //     $ulpinMsg = $data['ulpinMsg'];
    //     $compareFlag = $checkPropAndChitha['compareFlag'];
    //     $compareMsg = $checkPropAndChitha['message'];

    //     // hidden fields
    //     $data['ulpin_hidden'] = "<input type='hidden' name='ulpinFlag' id='ulpinFlag' value='$ulpinFlag'>";
    //     $data['uplpin_msg_hidden'] = "<input type='hidden' name='ulpinMsg' id='ulpinMsg' value='$ulpinMsg'>";
    //     $data['compare_hidden'] = "<input type='hidden' name='compareFlag' id='compareFlag' value='$compareFlag'>";
    //     $data['compare_msg_hidden'] = "<input type='hidden' name='compareMsg' id='compareMsg' value='$compareMsg'>";

    //     return $data;
    // }

    public function chainChithaUlpinCheckProcess($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no, $dag_area_b, $dag_area_k, $dag_area_lc, $dag_area_g, $patta_type_code)
    {
        $office_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $locationId = $this->blockchainutilityclass->generateLocId($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        $pattadars = $this->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

        $gisCode = $this->blockchainutilityclass->generateGisCode($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code);

        ////////////////////////////////////////// check and get ulpin (START) //////////////////////////////////////////////////////
        //First check in the database
        $checkUlpin = $this->getUlpin($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

        // edited for comparision of bhunaksha land area and chitha land area
        $get_bhunaksha_area = json_decode($this->blockchainutilityclass->getGeoJsonAPI(ASSAM_STATE_CODE, $gisCode, $dag_no));
        // echo "<pre>";
        // var_dump($get_bhunaksha_area);
        // die;
        $bhunaksha_area = null;
        if ($get_bhunaksha_area != null && isset($get_bhunaksha_area->features[0]->properties->Area)) {
            $bhunaksha_area = $get_bhunaksha_area->features[0]->properties->Area;
        }

        if ($checkUlpin->ulpin == null || $checkUlpin->ulpin == '') {
            $checkUlpin2 = $this->blockchainutilityclass->checkUlpin($gisCode, ASSAM_STATE_CODE, $dag_no);
            // var_dump($checkUlpin2);
            // die;
            $data['ulpinCheck'] = $checkUlpin2['success'];
            $data['ulpinMsg'] = $checkUlpin2['message'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $checkUlpin2['ulpin'];
            } else {
                $data['ulpin'] = "";
            }
        } elseif (isset($checkUlpin->ulpin) && ($checkUlpin->ulpin != null || $checkUlpin->ulpin != '')) {
            $data['ulpinCheck'] = 1;
            // $data['ulpinMsg'] = "<b><h4 class = 'bg-green text-white text-center' style='padding:4px;'><span><i class='fa fa-check'></i></span> Ulpin found for the property.</h4></b>";
            $data['ulpinMsg'] = "Ulpin found for the property.";

            $data['ulpin'] = $checkUlpin->ulpin;
            if ($checkUlpin->old_ulpin == null) {
                $data['old_ulpin'] = "";
            } else {
                $data['old_ulpin'] = $checkUlpin->old_ulpin;
            }
        } else {
            $data['ulpinCheck'] = 0;
            // $data['ulpinMsg'] = "<p><b><h4 class = 'bg-danger text-white text-center' style='padding:4px;'><span><i class='fa fa-warning'></i></span> Something went wrong.</h4></b></p>";
            $data['ulpinMsg'] = "Something went wrong.";

            $data['ulpin'] = "";
        }

        /////////////////////////////////////////// check and get ulpin (END) ///////////////////////////////////////////////////////////

        $checkPropAndChitha = $this->blockchainutilityclass->checkPropAndChitha($user_code, $office_code, $locationId, $patta_no, $dag_no, $pattadars, $dag_area_b, $dag_area_k, $dag_area_lc, $dag_area_g, $data['ulpin'], $bhunaksha_area);
        // echo "<pre>";
        // var_dump($checkPropAndChitha);
        // die;

        $revenue_details = $this->getDagRevenue($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

        if(ALLOW_LANDREVENUE_FOR_BLOCKCHAIN == 1)
        {
            $revenue = $revenue_details->dag_revenue;
            $local_tax = $revenue_details->dag_local_tax;
        }
        else
        {
            $revenue = '0.00';
            $local_tax = '0.00';
        }

        

        // if property does not exists call property create button
        if ($checkPropAndChitha['compareFlag'] == 'NE') {

            $get_old_ulpin = $this->get_old_ulpin($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);
            if ($get_old_ulpin->old_ulpin == null || $get_old_ulpin->old_ulpin == "") {
                $old_ulpin = "";
            } else {
                $old_ulpin = $get_old_ulpin->old_ulpin;
            }
            $createChainPropBtn = $this->getPropCreateBtn(
                $dist_code,
                $subdiv_code,
                $cir_code,
                $mouza_pargona_code,
                $lot_no,
                $vill_townprt_code,
                $dag_no,
                $patta_no,
                $patta_type_code,
                $dag_area_b,
                $dag_area_k,
                $dag_area_lc,
                $dag_area_g,
                $revenue,
                $local_tax,
                $data['ulpin'],
                $old_ulpin
            );

            $data['createPropChainBtn'] = $createChainPropBtn;
        }

        if (isset($checkPropAndChitha['oldulpin'])) {
            $data['old_ulpin'] = $checkPropAndChitha['oldulpin'];
        }

        /////////////// edit for bhunaksha and chitha area comparision///////////////////
        $get_bhu_cmp_status = explode('_', $checkPropAndChitha['bhu_chitha_area_cmp_status']);

        $data['bhuChithaCmpStatus'] = $get_bhu_cmp_status[0];

        if ($get_bhu_cmp_status[0] == 0)
            $bhun_cmp_msg =  $data['bhuChithaCmpMsg'] = $get_bhu_cmp_status[1] . ". Bhunaksha area: " . $get_bhu_cmp_status[2] . ", Chitha area: " . $get_bhu_cmp_status[3];
        else
            $bhun_cmp_msg = $data['bhuChithaCmpMsg'] = $get_bhu_cmp_status[1] . ". Bhunaksha area: " . $get_bhu_cmp_status[2] . ", Chitha area: " . $get_bhu_cmp_status[3];

        $data['bhun_cmp_msg'] = $bhun_cmp_msg;
        // var_dump($data['bhuChithaCmpMsg']);
        // die;
        /////////////////////////////////////////////////////////////////////////////////

        $data['revenue'] = $revenue;
        $data['local_tax'] = $local_tax;
        $data['chithaPropChainCmpFlag'] = $checkPropAndChitha['compareFlag'];
        $data['compareFlagMsg'] = $checkPropAndChitha['message'];

        $ulpinFlag = $data['ulpinCheck'];
        $ulpinMsg = $data['ulpinMsg'];
        $compareFlag = $checkPropAndChitha['compareFlag'];
        $compareMsg = $checkPropAndChitha['message'];

        // hidden fields
        $data['ulpin_hidden'] = "<input type='hidden' name='ulpinFlag' id='ulpinFlag' value='$ulpinFlag'>";
        $data['uplpin_msg_hidden'] = "<input type='hidden' name='ulpinMsg' id='ulpinMsg' value='$ulpinMsg'>";
        $data['compare_hidden'] = "<input type='hidden' name='compareFlag' id='compareFlag' value='$compareFlag'>";
        $data['compare_msg_hidden'] = "<input type='hidden' name='compareMsg' id='compareMsg' value='$compareMsg'>";
        $data['bhu_hidden'] = "<input type='hidden' name='bhuCompareFlag' id='bhuCompareFlag' value='$get_bhu_cmp_status[0]'>";
        $data['bhu_compare_msg_hidden'] = "<input type='hidden' name='bhuCompareMsg' id='bhuCompareMsg' value='$bhun_cmp_msg '>";

        return $data;
    }

    public function get_old_ulpin($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no)
    {
        // $this->dbswitch();

        $this->db->select('old_ulpin');
        $get_old_ulpin = $this->db->get_where('chitha_basic', array('dist_code' => $dist_code, 'subdiv_code' => $subdiv_code, 'cir_code' => $cir_code, 'mouza_pargona_code' => $mouza_pargona_code, 'lot_no' => $lot_no, 'vill_townprt_code' => $vill_townprt_code, 'dag_no' => $dag_no))->row();

        return $get_old_ulpin;
    }

    public function checkGetUlpin($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no)
    {

        $checkInDb = $this->getUlpin($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no);

        if ($checkInDb->ulpin == null || $checkInDb->ulpin == '') {
            $gisCode = $dist_code . '_' . $subdiv_code . '_' . $cir_code . '_' . $mouza_pargona_code . '_' . $lot_no . '_' . $vill_townprt_code;
            $checkApi = $this->blockchainutilityclass->checkUlpin($gisCode, ASSAM_STATE_CODE, $dag_no);

            $data['ulpinCheck'] = $checkApi['success'];
            // $data['ulpinMsg'] = $checkApi['message'];

            if ($data['ulpinCheck'] == 1) {
                $data['ulpin'] = $checkApi['ulpin'];
            } else {
                $data['ulpin'] = "";
            }
        } elseif (isset($checkInDb->ulpin) && ($checkInDb->ulpin != null || $checkInDb != '')) {
            $data['ulpinCheck'] = 1;

            $data['ulpin'] = $checkInDb->ulpin;
            if ($checkInDb->old_ulpin == null) {
                $data['old_ulpin'] = "";
            } else {
                $data['old_ulpin'] = $checkInDb->old_ulpin;
            }
        } else {
            $data['ulpinCheck'] = 0;
            $data['ulpin'] = "";
        }

        return $data;
    }

    public function getUlpin($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no)
    {
        // $this->dbswitch();
        // $this->db->select(array('old_ulpin', 'new_ulpin'));
        // $result = $this->db->get_where('ulpin_details', array('dist_code' => $dist_code, 'subdiv_code' => $subdiv_code, 'cir_code' => $cir_code, 'mouza_pargona_code' => $mouza_pargona_code, 'lot_no' => $lot_no, 'vill_townprt_code' => $vill_townprt_code, 'patta_no' => $patta_no, 'dag_no' => $dag_no));

        $this->db->select(array('old_ulpin', 'ulpin'));
        $result = $this->db->get_where('chitha_basic', array('dist_code' => $dist_code, 'subdiv_code' => $subdiv_code, 'cir_code' => $cir_code, 'mouza_pargona_code' => $mouza_pargona_code, 'lot_no' => $lot_no, 'vill_townprt_code' => $vill_townprt_code, 'patta_no' => $patta_no, 'dag_no' => $dag_no));


        return $result->row();
    }

    public function getDagRevenue($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no)
    {
        // $this->dbswitch();

        $this->db->select(array('dag_revenue', 'dag_local_tax'));
        $result = $this->db->get_where('chitha_basic', array('dist_code' => $dist_code, 'subdiv_code' => $subdiv_code, 'cir_code' => $cir_code, 'mouza_pargona_code' => $mouza_pargona_code, 'lot_no' => $lot_no, 'vill_townprt_code' => $vill_townprt_code, 'dag_no' => $dag_no, 'patta_no' => $patta_no))->row();

        return $result;
    }

    public function getMismatchBtn($case_no, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_no, $dag_no, $dag_area_b, $dag_area_k, $dag_area_lc, $dag_area_g, $patta_type_code)
    {
        $base_url = base_url();
        $btn = '<div class="row text-center">
        <div class="d-flex flex-row justify-content-center">
                       <a class="btn btn-primary" href="' . $base_url . 'index.php/PropChainReport/viewMismatchCase?case_no=' . $case_no . '&dist_code=' . $dist_code . '&subdiv_code=' . $subdiv_code . '&cir_code=' . $cir_code . '&mouza_pargona_code=' . $mouza_pargona_code . '&lot_no=' . $lot_no . '&vill_townprt_code=' . $vill_townprt_code . '&patta_no=' . $patta_no . '&dag_no=' . $dag_no . '&dag_area_b=' . $dag_area_b . '&dag_area_k=' . $dag_area_k . '&dag_area_lc=' . $dag_area_lc . '&dag_area_g=' . $dag_area_g . '&patta_type_code=' . $patta_type_code . '"><i class="fa fa-eye text-white"></i> View Mismatch case</a>
                   </div>
               </div>';

        return $btn;
    }

    public function ulpinUpdateChtBsc($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $pattano, $dagno, $pattatype, $landclass, $old_ulpin, $ulpin)
    {

        // $this->dbswitch();

        $query = "update chitha_basic set ulpin='$ulpin',map_for_property='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$dagno' and patta_no ='$pattano' and patta_type_code='$pattatype' and land_class_code ='$landclass'";
        $this->db->query($query);

        return $this->db->affected_rows();
    }

    public function updateBhuMapDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $dagno)
    {

        // $this->dbswitch();
        $query = "update bhun_map_creation_cases set map_for_property='Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and dag_no='$dagno'";
        $this->db->query($query);
        return $this->db->affected_rows();
    }

    public function getRemainingLandArea($m_dag_area_b, $m_dag_area_k, $m_dag_area_lc, $m_dag_area_g, $dag_area_b, $dag_area_k, $dag_area_lc, $dag_area_g)
    {
        $source_lessa = $dag_area_b * 100 + $dag_area_k * 20 + $dag_area_lc;

        $applied_lessa = $m_dag_area_b * 100 + $m_dag_area_k * 20 + $m_dag_area_lc;

        $remaining_lessa = $source_lessa - $applied_lessa;
        // $remaining_lessa = 100;
        $data['remaining_land'] = $remaining_lessa;
        if ($remaining_lessa > 0) {
            $data['message'] = "<b><h4 class = 'bg-danger text-white text-center' style='padding:4px;'><span><i class='fa fa-close'></i></span> The case will be on hold until a new map is generated for the new land.</h4></b>";
            $data['flag'] = 0;
        } elseif ($remaining_lessa == 0) {
            $data['message'] = "<b><h4 class = 'bg-green text-white text-center' style='padding:4px;'><span><i class='fa fa-check'></i></span> The Final order for the case can be passed.</h4></b>";
            $data['flag'] = 1;
        }

        return $data;
    }

    public function createAssetAndUptMap($pattadar_details, $create_prop_data, $gis_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $property_id, $location_id, $user_code, $office_code, $property_signature, $property_signer_key, $old_dag_no, $old_patta_no, $old_patta_type_code)
    {
        // $this->dbswitch();
        $state = ASSAM_STATE_CODE;
        // check if ulpin exists and get GeoJson Data
        $getUlPin = $this->blockchainutilityclass->getGeoJsonAPI($state, $gis_code, $old_dag_no);

        $ulpinDetails = json_decode($getUlPin);

        // $this->db->trans_begin();

        if (!empty($ulpinDetails->features) && $ulpinDetails->features[0]->properties->pniu != null) {
            $ulpin = $ulpinDetails->features[0]->properties->pniu;
            $geomType = $ulpinDetails->features[0]->geometry->type;
            $coordinates = $ulpinDetails->features[0]->geometry->coordinates;
            $old_ulpin = "";

            $insertUlpinDetails = $this->insertUlpinDetails($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $create_prop_data['pattano'], $create_prop_data['dagno'], $create_prop_data['pattatype'], $create_prop_data['landclass'], $old_ulpin, $ulpin);

            if ($insertUlpinDetails) {

                $result = $this->blockchainutilityclass->propChainCreateApi($create_prop_data, $user_code, $office_code, $property_id, $property_signature, $property_signer_key);

                if ($result->success == 1) {
                    $this->chainTransactionInsert($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $create_prop_data['dagno'], $create_prop_data['pattano'], $create_prop_data['landclass'], $create_prop_data['pattatype'], $property_id, $result->transaction_id, CERTMNEMONIC_ROR, $property_id, $user_code, $ulpin);

                    $ulpinChainUpdData = $this->blockchainutilityclass->getMapUpdateArray($pattadar_details, $create_prop_data['location'], $property_id, $ulpin, $create_prop_data['dagno'], $create_prop_data['pattano'], $create_prop_data['pattatype'], $create_prop_data['landclass'], $create_prop_data['bigha'], $create_prop_data['katha'], $create_prop_data['lessa'], $create_prop_data['ganda'], CERTMNEMONIC_MAP, $property_signature, $property_signer_key, $office_code, $user_code, $ulpin, $old_ulpin, $create_prop_data['revenue'], $create_prop_data['localtax'], $geomType, $coordinates);


                    $ulpinUpdate = $this->blockchainutilityclass->propertyChainUpdateApi($ulpinChainUpdData);

                    if ($ulpinUpdate->success == 1) {
                        // set  map_for_property = 'Y' in chitha_basic
                        $this->updateMapFlag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $create_prop_data['dagno'], $create_prop_data['pattano'], $create_prop_data['pattatype']);
                        //
                        $this->chainTransactionInsert($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $create_prop_data['dagno'], $create_prop_data['pattano'], $create_prop_data['landclass'], $create_prop_data['pattatype'], $property_id, $ulpinUpdate->transaction_id, CERTMNEMONIC_MAP, $ulpin, $user_code, $ulpin);

                        $result1 = array(
                            "success" => 1,
                            "transaction_id" => $result->transaction_id . "/" . $ulpinUpdate->transaction_id,
                            "message" => $result->message . " and " . $ulpinUpdate->message,
                            "timestamp" => $result->timestamp . " and " . $ulpinUpdate->timestamp,
                        );
                    } else {
                        // $this->db->trans_rollback();
                        $result1 = array(
                            "success" => $ulpinUpdate->success,
                            "transaction_id" => $result->transaction_id . "/" . $ulpinUpdate->transaction_id,
                            "error_msg" => $result->message . " and " . $ulpinUpdate->error_msg,
                            "error_code" => $result->error_code . " and " . $ulpinUpdate->error_code,
                            "timestamp" => $result->timestamp . " and " . $ulpinUpdate->timestamp,
                        );
                    }
                } else {
                    // $this->db->trans_rollback();

                    $result1 = array(
                        "success" => $result->success,
                        "message" => $result->message,
                        "error_msg" => $result->error_msg,
                        "error_code" => $result->error_code,
                        "timestamp" => $result->timestamp,
                    );
                }
            } else {
                // $this->db->trans_rollback();
                $result1 = array(
                    "success" => 0,
                    "message" => 'Database Error',
                    "error_msg" => 'Unable to save ulpin details',
                    "error_code" => '#ULPININSERROR0001',
                    // unable to save in ulpin_details

                );
            }
        } elseif (empty($ulpinDetails->features) || $ulpinDetails->features[0]->properties->pniu == null || $ulpinDetails == null) {

            if (empty($ulpinDetails) || $ulpinDetails->features[0]->properties->pniu == null) {
                $result1 = array(
                    "success" => 0,
                    "message" => "Ulpin not found",
                    "error_msg" => "Ulpin for the property not found. Asset cannot be created",
                    "error_code" => "#MAPERROR0001",
                );
            }

            // if ($ulpinDetails->features[0]->properties->pniu == null)
            //     $result1 = array(
            //         "success" => 0,
            //         "message" => "Ulpin not found",
            //         "error_msg" => "Ulpin for the property not found but geom data found. Asset cannot be created",
            //         "error_code" => "#MAPERROR0003"
            //     );

            if ($ulpinDetails == null) {
                $result1 = array(
                    "success" => 0,
                    "message" => "Ulpin not found",
                    "error_msg" => "Unable to connect to ulpin API. Asset cannot be created",
                    "error_code" => "#MAPERROR0004",
                );
            }
        } else {
            $result1 = array(
                "success" => 0,
                "message" => "Error",
                "error_msg" => "Unable to connect to Bhunaksha API or something went wrong",
                "error_code" => "#MAPERROR0002",
            );
        }

        $data = (object) $result1;

        if ($data->success == 0) {
            log_message("error", $data->message . ": " . $data->error_msg . ". Error Code: " . $data->error_code);
        }

        return $data;
    }

    public function getAcPpCaseDetails($case_no)
    {

        // $this->dbswitch();

        $case_data = $this->db->get_where('allotment_pet_dag', array('case_no' => $case_no));

        return $case_data->row();
    }

    public function updateMapFlag($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dagno, $pattano, $patta_type)
    {
        // $this->dbswitch();

        $query = "update chitha_basic set map_for_property = 'Y' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$dagno' and patta_no ='$pattano' and patta_type_code='$patta_type'";

        $this->db->query($query);

        return $this->db->affected_rows();
    }

    public function updateFlagCthBsc($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $dag_no, $patta_no, $patta_type)
    {
        // $this->dbswitch();

        $query = "update chitha_basic set map_for_property = 'N' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$dag_no' and patta_no ='$patta_no' and patta_type_code='$patta_type'";

        $this->db->query($query);

        return $this->db->affected_rows();
    }

    public function getPendingNewAssets()
    {
        // $this->dbswitch();

        $query = $this->db->get_where('chitha_basic', array('map_for_property' => 'N'));

        $result = $this->db->query($query)->result();

        return $result;
    }

    // public function getPndngAssetCrtnDags()
    // {
    //     $this->dbswitch();
    //     $dist_code = $this->session->userdata('dist_code');
    //     $subdiv_code = $this->session->userdata('subdiv_code');
    //     $cir_code = $this->session->userdata('cir_code');
    //     $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    //     $lot_no = $this->session->userdata('lot_no');
    //     $user_desig = $this->session->userdata('user_desig_code');

    //     // $query = $this->db->get_where('chitha_basic', array('ulpin' => NULL, 'map_for_property' => 'N'));
    //     if ($user_desig == 'CO') {
    //         $query = "select bh.* from bhun_map_creation_cases bh join chitha_basic cb on bh.dist_code = cb.dist_code and bh.subdiv_code = cb.subdiv_code and bh.cir_code = cb.cir_code and bh.mouza_pargona_code = cb.mouza_pargona_code and bh.lot_no = cb.lot_no and bh.vill_townprt_code = cb.vill_townprt_code and bh.patta_no = cb.patta_no and bh.dag_no = cb.dag_no and bh.old_ulpin = cb.old_ulpin where cb.map_for_property = 'N' and (bh.map_for_property = 'Y' or bh.map_for_property = 'N') and bh.dist_code='$dist_code' and bh.subdiv_code='$subdiv_code' and bh.cir_code='$cir_code'";
    //     } elseif ($user_desig == 'LM') {
    //         $query = "select bh.* from bhun_map_creation_cases bh join chitha_basic cb on bh.dist_code = cb.dist_code and bh.subdiv_code = cb.subdiv_code and bh.cir_code = cb.cir_code and bh.mouza_pargona_code = cb.mouza_pargona_code and bh.lot_no = cb.lot_no and bh.vill_townprt_code = cb.vill_townprt_code and bh.patta_no = cb.patta_no and bh.dag_no = cb.dag_no and bh.old_ulpin = cb.old_ulpin where bh.map_for_property = 'N' and bh.dist_code='$dist_code' and bh.subdiv_code='$subdiv_code' and bh.cir_code='$cir_code' and bh.mouza_pargona_code='$mouza_pargona_code' and bh.lot_no='$lot_no'";
    //     }

    //     $result = $this->db->query($query)->result();

    //     return $result;
    // }
    public function getPndngAssetCrtnDags()
    {
        // $this->dbswitch();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_desig = $this->session->userdata('user_desig_code');

        // $query = $this->db->get_where('chitha_basic', array('ulpin' => NULL, 'map_for_property' => 'N'));
        if ($user_desig == 'CO') {
            // $query = "select bh.* from bhun_map_creation_cases bh join chitha_basic cb on bh.dist_code = cb.dist_code and bh.subdiv_code = cb.subdiv_code and bh.cir_code = cb.cir_code and bh.mouza_pargona_code = cb.mouza_pargona_code and bh.lot_no = cb.lot_no and bh.vill_townprt_code = cb.vill_townprt_code and bh.patta_no = cb.patta_no and bh.dag_no = cb.dag_no and bh.old_ulpin = cb.old_ulpin where bh.map_for_property = 'N' and (cb.map_for_property = 'Y' or cb.map_for_property = 'N') and bh.dist_code='$dist_code' and bh.subdiv_code='$subdiv_code' and bh.cir_code='$cir_code'";
            $query = "select cb.*,bh.case_no,bh.p_dag_area_b,bh.p_dag_area_k,bh.p_dag_area_lc,bh.p_dag_area_g,bh.mut_date, bh.old_dag_no from chitha_basic cb join bhun_map_creation_cases bh on bh.dist_code = cb.dist_code and bh.subdiv_code = cb.subdiv_code and bh.cir_code = cb.cir_code and bh.mouza_pargona_code = cb.mouza_pargona_code and bh.lot_no = cb.lot_no and bh.vill_townprt_code = cb.vill_townprt_code and bh.patta_no = cb.patta_no and bh.dag_no = cb.dag_no and bh.old_ulpin = cb.old_ulpin where bh.map_for_property = 'N' and (cb.map_for_property = 'Y' or cb.map_for_property = 'N') and bh.dist_code='$dist_code' and bh.subdiv_code='$subdiv_code' and bh.cir_code='$cir_code'";
        } elseif ($user_desig == 'LM') {
            // $query = "select bh.* from bhun_map_creation_cases bh join chitha_basic cb on bh.dist_code = cb.dist_code and bh.subdiv_code = cb.subdiv_code and bh.cir_code = cb.cir_code and bh.mouza_pargona_code = cb.mouza_pargona_code and bh.lot_no = cb.lot_no and bh.vill_townprt_code = cb.vill_townprt_code and bh.patta_no = cb.patta_no and bh.dag_no = cb.dag_no and bh.old_ulpin = cb.old_ulpin where bh.map_for_property = 'N' and bh.dist_code='$dist_code' and bh.subdiv_code='$subdiv_code' and bh.cir_code='$cir_code' and bh.mouza_pargona_code='$mouza_pargona_code' and bh.lot_no='$lot_no'";
            $query = "select cb.*,bh.case_no,bh.p_dag_area_b,bh.p_dag_area_k,bh.p_dag_area_lc,bh.p_dag_area_g,bh.mut_date, bh.old_dag_no from chitha_basic cb join bhun_map_creation_cases bh on bh.dist_code = cb.dist_code and bh.subdiv_code = cb.subdiv_code and bh.cir_code = cb.cir_code and bh.mouza_pargona_code = cb.mouza_pargona_code and bh.lot_no = cb.lot_no and bh.vill_townprt_code = cb.vill_townprt_code and bh.patta_no = cb.patta_no and bh.dag_no = cb.dag_no and bh.old_ulpin = cb.old_ulpin where cb.map_for_property = 'N' and bh.dist_code='$dist_code' and bh.subdiv_code='$subdiv_code' and bh.cir_code='$cir_code' and bh.mouza_pargona_code='$mouza_pargona_code' and bh.lot_no='$lot_no'";
        }

        $result = $this->db->query($query)->result();

        return $result;
    }
    // public function chainFullDagProcess($pattadar_details, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $reference_id, $old_dag, $old_patta, $patta_type_code, $land_class_code, $remaining_b, $remaining_k, $remaining_lc, $remaining_g, $certmnemonic, $property_signature, $property_signer_key, $office_code, $user_code, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_patta_no, $old_dag_revenue, $old_dag_local_tax, $old_land_class_code, $new_bigha, $new_katha, $new_lessa, $new_ganda, $new_patta_type_code)
    // {

    //     //---------------------------------------- view/test update chain array(start)----------------------------------------

    //     // $type = LOC_TYPE_RURAL;

    //     // $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code;

    //     // $property_id_update = $this->blockchainutilityclass->generatePropertyId($type, $vill_townprt_code, $old_patta, $old_dag, $ulpin);

    //     // if ($certmnemonic == 'PRT' || $certmnemonic == 'BLP') {
    //     //     $chain_update_data = $this->blockchainutilityclass->getUpdateChainArray($pattadar_details, $location_id, $property_id_update, $reference_id, $old_dag, $old_patta, $patta_type_code, $land_class_code, $remaining_b, $remaining_k,  $remaining_lc, $remaining_g, $ce0p-;rtmnemonic, $property_signature, $property_signer_key, $office_code, $user_code, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_patta_no, $old_dag, $old_dag_revenue, $old_dag_local_tax, $old_land_class_code, $new_bigha, $new_katha, $new_lessa, $new_ganda);

    //     //     $create_prop_data = $this->blockchainutilityclass->getCreatePropArray($pattadar_details, $location_id, $new_patta_no, $old_dag, $land_class_code, $patta_type_code, $new_bigha, $new_katha, $new_lessa, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_ganda);
    //     // } elseif ($certmnemonic == 'CONV' || $certmnemonic == 'BLC'  || $certmnemonic == 'APC' || $certmnemonic == 'SETT' || $certmnemonic == 'ALLT') {
    //     //     $chain_update_data = $this->blockchainutilityclass->getConvChainArray($pattadar_details, $location_id, $property_id_update, $reference_id, $old_dag, $old_patta, $patta_type_code, $land_class_code, $remaining_b, $remaining_k,  $remaining_lc, $remaining_g, $certmnemonic, $property_signature, $property_signer_key, $office_code, $user_code, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_patta_no, $old_dag, $old_dag_revenue, $old_dag_local_tax, $new_patta_type_code);

    //     //     $create_prop_data = $this->blockchainutilityclass->getCreatePropArray($pattadar_details, $location_id, $new_patta_no, $old_dag, $land_class_code, $new_patta_type_code, $new_bigha, $new_katha, $new_lessa, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_ganda);
    //     // }

    //     // echo "<pre>";
    //     // var_dump($chain_update_data);
    //     // var_dump($create_prop_data);
    //     // die;

    //     //---------------------------------------- view/test update chain array(end)----------------------------------------

    //     //in chitha_basic map_for_property = 'Y', ulpin will remain same

    //     $this->dbswitch();

    //     $this->db->trans_begin();

    //     $query = "UPDATE chitha_basic SET map_for_property =?, ulpin=? WHERE dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and patta_no =?";

    //     $this->db->query($query, array('Y', $ulpin, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_dag, $new_patta_no));

    //     $data = array();
    //     if ($this->db->affected_rows() > 0) {

    //         $type = LOC_TYPE_RURAL;

    //         $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code;

    //         $property_id_update = $this->blockchainutilityclass->generatePropertyId($type, $vill_townprt_code, $old_patta, $old_dag, $ulpin);

    //         // $pattadar_details = $this->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $new_patta_no, $old_dag);
    //         if ($certmnemonic == 'PRT' || $certmnemonic == 'BLP') {
    //             $chain_update_data = $this->blockchainutilityclass->getUpdateChainArray($pattadar_details, $location_id, $property_id_update, $reference_id, $old_dag, $old_patta, $patta_type_code, $land_class_code, $remaining_b, $remaining_k, $remaining_lc, $remaining_g, $certmnemonic, $property_signature, $property_signer_key, $office_code, $user_code, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_patta_no, $old_dag, $old_dag_revenue, $old_dag_local_tax, $old_land_class_code, $new_bigha, $new_katha, $new_lessa, $new_ganda);
    //         } elseif ($certmnemonic == 'CONV' || $certmnemonic == 'BLC' || $certmnemonic == 'APC' || $certmnemonic == 'SETT' || $certmnemonic == 'ALLT') {
    //             $chain_update_data = $this->blockchainutilityclass->getConvChainArray($pattadar_details, $location_id, $property_id_update, $reference_id, $old_dag, $old_patta, $patta_type_code, $land_class_code, $remaining_b, $remaining_k, $remaining_lc, $remaining_g, $certmnemonic, $property_signature, $property_signer_key, $office_code, $user_code, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_patta_no, $old_dag, $old_dag_revenue, $old_dag_local_tax, $new_patta_type_code);
    //         }

    //         $update_chain_api = $this->blockchainutilityclass->propertyChainUpdateApi($chain_update_data);

    //         if ($update_chain_api->success == 1) {
    //             $transaction_insert = $this->chainTransactionInsert($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_dag, $old_patta, $land_class_code, $patta_type_code, $property_id_update, $update_chain_api->transaction_id, $certmnemonic, $reference_id, $user_code, $ulpin);

    //             //* ////////////////creating new asset will be not required once the format of property id is changed (delete start)///////////////////

    //             $property_id_create = $this->blockchainutilityclass->generatePropertyId($type, $vill_townprt_code, $new_patta_no, $old_dag, $ulpin);

    //             $gis_code = $dist_code . '_' . $subdiv_code . '_' . $cir_code . '_' . $mouza_pargona_code . '_' . $lot_no . '_' . $vill_townprt_code;

    //             // $pattadar_details_create =  $this->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $new_patta_no, $old_dag);
    //             if ($certmnemonic == 'CONV' || $certmnemonic == 'BLC') {
    //                 $create_prop_data = $this->blockchainutilityclass->getCreatePropArray($pattadar_details, $location_id, $new_patta_no, $old_dag, $land_class_code, $new_patta_type_code, $new_bigha, $new_katha, $new_lessa, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_ganda);
    //             } elseif ($certmnemonic == 'PRT' || $certmnemonic == 'BLP') {
    //                 $create_prop_data = $this->blockchainutilityclass->getCreatePropArray($pattadar_details, $location_id, $new_patta_no, $old_dag, $land_class_code, $patta_type_code, $new_bigha, $new_katha, $new_lessa, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_ganda);
    //             }

    //             $old_patta_type_code = "";

    //             $createNUpdtMap = $this->createAssetAndUptMap($pattadar_details, $create_prop_data, $gis_code, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $property_id_create, $location_id, $user_code, $office_code, $property_signature, $property_signer_key, $old_dag, $old_patta, $old_patta_type_code);

    //             $data['chain_create_result'] = $createNUpdtMap;
    //             //*//////////////////////////////////////////////////(delete end)
    //         } elseif ($update_chain_api->success == 0) {
    //             $this->db->trans_rollback();
    //             $result = array(
    //                 'success' => 0,
    //                 'message' => $update_chain_api->message,
    //                 'error_msg' => $update_chain_api->error_msg,
    //                 'error_code' => $update_chain_api->error_code,
    //             );

    //             $update_chain_api = (object) $result;
    //         } else {
    //             $this->db->trans_rollback();
    //             $result = array(
    //                 'success' => 0,
    //                 'message' => "ERROR",
    //                 'error_msg' => "Unable to update in property chain. Error Code(#ERRORUPD0001)",
    //                 'error_code' => 'ERRORUPD0001',
    //             );
    //             log_message("error", "##ERRORUPD0001 unable connect to Property Chain or something went wrong or schema not not added for the process");

    //             $update_chain_api = (object) $result;
    //         }
    //     } else {
    //         $this->db->trans_rollback();
    //         $result = array(
    //             'success' => 0,
    //             'message' => "ERROR",
    //             'error_msg' => "Chitha Could not be updated. Please try Again. Error Code(#ERRULP002)",
    //             'error_code' => '#ERRULP002',
    //         );

    //         log_message("error", "##ERRULP002 unable to update ulpin and map_for_property in chitha_basic from dist: " . $dist_code . ", subdiv: " . $subdiv_code . ", cir code: " . $cir_code . ", mouza: " . $mouza_pargona_code . ", lot: " . $lot_no . ",dag no: " . $old_dag . ", patta no: " . $new_patta_no . ",old ulpin: ", $ulpin);

    //         $update_chain_api = (object) $result;
    //     }

    //     $data['chain_update_result'] = $update_chain_api;

    //     return $data;
    // }

    public function chainFullDagProcess($chain_data)
    {

        //---------------------------------------- view/test update chain array(start)----------------------------------------

        $type = LOC_TYPE_RURAL;

        $location_id = $chain_data->dist_code . $chain_data->subdiv_code . $chain_data->cir_code . $chain_data->mouza_pargona_code . $chain_data->lot_no . $chain_data->vill_townprt_code;

        $property_id_update = $this->blockchainutilityclass->generatePropertyId($type, $chain_data->vill_townprt_code, $chain_data->old_patta, $chain_data->old_dag, $chain_data->ulpin);

        if ($chain_data->certmnemonic == 'PRT' || $chain_data->certmnemonic == 'BLP') {


            $update_params = array(
                'pattadar_details' => $chain_data->pattadar_details,
                'location_id' => $location_id,
                'property_id' => $property_id_update,
                'reference_id' => $chain_data->reference_id,
                'dag_no' => $chain_data->old_dag,
                'patta_no' => $chain_data->new_patta_no, //$chain_data->old_patta,
                'patta_type_code' => $chain_data->patta_type_code,
                'land_class_code' => $chain_data->land_class_code,
                'bigha_chain' => $chain_data->remaining_b,
                'katha_chain' => $chain_data->remaining_k,
                'lessa_chain' => $chain_data->remaining_lc,
                'ganda_chain' => $chain_data->remaining_g,
                'certmnemonic' => $chain_data->certmnemonic,
                'property_signature' => $chain_data->property_signature,
                'property_signer_key' => $chain_data->property_signer_key,
                'office_code' => $chain_data->office_code,
                'user_code' => $chain_data->user_code,
                'ulpin' => $chain_data->ulpin,
                'old_ulpin' => $chain_data->old_ulpin,
                'revenue' => $chain_data->old_dag_revenue,
                'local_tax' => $chain_data->old_dag_local_tax,
                'new_patta_no' => $chain_data->old_patta, //$chain_data->new_patta_no,
                'new_dag_no' => "",
                'old_revenue' => $chain_data->dag_revenue,
                'old_local_tax' => $chain_data->dag_local_tax,
                'old_land_class_code' => $chain_data->old_land_class_code,
                'new_bigha' => "",
                'new_katha' => "",
                'new_lessa' => "",
                'new_ganda' => ""
            );
            $chain_update_data = $this->blockchainutilityclass->getUpdateChainArrayN((object)$update_params);
        } elseif ($chain_data->certmnemonic == 'CONV' || $chain_data->certmnemonic == 'BLC' || $chain_data->certmnemonic == 'APC' || $chain_data->certmnemonic == 'SETT' || $chain_data->certmnemonic == 'ALLT') {

            $update_params = array(
                'pattadar_details' => $chain_data->pattadar_details,
                'location_id' => $location_id,
                'property_id' => $property_id_update,
                'reference_id' => $chain_data->reference_id,
                'dag_no' => $chain_data->old_dag,
                'patta_no' => $chain_data->new_patta_no, //$chain_data->old_patta,
                'patta_type_code' => $chain_data->patta_type_code,
                'land_class_code' => $chain_data->land_class_code,
                'bigha_chain' => $chain_data->remaining_b,
                'katha_chain' => $chain_data->remaining_k,
                'lessa_chain' => $chain_data->remaining_lc,
                'ganda_chain' => $chain_data->remaining_g,
                'certmnemonic' => $chain_data->certmnemonic,
                'property_signature' => $chain_data->property_signature,
                'property_signer_key' => $chain_data->property_signer_key,
                'office_code' => $chain_data->office_code,
                'user_code' => $chain_data->user_code,
                'ulpin' => $chain_data->ulpin,
                'old_ulpin' => $chain_data->old_ulpin,
                'new_revenue' => $chain_data->old_dag_revenue,
                'new_local_tax' => $chain_data->old_dag_local_tax,
                'new_patta_no' => $chain_data->old_patta, //$chain_data->new_patta_no,
                'new_dag_no' => $chain_data->old_dag,
                'old_revenue' => $chain_data->dag_revenue,
                'old_local_tax' => $chain_data->dag_local_tax,
                'new_patta_type_code' => $chain_data->new_patta_type_code
            );

            $chain_update_data = $this->blockchainutilityclass->getConvChainArrayN((object)$update_params);
        }

        // echo "<pre>";
        // var_dump($chain_update_data);
        // die;

        //---------------------------------------- view/test update chain array(end)----------------------------------------

        //in chitha_basic map_for_property = 'Y', ulpin will remain same

        // $this->dbswitch();

        // $this->db->trans_begin();==========MRIGANKA

        $query = "UPDATE chitha_basic SET map_for_property =?, ulpin=? WHERE dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and patta_no =?";

        $this->db->query($query, array('Y', $chain_data->ulpin, $chain_data->dist_code, $chain_data->subdiv_code, $chain_data->cir_code, $chain_data->mouza_pargona_code, $chain_data->lot_no, $chain_data->vill_townprt_code, $chain_data->old_dag, $chain_data->new_patta_no));

        $chain_data->data = array();
        if ($this->db->affected_rows() > 0) {

            $type = LOC_TYPE_RURAL;

            $location_id = $chain_data->dist_code . $chain_data->subdiv_code . $chain_data->cir_code . $chain_data->mouza_pargona_code . $chain_data->lot_no . $chain_data->vill_townprt_code;

            $property_id_update = $this->blockchainutilityclass->generatePropertyId($type, $chain_data->vill_townprt_code, $chain_data->old_patta, $chain_data->old_dag, $chain_data->ulpin);

            // $chain_data->pattadar_details = $this->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $new_patta_no, $old_dag);


            if ($chain_data->certmnemonic == 'PRT' || $chain_data->certmnemonic == 'BLP') {


                $update_params = array(
                    'pattadar_details' => $chain_data->pattadar_details,
                    'location_id' => $location_id,
                    'property_id' => $property_id_update,
                    'reference_id' => $chain_data->reference_id,
                    'dag_no' => $chain_data->old_dag,
                    'patta_no' => $chain_data->new_patta_no, //only patta no changes, dags remain same so in patta_no send the new patta no and in place of new_patta_no send the old patta no ,
                    'patta_type_code' => $chain_data->patta_type_code,
                    'land_class_code' => $chain_data->land_class_code,
                    'bigha_chain' => $chain_data->remaining_b,
                    'katha_chain' => $chain_data->remaining_k,
                    'lessa_chain' => $chain_data->remaining_lc,
                    'ganda_chain' => $chain_data->remaining_g,
                    'certmnemonic' => $chain_data->certmnemonic,
                    'property_signature' => $chain_data->property_signature,
                    'property_signer_key' => $chain_data->property_signer_key,
                    'office_code' => $chain_data->office_code,
                    'user_code' => $chain_data->user_code,
                    'ulpin' => $chain_data->ulpin,
                    'old_ulpin' => $chain_data->old_ulpin,
                    'revenue' => $chain_data->old_dag_revenue,
                    'local_tax' => $chain_data->old_dag_local_tax,
                    'new_patta_no' => $chain_data->old_patta, //
                    'new_dag_no' => "",
                    'old_revenue' => $chain_data->dag_revenue,
                    'old_local_tax' => $chain_data->dag_local_tax,
                    'old_land_class_code' => $chain_data->old_land_class_code,
                    'new_bigha' => "",
                    'new_katha' => "",
                    'new_lessa' => "",
                    'new_ganda' => ""
                );
                $chain_update_data = $this->blockchainutilityclass->getUpdateChainArrayN((object)$update_params);
            } elseif ($chain_data->certmnemonic == 'CONV' || $chain_data->certmnemonic == 'BLC' || $chain_data->certmnemonic == 'APC' || $chain_data->certmnemonic == 'SETT' || $chain_data->certmnemonic == 'ALLT') {

                $update_params = array(
                    'pattadar_details' => $chain_data->pattadar_details,
                    'location_id' => $location_id,
                    'property_id' => $property_id_update,
                    'reference_id' => $chain_data->reference_id,
                    'dag_no' => $chain_data->old_dag,
                    'patta_no' => $chain_data->new_patta_no, 
                    //only patta no changes, dags remain same so in patta_no send the new patta no and in place of new_patta_no send the old patta no ,
                    'patta_type_code' => $chain_data->new_patta_type_code,
                    'land_class_code' => $chain_data->land_class_code,
                    'bigha_chain' => $chain_data->remaining_b,
                    'katha_chain' => $chain_data->remaining_k,
                    'lessa_chain' => $chain_data->remaining_lc,
                    'ganda_chain' => $chain_data->remaining_g,
                    'certmnemonic' => $chain_data->certmnemonic,
                    'property_signature' => $chain_data->property_signature,
                    'property_signer_key' => $chain_data->property_signer_key,
                    'office_code' => $chain_data->office_code,
                    'user_code' => $chain_data->user_code,
                    'ulpin' => $chain_data->ulpin,
                    'old_ulpin' => $chain_data->old_ulpin,
                    'new_revenue' => $chain_data->old_dag_revenue,
                    'new_local_tax' => $chain_data->old_dag_local_tax,
                    'new_patta_no' => $chain_data->old_patta, //
                    'new_dag_no' => $chain_data->old_dag,
                    'old_revenue' => $chain_data->dag_revenue,
                    'old_local_tax' => $chain_data->dag_local_tax,
                    'new_patta_type_code' => $chain_data->patta_type_code
                );

                $chain_update_data = $this->blockchainutilityclass->getConvChainArrayN((object)$update_params);
            }

            $save_chain_data = $this->save_chain_data(json_encode($chain_update_data), $chain_data->reference_id);

            if ($save_chain_data > 0) {
                $result = array(
                    'success' => 1,
                );

                $update_chain_api = (object) $result;
            } else {
                $this->db->trans_rollback();
                $result = array(
                    'success' => 0,
                    'message' => "ERROR",
                    'error_msg' => "Case cannot be passed. Error Code(#CHAINSAVEERROR0001)",
                    'error_code' => '#CHAINSAVEERROR0001',
                );

                log_message("error", "Error code: ##CHAINSAVEERROR0001 unable to insert data in prop_chain_sent_data table case no: " . $chain_data->reference_id);

                $update_chain_api = (object) $result;
            }

            // $update_chain_api = $this->blockchainutilityclass->propertyChainUpdateApi($chain_update_data);

            // if ($update_chain_api->success == 1) {
            //     $transaction_insert = $this->chainTransactionInsert($chain_data->dist_code, $chain_data->subdiv_code, $chain_data->cir_code, $chain_data->mouza_pargona_code, $chain_data->lot_no, $chain_data->vill_townprt_code, $chain_data->old_dag, $chain_data->old_patta, $chain_data->land_class_code, $chain_data->patta_type_code, $property_id_update, $chain_data->update_chain_api->transaction_id, $chain_data->certmnemonic, $chain_data->reference_id, $chain_data->user_code, $chain_data->ulpin);
            // } elseif ($update_chain_api->success == 0) {
            //     $this->db->trans_rollback();
            //     $result = array(
            //         'success' => 0,
            //         'message' => $update_chain_api->message,
            //         'error_msg' => $update_chain_api->error_msg,
            //         'error_code' => $update_chain_api->error_code,
            //     );

            //     $update_chain_api = (object) $result;
            // } else {
            //     $this->db->trans_rollback();
            //     $result = array(
            //         'success' => 0,
            //         'message' => "ERROR",
            //         'error_msg' => "Unable to update in property chain. Error Code(#ERRORUPD0001)",
            //         'error_code' => 'ERRORUPD0001',
            //     );
            //     log_message("error", "##ERRORUPD0001 unable connect to Property Chain or something went wrong or schema not not added for the process");

            //     $update_chain_api = (object) $result;
            // }
        } else {
            $this->db->trans_rollback();
            $result = array(
                'success' => 0,
                'message' => "ERROR",
                'error_msg' => "Chitha Could not be updated. Please try Again. Error Code(#ERRULP002)",
                'error_code' => '#ERRULP002',
            );

            log_message("error", "##ERRULP002 unable to update ulpin and map_for_property in chitha_basic from dist: " . $chain_data->dist_code . ", subdiv: " . $chain_data->subdiv_code . ", cir code: " . $chain_data->cir_code . ", mouza: " . $chain_data->mouza_pargona_code . ", lot: " . $chain_data->lot_no . " village code: " . $chain_data->vill_townprt_code . ",dag no: " . $chain_data->old_dag . ", patta no: " . $chain_data->new_patta_no . ",old ulpin: ", $chain_data->ulpin);

            $update_chain_api = (object) $result;
        }

        // $data['chain_update_result'] = $update_chain_api;

        return $update_chain_api;
    }


    public function chainPartialDagProcess($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta, $old_dag, $patta_type_code, $reference_id, $land_class_code, $remaining_b, $remaining_k, $remaining_lc, $remaining_g, $certmnemonic, $property_signature, $property_signer_key, $office_code, $user_code, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_patta_no, $new_dag_no, $old_dag_revenue, $old_dag_local_tax, $old_land_class_code, $bigha_new, $katha_new, $lessa_new, $ganda_new, $new_patta_type_code)
    {

        // ---------------------------- to test/view the update data array uncomment this section(START)---------------------------------------
        // $type = LOC_TYPE_RURAL;

        // $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code;

        // $property_id_update = $this->blockchainutilityclass->generatePropertyId($type, $vill_townprt_code, $old_patta, $old_dag, $ulpin);
        // $pattadar_update_details = $this->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta, $old_dag);

        // if ($certmnemonic == 'PRT' || $certmnemonic == 'BLP')
        //     $chain_update_data = $this->blockchainutilityclass->getUpdateChainArray($pattadar_update_details, $location_id, $property_id_update, $reference_id, $old_dag, $old_patta, $patta_type_code, $land_class_code, $remaining_b, $remaining_k,  $remaining_lc, $remaining_g, $certmnemonic, $property_signature, $property_signer_key, $office_code, $user_code, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_patta_no, $new_dag_no, $old_dag_revenue, $old_dag_local_tax, $old_land_class_code, $bigha_new, $katha_new, $lessa_new, $ganda_new);
        // elseif ($certmnemonic == 'CONV' || $certmnemonic == 'BLC' ||  $certmnemonic == 'SETT' || $certmnemonic == 'ALLT')
        //     $chain_update_data = $this->blockchainutilityclass->getConvChainArray($pattadar_update_details, $location_id, $property_id_update, $reference_id, $old_dag, $old_patta, $patta_type_code, $land_class_code, $remaining_b, $remaining_k,  $remaining_lc, $remaining_g, $certmnemonic, $property_signature, $property_signer_key, $office_code, $user_code, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_patta_no, $new_dag_no, $old_dag_revenue, $old_dag_local_tax, $new_patta_type_code);
        // echo "<pre>";
        // var_dump($chain_update_data, $certmnemonic);
        // var_dump($reference_id, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta, $old_dag, $new_patta_no, $new_dag_no, $ulpin, $bigha_new, $katha_new, $lessa_new, $ganda_new);
        // die;
        // -----------------------------------to test/view the update data array uncomment this section(END)-------------------------------------

        // * changes in the new dag: ulpin of the old_dag will be the old_ulpin of the new_dag, map_for_property = 'N'
        // * new asset creation will pe pending until map for the new dag is created at bhunaksha
        // $this->dbswitch();

        $this->db->trans_begin();

        // update chitha_basic for the new property
        $query = "UPDATE chitha_basic SET map_for_property ='N', old_ulpin='$ulpin' WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and vill_townprt_code='$vill_townprt_code' and dag_no='$new_dag_no' and patta_no ='$new_patta_no'";

        $this->db->query($query);

        if ($this->db->affected_rows() > 0) {
            // insert data into bhun_map_creation_cases
            $insert_map_case_details = $this->insertBhuCaseDetails($reference_id, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta, $old_dag, $new_patta_no, $new_dag_no, $ulpin, $bigha_new, $katha_new, $lessa_new, $ganda_new);
            if ($insert_map_case_details) {
                $type = LOC_TYPE_RURAL;

                $location_id = $dist_code . $subdiv_code . $cir_code . $mouza_pargona_code . $lot_no . $vill_townprt_code;

                $property_id_update = $this->blockchainutilityclass->generatePropertyId($type, $vill_townprt_code, $old_patta, $old_dag, $ulpin);
                // var_dump($property_id_update);
                // die;
                $pattadar_update_details = $this->getPattadars($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta, $old_dag);

                if ($certmnemonic == 'PRT' || $certmnemonic == 'BLP') {
                    $chain_update_data = $this->blockchainutilityclass->getUpdateChainArray($pattadar_update_details, $location_id, $property_id_update, $reference_id, $old_dag, $old_patta, $patta_type_code, $land_class_code, $remaining_b, $remaining_k, $remaining_lc, $remaining_g, $certmnemonic, $property_signature, $property_signer_key, $office_code, $user_code, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_patta_no, $new_dag_no, $old_dag_revenue, $old_dag_local_tax, $old_land_class_code, $bigha_new, $katha_new, $lessa_new, $ganda_new);
                } elseif ($certmnemonic == 'CONV' || $certmnemonic == 'BLC' || $certmnemonic == 'ALLT' || $certmnemonic == 'SETT') {
                    $chain_update_data = $this->blockchainutilityclass->getConvChainArray($pattadar_update_details, $location_id, $property_id_update, $reference_id, $old_dag, $old_patta, $patta_type_code, $land_class_code, $remaining_b, $remaining_k, $remaining_lc, $remaining_g, $certmnemonic, $property_signature, $property_signer_key, $office_code, $user_code, $ulpin, $old_ulpin, $dag_revenue, $dag_local_tax, $new_patta_no, $new_dag_no, $old_dag_revenue, $old_dag_local_tax, $new_patta_type_code);
                }
                $save_chain_data = $this->save_chain_data(json_encode($chain_update_data), $reference_id);

                if ($save_chain_data > 0) {
                    $result = array(
                        'success' => 1,
                    );

                    $update_chain_api = (object) $result;
                } else {
                    $this->db->trans_rollback();
                    $result = array(
                        'success' => 0,
                        'message' => "ERROR",
                        'error_msg' => "Case cannot be passed. Error Code(#CHAINSAVEERROR0001)",
                        'error_code' => '#CHAINSAVEERROR0001',
                    );

                    log_message("error", "Error code: ##CHAINSAVEERROR0001 unable to insert data in prop_chain_sent_data table case no: " . $reference_id);

                    $update_chain_api = (object) $result;
                }
            } else {
                $this->db->trans_rollback();
                $result = array(
                    'success' => 0,
                    'message' => "ERROR",
                    'error_msg' => "Case cannot be passed. Please try Again. Error Code(#ERRULP003)",
                    'error_code' => '#ERRULP003',
                );

                log_message("error", "##ERRULP003 unable to insert data in bhun_map_creation_cases table case no: " . $reference_id);

                $update_chain_api = (object) $result;
            }
        } else {
            $this->db->trans_rollback();
            $result = array(
                'success' => 0,
                'message' => "ERROR",
                'error_msg' => "Chitha Could not be updated. Please try Again. Error Code(#ERRULP001)",
                'error_code' => '#ERRULP001',
            );

            log_message("error", "##ERRULP001 unable to update old_ulpin and map_for_property in chitha_basic from dist: " . $dist_code . ", subdiv: " . $subdiv_code . ", cir code: " . $cir_code . ", mouza: " . $mouza_pargona_code . ", lot: " . $lot_no . ",dag no: " . $new_dag_no . ", patta no: " . $new_patta_no . ",old ulpin: ", $ulpin);

            $update_chain_api = (object) $result;
        }


        return $update_chain_api;
    }

    public function chainPartialDagProcessN($chain_data)
    {

        // ---------------------------- to test/view the update data array uncomment this section(START)---------------------------------------
        // $type = LOC_TYPE_RURAL;


        // $location_id = $chain_data->dist_code . $chain_data->subdiv_code . $chain_data->cir_code . $chain_data->mouza_pargona_code . $chain_data->lot_no . $chain_data->vill_townprt_code;

        // $property_id_update = $this->blockchainutilityclass->generatePropertyId($type, $chain_data->vill_townprt_code, $chain_data->old_patta, $chain_data->old_dag, $chain_data->ulpin);
        // // var_dump($property_id_update);
        // // die;
        // $pattadar_update_details = $this->getPattadars($chain_data->dist_code, $chain_data->subdiv_code, $chain_data->cir_code, $chain_data->mouza_pargona_code, $chain_data->lot_no, $chain_data->vill_townprt_code, $chain_data->old_patta, $chain_data->old_dag);
        // if ($chain_data->certmnemonic == 'PRT' || $chain_data->certmnemonic == 'BLP') {
        //     $update_params = array(
        //         'pattadar_details' => $pattadar_update_details,
        //         'location_id' => $location_id,
        //         'property_id' => $property_id_update,
        //         'reference_id' => $chain_data->reference_id,
        //         'dag_no' => $chain_data->old_dag,
        //         'patta_no' => $chain_data->old_patta,
        //         'patta_type_code' => $chain_data->patta_type_code,
        //         'land_class_code' => $chain_data->land_class_code,
        //         'bigha_chain' => $chain_data->remaining_b,
        //         'katha_chain' => $chain_data->remaining_k,
        //         'lessa_chain' => $chain_data->remaining_lc,
        //         'ganda_chain' => $chain_data->remaining_g,
        //         'certmnemonic' => $chain_data->certmnemonic,
        //         'property_signature' => $chain_data->property_signature,
        //         'property_signer_key' => $chain_data->property_signer_key,
        //         'office_code' => $chain_data->office_code,
        //         'user_code' => $chain_data->user_code,
        //         'ulpin' => $chain_data->ulpin,
        //         'old_ulpin' => $chain_data->old_ulpin,
        //         'revenue' => $chain_data->dag_revenue,
        //         'local_tax' => $chain_data->dag_local_tax,
        //         'new_patta_no' => $chain_data->new_patta_no,
        //         'new_dag_no' => $chain_data->new_dag_no,
        //         'old_revenue' => $chain_data->old_dag_revenue,
        //         'old_local_tax' => $chain_data->old_dag_local_tax,
        //         'old_land_class_code' => $chain_data->old_land_class_code,
        //         'new_bigha' => $chain_data->bigha_new,
        //         'new_katha' => $chain_data->katha_new,
        //         'new_lessa' => $chain_data->lessa_new,
        //         'new_ganda' => $chain_data->ganda_new
        //     );

        //     $chain_update_data = $this->blockchainutilityclass->getUpdateChainArrayN((object)$update_params);
        // } elseif ($chain_data->certmnemonic == 'CONV' || $chain_data->certmnemonic == 'BLC' || $chain_data->certmnemonic == 'ALLT' || $chain_data->certmnemonic == 'SETT') {
        //     $update_params = array(
        //         'pattadar_details' => $pattadar_update_details,
        //         'location_id' => $location_id,
        //         'property_id' => $property_id_update,
        //         'reference_id' => $chain_data->reference_id,
        //         'dag_no' => $chain_data->old_dag,
        //         'patta_no' => $chain_data->old_patta,
        //         'patta_type_code' => $chain_data->patta_type_code,
        //         'land_class_code' => $chain_data->land_class_code,
        //         'bigha_chain' => $chain_data->remaining_b,
        //         'katha_chain' => $chain_data->remaining_k,
        //         'lessa_chain' => $chain_data->remaining_lc,
        //         'ganda_chain' => $chain_data->remaining_g,
        //         'certmnemonic' => $chain_data->certmnemonic,
        //         'property_signature' => $chain_data->property_signature,
        //         'property_signer_key' => $chain_data->property_signer_key,
        //         'office_code' => $chain_data->office_code,
        //         'user_code' => $chain_data->user_code,
        //         'ulpin' => $chain_data->ulpin,
        //         'old_ulpin' => $chain_data->old_ulpin,
        //         'new_revenue' => $chain_data->dag_revenue,
        //         'new_local_tax' => $chain_data->dag_local_tax,
        //         'new_patta_no' => $chain_data->new_patta_no,
        //         'new_dag_no' => $chain_data->new_dag_no,
        //         'old_revenue' => $chain_data->old_dag_revenue,
        //         'old_local_tax' => $chain_data->old_dag_local_tax,
        //         'new_patta_type_code' => $chain_data->new_patta_type_code
        //     );

        //     $chain_update_data = $this->blockchainutilityclass->getConvChainArrayN((object)$update_params);
        // }
        // echo "<pre>";
        // var_dump($chain_update_data);
        // die;
        // -----------------------------------to test/view the update data array uncomment this section(END)-------------------------------------

        // * changes in the new dag: ulpin of the old_dag will be the old_ulpin of the new_dag and old_ulpin of the old dag after map partition, map_for_property = 'N'
        // * new asset creation will pe pending until map for the new dag is created at bhunaksha
        // $this->dbswitch();

        // $this->db->trans_begin();

        // update chitha_basic for the new property
        $query = "UPDATE chitha_basic SET map_for_property ='N', old_ulpin='$chain_data->ulpin' WHERE dist_code='$chain_data->dist_code' and subdiv_code='$chain_data->subdiv_code' and cir_code='$chain_data->cir_code' and mouza_pargona_code='$chain_data->mouza_pargona_code' and lot_no='$chain_data->lot_no' and vill_townprt_code='$chain_data->vill_townprt_code' and dag_no='$chain_data->new_dag_no' and patta_no ='$chain_data->new_patta_no'";

        $this->db->query($query);

        if ($this->db->affected_rows() > 0) {

            // update the old_ulpin of the old dag and set ulpin as null 
            $query = "UPDATE chitha_basic SET old_ulpin='$chain_data->ulpin', ulpin = null WHERE dist_code='$chain_data->dist_code' and subdiv_code='$chain_data->subdiv_code' and cir_code='$chain_data->cir_code' and mouza_pargona_code='$chain_data->mouza_pargona_code' and lot_no='$chain_data->lot_no' and vill_townprt_code='$chain_data->vill_townprt_code' and dag_no='$chain_data->old_dag' and patta_no ='$chain_data->old_patta'";

            $this->db->query($query);
            if ($this->db->affected_rows() > 0) {
                // insert data into bhun_map_creation_cases

                $insert_map_case_details = $this->insertBhuCaseDetails($chain_data->reference_id, $chain_data->dist_code, $chain_data->subdiv_code, $chain_data->cir_code, $chain_data->mouza_pargona_code, $chain_data->lot_no, $chain_data->vill_townprt_code, $chain_data->old_patta, $chain_data->old_dag, $chain_data->new_patta_no, $chain_data->new_dag_no, $chain_data->ulpin, $chain_data->bigha_new, $chain_data->katha_new, $chain_data->lessa_new, $chain_data->ganda_new);
                if ($insert_map_case_details) {
                    $type = LOC_TYPE_RURAL;

                    $location_id = $chain_data->dist_code . $chain_data->subdiv_code . $chain_data->cir_code . $chain_data->mouza_pargona_code . $chain_data->lot_no . $chain_data->vill_townprt_code;

                    $property_id_update = $this->blockchainutilityclass->generatePropertyId($type, $chain_data->vill_townprt_code, $chain_data->old_patta, $chain_data->old_dag, $chain_data->ulpin);
                    // var_dump($property_id_update);
                    // die;
                    $pattadar_update_details = $this->getPattadars($chain_data->dist_code, $chain_data->subdiv_code, $chain_data->cir_code, $chain_data->mouza_pargona_code, $chain_data->lot_no, $chain_data->vill_townprt_code, $chain_data->old_patta, $chain_data->old_dag);

                    if ($chain_data->certmnemonic == 'PRT' || $chain_data->certmnemonic == 'BLP') {

                        $update_params = array(
                            'pattadar_details' => $pattadar_update_details,
                            'location_id' => $location_id,
                            'property_id' => $property_id_update,
                            'reference_id' => $chain_data->reference_id,
                            'dag_no' => $chain_data->old_dag,
                            'patta_no' => $chain_data->old_patta,
                            'patta_type_code' => $chain_data->patta_type_code,
                            'land_class_code' => $chain_data->land_class_code,
                            'bigha_chain' => $chain_data->remaining_b,
                            'katha_chain' => $chain_data->remaining_k,
                            'lessa_chain' => $chain_data->remaining_lc,
                            'ganda_chain' => $chain_data->remaining_g,
                            'certmnemonic' => $chain_data->certmnemonic,
                            'property_signature' => $chain_data->property_signature,
                            'property_signer_key' => $chain_data->property_signer_key,
                            'office_code' => $chain_data->office_code,
                            'user_code' => $chain_data->user_code,
                            'ulpin' => $chain_data->ulpin,
                            'old_ulpin' => $chain_data->old_ulpin,
                            'revenue' => $chain_data->dag_revenue,
                            'local_tax' => $chain_data->dag_local_tax,
                            'new_patta_no' => $chain_data->new_patta_no,
                            'new_dag_no' => $chain_data->new_dag_no,
                            'old_revenue' => $chain_data->old_dag_revenue,
                            'old_local_tax' => $chain_data->old_dag_local_tax,
                            'old_land_class_code' => $chain_data->old_land_class_code,
                            'new_bigha' => $chain_data->bigha_new,
                            'new_katha' => $chain_data->katha_new,
                            'new_lessa' => $chain_data->lessa_new,
                            'new_ganda' => $chain_data->ganda_new
                        );

                        $chain_update_data = $this->blockchainutilityclass->getUpdateChainArrayN((object)$update_params);
                    } elseif ($chain_data->certmnemonic == 'CONV' || $chain_data->certmnemonic == 'BLC' || $chain_data->certmnemonic == 'ALLT' || $chain_data->certmnemonic == 'SETT') {

                        $update_params = array(
                            'pattadar_details' => $pattadar_update_details,
                            'location_id' => $location_id,
                            'property_id' => $property_id_update,
                            'reference_id' => $chain_data->reference_id,
                            'dag_no' => $chain_data->old_dag,
                            'patta_no' => $chain_data->old_patta,
                            'patta_type_code' => $chain_data->patta_type_code,
                            'land_class_code' => $chain_data->land_class_code,
                            'bigha_chain' => $chain_data->remaining_b,
                            'katha_chain' => $chain_data->remaining_k,
                            'lessa_chain' => $chain_data->remaining_lc,
                            'ganda_chain' => $chain_data->remaining_g,
                            'certmnemonic' => $chain_data->certmnemonic,
                            'property_signature' => $chain_data->property_signature,
                            'property_signer_key' => $chain_data->property_signer_key,
                            'office_code' => $chain_data->office_code,
                            'user_code' => $chain_data->user_code,
                            'ulpin' => $chain_data->ulpin,
                            'old_ulpin' => $chain_data->old_ulpin,
                            'new_revenue' => $chain_data->dag_revenue,
                            'new_local_tax' => $chain_data->dag_local_tax,
                            'new_patta_no' => $chain_data->new_patta_no,
                            'new_dag_no' => $chain_data->new_dag_no,
                            'old_revenue' => $chain_data->old_dag_revenue,
                            'old_local_tax' => $chain_data->old_dag_local_tax,
                            'new_patta_type_code' => $chain_data->new_patta_type_code
                        );

                        $chain_update_data = $this->blockchainutilityclass->getConvChainArrayN((object)$update_params);
                    }
                    $save_chain_data = $this->save_chain_data(json_encode($chain_update_data), $chain_data->reference_id);

                    if ($save_chain_data > 0) {
                        $result = array(
                            'success' => 1,
                        );

                        $update_chain_api = (object) $result;
                    } else {
                        $this->db->trans_rollback();
                        $result = array(
                            'success' => 0,
                            'message' => "ERROR",
                            'error_msg' => "Case cannot be passed. Error Code(#CHAINSAVEERROR0001)",
                            'error_code' => '#CHAINSAVEERROR0001',
                        );

                        log_message("error", "Error code: ##CHAINSAVEERROR0001 unable to insert data in prop_chain_sent_data table case no: " . $chain_data->reference_id);

                        $update_chain_api = (object) $result;
                    }
                } else {
                    $this->db->trans_rollback();
                    $result = array(
                        'success' => 0,
                        'message' => "ERROR",
                        'error_msg' => "Case cannot be passed. Please try Again. Error Code(#ERRULP003)",
                        'error_code' => '#ERRULP003',
                    );

                    log_message("error", "##ERRULP003 unable to insert data in bhun_map_creation_cases table case no: " . $chain_data->reference_id);

                    $update_chain_api = (object) $result;
                }
            } else {
                $this->db->trans_rollback();
                $result = array(
                    'success' => 0,
                    'message' => "ERROR",
                    'error_msg' => "Chitha Could not be updated. Please try Again. Error Code(#ERRULP004)",
                    'error_code' => '#ERRULP004',
                );

                log_message("error", "##ERRULP004 unable to update old_ulpin and ulpin in chitha_basic from dist: " . $chain_data->dist_code . ", subdiv: " . $chain_data->subdiv_code . ", cir code: " . $chain_data->cir_code . ", mouza: " . $chain_data->mouza_pargona_code . ", lot: " . $chain_data->lot_no . ", village code: " . $chain_data->vill_townprt_code . ",dag no: " . $chain_data->old_dag . ", patta no: " . $chain_data->old_patta . ",old ulpin: ", $chain_data->ulpin);

                $update_chain_api = (object) $result;
            }
        } else {
            $this->db->trans_rollback();
            $result = array(
                'success' => 0,
                'message' => "ERROR",
                'error_msg' => "Chitha Could not be updated. Please try Again. Error Code(#ERRULP001)",
                'error_code' => '#ERRULP001',
            );

            log_message("error", "##ERRULP001 unable to update old_ulpin and map_for_property in chitha_basic from dist: " . $chain_data->dist_code . ", subdiv: " . $chain_data->subdiv_code . ", cir code: " . $chain_data->cir_code . ", mouza: " . $chain_data->mouza_pargona_code . ", lot: " . $chain_data->lot_no . ", village code: " . $chain_data->vill_townprt_code . ",dag no: " . $chain_data->new_dag_no . ", patta no: " . $chain_data->new_patta_no . ",old ulpin: ", $chain_data->ulpin);

            $update_chain_api = (object) $result;
        }


        return $update_chain_api;
    }

    public function getCreateDataJson($pattadar_details, $propertyId, $property_sign, $property_sign_key, $location_id, $patta, $dag, $land_class_code, $patta_type_code, $bigha, $katha, $lessa, $ulpin, $old_ulpin, $revenue, $local_tax, $ganda)
    {
        $office_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $chain_pattadar = array();
        foreach ($pattadar_details as $pattadar) {
            $nestedData = array(
                'pdarid' => $pattadar->pdar_id,
                'pdarname' => $pattadar->pdar_name,
                'pdarfather' => $pattadar->pdar_father,
                'pdarstrikeout' => $pattadar->p_flag,
            );
            $chain_pattadar[] = $nestedData;
        }

        $property_data = array(
            "ulpin" => $ulpin,
            "oldulpin" => $old_ulpin,
            "location" => $location_id,
            "dagno" => $dag,
            "pattano" => $patta,
            "pattatype" => $patta_type_code,
            "landclass" => $land_class_code,
            "revenue" => $revenue,
            "localtax" => $local_tax,
            "bigha" => strval($bigha),
            "katha" => strval($katha),
            "lessa" => strval($lessa),
            "ganda" => strval($ganda),
            "pid" => $chain_pattadar,
        );

        $json_encode_prop_data = json_encode($property_data);

        $send_data = array(
            "office_code" => $office_code,
            "user_code" => $user_code,
            "records" => array(
                array(
                    "propertyid" => $propertyId,
                    "propertydata" => base64_encode($json_encode_prop_data),
                    "propertysignature" => $property_sign,
                    "propertysignerkey" => $property_sign_key,
                ),
            ),
        );

        $payload = json_encode($send_data);

        return $payload;
    }

    public function getassetPendInPush()
    {
        //$this->dbswitch();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $query = "SELECT * FROM chitha_basic WHERE ulpin is null and map_for_property is null  and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ORDER BY dag_no LIMIT 5";

        $result = $this->db->query($query)->result();

        return $result;
    }

    public function insertBhuCaseDetails($reference_id, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $old_patta, $old_dag, $new_patta_no, $new_dag_no, $ulpin, $bigha_new, $katha_new, $lessa_new, $ganda_new)
    {
        //$this->dbswitch();

        $data = array(
            'case_no' => $reference_id,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'old_patta_no' => $old_patta,
            'old_dag_no' => $old_dag,
            'patta_no' => $new_patta_no,
            'dag_no' => $new_dag_no,
            'old_ulpin' => $ulpin,
            'map_for_property' => 'N',
            'p_dag_area_b' => $bigha_new,
            'p_dag_area_k' => $katha_new,
            'p_dag_area_lc' => $lessa_new,
            'p_dag_area_g' => $ganda_new,
            'mut_date' => date('Y-m-d'),
        );

        $insert = $this->db->insert('bhun_map_creation_cases', $data);

        return $insert;
    }

    public function getChithaBasicData($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza_pargona_code, $vill_code, $dag_no, $patta_no, $patta_type_code)
    {
        $query = $this->db->get_where('chitha_basic', array('dist_code' => $dist_code, 'subdiv_code' => $subdiv_code, 'cir_code' => $cir_code, 'lot_no' => $lot_no, 'mouza_pargona_code' => $mouza_pargona_code, 'vill_townprt_code' => $vill_code, 'dag_no' => $dag_no, 'patta_no' => trim($patta_no), 'patta_type_code' => $patta_type_code));
        $data = $this->db->query($query)->row();

        return $data;
    }

    public function getFieldMutPartTrans($office_code, $user_code, $propertyId, $prop_data, $certmnemonic, $referenceId)
    {
        $currentTransPdars = array();
        if ($certmnemonic == 'MUT') {
            $getPetnPdars = $this->PropChainModel->getPetnPdar($referenceId);
            $getOccupPdars = $this->PropChainModel->getOccupPdar($referenceId);
            $currentTransPdars = array_merge($getPetnPdars, $getOccupPdars);
        } elseif ($certmnemonic == 'PRT') {
            $getPartnPdars = $this->PropChainModel->getPatnPdar($referenceId);
            $currentTransPdars = $getPartnPdars;
        }

        $result = $this->blockchainutilityclass->getPropTransData($office_code, $user_code, $propertyId, $prop_data, $certmnemonic, $referenceId);

        $trans_data = json_decode($result->property_data);
        // echo "<pre>";
        // var_dump($trans_data);
        // die;

        $data['success'] = $result->success;
        $data['message'] = $result->message;
        $data['certmnemonic'] = $certmnemonic;
        $data['trans_data'] = $trans_data;
        $data['current_trans_pdars'] = $currentTransPdars;
        // var_dump($data['property_data']);
        $data['timestamp'] = $result->timestamp;
        $data['error_code'] = $result->error_code;
        $data['error_msg'] = $result->error_msg;

        return $data;
    }

    public function getOfficeMutPartTrans($office_code, $user_code, $propertyId, $prop_data, $certmnemonic, $referenceId)
    {
        $currentTransPdars = array();
        if ($certmnemonic == 'MUT') {
            $currentTransPdars = $this->PropChainModel->getOfcMutPdar($referenceId);
        } elseif ($certmnemonic == 'PRT') {
            $currentTransPdars = $this->PropChainModel->getOfcPatnPdar($referenceId);
        }

        $result = $this->blockchainutilityclass->getPropTransData($office_code, $user_code, $propertyId, $prop_data, $certmnemonic, $referenceId);

        $trans_data = json_decode($result->property_data);
        // echo "<pre>";
        // var_dump($property_data);
        // die;

        $data['success'] = $result->success;
        $data['message'] = $result->message;
        $data['certmnemonic'] = $certmnemonic;
        $data['trans_data'] = $trans_data;
        $data['current_trans_pdars'] = $currentTransPdars;
        // var_dump($data['property_data']);
        $data['timestamp'] = $result->timestamp;
        $data['error_code'] = $result->error_code;
        $data['error_msg'] = $result->error_msg;
        return $data;
    }

    public function getPropTrans($office_code, $user_code, $propertyId, $prop_data, $certmnemonic, $referenceId)
    {
        $result = $this->blockchainutilityclass->getPropTransData($office_code, $user_code, $propertyId, $prop_data, $certmnemonic, $referenceId);

        $trans_data = json_decode($result->property_data);
        // echo "<pre>";
        // var_dump($property_data);
        // die;

        $data['success'] = $result->success;
        $data['message'] = $result->message;
        $data['certmnemonic'] = $certmnemonic;
        $data['trans_data'] = $trans_data;
        // $data['current_trans_pdars'] = $currentTransPdars;
        // var_dump($trans_data);
        // die;
        $data['timestamp'] = $result->timestamp;
        $data['error_code'] = $result->error_code;
        $data['error_msg'] = $result->error_msg;
        return $data;
    }

    // public function createChainData()
    // {
    //     $create_prop_data = $this->input->post('property_data');
    //     $property_data = json_decode(base64_decode($this->input->post('property_data')));
    //     // $property_id = $this->input->post('property_id');
    //     $prop_sign = $this->input->post('prop_sign');
    //     $prop_sign_key = $this->input->post('prop_sign_key');
    //     $digital_certificate = $this->input->post('digi_cert');
    //     $office_code = $this->session->userdata('cir_code');
    //     $user_code = $this->session->userdata('user_code');

    //     $dist_code = substr($property_data->location, 0, 2);
    //     $subdiv_code = substr($property_data->location, 2, 2);
    //     $circle_code = substr($property_data->location, 4, 2);
    //     $mouza_code = substr($property_data->location, 6, 2);
    //     $lot_no = substr($property_data->location, 8, 2);
    //     $vill_code = substr($property_data->location, 10, 5);

    //     $gisCode = $dist_code . '_' . $subdiv_code . '_' . $circle_code . '_' . $mouza_code . '_' . $lot_no . '_' . $vill_code;
    //     $state = ASSAM_STATE_CODE;
    //     $dag = $property_data->dagno;
    //     $patta = $property_data->pattano;

    //     // check if ulpin exists and get GeoJson Data
    //     $getUlPin = $this->blockchainutilityclass->getGeoJsonAPI($state, $gisCode,  $dag);

    //     $ulpinDetails = json_decode($getUlPin);
    //     // echo "<pre>";
    //     // var_dump($property_data);
    //     $this->db->trans_begin();

    //     if (!empty($ulpinDetails->features) && $ulpinDetails->features[0]->properties->pniu != null) {

    //         $ulpin = $ulpinDetails->features[0]->properties->pniu;
    //         $geomType = $ulpinDetails->features[0]->geometry->type;
    //         $coordinates = $ulpinDetails->features[0]->geometry->coordinates;
    //         $old_ulpin = ""; //send empty old ulpin

    //         //     //////////////////////////////////////////////////////////////////////////// dsc test /////////////////////////////////////////////////////////
    //         //     $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $vill_code, $patta, $dag, $ulpin);

    //         //     $create_prop_data = $this->blockchainutilityclass->getCreatePropArray($property_data->pid, $property_data->location, $property_data->pattano, $property_data->dagno, $property_data->landclass, $property_data->pattatype, $property_data->bigha, $property_data->katha, $property_data->lessa, $ulpin, $old_ulpin, $property_data->revenue, $property_data->localtax, $property_data->ganda);
    //         //     $result = $this->blockchainutilityclass->propChainCreateApi($create_prop_data, $user_code, $office_code, $property_id, $prop_sign, $prop_sign_key, $digital_certificate);
    //         // }
    //         // ////////////////////////////////////////////////////////////////////////////dsc test end///////////////////////////////////////////////////////
    //         // var_dump($insertUlpinDetails);
    //         // die;
    //         // update chitha basic with ulpin

    //         $updateChithaBasic = $this->ulpinUpdateChtBsc($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->pattano, $property_data->dagno, $property_data->pattatype, $property_data->landclass, $old_ulpin, $ulpin);

    //         if ($updateChithaBasic > 0) {
    //             // insert ulpin details in ulpin_details relation

    //             $insertUlpinDetails = $this->insertUlpinDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->pattano, $property_data->dagno, $property_data->pattatype, $property_data->landclass, $old_ulpin, $ulpin);

    //             if ($insertUlpinDetails) {
    //                 // $this->db->trans_commit();

    //                 $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $vill_code, $patta, $dag, $ulpin);

    //                 // $create_prop_data = $this->blockchainutilityclass->getCreatePropArray($property_data->pid, $property_data->location, $property_data->pattano, $property_data->dagno, $property_data->landclass, $property_data->pattatype, $property_data->bigha, $property_data->katha, $property_data->lessa, $ulpin, $old_ulpin, $property_data->revenue, $property_data->localtax, $property_data->ganda);

    //                 // var_dump($create_prop_data);
    //                 // die;
    //                 // $this->db->trans_rollback();

    //                 // call create asset api
    //                 $result = $this->blockchainutilityclass->propChainCreateApi($create_prop_data, $user_code, $office_code, $property_id, $prop_sign, $prop_sign_key, $digital_certificate);

    //                 if ($result->success == 1) {
    //                     $this->db->trans_commit();

    //                     // insert into transaction table
    //                     $this->chainTransactionInsert($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->dagno, $property_data->pattano, $property_data->landclass, $property_data->pattatype, $property_id, $result->transaction_id, CERTMNEMONIC_ROR, $property_id, $user_code, $ulpin);

    //                     // echo "<pre>";
    //                     // var_dump($property_data);

    //                     //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! (Map updation code START) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    //                     /////////////////////////// if map found //////////////////////////////////

    //                     $ulpinChainUpdData = $this->blockchainutilityclass->getMapUpdateArray($property_data->pid, $property_data->location, $property_id, $ulpin, $property_data->dagno, $property_data->pattano, $property_data->pattatype, $property_data->landclass, $property_data->bigha, $property_data->katha,  $property_data->lessa, $property_data->ganda, CERTMNEMONIC_MAP, $prop_sign, $prop_sign_key, $office_code, $user_code, $ulpin, $old_ulpin, $property_data->revenue, $property_data->localtax, $geomType, $coordinates);
    //                     // var_dump($ulpinChainUpdData);

    //                     //////////////////////// call update api///////////////////////////////
    //                     $ulpinUpdate = $this->blockchainutilityclass->propertyChainUpdateApi($ulpinChainUpdData);
    //                     // var_dump($ulpinUpdate);

    //                     if ($ulpinUpdate->success == 1) {

    //                         ///////////////// insert into trasaction table/////////////////////////////////////////

    //                         $this->chainTransactionInsert($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->dagno, $property_data->pattano, $property_data->landclass, $property_data->pattatype, $property_id, $ulpinUpdate->transaction_id, CERTMNEMONIC_MAP, $ulpin, $user_code, $ulpin);

    //                         $result1 = array(
    //                             "success" => 1,
    //                             "transaction_id" => $result->transaction_id . "/" . $ulpinUpdate->transaction_id,
    //                             "message" => '*' . $result->message . ". \n*" . $ulpinUpdate->message,
    //                             "timestamp" => $result->timestamp . " and " . $ulpinUpdate->timestamp
    //                         );
    //                     } else {
    //                         $result1 = array(
    //                             "success" => $ulpinUpdate->success,
    //                             "transaction_id" => $result->transaction_id . "/" . $ulpinUpdate->transaction_id,
    //                             "error_msg" => $result->message . " and " . $ulpinUpdate->error_msg,
    //                             "error_code" => $result->error_code . " and " . $ulpinUpdate->error_code,
    //                             "timestamp" => $result->timestamp . " and " . $ulpinUpdate->timestamp
    //                         );
    //                     }
    //                     // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!(Map updation code END) !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    //                     //////////////////////////////////////////////////////////////// use this code to when map updation is to be stopped and comment the 'Map updation code' section (START) ////////////////////////////////////////////////////////////

    //                     // $result1 = array(
    //                     //     "success" => 1,
    //                     //     "transaction_id" => $result->transaction_id,
    //                     //     "message" => $result->message,
    //                     //     "timestamp" => $result->timestamp
    //                     // );
    //                     /////////////////////////////////////////////////////////////////use this code to when map updation is to be stopped and comment the 'Map updation code' section (END)///////////////////////////////////////////////////////////

    //                 } else {
    //                     $this->db->trans_rollback();

    //                     $result1 = array(
    //                         "success" => $result->success,
    //                         "message" => $result->message,
    //                         "error_msg" => $result->error_msg,
    //                         "error_code" => $result->error_code,
    //                         "timestamp" => $result->timestamp
    //                     );
    //                 }
    //             } else {
    //                 $this->db->trans_rollback();
    //                 $result1 = array(
    //                     "success" => 0,
    //                     "message" => 'Database Error',
    //                     "error_msg" => 'Unable to save ulpin details',
    //                     "error_code" => '#ULPININSERROR0001',
    //                     // unable to save in ulpin_details

    //                 );
    //             }
    //         } else {
    //             $this->db->trans_rollback();
    //             $result1 = array(
    //                 "success" => 0,
    //                 "message" => 'Database Error',
    //                 "error_msg" => 'Unable to save ulpin details',
    //                 "error_code" => '#ULPININSERROR0002',
    //                 // unable to save in chitha_basic
    //             );
    //         }
    //     } elseif (empty($ulpinDetails->features) || $ulpinDetails->features[0]->properties->pniu == null || $ulpinDetails == null) {
    //         if (empty($ulpinDetails) || $ulpinDetails->features[0]->properties->pniu == null)
    //             $result1 = array(
    //                 "success" => 0,
    //                 "message" => "Ulpin not found",
    //                 "error_msg" => "Ulpin for the property not found. Asset cannot be created",
    //                 "error_code" => "#MAPERROR0001"
    //             );

    //         if ($ulpinDetails == null)
    //             $result1 = array(
    //                 "success" => 0,
    //                 "message" => "Ulpin not found",
    //                 "error_msg" => "Unable to connect to ulpin API. Asset cannot be created",
    //                 "error_code" => "#MAPERROR0004"
    //             );
    //     } else {
    //         $result1 = array(
    //             "success" => 0,
    //             "message" => "Error",
    //             "error_msg" => "Unable to connect to Bhunaksha API or something went wrong",
    //             "error_code" => "#MAPERROR0002"
    //         );
    //     }

    //     $result = (object)$result1;

    //     if ($result->success == 0)
    //         log_message("error", $result->message . ": " . $result->error_msg . ". Error Code: " . $result->error_code);

    //     echo json_encode($result);
    // }

    // !!!!!!!!!!!!!!!!!!!!!!!!!!!!property pushed directly at the property chain !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

    /* public function createChainData()
    {
        $create_prop_data = $this->input->post('property_data');
        $property_data = json_decode(base64_decode($this->input->post('property_data')));
        // $property_id = $this->input->post('property_id');
        $prop_sign = $this->input->post('prop_sign');
        $prop_sign_key = $this->input->post('prop_sign_key');
        $digital_certificate = $this->input->post('digi_cert');
        $office_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $dist_code = substr($property_data->location, 0, 2);
        $subdiv_code = substr($property_data->location, 2, 2);
        $circle_code = substr($property_data->location, 4, 2);
        $mouza_code = substr($property_data->location, 6, 2);
        $lot_no = substr($property_data->location, 8, 2);
        $vill_code = substr($property_data->location, 10, 5);

        $gisCode = $dist_code . '_' . $subdiv_code . '_' . $circle_code . '_' . $mouza_code . '_' . $lot_no . '_' . $vill_code;
        $state = ASSAM_STATE_CODE;
        $dag = $property_data->dagno;
        $patta = $property_data->pattano;

        // check if ulpin exists and get GeoJson Data
        $getUlPin = $this->blockchainutilityclass->getGeoJsonAPI($state, $gisCode, $dag);

        $ulpinDetails = json_decode($getUlPin);
        // echo "<pre>";
        // var_dump($property_data);
        $this->db->trans_begin();

        if (!empty($ulpinDetails->features) && $ulpinDetails->features[0]->properties->pniu != null) {

            $ulpin = $ulpinDetails->features[0]->properties->pniu;
            $geomType = $ulpinDetails->features[0]->geometry->type;
            //$coordinates = $ulpinDetails->features[0]->geometry->coordinates;
            $old_ulpin = $property_data->oldulpin;
            //     //////////////////////////////////////////////////////////////////////////// dsc test /////////////////////////////////////////////////////////
            //     $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $vill_code, $patta, $dag, $ulpin);

            //     $create_prop_data = $this->blockchainutilityclass->getCreatePropArray($property_data->pid, $property_data->location, $property_data->pattano, $property_data->dagno, $property_data->landclass, $property_data->pattatype, $property_data->bigha, $property_data->katha, $property_data->lessa, $ulpin, $old_ulpin, $property_data->revenue, $property_data->localtax, $property_data->ganda);
            //     $result = $this->blockchainutilityclass->propChainCreateApi($create_prop_data, $user_code, $office_code, $property_id, $prop_sign, $prop_sign_key, $digital_certificate);
            // }
            // ////////////////////////////////////////////////////////////////////////////dsc test end///////////////////////////////////////////////////////
            // var_dump($insertUlpinDetails);
            // die;
            // update chitha basic with ulpin

            $updateChithaBasic = $this->ulpinUpdateChtBsc($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->pattano, $property_data->dagno, $property_data->pattatype, $property_data->landclass, $old_ulpin, $ulpin);

            if ($updateChithaBasic > 0) {
                // insert ulpin details in ulpin_details relation

                $insertUlpinDetails = $this->insertUlpinDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->pattano, $property_data->dagno, $property_data->pattatype, $property_data->landclass, $old_ulpin, $ulpin);

                if ($insertUlpinDetails) {
                    // $this->db->trans_commit();

                    $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $vill_code, $patta, $dag, $ulpin);

                    // $create_prop_data = $this->blockchainutilityclass->getCreatePropArray($property_data->pid, $property_data->location, $property_data->pattano, $property_data->dagno, $property_data->landclass, $property_data->pattatype, $property_data->bigha, $property_data->katha, $property_data->lessa, $ulpin, $old_ulpin, $property_data->revenue, $property_data->localtax, $property_data->ganda);

                    // var_dump($create_prop_data);
                    // die;
                    // $this->db->trans_rollback();

                    // call create asset api
                    $result = $this->blockchainutilityclass->propChainCreateApi($create_prop_data, $user_code, $office_code, $property_id, $prop_sign, $prop_sign_key, $digital_certificate);

                    if ($result->success == 1) {
                        $this->db->trans_commit();

                        // insert into transaction table
                        $this->chainTransactionInsert($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->dagno, $property_data->pattano, $property_data->landclass, $property_data->pattatype, $property_id, $result->transaction_id, CERTMNEMONIC_ROR, $property_id, $user_code, $ulpin);

                        // echo "<pre>";
                        // var_dump($property_data);
                        $prop_sign = $prop_sign_key = '';
                        // $ulpinChainUpdData = $this->blockchainutilityclass->getMapUpdateArray($property_data->pid, $property_data->location, $property_id, $ulpin, $property_data->dagno, $property_data->pattano, $property_data->pattatype, $property_data->landclass, $property_data->bigha, $property_data->katha, $property_data->lessa, $property_data->ganda, CERTMNEMONIC_MAP, $prop_sign, $prop_sign_key, $office_code, $user_code, $ulpin, $old_ulpin, $property_data->revenue, $property_data->localtax, $geomType, $getUlPin);

                        $update_map_params = array(
                            'pattadar_details' => $property_data->pid,
                            'location_id' => $property_data->location,
                            'property_id' => $property_id,
                            'reference_id' => $ulpin,
                            'dag_no' => $property_data->dagno,
                            'patta_no' => $property_data->pattano,
                            'patta_type_code' => $property_data->pattatype,
                            'land_class_code' => $property_data->landclass,
                            'bigha_chain' => $property_data->bigha,
                            'katha_chain' => $property_data->katha,
                            'lessa_chain' => $property_data->lessa,
                            'ganda_chain' => $property_data->ganda,
                            'certmnemonic' => CERTMNEMONIC_MAP,
                            'property_signature' => $prop_sign,
                            'property_signer_key' => $prop_sign_key,
                            'office_code' => $office_code,
                            'user_code' => $user_code,
                            'ulpin' => $ulpin,
                            'old_ulpin' => $old_ulpin,
                            'revenue' => $property_data->revenue,
                            'local_tax' => $property_data->localtax,
                            'geomType' => $geomType,
                            'geo_json' => $getUlPin
                        );

                        $ulpinChainUpdData = $this->blockchainutilityclass->getMapUpdateArrayN((object)$update_map_params);

                        // var_dump($ulpinChainUpdData);

                        $result1 = array(
                            "success" => 1,
                            "map_data" => base64_encode(json_encode($ulpinChainUpdData)),
                            "property_data" => base64_encode(json_encode($ulpinChainUpdData['property_data'])),
                            "transaction_id" => $result->transaction_id,
                            "message" => $result->message,
                            "timestamp" => $result->timestamp,
                        );
                    } else {
                        $this->db->trans_rollback();

                        $result1 = array(
                            "success" => $result->success,
                            "message" => $result->message,
                            "error_msg" => $result->error_msg,
                            "error_code" => $result->error_code,
                            "timestamp" => $result->timestamp,
                        );
                    }
                } else {
                    $this->db->trans_rollback();
                    $result1 = array(
                        "success" => 0,
                        "message" => 'Database Error',
                        "error_msg" => 'Unable to save ulpin details',
                        "error_code" => '#ULPININSERROR0001',
                        // unable to save in ulpin_details

                    );
                }
            } else {
                $this->db->trans_rollback();
                $result1 = array(
                    "success" => 0,
                    "message" => 'Database Error',
                    "error_msg" => 'Unable to save ulpin details',
                    "error_code" => '#ULPININSERROR0002',
                    // unable to save in chitha_basic
                );
            }
        } elseif (empty($ulpinDetails->features) || $ulpinDetails->features[0]->properties->pniu == null || $ulpinDetails == null) {
            if (empty($ulpinDetails) || $ulpinDetails->features[0]->properties->pniu == null) {
                $result1 = array(
                    "success" => 0,
                    "message" => "Ulpin not found",
                    "error_msg" => "Ulpin for the property not found. Asset cannot be created",
                    "error_code" => "#MAPERROR0001",
                );
            }

            if ($ulpinDetails == null) {
                $result1 = array(
                    "success" => 0,
                    "message" => "Ulpin not found",
                    "error_msg" => "Unable to connect to ulpin API. Asset cannot be created",
                    "error_code" => "#MAPERROR0004",
                );
            }
        } else {
            $result1 = array(
                "success" => 0,
                "message" => "Error",
                "error_msg" => "Unable to connect to Bhunaksha API or something went wrong",
                "error_code" => "#MAPERROR0002",
            );
        }
        /////////////////////////////////////////////////// for testing ///////////////////////////////////////////////////////////////////
        // $result1 = array(
        //     "success" => 1,
        //     "map_data" => "test",
        //     "property_data" => "test"
        // );
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $result = (object) $result1;

        if ($result->success == 0) {
            log_message("error", $result->message . ": " . $result->error_msg . ". Error Code: " . $result->error_code);
        }

        echo json_encode($result);
    }*/


    /* !!!!!!! new createChainData first inserted in the database and then will be added to the property chain in bulk !!!!!!*/

    public function createChainData()
    {
        $create_prop_data = $this->input->post('property_data');
        $property_data = json_decode(base64_decode($this->input->post('property_data')));
        // $property_id = $this->input->post('property_id');
        $prop_sign = $this->input->post('prop_sign');
        $prop_sign_key = $this->input->post('prop_sign_key');
        $digital_certificate = $this->input->post('digi_cert');
        $office_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $dist_code = substr($property_data->location, 0, 2);
        $subdiv_code = substr($property_data->location, 2, 2);
        $circle_code = substr($property_data->location, 4, 2);
        $mouza_code = substr($property_data->location, 6, 2);
        $lot_no = substr($property_data->location, 8, 2);
        $vill_code = substr($property_data->location, 10, 5);

        $gisCode = $dist_code . '_' . $subdiv_code . '_' . $circle_code . '_' . $mouza_code . '_' . $lot_no . '_' . $vill_code;
        $state = ASSAM_STATE_CODE;
        $dag = $property_data->dagno;
        $patta = $property_data->pattano;

        // check if ulpin exists and get GeoJson Data
        $getUlPin = $this->blockchainutilityclass->getGeoJsonAPI($state, $gisCode, $dag);

        $ulpinDetails = json_decode($getUlPin);
        // echo "<pre>";
        // var_dump($property_data);
        $this->db->trans_begin();

        if (!empty($ulpinDetails->features) && $ulpinDetails->features[0]->properties->pniu != null) {

            $ulpin = $ulpinDetails->features[0]->properties->pniu;
            $geomType = $ulpinDetails->features[0]->geometry->type;
            //$coordinates = $ulpinDetails->features[0]->geometry->coordinates;
            $old_ulpin = $property_data->oldulpin;
            //     //////////////////////////////////////////////////////////////////////////// dsc test /////////////////////////////////////////////////////////
            //     $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $vill_code, $patta, $dag, $ulpin);

            //     $create_prop_data = $this->blockchainutilityclass->getCreatePropArray($property_data->pid, $property_data->location, $property_data->pattano, $property_data->dagno, $property_data->landclass, $property_data->pattatype, $property_data->bigha, $property_data->katha, $property_data->lessa, $ulpin, $old_ulpin, $property_data->revenue, $property_data->localtax, $property_data->ganda);
            //     $result = $this->blockchainutilityclass->propChainCreateApi($create_prop_data, $user_code, $office_code, $property_id, $prop_sign, $prop_sign_key, $digital_certificate);
            // }
            // ////////////////////////////////////////////////////////////////////////////dsc test end///////////////////////////////////////////////////////
            // var_dump($insertUlpinDetails);
            // die;
            // update chitha basic with ulpin

            $updateChithaBasic = $this->ulpinUpdateChtBsc($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->pattano, $property_data->dagno, $property_data->pattatype, $property_data->landclass, $old_ulpin, $ulpin);

            if ($updateChithaBasic > 0) {
                //update bhu map details if map done in bhunaksha==========MRI

                $bhuFlag = $this->updateBhuMapDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->dagno);

    
                // insert ulpin details in ulpin_details relation

                $insertUlpinDetails = $this->insertUlpinDetails($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->pattano, $property_data->dagno, $property_data->pattatype, $property_data->landclass, $old_ulpin, $ulpin);

                if ($insertUlpinDetails) {
                    // $this->db->trans_commit();

                    $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $vill_code, $patta, $dag, $ulpin);

                    // call create asset api
                    // $result = $this->blockchainutilityclass->propChainCreateApi($create_prop_data, $user_code, $office_code, $property_id, $prop_sign, $prop_sign_key, $digital_certificate);
                    $create_data = $this->blockchainutilityclass->getCreateChainArray($property_data, $property_id, $prop_sign, $prop_sign_key, $digital_certificate);
                    $save_to_db = $this->save_chain_data(json_encode($create_data), CERTMNEMONIC_ROR . ':' . $property_id);
                    $hashed_data =  hash('sha512', base64_encode(json_encode($create_data['property_data'])));
                    if ($save_to_db) {
                        $this->db->trans_commit();

                        // insert into transaction table
                        // $this->chainTransactionInsert($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $property_data->dagno, $property_data->pattano, $property_data->landclass, $property_data->pattatype, $property_id, $result->transaction_id, CERTMNEMONIC_ROR, $property_id, $user_code, $ulpin);

                        // echo "<pre>";
                        // var_dump($property_data);
                        $prop_sign = $prop_sign_key = '';

                        $update_map_params = array(
                            'pattadar_details' => $property_data->pid,
                            'location_id' => $property_data->location,
                            'property_id' => $property_id,
                            'reference_id' => $ulpin,
                            'dag_no' => $property_data->dagno,
                            'patta_no' => $property_data->pattano,
                            'patta_type_code' => $property_data->pattatype,
                            'land_class_code' => $property_data->landclass,
                            'bigha_chain' => $property_data->bigha,
                            'katha_chain' => $property_data->katha,
                            'lessa_chain' => $property_data->lessa,
                            'ganda_chain' => $property_data->ganda,
                            'certmnemonic' => CERTMNEMONIC_MAP,
                            'property_signature' => $prop_sign,
                            'property_signer_key' => $prop_sign_key,
                            'office_code' => $office_code,
                            'user_code' => $user_code,
                            'ulpin' => $ulpin,
                            'old_ulpin' => $old_ulpin,
                            'revenue' => $property_data->revenue,
                            'local_tax' => $property_data->localtax,
                            'geomType' => $geomType,
                            'geo_json' => $getUlPin,
                            'previous_hash' => $hashed_data
                        );

                        $ulpinChainUpdData = $this->blockchainutilityclass->getMapUpdateArrayN((object)$update_map_params);

                        // var_dump($ulpinChainUpdData);

                        $result1 = array(
                            "success" => 1,
                            "map_data" => base64_encode(json_encode($ulpinChainUpdData)),
                            "property_data" => base64_encode(json_encode($ulpinChainUpdData['property_data'])),
                            // "transaction_id" => $result->transaction_id,
                            // "message" => $result->message,
                            // "timestamp" => $result->timestamp,
                            "message" => "Data successfully saved in DB"
                        );
                    } else {
                        $this->db->trans_rollback();

                        $result1 = array(
                            "success" => 0,
                            "message" => 'DB error',
                            "error_msg" => 'Unable to save data',
                            "error_code" => '#ASSETSAVEERROR0001'
                            // "timestamp" => $result->timestamp,
                        );
                    }
                } else {
                    $this->db->trans_rollback();
                    $result1 = array(
                        "success" => 0,
                        "message" => 'Database Error',
                        "error_msg" => 'Unable to save ulpin details',
                        "error_code" => '#ULPININSERROR0001',
                        // unable to save in ulpin_details

                    );
                }
            } else {
                $this->db->trans_rollback();
                $result1 = array(
                    "success" => 0,
                    "message" => 'Database Error',
                    "error_msg" => 'Unable to save ulpin details',
                    "error_code" => '#ULPININSERROR0002',
                    // unable to save in chitha_basic
                );
            }
        } elseif (empty($ulpinDetails->features) || $ulpinDetails->features[0]->properties->pniu == null || $ulpinDetails == null) {
            if (empty($ulpinDetails) || $ulpinDetails->features[0]->properties->pniu == null) {
                $result1 = array(
                    "success" => 0,
                    "message" => "Ulpin not found",
                    "error_msg" => "Ulpin for the property not found. Asset cannot be created",
                    "error_code" => "#MAPERROR0001",
                );
            }

            if ($ulpinDetails == null) {
                $result1 = array(
                    "success" => 0,
                    "message" => "Ulpin not found",
                    "error_msg" => "Unable to connect to ulpin API. Asset cannot be created",
                    "error_code" => "#MAPERROR0004",
                );
            }
        } else {
            $result1 = array(
                "success" => 0,
                "message" => "Error",
                "error_msg" => "Unable to connect to Bhunaksha API or something went wrong",
                "error_code" => "#MAPERROR0002",
            );
        }
        /////////////////////////////////////////////////// for testing ///////////////////////////////////////////////////////////////////
        // $result1 = array(
        //     "success" => 1,
        //     "map_data" => "test",
        //     "property_data" => "test"
        // );
        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        $result = (object) $result1;

        if ($result->success == 0) {
            log_message("error", $result->message . ": " . $result->error_msg . ". Error Code: " . $result->error_code);
        }

        echo json_encode($result);
    }

    // !!!!!!!!!!!! updating map directy in the property chain !!!!!!!!!!!!!!!!!!!!
    /* public function updateMapData()
    {

        $map_data = json_decode(base64_decode($this->input->post('map_data', true)), true);
        $certificate = $this->input->post('certificate', true);
        $prop_sign = $this->input->post('prop_sign', true);
        $prop_sign_key = $this->input->post('prop_sign_key', true);
        $property_data = json_decode(base64_decode($this->input->post('prop_data', true)));

        $office_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');



        $map_data['certificate'] = $certificate;
        $map_data['property_signature'] = $prop_sign;
        $map_data['property_signer_key'] = $prop_sign_key;
        $map_data['property_data'] = $property_data;
        // echo "<pre>";
        // var_dump($map_data['property_data']->location);
        $location = $map_data['property_data']->location;
        // echo $location;

        $dist_code = substr($location, 0, 2);
        $subdiv_code = substr($location, 2, 2);
        $circle_code = substr($location, 4, 2);
        $mouza_code = substr($location, 6, 2);
        $lot_no = substr($location, 8, 2);
        $vill_code = substr($location, 10, 5);
        $encode_data = base64_encode(json_encode($map_data));
        // var_dump ($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        //         die;

        $ulpinUpdate = $this->blockchainutilityclass->propertyChainUpdateApi($map_data);
        // var_dump($ulpinUpdate);

        if ($ulpinUpdate->success == 1) {

            ///////////////// insert into trasaction table/////////////////////////////////////////

            $this->chainTransactionInsert($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $map_data['property_data']->dagno, $map_data['property_data']->pattano, $map_data['property_data']->landclass, $map_data['property_data']->pattatype, $map_data['property_id'], $ulpinUpdate->transaction_id, CERTMNEMONIC_MAP, $map_data['property_data']->ulpin, $user_code, $map_data['property_data']->ulpin);

            $result1 = array(
                "success" => 1,
                "transaction_id" => $ulpinUpdate->transaction_id,
                "message" => $ulpinUpdate->message,
                "timestamp" => $ulpinUpdate->timestamp,
            );
        } else {
            $result1 = array(
                "success" => $ulpinUpdate->success,
                "transaction_id" => $ulpinUpdate->transaction_id,
                "error_msg" => $ulpinUpdate->error_msg,
                "error_code" => $ulpinUpdate->error_code,
                "timestamp" => $ulpinUpdate->timestamp,
            );
        }

        echo json_encode($result1);
    }*/

    // !!!!!!!!!!!!!!!!!!!!!!!!!! save the mapdata in table prop_chain_send_data the sent in bulk to property  chain !!!!!!!!!!!!!!!!!!!!!!!!!!!
    public function updateMapData()
    {

        $map_data = json_decode(base64_decode($this->input->post('map_data', true)), true);
        $certificate = $this->input->post('certificate', true);
        $prop_sign = $this->input->post('prop_sign', true);
        $prop_sign_key = $this->input->post('prop_sign_key', true);
        $property_data = json_decode(base64_decode($this->input->post('prop_data', true)));

        $office_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $map_data['certificate'] = $certificate;
        $map_data['property_signature'] = $prop_sign;
        $map_data['property_signer_key'] = $prop_sign_key;
        $map_data['property_data'] = $property_data;
        // echo "<pre>";
        // var_dump($map_data['property_data']->location);
        $location = $map_data['property_data']->location;
        // echo $location;

        $dist_code = substr($location, 0, 2);
        $subdiv_code = substr($location, 2, 2);
        $circle_code = substr($location, 4, 2);
        $mouza_code = substr($location, 6, 2);
        $lot_no = substr($location, 8, 2);
        $vill_code = substr($location, 10, 5);
        $encoded_data = json_encode($map_data);
        // var_dump ($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);

        //         die;

        // $ulpinUpdate = $this->blockchainutilityclass->propertyChainUpdateApi($map_data);
        // var_dump($ulpinUpdate);
        $save_data = $this->save_chain_data($encoded_data, CERTMNEMONIC_MAP . ":" . $map_data['property_data']->ulpin);

        if ($save_data) {

            ///////////////// insert into trasaction table/////////////////////////////////////////

            // $this->chainTransactionInsert($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $map_data['property_data']->dagno, $map_data['property_data']->pattano, $map_data['property_data']->landclass, $map_data['property_data']->pattatype, $map_data['property_id'], $ulpinUpdate->transaction_id, CERTMNEMONIC_MAP, $map_data['property_data']->ulpin, $user_code, $map_data['property_data']->ulpin);

            $result1 = array(
                "success" => 1,
                "message" => "Data saved successfully",
            );
        } else {

            $result1 = array(
                "success" => 0,
                "message" => "DB error",
                "error_msg" => "Unable to save data",
                "error_code" => "#ASSETSAVEERROR0002",
                // "timestamp" => $ulpinUpdate->timestamp,
            );
        }

        echo json_encode($result1);
    }

    public function getUserName($noc_user)
    {
       // $this->dbswitch();

        $this->db->select('use_name');
        $user_name = $this->db->get_where('loginuser_table', array('nocuser' => $noc_user))->row();

        return $user_name->use_name;
    }

    public function dscTestBtn()
    {
        $button = '<a href="#!" id="dsc_sign_btn_id" property-id="' . $property_id . '" prop-data="' . base64_encode(json_encode($property_data)) . '" dag-no="' . $dag_no . '" class="modal-show-dsc btn btn-info text-white create_prop_btn"><i class="fa fa-upload" style="margin:2px;" ></i>&nbsp;Create Property Chain for Dag ' . $dag_no . '</a>';
    }

    public function getUpdateChainArray($pattadar_details, $location_id, $property_id, $reference_id, $dag_no, $patta_no, $patta_type_code, $land_class_code, $bigha_chain, $katha_chain, $lessa_chain, $ganda_chain, $certmnemonic, $property_signature, $property_signer_key, $office_code, $user_code, $ulpin, $old_ulpin, $revenue, $local_tax, $new_patta_no, $new_dag_no, $old_revenue, $old_local_tax, $old_land_class_code, $new_bigha, $new_katha, $new_lessa, $new_ganda)
    {
        //* $new_bigha, $new_katha, $new_lessa, $new_ganda parameters are for partition so for other processes send them as empty string

        //* parameters that are not applicable for a particular process send them as empty string
        $chain_pattadar = array();
        foreach ($pattadar_details as $pattadar) {

            $nestedData['pdarid'] = $pattadar->pdar_id;
            $nestedData['pdarname'] = $pattadar->pdar_name;
            $nestedData['pdarfather'] = $pattadar->pdar_father;
            // if ($pattadar->p_flag == null)
            //     $nestedData['pdarstrikeout'] = "0";
            // else
            $nestedData['pdarstrikeout'] = $pattadar->p_flag;

            $chain_pattadar[] = $nestedData;
        }

        $chain_property_data['ulpin'] = $ulpin;
        $chain_property_data['oldulpin'] = $old_ulpin;

        $chain_property_data['location'] = $location_id;
        $chain_property_data['dagno'] = $dag_no;
        $chain_property_data['pattano'] = $patta_no;

        if ($certmnemonic == 'PRT' || $certmnemonic == 'BLP') {
            $chain_property_data['newdagno'] = $new_dag_no;
            $chain_property_data['newpattano'] = $new_patta_no;
        }

        $chain_property_data['pattatype'] = $patta_type_code;
        $chain_property_data['landclass'] = $land_class_code;

        if ($certmnemonic == 'PRT' || $certmnemonic == 'BLP') {
            $chain_property_data['revenue'] = $old_revenue;
            $chain_property_data['localtax'] = $old_local_tax;
        } else {
            $chain_property_data['revenue'] = $revenue;
            $chain_property_data['localtax'] = $local_tax;
        }

        if ($certmnemonic == 'REC') {
            $chain_property_data['oldlandclass'] = $old_land_class_code;
            $chain_property_data['oldrevenue'] = $old_revenue;
            $chain_property_data['oldlocaltax'] = $old_local_tax;
        }

        if ($certmnemonic == 'PRT' || $certmnemonic == 'BLP') {
            $chain_property_data['newrevenue'] = $revenue;
            $chain_property_data['newlocaltax'] = $local_tax;
        }

        $chain_property_data['bigha'] = strval($bigha_chain);
        $chain_property_data['katha'] = strval($katha_chain);
        $chain_property_data['lessa'] = strval($lessa_chain);
        $chain_property_data['ganda'] = strval($ganda_chain);
        if ($certmnemonic == 'PRT' || $certmnemonic == 'BLP') {
            $chain_property_data['newbigha'] = strval($new_bigha);
            $chain_property_data['newkatha'] = strval($new_katha);
            $chain_property_data['newlessa'] = strval($new_lessa);
            $chain_property_data['newganda'] = strval($new_ganda);
        }
        $chain_property_data['pid'] = $chain_pattadar;

        echo '<script type="text/javascript">alert("test test")</script>';

        // $data['property_data'] = base64_encode(json_encode($chain_property_data));
        // $data['_view'] = 'dsc/dscSignUpdateTest';
        // $this->load->view('layouts/main', $data);
        // return $data;
        // $this->load->view('dsc/signDsc');
    }

    public function dscUpdateData()
    {
        // $chain_send_data = array(
        //     "property_id" =>    "$property_id",
        //     "reference_id" =>  $reference_id,
        //     "certmnemonic" =>  $certmnemonic,
        //     "property_signature" =>  $property_signature,
        //     "property_signer_key" =>  $property_signer_key,
        //     "office_code" =>   $office_code,
        //     "user_code" =>  $user_code,
        //     "property_data" => $chain_property_data
        // );

        $chain_send_data = array(
            "property_id" => "test",
            "reference_id" => "test",
            "certmnemonic" => "test",
            "property_signature" => "test",
            "property_signer_key" => "test",
            "office_code" => "test",
            "user_code" => "test",
            "property_data" => "test",
        );

        return $chain_send_data;
    }

    // edit for dsc sign
    // public function propChainCreateApi($property_data, $user_code, $office_code, $propertyId, $property_sign, $property_sign_key)
    // {
    //     $smsGatewayUrl =  PROP_CHAIN_API . "create.php";

    //     $encode_prop_data = base64_encode(json_encode($property_data));
    //     $dsc_data['encoded_data'] = $encode_prop_data;
    //     $this->load->view('dsc/dscSign', $dsc_data);

    //     $send_data = array(
    //         "office_code" => $office_code,
    //         "user_code" => $user_code,
    //         "records" => array(
    //             array(
    //                 "propertyid" => $propertyId,
    //                 "propertydata" => $encode_prop_data,
    //                 "propertysignature" => $property_sign,
    //                 "propertysignerkey" => $property_sign_key
    //             )
    //         )
    //     );

    //     $payload = json_encode($send_data);
    //     // echo "<pre>";
    //     // print_r($payload);
    //     // die;

    //     // $url = $smsGatewayUrl;

    //     // $ch = curl_init($url);
    //     // curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    //     // curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
    //     // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     // $output = curl_exec($ch);
    //     // curl_close($ch);
    //     // $result = json_decode($output);

    //     // if ($result->success == 0) {
    //     //     log_message("error", $result->message . ": " . $result->error_msg . ". Error Code: " . $result->error_code . "Send data: " . $send_data);
    //     // }

    //     // return $result;
    // }

    /* public function save_chain_data($json_chain_data, $case_no)
    {
        $this->dbswitch();

        if ($json_chain_data == null) {
            return false;
            log_message('error', "Null json passed. case no: $case_no. Error Code: #CHAINSAVEERROR0001 -01");
        } elseif ($json_chain_data != null) {
            $validate_json = $this->blockchainutilityclass->validatePropJson($json_chain_data);
            if ($validate_json) {

                $user_code = $this->session->userdata('user_code');

                $prop_data = json_decode($json_chain_data, true);
                $dist_code = substr($prop_data['property_data']['location'], 0, 2);
                $subdiv_code = substr($prop_data['property_data']['location'], 2, 2);
                $circle_code = substr($prop_data['property_data']['location'], 4, 2);
                $mouza_code = substr($prop_data['property_data']['location'], 6, 2);
                $lot_no = substr($prop_data['property_data']['location'], 8, 2);
                $vill_code = substr($prop_data['property_data']['location'], 10, 5);

                $check_create_or_update = explode(':', $case_no);

                // for create asset previous hash not applicable
                if ($check_create_or_update[0] == CERTMNEMONIC_ROR) {
                    $base_encode_property_data = base64_encode(json_encode($prop_data['property_data']));

                    $prop_data['propertydata'] = $base_encode_property_data;

                    $db_data = array(
                        'case_no' => $case_no,
                        'json_case_data' => json_encode($prop_data),
                        'sending_status' => 'N',
                        'case_passed_time' => date('Y-m-d H:i:s'),
                        'reference_no' => floor(microtime(true) * 1000),
                    );
                    $insert = $this->db->insert('prop_chain_sent_data', $db_data);
                    return $insert;
                } else { //for update get the previous data
                    if ($check_create_or_update[0] == CERTMNEMONIC_MAP) {
                        $hash = hash('sha512', base64_encode(json_encode($prop_data['property_data'])));
                        // $hash = hash('sha512', $prop_data['property_data']);
                    } else {
                        $get_prop_chain = $this->blockchainutilityclass->fetchPropChainData($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $prop_data['property_data']['dagno'], $prop_data['property_data']['pattano'], $user_code, $circle_code, $prop_data['property_data']['ulpin']);
                        $prop_chain = json_decode($get_prop_chain);

                        if ($prop_chain->result == 1) {
                            // sha 512 hash the previous data
                            // $hash = hash('sha512', base64_encode(json_encode($prop_chain['property_data'])));
                            $hash = hash('sha512', base64_encode(json_encode($prop_chain->property_data)));
                        } else {
                            return false;
                            log_message('error', "Unable to fetch data from property chain. case no: $case_no. Error Code: #CHAINSAVEERROR0001 -02");
                        }
                    }

                    $db_data = array(
                        'case_no' => $case_no,
                        'json_case_data' => $json_chain_data,
                        'sending_status' => 'N',
                        'case_passed_time' => date('Y-m-d H:i:s'),
                        'reference_no' => floor(microtime(true) * 1000),
                        'previous_hash' => $hash
                    );
                    $insert = $this->db->insert('prop_chain_sent_data', $db_data);
                    return $insert;
                }
            } else {
                return false;
                log_message('error', "Invalid json passed. Null value present in parameters.Json data: $json_chain_data. case no: $case_no. Error Code: #CHAINSAVEERROR0001 -03");
            }
        }
    }*/

    public function save_chain_data($json_chain_data, $case_no)
    {
       // $this->dbswitch();
        if(ALLOW_LANDREVENUE_FOR_BLOCKCHAIN == 0)
        {
            $json_chain_data = json_decode($json_chain_data, true);
            if(isset($json_chain_data['property_data']['revenue']))
                $json_chain_data['property_data']['revenue'] = '0.00';
            if(isset($json_chain_data['property_data']['localtax']))
                $json_chain_data['property_data']['localtax'] = '0.00';
            if(isset($json_chain_data['property_data']['newrevenue']))
                $json_chain_data['property_data']['newrevenue'] = '0.00';
            if(isset($json_chain_data['property_data']['newlocaltax']))
                $json_chain_data['property_data']['newlocaltax'] = '0.00';
            if(isset($json_chain_data['property_data']['oldrevenue']))
                $json_chain_data['property_data']['oldrevenue'] = '0.00';
            if(isset($json_chain_data['property_data']['oldlocaltax']))
                $json_chain_data['property_data']['oldlocaltax'] = '0.00';

            $json_chain_data = json_encode($json_chain_data);

        }
        //var_dump($json_chain_data.$case_no);exit;

        
        if ($json_chain_data == null) {
            return false;
            log_message('error', "Null json passed. case no: $case_no. Error Code: #CHAINSAVEERROR0001 -01");
        } elseif ($json_chain_data != null) {
            $validate_json = $this->blockchainutilityclass->validatePropJson($json_chain_data);



            if ($validate_json) {

                $user_code = $this->session->userdata('user_code');

                $prop_data = json_decode($json_chain_data, true);
                
                $dist_code = substr($prop_data['property_data']['location'], 0, 2);
                $subdiv_code = substr($prop_data['property_data']['location'], 2, 2);
                $circle_code = substr($prop_data['property_data']['location'], 4, 2);
                $mouza_code = substr($prop_data['property_data']['location'], 6, 2);
                $lot_no = substr($prop_data['property_data']['location'], 8, 2);
                $vill_code = substr($prop_data['property_data']['location'], 10, 5);

                $check_create_or_update = explode(':', $case_no);
                log_message('error',"MB098 : CERTMNEMONIC FOR DHAR==========".json_encode($check_create_or_update[0]));
                // for create asset previous hash not applicable
                if ($check_create_or_update[0] == CERTMNEMONIC_ROR) {
                    $base_encode_property_data = base64_encode(json_encode($prop_data['property_data']));
                    $prop_data['propertydata'] = $base_encode_property_data;
                    //**************************************************************************/
                    //insertion in prop chain audit table for ror 
                    $vill_uuid = null;
                    $vill_uuid = $this->blockchainutilityclass->getVillageUUID($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
                    $dag_no  = $prop_data['property_data']['dagno'];
                    $pattano = $prop_data['property_data']['pattano'];
                    $insertAuditData = array(
                        'dist_code'   => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code'    => $circle_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no'      => $lot_no,
                        'vill_townprt_code' => $vill_code,
                        'village_uuid' => $vill_uuid,
                        'patta_no'    => $pattano,
                        'dag_no'      => $dag_no,
                        'transaction_id' => $case_no,
                        'sent_data_json' => $json_chain_data,
                        'property_chain_status' => 'N',
                        'response_data_json' => null ,
                        'case_no'    => $case_no,
                        'is_digitally_signed' => 'Y',
                        "user_code" => $this->session->all_userdata()['user_code'],
                        'digitally_signed_date_time' => date('Y-m-d H:i:s'),
                        'created_at'  => date('Y-m-d H:i:s'),
                        'modified_at' => date('Y-m-d H:i:s'),
                        'certmnemonic' => CERTMNEMONIC_ROR,
                        'certmnemonic_dharitree' => CERTMNEMONIC_ROR
                    );


                    $pc_audit_flag = $this->PropChainCommonModel->insertPropChainAuditData($insertAuditData);
                   
                    if($pc_audit_flag['result'] == false)
                    {
                        return false;
                    }
                    //**************************************************************************/
                    $db_data = array(
                        'dist_code'   => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code'    => $circle_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_code,
                        'village_uuid' => $vill_uuid,
                        'patta_no' => $pattano,
                        'dag_no' => $dag_no,
                        'created_at'  => date('Y-m-d H:i:s'),
                        'modified_at' => date('Y-m-d H:i:s'),
                        'is_digitally_signed' => 'Y',
                        'digitally_signed_date_time' => date('Y-m-d H:i:s'),
                        'case_no' => $case_no,
                        'json_case_data' => json_encode($prop_data),
                        'sending_status' => 'N',
                        'case_passed_time' => date('Y-m-d H:i:s'),
                        'reference_no' => floor(microtime(true) * 1000),
                        'certmnemonic' => CERTMNEMONIC_ROR,
                        'certmnemonic_dharitree' => CERTMNEMONIC_ROR
                    );
                    $insert = $this->db->insert('prop_chain_sent_data', $db_data);
                    return $insert;
                } else { //for update get the previous data
                    $hash = null;
                    if ($check_create_or_update[0] != CERTMNEMONIC_MAP) 
                    {
                        $x = explode('/',$check_create_or_update[0]);
                        $certmnemonic_dharitree = $x[4];
                        $certmnemonic = $x[4];

                        //changes certmnemonic for bulk push transaction =========
                        $certmnemonic = $this->getCertmnemonicForProcess($certmnemonic);
                        



                        $is_digitally_signed = 'N';
                        $digitally_signed_date_time = null;
                        $hash = hash('sha512', base64_encode(json_encode($prop_data['property_data'])));
                        // $hash = hash('sha512', $prop_data['property_data']);

                        $get_prop_chain = $this->blockchainutilityclass->fetchPropChainData($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code, $prop_data['property_data']['dagno'], $prop_data['property_data']['pattano'], $user_code, $circle_code, $prop_data['property_data']['ulpin']);
                        $prop_chain = json_decode($get_prop_chain);


                        if ($prop_chain->result == 1) {
                            // sha 512 hash the previous data
                            // $hash = hash('sha512', base64_encode(json_encode($prop_chain['property_data'])));
                            $hash = hash('sha512', base64_encode(json_encode($prop_chain->property_data)));
                        } 
                        else {
                            return false;
                            log_message('error', "Unable to fetch data from property chain. case no: $case_no. Error Code: #CHAINSAVEERROR0001 -02");
                        }
                    }
                    else
                    {


                        $is_digitally_signed = 'Y';
                        $digitally_signed_date_time = date('Y-m-d H:i:s');
                        $certmnemonic = CERTMNEMONIC_MAP;
                        $certmnemonic_dharitree = CERTMNEMONIC_MAP;
                        


                    }

                    ///////////////INSERT=====================AUDIT/////////////
                    $vill_uuid = null;
                    $vill_uuid = $this->blockchainutilityclass->getVillageUUID($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
                    $dag_no  = $prop_data['property_data']['dagno'];
                    $pattano = $prop_data['property_data']['pattano'];
                    
                    $insertAuditData = array(
                        'dist_code'   => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code'    => $circle_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no'      => $lot_no,
                        'vill_townprt_code' => $vill_code,
                        'village_uuid' => $vill_uuid,
                        'patta_no'    => $pattano,
                        'dag_no'      => $dag_no,
                        'transaction_id' => $case_no,
                        'sent_data_json' => $json_chain_data,
                        'property_chain_status' => 'N',
                        'response_data_json' => null ,
                        'case_no'    => $case_no,
                        'is_digitally_signed' => $is_digitally_signed ,
                        'digitally_signed_date_time' => $digitally_signed_date_time ,
                        'created_at'  => date('Y-m-d H:i:s') ,
                        'modified_at' => date('Y-m-d H:i:s'),
                        'user_code' => $this->session->all_userdata()['user_code'],
                        'certmnemonic' => $certmnemonic,
                        'certmnemonic_dharitree' => $certmnemonic_dharitree
                    );

                    $pc_audit_flag = $this->PropChainCommonModel->insertPropChainAuditData($insertAuditData);
                    if($pc_audit_flag['result'] == false)
                    {
                        return false;
                    }

                    $db_data = array(
                        'dist_code'   => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code'    => $circle_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no' => $lot_no,
                        'vill_townprt_code' => $vill_code,
                        'village_uuid' => $vill_uuid,
                        'patta_no' => $pattano,
                        'dag_no' => $dag_no,
                        'case_no' => $case_no,
                        'json_case_data' => $json_chain_data,
                        'sending_status' => 'N',
                        'case_passed_time' => date('Y-m-d H:i:s'),
                        'reference_no' => floor(microtime(true) * 1000),
                        'previous_hash' => $hash,
                        'is_digitally_signed' => $is_digitally_signed ,
                        'digitally_signed_date_time' => $digitally_signed_date_time ,
                        'created_at'  => date('Y-m-d H:i:s') ,
                        'modified_at' => date('Y-m-d H:i:s'),
                        'certmnemonic' => $certmnemonic,
                        'certmnemonic_dharitree' => $certmnemonic_dharitree
                    );
                    $insert = $this->db->insert('prop_chain_sent_data', $db_data);
                    return $insert;
                }
            } else {
                return false;
                log_message('error', "Invalid json passed. Null value present in parameters.Json data: $json_chain_data. case no: $case_no. Error Code: #CHAINSAVEERROR0001 -03");
            }
        }
    }

    public function getPropCaseData($case_no)
    {
       // $this->dbswitch();
        $case_data = $this->db->get_where('prop_chain_sent_data', array('case_no' => base64_decode(urldecode($case_no))))->row();

        return $case_data;
    }

    public function upd_chain_send_data($case_no, $reference_no, $case_data, $status)
    {
        //$this->dbswitch();
        if ($status == 'Y')
            $update_time = date('Y-m-d H:i:s');
        else
            $update_time = null;

        
        
        $db_data = array(
            'json_case_data' => $case_data,
            'sending_status' => $status,
            'prop_chain_update_time' => $update_time
        );

        if ($status == 'N')
        {
            $db_data['is_digitally_signed'] = 'Y';
            $db_data['digitally_signed_date_time'] =  date('Y-m-d H:i:s');
        }


        $this->db->where(array('case_no' => $case_no, 'reference_no' => $reference_no));
        $this->db->update('prop_chain_sent_data', $db_data);

        return $this->db->affected_rows();
    }

    public function checkOldUlpin($ulpin)
    {
       // $this->dbswitch();

        $this->db->select('old_ulpin',);
        // $get_old_ulpin = $this->db->get_where('chitha_basic', array('ulpin' => $ulpin))->row();
        $this->db->select(array('new_ulpin', 'old_ulpin', 'dag_no', 'patta_no', 'patta_type_code'));
        $get_old_ulpin = $this->db->get_where('ulpin_details', array('new_ulpin' => $ulpin))->row();
        // var_dump($get_old_ulpin);
        // die;
        if (isset($get_old_ulpin->old_ulpin) && $get_old_ulpin->old_ulpin != null) {
            // $this->db->select(array('ulpin', 'old_ulpin', 'dag_no', 'patta_no', 'patta_type_code'));
            // $this->db->order_by('dag_no', 'DESC');
            // $old_ulpin_details = $this->db->get_where('chitha_basic', array('old_ulpin' => $get_old_ulpin->old_ulpin))->row();
            // echo $this->db->last_query();
            return $get_old_ulpin;
        } else {
            return false;
        }
    }

    /*public function getAssetToCreatePc($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code, $limit, $start)
    {
        $this->dbswitch();

        // echo "SELECT patta_no, dag_no, patta_type_code, landclass_code, ulpin, old_ulpin FROM chitha_basic WHERE dist_code = $dist_code AND subdiv_code = $subdiv_code AND cir_code = $cir_code AND mouza_pargona_code = $mouza_code AND lot_no = $lot_no AND vill_townprt_code = $village_code AND (ulpin IS NULL OR ulpin='')";
        $result = $this->db->query("SELECT dag_no FROM chitha_basic WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_townprt_code = '$village_code' AND (ulpin IS NULL OR ulpin='')");
        $total_rows = $result->num_rows();

        $this->db->select('patta_no, dag_no, patta_type_code, land_class_code, ulpin, old_ulpin, dag_area_b, dag_area_k, dag_area_lc, dag_area_g, dag_revenue, dag_local_tax, patta_type_code, land_class_code');
        $this->db->from('chitha_basic');
        $this->db->where('dist_code', $dist_code);
        $this->db->where('subdiv_code', $subdiv_code);
        $this->db->where('cir_code', $cir_code);
        $this->db->where('mouza_pargona_code', $mouza_code);
        $this->db->where('lot_no', $lot_no);
        $this->db->where('vill_townprt_code', $village_code);
        $this->db->where('ulpin', NULL);
        $this->db->or_where('ulpin', '');
        $this->db->order_by('dag_no_int');
        $this->db->limit($limit, $start);
        $query = $this->db->get();

        $filtered_rows = $query->num_rows();

        return array(
            "total_rows" => $total_rows,
            "filtered_rows" => $filtered_rows,
            "data" => $query->result()
        );
    }*/
	
	 public function getAssetToCreatePc($dist_code, $subdiv_code, $cir_code, $mouza_code, $lot_no, $village_code, $limit, $start,$patta_type_code)
    {
        // $this->dbswitch();

        $result = $this->db->query("SELECT dag_no FROM chitha_basic WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code'
        AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_townprt_code = '$village_code' AND (ulpin IS NULL OR ulpin='') 
        AND patta_type_code='$patta_type_code'");
        $total_rows = $result->num_rows();

        $filtered_rows = 0;

        if (isset($_POST["search"]["value"]) && $_POST["search"]["value"]!=null) {
            $search = $_POST["search"]["value"];
            $query = $this->db->query("SELECT patta_no, dag_no, patta_type_code, land_class_code, ulpin, old_ulpin, dag_area_b, dag_area_k, dag_area_lc, dag_area_g, dag_revenue, dag_local_tax, patta_type_code, land_class_code FROM chitha_basic WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_townprt_code = '$village_code' AND patta_type_code='$patta_type_code' and dag_no LIKE '%$search%' AND (ulpin IS NULL OR ulpin = '')  ORDER BY dag_no_int LIMIT $limit OFFSET $start");

            $filtered_rows = $this->db->query("SELECT dag_no FROM chitha_basic WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_townprt_code = '$village_code' AND patta_type_code='$patta_type_code' AND dag_no LIKE '%$search%' AND (ulpin IS NULL OR ulpin = '')  ORDER BY dag_no_int")->num_rows();
        } else {
            $query = $this->db->query("SELECT patta_no, dag_no, patta_type_code, land_class_code, ulpin, old_ulpin, dag_area_b, dag_area_k, dag_area_lc, dag_area_g, dag_revenue, dag_local_tax, patta_type_code, land_class_code FROM chitha_basic WHERE dist_code = '$dist_code' AND subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' AND mouza_pargona_code = '$mouza_code' AND lot_no = '$lot_no' AND vill_townprt_code = '$village_code' AND patta_type_code='$patta_type_code' AND (ulpin IS NULL OR ulpin = '') ORDER BY dag_no_int LIMIT $limit OFFSET $start");

            $filtered_rows = $query->num_rows();
        }

        //log_message('error','getdagsquery:111'.json_encode($this->db->last_query()));

        return array(
            "total_rows" => $total_rows,
            "filtered_rows" => $filtered_rows,
            "data" => $query->result()
        );
    }

    /** @param object $data
     */
    public function getPropCreateBtnNew($data)
    {
        // $this->dbswitch();
        $getPattadars = $this->getPattadars($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $data->vill_townprt_code, $data->patta_no, $data->dag_no);

        log_message('error','PATTADARS09 : '.json_encode($getPattadars));

        $location_id = $data->dist_code . $data->subdiv_code . $data->cir_code . $data->mouza_pargona_code . $data->lot_no . $data->vill_townprt_code;

        $property_id = $this->blockchainutilityclass->generatePropertyId(LOC_TYPE_RURAL, $data->vill_townprt_code, $data->patta_no, $data->dag_no, $data->ulpin);

        $property_data = $this->blockchainutilityclass->getCreatePropArray($getPattadars, $location_id, $data->patta_no, $data->dag_no, $data->landclass_code, $data->patta_type_code, $data->bigha, $data->katha, $data->lessa, $data->ulpin, $data->old_ulpin, $data->revenue, $data->local_tax, $data->ganda);

        $propertysignature = "base64 encoded signature";
        $propertysignerkey = "base64 encoded public key";

        // create a button to push new property to property chain
        $prop_chain_button = $this->PropChainModel->createPropBtn($property_id, $property_data, $propertysignature, $propertysignerkey, $data->dag_no);

        return $prop_chain_button;
    }

    public function get_pending_ror_propchain_data()
    {
        // $this->dbswitch();

        $this->db->from('prop_chain_sent_data');
        $this->db->where('sending_status', 'N');
        $this->db->like('case_no', 'ROR:', 'after');
        $this->db->limit(MAX_CHAIN_CREATE);
        $this->db->order_by('case_passed_time', 'ASC');
        $query = $this->db->get();

        $ror_data = $query->result();

        return $ror_data;
    }

    public function get_pending_map_propchain_data()
    {
        $this->db->from('prop_chain_sent_data');
        $this->db->where('sending_status', 'N');
        $this->db->like('case_no', 'MAP:', 'after');
        $this->db->limit(MAX_CHAIN_UPDATE);
        $this->db->order_by('case_passed_time', 'ASC');
        $query = $this->db->get();

        $map_data = $query->result();

        return $map_data;
    }

    public function get_pending_update_propchain_chain()
    {
        // $this->dbswitch();

        $this->db->from('prop_chain_sent_data');
        $this->db->where('sending_status', 'N');
        $this->db->not_like('case_no', 'ROR:', 'after');
        $this->db->not_like('case_no', 'MAP:', 'after');
        $this->db->limit(MAX_CHAIN_UPDATE);
        $this->db->order_by('case_passed_time', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }


    public function getSentJson($key){
        $query = $this->db->query('select json_case_data from prop_chain_sent_data where case_no=?', array($key));
        return $query->row()->json_case_data;
    }

    public function getDigitalSignedTime($key){
        $query = $this->db->query('select digitally_signed_date_time from prop_chain_sent_data where case_no=?', array($key));
        return $query->row()->digitally_signed_date_time;
    }

    public function getPropChainSentDataDetails($key){
        $query = $this->db->query('select * from prop_chain_sent_data where case_no=?', array($key));
        return $query->row();
    }

    public function ror_bulk_push()
    {
        // $this->dbswitch();
        $this->load->model('propChain/PropChainCommonModel');

        $office_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $push_data = $this->get_pending_ror_propchain_data();

        $property_records = array();
        $bulk_transaction_data = array();

        // form an array of ror transactions
        foreach ($push_data as $chain_data) 
        {
            $decoded_data = json_decode($chain_data->json_case_data, true);
            $case_no =  $chain_data->case_no;
            $property_records[] = $decoded_data;

            $property_data = json_decode(base64_decode($decoded_data['propertydata']), true);

            $dist_code = substr($property_data['location'], 0, 2);
            $subdiv_code = substr($property_data['location'], 2, 2);
            $circle_code = substr($property_data['location'], 4, 2);
            $mouza_code = substr($property_data['location'], 6, 2);
            $lot_no = substr($property_data['location'], 8, 2);
            $vill_code = substr($property_data['location'], 10, 5);

            $transaction_param = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_pargona_code' => $mouza_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'dag' => $property_data['dagno'],
                'patta' => $property_data['pattano'],
                'land_class_code' => $property_data['landclass'],
                'patta_type_code' => $property_data['pattatype'],
                'property_id' => $decoded_data['propertyid'],
                'transaction_id' => '',
                'certmnemonic' => CERTMNEMONIC_ROR,
                'case_no' => $decoded_data['propertyid'],
                'user_code' => $user_code,
                'ulpin' => $property_data['ulpin']
            );

            // transactions data to be inserted in database
            $get_transaction_data = $this->PropChainModel->get_transaction_array((object)$transaction_param);
            $bulk_transaction_data[$case_no] = $get_transaction_data;
        }

        $temp_bulk_trans_data = $bulk_transaction_data;

        // send the bulk data to property chain
        $create_chain_trans = $this->blockchainutilityclass->propChainCreateApiBulk($property_records, $user_code, $office_code);

        if(!$create_chain_trans['result'])
        {
            echo $create_chain_trans['response'];
            exit;
        }

        $create_chain_trans = $create_chain_trans['response'];

        // echo "<pre>";
        // var_dump($create_chain_trans);
        log_message('error','ChainDataLogResponseROR-------'.json_encode($create_chain_trans));
        // die;

        if ($create_chain_trans->success === 0) 
        {
            foreach ($temp_bulk_trans_data as $key => $transaction_data) 
            {
                $transaction_id = $create_chain_trans->transaction_id;
                $transaction_data['transaction_id'] = $transaction_id;
                $temp_bulk_trans_data[$key] = $transaction_data;
                //**************************************************************************/
                //insertion in prop chain audit table for ror 
                $propSentData = $this->getPropChainSentDataDetails($key);
                $dist_code = $propSentData->dist_code;
                $subdiv_code = $propSentData->subdiv_code;
                $circle_code = $propSentData->cir_code;
                $mouza_code = $propSentData->mouza_pargona_code;
                $lot_no = $propSentData->lot_no;
                $vill_code = $propSentData->vill_townprt_code;
                $vill_uuid = $propSentData->village_uuid;
                $insertAuditData = array(
                    'dist_code'   => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code'    => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no'      => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'village_uuid' => $vill_uuid,
                    'patta_no'    => $propSentData->patta_no,
                    'dag_no'      => $propSentData->dag_no,
                    'transaction_id' => '',
                    'sent_data_json' => $propSentData->json_case_data,
                    'property_chain_status' => 'F',
                    'response_data_json' => json_encode($create_chain_trans) ,
                    'case_no'    => $key,
                    'is_digitally_signed' => 'Y',
                    "user_code" => $this->session->all_userdata()['user_code'],
                    'digitally_signed_date_time' => $propSentData->digitally_signed_date_time,
                    'created_at'  => date('Y-m-d H:i:s'),
                    'modified_at' => date('Y-m-d H:i:s'),
                    'certmnemonic' => CERTMNEMONIC_ROR
                );
                $this->PropChainCommonModel->insertPropChainAuditData($insertAuditData);            
                //**************************************************************************/
                // update sending_status flag to 'F' 
                $this->update_prop_chain_sent_data($key, 'F', json_encode($create_chain_trans));
                log_message('error', 'Msg: ' . $create_chain_trans->message . '. Error msg: ' . $create_chain_trans->error_msg . '. Property chain error-code: ' . $create_chain_trans->error_code . '. Error-code: RORBULKERROR0001');
            }
        } 
        elseif ($create_chain_trans->success === 1) 
        {
            foreach ($temp_bulk_trans_data as $key => $transaction_data) 
            {
                $transaction_id = $create_chain_trans->transaction_id;

                $transaction_data['transaction_id'] = $transaction_id;

                $temp_bulk_trans_data[$key] = $transaction_data;
                //**************************************************************************/
                //insertion in prop chain audit table for ror 
                $propSentData = $this->getPropChainSentDataDetails($key);
                $dist_code = $propSentData->dist_code;
                $subdiv_code = $propSentData->subdiv_code;
                $circle_code = $propSentData->cir_code;
                $mouza_code = $propSentData->mouza_pargona_code;
                $lot_no = $propSentData->lot_no;
                $vill_code = $propSentData->vill_townprt_code;
                $vill_uuid = $propSentData->village_uuid;
                $insertAuditData = array(
                    'dist_code'   => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code'    => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no'      => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'village_uuid' => $vill_uuid,
                    'patta_no'    => $propSentData->patta_no,
                    'dag_no'      => $propSentData->dag_no,
                    'transaction_id' => $transaction_id,
                    'sent_data_json' => $propSentData->json_case_data,
                    'property_chain_status' => 'Y',
                    'response_data_json' => json_encode($create_chain_trans) ,
                    'case_no'    => $key,
                    'is_digitally_signed' => 'Y',
                    "user_code" => $this->session->all_userdata()['user_code'],
                    'digitally_signed_date_time' => $propSentData->digitally_signed_date_time,
                    'created_at'  => date('Y-m-d H:i:s'),
                    'modified_at' => date('Y-m-d H:i:s'),
                    'certmnemonic' => CERTMNEMONIC_ROR
                );
                $this->PropChainCommonModel->insertPropChainAuditData($insertAuditData);            
                //**************************************************************************/
                //***************************************************************************/
                //inserting into prop chain ror success transaction 
                $insert_data_into_ror_success_table=[
                    "dist_code"=> $dist_code,
                    "subdiv_code"=> $subdiv_code,
                    "cir_code"=> $circle_code,
                    "mouza_pargona_code"=> $mouza_code,
                    "lot_no"=>  $lot_no,
                    "vill_townprt_code"=>  $vill_code,
                    "village_uuid "=> $vill_uuid,
                    "patta_no"=> $propSentData->patta_no,
                    "dag_no"=> $propSentData->dag_no,
                    "transaction_id"=> $transaction_id,
                    "sent_data_json "=> $propSentData->json_case_data,
                    "property_chain_status"=> 'Y',
                    "is_digitally_signed"=> 'Y',
                    "digitally_signed_date_time"=> $propSentData->digitally_signed_date_time,
                    "created_at"=> date('Y-m-d h:i:s'),
                    "modified_at "=> date('Y-m-d h:i:s'),
                    'certmnemonic' => CERTMNEMONIC_ROR
                ];
                $this->PropChainCommonModel->insertPropChainRorSuccessData($insert_data_into_ror_success_table);                
                //***************************************************************************/
                // update sending_status flag to 'Y' and prop_chain_update_time in prop_chain_sent_data 
                $this->update_prop_chain_sent_data($key, 'Y');
                echo "ROR updated successfully with transaction id: " . $transaction_id . "<br>";
            }
        } 
        elseif ($create_chain_trans->success === 2)
        {
            $valid_list = $create_chain_trans->valid_list;


            if(gettype($valid_list) == 'string'){
                $valid_list = json_decode($valid_list);
            }


            $invalid_list = $create_chain_trans->invalid_list;
            if (is_array($invalid_list)) 
            {
                foreach ($invalid_list as $invalid_item) 
                {
                    $key = CERTMNEMONIC_ROR . ':' . $invalid_item->propertyId;
                    //**************************************************************************/
                    //insertion in prop chain audit table for ror 
                    $propSentData = $this->getPropChainSentDataDetails($key);
                    $dist_code = $propSentData->dist_code;
                    $subdiv_code = $propSentData->subdiv_code;
                    $circle_code = $propSentData->cir_code;
                    $mouza_code = $propSentData->mouza_pargona_code;
                    $lot_no = $propSentData->lot_no;
                    $vill_code = $propSentData->vill_townprt_code;
                    $vill_uuid = $propSentData->village_uuid;
                    $sendingStatus = 'F';
                    if($invalid_item->errorCode == '02106')
                    {
                        $sendingStatus = 'Y';
                    }
                    $insertAuditData = array(
                        'dist_code'   => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code'    => $circle_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no'      => $lot_no,
                        'vill_townprt_code' => $vill_code,
                        'village_uuid' => $vill_uuid,
                        'patta_no'    => $propSentData->patta_no,
                        'dag_no'      => $propSentData->dag_no,
                        'transaction_id' => '',
                        'sent_data_json' => $propSentData->json_case_data,
                        'property_chain_status' => $sendingStatus,
                        'response_data_json' => json_encode($create_chain_trans) ,
                        'case_no'    => $key,
                        'is_digitally_signed' => 'Y',
                        "user_code" => $this->session->all_userdata()['user_code'],
                        'digitally_signed_date_time' => $propSentData->digitally_signed_date_time,
                        'created_at'  => date('Y-m-d H:i:s'),
                        'modified_at' => date('Y-m-d H:i:s'),
                        'certmnemonic' => CERTMNEMONIC_ROR
                    );
                    $this->PropChainCommonModel->insertPropChainAuditData($insertAuditData);            
                    //**************************************************************************/
                    // update sending_status flag to 'F'
                    $this->update_prop_chain_sent_data($key, $sendingStatus, json_encode($create_chain_trans));
                    
                    

                    // delete the invalid list item from transaction bulk data
                    unset($temp_bulk_trans_data[$key]);
                }
            }
            if(is_array($valid_list)) 
            {
                $transaction_id = $create_chain_trans->transaction_id;
                foreach ($valid_list as $valid_item) 
                {
                    $key = CERTMNEMONIC_ROR . ':' . $valid_item;
                    // insert transaction id in each transaction data
                    // $temp_bulk_trans_data[$key]['transaction_id'] = $transaction_id;
                    //**************************************************************************/
                    //insertion in prop chain audit table for ror 
                    $propSentData = $this->getPropChainSentDataDetails($key);
                    $dist_code = $propSentData->dist_code;
                    $subdiv_code = $propSentData->subdiv_code;
                    $circle_code = $propSentData->cir_code;
                    $mouza_code = $propSentData->mouza_pargona_code;
                    $lot_no = $propSentData->lot_no;
                    $vill_code = $propSentData->vill_townprt_code;
                    $vill_uuid = $propSentData->village_uuid;
                    $insertAuditData = array(
                        'dist_code'   => $dist_code,
                        'subdiv_code' => $subdiv_code,
                        'cir_code'    => $circle_code,
                        'mouza_pargona_code' => $mouza_code,
                        'lot_no'      => $lot_no,
                        'vill_townprt_code' => $vill_code,
                        'village_uuid' => $vill_uuid,
                        'patta_no'    => $propSentData->patta_no,
                        'dag_no'      => $propSentData->dag_no,
                        'transaction_id' => $transaction_id,
                        'sent_data_json' => $propSentData->json_case_data,
                        'property_chain_status' => 'Y',
                        'case_no'    => $key,
                        'is_digitally_signed' => 'Y',
                        "user_code" => $this->session->all_userdata()['user_code'],
                        'digitally_signed_date_time' => $propSentData->digitally_signed_date_time,
                        'created_at'  => date('Y-m-d H:i:s'),
                        'modified_at' => date('Y-m-d H:i:s'),
                        'certmnemonic' => CERTMNEMONIC_ROR
                    );
                    $this->PropChainCommonModel->insertPropChainAuditData($insertAuditData);            
                    //**************************************************************************/
                    //***************************************************************************/
                    //inserting into prop chain ror success transaction 
                    $insert_data_into_ror_success_table=[
                        "dist_code"=> $dist_code,
                        "subdiv_code"=> $subdiv_code,
                        "cir_code"=> $circle_code,
                        "mouza_pargona_code"=> $mouza_code,
                        "lot_no"=>  $lot_no,
                        "vill_townprt_code"=>  $vill_code,
                        "village_uuid "=> $vill_uuid,
                        "patta_no"=> $propSentData->patta_no,
                        "dag_no"=> $propSentData->dag_no,
                        "transaction_id"=> $transaction_id,
                        "sent_data_json "=> $propSentData->json_case_data,
                        "property_chain_status"=> 'Y',
                        "is_digitally_signed"=> 'Y',
                        "digitally_signed_date_time"=> $propSentData->digitally_signed_date_time,
                        "created_at"=> date('Y-m-d h:i:s'),
                        "modified_at "=> date('Y-m-d h:i:s'),
                        'certmnemonic' => CERTMNEMONIC_ROR
                    ];
                    $this->PropChainCommonModel->insertPropChainRorSuccessData($insert_data_into_ror_success_table);                
                    //***************************************************************************/
                    // update sending_status flag to 'Y' and prop_chain_update_time in prop_chain_sent_data                     
                    $this->update_prop_chain_sent_data($key, 'Y');
                    echo 'Msg: ' . $create_chain_trans->message . '. Error msg: ' . $create_chain_trans->error_msg . '. Property chain error-code: ' . $create_chain_trans->error_code . '<br>';
                }
            }

            echo 'Msg: ' . $create_chain_trans->message . '. Error msg: ' . $create_chain_trans->error_msg . '. Property chain error-code: ' . $create_chain_trans->error_code . '. Error-code: RORBULKERROR0002';

            log_message('error', 'Msg: ' . $create_chain_trans->message . '. Error msg: ' . $create_chain_trans->error_msg . '. Property chain error-code: ' . $create_chain_trans->error_code . '. Error-code: RORBULKERROR0002');
        }


        if (sizeof($temp_bulk_trans_data) > 0) {
            // if bulk data exists insert them in database in batch

            $total_insert_items = sizeof($temp_bulk_trans_data);
            $insert_transaction =  $this->chainTransactionInsertBulk($temp_bulk_trans_data);

            if ($total_insert_items > $insert_transaction) {
                echo "All transaction data not inserted in prop_chain_transaction. Rows supposed to insert: " . $total_insert_items . ", rows inserted: " . $insert_transaction . ". RORBULKERROR0003";
                log_message('error', "All transaction data not inserted in prop_chain_transaction. Rows supposed to insert: " . $total_insert_items . ", rows inserted: " . $insert_transaction . '. RORBULKERROR0003');
            } elseif ($total_insert_items == $insert_transaction) {
                echo "All rows inserted in prop_chain_transaction";
            }
        } else {
            echo "<br>No data to insert";
        }
        // die;
    }

    public function map_bulk_push()
    {
        // $this->dbswitch();

        $office_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $push_data = $this->get_pending_map_propchain_data();

        $update_records = array();
        $bulk_transaction_data = array();

        foreach ($push_data as $chain_data) 
        {
            $decoded_data = json_decode($chain_data->json_case_data, true);
            $case_no =  $chain_data->case_no;
            $update_records[$case_no] = $decoded_data;

            $property_data = $decoded_data['property_data'];

            $dist_code = substr($property_data['location'], 0, 2);
            $subdiv_code = substr($property_data['location'], 2, 2);
            $circle_code = substr($property_data['location'], 4, 2);
            $mouza_code = substr($property_data['location'], 6, 2);
            $lot_no = substr($property_data['location'], 8, 2);
            $vill_code = substr($property_data['location'], 10, 5);

            $transaction_param = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_pargona_code' => $mouza_code,
                'lot_no' => $lot_no,
                'vill_townprt_code' => $vill_code,
                'dag' => $property_data['dagno'],
                'patta' => $property_data['pattano'],
                'land_class_code' => $property_data['landclass'],
                'patta_type_code' => $property_data['pattatype'],
                'property_id' => $decoded_data['property_id'],
                'transaction_id' => '',
                'certmnemonic' => CERTMNEMONIC_MAP,
                'case_no' => $property_data['ulpin'],
                'user_code' => $user_code,
                'ulpin' => $property_data['ulpin']
            );

            // transactions data to be inserted in database
            $get_transaction_data = $this->PropChainModel->get_transaction_array((object)$transaction_param);

            $bulk_transaction_data[$case_no] = $get_transaction_data;
        }

        // !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! since there is no provision to send the update data in bulk, now we are sending each update data individually to property chain !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
        foreach ($update_records as $key => $record) 
        {
            // echo "<pre>";
            // var_dump($record);
            // die;
            $update_chain_trans = $this->blockchainutilityclass->propertyChainUpdateApi($record);

            log_message('error','ChainMapDataResponse---------------'.json_encode($update_chain_trans));

            if ($update_chain_trans->success == 1) 
            {
                $transaction_id = $update_chain_trans->transaction_id;
                $transaction_record = $bulk_transaction_data[$key];
                //**************************************************************************/
                //insertion in prop chain audit table for map
                $propSentData = $this->getPropChainSentDataDetails($key);
                $dist_code = $propSentData->dist_code;
                $subdiv_code = $propSentData->subdiv_code;
                $circle_code = $propSentData->cir_code;
                $mouza_code = $propSentData->mouza_pargona_code;
                $lot_no = $propSentData->lot_no;
                $vill_code = $propSentData->vill_townprt_code;
                $vill_uuid = $propSentData->village_uuid;
                $insertAuditData = array(
                    'dist_code'   => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code'    => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no'      => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'village_uuid' => $vill_uuid,
                    'patta_no'    => $propSentData->patta_no,
                    'dag_no'      => $propSentData->dag_no,
                    'transaction_id' => $transaction_id,
                    'sent_data_json' => $propSentData->json_case_data,
                    'property_chain_status' => 'Y',
                    'case_no'    => $key,
                    'is_digitally_signed' => 'Y',
                    "user_code" => $this->session->all_userdata()['user_code'],
                    'digitally_signed_date_time' => $propSentData->digitally_signed_date_time,
                    'created_at'  => date('Y-m-d H:i:s'),
                    'modified_at' => date('Y-m-d H:i:s'),
                    'certmnemonic' => CERTMNEMONIC_MAP
                );
                $this->PropChainCommonModel->insertPropChainAuditData($insertAuditData);            
                //**************************************************************************/
                //***************************************************************************/
                //inserting into prop chain other success transaction 
                $insert_data=[
                    "dist_code"=> $dist_code,
                    "subdiv_code"=> $subdiv_code,
                    "cir_code"=> $circle_code,
                    "mouza_pargona_code"=> $mouza_code,
                    "lot_no"=>  $lot_no,
                    "vill_townprt_code"=>  $vill_code,
                    "village_uuid "=> $vill_uuid,
                    "patta_no"=> $propSentData->patta_no,
                    "dag_no"=> $propSentData->dag_no,
                    "transaction_id"=> $transaction_id,
                    "sent_data_json "=> $propSentData->json_case_data,
                    "property_chain_status"=> 'Y',
                    "is_digitally_signed"=> 'Y',
                    "digitally_signed_date_time"=> $propSentData->digitally_signed_date_time,
                    "created_at"=> date('Y-m-d h:i:s'),
                    "modified_at "=> date('Y-m-d h:i:s'),
                    "user_code" => $this->session->all_userdata()['user_code'],
                    "case_no" => $propSentData->case_no,
                    'certmnemonic' => CERTMNEMONIC_MAP
                ];
                $this->PropChainCommonModel->insertPropChainTransactionSuccessData($insert_data);                
                //***************************************************************************/
                // insert transaction id
                $transaction_record['transaction_id'] = $transaction_id;
                $transaction_insert = $this->db->insert('prop_chain_transaction', $transaction_record);
                $update = $this->update_prop_chain_sent_data($key, 'Y');
                echo "Map updated in property chain with transaction id: " .  $update_chain_trans->transaction_id . "<br>";
                if (!$transaction_insert) {
                    echo 'Transaction not inserted in prop_chain_transaction for reference id(prop_chain_sent_data): ' . $key . '. Error-code: MAPBULKERROR0001';
                    log_message('error', 'Transaction not inserted in prop_chain_transaction for reference id(prop_chain_sent_data): ' . $key . '. Error-code: MAPBULKERROR0001');
                }

                if ($update <= 0) 
                {
                    echo 'Flag not update in prop_chain_sent_data for reference id: ' . $key . '. Error-code: MAPBULKERROR0002';
                    log_message('error', 'Flag not update in prop_chain_sent_data for reference id: ' . $key . '. Error-code: MAPBULKERROR0002');
                }
            } 
            elseif ($update_chain_trans->success == 0 || $update_chain_trans->success == 2) 
            {
                //**************************************************************************/
                //insertion in prop chain audit table for map
                $propSentData = $this->getPropChainSentDataDetails($key);
                $dist_code = $propSentData->dist_code;
                $subdiv_code = $propSentData->subdiv_code;
                $circle_code = $propSentData->cir_code;
                $mouza_code = $propSentData->mouza_pargona_code;
                $lot_no = $propSentData->lot_no;
                $vill_code = $propSentData->vill_townprt_code;
                $vill_uuid = $propSentData->village_uuid;
                $insertAuditData = array(
                    'dist_code'   => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code'    => $circle_code,
                    'mouza_pargona_code' => $mouza_code,
                    'lot_no'      => $lot_no,
                    'vill_townprt_code' => $vill_code,
                    'village_uuid' => $vill_uuid,
                    'patta_no'    => $propSentData->patta_no,
                    'dag_no'      => $propSentData->dag_no,
                    'transaction_id' => null,
                    'sent_data_json' => $propSentData->json_case_data,
                    'property_chain_status' => 'F',
                    'response_data_json' => json_encode($update_chain_trans->message) ,
                    'case_no'    => $key,
                    'is_digitally_signed' => 'Y',
                    "user_code" => $this->session->all_userdata()['user_code'],
                    'digitally_signed_date_time' => $propSentData->digitally_signed_date_time,
                    'created_at'  => date('Y-m-d H:i:s'),
                    'modified_at' => date('Y-m-d H:i:s'),
                    'certmnemonic' => CERTMNEMONIC_MAP
                );
                $this->PropChainCommonModel->insertPropChainAuditData($insertAuditData);            
                //**************************************************************************/
                echo 'Property chain not updated for reference id: ' . $key . '. Error-code: MAPBULKERROR0003. Msg: ' . $update_chain_trans->message . '. Error Msg: ' . $update_chain_trans->error_msg . '. Property chain error-code: ' . $update_chain_trans->error_code;

                log_message('error', 'Property chain not updated for reference id: ' . $key . '. Error-code: MAPBULKERROR0003. Msg: ' . $update_chain_trans->message . '. Error Msg: ' . $update_chain_trans->error_msg . '. Property chain error-code: ' . $update_chain_trans->error_code);

                $update = $this->update_prop_chain_sent_data($key, 'Y', json_encode($update_chain_trans));
                if ($update <= 0) {
                    echo 'Flag not update in prop_chain_sent_data for reference id: ' . $key . '. Error-code: MAPBULKERROR0002';
                    log_message('error', 'Flag not update in prop_chain_sent_data for reference id: ' . $key . '. Error-code: MAPBULKERROR0002');
                }
            } else {
                echo  'Unable to connect to property chain. Error-code: MAPBULKERROR0004';
                log_message('error', 'Unable to connect to property chain. Error-code: MAPBULKERROR0004');
            }
        }
    } 

    public function update_bulk_push()
    {
    }

    private function update_prop_chain_sent_data($case_no, $status, $failed_json_response = null)
    {
        // $this->dbswitch();

        if ($status == 'Y') {
            $db_data = array('sending_status' => 'Y', 'prop_chain_update_time' => date('Y-m-d H:i:s'));
        } elseif ($status == 'F') {
            $db_data = array('sending_status' => 'F', 'json_response' => $failed_json_response);
        }

        $this->db->where(array('case_no' => $case_no));
        $this->db->update('prop_chain_sent_data', $db_data);

        if ($this->db->affected_rows() < 1) {
            log_message('error', 'sending_status flag not update for case_no: ' . $case_no . '. flag value: ' . $status);
        }
        return $this->db->affected_rows();
    }

    public function getSignedAssets($status)
    {
        // $this->dbswitch();

        $this->db->from('prop_chain_sent_data');
        $this->db->select(array('case_no', 'sending_status', 'reference_no', 'case_passed_time', 'prop_chain_update_time'));
        if ($status == 'N' || $status == 'F' || $status == 'Y')
        {
            $this->db->where('sending_status', $status);
        }
        if($status == 'DSC')
        {
            //signature pending and order pass-============
            $this->db->where('sending_status', 'N');
            $this->db->where('is_digitally_signed', 'N');
            $this->db->where('digitally_signed_date_time', null);
        }
        $this->db->order_by('case_passed_time', 'ASC');
        $query = $this->db->get();

        return $query->result();
    }
	
	public function check_n_update_map_flag()
    {
        // $this->dbswitch();
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        // select the dags whose map_for_proprty is 'N'
        $this->db->select('dist_code,subdiv_code, cir_code, lot_no, mouza_pargona_code, vill_townprt_code, patta_no, dag_no, map_for_property, old_ulpin,ulpin');
        $checking_data = $this->db->get_where('chitha_basic', array('dist_code' => $dist_code, 'subdiv_code' => $subdiv_code, 'cir_code' => $cir_code, 'map_for_property' => 'N'))->result();

        foreach ($checking_data as $cd) {
            $lot_no = $cd->lot_no;
            $mouza_code = $cd->mouza_pargona_code;
            $vill_townprt_code = $cd->vill_townprt_code;
            $patta_no = $cd->patta_no;
            $dag_no = $cd->dag_no;
            $gis_code = $this->blockchainutilityclass->generateGisCode($dist_code, $subdiv_code, $cir_code, $lot_no, $mouza_code, $vill_townprt_code);

            $check_ulpin = $this->blockchainutilityclass->checkUlpin($gis_code, ASSAM_STATE_CODE, $dag_no);

            if ($check_ulpin['success'] === 1) {
                // if ulpin is found update the map_for_property to 'Y'
                // $this->db->set('map_for_property', 'Y');
                // $this->db->where('dist_code', $dist_code);
                // $this->db->where('subdiv_code', $subdiv_code);
                // $this->db->where('cir_code', $cir_code);
                // $this->db->where('lot_no', $lot_no);
                // $this->db->where('mouza_pargona_code', $mouza_code);
                // $this->db->where('vill_townprt_code', $vill_townprt_code);
                // $this->db->where('patta_no', $patta_no);
                // $this->db->where('dag_no', $dag_no);
                // $this->db->update('chitha_basic');
                $table = 'chitha_basic';
                $params = [
                    'map_for_property' => 'Y',
                ];
                $where = [
                    'dist_code'          => $dist_code,
                    'subdiv_code'        => $subdiv_code,
                    'cir_code'           => $cir_code,
                    'lot_no'             => $lot_no,
                    'mouza_pargona_code' => $mouza_code,
                    'vill_townprt_code'  => $vill_townprt_code,
                    'patta_no'           => $patta_no,
                    'dag_no'             => $dag_no,
                ];
                // Call model's reusable update method
                $this->Chitha_basic_model->update_table($table, $params, $where);

            }
        }
    }

    public function getCertmnemonicForProcess($certmnemonic)
    {
        if($certmnemonic == 'FPART' || $certmnemonic == 'OPART')
        {
            $certmnemonic = 'PRT';
        }elseif($certmnemonic == 'FMUT' || $certmnemonic == 'OMUT' || $certmnemonic == 'OMUTC')
        {
            $certmnemonic = 'MUT';
        }elseif($certmnemonic == 'RECLASS')
        {
            $certmnemonic = 'REC';
        }elseif($certmnemonic == 'CONV')
        {
            $certmnemonic = 'CONV';
        }elseif($certmnemonic == 'MiNC')
        {
            $certmnemonic = 'NCR';
        }elseif($certmnemonic == 'MiND')
        {
            $certmnemonic = 'NCL';
        }elseif($certmnemonic == 'LDU')
        {
            $certmnemonic = 'LEGACY';
        }

        return $certmnemonic;
    }

    public function getPropCaseDataformultiDags($case_no)
    {
        // $this->dbswitch();
        // $case_no = base64_decode(urldecode($case_no));
        $case_data = $this->db->get_where('prop_chain_sent_data', array('case_no' => $case_no))->result();

        foreach ($case_data as $key => $value) {

            $query = "update prop_chain_sent_data set case_no = ?,dhar_case_no= ?  where case_no = ? and dag_no = ? ";
            $updatedCase = $case_no.'-DAG-'.$value->dag_no;
            $this->db->query($query,array($updatedCase,$case_no,$case_no,$value->dag_no));
        }

        $prop_data = $this->db->get_where('prop_chain_sent_data', array('dhar_case_no' => $case_no,'order_pass'=>null))->result();

        return $prop_data;
    }

    public function getPropCaseDataformultiDagsDetails($case_no)
    {
        // $this->dbswitch();
        // $case_no = base64_decode(urldecode($case_no));
        $prop_data = $this->db->get_where('prop_chain_sent_data', array('dhar_case_no' => $case_no))->result();

        return $prop_data;
    }

    public function getPropCaseDataformultiDagsDetailsCheck($case_no)
    {
        
        $case_no = base64_decode(urldecode($case_no));
        // $prop_data = $this->db->get_where('prop_chain_sent_data', array('case_no' => $case_no))->result();

        $query = "select * from prop_chain_sent_data where case_no = ? or dhar_case_no = ?";
        $prop_num_rows=$this->db->query($query,array($case_no,$case_no))->num_rows();

        $array = array();
        $array['dagCount'] = $prop_num_rows;
        $array['multiDag'] = 'N';
        if($prop_num_rows > 1)
        {
            $array['multiDag'] = 'Y';
        }

        return $array;
    }

    public function getDscSignCertificate($dist_code)
    {
        $query = $this->db->query("select cert from dsc_registration_details where dist_code=? and status =? and subdiv_code ='00'", array($dist_code,'ACTIVE'));
        if($query->num_rows() == 0){
            return null;
        }else{
            return $query->row()->cert;
        }
    }

    public function upd_chain_send_data_multiple($case_no, $reference_no, $case_data, $status)
    {
        // $this->dbswitch();
        if ($status == 'Y')
            $update_time = date('Y-m-d H:i:s');
        else
            $update_time = null;

        
        
        $db_data = array(
            'json_case_data' => $case_data,
            'sending_status' => $status,
            'prop_chain_update_time' => $update_time
        );

        if ($status == 'N')
        {
            $db_data['is_digitally_signed'] = 'Y';
            $db_data['digitally_signed_date_time'] =  date('Y-m-d H:i:s');
        }
        $db_data['order_pass'] =  'Y';
        $this->db->where(array('case_no' => $case_no, 'reference_no' => $reference_no));
        $this->db->update('prop_chain_sent_data', $db_data);

        return $this->db->affected_rows();
    }

    public function getPropCaseDataCompleteStatus($case_no)
    {
        // $this->dbswitch();
        // $case_no = base64_decode(urldecode($case_no));
        $prop_data = $this->db->get_where('prop_chain_sent_data', array('dhar_case_no' => $case_no,'order_pass' => null))->result();

        return $prop_data;
    }

    public function getPropDharCaseNo($case_no)
    {
        // $this->dbswitch();
        // $case_no = base64_decode(urldecode($case_no));
        $prop_data = $this->db->get_where('prop_chain_sent_data', array('case_no' => $case_no))->row();

        return $prop_data;
    }

    public function getDagscount($case_no)
    {

        $query = $this->db->query("select count(dag_no) as c from petition_dag_details pd join petition_basic pb on pd.case_no = pb.case_no and pd.dist_code=pb.dist_code and pd.subdiv_code=pb.subdiv_code and pd.cir_code=pb.cir_code and pd.mouza_pargona_code=pb.mouza_pargona_code and pd.lot_no=pb.lot_no and pd.vill_townprt_code=pb.vill_townprt_code where pb.case_no = ? and pb.status not in ('F') group by pd.case_no having count(dag_no) >1", array($case_no));
        if($query->num_rows() == 0){
            return null;
        }else
        {
            return $query->row()->c;
        }
    }
}
