
<?php
class ChithaUpdateModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('SettlementModel/SettlementApModel');
        $this->load->model('SettlementMb/SettlementCommonDcModel');
        $this->load->model('Chitha_basic_model');
        $this->load->model('BhunakshaIntegrationModel');
    }
    public function caseDetails($case_no, $chithaDetailsMod)
    {
        //$this->input->post('case_no');
        // echo "<pre>";
        $chitha_pattadar = true;
        $chitha_nominee = true;
        $date = date('Y-m-d H:i:s');
        $ord_cron_no = 1;
        $user_code = $this->session->userdata('user_code');

        // *****************LAND BANK INSERT/UPDATE***********************
        $landBankResponse = $this->landBankEncIncVal($case_no);
        if ($landBankResponse['responseType'] != 2) {
            return false;
        }
        // **************end landbank*****************
        // var_dump($chithaDetailsMod);
        // die;
        //////////////Insert base payment history/////////////////
        $emiHistory = $this->settlementPaymentHistory($case_no);
        if ($emiHistory == false) {
            return false;
        }
        //////////////////////////////
        // var_dump($chithaDetailsMod);
        if ($chithaDetailsMod['responseType'] == 2) {

            $service_code = $chithaDetailsMod['service_code'];
            if (!in_array($service_code, json_decode(CHITHA_UPDATE_ALLOWED))) {
                log_message('error', "UPDATE_Service_NOT_allowed");
                $this->db->trans_rollback();
                return false;
            }
            /////////ChithaUpdate////////////
            $basicUpdate = [
                'co_chitha_corrected_yn' => 'Y',
                'co_chitha_corrected_date' => date('Y-m-d H:i:s'),
                'order_passed' => 'Y',
                'date_of_order' => date('Y-m-d H:i:s'),
                'date_update' => date('Y-m-d H:i:s'),
            ];
            $where_array = [
                'case_no' => $case_no,
            ];
            $settlement_basic = $this->Chitha_basic_model->update_table('settlement_basic', $basicUpdate, $where_array);
            if ($settlement_basic == 0) {
                log_message('error', "UPDATE_settlement_basic" . $this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            /////////////////////
            $ap_old_area_ref = false;
            $chitha_ap_landowner_insert = false;
            foreach ($chithaDetailsMod['dagArray'] as $mainDagarray) {
                ///////Homestead////////
                //    var_dump($mainDagarray);

                if ($mainDagarray['land_type'] == 3) {
                    $ap_chitha_old_area = $this->chithaBasic($mainDagarray['homestead_details']['dist_code'], $mainDagarray['homestead_details']['subdiv_code'], $mainDagarray['homestead_details']['cir_code'], $mainDagarray['homestead_details']['mouza_pargona_code'], $mainDagarray['homestead_details']['lot_no'], $mainDagarray['homestead_details']['vill_townprt_code'], $mainDagarray['homestead_details']['old_dag_no']);
                    $ap_old_area_ref = true;
                }

                if ($mainDagarray['land_type'] == 1 || $mainDagarray['land_type'] == 3) {
                    // var_dump($mainDagarray['homestead_details']);
                    ////////////////////////////////
                    $location = [
                        'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                        'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                        'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                        'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                        'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                        'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                        'dag_no' => $mainDagarray['homestead_details']['new_dag_no'],
                    ];
                    ////////////////////////////////

                    //****if dag is full then update the existing dag in chitha  */

                    $chithaData = $this->chithaBasic($mainDagarray['homestead_details']['dist_code'], $mainDagarray['homestead_details']['subdiv_code'], $mainDagarray['homestead_details']['cir_code'], $mainDagarray['homestead_details']['mouza_pargona_code'], $mainDagarray['homestead_details']['lot_no'], $mainDagarray['homestead_details']['vill_townprt_code'], $mainDagarray['homestead_details']['old_dag_no']);

                    if (trim((string) $mainDagarray['homestead_details']['new_dag_no']) == trim((string) $mainDagarray['homestead_details']['old_dag_no'])) {
                        $paramsUpdate = [
                            'old_patta_no'      => $mainDagarray['homestead_details']['old_patta_no'],
                            'patta_no'          => $mainDagarray['homestead_details']['new_patta_no'],
                            'patta_type_code'   => $mainDagarray['homestead_details']['new_patta_type'],
                            'land_class_code'   => $mainDagarray['homestead_details']['new_land_class'],
                            'dag_area_b'        => $mainDagarray['homestead_details']['settlement_bigha'],
                            'dag_area_k'        => $mainDagarray['homestead_details']['settlement_katha'],
                            'dag_area_lc'       => $mainDagarray['homestead_details']['settlement_lessa'],
                            'dag_area_g'        => $mainDagarray['homestead_details']['settlement_ganda'],
                            'dag_area_kr'       => 0,
                            // 'dag_area_are' =>$mainDagarray['homestead_details']['old_dag_no'],
                            'dag_revenue'       => $mainDagarray['homestead_details']['new_land_revenue'],
                            'dag_local_tax'     => $mainDagarray['homestead_details']['new_land_local_tax'],
                            'dag_n_desc'        => $mainDagarray['homestead_details']['land_mark_north_village_name'],
                            'dag_s_desc'        => $mainDagarray['homestead_details']['land_mark_south_village_name'],
                            'dag_e_desc'        => $mainDagarray['homestead_details']['land_mark_east_village_name'],
                            'dag_w_desc'        => $mainDagarray['homestead_details']['land_mark_west_village_name'],
                            'dag_n_dag_no'      => $mainDagarray['homestead_details']['land_mark_north_dag_no'],
                            'dag_s_dag_no'      => $mainDagarray['homestead_details']['land_mark_south_dag_no'],
                            'dag_e_dag_no'      => $mainDagarray['homestead_details']['land_mark_east_dag_no'],
                            'dag_w_dag_no'      => $mainDagarray['homestead_details']['land_mark_west_dag_no'],
                            'operation'         => 'E',
                            'user_code'         => $this->session->userdata('user_code'),
                            'date_entry'        => $date,
                            'dag_status'        => $mainDagarray['homestead_details']['is_fully_paid'],
                            'possession_from'   => $mainDagarray['homestead_details']['possession_from'],
                        ];



                        // if($chithaDetailsMod['service_code'] == SETTLEMENT_TENANT_ID){
                        if (in_array($chithaDetailsMod['service_code'], [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
                            $where = [
                                'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                                'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                                'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                                'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                                'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                                'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                                'dag_no' => $mainDagarray['homestead_details']['old_dag_no'],
                                'patta_no' => $mainDagarray['homestead_details']['old_patta_no'],
                            ];
                        } else {
                            $where = [
                                'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                                'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                                'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                                'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                                'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                                'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                                'dag_no' => $mainDagarray['homestead_details']['old_dag_no'],
                            ];
                        }

                        $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_basic', $paramsUpdate, $where);
                        if ($chithaUpdate == 0) {
                            log_message('error', "UPDATE_CHITHA" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }

                        if ($chithaDetailsMod['service_code'] == NC_KHAS_LAND_ID) {
                            $savimtva_array = [
                                'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                                'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                                'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                                'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                                'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                                'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                                'new_dag_no' => (string)$mainDagarray['homestead_details']['new_dag_no'],
                                'mutation_date' => date('Y-m-d'),
                                'dag_no' => (string)$mainDagarray['homestead_details']['old_dag_no'],
                                'case_no' => $case_no,
                                'is_full_dag' => 1,
                            ];
                            $savimtva_array = $this->BhunakshaIntegrationModel->insert($savimtva_array);
                            if ($savimtva_array == 0) {
                                log_message('error', "INSERT_SAVITMVA#137895" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return false;
                            }
                        }
                    } else {
                        $chitha_baic = [
                            'old_dag_no' => $mainDagarray['homestead_details']['old_dag_no'],
                            'old_patta_no' => $mainDagarray['homestead_details']['old_patta_no'],
                            'dag_no_int' => $mainDagarray['homestead_details']['new_dag_no'] . '00',
                            'patta_no' => $mainDagarray['homestead_details']['new_patta_no'],
                            'patta_type_code' => $mainDagarray['homestead_details']['new_patta_type'],
                            'land_class_code' => $mainDagarray['homestead_details']['new_land_class'],
                            'dag_area_b' => $mainDagarray['homestead_details']['settlement_bigha'],
                            'dag_area_k' => $mainDagarray['homestead_details']['settlement_katha'],
                            'dag_area_lc' => $mainDagarray['homestead_details']['settlement_lessa'],
                            'dag_area_g' => $mainDagarray['homestead_details']['settlement_ganda'],
                            'dag_area_kr' => 0,
                            // 'dag_area_are' =>$mainDagarray['homestead_details']['old_dag_no'],
                            'dag_revenue' => $mainDagarray['homestead_details']['new_land_revenue'],
                            'dag_local_tax' => $mainDagarray['homestead_details']['new_land_local_tax'],
                            'dag_n_desc' => $mainDagarray['homestead_details']['land_mark_north_village_name'],
                            'dag_s_desc' => $mainDagarray['homestead_details']['land_mark_south_village_name'],
                            'dag_e_desc' => $mainDagarray['homestead_details']['land_mark_east_village_name'],
                            'dag_w_desc' => $mainDagarray['homestead_details']['land_mark_west_village_name'],
                            'dag_n_dag_no' => $mainDagarray['homestead_details']['land_mark_north_dag_no'],
                            'dag_s_dag_no' => $mainDagarray['homestead_details']['land_mark_south_dag_no'],
                            'dag_e_dag_no' => $mainDagarray['homestead_details']['land_mark_east_dag_no'],
                            'dag_w_dag_no' => $mainDagarray['homestead_details']['land_mark_west_dag_no'],
                            'operation' => 'E',
                            'user_code' => $this->session->userdata('user_code'),
                            'date_entry' => $date,
                            'dag_status' => $mainDagarray['homestead_details']['is_fully_paid'],
                            'possession_from' => $mainDagarray['homestead_details']['possession_from'],
                            'map_for_property' => 'y',
                        ];

                        $mainchitha_basic = array_merge($location, $chitha_baic);
                        $chithaBasic = $this->Chitha_basic_model->insert_table('chitha_basic', $mainchitha_basic);

                        if ($chithaBasic == 0) {
                            log_message('error', "INSERT_CHITHA#343434 " . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                        //////////////////////
                        if ($chithaDetailsMod['service_code'] == NC_KHAS_LAND_ID) {
                            $savimtva_array = [
                                'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                                'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                                'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                                'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                                'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                                'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                                'new_dag_no' => (string)$mainDagarray['homestead_details']['new_dag_no'],
                                'mutation_date' => date('Y-m-d'),
                                'dag_no' => (string)$mainDagarray['homestead_details']['old_dag_no'],
                                'case_no' => $case_no,
                            ];
                            $savimtva_array = $this->BhunakshaIntegrationModel->insert($savimtva_array);
                            if ($savimtva_array == 0) {
                                log_message('error', "INSERT_SAVITMVA#137895" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return false;
                            }
                        }
                        ////////////Substract Settlement Area////////////////
                        $oldAreaChitha = $this->verifyChithaArea($case_no, $mainDagarray['homestead_details']['old_dag_no'], $mainDagarray['homestead_details']['settlement_bigha'], $mainDagarray['homestead_details']['settlement_katha'], $mainDagarray['homestead_details']['settlement_lessa'], $mainDagarray['homestead_details']['settlement_ganda']);
                        if ($oldAreaChitha) {

                            // if($chithaDetailsMod['service_code'] == SETTLEMENT_TENANT_ID){
                            if (in_array($chithaDetailsMod['service_code'], [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
                                $where = [
                                    'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                                    'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                                    'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                                    'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                                    'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                                    'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                                    'dag_no' => $mainDagarray['homestead_details']['old_dag_no'],
                                    'patta_no' => $mainDagarray['homestead_details']['old_patta_no'],

                                ];
                            } else {
                                $where = [
                                    'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                                    'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                                    'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                                    'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                                    'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                                    'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                                    'dag_no' => $mainDagarray['homestead_details']['old_dag_no'],
                                ];
                            }

                            $params = [
                                'dag_area_b' => $oldAreaChitha['dag_area_b'],
                                'dag_area_k' => $oldAreaChitha['dag_area_k'],
                                'dag_area_lc' => $oldAreaChitha['dag_area_lc'],
                                'dag_area_g' => $oldAreaChitha['dag_area_g'],
                            ];

                            if ($mainDagarray['homestead_details']['is_full_dag'] != 1) {
                                $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_basic', $params, $where);
                                if ($chithaUpdate == 0) {
                                    log_message('error', "UPDATE_CHITHA" . $this->db->last_query());
                                    $this->db->trans_rollback();
                                    return false;
                                }
                            }
                        }
                    }

                    ///////For reservation/////////////////
                    $road_side_reservation_bigha = $mainDagarray['homestead_details']['road_side_reservation_bigha'];
                    $road_side_reservation_katha = $mainDagarray['homestead_details']['road_side_reservation_katha'];
                    $road_side_reservation_lessa = $mainDagarray['homestead_details']['road_side_reservation_lessa'];
                    $road_side_reservation_ganda = $mainDagarray['homestead_details']['road_side_reservation_ganda'];
                    if ($mainDagarray['homestead_details']['is_reservation'] != 0) {
                        // $reservation=$this->roadSideReservation($road_side_reservation_bigha,$road_side_reservation_katha,$road_side_reservation_lessa,$road_side_reservation_ganda);
                        ///////////////////////
                        if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                            $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $road_side_reservation_bigha . " বিঘা " . $road_side_reservation_katha . " কঠা " . $road_side_reservation_lessa . " চাতক " . $road_side_reservation_ganda . " গোণ্ডা মিছন বাসুন্ধৰা-2.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case_no . " নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                        } else {
                            $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $road_side_reservation_bigha . " বিঘা " . $road_side_reservation_katha . " কঠা " . $road_side_reservation_lessa . " লেচা মিছন বাসুন্ধৰা-2.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case_no . " নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                        }
                        $backlog_orders = array(
                            'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                            'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                            'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                            'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                            'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                            'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                            'patta_no' => $mainDagarray['homestead_details']['old_patta_no'],
                            'patta_type_code' => $mainDagarray['homestead_details']['old_patta_type'],
                            'dag_no' => $mainDagarray['homestead_details']['old_dag_no'],
                            'dag_no_int' => $mainDagarray['homestead_details']['old_dag_no'] . '00',
                            'remark' => addslashes($rmk),
                            'category' => 2,
                            'date_entry' => date('Y-m-d'),
                            'user_code' => $user_code,
                        );
                        $backlog_orders = $this->Chitha_basic_model->insert_table('backlog_orders', $backlog_orders);
                        if ($backlog_orders == 0) {
                            log_message('error', "INSERT_backlog_orders" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                    }
                    ///////////End of reservation/////////////////
                    // var_dump($mainchitha_basic);

                    // echo "<br>chithabasic****************<br>";
                    $rmk_type_hist_no = $this->maxHistoryNoOrder($location, $mainDagarray['homestead_details']['old_dag_no']);
                    // $ord_cron_no=$ord_cron_no++;
                    $remark_gen = array(
                        'rmk_type_code' => '01',
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'jama_updated' => null,
                        'patta_no' => $mainDagarray['homestead_details']['new_patta_no'],
                    );
                    $chitha_remark_gen_data = (array_merge($location, $remark_gen));
                    $chitha_rmk_gen = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
                    if ($chitha_rmk_gen == 0) {
                        log_message('error', "INSERT_CHITHA_RMK_GEN" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                    /////////////OLD DAG////////////////
                    if (trim((string) $mainDagarray['homestead_details']['old_dag_no']) != trim((string) $mainDagarray['homestead_details']['new_dag_no'])) {
                        $chitha_remark_gen_data['dag_no'] = $mainDagarray['homestead_details']['old_dag_no'];
                        $chitha_rmk_gen = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
                        if ($chitha_rmk_gen == 0) {
                            log_message('error', "INSERT_OLD_CHITHA_RMK_GEN" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                    }
                    ////////////////////////////

                    //var_dump($chitha_remark_gen);
                    $order_basic = array(
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'ord_no' => $case_no,
                        'ord_date' => date('Y-m-d'),
                        'ord_type_code' => $service_code,
                        'ord_cron_no' => $ord_cron_no++,
                        'case_no' => $case_no,
                        'ord_passby_sign_yn' => 'Y',
                        'ord_passby_desig' => $this->session->userdata('user_desig_code'),
                        'lm_code' => $chithaDetailsMod['lmcode'],
                        'lm_sign_yn' => 'Y',
                        'lm_sign_date' => $chithaDetailsMod['lm_sign_date'],
                        'co_code' => $user_code,
                        'co_sign_yn' => 'Y',
                        'co_ord_date' => date('Y-m-d'),
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'm_dag_area_b' => $mainDagarray['homestead_details']['settlement_bigha'],
                        'm_dag_area_k' => $mainDagarray['homestead_details']['settlement_katha'],
                        'm_dag_area_lc' => $mainDagarray['homestead_details']['settlement_lessa'],
                        'm_dag_area_g' => $mainDagarray['homestead_details']['settlement_ganda'],
                        'm_dag_area_kr' => 0,
                        'area_left_b' => '0',
                        'area_left_k' => '0',
                        'area_left_lc' => '0',
                        'area_left_g' => '0',
                        'old_dag_area_b' => $chithaData ? $chithaData['dag_area_b'] : 0,
                        'old_dag_area_k' => $chithaData ? $chithaData['dag_area_k'] : 0,
                        'old_dag_area_lc' => $chithaData ? $chithaData['dag_area_lc'] : 0,
                        'old_dag_area_g' => $chithaData ? $chithaData['dag_area_g'] : 0,
                        'rural_urban' => $mainDagarray['homestead_details']['is_urban'],
                        'full_partial' => $mainDagarray['homestead_details']['is_fully_paid'],
                        'rtps_no' => $chithaDetailsMod['applid'],
                        'rtps_app_date' => $chithaDetailsMod['application_date'],
                        'dag_revenue' => $mainDagarray['homestead_details']['new_land_revenue'],
                        'dag_local_tax' => $mainDagarray['homestead_details']['new_land_local_tax'],
                        'ord_impli_flag' => 1,
                        'full_dag' => trim((string) $mainDagarray['homestead_details']['old_dag_no']) != trim((string) $mainDagarray['homestead_details']['new_dag_no']) ? 0 : $mainDagarray['homestead_details']['is_full_dag'],
                    );

                    if ($ap_old_area_ref == true) {
                        $order_basic['old_dag_area_b'] = $ap_chitha_old_area ? $ap_chitha_old_area['dag_area_b'] : 0;
                        $order_basic['old_dag_area_k'] = $ap_chitha_old_area ? $ap_chitha_old_area['dag_area_k'] : 0;
                        $order_basic['old_dag_area_lc'] = $ap_chitha_old_area ? $ap_chitha_old_area['dag_area_lc'] : 0;
                        $order_basic['old_dag_area_g'] = $ap_chitha_old_area ? $ap_chitha_old_area['dag_area_g'] : 0;
                    }

                    $chitha_rmk_ordbasic_data = (array_merge($location, $order_basic));
                    $chitha_rmk_ordbasic = $this->Chitha_basic_model->insert_table('chitha_rmk_ordbasic', $chitha_rmk_ordbasic_data);
                    if ($chitha_rmk_ordbasic == 0) {
                        log_message('error', "INSERT_CHITHA_RMK_ORDBASIC" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                    ////////////OLD DAG///////////

                    if (trim((string) $mainDagarray['homestead_details']['old_dag_no']) != trim((string) $mainDagarray['homestead_details']['new_dag_no'])) {
                        $chitha_rmk_ordbasic_data['dag_no'] = $mainDagarray['homestead_details']['old_dag_no'];
                        $chitha_rmk_ordbasic = $this->Chitha_basic_model->insert_table('chitha_rmk_ordbasic', $chitha_rmk_ordbasic_data);
                        if ($chitha_rmk_ordbasic == 0) {
                            log_message('error', "INSERT_OLD_CHITHA_RMK_ORDBASIC" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                    }

                    //       var_dump($chitha_order_basic);
                    // echo "<br>ordbasic****************<br>";
                    $pdar_id = $this->maxpdarIdCheckSettlment($case_no, $mainDagarray['homestead_details']['new_dag_no'], $mainDagarray['homestead_details']['new_patta_type'], $mainDagarray['homestead_details']['new_patta_no']);
                    $pattdarIdCheck = true;
                    $pdar_cron_no = 1;

                    //getting the next riotee id
                    $next_tenant_id = null;
                    $chitha_tenant_row = null;
                    $khatian_no = null;

                    foreach ($chithaDetailsMod['applicantArray'] as $slp) {
                        // if ($chithaDetailsMod['service_code'] == SETTLEMENT_TENANT_ID) {
                        if (in_array($chithaDetailsMod['service_code'], [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
                            if ($slp['pdar_type'] == 'EN') {
                                //****handle for tennat khatian cut in chitha tenant with pdar_id and khatian no */
                                if (($slp['khatian_no'] != -1) && ($slp['riotee_id'] != -1)) {
                                    $khatian_no = $slp['khatian_no'];
                                }
                            }
                        }
                    }


                    foreach ($chithaDetailsMod['applicantArray'] as $slp) {
                        // if ($chithaDetailsMod['service_code'] == SETTLEMENT_TENANT_ID) {
                        if (in_array($chithaDetailsMod['service_code'], [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
                            if ($slp['pdar_type'] == 'EN') {
                                //****handle for tennat khatian cut in chitha tenant with pdar_id and khatian no */
                                if (($slp['khatian_no'] != -1) && ($slp['riotee_id'] != -1)) {
                                    // insert new tenant
                                    $sql = $this->db->query(
                                        'SELECT ct.*, 
																																				(SELECT MAX(tenant_id) AS max_tenant_id
																																				FROM chitha_tenant
																																				WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ? AND vill_townprt_code = ? AND dag_no = ? AND khatian_no = ?)
																																				max_tenant_id
																																				FROM chitha_tenant ct
																																				WHERE ct.dist_code = ? AND ct.subdiv_code = ? AND ct.cir_code = ? AND 
																																				ct.mouza_pargona_code = ? AND ct.lot_no = ? AND ct.vill_townprt_code = ? 
																																				AND ct.dag_no = ? AND ct.khatian_no = ? and ct.tenant_id = ?',
                                        array(
                                            $mainDagarray['homestead_details']['dist_code'],
                                            $mainDagarray['homestead_details']['subdiv_code'],
                                            $mainDagarray['homestead_details']['cir_code'],
                                            $mainDagarray['homestead_details']['mouza_pargona_code'],
                                            $mainDagarray['homestead_details']['lot_no'],
                                            $mainDagarray['homestead_details']['vill_townprt_code'],
                                            $mainDagarray['homestead_details']['old_dag_no'],
                                            $slp['khatian_no'],
                                            $mainDagarray['homestead_details']['dist_code'],
                                            $mainDagarray['homestead_details']['subdiv_code'],
                                            $mainDagarray['homestead_details']['cir_code'],
                                            $mainDagarray['homestead_details']['mouza_pargona_code'],
                                            $mainDagarray['homestead_details']['lot_no'],
                                            $mainDagarray['homestead_details']['vill_townprt_code'],
                                            $mainDagarray['homestead_details']['old_dag_no'],
                                            $slp['khatian_no'],
                                            $slp['riotee_id']
                                        )
                                    );

                                    if ($sql->num_rows() <= 0) {
                                        log_message('error', "RIOTEE NOT FOUND IN chitha_tenant" . $this->db->last_query());
                                        $this->db->trans_rollback();
                                        return false;
                                    }

                                    $chitha_tenant_row = $sql->row();
                                    $next_tenant_id = (int) $chitha_tenant_row->max_tenant_id;
                                }
                            }
                        }
                    }

                    // if ($chithaDetailsMod['service_code'] == SETTLEMENT_TENANT_ID){
                    if (in_array($chithaDetailsMod['service_code'], [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
                        if ($next_tenant_id == null || $chitha_tenant_row == null) {
                            log_message('error', "RIOTEE NOT FOUND IN chitha_tenant" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                    }

                    foreach ($chithaDetailsMod['applicantArray'] as $slp) {
                        // if ($slp['pdar_type'] == 'EN' && in_array($chithaDetailsMod['service_code'],[SETTLEMENT_KHAS_LAND_ID,SETTLEMENT_TRIBAL_COMMUNITY,SETTLEMENT_SPECIAL_CULTIVATORS_ID,SETTLEMENT_PGR_VGR_LAND_ID,SETTLEMENT_AP_TRANSFER_ID])  ) {
                        if ($slp['pdar_type'] == 'EN' && in_array($chithaDetailsMod['service_code'], json_decode(CHITHA_UPDATE_ALLOWED))) {
                            if (!in_array($chithaDetailsMod['service_code'], [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
                                continue;
                            }
                        }
                        //****** handle for Owner

                        if (in_array($chithaDetailsMod['service_code'], [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
                            if (in_array($slp['pdar_type'], ['B', 'P', 'GP', 'GGP', 'EN'])) {
                                //****handle for tennat khatian cut in chitha tenant with pdar_id and khatian no */
                                // insert new tenant
                                if (($slp['riotee_id'] == -1) && ($slp['riotee_id'] == -1)) {
                                    $chitha_tenant_insert_array = [
                                        'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                                        'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                                        'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                                        'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                                        'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                                        'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                                        'dag_no' => $mainDagarray['homestead_details']['old_dag_no'],
                                        'tenant_id' => ++$next_tenant_id,
                                        'khatian_no' => $khatian_no,
                                        'tenant_name' => $slp['applicant_assamese_name'],
                                        'tenants_father' => $slp['guardian_assamese_name'],
                                        'tenants_add1' => $slp['present_address'],
                                        'tenants_add2' => $slp['permanent_address'],
                                        'type_of_tenant' => $chitha_tenant_row->type_of_tenant,
                                        'revenue_tenant' => $chitha_tenant_row->revenue_tenant,
                                        'user_code' => $this->session->userdata('user_code'),
                                        'date_entry' => date('Y-m-d H:i:s'),
                                        'operation' => 'B',
                                        'status' => $chitha_tenant_row->status,
                                        'p_flag' => '1',
                                    ];

                                    $c_insert = $this->db->insert('chitha_tenant', $chitha_tenant_insert_array);
                                    if ($c_insert != 1) {
                                        log_message('error', "Unable to insert in chitha_tenant" . $this->db->last_query());
                                        $this->db->trans_rollback();
                                        return false;
                                    }

                                    if (in_array($slp['pdar_type'], ['P', 'GP', 'GGP'])) {
                                        continue;
                                    }
                                } else {
                                    //update p_flag
                                    $update_array = [
                                        'p_flag' => '1',
                                        'updated_date' => date('Y-m-d H:i:s'),
                                    ];
                                    $this->db->where('dist_code', $mainDagarray['homestead_details']['dist_code']);
                                    $this->db->where('subdiv_code', $mainDagarray['homestead_details']['subdiv_code']);
                                    $this->db->where('cir_code', $mainDagarray['homestead_details']['cir_code']);
                                    $this->db->where('mouza_pargona_code', $mainDagarray['homestead_details']['mouza_pargona_code']);
                                    $this->db->where('lot_no', $mainDagarray['homestead_details']['lot_no']);
                                    $this->db->where('vill_townprt_code', $mainDagarray['homestead_details']['vill_townprt_code']);
                                    $this->db->where('dag_no', $mainDagarray['homestead_details']['old_dag_no']);
                                    $this->db->where('tenant_id', $slp['riotee_id']);
                                    $this->db->where('khatian_no', $slp['khatian_no']);
                                    $this->db->update('chitha_tenant', $update_array);

                                    if ($this->db->affected_rows() != 1) {
                                        log_message('error', "Unable to update in chitha_tenant" . $this->db->last_query());
                                        $this->db->trans_rollback();
                                        return false;
                                    }
                                    //if encroachers then continue
                                    continue;
                                }
                            }

                            if (trim($slp['pdar_type']) == 'O') {
                                if (strtolower(trim($slp['inplace_alongwith'])) == 'i') {
                                    //****cut the owner name */
                                    $params = [
                                        'p_flag' => 1,
                                    ];

                                    $where = [
                                        'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                                        'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                                        'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                                        'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                                        'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                                        'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                                        'dag_no' => $slp['ap_dag_no'],
                                        'patta_no' => $slp['ap_patta_no'],
                                        'patta_type_code' => $slp['ap_patta_type_code'],
                                        'pdar_id' => $slp['ap_pdar_id'],
                                        'patta_no' => $mainDagarray['homestead_details']['old_patta_no']
                                    ];

                                    $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_dag_pattadar', $params, $where);
                                    if ($chithaUpdate == 0) {
                                        log_message('error', "chitha_dag_pattadar####" . $this->db->last_query());
                                        $this->db->trans_rollback();
                                        return false;
                                    }
                                }
                                continue;
                            }
                        }

                        if ($chithaDetailsMod['service_code'] == SETTLEMENT_AP_TRANSFER_ID) {
                            //********update the patta no to backlog orders */
                            $paramsP = [
                                'patta_no' => $mainDagarray['homestead_details']['new_patta_no'],
                                'patta_type_code' => $mainDagarray['homestead_details']['new_patta_type'],
                            ];

                            $locationP = [
                                'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                                'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                                'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                                'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                                'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                                'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                                'dag_no' => $mainDagarray['homestead_details']['old_dag_no'],
                            ];

                            $updatePat = $this->Chitha_basic_model->update_table('backlog_orders', $paramsP, $locationP);
                            if ($updatePat == 0) {
                                log_message('error', "backlog_orders####" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return false;
                            }

                            if (trim($slp['pdar_type']) == 'O') {
                                if (strtolower(trim($slp['inplace_alongwith'])) == 'i') {
                                    //****cut the owner name */
                                    $params = [
                                        'p_flag' => 1,
                                    ];

                                    $where = [
                                        'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                                        'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                                        'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                                        'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                                        'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                                        'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                                        'dag_no' => $slp['ap_dag_no'],
                                        'patta_no' => $slp['ap_patta_no'],
                                        'patta_type_code' => $slp['ap_patta_type_code'],
                                        'pdar_id' => $slp['ap_pdar_id'],
                                    ];

                                    $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_dag_pattadar', $params, $where);
                                    if ($chithaUpdate == 0) {
                                        log_message('error', "chitha_dag_pattadar####" . $this->db->last_query());
                                        $this->db->trans_rollback();
                                        return false;
                                    }
                                }
                                //****ref with primary land owner for ap cases  */
                                if ($chitha_ap_landowner_insert != true) {
                                    $apLandOwnerInsertArr = [
                                        'case_no' => $case_no,
                                        'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                                        'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                                        'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                                        'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                                        'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                                        'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                                        'dag_no' => $slp['ap_dag_no'],
                                        'patta_no' => $slp['ap_patta_no'],
                                        'new_patta_no' => $mainDagarray['homestead_details']['new_patta_no'],
                                        'patta_type_code' => $slp['ap_patta_type_code'],
                                        'new_patta_type_code' => $mainDagarray['homestead_details']['new_patta_type'],
                                        'pdar_id' => $slp['ap_pdar_id'],
                                        'pdar_name' => $slp['applicant_assamese_name'],
                                        'pdar_guardian_name' => $slp['guardian_assamese_name'],
                                        'pdar_relation' => $slp['relation'],
                                        'pdar_gender' => $slp['gender'],
                                        'date_entry' => date('Y-m-d G:i:s'),
                                    ];

                                    $lad_owner_insert = $this->Chitha_basic_model->insert_table('chitha_ap_landowner', $apLandOwnerInsertArr);
                                    if ($lad_owner_insert == 0) {
                                        log_message('error', "#INSERT--chitha_ap_landowner####" . $this->db->last_query());
                                        $this->db->trans_rollback();
                                        return false;
                                    }
                                    $chitha_ap_landowner_insert = true;
                                }

                                continue;
                            }
                        }

                        // if ($chithaDetailsMod['service_code'] == SETTLEMENT_TENANT_ID) {
                        if (in_array($chithaDetailsMod['service_code'], [SETTLEMENT_TENANT_ID, SETTLEMENT_TENANT_URBAN_ID])) {
                            if ($khatian_no == null) {
                                log_message('error', "Khatian no not found####" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return false;
                            }
                        }

                        $allotee = array(
                            'rmk_type_hist_no' => $rmk_type_hist_no,
                            'ord_no' => $case_no,
                            'ord_date' => $date,
                            'ord_cron_no' => $ord_cron_no,
                            'settlement_id' => $pdar_cron_no++,
                            'settlement_name' => $slp['applicant_assamese_name'],
                            'settlement_guardian' => $slp['guardian_assamese_name'],
                            'settlement_guar_relation' => $slp['relation'],
                            'settlement_gender' => $slp['gender'],
                            'settlement_dob' => $slp['dob'],
                            // 'settlement_mother'=> $slp['pdar_mother'],
                            'settlement_land_b' => 0,
                            'settlement_land_k' => 0,
                            'settlement_land_lc' => 0,
                            'settlement_land_g' => 0,
                            'settlement_land_kr' => 0,
                            'user_code' => $this->session->userdata('user_code'),
                            'date_entry' => date('Y-m-d H:i:s'),
                            'operation' => 'E',
                            'case_no' => $case_no,
                            'patta_no' => $mainDagarray['homestead_details']['new_patta_no'],
                            'old_patta_no' => $mainDagarray['homestead_details']['old_patta_no'],
                            'old_dag' => $mainDagarray['homestead_details']['old_dag_no'],
                            'new_dag' => $mainDagarray['homestead_details']['new_dag_no'],
                            'new_patta_type' => $mainDagarray['homestead_details']['new_patta_type'],
                            'pdar_type' => $slp['pdar_type'],
                            'inplace_along_with' => null,
                            'lm_code' => $chithaDetailsMod['lmcode'],
                            'dc_code' => $chithaDetailsMod['dccode'],
                            'inplace_along_with' => null,
                            'dc_order_no' => $chithaDetailsMod['dc_order_no'],
                            'dc_order_date' => $chithaDetailsMod['dc_sign_date'],
                            'dept_order_no' => $mainDagarray['homestead_details']['dept_order_no'],
                            'dept_order_date' => $mainDagarray['homestead_details']['dept_order_date'],
                            'grn_no' => $mainDagarray['homestead_details']['grn_no'],
                            'possession_from' => $mainDagarray['homestead_details']['possession_from'],
                            'payment_date' => $mainDagarray['homestead_details']['payment_date'],
                            'final_premium_amount' => $mainDagarray['homestead_details']['final_premium_amount'],
                            'paid_amount' => $mainDagarray['homestead_details']['paid_amount'],
                            'is_applicant' => $slp['is_applicant'],
                            'identity_type ' => $slp['identity_type'],
                            // 'pdar_occupation'=>$slp['is_applicant']==1?$chithaDetailsMod['service_code']:null,
                            'pdar_occupation' => $slp['is_applicant'] == 1 ? $chithaDetailsMod['occupation'] : null,

                            'settlement_name_eng' => $slp['applicant_english_name'],
                            'settlement_guardian_eng' => $slp['guardian_english_name'],
                            'khatian_no' => $khatian_no
                        );
                        $chitha_settlement_allottee = (array_merge($location, $allotee));
                        // var_dump($chitha_settlement_allottee);
                        $chitha_settlement_allottee = $this->Chitha_basic_model->insert_table('chitha_settlement_allottee', $chitha_settlement_allottee);
                        if ($chitha_settlement_allottee == 0) {
                            log_message('error', "INSERT_CHITHA_RMK_ALLOTEE" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                        if ($mainDagarray['homestead_details']['is_fully_paid'] != 1) {
                            $non_assigned_pattadar = [
                                'applicant_name' => $slp['applicant_assamese_name'],
                                'guardian_name' => $slp['guardian_assamese_name'],
                                'gender' => $slp['gender'],
                                'relation' => $slp['relation'],
                                'identity_type' => $slp['identity_type'] != null ? $slp['identity_type'] : 'NA',
                                'identity_ref_no' => $slp['identity_ref_no'] != null ? $slp['identity_ref_no'] : 'NA',
                                'new_dag_no' => $mainDagarray['homestead_details']['new_dag_no'],
                                'case_no' => $case_no,
                            ];
                            $pattadar_non_assigned = array_merge($location, $non_assigned_pattadar);
                            $partial_payment = $this->Chitha_basic_model->insert_table('partial_payment', $pattadar_non_assigned);
                            if ($partial_payment == 0) {
                                log_message('error', "INSERT_pattadar_non_assigned" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return false;
                            }
                            continue;
                        }
                        // echo "<br>chitha_allotee****************<br>";
                        //Insert query/////////////////
                        $final_pdarId = $pdar_id;
                        $c_d_p = array(
                            'pdar_id' => $final_pdarId,
                            'patta_no' => $mainDagarray['homestead_details']['new_patta_no'],
                            'patta_type_code' => $mainDagarray['homestead_details']['new_patta_type'],
                            'dag_por_b' => $this->utilityclass->assToeng($mainDagarray['homestead_details']['settlement_bigha']),
                            'dag_por_k' => $this->utilityclass->assToeng($mainDagarray['homestead_details']['settlement_katha']),
                            'dag_por_lc' => $this->utilityclass->assToeng($mainDagarray['homestead_details']['settlement_lessa']),
                            'dag_por_g' => $this->utilityclass->assToeng($mainDagarray['homestead_details']['settlement_ganda']),
                            'dag_por_kr' => 0,
                            'user_code' => $user_code,
                            'date_entry' => date('Y-m-d'),
                            'operation' => 'E',
                            'p_flag' => '0',
                            'jama_yn' => 'N',
                        );
                        $chitha_dag_pattadar = array_merge($location, $c_d_p);
                        // var_dump($chitha_dag_pattadar);
                        $chitha_dag_pattadar = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar', $chitha_dag_pattadar);
                        if ($chitha_dag_pattadar == 0) {
                            log_message('error', "INSERT_chitha_dag_pattadar" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                        //////////////////Nominee Details Insert/////////////////////////
                        if ($slp['is_applicant'] == 1 && !empty($chithaDetailsMod['nominee']) && $chitha_nominee == true) {
                            foreach ($chithaDetailsMod['nominee'] as $nominee) {
                                $chitha_nominee_pattadar = [
                                    'patta_no' => $mainDagarray['homestead_details']['new_patta_no'],
                                    'patta_type_code' => $mainDagarray['homestead_details']['new_patta_type'],
                                    'pdar_id' => $final_pdarId,
                                    'nominee_name' => $nominee['nominee_name'],
                                    'nominee_name_eng' => $nominee['nominee_name_eng'],
                                    'nominee_guardian_name' => $nominee['nominee_guardian_name'],
                                    'nominee_guardian_eng_name' => $nominee['nominee_guardian_eng_name'],
                                    'nominee_address' => $nominee['nominee_address'],
                                    'nominee_mobile' => $nominee['nominee_mobile'],
                                    'nominee_relation' => $nominee['nominee_relation'],
                                    'nominee_email' => $nominee['nominee_email'],
                                ];
                                $nominee_insert = array_merge($location, $chitha_nominee_pattadar);
                                $chitha_nominee_pattadar = $this->Chitha_basic_model->insert_table('chitha_nominee_pattadar', $nominee_insert);
                                if ($chitha_nominee_pattadar == 0) {
                                    log_message('error', "INSERT_chitha_nominee_pattadar" . $this->db->last_query());
                                    $this->db->trans_rollback();
                                    return false;
                                }
                            }
                            $chitha_nominee = false;
                        }
                        /////////////Chitha Pattadar////////////////
                        if ($chitha_pattadar == true) {
                            $chitha_pattadar = array(
                                'dist_code' => $mainDagarray['homestead_details']['dist_code'],
                                'subdiv_code' => $mainDagarray['homestead_details']['subdiv_code'],
                                'cir_code' => $mainDagarray['homestead_details']['cir_code'],
                                'mouza_pargona_code' => $mainDagarray['homestead_details']['mouza_pargona_code'],
                                'lot_no' => $mainDagarray['homestead_details']['lot_no'],
                                'vill_townprt_code' => $mainDagarray['homestead_details']['vill_townprt_code'],
                                'patta_no' => $mainDagarray['homestead_details']['new_patta_no'],
                                'patta_type_code' => $mainDagarray['homestead_details']['new_patta_type'],
                                'pdar_id' => $final_pdarId,
                                'pdar_name' => $slp['applicant_assamese_name'],
                                'pdar_father' => $slp['guardian_assamese_name'],
                                'pdar_name_eng' => $slp['applicant_english_name'],
                                'pdar_guard_eng' => $slp['guardian_english_name'],
                                'pdar_add1' => $slp['present_address'],
                                'pdar_add2' => $slp['permanent_address'],
                                'dob' => $slp['dob'],
                                'o1_case_no' => $case_no,
                                //'pdar_pan_no' => $alp->alotee_pan_card,
                                'user_code' => $user_code,
                                'date_entry' => date('Y-m-d'),
                                'operation' => 'E',
                                'jama_yn' => 'n',
                                'pdar_guard_reln' => $this->utilityclass->relationByID($slp['relation']),
                                'pdar_gender' => ($slp['gender'] == 1) ? 'm' : (($slp['gender'] == 2) ? 'f' : 'o'),
                                'pdar_minor_yn' => null,
                                'pdar_minor_dob' => null,
                                'pdar_caste' => $slp['caste'],
                                // 'pdar_mother' => $slp['pdar_mother'],
                                // 'pdar_aadharno' => null,
                                'pdar_mobile' => $slp['mobile'],
                                'new_pdar_name' => 'N',
                                // 'pdar_occupation'=>$slp['is_applicant']==1?$chithaDetailsMod['service_code']:null,
                                'pdar_occupation' => $slp['is_applicant'] == 1 ? $chithaDetailsMod['occupation'] : null,
                                'mask_id' => $slp['mask_id'],
                            );

                            // var_dump($slp['relation']);
                            if ($slp['identity_type'] == 'AADHAAR' && $slp['is_applicant'] == 1) {
                                $chitha_pattadar['pdar_aadharno'] = $slp['identity_ref_no'];
                            }
                            if ($slp['identity_type'] == 'PAN' && $slp['is_applicant'] == 1) {
                                $chitha_pattadar['pdar_pan_no'] = $slp['identity_ref_no'];
                            }
                            if ($slp['identity_type'] == 'DL' && $slp['is_applicant'] == 1) {
                                $chitha_pattadar['pdar_nrcno'] = $slp['identity_ref_no'];
                            }
                            // var_dump($chitha_pattadar);
                            // echo "<br>chitha_pattadar****************<br>";
                            $chitha_pattadar = $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);

                            if ($chitha_pattadar == 0) {
                                log_message('error', "INSERT_chitha_pattadar" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return false;
                            }
                        }
                        $pdar_id++;
                    }
                    $pattdarIdCheck = $chitha_pattadar = false;
                }

                if ($mainDagarray['land_type'] == 2 || $mainDagarray['land_type'] == 3) {
                    // var_dump($mainDagarray['homestead_details']);
                    ////////////////////////////////
                    $location = [
                        'dist_code' => $mainDagarray['agriculture_details']['dist_code'],
                        'subdiv_code' => $mainDagarray['agriculture_details']['subdiv_code'],
                        'cir_code' => $mainDagarray['agriculture_details']['cir_code'],
                        'mouza_pargona_code' => $mainDagarray['agriculture_details']['mouza_pargona_code'],
                        'lot_no' => $mainDagarray['agriculture_details']['lot_no'],
                        'vill_townprt_code' => $mainDagarray['agriculture_details']['vill_townprt_code'],
                        'dag_no' => $mainDagarray['agriculture_details']['new_dag_no'],
                    ];
                    ////////////////////////////////

                    $chithaData = $this->chithaBasic($mainDagarray['agriculture_details']['dist_code'], $mainDagarray['agriculture_details']['subdiv_code'], $mainDagarray['agriculture_details']['cir_code'], $mainDagarray['agriculture_details']['mouza_pargona_code'], $mainDagarray['agriculture_details']['lot_no'], $mainDagarray['agriculture_details']['vill_townprt_code'], $mainDagarray['agriculture_details']['old_dag_no']);

                    if (trim((string) $mainDagarray['agriculture_details']['new_dag_no']) == trim((string) $mainDagarray['agriculture_details']['old_dag_no'])) {
                        $paramsUpdate = [
                            'old_patta_no' => $mainDagarray['agriculture_details']['old_patta_no'],
                            'patta_no' => $mainDagarray['agriculture_details']['new_patta_no'],
                            'patta_type_code' => $mainDagarray['agriculture_details']['new_patta_type'],
                            'land_class_code' => $mainDagarray['agriculture_details']['new_land_class'],
                            'dag_area_b' => $mainDagarray['agriculture_details']['settlement_bigha'],
                            'dag_area_k' => $mainDagarray['agriculture_details']['settlement_katha'],
                            'dag_area_lc' => $mainDagarray['agriculture_details']['settlement_lessa'],
                            'dag_area_g' => $mainDagarray['agriculture_details']['settlement_ganda'],
                            'dag_area_kr' => 0,
                            'dag_revenue' => $mainDagarray['agriculture_details']['new_land_revenue'],
                            'dag_local_tax' => $mainDagarray['agriculture_details']['new_land_local_tax'],
                            'dag_n_desc' => $mainDagarray['agriculture_details']['land_mark_north_village_name'],
                            'dag_s_desc' => $mainDagarray['agriculture_details']['land_mark_south_village_name'],
                            'dag_e_desc' => $mainDagarray['agriculture_details']['land_mark_east_village_name'],
                            'dag_w_desc' => $mainDagarray['agriculture_details']['land_mark_west_village_name'],
                            'dag_n_dag_no' => $mainDagarray['agriculture_details']['land_mark_north_dag_no'],
                            'dag_s_dag_no' => $mainDagarray['agriculture_details']['land_mark_south_dag_no'],
                            'dag_e_dag_no' => $mainDagarray['agriculture_details']['land_mark_east_dag_no'],
                            'dag_w_dag_no' => $mainDagarray['agriculture_details']['land_mark_west_dag_no'],
                            'user_code' => $this->session->userdata('user_code'),
                            'operation' => 'E',
                            'date_entry' => $date,
                            'dag_status' => $mainDagarray['agriculture_details']['is_fully_paid'],
                            'possession_from' => $mainDagarray['agriculture_details']['possession_from'],
                        ];




                        $where = [
                            'dist_code' => $mainDagarray['agriculture_details']['dist_code'],
                            'subdiv_code' => $mainDagarray['agriculture_details']['subdiv_code'],
                            'cir_code' => $mainDagarray['agriculture_details']['cir_code'],
                            'mouza_pargona_code' => $mainDagarray['agriculture_details']['mouza_pargona_code'],
                            'lot_no' => $mainDagarray['agriculture_details']['lot_no'],
                            'vill_townprt_code' => $mainDagarray['agriculture_details']['vill_townprt_code'],
                            'dag_no' => $mainDagarray['agriculture_details']['old_dag_no'],
                        ];

                        $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_basic', $paramsUpdate, $where);
                        if ($chithaUpdate == 0) {
                            log_message('error', "UPDATE_CHITHA" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }

                        if ($chithaDetailsMod['service_code'] == NC_KHAS_LAND_ID) {
                            $savimtva_array = [
                                'dist_code' => $mainDagarray['agriculture_details']['dist_code'],
                                'subdiv_code' => $mainDagarray['agriculture_details']['subdiv_code'],
                                'cir_code' => $mainDagarray['agriculture_details']['cir_code'],
                                'mouza_pargona_code' => $mainDagarray['agriculture_details']['mouza_pargona_code'],
                                'lot_no' => $mainDagarray['agriculture_details']['lot_no'],
                                'vill_townprt_code' => $mainDagarray['agriculture_details']['vill_townprt_code'],
                                'new_dag_no' => (string)$mainDagarray['agriculture_details']['new_dag_no'],
                                'mutation_date' => date('Y-m-d'),
                                'dag_no' => (string)$mainDagarray['agriculture_details']['old_dag_no'],
                                'case_no' => $case_no,
                                'is_full_dag' => 1,
                            ];
                            $savimtva_array = $this->BhunakshaIntegrationModel->insert($savimtva_array);
                            if ($savimtva_array == 0) {
                                log_message('error', "INSERT_SAVITMVA#137895" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return false;
                            }
                        }
                    } else {
                        $chitha_baic = [
                            'old_dag_no' => $mainDagarray['agriculture_details']['old_dag_no'],
                            'old_patta_no' => $mainDagarray['agriculture_details']['old_patta_no'],
                            'dag_no_int' => $mainDagarray['agriculture_details']['new_dag_no'] . '00',
                            'patta_no' => $mainDagarray['agriculture_details']['new_patta_no'],
                            'patta_type_code' => $mainDagarray['agriculture_details']['new_patta_type'],
                            'land_class_code' => $mainDagarray['agriculture_details']['new_land_class'],
                            'dag_area_b' => $mainDagarray['agriculture_details']['settlement_bigha'],
                            'dag_area_k' => $mainDagarray['agriculture_details']['settlement_katha'],
                            'dag_area_lc' => $mainDagarray['agriculture_details']['settlement_lessa'],
                            'dag_area_g' => $mainDagarray['agriculture_details']['settlement_ganda'],
                            'dag_area_kr' => 0,
                            // 'dag_area_are' =>$mainDagarray['agriculture_details']['old_dag_no'],
                            'dag_revenue' => $mainDagarray['agriculture_details']['new_land_revenue'],
                            'dag_local_tax' => $mainDagarray['agriculture_details']['new_land_local_tax'],
                            'dag_n_desc' => $mainDagarray['agriculture_details']['land_mark_north_village_name'],
                            'dag_s_desc' => $mainDagarray['agriculture_details']['land_mark_south_village_name'],
                            'dag_e_desc' => $mainDagarray['agriculture_details']['land_mark_east_village_name'],
                            'dag_w_desc' => $mainDagarray['agriculture_details']['land_mark_west_village_name'],
                            'dag_n_dag_no' => $mainDagarray['agriculture_details']['land_mark_north_dag_no'],
                            'dag_s_dag_no' => $mainDagarray['agriculture_details']['land_mark_south_dag_no'],
                            'dag_e_dag_no' => $mainDagarray['agriculture_details']['land_mark_east_dag_no'],
                            'dag_w_dag_no' => $mainDagarray['agriculture_details']['land_mark_west_dag_no'],
                            'user_code' => $this->session->userdata('user_code'),
                            'operation' => 'E',
                            'date_entry' => $date,
                            'dag_status' => $mainDagarray['agriculture_details']['is_fully_paid'],
                            'possession_from' => $mainDagarray['agriculture_details']['possession_from'],
                            'map_for_property' => 'y'
                        ];
                        $mainchitha_basic = array_merge($location, $chitha_baic);
                        $chithaBasic = $this->Chitha_basic_model->insert_table('chitha_basic', $mainchitha_basic);
                        if ($chithaBasic == 0) {
                            log_message('error', "INSERT_CHITHA" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                        //////////////////////
                        if ($chithaDetailsMod['service_code'] == NC_KHAS_LAND_ID) {
                            $savimtva_array = [
                                'dist_code' => $mainDagarray['agriculture_details']['dist_code'],
                                'subdiv_code' => $mainDagarray['agriculture_details']['subdiv_code'],
                                'cir_code' => $mainDagarray['agriculture_details']['cir_code'],
                                'mouza_pargona_code' => $mainDagarray['agriculture_details']['mouza_pargona_code'],
                                'lot_no' => $mainDagarray['agriculture_details']['lot_no'],
                                'vill_townprt_code' => $mainDagarray['agriculture_details']['vill_townprt_code'],
                                'new_dag_no' => (string)$mainDagarray['agriculture_details']['new_dag_no'],
                                'mutation_date' => date('Y-m-d'),
                                'dag_no' => (string)$mainDagarray['agriculture_details']['old_dag_no'],
                                'case_no' => $case_no,
                            ];
                            $savimtva_array = $this->BhunakshaIntegrationModel->insert($savimtva_array);
                            if ($savimtva_array == 0) {
                                log_message('error', "INSERT_SAVITMVA#137895" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return false;
                            }
                        }
                        ////////////Substract Settlement Area////////////////
                        $oldAreaChitha = $this->verifyChithaArea($case_no, $mainDagarray['agriculture_details']['old_dag_no'], $mainDagarray['agriculture_details']['settlement_bigha'], $mainDagarray['agriculture_details']['settlement_katha'], $mainDagarray['agriculture_details']['settlement_lessa'], $mainDagarray['agriculture_details']['settlement_ganda']);
                        if ($oldAreaChitha) {
                            $where = [
                                'dist_code' => $mainDagarray['agriculture_details']['dist_code'],
                                'subdiv_code' => $mainDagarray['agriculture_details']['subdiv_code'],
                                'cir_code' => $mainDagarray['agriculture_details']['cir_code'],
                                'mouza_pargona_code' => $mainDagarray['agriculture_details']['mouza_pargona_code'],
                                'lot_no' => $mainDagarray['agriculture_details']['lot_no'],
                                'vill_townprt_code' => $mainDagarray['agriculture_details']['vill_townprt_code'],
                                'dag_no' => $mainDagarray['agriculture_details']['old_dag_no'],
                            ];
                            $params = [
                                'dag_area_b' => $oldAreaChitha['dag_area_b'],
                                'dag_area_k' => $oldAreaChitha['dag_area_k'],
                                'dag_area_lc' => $oldAreaChitha['dag_area_lc'],
                                'dag_area_g' => $oldAreaChitha['dag_area_g'],
                            ];

                            if ($mainDagarray['agriculture_details']['is_full_dag'] != 1) {
                                $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_basic', $params, $where);
                                if ($chithaUpdate == 0) {
                                    log_message('error', "UPDATE_CHITHA" . $this->db->last_query());
                                    $this->db->trans_rollback();
                                    return false;
                                }
                            }
                        }
                    }

                    ///////For reservation/////////////////
                    $road_side_reservation_bigha = $mainDagarray['agriculture_details']['road_side_reservation_bigha'];
                    $road_side_reservation_katha = $mainDagarray['agriculture_details']['road_side_reservation_katha'];
                    $road_side_reservation_lessa = $mainDagarray['agriculture_details']['road_side_reservation_lessa'];
                    $road_side_reservation_ganda = $mainDagarray['agriculture_details']['road_side_reservation_ganda'];
                    if ($mainDagarray['agriculture_details']['is_reservation'] != 0) {
                        // $reservation=$this->roadSideReservation($road_side_reservation_bigha,$road_side_reservation_katha,$road_side_reservation_lessa,$road_side_reservation_ganda);
                        ///////////////////////
                        if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                            $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $road_side_reservation_bigha . " বিঘা " . $road_side_reservation_katha . " কঠা " . $road_side_reservation_lessa . " চাতক " . $road_side_reservation_ganda . " গোণ্ডা মিছন বাসুন্ধৰা-2.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case_no . " নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                        } else {
                            $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $road_side_reservation_bigha . " বিঘা " . $road_side_reservation_katha . " কঠা " . $road_side_reservation_lessa . " লেচা মিছন বাসুন্ধৰা-2.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case_no . " নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                        }
                        $backlog_orders = array(
                            'dist_code' => $mainDagarray['agriculture_details']['dist_code'],
                            'subdiv_code' => $mainDagarray['agriculture_details']['subdiv_code'],
                            'cir_code' => $mainDagarray['agriculture_details']['cir_code'],
                            'mouza_pargona_code' => $mainDagarray['agriculture_details']['mouza_pargona_code'],
                            'lot_no' => $mainDagarray['agriculture_details']['lot_no'],
                            'vill_townprt_code' => $mainDagarray['agriculture_details']['vill_townprt_code'],
                            'patta_no' => $mainDagarray['agriculture_details']['old_patta_no'],
                            'patta_type_code' => $mainDagarray['agriculture_details']['old_patta_type'],
                            'dag_no' => $mainDagarray['agriculture_details']['old_dag_no'],
                            'dag_no_int' => $mainDagarray['agriculture_details']['old_dag_no'] . '00',
                            'remark' => addslashes($rmk),
                            'category' => 2,
                            'date_entry' => date('Y-m-d'),
                            'user_code' => $user_code,
                        );
                        $backlog_orders = $this->Chitha_basic_model->insert_table('backlog_orders', $backlog_orders);
                        if ($backlog_orders == 0) {
                            log_message('error', "INSERT_backlog_orders" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                    }
                    ///////////End of reservation/////////////////
                    $rmk_type_hist_no = $this->maxHistoryNoOrder($location, $mainDagarray['agriculture_details']['old_dag_no']);

                    $ord_cron_no = 1;
                    $remark_gen = array(
                        'rmk_type_code' => '01',
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'jama_updated' => null,
                        'patta_no' => $mainDagarray['agriculture_details']['new_patta_no'],
                    );
                    $chitha_remark_gen_data = (array_merge($location, $remark_gen));
                    $chitha_rmk_gen = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
                    if ($chitha_rmk_gen == 0) {
                        log_message('error', "INSERT_CHITHA_RMK_GEN" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                    //OLD DAG /////////////////
                    if (trim((string) $mainDagarray['agriculture_details']['old_dag_no']) != trim((string) $mainDagarray['agriculture_details']['new_dag_no'])) {
                        $chitha_remark_gen_data['dag_no'] = $mainDagarray['agriculture_details']['old_dag_no'];
                        $chitha_rmk_gen = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
                        if ($chitha_rmk_gen == 0) {
                            log_message('error', "INSERT_CHITHA_RMK_GEN" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                    }

                    //          var_dump($chitha_remark_gen);
                    // echo "<br>Rmkgen****************<br>";

                    $order_basic = array(
                        'rmk_type_hist_no' => $rmk_type_hist_no,
                        'ord_no' => $case_no,
                        'ord_date' => date('Y-m-d'),
                        'ord_type_code' => $service_code,
                        'ord_cron_no' => $ord_cron_no++,
                        'case_no' => $case_no,
                        'ord_passby_sign_yn' => 'Y',
                        'ord_passby_desig' => $this->session->userdata('user_desig_code'),
                        'lm_code' => $chithaDetailsMod['lmcode'],
                        'lm_sign_yn' => 'Y',
                        'lm_sign_date' => $chithaDetailsMod['lm_sign_date'],
                        'co_code' => $user_code,
                        'co_sign_yn' => 'Y',
                        'co_ord_date' => date('Y-m-d'),
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d'),
                        'operation' => 'E',
                        'm_dag_area_b' => $mainDagarray['agriculture_details']['settlement_bigha'],
                        'm_dag_area_k' => $mainDagarray['agriculture_details']['settlement_katha'],
                        'm_dag_area_lc' => $mainDagarray['agriculture_details']['settlement_lessa'],
                        'm_dag_area_g' => $mainDagarray['agriculture_details']['settlement_ganda'],
                        'm_dag_area_kr' => 0,
                        'area_left_b' => '0',
                        'area_left_k' => '0',
                        'area_left_lc' => '0',
                        'area_left_g' => '0',
                        'old_dag_area_b' => $chithaData ? $chithaData['dag_area_b'] : 0,
                        'old_dag_area_k' => $chithaData ? $chithaData['dag_area_k'] : 0,
                        'old_dag_area_lc' => $chithaData ? $chithaData['dag_area_lc'] : 0,
                        'old_dag_area_g' => $chithaData ? $chithaData['dag_area_g'] : 0,
                        'rural_urban' => $mainDagarray['agriculture_details']['is_urban'],
                        'full_partial' => $mainDagarray['agriculture_details']['is_fully_paid'],
                        'rtps_no' => $chithaDetailsMod['applid'],
                        'rtps_app_date' => $chithaDetailsMod['application_date'],
                        'dag_revenue' => $mainDagarray['agriculture_details']['new_land_revenue'],
                        'dag_local_tax' => $mainDagarray['agriculture_details']['new_land_local_tax'],
                        'ord_impli_flag' => 2,
                        'full_dag' => trim((string) $mainDagarray['agriculture_details']['old_dag_no']) != trim((string) $mainDagarray['agriculture_details']['new_dag_no']) ? 0 : $mainDagarray['agriculture_details']['is_full_dag'],
                    );

                    if ($ap_old_area_ref == true) {
                        $order_basic['old_dag_area_b'] = $ap_chitha_old_area ? $ap_chitha_old_area['dag_area_b'] : 0;
                        $order_basic['old_dag_area_k'] = $ap_chitha_old_area ? $ap_chitha_old_area['dag_area_k'] : 0;
                        $order_basic['old_dag_area_lc'] = $ap_chitha_old_area ? $ap_chitha_old_area['dag_area_lc'] : 0;
                        $order_basic['old_dag_area_g'] = $ap_chitha_old_area ? $ap_chitha_old_area['dag_area_g'] : 0;
                    }

                    $chitha_rmk_ordbasic_data = (array_merge($location, $order_basic));
                    $chitha_rmk_ordbasic = $this->Chitha_basic_model->insert_table('chitha_rmk_ordbasic', $chitha_rmk_ordbasic_data);
                    if ($chitha_rmk_ordbasic == 0) {
                        log_message('error', "INSERT_CHITHA_RMK_ORDBASIC" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return false;
                    }
                    //OLD DAG /////////////////
                    if (trim((string) $mainDagarray['agriculture_details']['old_dag_no']) != trim((string) $mainDagarray['agriculture_details']['new_dag_no'])) {
                        $chitha_rmk_ordbasic_data['dag_no'] = $mainDagarray['agriculture_details']['old_dag_no'];
                        $chitha_rmk_ordbasic = $this->Chitha_basic_model->insert_table('chitha_rmk_ordbasic', $chitha_rmk_ordbasic_data);
                        if ($chitha_rmk_ordbasic == 0) {
                            log_message('error', "INSERT_CHITHA_RMK_ORDBASIC" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                    }
                    //       var_dump($chitha_order_basic);
                    // echo "<br>ordbasic****************<br>";
                    $pdar_id = $this->maxpdarIdCheckSettlment($case_no, $mainDagarray['agriculture_details']['new_dag_no'], $mainDagarray['agriculture_details']['new_patta_type'], $mainDagarray['agriculture_details']['new_patta_no']);
                    $pattdarIdCheck = true;
                    $pdar_cron_no = 1;

                    foreach ($chithaDetailsMod['applicantArray'] as $slp) {
                        if ($slp['pdar_type'] == 'EN') {
                            continue;
                        }

                        if ($chithaDetailsMod['service_code'] == SETTLEMENT_AP_TRANSFER_ID) {

                            //********update the patta no to backlog orders */
                            $paramsP = [
                                'patta_no' => $mainDagarray['agriculture_details']['new_patta_no'],
                                'patta_type_code' => $mainDagarray['agriculture_details']['new_patta_type'],
                            ];

                            $locationP = [
                                'dist_code' => $mainDagarray['agriculture_details']['dist_code'],
                                'subdiv_code' => $mainDagarray['agriculture_details']['subdiv_code'],
                                'cir_code' => $mainDagarray['agriculture_details']['cir_code'],
                                'mouza_pargona_code' => $mainDagarray['agriculture_details']['mouza_pargona_code'],
                                'lot_no' => $mainDagarray['agriculture_details']['lot_no'],
                                'vill_townprt_code' => $mainDagarray['agriculture_details']['vill_townprt_code'],
                                'dag_no' => $mainDagarray['agriculture_details']['old_dag_no'],
                            ];

                            $updatePat = $this->Chitha_basic_model->update_table('backlog_orders', $paramsP, $locationP);
                            if ($updatePat == 0) {
                                log_message('error', "backlog_orders####" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return false;
                            }

                            if (trim($slp['pdar_type']) == 'O') {
                                if (strtolower(trim($slp['inplace_alongwith'])) == 'i') {
                                    //****cut the owner name */
                                    $params = [
                                        'p_flag' => 1,
                                    ];

                                    $where = [
                                        'dist_code' => $mainDagarray['agriculture_details']['dist_code'],
                                        'subdiv_code' => $mainDagarray['agriculture_details']['subdiv_code'],
                                        'cir_code' => $mainDagarray['agriculture_details']['cir_code'],
                                        'mouza_pargona_code' => $mainDagarray['agriculture_details']['mouza_pargona_code'],
                                        'lot_no' => $mainDagarray['agriculture_details']['lot_no'],
                                        'vill_townprt_code' => $mainDagarray['agriculture_details']['vill_townprt_code'],
                                        'dag_no' => $slp['ap_dag_no'],
                                        'patta_no' => $slp['ap_patta_no'],
                                        'patta_type_code' => $slp['ap_patta_type_code'],
                                        'pdar_id' => $slp['ap_pdar_id'],
                                    ];

                                    $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_dag_pattadar', $params, $where);
                                    if ($chithaUpdate == 0) {
                                        log_message('error', "chitha_dag_pattadar####" . $this->db->last_query());
                                        $this->db->trans_rollback();
                                        return false;
                                    }
                                }

                                //****ref with primary land owner for ap cases  */
                                if ($chitha_ap_landowner_insert != true) {
                                    $apLandOwnerInsertArr = [
                                        'case_no' => $case_no,
                                        'dist_code' => $mainDagarray['agriculture_details']['dist_code'],
                                        'subdiv_code' => $mainDagarray['agriculture_details']['subdiv_code'],
                                        'cir_code' => $mainDagarray['agriculture_details']['cir_code'],
                                        'mouza_pargona_code' => $mainDagarray['agriculture_details']['mouza_pargona_code'],
                                        'lot_no' => $mainDagarray['agriculture_details']['lot_no'],
                                        'vill_townprt_code' => $mainDagarray['agriculture_details']['vill_townprt_code'],
                                        'dag_no' => $slp['ap_dag_no'],
                                        'patta_no' => $slp['ap_patta_no'],
                                        'patta_type_code' => $slp['ap_patta_type_code'],
                                        'new_patta_no' => $mainDagarray['agriculture_details']['new_patta_no'],
                                        'new_patta_type_code' => $mainDagarray['agriculture_details']['new_patta_type'],
                                        'pdar_id' => $slp['ap_pdar_id'],
                                        'pdar_name' => $slp['applicant_assamese_name'],
                                        'pdar_guardian_name' => $slp['guardian_assamese_name'],
                                        'pdar_relation' => $slp['relation'],
                                        'pdar_gender' => $slp['gender'],
                                        'date_entry' => date('Y-m-d G:i:s'),
                                    ];

                                    $lad_owner_insert = $this->Chitha_basic_model->insert_table('chitha_ap_landowner', $apLandOwnerInsertArr);
                                    if ($lad_owner_insert == 0) {
                                        log_message('error', "#INSERT--chitha_ap_landowner####" . $this->db->last_query());
                                        $this->db->trans_rollback();
                                        return false;
                                    }
                                }

                                continue;
                            }
                        }

                        $allotee = array(
                            'rmk_type_hist_no' => $rmk_type_hist_no,
                            'ord_no' => $case_no,
                            'ord_date' => $date,
                            'ord_cron_no' => $ord_cron_no,
                            'settlement_id' => $pdar_cron_no++,
                            'settlement_name' => $slp['applicant_assamese_name'],
                            'settlement_guardian' => $slp['guardian_assamese_name'],
                            'settlement_guar_relation' => $slp['relation'],
                            'settlement_gender' => $slp['gender'],
                            'settlement_dob' => $slp['dob'],
                            // 'settlement_mother'=> $slp['pdar_mother'],
                            'settlement_land_b' => 0,
                            'settlement_land_k' => 0,
                            'settlement_land_lc' => 0,
                            'settlement_land_g' => 0,
                            'settlement_land_kr' => 0,
                            'user_code' => $this->session->userdata('user_code'),
                            'date_entry' => date('Y-m-d H:i:s'),
                            'operation' => 'E',
                            'case_no' => $case_no,
                            'patta_no' => $mainDagarray['agriculture_details']['new_patta_no'],
                            'old_patta_no' => $mainDagarray['agriculture_details']['old_patta_no'],
                            'old_dag' => $mainDagarray['agriculture_details']['old_dag_no'],
                            'new_dag' => $mainDagarray['agriculture_details']['new_dag_no'],
                            'new_patta_type' => $mainDagarray['agriculture_details']['new_patta_type'],
                            'pdar_type' => $slp['pdar_type'],
                            'lm_code' => $chithaDetailsMod['lmcode'],
                            'dc_code' => $chithaDetailsMod['dccode'],
                            'inplace_along_with' => null,
                            'dc_order_no' => $chithaDetailsMod['dc_order_no'],
                            'dc_order_date' => $chithaDetailsMod['dc_sign_date'],
                            'dept_order_no' => $mainDagarray['agriculture_details']['dept_order_no'],
                            'dept_order_date' => $mainDagarray['agriculture_details']['dept_order_date'],
                            'grn_no' => $mainDagarray['agriculture_details']['grn_no'],
                            'possession_from' => $mainDagarray['agriculture_details']['possession_from'],
                            'payment_date' => $mainDagarray['agriculture_details']['payment_date'],
                            'final_premium_amount' => $mainDagarray['agriculture_details']['final_premium_amount'],
                            'paid_amount' => $mainDagarray['agriculture_details']['paid_amount'],
                            'is_applicant' => $slp['is_applicant'],
                            'identity_type ' => $slp['identity_type'],
                            // 'pdar_occupation'=>$slp['is_applicant']==1?$chithaDetailsMod['service_code']:null,
                            'pdar_occupation' => $slp['is_applicant'] == 1 ? $chithaDetailsMod['occupation'] : null,

                            'settlement_name_eng' => $slp['applicant_english_name'],
                            'settlement_guardian_eng' => $slp['guardian_english_name'],

                        );
                        $chitha_settlement_allottee = (array_merge($location, $allotee));
                        //var_dump($chitha_settlement_allottee);
                        $chitha_settlement_allottee = $this->Chitha_basic_model->insert_table('chitha_settlement_allottee', $chitha_settlement_allottee);
                        if ($chitha_settlement_allottee == 0) {
                            log_message('error', "INSERT_CHITHA_RMK_ALLOTEE" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                        if ($mainDagarray['agriculture_details']['is_fully_paid'] != 1) {
                            $non_assigned_pattadar = [
                                'applicant_name' => $slp['applicant_assamese_name'],
                                'guardian_name' => $slp['guardian_assamese_name'],
                                'gender' => $slp['gender'],
                                'relation' => $slp['relation'],
                                'identity_type' => $slp['identity_type'],
                                'identity_ref_no' => $slp['identity_ref_no'],
                                'new_dag_no' => $mainDagarray['agriculture_details']['new_dag_no'],
                                'case_no' => $case_no,
                            ];
                            $pattadar_non_assigned = array_merge($location, $non_assigned_pattadar);
                            $partial_payment = $this->Chitha_basic_model->insert_table('partial_payment', $pattadar_non_assigned);
                            if ($partial_payment == 0) {
                                log_message('error', "INSERT_pattadar_non_assigned" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return false;
                            }
                            //****
                            continue;
                        }
                        //Insert query/////////////////
                        $final_pdarId = $pdar_id;
                        $c_d_p = array(
                            'pdar_id' => $final_pdarId,
                            'patta_no' => $mainDagarray['agriculture_details']['new_patta_no'],
                            'patta_type_code' => $mainDagarray['agriculture_details']['new_patta_type'],
                            'dag_por_b' => $this->utilityclass->assToeng($mainDagarray['agriculture_details']['settlement_bigha']),
                            'dag_por_k' => $this->utilityclass->assToeng($mainDagarray['agriculture_details']['settlement_katha']),
                            'dag_por_lc' => $this->utilityclass->assToeng($mainDagarray['agriculture_details']['settlement_lessa']),
                            'dag_por_g' => $this->utilityclass->assToeng($mainDagarray['agriculture_details']['settlement_ganda']),
                            'dag_por_kr' => 0,
                            'user_code' => $user_code,
                            'date_entry' => date('Y-m-d'),
                            'operation' => 'E',
                            'p_flag' => '0',
                            'jama_yn' => 'N',
                        );
                        $chitha_dag_pattadar = array_merge($location, $c_d_p);
                        // var_dump($chitha_dag_pattadar);
                        $chitha_dag_pattadar = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar', $chitha_dag_pattadar);
                        if ($chitha_dag_pattadar == 0) {
                            log_message('error', "INSERT_chitha_dag_pattadar" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                        //////////////////Nominee Details Insert/////////////////////////
                        if ($slp['is_applicant'] == 1 && !empty($chithaDetailsMod['nominee']) && $chitha_nominee == true) {
                            foreach ($chithaDetailsMod['nominee'] as $nominee) {
                                $chitha_nominee_pattadar = [
                                    'patta_no' => $mainDagarray['agriculture_details']['new_patta_no'],
                                    'patta_type_code' => $mainDagarray['agriculture_details']['new_patta_type'],
                                    'pdar_id' => $final_pdarId,
                                    'nominee_name' => $nominee['nominee_name'],
                                    'nominee_name_eng' => $nominee['nominee_name_eng'],
                                    'nominee_guardian_name' => $nominee['nominee_guardian_name'],
                                    'nominee_guardian_eng_name' => $nominee['nominee_guardian_eng_name'],
                                    'nominee_address' => $nominee['nominee_address'],
                                    'nominee_mobile' => $nominee['nominee_mobile'],
                                    'nominee_relation' => $nominee['nominee_relation'],
                                    'nominee_email' => $nominee['nominee_email'],
                                ];
                                $nominee_insert = array_merge($location, $chitha_nominee_pattadar);
                                $chitha_nominee_pattadar = $this->Chitha_basic_model->insert_table('chitha_nominee_pattadar', $nominee_insert);
                                if ($chitha_nominee_pattadar == 0) {
                                    log_message('error', "INSERT_chitha_nominee_pattadar" . $this->db->last_query());
                                    $this->db->trans_rollback();
                                    return false;
                                }
                            }
                            $chitha_nominee = false;
                        }
                        /////////////Chitha Pattadar////////////////
                        if ($chitha_pattadar == true) {
                            $chitha_pattadar = array(
                                'dist_code' => $mainDagarray['agriculture_details']['dist_code'],
                                'subdiv_code' => $mainDagarray['agriculture_details']['subdiv_code'],
                                'cir_code' => $mainDagarray['agriculture_details']['cir_code'],
                                'mouza_pargona_code' => $mainDagarray['agriculture_details']['mouza_pargona_code'],
                                'lot_no' => $mainDagarray['agriculture_details']['lot_no'],
                                'vill_townprt_code' => $mainDagarray['agriculture_details']['vill_townprt_code'],
                                'patta_no' => $mainDagarray['agriculture_details']['new_patta_no'],
                                'patta_type_code' => $mainDagarray['agriculture_details']['new_patta_type'],
                                'pdar_id' => $final_pdarId,
                                'pdar_name' => $slp['applicant_assamese_name'],
                                'pdar_father' => $slp['guardian_assamese_name'],
                                'pdar_name_eng' => $slp['applicant_english_name'],
                                'pdar_guard_eng' => $slp['guardian_english_name'],
                                'pdar_add1' => $slp['present_address'],
                                'pdar_add2' => $slp['permanent_address'],
                                'dob' => $slp['dob'],
                                'o1_case_no' => $case_no,
                                //'pdar_pan_no' => $alp->alotee_pan_card,
                                'user_code' => $user_code,
                                'date_entry' => date('Y-m-d'),
                                'operation' => 'E',
                                'jama_yn' => 'n',
                                'pdar_guard_reln' => $this->utilityclass->relationByID($slp['relation']),
                                'pdar_gender' => ($slp['gender'] == 1) ? 'm' : (($slp['gender'] == 2) ? 'f' : 'o'),
                                'pdar_minor_yn' => null,
                                'pdar_minor_dob' => null,
                                'pdar_caste' => $slp['caste'],
                                // 'pdar_mother' => $slp['pdar_mother'],
                                // 'pdar_aadharno' => null,
                                'pdar_mobile' => $slp['mobile'],
                                'new_pdar_name' => 'N',
                                // 'pdar_occupation'=>$slp['is_applicant']==1?$chithaDetailsMod['service_code']:null,
                                'pdar_occupation' => $slp['is_applicant'] == 1 ? $chithaDetailsMod['occupation'] : null,

                                'mask_id' => $slp['mask_id'],
                            );
                            if ($slp['identity_type'] == 'AADHAAR' && $slp['is_applicant'] == 1) {
                                $chitha_pattadar['pdar_aadharno'] = $slp['identity_ref_no'];
                            }
                            if ($slp['identity_type'] == 'PAN' && $slp['is_applicant'] == 1) {
                                $chitha_pattadar['pdar_pan_no'] = $slp['identity_ref_no'];
                            }
                            if ($slp['identity_type'] == 'DL' && $slp['is_applicant'] == 1) {
                                $chitha_pattadar['pdar_nrcno'] = $slp['identity_ref_no'];
                            }
                            $chitha_pattadar = $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);

                            if ($chitha_pattadar == 0) {
                                log_message('error', "INSERT_chitha_pattadar" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return false;
                            }
                        }
                        $pdar_id++;
                    }
                    $pattdarIdCheck = $chitha_pattadar = false;
                }
            }

            return true;
        } else {
            return false;
        }
    }
    public function maxHistoryNoOrder($main, $olddag)
    {
        $q = "Select max(rmk_type_hist_no) c from chitha_rmk_ordbasic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? ";
        $histNo = $this->db->query($q, array($main['dist_code'], $main['subdiv_code'], $main['cir_code'], $main['mouza_pargona_code'], $main['lot_no'], $main['vill_townprt_code'], $olddag));
        if ($histNo->num_rows() == 0) {
            $rmk_type_hist_no = 1;
        } else {
            $rmk_type_hist_no = ($histNo->row()->c) + 1;
        }
        //////////////////////////////////////
        $q = "Select max(rmk_type_hist_no) c from chitha_rmk_gen where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? ";
        $histNo = $this->db->query($q, array($main['dist_code'], $main['subdiv_code'], $main['cir_code'], $main['mouza_pargona_code'], $main['lot_no'], $main['vill_townprt_code'], $olddag));
        if ($histNo->num_rows() == 0) {
            $rmk_type_hist_noo = 1;
        } else {
            $rmk_type_hist_noo = ($histNo->row()->c) + 1;
        }
        ////////////////
        if ($rmk_type_hist_no > $rmk_type_hist_noo) {
            return $rmk_type_hist_no;
        } else {
            return $rmk_type_hist_noo;
        }
    }
    public function maxpdarIdCheckSettlment($case_no, $dag_no, $patta_type, $patta_no)
    {
        // die;
        $sql1 = "Select * from settlement_dag_details where case_no=? ";
        $main = $this->db->query($sql1, array($case_no))->row_array();
        $pattadars_in_chitha_pattadar = $pattadars_in_jama_pattadar = $pattadars_in_chithaDag_pattadar = 0;
        // $pattadars_in_chitha_pattadar = $this->db->query("select max(pdar_id::int)+1 as cp from chitha_pattadar where
        //         dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and  patta_type_code=? and TRIM(patta_no)::varchar=trim(?)",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$patta_type,(string)$patta_no));
        // // echo $this->db->last_query();
        // if($pattadars_in_chitha_pattadar->num_rows()>0){
        //     $pattadars_in_chitha_pattadar=$pattadars_in_chitha_pattadar->row()->cp;
        // }
        // $pattadars_in_jama_pattadar = $this->db->query("select max(pdar_id::int)+1 as jp from jama_pattadar where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and
        //             TRIM(patta_no)=trim(?)",array($main['dist_code'],$main['subdiv_code'],$main['cir_code'],$main['mouza_pargona_code'],$main['lot_no'],$main['vill_townprt_code'],$patta_type,(string)$patta_no));
        // if($pattadars_in_jama_pattadar->num_rows()>0){
        //     $pattadars_in_jama_pattadar=$pattadars_in_jama_pattadar->row()->jp;
        // }
        // echo $this->db->last_query();
        $pattadars_in_chithaDag_pattadar = $this->db->query("select max(pdar_id::int)+1 as dp from chitha_dag_pattadar where
																				dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and patta_type_code=? and  TRIM(patta_no)=trim(?) and dag_no=?", array($main['dist_code'], $main['subdiv_code'], $main['cir_code'], $main['mouza_pargona_code'], $main['lot_no'], $main['vill_townprt_code'], $patta_type, (string) $patta_no, (string) $dag_no));
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
    public function roadSideReservation($bigha, $katha, $lessa, $ganda, $reserveAreaRoad = 0)
    {
        if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
            $applied = $bigha * 6400 + $katha * 320 + $lessa * 20 + $ganda;
            $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa2($applied - $reserveAreaRoad);
        } else {
            $applied = $bigha * 100 + $katha * 20 + $lessa;
            $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa($applied - $reserveAreaRoad);
        }
        return [
            'dag_area_b' => $areaSubstract[0],
            'dag_area_k' => $areaSubstract[1],
            'dag_area_lc' => $areaSubstract[2],
            'dag_area_g' => $areaSubstract[3],
        ];
    }
    public function verifyChithaArea($case_no, $dag_no, $bigha, $katha, $lessa, $ganda)
    {
        $response = $this->fecthLocation($case_no, $dag_no);
        if ($response) {
            $bigha = $bigha;
            $katha = $katha;
            $lessa = $lessa;
            $ganda = $ganda;
            $chithaArea = $this->chithaBasic($response['dist_code'], $response['subdiv_code'], $response['cir_code'], $response['mouza_pargona_code'], $response['lot_no'], $response['vill_townprt_code'], $dag_no);
            if ($chithaArea) {
                // log_message('error',json_encode($chithaArea));
                $chithaAreabigha = $chithaArea['dag_area_b'];
                $chithaAreakatha = $chithaArea['dag_area_k'];
                $chithaArealessa = $chithaArea['dag_area_lc'];
                $chithaAreaganda = $chithaArea['dag_area_g'];
                // log_message('error',$chithaAreabigha.$chithaAreakatha.$chithaArealessa.$chithaAreaganda);
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $applied = $bigha * 6400 + $katha * 320 + $lessa * 20 + $ganda;
                    $totalArea = $chithaAreabigha * 6400 + $chithaAreakatha * 320 + $chithaArealessa * 20 + $chithaAreaganda;
                    // log_message('error','APPLIED'.$applied."TOTALAREA".$totalArea);
                    $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalArea - $applied);
                } else {
                    $applied = $bigha * 100 + $katha * 20 + $lessa;
                    $totalArea = $chithaAreabigha * 100 + $chithaAreakatha * 20 + $chithaArealessa;
                    $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa($totalArea - $applied);
                    // log_message('error', 'APPLIED' . $applied . "TOTALAREA" . $totalArea . "SUB" . json_encode($areaSubstract));
                }
                if ($areaSubstract >= 0) {
                    return [
                        'dag_area_b' => $areaSubstract[0],
                        'dag_area_k' => $areaSubstract[1],
                        'dag_area_lc' => $areaSubstract[2],
                        'dag_area_g' => $areaSubstract[3],
                    ];
                } else {
                    return false;
                }
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    public function fecthLocation($case_no, $dag_no)
    {
        $sql1 = "Select * from settlement_dag_details where case_no=? and dag_no=? ";
        $main = $this->db->query($sql1, array($case_no, $dag_no));
        if ($main->num_rows() > 0) {
            return $main->row_array();
        } else {
            return false;
        }
    }
    public function chithaBasic($d, $s, $c, $m, $l, $v, $dag)
    {
        $sql1 = "Select * from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? ";
        $main = $this->db->query($sql1, array($d, $s, $c, $m, $l, $v, $dag));
        // log_message('error',$this->db->last_query());
        if ($main->num_rows() > 0) {
            return $main->row_array();
        } else {
            return false;
        }
    }
    // *******************LAND BANK INSERTION********************************
    public function getAllApplicantEncroacher($case)
    {
        $applicants = $this->db->select()
            ->where('case_no', $case)
            ->where('pdar_type', 'EN')
            ->get('settlement_applicant');
        return $applicants->result();
    }

    //lb details approve handle for settlement application cases---------29122022
    // public function lbdetailsApproveSettlementCases($lb_details_id,$elb_enc_id,$uuid,$dag_no,$application_no,$lb_approval_rmk){
    //     error_reporting(0);
    //     date_default_timezone_set("Asia/Calcutta");
    //     //getting the location,dag and year details frtom land bank details table
    //     $this->db->select('*')
    //         ->where('id',  $lb_details_id)
    //         ->where('village_uuid',  $uuid)
    //         ->where('dag_no',  $dag_no)
    //         ->from('land_bank_details');
    //     $query = $this->db->get();
    //     $lb_details = $query->row_array();
    //     // log_message('error',"LANDBANKCHECK"."$application_no".$this->db->last_query());
    //     if(count($lb_details) > 0){
    //         //update data in land bank details
    //         $this->db->where('id', $lb_details_id)
    //             ->where('village_uuid',  $uuid)
    //             ->where('dag_no',  $dag_no)
    //             ->update('land_bank_details', array(
    //                 'status' => LAND_BANK_STATUS_APPROVED
    //             ));
    //         if($this->db->affected_rows() != 1){
    //             //if error in update--------
    //             log_message("error", "#LBSETL001, Error in update, table 'land_bank_details' in changing status to approved");
    //             return array(
    //                 'responseType' => 0,
    //                 'msg'=>"#LBSETL001: Insertion fail in Land Bank for case no : ".$application_no
    //             );
    //             // return json_encode($data);
    //             // return false;
    //         }
    //     }else{
    //         log_message("error", "#LBSETL003, Error in fetch, table 'land_bank_details' in changing status to approved");
    //         return array(
    //             'responseType' => 0,
    //             'msg'=>"#LBSETL003: Insertion fail in Land Bank for case no : ".$application_no
    //         );
    //         // return json_encode($data);
    //         // return false;
    //     }

    //     //******************//
    //     //insert data in land bank proceeding details
    //     $tstatus1 = $this->db->insert('land_bank_proceeding_details', array(
    //         'land_bank_details_id' => $lb_details_id,
    //         'remark' => $lb_approval_rmk,
    //         'status' => LAND_BANK_STATUS_APPROVED,
    //         'created_at' => date('Y-m-d H:i:s'),
    //         'approved_by' => $this->session->all_userdata()['user_code']
    //     ));
    //     if ($tstatus1 != 1 )
    //     {
    //         log_message("error", "#LBSETL002, Error in insert on land_bank_proceeding_details table with land bank details id ". $lb_details_id);
    //         return array(
    //             'responseType' => 0,
    //             'msg'=>"#LBSETL002: Insertion fail in Land Bank for case no : ".$application_no
    //         );
    //         // return json_encode($data);
    //         // return false;
    //     }

    //     //insert data in c_land_bank_details table -------------
    //     $this->db->select('id')
    //         ->where('village_uuid',  $uuid)
    //         ->where('dag_no',  $dag_no)
    //         ->from('c_land_bank_details');
    //     $query = $this->db->get();
    //     $c_lb_id = $query->row()->id;
    //     if ($c_lb_id == null || $c_lb_id == '' )
    //     {
    //         log_message("error", "#LBSETLE4U, Error in fetch on c_land_bank_details table");
    //         return array(
    //             'responseType' => 0,
    //             'msg'=>"#LBSETLE4U: Insertion fail in Land Bank for case no : ".$application_no
    //         );
    //         // return json_encode($data);
    //         // return false;
    //     }

    //     //return $c_land_bank_inserted_id;
    //     //getting data from land bank encroacher details
    //     $this->db->select('*')
    //         ->where('land_bank_details_id',  $lb_details_id)
    //         ->where('application_no',  $application_no)
    //         ->where('id',$elb_enc_id)
    //         ->from('land_bank_encroacher_details');
    //     $query = $this->db->get();
    //     $lb_encroacher_details_array = $query->row_array();
    //     //insert data in the land bank encroacher details
    //     unset($lb_encroacher_details_array['land_bank_details_id']);
    //     $lb_encroacher_details_array['c_land_bank_details_id'] = $c_lb_id;
    //     $tstatus3 = $this->db->insert('c_land_bank_encroacher_details', $lb_encroacher_details_array);
    //     if ($tstatus3 != 1 )
    //     {
    //         log_message("error", "#LANDBNK001333, Error in insert on c_land_bank_encroacher_details table");
    //         return array(
    //             'responseType' => 0,
    //             'msg'=>"#LANDBNK001333: Insertion fail in Land Bank for case no : ".$application_no
    //         );
    //         // return json_encode($data);
    //         // return false;
    //     }
    //     //******************//
    //     //transaction final check
    //     if($this->db->trans_status()==FALSE){
    //         log_message("error", "#LANDBNK0013, Transaction Status Error");

    //         return array(
    //             'responseType' => 0,
    //             'msg'=>"#LANDBNK0013: Insertion fail in Land Bank for case no : ".$application_no
    //         );
    //         // return json_encode($data);
    //         // return false;
    //     }else{
    //         return array(
    //             'responseType' => 1,
    //             'msg'=>"#LANDBNK00133: Data successfully inserted into Land Bank : ".$application_no
    //         );
    //         // return json_encode($data);
    //     }
    // }
    public function lbdetailsApproveSettlementCases($lb_details_id, $elb_enc_id, $uuid, $dag_no, $application_no, $lb_approval_rmk)
    {
        error_reporting(0);
        date_default_timezone_set("Asia/Calcutta");
        //getting the location,dag and year details frtom land bank details table
        $this->db->select('*')
            ->where('id', $lb_details_id)
            ->where('village_uuid', $uuid)
            ->where('dag_no', $dag_no)
            ->from('land_bank_details');
        $query = $this->db->get();
        $lb_details = $query->row_array();
        log_message('error', "LANDBANK001" . $this->db->last_query());
        if (count($lb_details) > 0) {
            //update data in land bank details
            $this->db->where('id', $lb_details_id)
                ->where('village_uuid', $uuid)
                ->where('dag_no', $dag_no)
                ->update('land_bank_details', array(
                    'status' => LAND_BANK_STATUS_APPROVED,
                ));
            if ($this->db->affected_rows() != 1) {
                //if error in update--------
                log_message("error", "#LBSETL001, Error in update, table 'land_bank_details' in changing status to approved");
                return array(
                    'responseType' => 0,
                    'msg' => "#LBSETL001: Insertion fail in Land Bank for case no : " . $application_no,
                );
                // return json_encode($data);
                // return false;
            }
        } else {
            log_message("error", "#LBSETL003, Error in fetch, table 'land_bank_details' in changing status to approved");
            return array(
                'responseType' => 0,
                'msg' => "#LBSETL003: Insertion fail in Land Bank for case no : " . $application_no,
            );
            // return json_encode($data);
            // return false;
        }

        //******************//
        //insert data in land bank proceeding details
        $tstatus1 = $this->db->insert('land_bank_proceeding_details', array(
            'land_bank_details_id' => $lb_details_id,
            'remark' => $lb_approval_rmk,
            'status' => LAND_BANK_STATUS_APPROVED,
            'created_at' => date('Y-m-d H:i:s'),
            'approved_by' => $this->session->all_userdata()['user_code'],
        ));
        log_message('error', "LANDBANK002" . $this->db->last_query());
        if ($tstatus1 != 1) {
            log_message("error", "#LBSETL002, Error in insert on land_bank_proceeding_details table with land bank details id " . $lb_details_id);
            return array(
                'responseType' => 0,
                'msg' => "#LBSETL002: Insertion fail in Land Bank for case no : " . $application_no,
            );
            // return json_encode($data);
            // return false;
        }

        //insert data in c_land_bank_details table -------------
        $this->db->select('id')
            ->where('village_uuid', $uuid)
            ->where('dag_no', $dag_no)
            ->from('c_land_bank_details');
        $query = $this->db->get();
        $c_lb_id = $query->row()->id;
        // log_message('error',"LANDBANK003".$this->db->last_query());
        if ($c_lb_id == null || $c_lb_id == '') {
            log_message("error", "#LBSETLE4U, Error in fetch on c_land_bank_details table");
            return array(
                'responseType' => 0,
                'msg' => "#LBSETLE4U: Insertion fail in Land Bank for case no : " . $application_no,
            );
            // return json_encode($data);
            // return false;
        }

        //return $c_land_bank_inserted_id;
        //getting data from land bank encroacher details
        $this->db->select('*')
            ->where('land_bank_details_id', $lb_details_id)
            ->where('application_no', $application_no)
            ->where('id', $elb_enc_id)
            ->from('land_bank_encroacher_details');
        $query = $this->db->get();
        $lb_encroacher_details_array = $query->row_array();
        //insert data in the land bank encroacher details
        unset($lb_encroacher_details_array['land_bank_details_id']);
        $lb_encroacher_details_array['c_land_bank_details_id'] = $c_lb_id;
        $tstatus3 = $this->db->insert('c_land_bank_encroacher_details', $lb_encroacher_details_array);
        // log_message('error',"LANDBANK004".$this->db->last_query());
        if ($tstatus3 != 1) {
            log_message("error", "#LANDBNK001333, Error in insert on c_land_bank_encroacher_details table");
            return array(
                'responseType' => 0,
                'msg' => "#LANDBNK001333: Insertion fail in Land Bank for case no : " . $application_no,
            );
            // return json_encode($data);
            // return false;
        }
        //******************//
        //transaction final check
        if ($this->db->trans_status() == false) {
            log_message("error", "#LANDBNK0013, Transaction Status Error");
            return array(
                'responseType' => 0,
                'msg' => "#LANDBNK0013: Insertion fail in Land Bank for case no : " . $application_no,
            );
            // return json_encode($data);
            // return false;
        } else {
            return array(
                'responseType' => 1,
                'msg' => "#LANDBNK00133: Data successfully inserted into Land Bank : " . $application_no,
            );
            // return json_encode($data);
        }
    }

    public function landBankEncIncVal($case_no)
    {
        $applicants_encroacher = $this->getAllApplicantEncroacher($case_no);
        foreach ($applicants_encroacher as $applicant_enc) {
            $enc_check = $this->db->query("SELECT * FROM settlement_land_bank_details WHERE application_no =? AND dag_no =?", array($this->utilityclass->getApplidFromCaseNo($case_no), $applicant_enc->dag_no));

            if ($enc_check->num_rows() > 0) {
                //***check is already inserted in c_land_bank_details */
                $application_no = $this->utilityclass->getApplidFromCaseNo($case_no);

                $applicationNumbers = array($case_no, $application_no);

                $placeholders = rtrim(str_repeat('?, ', count($applicationNumbers)), ', ');

                $cSql = $this->db->query("SELECT * FROM c_land_bank_encroacher_details WHERE application_no IN ($placeholders)", $applicationNumbers);

                // echo $this->db->last_query();
                // die;

                if ($cSql->num_rows() <= 0) {
                    $sql_land_bank = $this->db->query("SELECT B.land_bank_details_id, B.id AS enc_id, A.dag_no, A.village_uuid AS uuid, B.name, B.fathers_name, B.encroachment_from, B.encroachment_to, B.landless_indigenous, B.erosion, B.landless, B.caste, B.gender, B.type_of_land_use, B.application_no FROM land_bank_details A INNER JOIN land_bank_encroacher_details B ON A.id = B.land_bank_details_id where A.id = ? AND A.village_uuid = ? AND A.dag_no = ? AND B.id = ? ORDER BY A.id DESC LIMIT 1", array($enc_check->row()->land_bank_details_id, $enc_check->row()->uuid, $enc_check->row()->dag_no, $enc_check->row()->encroacher_id));

                    // echo $this->db->last_query();
                    if ($sql_land_bank->num_rows() > 0) {
                        $lb_details_id = $sql_land_bank->row()->land_bank_details_id;
                        $elb_enc_id = $sql_land_bank->row()->enc_id;
                        $uuid = $sql_land_bank->row()->uuid;
                        $dag_no = $sql_land_bank->row()->dag_no;
                        $application_no = $sql_land_bank->row()->application_no;
                        $lb_approval_rmk = "Approved by DC";

                        $insertVLBquery = $this->lbdetailsApproveSettlementCases($lb_details_id, $elb_enc_id, $uuid, $dag_no, $application_no, $lb_approval_rmk);

                        // $VLBresponse = json_decode($insertVLBquery);
                        if ($insertVLBquery['responseType'] != 1) {
                            $this->db->trans_rollback();
                            log_message('error', '#LNDBNK0002212: Insertion failed in landbank for case no :' . $case_no);
                            return array(
                                'responseType' => 0,
                                'msg' => '#LNDBNK0002212: Unable to process!',
                            );
                        }
                    }
                }

                //***strike out the encroacher  */
                $checkInsL = $this->db->query("select * from land_bank_encroacher_details where application_no IN ($placeholders)", $applicationNumbers);
                // echo $this->db->last_query();
                if ($checkInsL->num_rows() <= 0) {
                    $this->db->trans_rollback();
                    return array(
                        'responseType' => 0,
                        'msg' => '#LNDBNK4336: Unable to process!',
                    );
                }

                $updateLandB = array(
                    'p_flag' => 1,
                );

                $this->db->where_in('application_no', array($case_no, $application_no));
                $this->db->update('land_bank_encroacher_details', $updateLandB);

                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    return array(
                        'responseType' => 0,
                        'msg' => '#LNDBNK4341: Unable to process!',
                    );
                }

                $checkInsCL = $this->db->query("select * from c_land_bank_encroacher_details where application_no IN ($placeholders)", $applicationNumbers);
                // echo $this->db->last_query();
                if ($checkInsCL->num_rows() <= 0) {
                    $this->db->trans_rollback();
                    return array(
                        'responseType' => 0,
                        'msg' => '#LNDBNK4362: Unable to process!',
                    );
                }

                $this->db->where_in('application_no', array($case_no, $application_no));
                $this->db->update('c_land_bank_encroacher_details', $updateLandB);
                if ($this->db->affected_rows() == 0) {
                    $this->db->trans_rollback();
                    return array(
                        'responseType' => 0,
                        'msg' => '#LNDBNK4352: Unable to process!',
                    );
                }
            }
        }

        return array(
            'responseType' => 2,
            'msg' => 'Landbank Success...',
        );
    }
    // ***************************************************
    public function settlementPaymentHistory($case_no)
    {
        $sql = "Select * from settlement_emi_history where case_no=?";
        $data = $this->db->query($sql, $case_no);
        if ($data->num_rows() == 0) {
            $sql1 = $this->db->query("Select * from settlement_premium where case_no=? and is_final=? and grn_no is not null ", array($case_no, '1'));
            if ($sql1->num_rows() > 0) {
                $data1 = $sql1->row();
                $data2 = $sql1->result();
                foreach ($data2 as $dags) {
                    $list[] = $dags->dag_no;
                }
                $settlement_emi_history = [
                    'case_no' => $case_no,
                    'application_no' => $this->utilityclass->getApplidFromCaseNo($case_no),
                    'final_amount' => $data1->due_amount,
                    'paid_amount' => $data1->paid_amount,
                    'remaining_amount' => $data1->remaining_amount,
                    'tenure' => $data1->tenure,
                    'installment_amount' => $data1->installment_amount,
                    'payment_date' => $data1->payment_date,
                    'grn_no' => $data1->grn_no,
                    'challen_link' => $data1->due_amount,
                    'old_dag_no' => $data1->manual_challan_upload_dir,
                    'settlement_dag_no' => implode(',', $list),
                    'is_full_paid' => $data1->due_amount <= $data1->paid_amount ? 1 : 0,
                    'date_entry' => date('Y-m-d'),
                ];
                $settlement_emi_history = $this->Chitha_basic_model->insert_table('settlement_emi_history', $settlement_emi_history);
                if ($settlement_emi_history == 0) {
                    log_message('error', "INSERT_settlement_emi_history" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                } else {
                    return true;
                }
            } else {
                return false;
            }
        } else {
            return true;
        }
    }

    public function caseDetailsPartialPayment($case_no, $chithaDetailsMod)
    {
        $user_code = $this->session->userdata('user_code');
        $chitha_pattadar = true;

        $chitha_dag_pattadar_insertion = false;
        $chitha_pattadar_insertion = false;
        $chitha_rmk_gen_insertion = false;
        $chitha_rmk_ordbasic_insertion = false;
        $chitha_flag_update = false;
        foreach ($chithaDetailsMod as $case_row) {
            // var_dump($case_row);
            if (!in_array($case_row->service_code, ['15', '16', '17', '18'])) {
                return array(
                    'responseType' => 0,
                    'msg' => '#ERR1663: Service code not allowed...',
                );
            }
            if ($case_row->is_full_paid != 1) {
                return array(
                    'responseType' => 0,
                    'msg' => '#ERR1783: Partial payment case...',
                );
            }
            //update chitha_basic with patta_no, patta_type_code
            $table = 'chitha_basic';
            $cb_array = [
                'patta_no' => $case_row->new_patta_no,

                'patta_type_code' => $case_row->new_patta_type,
                'updated_on' => date('Y-m-d H:i:s'),
            ];
            $where = [
                'dist_code' =>  $case_row->dist_code,
                'subdiv_code' =>  $case_row->subdiv_code,
                'cir_code' =>  $case_row->cir_code,
                'mouza_pargona_code' =>  $case_row->mouza_pargona_code,
                'lot_no' =>  $case_row->lot_no,
                'vill_townprt_code' =>  $case_row->vill_townprt_code,
                'dag_no' =>  $case_row->new_dag,
            ];
            // $this->db->where('dist_code', $case_row->dist_code);
            // $this->db->where('subdiv_code', $case_row->subdiv_code);
            // $this->db->where('cir_code', $case_row->cir_code);
            // $this->db->where('mouza_pargona_code', $case_row->mouza_pargona_code);
            // $this->db->where('lot_no', $case_row->lot_no);
            // $this->db->where('vill_townprt_code', $case_row->vill_townprt_code);
            // $this->db->where('dag_no', $case_row->new_dag);
            // $this->db->update('chitha_basic', $cb_array);
            $result = $this->Chitha_basic_model->update_table($table, $cb_array, $where);
            if ($result != 1) {
                return array(
                    'responseType' => 0,
                    'msg' => '#ERR1683: Unable to update chitha! Something went wrong...' . $this->db->last_query(),
                );
            }

            //get hist_no
            $location['dist_code'] = $case_row->dist_code;
            $location['subdiv_code'] = $case_row->subdiv_code;
            $location['cir_code'] = $case_row->cir_code;
            $location['mouza_pargona_code'] = $case_row->mouza_pargona_code;
            $location['lot_no'] = $case_row->lot_no;
            $location['vill_townprt_code'] = $case_row->vill_townprt_code;
            $location['dag_no'] = $case_row->new_dag;

            $hist_no = $this->maxHistoryNoOrder($location, $case_row->old_dag);
            //insert into chitha_settlement_allottee with new payment detail
            $pdar_id = $this->maxpdarIdCheckSettlment($case_no, $case_row->new_dag, $case_row->new_patta_type, $case_row->new_patta_no);
            foreach ($case_row->chitha_settlement_allottee_result as $allot_row) {
                $allot_row->rmk_type_hist_no = $hist_no;
                $allot_row->ord_cron_no = (int) $allot_row->ord_cron_no + 1;
                // $allot_row->settlement_id        =
                $allot_row->date_entry = date('Y-m-d H:i:s');
                $allot_row->patta_no = $case_row->new_patta_no;
                // $allot_row->old_patta_no         = $case_row->new_patta_no
                // $allot_row->old_dag              = $case_row->old_dag;
                // $allot_row->new_dag              = $case_row->new_dag;
                $allot_row->new_patta_type = $case_row->new_patta_type;
                $allot_row->grn_no = $case_row->grn_no;
                $allot_row->payment_date = $case_row->payment_date;
                $allot_row->final_premium_amount = $case_row->full_amount;
                $allot_row->paid_amount = $case_row->installment_paid_amount;
                $allot_row->user_code = $user_code;
                $allot_row->ord_date = date('Y-m-d H:i:s');

                $insert_settlement_allottee = $this->db->insert('chitha_settlement_allottee', $allot_row);
                if ($insert_settlement_allottee != true) {
                    return array(
                        'responseType' => 0,
                        'msg' => '#ERR1716: Unable to update chitha! Something went wrong...',
                    );
                }
                //insert chitha_dag_pattadar
                $dag_pattadar_array = [
                    'dist_code' => $location['dist_code'],
                    'subdiv_code' => $location['subdiv_code'],
                    'cir_code' => $location['cir_code'],
                    'mouza_pargona_code' => $location['mouza_pargona_code'],
                    'lot_no' => $location['lot_no'],
                    'vill_townprt_code' => $location['vill_townprt_code'],
                    'dag_no' => $location['dag_no'],
                    'pdar_id' => $pdar_id,
                    'patta_no' => $case_row->new_patta_no,
                    'patta_type_code' => $case_row->new_patta_type,
                    'dag_por_b' => $this->utilityclass->assToeng($case_row->bigha),
                    'dag_por_k' => $this->utilityclass->assToeng($case_row->katha),
                    'dag_por_lc' => $this->utilityclass->assToeng($case_row->lessa),
                    'dag_por_g' => $this->utilityclass->assToeng($case_row->ganda),
                    'dag_por_kr' => 0,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d H:i:s'),
                    'operation' => 'E',
                    'p_flag' => '0',
                    'jama_yn' => 'N',
                ];
                // $insert_dag_pattadar = $this->db->insert('chitha_dag_pattadar', $dag_pattadar_array);
                $insert_dag_pattadar = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar', $dag_pattadar_array);
                if ($insert_dag_pattadar != true) {
                    return array(
                        'responseType' => 0,
                        'msg' => '#ERR1743: Unable to update chitha! Something went wrong...',
                    );
                }
                $chitha_dag_pattadar_insertion = true;
                //insert chitha_pattadar
                if ($chitha_pattadar == true) {

                    $chitha_pattadar_array = array(
                        'dist_code' => $case_row->dist_code,
                        'subdiv_code' => $case_row->subdiv_code,
                        'cir_code' => $case_row->cir_code,
                        'mouza_pargona_code' => $case_row->mouza_pargona_code,
                        'lot_no' => $case_row->lot_no,
                        'vill_townprt_code' => $case_row->vill_townprt_code,
                        'patta_no' => $case_row->new_patta_no,
                        'patta_type_code' => $case_row->new_patta_type,
                        'pdar_id' => $pdar_id,
                        'pdar_name' => $allot_row->settlement_name,
                        'pdar_father' => $allot_row->settlement_guardian,
                        'pdar_name_eng' => $allot_row->settlement_name_eng,
                        'pdar_guard_eng' => $allot_row->settlement_guardian_eng,
                        'pdar_add1' => $case_row->is_applicant_row->pdar_add1,
                        'pdar_add2' => $case_row->is_applicant_row->pdar_add2,
                        'dob' => $allot_row->settlement_dob,
                        'o1_case_no' => $case_no,
                        //'pdar_pan_no' => $alp->alotee_pan_card,
                        'user_code' => $user_code,
                        'date_entry' => date('Y-m-d H:i:s'),
                        'operation' => 'E',
                        'jama_yn' => 'n',
                        'pdar_guard_reln' => $this->utilityclass->relationByID($allot_row->settlement_guar_relation),
                        'pdar_gender' => ($allot_row->settlement_gender == '1') ? 'm' : (($allot_row->settlement_gender == '2') ? 'f' : 'o'),
                        'pdar_minor_yn' => null,
                        'pdar_minor_dob' => null,
                        'pdar_caste' => $case_row->basic_row->caste,
                        // 'pdar_mother' => $slp['pdar_mother'],
                        // 'pdar_aadharno' => null,
                        'pdar_mobile' => $case_row->is_applicant_row->pdar_mobile,
                        'new_pdar_name' => 'N',
                        // 'pdar_occupation'=>$slp['is_applicant']==1?$chithaDetailsMod['service_code']:null,
                        'pdar_occupation' => $allot_row->pdar_occupation,
                        'mask_id' => $case_row->is_applicant_row->mask_id,
                        // 'identity_type' => $allot_row->identity_type,
                    );

                    if ($case_row->is_applicant_row->identity_type == 'AADHAAR') {
                        $chitha_pattadar_array['pdar_aadharno'] = $case_row->is_applicant_row->identity_ref_no;
                    }
                    if ($case_row->is_applicant_row->identity_type == 'PAN') {
                        $chitha_pattadar_array['pdar_pan_no'] = $case_row->is_applicant_row->identity_ref_no;
                    }
                    if ($case_row->is_applicant_row->identity_type == 'DL') {
                        $chitha_pattadar_array['pdar_nrcno'] = $case_row->is_applicant_row->identity_ref_no;
                    }
                    // $insert_pattadar = $this->db->insert('chitha_pattadar', $chitha_pattadar_array);
                    $chitha_pattadar_array['f1_case_no'] = $case_no;
                    $insert_pattadar = $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar_array);
                    if ($insert_pattadar != true) {
                        return array(
                            'responseType' => 0,
                            'msg' => '#ERR17925: Unable to update chitha! Something went wrong...',
                        );
                    }
                    $chitha_pattadar_insertion = true;
                }
                $pdar_id++;
            }
            $chitha_pattadar = false;
            //insert in chitha_rmk_gen
            foreach ($case_row->chitha_rmk_gen_result as $crgr) {
                $crgr->rmk_type_hist_no = $hist_no;
                $crgr->rmk_type_code = '01';
                $crgr->user_code = $user_code;
                $crgr->date_entry = date('Y-m-d H:i:s');
                $crgr->patta_no = $case_row->new_patta_no;

                $insert_rmk_gen = $this->db->insert('chitha_rmk_gen', $crgr);
                if ($insert_rmk_gen != true) {
                    return array(
                        'responseType' => 0,
                        'msg' => '#ERR1734: Unable to update chitha! Something went wrong...',
                    );
                }
                $chitha_rmk_gen_insertion = true;
            }
            //insert into chitha_rmk_ordbasic
            // $update_stat = 0;
            foreach ($case_row->chitha_rmk_ordbasic_result as $cror) {

                // if(!empty($total_number_of_installment_paid)){
                //     $update_stat = ++$total_number_of_installment_paid;
                // }

                $cror->rmk_type_hist_no = $hist_no;
                $cror->ord_cron_no = (int) $cror->ord_cron_no + 1;
                // $cror->ord_on_gl_type =
                $cror->date_entry = date('Y-m-d H:i:s');
                $cror->full_partial = $case_row->is_full_paid;
                $cror->partial_pay_status = 1;
                $cror->ord_date = date('Y-m-d H:i:s');

                $insert_rmk_ordbasic = $this->db->insert('chitha_rmk_ordbasic', $cror);
                if ($insert_rmk_ordbasic != true) {
                    return array(
                        'responseType' => 0,
                        'msg' => '#ERR1749: Unable to update chitha! Something went wrong...',
                    );
                }
                $chitha_rmk_ordbasic_insertion = true;
            }

            //update emi_history for chitha update flag
            if ($chitha_flag_update == false) {
                //get the max installment number
                $sqlMax = $this->db->query('select max(paid_no_of_installment) as max_no from settlement_emi_history where case_no = ?', array($case_no));

                $maxChitaUpdateStat = $sqlMax->row()->max_no;

                $update_emi = [
                    'chitha_update_status' => $maxChitaUpdateStat,
                ];
                $this->db->order_by('id', 'DESC');
                $this->db->limit(1);
                $this->db->where('case_no', $case_no);
                $query = $this->db->get('settlement_emi_history');

                if ($query->num_rows() > 0) {
                    // Get the ID of the record to be updated
                    $row = $query->row();
                    $id = $row->id;

                    // Perform the update on the selected record
                    $this->db->where('id', $id);
                    $this->db->update('settlement_emi_history', $update_emi);
                }
                if ($this->db->affected_rows() != 1) {
                    return array(
                        'responseType' => 0,
                        'msg' => '#ERR1874: Unable to update chitha! Something went wrong...',
                    );
                }
                $chitha_flag_update = true;
            }
        }

        if ($chitha_dag_pattadar_insertion != true || $chitha_pattadar_insertion != true || $chitha_rmk_gen_insertion != true || $chitha_rmk_ordbasic_insertion != true) {
            return array(
                'responseType' => 0,
                'msg' => '#ERR1866: Unable to update chitha! Something went wrong...',
            );
        }

        return array(
            'responseType' => 2,
            'msg' => 'success',
        );
    }
    ////////////////////CONVERSION////////////////////////////////
    private function validateApplicationData($data)
    {
        $errors = [];
        $errors = [];
        // Required top-level fields
        $requiredFields = [
            'service_code', 'case_no', 'date_of_registration', 'lm_code', 'lm_date', 'grn_no', 'premium_amt','payment_date'
        ];
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || $data[$field] === NULL || $data[$field] === '' || $data[$field] === 'NA') {
                $errors[] = "Missing or blank: $field";
            }
        }
        // dags
        if (!isset($data['dags']) || !is_array($data['dags'])) {
            $errors[] = "Missing or invalid 'dags' subarray.";
        } else {
            $requiredDagFields = [
                'dag_no', 'patta_no', 'patta_type_code', 'new_patta_type_code', 'applied_b', 'applied_k', 'applied_lc', 'revenue', 'local_tax'
            ];
            foreach ($requiredDagFields as $field) {
                if (!isset($data['dags'][$field]) || $data['dags'][$field] === NULL || $data['dags'][$field] === '') {
                    $errors[] = "Missing or blank 'dags' field: $field";
                }
            }
        }
        // applicants
        if (!isset($data['applicant']) || !is_array($data['applicant']) || count($data['applicant']) === 0) {
            $errors[] = "Missing or invalid 'applicant' array.";
        } else {
            foreach ($data['applicant'] as $index => $applicant) {
                $requiredApplicantFields = [
                    'name',
                    'gurdian_name',
                    'relation',
                    'pdar_id',
                    'dag_no'
                ];
                foreach ($requiredApplicantFields as $field) {
                    if (!isset($applicant[$field]) || $applicant[$field] === NULL || $applicant[$field] === '' || $applicant[$field] === 'NA') {
                        $errors[] = "Missing or blank applicant[$index] field: $field";
                    }
                }
            }
        }
        return $errors;
    }
    public function areaVerifyInChitha($location, $dag_no, $patta_type_code, $patta_no)
    {
        // var_dump($location);
        $sqlChithaArea = $this->db->query("Select dag_area_b,dag_area_k,dag_area_lc,dag_area_g,land_class_code from chitha_basic where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and  vill_townprt_code=? and dag_no=? and patta_type_code=? and patta_no=? ", [$location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'], $dag_no, $patta_type_code, $patta_no]);
        // echo $this->db->last_query();
        $data = $sqlChithaArea->num_rows();
        if ($data > 0) {
            return $sqlChithaArea->row();
        } else
            return 'NA';
    }
    function conversionUpdateChitha($case_no, $data)
    {
        $date = date('Y-m-d H:i:s');
        $ord_cron_no = 1;
        $user_code = $this->session->userdata('user_code');
        $errors = [];
        $errors = $this->validateApplicationData($data);
        if ($errors) {
            return json_encode([
                'responseType' => 1,
                'error' => $errors
            ]);
        }
        // var_dump($chithaDetailsMod);
        if (!in_array($data['service_code'], json_decode(CHITHA_UPDATE_ALLOWED))) {
            log_message('error', "UPDATE_Service_NOT_allowed");
            $this->db->trans_rollback();
            return json_encode([
                'responseType' => 1,
                'error' => 'CHITHA_UPDATE_NOT_ALLOWED'
            ]);
        }
        $rtps_app_no = $data['application_no'];
        $service_code = $data['service_code'];
        $date_of_registration = $data['date_of_registration'];
        $goa_approve_date = $data['goa_approve_date'];
        $goa_order_no = $data['goa_order_no'];
        $dc_order_no = $data['dc_order_no'];
        $dc_order_date = $data['dc_order_date'];
        $lm_code = $data['lm_code'];
        $lm_date = $data['lm_date'];
        $grn_no = $data['grn_no'];
        $premium_amt = $data['premium_amt'];
        $payment_date = date('Y-m-d', strtotime($data['payment_date']));


        $location = $data['location'];
        $dags = isset($data['dags'][0]) ? $data['dags'] : [$data['dags']];
        foreach ($dags as $dag) {

            $new_dag_no = null;
            $old_dag_no = $dag['dag_no'];
            $old_patta_no = $dag['patta_no'];
            $old_patta_type_code = $dag['patta_type_code'];
            $new_patta_type = $dag['new_patta_type_code'];

            $applied_b = isset($dag['applied_b']) ? $dag['applied_b'] : 0 ?? 0;
            $applied_k = isset($dag['applied_k']) ? $dag['applied_k'] : 0 ?? 0;
            $applied_lc = isset($dag['applied_lc']) ? $dag['applied_lc'] : 0 ?? 0;
            $applied_g = isset($dag['applied_g']) ? $dag['applied_g'] : 0 ?? 0;

            $reservation_b = isset($dag['reservation_b']) ? $dag['reservation_b'] : 0 ?? 0;
            $reservation_k = isset($dag['reservation_k']) ? $dag['reservation_k'] : 0 ?? 0;
            $reservation_lc = isset($dag['reservation_lc']) ? $dag['reservation_lc'] : 0 ?? 0;
            $reservation_g = isset($dag['reservation_g']) ? $dag['reservation_g'] : 0 ?? 0;

            $revenue = $dag['revenue'];
            $local_tax = $dag['local_tax'];
            ///////////////////////////////////
            $is_reservation = $reservation_b + $reservation_k + $reservation_lc + $reservation_g;
            $oldAreaChitha = $this->areaVerifyInChitha($location, $old_dag_no, $old_patta_type_code, $old_patta_no);
            if ($oldAreaChitha == 'NA') {
                return json_encode([
                    'responseType' => 1,
                    'error' => 'NO-RECORD-FOUND'
                ]);
            }
            //////////AREA VERIFY//////////////
            $old_bigha = $oldAreaChitha->dag_area_b;
            $old_katha = $oldAreaChitha->dag_area_k;
            $old_lessa = $oldAreaChitha->dag_area_lc;
            $old_gonda = $oldAreaChitha->dag_area_g;
            // echo $old_bigha ."##". $old_katha;
            //////////////////
            if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                $applied = $applied_b * 6400 + $applied_k * 320 + $applied_lc * 20 + $applied_g;
                $totalArea = $old_bigha * 6400 + $old_katha * 320 + $old_lessa * 20 + $old_gonda;
                // $totalArea = $reservation_b * 6400 + $reservation_k * 320 + $reservation_lc * 20 + $reservation_g;
                // log_message('error','APPLIED'.$applied."TOTALAREA".$totalArea);
                $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalArea - $applied);
            } else {
                $applied = $applied_b * 100 + $applied_k * 20 + $applied_lc;
                $totalArea = $old_bigha * 100 + $old_katha * 20 + $old_lessa;
                // $totalArea = $reservation_b * 100 + $reservation_k * 20 + $reservation_lc;
                $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa($totalArea - $applied);
                // log_message('error', 'APPLIED' . $applied . "TOTALAREA" . $totalArea . "SUB" . json_encode($areaSubstract));
            }
            ///////////IF BOTH AREA SAME OLD DAG=NEW DAG////////////////////
            // echo $applied ."##". $totalArea;
            // var_dump($areaSubstract);
            if ($applied != $totalArea) {
                $new_dag_no = $this->utilityclass->maxdag($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
            }
            // echo $new_dag_no;
            $new_patta_no = $this->utilityclass->maxpatta($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'], $new_patta_type);
            $ord_cron_no = 1;
            $common = $this->getCommonFields($location, $user_code);
            if ($new_dag_no)
            {
                /////////////////////////
                $chitha_baic = [
                    'old_dag_no' => $old_dag_no,
                    'old_patta_no' => $old_patta_no,
                    'dag_no_int' => $new_dag_no . '00',
                    'dag_no' => (string) $new_dag_no,
                    'patta_no' => (string) $new_patta_no,
                    'patta_type_code' => $new_patta_type,
                    'land_class_code' => $oldAreaChitha->land_class_code,
                    'dag_area_b' => $applied_b,
                    'dag_area_k' => $applied_k,
                    'dag_area_lc' => $applied_lc,
                    'dag_area_g' => $applied_g,
                    'dag_area_kr' => 0,
                    'dag_revenue' => $revenue,
                    'dag_local_tax' => $local_tax,
                    'user_code' => $user_code,
                    'operation' => 'I',
                    'date_entry' => $date,
                ];
                $mainchitha_basic = array_merge($location, $chitha_baic);
                $chithaBasic = $this->Chitha_basic_model->insert_table('chitha_basic', $mainchitha_basic);
                // log_message('error', "INSERT_CHITHA-AP###" . $this->db->last_query());
                if ($chithaBasic == 0) {
                    log_message('error', "INSERT_CHITHA-AP-001###" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'INSERT_CHITHA-AP-001'
                    ]);
                }
                ////////////SUBSTRACT OLD AREA///////////////
                $where = [
                    'dist_code' => $location['dist_code'],
                    'subdiv_code' => $location['subdiv_code'],
                    'cir_code' => $location['cir_code'],
                    'mouza_pargona_code' => $location['mouza_pargona_code'],
                    'lot_no' => $location['lot_no'],
                    'vill_townprt_code' => $location['vill_townprt_code'],
                    'dag_no' => $old_dag_no,
                ];
                $params = [
                    'dag_area_b' => $areaSubstract[0],
                    'dag_area_k' => $areaSubstract[1],
                    'dag_area_lc' => $areaSubstract[2],
                    'dag_area_g' =>  $areaSubstract[3],
                    'operation' => 'U'
                ];
                $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_basic', $params, $where);
                if ($chithaUpdate == 0) {
                    log_message('error', "UPDATE_CHITHA-AP-002#####" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'UPDATE_CHITHA-AP-002'
                    ]);
                }
                /////////////////////////////
                ///////For reservation/////////////////
                $road_side_reservation_bigha = $reservation_b;
                $road_side_reservation_katha = $reservation_k;
                $road_side_reservation_lessa = $reservation_lc;
                $road_side_reservation_ganda = $reservation_g;
                if ($is_reservation != 0) {
                    ///////////////////////
                    if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                        $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $road_side_reservation_bigha . " বিঘা " . $road_side_reservation_katha . " কঠা " . $road_side_reservation_lessa . " চাতক " . $road_side_reservation_ganda . " গোণ্ডা মিছন বাসুন্ধৰা-3.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case_no . " নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                    } else {
                        $rmk = "চক্ৰ বিষয়াৰ হুকুমমৰ্মে এই দাগৰ " . $road_side_reservation_bigha . " বিঘা " . $road_side_reservation_katha . " কঠা " . $road_side_reservation_lessa . " লেচা মিছন বাসুন্ধৰা-3.0 " . date('d/m/Y') . " তাৰিখৰ হুকুম " . $case_no . " নং ৰ অধীনত ৰোড চাইড/ৰিভাৰচাইডৰ বাবে সংৰক্ষিত কৰা হ’ল ৷";
                    }
                    $backlog_orders = array(
                        'dist_code' => $location['dist_code'],
                        'subdiv_code' => $location['subdiv_code'],
                        'cir_code' => $location['cir_code'],
                        'mouza_pargona_code' => $location['mouza_pargona_code'],
                        'lot_no' => $location['lot_no'],
                        'vill_townprt_code' => $location['vill_townprt_code'],
                        'patta_no' => $old_patta_no,
                        'patta_type_code' => $old_patta_type_code,
                        'dag_no' => $old_dag_no,
                        'dag_no_int' => $old_dag_no . '00',
                        'remark' => addslashes($rmk),
                        'category' => 2,
                        'date_entry' => date('Y-m-d'),
                        'user_code' => $user_code,
                    );
                    $backlog_orders = $this->Chitha_basic_model->insert_table('backlog_orders', $backlog_orders);
                    if ($backlog_orders == 0) {
                        log_message('error', "INSERT_backlog_orders" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error' => 'RESERVATION-AP-003'
                        ]);
                    }
                }
                ///////////End of reservation/////////////////
                $rmk_type_hist_no = $this->maxHistoryNoOrder($location, $old_dag_no);
                // $ord_cron_no=$ord_cron_no++;
                $remark_gen = array(
                    'rmk_type_code' => '01',
                    'rmk_type_hist_no' => $rmk_type_hist_no,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'jama_updated' => null,
                    'patta_no' => $old_patta_no,
                    'dag_no' => $old_dag_no
                );
                $chitha_remark_gen_data = (array_merge($location, $remark_gen));
                $chitha_rmk_gen = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
                // log_message('error', "INSERT_CHITHA_RMK_GEN-AP###" . $this->db->last_query());
                if ($chitha_rmk_gen == 0) {
                    log_message('error', "INSERT_CHITHA_RMK_GEN-AP-004###" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'INSERT_CHITHA_RMK_GEN-AP-004'
                    ]);
                }
                /////////////OLD DAG////////////////
                if (trim((string) $old_dag_no) != trim((string) $new_dag_no)) {
                    $chitha_remark_gen_data['dag_no'] = $new_dag_no;
                    $chitha_remark_gen_data['patta_no'] = $new_patta_no;
                    $chitha_rmk_gen = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
                    // log_message('error', "INSERT_NEW_CHITHA_RMK_GEN-AP##" . $this->db->last_query());
                    if ($chitha_rmk_gen == 0) {
                        log_message('error', "INSERT_NEW_CHITHA_RMK_GEN-AP-005##" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error' => 'INSERT_CHITHA_RMK_GEN-AP-005'
                        ]);
                    }
                }
                ////////////////////////////
                //var_dump($chitha_remark_gen);
                $order_basic = array(
                    'rmk_type_hist_no' => $rmk_type_hist_no,
                    'ord_no' => $case_no,
                    'ord_date' => date('Y-m-d'),
                    'ord_type_code' => $service_code,
                    'ord_cron_no' => $ord_cron_no,
                    'case_no' => $case_no,
                    'ord_passby_sign_yn' => 'Y',
                    'ord_passby_desig' => $user_code,
                    'lm_code' => $lm_code,
                    'lm_sign_yn' => 'Y',
                    'lm_sign_date' => $lm_date,
                    'co_code' => $user_code,
                    'co_sign_yn' => 'Y',
                    'co_ord_date' => date('Y-m-d'),
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'm_dag_area_b' => $applied_b,
                    'm_dag_area_k' => $applied_k,
                    'm_dag_area_lc' => $applied_lc,
                    'm_dag_area_g' => $applied_g,
                    'm_dag_area_kr' => 0,
                    'area_left_b' => '0',
                    'area_left_k' => '0',
                    'area_left_lc' => '0',
                    'area_left_g' => '0',
                    'old_dag_area_b' => $old_bigha,
                    'old_dag_area_k' => $old_katha,
                    'old_dag_area_lc' => $old_lessa,
                    'old_dag_area_g' => $old_gonda,
                    // 'rural_urban' => ,
                    // 'full_partial' => ,
                    'rtps_no' => $rtps_app_no,
                    'rtps_app_date' => $date_of_registration,
                    'dag_revenue' => $revenue,
                    'dag_local_tax' => $local_tax,
                    'ord_impli_flag' => 1,
                    'full_dag' =>  0,
                    'dag_no' => $old_dag_no
                );
                $chitha_rmk_ordbasic_data = (array_merge($location, $order_basic));
                $chitha_rmk_ordbasic = $this->Chitha_basic_model->insert_table('chitha_rmk_ordbasic', $chitha_rmk_ordbasic_data);
                // log_message('error', "INSERT_CHITHA_RMK_ORDBASIC-AP###" . $this->db->last_query());
                if ($chitha_rmk_ordbasic == 0) {
                    log_message('error', "INSERT_CHITHA_RMK_ORDBASIC-AP-006###" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'INSERT_CHITHA_RMK_ORDBASIC-AP-006'
                    ]);
                }
                ////////////OLD DAG///////////
                $chitha_rmk_ordbasic_data['dag_no'] = $new_dag_no;
                $chitha_rmk_ordbasic = $this->Chitha_basic_model->insert_table('chitha_rmk_ordbasic', $chitha_rmk_ordbasic_data);
                if ($chitha_rmk_ordbasic == 0) {
                    log_message('error', "INSERT_OLD_CHITHA_RMK_ORDBASIC-AP-007###" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'INSERT_CHITHA_RMK_ORDBASIC-AP-007'
                    ]);
                }
                ////////////APPLICANT START////////////////////
                $pdar_id = $this->maxPdarIdFetch($location, $new_dag_no, $new_patta_no, $new_patta_type); // initial max + 1
                // echo $pdar_id ;
                $index = 0;
                $i = 1;
                foreach ($data['applicant'] as $applicants) {
                    $next_pdar_id = $pdar_id + $index;
                    ///// insert chitha_rmk_convorder //////

                    $chitha_rmk_convorder = array_merge( $common,
                        [
                            'dag_no' => $old_dag_no,
                            'ord_cron_no' => $ord_cron_no,
                            'ord_no' => $case_no,
                            'patta_type_code' => $old_patta_type_code,
                            'patta_no' => $old_patta_no,
                            'ord_onbehalf_id' => $i++,
                            'ord_onbehalf_of' => $applicants['name'],
                            'premium' => $premium_amt,
                            'premi_chal_recpt_no' => $grn_no,
                            'land_area_b' => $applied_b,
                            'land_area_k' => $applied_k,
                            'land_area_lc' => $applied_lc,
                            'land_area_g' => $applied_g,
                            'land_area_kr' => 0,
                            'new_patta_type' => $new_patta_type,
                            'new_patta_no' => $new_patta_no,
                            'new_dag_no' => $new_dag_no,
                            'ord_onbehalf_guard' => $applicants['gurdian_name'],
                            'pdar_gender' => $applicants['gender'],
                            'pdar_mother' => $applicants['mother_name'] ?? '',
                            'pdar_guard_reln' => $applicants['relation'],
                            'rmk_type_hist_no' => $rmk_type_hist_no,
                            'dc_order_no'			=>	$dc_order_no ?? '',
                            'dc_order_date' => 	$dc_order_date ?? '',
                            'dpt_order_no' => $goa_order_no ?? '',
                            'dpt_order_date' => date('Y-m-d',strtotime($goa_approve_date)),
                            'payment_date' => $payment_date,
                        ]
                    );
                    $chitha_rmk_convorder_i = $this->Chitha_basic_model->insert_table('chitha_rmk_convorder', $chitha_rmk_convorder);
                    if ($chitha_rmk_convorder_i == 0) {
                        log_message('error', "INSERT_CHITHA_RMK_CONVORDER-AP-008###" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error' => 'INSERT_CHITHA_RMK_CONVORDER-AP-008'
                        ]);
                    }
                    //////////// insert chitha_dag_pattadar ///////////////
                    $dag_pattadar = array_merge($common,
                        [
                            'pdar_id' => $next_pdar_id,
                            'patta_no' => $new_patta_no,
                            'dag_no' => $new_dag_no,
                            'patta_type_code' => $new_patta_type,
                            'dag_por_b' => $applied_b ?? 0,
                            'dag_por_k' => $applied_k ?? 0,
                            'dag_por_lc' => $applied_lc ?? 0,
                            'dag_por_g' => $applied_g ?? 0,
                            'dag_por_kr' => 0,
                            'p_flag' => 0,
                        ]
                    );
                    $dag_pattadar_i = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar', $dag_pattadar);
                    if ($dag_pattadar_i == 0) {
                        log_message('error', "INSERT_CHITHA_DAG-PATTADAR-AP###-009" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error' => 'NSERT_CHITHA_DAG-PATTADAR-AP###-009'
                        ]);
                    }
                    ////////// insert chitha_pattadar ////////////////////////
                    $chitha_pattadar = array_merge(
                        $common,
                        [
                            'pdar_name' => $applicants['name'],
                            'pdar_father' => $applicants['gurdian_name'],
                            'patta_no' => $new_patta_no,
                            'patta_type_code' => $new_patta_type,
                            'pdar_add1' => $applicants['add1'] ?? '',
                            'pdar_add2' => $applicants['add2'] ?? '',
                            'user_code' => $user_code,
                            'o2_case_no' => $case_no,
                            'pdar_id' => $next_pdar_id,
                            'new_pdar_name' => 'N',
                            'jama_yn' => 'n',
                            'pdar_gender' => $applicants['gender'],
                            'pdar_mother' => $applicants['mother_name'] ?? '',
                            'pdar_guard_reln' => $applicants['relation'],
                        ]
                    );
                    $chithapattadar_i = $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);
                    // log_message('error', "INSERT_CHITHA-PATTADAR-AP###" . $this->db->last_query());
                    if ($chithapattadar_i == 0) {
                        log_message('error', "INSERT_CHITHA-PATTADAR-AP###-010" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error' => 'INSERT_CHITHA-PATTADAR-AP###-010'
                        ]);
                    }
                    $index++;
                    $ord_cron_no++; // move to next pdar_id
                    /////////////////////Remove old pattadar////////////////////
                    $params = [
                        'p_flag'    => '1',
                        'operation' => 'U',
                        'user_code' => $user_code,
                        'updated_on' => date('Y-m-d H:i:s')
                    ];
                    $where = [
                        'dist_code' => $location['dist_code'],
                        'subdiv_code' => $location['subdiv_code'],
                        'cir_code' => $location['cir_code'],
                        'mouza_pargona_code' => $location['mouza_pargona_code'],
                        'lot_no' => $location['lot_no'],
                        'vill_townprt_code' => $location['vill_townprt_code'],
                        'dag_no'             => $old_dag_no,
                        'pdar_id'            => $applicants['pdar_id'],
                        'patta_type_code'    => $old_patta_type_code,
                        'patta_no'           => trim($old_patta_no),
                    ];
                    $result = $this->Chitha_basic_model->update_table('chitha_dag_pattadar', $params, $where);
                    if ($result == 0) {
                        log_message('error', "UPDATE_CHITHA-DAG-PATTADAR-AP###-011" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error' => 'UPDATE_CHITHA-DAG-PATTADAR-AP###-011'
                        ]);
                    }
                    //////////////////////////////////////////////////////////

                }
                //////////////////////////////////////////
            }
            else
            {
                ///////////////////FOR FULL DAG CONVERSION/////////////////////////
                // echo $old_dag_no;
                $where = [
                    'dist_code' => $location['dist_code'],
                    'subdiv_code' => $location['subdiv_code'],
                    'cir_code' => $location['cir_code'],
                    'mouza_pargona_code' => $location['mouza_pargona_code'],
                    'lot_no' => $location['lot_no'],
                    'vill_townprt_code' => $location['vill_townprt_code'],
                    'dag_no' => $old_dag_no,
                ];
                $params = [
                    'patta_type_code' => $new_patta_type,
                    'patta_no' => (string) $new_patta_no,
                    'old_patta_no' => $old_patta_no,
                    'dag_revenue' => $revenue,
                    'dag_local_tax' =>  $local_tax,
                    'updated_on' =>  date('Y-m-d H:i:s'),
                    'operation' =>  'U',
                    'user_code' =>  $user_code,
                    'jama_yn' =>  'n',
                ];
                $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_basic', $params, $where);
                if ($chithaUpdate == 0) {
                    log_message('error', "UPDATE_CHITHABASIC-AP#####-012" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'UPDATE_CHITHABASIC-AP#####-012'
                    ]);
                }
                /////////////////////
                $rmk_type_hist_no = $this->maxHistoryNoOrder($location, $old_dag_no);
                // $ord_cron_no=$ord_cron_no++;
                $remark_gen = array(
                    'rmk_type_code' => '01',
                    'rmk_type_hist_no' => $rmk_type_hist_no,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'jama_updated' => null,
                    'patta_no' => $old_patta_no,
                    'dag_no' => $old_dag_no
                );
                $chitha_remark_gen_data = (array_merge($location, $remark_gen));
                $chitha_rmk_gen = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
                // log_message('error', "INSERT_CHITHA_RMK_GEN-AP###" . $this->db->last_query());
                if ($chitha_rmk_gen == 0) {
                    log_message('error', "INSERT_CHITHA_RMK_GEN-AP###-013" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'INSERT_CHITHA_RMK_GEN-AP###-013'
                    ]);
                }
                $order_basic = array(
                    'rmk_type_hist_no' => $rmk_type_hist_no,
                    'ord_no' => $case_no,
                    'ord_date' => date('Y-m-d'),
                    'ord_type_code' => $service_code,
                    'ord_cron_no' => $ord_cron_no++,
                    'case_no' => $case_no,
                    'ord_passby_sign_yn' => 'Y',
                    'ord_passby_desig' => $user_code,
                    'lm_code' => $lm_code,
                    'lm_sign_yn' => 'Y',
                    'lm_sign_date' => $lm_date,
                    'co_code' => $user_code,
                    'co_sign_yn' => 'Y',
                    'co_ord_date' => date('Y-m-d'),
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'E',
                    'm_dag_area_b' => $applied_b,
                    'm_dag_area_k' => $applied_k,
                    'm_dag_area_lc' => $applied_lc,
                    'm_dag_area_g' => $applied_g,
                    'm_dag_area_kr' => 0,
                    'area_left_b' => '0',
                    'area_left_k' => '0',
                    'area_left_lc' => '0',
                    'area_left_g' => '0',
                    'old_dag_area_b' => $old_bigha,
                    'old_dag_area_k' => $old_katha,
                    'old_dag_area_lc' => $old_lessa,
                    'old_dag_area_g' => $old_gonda,
                    // 'rural_urban' => ,
                    // 'full_partial' => ,
                    'rtps_no' => $rtps_app_no,
                    'rtps_app_date' => $date_of_registration,
                    'dag_revenue' => $revenue,
                    'dag_local_tax' => $local_tax,
                    'ord_impli_flag' => 1,
                    'full_dag' =>  1,
                    'dag_no' => $old_dag_no
                );
                $chitha_rmk_ordbasic_data = (array_merge($location, $order_basic));
                $chitha_rmk_ordbasic = $this->Chitha_basic_model->insert_table('chitha_rmk_ordbasic', $chitha_rmk_ordbasic_data);
                // log_message('error', "INSERT_CHITHA_RMK_ORDBASIC-AP###" . $this->db->last_query());
                if ($chitha_rmk_ordbasic == 0) {
                    log_message('error', "INSERT_CHITHA_RMK_ORDBASIC-AP###-014" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'INSERT_CHITHA_RMK_ORDBASIC-AP###-014'
                    ]);
                }
                /////////////////////
                $otherexistaceInPatta = $this->checkOtherExistanceDag($location, $old_dag_no, $old_patta_no, $old_patta_type_code);
                $pdar_id = $this->maxPdarIdFetch($location, $new_dag_no, $new_patta_no, $new_patta_type);

                ///////else Update Only PDAR-ID//////////
                $index = 0;
                $i = 1;
                foreach ($data['applicant'] as $applicants) {
                    $next_pdar_id = $pdar_id + $index;
                    ///// insert chitha_rmk_convorder //////
                    $chitha_rmk_convorder = array_merge(
                        $common,
                        [
                            'dag_no' => $old_dag_no,
                            'ord_cron_no' => $ord_cron_no,
                            'ord_no' => $case_no,
                            'patta_type_code' => $old_patta_type_code,
                            'patta_no' => $old_patta_no,
                            'ord_onbehalf_id' => $i++,
                            'ord_onbehalf_of' => $applicants['name'],
                            'premium' => $premium_amt,
                            'premi_chal_recpt_no' => $grn_no,
                            'land_area_b' => $applied_b,
                            'land_area_k' => $applied_k,
                            'land_area_lc' => $applied_lc,
                            'land_area_g' => $applied_g,
                            'land_area_kr' => 0,
                            'new_patta_type' => $new_patta_type,
                            'new_patta_no' => $new_patta_no,
                            'new_dag_no' => $new_dag_no,
                            'ord_onbehalf_guard' => $applicants['gurdian_name'],
                            'pdar_gender' => $applicants['gender'],
                            'pdar_mother' => $applicants['mother_name'] ?? '',
                            'pdar_guard_reln' => $applicants['relation'],
                            'rmk_type_hist_no' => $rmk_type_hist_no,
                            'dc_order_no'			=>	$dc_order_no ?? '',
                            'dc_order_date' => 	$dc_order_date ?? '',
                            'dpt_order_no' => $goa_order_no ?? '',
                            'dpt_order_date' => date('Y-m-d',strtotime($goa_approve_date)),
                            'payment_date' => $payment_date,
                        ]
                    );
                    $chitha_rmk_convorder_i = $this->Chitha_basic_model->insert_table('chitha_rmk_convorder', $chitha_rmk_convorder);
                    if ($chitha_rmk_convorder_i == 0) {
                        log_message('error', "INSERT_CHITHA_RMK_CONVORDER-AP###-015" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error' => 'INSERT_CHITHA_RMK_CONVORDER-AP###-015'
                        ]);
                    }
                    if ($otherexistaceInPatta > 0) {
                        $chitha_pattadar = array_merge(
                            $common,
                            [
                                'pdar_name' => $applicants['name'],
                                'pdar_father' => $applicants['gurdian_name'],
                                'patta_no' => $new_patta_no,
                                'patta_type_code' => $new_patta_type,
                                'pdar_add1' => $applicants['add1'] ?? '',
                                'pdar_add2' => $applicants['add2'] ?? '',
                                'user_code' => $user_code,
                                'o2_case_no' => $case_no,
                                'pdar_id' => $next_pdar_id,
                                'new_pdar_name' => 'N',
                                'jama_yn' => 'n',
                                'pdar_gender' => $applicants['gender'],
                                'pdar_mother' => $applicants['mother_name'] ?? '',
                                'pdar_guard_reln' => $applicants['relation'],
                            ]
                        );
                        $chithapattadar_i = $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);
                        // log_message('error', "INSERT_CHITHA-PATTADAR-AP###" . $this->db->last_query());
                        if ($chithapattadar_i == 0) {
                            log_message('error', "INSERT_CHITHA-PATTADAR-AP#OLD###-016" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return json_encode([
                                'responseType' => 1,
                                'error' => 'INSERT_CHITHA-PATTADAR-AP#OLD###-016'
                            ]);
                        }
                    } else {
                        ///////////UPDATE CP/////////////
                        $where = [
                            'dist_code' => $location['dist_code'],
                            'subdiv_code' => $location['subdiv_code'],
                            'cir_code' => $location['cir_code'],
                            'mouza_pargona_code' => $location['mouza_pargona_code'],
                            'lot_no' => $location['lot_no'],
                            'vill_townprt_code' => $location['vill_townprt_code'],
                            'patta_no' => $old_patta_no,
                            'patta_type_code' => $old_patta_type_code,
                            'pdar_id' => $applicants['pdar_id'],
                        ];
                        $params = [
                            'patta_type_code' => $new_patta_type,
                            'patta_no' => (string) $new_patta_no,
                            'o2_case_no' => $case_no,
                            'updated_on' =>  date('Y-m-d H:i:s'),
                            'operation' =>  'U',
                            'user_code' =>  $user_code,
                            'jama_yn' =>  'n',
                            'pdar_id' => $next_pdar_id
                        ];
                        $chitha_pattadar = $this->Chitha_basic_model->update_table('chitha_pattadar', $params, $where);
                        if ($chitha_pattadar == 0) {
                            log_message('error', "UPDATE_CHITHA-OLD-AP#####-017" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return json_encode([
                                'responseType' => 1,
                                'error' => 'UPDATE_CHITHA-OLD-AP#####-017'
                            ]);
                        }
                    }
                    //////////////UPDATE CDP////////////////////
                    $where = [
                        'dist_code' => $location['dist_code'],
                        'subdiv_code' => $location['subdiv_code'],
                        'cir_code' => $location['cir_code'],
                        'mouza_pargona_code' => $location['mouza_pargona_code'],
                        'lot_no' => $location['lot_no'],
                        'vill_townprt_code' => $location['vill_townprt_code'],
                        'dag_no' => $old_dag_no,
                        'patta_no' => $old_patta_no,
                        'patta_type_code' => $old_patta_type_code,
                        'pdar_id' => $applicants['pdar_id'],
                    ];
                    $params = [
                        'patta_type_code' => $new_patta_type,
                        'patta_no' => (string) $new_patta_no,
                        'updated_on' =>  date('Y-m-d H:i:s'),
                        'operation' =>  'U',
                        'user_code' =>  $user_code,
                        'jama_yn' =>  'n',
                        'pdar_id' => $next_pdar_id
                    ];
                    $chitha_dag_pattadar = $this->Chitha_basic_model->update_table('chitha_dag_pattadar', $params, $where);
                    if ($chitha_dag_pattadar == 0) {
                        log_message('error', "UPDATE_CHITHA-DAG-OLD-AP#####-018" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error' => 'UPDATE_CHITHA-DAG-OLD-AP#####-018'
                        ]);
                    }
                    $index++; // move to next pdar_id
                }
            }
        }
        $basicUpdate = [
            'co_chitha_corrected_yn' => 'Y',
            'co_chitha_corrected_date' => date('Y-m-d H:i:s'),
            'order_passed' => 'Y',
            'date_of_order' => date('Y-m-d H:i:s'),
        ];
        $where_array = [
            'case_no' => $case_no,
        ];
        $petition_basic = $this->Chitha_basic_model->update_table('petition_basic', $basicUpdate, $where_array);
        if ($petition_basic == 0) {
            log_message('error', "UPDATE_petition_basic#7777-1##" . $this->db->last_query());
            $this->db->trans_rollback();
            return json_encode([
                'responseType' => 1,
                'error' => 'Final Updation Failed #7777-1'
            ]);
        }
        /////////////API Hit For Status change///////////
        $this->load->model('basundhara/basundharamodel');
        $basundhara=$this->basundharamodel->checkExistBasundhar($case_no);
        if($basundhara){
            $rmk='Final Order Passed';
            $status='F';
            $task='CO';
            $pen='NA';
            $case=$case_no;
            $updateApiReturn= $this->basundharamodel->postApiBasundharaSec($case,$rmk,$status,$task,$pen);
            if($updateApiReturn=='n'){
                $this->db->trans_rollback();
                return json_encode([
                    'responseType' => 1,
                    'error' => 'API-FAILED-CHANGE-STATUS #888-1'
                ]);
            }
        }
        return json_encode([
            'responseType' => 2,
            'success' => 'Chitha Updated successfully'
        ]);
        /////////////////////////
    }

    function maxPdarIdFetch($location, $dag_no, $patta_no, $patta_type)
    {
        $dist_code           = $location['dist_code'];
        $subdiv_code         = $location['subdiv_code'];
        $cir_code            = $location['cir_code'];
        $mouza_pargona_code  = $location['mouza_pargona_code'];
        $lot_no              = $location['lot_no'];
        $vill_townprt_code   = $location['vill_townprt_code'];
        $where = [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type, trim($patta_no)];
        $cp = $this->db->query("
												SELECT MAX(pdar_id::int) + 1 AS val 
												FROM chitha_pattadar 
												WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
												AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
												AND patta_type_code=? AND TRIM(patta_no)=?
								", $where)->row()->val;

        $jp = $this->db->query("
												SELECT MAX(pdar_id::int) + 1 AS val 
												FROM jama_pattadar 
												WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
												AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
												AND patta_type_code=? AND TRIM(patta_no)=?
								", $where)->row()->val;

        $dp = $this->db->query("
												SELECT MAX(pdar_id::int) + 1 AS val 
												FROM chitha_dag_pattadar 
												WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
												AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
												AND patta_type_code=? AND TRIM(patta_no)=? AND dag_no=?
								", array_merge($where, [(string)$dag_no]))->row()->val;
        // echo $this->db->last_query();

        $pdar_id = max($cp ?: 0, $jp ?: 0, $dp ?: 0);  // null-safe comparison
        return $pdar_id ?: 1;
    }
    function checkOtherExistanceDag($location, $dag_no, $patta_no, $patta_type)
    {
        $dist_code           = $location['dist_code'];
        $subdiv_code         = $location['subdiv_code'];
        $cir_code            = $location['cir_code'];
        $mouza_pargona_code  = $location['mouza_pargona_code'];
        $lot_no              = $location['lot_no'];
        $vill_townprt_code   = $location['vill_townprt_code'];
        $where = [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $vill_townprt_code, $patta_type, trim($patta_no), trim($dag_no)];
        $dp = $this->db->query("
												SELECT * 
												FROM chitha_dag_pattadar 
												WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
												AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
												AND patta_type_code=? AND TRIM(patta_no)=? AND dag_no!=?
								", $where)->num_rows();
        // log_message('error',"CHECK-EXISTANCE-PATTADAR-OLD####".$this->db->last_query());
        return $dp;
    }
    private function getCommonFields($location, $user_code)
    {
        return [
            'dist_code'											=> $location['dist_code'],
            'subdiv_code'									=> $location['subdiv_code'],
            'cir_code'												=> $location['cir_code'],
            'mouza_pargona_code'		=> $location['mouza_pargona_code'],
            'lot_no'														=> $location['lot_no'],
            'vill_townprt_code'			=> $location['vill_townprt_code'],
            'user_code'											=> $user_code,
            'date_entry'									 => date('Y-m-d H:i:s'),
            'operation'											=> 'I',
        ];
    }
    ///////////////RECLASS///////////////////////////
    private function validateReclsApplicationData($data)
    {
        $errors = [];

        // Top-level required fields
        $requiredFields = [
            'case_no', 'service_code', 'approve_by', 'dc_order_no',
            'dc_order_date', 'rtps_ref_no', 'grn_no', 'payment_date',
            'lm_code', 'lm_date', 'amount', 'date_of_application',
            'location', 'dags', 'all_pattadar'
        ];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || (is_string($data[$field]) && trim($data[$field]) === '') || (is_array($data[$field]) && empty($data[$field]))) {
                $errors[] = "Missing or empty field: {$field}";
            }
        }
        $validApprovers = ['DC', 'DLR', 'DPT'];
        if (isset($data['approve_by']) && !in_array($data['approve_by'], $validApprovers)) {
            $errors[] = "Invalid approve_by value. Allowed values: DC, DLR, DPT";
        }
        if (isset($data['approve_by']) && $data['approve_by'] == 'DPT') {
            if (empty($data['dept_order_no'])) {
                $errors[] = "dept_order_no is mandatory when approve_by is DPT";
            }
            if (empty($data['dept_order_date'])) {
                $errors[] = "dept_order_date is mandatory when approve_by is DPT";
            }
        }
        // Validate location
        if (isset($data['location']) && is_array($data['location'])) {
            $locFields = ['dist_code', 'subdiv_code', 'cir_code', 'mouza_pargona_code', 'lot_no', 'vill_townprt_code'];
            foreach ($locFields as $field) {
                if (!isset($data['location'][$field]) || $data['location'][$field] === '') {
                    $errors[] = "Missing or empty location field: {$field}";
                }
            }
        }

        // Validate dags
        if (isset($data['dags']) && is_array($data['dags'])) {
            foreach ($data['dags'] as $i => $dag) {
                $dagFields = [
                    'dag_no', 'patta_no', 'patta_type_code', 'full_part_dag', 'old_land_class',
                    'new_land_class', 'applied_b', 'applied_k', 'applied_lc', 'applied_g', 'revenue', 'local_tax'
                ];
                foreach ($dagFields as $field) {
                    if (!isset($dag[$field]) || $dag[$field] === '') {
                        $errors[] = "Missing or empty field in dags[{$i}]: {$field}";
                    }
                }
            }
        }

        // Validate all_pattadar
        if (isset($data['all_pattadar']) && is_array($data['all_pattadar'])) {
            foreach ($data['all_pattadar'] as $dag_no => $pattadarList) {
                if (!is_array($pattadarList)) {
                    $errors[] = "Invalid pattadar list for dag_no: {$dag_no}";
                    continue;
                }
                foreach ($pattadarList as $j => $pat) {
                    $patFields = ['pdar_id', 'dag_no', 'patta_no', 'pdar_name', 'pdar_guardian', 'pdar_relation'];
                    foreach ($patFields as $field) {
                        if (!isset($pat[$field]) || $pat[$field] === '') {
                            $errors[] = "Missing or empty field in all_pattadar[{$dag_no}][{$j}]: {$field}";
                        }
                    }
                }
            }
        }
        return empty($errors) ? true : $errors;
    }
    private function landclassNew($id){
        $sql=$this->db->query("select land_class_code from land_class_groups where id=?",[$id]);
        if($sql->num_rows()>0){
            return $sql->row()->land_class_code;
        }else{
            return false;
        }
    }
    function reclassFinalOrder($case_no, $data)
    {
        $response = $this->validateReclsApplicationData($data);
        if ($response !== true) {
            log_message('error', "VALIDATION-ERROR-RECLS##".json_encode($response));
            return ['responseType' => 1, 'error' => 'VALIDATION-ERROR#00011'];
        }
        if (!in_array($data['service_code'], json_decode(CHITHA_UPDATE_ALLOWED))) {
            log_message('error', "UPDATE_Service_NOT_allowed");
            $this->db->trans_rollback();
            return json_encode([
                'responseType' => 1,
                'error' => 'CHITHA_UPDATE_NOT_ALLOWED-RECLS#####-0001'
            ]);
        }
        $part_dags_array  = [];
        $case_no          =  $data['case_no'];
        $rtps_app_no      =  $data['rtps_ref_no'];
        $service_code     =  $data['service_code'];
        $lm_code          =  $data['lm_code'];
        $lm_date          =  $data['lm_date'];
        $approve_by       =  $data['approve_by'];
        $dc_order_no      =  $data['dc_order_no'];
        $dc_order_date    =  $data['dc_order_date'];
        $dept_order_no    =  $data['dept_order_no'] ?? null;
        $dept_order_date  =  $data['dept_order_date'] ?? null;
        $rtps_ref_no      =  $data['rtps_ref_no'];
        $date_of_application      =  date('Y-m-d',strtotime($data['date_of_application']));
        $grn_no           =  $data['grn_no'] ?? null;
        $payment_date     =  date('Y-m-d',strtotime($data['payment_date'])) ?? date('Y-m-d');
        $amount           =  $data['amount'];
        $location         =  $data['location'];
        $user_code          =  $this->session->userdata('user_code');
        $date             =  date('Y-m-d H:i:s');
        ///////////////////////////////
        // N means only full dag reclass.
        // P partition as well reclass
        // F full partition with reclass
        /////////ChithaUpdate////////////
        $basicUpdate = [
            'co_chitha_corrected_yn' => 'Y',
            'co_chitha_corrected_date' => date('Y-m-d H:i:s'),
            'order_passed' => 'Y',
            'date_of_order' => date('Y-m-d H:i:s'),
            'date_update' => date('Y-m-d H:i:s'),
        ];
        $where_array = [
            'case_no' => $case_no,
        ];
        if($service_code!=51){
            $reclass_suite_basic = $this->Chitha_basic_model->update_table('reclass_suite_basic', $basicUpdate, $where_array);
            if ($reclass_suite_basic == 0) {
                log_message('error', "UPDATE_reclass_suite_basic" . $this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        $patta_generated=true;
        foreach ($data['dags'] as $dag) {
            // var_dump($dag);
            $applied_b       = $dag['applied_b'];
            $applied_k       = $dag['applied_k'];
            $applied_lc      = $dag['applied_lc'];
            $applied_g       = $dag['applied_g'];
            $revenue         = $dag['revenue'];
            $local_tax       = $dag['local_tax'];
            $dag_no          = $dag['dag_no'];
            $patta_type_code = $dag['patta_type_code'];
            $patta_no        = $dag['patta_no'];
            $old_land_class  = $dag['old_land_class'];
            $new_land_class  = $dag['new_land_class'];

            ////////////////////
            $oldAreaChitha = $this->areaVerifyInChitha($location, $dag_no, $patta_type_code, $patta_no);
            if ($oldAreaChitha == 'NA') {
                return json_encode([
                    'responseType' => 1,
                    'error' => 'NO-RECORD-FOUND'
                ]);
            }
            //////////AREA VERIFY//////////////
            $old_bigha = $oldAreaChitha->dag_area_b;
            $old_katha = $oldAreaChitha->dag_area_k;
            $old_lessa = $oldAreaChitha->dag_area_lc;
            $old_gonda = $oldAreaChitha->dag_area_g;
            if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                $applied = $applied_b * 6400 + $applied_k * 320 + $applied_lc * 20 + $applied_g;
                $totalArea = $old_bigha * 6400 + $old_katha * 320 + $old_lessa * 20 + $old_gonda;
                // $totalArea = $reservation_b * 6400 + $reservation_k * 320 + $reservation_lc * 20 + $reservation_g;
                // log_message('error','APPLIED'.$applied."TOTALAREA".$totalArea);
                $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalArea - $applied);
            } else {
                $applied = $applied_b * 100 + $applied_k * 20 + $applied_lc;
                $totalArea = $old_bigha * 100 + $old_katha * 20 + $old_lessa;
                // $totalArea = $reservation_b * 100 + $reservation_k * 20 + $reservation_lc;
                $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa($totalArea - $applied);
                // log_message('error', 'APPLIED' . $applied . "TOTALAREA" . $totalArea . "SUB" . json_encode($areaSubstract));
            }
            // print_r($areaSubstract);
            ////////////////////
            $landclass_new_code=$this->landclassNew($new_land_class);
            if($landclass_new_code==false){
                return json_encode([
                    'responseType' => 1,
                    'error' => 'NEW-LANDCLASS-RECORD-NOT'
                ]);
            }
            ////////////////////
            $rmk_type_hist_no = $this->maxHistoryNoOrder($location, $dag_no);
            $ord_cron_no =1;
            //////////////////
            if($dag['full_part_dag']=='N'){
                // echo "ONLY RECLASS";
                if((float)$applied != (float)$totalArea){
                    log_message('error',"RECLS-###0003 OLDAREA:{$totalArea} NEWAREA:{$applied} ##application_no:{$case_no}");
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'RECLS-FULL-DAG-RECLASS-AREA-MISMATCHED#####-0003#'.$dag_no
                    ]);
                }
                /////////LOGIC//////////////
                $where = [
                    'dist_code' => $location['dist_code'],
                    'subdiv_code' => $location['subdiv_code'],
                    'cir_code' => $location['cir_code'],
                    'mouza_pargona_code' => $location['mouza_pargona_code'],
                    'lot_no' => $location['lot_no'],
                    'vill_townprt_code' => $location['vill_townprt_code'],
                    'dag_no' => $dag_no,
                ];
                $params = [
                    'land_class_code'       =>  $landclass_new_code,
                    'dag_revenue'           =>  $revenue,
                    'dag_local_tax'         =>  $local_tax,
                    'updated_on'            =>  date('Y-m-d H:i:s'),
                    'operation'             =>  'U',
                    'user_code'             =>  $user_code,
                    'jama_yn'               =>  'n',
                ];
                $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_basic', $params, $where);
                if ($chithaUpdate == 0) {
                    log_message('error', "UPDATE_CHITHABASIC-RCLS#####-0004" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'UPDATE_CHITHABASIC-AP#####-012'
                    ]);
                }

                // $ord_cron_no=$ord_cron_no++;
                $remark_gen = array(
                    'rmk_type_code' => '01',
                    'rmk_type_hist_no' => $rmk_type_hist_no,
                    'user_code' => $user_code,
                    'date_entry' => $date,
                    'operation' => 'E',
                    'jama_updated' => null,
                    'patta_no' => $patta_no,
                    'dag_no' => $dag_no
                );
                $chitha_remark_gen_data = (array_merge($location, $remark_gen));
                $chitha_rmk_gen = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
                // log_message('error', "INSERT_CHITHA_RMK_GEN-AP###" . $this->db->last_query());
                if ($chitha_rmk_gen == 0) {
                    log_message('error', "INSERT_CHITHA_RMK_GEN-RECLS###-00013" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'INSERT_CHITHA_RMK_GEN-AP###-013'
                    ]);
                }
                $order_basic = array(
                    'rmk_type_hist_no' => $rmk_type_hist_no,
                    'ord_no' => $case_no,
                    'ord_date' => date('Y-m-d'),
                    'ord_type_code' => $service_code,
                    'ord_cron_no' => $ord_cron_no++,
                    'case_no' => $case_no,
                    'ord_passby_sign_yn' => 'Y',
                    'ord_passby_desig' => $user_code,
                    'lm_code' => $lm_code,
                    'lm_sign_yn' => 'Y',
                    'lm_sign_date' => $lm_date,
                    'co_code' => $user_code,
                    'co_sign_yn' => 'Y',
                    'co_ord_date' => $date,
                    'user_code' => $user_code,
                    'date_entry' => $date,
                    'operation' => 'E',
                    'm_dag_area_b' => $applied_b,
                    'm_dag_area_k' => $applied_k,
                    'm_dag_area_lc' => $applied_lc,
                    'm_dag_area_g' => $applied_g,
                    'm_dag_area_kr' => 0,
                    'area_left_b' => '0',
                    'area_left_k' => '0',
                    'area_left_lc' => '0',
                    'area_left_g' => '0',
                    'old_dag_area_b' => $old_bigha,
                    'old_dag_area_k' => $old_katha,
                    'old_dag_area_lc' => $old_lessa,
                    'old_dag_area_g' => $old_gonda,
                    'rural_urban' => $approve_by,
                    'rtps_no' => $rtps_app_no,
                    'rtps_app_date' => date('Y-m-d',strtotime($date_of_application)),
                    'dag_revenue' => $revenue,
                    'dag_local_tax' => $local_tax,
                    'ord_impli_flag' => 1,
                    'dag_no' => $dag_no,
                    'full_partial' => $dag['full_part_dag'],
                );
                $chitha_rmk_ordbasic_data = (array_merge($location, $order_basic));
                $chitha_rmk_ordbasic = $this->Chitha_basic_model->insert_table('chitha_rmk_ordbasic', $chitha_rmk_ordbasic_data);
                // log_message('error', "INSERT_CHITHA_RMK_ORDBASIC-AP###" . $this->db->last_query());
                if ($chitha_rmk_ordbasic == 0) {
                    log_message('error', "INSERT_CHITHA_RMK_ORDBASIC-RECLS###-00014" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'INSERT_CHITHA_RMK_ORDBASIC-RECLS###-00014'
                    ]);
                }
                ///////////////////////////////
                foreach ($data['all_pattadar'] as $key => $dag_pattadars) {
                    $common = $this->getCommonFields($location, $user_code);
                    if ((string)$dag_no == (string)$key) {
                        $proposal_no = 1;
                        foreach ($dag_pattadars as $pat) {
                            $pattadarInsert = array_merge($common,
                                [
                                    'rmk_type_hist_no'     => $rmk_type_hist_no,
                                    'proposal_no'          => $proposal_no++,
                                    'dag_no'               => $dag_no,
                                    'patta_no'             => $patta_no,
                                    'patta_type_code'      => $patta_type_code,
                                    'present_land_class'   => $old_land_class,
                                    'proposed_land_class'  => $landclass_new_code,
                                    'proposed_land_revenue'  => $revenue,
                                    'proposed_land_localtax'  => $local_tax,
                                    'lm_date'															=> $lm_date,
                                    'lm_code'															=> $lm_code,
                                    'co_code'															=> $user_code,
                                    'co_date'															=> $date,
                                    'dc_code'															=> $dc_code ?? null,
                                    'dc_order_no'											=> $dc_order_no ?? null,
                                    'dc_date'															=> $dc_order_date ?? null,
                                    'dpt_order_no'										=> $dept_order_no ?? null,
                                    'dpt_order_date'								=> $dept_order_date ?? null,
                                    'ord_no'															 => $case_no,
                                    'pdar_id'              => $pat['pdar_id'],
                                    'pdar_name'            => $pat['pdar_name'],
                                    'pdar_guardian'								=> $pat['pdar_guardian'],
                                    'pdar_relation'								=> $pat['pdar_relation'],
                                    'grn_no'															=> $grn_no,
                                    'payment_date'									=> $payment_date,
                                    'paid_amount'          => $amount,
                                ] );
                            $chitha_reclassification_suite = $this->Chitha_basic_model->insert_table('chitha_reclassification_suite', $pattadarInsert);
                            if ($chitha_reclassification_suite == 0) {
                                log_message('error', "INSERT_PATTADAR-RECLS###-000144" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return json_encode([
                                    'responseType' => 1,
                                    'error' => 'INSERT_PATTADAR-RECLS###-000144'
                                ]);
                            }
                        }
                    }
                }

            }else if(in_array($dag['full_part_dag'],['F','P'])){

                if($patta_generated===true){
                    $new_patta_no = $this->utilityclass->maxpatta($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'], $patta_type_code);
                    $patta_generated=false;
                }

                if($applied > $totalArea){
                    log_message('error',"RECLS-###0003 OLDAREA:{$totalArea} NEWAREA:{$applied} ##application_no:{$case_no}");
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'RECLS-APPLIED-AREA-TOTAL-AREA-MISMATCHED-FOR-PARTIAL#####-000333'.$dag_no
                    ]);
                }
                /////////////////////////////////////////
                if($dag['full_part_dag']=='P')
                {
                    $new_dag_no = $this->utilityclass->maxdag($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code']);
                    $chitha_baic = [
                        'old_dag_no' => $dag_no,
                        'old_patta_no' => $patta_no,
                        'dag_no_int' => $new_dag_no . '00',
                        'dag_no' => (string) $new_dag_no,
                        'patta_no' => (string) $new_patta_no,
                        'patta_type_code' => $patta_type_code,
                        'land_class_code' => $landclass_new_code,
                        'dag_area_b' => $applied_b,
                        'dag_area_k' => $applied_k,
                        'dag_area_lc' => $applied_lc,
                        'dag_area_g' => $applied_g,
                        'dag_area_kr' => 0,
                        'dag_revenue' => $revenue,
                        'dag_local_tax' => $local_tax,
                        'user_code' => $user_code,
                        'operation' => 'I',
                        'date_entry' => $date,
                    ];
                    $mainchitha_basic = array_merge($location, $chitha_baic);
                    $chithaBasic = $this->Chitha_basic_model->insert_table('chitha_basic', $mainchitha_basic);
                    // log_message('error', "INSERT_CHITHA-AP###" . $this->db->last_query());
                    if ($chithaBasic == 0) {
                        log_message('error', "INSERT_CHITHA-RECLSP-001P###" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error' => 'INSERT_CHITHA-RECLSP-001P'
                        ]);
                    }
                }
                ////////OLD AREA SUBSTRACT///////
                $where = [
                    'dist_code' => $location['dist_code'],
                    'subdiv_code' => $location['subdiv_code'],
                    'cir_code' => $location['cir_code'],
                    'mouza_pargona_code' => $location['mouza_pargona_code'],
                    'lot_no' => $location['lot_no'],
                    'vill_townprt_code' => $location['vill_townprt_code'],
                    'dag_no' => $dag_no,
                ];
                if($dag['full_part_dag']=='P'){
                    $paramsUp = [
                        'dag_area_b' 						=> $areaSubstract[0],
                        'dag_area_k' 						=> $areaSubstract[1],
                        'dag_area_lc'      => $areaSubstract[2],
                        'dag_area_g'       => $areaSubstract[3],
                    ];
                }
                if($dag['full_part_dag']=='F'){
                    // echo "PARTIAL-PARTITION-RECLASS";
                    $paramsUp =[
                        'patta_no'        => $new_patta_no,
                        'land_class_code' => $landclass_new_code,
                        'dag_revenue'     => $dag_revenue,
                        'dag_local_tax'   => $local_tax,
                    ];
                }
                $params = [
                    'updated_on'            =>  date('Y-m-d H:i:s'),
                    'operation'             =>  'U',
                    'user_code'             =>  $user_code,
                    'jama_yn'               =>  'n',
                ];
                $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_basic', array_merge($params,$paramsUp), $where);
                if ($chithaUpdate == 0) {
                    log_message('error', "UPDATE_CHITHABASIC-RCLS#####-0004P" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'UPDATE_CHITHABASIC-RCLS#####-0004P'
                    ]);
                }
                ////////////////////////////////////
                // $ord_cron_no=$ord_cron_no++;
                $remark_gen = array(
                    'rmk_type_code' => '01',
                    'rmk_type_hist_no' => $rmk_type_hist_no,
                    'user_code' => $user_code,
                    'date_entry' => $date,
                    'operation' => 'E',
                    'jama_updated' => null,
                    'patta_no' => $patta_no,
                    'dag_no' => $dag_no
                );
                $chitha_remark_gen_data = (array_merge($location, $remark_gen));
                $chitha_rmk_gen = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
                // log_message('error', "INSERT_CHITHA_RMK_GEN-AP###" . $this->db->last_query());
                if ($chitha_rmk_gen == 0) {
                    log_message('error', "INSERT_CHITHA_RMK_GEN-RECLSP###-00013-1" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'INSERT_CHITHA_RMK_GEN-RECLSP###-00013-1'
                    ]);
                }
                if($dag['full_part_dag']=='P'){
                    $remark_gen['dag_no']= $new_dag_no;
                    $remark_gen['patta_no']= $new_patta_no;
                    $chitha_remark_gen_data = (array_merge($location, $remark_gen));
                    $chitha_rmk_gen = $this->Chitha_basic_model->insert_table('chitha_rmk_gen', $chitha_remark_gen_data);
                    // log_message('error', "INSERT_CHITHA_RMK_GEN-AP###" . $this->db->last_query());
                    if ($chitha_rmk_gen == 0) {
                        log_message('error', "INSERT_CHITHA_RMK_GEN-RECLSP###-00013-2" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error' => 'INSERT_CHITHA_RMK_GEN-RECLSP###-00013-2'
                        ]);
                    }
                }

                $order_basic = array(
                    'rmk_type_hist_no'			=> $rmk_type_hist_no,
                    'ord_no'							      => $case_no,
                    'ord_date'							    => date('Y-m-d'),
                    'ord_type_code'						=> $service_code,
                    'ord_cron_no'							 => $ord_cron_no++,
                    'case_no'							     => $case_no,
                    'ord_passby_sign_yn'	=> 'Y',
                    'ord_passby_desig'			=> $user_code,
                    'lm_code'							     => $lm_code,
                    'lm_sign_yn'							  => 'Y',
                    'lm_sign_date'							=> $lm_date,
                    'co_code'							     => $user_code,
                    'co_sign_yn'							  => 'Y',
                    'co_ord_date'							 => $date,
                    'user_code'							   => $user_code,
                    'date_entry'							  => $date,
                    'operation'							   => 'E',
                    'm_dag_area_b'							=> $applied_b,
                    'm_dag_area_k'							=> $applied_k,
                    'm_dag_area_lc'						=> $applied_lc,
                    'm_dag_area_g'							=> $applied_g,
                    'm_dag_area_kr'						=> 0,
                    'area_left_b'							 => '0',
                    'area_left_k'							 => '0',
                    'area_left_lc'							=> '0',
                    'area_left_g'							 => '0',
                    'old_dag_area_b'					=> $old_bigha,
                    'old_dag_area_k'					=> $old_katha,
                    'old_dag_area_lc'				=> $old_lessa,
                    'old_dag_area_g'					=> $old_gonda,
                    // 'rural_urban'							 => $approve_by,
                    'rtps_no'							     => $rtps_app_no,
                    'rtps_app_date'						=> date('Y-m-d',strtotime($date_of_application)),
                    'dag_revenue'							 => $revenue,
                    'dag_local_tax'						=> $local_tax,
                    'ord_impli_flag'					=> 1,
                    'dag_no'							      => $dag_no,
                    'full_partial'							=> $dag['full_part_dag'],
                );
                $chitha_rmk_ordbasic_data = (array_merge($location, $order_basic));
                $chitha_rmk_ordbasic = $this->Chitha_basic_model->insert_table('chitha_rmk_ordbasic', $chitha_rmk_ordbasic_data);
                // log_message('error', "INSERT_CHITHA_RMK_ORDBASIC-AP###" . $this->db->last_query());
                if ($chitha_rmk_ordbasic == 0) {
                    log_message('error', "INSERT_CHITHA_RMK_ORDBASIC-RECLS-1###-00014-1" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return json_encode([
                        'responseType' => 1,
                        'error' => 'INSERT_CHITHA_RMK_ORDBASIC-RECLS-1###-00014-1'
                    ]);
                }
                if($dag['full_part_dag']=='P'){
                    $order_basic['dag_no']=$new_dag_no;
                    $chitha_rmk_ordbasic_data = (array_merge($location, $order_basic));
                    $chitha_rmk_ordbasic = $this->Chitha_basic_model->insert_table('chitha_rmk_ordbasic', $chitha_rmk_ordbasic_data);
                    // log_message('error', "INSERT_CHITHA_RMK_ORDBASIC-AP###" . $this->db->last_query());
                    if ($chitha_rmk_ordbasic == 0) {
                        log_message('error', "INSERT_CHITHA_RMK_ORDBASIC-RECLS-2###-00014-2" . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode([
                            'responseType' => 1,
                            'error' => 'INSERT_CHITHA_RMK_ORDBASIC-RECLS-2###-00014-2'
                        ]);
                    }
                }

                /////////////////////////////////////////////
                foreach ($data['all_pattadar'] as $key => $dag_pattadars)
                {
                    $common = $this->getCommonFields($location, $user_code);
                    if ((string)$dag_no == (string)$key) {
                        $proposal_no = 1;
                        foreach ($dag_pattadars as $pat) {
                            $pattadarInsert = array_merge($common,
                                [
                                    'rmk_type_hist_no'     => $rmk_type_hist_no,
                                    'proposal_no'          => $proposal_no++,
                                    'dag_no'               => $dag_no,
                                    'patta_no'             => $patta_no,
                                    'patta_type_code'      => $patta_type_code,
                                    'present_land_class'   => $old_land_class,
                                    'proposed_land_class'  => $landclass_new_code,
                                    'proposed_land_revenue'=> $revenue,
                                    'proposed_land_localtax' => $local_tax,
                                    'lm_date'							 => $lm_date,
                                    'lm_code'							 => $lm_code,
                                    'co_code'							 => $user_code,
                                    'co_date'							 => $date,
                                    'dc_code'							 => $dc_code ?? null,
                                    'dc_date'							 => $dc_order_date ?? null,
                                    'dpt_order_no'				 => $dept_order_no ?? null,
                                    'dpt_order_date'			 => $dept_order_date ?? null,
                                    'ord_no'							 => $case_no,
                                    'pdar_id'              => $pat['pdar_id'],
                                    'pdar_name'            => $pat['pdar_name'],
                                    'pdar_guardian'				 => $pat['pdar_guardian'],
                                    'pdar_relation'				 => $pat['pdar_relation'],
                                    'new_dag_no'				   => $new_dag_no,
                                    'new_patta_no'     => $new_patta_no,
                                ] );
                            $chitha_reclassification_suite = $this->Chitha_basic_model->insert_table('chitha_reclassification_suite', $pattadarInsert);
                            if ($chitha_reclassification_suite == 0) {
                                log_message('error', "INSERT_PATTADAR-RECLS###-000144" . $this->db->last_query());
                                $this->db->trans_rollback();
                                return json_encode([
                                    'responseType' => 1,
                                    'error' => 'INSERT_PATTADAR-RECLS###-000144'
                                ]);
                            }
                        }
                    }
                }
                // echo $dag['full_part_dag'];
                //////////////Check No of pattadars /////////////////
                if($dag['full_part_dag']=='F'){
                    // $full_dags_array[]=['dag_no'=>$dag_no,'new_patta_no'=>$new_patta_no];
                    log_message('error',"FULL-DAGS##{$case_no}##DAG_NO###{$dag_no}###PATTANO###{$new_patta_no}");
                    $InsertStatus=$this->pattadarsLoopForInsert($location,$dag_no,$patta_no,$patta_type_code,$new_patta_no,$case_no);
                    if($InsertStatus==false){
                        return json_encode([
                            'responseType' => 1,
                            'error' => 'INSERT_PATTADAR-RECLS-FULL-UPDATE###-0005557'
                        ]);
                    }
                    $new_patta_no = $new_patta_no +1 ;
                }
                if($dag['full_part_dag']=='P'){
                    $part_dags_array[]=['dag_no'=>$new_dag_no,'old_dag'=>$dag_no];
                }
                // var_dump($part_dags_array);
            }
        }
        //////////Handle Partial and Full//////////////////////
        if(!empty($part_dags_array)){
            $pattadarInsertFullPart= $this->partialChithaDagPattadarInsert($location,$part_dags_array,$data['pattadar'],$patta_no,$patta_type_code,$new_patta_no,$case_no);
            // var_dump($pattadarInsertFullPart);
            if($pattadarInsertFullPart===false){
                return json_encode([
                    'responseType' => 1,
                    'error' => 'ERROR_IN_PROCESSING-0001111#####-0001111'
                ]);
            }
        }
        return json_encode([
            'responseType' => 2,
            'success' => 'Order successfully Completed'
        ]);
    }
    function pattadarsLoopForInsert($location,$dag_no,$patta_no,$patta_type_code,$new_patta_no,$case_no)
    {
        /////////////////////INSERT INTO THE NEW PATTA IN CASE OF FULL DAG PARTITION////////////////////////
        $user_code=$this->session->userdata('user_code');
        $date=date('Y-m-d H:i:s');
        $sqlPattadar=$this->db->query("Select cdp.pdar_id,cp.pdar_name,cp.pdar_father,cp.pdar_add1,cp.pdar_name_eng,cp.pdar_guard_eng,cp.pdar_guard_reln from chitha_pattadar cp join chitha_dag_pattadar cdp on cp.dist_code=cdp.dist_code and cp.subdiv_code=cdp.subdiv_code and cp.cir_code=cdp.cir_code and cp.mouza_pargona_code=cdp.mouza_pargona_code and cp.lot_no=cdp.lot_no and cp.vill_townprt_code=cdp.vill_townprt_code and cp.patta_type_code=cdp.patta_type_code and cp.patta_no=cdp.patta_no and cdp.pdar_id=cp.pdar_id where cdp.dist_code=? and cdp.subdiv_code=? and cdp.cir_code=? and cdp.mouza_pargona_code=? and cdp.lot_no=? and cdp.vill_townprt_code=? and cdp.patta_no=? and cdp.patta_type_code=? and cdp.dag_no=?
						and (cdp.p_flag is null or cdp.p_flag!='1')
						",
            [
                $location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'],$patta_no,$patta_type_code,$dag_no
            ]
        );
        $oldPattadars=$sqlPattadar->num_rows();
        if($oldPattadars==0){
            log_message('error', "PATTADARS-MISMATCH-RECLS-F###-00017F" . $this->db->last_query());
            $this->db->trans_rollback();
            return false;
        }
        // else if($oldPattadars==1){
        // 	/////////Only Single Pattadar Don't strike-out from old dag-patta//////////////
        // 	$strike_out=false;
        // }else if($oldPattadars > 1){
        // 	////////Strike out from old dag///////////
        // 	$strike_out=true;
        // }
        foreach($sqlPattadar->result_array() as $fp){
            $chitha_pattadar_final = [
                'pdar_name'       => $fp['pdar_name'] ?? '',
                'pdar_father'     => $fp['pdar_father'] ?? '',
                'pdar_name_eng'   => $fp['pdar_name_eng'] ?? '',
                'pdar_guard_eng'  => $fp['pdar_guard_eng'] ?? '',
                'o2_case_no'      => $case_no,
                'user_code'       => $user_code,
                'date_entry'      => $date,
                'operation'       => 'I',
                'jama_yn'         => 'n',
                'pdar_guard_reln' => $fp['pdar_guard_reln'],
                'new_pdar_name'   => 'N',
                'pdar_id'         => $fp['pdar_id']
            ];
            $chitha_pattadar_final['patta_no']=$new_patta_no;
            $chitha_pattadar_final['patta_type_code']=$patta_type_code;
            // var_dump($chitha_pattadar_final);
            $chitha_pattadar = $this->Chitha_basic_model->insert_table('chitha_pattadar', array_merge($location, $chitha_pattadar_final));
            if ($chitha_pattadar == 0) {
                log_message('error', "INSERT_chitha_pattadar-FINAL-RECLS-0047###" . $this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
        }
        ///////////UPDATE IN CHITHA-DAG-PATTADAR///////////////////
        $update_dag_pattadar=$this->db->query("update chitha_dag_pattadar set patta_no='$new_patta_no',date_entry='$date',user_code='$user_code' where dist_code=? and subdiv_code=? and cir_code=? and mouza_pargona_code=? and lot_no=? and vill_townprt_code=? and dag_no=? and patta_no=? and patta_type_code=? and (p_flag is null or p_flag!='1') ",[$location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'],$dag_no,$patta_no,$patta_type_code]);
        if($update_dag_pattadar==0){
            log_message('error', "INSERT_chitha_dag_pattadar-FINAL-RECLS-0048###" . $this->db->last_query());
            $this->db->trans_rollback();
            return false;
        }
        return true;
    }
    ///////////////////////
    function partialChithaDagPattadarInsert($location,$part_dags_array,$pattadar,$patta_no,$patta_type_code,$new_patta_no,$case_no){
        $user_code=$this->session->userdata('user_code');
        $date=date('Y-m-d H:i:s');
        //////////////Findout different IDs////////////////////
        $ids = [];
        foreach ($pattadar as $dag => $rows) {
            foreach ($rows as $row) {
                $ids[] = $row['pdar_id'];
            }
        }
        $unique_ids = array_unique($ids);
        $id_str = implode(",", $unique_ids);
        /////////////Findout Different Same///////////////////
        $sqlcp=$this->db->query("Select * from chitha_pattadar cp where cp.dist_code=? and cp.subdiv_code=? and cp.cir_code=? and cp.mouza_pargona_code=? and cp.lot_no=? and cp.vill_townprt_code=? and cp.patta_no=? and cp.patta_type_code=? and cp.pdar_id in (?)",array($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'],$patta_no,$patta_type_code, $id_str ));
        if($sqlcp->num_rows()==0){
            return false;
        }
        foreach($sqlcp->result_array() as $cp){
            ///////Bring a logic to store unqiue pdar_name only///////////////
            $name   = $this->normalize_bengali($cp['pdar_name']);
            $father = $this->normalize_bengali($cp['pdar_father']);
            $key = $name . '|' . $father;  // uniqueness based on name+father only
            if (!isset($unique_combos[$key])) {
                // store first occurrence (id doesn’t matter, but keep it if needed)
                $unique_combos[$key] = [
                    'pdar_id'     => $cp['pdar_id'],
                    'pdar_name'   => $name,
                    'pdar_father' => $father ,
                    'pdar_add1'  => $cp['pdar_add1'],
                    'pdar_add2'  => $cp['pdar_add2'],
                    'pdar_gender'  => $cp['pdar_gender'],
                    'pdar_mother'  => $cp['pdar_mother'],
                    'pdar_guard_reln'  => $cp['pdar_guard_reln'],
                ];
            }
        }
        $finalPattadarList= array_values($unique_combos);
        $pdar_id=$this->Chitha_basic_model->maxpdarIdCheck($location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'],$patta_type_code,$new_patta_no);
        $common = $this->getCommonFields($location, $user_code);
        foreach($finalPattadarList as $fp){
            $chitha_pattadar = array_merge(
                $common,
                [
                    'pdar_name'   => $fp['pdar_name'],
                    'pdar_father' => $fp['pdar_father'],
                    'patta_no'    => $new_patta_no,
                    'patta_type_code' => $patta_type_code,
                    'pdar_add1'   =>  $fp['pdar_add1'],
                    'pdar_add2'   =>  $fp['pdar_add2'],
                    'user_code'   => $user_code,
                    'o2_case_no'  => $case_no,
                    'pdar_id'     => $pdar_id,
                    'new_pdar_name' => 'N',
                    'jama_yn'     => 'n',
                    'pdar_gender' => $fp['pdar_gender'],
                    'pdar_mother' => $fp['pdar_mother'],
                    'pdar_guard_reln' => $fp['pdar_guard_reln'],
                ]
            );
            $chithapattadar_i = $this->Chitha_basic_model->insert_table('chitha_pattadar', $chitha_pattadar);
            // log_message('error', "INSERT_CHITHA-PATTADAR-AP###" . $this->db->last_query());
            if ($chithapattadar_i == 0) {
                log_message('error', "INSERT_CHITHA-PATTADAR-AP#OLD###-016" . $this->db->last_query());
                $this->db->trans_rollback();
                return false;
            }
            $finalIsertIds[]=[$pdar_id];
            $pdar_id++;
        }
        ///////////////Insert IN CDP/////////////////
        foreach($part_dags_array as $partDag){
            foreach($finalIsertIds as $pdarIDS)
            {
                // var_dump($pdarIDS);
                $i=0;
                $c_d_p = array(
                    'pdar_id' => $pdarIDS[$i],
                    'patta_no' => $new_patta_no,
                    'patta_type_code' => $patta_type_code,
                    'dag_por_b' => 0,
                    'dag_por_k' => 0,
                    'dag_por_lc' => 0,
                    'dag_por_g' => 0,
                    'dag_por_kr' => 0,
                    'user_code' => $user_code,
                    'date_entry' => date('Y-m-d'),
                    'operation' => 'I',
                    'p_flag' => '0',
                    'jama_yn' => 'N',
                    'dag_no' => $partDag['dag_no']
                );
                $i++;
                $chitha_dag_pattadar = array_merge($location, $c_d_p);
                // var_dump($chitha_dag_pattadar);
                $chitha_dag_pattadar = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar', $chitha_dag_pattadar);
                if ($chitha_dag_pattadar == 0) {
                    log_message('error', "INSERT_chitha_dag_pattadar_RECLS_PART#####" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
            }
        }
        /////////////////REMOVE FROM OLD DAG/////////////////////////
        foreach ($pattadar as $dag => $rows) {
            foreach ($rows as $row) {
                $pdar_id= $row['pdar_id'];
                /////////////////////////////////
                $sqlPattadar=$this->db->query("Select cdp.pdar_id,cp.pdar_name,cp.pdar_father,cp.pdar_add1,cp.pdar_name_eng,cp.pdar_guard_eng,cp.pdar_guard_reln from chitha_pattadar cp join chitha_dag_pattadar cdp on cp.dist_code=cdp.dist_code and cp.subdiv_code=cdp.subdiv_code and cp.cir_code=cdp.cir_code and cp.mouza_pargona_code=cdp.mouza_pargona_code and cp.lot_no=cdp.lot_no and cp.vill_townprt_code=cdp.vill_townprt_code and cp.patta_type_code=cdp.patta_type_code and cp.patta_no=cdp.patta_no and cdp.pdar_id=cp.pdar_id where cdp.dist_code=? and cdp.subdiv_code=? and cdp.cir_code=? and cdp.mouza_pargona_code=? and cdp.lot_no=? and cdp.vill_townprt_code=? and cdp.patta_no=? and cdp.patta_type_code=? and cdp.dag_no=?
													 and (cdp.p_flag is null or cdp.p_flag!='1')
													",
                    [
                        $location['dist_code'], $location['subdiv_code'], $location['cir_code'], $location['mouza_pargona_code'], $location['lot_no'], $location['vill_townprt_code'],$patta_no,$patta_type_code,$row['dag_no']
                    ]
                );
                // echo $this->db->last_query();
                $oldPattadars=$sqlPattadar->num_rows();
                if($oldPattadars==0){
                    log_message('error', "PATTADARS-MISMATCH-RECLS-F###-000777P" . $this->db->last_query());
                    $this->db->trans_rollback();
                    return false;
                }
                else if($oldPattadars==1){
                    /////////Only Single Pattadar Don't strike-out from old dag-patta//////////////
                    $strike_out = false;
                    continue;
                }else if($oldPattadars > 1){
                    ////////Strike out from old dag///////////
                    $strike_out = true;
                    if($row['retain_old_dag']===false){
                        $params = [
                            'p_flag' => 1,
                            'operation' => 'U',
                            'date_entry' => $date,
                            'user_code'  => $user_code
                        ];
                        $where = [
                            'dist_code' => $location['dist_code'],
                            'subdiv_code' => $location['subdiv_code'],
                            'cir_code' => $location['cir_code'],
                            'mouza_pargona_code' => $location['mouza_pargona_code'],
                            'lot_no' => $location['lot_no'],
                            'vill_townprt_code' => $location['vill_townprt_code'],
                            'dag_no' => $row['dag_no'],
                            'patta_no' => $patta_no,
                            'patta_type_code' => $patta_type_code,
                            'pdar_id' => $pdar_id,
                        ];

                        $chithaUpdate = $this->Chitha_basic_model->update_table('chitha_dag_pattadar', $params, $where);
                        if ($chithaUpdate == 0) {
                            log_message('error', "chitha_dag_pattadar####" . $this->db->last_query());
                            $this->db->trans_rollback();
                            return false;
                        }
                    }
                }else{
                    continue;
                }
            }
        }
        //////////////////////////////////////////////
        return true;
    }

    public function RelinqishmentChithaUpdate($input)
    {
        // -----------------------------
        // Basic required fields
        // -----------------------------
        $requiredMain = ['case_no', 'remarks', 'location', 'dags'];
        foreach ($requiredMain as $key) {
            if (!isset($input[$key]) || $input[$key] === '' || (is_array($input[$key]) && count($input[$key]) === 0)) {
                return json_encode(['status' => 0, 'msg' => "$key is missing or empty"]);
            }
        }

        // -----------------------------
        // LOCATION VALIDATION
        // -----------------------------
        $locationReq = [
            'dist_code', 'subdiv_code', 'cir_code',
            'mouza_pargona_code', 'lot_no', 'vill_townprt_code',
            'service_code', 'case_no', 'applid', 'petition_no', 'status'
        ];
        if (!is_array($input['location'])) {
            return json_encode(['status' => 0, 'msg' => "location must be an array"]);
        }
        foreach ($locationReq as $key) {
            if (!isset($input['location'][$key]) || $input['location'][$key] === '') {
                return json_encode(['status' => 0, 'msg' => "location.$key is missing"]);
            }
        }

        $location = [
            'dist_code' => $input['location']['dist_code'],
            'subdiv_code' => $input['location']['subdiv_code'],
            'cir_code' => $input['location']['cir_code'],
            'mouza_pargona_code' => $input['location']['mouza_pargona_code'],
            'lot_no' => $input['location']['lot_no'],
            'vill_townprt_code' => $input['location']['vill_townprt_code'],
        ];

        // -----------------------------
        // DAGS VALIDATION
        // -----------------------------
        if (!is_array($input['dags']) || count($input['dags']) === 0) {
            return json_encode(['status' => 0, 'msg' => "dags array is required"]);
        }

        foreach ($input['dags'] as $dagIndex => $dag) {
            $dagRequired = [
                'dag_no', 'patta_no', 'patta_type_code', 'land_type',
                's_dag_area_b', 's_dag_area_k', 's_dag_area_lc', 's_dag_area_g',
                'dag_area_b', 'dag_area_k', 'dag_area_lc', 'dag_area_g',
                'is_urban', 'pattadars'
            ];
            if (!is_array($dag)) {
                return json_encode(['status' => 0, 'msg' => "dags[$dagIndex] must be an array"]);
            }
            foreach ($dagRequired as $key) {
                if (!array_key_exists($key, $dag)) {
                    return json_encode(['status' => 0, 'msg' => "dags[$dagIndex].$key is missing"]);
                }
            }

            if (!is_array($dag['pattadars']) || count($dag['pattadars']) === 0) {
                return json_encode(['status' => 0, 'msg' => "dags[$dagIndex].pattadars is empty"]);
            }

            foreach ($dag['pattadars'] as $pIndex => $pd) {
                $pdReq = [
                    'pdar_id', 'pdar_cron_no', 'pdar_name',
                    'pdar_guardian', 'inplace_alongwith', 'pdar_type'
                ];
                if (!is_array($pd)) {
                    return json_encode(['status' => 0, 'msg' => "dags[$dagIndex].pattadars[$pIndex] must be an array"]);
                }
                foreach ($pdReq as $k) {
                    if (!array_key_exists($k, $pd)) {
                        return json_encode(['status' => 0, 'msg' => "dags[$dagIndex].pattadars[$pIndex].$k is missing"]);
                    }
                }
            }
        }
        try {
            // Save main application (sample)
            $appData = [
                'case_no' => $input['case_no'],
                'remarks' => $input['remarks'],
                'applid' => $input['location']['applid'],
                'service_code' => $input['location']['service_code'],
                'created_at' => date('Y-m-d H:i:s'),
                'user_code' => $this->session->userdata('user_code') ?: null
            ];
            // If you actually have a model to save application, call it here.
            // e.g. $this->SomeModel->insert_application($appData);

            // Process dags
            foreach ($input['dags'] as $dag) {
                $dag_no = $dag['dag_no'];
                $patta_no = $dag['patta_no'];
                $patta_type_code = $dag['patta_type_code'];

                // Validate area against CHITHA
                $oldAreaChitha = $this->areaVerifyInChitha($location, $dag_no, $patta_type_code, $patta_no);
                if ($oldAreaChitha === 'NA' || empty($oldAreaChitha)) {
                    $this->db->trans_rollback();
                    return json_encode(['status' => 0, 'msg' => 'CHITHA-RECORD-NOT-FOUND']);
                }

                $old_bigha = (float)$oldAreaChitha->dag_area_b;
                $old_katha = (float)$oldAreaChitha->dag_area_k;
                $old_lessa = (float)$oldAreaChitha->dag_area_lc;
                $old_gonda = (float)$oldAreaChitha->dag_area_g;

                // Compute applied & total area depending on Barak valley logic
                if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {
                    $applied = $dag['s_dag_area_b'] * 6400 + $dag['s_dag_area_k'] * 320 + $dag['s_dag_area_lc'] * 20 + $dag['s_dag_area_g'];
                    $totalArea = $old_bigha * 6400 + $old_katha * 320 + $old_lessa * 20 + $old_gonda;
                    $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalArea - $applied);
                } else {
                    $applied = $dag['s_dag_area_b'] * 100 + $dag['s_dag_area_k'] * 20 + $dag['s_dag_area_lc'];
                    $totalArea = $old_bigha * 100 + $old_katha * 20 + $old_lessa;
                    $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa($totalArea - $applied);
                }

                // Determine if we need to create a new govt dag
                $new_dag_no = false;
                if ($applied != $totalArea) {
                    // maxdag expects location fields separately
                    $new_dag_no = $this->utilityclass->maxdag(
                        $location['dist_code'],
                        $location['subdiv_code'],
                        $location['cir_code'],
                        $location['mouza_pargona_code'],
                        $location['lot_no'],
                        $location['vill_townprt_code']
                    );
                }
                // If new dag created -> insert new chitha_basic govt dag
                if ($new_dag_no) {
                    $cb_insert = [
                        'dag_area_b' => $areaSubstract[0],
                        'dag_area_k' => $areaSubstract[1],
                        'dag_area_lc' => $areaSubstract[2],
                        'dag_area_g' => $areaSubstract[3],
                        'dag_area_kr' => 0,
                        'dag_no' => (string)$new_dag_no,
                        'patta_no' => '0',            // govt patta
                        'patta_type_code' => '0209',  // sreni nai
                        'old_dag_no' => $dag_no,
                        'old_patta_no' => $patta_no,
                        'dag_no_int' => $new_dag_no . '00',
                        'land_class_code' => '5555',
                        'dag_revenue' => 0,
                        'dag_local_tax' => 0,
                        'operation' => 'I',
                        'user_code' => $this->session->userdata('user_code'),
                        'date_entry' => date('Y-m-d'),
                    ];

                    $mainchitha_basic = array_merge($location, $cb_insert);
                    $chithaBasic = $this->Chitha_basic_model->insert_table('chitha_basic', $mainchitha_basic);
                    if ($chithaBasic == 0) {
                        log_message('error', "INSERT_CHITHA# " . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode(['status' => 0, 'msg' => 'Failed in Updation##CBI###00012']);
                    }

                    // Insert govt-only cdp/cp for the new dag
                    $insertcdp_cp = $this->insert_cdp_cp_govt_only($location, $new_dag_no);
                    if ($insertcdp_cp == false) {
                        $this->db->trans_rollback();
                        return json_encode(['status' => 0, 'msg' => 'Failed in INSERTION-GOVT-PDAR##CDPCP###00013']);
                    }
                } else {
                    // Update existing dag as govt
                    $chitha_basic_update = [
                        'updated_on' => date('Y-m-d'),
                        'operation' => 'U',
                        'user_code' => $this->session->userdata('user_code'),
                        'patta_no' => '0',
                        'patta_type_code' => '0209',
                        'land_class_code' => '5555'
                    ];

                    $where = array_merge($location, [
                        'dag_no' => $dag['dag_no'],
                        'patta_no' => $dag['patta_no'],
                        'patta_type_code' => $dag['patta_type_code']
                    ]);

                    $chitha_basic = $this->Chitha_basic_model->update_table('chitha_basic', $chitha_basic_update, $where);
                    if ($chitha_basic == 0) {
                        log_message('error', "UPDATE_chitha_basic " . $this->db->last_query());
                        $this->db->trans_rollback();
                        return json_encode(['status' => 0, 'msg' => 'Failed in Updation##CB###00011']);
                    }

                    $insertcdp_cp = $this->insert_cdp_cp_govt_only($location, $dag['dag_no']);
                    if ($insertcdp_cp == false) {
                        $this->db->trans_rollback();
                        return json_encode(['status' => 0, 'msg' => 'Failed in INSERTION-GOVT-PDAR##CDPCP###00014']);
                    }
                }

                // -----------------------------
                // Update pattadars inside dag
                // -----------------------------
                $pattadars = $dag['pattadars'];
                foreach ($pattadars as $pd) {
                    $pdar_id = $pd['pdar_id'];
                    $inplace_alongwith = $pd['inplace_alongwith'];

                    if ($inplace_alongwith == 'i') {
                        $chitha_dag_pattadar = [
                            'p_flag' => '1',
                            'updated_on' => date('Y-m-d'),
                            'operation' => 'U',
                            'user_code' => $this->session->userdata('user_code')
                        ];
                        $where = array_merge($location, [
                            'dag_no' => $dag['dag_no'],
                            'patta_no' => $dag['patta_no'],
                            'patta_type_code' => $dag['patta_type_code'],
                            'pdar_id' => $pdar_id
                        ]);
                    }
                } // end pattadars loop
            } // end dags loop
            return json_encode(['status' => 1, 'msg' => "Success"]);
        } catch (Exception $e) {
            $this->db->trans_rollback();
            log_message('error', "RelinqishmentChithaUpdate Exception: " . $e->getMessage());
            return json_encode(['status' => 0, 'msg' => 'Exception: ' . $e->getMessage()]);
        }
    }
    private function insert_cdp_cp_govt_only($location, $dag_no)
    {
        $dist   = $location['dist_code'];
        $subdiv = $location['subdiv_code'];
        $cir    = $location['cir_code'];
        $mouza  = $location['mouza_pargona_code'];
        $lot    = $location['lot_no'];
        $vill   = $location['vill_townprt_code'];
        $user_code = $this->session->userdata('user_code');
        // -----------------------------------------------------
        // CHECK CDP (chitha_dag_pattadar)
        // -----------------------------------------------------
        $sql = "SELECT * FROM chitha_dag_pattadar 
	            WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
	            AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
	            AND dag_no=? AND patta_no=? AND patta_type_code=? AND pdar_id=?";
        $cdp = $this->db->query($sql, [
            $dist, $subdiv, $cir, $mouza, $lot, $vill,
            (string)$dag_no, '0', '0209', 1
        ]);
        // echo $this->db->last_query();
        if ($cdp->num_rows() == 0) {

            $c_d_p = [
                'pdar_id'        => 1,
                'patta_no'       => '0',
                'patta_type_code'=> '0209',
                'dag_por_b'      => 0,
                'dag_por_k'      => 0,
                'dag_por_lc'     => 0,
                'dag_por_g'      => 0,
                'dag_por_kr'     => 0,
                'user_code'      => $user_code,
                'date_entry'     => date('Y-m-d'),
                'operation'      => 'I',
                'p_flag'         => '0',
                'jama_yn'        => 'N'
            ];
            $row = array_merge($location, ['dag_no'=>(string)$dag_no], $c_d_p);
            $ins = $this->Chitha_basic_model->insert_table('chitha_dag_pattadar', $row);
            if ($ins == 0) {
                log_message('error', "INSERT_chitha_dag_pattadar" . $this->db->last_query());
                return false;
            }
        }
        // -----------------------------------------------------
        // CHECK CP (chitha_pattadar)
        // -----------------------------------------------------
        $sqlcp = "SELECT * FROM chitha_pattadar 
	              WHERE dist_code=? AND subdiv_code=? AND cir_code=? 
	              AND mouza_pargona_code=? AND lot_no=? AND vill_townprt_code=? 
	              AND patta_no=? AND patta_type_code=?";

        $cp = $this->db->query($sqlcp, [
            $dist, $subdiv, $cir, $mouza, $lot, $vill,
            '0', '0209'
        ]);
        if ($cp->num_rows() == 0) {

            $cp_data = [
                'pdar_id'        => 1,
                'pdar_name'      => 'চৰকাৰী',
                'pdar_father'    => 'নাই',
                'patta_no'       => '0',
                'patta_type_code'=> '0209',
                'user_code'      => $user_code,
                'date_entry'     => date('Y-m-d'),
                'operation'      => 'I',
                'jama_yn'        => 'Y',
                'pdar_guard_reln'=> 'u',
                'pdar_gender'    => 'o',
                'new_pdar_name'  => 'N'
            ];
            $row = array_merge($location, $cp_data);
            $ins = $this->Chitha_basic_model->insert_table('chitha_pattadar', $row);
            if ($ins == 0) {
                log_message('error', "INSERT_chitha_pattadar" . $this->db->last_query());
                return false;
            }
        }
        return true;
    }
    private function normalize_bengali($str) {
        // Normalize য + nukta → য়
        $str = str_replace("\u{09AF}\u{09BC}", "\u{09DF}", $str);

        // Remove ZERO WIDTH JOINER and NON-JOINER
        $str = str_replace(["\u{200C}", "\u{200D}"], '', $str);

        // Replace non-breaking space with regular space
        $str = str_replace("\u{00A0}", ' ', $str);

        // Trim and normalize multiple spaces
        $str = preg_replace('/\s+/u', ' ', trim($str));

        return $str;
    }
    public function AcqChithaUpdate($input)
	{
	    $requiredMain = ['case_no', 'remarks', 'location', 'dags'];
	    foreach ($requiredMain as $key) {
	        if (!isset($input[$key])) {
	            return ['status' => 0, 'msg' => "$key is missing"];
	        }
	    }
	    if (empty($input['case_no'])) {
	        return ['status' => 0, 'msg' => 'case_no cannot be empty'];
	    }

	    if (!is_array($input['location'])) {
	        return ['status' => 0, 'msg' => 'location must be an array'];
	    }

	    if (!is_array($input['dags']) || count($input['dags']) == 0) {
	        return ['status' => 0, 'msg' => 'dags must contain at least one item'];
	    }
	    // Location required keys
	    $requiredLoc = [
	        'dist_code','subdiv_code','cir_code','mouza_pargona_code','lot_no',
	        'vill_townprt_code','case_no','applid','tea_estate_name','status',
	        'user_code','uuid','notice_no','notice_date','mobile_no'
	    ];
	    foreach ($requiredLoc as $key) {
	        if (!isset($input['location'][$key]) || $input['location'][$key] === "") {
	            return ['status' => 0, 'msg' => "location.$key is missing or empty"];
	        }
	    }
	    // Dags validation
	    $requiredDag = [
	        'dag_no','patta_no','patta_type_code','bigha','katha',
	        'lessa','ganda','chatak','kranti'
	    ];
	    foreach ($input['dags'] as $index => $dg) {
	        foreach ($requiredDag as $key) {
	            if (!isset($dg[$key]) || $dg[$key] === "") {
	                return [
	                    'status' => 0,
	                    'msg' => "dags[$index].$key is missing or empty"
	                ];
	            }
	        }
	    }
	    try {
	        // ###########################################################
	        // TRANSACTION START
	        // ###########################################################
	        $location = [
	            'dist_code' => $input['location']['dist_code'],
	            'subdiv_code' => $input['location']['subdiv_code'],
	            'cir_code' => $input['location']['cir_code'],
	            'mouza_pargona_code' => $input['location']['mouza_pargona_code'],
	            'lot_no' => $input['location']['lot_no'],
	            'vill_townprt_code' => $input['location']['vill_townprt_code'],
	        ];

	        foreach ($input['dags'] as $dg) {

	            $dag_no    = $dg['dag_no'];
	            $patta_no  = $dg['patta_no'];
	            $patta_type_code  = $dg['patta_type_code'];
	            $bigha     = $dg['bigha'];
	            $katha     = $dg['katha'];
	            $lessa     = $dg['lessa'];
	            $ganda     = $dg['ganda'];
	            $chatak    = $dg['chatak'];
	            $kranti    = $dg['kranti'];

	            // --------------------------------------------------------
	            // FETCH OLD CHITHA AREA
	            // --------------------------------------------------------
	            $oldAreaChitha = $this->areaVerifyInChitha($location, $dag_no, $patta_type_code, $patta_no);

	            if ($oldAreaChitha === 'NA' || empty($oldAreaChitha)) {
	                $this->db->trans_rollback();
	                return ['status' => 0, 'msg' => 'CHITHA-RECORD-NOT-FOUND'];
	            }

	            $old_bigha = (float)$oldAreaChitha->dag_area_b;
	            $old_katha = (float)$oldAreaChitha->dag_area_k;
	            $old_lessa = (float)$oldAreaChitha->dag_area_lc;
	            $old_gonda = (float)$oldAreaChitha->dag_area_g;

	            // --------------------------------------------------------
	            // AREA CALCULATION (BARAK VS NON-BARAK)
	            // --------------------------------------------------------
	            if (in_array($this->session->userdata('dist_code'), json_decode(BARAK_VALLEY))) {

	                $applied = $bigha * 6400 + $katha * 320 + $lessa * 20 + $ganda;
	                $totalArea = $old_bigha * 6400 + $old_katha * 320 + $old_lessa * 20 + $old_gonda;
	                $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa2($totalArea - $applied);

	            } else {

	                $applied = $bigha * 100 + $katha * 20 + $lessa;
	                $totalArea = $old_bigha * 100 + $old_katha * 20 + $old_lessa;
	                $areaSubstract = $this->utilityclass->Total_Bigha_Katha_Lessa($totalArea - $applied);
	            }

	            // --------------------------------------------------------
	            // CHECK IF NEW DAG IS NEEDED
	            // --------------------------------------------------------
	            $new_dag_no = false;
	            if ($applied != $totalArea) {
	                $new_dag_no = $this->utilityclass->maxdag(
	                    $location['dist_code'],
	                    $location['subdiv_code'],
	                    $location['cir_code'],
	                    $location['mouza_pargona_code'],
	                    $location['lot_no'],
	                    $location['vill_townprt_code']
	                );
	            }
	            // --------------------------------------------------------
	            // NEW GOVT DAG CREATION
	            // --------------------------------------------------------
	            if ($new_dag_no) {
	                $cb_insert = [
	                    'dag_area_b' => $areaSubstract[0],
	                    'dag_area_k' => $areaSubstract[1],
	                    'dag_area_lc' => $areaSubstract[2],
	                    'dag_area_g' => $areaSubstract[3],
	                    'dag_area_kr' => 0,
	                    'dag_no' => (string)$new_dag_no,
	                    'patta_no' => '0',
	                    'patta_type_code' => '0209',
	                    'old_dag_no' => $dag_no,
	                    'old_patta_no' => $patta_no,
	                    'dag_no_int' => $new_dag_no . '00',
	                    'land_class_code' => '5555',
	                    'dag_revenue' => 0,
	                    'dag_local_tax' => 0,
	                    'operation' => 'I',
	                    'user_code' => $this->session->userdata('user_code'),
	                    'date_entry' => date('Y-m-d'),
	                ];
	                $mainchitha_basic = array_merge($location, $cb_insert);
	                $chithaBasic = $this->Chitha_basic_model->insert_table('chitha_basic', $mainchitha_basic);
	                if ($chithaBasic == 0) {
	                    log_message('error', "INSERT_CHITHA# " . $this->db->last_query());
	                    $this->db->trans_rollback();
	                    return ['status' => 0, 'msg' => 'Failed in Updation##CBI###00012'];
	                }
	                // Insert govt PDAR
	                if (!$this->insert_cdp_cp_govt_only($location, $new_dag_no)) {
	                    $this->db->trans_rollback();
	                    return ['status' => 0, 'msg' => 'Failed in INSERTION-GOVT-PDAR##CDPCP###00013'];
	                }

	            } else {

	                // --------------------------------------------------------
	                // UPDATE EXISTING DAG TO GOVT
	                // --------------------------------------------------------
	                $chitha_basic_update = [
	                    'updated_on' => date('Y-m-d'),
	                    'operation' => 'U',
	                    'user_code' => $this->session->userdata('user_code'),
	                    'patta_no' => '0',
	                    'patta_type_code' => '0209',
	                    'land_class_code' => '5555'
	                ];

	                $where = array_merge($location, [
	                    'dag_no' => $dg['dag_no'],
	                    'patta_no' => $dg['patta_no'],
	                    'patta_type_code' => $dg['patta_type_code']
	                ]);

	                $chitha_basic = $this->Chitha_basic_model->update_table('chitha_basic', $chitha_basic_update, $where);

	                if ($chitha_basic == 0) {
	                    log_message('error', "UPDATE_chitha_basic " . $this->db->last_query());
	                    $this->db->trans_rollback();
	                    return ['status' => 0, 'msg' => 'Failed in Updation##CB###00011'];
	                }

	                if (!$this->insert_cdp_cp_govt_only($location, $dg['dag_no'])) {
	                    $this->db->trans_rollback();
	                    return ['status' => 0, 'msg' => 'Failed in INSERTION-GOVT-PDAR##CDPCP###00014'];
	                }
	            }
	        }
	        // ###########################################################
	        // COMMIT
	        // ###########################################################
	        if ($this->db->trans_status() === FALSE) {
	            $this->db->trans_rollback();
	            return ['status' => 0, 'msg' => 'Transaction failed'];
	        }
	        return ['status' => 1, 'msg' => 'SUCCESS'];
	    } catch (Exception $e) {
	        // FAILSAFE ROLLBACK
	        if ($this->db->trans_status()) {
	            $this->db->trans_rollback();
	        }
	        log_message('error', 'ERROR_AcqChithaUpdate: ' . $e->getMessage());
	        return ['status' => 0, 'msg' => 'EXCEPTION: ' . $e->getMessage()];
	    }
	}

}
 