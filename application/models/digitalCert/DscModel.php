<?php

class DscModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function dbswitch()
    {
        //$CI=&get_instance();
        if ($this->session->userdata('dist_code') == "02") {
            $this->db = $this->load->database('dha3', TRUE);
        } else if ($this->session->userdata('dist_code') == "05") {
            $this->db = $this->load->database('dha1', TRUE);
        } else if ($this->session->userdata('dist_code') == "10") {
            $this->db = $this->load->database('dha24', TRUE);
        } else if ($this->session->userdata('dist_code') == "13") {
            $this->db = $this->load->database('dha2', TRUE);
        } else if ($this->session->userdata('dist_code') == "17") {
            $this->db = $this->load->database('dha4', TRUE);
        } else if ($this->session->userdata('dist_code') == "15") {
            $this->db = $this->load->database('dha5', TRUE);
        } else if ($this->session->userdata('dist_code') == "14") {
            $this->db = $this->load->database('dha6', TRUE);
        } else if ($this->session->userdata('dist_code') == "07") {
            $this->db = $this->load->database('dha7', TRUE);
        } else if ($this->session->userdata('dist_code') == "03") {
            $this->db = $this->load->database('dha8', TRUE);
        } else if ($this->session->userdata('dist_code') == "18") {
            $this->db = $this->load->database('dha9', TRUE);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', TRUE);
        } else if ($this->session->userdata('dist_code') == "24") {
            $this->db = $this->load->database('dha10', TRUE);
        } else if ($this->session->userdata('dist_code') == "06") {
            $this->db = $this->load->database('dha11', TRUE);
        } else if ($this->session->userdata('dist_code') == "11") {
            $this->db = $this->load->database('dha12', TRUE);
        } else if ($this->session->userdata('dist_code') == "12") {
            $this->db = $this->load->database('dha13', TRUE);
        } else if ($this->session->userdata('dist_code') == "16") {
            $this->db = $this->load->database('dha14', TRUE);
        } else if ($this->session->userdata('dist_code') == "32") {
            $this->db = $this->load->database('dha15', TRUE);
        } else if ($this->session->userdata('dist_code') == "33") {
            $this->db = $this->load->database('dha16', TRUE);
        } else if ($this->session->userdata('dist_code') == "34") {
            $this->db = $this->load->database('dha17', TRUE);
        } else if ($this->session->userdata('dist_code') == "21") {
            $this->db = $this->load->database('dha18', TRUE);
        } else if ($this->session->userdata('dist_code') == "08") {
            $this->db = $this->load->database('dha19', TRUE);
        } else if ($this->session->userdata('dist_code') == "35") {
            $this->db = $this->load->database('dha20', TRUE);
        } else if ($this->session->userdata('dist_code') == "36") {
            $this->db = $this->load->database('dha21', TRUE);
        } else if ($this->session->userdata('dist_code') == "37") {
            $this->db = $this->load->database('dha22', TRUE);
        } else if ($this->session->userdata('dist_code') == "25") {
            $this->db = $this->load->database('dha23', TRUE);
        }
    }

    public function add_update_dsc()
    {
        $this->dbswitch();

        $data = $this->input->post();
        $name = $data['cname'];
        $serial_no = $data['serialNum'];
        $valid_from = date('Y-m-d', strtotime($data['validFrom']));
        $valid_to = date('Y-m-d', strtotime($data['validTo']));
        $certificate = $data['cert'];
        $status = $data['sts'];

        // check if serial no and certificate exists
        $check_cert = $this->db->get_where('digital_certificate', array('serial_no' => $serial_no, 'certificate' => $certificate))->row();

        if (empty($check_cert)) {
            // save new certificate
            $db_data = array(
                 'name' => $name,
                'serial_no' => $serial_no,
                'valid_from' => $valid_from,
                'valid_to' => $valid_to,
                'certificate' => $certificate,
                'status' => $status
            );

            $insert = $this->db->insert('digital_certificate', $db_data);
            if ($insert) {
                $result = array(
                    'status' => 1,
                    'msg' => 'Digital signature certificate saved successfully'
                );
            } elseif (!$insert) {
                $result = array(
                    'status' => 0,
                    'msg' => 'Unable to save digital certificate',
                    'error_code' => '#DIGCERT0001'
                );
                log_message('Error', 'unable to save data in table digital_certificate. Error code: #DIGCERT0001');
            }
        } elseif (!empty($check_cert) > 0) {
            $db_data = array(
                'name' => $name,
                'valid_from' => $valid_from,
                'valid_to' => $valid_to,
                'status' => $status
            );

            $this->db->update('digital_certificate', $db_data);

            if ($this->db->affected_rows() > 0) {
                $result = array(
                    'status' => 1,
                    'msg' => 'Digital signature certificate data updated successfully'
                );
            } elseif ($this->db->affected_rows() <= 0) {
                $result = array(
                    'status' => 0,
                    'msg' => 'Unable to update digital certificate',
                    'error_code' => '#DIGCERT0002'
                );
                log_message('Error', 'unable to update data in table digital_certificate. Error code: #DIGCERT0002');
            }
        }

        return $result;
    }

    public function test()
    {
        $this->load->view('dsc/dscSign');
    }
}
