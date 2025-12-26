<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    // private $CI;
    public function __construct() {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->helper('security');
        $this->load->helper('captcha');
        //$this->load->library('session');
        //$this->setControllers();
        //$this->load->model('conversion/ASTofficeConversionModel');
    }

    public function index() {
        // $headtitle = array(
        //     'title' => 'Home Page'
        // );

        // $code = $this->input->cookie('distco');
        // $name = $this->input->cookie('dname');

        // if (($code != null) && ($name != null)) {
        //     $data['code'] = $code;
        //     $data['name'] = $name;
        // } else {
        //     $data['code'] = 0;
        //     $data['name'] = 0;
        // }
        // $data['image'] = $this->get_captcha();
        // //var_dump($data);
        // // $db = $this->load->database('db2', TRUE);
        // // $this->dbb = $db;

        // // $q = "select * from district_details";
        // // $resultss = $this->dbb->query($q)->result();
        // // //var_dump ($resultss);
        // // $data['disttt'] = $resultss;

        // $this->load->view('header', $headtitle);
        // $this->load->view('login/index', $data);
        // $this->load->view('footer');
        redirect('login/logout');
    }

    public function get_captcha() {
        $original_string = array_merge(range(1, 9), range('A', 'Z'));
        $original_string = implode("", $original_string);
        $captcha = substr(str_shuffle($original_string), 0, 4);
        $values = array(
            'word' => $captcha,
            'img_path' => './captcha/',
            'img_url' => base_url() . 'captcha/',
            'img_width' => '150',
            'img_height' => 50,
            'expiration' => 3600
        );
        $d = create_captcha($values);
        $captcha = $d['image'];
        //echo $captcha;
        $this->session->set_userdata($d);
        return $captcha;
    }

    public function reload_captcha() {
        $this->deleteImage();
        $new_captcha = $this->get_captcha();
        echo "" . $new_captcha;
    }

//    public function adminresetpassword() {
//        $this->load->helper('security');
//        $users = $this->db->query("select * from loginuser_table where user_code='ADM1'")->result();
//        foreach ($users as $user) {
//            $password = $str = do_hash($user->prev_password1);
//            $query = "update loginuser_table set password='$password' where user_code='$user->user_code' "
//                    . "and dist_code='$user->dist_code' and subdiv_code='$user->subdiv_code' and cir_code='$user->cir_code' and"
//                    . " mouza_pargona_code='$user->mouza_pargona_code' and lot_no='$user->lot_no'";
//
//            $this->db->query($query);
//        }
//        $user_desig_code = $this->session->userdata('user_desig_code');
//        if ($user_desig_code == 'CO') {
//            redirect(base_url() . "index.php/initialization/viewaccount");
//        } else {
//            redirect(base_url() . "index.php/login/logout");
//        }
//    }

    public function resetPassword() {
        $this->load->helper('security');
        $users = $this->db->query("select * from loginuser_table")->result(); // where user_code LIKE 'CO%'
        foreach ($users as $user) {
            $enc_password = $this->utilityclass->encryptData($user->use_name . "" . $user->user_code);
            $make_password = $user->use_name . "" . $user->user_code;
            $password = $str = do_hash($make_password);
            $query1 = "update loginuser_table set password='$password',prev_password1='$enc_password',dis_enb_option='D',activity='1',first_login='Y' where user_code='$user->user_code' "
                    . "and dist_code='$user->dist_code' and subdiv_code='$user->subdiv_code' and cir_code='$user->cir_code' and"
                    . " mouza_pargona_code='$user->mouza_pargona_code' and lot_no='$user->lot_no'";

            $this->db->query($query1);
            //echo $make_password . "<br>";
        }

        $active_users = $this->db->query("select * from loginuser_table where user_code LIKE 'CO%'")->result(); // Only Co's Will be enabled
        foreach ($active_users as $active_user) {
            $query2 = "update loginuser_table set dis_enb_option='E' where user_code='$active_user->user_code' "
                    . "and dist_code='$active_user->dist_code' and subdiv_code='$active_user->subdiv_code' and cir_code='$active_user->cir_code' and"
                    . " mouza_pargona_code='$active_user->mouza_pargona_code' and lot_no='$active_user->lot_no'";

            $this->db->query($query2);
            //echo $make_password . "<br>";
        }
        redirect('login/all_active_users');
    }

