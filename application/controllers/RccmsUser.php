<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class RccmsUser extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->library(['session']);
        $this->load->helper(['url', 'security', 'custom']);
    }

    public function index() {
        $jwt = new JWT();
        $key = "abcd123haryanasinglesigonapplicationDFFEFSDAFE";
        $session = $_SESSION['credentials'];
        if (empty($session)) {
            echo json_encode(['resonponseType'=>2, 'status'=>'n', 'message'=>'Session expired']);
            return;
        }

        $dist_code     = $this->session->userdata('dist_code');
        $subdiv_code   = $this->session->userdata('subdiv_code');
        $cir_code      = $this->session->userdata('cir_code');
        $user          = $session['username'];
        $user_code     = $this->session->userdata('user_code');

        // Ensure your database.php has groups for each region if needed
        // Fetch login and user info
        $query = $this->db->query("
            SELECT permission_allowed, parent_code, u.user_desig_code, u.user_code, u.username 
            FROM loginuser_table lg 
            JOIN users u 
              ON u.user_code=lg.user_code 
             AND lg.dist_code=u.dist_code 
             AND lg.subdiv_code=u.subdiv_code 
             AND lg.cir_code=u.cir_code 
            WHERE lg.use_name=? 
              AND lg.dis_enb_option='E' 
              AND lg.dist_code=? 
              AND lg.subdiv_code=? 
              AND lg.cir_code=? 
              AND lg.permission_allowed IS NOT NULL
        ", [$user, $dist_code, $subdiv_code, $cir_code]);
        $row = $query->row_array();
        if (!$row) {
            echo json_encode(['resonponseType'=>2, 'status'=>'n']);
            return;
        }
        if ($row['user_desig_code'] != 'DC' && empty($row['permission_allowed'])) {
            echo json_encode(['resonponseType'=>2, 'status'=>'n']);
            return;
        }
        // Determine office type for parent user
        $DC_OFFICE_USER = ['DDA','ADA','DC','ADC'];
        $CO_OFFICE_USER = ['CO','AST','CDA'];
        $row1 = null;

        if (in_array($row['user_desig_code'], $DC_OFFICE_USER)) {
            $query1 = $this->db->query("
                SELECT use_name 
                FROM loginuser_table 
                WHERE dist_code=? 
                  AND subdiv_code='00' 
                  AND user_code=? 
                  AND dis_enb_option='E'
            ", [$dist_code, $row['parent_code']]);
            $row1 = $query1->row_array();
        } elseif (in_array($row['user_desig_code'], $CO_OFFICE_USER)) {
            $query1 = $this->db->query("
                SELECT use_name 
                FROM loginuser_table 
                WHERE dist_code=? 
                  AND subdiv_code=? 
                  AND cir_code=? 
                  AND user_code=? 
                  AND dis_enb_option='E'
            ", [$dist_code, $subdiv_code, $cir_code, $row['parent_code']]);
            $row1 = $query1->row_array();
        }
        // LGD info
        $query2 = $this->db->query("
            SELECT lgd_code, uuid, 
                   (SELECT lgd_code FROM location 
                    WHERE dist_code=ll.dist_code AND subdiv_code='00') AS dist_lgd_code
            FROM location ll 
            WHERE dist_code=? 
              AND subdiv_code=? 
              AND cir_code=? 
              AND mouza_pargona_code='00'
        ", [$dist_code, $subdiv_code, $cir_code]);
        $row2 = $query2->row_array();

        // Prepare payload for JWT
        $payload = [
            "Sub" => "logintoken",
            "UserName" => $user,
            "Dist_code" => $row2['dist_lgd_code'] ?? '',
            "Cir_code" => $row2['uuid'] ?? '',
            "Name" => $row['username'],
            "Designation" => $row['user_desig_code'],
            "UserCode" => $row['user_code'],
            "ParentUserCode" => $row['parent_code'],
            "ParentUserName" => $row1['use_name'] ?? 'NA',
            "UserStatusUpdated" => null,
            "Client_IP" => $this->get_client_ip(),
            "Sess_out" => DHARITREE_LINK
        ];
        // Generate JWT
        $jwt = $jwt->encode($payload, $key, 'HS256');
        // $jwt = JWT::encode($payload, $key, 'HS256');
        log_message('info', "USERID###{$user}###JWT###{$jwt}");

        // Insert into central_auth using secondary connection
        $central_db = $this->load->database('auth', TRUE);
        $central_db->insert('rccms_tokens', [
            'date_entry' => date('Y-m-d H:i:s'),
            'user_code'  => $user,
            'token'      => $jwt,
            'ip'         => $this->get_client_ip()
        ]);
        if ($central_db->affected_rows() <= 0) {
            log_message('error', "TOKEN-INSERTION-FAILED###" . $jwt);
            echo json_encode(['resonponseType'=>2, 'status'=>'n']);
            return;
        }
        echo json_encode(['resonponseType'=>2, 'status'=>'y', 'token'=>$jwt]);
    }
    function get_client_ip()
    {
        $ipaddress = '';
        if (isset($_SERVER['HTTP_CLIENT_IP']))
          $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
        else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
          $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_X_FORWARDED']))
          $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
        else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
          $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
        else if (isset($_SERVER['HTTP_FORWARDED']))
          $ipaddress = $_SERVER['HTTP_FORWARDED'];
        else if (isset($_SERVER['REMOTE_ADDR']))
          $ipaddress = $_SERVER['REMOTE_ADDR'];
        else
          $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
    function validateUser(){
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // RCCMS API URL
            // $url = RCCMS;
            // $token = $_POST["jwt"] ?? "";
            // $postData = [
            //     "jwt" => $_POST["jwt"] ?? ""
            // ];
            $url = "https://rccms.assam.gov.in/rccms_live/v1/ssoLogin/userLoginSso";
            $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJTdWIiOiJsb2dpbnRva2VuIiwiVXNlck5hbWUiOiJjby1w
b3BpIiwiRGlzdF9jb2RlIjoiMjk1IiwiQ2lyX2NvZGUiOiIxMDAwMDAwMDAwNzEyMSIsIk5hbWUiOiJcdTA5YWFcdTA5YWFcdTA5YzAgXHUwOWFiXHUwOWMxXHUwOTk1XHUwOWE4I
iwiRGVzaWduYXRpb24iOiJDTyIsIlVzZXJDb2RlIjoiQ08yNyIsIlBhcmVudFVzZXJDb2RlIjoiQURDMTEiLCJQYXJlbnRVc2VyTmFtZSI6Ik5BIiwiVXNlclN0YXR1c1VwZGF0ZW
QiOm51bGwsIkNsaWVudF9JUCI6IjE0MS4xNDguMjA5LjIxMyIsIlNlc3Nfb3V0IjoiaHR0cHM6XC9cL2RoYXJpdHJlZS5hc3NhbS5nb3YuaW5cLyJ9.qn-OuSPk9V-Pfdhst2AY0z
AEdZdJboKptxh0DVkvLFc";
            $postData=[
                "jwt" => $token
            ];
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                "Authorization: Bearer $token",
                "Content-Type: application/json"
            ]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($postData));
            $response = curl_exec($ch);
            if (curl_errno($ch)) {
                echo 'Error: ' . curl_error($ch);  
            }
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            log_message("error","API-RCCMS".$response);
            $data = json_decode($response, true);
            //var_dump($data);
            if ($httpCode !== 200 || empty($data)) {
                die("Error: Invalid response from RCCMS server.");
            }
            $redirectUrl = $data["redirectUrl"];
            header("Location: " . $redirectUrl);
            exit();
        }
    }
}
