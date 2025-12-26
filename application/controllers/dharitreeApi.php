<?php
ini_set('memory_limit', '-1');
class DharitreeApi extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('jamabandi/JamabandiModel');
        $this->load->model('misreport/MisModel');
        $this->load->helper('url');
    }
    public function dbswitch($dist_code)
    {
        if($dist_code == "02"){
            $this->db=$this->load->database('dha3', TRUE);
        } else if($dist_code == "05"){
            $this->db=$this->load->database('dha1', TRUE);
        } else if($dist_code == "10"){
            $this->db=$this->load->database('dha24', TRUE);
        } else if($dist_code == "13"){
            $this->db=$this->load->database('dha2', TRUE);
        }  else if($dist_code == "17"){
            $this->db=$this->load->database('dha4', TRUE);
        }  else if($dist_code == "15"){
            $this->db=$this->load->database('dha5', TRUE);
        }  else if($dist_code == "14"){
            $this->db=$this->load->database('dha6', TRUE);
        }  else if($dist_code == "07"){
            $this->db=$this->load->database('dha7', TRUE);
        }  else if($dist_code == "03"){
            $this->db=$this->load->database('dha8', TRUE);
        }  else if($dist_code == "18"){
            $this->db=$this->load->database('dha9', TRUE);
        }  else if($dist_code == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($dist_code == "24"){
            $this->db=$this->load->database('dha10', TRUE);
        }  else if($dist_code == "06"){
            $this->db=$this->load->database('dha11', TRUE);
        }  else if($dist_code == "11"){
            $this->db=$this->load->database('dha12', TRUE);
        }  else if($dist_code == "12"){
            $this->db=$this->load->database('dha13', TRUE);
        }  else if($dist_code == "16"){
            $this->db=$this->load->database('dha14', TRUE);
        }  else if($dist_code == "32"){
            $this->db=$this->load->database('dha15', TRUE);
        }  else if($dist_code == "33"){
            $this->db=$this->load->database('dha16', TRUE);
        }  else if($dist_code == "34"){
            $this->db=$this->load->database('dha17', TRUE);
        }  else if($dist_code == "21"){
            $this->db=$this->load->database('dha18', TRUE);
        }  else if($dist_code == "08"){
            $this->db=$this->load->database('dha19', TRUE);
        }  else if($dist_code == "35"){
            $this->db=$this->load->database('dha20', TRUE);
        }  else if($dist_code == "36"){
            $this->db=$this->load->database('dha21', TRUE);
        }  else if($dist_code == "37"){
            $this->db=$this->load->database('dha22', TRUE);
        }  else if($dist_code == "25"){
            $this->db=$this->load->database('dha23', TRUE);
        }  else if($dist_code == "39"){
            $this->db=$this->load->database('dha39', TRUE);
        }else if($dist_code == "38"){
            $this->db=$this->load->database('dha25', TRUE);
        }else if($dist_code == "22"){
            $this->db=$this->load->database('dha41', TRUE);
        }else if($dist_code == "23"){
            $this->db=$this->load->database('dha40', TRUE);
        }
        return $this->db;
    }
    function apiforJamabandi()
    {
        $location=$_POST['location'];
        $pattatypeCode=$_POST['patta_type'];
        $patta_no=$_POST['patta_no'];
        $all_location=explode("_",$location);
        $application_no=$_POST['application_no'];
        $link=$_POST['link'];
        //display jama by entering pattano new beigns here
        $main = array();
        $jamainfo = array();
        $dist_code = $all_location[0];
        $subdiv_code = $all_location[1];
        $circle_code = $all_location[2];
        $mouza_code = $all_location[3];
        $lot_no = $all_location[4];
        $vill_code = $all_location[5];
        $this->db=$this->dbswitch($dist_code);
        $pattatype = array(
            'patta_type' => $pattatypeCode,
            'patta_no' => $patta_no
        );
        $this->session->set_userdata($pattatype);
        $this->load->model('misreport/MisModel');
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);
        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        $pattatypename = $this->MisModel->getpattatypeNameforJamabandi($pattatypeCode);
        $maindata['namedata'] = array_merge($districtdata, $subdivdata, $circledata, $mouzadata, $lotdata, $villagedata, $pattatypename);
        $maindata['pattainfo'] = $pattatype;
        $pno = trim($patta_no);
        $main['daginfo'] = array();
        $this->load->helper('qrcode');
        $base_64 = printQR($link);
        //$data['qrcode'] = $base_64;
        $html = '
        <div class="container">
        <div class="border" id="exportthis">
        <center>
                <div style="font-size: 20px; padding: 5px 0px 0px 5px;">জৰীপ হোৱা গাঁওৰ জমাবন্দী <br> (Jamabandi for Surveyed Village)<br></div>
        </center>
        ';
        $html.='<center><p style="fonts: Sans-serif; font-weight: bold"> Application No. '.$application_no.' Dated: '.date('d/m/Y').'</p></center>';
        $html .='
        <table class="table table_black"  align="center" width="100%;" border=1 style="border-collapse: collapse;border-bottom:none" >
                <tr>
                    <td align="center">District:'.$maindata['namedata'][0]->district.' </td> 
                    <td align="center">Subdivision:'.$maindata['namedata'][1]->subdiv.' </td> 
                    <td align="center">Circle:'.$maindata['namedata'][2]->circle.' </td> 
                    <td align="center">Mouza: '.$maindata['namedata'][3]->mouza.'</td> 
                </tr>
                <tr>
                    <td align="center">Lot Number:'.$maindata['namedata'][4]->lot_no.'</td> 
                    <td align="center">Village/Town :'.$maindata['namedata'][5]->village.'</td> 
                    <td align="center">Pattatype: '.$maindata['namedata'][6]->patta_type.'</td> 
                </tr>
            </table> ';
        $html .= '
        <table border=1 style="border-collapse: collapse;border-bottom:none;font-size:12px !important" width="100%;" class="report table_black">
        <thead>
        ';
        $html .=     '<tr class="sub-heading show-on-print" style="border-bottom:1px solid #E8E8E8; text-align:center; font-weight: bold;">
                        <td align="center" colspan="2" height="24">  পট্টা নং  </td>
                        <td align="center" rowspan="3" height="78" width="200">   পট্টাদাৰৰ নাম,পিতাৰ নাম/স্ৱামীৰ নাম আৰু ঠিকনা  </td>
                        <td align="center" colspan="5" height="34">  &nbsp;&nbsp;    প্ৰত্যেক দাগৰ মাটিৰ     &nbsp;  </td>
                        <td align="center" rowspan="3" height="73">  ৰাজহ<br> </td>
                        <td align="center" rowspan="3" height="73">  স্হানীয় কৰ<br>  </td>
                        <td align="center" rowspan="3" height="100" width="300">  মন্তব্য  </td>
                    </tr>
                    <tr class="sub-heading show-on-print" style="border-bottom:1px solid #E8E8E8; text-align:center; font-weight: bold;">
                        <td align="center" rowspan="2" height="48"> পুৰণি </td>
                        <td align="center" rowspan="2" height="48"> নতুন </td>
                        <td align="center" rowspan="2" height="48"> নং</td>
                        <td align="center" rowspan="2" height="48"> কালি<br>(বি-ক-লে) </td>
                        <td align="center" height="48" colspan="2">  শ্রেণী  </td>
                        <td align="center" rowspan="2" height="48">  কালি <br>(হে-আৰ-ছে)  </td>
                    </tr>
                    <tr class="sub-heading show-on-print" style="border-bottom:1px solid #E8E8E8; text-align:center; font-weight: bold;">
                        <td align="center">
                            কৃষি
                        </td>
                        <td align="center">
                            অকৃষি
                        </td>
                    </tr>
                    <tr class="sub-heading show-on-print" style="border-bottom:1px solid #E8E8E8; text-align:center; font-weight: bold;">
                        <td align="middle" height="24"> ১ </td>
                        <td align="center" height="24"> ২ </td>
                        <td align="center" height="24"> ৩ </td>
                        <td align="center" height="24"> ৪ </td>
                        <td align="center" height="24"> ৫ </td>
                        <td align="center" height="24" colspan="2"> ৬ </td>
                        <td align="center" height="24"> ৭ </td>
                        <td align="center" height="24"> ৮ </td>
                        <td align="center" height="24"> ৯ </td>
                        <td width="20" align="center" height="24"> ১০ </td>
                    </tr>
                    </thead>
                ';
        $GrandlocaltaxTotal = '';
        $GrandrevenueTotal = '';
        $Grandbigha_total = '';
        $Grandkatha_total = '';
        $Grandlesa_total = '';
        //  $details="";
        $GrandtotalHAC1 = "";
        $localtaxTotal = '';
        $revenueTotal = '';
        $bigha_total = '';
        $katha_total = '';
        $lesa_total = '';
        $bigha_totall = '';
        $katha_totall = '';
        $lesa_totall = '';
        $html .= '<tbody>';
        ///////////////////////////////////////////
        $sql11="select jd.dag_no,jd.dag_revenue,jd.dag_localtax,jd.dag_area_b,jd.dag_area_k,jd.dag_area_lc,jd.dag_area_g,lcd.land_type,lcd.class_code_cat from    "
            . "jama_dag as jd  JOIN   landclass_code as lcd ON jd.dag_class_code=lcd.class_code WHERE jd.dist_code='$dist_code' and jd.subdiv_code = '$subdiv_code' and jd.cir_code='$circle_code' and "
            . "jd.mouza_pargona_code = '$mouza_code' and jd.lot_no = '$lot_no' and jd.vill_townprt_code='$vill_code' and "
            . "jd.patta_type_code='$pattatypeCode' and TRIM(jd.patta_no)='$pno' order by length(dag_no)";
        $totalDag=$this->db->query($sql11);
        $sql13="
            select t.*
            from
            (
            (Select * from jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  and  TRIM(patta_no)=trim('$pno') and patta_type_code='$pattatypeCode' and pdar_sl_no > 0 order by pdar_sl_no::int asc)
            union
            (
            Select * from jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code'  and  TRIM(patta_no)=trim('$pno') and patta_type_code='$pattatypeCode' 
             and (pdar_sl_no = 0 or pdar_sl_no is null) order by cast(pdar_id as integer) asc
            )
            ) t order by t.pdar_sl_no::int asc,t.pdar_id::int asc";
        $totalPattadar=$this->db->query($sql13);
        $sql12="select * from jama_remark WHERE dist_code='$dist_code' and subdiv_code = '$subdiv_code' and cir_code='$circle_code' and "
            . "mouza_pargona_code = '$mouza_code' and lot_no = '$lot_no' and vill_townprt_code='$vill_code' and "
            . "patta_type_code='$pattatypeCode' and TRIM(patta_no)=trim('$pno') ";
        $totalRemark=$this->db->query($sql12);
        if($totalPattadar->num_rows()<$totalRemark->num_rows()){
            $count=$totalRemark->num_rows();
        }else{
            $count=$totalPattadar->num_rows();
        }
        if($totalDag->num_rows()==0){
            $response=array(
                'responseType'=>3,
                'message'=>"No dag assigned to the applied patta"
            );
            echo json_encode($response);
            return;
        }
        if($totalPattadar->num_rows()==0){
            $response=array(
                'responseType'=>3,
                'message'=>"No Pattadar available to the applied patta"
            );
            echo json_encode($response);
            return;
        }
        //////No. of records in one loop////////
        $pattadar=$totalPattadar->result_array();
        $dags=$totalDag->result_array();
        $remark=$totalRemark->result_array();
        $pattaNoAss=$this->utilityclass->cassnum($pno);
        $genpattaNo=empty($pattaNoAss)?$pno:$pattaNoAss;
        $html.="<tr style=\"border-collapse:collapse;text-allign:center\">";
        $pat_name_td='<td valign="top">';
        //$html.="<td>".$loopmoving."</td>";
        $html.="<td  valign='top'>".$this->utilityclass->cassnum($pattaTabledata['old_patta_no'])."</td>";
        $html.="<td valign='top'>".$genpattaNo."</td>";
        // $html.="<td align='center' valign='top'>".$this->utilityclass->cassnum($pno)==null?$pno:$this->utilityclass->cassnum($pno)."</td>";
        for($i=0;$i<$totalPattadar->num_rows();$i++){
            //var_dump($pattadar[$i]['p_flag']);
            $pdarflag = $pattadar[$i]['p_flag'];
            $newpdar_name = $pattadar[$i]['new_pdar_name'];
            if ($pdarflag == '1') {
                $pattadarName = '<span style="Color:#ff0000;text-decoration: line-through;">' . $pattadar[$i]['pdar_name'] ;
            } elseif (($pdarflag == '1') and ( $newpdar_name == "N")) {
                $pattadarName = '<span style="Color:#ff0000;">' . $pattadar[$i]['pdar_name'] ;
            } elseif (($pdarflag == null) and ( $newpdar_name == "N")) {
                $pattadarName = '<span style="Color:#ff0000;">' . $pattadar[$i]['pdar_name'] ;
            } elseif ($newpdar_name == "N") {
                $pattadarName = '<span style="Color:#ff0000;">' . $pattadar[$i]['pdar_name'] ;
            } elseif ($newpdar_name != "N") {
                $pattadarName = '<span style="Color:black;">' . $pattadar[$i]['pdar_name'] ;
            }
            $pat_name_td.= $i+1 .")".$pattadarName . "(" . $pattadar[$i]['pdar_father'] . ") </span>" . '<br>' . $pattadar[$i]['pdar_add1'] . "," . $pattadar[$i]['pdar_add2'] ."<br><br>";
        }
        $html.=$pat_name_td."</td>";
        //echo $var."---".$totalDag->num_rows();
        $htmldag=$htmlarea=$htmlrmk=$dagRev=$dagLocal=$krishi=$akrishi=$hecarccent=null;
        for($k=0;($k<$totalDag->num_rows());$k++){
            $htmldag.=$this->utilityclass->cassnum($dags[$k]['dag_no'])."<br>";
            $dagRev.=$this->utilityclass->cassnum(number_format($dags[$k]['dag_revenue'],2))."<br>";
            $dagLocal.=$this->utilityclass->cassnum(number_format($dags[$k]['dag_localtax'],2))."<br>";
            $htmlarea.=$this->utilityclass->cassnum($dags[$k]['dag_area_b']."-".$dags[$k]['dag_area_k']."-".$dags[$k]['dag_area_lc'])."<br>";
            if ($dags[$k]['class_code_cat'] == '01'){
                $krishi.=$dags[$k]['land_type']."<br>";
                $akrishi.="------"."<br>";
            }
            if ($dags[$k]['class_code_cat'] == '02'){
                $krishi.="------"."<br>";
                $akrishi.=$dags[$k]['land_type']."<br>";
            }
            $H_A_C= $this->utilityclass->get_Hec_Are_CAre($dags[$k]['dag_area_b'], $dags[$k]['dag_area_k'], $dags[$k]['dag_area_lc']);
            $hecarccent.=$this->utilityclass->cassnum($H_A_C) . '<br>';
        }
        $html.="<td align='center' valign='top'>".$htmldag ."</td>";
        $html.="<td align='center' valign='top'>".$htmlarea."</td>";
        $html.="<td align='center' valign='top'>".$krishi."</td>";
        $html.="<td align='center' valign='top'>".$akrishi."</td>";
        $html.="<td align='center' valign='top'>".$hecarccent."</td>";
        $html.="<td align='center' valign='top'>".$dagRev."</td>";
        $html.="<td align='center' valign='top'>".$dagLocal."</td>";

        for($j=0;($j<$totalRemark->num_rows());$j++){
            $htmlrmk.=strip_tags($remark[$j]['remark'],'<p><br><s>')."<br>";
            if($remark[$j]['entry_mode']=='O'){
                $htmlrmk.="<span style='color:red'>Order(s) Manually Entered By CO:";
                $name=$this->utilityclass->getSelectedCOName($remark[$j]['dist_code'],$remark[$j]['subdiv_code'],$remark[$j]['cir_code'],$remark[$j]['user_code']);
                $htmlrmk.=$name->username." on dated ".$remark[$j]['entry_date'] ."</span><br>";
            }
            if($remark[$j]['entry_mode']=='K'){
                $htmlrmk.="<span style='color:red'> Above Remark(s) Edited By CO:".
                    $name=$this->utilityclass->getSelectedCOName($remark[$j]['dist_code'],$remark[$j]['subdiv_code'],$remark[$j]['cir_code'],$remark[$j]['user_code']);
                $htmlrmk.= $name->username." on dated ".$remark[$j]['entry_date']."</span><br>";
            }
        }
        $html.="<td valign='top'>".$htmlrmk."</td>";
        $html.="</tr>";
        $html .= '</tbody></table>
        <center><p style="color:red">** Please note this is a system generated certificate and does not need any signature **</p></center>';
        $html.='<div class="col-lg-2">
        <img src="' . $base_64 . '" /></div>';
        $html .= '</div></div>';
        $new_case_no=str_replace("/","-",$application_no);
        $base_64_file_path = JB_BASE64_POST_FILE.$new_case_no.".json";
        $file_to_write_base64 = fopen($base_64_file_path, "w") or die("Unable to open file!");
        $htmlstring_text = json_encode(base64_encode($html));
        fwrite($file_to_write_base64, $htmlstring_text);
        fclose($file_to_write_base64);
        $response=array(
            'responseType'=>2,
            'data'=>base64_encode($html),
        );
        echo  json_encode($response);
        return;
    }
    function getJamaWasil()
    {
        // $location=$_POST['location'];
        // $pattatypeCode=$_POST['patta_type'];
        // $patta_no=$_POST['patta_no'];
        // $no_of_page=$_POST['no_of_page'];
        //echo '<div>Under Process</div>';


        $pdarARR=array();
        $dagARR=array();
        $ltARR=array();
        $areaARR=array();
        $combineARR=array();
        $cntPdar=0;
        $cntDag=0;
        $myCNT=0;
        $total_B=0;
        $total_K=0;
        $total_L=0;
        $g_areaB=0;
        $g_areaK=0;
        $totalLC=0;
        $d_rev=0;
        $d_ltax=0;
        $myCnt;
        $cnt=0;
        $tLine=0;

        $pno=$_POST['patta_no'];
        $patta_type = $_POST['patta_type'];
        $location = $_POST['location'];
        $all_location=explode("_",$location);
        //var_dump($_POST);
        $dist_code = $all_location[0];
        $subdiv_code = $all_location[1];
        $circle_code = $all_location[2];
        $mouza_code = $all_location[3];
        $lot_no = $all_location[4];
        $vill_code = $all_location[5];
        $tLine=$this->input->post('per_page');
        $_SESSION["patta_no"] = $pno;
        $this->db=$this->dbswitch($dist_code);
        //$this->session->set_userdata('dist_code', $dist_code);
        $districtdata = $this->MisModel->getDistrictName($dist_code);
        $subdivdata = $this->MisModel->getSubDivName($dist_code, $subdiv_code);
        $circledata = $this->MisModel->getCircleName($dist_code, $subdiv_code, $circle_code);

        $mouzadata = $this->MisModel->getMouzaName($dist_code, $subdiv_code, $circle_code, $mouza_code);
        $lotdata = $this->MisModel->getLotName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no);
        $villagedata = $this->MisModel->getVillageName($dist_code, $subdiv_code, $circle_code, $mouza_code, $lot_no, $vill_code);
        //var_dump($villagedata );
        $pattaNameSql="Select patta_type from   patta_code where Type_code=?";
        $pattatypename = $this->db->query($pattaNameSql,$patta_type)->row()->patta_type;
        //echo $circledata[0]->circle.$villagedata[0]->village;
        $_SESSION["myCircle"]=$circledata[0]->circle;
        $_SESSION["myVillage"]= $villagedata[0]->village;
        $_SESSION["myPattaType"]=$pattatypename ;
        if ($tLine<2)
        {
            $tLine=2;
        }

        // $pno=$this->input->post('patta_no');
        // $dist_code = $this->input->post('dist_code');
        // $subdiv_code = $this->input->post('subdiv_code');
        // $circle_code = $this->input->post('circle_code');
        // $mouza_code = $this->input->post('mouza_code');
        // $lot_no = $this->input->post('lot_no');
        // $vill_code = $this->input->post('vill_code');
        // $_SESSION["patta_no"] = $this->input->post('patta_no');
        // $patta_type = $this->input->post('patta_type');
        $sqlJP= $this->db->query("SELECT * FROM jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_no='$pno' and patta_type_code='$patta_type'");
        //log_message('error',"EKHAJANA:".$this->db->last_query());
        if($sqlJP->num_rows()==0){
            $response=array(
                'responseType'=>3,
                'message'=>"No Pattadar Found",
            );
            echo  json_encode($response);
            log_message('error',"EKHAJANA####".json_encode($_POST)."#########query:".$this->db->last_query());
            return;
        }
        $sqlDAG= $this->db->query("SELECT * FROM jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_no='$pno' and patta_type_code='$patta_type'");
        if($sqlDAG->num_rows()==0){
            $response=array(
                'responseType'=>3,
                'message'=>"No Dag Found",
            );
            echo  json_encode($response);
            log_message('error',"EKHAJANA####".json_encode($_POST)."#########query:".$this->db->last_query());
            return;
        }
        $q= $this->db->query("SELECT count(*) as c1 FROM jama_pattadar where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_no='$pno' and patta_type_code='$patta_type'");
        //log_message('error',"JB".$this->db->last_query());
        $r= $this->db->query("SELECT count(*) as c2 FROM jama_dag where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and mouza_pargona_code='$mouza_code' and lot_no='$lot_no' and vill_townprt_code='$vill_code' and patta_no='$pno' and patta_type_code='$patta_type'");
        foreach ($q->result() as $row)
        {
            $cntPdar=$row->c1;
        }
        foreach ($r->result() as $row)
        {
            $cntDag=$row->c2;
        }
        if ($cntPdar < $cntDag)
        {
            $myCnt=$cntPdar;
        }
        else
        {
            $myCnt=$cntDag;
        }
        //--------------------
        $header=$this->TableHeader($_SESSION["myCircle"],$_SESSION["myVillage"],$_SESSION["myPattaType"],$_SESSION["patta_no"]);
        $content=$this->CreateArrayforPDarDag($dist_code,$subdiv_code,$circle_code,$mouza_code,$lot_no,$vill_code,$pno,$patta_type,$sqlJP,$sqlDAG,$cntPdar,$cntDag,$myCnt,$ltARR,$areaARR,$tLine);
        $final=$header.$content;
        $response=array(
            'responseType'=>2,
            'data'=>base64_encode($final),
        );
        echo  json_encode($response);
        return;
    }

    function TableHeader($Circle, $Village, $PType, $pno)
    {
        $html= "<body>";
        $html.= "<p align=left><font size=4>Assam Schedule XXIV (Part-I) Form No.6</font></p>";
        $html.= "<table  width=100%>";
        $html.= "<tr><td align=center colspan=2><font size=5>" . "জমা ওৱাছিল" . "</font></td></tr>";
        $html.= "<tr><td align=center><font size=4>" . "চক্ৰ :" . $Circle . ";" . "গাওঁৰ নাম :" . $Village . "(" . $PType . ")" . "</font></td><td></td></tr></table>";
        $html.= "</body>";
        $html.= "<div class=container-fluid form-top>";
        $html.= "<div class=row><div class=col-lg-12>";
        $html.= " <table style='border:1px solid black;' width='100%' >";
        $html.= "<tr>";
        $html.= "<td style='border:1px solid black;' rowspan='2' align='center' width=5%\>পাট্টা-নং</td>";
        $html.= "<td style='border:1px solid black;' rowspan='2' align='center' width=25%\>ৰায়তৰ নিজ নাম আৰু পিতাৰ নাম</td>";
        $html.= "<td style='border:1px solid black;' colspan='2' align='center' width=20%>পাব লগা ধন</td>";
        $html.= "<td style='border:1px solid black;' colspan='4' align='center' width=40%\>আদায়</td>";
        $html.= "<td style='border:1px solid black;' rowspan='2' align='center' width=20%\>মন্তব্য</td>";
        $html.= "</tr><tr>";
        $html.= "<td style='border:1px solid black;' align='center' width=13%\>ৰাজহ</td>";
        $html.= "<td style='border:1px solid black;' align='center' width=80>স্হানীয় কৰ</td>";
        $html.= "<td style='border:1px solid black;' align='center' width=7%\>তাৰিখ</td>";
        $html.= "<td style='border:1px solid black;' align='center' width=8%\>ৰাজহ</td>";
        $html.= "<td style='border:1px solid black;' align='center' width=8%\>স্হানীয় কৰ</td>";
        $html.= "<td style='border:1px solid black;' align='center' width=12%\>ক্ৰমিক নম্বৰ দৈনিক আমদানিৰ </td>";
        $html.= "</tr>";
        $html.= "<tr>";
        $html.= "<td style='border:1px solid black;' align='center'>1</td>";
        $html.= "<td style='border:1px solid black;' align='center'>2</td>";
        $html.= "<td style='border:1px solid black;' align='center'>3</td>";
        $html.= "<td style='border:1px solid black;' align='center'>4</td>";
        $html.= "<td style='border:1px solid black;' align='center'>5</td>";
        $html.= "<td style='border:1px solid black;' align='center'>6</td>";
        $html.= "<td style='border:1px solid black;' align='center'>7</td>";
        $html.= "<td style='border:1px solid black;' align='center'>8</td>";
        $html.= "<td style='border:1px solid black;' align='center'>9</td></tr>";
        $html.= "<tr style='border:1px solid black;'><td align='center'>" . $pno . "</td>";
        return $html;
    }
    function CreateArrayforPDarDag($dist_code, $subdiv_code, $circle_code, $mouza_code,$lot_no, $vill_code, $pno, $patta_type,$sqlJP,$sqlDAG,$cntPdar,$cntDag,$myCnt,$ltARR,$areaARR,$tLine)
    {
        //Inseting Pattadar Names into ARRAY (pdarARR]
        $cnt=0;
        $totalLine=$tLine;
        $totalPG=0;
        global $pdarARR;
        global $dagARR;
        global $ltARR;
        global $areaARR;
        global $combineARR;
        global $myCnt;
        $NewArrayPosition=0;
        global $pno;
        global $myCircle;
        global $myVillage;
        global $myPattaType;
        global $pno;
        $total_B=0;
        $total_K=0;
        $total_L=0;
        $d_rev=0;
        $d_ltax=0;
        $totalLC=0;
        $g_areaB=0;
        $g_areaK= intval($totalLC/20);
        foreach ($sqlJP->result() as $row)
        {
            $cnt++;
            if ($row->p_flag=='1')
            {
                $pdar="<font color='red'> '<strike style=HEIGHT: 1px>'" . $cnt . ")" .$row->pdar_name . ", " . $row->pdar_father . "</strike></font><br>";
                //echo "</strike>";
            }
            else
            {
                $pdar= $cnt . ")" . $row->pdar_name . ", " . $row->pdar_father . "<br>";
            }
            $pdarARR[].=$pdar;
        }
        //Inserting DAG No, Revenue into the array $dagARR;
        foreach ($sqlDAG->result() as $row)
        {
            $DagRevLTArea="Dag-" . $row->dag_no . ", " . "Rs." . number_format($row->dag_revenue,2) . "<br>";
            $ltax= "Rs." . number_format($row->dag_localtax,2) . "<br>";
            $darea= $row->dag_area_b . "B-" . $row->dag_area_k . "K-" . number_format($row->dag_area_lc,2) . "L"  . "<br>";
            $dagARR[].=$DagRevLTArea;
            $ltARR[].=$ltax;
            $areaARR[].=$darea;
            $total_B=($total_B +$row->dag_area_b);
            $total_K=($total_K + $row->dag_area_k);
            $total_L=($total_L + $row->dag_area_lc);
            $d_rev=($d_rev + $row->dag_revenue);
            $d_ltax=($d_ltax + $row->dag_localtax);
        }

        //  Calculate the Grand total of Revenue, Local Tax and Land Area
        $totalLC=($total_B*100 + $total_K * 20 + $total_L);
        $g_areaB=intval($totalLC/100);
        $totalLC=($totalLC % 100);
        $g_areaK= intval($totalLC/20);
        $totalLC= ($totalLC % 20);
        //======================================================
        //Adjust the array for Dags and Pattadar for equal no of rows.
        if ($cntPdar > $cntDag)
        {
            for($i=$cntDag; $i<$cntPdar;$i++)
            {
                $dagARR[].=" ";
                $ltARR[].=" ";
                $areaARR[].=" ";
            }
        }
        else
        {
            for($j=$cntPdar; $j<$cntDag; $j++)
            {
                $pdarARR[].=" ";
            }
        }
        //If the Total Nos of Pattadar or Dags etc are less than 15 or equal to 15
        //than the following part will be executed.
        $myCnt1=count($pdarARR); // Since all the arrays are made of samne size, so any one can be used for getting the total no of records in Array.
        $html= "<td style='border:1px solid black;'>";
        for($p=0;$p<$myCnt1;$p++)
        {
            $html.=  $pdarARR[$p];
            if ($p==($totalLine-1))
            {
                break;
            }
        }

        $html.= "</td>";
        //----------------------For Dags, Revenue and Lcal Tax
        $html.= "<td style='border:1px solid black;'>";
        for($p=0;$p<$myCnt1;$p++)
        {
            $html.=  "<font size=2>" . $dagARR[$p] . "</font>";
            if ($p==($totalLine-1))
            {
                break;
            }

        }
        $html.= "Total Rs." . $d_rev;
        $html.= "</td>";
        //--------------------
        $html.= "<td style='border:1px solid black;'>";
        for($p=0;$p<$myCnt1;$p++)
        {
            $html.=  $ltARR[$p];
            if ($p==($totalLine-1))
            {
                break;
            }
        }
        $html.= "Total Rs." .  $d_ltax;
        $html.= "</td>";
        //----------------------------------------------
        $html.= "<td style='border:1px solid black;'></td>";
        $html.= "<td style='border:1px solid black;'></td>";
        $html.= "<td style='border:1px solid black;'></td>";
        $html.= "<td style='border:1px solid black;'></td>";
        $html.= "<td style='border:1px solid black;'>";
        for($p=0;$p<$myCnt1;$p++)
        {
            $html.=  $areaARR[$p] ;
            if ($p==($totalLine-1))
            {
                $NewArrayPosition=($p+1);
                break;
            }
        }
        if ($myCnt<$totalLine)
        {
            for($q=0;$q<($totalLine-$myCnt);$q++) //For managing the lines in the table the Smaller Counter between Padar and Area has be selected.
            {
                $html.= "&nbsp;</br>";
            }
        }
        $html.= "Total-" . $g_areaB ."B-" . $g_areaK . "K-" . $totalLC . "L<br>";
        $html.= "</td>";
        $html.= "</tr></table>";
        $html.= "<p align='center'> Page-1 </p>";
        $html.= "<div style='page-break-after:always' ></div>";
        $totalPG=count($pdarARR)/$totalLine;
        //$html.= "CT" . count($pdarARR);
        //$html.= "PG " . $totalPG;
        //The following Part is for displaying the records after 15.
        if ( $myCnt1>$totalLine)
            //Jumping Statement
        {
            $pgno=1;
            for($z=0; $z<($totalPG-1); $z++)
            {
                $html.= $this->TableHeader($_SESSION["myCircle"],$_SESSION["myVillage"],$_SESSION["myPattaType"],$_SESSION["patta_no"]);
                //==========================================
                $html.= "<td style='border:1px solid black;' width=25%\>";
                $c1=0;
                for($p=$NewArrayPosition;$p<$myCnt1;$p++)
                {
                    $c1++;
                    $html.=  $pdarARR[$p];
                    if ($c1==$totalLine)
                    {
                        break;
                    }
                }
                $html.= "</td>";
                $c1=0;
                $html.= "<td style='border:1px solid black;'>";
                for($p=$NewArrayPosition;$p<$myCnt1;$p++)
                { $c1++;
                    $html.=  $dagARR[$p] ;
                    if ($c1==$totalLine)
                    {
                        break;
                    }
                }
                $html.= "</td>";
                //--------------------
                $c1=0;
                $html.= "<td style='border:1px solid black;'>";
                for($p=$NewArrayPosition;$p<$myCnt1;$p++)
                { $c1++;
                    $html.=  $ltARR[$p];
                    if ($c1==$totalLine)
                    {
                        break;
                    }
                }
                $html.= "</td>";
                //----------------------------------------------
                $html.= "<td style='border:1px solid black;'></td>";
                $html.= "<td style='border:1px solid black;'></td>";
                $html.= "<td style='border:1px solid black;'></td>";
                $html.= "<td style='border:1px solid black;'></td>";
                $c1=0;
                $html.= "<td style='border:1px solid black;'>";
                for($p=$NewArrayPosition;$p<$myCnt1;$p++)
                { $c1++;
                    $html.=  $areaARR[$p] ;
                    if ($c1==$totalLine)
                    {
                        $NewArrayPosition=($p+1);
                        break;
                    }
                }
                $html.= "</td>";
                $html.= "</tr></table>";
                //==========================================
                $pgno++;
                $html.= "<p align='center'>Page-" . $pgno  . "</p>";
                $html.= "<div style='page-break-after:always'></div>";
            }
        }
        return $html;
    }
    function createsdlcAccount(){

        log_message('error',json_encode($_POST));
        $this->load->helper('security');
        // var_dump($_POST['dist_code']);
        $final_dist_array=$_POST['dist_code'];
        // $dist_code=str_replace("[",'',$dist_code);
        // $dist_code=str_replace("]",'',$dist_code);
        // $dist_code=str_replace('"','',$dist_code);
        // $final_dist_array=explode(',',$dist_code);
        if(count($final_dist_array)==0 || empty($final_dist_array)){
            echo json_encode(
                array(
                    'responseType'=>3,
                    'msg'=>'Please select atleast one district'
                )
            );
            return;
        }
        $subdiv_code = '00';
        $circle_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';
        $phone_no = $this->input->post('mobile_no');
        $user_desig_code = trim($this->input->post('designation'));
        //echo $user_desig_code;
        $emailid = $this->input->post('email');
        $username = $this->input->post('name');
        $use_name = $this->input->post('unique_user_id');
        $password = do_hash($this->input->post('password'));
        $aadhar_no = $this->input->post('aadhaar_no');
        $display_name = $this->input->post('display_name');
        $user_type=$this->input->post('user_type');
        //$user_code = $this->input->post('user_code');
        $dbb=$this->load->database('auth',true);
        $sqlAuth="Select * from central_auth where dhar_user=? ";
        $data=$dbb->query($sqlAuth,$use_name)->num_rows();

        //$dist_code = $this->input->post('dist_code');
        for($i=0;$i<count($final_dist_array);$i++){
            $dist_code=trim($final_dist_array[$i]);
            log_message('error',"DIST:".$dist_code);
            $this->dbswitch($dist_code);
            $this->db->trans_begin();
            $sqlLogin="Select * from loginuser_table where use_name=? ";
            $data1=$this->db->query($sqlLogin,$use_name)->num_rows();
            if($data==1 || $data1==1){
                echo json_encode(
                    array(
                        'responseType'=>3,
                        'msg'=>$use_name.' Name already exists in our records. Please try another ID'
                    )
                );
                return;
            }
            $sql="Select * from users where user_desig_code=? ";
            $userList=$this->db->query($sql,$user_desig_code)->num_rows();
            $p=1;
            if($userList==0)
                $user_code=$user_desig_code.$p;
            else
                $user_code=$user_desig_code.($userList+1);

            $users = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'username' => $username,
                'user_code' => $user_code,
                'user_desig_code' => $user_desig_code,
                'status' => 'A',
                'emailid' => $emailid,
                'date_from' => date('Y-m-d'),
                'date_to' =>  date('Y-m-d'),
                'phone_no' =>$phone_no,
                'aadhar_no' => $aadhar_no,
                'display_name' => $display_name
            );

            $this->db->insert('users', $users);
            if($this->db->affected_rows()!=1){
                log_message('error',"##APIINSERT001".$this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode(
                    array(
                        'responseType'=>3,
                        'msg'=>'Error in Processing. Please try Again'
                    )
                );
                return;
            }
            $loginuser_table = array(
                'use_name' => $use_name,
                'user_code' => $user_code,
                'priv' => 'mut',
                'date_of_creation' => date('Y-m-d'),
                'dis_enb_option' => 'E',
                'first_login' => 'Y',
                'activity' => '1 ',
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'password' => $password,
                'prev_password1' => $this->utilityclass->encryptData($this->input->post('password'))
            );
            $this->db->insert('loginuser_table', $loginuser_table);
            if($this->db->affected_rows()!=1){
                log_message('error',"##APIINSERT002".$this->db->last_query());
                $this->db->trans_rollback();
                echo json_encode(
                    array(
                        'responseType'=>3,
                        'msg'=>'Error in Processing. Please try Again'
                    )
                );
                return;
            }
            $this->db->trans_commit();
        }
        $insert= array(
            'dhar_user'=>$use_name,
            'dhar_code'=>$user_code,
            'dist_code'=>$user_type =='MP' ? "00" : ($user_type =='MLA' ? "00" : $dist_code),
            'subdiv_code'=>$user_type =='MP' ? "00" : ($user_type =='MLA' ? "00" : $subdiv_code),
            'cir_code'=>$user_type =='MP' ? "00" : ($user_type =='MLA' ? "00" : $circle_code),
            'mouza_pargona_code'=>$user_type =='MP' ? "00" : ($user_type =='MLA' ? "00" : $mouza_pargona_code),
            'lot_no'=>$user_type =='MP' ? "00" : ($user_type =='MLA' ? "00" : $lot_no),
            'mapped_by'=> $use_name,
            'date_of_map'=>date('Y-m-d'),
            'password' => $password,
            'prev_password1' => $this->utilityclass->encryptData($this->input->post('password')),
            'emailid' => $emailid,
            'mobile'=>$phone_no
        );
        if($insert){
            $dbb->trans_begin();
            $dbb->insert('central_auth',$insert);
            if($dbb->affected_rows()!=1){
                log_message('error',"##AUTHAPI002".$dbb->last_query());
                $dbb->trans_rollback();
                $this->db->trans_rollback();
                echo json_encode(
                    array(
                        'responseType'=>3,
                        'msg'=>'Error in Processing. Please try Again'
                    )
                );
                return;
            }
        }
        ////////////////////
        if($dbb->trans_status() === TRUE){
            $dbb->trans_commit();
            echo json_encode(
                array(
                    'responseType'=>2,
                    'code'=>$user_code,
                    'msg'=>'User Created successfully'
                )

            );
            return;
        }
    }
    function userInsert($dist_code){
        $url = "https://basundhara.assam.gov.in/irlms/DepartmentApi/getDepartmentUserDetailByDist/".$dist_code ;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        $output = curl_exec($ch);
        curl_close($ch);
        // echo $output;
        // die();
        $data=json_decode($output);
        $this->dbswitch($dist_code);
        //var_dump($data->responseData);
        $subdiv_code = '00';
        $circle_code = '00';
        $mouza_pargona_code = '00';
        $lot_no = '00';
        $i=1;
        foreach ($data->responseData as $key => $value) {
            $i=$i+1;
            $dist_code = $value->dist_code;
            $phone_no = $value->mobile_no;
            $user_desig_code = trim($value->designation);
            //echo $user_desig_code;
            $emailid = $value->email;
            $username = $value->name;
            $use_name = $value->unique_user_id;
            $password = do_hash($value->password);
            $aadhar_no = $value->aadhaar_no;
            $display_name = $value->display_name;
            $user_type=$value->user_type;
            //$user_code = $this->input->post('user_code');
            $dbb=$this->load->database('auth',true);
            $sqlAuth="Select * from central_auth where dhar_user=? ";
            $data=$dbb->query($sqlAuth,$use_name)->num_rows();
            if($data>=1){
                continue;
            }

            $sqlLogin="Select * from loginuser_table where use_name=? ";
            $data1=$this->db->query($sqlLogin,$use_name)->num_rows();
            if($data1==1){
                continue;
            }
            $sql="Select * from users where user_desig_code=? ";
            $userList=$this->db->query($sql,$user_desig_code)->num_rows();
            $p=1;
            if($userList==0)
                $user_code=$user_desig_code.$p;
            else
                $user_code=$user_desig_code.($userList+1);
            $users = array(
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'username' => $username,
                'user_code' => $user_code,
                'user_desig_code' => $user_desig_code,
                'status' => 'A',
                'emailid' => $emailid,
                'date_from' => date('Y-m-d'),
                'date_to' =>  date('Y-m-d'),
                'phone_no' =>$phone_no,
                'aadhar_no' => $aadhar_no,
                'display_name' => $display_name
            );
            $this->db->trans_begin();
            $this->db->insert('users', $users);
            if($this->db->affected_rows()!=1){
                log_message('error',"##APIINSERT001".$this->db->last_query());
                $this->db->trans_rollback();
                continue;
            }
            $loginuser_table = array(
                'use_name' => $use_name,
                'user_code' => $user_code,
                'priv' => 'mut',
                'date_of_creation' => date('Y-m-d'),
                'dis_enb_option' => 'E',
                'first_login' => 'Y',
                'activity' => '1 ',
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $circle_code,
                'mouza_pargona_code' => $mouza_pargona_code,
                'lot_no' => $lot_no,
                'password' => $password,
                'prev_password1' => $this->utilityclass->encryptData($value->password)
            );
            $this->db->insert('loginuser_table', $loginuser_table);
            if($this->db->affected_rows()!=1){
                log_message('error',"##APIINSERT002".$this->db->last_query());
                $this->db->trans_rollback();
                continue;
            }
            $insert= array(
                'dhar_user'=>$use_name,
                'dhar_code'=>$user_code,
                'dist_code'=>$user_type =='MP' ? "00" : ($user_type =='MLA' ? "00" : $dist_code),
                'subdiv_code'=>$user_type =='MP' ? "00" : ($user_type =='MLA' ? "00" : $subdiv_code),
                'cir_code'=>$user_type =='MP' ? "00" : ($user_type =='MLA' ? "00" : $circle_code),
                'mouza_pargona_code'=>$user_type =='MP' ? "00" : ($user_type =='MLA' ? "00" : $mouza_pargona_code),
                'lot_no'=>$user_type =='MP' ? "00" : ($user_type =='MLA' ? "00" : $lot_no),
                'mapped_by'=> $use_name,
                'date_of_map'=>date('Y-m-d'),
                'password' => $password,
                'prev_password1' => $this->utilityclass->encryptData($value->password),
                'emailid' => $emailid,
                'mobile'=>$phone_no
            );
            $sqlLogin="Select * from central_auth where dhar_user=? ";
            $data1=$this->db->query($sqlLogin,$use_name)->num_rows();
            if($data1==1){
                $this->db->trans_commit();
                continue;
            }else{
                if($insert){
                    $dbb->trans_begin();
                    $dbb->insert('central_auth',$insert);
                    if($dbb->affected_rows()!=1){
                        log_message('error',"##AUTHAPI002".$dbb->last_query());
                        $dbb->trans_rollback();
                        $this->db->trans_rollback();
                        continue;
                    }
                }
            }

            // $dbb->trans_rollback();
            // $this->db->trans_rollback();
            if($this->db->trans_status()===true && $dbb->trans_status()===true){
                $dbb->trans_commit();
                $this->db->trans_commit();
            }
            echo $i;
        }
    }

    function  tenatNameApi(){
        $dist_code=$this->input->post('dist_code');
        $subdiv_code=$this->input->post('subdiv_code');
        $cir_code=$this->input->post('cir_code');
        $mouza_pargona_code=$this->input->post('mouza_pargona_code');
        $lot_no=$this->input->post('lot_no');
        $vill_townprt_code=$this->input->post('vill_townprt_code');
        $dag_no=$this->input->post('dag_no');
        $this->dbswitch($dist_code);
        $sql="Select  khatian_no,tenant_name,tenants_father from chitha_tenant where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=?
        and lot_no=? and vill_townprt_code=? and dag_no=?";
        $data=$this->db->query($sql,array($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$dag_no));
        log_message('error',$this->db->last_query());
        if($data->num_rows()==0){
            echo json_encode('No Data Found');
            return;
        }
        $result=$data->result_array();
        echo json_encode($result);
    }
    function getMinutes(){
        $error=array();
        $dist_code=$_POST['dist_code'];
        if(isset($_POST['dist_code']) && $_POST['dist_code'] == '' || !isset($_POST['dist_code']))
            $error[]=(array('responseType' => 1,'message' => 'distcode is required'));
        $this->dbswitch($dist_code);
        $meeting_id=$_POST['meeting_id'];
        if(isset($_POST['meeting_id']) && $_POST['meeting_id'] == '' || !isset($_POST['meeting_id']))
            $error[]=(array('responseType' => 1,'message' => 'meeting_id is required'));
        if($error){
            echo json_encode($error);
            return;
        }
        $sql="select * from proposal_meeting_list where dist_code=? and id=?";
        $num=$this->db->query($sql,array($dist_code,$meeting_id));
        if($num->num_rows()==0){
            echo json_encode('No minutes Found');
            return;
        }
        $data=$num->row()->encode_pdf_dir_path;
        echo $section = file_get_contents($data, true);
    }
    public function generateChithaRegistration() {
        // 07 01 07 03 02 10003 934
        $error=array();
        $dist_code=$_POST['dist_code'];
        if(isset($_POST['dist_code']) && $_POST['dist_code'] == '' || !isset($_POST['dist_code']))
            $error[]=(array('responseType' => 1,'message' => 'distcode is required'));
        $this->dbswitch($dist_code);
        $subdiv_code=$_POST['subdiv_code'];
        if(isset($_POST['subdiv_code']) && $_POST['subdiv_code'] == '' || !isset($_POST['subdiv_code']))
            $error[]=(array('responseType' => 1,'message' => 'subdiv_code is required'));
        $cir_code=$_POST['cir_code'];
        if(isset($_POST['cir_code']) && $_POST['cir_code'] == '' || !isset($_POST['cir_code']))
            $error[]=(array('responseType' => 1,'message' => 'cir_code is required'));
        $mouza_pargona_code=$_POST['mouza_pargona_code'];
        if(isset($_POST['mouza_pargona_code']) && $_POST['mouza_pargona_code'] == '' || !isset($_POST['mouza_pargona_code']))
            $error[]=(array('responseType' => 1,'message' => 'mouza_pargona_code is required'));
        $lot_no=$_POST['lot_no'];
        if(isset($_POST['lot_no']) && $_POST['lot_no'] == '' || !isset($_POST['lot_no']))
            $error[]=(array('responseType' => 1,'message' => 'lot_no is required'));
        $vill_townprt_code=$_POST['vill_townprt_code'];
        if(isset($_POST['vill_townprt_code']) && $_POST['vill_townprt_code'] == '' || !isset($_POST['vill_townprt_code']))
            $error[]=(array('responseType' => 1,'message' => 'vill_townprt_code is required'));
        $patta_code=$_POST['patta_code'];
        if(isset($_POST['patta_code']) && $_POST['patta_code'] == '' || !isset($_POST['patta_code']))
            $error[]=(array('responseType' => 1,'message' => 'patta_code is required'));
        $dag_no=$_POST['dag_no'];
        if(isset($_POST['dag_no']) && $_POST['dag_no'] == '' || !isset($_POST['dag_no']))
            $error[]=(array('responseType' => 1,'message' => 'dag_no is required'));
        $application_no=$_POST['application_no'];
        if(isset($_POST['application_no']) && $_POST['application_no'] == '' || !isset($_POST['application_no']))
            $error[]=(array('responseType' => 1,'message' => 'application_no is required'));
        $link=$_POST['link'];
        if(isset($_POST['link']) && $_POST['link'] == '' || !isset($_POST['link']))
            $error[]=(array('responseType' => 1,'message' => 'link is required'));
        if($error){
            echo json_encode($error);
            return;
        }
        $district_code = $dist_code;
        $subdivision_code = $subdiv_code;
        $circlecode = $cir_code;
        $mouzacode = $mouza_pargona_code;
        $lot_code = $lot_no;
        $village_code = $vill_townprt_code;
        $patta_code = $patta_code;
        $dag_no_lower = $dag_no * 100;
        $dag_no_upper = $dag_no * 100;

        $dist_name = $this->utilityclass->getDistrictName($district_code);
        $subdiv_name = $this->utilityclass->getSubDivName($district_code, $subdivision_code);
        $cir_name = $this->utilityclass->getCircleName($district_code, $subdivision_code, $circlecode);
        $mouza_pargona_code_name = $this->utilityclass->getMouzaName($district_code, $subdivision_code, $circlecode, $mouzacode);
        $lot_no = $this->utilityclass->getLotLocationName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code);
        $vill_townprt_code_name = $this->utilityclass->getVillageName($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code);

        $data['location'] = array('dist' => $dist_name, 'sub' => $subdiv_name, 'cir' => $cir_name, 'mouza' => $mouza_pargona_code_name, 'lot' => $lot_no, 'vill' => $vill_townprt_code_name);


        $secondSelection = array('patta_code' => $patta_code, 'dag_no_lower' => $dag_no_lower, 'dag_no_upper' => $dag_no_upper);

        $this->load->model('chitha/ChithaModel');
        $pattatype['chithaPattatypeinfo'] = $this->ChithaModel->getpattatype($patta_code);
        $this->session->set_userdata(array('patta_type' => $pattatype['chithaPattatypeinfo'][0]->patta_type));
        if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123Barak($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
        }
        else{
            $chithainfo1['data'] = $this->ChithaModel->getchithaDetails123($district_code, $subdivision_code, $circlecode, $mouzacode, $lot_code, $village_code, $dag_no_lower, $dag_no_upper, $patta_code);
        }
        
        if(empty($chithainfo1['data'])){
            echo json_encode("Dag not available at present in our records !");
            return;
        }
        if($application_no)
        {
                $this->load->helper('qrcode');
                $base_64 = printQR($link);
                $rtps_applied_chitha=[
                        'application_no'=>$application_no,
                        'link'=> $$base_64
                ];
        }else $rtps_applied_chitha=[];
        $maindataforchitha = array_merge($data, $secondSelection, $chithainfo1, $pattatype,$rtps_applied_chitha);
        $dist_code = $this->session->userdata('dist_code');
        if($dist_code==21)
        {
            $content = $this->load->view('chitha_report/saveChithaReportKar', $maindataforchitha, true);
        }
        else{
            $content = $this->load->view('chitha_report/saveChithaReport', $maindataforchitha, true);
        }
        header("Access-Control-Allow-Origin: *");
        echo json_encode(base64_encode($content));
    }
    function getRemoteFile()
    {
        $f_path = $_POST['path'];
        if (file_exists($f_path))
        {
            echo file_get_contents($f_path);
            return;
        }
    }
    ////////////////
    function checkPaymentRevival(){
        $error=array();
        $dist_code=$_POST['dist_code'];
        if(isset($_POST['dist_code']) && $_POST['dist_code'] == '' || !isset($_POST['dist_code']))
            $error[]=(array('responseType' => 1,'message' => 'distcode is required'));
        $this->dbswitch($dist_code);
        $application_no=$_POST['application_no'];
        if(isset($_POST['application_no']) && $_POST['application_no'] == '' || !isset($_POST['application_no']))
            $error[]=(array('responseType' => 1,'message' => 'application no is required'));
        $sql="Select * from settlement_basic where applid=?";
        $data=$this->db->query($sql,$application_no);
        if($data->num_rows()==0){
            echo json_encode(array('responseType'=>1,'msg'=>'No Case no found'));
            return;
        }
        echo json_encode(array('responseType'=>2,'status'=>$data->row()->pull_request,'msg'=>'Successfull'));
        return;
    }
    ////////////////
    function traceMapAttachment(){
        $error=array();
        $dist_code=$_POST['dist_code'];
        if(isset($_POST['dist_code']) && $_POST['dist_code'] == '' || !isset($_POST['dist_code'])){
            $error=(array('responseType' => 1,'message' => 'District is required'));
            echo json_encode($error);
            return;
        }
        $this->dbswitch($dist_code);
        $application_no=$_POST['application_no'];
        $dag_no=$_POST['dag_no'];
        if(isset($_POST['application_no']) && $_POST['application_no'] == '' || !isset($_POST['application_no'])){
            $error[]=(array('responseType' => 1,'message' => 'Application no is required'));
            echo json_encode($error);
            return;
        }
        if(isset($_POST['dag_no']) && $_POST['dag_no'] == '' || !isset($_POST['dag_no'])){
            $error[]=(array('responseType' => 1,'message' => 'Dag no is required'));
            echo json_encode($error);
            return;
        }
        /////////Fecth Applid////////////
        $sql="Select case_no from settlement_basic where applid=?";
        $case_no_data=$this->db->query($sql,$application_no);
        if($case_no_data->num_rows()==0){
            $error[]=(array('responseType' => 1,'message' => 'Case No is Missing'));
            echo json_encode($error);
            return;
        }
        /////////////////////
        $case_no=$case_no_data->row()->case_no;
        $sql=" select * from supportive_document where file_name='Trace Map Copy' and  ((case_no=? or case_no=?) or (applid=? or applid=?)) and dag_no=? order by id desc";
        $data=$this->db->query($sql,array($application_no,$case_no,$application_no,$case_no,$dag_no));
        // echo $this->db->last_query();
        if($data->num_rows()==0){
            echo json_encode(array('responseType'=>1,'msg'=>'No Case no/Dag No found'));
            return;
        }
        $result=$data->row_array();
        $base64decoded_notice_file=null;
        if(!file_exists($result['file_path']))
        {
            $this->load->model('SettlementModel/SettlementCommonModel');
            $getFile = $this->SettlementCommonModel->callRemoteFile('index.php/DharitreeApi/getRemoteFile',$result['file_path']);
            if ($getFile == true)
            {
                // $open_notice_file = fopen($result['file_path'], "r") or die("Unable to open file!");
                // $read_notice_file = fread($open_notice_file,filesize($result['file_path']));
                // fclose($open_notice_file);
                $base64decoded_notice_file = json_decode($getFile);
            }
            else
            {
                echo json_encode(array('responseType'=>1,'msg'=>'File Missing'));
                return false;
            }
        }
        else
        {
            // $open_notice_file = fopen($result['file_path'], "r") or die("Unable to open file!");
            // $read_notice_file = fread($open_notice_file,filesize($result['file_path']));
            // fclose($open_notice_file);
            $base64decoded_notice_file = file_get_contents($result['file_path']);
        }
        $status=array(
            'file_type'=>$result['file_type'],
            'base64file'=>base64_encode(($base64decoded_notice_file))
        );
        echo json_encode(array('responseType'=>2,'status'=>$status,'msg'=>'Successfull'));
        return;
    }

    public function getSronoteAPI() {

        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $error=array();
        $dist_code=$jsonArray['dist_code'];
        if(isset($jsonArray['dist_code']) && $jsonArray['dist_code'] == '' || !isset($jsonArray['dist_code'])){
            log_message('error',"epanjeeyannew####------".json_encode($jsonArray));
            echo json_encode(array('responseType' => 1,'message' => 'distcode is required'));
            return;
        }
        $this->dbswitch($dist_code);
        $subdiv_code=$jsonArray['subdiv_code'];
        if(isset($jsonArray['subdiv_code']) && $jsonArray['subdiv_code'] == '' || !isset($jsonArray['subdiv_code']))
            $error[]=(array('responseType' => 1,'message' => 'subdiv_code is required'));
        $cir_code=$jsonArray['cir_code'];
        if(isset($jsonArray['cir_code']) && $jsonArray['cir_code'] == '' || !isset($jsonArray['cir_code']))
            $error[]=(array('responseType' => 1,'message' => 'cir_code is required'));
        $mouza_pargona_code=$jsonArray['mouza_pargona_code'];
        if(isset($jsonArray['mouza_pargona_code']) && $jsonArray['mouza_pargona_code'] == '' || !isset($jsonArray['mouza_pargona_code']))
            $error[]=(array('responseType' => 1,'message' => 'mouza_pargona_code is required'));
        $lot_no=$jsonArray['lot_no'];
        if(isset($jsonArray['lot_no']) && $jsonArray['lot_no'] == '' || !isset($jsonArray['lot_no']))
            $error[]=(array('responseType' => 1,'message' => 'lot_no is required'));
        $vill_townprt_code=$jsonArray['vill_townprt_code'];
        if(isset($jsonArray['vill_townprt_code']) && $jsonArray['vill_townprt_code'] == '' || !isset($jsonArray['vill_townprt_code']))
            $error[]=(array('responseType' => 1,'message' => 'vill_townprt_code is required'));
        $patta_type_code=$jsonArray['patta_type_code'];
        if(isset($jsonArray['patta_type_code']) && $jsonArray['patta_type_code'] == '' || !isset($jsonArray['patta_type_code']))
            $error[]=(array('responseType' => 1,'message' => 'patta_type_code is required'));
        $patta_no=$jsonArray['patta_no'];
        if(isset($jsonArray['patta_no']) && $jsonArray['patta_no'] == '' || !isset($jsonArray['patta_no']))
            $error[]=(array('responseType' => 1,'message' => 'patta_no is required'));
        $sro_code=$jsonArray['sro_code'];
        if(isset($jsonArray['sro_code']) && $jsonArray['sro_code'] == '' || !isset($jsonArray['sro_code']))
            $error[]=(array('responseType' => 1,'message' => 'sro_code is required'));
        $dag_no=$jsonArray['dag_no'];
        if(isset($jsonArray['dag_no']) && $jsonArray['dag_no'] == '' || !isset($jsonArray['dag_no']))
            $error[]=(array('responseType' => 1,'message' => 'dag_no is required'));
        $deed_no=$jsonArray['deed_no'];
        if(isset($jsonArray['deed_no']) && $jsonArray['deed_no'] == '' || !isset($jsonArray['deed_no']))
            $error[]=(array('responseType' => 1,'message' => 'deed_no is required'));

        if($error){
            echo json_encode($error);
            return;
        }

        $user_code_row = $this->db->query("select user_code from loginuser_table where 
                                     dist_code='$dist_code'
                                     and subdiv_code='$subdiv_code' and cir_code='$cir_code'
                                     and user_code like 'CO%' and dis_enb_option='E' ");
        // if ($user_code_row->num_rows() <=0)
        // continue;
        //var_dump($user_code->row()->c);
        $user_code = $user_code_row->row();
        if(empty($user_code))
        {
            log_message('error', 'users-co'.$user_code->user_code."QUERY".$this->db->last_query());
        }

        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag_no,
            'deed_type' => $jsonArray['deed_type'],
            'patta_type_code' => $patta_type_code,
            'patta_no' => trim($patta_no),
            'dag_area_b' => $jsonArray['dag_area_b'],
            'dag_area_k' => $jsonArray['dag_area_k'],
            'dag_area_lc' => $jsonArray['dag_area_lc'],
            'dag_area_g' => $jsonArray['dag_area_g'],
            'dag_area_kr' => 0,
            'reg_to_name' => $jsonArray['reg_to_name'],
            'reg_from_name' => $jsonArray['reg_from_name'],
            'name_of_sro' => $jsonArray['name_of_sro'],
            'deed_no' => $jsonArray['deed_no'],
            'deed_value' => $jsonArray['deed_value'],
            'date_of_deed' => date('Y-m-d H:i:sP', strtotime($jsonArray['date_of_deed'])),
            'user_code' => $user_code->user_code,
            'operation' => 'E',
            'status' => 0,
            'sro_code' =>$jsonArray['sro_code'],
            'update_date' => date('Y-m-d G:i:s'),
            'nocno' => $jsonArray['nocno'],
            'deed_no_actual' => $jsonArray['deed_no_actual'],
            'user_name' => $jsonArray['user_name'],
            'ipaddress' =>$jsonArray['ipaddress'],

        );

        $count = $this->db->query("select * from  sro_note where
                deed_no=? and dist_code=?
                and subdiv_code=? and cir_code=? and sro_code=?",array($deed_no,$dist_code,$subdiv_code,$cir_code,$sro_code));
        if ($count->num_rows() == 0) {
            $data1 = $this->db->insert('sro_note', $data);

            if($data1==false or $data1!=1){
                echo json_encode(array('type'=>2,
                    'text'=> 'Data not updated'));
                return;
            }
        }
        else{

            $get_sro_note =  $this->db->get_where('sro_note', array('dist_code' => $jsonArray['dist_code'],
                'subdiv_code'=>$jsonArray['subdiv_code'],
                'cir_code' => $jsonArray['cir_code'],
                'deed_no' => $jsonArray['deed_no'],
                'sro_code' => $jsonArray['sro_code']
            ));

            if ($get_sro_note->num_rows() > 0) {
                $sro_note_data = $get_sro_note->result();
            }


            $this->db->trans_begin();

            $case_no=$jsonArray['nocno'].'-'.$jsonArray['deed_no'];


            $archive_data = $this->archive_data($case_no, 'sro_note', $sro_note_data, $jsonArray['dist_code']);
            if($archive_data==0){
                $this->db->trans_rollback();
                echo json_encode(array('type'=>3,
                    'text'=> 'Data not updated'));
                return;
            }

            if ($archive_data > 0) {
                // delete from petition_pattadar
                $this->db->where(array('dist_code' => $jsonArray['dist_code'], 'subdiv_code' => $jsonArray['subdiv_code'],
                    'cir_code' => $jsonArray['cir_code'],
                    'sro_code' => $jsonArray['sro_code'],
                    'deed_no' => $jsonArray['deed_no'],

                ));
                $delstatus=$this->db->delete('sro_note');
                if($delstatus!=1){
                    $this->db->trans_rollback();
                    echo json_encode(array('type'=>3,
                        'text'=> 'Data not updated'));
                    return;
                }
            }


            $count = $this->db->query("select count(deed_no) as c from  sro_note where
                deed_no='$deed_no' and dist_code='$dist_code'
                and subdiv_code='$subdiv_code' and cir_code='$cir_code' and sro_code='$sro_code' ")->row()->c;

            if ($count == 0) {
                $data1 = $this->db->insert('sro_note', $data);
                if($data1!=1){
                    $this->db->trans_rollback();
                    echo json_encode(array('type'=>3,
                        'text'=> 'Data not updated'));
                    return;
                }
            }

        }

        $this->db->trans_commit();
        echo json_encode(array('type'=>4,
            'text'=> 'Data updated'));
    }

    public function archive_data($case_no, $table_name, $data, $dist_code)
    {
        $archived_data = [
            'case_no' => $case_no,
            'date' => date('Y-m-d H:i:s'),
            'table_name' => $table_name,
            'data' => json_encode($data)
        ];
        $this->db->insert('archive_data', $archived_data);

        return $this->db->affected_rows();
    }

    function updateUserPassword()
    {
        // var_dump($_POST);
        log_message('error','D1: POST 1: '.json_encode($_POST));

        $error=array();
        $dist_code=$_POST['dist_code'];
        if(isset($_POST['dist_code']) && $_POST['dist_code'] == '' || !isset($_POST['dist_code'])){
            $error=(array('responseType' => 1,'message' => 'District is required'));
            echo json_encode($error);
            return;
        }
        $this->db = $this->dbswitch($dist_code);
        //log_message('error','C1: individual 1: '.json_encode($this->db));

        $uname=$_POST['uname'];
        $cred=$_POST['cred'];
        $mobile=$_POST['mobile'];
        if(isset($_POST['uname']) && $_POST['uname'] == '' || !isset($_POST['uname'])){
            $error[]=(array('responseType' => 1,'message' => 'User Name no is required'));
            echo json_encode($error);
            return;
        }
        if(isset($_POST['cred']) && $_POST['cred'] == '' || !isset($_POST['cred'])){
            $error[]=(array('responseType' => 1,'message' => 'Password no is required'));
            echo json_encode($error);
            return;
        }
        if(isset($_POST['mobile']) && $_POST['mobile'] == '' || !isset($_POST['mobile'])){
            $error[]=(array('responseType' => 1,'message' => 'Mobile no is required'));
            echo json_encode($error);
            return;
        }

        //log_message('error','A1: individual 1: '.json_encode($this->db));
        $this->db->trans_begin();
        $dbb=$this->load->database('auth', TRUE);
        //log_message('error','B1: central 1: '.json_encode($dbb));

        $dbb->trans_begin();
        //log_message('error','A2: individual 2: '.json_encode($this->db));
        //log_message('error','B2: central 1: '.json_encode($dbb));

        // *********************************************
        $auth=array(
            'password_change_flag'=>1,
            'password' => $cred,
            'mobile' => $mobile,
            'password_change' => date('Y-m-d'),
        );
        $dhar_user=$_POST['dhar_user'];
        $noc_user=$_POST['noc_user'];
        if($noc_user and $dhar_user){
            $dbb->where('noc_user',$noc_user);
            $dbb->where('dhar_user',$dhar_user);
        }else if($noc_user and $dhar_user==null ){
            $dbb->where('noc_user',$noc_user);
        }else if($dhar_user and $noc_user ==null){
            $dbb->where('dhar_user',$dhar_user);
        }
        $dbb->where('dist_code',$dist_code);
        $dbb->update('central_auth',$auth);
        if($dbb->affected_rows()!=1){

            log_message('error','X: '.$dbb->last_query());
            $dbb->trans_rollback();
            $error[]=(array('responseType' => 1,'message' => 'Error Found in Updating record'));
            echo json_encode($error);
            return ;
        }
        if($dhar_user==null || empty($dhar_user) || $dhar_user==''){
            log_message('error','NOCUSER: '.$noc_user);
            $dbb->trans_commit();
            $this->db->trans_commit();
            $error[]=(array('responseType' => 2,'message' => 'Success'));
            echo json_encode($error);
            return ;
        }
        // *******************************************
        $sql = 'select * from loginuser_table where use_name=?';
        $count = $this->db->query($sql, array($uname));
        if ($count->num_rows()==0)
        {
            $error[]=(array('responseType' => 1,'message' => 'No User Found'));
            echo json_encode($error);
            return;
        }
        $user_data = array(
            'date_password_changed'=> date('Y-m-d'),
            'password_change_flag' => 1,
            'password'    => $cred
        );

        $this->db->where('use_name',$dhar_user);
        $this->db->or_where('nocuser',$uname);
        $this->db->where('dis_enb_option','E');
        $status = $this->db->update("loginuser_table", $user_data);
        if ($this->db->affected_rows()!=1)
        {
            log_message('error','M1: '.$this->db->last_query());
            log_message('error','M2: '.$dbb->last_query());
            $dbb->trans_rollback();
            $this->db->trans_rollback();

            $error[]=(array('responseType' => 1,'message' => 'Error Found in Updating record'));
            echo json_encode($error);
            return ;
        }
        ////////////////
        $updateFetch=$this->db->query("Select * from loginuser_table where (use_name=? or nocuser=?) and dis_enb_option='E' ",array($dhar_user,$uname));
        if($updateFetch->num_rows()==1){
            $loginuserdata=$updateFetch->row_array();
            $mobile=array(
                'phone_no'=>$mobile,
            );
            $user_desig_code=str_split($loginuserdata['user_code']);
            if(strtoupper($user_desig_code[0])=='C' || strtoupper($user_desig_code[0])=='A' || strtoupper($user_desig_code[0])=='D' || strtoupper($user_desig_code[0])=='S'|| strtoupper($user_desig_code[0])=='B' ){
                $this->db->where('dist_code',$loginuserdata['dist_code']);
                $this->db->where('subdiv_code',$loginuserdata['subdiv_code']);
                $this->db->where('cir_code',$loginuserdata['cir_code']);
                $this->db->where('user_code',$loginuserdata['user_code']);
                $this->db->update('users',$mobile);
                if($this->db->affected_rows()==1){
                    log_message('error','L1: '.$this->db->last_query());
                    log_message('error','L2: '.$dbb->last_query());
                    $this->db->trans_commit();
                    $dbb->trans_commit();
                    // $this->db->trans_rollback();
                    // $dbb->trans_rollback();
                    $error[]=(array('responseType' => 2,'message' => 'Success'));
                    echo json_encode($error);
                    return ;
                }else{
                    log_message('error','L3: '.$this->db->last_query());
                    log_message('error','L4: '.$dbb->last_query());
                    $this->db->trans_rollback();
                    $dbb->trans_rollback();
                    $error[]=(array('responseType' => 1,'message' => 'Error Found in Updating record'));
                    echo json_encode($error);
                    return ;
                }
            }
            else if (strtoupper($user_desig_code[0])=='M'){
                $this->db->where('dist_code',$loginuserdata['dist_code']);
                $this->db->where('subdiv_code',$loginuserdata['subdiv_code']);
                $this->db->where('cir_code',$loginuserdata['cir_code']);
                $this->db->where('mouza_pargona_code',$loginuserdata['mouza_pargona_code']);
                $this->db->where('lot_no',$loginuserdata['lot_no']);
                $this->db->where('lm_code',$loginuserdata['user_code']);
                $this->db->update('lm_code',$mobile);
                if($this->db->affected_rows()==1){
                    log_message('error','L5: '.$this->db->last_query());
                    log_message('error','L6: '.$dbb->last_query());
                    $this->db->trans_commit();
                    $dbb->trans_commit();
                    // $this->db->trans_rollback();
                    // $dbb->trans_rollback();
                    $error[]=(array('responseType' => 2,'message' => 'Success'));
                    echo json_encode($error);
                    return ;
                }else{
                    log_message('error','L7: '.$this->db->last_query());
                    log_message('error','L8: '.$dbb->last_query());
                    $this->db->trans_rollback();
                    $dbb->trans_rollback();
                    $error[]=(array('responseType' => 1,'message' => 'Error Found in Updating record'));
                    echo json_encode($error);
                    return ;
                }
            }else{
                log_message('error','L9: '.$this->db->last_query());
                log_message('error','L10: '.$dbb->last_query());
                $this->db->trans_rollback();
                $dbb->trans_rollback();

                $error[]=(array('responseType' => 1,'message' => 'Error Found in Updating record'));
                echo json_encode($error);
                return ;
            }
        }else{
            log_message('error','L11: '.$this->db->last_query());
            log_message('error','L12: '.$dbb->last_query());
            $this->db->trans_rollback();
            $dbb->trans_rollback();
            $error[]=(array('responseType' => 1,'message' => 'USER-ID not unique'));
            echo json_encode($error);
            return;
        }
    }


    public function getResponseAfterEkyc()
    {
        $this->load->model('ApplicantChangeModel');

        $enc_data  = $_POST['external_data_response'];
        $aes       = new AES($enc_data, ENCRYPTION_KEY);
        $decrypted = $aes->decrypt();
        $decrypted = json_decode($decrypted);

        $response       = $_POST['response'];
        $originalString = str_replace("@","/",$response);
        $res_aes        = new AES($originalString, ENCRYPTION_KEY);
        $response       = $res_aes->decrypt();
        $response       = json_decode($response);

        // $aadhaar = $this->ApplicantChangeModel->insertNewApplicantAuthData($decrypted->case_no);

        $this->dbswitch($decrypted->dist_code);

        $data = [
            'extra_data' => $_POST['external_data_response'],
            'back_url'   => rawurldecode($decrypted->back_url),
            'dist_code'  => $decrypted->dist_code,
            'case_no'    => $decrypted->case_no,
            'response'   => $_POST['response'],
        ];
        $this->load->view('authentication', $data);
    }


    ///post api for ngdrs to push deeds at delivery///
    public function postSronoteNGDRSAPI() 
    {
        $postdata = json_decode($_POST['data']);//json_decode(file_get_contents('php://input'), true);
        $jsonArray = $postdata[0];
         // var_dump($jsonArray);exit;
        $error=array();
        $dist_code=$jsonArray->dist_code;
        if(isset($jsonArray->dist_code) && $jsonArray->dist_code == '' || !isset($jsonArray->dist_code)){
            log_message('error',"NGDRS####------".json_encode($jsonArray));
            echo json_encode(array('responseType' => 1,'message' => 'distcode is required'));
            return;
        }
        $this->dbswitch($dist_code);
        $subdiv_code=$jsonArray->subdiv_code;
        if(isset($jsonArray->subdiv_code) && $jsonArray->subdiv_code == '' || !isset($jsonArray->subdiv_code))
            $error[]=(array('responseType' => 1,'message' => 'subdiv_code is required'));
        $cir_code=$jsonArray->cir_code;
        if(isset($jsonArray->cir_code) && $jsonArray->cir_code == '' || !isset($jsonArray->cir_code))
            $error[]=(array('responseType' => 1,'message' => 'cir_code is required'));
        $mouza_pargona_code=$jsonArray->mouza_pargona_code;
        if(isset($jsonArray->mouza_pargona_code) && $jsonArray->mouza_pargona_code == '' || !isset($jsonArray->mouza_pargona_code))
            $error[]=(array('responseType' => 1,'message' => 'mouza_pargona_code is required'));
        $lot_no=$jsonArray->lot_no;
        if(isset($jsonArray->lot_no) && $jsonArray->lot_no == '' || !isset($jsonArray->lot_no))
            $error[]=(array('responseType' => 1,'message' => 'lot_no is required'));
        $vill_townprt_code=$jsonArray->vill_townprt_code;
        if(isset($jsonArray->vill_townprt_code) && $jsonArray->vill_townprt_code == '' || !isset($jsonArray->vill_townprt_code))
            $error[]=(array('responseType' => 1,'message' => 'vill_townprt_code is required'));
        $patta_type_code=$jsonArray->pattatype;
        if(isset($jsonArray->pattatype) && $jsonArray->pattatype == '' || !isset($jsonArray->pattatype))
            $error[]=(array('responseType' => 1,'message' => 'patta_type_code is required'));
        $patta_no=$jsonArray->patta_no;
        if(isset($jsonArray->patta_no) && $jsonArray->patta_no == '' || !isset($jsonArray->patta_no))
            $error[]=(array('responseType' => 1,'message' => 'patta_no is required'));
        $sro_code=$jsonArray->sro_code;
        if(isset($jsonArray->sro_code) && $jsonArray->sro_code == '' || !isset($jsonArray->sro_code))
            $error[]=(array('responseType' => 1,'message' => 'sro_code is required'));
        $dag_no=$jsonArray->dag_no;
        if(isset($jsonArray->dag_no) && $jsonArray->dag_no == '' || !isset($jsonArray->dag_no))
            $error[]=(array('responseType' => 1,'message' => 'dag_no is required'));

        $nocno=$jsonArray->nocno;
        if(isset($jsonArray->nocno) && $jsonArray->nocno == '' || !isset($jsonArray->nocno))
            $error[]=(array('responseType' => 1,'message' => 'nocno is required'));

        $deed_no=$jsonArray->deed_no;
        if(isset($jsonArray->deed_no) && $jsonArray->deed_no == '' || !isset($jsonArray->deed_no))
            $error[]=(array('responseType' => 1,'message' => 'deed_no is required'));

        $deed_type=$jsonArray->deed_type;
        if(isset($jsonArray->deed_type) && $jsonArray->deed_type == '' || !isset($jsonArray->deed_type))
            $error[]=(array('responseType' => 1,'message' => 'deed type is required'));

        $dag_area_b=$jsonArray->dag_area_b;
        if(isset($jsonArray->dag_area_b) && $jsonArray->dag_area_b == '' || !isset($jsonArray->dag_area_b))
            $error[]=(array('responseType' => 1,'message' => 'dag_area_b is required'));

        $dag_area_k=$jsonArray->dag_area_k;
        if(isset($jsonArray->dag_area_k) && $jsonArray->dag_area_k == '' || !isset($jsonArray->dag_area_k))
            $error[]=(array('responseType' => 1,'message' => 'dag_area_k is required'));

        $dag_area_lc=$jsonArray->dag_area_lc;
        if(isset($jsonArray->dag_area_lc) && $jsonArray->dag_area_lc == '' || !isset($jsonArray->dag_area_lc))
            $error[]=(array('responseType' => 1,'message' => 'dag_area_lc is required'));

        if(in_array($dist_code, json_decode(BARAK_VALLEY)))
        {
            $dag_area_g = $jsonArray->dag_area_g;
            if(isset($jsonArray->dag_area_g) && $jsonArray->dag_area_g == '' || !isset($jsonArray->dag_area_g))
                $error[]=(array('responseType' => 1,'message' => 'dag_area_g is required'));
        }
        else
        {
            $dag_area_g = 0;
        }

        $reg_to_name=$jsonArray->partydetails->reg_to_name;
        if(isset($jsonArray->partydetails->reg_to_name) && $jsonArray->partydetails->reg_to_name == '' || !isset($jsonArray->partydetails->reg_to_name))
            $error[]=(array('responseType' => 1,'message' => 'reg_to_name is required'));

        $reg_from_name=$jsonArray->partydetails->reg_from_name;
        if(isset($jsonArray->partydetails->reg_from_name) && $jsonArray->partydetails->reg_from_name == '' || !isset($jsonArray->partydetails->reg_from_name))
            $error[]=(array('responseType' => 1,'message' => 'reg_from_name is required'));

        $name_of_sro=$jsonArray->name_of_sro;
        if(isset($jsonArray->name_of_sro) && $jsonArray->name_of_sro == '' || !isset($jsonArray->name_of_sro))
            $error[]=(array('responseType' => 1,'message' => 'name_of_sro is required'));

        $deed_value=$jsonArray->deed_value;
        if(isset($jsonArray->deed_value) && $jsonArray->deed_value == '' || !isset($jsonArray->deed_value))
            $error[]=(array('responseType' => 1,'message' => 'deed_value is required'));

        $date_of_deed=$jsonArray->date_of_deed;
        if(isset($jsonArray->date_of_deed) && $jsonArray->date_of_deed == '' || !isset($jsonArray->date_of_deed))
            $error[]=(array('responseType' => 1,'message' => 'date_of_deed is required'));


        if($error){
            echo json_encode($error);
            return;
        }

        $user_code_row = $this->db->query("select user_code from loginuser_table where 
                                     dist_code='$dist_code'
                                     and subdiv_code='$subdiv_code' and cir_code='$cir_code'
                                     and user_code like 'CO%' and dis_enb_option='E' ");
        $user_code = $user_code_row->row();
        if(empty($user_code))
        {
            log_message('error', 'users-co'.$user_code->user_code."QUERY".$this->db->last_query());
        }

        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag_no,
            'deed_type' => $deed_type,
            'patta_type_code' => $patta_type_code,
            'patta_no' => trim($patta_no),
            'dag_area_b' => $dag_area_b,
            'dag_area_k' => $dag_area_k,
            'dag_area_lc' => $dag_area_lc,
            'dag_area_g' => $dag_area_g,
            'dag_area_kr' => 0,
            'reg_to_name' => $reg_to_name,
            'reg_from_name' => $reg_from_name,
            'name_of_sro' => $name_of_sro,
            'deed_no' => $deed_no,
            'deed_value' => $deed_value,
            'date_of_deed' => date('Y-m-d H:i:sP', strtotime($date_of_deed)),
            'user_code' => $user_code->user_code,
            'operation' => 'E',
            'status' => 0,
            'sro_code' =>$sro_code,
            'update_date' => date('Y-m-d G:i:s'),
            'nocno' => $nocno,
            'user_name' => $name_of_sro,
            'ipaddress' =>$jsonArray->ipaddress,
            'ngdrs'=>'Y'

        );

        if(isset($jsonArray->utility) || count($jsonArray->utility)>0)
            {
              $utility = 'Y';
              $utility_json = json_encode($jsonArray->utility);
            }
            else
            {
              $utility = null;
              $utility_json = null;
            }
        $data['utility']=$utility;
        $data['utility_json']=$utility_json;

        $count = $this->db->query("select * from  sro_note where
                deed_no=? and dist_code=?
                and subdiv_code=? and cir_code=? and sro_code=? and nocno = ?",array($deed_no,$dist_code,$subdiv_code,$cir_code,$sro_code,$nocno));
        if ($count->num_rows() == 0) 
        {
            $data1 = $this->db->insert('sro_note', $data);


            $primary=[
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'deed_no'=>$deed_no,
                    'nocno' => $nocno,
                ];
                if (isset($jsonArray->utility) && is_array($jsonArray->utility)) 
                {
                foreach($jsonArray->utility as $cons)
                {
                    $consumer=[
                        'consumer_no'=>$cons->consumer_no,
                        'holding_no' => $cons->holding_no,
                        'patta_type_code'=>$cons->patta_type_code,
                        'unique_vill_code'=>$cons->unique_vill_code,
                        'date_of_update'=>date('Y-m-d G:i:s'),
                        'dag_no'=>$cons->dag,
                        'patta_no'=>$cons->patta_no,
                    ];
                    $base=array_merge($primary,$consumer);
                    if (isset($cons->buyers) && is_array($cons->buyers)) {
                             foreach($cons->buyers as $buyer)
                              {
                                  $data_util1 = array(
                                    'name'=>$buyer->name,
                                    'ngdrs_id'=>$buyer->ngdrs_id,
                                    'mobile'=>$buyer->mobile,
                                    'guard_name' => $buyer->father_name,
                                    'consumer_type'=>'B',
                                  );
                                  $data1 = $this->db->insert('sronote_apdcl_gmc', array_merge($base,$data_util1));
                                  if($data1 != 1)
                                  {
                                    $this->db->trans_rollback();  
                                    log_message("error"," #APDCLGMC001 could not insert sronote_apdcl_gmc deed_no: ".$deed_no);
                                    return;
                                  }
                              }
                          }
                          if (isset($cons->sellers) && is_array($cons->sellers)) {
                              foreach($cons->sellers as $seller)
                              {
                                  $data_util2 = array(
                                    'name'=>$seller->name,
                                    'ngdrs_id'=>$seller->ngdrs_id,
                                    'mobile'=>$seller->mobile,
                                    'consumer_type'=>'S',
                                  );
                                  $data2 = $this->db->insert('sronote_apdcl_gmc', array_merge($base,$data_util2));
                                  if($data2 != 1)
                                  {
                                    $this->db->trans_rollback();  
                                    log_message("error"," #APDCLGMC002 could not insert sronote_apdcl_gmc deed_no: ".$deed_no);
                                    return;
                                  }
                              }
                          }
                    }
                }

            if($data1==false or $data1!=1)
            {
                echo json_encode(array('responseType'=>2,
                    'text'=> 'Data not updated',
                    'deed_no' => $deed_no
                ));
                return;
            }
        }
        echo json_encode(array('responseType'=>4,
            'text'=> 'Data updated',
            'deed_no' => $deed_no
        ));
    }


    public function rejectedDharCompcase() 
    {
        $jsonArray = json_decode(file_get_contents('php://input'), true);
        $error=array();
        $dist_code=$jsonArray['dist_code'];
        if(isset($jsonArray['dist_code']) && $jsonArray['dist_code'] == '' || !isset($jsonArray['dist_code']))
        {
            log_message('error',"composite####------".json_encode($jsonArray));
            echo json_encode(array('responseType' => 1,'message' => 'distcode is required'));
            return;
        }
        $this->dbswitch($dist_code);

        $noc_no=$jsonArray['noc_no'];
        if(isset($jsonArray['noc_no']) && $jsonArray['noc_no'] == '' || !isset($jsonArray['noc_no']))
            $error[]=(array('responseType' => 1,'message' => 'noc no is required'));

        $remarks=$jsonArray['remarks'];
        if(isset($jsonArray['remarks']) && $jsonArray['remarks'] == '' || !isset($jsonArray['remarks']))
            $error[]=(array('responseType' => 1,'message' => 'Remark is required'));

        $date_of_reject=$jsonArray['date_of_reject'];
        if(isset($jsonArray['date_of_reject']) && $jsonArray['date_of_reject'] == '' || !isset($jsonArray['date_of_reject']))
            $error[]=(array('responseType' => 1,'message' => 'Rejection date is required'));

        $user_code=$jsonArray['user_code'];
        if(isset($jsonArray['user_code']) && $jsonArray['user_code'] == '' || !isset($jsonArray['user_code']))
            $error[]=(array('responseType' => 1,'message' => 'User code is required'));

        if($error)
        {
            echo json_encode($error);
            return;
        }

        $sql = "select dist_code,subdiv_code,cir_code,case_no,noc_no from petition_basic where status = ? and comp_serv_yn = ? and noc_no = ?";
        $res = $this->db->query($sql, array('P', 'Y', $noc_no));
       // echo $this->db->last_query();exit;
        $data['cases'] = array();
        if ($res->num_rows() > 0) 
        {
            $data = $res->row();
            $this->db->trans_begin();

            $proceeding_id = $this->db->query("select count(proceeding_id)+1 as pid from    petition_proceeding where case_no='$data->case_no'")->row()->pid;
            if ($proceeding_id == null) 
            {
                $proceeding_id = 1;
            }

            $array = [
                'status' => 'D',
                'order_passed' => 'Y',
                'remarks' => $remarks,
                'date_of_order' => $date_of_reject,
            ];

            $proceeding = array(
                'case_no' => $data->case_no,
                'proceeding_id' =>  $proceeding_id,
                'date_of_hearing' => $date_of_reject,
                'co_order' => $remarks,
                'next_date_of_hearing' => null,
                'status' => '0',
                'user_code' => $user_code,
                'date_entry' => $date_of_reject,
                'operation' => 'E',
                'dist_code' => $data->distcode,
                'subdiv_code' => $data->subcode,
                'cir_code' => $data->circode,
            ); 
            
            $proceeding1 = $this->db->insert('petition_proceeding', $proceeding);
            if ($proceeding1 == false) 
            {
            $this->db->trans_rollback();
            log_message("error", "##AUTOM001222. Unable to save data into 
                        petition_proceeding. case no. $data->case_no");
            echo json_encode(array('responseType'=>1,
            'message'=> 'Data not updated in petition_proceeding'));
            exit;
            }

            $this->db->where(['case_no' => $data->case_no]);
            $this->db->update('petition_basic', $array);

            if ($this->db->affected_rows() != 1) 
            {
            $this->db->trans_rollback();
            log_message("error", " #ERRJB00002: Updation failed in petition_basic 
            for case no: " . $data->case_no);
            echo json_encode(array('responseType'=>1,
            'message'=> 'Data not updated in petition_basic'));
            }

            else
            {
                $this->db->trans_commit();
                echo json_encode(array('responseType'=>2,
                'message'=> 'Data updated'));
            }
        }

        else
        {
            echo json_encode(array('responseType'=>1,
            'message'=> 'Data not found in petition_basic'));
        }
    }


    function sroreplyApi()
     {

        $dharitree=$this->input->post('case_no');

        if(isset($dharitree) && $dharitree == '' || !isset($dharitree)){
            log_message('error',"NGDRS####------".json_encode($dharitree));
            echo json_encode(array('responseType' => 1,'message' => 'Case no is required'));
            exit;
        }
        $dist_code = $this->input->post('dist_code');
        if(isset($dist_code) && $dist_code == '' || !isset($dist_code)){
            log_message('error',"NGDRS####------".json_encode($dist_code));
            echo json_encode(array('responseType' => 1,'message' => 'Dist code is required'));
            exit;
        }

        $location = $this->input->post('location');
        if(isset($location) && $location == '' || !isset($location)){
            log_message('error',"NGDRS####------".json_encode($location));
            echo json_encode(array('responseType' => 1,'message' => 'Location is required'));
            exit;
        }

        $loc = explode("_", $location);
        $subdiv_code = $loc[1];
        $cir_code = $loc[2];
        $mouza_pargona_code = $loc[3];
        $lot_no = $loc[4];
        $vill_townprt_code = $loc[5];


        $slno = $this->input->post('slno');
        if(isset($slno) && $slno == '' || !isset($slno)){
            log_message('error',"NGDRS####------".json_encode($slno));
            echo json_encode(array('responseType' => 1,'message' => 'Sl no is required'));
            exit;
        }
        $remark = $this->input->post('remark');
        if(isset($remark) && $remark == '' || !isset($remark)){
            log_message('error',"NGDRS####------".json_encode($remark));
            echo json_encode(array('responseType' => 1,'message' => 'Remark is required'));
            exit;
        }
        $date_of_update = $this->input->post('date_of_update');

        $sro_code = $this->input->post('sro');
        if(isset($sro_code) && $sro_code == '' || !isset($sro_code)){
            log_message('error',"NGDRS####------".json_encode($sro_code));
            echo json_encode(array('responseType' => 1,'message' => 'SRO Code is required'));
            exit;
        }
        $is_deed_valid = $this->input->post('is_deed_valid');
        if(isset($is_deed_valid) && $is_deed_valid == '' || !isset($is_deed_valid)){
            log_message('error',"NGDRS####------".json_encode($is_deed_valid));
            echo json_encode(array('responseType' => 1,'message' => 'SIs valid flag is required'));
            exit;
        }

        //var_dump($subdiv_code);exit;

        $this->dbswitch($dist_code);
        $sql = $this->db->query("select * from sro_push_history where case_no =? and dist_code = ? and subdiv_code = ? and cir_code = ? and mouza_pargona_code = ? and lot_no = ? and vill_townprt_code = ? and slno = ? ",array($dharitree,$dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$vill_townprt_code,$slno));

        $swl = $sql->row();

        if($sql->num_rows()<=0)
        {
            echo json_encode(array('responseType'=>1,
                'text'=> 'No Data Found'));
                exit;
        }

        else
        {
            $update_history = array(
                'sro_code' => $sro_code,
                'remark' => $remark,
                'action' => 'Y',
                'is_deed_valid' => $is_deed_valid,
                'date_of_update' => $date_of_update
            );

            $this->db->where('case_no',$dharitree);
            $this->db->where('slno',$slno);
            $this->db->where('dist_code',$dist_code);
            $this->db->update('sro_push_history',$update_history);
            //echo $this->db->last_query();exit;

            if($this->db->affected_rows()==0)
            {
                echo json_encode(array('responseType'=>1,
                'text'=> 'Data Not updated'));
                exit;
            }

            else
            {
                
                echo json_encode(array('responseType'=>2,
                'text'=> 'Data updated'));
                exit;
            }
        }
    }
    function deedviewNgdrsApi()
    {
        $dharitree=$this->input->post('case_no');
        if(isset($dharitree) && $dharitree == '' || !isset($dharitree)){
            log_message('error',"NGDRS####------".json_encode($dharitree));
            echo json_encode(array('responseType' => 1,'message' => 'Case no is required'));
            exit;
        }

        $dist_code = $this->input->post('dist_code');
        if(isset($dist_code) && $dist_code == '' || !isset($dist_code)){
            log_message('error',"NGDRS####------".json_encode($dist_code));
            echo json_encode(array('responseType' => 1,'message' => 'Dist code is required'));
            exit;
        }

        // for tgpp cases only
        $arr = explode('/',$dharitree);
        if($arr[4] == 'TGPP')
        {
            $dharDb = $this->dbswitch($dist_code);           
            $this->load->model('TeaGrant/LM/TeaGrantModel');
            $output = $this->TeaGrantModel->viewDalilUploadedByLra($dharDb, $dharitree);
            log_message("error", "viewDalilUploadedByLra : ".json_encode($output));

            if($output['status'] == 'y')
            {
                echo $output['response'];
            }
        }
        else
        {
            $this->dbswitch($dist_code);
            $sql = $this->db->query("select * from basundhar_application where dharitree=?",array($dharitree))->row();

            $basundhara = $sql->basundhara;

            if($basundhara)
            {
                $url = RTPS_API_LINK."viewuploadedDeedfile?case=" . $basundhara;
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  2);
                $output = curl_exec($ch);
                //var_dump($output);exit;
                curl_close($ch);
               // $output = json_decode($output);
                //var_dump($output->data);exit;

                echo $output;  
                // $pdf_decoded = base64_decode($output->data);
                //    header('Content-Type: application/pdf');
                //    echo $pdf_decoded;   
            }
            else
            {
              return false;
            }
        }
    }


    function authLocation(){
        $this->db=$this->load->database('auth',true);
        $sql="Select 
        concat(dist_code ||'_'|| subdiv_code ||'_'|| cir_code ||'_'||mouza_pargona_code||'_'||lot_no||'_'||vill_townprt_code) gis_code,
        (Select loc_name||'-'||locname_eng from location where dist_code =t.dist_code and subdiv_code='00') as district_name,
        (Select loc_name||'-'||locname_eng from location where dist_code =t.dist_code and subdiv_code=t.subdiv_code and cir_code=t.cir_code and mouza_pargona_code='00') as circle_name
        , * from location t where vill_townprt_code<>'00000' ";
        $data=$this->db->query($sql)->result_array();
        foreach($data as $row){
            ////////////////
            $chitha="select count(*) from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=?";
            $chithaRows=$this->db->query($chitha,array($row['dist_code'],$row['subdiv_code'],$row['cir_code'],$row['mouza_pargona_code'],$row['lot_no'],$row['vill_townprt_code']))->num_rows();
            ///////////////
            $response=$this->apiForMap($gis_code);
            $decode_response=json_decode($response);
            $final_response[]=
            [
                'district'=>$row['district_name'],
                'circle'=>$row['circle_name'],
                'village'=>$row['loc_name'].'-'.$row['locname_eng'],
                'lgd_code'=>$row['lgd_code'],
                'map_available'=>$decode_response[0]->mapPresent,
                'plot_count_bhunaksha'=>$decode_response[0]->plotCount,
                'plot_in_ror'=>$chithaRows
            ];
        }
        echo json_encode($final_response);
    }
    function apiForMap($gis_code){
         $curl = curl_init();
         curl_setopt_array($curl, array(
          CURLOPT_URL => 'https://landhub.assam.gov.in/api/index.php/NicApi/getMapStatus',
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 60,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS =>'{
            "gis_code":"'.$gis_code.'"
        }',
          CURLOPT_HTTPHEADER => array(
            'Content-Type: application/json'
          ),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function ReclassSuiteCo()
    {
        $post_data = $this->input->post();
        // if (!isset($post_data['dist_code']) || !isset($post_data['application_no'])) {
        //     $response = [
        //         'status' => false,
        //         'message' => 'Required parameters are missing: dist_code or application_no',
        //     ];
        //     echo json_encode($response);
        //     return;
        // }
        // if (empty($dist_code) || empty($application_no)) {
        //     $response = [
        //         'status' => false,
        //         'message' => 'dist_code or application_no cannot be empty',
        //     ];
        //     echo json_encode($response);
        //     return;
        // }
        $ref_dist_code = $post_data['dist_code'];
        $application_no = $post_data['application_no'];
        $this->db=$this->dbswitch($ref_dist_code);

        $this->load->model('basundhara3/reclassModel');
        $this->load->model('SettlementModel/SettlementCommonModel');

        $basic                 = $this->reclassModel->getSettlementBasic($application_no);
        $applicants_buyers     = $this->reclassModel->getAllApplicantBuyers($application_no);
        $applicants_owners     = $this->reclassModel->getAllApplicantOwners($application_no);

        $applicants_dag_details= $this->reclassModel->getAllApplicantDagDetails($application_no);

        $lmdata        = [];

        $dags          = $this->reclassModel->getSettlementDag($application_no);
        $lmnotes       = $this->reclassModel->getSettlementTenantLmNote($application_no);
        $proceedings   = $this->reclassModel->getSettlementProceeding($application_no);
        $dhardocuments = $this->reclassModel->getDocuments($application_no);
        $nominee       = $this->reclassModel->getAllNomineeDetail($application_no);
        $existing_pattadar = $this->reclassModel->getAllExistingPattadar($application_no);
        $deed_applicant= '';//$this->reclassModel->getAllDeedPattadar($application_no);
        $family_tree   = '';//$this->reclassModel->getAllFamilyTree($application_no);

        $lmdata['basic']             = $basic;
        $lmdata['nominee']           = $nominee;
        $lmdata['applicants_buyers'] = $applicants_buyers;
        $lmdata['applicants_owners'] = $applicants_owners;

        $lmdata['existing_pattadar'] = $existing_pattadar;
        $lmdata['deed_applicant']    = $deed_applicant;
        $lmdata['family_tree']       = $family_tree;
        $lmdata['applicants_dag_details'] = $applicants_dag_details;

        $lmdata['checkAdditionalProperty'] = '';//$this->SettlementCommonModel->activeAdditionalPropertyDetailByCase($application_no)->result();

        $applid = $this->utilityclass->getApplidFromCaseNoReclass($application_no);

        // foreach($lmdata['applicants_buyers'] as $adhar_photo):
        //   if($adhar_photo->is_applicant == 1):
        //     if (trim($adhar_photo->identity_type) == 'AADHAAR'):
        //       $adhar_photo_link = $adhar_photo->identity_doc_link;
        //       if(!file_exists($adhar_photo_link))
        //       {
        //           //****Directory Change */
        //           $parts = explode("uploads/", $adhar_photo_link, 2);
        //           if (count($parts) > 1) {
        //               $path = BACKUP_DIR."uploads/" . $parts[1];
        //           }
        //           else
        //           {
        //               $path = $adhar_photo_link;
        //           }

        //           if(!file_exists($path))
        //           {
        //               $url = API_LINK_MB2."getApplicantPhoto";
        //               $arrayData =array(
        //                   'application_no' => $applid,
        //               );
        //               //*****API call again for aadhar photo missing */
        //               $aadhaarPhotoReCall = $this->utilityclass->curlPost($url, $arrayData);

        //               if($aadhaarPhotoReCall == true)
        //               {
        //                   $aadhar_path = $adhar_photo_link;
        //                   $aadhaar_file_to_write_base64 = fopen($aadhar_path, "w") or die("Unable to open file!");
        //                   $aadhaar_encoded_file = $aadhaarPhotoReCall;
        //                   fwrite($aadhaar_file_to_write_base64, $aadhaar_encoded_file);
        //                   fclose($aadhaar_file_to_write_base64);
        //               }
        //               else
        //               {
        //                   echo json_encode(array('ERROR885784: API Response fail!'));
        //                   return false;
        //               }
        //           }
        //           else
        //           {
        //               $adhar_photo_link = $path;
        //           }
        //       }
        //       //**********reopening the updated file */
        //       $open_adhar_file = fopen($adhar_photo_link, "r") or die("Unable to open file!");
        //       $read_adhar_file = fread($open_adhar_file, filesize($adhar_photo_link));
        //       fclose($open_adhar_file);
        //       // decoding the base64 encoding file variable
        //       $lmdata['base64_decoded_adhar_file'] = "<img src = data:".$this->decodeBase64($read_adhar_file).";base64,".$read_adhar_file." class='img-thumbnail' alt='Adhar Photo' width='170' height='200'>";
        //     endif;
        //   endif;
        // endforeach;


        //****getting tribe cat and under tribal belt data from backup */
        $getJsonBackup = $this->reclassModel->getJsonDataFromBackup($application_no);


        $lmdata['dags']          = $dags;
        $lmdata['lmnotes']       = $lmnotes;
        $lmdata['proceedings']   = $proceedings;
        $lmdata['dhardocuments'] = $dhardocuments;

        $premium_data = $this->db->query("SELECT sp.*,spa.area,spl.land_type,spr.house_type,spr.rate_type as ratetype FROM settlement_premium sp inner join settlement_premium_area spa on spa.paid=sp.area_name inner join settlement_premium_land_type spl on spl.plid=sp.land_type inner join settlement_premium_rate spr on spr.prid=sp.rate_type where case_no='$application_no' and is_final=1")->result();
        $lmdata['premium_data'] = $premium_data;


        $lmdata['premium']     = $this->SettlementCommonModel->getPremium($application_no);
        $lmdata['reservation'] = null;//$this->SettlementVgrModel->getSettlementReservation($application_no);
        $lmdata['additional_property'] = $this->reclassModel->getAdditionalProperty($application_no);
        //********check if SDO exist for that area */
        /*
        $headQtrCheck = $this->SettlementCommonModel->headquarterCheck($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));
        if(trim($headQtrCheck) != 'Y'){

          $sdoCheckResult = $this->SettlementCommonModel->userCheckSDO($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'));

          if(trim($sdoCheckResult) == 'y'){
            $lmdata['sdo_user_check'] = trim($sdoCheckResult);
          }
          else
          {
            $lmdata['sdo_user_check'] = 'No SDO created for this location...';
          }
        }
        else
        {
          $lmdata['sdo_user_check'] = 'y';
        }
        */
        $areaModificationCheck = $this->SettlementCommonModel->checkIfAreaModified($application_no);

        if(isset($areaModificationCheck)){
            if($areaModificationCheck){
                foreach($areaModificationCheck as $areaHis){
                    $applied_area_home_bigha = $areaHis->applied_area_home_bigha;
                    $applied_area_home_katha = $areaHis->applied_area_home_katha;
                    $applied_area_home_lessa = $areaHis->applied_area_home_lessa;
                    $applied_area_home_ganda = $areaHis->applied_area_home_ganda;
                    $applied_area_home_kranti = $areaHis->applied_area_home_kranti;

                    $applied_area_agri_bigha = $areaHis->applied_area_agri_bigha;
                    $applied_area_agri_katha = $areaHis->applied_area_agri_katha;
                    $applied_area_agri_lessa = $areaHis->applied_area_agri_lessa;
                    $applied_area_agri_ganda = $areaHis->applied_area_agri_ganda;
                    $applied_area_agri_kranti = $areaHis->applied_area_agri_kranti;


                    $settlement_area_home_bigha = $areaHis->settlement_area_home_bigha;
                    $settlement_area_home_katha = $areaHis->settlement_area_home_katha;
                    $settlement_area_home_lessa = $areaHis->settlement_area_home_lessa;
                    $settlement_area_home_ganda = $areaHis->settlement_area_home_ganda;
                    $settlement_area_home_kranti = $areaHis->settlement_area_home_kranti;

                    $settlement_area_agri_bigha = $areaHis->settlement_area_agri_bigha;
                    $settlement_area_agri_katha = $areaHis->settlement_area_agri_katha;
                    $settlement_area_agri_lessa = $areaHis->settlement_area_agri_lessa;
                    $settlement_area_agri_ganda = $areaHis->settlement_area_agri_ganda;
                    $settlement_area_agri_kranti = $areaHis->settlement_area_agri_kranti;


                    if (in_array($ref_dist_code, json_decode(BARAK_VALLEY))) {

                        $total_applied_area_home_in_ganda = $this->utilityclass->Total_ganda($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa, $applied_area_home_ganda);
                        $total_applied_area_agri_in_ganda = $this->utilityclass->Total_ganda($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa, $applied_area_agri_ganda);
                        $total_settlement_area_home_in_ganda = $this->utilityclass->Total_ganda($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa, $settlement_area_home_ganda);
                        $total_settlement_area_agri_in_ganda = $this->utilityclass->Total_ganda($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa, $settlement_area_agri_ganda);

                        if(($total_applied_area_home_in_ganda != $total_settlement_area_home_in_ganda) || ($total_applied_area_agri_in_ganda != $total_settlement_area_agri_in_ganda)){

                            $lmdata['area_modified'] = $areaModificationCheck;
                        }

                    }
                    else
                    {
                        $total_applied_area_home_in_lessa = $this->utilityclass->Total_Lessa($applied_area_home_bigha, $applied_area_home_katha, $applied_area_home_lessa);
                        $total_applied_area_agri_in_lessa = $this->utilityclass->Total_Lessa($applied_area_agri_bigha, $applied_area_agri_katha, $applied_area_agri_lessa);
                        $total_settlement_area_home_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_home_bigha, $settlement_area_home_katha, $settlement_area_home_lessa);
                        $total_settlement_area_agri_in_lessa = $this->utilityclass->Total_Lessa($settlement_area_agri_bigha, $settlement_area_agri_katha, $settlement_area_agri_lessa);
                        //check if area modified
                        if(($total_applied_area_home_in_lessa != $total_settlement_area_home_in_lessa) || ($total_applied_area_agri_in_lessa != $total_settlement_area_agri_in_lessa)){

                            $lmdata['area_modified'] = $areaModificationCheck;
                        }
                    }
                }
            }
        }

        $checkAreaDetails = '';//$this->chithaAreaCheckWithCaseNo($application_no);

        $lmdata['chithaArea']   = '';//$checkAreaDetails['chithaArea'];
        $lmdata['reservedArea'] = '';//$checkAreaDetails['reservedArea'];
        $lmdata['areaCheck']    = '';//$checkAreaDetails['areaCheck'];
        $lmdata['appliedDags']  = '';//$checkAreaDetails['appliedDags'];
        $lmdata['lmProcessArea']= '';//$checkAreaDetails['lmProcessArea'];

        // for guardian relation
        $query_for_guar_rel = "SELECT * from master_guard_rel WHERE id NOT IN ('5','6')";
        $relation_executation = $this->db->query($query_for_guar_rel);
        $row = $relation_executation->num_rows;
        if ($row != 0) {
          $lmdata['guar_rel'] = $relation_executation->result();
        }

        $lmdata['basic_status'] = $this->SettlementCommonModel->getCurrentBasicStatus($application_no);

        $lmdata['user_desig_code'] = null;//$this->session->userdata('user_desig_code');
        $lmdata['co_name']= $this->SettlementCommonModel->getCoName($basic['dist_code'], $basic['subdiv_code'], $basic['cir_code']);

        //*******getting the deleted settlement_dag_details data from settlement_deleted_data table */
        $deletedEnc=$this->SettlementCommonModel->getDeletedEncroacher($application_no);
        $deletedEncArray = array();
        foreach($deletedEnc as $encroacherDeleted_data)
        {
          $deletedEncArray[] = json_decode($encroacherDeleted_data->table_data);
        }
        $lmdata['deleted_encroacher'] = $deletedEncArray;

        //***********getting the settlement_applicant occupiers data from settlement_deleted_data table */
        $deletedDags=$this->SettlementCommonModel->getDeletedDags($application_no);
        $deletedData = array();
        foreach($deletedDags as $deleteDag){
          $deletedData[] = json_decode($deleteDag->table_data);
        }
        $lmdata['deleted_dags'] = $deletedData;

        $rejected_data = $this->SettlementCommonModel->getRejectModal(TEA_SERVICE_CODE);
        if($rejected_data == 'n')
        {
          $lmdata['rejected_list'] = false;
        }
        else
        {
          $lmdata['rejected_list'] = $rejected_data;
        }


        foreach(json_decode(VALIDATION_BYPASS) as $val_bypas)
        {
          if($val_bypas->SERVICE_CODE == TEA_SERVICE_CODE)
          {
            $const_bypass_arr_code = $val_bypas->REJECTED_CODE;
          }
        }

        $lmdata['validation_bypass'] = 0;

        foreach($lmdata['lmnotes'] as $lm_rr)
        {
          $decoded_r = json_decode($lm_rr->lm_rejected_remarks);

          if($decoded_r){
            foreach($decoded_r as  $lm_rejected_code)
            {
              if(isset($lm_rejected_code->reject_code))
              {
                if(in_array($lm_rejected_code->reject_code, $const_bypass_arr_code)){
                  $lmdata['validation_bypass'] = 1;
                }
              }
              else
              {
                if(in_array($lm_rejected_code, $const_bypass_arr_code)){
                  $lmdata['validation_bypass'] = 1;
                }
              }
            }
          }
        }

        $lmdata['reject_list_type'] = '';

        foreach($lmnotes as $r_remark)
        {
          $rejected_list_json = json_decode($r_remark->lm_rejected_remarks);

          if($rejected_list_json)
          {
            foreach ($rejected_list_json as $re_list)
            {
              if(isset($re_list->reject_code))
              {
                $r_code = $re_list->reject_code;
              }
              else
              {
                $r_code = $re_list;
              }

              $sql = $this->db->query("select remark_head from reject_master where reject_code = ?", array($r_code));

              if($sql->row()->remark_head != null)
              {
                $lmdata['reject_list_type'] = 'new';
              }
              else
              {
                $lmdata['reject_list_type'] = 'old';
              }
            }
          }
        }
        echo $viewContent = $this->load->view('reclass_suite/co/ReclassSuiteCoViewApi', $lmdata, TRUE);
    }


    // api for inserting location by caseno for escalation
    public function apiForLocationEntry()
    {
      // get all from escalation_details
      $escalationCases = $this->db->query("SELECT * FROM escalation_details")->result();

      if(!empty($escalationCases))
      {
        foreach($escalationCases as $r)
        {
          $case_no = $r->case_no;

          // get location detail from table
          $serviceTable = $this->serviceTableName($case_no);

          if($serviceTable == 'allotment_cert_basic')
          {
            $cir_code = $r->circle_code;
          }
          else
          {
            $cir_code = $r->cir_code;
          }

          // get rtps application no
          $rtps_no = $this->getBasundharaApplNo($case_no);

          $dist_name = $this->db->query("SELECT loc_name, locname_eng FROM location WHERE dist_code=? AND subdiv_code=? AND 
                        cir_code=? AND mouza_pargona_code=? AND vill_townprt_code=? AND lot_no=?", 
                          array($r->dist_code, '00', '00', '00', '00000', '00'))->row();

          $cir_name = $this->db->query("SELECT loc_name, locname_eng FROM location WHERE dist_code=? AND subdiv_code=? AND 
                        cir_code=? AND mouza_pargona_code=? AND  vill_townprt_code=? AND lot_no=?", 
                          array($r->dist_code, $r->subdiv_code, $cir_code, '00', '00000', '00'))->row();

          $vill_name = $this->db->query("SELECT loc_name, locname_eng FROM location WHERE dist_code=? AND subdiv_code=? AND 
                        cir_code=? AND mouza_pargona_code=? AND  vill_townprt_code=? AND lot_no=?", 
                          array($r->dist_code, $r->subdiv_code, $cir_code, $r->mouza_pargona_code, $r->vill_townprt_code, 
                            $r->lot_no))->row();


          // check if data already inserted
          $dataExist = $this->db->query("SELECT * FROM escalation_location WHERE case_no=?", array($case_no));

          if($dataExist->num_rows() == 0)
          {
            // insert into escalation_location table
            $ins = [
              'case_no'        => $case_no,
              'application_no' => $rtps_no,
              'service_code'   => $r->service_code,
              'dist_code'      => $r->dist_code,
              'subdiv_code'    => $r->subdiv_code,
              'cir_code'       => $cir_code,
              'mouza_code'     => $r->mouza_pargona_code,
              'lot_no'         => $r->lot_no,
              'vill_code'      => $r->vill_townprt_code,
              'dist_name_asm'  => $dist_name->loc_name,
              'cir_name_asm'   => $cir_name->loc_name,
              'vill_name_asm'  => $vill_name->loc_name,
              'dist_name_eng'  => $dist_name->locname_eng,
              'cir_name_eng'   => $cir_name->locname_eng,
              'vill_name_eng'  => $vill_name->locname_eng,
              'created_date'   => date('Y-m-d H:i:s'),
            ];
            $insert = $this->db->insert('escalation_location', $ins);
            if($insert != 1)
            {
              log_message("error","#apiForLocationEntry2546: Insertion failed in escalation_location table ".$this->db->last_query());
              echo "Insertion failed for case_no $case_no";
              continue;
            }
          }
          else
          {
            echo "Data already available for case no $case_no";
            continue;
          }
        }
      }
      else
      {
        echo "No data available to insert !!!!";
      }            
    }

    // get application no from basundhar_application
    protected function getBasundharaApplNo($case_no)
    {
      return $basundhara = $this->db->query("SELECT basundhara FROM basundhar_application WHERE dharitree=?", 
                              array($case_no))->row()->basundhara;
    }

    protected function getServiceType($case_no)
    {
      $get_case_no = explode('/', $case_no);
      return $get_type = $get_case_no[4];
    }

    // table service wise table
    protected function serviceTableName($case_no)
    {
      $service_type = $this->getServiceType($case_no);

      if($service_type == 'FMUT' || $service_type == 'FPART')
      {
        $table = 'field_mut_basic';
      }
      else if($service_type == 'OMUT' || $service_type == 'OPART' || $service_type == 'CONV')
      {
        $table = 'petition_basic';
      }
      else if($service_type == 'RECLASS')
      {
        $table = 't_reclassification';
      }
      else if($service_type == 'ACPP')
      {
        $table = 'allotment_cert_basic';
      }
      else if($service_type == 'MiNC' || $service_type == 'MiND')
      {
        $table = 'misc_case_basic';
      }
      return $table;
    }

    function checkPaymentRevivalMb3(){
        $error=array();
        $dist_code=$_POST['dist_code'];
        if(isset($_POST['dist_code']) && $_POST['dist_code'] == '' || !isset($_POST['dist_code']))
            $error[]=(array('responseType' => 1,'message' => 'distcode is required'));
        $this->dbswitch($dist_code);
        $application_no=$_POST['application_no'];
        if(isset($_POST['application_no']) && $_POST['application_no'] == '' || !isset($_POST['application_no']))
            $error[]=(array('responseType' => 1,'message' => 'application no is required'));

        $service_code=$_POST['service_code'];
        if($service_code=='44')
        {
            $sql="Select * from basundhar_application where basundhara=?";
        }
        else if ($service_code=='40')
        {
            $sql="Select * from reclass_suite_basic where applid=?";
        }
        else
        {
            $sql="Select * from settlement_basic where applid=?";
        }
        

        $data=$this->db->query($sql,$application_no);
        if($data->num_rows()==0){
            echo json_encode(array('responseType'=>1,'msg'=>'No Case no found'));
            return;
        }
        echo json_encode(array('responseType'=>2,'status'=>2,'msg'=>'Successfull'));
        return;
    }




    ///post api for ngdrs to push deeds at delivery///
    public function postSronoteNGDRSAPI_manualpush() 
    {
        $postdata = json_decode($_POST['data']);//json_decode(file_get_contents('php://input'), true);
        $jsonArray = $postdata[0];
         // var_dump($jsonArray);exit;
        log_message('error',"NGDRS-API-SRONOTE####------".json_encode($postdata));
        $error=array();
        $dist_code=$jsonArray->dist_code;
        if(isset($jsonArray->dist_code) && $jsonArray->dist_code == '' || !isset($jsonArray->dist_code)){
            log_message('error',"NGDRS####------".json_encode($jsonArray));
            echo json_encode(array('responseType' => 1,'message' => 'distcode is required'));
            return;
        }
        $this->dbswitch($dist_code);
        $subdiv_code=$jsonArray->subdiv_code;
        if(isset($jsonArray->subdiv_code) && $jsonArray->subdiv_code == '' || !isset($jsonArray->subdiv_code))
            $error[]=(array('responseType' => 1,'message' => 'subdiv_code is required'));
        $cir_code=$jsonArray->cir_code;
        if(isset($jsonArray->cir_code) && $jsonArray->cir_code == '' || !isset($jsonArray->cir_code))
            $error[]=(array('responseType' => 1,'message' => 'cir_code is required'));
        $mouza_pargona_code=$jsonArray->mouza_pargona_code;
        if(isset($jsonArray->mouza_pargona_code) && $jsonArray->mouza_pargona_code == '' || !isset($jsonArray->mouza_pargona_code))
            $error[]=(array('responseType' => 1,'message' => 'mouza_pargona_code is required'));
        $lot_no=$jsonArray->lot_no;
        if(isset($jsonArray->lot_no) && $jsonArray->lot_no == '' || !isset($jsonArray->lot_no))
            $error[]=(array('responseType' => 1,'message' => 'lot_no is required'));
        $vill_townprt_code=$jsonArray->vill_townprt_code;
        if(isset($jsonArray->vill_townprt_code) && $jsonArray->vill_townprt_code == '' || !isset($jsonArray->vill_townprt_code))
            $error[]=(array('responseType' => 1,'message' => 'vill_townprt_code is required'));
        $patta_type_code=$jsonArray->pattatype;
        if(isset($jsonArray->pattatype) && $jsonArray->pattatype == '' || !isset($jsonArray->pattatype))
            $error[]=(array('responseType' => 1,'message' => 'patta_type_code is required'));
        $patta_no=$jsonArray->patta_no;
        if(isset($jsonArray->patta_no) && $jsonArray->patta_no == '' || !isset($jsonArray->patta_no))
            $error[]=(array('responseType' => 1,'message' => 'patta_no is required'));
        $sro_code=$jsonArray->sro_code;
        if(isset($jsonArray->sro_code) && $jsonArray->sro_code == '' || !isset($jsonArray->sro_code))
            $error[]=(array('responseType' => 1,'message' => 'sro_code is required'));
        $dag_no=$jsonArray->dag_no;
        if(isset($jsonArray->dag_no) && $jsonArray->dag_no == '' || !isset($jsonArray->dag_no))
            $error[]=(array('responseType' => 1,'message' => 'dag_no is required'));

        $nocno=$jsonArray->nocno;

        $ngdrs=$jsonArray->ngdrs;

        if(isset($jsonArray->ngdrs) && $jsonArray->ngdrs == '' || !isset($jsonArray->ngdrs))
            $error[]=(array('responseType' => 1,'message' => 'ngdrs field is required'));

        $deed_no=$jsonArray->deed_no;
        if(isset($jsonArray->deed_no) && $jsonArray->deed_no == '' || !isset($jsonArray->deed_no))
            $error[]=(array('responseType' => 1,'message' => 'deed_no is required'));

        $deed_type=$jsonArray->deed_type;
        if(isset($jsonArray->deed_type) && $jsonArray->deed_type == '' || !isset($jsonArray->deed_type))
            $error[]=(array('responseType' => 1,'message' => 'deed type is required'));

        $dag_area_b=$jsonArray->dag_area_b;
        if(isset($jsonArray->dag_area_b) && $jsonArray->dag_area_b == '' || !isset($jsonArray->dag_area_b))
            $error[]=(array('responseType' => 1,'message' => 'dag_area_b is required'));

        $dag_area_k=$jsonArray->dag_area_k;
        if(isset($jsonArray->dag_area_k) && $jsonArray->dag_area_k == '' || !isset($jsonArray->dag_area_k))
            $error[]=(array('responseType' => 1,'message' => 'dag_area_k is required'));

        $dag_area_lc=$jsonArray->dag_area_lc;
        if(isset($jsonArray->dag_area_lc) && $jsonArray->dag_area_lc == '' || !isset($jsonArray->dag_area_lc))
            $error[]=(array('responseType' => 1,'message' => 'dag_area_lc is required'));

        if(in_array($dist_code, json_decode(BARAK_VALLEY)))
        {
            $dag_area_g = $jsonArray->dag_area_g;
            if(isset($jsonArray->dag_area_g) && $jsonArray->dag_area_g == '' || !isset($jsonArray->dag_area_g))
                $error[]=(array('responseType' => 1,'message' => 'dag_area_g is required'));
        }
        else
        {
            $dag_area_g = 0;
        }

        $reg_to_name=$jsonArray->partydetails->reg_to_name;
        if(isset($jsonArray->partydetails->reg_to_name) && $jsonArray->partydetails->reg_to_name == '' || !isset($jsonArray->partydetails->reg_to_name))
            $error[]=(array('responseType' => 1,'message' => 'reg_to_name is required'));

        $reg_from_name=$jsonArray->partydetails->reg_from_name;
        if(isset($jsonArray->partydetails->reg_from_name) && $jsonArray->partydetails->reg_from_name == '' || !isset($jsonArray->partydetails->reg_from_name))
            $error[]=(array('responseType' => 1,'message' => 'reg_from_name is required'));

        $name_of_sro=$jsonArray->name_of_sro;
        if(isset($jsonArray->name_of_sro) && $jsonArray->name_of_sro == '' || !isset($jsonArray->name_of_sro))
            $error[]=(array('responseType' => 1,'message' => 'name_of_sro is required'));

        $deed_value=$jsonArray->deed_value;
        if(isset($jsonArray->deed_value) && $jsonArray->deed_value == '' || !isset($jsonArray->deed_value))
            $error[]=(array('responseType' => 1,'message' => 'deed_value is required'));

        $date_of_deed=$jsonArray->date_of_deed;
        if(isset($jsonArray->date_of_deed) && $jsonArray->date_of_deed == '' || !isset($jsonArray->date_of_deed))
            $error[]=(array('responseType' => 1,'message' => 'date_of_deed is required'));


        if($error){
            echo json_encode($error);
            return;
        }

        $user_code_row = $this->db->query("select user_code from loginuser_table where 
                                     dist_code='$dist_code'
                                     and subdiv_code='$subdiv_code' and cir_code='$cir_code'
                                     and user_code like 'CO%' and dis_enb_option='E' ");
        $user_code = $user_code_row->row();
        if(empty($user_code))
        {
            log_message('error', 'users-co'.$user_code->user_code."QUERY".$this->db->last_query());
        }

        $data = array(
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $vill_townprt_code,
            'dag_no' => $dag_no,
            'deed_type' => $deed_type,
            'patta_type_code' => $patta_type_code,
            'patta_no' => trim($patta_no),
            'dag_area_b' => $dag_area_b,
            'dag_area_k' => $dag_area_k,
            'dag_area_lc' => $dag_area_lc,
            'dag_area_g' => $dag_area_g,
            'dag_area_kr' => 0,
            'reg_to_name' => $reg_to_name,
            'reg_from_name' => $reg_from_name,
            'name_of_sro' => $name_of_sro,
            'deed_no' => $deed_no,
            'deed_value' => $deed_value,
            'date_of_deed' => date('Y-m-d H:i:sP', strtotime($date_of_deed)),
            'user_code' => $user_code->user_code,
            'operation' => 'E',
            'status' => 0,
            'sro_code' =>$sro_code,
            'update_date' => date('Y-m-d G:i:s'),
            'nocno' => $nocno,
            'user_name' => $name_of_sro,
            'ipaddress' =>$jsonArray->ipaddress,
            'ngdrs'=> $ngdrs

        );

        if(isset($jsonArray->utility) || count($jsonArray->utility)>0)
            {
              $utility = 'Y';
              $utility_json = json_encode($jsonArray->utility);
            }
            else
            {
              $utility = null;
              $utility_json = null;
            }
        $data['utility']=$utility;
        $data['utility_json']=$utility_json;


        $get_sro_note =  $this->db->get_where('sro_note', array('dist_code' => $dist_code,
                'subdiv_code'=>$subdiv_code,
                'cir_code' => $cir_code,
                'deed_no' => $deed_no,
                'sro_code' => $sro_code
            ));

            if ($get_sro_note->num_rows() > 0) {
                $sro_note_data = $get_sro_note->result();
            }


            $this->db->trans_begin();

            $case_no = $nocno.'-'.$deed_no;


            $archive_data = $this->archive_data($case_no, 'sro_note', $sro_note_data, $dist_code);
            if($archive_data==0){
                $this->db->trans_rollback();
                echo json_encode(array('type'=>3,
                    'text'=> 'Data not updated'));
                return;
            }

            if ($archive_data > 0) {
                // delete from petition_pattadar
                $this->db->where(array('dist_code' => $dist_code, 'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'sro_code' => $sro_code,
                    'deed_no' => $deed_no,

                ));
                $delstatus=$this->db->delete('sro_note');
                if($delstatus!=1){
                    $this->db->trans_rollback();
                    echo json_encode(array('type'=>3,
                        'text'=> 'Data not updated'));
                    return;
                }
            }



        $count = $this->db->query("select * from  sro_note where
                deed_no=? and dist_code=?
                and subdiv_code=? and cir_code=? and sro_code=? and deed_no = ?",array($deed_no,$dist_code,$subdiv_code,$cir_code,$sro_code,$deed_no));
        if ($count->num_rows() == 0) 
        {
            $data1 = $this->db->insert('sro_note', $data);


            $primary=[
                    'dist_code' => $dist_code,
                    'subdiv_code' => $subdiv_code,
                    'cir_code' => $cir_code,
                    'mouza_pargona_code' => $mouza_pargona_code,
                    'lot_no' => $lot_no,
                    'vill_townprt_code' => $vill_townprt_code,
                    'deed_no'=>$deed_no,
                    'nocno' => $nocno,
                ];
                if (isset($jsonArray->utility) && is_array($jsonArray->utility)) 
                {
                foreach($jsonArray->utility as $cons)
                {
                    $consumer=[
                        'consumer_no'=>$cons->consumer_no,
                        'holding_no' => $cons->holding_no,
                        'patta_type_code'=>$cons->patta_type_code,
                        'unique_vill_code'=>$cons->unique_vill_code,
                        'date_of_update'=>date('Y-m-d G:i:s'),
                        'dag_no'=>$cons->dag,
                        'patta_no'=>$cons->patta_no,
                    ];
                    $base=array_merge($primary,$consumer);
                    if (isset($cons->buyers) && is_array($cons->buyers)) {
                             foreach($cons->buyers as $buyer)
                              {
                                  $data_util1 = array(
                                    'name'=>$buyer->name,
                                    'ngdrs_id'=>$buyer->ngdrs_id,
                                    'mobile'=>$buyer->mobile,
                                    'guard_name' => $buyer->father_name,
                                    'consumer_type'=>'B',
                                  );
                                  $data1 = $this->db->insert('sronote_apdcl_gmc', array_merge($base,$data_util1));
                                  if($data1 != 1)
                                  {
                                    $this->db->trans_rollback();  
                                    log_message("error"," #APDCLGMC001 could not insert sronote_apdcl_gmc deed_no: ".$deed_no);
                                    return;
                                  }
                              }
                          }
                          if (isset($cons->sellers) && is_array($cons->sellers)) {
                              foreach($cons->sellers as $seller)
                              {
                                  $data_util2 = array(
                                    'name'=>$seller->name,
                                    'ngdrs_id'=>$seller->ngdrs_id,
                                    'mobile'=>$seller->mobile,
                                    'consumer_type'=>'S',
                                  );
                                  $data2 = $this->db->insert('sronote_apdcl_gmc', array_merge($base,$data_util2));
                                  if($data2 != 1)
                                  {
                                    $this->db->trans_rollback();  
                                    log_message("error"," #APDCLGMC002 could not insert sronote_apdcl_gmc deed_no: ".$deed_no);
                                    return;
                                  }
                              }
                          }
                    }
                }

            if($data1==false or $data1!=1)
            {
                $this->db->trans_rollback();
                echo json_encode(array('responseType'=>2,
                    'text'=> 'Data not updated',
                    'deed_no' => $deed_no
                ));
                return;
            }
            $this->db->trans_commit();
            echo json_encode(array('responseType'=>4,
            'text'=> 'Data updated',
            'deed_no' => $deed_no
            ));
        }

        else
        {
            $this->db->trans_rollback(); 
            echo json_encode(array('responseType'=>2,
                    'text'=> 'Data not updated',
                    'deed_no' => $deed_no
                ));
                return;
        }
    }



    function deedviewNgdrsApi_test()
    {
        $dharitree=$this->input->post('case_no');
        if(isset($dharitree) && $dharitree == '' || !isset($dharitree)){
            log_message('error',"NGDRS####------".json_encode($dharitree));
            echo json_encode(array('responseType' => 1,'message' => 'Case no is required'));
            exit;
        }

        // for tgpp cases only
        $arr      = explode('/',$dharitree);

        log_message("error", "#ERRTEADALIL : ".$arr[4]);

        $this->load->model('TeaGrant/LM/TeaGrantModel');
        $output = $this->TeaGrantModel->viewDalilUploadedByLra($dharitree);
        if($output['status'] == 'y')
        {
            echo $output['response'];
        }
    }
    function ReclassHydroCarbon(){
        $rawInput = file_get_contents("php://input");
        $data = json_decode($rawInput, true);
        if (empty($data)) {
            echo json_encode(['status' => 'error', 'errors' => ['Invalid JSON input']]);
            return;
        }
        // echo "success";
        $this->dbswitch($data['location']['dist_code']);
        $this->db->trans_begin();
        $this->load->model('ChithaUpdateModel');
        $response= $this->ChithaUpdateModel->reclassFinalOrder($data['case_no'], $data);
        $result=json_decode($response);
        if($result->responseType==2){
            $this->db->trans_commit();
            echo json_encode(['status' => 'success', 'msg' => ['Records Updated Successfully']]);
            return;
        }else{
            $this->db->trans_rollback();
            echo json_encode(['status' => 'error', 'msg' => ['Error']]);
            return;
        }
    }

    public function register()
    {

        $raw = file_get_contents("php://input");
        $input = json_decode($raw, true);
        if ($input === null) {
            echo "JSON ERROR: " . json_last_error_msg();
            echo "\nRAW:\n" . $raw;
            exit;
        }
        if (!$input || empty($input['tea_gardens']) || !is_array($input['tea_gardens'])) {
            return $this->respond(false, "Invalid JSON or 'tea_gardens' missing.");
        }
        $this->dbswitch($input['dist_code']);
        $this->db->trans_begin(); // START TRANSACTION

        $saved_cases = [];

        foreach ($input['tea_gardens'] as $index => $garden) {

            // ===== REQUIRED FIELD VALIDATION =====
            $required = [
                'tea_estate_name','dist_code','subdiv_code','cir_code',
                'mouza_pargona_code','lot_no','vill_townprt_code',
                'uuid','applid','status','mobile_no'
            ];

            foreach ($required as $f) {
                if (empty($garden[$f])) {
                    $this->db->trans_rollback();
                    return $this->respond(false, "$f is required in tea_gardens item #" . ($index+1));
                }
            }

            if (empty($garden['dag_details']) || !is_array($garden['dag_details'])) {
                $this->db->trans_rollback();
                return $this->respond(false, "dag_details missing in item #" . ($index+1));
            }

            // ===== GENERATE CASE NUMBER =====
            $case_name = $this->genearteCaseName($garden['dist_code'], $garden['subdiv_code'], $garden['cir_code']);
            $petition_no = $this->genearteSettlementPetitionNo();

            if (!$case_name) {
                $this->db->trans_rollback();
                return $this->respond(false, "Failed generating case number for item #" . ($index+1));
            }

            $case_no = $case_name . $petition_no . "/ACQP";

            // ===== INSERT BASIC CASE =====
            $caseData = [
                'tea_estate_name'     => $garden['tea_estate_name'],
                'mobile_no'           => $garden['mobile_no'],
                'dist_code'           => $garden['dist_code'],
                'subdiv_code'         => $garden['subdiv_code'],
                'cir_code'            => $garden['cir_code'],
                'mouza_pargona_code'  => $garden['mouza_pargona_code'],
                'lot_no'              => $garden['lot_no'],
                'vill_townprt_code'   => $garden['vill_townprt_code'],
                'uuid'                => $garden['uuid'],
                'case_no'             => $case_no,
                'applid'              => $garden['applid'],
                'status'              => $garden['status'],
                'final_order'         => $garden['final_order'] ?? null,
                'order_date'          => $garden['order_date'] ?? null,
                'user_code'           => $garden['user_code'],
                'created_at'          => date('Y-m-d H:i:s'),
                'updated_at'          => date('Y-m-d H:i:s'),
                'service_code'        => '53'
            ];

            $this->db->insert('acquisition_basic', $caseData);
            $case_id = $this->db->insert_id();

            if (!$case_id) {
                $this->db->trans_rollback();
                return $this->respond(false, "Failed inserting case for item #" . ($index+1));
            }

            // ===== INSERT DAG DETAILS =====
            foreach ($garden['dag_details'] as $d => $dag) {

                if (empty($dag['dag_no']) || empty($dag['patta_no'])) {
                    $this->db->trans_rollback();
                    return $this->respond(false, "dag_no & patta_no required in DAG item #" . ($d+1) . " of garden #" . ($index+1));
                }

                $dagData = [
                    'case_no'            => $case_no,
                    'dist_code'          => $garden['dist_code'],
                    'subdiv_code'        => $garden['subdiv_code'],
                    'cir_code'           => $garden['cir_code'],
                    'mouza_pargona_code' => $garden['mouza_pargona_code'],
                    'lot_no'             => $garden['lot_no'],
                    'vill_townprt_code'  => $garden['vill_townprt_code'],
                    'dag_no'             => $dag['dag_no'],
                    'patta_no'           => $dag['patta_no'],
                    'bigha'              => floatval($dag['bigha'] ?? 0),
                    'katha'              => floatval($dag['katha'] ?? 0),
                    'lessa'              => floatval($dag['lessa'] ?? 0),
                    'ganda'              => floatval($dag['ganda'] ?? 0),
                    'chatak'             => floatval($dag['chatak'] ?? 0),
                    'kranti'             => floatval($dag['kranti'] ?? 0),
                    'reservation_b'      => $dag['reservation_b'] ?? null,
                    'user_code'          => null,
                    'patta_type_code'    => $dag['patta_code'],
                ];

                $this->db->insert('acquisition_dag_details', $dagData);
            }

            // Save summary
            $saved_cases[] = [
                'case_id' => $case_id,
                'case_no' => $case_no,
                'tea_estate_name' => $garden['tea_estate_name']
            ];
        }
        // ===== COMMIT TRANSACTION =====
        if ($this->db->trans_status() === FALSE) 
        {
            $this->db->trans_rollback();
            return $this->respond(false, "Transaction failed.");
        }
        $this->db->trans_commit();
        return $this->respond(true, "All tea garden cases registered successfully.", $saved_cases);
    } 

    function genearteCaseName($dist_code,$subdiv_code,$cir_code){

        $financialyeardate = (date('m') < '07') ? date('Y', strtotime('-1 year')) . "-" . date('y') : date('Y') . "-" . date('y', strtotime('+1 year'));
        $q = "Select dist_abbr,cir_abbr from location where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code!='00' ";
        $abbrname = $this->db->query($q)->row();
        if($abbrname)
        {
            $cir_dist_name = $abbrname->dist_abbr . "/" . $abbrname->cir_abbr;
            $case_no = $cir_dist_name . "/" . $financialyeardate . "/" ;
            return $case_no;
        }
        return false;
    }
    function genearteSettlementPetitionNo(){
        $petition_no = $this->db->query("select nextval('seq_max_settlement') as count ")->row()->count;
        return $petition_no;
    }

    // Common JSON response
    private function respond($success, $message, $extra = []) {
        echo json_encode(array_merge([
            'success' => $success,
            'message' => $message
        ], $extra));
    }
}
?>