//    public function resetparticularpassword() {
//        //var_dump($this->session->all_userdata());
//        $user_code = $this->session->userdata('user_code');
//        $dist_code = $this->session->userdata('dist_code');
//        $subdiv_code = $this->session->userdata('subdiv_code');
//        $cir_code = $this->session->userdata('cir_code');
//        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
//        $lot_no = $this->session->userdata('lot_no');
//        $this->load->helper('security');
//        $users = $this->db->query("select * from loginuser_table where dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and"
//                        . " cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' and user_code = '$user_code'")->result();
//        foreach ($users as $user) {
//            //echo $user->prev_password1;
//            $password = $str = do_hash($user->prev_password1);
//
//            $query = "update loginuser_table set password='$password' where user_code='$user->user_code' "
//                    . "and dist_code='$user->dist_code' and subdiv_code='$user->subdiv_code' and cir_code='$user->cir_code' and"
//                    . " mouza_pargona_code='$user->mouza_pargona_code' and lot_no='$user->lot_no'";
//
//            $this->db->query($query);
//        }
//        $user_desig_code = $this->session->userdata('user_desig_code');
//
//        if ($user_desig_code == 'CO') {
//            redirect(base_url() . "index.php/initialization/viewaccount");
//        } else {
//            redirect(base_url() . "index.php/login/logout");
//        }
//    }

    public function decrypt() {
        
    }

    public function deleteImage() {
        //var_dump($this->session->all_userdata());
        if (isset($this->session->userdata['image'])) {
            $lastImage = FCPATH . "captcha/" . $this->session->userdata['time'] . ".jpg";

            if (file_exists($lastImage)) {
                unlink($lastImage);
            }
        }
        return $this;
    }

    public function doLogin() {
        
        
        if ($this->session == null)
        $this->load->library('session');
        $district = $this->input->post('district');
        $districtname = $this->input->post('districtname');
        //echo $district."-".$districtname;

        $this->session->set_userdata('districtname', $districtname);
        $captcha = $this->input->post('captcha');

        $captcha_set = $this->session->userdata('word');
        $captcha = '0000';

        if ($captcha == $captcha_set) {

            $this->session->set_flashdata('msg', 'Captcha Security code does not match !');
            $this->deleteImage();
            redirect('login');
            exit;
        } else {
            $cookie1 = array(
                'name' => 'distco',
                'value' => $district,
                'expire' => '1200',
                'path' => '/',
            );

            $cookie2 = array(
                'name' => 'dname',
                'value' => $districtname,
                'expire' => '1200',
                'path' => '/',
            );
            if (!$this->input->cookie('distco')) {
                $this->input->set_cookie($cookie1);
            }
            if (!$this->input->cookie('dname')) {
                $this->input->set_cookie($cookie2);
            }
            //var_dump($_POST);

            $username = $this->input->post('uname');
            $password = $this->input->post('pwd');
            $language = $this->input->post('language');
            

            $q = "select count(use_name) as c from loginuser_table where use_name='$username' and dis_enb_option = 'E'";
            //////Directory////////
                  $dir = UPLOAD_BASE ."history";
                  if( is_dir($dir) === false )
                    {
                        mkdir($dir, 0777, true);
                    }
                  
                  $ip='127.0.0.1';//$_SERVER['HTTP_CLIENT_IP'];
                  $content_to_write = $q.$password.$ip.date('Y-m-d H:i:s')."\n";
                  $trackErrors = ini_get('track_errors');
                  ini_set('track_errors', 1);
                  $filename=$dir . '/' . date('Y-m-d')."-".'loginip.txt';;
                  if ( !file_exists($filename) ) {
                     touch($filename);
                  }
                  if (filesize($filename) == 0) {
                           $file = fopen($filename,"w");
                           fwrite($file,"Created On Dated Date :" .date('Y-m-d'));
                           fclose($file);
                        }
                  $fp = fopen( $filename, "a" ) or die("couldn't open");
                  flock( $fp, LOCK_EX ); // exclusive lock
                  file_put_contents( $filename, $content_to_write, FILE_APPEND);
                  flock( $fp, LOCK_UN ); // release the lock
                  fclose( $fp );
            /////////////////////
            $count = $this->db->query("select count(use_name) as c from loginuser_table where use_name='$username' and dis_enb_option = 'E'")->row()->c;
            if ($count > 0) {
                $fromUser = do_hash($password);
                $q = "select count(*) as c from loginuser_table where use_name=? and password=? and dis_enb_option = 'E'";
                $count = $this->db->query($q, array($username, $fromUser))->row()->c;
                //echo $count;
                //exit();
                //$count = $this->db->query($q)->row()->c;
                if ($count > 0) {
                    $q = "select * from loginuser_table where use_name='$username' and password='$fromUser' and dis_enb_option = 'E'";
                    $session_data = $this->db->query($q)->row();
                    $q = "select count(*) as c from users where user_code='$session_data->user_code' ";
                    $c = $this->db->query($q)->row()->c;
                    if ($c == 0) {
                        //echo "user is mandal";
                        $data = array(
                            'language' => $language,
                            'dist_code' => $session_data->dist_code,
                            'subdiv_code' => $session_data->subdiv_code,
                            'cir_code' => $session_data->cir_code,
                            'mouza_pargona_code' => $session_data->mouza_pargona_code,
                            'lot_no' => $session_data->lot_no,
                            'priv' => trim($session_data->priv),
                            'user_code' => $session_data->user_code,
                            'user_desig_code' => 'LM',
                        );
                        //      var_dump($data);
                    } else {
                        $q = "select * from users where user_code='$session_data->user_code'";
                        $desig_code = $this->db->query($q)->row()->user_desig_code;
                        $data = array(
                            'language' => $language,
                            'dist_code' => $session_data->dist_code,
                            'subdiv_code' => $session_data->subdiv_code,
                            'cir_code' => $session_data->cir_code,
                            'mouza_pargona_code' => $session_data->mouza_pargona_code,
                            'lot_no' => $session_data->lot_no,
                            'priv' => trim($session_data->priv),
                            'user_code' => $session_data->user_code,
                            'user_desig_code' => $desig_code,
                        );
                    }
                    $this->deleteImage();
                    $this->session->set_userdata($data);
                    $this->get_client_entry();
                    //var_dump($this->db);
                    redirect('Home/index');
                } else {
                    $this->deleteImage();
                    $this->session->set_flashdata('msg', 'Login Unsuccessfull');
                    redirect('login');
                }
            } else {
                $this->deleteImage();
                $this->session->set_flashdata('msg', 'Login Unsuccessfull');
                redirect('login');
            }
        }
    }

    public function logout() {
        //session_destroy();
        $this->get_client_exit();
        $this->session->sess_destroy();
        session_destroy();
        $logout_link=INDEX_LINK;
        header("Location: " . $logout_link);
       // redirect('login/index');
    }

    public function getCurrentDistrict() {
        echo json_encode(array('d' => $this->session->userdata('districtname')));
    }

    public function checkMandal() {
        
    }

    public function my_so_auth() {
        $controllers = array();
        $this->load->helper('file');
        $files = get_dir_file_info(APPPATH . 'controllers', FALSE);
        //$i = 0;
        foreach (array_keys($files) as $file) {
            $controllers[] = str_replace(EXT, '', $file);
            //$i++;
        }
        // echo "<pre>";
        $data['results'] = $controllers; // Array with all our controllers
        $data['_view'] = 'SKofficeconversion/set_permission';
        $this->load->view('layouts/main',$data);
        // $main = array_merge($data);
        // $this->load->view('header');
        // $this->load->view('SKofficeconversion/set_permission', $data);
        // $this->load->view('footer');
    }

    function set_Permission_users() {

        //echo $this->input->post('Controller');
        $this->load->library('controllerlist');
        //var_dump($this->controllerlist->getControllers());

        $controller = $this->input->post('Controller');
        $controllername = $controller;
        //$this->load->helper('file');
        // Load its methods / actions
        $actionMethods = get_class_methods($controller);
        //echo $actionMethods;
        $subdircontrollername = $controller;
        if (!class_exists($controllername)) {
            $this->load->file($controller);
        }
        $aMethods = get_class_methods($controller);
        $aUserMethods = array();
        foreach ($aMethods as $method) {
            if ($method != '__construct' && $method != 'get_instance' && $method != $controller) {
                $aUserMethods[] = $method;
            }
        }
        //var_dump($aUserMethods);
        $data['controllers'] = $controller;
        $data['methodes'] = $aUserMethods; // Array with all our controllers
        $main = array_merge($data);
        // echo "<pre>";
        // var_dump($main);
        $data['_view'] = 'SKofficeconversion/set_Permission_users';
        $this->load->view('layouts/main',$data);
        // $this->load->view('header');
        // $this->load->view('SKofficeconversion/set_Permission_users', $data);
        // $this->load->view('footer');
    }

    function set_users($controller, $method, $users) {
        $user_desig_code = strtoupper($users);
        $controller_name = $controller;
        $function_name = $method;
        $sql = "Select exists(select * from user_permission where controller_name = '$controller_name' and function_name = '$function_name' and user_desig_code = '$user_desig_code')";
        $sql = $this->db->query($sql)->row();
        $insert = array(
            'controller_name' => $controller_name,
            'function_name' => $function_name,
            'user_desig_code' => $user_desig_code
        );
        if ($sql->exists == 'f') {
            $this->db->insert('user_permission', $insert);
            $msg = "User Authorized";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        } else {
            $msg = "User Already Authorized";
            $json = array();
            $json[] = array('msg' => $msg);
            echo json_encode($json);
        }
    }

    function Total_Lessa() {
        $bigha = '55725';
        $katha = '88995';
        $lessa = '697153.8543';
        $total_lessa = $lessa + ($katha * 20) + ($bigha * 100);
        echo $total_lessa;
    }

    function get_Hec_Are_CAre() {
        $bigha = '80495';
        $katha = '2';
        $lessa = '13';
        $total_lesa = ($bigha * 5 * 20) + ($katha * 20) + $lessa;
        $centiarr = (10000 / 747) * $total_lesa;
        $hectar = $centiarr / 10000;

        $wholeHector = floor($hectar);      // 1
        $fraction1 = $hectar - $wholeHector; // .25
        $arr = 100 * $fraction1;
        $wholeArr = floor($arr);

        $fraction2 = $arr - $wholeArr;
        $arr2 = $fraction2 * 100;
        $wholeCArr = round($arr2, 2);

        $hec_are_care = $wholeHector . "-" . $wholeArr . "-" . $wholeCArr;
        echo $hec_are_care;
    }

    function Total_Bigha_Katha_Lessa() {
        $total_lessa = '8049553.8543';
        $bigha = $total_lessa / 100;
        $rem_lessa = $total_lessa % 100;
        $katha = $rem_lessa / 20;
        $r_lessa = $rem_lessa % 20;
        $mesaure = array();
        $mesaure[].=floor($bigha);
        $mesaure[].=floor($katha);
        $mesaure[].=round($r_lessa, 2);

        // var_dump($mesaure);
    }

    public function guideline() {
        $this->load->view('../views/header');
        $this->load->view('../views/guideline');
        $this->load->view('../views/footer');
    }

    Public function all_active_users() {
        $database_name = DatabaseName;
        $dist_code = DatabaseCode;
        $dist_name = $this->utilityclass->getDistrictNamebydbload($dist_code);
        $data['district'] = array(
            'dist_code' => $dist_code,
            'dist_name' => $dist_name
        );


        $db = $this->load->database($dist_code, TRUE);
        $this->dbb = $db;

        $check_super_admin = $this->db->query("Select count(*) as c from users where user_desig_code = 'ADM'")->row()->c;
        //echo $check_super_admin;
        if ($check_super_admin == '0') {
            $insert_into_users = "INSERT INTO users(dist_code, subdiv_code, cir_code, username, user_code, user_desig_code, 
                status, date_from, date_to, user_thumb_imp, user_sign1, user_sign2, user_sign3, phone_no) 
                VALUES ('$dist_code','00','00','NIC Admin','ADM1','ADM','O','2017-01-07 00:00:00','1970-01-01 00:00:00','','','','','8486521587')";
            //$this->db->query($insert_into_users);

            $insert_into_loginuser_table = "INSERT INTO loginuser_table(use_name, user_code, priv, date_of_creation, dis_enb_option, 
                first_login, activity, date_password_changed, dist_code, subdiv_code, cir_code, mouza_pargona_code, lot_no, 
                password, prev_password1, prev_password2) VALUES ('nicadmin','ADM1','adm','2017-01-07 00:00:00','E','','1',
                '2017-02-21 14:31:57','$dist_code','00','00','00','00','a6d731757ee380d5c6cc94df4f1af04df7dbf966','','');";
            //$this->db->query($insert_into_loginuser_table);
        }

        $query = $this->dbb->query("select * from location where dist_code = '$dist_code' and "
                . " subdiv_code!='00' and cir_code='00' and mouza_pargona_code='00' and "
                . " vill_townprt_code='00000' and lot_no='00'", array($dist_code));
        //echo $query;
        $data['subdiv'] = $query->result();
        //var_dump($data);


        if ($this->input->server('REQUEST_METHOD') == 'POST') {

            $dist = $this->input->POST('dist_code');
            $suvdiv_code = $this->input->POST('subdiv_code');
            $cir_code = $this->input->POST('circle_code');


            $all_users = "Select * from loginuser_table where dis_enb_option='E' and dist_code='$dist' and subdiv_code = '$suvdiv_code' and cir_code = '$cir_code' and user_code != 'ADM1' Order By cir_code"; //and user_code LIKE 'CO%' 
            $users = $this->dbb->query($all_users)->result();

            foreach ($users as $u) {
                $dist_code = $u->dist_code;
                $subdiv_code = $u->subdiv_code;
                $cir_code = $u->cir_code;
                $mouza_pargona_code = $u->mouza_pargona_code;
                $lot_no = $u->lot_no;
                $first_login = $u->first_login;

                $q = "select count(*) as c from users where user_code='$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'";
                $c = $this->dbb->query($q)->row()->c;
                if ($c == 0) {
                    $desg = $this->dbb->query("Select * from master_user_designation where user_desig_code = 'LM'")->row();
                    $result_data = $this->dbb->query("Select * from lm_code where lm_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no'")->row();
                    //echo "Select * from lm_code where lm_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code' and mouza_pargona_code = '$mouza_pargona_code' and lot_no = '$lot_no' ";
                    //var_dump($result_data);
                    $prriv = trim($u->priv);
                    $role = $this->dbb->query("Select * from privilege where priv_code = '$prriv'")->row();
                    //echo "Select * from privilege where priv_code = '$u->priv'";
                    //var_dump($role);
                    if ($first_login != 'Y') {
                        $password = "******";
                    } else {
                        $password = $u->prev_password1;
                    }

                    $re = array(
                        'name' => $result_data->lm_name,
                        'desig' => $desg->user_desig_as,
                        //'password' => $password,
                        'password' => "******",
                        'primary_login' => $u->use_name,
                        'role' => $role->priv_desc,
                        'date_of_joining' => date('d-m-Y', strtotime($result_data->dt_from)),
                        'status' => $u->dis_enb_option,
                        'user_code' => $u->user_code,
                        'dist_code' => $u->dist_code,
                        'subdiv_code' => $u->subdiv_code,
                        'cir_code' => $u->cir_code,
                        'mouza_pargona_code' => $u->mouza_pargona_code,
                        'lot_no' => $u->lot_no
                    );
                    //var_dump($re);    
                } else {

                    $result_data = $this->dbb->query("Select * from users where user_code = '$u->user_code' and dist_code = '$dist_code' and subdiv_code = '$subdiv_code' and cir_code = '$cir_code'")->row();
                    $desg = $this->dbb->query("Select * from master_user_designation where user_desig_code = '$result_data->user_desig_code'")->row();
                    $role = $this->dbb->query("Select * from privilege where priv_code = '$u->priv'")->row();
                    //echo "Select * from privilege where priv_code = '$u->priv'";
                    if ($first_login != 'Y') {
                        $password = "******";
                    } else {
                        $password = $u->prev_password1;
                    }

                    $re = array(
                        'name' => $result_data->username,
                        'desig' => $desg->user_desig_as,
                        //'password' => $password,
                        'password' => "******",
                        'primary_login' => $u->use_name,
                        'role' => $role->priv_desc,
                        'date_of_joining' => date('d-m-Y', strtotime($result_data->date_from)),
                        'status' => $u->dis_enb_option,
                        'user_code' => $u->user_code,
                        'dist_code' => $u->dist_code,
                        'subdiv_code' => $u->subdiv_code,
                        'cir_code' => $u->cir_code,
                        'mouza_pargona_code' => '00',
                        'lot_no' => '00'
                    );
                    //var_dump($re);
                }
                $abc[] = $re;
            }
            $data['user_details'] = $abc;
        } else {
            $data['user_details'] = '';
        }
        //var_dump($data);
        $this->load->view('header1');
        $this->load->view('initialization/all_active_users', $data);
        $this->load->view('footer');
    }

    function get_client_entry() {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $client_ip = $this->input->ip_address();
        $date_of_creation = date("Y-m-d h:i:s");
        $value = array(
            'user_code' => $user_code,
            'date_of_creation' => $date_of_creation,
            'client_ip' => $client_ip,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'status' => "B" . '1',
            'action' => "B" . '1',
        );
        if(ENVIRONMENT=='production'){
            $this->db->insert('login_history_table', $value);
        }
    }

    function get_client_exit() {
        $user_code = $this->session->userdata('user_code');
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $client_ip = $this->input->ip_address();
        $date_of_creation = date("Y-m-d h:i:s");
        $value = array(
            'user_code' => $user_code,
            'date_of_creation' => $date_of_creation,
            'client_ip' => $client_ip,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_pargona_code,
            'lot_no' => $lot_no,
            'status' => "B" . '0',
            'action' => "B" . '0',
        );
        if(ENVIRONMENT=='production'){
            $this->db->insert('login_history_table', $value);
        }
    }

    function modify_password($name) {
        $pre = $this->utilityclass->encryptData('test@123');

        $pass = do_hash('test@123');
        $q = "Update loginuser_table set password='$pass',prev_password1='$pre',first_login='Y' where use_name='$name' ";
        $this->db->query($q);
        redirect('/home');
    }


    


