<?php

class ZonalByforcationController extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('form_validation');
        $this->load->helper(array('form', 'url', 'date', 'file'));
        $this->load->model('ZonalInformation/zonalByforcationModel');
        $this->load->model('ZonalInformation/zonalinformationmodel');
        $this->load->model('UtilsModel');
    }


    //******* Zonal Dag Village Wise ********//
    public function zonalDagVillageWise()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data['dist_code'] = $dist_code;
        $data['subdiv_code'] = $subdiv_code;
        $data['cir_code'] = $cir_code;
        $data['_view'] = 'ZonalAutoUpdate/zonal_byforcation_dagwise_co';
        $this->load->view('layouts/main', $data);
    }



    public function viewDagwiseZonalDetailsVillWise()
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        // $searchByCol_0 = $this->input->post('columns')[0]['search']['value'];
        $searchByCol_1 = $this->input->post('columns')[1]['search']['value'];
        $village_code = $this->input->post('village_code');
        $results = $this->zonalByforcationModel->getZonalDagVillwise($start, $length, $order, $dist_code, $subdiv_code, $cir_code, $village_code);


        // var_dump($results['data_results']);
        if (isset($results)) {
            $data_rows = $results['data_results'];

            foreach ($data_rows as $rows) {

                if ($rows['pending_dags'] < 0) {

                    $pending = 0;
                } else {
                    $pending = $rows['pending_dags'];
                }

                $json[] = array(
                    // $rows['chitha_dags'],
                    $this->utilityclass->getCircleName($rows['dist_code'], $rows['subdiv_code'], $rows['cir_code']),
                    $this->utilityclass->getVillageNameByUUID($rows['vill_uuid']),
                    $rows['zonal_dags'],
                    $rows['chitha_dags'],
                    $pending,
                    $rows['approve_dags'],

                );
            }

            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }


    // Added on 04/03/2023

    //******* Zonal Dag Village Wise ********//
    public function zonalVillageVillageWise()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data['dist_code'] = $dist_code;
        $data['subdiv_code'] = $subdiv_code;
        $data['cir_code'] = $cir_code;

        $data['_view'] = 'ZonalAutoUpdate/zonal_byforcation_villagewise_co';
        $this->load->view('layouts/main', $data);
    }



    // Zonal Village Villagewise
    public function viewVillageZonalDetailsVillWise()
    {
        $dist_code = $this->input->post('dist_code');
        $subdiv_code = $this->input->post('subdiv_code');
        $cir_code = $this->input->post('cir_code');
        $draw = intval($this->input->post('draw'));
        $start = intval($this->input->post('start'));
        $length = intval($this->input->post('length'));
        $order = $this->input->post('order');
        $village_code = $this->input->post('village_code');
        $results = $this->zonalByforcationModel->getVillageZonalDetailsVillwise($start, $length, $order, $dist_code, $subdiv_code, $cir_code, $village_code);

        if (isset($results)) {
            $data_rows = $results['data_results'];

            foreach ($data_rows as $rows) {

                $json[] = array(
                    $this->utilityclass->getCircleName($rows['dist_code'], $rows['subdiv_code'], $rows['cir_code']),
                    $this->utilityclass->getVillageNameByUUID($rows['vill_uuid']),
                    $rows['zonal_village'] == '1' ? "<i class='fa fa-check' style='color:green'></i>" : "<i class='fa fa-close red' style='color:red'></i>",
                    $rows['zonal_village_flag'] > '0' ? "<i class='fa fa-check' style='color:green'></i>" : "<i class='fa fa-close red' style='color:red'></i>",
                );
            }

            $total_records = $results['total_records'];
            $response = array(
                'draw'              => $draw,
                'recordsTotal'      => $total_records,
                'recordsFiltered'   => $total_records,
                'data'              => $json
            );
            echo json_encode($response);
        } else {
            $response = array();
            $response['sEcho'] = 0;
            $response['iTotalRecords'] = 0;
            $response['iTotalDisplayRecords'] = 0;
            $response['aaData'] = [];
            echo json_encode($response);
        }
    }



    // Dashboard for DC 

    //******* Zonal Dag Circle Wise for DC********//
    public function zonalDagCircleWiseDc()
    {
        $dist_code = $this->session->userdata('dist_code');
        $data['dist_code'] = $dist_code;

        $results = $this->zonalByforcationModel->getZonalDagCirclewiseDc($dist_code);

        $data_rows = $results['data_results'];
        $data['data_rows'] = $data_rows;
        $data['_view'] = 'ZonalAutoUpdate/zonal_byforcation_circlewise_dc';
        $this->load->view('layouts/main', $data);
    }

    //******* Zonal Details Missing Report Villagewise ********//
    public function zonalDetailsVillageWiseReport()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $data['dist_code'] = $dist_code;
        $data['subdiv_code'] = $subdiv_code;
        $data['cir_code'] = $cir_code;

        // $sql = "select
        //             (select loc_name from location where subdiv_code=d.subdiv_code and cir_code=d.cir_code and mouza_pargona_code='00') as Circle,
        //             (select loc_name from location where subdiv_code=d.subdiv_code and cir_code=d.cir_code and mouza_pargona_code=d.mouza_pargona_code and lot_no='00') as Mouza,
        //             (select loc_name from location where subdiv_code=d.subdiv_code and cir_code=d.cir_code and mouza_pargona_code=d.mouza_pargona_code and lot_no=d.lot_no and vill_townprt_code='00000') as Lot,(select loc_name from location where uuid=d.unique_village_code::bigint) as Village,
        //             (select zone_name from zonal_master where zone_code::int=d.zone_id::int) as Zone,
        //             (select subclass_name from subclass_master where subclass_code::int=d.subclass_id::int) as Subclass,
        //             d.dag_no from dagwise_zone_info d left join villagewise_zone_info v on d.unique_village_code=v.unique_village_code
        //             and v.zone_code::int=d.zone_id::int and v.subclass_code::int=d.subclass_id::int
        //             join location l on l.uuid=d.unique_village_code::bigint
        //             join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
        //             b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
        //             where d.flag='1' and  (v.flag='0' or v.land_rate is null or v.land_rate='' )
        //             and d.subdiv_code='$subdiv_code' and d.cir_code='$cir_code'
        //             and  l.nc_btad is null and b.dag_flag_type is null";


        $sql = "select
                    (select loc_name from location where subdiv_code=d.subdiv_code and cir_code=d.cir_code and mouza_pargona_code='00') as Circle,
                    (select loc_name from location where subdiv_code=d.subdiv_code and cir_code=d.cir_code and mouza_pargona_code=d.mouza_pargona_code and lot_no='00') as Mouza,
                    (select loc_name from location where subdiv_code=d.subdiv_code and cir_code=d.cir_code and mouza_pargona_code=d.mouza_pargona_code and lot_no=d.lot_no and vill_townprt_code='00000') as Lot,(select loc_name from location where uuid=d.unique_village_code::bigint) as Village,
                    (select zone_name from zonal_master where zone_code::int=d.zone_id::int) as Zone,
                    (select subclass_name from subclass_master where subclass_code::int=d.subclass_id::int) as Subclass,
                    d.dag_no from dagwise_zone_info d left join villagewise_zone_info v on d.unique_village_code=v.unique_village_code
                    and v.zone_code::int=d.zone_id::int and v.subclass_code::int=d.subclass_id::int
                    join location l on l.uuid=d.unique_village_code::bigint
                    join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
                    b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no	
                    where d.flag='1' and  (v.flag='0' or v.land_rate is null or v.land_rate='' )
                    and d.subdiv_code='$subdiv_code' and d.cir_code='$cir_code'
                    and  l.nc_btad is null and b.dag_flag_type is null and  b.dag_no not in ( select dag_no from chitha_dag_all_flag_details_final df where df.subdiv_code = b.subdiv_code and df.cir_code = b.cir_code and
                    df.mouza_pargona_code = b.mouza_pargona_code and df.lot_no = b.lot_no and df.vill_townprt_code = b.vill_townprt_code and df.dag_no = b.dag_no and (df.is_eroded ='7' or df.is_landclassless ='4' or df.is_sad ='3'))";

        $data_rows = $this->db->query($sql)->num_rows();

        if ($data_rows <= 0) {
            $this->session->set_flashdata('message', 'No Missing Zonal Value Found');
            redirect(base_url() . "index.php/Home");
        } else {
            $time_format = "%d-%M-%Y-%h-%i-%s-%A";
            $time = mdate($time_format);
            $data = $this->db->query($sql)->result_array();
            $file_name = "Zonal_Missing_Report" . $time . '.xlsx';
            $this->load->model('UtilsModel');
            $this->UtilsModel->downloadExcelReport($file_name, $data);
        }
    }




    //  Dagwise Pending Report CO
    public function dagwiseEntryMissingReportCO()
    {
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');


        $sql = "SELECT P.loc_name as circle, C.loc_name as Lot, L.loc_name as village,B.dag_no
                        FROM chitha_basic AS B
                        JOIN location AS L
                        ON     L.dist_code=B.dist_code and
                            L.subdiv_code=B.subdiv_code and
                            L.cir_code=B.cir_code and
                            L.mouza_pargona_code=B.mouza_pargona_code and
                            L.lot_no=B.lot_no and
                            L.vill_townprt_code=B.vill_townprt_code
                        JOIN location AS P
                        ON     P.dist_code=B.dist_code and
                            P.subdiv_code=B.subdiv_code and
                            P.cir_code=B.cir_code and
                            P.mouza_pargona_code='00' and
                            P.lot_no='00' and
                            P.vill_townprt_code='00000'

                        JOIN location AS C
                        ON     C.dist_code=B.dist_code and
                            C.subdiv_code=B.subdiv_code and
                            C.cir_code=B.cir_code and
                            C.mouza_pargona_code=B.mouza_pargona_code and
                            C.lot_no=B.lot_no and
                            C.vill_townprt_code='00000'
                        WHERE B.dag_no  NOT IN (SELECT dag_no  FROM dagwise_zone_info WHERE subdiv_code = '$subdiv_code' AND cir_code = '$cir_code' AND mouza_pargona_code != '00' AND lot_no != '00' AND vill_code != '00000') AND B.subdiv_code = '$subdiv_code'
                        AND B.cir_code = '$cir_code' AND B.mouza_pargona_code != '00' AND B.lot_no != '00'
                        AND B.vill_townprt_code != '00000' AND L.nc_btad is null AND B.dag_flag_type is null";

        $data_rows = $this->db->query($sql)->num_rows();

        if ($data_rows <= 0) {
            $this->session->set_flashdata('message', 'No Pending Zonal Dags Found');
            redirect(base_url() . "index.php/Home");
        } else {
            $time_format = "%d-%M-%Y-%h-%i-%s-%A";
            $time = mdate($time_format);
            $data = $this->db->query($sql)->result_array();
            $file_name = "Pending_Dagwise_Entry_Report_CO" . $time . '.xlsx';
            $this->load->model('UtilsModel');
            $this->UtilsModel->downloadExcelReport($file_name, $data);
        }
    }



    // Dagwise Pending Report DC End
    public function dagwiseEntryMissingReportDC()
    {
        $data =   $this->db->query("SELECT  B.dag_no,P.loc_name as circle,C.loc_name as lot,L.loc_name as village
        FROM    chitha_basic AS B
        JOIN location AS L
        ON     L.dist_code=B.dist_code and
            L.subdiv_code=B.subdiv_code and
            L.cir_code=B.cir_code and
            L.mouza_pargona_code=B.mouza_pargona_code and
            L.lot_no=B.lot_no and
            L.vill_townprt_code=B.vill_townprt_code
        JOIN location AS P
        ON     P.dist_code=B.dist_code and
            P.subdiv_code=B.subdiv_code and
            P.cir_code=B.cir_code and
            P.mouza_pargona_code='00' and
            P.lot_no='00' and
            P.vill_townprt_code='00000'
            
        JOIN location AS C
        ON     C.dist_code=B.dist_code and
            C.subdiv_code=B.subdiv_code and
            C.cir_code=B.cir_code and
            C.mouza_pargona_code=B.mouza_pargona_code and
            C.lot_no=B.lot_no and
            C.vill_townprt_code='00000'
        WHERE   NOT EXISTS       
        (     
            SELECT  dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, vill_code,dag_no
            FROM    dagwise_zone_info A
            WHERE    
            A.dist_code=B.dist_code and
            A.subdiv_code=B.subdiv_code and
            A.cir_code=B.cir_code and
            A.mouza_pargona_code=B.mouza_pargona_code and
            A.lot_no=B.lot_no and
            A.vill_code=B.vill_townprt_code and
            A.dag_no=B.dag_no 
        ) AND B.dag_flag_type is null")->result_array();

        $file_name = "Pending_Dagwise_Entry_Report_DC" . time() . '.xlsx';
        $this->load->model('UtilsModel');
        $this->UtilsModel->downloadExcelReport($file_name, $data);
    }



    public function convertLiteral($arr)
    {
        $y = substr($arr, 1, -1);
        $z = explode(',', $y);
        $index = 0;
        $final_str = '';
        foreach ($z as $a) {
            if ($index == 0)
                $final_str = "'" . $a . "'";
            else
                $final_str = $final_str . ",'" . $a . "'";
            $index++;
        }
        //var_dump($final_str);
        return array(sizeof($z), $final_str, $z);
    }



    //Zonal Application Missing Dags Report for Basundhara Dags
    public function zonalApplicationMissingDags()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');

        $curl = curl_init();
        $url = API_LINK_MB2 . "zonalApplicationDags/" . $dist_code . "/" . $subdiv_code . "/" . $cir_code;

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        $zonal_dags = json_decode($response);


        foreach ($zonal_dags as $zonal) {

            // Get Location name From Location
            $sql = "select (select loc_name from location where dist_code=a.dist_code and subdiv_code='00') as dist_name,
                            (select loc_name from location where dist_code=a.dist_code and subdiv_code=a.subdiv_code and cir_code=a.cir_code
                                and mouza_pargona_code='00') as circle_name,

                            (select loc_name from location where dist_code=a.dist_code and subdiv_code=a.subdiv_code and cir_code=a.cir_code
                                and mouza_pargona_code=a.mouza_pargona_code and lot_no='00') as mouza_name,

                            (select loc_name from location where dist_code=a.dist_code and subdiv_code=a.subdiv_code and cir_code=a.cir_code
                                and mouza_pargona_code=a.mouza_pargona_code and lot_no=a.lot_no and vill_townprt_code='00000') as lot_name,

                            (select loc_name from location where uuid=a.uuid) as village_name,
                            dist_code,subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code

                            from location a where uuid=? and nc_btad is null";
            // $loc_data = $this->db->query($sql, array($zonal->uuid))->row();

            $loc_dataa = $this->db->query($sql, array($zonal->uuid));
            if ($loc_dataa->num_rows() > 0) {
                $loc_data = $loc_dataa->row();
            }

            $newarray = $this->convertLiteral($zonal->arr);


            $sql = "select d.unique_village_code,d.dag_no from dagwise_zone_info d join (select * from  villagewise_zone_info where unique_village_code =?)  v on 
                    d.zone_id::int = v.zone_code and d.subclass_id::int=v.subclass_code
                    where d.flag='1' and v.flag='1' and d.unique_village_code=? and d.dag_no in ($newarray[1]) group by d.unique_village_code,d.dag_no";
            $dag_data = $this->db->query($sql, array($zonal->uuid, $zonal->uuid));

            $dag_count = $dag_data->num_rows();
            $total_dags = $newarray[0];

            $dag_count_y = $dag_count;
            if ($dag_count_y == $total_dags) {
                continue;
            }
            $dag_count_n = $total_dags - $dag_count;
            if ($dag_count > 0) {
                $dag_data_result = $dag_data->result();
                foreach ($dag_data_result as $dr) {
                    $dag_yes_zone[] = $dr->dag_no;
                }
            } else
                $dag_yes_zone = [];

            $dag_no_zone = array_diff($newarray[2], $dag_yes_zone);
            //log_message('error','ZONAL: newarray[2]='.json_encode($newarray[2]).'------ dag_no_zone='.json_encode($dag_no_zone));

            $finalArray[] = array(
                'circle' => $loc_data->circle_name,
                'mouza' => $loc_data->mouza_name,
                'lot' => $loc_data->lot_name,
                'village' => $loc_data->village_name,
                'uuid' => $zonal->uuid,
                'total_dag' => $total_dags,
                'ZonalEntryYes' => $dag_count_y,
                'ZonalEntryNo' => $dag_count_n,
                'dags_missing_zonal' => implode(',', $dag_no_zone),

            );
        }

        if (sizeof($finalArray) == 0) {
            $this->session->set_flashdata('message', 'No Pending Basundhara Dags with Missing Zonal Entry');
            redirect(base_url() . "index.php/Home");
        } else {
            $time_format = "%d-%M-%Y-%h-%i-%s-%A";
            $time = mdate($time_format);
            $file_name = "Basundhara_Dag_Missing_Report_CO_" . $time . '.xlsx';
            $this->load->model('UtilsModel');
            $this->UtilsModel->downloadExcelReport($file_name, $finalArray);
        }
    }



    //Get All the List of All Approved Dags with Zone and Subclass and Zonal Value (Land Rate)
    public function zonalValueCertificateReportCO_old()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');

        $dist_name = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code)->locname_eng;
        $subDiv_name = $this->UtilsModel->getEngSubdivNameByDistCode($dist_code, $subdiv_code)->locname_eng;
        $circle_name = $this->UtilsModel->getEngCircleDetails($dist_code, $subdiv_code, $cir_code)->locname_eng;
        $co_name = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);


        //Check for Zonal Value Missing Dags

        $sql = "select d.dag_no from dagwise_zone_info d left join villagewise_zone_info v on d.unique_village_code=v.unique_village_code 
                and v.zone_code::int=d.zone_id::int and v.subclass_code::int=d.subclass_id::int
				join location l on l.uuid=d.unique_village_code::bigint 
                join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and b.mouza_pargona_code = d.mouza_pargona_code
                and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
				where d.flag='1' and  (v.flag='0' or v.land_rate is null or v.land_rate='' ) 
        		and d.subdiv_code='$subdiv_code' and d.cir_code='$cir_code' and l.nc_btad is null and b.dag_flag_type is null";

        $data_rows = $this->db->query($sql)->num_rows();

        if ($data_rows > 0) {

            $this->session->set_flashdata('message', 'There are ' . $data_rows . ' dags for which Zonal Value are missing. Kindly get it rectified before generating the certificate');
            redirect(base_url() . "index.php/ZoneInformationController/zonalInformationDetails_dc_co");
        } else {


            $sql = "select
        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no='00') as mouza_name,
        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no=v.lot_no and vill_townprt_code='00000') as lot_name,
        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no=v.lot_no and vill_townprt_code=v.vill_code) as village_name,
        v.zone_name, v.subclass_name, v.land_rate, string_agg(distinct(d.dag_no),',') as dag
        from villagewise_zone_info v join dagwise_zone_info d on v.unique_village_code=d.unique_village_code
            and v.zone_code =d.zone_id::int and v.subclass_code=d.subclass_id::int
            join location l on l.uuid=d.unique_village_code::bigint
           join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
            b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
            where d.flag='1' and v.flag='1' and v.subdiv_code ='$subdiv_code' and v.cir_code ='$cir_code' and l.nc_btad is null and b.dag_flag_type is null
            group by v.subdiv_code, v.cir_code, v.mouza_pargona_code, v.lot_no, v.vill_code, v.zone_name, v.subclass_name, v.land_rate";
            $zonalDetails = $this->db->query($sql)->result();
            include 'vendor\mpdf\vendor\autoload.php';
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 9,
                'default_font' => 'dejavusans',
                'orientation' => 'L'
            ]);
            $mpdf->SetWatermarkText('DHARITREE');
            $mpdf->showWatermarkText = true;
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            ini_set("pcre.backtrack_limit", "500000000");
            ini_set('memory_limit', '4096M');
            set_time_limit(0);
            $html = '';
            $htmlTag = '';
            $htmlTag1 = '';
            $htmlTag2 = '';


            $htmlTag .= '<h3 style="text-align: center"><u>Dag wise zonal rate</u></h3>';
            $htmlTag1 .= '<br><br><p style="text-align: center  ;font-size:20px">District: ' . $dist_name . ' &nbsp; Subdiv: ' . $subDiv_name . ' &nbsp; Circle: ' . $circle_name . '</p>';
            $htmlTag2 .= '<br><br><p style="text-align: center  ;font-size:15px">' . $co_name->username . '</p>';
            $htmlTag3 .= '<p style="text-align: right">Circle Officer ( ' . $circle_name . ' )</p>';
            $htmlTag4 .= '<br><p style="text-align: center;font-size:15px">This is to certify that i have checked 100% of the Zonal Value entries for the Circle: ' . $circle_name . '.</p>';
            $table1 = ' <table cellpadding="5px" autosize="1" border="1" width="100%" style="overflow: wrap">
                    <thead>
                    <tr>
                        <th  >Mouza </th>
                        <th >Lot </th>
                        <th >Village </th>
                        <th >Zone </th>
                        <th  >Subclass </th>
                        <th >Zonal Value(Land Rate)</th>
                        <th >Dag No(s)</th>
                    </tr>
                    </thead>
                    <tbody>';
            foreach ($zonalDetails as $details) {
                $table2 .= '<tr>
                        <td >' . $details->mouza_name . '</td>
                        <td>' . $details->lot_name . '</td>
                        <td>' . $details->village_name . '</td>
                        <td>' . $details->zone_name . '</td>
                        <td >' . $details->subclass_name . '</td>
                        <td>' . $details->land_rate . '</td>
                        <td> ' . $details->dag . '</td>
                    </tr>';
            }
            $table3 = '</tbody></table>';
            $table = $table1 . $table2 . $table3;
            $final = $htmlTag1 . $htmlTag4 . $htmlTag . $table . $htmlTag2 . $htmlTag3;
            $mpdf->writeHTML($final);
            header('Content-type: application/pdf');
            $mpdf->Output('Dagwise_Zonal_Value_Report.pdf', 'I');
        }
    }


    function uploadReportCo()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        if ($subdiv_code != '00' && $cir_code != '00') {

            // $sql = "select d.dag_no from dagwise_zone_info d left join villagewise_zone_info v on d.unique_village_code=v.unique_village_code 
            //     and v.zone_code::int=d.zone_id::int and v.subclass_code::int=d.subclass_id::int
            //     join location l on l.uuid=d.unique_village_code::bigint 
            //     join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
            //     b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
            //      where d.flag='1' and  (v.flag='0' or v.land_rate is null or v.land_rate='' ) 
        	// 	and d.subdiv_code='$subdiv_code' and d.cir_code='$cir_code' and l.nc_btad is null and b.dag_flag_type is null";


            $sql ="SELECT d.dag_no
                        FROM dagwise_zone_info d
                        LEFT JOIN villagewise_zone_info v ON d.unique_village_code = v.unique_village_code
                            AND v.zone_code::int = d.zone_id::int
                            AND v.subclass_code::int = d.subclass_id::int
                        JOIN location l ON l.uuid = d.unique_village_code::bigint
                        JOIN chitha_basic b ON b.subdiv_code = d.subdiv_code
                            AND b.cir_code = d.cir_code
                            AND b.mouza_pargona_code = d.mouza_pargona_code
                            AND b.lot_no = d.lot_no
                            AND b.vill_townprt_code = d.vill_code
                            AND b.dag_no = d.dag_no
                        WHERE d.flag = '1'
                            AND (v.flag = '0' OR v.land_rate IS NULL OR v.land_rate = '')
                            AND d.subdiv_code = '$subdiv_code'
                            AND d.cir_code = '$cir_code'
                            AND l.nc_btad IS NULL
                            AND b.dag_flag_type IS NULL
                            AND NOT EXISTS (
                                SELECT 1
                                FROM chitha_dag_all_flag_details_final df
                                WHERE df.uuid = d.unique_village_code::bigint
                                    AND df.dag_no = d.dag_no
                                    AND (df.is_eroded = '7' OR df.is_landclassless = '4' OR df.is_sad = '3')
                            )";

            if (ZONAL_UPLOAD_CHECK == 0) {
                $data_rows = '0';
            } else {
                $data_rows = $this->db->query($sql)->num_rows();
            }

            if ($data_rows > 0) {
                echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> There are ' . $data_rows . ' dags for which Zonal Value are missing. Kindly get it rectified before Uploading the certificate</span>';
            } else {
                $folder = ZONAL_REPORT_BASE_DIR;
                $time_format = "%d_%M_%Y_%h_%i_%s_%A";
                $time = mdate($time_format);
                $file = "zonal_report_co_" . $time . uniqid();

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    $path = $folder;
                } else {
                    $path = $folder;
                }

                $config = array(
                    'upload_path' => $path,
                    'allowed_types' => 'pdf',
                    'max_size' => '15000',
                    'overwrite' => TRUE,
                    'file_name' => $file,
                );

                if (isset($_FILES['file']['name'])) {
                    if (0 < $_FILES['file']['error']) {
                        echo 'Error during file upload' . $_FILES['file']['error'];
                    } else {
                        if (file_exists($folder . $_FILES['file']['name'])) {
                            echo 'File already exists : '. $folder . $_FILES['file']['name'];
                        } else {
                            //Check for previous Report
                            $sql = "SELECT * FROM uploaded_report WHERE subdiv_code ='$subdiv_code' AND cir_code='$cir_code' AND user_code='$user_code' AND is_active in('E','R','A')";
                            $previousReport = $this->db->query($sql)->num_rows();

                            if ($previousReport >= 1) {
                                $this->load->library('upload', $config);
                                if (!$this->upload->do_upload('file')) {
                                    $errors = $this->upload->display_errors();
                                    echo '<span class="text-danger">' . $errors . '</span>';
                                } else {
                                    $updateData = [
                                        'is_active' => 'D',
                                    ];
                                    $where = [
                                        'dist_code' => $dist_code,
                                        'subdiv_code' => $subdiv_code,
                                        'cir_code' => $cir_code,
                                        'user_code' => $user_code,
                                    ];
                                    $updateReportCo = $this->db->set($updateData)->where($where)->update('uploaded_report');

                                    if ($updateReportCo != 1) {

                                        echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> Report Not Uploaded !! Kindly Contact System Administrator</span>';
                                        return false;
                                    } else {
                                        //insert to DB
                                        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                                        $report_name = $file . '.' . $ext;
                                        $report_upload_path = $path . $file . '.' . $ext;
                                        $report = [
                                            'dist_code' => $dist_code,
                                            'subdiv_code' => $subdiv_code,
                                            'cir_code' => $cir_code,
                                            'mouza_pargona_code' => "00",
                                            'lot_no' => "00",
                                            'user_code' => $user_code,
                                            'ip' => $this->utilityclass->get_client_ip(),
                                            'is_active' => "E",
                                            'report_name' => $report_name,
                                            'report_by' => 'CO',
                                            'report_upload_path' => $report_upload_path,
                                            'date_upload' => date('Y-m-d h:i:s'),
                                        ];
                                        $insUpload = $this->db->insert('uploaded_report', $report);

                                        if ($insUpload != 1) {
                                            echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> Report Not Uploaded !! Kindly Contact System Administrator</span>';
                                            return false;
                                        } else {
                                            echo '<span class="bg-success blink_text style="font-size:22px""><i class="fa fa-check-circle"></i> Report Uploaded Successfully</span>';
                                        }
                                    }
                                }
                            } else {

                                $this->load->library('upload', $config);
                                if (!$this->upload->do_upload('file')) {
                                    $errors = $this->upload->display_errors();
                                    echo '<span class="text-danger">' . $errors . '</span>';
                                } else {
                                    //insert to DB
                                    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                                    $report_name = $file . '.' . $ext;
                                    $report_upload_path = $path . $file . '.' . $ext;
                                    $report = [
                                        'dist_code' => $dist_code,
                                        'subdiv_code' => $subdiv_code,
                                        'cir_code' => $cir_code,
                                        'mouza_pargona_code' => "00",
                                        'lot_no' => "00",
                                        'user_code' => $user_code,
                                        'ip' => $this->utilityclass->get_client_ip(),
                                        'is_active' => "E",
                                        'report_name' => $report_name,
                                        'report_by' => 'CO',
                                        'report_upload_path' => $report_upload_path,
                                        'date_upload' => date('Y-m-d h:i:s'),
                                    ];
                                    $insUpload = $this->db->insert('uploaded_report', $report);

                                    if ($insUpload === TRUE) {
                                        echo '<span class="bg-success blink_text style="font-size:22px""><i class="fa fa-check-circle"></i> Report Uploaded Successfully</span>';
                                    } else {
                                        echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> Report Not Uploaded !! Kindly Contact System Administrator</span>';
                                        return false;
                                    }
                                    //insert end
                                }
                            }
                        }
                    }
                } else {
                    echo '<span  class="bg-yellow blink_text" style="font-size:22px"><i class="fa fa-exclamation-circle"></i> Please choose a file to Upload</span>';
                }
            }
        } else {

            echo '<span  class="bg-yellow blink_text" style="font-size:22px"><i class="fa fa-exclamation-circle"></i> Session Mismatched</span>';
        }
    }




    function uploadReportADC()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $user_code = $this->session->userdata('user_code');



        // $sql = "select d.dag_no from dagwise_zone_info d left join villagewise_zone_info v on d.unique_village_code=v.unique_village_code 
        //         and v.zone_code::int=d.zone_id::int and v.subclass_code::int=d.subclass_id::int
        //         join location l on l.uuid=d.unique_village_code::bigint
        //         join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
        //         b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
        //          where d.flag='1' and  (v.flag='0' or v.land_rate is null or v.land_rate='' ) and l.nc_btad is null and b.dag_flag_type is null";


        $sql ="SELECT d.dag_no
                        FROM dagwise_zone_info d
                        LEFT JOIN villagewise_zone_info v ON d.unique_village_code = v.unique_village_code
                            AND v.zone_code::int = d.zone_id::int
                            AND v.subclass_code::int = d.subclass_id::int
                        JOIN location l ON l.uuid = d.unique_village_code::bigint
                        JOIN chitha_basic b ON b.subdiv_code = d.subdiv_code
                            AND b.cir_code = d.cir_code
                            AND b.mouza_pargona_code = d.mouza_pargona_code
                            AND b.lot_no = d.lot_no
                            AND b.vill_townprt_code = d.vill_code
                            AND b.dag_no = d.dag_no
                        WHERE d.flag = '1'
                            AND (v.flag = '0' OR v.land_rate IS NULL OR v.land_rate = '')
                            AND d.subdiv_code = '$subdiv_code'
                            AND l.nc_btad IS NULL
                            AND b.dag_flag_type IS NULL
                            AND NOT EXISTS (
                                SELECT 1
                                FROM chitha_dag_all_flag_details_final df
                                WHERE df.uuid = d.unique_village_code::bigint
                                    AND df.dag_no = d.dag_no
                                    AND (df.is_eroded = '7' OR df.is_landclassless = '4' OR df.is_sad = '3')
                            )";

        $data_rows = $this->db->query($sql)->num_rows();

        if ($data_rows > 0) {
            echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> There are ' . $data_rows . ' dags for which Zonal Value are missing. Kindly get it rectified before Uploading the certificate</span>';
        } else {

            $folder = ZONAL_REPORT_BASE_DIR;
            $time_format = "%d_%M_%Y_%h_%i_%s_%A";
            $time = mdate($time_format);
            // $file = "zonal_report_" . date('mdYhis', time()) . uniqid();
            $file = "zonal_report_adc_" . $time . uniqid();

            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
                $path = $folder;
            } else {
                $path = $folder;
            }

            $config = array(
                'upload_path' => $path,
                'allowed_types' => 'pdf',
                'max_size' => '15000',
                // 'encrypt_name' => 'TRUE'
                'overwrite' => TRUE,
                'file_name' => $file,
            );

            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    echo 'Error during file upload' . $_FILES['file']['error'];
                } else {
                    if (file_exists($folder . $_FILES['file']['name'])) {
                        echo 'File already exists : '. $folder . $_FILES['file']['name'];
                    } else {
                        //Check for previous Report
                        $sql = "SELECT * FROM uploaded_report WHERE subdiv_code ='00' AND cir_code='00' AND user_code='$user_code' AND report_by ='ADC' AND is_active in('E','R','A')";
                        $previousReport = $this->db->query($sql)->num_rows();

                        if ($previousReport >= 1) {
                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('file')) {
                                $errors = $this->upload->display_errors();
                                echo '<span class="text-danger">' . $errors . '</span>';
                            } else {
                                $updateData = [
                                    'is_active' => 'D',
                                ];
                                $where = [
                                    'dist_code' => $dist_code,
                                    'subdiv_code' => '00',
                                    'cir_code' => '00',
                                    'user_code' => $user_code,
                                    'report_by' => 'ADC',
                                ];
                                $updateReportCo = $this->db->set($updateData)->where($where)->update('uploaded_report');

                                if ($updateReportCo != 1) {

                                    echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> Report Not Uploaded !! Kindly Contact System Administrator</span>';
                                    return false;
                                } else {
                                    //insert to DB
                                    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                                    $report_name = $file . '.' . $ext;
                                    $report_upload_path = $path . $file . '.' . $ext;
                                    $report = [
                                        'dist_code' => $dist_code,
                                        'subdiv_code' => '00',
                                        'cir_code' => '00',
                                        'mouza_pargona_code' => "00",
                                        'lot_no' => "00",
                                        'user_code' => $user_code,
                                        'ip' => $this->utilityclass->get_client_ip(),
                                        'is_active' => "E",
                                        'report_name' => $report_name,
                                        'report_by' => 'ADC',
                                        'report_upload_path' => $report_upload_path,
                                        'date_upload' => date('Y-m-d h:i:s'),
                                    ];
                                    $insUpload = $this->db->insert('uploaded_report', $report);

                                    if ($insUpload != 1) {
                                        echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> Report Not Uploaded !! Kindly Contact System Administrator</span>';
                                        return false;
                                    } else {
                                        echo '<span class="bg-success blink_text style="font-size:22px""><i class="fa fa-check-circle"></i> Report Uploaded Successfully</span>';
                                    }
                                }
                            }
                        } else {

                            $this->load->library('upload', $config);
                            if (!$this->upload->do_upload('file')) {
                                $errors = $this->upload->display_errors();
                                echo '<span class="text-danger">' . $errors . '</span>';
                            } else {
                                //insert to DB
                                $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                                $report_name = $file . '.' . $ext;
                                $report_upload_path = $path . $file . '.' . $ext;
                                $report = [
                                    'dist_code' => $dist_code,
                                    'subdiv_code' => '00',
                                    'cir_code' => '00',
                                    'mouza_pargona_code' => "00",
                                    'lot_no' => "00",
                                    'user_code' => $user_code,
                                    'ip' => $this->utilityclass->get_client_ip(),
                                    'is_active' => "E",
                                    'report_name' => $report_name,
                                    'report_by' => 'ADC',
                                    'report_upload_path' => $report_upload_path,
                                    'date_upload' => date('Y-m-d h:i:s'),
                                ];
                                $insUpload = $this->db->insert('uploaded_report', $report);


                                if ($insUpload === TRUE) {
                                    echo '<span class="bg-success blink_text style="font-size:22px""><i class="fa fa-check-circle"></i> Report Uploaded Successfully</span>';
                                } else {
                                    echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> Report Not Uploaded !! Kindly Contact System Administrator</span>';
                                    return false;
                                }
                                //insert end
                            }
                        }
                    }
                }
            } else {
                echo '<span  class="bg-yellow blink_text" style="font-size:22px"><i class="fa fa-exclamation-circle"></i> Please choose a file to Upload</span>';
            }
        }
    }



    public function viewUploadedReport()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');

        $sql = "SELECT report_upload_path FROM uploaded_report WHERE subdiv_code ='$subdiv_code' AND cir_code='$cir_code' AND mouza_pargona_code ='$mouza_pargona_code' AND lot_no ='$lot_no' AND user_code='$user_code' AND is_active in ('E','A','R')";

        $report = $this->db->query($sql)->row();
        $filename = $report->report_upload_path;


        header("Content-type: application/pdf");
        header("Content-Length: " . filesize($filename));
        readfile($filename);
    }

    public function verificationReportADC()
    {
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');

        $adc_name = $this->utilityclass->getSelectedADCName($dist_code, $user_code);
        $adc_name = $adc_name->username;
        $dist_name = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code)->locname_eng;

        //Check for missing zonal Value
        // $sql = "select 
		// 		d.dag_no from dagwise_zone_info d left join villagewise_zone_info v on d.unique_village_code=v.unique_village_code 
        //         and v.zone_code::int=d.zone_id::int and v.subclass_code::int=d.subclass_id::int
        //         join location l on l.uuid=d.unique_village_code::bigint 
        //         join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
        //         b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
        //          where d.flag='1' and  (v.flag='0' or v.land_rate is null or v.land_rate='' ) and l.nc_btad is null and b.dag_flag_type is null";


        $sql ="SELECT d.dag_no
                        FROM dagwise_zone_info d
                        LEFT JOIN villagewise_zone_info v ON d.unique_village_code = v.unique_village_code
                            AND v.zone_code::int = d.zone_id::int
                            AND v.subclass_code::int = d.subclass_id::int
                        JOIN location l ON l.uuid = d.unique_village_code::bigint
                        JOIN chitha_basic b ON b.subdiv_code = d.subdiv_code
                            AND b.cir_code = d.cir_code
                            AND b.mouza_pargona_code = d.mouza_pargona_code
                            AND b.lot_no = d.lot_no
                            AND b.vill_townprt_code = d.vill_code
                            AND b.dag_no = d.dag_no
                        WHERE d.flag = '1'
                            AND (v.flag = '0' OR v.land_rate IS NULL OR v.land_rate = '')
                            AND l.nc_btad IS NULL
                            AND b.dag_flag_type IS NULL
                            AND NOT EXISTS (
                                SELECT 1
                                FROM chitha_dag_all_flag_details_final df
                                WHERE df.uuid = d.unique_village_code::bigint
                                    AND df.dag_no = d.dag_no
                                    AND (df.is_eroded = '7' OR df.is_landclassless = '4' OR df.is_sad = '3')
                            )";
        $data_rows = $this->db->query($sql)->num_rows();

        if ($data_rows > 0) {

            $this->session->set_flashdata('message', 'There are ' . $data_rows . ' dags for which Zonal Value are missing. Kindly get it rectified before generating the certificate');
            redirect(base_url() . "index.php/ZoneInformationController/zonalinformationDetailsADC");
        } else {

            //report

            $sql = "select 
            (select loc_name from location where dist_code=v.dist_code and subdiv_code=v.subdiv_code  and cir_code='00') as subdivision,
            (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code='00') as circle,
	        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no='00') as mouza_name,
	        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no=v.lot_no and vill_townprt_code='00000') as lot_name,
	        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no=v.lot_no and vill_townprt_code=v.vill_code) as village_name,
	        d.dag_no, v.zone_name, v.subclass_name,v.land_rate
            from (SELECT * FROM dagwise_zone_info TABLESAMPLE SYSTEM (5) limit 200) d join  villagewise_zone_info v
            on v.unique_village_code=d.unique_village_code
            and v.zone_code =d.zone_id::int and v.subclass_code=d.subclass_id::int
            join location l on l.uuid=d.unique_village_code::bigint 
            join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
            b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
             where d.flag='1' and v.flag='1' and l.nc_btad is null and b.dag_flag_type is null";
            $zonalDetails = $this->db->query($sql)->result();
            include 'vendor\mpdf\vendor\autoload.php';
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 9,
                'default_font' => 'dejavusans',
                'orientation' => 'P'
            ]);
            $mpdf->SetWatermarkText('DHARITREE');
            $mpdf->showWatermarkText = true;
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            ini_set("pcre.backtrack_limit", "500000000");
            ini_set('memory_limit', '4096M');
            set_time_limit(0);
            $html = '';
            $htmlTag = '';
            $htmlTag1 = '';
            $htmlTag2 = '';


            $htmlTag .= '<br><br><p style="text-align: center  ;font-size:20px">District: ' . $dist_name . '</p>';
            $htmlTag1 .= '<h3 style="text-align: center; text-transform: uppercase"><u>Zonal Certification Report</u></h3>';
            $htmlTag2 .= '<p style="height: 60%; width: 60%;  margin: 10px; display: flex;">
         <p style="align-self: flex-end; text-align: right;font-size:15px; "> ' . $adc_name . '<br>ADC (' . ($dist_name) . ')</p>
        </p>';

            $htmlTag3 .= '<br><br><p style="text-align: center;font-size:15px">This is to certify that i have checked following 200 dags generated
            randomly  by Dharitree for Zonal Value for the district ' . $dist_name . '.</p>';

            $table1 = ' <table cellpadding="5px" autosize="1" border="1" width="100%" style="overflow: wrap">
                    <thead>
                    <tr>
                        <th  >Subdiv</th>
                        <th >Circle </th>
                        <th >Mouza </th>
                        <th >Lot </th>
                        <th >Village </th>
                        <th >Dag. No. </th>
                        <th >Zone </th>
                        <th  >Subclass </th>
                        <th >Zonal Value(Land Rate)</th>
                    </tr>
                    </thead>
                    <tbody>';
            foreach ($zonalDetails as $details) {
                $table2 .= '<tr>
                        <td >' . $details->subdivision . '</td>
                        <td>' . $details->circle . '</td>
                        <td>' . $details->mouza_name . '</td>
                        <td>' . $details->lot_name . '</td>
                        <td>' . $details->village_name . '</td>
                        <td>' . $details->dag_no . '</td>
                        <td>' . $details->zone_name . '</td>
                        <td >' . $details->subclass_name . '</td>
                        <td>' . $details->land_rate . '</td>
                    </tr>';
            }
            $table3 = '</tbody></table>';
            $table = $table1 . $table2 . $table3;
            $final = $htmlTag . $htmlTag1 . $htmlTag3 . $table  . $htmlTag2;
            $mpdf->writeHTML($final);
            header('Content-type: application/pdf');
            $mpdf->Output('Zonal_Certificate_report_adc.pdf', 'I');
            //report

        }
    }


    public function viewUploadedReportByCOADC($subdiv_code, $cir_code, $user_code)
    {

        $sql = "SELECT report_upload_path FROM uploaded_report WHERE subdiv_code ='$subdiv_code' AND cir_code='$cir_code' AND user_code ='$user_code'   AND is_active in('E','A','R')";
        $report = $this->db->query($sql)->row();

        $filename = $report->report_upload_path;

        header("Content-type: application/pdf");
        header("Content-Length: " . filesize($filename));
        readfile($filename);
    }

    function uploadReportDC()
    {
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');

        // $sql = "select d.dag_no from dagwise_zone_info d left join villagewise_zone_info v on d.unique_village_code=v.unique_village_code 
        //         and v.zone_code::int=d.zone_id::int and v.subclass_code::int=d.subclass_id::int
        //         join location l on l.uuid=d.unique_village_code::bigint
        //         join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
        //         b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
        //         where d.flag='1' and  (v.flag='0' or v.land_rate is null or v.land_rate='' ) and l.nc_btad is null and b.dag_flag_type is null";


        $sql ="SELECT d.dag_no
                        FROM dagwise_zone_info d
                        LEFT JOIN villagewise_zone_info v ON d.unique_village_code = v.unique_village_code
                            AND v.zone_code::int = d.zone_id::int
                            AND v.subclass_code::int = d.subclass_id::int
                        JOIN location l ON l.uuid = d.unique_village_code::bigint
                        JOIN chitha_basic b ON b.subdiv_code = d.subdiv_code
                            AND b.cir_code = d.cir_code
                            AND b.mouza_pargona_code = d.mouza_pargona_code
                            AND b.lot_no = d.lot_no
                            AND b.vill_townprt_code = d.vill_code
                            AND b.dag_no = d.dag_no
                        WHERE d.flag = '1'
                            AND (v.flag = '0' OR v.land_rate IS NULL OR v.land_rate = '')
                            AND l.nc_btad IS NULL
                            AND b.dag_flag_type IS NULL
                            AND NOT EXISTS (
                                SELECT 1
                                FROM chitha_dag_all_flag_details_final df
                                WHERE df.uuid = d.unique_village_code::bigint
                                    AND df.dag_no = d.dag_no
                                    AND (df.is_eroded = '7' OR df.is_landclassless = '4' OR df.is_sad = '3')
                            )";

        $data_rows = $this->db->query($sql)->num_rows();
        // $data_rows = '0';


        if ($data_rows > 0) {
            echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> There are ' . $data_rows . ' dags for which Zonal Value are missing. Kindly get it rectified before Uploading the certificate</span>';
        } else {
            $folder = ZONAL_REPORT_BASE_DIR;
            $time_format = "%d_%M_%Y_%h_%i_%s_%A";
            $time = mdate($time_format);
            // $file = "zonal_report_" . date('mdYhis', time()) . uniqid();
            $file = "zonal_report_dc_" . $time . uniqid();

            if (!file_exists($folder)) {
                mkdir($folder, 0777, true);
                $path =  $folder;
            } else {
                $path = $folder;
            }

            $config = array(
                'upload_path' => $path,
                'allowed_types' => 'pdf',
                'max_size' => '15000',
                // 'encrypt_name' => 'TRUE'
                'overwrite' => TRUE,
                'file_name' => $file,
            );

            if (isset($_FILES['file']['name'])) {
                if (0 < $_FILES['file']['error']) {
                    echo 'Error during file upload' . $_FILES['file']['error'];
                } else {
                    if (file_exists($folder . $_FILES['file']['name'])) {
                        echo 'File already exists : '.  $folder . $_FILES['file']['name'];
                    } else {

                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('file')) {
                            $errors = $this->upload->display_errors();
                            echo '<span class="text-danger">' . $errors . '</span>';
                        } else {
                            //insert to DB
                            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                            $report_name = $file . '.' . $ext;
                            $report_upload_path = $path . $file . '.' . $ext;
                            $report = [
                                'dist_code' => $dist_code,
                                'subdiv_code' => '00',
                                'cir_code' => '00',
                                'mouza_pargona_code' => "00",
                                'lot_no' => "00",
                                'user_code' => $user_code,
                                'ip' => $this->utilityclass->get_client_ip(),
                                'is_active' => "A",
                                'report_name' => $report_name,
                                'report_by' => 'DC',
                                'report_upload_path' => $report_upload_path,
                                'date_upload' => date('Y-m-d h:i:s'),
                            ];
                            $insUpload = $this->db->insert('uploaded_report', $report);

                            if ($insUpload === TRUE) {
                                echo '<span class="bg-success blink_text style="font-size:22px""><i class="fa fa-check-circle"></i> Report Uploaded Successfully</span>';
                            } else {
                                echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> Report Not Uploaded !! Kindly Contact System Administrator</span>';
                                return false;
                            }
                            //insert end
                        }
                    }
                }
            } else {
                echo '<span  class="bg-yellow blink_text" style="font-size:22px"><i class="fa fa-exclamation-circle"></i> Please choose a file to Upload</span>';
            }
        }
    }

    public function verificationReportDC()
    {
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');

        $adc_name = $this->utilityclass->getSelectedADCName($dist_code, $user_code);
        $adc_name = $adc_name->username;
        $dist_name = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code)->locname_eng;

        //Check for missing zonal Value
        // $sql = "select 
		// 		d.dag_no from dagwise_zone_info d left join villagewise_zone_info v on d.unique_village_code=v.unique_village_code 
        //         and v.zone_code::int=d.zone_id::int and v.subclass_code::int=d.subclass_id::int
        //         join location l on l.uuid=d.unique_village_code::bigint 
        //         join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
        //         b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
        //         where d.flag='1' and  (v.flag='0' or v.land_rate is null or v.land_rate='' ) and l.nc_btad is null and b.dag_flag_type is null";

        $sql ="SELECT d.dag_no
                        FROM dagwise_zone_info d
                        LEFT JOIN villagewise_zone_info v ON d.unique_village_code = v.unique_village_code
                            AND v.zone_code::int = d.zone_id::int
                            AND v.subclass_code::int = d.subclass_id::int
                        JOIN location l ON l.uuid = d.unique_village_code::bigint
                        JOIN chitha_basic b ON b.subdiv_code = d.subdiv_code
                            AND b.cir_code = d.cir_code
                            AND b.mouza_pargona_code = d.mouza_pargona_code
                            AND b.lot_no = d.lot_no
                            AND b.vill_townprt_code = d.vill_code
                            AND b.dag_no = d.dag_no
                        WHERE d.flag = '1'
                            AND (v.flag = '0' OR v.land_rate IS NULL OR v.land_rate = '')
                            AND l.nc_btad IS NULL
                            AND b.dag_flag_type IS NULL
                            AND NOT EXISTS (
                                SELECT 1
                                FROM chitha_dag_all_flag_details_final df
                                WHERE df.uuid = d.unique_village_code::bigint
                                    AND df.dag_no = d.dag_no
                                    AND (df.is_eroded = '7' OR df.is_landclassless = '4' OR df.is_sad = '3')
                            )";

        $data_rows = $this->db->query($sql)->num_rows();

        if ($data_rows > 0) {

            $this->session->set_flashdata('message', 'There are ' . $data_rows . ' dags for which Zonal Value are missing. Kindly get it rectified before generating the certificate');
            redirect(base_url() . "index.php/ZoneInformationController/zonalinformationDetailsDC");
        } else {

            //report

            $sql = "select 
            (select loc_name from location where dist_code=v.dist_code and subdiv_code=v.subdiv_code  and cir_code='00') as subdivision,
            (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code='00') as circle,
	        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no='00') as mouza_name,
	        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no=v.lot_no and vill_townprt_code='00000') as lot_name,
	        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no=v.lot_no and vill_townprt_code=v.vill_code) as village_name,
	        d.dag_no, v.zone_name, v.subclass_name,v.land_rate
            from (SELECT * FROM dagwise_zone_info TABLESAMPLE SYSTEM (5) limit 100) d join  villagewise_zone_info v
            on v.unique_village_code=d.unique_village_code
            and v.zone_code =d.zone_id::int and v.subclass_code=d.subclass_id::int
             join location l on l.uuid=d.unique_village_code::bigint
             join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
            b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
             where d.flag='1' and v.flag='1' and l.nc_btad is null and b.dag_flag_type is null";
            $zonalDetails = $this->db->query($sql)->result();
            include 'vendor\mpdf\vendor\autoload.php';
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 9,
                'default_font' => 'dejavusans',
                'orientation' => 'P'
            ]);
            $mpdf->SetWatermarkText('DHARITREE');
            $mpdf->showWatermarkText = true;
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            ini_set("pcre.backtrack_limit", "500000000");
            ini_set('memory_limit', '4096M');
            set_time_limit(0);
            $html = '';
            $htmlTag = '';
            $htmlTag1 = '';
            $htmlTag2 = '';


            $htmlTag .= '<br><br><p style="text-align: center  ;font-size:20px">District: ' . $dist_name . '</p>';
            $htmlTag1 .= '<h3 style="text-align: center; text-transform: uppercase"><u>Zonal Certification Report</u></h3>';
            $htmlTag2 .= '<p style="height: 60%; width: 60%;  margin: 10px; display: flex;">
         <p style="align-self: flex-end; text-align: right;font-size:15px; "> ' . $adc_name . '<br>DC (' . ($dist_name) . ')</p>
        </p>';

            $htmlTag3 .= '<br><br><p style="text-align: center;font-size:15px">This is to certify that i have checked following 100 dags generated
            randomly  by Dharitree for Zonal Value for the district ' . $dist_name . '.</p>';

            $table1 = ' <table cellpadding="5px" autosize="1" border="1" width="100%" style="overflow: wrap">
                    <thead>
                    <tr>
                        <th  >Subdiv</th>
                        <th >Circle </th>
                        <th >Mouza </th>
                        <th >Lot </th>
                        <th >Village </th>
                        <th >Dag. No. </th>
                        <th >Zone </th>
                        <th  >Subclass </th>
                        <th >Zonal Value(Land Rate)</th>
                    </tr>
                    </thead>
                    <tbody>';
            foreach ($zonalDetails as $details) {
                $table2 .= '<tr>
                        <td >' . $details->subdivision . '</td>
                        <td>' . $details->circle . '</td>
                        <td>' . $details->mouza_name . '</td>
                        <td>' . $details->lot_name . '</td>
                        <td>' . $details->village_name . '</td>
                        <td>' . $details->dag_no . '</td>
                        <td>' . $details->zone_name . '</td>
                        <td >' . $details->subclass_name . '</td>
                        <td>' . $details->land_rate . '</td>
                    </tr>';
            }
            $table3 = '</tbody></table>';
            $table = $table1 . $table2 . $table3;
            $final = $htmlTag . $htmlTag1 . $htmlTag3 . $table  . $htmlTag2;
            $mpdf->writeHTML($final);
            header('Content-type: application/pdf');
            $mpdf->Output('Zonal_Certificate_report_dc.pdf', 'I');
            //report

        }
    }




    public function zonalValueCertificateReportLM()
    {

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');

        // $sql = "select d.dag_no from dagwise_zone_info d left join villagewise_zone_info v on d.unique_village_code=v.unique_village_code 
        //         and v.zone_code::int=d.zone_id::int and v.subclass_code::int=d.subclass_id::int
        //         join location l on l.uuid=d.unique_village_code::bigint 
        //         join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
        //         b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
        //         where d.flag='1' and  (v.flag='0' or v.land_rate is null or v.land_rate='' ) 
        // 		and d.subdiv_code='$subdiv_code' and d.cir_code='$cir_code' and d.mouza_pargona_code = '$mouza_pargona_code' and d.lot_no ='$lot_no'
        //         and l.nc_btad is null and b.dag_flag_type is null";


        $sql ="SELECT d.dag_no
                        FROM dagwise_zone_info d
                        LEFT JOIN villagewise_zone_info v ON d.unique_village_code = v.unique_village_code
                            AND v.zone_code::int = d.zone_id::int
                            AND v.subclass_code::int = d.subclass_id::int
                        JOIN location l ON l.uuid = d.unique_village_code::bigint
                        JOIN chitha_basic b ON b.subdiv_code = d.subdiv_code
                            AND b.cir_code = d.cir_code
                            AND b.mouza_pargona_code = d.mouza_pargona_code
                            AND b.lot_no = d.lot_no
                            AND b.vill_townprt_code = d.vill_code
                            AND b.dag_no = d.dag_no
                        WHERE d.flag = '1'
                            AND (v.flag = '0' OR v.land_rate IS NULL OR v.land_rate = '')
                            AND d.subdiv_code = '$subdiv_code'
                            AND d.cir_code = '$cir_code'
                            AND d.mouza_pargona_code = '$mouza_pargona_code'
                            AND d.lot_no = '$lot_no'
                            AND l.nc_btad IS NULL
                            AND b.dag_flag_type IS NULL
                            AND NOT EXISTS (
                                SELECT 1
                                FROM chitha_dag_all_flag_details_final df
                                WHERE df.uuid = d.unique_village_code::bigint
                                    AND df.dag_no = d.dag_no
                                    AND (df.is_eroded = '7' OR df.is_landclassless = '4' OR df.is_sad = '3')
                            )";

        // $data_rows = $this->db->query($sql)->num_rows();
        $data_rows = 0;

        if ($data_rows > 0) {
            $this->session->set_flashdata('message', 'There are ' . $data_rows . ' dags for which Zonal Value are missing. Kindly get it rectified before generating the certificate');
            redirect(base_url() . "index.php/ZoneInformationController/zonalValueReportLM");
        } else {
            $dist_name = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code)->locname_eng;
            $subDiv_name = $this->UtilsModel->getEngSubdivNameByDistCode($dist_code, $subdiv_code)->locname_eng;
            $circle_name = $this->UtilsModel->getEngCircleDetails($dist_code, $subdiv_code, $cir_code)->locname_eng;
            $lot_name = $this->UtilsModel->getEngLotDetails($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no)->locname_eng;
            $lm_name = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code,)->lm_name;
            $sql = "select
        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no=v.lot_no and vill_townprt_code='00000') as lot_name,
        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no=v.lot_no and vill_townprt_code=v.vill_code) as village_name,
        (select zone_name from zonal_master where zone_code = v.zone_code::int),
        (select subclass_name from subclass_master where subclass_code = v.subclass_code::int), v.land_rate, string_agg(distinct(d.dag_no),',') as dag
        from villagewise_zone_info v join dagwise_zone_info d on v.unique_village_code=d.unique_village_code
            and v.zone_code =d.zone_id::int and v.subclass_code=d.subclass_id::int
             join location l on l.uuid=d.unique_village_code::bigint
             
            where d.flag='1' and v.flag='1' and v.subdiv_code ='$subdiv_code' and v.cir_code ='$cir_code' and v.mouza_pargona_code ='$mouza_pargona_code' and v.lot_no ='$lot_no' and l.nc_btad is null
            group by v.subdiv_code, v.cir_code, v.mouza_pargona_code, v.lot_no, v.vill_code, v.zone_code, v.subclass_code, v.land_rate";
            $zonalDetails = $this->db->query($sql)->result();

            include 'vendor\mpdf\vendor\autoload.php';
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 9,
                'default_font' => 'dejavusans',
                'orientation' => 'L'
            ]);
            $mpdf->SetWatermarkText('DHARITREE');
            $mpdf->showWatermarkText = true;
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            ini_set("pcre.backtrack_limit", "500000000");
            ini_set('memory_limit', '4096M');
            set_time_limit(0);
            $html = '';
            $htmlTag = '';
            $htmlTag1 = '';
            $htmlTag2 = '';


            $htmlTag .= '<h3 style="text-align: center"><u>Dag wise zonal rate</u></h3>';
            $htmlTag1 .= '<br><p style="text-align: center  ;font-size:20px">District: ' . $dist_name . ' &nbsp; Subdiv: ' . $subDiv_name . ' &nbsp; Circle: ' . $circle_name . ' &nbsp; Lot: ' . $lot_name . '</p>';
            $htmlTag2 .= '<br><br><p style="text-align: right ;font-size:15px">' . $lm_name . '</p>';
            $htmlTag3 .= '<p style="text-align: right">Lot Mandal ( ' . $lot_name . ' )</p>';

            $htmlTag4 .= '<br><p style="text-align: center;font-size:15px">This is to certify that i have checked 100% of the Zonal Value entries for the Lot:  ' . $lot_name . '.</p>';

            $table1 = ' <table cellpadding="5px" autosize="1" border="1" width="100%" style="overflow: wrap">
                    <thead>
                    <tr>
                        <th >Lot </th>
                        <th >Village </th>
                        <th >Zone </th>
                        <th  >Subclass </th>
                        <th >Zonal Value(Land Rate)</th>
                        <th >Dag No(s)</th>
                    </tr>
                    </thead>
                    <tbody>';
            foreach ($zonalDetails as $details) {
                $table2 .= '<tr>
                        <td>' . $details->lot_name . '</td>
                        <td>' . $details->village_name . '</td>
                        <td>' . $details->zone_name . '</td>
                        <td >' . $details->subclass_name . '</td>
                        <td>' . $details->land_rate . '</td>
                        <td> ' . $details->dag . '</td>
                    </tr>';
            }
            $table3 = '</tbody></table>';
            $table = $table1 . $table2 . $table3;
            $final = $htmlTag1 . $htmlTag4 . $htmlTag . $table . $htmlTag2 . $htmlTag3;
            $mpdf->writeHTML($final);
            header('Content-type: application/pdf');
            $mpdf->Output('Dagwise_Zonal_Value_Report_lm.pdf', 'I');
        }
    }



    function uploadZonalReportLM()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $user_code = $this->session->userdata('user_code');

        if ($subdiv_code != '00' && $cir_code != '00' && $mouza_pargona_code != '00' && $lot_no != '00') {

            // $sql = "select d.dag_no from dagwise_zone_info d left join villagewise_zone_info v on d.unique_village_code=v.unique_village_code 
            //     and v.zone_code::int=d.zone_id::int and v.subclass_code::int=d.subclass_id::int
            //     join location l on l.uuid=d.unique_village_code::bigint 
            //     join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
            //     b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
            //     where d.flag='1' and  (v.flag='0' or v.land_rate is null or v.land_rate='' ) 
        	// 	and d.subdiv_code='$subdiv_code' and d.cir_code='$cir_code' and d.mouza_pargona_code = '$mouza_pargona_code' and d.lot_no ='$lot_no' and l.nc_btad is null and b.dag_flag_type is null";


            $sql ="SELECT d.dag_no
                        FROM dagwise_zone_info d
                        LEFT JOIN villagewise_zone_info v ON d.unique_village_code = v.unique_village_code
                            AND v.zone_code::int = d.zone_id::int
                            AND v.subclass_code::int = d.subclass_id::int
                        JOIN location l ON l.uuid = d.unique_village_code::bigint
                        JOIN chitha_basic b ON b.subdiv_code = d.subdiv_code
                            AND b.cir_code = d.cir_code
                            AND b.mouza_pargona_code = d.mouza_pargona_code
                            AND b.lot_no = d.lot_no
                            AND b.vill_townprt_code = d.vill_code
                            AND b.dag_no = d.dag_no
                        WHERE d.flag = '1'
                            AND (v.flag = '0' OR v.land_rate IS NULL OR v.land_rate = '')
                            AND d.subdiv_code = '$subdiv_code'
                            AND d.cir_code = '$cir_code'
                            AND d.mouza_pargona_code = '$mouza_pargona_code'
                            AND d.lot_no = '$lot_no'
                            AND l.nc_btad IS NULL
                            AND b.dag_flag_type IS NULL
                            AND NOT EXISTS (
                                SELECT 1
                                FROM chitha_dag_all_flag_details_final df
                                WHERE df.uuid = d.unique_village_code::bigint
                                    AND df.dag_no = d.dag_no
                                    AND (df.is_eroded = '7' OR df.is_landclassless = '4' OR df.is_sad = '3')
                            )";

            $data_rows = $this->db->query($sql)->num_rows();

            if ($data_rows > 0) {
                echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> There are ' . $data_rows . ' dags for which Zonal Value are missing. Kindly get it rectified before Uploading the certificate</span>';
            } else {
                $folder = ZONAL_REPORT_BASE_DIR;
                $time_format = "%d_%M_%Y_%h_%i_%s_%A";
                $time = mdate($time_format);
                // $file = "zonal_report_" . date('mdYhis', time()) . uniqid();
                $file = "zonal_report_lm_" . $time . uniqid();

                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    $path = $folder;
                } else {
                    $path = $folder;
                }

                $config = array(
                    'upload_path' => $path,
                    'allowed_types' => 'pdf',
                    'max_size' => '15000',
                    // 'encrypt_name' => 'TRUE'
                    'overwrite' => TRUE,
                    'file_name' => $file,
                );

                if (isset($_FILES['file']['name'])) {
                    if (0 < $_FILES['file']['error']) {
                        echo 'Error during file upload' . $_FILES['file']['error'];
                    } else {
                        if (file_exists($folder . $_FILES['file']['name'])) {
                            echo 'File already exists : '. $folder . $_FILES['file']['name'];
                        } else {
                            //Check for previous Report
                            $sql = "SELECT * FROM uploaded_report WHERE subdiv_code ='$subdiv_code' AND cir_code='$cir_code' AND mouza_pargona_code ='$mouza_pargona_code' AND lot_no ='$lot_no' AND user_code='$user_code' AND is_active in('E','R','A')";
                            $previousReport = $this->db->query($sql)->num_rows();

                            if ($previousReport >= 1) {
                                $this->load->library('upload', $config);
                                if (!$this->upload->do_upload('file')) {
                                    $errors = $this->upload->display_errors();
                                    echo '<span class="text-danger">' . $errors . '</span>';
                                } else {
                                    $updateData = [
                                        'is_active' => 'D',
                                    ];
                                    $where = [
                                        'dist_code' => $dist_code,
                                        'subdiv_code' => $subdiv_code,
                                        'cir_code' => $cir_code,
                                        'user_code' => $user_code,
                                    ];
                                    $updateReportCo = $this->db->set($updateData)->where($where)->update('uploaded_report');

                                    if ($updateReportCo != 1) {

                                        echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> Report Not Uploaded !! Kindly Contact System Administrator</span>';
                                        return false;
                                    } else {
                                        //insert to DB
                                        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                                        $report_name = $file . '.' . $ext;
                                        $report_upload_path = $path . $file . '.' . $ext;
                                        $report = [
                                            'dist_code' => $dist_code,
                                            'subdiv_code' => $subdiv_code,
                                            'cir_code' => $cir_code,
                                            'mouza_pargona_code' => $mouza_pargona_code,
                                            'lot_no' => $lot_no,
                                            'user_code' => $user_code,
                                            'ip' => $this->utilityclass->get_client_ip(),
                                            'is_active' => "E",
                                            'report_name' => $report_name,
                                            'report_by' => 'LM',
                                            'report_upload_path' => $report_upload_path,
                                            'date_upload' => date('Y-m-d h:i:s'),
                                        ];
                                        $insUpload = $this->db->insert('uploaded_report', $report);

                                        if ($insUpload != 1) {
                                            echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> Report Not Uploaded !! Kindly Contact System Administrator</span>';
                                            return false;
                                        } else {
                                            echo '<span class="bg-success blink_text style="font-size:22px""><i class="fa fa-check-circle"></i> Report Uploaded Successfully</span>';
                                        }
                                    }
                                }
                            } else {

                                $this->load->library('upload', $config);
                                if (!$this->upload->do_upload('file')) {
                                    $errors = $this->upload->display_errors();
                                    echo '<span class="text-danger">' . $errors . '</span>';
                                } else {
                                    //insert to DB
                                    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                                    $report_name = $file . '.' . $ext;
                                    $report_upload_path = $path . $file . '.' . $ext;
                                    $report = [
                                        'dist_code' => $dist_code,
                                        'subdiv_code' => $subdiv_code,
                                        'cir_code' => $cir_code,
                                        'mouza_pargona_code' => $mouza_pargona_code,
                                        'lot_no' => $lot_no,
                                        'user_code' => $user_code,
                                        'ip' => $this->utilityclass->get_client_ip(),
                                        'is_active' => "E",
                                        'report_name' => $report_name,
                                        'report_by' => 'LM',
                                        'report_upload_path' => $report_upload_path,
                                        'date_upload' => date('Y-m-d h:i:s'),
                                    ];
                                    $insUpload = $this->db->insert('uploaded_report', $report);

                                    if ($insUpload === TRUE) {
                                        echo '<span class="bg-success blink_text style="font-size:22px""><i class="fa fa-check-circle"></i> Report Uploaded Successfully</span>';
                                    } else {
                                        echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> Report Not Uploaded !! Kindly Contact System Administrator</span>';
                                        return false;
                                    }
                                    //insert end
                                }
                            }
                        }
                    }
                } else {
                    echo '<span  class="bg-yellow blink_text" style="font-size:22px"><i class="fa fa-exclamation-circle"></i> Please choose a file to Upload</span>';
                }
            }
        } else {

            echo '<span  class="bg-yellow blink_text" style="font-size:22px"><i class="fa fa-exclamation-circle"></i> Session Mismatched</span>';
        }
    }

    public function viewUploadedReportByLMCO($subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code)
    {

        $sql = "SELECT report_upload_path FROM uploaded_report WHERE subdiv_code ='$subdiv_code' AND cir_code='$cir_code' AND  mouza_pargona_code ='$mouza_pargona_code' AND lot_no ='$lot_no' AND user_code ='$user_code'  AND is_active in('E','A','R')";
        $report = $this->db->query($sql)->row();

        $filename = $report->report_upload_path;

        header("Content-type: application/pdf");
        header("Content-Length: " . filesize($filename));
        readfile($filename);
    }


    //******* Zonal Details Missing Report Villagewise ********//
    public function zonalDetailsMissingReportLM()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code  = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $data['dist_code'] = $dist_code;
        $data['subdiv_code'] = $subdiv_code;
        $data['cir_code'] = $cir_code;

        //Check for zonal Missing Dags
        $sql = "select 
				(select loc_name from location where subdiv_code=d.subdiv_code and cir_code=d.cir_code and mouza_pargona_code=d.mouza_pargona_code and lot_no=d.lot_no and vill_townprt_code='00000') as Lot,
				(select loc_name from location where uuid=d.unique_village_code::bigint) as Village,
                (select zone_name from zonal_master where zone_code::int=d.zone_id::int) as Zone,
				(select subclass_name from subclass_master where subclass_code::int=d.subclass_id::int) as Subclass,
				
				d.dag_no from dagwise_zone_info d left join villagewise_zone_info v on d.unique_village_code=v.unique_village_code 
                and v.zone_code::int=d.zone_id::int and v.subclass_code::int=d.subclass_id::int
                join location l on l.uuid=d.unique_village_code::bigint
                join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
                b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
                 where d.flag='1' and  (v.flag='0' or v.land_rate is null or v.land_rate='' ) 
				and d.subdiv_code='$subdiv_code' and d.cir_code='$cir_code'  and d.mouza_pargona_code = '$mouza_pargona_code' and d.lot_no ='$lot_no' and l.nc_btad is null and b.dag_flag_type is null";

        $data_rows = $this->db->query($sql)->num_rows();


        if ($data_rows <= 0) {
            $this->session->set_flashdata('message', 'No Missing Zonal Value Found');
            redirect(base_url() . "index.php/Home");
        } else {
            $time_format = "%d-%M-%Y-%h-%i-%s-%A";
            $time = mdate($time_format);
            $data = $this->db->query($sql)->result_array();
            $file_name = "Zonal_Missing_Report_lm" . $time . '.xlsx';
            $this->load->model('UtilsModel');
            $this->UtilsModel->downloadExcelReport($file_name, $data);
        }
    }



    //******* Zonal Details Missing Report Villagewise ********//
    public function zonalDetailsMissingReportDCADC()
    {
        $dist_code = $this->session->userdata('dist_code');
        $data['dist_code'] = $dist_code;

        $sql = "select 
				(select loc_name from location where subdiv_code=d.subdiv_code and cir_code=d.cir_code and mouza_pargona_code='00') as Circle,
				(select loc_name from location where subdiv_code=d.subdiv_code and cir_code=d.cir_code and mouza_pargona_code=d.mouza_pargona_code and lot_no='00') as Mouza,
				(select loc_name from location where subdiv_code=d.subdiv_code and cir_code=d.cir_code and mouza_pargona_code=d.mouza_pargona_code and lot_no=d.lot_no and vill_townprt_code='00000') as Lot,
				(select loc_name from location where uuid=d.unique_village_code::bigint) as Village,
                (select zone_name from zonal_master where zone_code::int=d.zone_id::int) as Zone,
				(select subclass_name from subclass_master where subclass_code::int=d.subclass_id::int) as Subclass,
				
				d.dag_no from dagwise_zone_info d left join villagewise_zone_info v on d.unique_village_code=v.unique_village_code 
                and v.zone_code::int=d.zone_id::int and v.subclass_code::int=d.subclass_id::int 
                join location l on l.uuid=d.unique_village_code::bigint
                join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
                b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
                where d.flag='1' and  (v.flag='0' or v.land_rate is null or v.land_rate='' ) and l.nc_btad is null and b.dag_flag_type is null";

        $data_rows = $this->db->query($sql)->num_rows();

        if ($data_rows <= 0) {
            $this->session->set_flashdata('message', 'No Missing Zonal Value Found');
            redirect(base_url() . "index.php/Home");
        } else {
            $time_format = "%d-%M-%Y-%h-%i-%s-%A";
            $time = mdate($time_format);
            $data = $this->db->query($sql)->result_array();
            $file_name = "Zonal_Missing_Report" . $time . '.xlsx';
            $this->load->model('UtilsModel');
            $this->UtilsModel->downloadExcelReport($file_name, $data);
        }
    }



    function zonalValueCertificateReportCO()
    {
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');

        $dist_name = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code)->locname_eng;
        $subDiv_name = $this->UtilsModel->getEngSubdivNameByDistCode($dist_code, $subdiv_code)->locname_eng;
        $circle_name = $this->UtilsModel->getEngCircleDetails($dist_code, $subdiv_code, $cir_code)->locname_eng;
        $co_name = $this->utilityclass->getSelectedCOName($dist_code, $subdiv_code, $cir_code, $user_code);


        //Check for Zonal Value Missing Dags
        // $sql = "select d.dag_no from dagwise_zone_info d left join villagewise_zone_info v on d.unique_village_code=v.unique_village_code 
        //         and v.zone_code::int=d.zone_id::int and v.subclass_code::int=d.subclass_id::int
		// 		join location l on l.uuid=d.unique_village_code::bigint 
        //         join chitha_basic b on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and b.mouza_pargona_code = d.mouza_pargona_code
        //         and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
		// 		where d.flag='1' and  (v.flag='0' or v.land_rate is null or v.land_rate='' ) 
        // 		and d.subdiv_code='$subdiv_code' and d.cir_code='$cir_code' and l.nc_btad is null and b.dag_flag_type is null";


        $sql = "SELECT d.dag_no
                    FROM dagwise_zone_info d
                    LEFT JOIN villagewise_zone_info v ON d.unique_village_code = v.unique_village_code
                        AND v.zone_code::int = d.zone_id::int
                        AND v.subclass_code::int = d.subclass_id::int
                    JOIN location l ON l.uuid = d.unique_village_code::bigint
                    JOIN chitha_basic b ON b.subdiv_code = d.subdiv_code
                        AND b.cir_code = d.cir_code
                        AND b.mouza_pargona_code = d.mouza_pargona_code
                        AND b.lot_no = d.lot_no
                        AND b.vill_townprt_code = d.vill_code
                        AND b.dag_no = d.dag_no
                    WHERE d.flag = '1'
                        AND (v.flag = '0' OR v.land_rate IS NULL OR v.land_rate = '')
                        AND d.subdiv_code = '$subdiv_code'
                        AND d.cir_code = '$cir_code'
                        AND l.nc_btad IS NULL
                        AND b.dag_flag_type IS NULL
                        AND NOT EXISTS (
                            SELECT 1
                            FROM chitha_dag_all_flag_details_final df
                            WHERE df.uuid = d.unique_village_code::bigint
                                AND df.dag_no = d.dag_no
                                AND (df.is_eroded = '7' OR df.is_landclassless = '4' OR df.is_sad = '3')
                        )";

        $data_rows = $this->db->query($sql)->num_rows();
        // $data_rows = 0;

        if ($data_rows > 0) {

            $this->session->set_flashdata('message', 'There are ' . $data_rows . ' dags for which Zonal Value are missing. Kindly get it rectified before generating the certificate');
            redirect(base_url() . "index.php/ZoneInformationController/zonalInformationDetails_dc_co");
        } else {
            $sql = "select
        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no='00') as mouza_name,
        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no=v.lot_no and vill_townprt_code='00000') as lot_name,
        (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no=v.lot_no and vill_townprt_code=v.vill_code) as village_name,
        v.zone_name, v.subclass_name, v.land_rate, string_agg(distinct(d.dag_no),''',''') as dag,v.subdiv_code , v.cir_code ,v.mouza_pargona_code ,v.lot_no ,v.vill_code
        from (select * from villagewise_zone_info where subdiv_code ='$subdiv_code' and cir_code ='$cir_code') v 
        join (select * from dagwise_zone_info where subdiv_code ='$subdiv_code' and cir_code ='$cir_code') d  on v.unique_village_code=d.unique_village_code and v.zone_code =d.zone_id::int and v.subclass_code=d.subclass_id::int
        join  (select * from location where subdiv_code ='$subdiv_code' and cir_code ='$cir_code') l  on l.uuid=d.unique_village_code::bigint where d.flag='1' and v.flag='1' and v.subdiv_code ='$subdiv_code' and v.cir_code ='$cir_code'
        and l.nc_btad is null group by v.subdiv_code, v.cir_code, v.mouza_pargona_code, v.lot_no, v.vill_code, v.zone_name, v.subclass_name, v.land_rate";
            $data = $this->db->query($sql)->result();

            //mpdf
            include 'vendor\mpdf\vendor\autoload.php';
            $mpdf = new \Mpdf\Mpdf([
                'default_font_size' => 9,
                'default_font' => 'dejavusans',
                'orientation' => 'L'
            ]);
            $mpdf->SetWatermarkText('DHARITREE');
            $mpdf->showWatermarkText = true;
            $mpdf->watermarkTextAlpha = 0.1;
            $mpdf->watermark_font = 'DejaVuSansCondensed';
            $mpdf->autoScriptToLang = true;
            $mpdf->autoLangToFont = true;
            ini_set("pcre.backtrack_limit", "500000000");
            ini_set('memory_limit', '4096M');
            set_time_limit(0);
            $htmlTag = '';
            $htmlTag1 = '';
            $htmlTag2 = '';

            $htmlTag .= '<h3 style="text-align: center"><u>Dag wise zonal rate</u></h3>';
            $htmlTag1 .= '<br><br><p style="text-align: center  ;font-size:20px">District: ' . $dist_name . ' &nbsp; Subdiv: ' . $subDiv_name . ' &nbsp; Circle: ' . $circle_name . '</p>';
            $htmlTag2 .= '<br><br><p style="text-align: right  ;font-size:15px">' . $co_name->username . '</p>';
            $htmlTag3 .= '<p style="text-align: right">Circle Officer ( ' . $circle_name . ' )</p>';
            $htmlTag4 .= '<br><p style="text-align: center;font-size:15px">This is to certify that i have checked 100% of the Zonal Value entries for the Circle: ' . $circle_name . '.</p>';
            $table1 = ' <table cellpadding="5px" autosize="1" border="1" width="100%" style="overflow: wrap">
                    <thead>
                        <tr>
                            <th  >Mouza </th>
                            <th >Lot </th>
                            <th >Village </th>
                            <th >Zone </th>
                            <th  >Subclass </th>
                            <th >Zonal Value(Land Rate)</th>
                            <th >Dag No(s)</th>
                        </tr>
                    </thead>
                <tbody>';

            $index = 0;
            foreach ($data as $d) {
                $in_array = '\'' . $d->dag . '\'';

                $sql = "select string_agg(dag_no,',') as dags from chitha_basic cb  where subdiv_code=? and cir_code =? and mouza_pargona_code =?
       	                and lot_no =? and vill_townprt_code=?  and dag_no in ($in_array) and dag_flag_type is null";

                $dags = $this->db->query($sql, array($d->subdiv_code, $d->cir_code, $d->mouza_pargona_code, $d->lot_no, $d->vill_code));
                // log_message('error', $this->db->last_query());
                $dags = $dags->row();

                $table2 .=
                    '<tr>
                    <td >' . $d->mouza_name . '</td>
                    <td>' . $d->lot_name . '</td>
                    <td>' . $d->village_name . '</td>
                    <td>' . $d->zone_name . '</td>
                    <td >' . $d->subclass_name . '</td>
                    <td>' . $d->land_rate . '</td>
                    <td> ' . $d->dag . '</td>
                </tr>';
            }

            $table3 = '</tbody></table>';
            $table = $table1 . $table2 . $table3;
            $final = $htmlTag1 . $htmlTag4 . $htmlTag . $table . $htmlTag2 . $htmlTag3;
            $mpdf->writeHTML($final);
            header('Content-type: application/pdf');
            $mpdf->Output('Dagwise_Zonal_Value_Report_CO.pdf', 'I');
        }
    }



    ///Report generated for each circle by ADC

    public function circleWiseGenerateReportADC()
    {
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');
        $subdiv_code = $this->input->get('subdiv_code');
        $cir_code = $this->input->get('cir_code');

        $adc_name = $this->utilityclass->getSelectedADCName($dist_code, $user_code);
        $circle_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
        $adc_name = $adc_name->username;
        $dist_name = $this->UtilsModel->getEngDistrictNameByDistCode($dist_code)->locname_eng;


        $sql1 = "select distinct  on (unique_village_code ) * from dagwise_zone_info where dist_code ='$dist_code' and subdiv_code ='$subdiv_code' and cir_code ='$cir_code'";
        $zonalDetails1 = $this->db->query($sql1)->result();

        $zonalDetails = array();
        foreach ($zonalDetails1 as $zonal) {
            $st_time = microtime(true);
            // Get Location name From Location
            $sql = "select 
            (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code='00') as circle,
            (select loc_name from location where subdiv_code=v.subdiv_code and cir_code=v.cir_code and mouza_pargona_code=v.mouza_pargona_code and lot_no=v.lot_no and vill_townprt_code=v.vill_code) as village_name,
            d.dag_no, v.zone_name, v.subclass_name,v.land_rate
            from (SELECT * FROM dagwise_zone_info where unique_village_code = ? ) d join 
             (select * from villagewise_zone_info where unique_village_code = ?)  v 
            on v.zone_code =d.zone_id::int and v.subclass_code=d.subclass_id::int
            join location l on l.uuid=d.unique_village_code::bigint 
            join (select * From chitha_basic where subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? ) b 
            on b.subdiv_code = d.subdiv_code and b.cir_code = d.cir_code and
            b.mouza_pargona_code = d.mouza_pargona_code and b.lot_no = d.lot_no and b.vill_townprt_code = d.vill_code and b.dag_no=d.dag_no
             where d.flag='1' and v.flag='1' and l.nc_btad is null and b.dag_flag_type is null limit 10 ";

            $zonalDetails[] = $this->db->query($sql, array(
                $zonal->unique_village_code, $zonal->unique_village_code, $zonal->subdiv_code,
                $zonal->cir_code, $zonal->mouza_pargona_code, $zonal->lot_no, $zonal->vill_code
            ))->result();
            log_message('error', 'last_query: ' . $this->db->last_query());
            log_message('error', 'time_taken=' . (microtime(true) - $st_time));
        }

        include 'vendor\mpdf\vendor\autoload.php';
        $mpdf = new \Mpdf\Mpdf([
            'default_font_size' => 9,
            'default_font' => 'dejavusans',
            'orientation' => 'P'
        ]);
        $mpdf->SetWatermarkText('DHARITREE');
        $mpdf->showWatermarkText = true;
        $mpdf->watermarkTextAlpha = 0.1;
        $mpdf->watermark_font = 'DejaVuSansCondensed';
        $mpdf->autoScriptToLang = true;
        $mpdf->autoLangToFont = true;
        ini_set("pcre.backtrack_limit", "500000000");
        ini_set('memory_limit', '4096M');
        set_time_limit(0);
        $html = '';
        $htmlTag = '';
        $htmlTag1 = '';
        $htmlTag2 = '';


        $htmlTag .= '<br><br><p style="text-align: center  ;font-size:16px">Circle: ' . $circle_name . ' :: District: ' . $dist_name . '</p>';
        $htmlTag1 .= '<h3 style="text-align: center; text-transform: uppercase"><u>Zonal Certification Report</u></h3>';
        $htmlTag2 .= '<p style="height: 60%; width: 60%;  margin: 10px; display: flex;">
         <p style="align-self: flex-end; text-align: right;font-size:15px; "> ' . $adc_name . '<br>ADC (' . ($dist_name) . ')</p>
        </p>';

        $htmlTag3 .= '<br><br><p style="text-align: center;font-size:15px">This is to certify that I have checked Zonal Value of  10 dags of each village 
             for circle ' . $circle_name . ' for district ' . $dist_name . '.</p>';

        $table1 = ' <table cellpadding="5px" autosize="1" border="1" width="100%" style="overflow: wrap">
                    <thead>
                    <tr>
                        <th >Circle </th>
                        <th >Village </th>
                        <th >Dag. No. </th>
                        <th >Zone </th>
                        <th  >Subclass </th>
                        <th >Zonal Value(Land Rate)</th>
                    </tr>
                    </thead>
                    <tbody>';

        foreach ($zonalDetails as $first) {

            foreach ($first as $details) {
                $table2 .= '<tr>
                        <td>' . $details->circle . '</td>
                        <td>' . $details->village_name . '</td>
                        <td>' . $details->dag_no . '</td>
                        <td>' . $details->zone_name . '</td>
                        <td >' . $details->subclass_name . '</td>
                        <td>' . $details->land_rate . '</td>
                    </tr>';
            }
        }

        $table3 = '</tbody></table>';
        $table = $table1 . $table2 . $table3;
        $final = $htmlTag . $htmlTag1 . $htmlTag3 . $table  . $htmlTag2;
        $mpdf->writeHTML($final);
        header('Content-type: application/pdf');
        $mpdf->Output('Zonal_Certificate_report_adc.pdf', 'I');
        //report
    }



    function uploadMultipleReportADC()
    {
        header('content-type:application/json');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $user_code = $this->session->userdata('user_code');

        $subdiv_code_upload = $_POST['subdiv_code_upload'];
        $cir_code_upload = $_POST['cir_code_upload'];

        $circle_name_upload = $this->utilityclass->getCircleName($dist_code, $subdiv_code_upload, $cir_code_upload);


        $folder = ZONAL_REPORT_BASE_DIR;
        $time_format = "%d_%M_%Y_%h_%i_%s_%A";
        $time = mdate($time_format);

        $file = "zonal_report_adc_" . $subdiv_code_upload . $cir_code_upload . $time . uniqid();


        if (!file_exists($folder)) {
            mkdir( $folder, 0777, true);
            $path = $folder;
        } else {
            $path = $folder;
        }

        $config = array(
            'upload_path' => $path,
            'allowed_types' => 'pdf',
            'max_size' => '15000',
            // 'encrypt_name' => 'TRUE'
            'overwrite' => TRUE,
            'file_name' => $file,
        );

        if (isset($_FILES['file']['name'])) {
            if (0 < $_FILES['file']['error']) {
                echo 'Error during file upload' . $_FILES['file']['error'];
            } else {
                if (file_exists($folder . $_FILES['file']['name'])) {
                    echo 'File already exists : '.  $folder . $_FILES['file']['name'];
                } else {
                    //Check for previous Report
                    $uploaded_status = $this->zonalinformationmodel->uploadedZonalReportDetailsByADC($subdiv_code_upload, $cir_code_upload)->num_rows();

                    if ($uploaded_status == 0) {
                        $this->load->library('upload', $config);
                        if (!$this->upload->do_upload('file')) {
                            $errors = $this->upload->display_errors();
                            echo '<span class="text-danger">' . $errors . '</span>';
                        } else {
                            //insert to DB
                            $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                            $report_name = $file . '.' . $ext;
                            $report_upload_path = $path . $file . '.' . $ext;
                            $report = [
                                'dist_code' => $dist_code,
                                'subdiv_code' => '00',
                                'cir_code' => '00',
                                'mouza_pargona_code' => "00",
                                'lot_no' => "00",
                                'user_code' => $user_code,
                                'ip' => $this->utilityclass->get_client_ip(),
                                'is_active' => "E",
                                'report_name' => $report_name,
                                'report_by' => 'ADC',
                                'report_upload_path' => $report_upload_path,
                                'date_upload' => date('Y-m-d h:i:s'),
                                'uploaded_subdiv_adc' => $subdiv_code_upload,
                                'uploaded_circle_adc' => $cir_code_upload,
                            ];
                            $insUpload = $this->db->insert('uploaded_report', $report);


                            if ($insUpload === TRUE) {
                                echo '<span class="bg-success blink_text style="font-size:22px""><i class="fa fa-check-circle"></i>ADC Zonal Report Uploaded Successfully for ' . $circle_name_upload . ' Circle </span>';
                            } else {
                                echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> Report Not Uploaded !! Kindly Contact System Administrator</span>';
                                return false;
                            }
                            //insert end
                        }
                    } else {
                        echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i>ADC Zonal Report Already Uploaded for this ' . $circle_name_upload . ' Circle</span>';
                        return false;
                    }
                }
            }
        } else {
            echo '<span  class="bg-yellow blink_text" style="font-size:22px"><i class="fa fa-exclamation-circle"></i> Please choose a file to Upload</span>';
        }
    }


    ///view Uploaded Report by ADC circlewise

    public function viewUploadedReportByADCCircleWise($uploaded_subdiv_adc, $uploaded_circle_adc, $user_code)
    {

        $sql = "SELECT report_upload_path FROM uploaded_report WHERE  user_code ='$user_code' AND uploaded_subdiv_adc ='$uploaded_subdiv_adc' AND uploaded_circle_adc ='$uploaded_circle_adc' AND report_by ='ADC'  AND is_active in('E','A','R')";
        $report = $this->db->query($sql)->row();

        $filename = $report->report_upload_path;

        header("Content-type: application/pdf");
        header("Content-Length: " . filesize($filename));
        readfile($filename);
    }


    function reUploadMultipleReportADC()
    {
        header('content-type:application/json');

        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $user_code = $this->session->userdata('user_code');

        $subdiv_code_upload = $_POST['subdiv_code_reupload'];
        $cir_code_upload = $_POST['cir_code_reupload'];

        $circle_name_upload = $this->utilityclass->getCircleName($dist_code, $subdiv_code_upload, $cir_code_upload);


        $folder = ZONAL_REPORT_BASE_DIR;
        $time_format = "%d_%M_%Y_%h_%i_%s_%A";
        $time = mdate($time_format);

        $file = "zonal_report_adc_" . $subdiv_code_upload . $cir_code_upload . $time . uniqid();


        if (!file_exists($folder)) {
            mkdir($folder, 0777, true);
            $path = $folder;
        } else {
            $path =  $folder;
        }

        $config = array(
            'upload_path' => $path,
            'allowed_types' => 'pdf',
            'max_size' => '15000',
            'overwrite' => TRUE,
            'file_name' => $file,
        );

        if (isset($_FILES['file']['name'])) {
            if (0 < $_FILES['file']['error']) {
                echo 'Error during file upload' . $_FILES['file']['error'];
            } else {
                if (file_exists($folder . $_FILES['file']['name'])) {
                    echo 'File already exists : '.  $folder . $_FILES['file']['name'];
                } else {
                    //Check for previous Report
                    $uploaded_status = $this->zonalinformationmodel->uploadedZonalReportDetailsByADC($subdiv_code_upload, $cir_code_upload)->num_rows();

                    $this->load->library('upload', $config);
                    if (!$this->upload->do_upload('file')) {
                        $errors = $this->upload->display_errors();
                        echo '<span class="text-danger">' . $errors . '</span>';
                    } else {
                        //insert to DB
                        $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
                        $report_name = $file . '.' . $ext;
                        $report_upload_path = $path . $file . '.' . $ext;
                        $report = [
                            'is_active' => "E",
                            'report_name' => $report_name,
                            'report_upload_path' => $report_upload_path,
                            'date_upload' => date('Y-m-d h:i:s'),
                        ];

                        $where = [
                            'dist_code' => $dist_code,
                            'subdiv_code' => '00',
                            'cir_code' => '00',
                            'mouza_pargona_code' => "00",
                            'lot_no' => "00",
                            'user_code' => $user_code,
                            'is_active' => "R",
                            'report_by' => 'ADC',
                            'uploaded_subdiv_adc' => $subdiv_code_upload,
                            'uploaded_circle_adc' => $cir_code_upload,
                        ];

                        $result = $this->db->where($where)->update('uploaded_report', $report);

                        if ($result === TRUE) {
                            echo '<span class="bg-success blink_text style="font-size:22px""><i class="fa fa-check-circle"></i>ADC Zonal Report Re Uploaded Successfully for ' . $circle_name_upload . ' Circle </span>';
                        } else {
                            echo '<span class="bg-danger blink_text style="font-size:22px""><i class="fa fa-exclamation-circle"></i> Report Not Uploaded !! Kindly Contact System Administrator</span>';
                            return false;
                        }
                        //insert end
                    }
                }
            }
        } else {
            echo '<span  class="bg-yellow blink_text" style="font-size:22px"><i class="fa fa-exclamation-circle"></i> Please choose a file to Upload</span>';
        }
    }
}
