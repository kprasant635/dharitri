<?php

class Portal extends CI_Controller {
		var $range1;
		var $range2;
		var $startdates =array(
			'kamrupm'=>'2017-02-21',
			'kamrupr'=>'2017-02-21',
			'sibsagar'=>'2017-02-24',
			'dibrugarh'=>'2017-02-24'
		);
		function __construct() {
			parent::__construct();    
			$this->range1 = date('Y-m-d');
            $this->range2 = date('Y-m-d', (strtotime('-60 day', strtotime(date('Y-m-d')))));
			if(strtotime($this->range2) < strtotime('2017-02-21')){
				$this->range2 = '2017-02-21';
			}
		}
        public function index() {
       
        }    
        public function saledeed() {
				$db=  $this->session->userdata('db');
            $data['dist']= $databsearray = array(
            array('kamrup', '07'),
          //  array('jorhat', '15'),
          //  array('goalpara', '03'),
            //array('dhubri', '02'),
            array('kamrupm', '24'),
           // array('lakhimpur', '12'),
            //array('golaghat', '14'),
           // array('barpeta', '05'),
			array('dibrugarh', '17'),
           // array('tinsukia', '18'),
			array('sibsagar', '16'),
            //array('nalbari', '06'),
           // array('sonitpur', '11'),
           // array('nagaon', '03'),
          // array('dhemaji', '25'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
            $sql = "Select count(*) as c from    sro_note where date(date_of_deed)<='$this->range1' and date(date_of_deed)<='$this->range2'";

            $data['reg'][$name]['sro_note'] = $this->dbb->query($sql)->row();
            $sql = "Select count(*) as co from    sro_note where status='1' and  date(date_of_deed)<='$this->range1' and date(date_of_deed)<='$this->range2'";
            $data['reg'][$name]['sro_note_co'] = $this->dbb->query($sql)->row();
            $this->db->close();
            $this->dbb->close();
        }
         $this->load->view('../views/portal/header');
        $this->load->view('../views/portal/saledeed', $data);
    }

    public function saledeedcircle() {
			$db=  $this->session->userdata('db');
        $dist_name = $this->input->get('d');
        $data['dist']= $databsearray = array(
            array('kamrup', '07'),
          //  array('jorhat', '15'),
          //  array('goalpara', '03'),
            //array('dhubri', '02'),
            array('kamrupM', '24'),
           // array('lakhimpur', '12'),
            //array('golaghat', '14'),
           // array('barpeta', '05'),
         //   array('dibrugarh', '17'),
           // array('tinsukia', '18'),
			// array('sibsagar', '16'),
            //array('nalbari', '06'),
           // array('sonitpur', '11'),
           // array('nagaon', '03'),
          // array('dhemaji', '25'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
            if($name==$dist_name){
        $q = "SELECT * from    location WHERE dist_code='$code' and subdiv_code !='00' and cir_code !='00'  and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code= '00000'";
        $data['loc'] = $location = $this->dbb->query($q)->result();
        foreach ($location as $loc) {
            $sql = "Select count(*) as c from    sro_note where cir_code='$loc->cir_code' where date(date_of_deed)<='$this->range1' and date(date_of_deed)<='$this->range2' ";
            $data['circle'][$loc->loc_name]['sro_note'] = $this->dbb->query($sql)->row();

            $sql = "Select count(*) as co from    sro_note where cir_code='$loc->cir_code' and status='1' and  date(date_of_deed)<='$this->range1' and date(date_of_deed)<='$this->range2'";
            $data['circle'][$loc->loc_name]['sro_note_co'] = $this->dbb->query($sql)->row();
        }
        }}
         $this->load->view('../views/portal/header');
        $this->load->view('../views/portal/saledeedcircle', $data);
    }