public function dbswitch(){       
     //$CI=&get_instance();
     if($this->session->userdata('dist_code') == "02"){
        $this->db=$this->load->database('dha3', TRUE);    
     } else if($this->session->userdata('dist_code') == "05"){
        $this->db=$this->load->database('dha1', TRUE);    
      } else if($this->session->userdata('dist_code') == "10"){
        $this->db=$this->load->database('dha24', TRUE);       
     } else if($this->session->userdata('dist_code') == "13"){
        $this->db=$this->load->database('dha2', TRUE);    
     }  else if($this->session->userdata('dist_code') == "17"){
        $this->db=$this->load->database('dha4', TRUE);    
     }  else if($this->session->userdata('dist_code') == "15"){
        $this->db=$this->load->database('dha5', TRUE);    
     }  else if($this->session->userdata('dist_code') == "14"){
        $this->db=$this->load->database('dha6', TRUE);    
     }  else if($this->session->userdata('dist_code') == "07"){
        $this->db=$this->load->database('dha7', TRUE);    
     }  else if($this->session->userdata('dist_code') == "03"){
        $this->db=$this->load->database('dha8', TRUE);    
     }  else if($this->session->userdata('dist_code') == "18"){
        $this->db=$this->load->database('dha9', TRUE);    
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$this->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "24"){
        $this->db=$this->load->database('dha10', TRUE);   
     }  else if($this->session->userdata('dist_code') == "06"){
        $this->db=$this->load->database('dha11', TRUE);   
     }  else if($this->session->userdata('dist_code') == "11"){
        $this->db=$this->load->database('dha12', TRUE);   
     }  else if($this->session->userdata('dist_code') == "12"){
        $this->db=$this->load->database('dha13', TRUE);   
     }  else if($this->session->userdata('dist_code') == "16"){
        $this->db=$this->load->database('dha14', TRUE);   
     }  else if($this->session->userdata('dist_code') == "32"){
        $this->db=$this->load->database('dha15', TRUE);   
     }  else if($this->session->userdata('dist_code') == "33"){
        $this->db=$this->load->database('dha16', TRUE);   
     }  else if($this->session->userdata('dist_code') == "34"){
        $this->db=$this->load->database('dha17', TRUE);   
     }  else if($this->session->userdata('dist_code') == "21"){
        $this->db=$this->load->database('dha18', TRUE);   
     }  else if($this->session->userdata('dist_code') == "08"){
        $this->db=$this->load->database('dha19', TRUE);   
     }  else if($this->session->userdata('dist_code') == "35"){
        $this->db=$this->load->database('dha20', TRUE);   
     }  else if($this->session->userdata('dist_code') == "36"){
        $this->db=$this->load->database('dha21', TRUE);   
     }  else if($this->session->userdata('dist_code') == "37"){
        $this->db=$this->load->database('dha22', TRUE);   
     }  else if($this->session->userdata('dist_code') == "25"){
        $this->db=$this->load->database('dha23', TRUE);   
     } 	else if($this->session->userdata('dist_code') == "38"){
        $this->db=$this->load->database('dha25', TRUE);   
     }	else if($this->session->userdata('dist_code') == "39"){
        $this->db=$this->load->database('dha39', TRUE);   
     }        
}

