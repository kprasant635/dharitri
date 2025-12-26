<?php
class ADCCaseTransferModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_services()
    {
        $services = $this->db->query("select * from master_services_for_transfercase");

        if ($services->num_rows() > 0) {
            return $services->result();
        } else {
            return false;
        }

    }

    public function get_adc_details()
    {
        $dist_code = $this->session->userdata('dist_code');
        $user_code = $this->session->userdata('user_code');

        // dd("SElect use_name,user_code,dist_code from loginuser_table where dist_code='$dist_code' and dis_enb_option!='E' and user_code like 'ADC%' and priv='adm' and user_code = '$user_code'");
        $ADCs = $this->db->query("SElect use_name,user_code,dist_code from loginuser_table where dist_code='$dist_code' and dis_enb_option='E' and user_code like 'ADC%' and priv='adm' and user_code = '$user_code'");
        // $ADCs = $this->db->query("SElect use_name,user_code,dist_code from loginuser_table where dist_code='$dist_code' and user_code like 'ADC%' and priv='adm'");
        if ($ADCs->num_rows() > 0) {
            return $ADCs->result();
        } else {
            return false;
        }
    }

    public function get_disbaled_adc_details()
    {
        $dist_code = $this->session->userdata('dist_code');
        $ADCs      = $this->db->query("SElect use_name,user_code,dist_code from loginuser_table where dist_code='$dist_code' and dis_enb_option !='E' and user_code like 'ADC%' and priv='adm'");
        // $ADCs = $this->db->query("SElect use_name,user_code,dist_code from loginuser_table where dist_code='$dist_code' and user_code like 'ADC%' and priv='adm'");
        if ($ADCs->num_rows() > 0) {
            return $ADCs->result();
        } else {
            return false;
        }
    }
    public function transferCase($service_code_name, $from_officer, $officer_to, $district)
    {
        // 1. Check if the service code exists in the master_services_for_transfercase table
        $this->db->where('id', $service_code_name);
        $query = $this->db->get('master_services_for_transfercase');

        if ($query->num_rows() == 0) {
            echo json_encode(['status' => 'error', 'message' => 'Service code not found']);
            return;
        }

        // 2. Get the combination_of_services array from the table
        $service                 = $query->row();
        $combination_of_services = json_decode($service->combination_of_services); // Assuming it's stored as a JSON array

        // 3. Begin a transaction to ensure atomicity
        $this->db->trans_start();

        // echo "$service_code_name"; die;

        // Initialize a variable to track the total number of rows updated in 'settlement_basic'
        $total_updated_rows = 0;

        if ($service_code_name == 1) {
            // 4. Loop through the combination_of_services and check in each table
            foreach ($combination_of_services as $service_code) {

                // Check and update in the 'settlement_basic' table
                $this->db->where('adc_code', $from_officer);
                $this->db->where('pending_officer', 'ADC');
                $this->db->where('dist_code', $this->session->userdata('dist_code'));
                // status not IN ('N', 'P', 'VN','D')
                $this->db->where_not_in('status', ['N', 'P', 'VN', 'D']);
                $query = $this->db->get('settlement_basic');

                if ($query->num_rows() > 0) {
                    // Update the 'settlement_basic' table
                    $this->db->where('adc_code', $from_officer);
                    $this->db->update('settlement_basic', ['adc_code' => $officer_to]);
                }

                // Update the total_updated_rows for the 'settlement_basic' table
                $total_updated_rows += $query->num_rows();

                // Check and update in the 'proposal_meeting_list' table
                $this->db->where('user_code', $from_officer);
                $query = $this->db->get('proposal_meeting_list');
                if ($query->num_rows() > 0) {
                    // Update the 'proposal_meeting_list' table
                    $this->db->where('user_code', $from_officer);
                    $this->db->where('dist_code', $this->session->userdata('dist_code'));
                    $this->db->update('proposal_meeting_list', ['user_code' => $officer_to]);
                }

                // Check and update in the 'settlement_proposal_list' table
                $this->db->where('user_code', $from_officer);
                $query = $this->db->get('settlement_proposal_list');
                if ($query->num_rows() > 0) {
                    // Update the 'settlement_proposal_list' table
                    $this->db->where('user_code', $from_officer);
                    $this->db->where('dist_code', $this->session->userdata('dist_code'));
                    $this->db->update('settlement_proposal_list', ['user_code' => $officer_to]);
                }
            }
        }else if ($service_code_name == 4) {
            // echo "sdfghjkl";
            foreach ($combination_of_services as $service_code) {

                // Check and update in the 'settlement_basic' table
                $this->db->where('adc_code', $from_officer);
                $this->db->where('pending_officer', 'ADC');
                $this->db->where('dist_code', $this->session->userdata('dist_code'));
                // status not IN ('N', 'P', 'VN','D')
                $this->db->where_not_in('status', ['N', 'P', 'VN', 'D']);
                $query = $this->db->get('settlement_basic');

                // echo $this->db->last_query(); die;

                if ($query->num_rows() > 0) {
                    // Update the 'settlement_basic' table
                    $this->db->where('adc_code', $from_officer);
                    $this->db->update('settlement_basic', ['adc_code' => $officer_to]);
                }

                // Update the total_updated_rows for the 'settlement_basic' table
                $total_updated_rows += $query->num_rows();
                // var_dump($total_updated_rows); die;

                // Check and update in the 'proposal_meeting_list' table
                $this->db->where('user_code', $from_officer);
                $query = $this->db->get('proposal_meeting_list');
                if ($query->num_rows() > 0) {
                    // Update the 'proposal_meeting_list' table
                    $this->db->where('user_code', $from_officer);
                    $this->db->where('dist_code', $this->session->userdata('dist_code'));
                    $this->db->update('proposal_meeting_list', ['user_code' => $officer_to]);
                }

                // Check and update in the 'settlement_proposal_list' table
                $this->db->where('user_code', $from_officer);
                $query = $this->db->get('settlement_proposal_list');
                if ($query->num_rows() > 0) {
                    // Update the 'settlement_proposal_list' table
                    $this->db->where('user_code', $from_officer);
                    $this->db->where('dist_code', $this->session->userdata('dist_code'));
                    $this->db->update('settlement_proposal_list', ['user_code' => $officer_to]);
                }
            }
        }else if ($service_code_name == 2) {

            // Check and update in the 'proposal_meeting_list' table
            $this->db->where('adc_code', $from_officer);
            $this->db->where('dist_code', $this->session->userdata('dist_code'));
            $this->db->where('status', 'A');
            $query = $this->db->get('t_reclassification');
            if ($query->num_rows() > 0) {
                // Update the 't_reclassification' table
                $this->db->where('adc_code', $from_officer);
                $this->db->where('dist_code', $this->session->userdata('dist_code'));
                $this->db->where('status', 'A');
                $this->db->update('t_reclassification', ['adc_code' => $officer_to]);
            }

            // Update the total_updated_rows for the 'settlement_basic' table
            $total_updated_rows += $query->num_rows();

            $this->db->where('assigned_to', $from_officer);
            $this->db->where('status', 'P');
            // status not IN ('N', 'P', 'VN','D')
            $query = $this->db->get('escalation_details');

            if ($query->num_rows() > 0) {
                // Update the 'settlement_basic' table
                $this->db->where('assigned_to', $from_officer);
                $this->db->where('status', 'P');
                $this->db->update('escalation_details', ['assigned_to' => $officer_to]);
            }

        }else if ($service_code_name == 3) {

            // Check and update in the 'proposal_meeting_list' table
            $this->db->where('adc_code', $from_officer);
            $this->db->where('dist_code', $this->session->userdata('dist_code'));
            $this->db->where('status', 'R');
            $query = $this->db->get('allotment_cert_basic');
            $total_updated_rows += $query->num_rows();

            if ($query->num_rows() > 0) {
                // Update the 'allotment_cert_basic' table

                //check the es_flag and update the allotment_cert_basic table for all rows
                foreach ($query->result() as $row) {
                    if ($row->es_flag == 1) {
                        $this->db->where('assigned_to', $from_officer);
                        $this->db->where('status', 'P');
                        $query2 = $this->db->get('escalation_details');
                        if ($query2->num_rows() > 0) {
                            // Update the 'allotment_cert_basic' table
                            $this->db->where('assigned_to', $from_officer);
                            $this->db->where('status', 'P');
                            $this->db->update('escalation_details', ['assigned_to' => $officer_to]);
                        }

                    }
                    //Update the table alloment cert basic
                    $this->db->where('adc_code', $from_officer);
                    $this->db->where('dist_code', $this->session->userdata('dist_code'));
                    $this->db->where('status', 'R');
                    $this->db->update('allotment_cert_basic', ['adc_code' => $officer_to]);
                }

            }

            // Update the total_updated_rows for the 'settlement_basic' table

        }else if ($service_code_name == 5) {

            // Check and update in the 'proposal_meeting_list' table
            $this->db->where('dc_adc_code', $from_officer);
            $this->db->where('dist_code', $this->session->userdata('dist_code'));
            $this->db->where('status', 'P');
            $query = $this->db->get('t_legacyupdation');
            $total_updated_rows += $query->num_rows();

            if ($query->num_rows() > 0) {
                // Update the 'allotment_cert_basic' table

                //check the es_flag and update the allotment_cert_basic table for all rows
                foreach ($query->result() as $row) {
                    if ($row->es_flag == 1) {
                        $this->db->where('dc_adc_code', $from_officer);
                        $this->db->where('status', 'P');
                        $query2 = $this->db->get('t_legacyupdation');
                        if ($query2->num_rows() > 0) {
                            // Update the 'allotment_cert_basic' table
                            $this->db->where('dc_adc_code', $from_officer);
                            $this->db->where('status', 'P');
                            $this->db->update('t_legacyupdation', ['dc_adc_code' => $officer_to]);
                        }

                    }
                    //Update the table alloment cert basic
                    $this->db->where('dc_adc_code', $from_officer);
                    $this->db->where('dist_code', $this->session->userdata('dist_code'));
                    $this->db->where('status', 'P');
                    $this->db->update('t_legacyupdation ', ['dc_adc_code' => $officer_to]);
                }

            }

            // Update the total_updated_rows for the 'settlement_basic' table

        }else if ($service_code_name == 6) {
    
            // Check and update in the 'proposal_meeting_list' table
            $this->db->where('user_code', $from_officer);
            $this->db->where('dist_code', $this->session->userdata('dist_code'));
            $this->db->where('status', 'P');
            $query = $this->db->get('petition_basic');
            $total_updated_rows += $query->num_rows();

            if ($query->num_rows() > 0) {
                // Update the 'allotment_cert_basic' table

                //check the es_flag and update the allotment_cert_basic table for all rows
                foreach ($query->result() as $row) {
                    $this->db->where('user_code', $from_officer);
                    $this->db->where('status', 'P');
                    $query2 = $this->db->get('petition_basic');
                    if ($query2->num_rows() > 0) {
                        // Update the 'allotment_cert_basic' table
                        $this->db->where('user_code', $from_officer);
                        $this->db->where('status', 'P');
                        $this->db->update('petition_basic', ['user_code' => $officer_to]);
                    }

                    
                    //Update the table alloment cert basic
                    $this->db->where('bo_code', $from_officer);
                    $this->db->where('dist_code', $this->session->userdata('dist_code'));
                    $this->db->where('status != ' , 'F');
                    $this->db->update('allotment_cert_basic ', ['bo_code' => $officer_to]);
                }

            }

            // Update the total_updated_rows for the 'settlement_basic' table


        }


        // 5. Insert into the transfer_history table
        $transfer_history_data = [
            'master_services_for_transfercase_id' => $service_code_name,
            'transfer_from'                       => $from_officer,
            'transfer_to'                         => $officer_to,
            'total_transfer_case_number'          => $total_updated_rows,                   // Total rows updated in 'settlement_basic'
            'trn_user'                            => $this->session->userdata('user_name'), // The user who performed the transfer
        ];

        $this->db->insert('case_transfer_history', $transfer_history_data);

        // echo $this->db->last_query(); die;

        // 6. Complete the transaction
        $this->db->trans_complete();

        // 7. Check if the transaction was successful
        if ($this->db->trans_status() === false) {
            // Something went wrong, rollback the transaction
            echo json_encode(['status' => 'error', 'message' => 'Error during the transfer process']);
        } else {
            // Success, commit the transaction
            echo json_encode(['status' => 'success', 'message' => 'Cases  Transferred to Officer successfully', 'total_transfer_case_number' => $total_updated_rows]);
        }
    }

}
