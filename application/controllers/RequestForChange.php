<?php
class RequestForChange extends CI_Controller {
	public function __construct() {
		parent::__construct();
	}
	function requestForChangeUI(){
        $dist_code = $this->session->userdata('dist_code');
        $subdiv_code = $this->session->userdata('subdiv_code');
        $cir_code = $this->session->userdata('cir_code');
        $user_code = $this->session->userdata('user_code');
        /////////////
        $sql="Select * from request_for_change where  status=? and dist_code=? and subdiv_code=? and cir_code=?";
        $data['datas']=$this->db->query($sql,array('P',$dist_code,$subdiv_code,$cir_code))->result_array();
        $data['_view'] = 'request_for_change';
        $this->load->view('layouts/main',$data);
    }
    function request_change_update($id){
        $user_code = $this->session->userdata('user_code');
        $user_desig = $this->session->userdata('user_desig_code');
        if($user_desig!='CO'){
            show_error('USER NOT AUTHORIZED');
        }
        $sql="Select * from request_for_change where request_id=? and status=?";
        $data=$this->db->query($sql,array($id,'P'))->row_array();
        $queries=$data['sql_query'];
        $result=explode(";",$queries); 
        $this->db->trans_begin();  
        foreach($result as $row){
            $mainQuries=explode("###",$row);
            for($i=0;$i<(count($mainQuries)-1);$i++){
                if($mainQuries[$i]==null) continue;
                $mainQuries[$i];
                $mainQuries[$i+1];
                $this->db->query($mainQuries[$i]);
                if($this->db->affected_rows()!=$mainQuries[$i+1]){
                    $this->db->trans_rollback();
                    log_message('error',"MANUAL-UPDATE-ERROR:".$i."#######".$this->db->last_query());
                    redirect('/home');
                }
            }   
        }
        $sqlUpdateArray=['status'=>'F','update_date_entry'=>date('Y-m-d H:i:s'),'user_code'=>$this->session->userdata('user_code')];
        $this->db->where('request_id',$id);
        $this->db->update('request_for_change',$sqlUpdateArray);
        if($this->db->affected_rows()!=1){
            $this->db->trans_rollback();
            log_message('error',"MANUAL-UPDATE-ERROR:3#######".$this->db->last_query());
            redirect('/home');
        }
        $this->db->trans_commit();
        $this->session->set_flashdata('message',"Kindly check Chitha/ROR Copy");
        redirect('/home/');
    }
}