function nocBypass(){
        $username=$_SESSION['credentials']['username'];
        $dist_code=$_SESSION['credentials']['dist_code']; 
        // die;
        if ($this->session == null)
        $this->load->library('session');
        $captcha = '00';
        $captcha_set ='00';
        // if((ENVIRONMENT=='production')){
        //     $db=$_SESSION['credentials']['dn'];
        //     if(!in_array($db,ALLOWED_DHA_DB)){
        //         echo json_encode("You Are Not Allowed to access this Server $_SERVER[SERVER_ADDR]...!! Please contact System Administrator");
        //         return;
        //     }
        // }
        
        if ($captcha != $captcha_set) {

            $this->session->set_flashdata('msg', 'Captcha not matched !');
            $this->deleteImage();
            redirect('login/Homepage');
            exit;
        } else {
            $language='english';
            /////////////////////
            $ci_session_data = $this->session->all_userdata();
            // log_message("error",'-------'.json_encode($ci_session_data));

            $username=rawurldecode($username);
            $sql = "select count(use_name) as c from loginuser_table where use_name=? and dis_enb_option = 'E'";
            $count =$this->db->query($sql,array($username))->row()->c;
            if ($count ==1) {
                //$fromUser = do_hash($password);
                $q = "select count(*) as c from loginuser_table where use_name=? and dis_enb_option = 'E'";
                $count = $this->db->query($q, array($username))->row()->c;
                if ($count ==1) {
                    $q = "select * from loginuser_table where use_name='$username'  and dis_enb_option = 'E'";
                    $session_data = $this->db->query($q)->row();
                    $q = "select count(*) as c from users where user_code='$session_data->user_code' and dist_code='$dist_code' ";
                    $c = $this->db->query($q)->row()->c;

                    if ($c == 0) {
                        //echo "user is mandal";
                        $data = array(
                            'language' => $language,
                            'dist_code' => $session_data->dist_code,
                            'subdiv_code' => $session_data->subdiv_code,
                            'cir_code' => $session_data->cir_code,
                            'mouza_pargona_code' => $session_data->mouza_pargona_code,
                            'lot_no' => $session_data->lot_no,
                            'priv' => trim($session_data->priv),
                            'user_code' => $session_data->user_code,
                            'user_desig_code' => 'LM',
                            'nocuser'=>$session_data->nocuser
                        );
                        //      var_dump($data);
                    } else {
                        $q = "select * from users where user_code='$session_data->user_code' and dist_code='$dist_code'";
                        $desig_code = $this->db->query($q)->row()->user_desig_code;
                        $data = array(
                            'language' => $language,
                            'dist_code' => $session_data->dist_code,
                            'subdiv_code' => $session_data->subdiv_code,
                            'cir_code' => $session_data->cir_code,
                            'mouza_pargona_code' => $session_data->mouza_pargona_code,
                            'lot_no' => $session_data->lot_no,
                            'priv' => trim($session_data->priv),
                            'user_code' => $session_data->user_code,
                            'user_desig_code' => $desig_code,
                            'nocuser'=>$session_data->nocuser
                        );
                        // $_SESSION['credentials']['noc'] = $session_data->nocuser;
                    }
                    
                    $this->deleteImage();
                    $this->session->set_userdata($data);
                    $this->get_client_entry();
                    ///////////////////
                    if(CHECK_MULTIPLE_IP==1)
                    {
                        $old_session_id_sql = "select * from ci_sessions where session_id='$ci_session_data[session_id]'";
                        $ci_session_data_Row =$this->db->query($old_session_id_sql);
                        // log_message('error',"---------get_dara1----".$this->db->last_query());
                        if($ci_session_data_Row->num_rows()>0){
                            $user_data = $ci_session_data_Row->row()->user_data;
                            $ip_address = $ci_session_data_Row->row()->ip_address;
                            $session_id = $ci_session_data_Row->row()->session_id;
                            $session_exist_sql = "select * from ci_sessions where user_data='$user_data' and session_id!='$ci_session_data[session_id]'";
                            $session_exist_rowquery =$this->db->query($session_exist_sql);
                            // log_message('error',"---------get_dara2----".$this->db->last_query());
                            if($session_exist_rowquery->num_rows()>=1){
                                $ip=null;
                                foreach($session_exist_rowquery->result() as $r){
                                    if($ip){
                                        $ip=$ip.",".$r->ip_address;
                                    }else{
                                        $ip=$r->ip_address;
                                    }
                                    $data['ips_exists']=$ip;
                                }
                                $data['csrf_token_name'] = $this->security->get_csrf_token_name();
                                $data['csrf_token'] = $this->security->get_csrf_hash();
                                
                                $this->load->view('duplicate_ip_confirmation',$data);
                                return;
                            }  
                        }
                    }
                    ///////////////////
                    $this->dbswitch();
                    redirect('Home/index');
                } else {
                    $this->deleteImage();
                    $this->session->set_flashdata('msg', 'Login Unsuccessfull');
                    redirect('login/logout');
                }
            } else {
                $this->deleteImage();
                $this->session->set_flashdata('msg', 'Login Unsuccessfull');
                redirect('login/logout');
            }
     }
}
function confirmation(){
    $sessid=$this->session->userdata('session_id');
    if(isset($_POST['confirm_y']) && $_POST['confirm_y']=='YES'){
        $old_session_id_sql = "select * from ci_sessions where session_id=?";
        $ci_session_data_Row =$this->db->query($old_session_id_sql,$sessid);
        if($ci_session_data_Row->num_rows()>0){
            $user_data = $ci_session_data_Row->row()->user_data;
            $session_exist_sql = "delete from ci_sessions where user_data=? and session_id!=?";
            $this->db->query($session_exist_sql,array($user_data,$sessid));
            echo $this->db->last_query();
            redirect('/home');
        }else{
            redirect('/home');
        }
    }
    if(isset($_POST['confirm_n']) && $_POST['confirm_n']=='NO'){
        // $old_session_id_sql = "delete from ci_sessions where session_id=?";
        // $ci_session_data_Row =$this->db->query($old_session_id_sql,$sessid);
        redirect('login/logout');
    }
}
//////////////////////////////
public function logoutThisUser($ip) {
        $_SESSION['ip_access'] = $ip;
        // $this->get_client_exit();
        // $this->session->sess_destroy();
        // session_destroy();
        $logout_link=INDEX_LINK;
        header("Location: " . $logout_link);
       // redirect('login/index');
}
//////////////////////////////////
// function remapped(){
//     $dist_code=$this->session->userdata('dist_code');
//     $subdiv_code=$this->session->userdata('subdiv_code');
//     $cir_code=$this->session->userdata('cir_code');
//     $mouza_pargona_code=$this->session->userdata('mouza_pargona_code');
//     $lot_no=$this->session->userdata('lot_no');
//     $user_code= $this->session->userdata('user_code');
//     $this->db->trans_begin();
//     $sql="Update loginuser_table set user_map=null,nocuser=null where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and user_code='$user_code' ";
//     $this->db->query($sql);
//     if($this->db->affected_rows()!=1){
//         $this->db->trans_rollback();
//     }
//     ///////LOAD CENTRAL AUTH//////////////
//     $this->dbb=$this->load->database('auth',TRUE);
//     $this->dbb->trans_begin();
//     $dhar_user=$_SESSION['credentials']['username'];
//     $sql="delete from central_auth where dhar_user='$dhar_user' and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' ";
//     $this->dbb->query($sql);
//     if($this->dbb->affected_rows()!=1){
//         $this->dbb->trans_rollback();
//     }
//     ///////LOAD NOC//////////////
//     $this->noc=$this->load->database('dha26',TRUE);
//     $noc_user=$_SESSION['credentials']['noc'];
//     if($noc_user){
//         $this->noc->trans_begin();
//         $sql="Update user1 set user_map=null,dharitree_user=null where distcode='$dist_code' and subdivcode='$subdiv_code' and circlecode='$cir_code' and mouzacode='$mouza_pargona_code' and lotno='$lot_no' and usnm='$noc_user' ";
//         $this->noc->query($sql);
//         if($this->noc->affected_rows()!=1){
//             $this->noc->trans_rollback();
//         }
//     }
//     // else{
//     //     $this->db->trans_rollback();
//     //     $this->dbb->trans_rollback();
//     //     $this->session->set_flashdata('message','NOC User Not found. Please contact System Administrator');
//     //     redirect('/home');
//     // }
//     if($this->db->trans_status()==true && $this->dbb->trans_status()==true && $this->noc->trans_status()==true){
//         $this->db->trans_commit();
//         $this->dbb->trans_commit();
//         $this->noc->trans_commit();
//         redirect('login/logout');
//     }else{
//         $this->db->trans_rollback();
//         $this->dbb->trans_rollback();
//         $this->noc->trans_rollback();
//         $this->session->set_flashdata('message','There is a problem found in Un-Mapped user. Please contact System Administrator');
//         redirect('/home');
//     }  
// }
function remapped(){
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
    $lot_no = $this->session->userdata('lot_no');
    $user_code = $this->session->userdata('user_code');
    $dhar_user = $_SESSION['credentials']['username'];   // logged-in Dharitree user
    $noc_user  = $_SESSION['credentials']['noc'];        // logged-in NOC user (if any)
    $log_filename = APPPATH . 'logs/remap-' . date('Y-m-d') . '.log';
    $this->load->helper('file');
    // ---- MAIN DB ----
    $this->db->trans_begin();
    $sql = "UPDATE loginuser_table 
            SET user_map = NULL, nocuser = NULL 
            WHERE dist_code = ? AND subdiv_code = ? AND cir_code = ? 
              AND mouza_pargona_code = ? AND lot_no = ? AND user_code = ?";
    $params = [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code];
    $this->db->query($sql, $params);

    $log_entry = sprintf("[%s][USER:%s] LOGINUSER SQL: %s | Params: %s\n", date('c'), $dhar_user, $sql, json_encode($params));
    write_file($log_filename, $log_entry, 'a');

    if ($this->db->affected_rows() != 1) {
        $this->db->trans_rollback();
        write_file($log_filename, sprintf("[%s][USER:%s] LOGINUSER ROLLBACK\n", date('c'), $dhar_user), 'a');
    }

    // ---- CENTRAL AUTH ----
    $this->dbb = $this->load->database('auth', TRUE);
    $this->dbb->trans_begin();

    $new_dhar_user = $dhar_user . $this->generateUniqueRandomId($this->dbb);
    $sql = "UPDATE central_auth 
            SET dhar_user = ? 
            WHERE dhar_user = ? AND dist_code = ? AND subdiv_code = ? 
              AND cir_code = ? AND mouza_pargona_code = ? AND lot_no = ?";
    $params = [$new_dhar_user, $dhar_user, $dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no];
    $this->dbb->query($sql, $params);

    $log_entry = sprintf("[%s][USER:%s] CENTRAL_AUTH SQL: %s | Params: %s | NEW_USER: %s\n", date('c'), $dhar_user, $sql, json_encode($params), $new_dhar_user);
    write_file($log_filename, $log_entry, 'a');

    if ($this->dbb->affected_rows() != 1) {
        $this->dbb->trans_rollback();
        write_file($log_filename, sprintf("[%s][USER:%s] CENTRAL_AUTH ROLLBACK\n", date('c'), $dhar_user), 'a');
    }

    // ---- NOC DB ----
    $this->noc = $this->load->database('dha26', TRUE);
    if ($noc_user) {
        $this->noc->trans_begin();
        $sql = "UPDATE user1 
                SET user_map = NULL, dharitree_user = NULL 
                WHERE distcode = ? AND subdivcode = ? AND circlecode = ? 
                  AND mouzacode = ? AND lotno = ? AND usnm = ?";
        $params = [$dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $noc_user];
        $this->noc->query($sql, $params);

        $log_entry = sprintf("[%s][USER:%s] NOC SQL: %s | Params: %s\n", date('c'), $dhar_user, $sql, json_encode($params));
        write_file($log_filename, $log_entry, 'a');

        if ($this->noc->affected_rows() != 1) {
            $this->noc->trans_rollback();
            write_file($log_filename, sprintf("[%s][USER:%s] NOC ROLLBACK\n", date('c'), $dhar_user), 'a');
        }
    }

    // ---- FINAL COMMIT / ROLLBACK ----
    if ($this->db->trans_status() && $this->dbb->trans_status() && $this->noc->trans_status()) {
        $this->db->trans_commit();
        $this->dbb->trans_commit();
        $this->noc->trans_commit();
        write_file($log_filename, sprintf("[%s][USER:%s] ALL TRANSACTIONS COMMITTED SUCCESSFULLY\n", date('c'), $dhar_user), 'a');
        redirect('login/logout');
    } else {
        $this->db->trans_rollback();
        $this->dbb->trans_rollback();
        $this->noc->trans_rollback();
        write_file($log_filename, sprintf("[%s][USER:%s] FINAL ROLLBACK TRIGGERED\n", date('c'), $dhar_user), 'a');
        $this->session->set_flashdata('message', 'There is a problem found in Un-Mapped user. Please contact System Administrator');
        redirect('/home');
    }
}
private function generateUniqueRandomId($dbb) {
    $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    do {
        $randId = '';
        for ($i = 0; $i < 5; $i++) {
            $randId .= $characters[random_int(0, strlen($characters) - 1)];
        }
        $exists = $dbb->query("SELECT 1 FROM central_auth WHERE dhar_user = ?", [$randId])->num_rows();
    } while ($exists > 0);

    return $randId;
}
//////////Basundhara API///////////////////////
function activeUser($ru,$d,$s,$c,$m,$l){
        $this->session->set_userdata('dist_code',$d);
        $this->dbswitch();
        if($ru=='U'){
            $sql="Select user_code,use_name from loginuser_table where user_code like 'AS%' and dist_code='$d' and subdiv_code='$s' and cir_code='$c' and dis_enb_option='E' ";
            $data=$this->db->query($sql)->row_array();
            $query="Select username,phone_no from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and user_code='$data[user_code]' ";
            $result=$this->db->query($query)->row_array();
            $data=array(
                'name'=>$result['username'],
                'phone'=>$result['phone_no']
            );
        }else{
            $sql="Select user_code,use_name from loginuser_table where user_code like 'M%' and dist_code='$d' and subdiv_code='$s' and cir_code='$c' and mouza_pargona_code='$m' and lot_no='$l' and dis_enb_option='E' ";
            $data=$this->db->query($sql)->row_array();
            if($data){
                $query="Select lm_name  as username from users where dist_code='$d' and subdiv_code='$s' and cir_code='$c' and user_code='$data[user_code]' and mouza_pargona_code='$m' and lot_no='$l' ";
                $result=$this->db->query($query)->row_array();
                $data=array(
                    'name'=>$result['username'],
                    'phone'=>'na'
                );
            }else{
                $data= array('name' =>'NOT FOUND' ,
                    'phone'=>'NA'
                 );
            }
        }
        echo json_encode($data);
    }
}
