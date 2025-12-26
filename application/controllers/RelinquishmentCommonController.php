<?php
class RelinquishmentCommonController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('patta/pattamodel');
        $this->load->model('Relinquishment/RelinquishmentCommonModel');
        $this->load->model('basundhara/SettlementApiModel');
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper('file');
        $this->load->helper('download');
        $this->load->helper(array('form', 'url'));
        $this->load->model('UtilsModel');
        $this->dbswitch();


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
        } else if ($this->session->userdata('dist_code') == "39") {
            $this->db = $this->load->database('dha39', true);
        } else if ($this->session->userdata('dist_code') == "38") {
            $this->db = $this->load->database('dha25', true);
        }
    }


    //// ******************* 26-06-2024 / Masud Reza *************************


    public function checkAccessRelinquishment()
    {
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if(!in_array($userDegCode,RELINQUISHMENT_PROCESS_ACCESS))
        {
            $errors = '#MRLQM003: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }
    }

    public function checkAccessRelinquishmentRegister()
    {
        $userDegCode = trim($this->session->userdata('user_desig_code'));
        if(!in_array($userDegCode,RELINQUISHMENT_REGISTER_ACCESS))
        {
            $errors = '#MRLQM003: You are not Authorized for this process';
            $this->session->set_flashdata('error', $errors);
            redirect(base_url() .'index.php/Home/index');
        }
    }


    // first landing page for all
    public function firstLandingPageCommonRelinquishment()
    {
        $this->checkAccessRelinquishment();
        $dist_code   = trim($this->session->userdata('dist_code'));
        $subdiv_code = trim($this->session->userdata('subdiv_code'));
        $cir_code    = trim($this->session->userdata('cir_code'));
        $cir_code    = trim($this->session->userdata('cir_code'));
        $mou_code    = trim($this->session->userdata('mouza_pargona_code'));
        $lot_code    = trim($this->session->userdata('lot_no'));
        $serviceCode = RELINQUISHMENT_ID;
        $userDegCode = trim($this->session->userdata('user_desig_code'));

        $registerCases = 0;
        $pendingCases  = 0;
        $lmForwardToCo = 0;
        $chithaUpdate  = 0;
        if(in_array($userDegCode,RELINQUISHMENT_REGISTER_ACCESS))
        {
            $url = API_LINK_MB2."relinquishRecords/$dist_code/$subdiv_code/$cir_code/$mou_code/$lot_code" ;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
            $output = curl_exec($ch);
            curl_close($ch);
            $outputM = json_decode($output);

            foreach ($outputM as $outputS)
            {
                if($outputS->service_code == $serviceCode)
                {
                    $registerCases = $outputS->count;
                }
            }
        }

        if(in_array($userDegCode,RELINQUISHMENT_PROCESS_ACCESS))
        {
            if($userDegCode ==  MB_DEPUTY_COMM)
            {
                $pendingCases      = $this->RelinquishmentCommonModel->countPendingRelinquishmentCasesDc($dist_code,$serviceCode);
                $noticeCasesCount  = $this->RelinquishmentCommonModel->countNoticeServedRelinquishmentCasesDc($dist_code,$serviceCode);
                $finalCasesCount   = $this->RelinquishmentCommonModel->countFinalOrderRelinquishmentCasesDc($dist_code,$serviceCode);
            }
            if($userDegCode ==  MB_CIRCLE_OFFICER)
            {
                $pendingCases  = $this->RelinquishmentCommonModel->countPendingRelinquishmentCasesCo($dist_code,$subdiv_code,$cir_code,$serviceCode);
                $lmForwardToCo = $this->RelinquishmentCommonModel->countPendingCasesForwardedByLmToCo($dist_code,$subdiv_code,$cir_code,$serviceCode);
            }
            if($userDegCode ==  MB_LOT_MONDOL)
            {
                $mouza  = $this->session->userdata('mouza_pargona_code');
                $lot_no = $this->session->userdata('lot_no');
                $pendingCases = $this->RelinquishmentCommonModel->countPendingRelinquishmentCasesLm($dist_code,$subdiv_code,$cir_code,$mouza,$lot_no,$serviceCode);
            }
        }

        $data['dist_code']          = $dist_code;
        $data['registerCasesCount'] = $registerCases;
        $data['pendingCasesCount']  = $pendingCases;
        $data['noticeCasesCount']   = $noticeCasesCount;
        $data['finalCasesCount']    = $finalCasesCount;
        $data['lmForwardToCoCount'] = $lmForwardToCo;

        $data['_view'] = 'Relinquishment/Common/first_landing_page';
        $this->load->view('layouts/main', $data);

    }


    // get village list
    function villageListCommon()
    {
        $subdiv=$this->input->post('subdiv_code');
        $circle=$this->input->post('cir_code');
        $query = $this->db->query("SELECT B.subdiv_code,B.cir_code,B.mouza_pargona_code,B.lot_no,B.vill_townprt_code, B.loc_name FROM settlement_basic A 
          JOIN location B ON A.uuid=B.uuid
          WHERE B.subdiv_code=? and B.cir_code=? and B.vill_townprt_code!='00000'
          GROUP BY B.subdiv_code,B.cir_code,B.mouza_pargona_code,B.lot_no,
          B.vill_townprt_code, B.loc_name",
            array($subdiv, $circle))->result();
        echo json_encode(array(
            'responseType' => 1,
            'location'     => $query,
        ));
        return;
    }



    public function getAdditionalInputIfAny()
    {
        $reject_code = $this->input->post('reject_code');
        $dag_no_remark = $this->input->post('dag_no_remark');

        $sql = $this->db->query("SELECT chitha_flag, sub_input_type, sub_input_json FROM reject_master WHERE reject_code = ?", [$reject_code]);

        if ($sql->num_rows() <= 0)
        {
            echo json_encode([
                'responseType' => 0,
                'msg'          => '#ERR3434322: No data found! Contact admin...',

            ]);
        }

        $sub_input_type = $sql->row()->sub_input_type;
        $chitha_flag    = $sql->row()->chitha_flag;
        $inputCon       = '';

        if ($chitha_flag != 0)
        {

            //this is for dagwise appearance

            if ($sub_input_type == 1)
            {
                $inputCon = '<br>
                <span class="ml-5">
                    <textarea name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no_remark . ']" id="" class="p-1 form_control col-6 mb-2" placeholder="Enter remark..."></textarea>
                <span>';
            }

            if ($sub_input_type == 2)
            {
                $inputCon = '<br>
                <span class="ml-5">
                    <input type="radio" name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no_remark . ']" value="YES" checked />
                    <label>Yes</label>
                    <input type="radio" name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no_remark . ']" value="NO" />
                    <label>No</label>
                </span>';
            }

            if ($sub_input_type == 3) {

                $sub_input_option = $sql->row()->sub_input_json;

                if (isset($sub_input_option)) {
                    if ($sub_input_option) {
                        $sub_input_option_decoded = json_decode($sub_input_option);
                    } else {
                        $sub_input_option_decoded = [];
                    }
                } else {
                    $sub_input_option_decoded = [];
                }

                $options = '';
                foreach ($sub_input_option_decoded as $option) {
                    $options .= '<option value="' . $option->NAME . '">' . $option->NAME . '</option>';
                }

                $inputCon = '<br><span class="ml-5">
                    <select name="sub_rejected_reasons[' . $reject_code . '_' . $dag_no_remark . ']" class="col-6 p-1">
                        <option value="">Select...</option>
                        ' . $options . '
                    </select>
                </span>';
            }
        }
        else
        {
            //this is for non dagwise appearance
            if ($sub_input_type == 1)
            {
                $inputCon = '<br>
                <span class="ml-5">
                    <textarea name="sub_rejected_reasons[' . $reject_code . ']" id="" class="p-1 form_control col-6 mb-2" placeholder="Enter remark..."></textarea>
                <span>';
            }

            if ($sub_input_type == 2)
            {
                $inputCon = '<br>
                <span class="ml-5">
                    <input type="radio" name="sub_rejected_reasons[' . $reject_code . ']" value="YES" checked />
                    <label>Yes</label>
                    <input type="radio" name="sub_rejected_reasons[' . $reject_code . ']" value="NO" />
                    <label>No</label>
                </span>';
            }

            if ($sub_input_type == 3)
            {
                $sub_input_option = $sql->row()->sub_input_json;

                if (isset($sub_input_option))
                {
                    if ($sub_input_option)
                    {
                        $sub_input_option_decoded = json_decode($sub_input_option);
                    }
                    else
                    {
                        $sub_input_option_decoded = [];
                    }
                }
                else
                {
                    $sub_input_option_decoded = [];
                }

                $options = '';
                foreach ($sub_input_option_decoded as $option) {
                    $options .= '<option value="' . $option->NAME . '">' . $option->NAME . '</option>';
                }

                $inputCon = '<br><span class="ml-5">
                    <select name="sub_rejected_reasons[' . $reject_code . ']" class="col-6 p-1">
                        <option value="">Select...</option>
                        ' . $options . '
                    </select>
                </span>';
            }
        }

        echo json_encode([
            'responseType' => 2,
            'inputContent' => $inputCon,
            'chithaFlag'   => $chitha_flag,
        ]);
    }




}