    public function districtwiselist() {
			$db=  $this->session->userdata('db');
       // $this->load->helper('html');
         $this->load->view('../views/portal/header');
       $data['dist']= $databsearray = array(
            array('kamrup', '07'),
          //  array('jorhat', '15'),
          //  array('goalpara', '03'),
            //array('dhubri', '02'),
            array('kamrupM', '24'),
           // array('lakhimpur', '12'),
            //array('golaghat', '14'),
           // array('barpeta', '05'),
            array('dibrugarh', '17'),
           // array('tinsukia', '18'),
			array('sibsagar', '16'),
            //array('nalbari', '06'),
           // array('sonitpur', '11'),
           // array('nagaon', '03'),
          // array('dhemaji', '25'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;

        //        Office Cases
        $q = "select count(*) as c from    Petition_Basic where  mut_type='03' and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
		echo $q;
		$data['mis'][$name]['omut'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where  mut_type='03' and (status='P' or status is null) and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2' ";
        $data['mis'][$name]['omutpen'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where  mut_type='03' and (status='D' or status='d' ) and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['omutdev'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where  mut_type='03' and (status ='F' or status ='f') and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2' ";
        $data['mis'][$name]['omutfinal'] = $this->dbb->query($q)->row();

        ////////////////
        $q = "select count(*) as c from    Petition_Basic where  mut_type='01' and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['ocon'] = $OPart = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where  mut_type='01' and (status='P' or status is null) and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['oconpen'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where  mut_type='01' and (status='D' or status='d' ) and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['ocondev'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where  mut_type='01' and (status ='F' or status ='f' ) and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2' ";
        $data['mis'][$name]['oconfinal'] = $this->dbb->query($q)->row();
        ///////////////
        $q = "select count(*) as c from    Petition_Basic where  mut_type='04' and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['opart'] = $OConv = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where mut_type='04' and (status='P' or status is null) and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['opartpen'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where  mut_type='04' and (status='D' or status='d' ) and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['opartdev'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Petition_Basic where  mut_type='04' and ( status ='F' or status ='f'   )  and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['opartfinal'] = $this->dbb->query($q)->row();

        //        Field Cases
        $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='01' and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['ofcmut'] = $OConv = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='01' and (order_passed is null and is_dispose is null ) and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['ofcmutpen'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='01' and (is_dispose='Y' or is_dispose='y'  ) and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['ofcmutdev'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='01' and (order_passed ='Y' or order_passed ='y'  ) and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['ofcmutfinal'] = $this->dbb->query($q)->row();
        ///////////
        $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='02' and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['fpart'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='02' and (order_passed is Null and is_dispose is null) and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['fpartpen'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='02' and (is_dispose='Y' or is_dispose='y' ) and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['fpartdev'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    Field_Mut_Basic where  mut_type='02' and (order_passed ='Y' or order_passed ='y'  ) and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";
        $data['mis'][$name]['fpartfinal'] = $this->dbb->query($q)->row();

        // Reclassfication
        $q = "select count(*) as c from    t_reclassification  ";
        $data['mis'][$name]['t_reclass_tot'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    t_reclassification where   (rkg_chitha_updated_yn !='Y' and co_chitha_updated_yn !='Y') ";
        $data['mis'][$name]['t_reclass_pen'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    t_reclassification where (rkg_chitha_updated_yn ='Y' and co_chitha_updated_yn ='Y')";
        $data['mis'][$name]['t_reclass_dev'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    t_reclassification where  co_yn='N' ";
        $data['mis'][$name]['t_reclass_dispose'] = $this->dbb->query($q)->row();
        // End Reclassfication     
        // NR Case
        $q = "select count(*) as c from    apcancel_petition_basic where date(submission_date)<='$this->range1' and date(submission_date)>='$this->range2'  ";

        $data['mis'][$name]['nr_tot'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    apcancel_petition_basic where   status ='P' and order_passed is null and date(submission_date)<='$this->range1' and date(submission_date)>='$this->range2'  ";
        $data['mis'][$name]['nr_pen'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    apcancel_petition_basic where  order_passed ='Y' and date(submission_date)<='$this->range1' and date(submission_date)>='$this->range2' ";
        $data['mis'][$name]['nr_dev'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    apcancel_petition_basic where  status='X' and date(submission_date)<='$this->range1' and date(submission_date)>='$this->range2' ";
        $data['mis'][$name]['nr_dispose'] = $this->dbb->query($q)->row();
        // // End NR Case
        // Misc Case
        $q = "select count(*) as c from    misc_case_basic where date(date_of_operation)<='$this->range1' and date(date_of_operation)>='$this->range2'  ";
        $data['mis'][$name]['misccase_tot'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    misc_case_basic where   (status !='10'  or status ='11'  )  and date(date_of_operation)<='$this->range1' and date(date_of_operation)>='$this->range2'";
        $data['mis'][$name]['misccase_pen'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    misc_case_basic where   status ='10' and date(date_of_operation)<='$this->range1' and date(date_of_operation)>='$this->range2' ";
        $data['mis'][$name]['misccase_dev'] = $this->dbb->query($q)->row();
        $q = "select count(*) as c from    misc_case_basic where    status ='11'  and date(date_of_operation)<='$this->range1' and date(date_of_operation)>='$this->range2' ";
        $data['mis'][$name]['misccase_dispose'] = $this->dbb->query($q)->row();
        // End Misc Case

        }
        $this->load->view('../views/portal/districtwiselist', $data);
        //$this->load->view('../views/footer');
    }

    public function DisposeGalanceCircle() {
			$db=  $this->session->userdata('db');
        //var_dump($this->session->all_userdata());
        $data = array();
        $distname = $this->input->get('d');
        $data['dist']= $databsearray = array(
            array('kamrup', '07'),
          //  array('jorhat', '15'),
          //  array('goalpara', '03'),
            //array('dhubri', '02'),
            array('kamrupM', '24'),
           // array('lakhimpur', '12'),
            //array('golaghat', '14'),
           // array('barpeta', '05'),
         //   array('dibrugarh', '17'),
           // array('tinsukia', '18'),
			// array('sibsagar', '16'),
            //array('nalbari', '06'),
           // array('sonitpur', '11'),
           // array('nagaon', '03'),
          // array('dhemaji', '25'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
             $dist_code = $databsearray[$i][1];
            $db = $this->load->database($dist_code, TRUE);
            $this->dbb = $db;
            if($name==$distname){

        $q = "SELECT * from    location WHERE dist_code='$dist_code' and subdiv_code !='00' and cir_code !='00'  and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code= '00000'";
        $data['loc'] = $location = $this->dbb->query($q)->result();
        foreach ($location as $loc) {
            $subdiv_code = $loc->subdiv_code;
            $cir_code = $loc->cir_code;
            //        Office Cases
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03'";
            echo $q;
			$data['circle'][$loc->loc_name]['omut'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03' and (status='P' or status is null) ";
            $data['circle'][$loc->loc_name]['omutpen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03' and (status='D' or status='d' )";
            $data['circle'][$loc->loc_name]['omutdev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='03' and (status ='F' or status ='f') ";
            $data['circle'][$loc->loc_name]['omutfinal'] = $this->dbb->query($q)->row();

            ////////////////
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01'";
            $data['circle'][$loc->loc_name]['ocon'] = $OPart = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (status='P' or status is null) ";
            $data['circle'][$loc->loc_name]['oconpen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (status='D' or status='d' ) ";
            $data['circle'][$loc->loc_name]['ocondev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (status ='F' or status ='f' )  ";
            $data['circle'][$loc->loc_name]['oconfinal'] = $this->dbb->query($q)->row();
            ///////////////
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04'";
            $data['circle'][$loc->loc_name]['opart'] = $OConv = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and (status='P' or status is null) ";
            $data['circle'][$loc->loc_name]['opartpen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and (status='D' or status='d' ) ";
            $data['circle'][$loc->loc_name]['opartdev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Petition_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='04' and ( status ='F' or status ='f'   )  ";
            $data['circle'][$loc->loc_name]['opartfinal'] = $this->dbb->query($q)->row();

            //        Field Cases
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' ";
            $data['circle'][$loc->loc_name]['ofcmut'] = $OConv = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (order_passed is null and is_dispose is null ) ";
            $data['circle'][$loc->loc_name]['ofcmutpen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='01' and (is_dispose='Y' or is_dispose='y'  )";
            $data['circle'][$loc->loc_name]['ofcmutdev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and  cir_code='$cir_code' and  mut_type='01' and (order_passed ='Y' or order_passed ='y'  ) ";
            $data['circle'][$loc->loc_name]['ofcmutfinal'] = $this->dbb->query($q)->row();
            ///////////
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='02'";
            $data['circle'][$loc->loc_name]['fpart'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='02' and (order_passed is Null and is_dispose is null) ";
            $data['circle'][$loc->loc_name]['fpartpen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='02' and (is_dispose='Y' or is_dispose='y' )";
            $data['circle'][$loc->loc_name]['fpartdev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    Field_Mut_Basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and mut_type='02' and (order_passed ='Y' or order_passed ='y'  )";
            $data['circle'][$loc->loc_name]['fpartfinal'] = $this->dbb->query($q)->row();

            // Reclassfication
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $data['circle'][$loc->loc_name]['t_reclass_tot'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  (rkg_chitha_updated_yn !='Y' and co_chitha_updated_yn !='Y') ";
            $data['circle'][$loc->loc_name]['t_reclass_pen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and (rkg_chitha_updated_yn ='Y' and co_chitha_updated_yn ='Y')";
            $data['circle'][$loc->loc_name]['t_reclass_dev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    t_reclassification where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and co_yn='N' ";
            $data['circle'][$loc->loc_name]['t_reclass_dispose'] = $this->dbb->query($q)->row();
            // End Reclassfication     
            // NR Case
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $data['circle'][$loc->loc_name]['nr_tot'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  status ='P' and order_passed is null  ";
            $data['circle'][$loc->loc_name]['nr_pen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and order_passed ='Y' ";
            $data['circle'][$loc->loc_name]['nr_dev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    apcancel_petition_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and status='X' ";
            $data['circle'][$loc->loc_name]['nr_dispose'] = $this->dbb->query($q)->row();
            // // End NR Case
            // Misc Case
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' ";
            $data['circle'][$loc->loc_name]['misccase_tot'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and  (status !='10'  or status ='11'  )  ";
            $data['circle'][$loc->loc_name]['misccase_pen'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and   status ='10'  ";
            $data['circle'][$loc->loc_name]['misccase_dev'] = $this->dbb->query($q)->row();
            $q = "select count(*) as c from    misc_case_basic where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and   status ='11'   ";
            $data['circle'][$loc->loc_name]['misccase_dispose'] = $this->dbb->query($q)->row();
            // End Misc Case
        }
        
        }
        
        }
       // var_dump($data);
        //$this->load->helper('html');
         $this->load->view('../views/portal/header');
        $this->load->view('../views/portal/diposecase_circlewise_list', $data);
        //$this->load->view('../views/footer');
    }

    function croplanddist() {
			$db=  $this->session->userdata('db');
        //$this->load->helper('html');
         $this->load->view('../views/portal/header');
        $data['dist']= $databsearray = array(
            array('kamrup', '07'),
          //  array('jorhat', '15'),
          //  array('goalpara', '03'),
            //array('dhubri', '02'),
            array('kamrupM', '24'),
           // array('lakhimpur', '12'),
            //array('golaghat', '14'),
           // array('barpeta', '05'),
			array('dibrugarh', '17'),
           // array('tinsukia', '18'),
			 array('sibsagar', '16'),
            //array('nalbari', '06'),
           // array('sonitpur', '11'),
           // array('nagaon', '03'),
          // array('dhemaji', '25'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
        //croplanddist
        //for normal - Ravi - irrigated
        $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where   crop_season='01' and source_of_water='01' and (crop_categ_code='n' or crop_categ_code is null)";
        $data['distname'][$name]['ravinormalirrg'] = $this->dbb->query($q)->row();
        //for normal - Ravi - non-irrigated
        $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where  crop_season='01' and source_of_water='03' and (crop_categ_code='n' or crop_categ_code is null)";
        $data['distname'][$name]['ravinormalnonirrg'] = $this->dbb->query($q)->row();
        //for normal - kharif - irrigated
        $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where  crop_season='02' and source_of_water='01' and (crop_categ_code='n' or crop_categ_code is null)";
        $data['distname'][$name]['kharifnormalirrg'] = $this->dbb->query($q)->row();
        //for normal - kharif - nonirrigated
        $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where  crop_season='02' and source_of_water='03' and (crop_categ_code='n' or crop_categ_code is null)";
        $data['distname'][$name]['kharifnormalnonirrg'] = $this->dbb->query($q)->row();
        //for rich - Ravi - irrigated
        $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where  crop_season='01' and source_of_water='01' and crop_categ_code='r' ";
        $data['distname'][$name]['ravirichirrg'] = $this->dbb->query($q)->row();
        //for rich - Ravi - non-irrigated
        $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where  crop_season='01' and source_of_water='03' and crop_categ_code='r'";
        $data['distname'][$name]['ravirichnonirrg'] = $this->dbb->query($q)->row();
        //for rich - kharif - irrigated
        $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where  crop_season='02' and source_of_water='01' and crop_categ_code='r'";
        $data['distname'][$name]['kharifrichirrg'] = $this->dbb->query($q)->row();
        //for rich - kharif - nonirrigated
        $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where crop_season='02' and source_of_water='03' and crop_categ_code='r' ";
        $data['distname'][$name]['kharifrichnonirrg'] = $this->dbb->query($q)->row();
       // var_dump($data);
        }
        //var_dump($data);
        $this->load->view('../views/portal/croplanddist', $data);
       // $this->load->view('../views/footer');
    }

    function croplandcircle() {
			$db=  $this->session->userdata('db');
        //$this->load->helper('html');
         $this->load->view('../views/portal/header');
        $distname = $this->input->get('key');
        $data['dist']= $databsearray = array(
            array('kamrup', '07'),
          //  array('jorhat', '15'),
          //  array('goalpara', '03'),
            //array('dhubri', '02'),
            array('kamrupM', '24'),
           // array('lakhimpur', '12'),
            //array('golaghat', '14'),
           // array('barpeta', '05'),
         //   array('dibrugarh', '17'),
           // array('tinsukia', '18'),
			// array('sibsagar', '16'),
            //array('nalbari', '06'),
           // array('sonitpur', '11'),
           // array('nagaon', '03'),
          // array('dhemaji', '25'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
            if($name==$distname){
        
        $q = "SELECT * from    location WHERE dist_code='$code' and subdiv_code !='00' and cir_code !='00'  and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code= '00000'";
        $data['loc'] = $location = $this->dbb->query($q)->result();
        foreach ($location as $loc) {
            $dist_code=$loc->dist_code;
            $subdiv_code = $loc->subdiv_code;
            $cir_code = $loc->cir_code;
            $mergecode=$loc->loc_name;
            //for normal - Ravi - irrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='01' and source_of_water='01' and (crop_categ_code='n' or crop_categ_code is null)";
            $data['circle'][$mergecode]['ravinormalirrg'] = $this->dbb->query($q)->row();
            //for normal - Ravi - non-irrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='01' and source_of_water='03' and (crop_categ_code='n' or crop_categ_code is null)";
            $data['circle'][$mergecode]['ravinormalnonirrg'] = $this->dbb->query($q)->row();
            //for normal - kharif - irrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='02' and source_of_water='01' and (crop_categ_code='n' or crop_categ_code is null)";
            $data['circle'][$mergecode]['kharifnormalirrg'] = $this->dbb->query($q)->row();
            //for normal - kharif - nonirrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='02' and source_of_water='03' and (crop_categ_code='n' or crop_categ_code is null)";
            $data['circle'][$mergecode]['kharifnormalnonirrg'] = $this->dbb->query($q)->row();
            //for rich - Ravi - irrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from    chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='01' and source_of_water='01' and crop_categ_code='r' ";
            $data['circle'][$mergecode]['ravirichirrg'] = $this->dbb->query($q)->row();
            //for rich - Ravi - non-irrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from     chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='01' and source_of_water='03' and crop_categ_code='r'";
            $data['circle'][$mergecode]['ravirichnonirrg'] = $this->dbb->query($q)->row();
            //for rich - kharif - irrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from     chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='02' and source_of_water='01' and crop_categ_code='r'";
            $data['circle'][$mergecode]['kharifrichirrg']= $this->dbb->query($q)->row();
            //for rich - kharif - nonirrigated
            $q = "Select sum (crop_land_area_b  ) as b,sum(crop_land_area_k) as k,sum(crop_land_area_lc) as l from     chitha_mcrop where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and crop_season='02' and source_of_water='03' and crop_categ_code='r' ";
            $data['circle'][$mergecode]['kharifrichnonirrg'] = $this->dbb->query($q)->row();
            }}
        }
       //       var_dump($data);
        $this->load->view('../views/portal/croplandcircle', $data);
        //$this->load->view('../views/footer');
    }

    function fruitdist() {
			$db=  $this->session->userdata('db');
       $data['dist']= $databsearray = array(
            array('kamrup', '07'),
          //  array('jorhat', '15'),
          //  array('goalpara', '03'),
            //array('dhubri', '02'),
            array('kamrupM', '24'),
           // array('lakhimpur', '12'),
            //array('golaghat', '14'),
           // array('barpeta', '05'),
            array('dibrugarh', '17'),
           // array('tinsukia', '18'),
			 array('sibsagar', '16'),
            //array('nalbari', '06'),
           // array('sonitpur', '11'),
           // array('nagaon', '03'),
          // array('dhemaji', '25'),
        );
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++) {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
            $q = "Select * from    fruit_tree_code";
            $tcode = $this->dbb->query($q)->result();
            foreach ($tcode as $t) {
                $tcode = $t->fruit_code;
				$tname = $t->fruit_name;
                $q = "Select sum(no_of_plants) as no_of_fruit_plants from    chitha_fruit where fruit_plants_name='$tcode' ";
               // echo $q."<br>";
                $val[$code][$tname] = $this->dbb->query($q)->row();  
            }
            $data['name']=  $val;     
        }
       
        $this->load->view('../views/portal/header');
        $this->load->view('../views/portal/fruitdist', $data);
      //  $this->load->view('../views/footer');
    }
    function fruitlistcircle(){
			$db=  $this->session->userdata('db');
        $data['dist']= $databsearray = array(
            array('kamrup', '07'),
          //  array('jorhat', '15'),
          //  array('goalpara', '03'),
            //array('dhubri', '02'),
            array('kamrupM', '24'),
           // array('lakhimpur', '12'),
            //array('golaghat', '14'),
           // array('barpeta', '05'),
         //   array('dibrugarh', '17'),
           // array('tinsukia', '18'),
			// array('sibsagar', '16'),
            //array('nalbari', '06'),
           // array('sonitpur', '11'),
           // array('nagaon', '03'),
          // array('dhemaji', '25'),
        );
        $datbase=$this->input->get('d');
        $getcode=$this->input->get('c');
        $size = sizeof($databsearray);
        for ($i = 0; $i < $size; $i++)
            {
            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            if($name==$datbase and $code==$getcode)
            {
                
                $db = $this->load->database($code, TRUE);
                $this->dbb = $db;
                $q = "SELECT * from    location WHERE dist_code='$code' and subdiv_code !='00' and cir_code !='00' "
                    . " and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code= '00000'";
                $data['loc'] = $location = $this->dbb->query($q)->result();
                foreach ($location as $loc) {
                $subdiv_code = $loc->subdiv_code;
                $cir_code = $loc->cir_code;
                
                $q = "Select * from    fruit_tree_code";
                $tcode = $this->dbb->query($q)->result();
                foreach ($tcode as $t) {
                    $tcode = $t->fruit_code;
                    $tname=$t->fruit_name;
                    $q = "Select sum(no_of_plants) as no_of_fruit_plants from    chitha_fruit where fruit_plants_name='$tcode' and cir_code='$cir_code' ";
                    $val[$tname] = $this->dbb->query($q)->row();  
                }
                $circlewise[$cir_code]=  $val; 
                 }
                 $data['circle']=$circlewise;
            
                }
            
            }
            $this->load->view('../views/portal/header');
            $this->load->view('../views/portal/fruitcirclelist', $data);
            //$this->load->view('../views/footer');
    }
	
	public function ApToPp_StateLevel() {
			$db=  $this->session->userdata('db');
        //$dist = unserialize(databases) ;
        //var_dump($dist);

        $data['dist']= $databsearray = array(
            array('kamrup', '07'),
          //  array('jorhat', '15'),
          //  array('goalpara', '03'),
            //array('dhubri', '02'),
            array('kamrupM', '24'),
           // array('lakhimpur', '12'),
            //array('golaghat', '14'),
           // array('barpeta', '05'),
             array('dibrugarh', '17'),
           // array('tinsukia', '18'),
			 array('sibsagar', '16'),
            //array('nalbari', '06'),
           // array('sonitpur', '11'),
           // array('nagaon', '03'),
          // array('dhemaji', '25'),
        );
        $size = sizeof($databsearray);
        
        for ($i = 0; $i < $size; $i++) {

            $name = $databsearray[$i][0];
            $code = $databsearray[$i][1];
            $db = $this->load->database($code, TRUE);
            $this->dbb = $db;
            //var_dump($db);
            $query1 = $this->dbb->query("SELECT count(*) from    t_chitha_rmk_ordbasic where Ord_type_code='01' and date(ord_date)<='$this->range1' and date(ord_date)>='$this->range2'");
            $order_passesd = $query1->row();
            //query for total chitha updated
            $query2 = $this->dbb->query("SELECT count(distinct ord_no) from     t_chitha_rmk_ordbasic "
                    . "where Ord_type_code='01' and iscorrected_inco='Y' and  date(ord_date)<='$this->range1' and date(ord_date)>='$this->range2'");
            $chitha_corrected = $query2->row();
            //query for total patta converted and total land
            $query3 = $this->dbb->query("SELECT * from    Chitha_Rmk_Ordbasic where Ord_type_code='01' and  date(ord_date)<='$this->range1' and date(ord_date)>='$this->range2'");
            $outerdata = $query3->result();
            $bigha = 0;
            $kotha = 0;
            $lessa = 0;
            $Totpatta = 0;
            //var_dump($Data3);
            foreach ($outerdata as $location) {
                $query5 = $this->dbb->query("SELECT COUNT(Distinct(new_patta_type)) AS new_patta_type from    Chitha_Rmk_convorder 
    where dist_code='$location->dist_code' and subdiv_code='$location->subdiv_code' and cir_code='$location->cir_code' and 
    mouza_pargona_code = '$location->mouza_pargona_code' and Lot_No = '$location->lot_no' and".
	"Vill_townprt_code = '$location->vill_townprt_code' and Dag_no = '$location->dag_no' ". 
	"and rmk_type_hist_no = '$location->rmk_type_hist_no' and ord_cron_no = '$location->ord_cron_no'").
	" and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'";

                $Data5 = $query5->row();
                $patta = $Data5->new_patta_type;
                $Totpatta = $Totpatta + $patta;

                $bigha = $bigha + $location->m_dag_area_b;
                $kotha = $kotha + $location->m_dag_area_k;
                $lessa = $lessa + $location->m_dag_area_lc;
            }
            $total_lesa_converted = ($bigha) * 100 + ($kotha) * 20 + ($lessa);
            $total_area_converted = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lesa_converted);

            //query for total patta not converted and total land
            $query4 = $this->dbb->query("SELECT * from    patta_code where conversion='y'");
            $query4 = $query4->result();
            $bigha_l = 0;
            $kotha_l = 0;
            $lessa_l = 0;
            $Totpatta_l = 0;
            foreach ($query4 as $left) {
                $query6 = $this->dbb->query("Select count(patta_no) as total_patta_left, sum(dag_area_b) as bigha, "
                        . "sum(dag_area_k) as katha, sum(dag_area_lc) as lesa from    chitha_basic".
						" where patta_type_code = '$left->type_code' and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'");
			
                $view = $query6->row();

                $patta_l = $view->total_patta_left;
                $Totpatta_l = $Totpatta_l + $patta_l;

                $bigha_l = $bigha_l + $view->bigha;
                $kotha_l = $kotha_l + $view->katha;
                $lessa_l = $lessa_l + $view->lesa;
            }
            $total_lesa_left = ($bigha_l) * 100 + ($kotha_l) * 20 + ($lessa_l);
            $total_area_left = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lesa_left);

            $arrData[] = array(
                "dist_name" => $name,
                "dist_code" => $code,
                "order_passesd" => $order_passesd,
                "chitha_corrected" => $chitha_corrected,
                'total_patta_l' => $Totpatta_l,
                'total_bigha_l' => $total_area_left[0],
                'total_kotha_l' => $total_area_left[1],
                'total_lessa_l' => $total_area_left[2],
                'total_patta' => $Totpatta,
                'total_bigha' => $total_area_converted[0],
                'total_kotha' => $total_area_converted[1],
                'total_lessa' => $total_area_converted[2]
            );
        }
        $arrDatas = array('result' => $arrData);
        $main = array_merge($arrDatas);
        //var_dump($arrDatas);
        $this->load->helper('html');
        $this->load->view('../views/portal/header');
        $this->load->view('../views/portal/ApToPp_StateLevel', $main);
    }

    public function ApToPp_DistrictLevel() {
			$db=  $this->session->userdata('db');
        $dist_code = $this->input->get('dist_code');
        //echo $dist_code;
        $db = $this->load->database($dist_code, TRUE);
        $this->dbb = $db;
        
        $sub_divs = $this->dbb->query("SELECT * from    location WHERE dist_code='$dist_code' and subdiv_code !='00' and cir_code !='00' ".
		" and Mouza_Pargona_code = '00' and Lot_no= '00' and vill_townprt_code= '00000'");
        $sub_divsa = $sub_divs->result();
        //var_dump($sub_divs);
        foreach ($sub_divsa as $s_d) {
            //var_dump($s_d);
            //query for total order passed
            $Subdiv_code=$s_d->subdiv_code;
            //echo $Subdiv_code;
            $cir_code=$s_d->cir_code;
            $query1 = $this->dbb->query("SELECT count(*) from    t_chitha_rmk_ordbasic "
                    . "where dist_code='$dist_code'  and Subdiv_code='$Subdiv_code' and cir_code = '$cir_code' and Ord_type_code='01' and date(ord_date)<='$this->range1' and date(ord_date)>='$this->range2'");
            $order_passesd = $query1->row();
            //query for total chitha updated
            $query2 = $this->dbb->query("SELECT count(distinct ord_no) from     t_chitha_rmk_ordbasic "
                    . "where Dist_code='$dist_code'  and Subdiv_code='$Subdiv_code' and cir_code = '$cir_code' and Ord_type_code='01' and iscorrected_inco='Y' and date(ord_date)<='$this->range1' and date(ord_date)>='$this->range2'");
            $chitha_corrected = $query2->row();
            //query for total patta converted and total land
            $query3 = $this->dbb->query("SELECT * from    Chitha_Rmk_Ordbasic where dist_code='$dist_code'  and Subdiv_code='$Subdiv_code' and cir_code = '$cir_code' and Ord_type_code='01' and date(ord_date)<='$this->range1' and date(ord_date)>='$this->range2'");
            $outerdata = $query3->result();
            $bigha = 0;
            $kotha = 0;
            $lessa = 0;
            $Totpatta = 0;
            //var_dump($Data3);
            foreach ($outerdata as $location) {
                $query5 = $this->dbb->query("SELECT COUNT(Distinct(new_patta_type)) AS new_patta_type from    Chitha_Rmk_convorder 
    where dist_code='$dist_code' and subdiv_code='$location->subdiv_code' and cir_code='$location->cir_code' and 
    mouza_pargona_code = '$location->mouza_pargona_code' and Lot_No = '$location->lot_no' and " .
	"Vill_townprt_code = '$location->vill_townprt_code' and Dag_no = '$location->dag_no' and " .
	" rmk_type_hist_no = '$location->rmk_type_hist_no' and ord_cron_no = '$location->ord_cron_no'");

                $Data5 = $query5->row();
                $patta = $Data5->new_patta_type;
                $Totpatta = $Totpatta + $patta;

                $bigha = $bigha + $location->m_dag_area_b;
                $kotha = $kotha + $location->m_dag_area_k;
                $lessa = $lessa + $location->m_dag_area_lc;
            }
            $total_lesa_converted = ($bigha) * 100 + ($kotha) * 20 + ($lessa);
            $total_area_converted = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lesa_converted);
            //query for total patta not converted and total land
            $query4 = $this->dbb->query("SELECT * from    patta_code where conversion='y'");
            $query4 = $query4->result();
            $bigha_l = 0;
            $kotha_l = 0;
            $lessa_l = 0;
            $Totpatta_l = 0;
            foreach ($query4 as $left) {
                $query6 = $this->dbb->query("Select count(patta_no) as total_patta_left, sum(dag_area_b) as bigha, "
                        . "sum(dag_area_k) as katha, sum(dag_area_lc) as " .
						" lesa from    chitha_basic where dist_code='$dist_code' and Subdiv_code='$Subdiv_code' and cir_code = '$cir_code' and patta_type_code = '$left->type_code' " .
						"and date(date_entry)<='$this->range1' and date(date_entry)>='$this->range2'");

                $view = $query6->row();

                $patta_l = $view->total_patta_left;
                $Totpatta_l = $Totpatta_l + $patta_l;

                $bigha_l = $bigha_l + $view->bigha;
                $kotha_l = $kotha_l + $view->katha;
                $lessa_l = $lessa_l + $view->lesa;
            }
            $total_lesa_left = ($bigha_l) * 100 + ($kotha_l) * 20 + ($lessa_l);
            $total_area_left = $this->utilityclass->Total_Bigha_Katha_Lessa($total_lesa_left);
            $arrData[] = array(
                "dist_code" => $s_d->dist_code,
                "subdiv_code" => $s_d->subdiv_code,
                "circle_name" => $s_d->loc_name,
                "circle_code" => $s_d->cir_code,
                "order_passesd" => $order_passesd,
                "chitha_corrected" => $chitha_corrected,
                'total_patta_l' => $Totpatta_l,
                'total_bigha_l' => $total_area_left[0],
                'total_kotha_l' => $total_area_left[1],
                'total_lessa_l' => $total_area_left[2],
                'total_patta' => $Totpatta,
                'total_bigha' => $total_area_converted[0],
                'total_kotha' => $total_area_converted[1],
                'total_lessa' => $total_area_converted[2]
            );
        }
        $arrDatas = array('result' => $arrData, 'district' => $dist_code);
        $main = array_merge($arrDatas);
        //var_dump($arrDatas);
        $this->load->helper('html');
        $this->load->view('../views/portal/header');
        $this->load->view('../views/portal/ApToPp_DistrictLevel', $main);
    }
	
	
    }
