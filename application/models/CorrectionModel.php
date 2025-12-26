<?php
class CorrectionModel extends CI_Model {

    public function getDistricts()
    {
        return $this->db->get('location')->result();
    }

    public function getSubdivisions($dist_code)
    {
        return $this->db->where('dist_code', $dist_code)->get('subdivisions')->result();
    }

    public function getPattaDetails($patta_type,$patta_no, $dist_code, $subdiv_code,$cir_code,$mouza_code,$lot_no,$village_code)
    {
        return $results = $this->db->select('pdar_id, pdar_name,pdar_father as pdar_father_name')
        ->where([
            'patta_type_code' => $patta_type,
            'patta_no' => $patta_no,
            'dist_code' => $dist_code,
            'subdiv_code' => $subdiv_code,
            'cir_code' => $cir_code,
            'mouza_pargona_code' => $mouza_code,
            'lot_no' => $lot_no,
            'vill_townprt_code' => $village_code,
        ])
        ->where('p_flag !=', '1')
        ->get('jama_pattadar')
        ->result();
        log_message('error',$this->db->last_query());
    }

    public function submitCorrection($data)
    {
        return $this->db->insert('jama_pattadar_corrections', $data);
    }
    function getMasterRelation(){
        return $this->db->get('master_guard_rel')->result();
    }
    function getCaste(){
        return $this->db->get('master_caste')->result();
    }
    function getGender(){
        return $this->db->get('master_gender')->result();
    }

    function getRelationbyId($id){
        $sql = $this->db->query("select guard_rel_desc_as as c from master_guard_rel where id='$id'")->row()->c;
        return $sql;
    }
    function getCastebyId($id){
        $sql = $this->db->query("select caset_name_eng as c from master_caste where id='$id'")->row()->c;
        return $sql;
    }
    function getGenderbyId($id){
        $sql = $this->db->query("select gen_name_ass as c from master_gender where id='$id'")->row()->c;
        return $sql;
    }
    function finalChithaJamaCorrection($case_no){
        $checkData = $this->db->get_where('jama_pattadar_corrections', ['case_no' => $case_no,'pending_status'=> 'F']);
        if($checkData->num_rows()==0){
            return false;
        }
        $correction=$checkData->row();
        $updateData = [
            //'pdar_name' => $correction->new_pdar_name,
            'pdar_father' => $correction->new_pdar_father,
            'user_code' => $this->session->userdata('user_code')
        ];
        $this->db->where([
            'dist_code' => $correction->dist_code,
            'subdiv_code' => $correction->subdiv_code,
            'cir_code' => $correction->cir_code,
            'mouza_pargona_code' => $correction->mouza_pargona_code,
            'lot_no' => $correction->lot_no,
            'vill_townprt_code' => $correction->vill_townprt_code,
            'patta_type_code' => $correction->patta_type_code,
            'patta_no' => $correction->patta_no,
            'pdar_id' => $correction->pdar_id,
            'p_flag !=' =>'1'
        ]);
        $this->db->update('jama_pattadar', $updateData);
        if($this->db->affected_rows()!=1){
            log_message('error', "#NGCORJAMAPATTA00:".$this->db->last_query());
            return false;
        }
        // $this->db->where([
        //     'dist_code' => $correction->dist_code,
        //     'subdiv_code' => $correction->subdiv_code,
        //     'cir_code' => $correction->cir_code,
        //     'mouza_pargona_code' => $correction->mouza_pargona_code,
        //     'lot_no' => $correction->lot_no,
        //     'vill_townprt_code' => $correction->vill_townprt_code,
        //     'patta_type_code' => $correction->patta_type_code,
        //     'patta_no' => $correction->patta_no,
        //     'pdar_id' => $correction->pdar_id,
        // ]);
        // $this->db->update('chitha_pattadar', $updateData);
        $table = 'chitha_pattadar';

        $params = $updateData;

        $where = [
            'dist_code'           => $correction->dist_code,
            'subdiv_code'         => $correction->subdiv_code,
            'cir_code'            => $correction->cir_code,
            'mouza_pargona_code'  => $correction->mouza_pargona_code,
            'lot_no'              => $correction->lot_no,
            'vill_townprt_code'   => $correction->vill_townprt_code,
            'patta_type_code'     => $correction->patta_type_code,
            'patta_no'            => $correction->patta_no,
            'pdar_id'             => $correction->pdar_id,
        ];

        // Call the reusable update method in your model
        $this->Chitha_basic_model->update_table($table, $params, $where);

        if($this->db->affected_rows()!=1){
            log_message('error', "#NGCORCHITHA00:".$this->db->last_query());
            return false;
        }
        return true;
    }
    function remarkGenerate($case_no){
        $checkData = $this->db->get_where('jama_pattadar_corrections', ['case_no' => $case_no,'pending_status'=> 'F']);
        if($checkData->num_rows()==0){
            return false;
        }
        $data=$checkData->row();
        // $lm = $this->utilityclass->getDefinedMondalsName($data->dist_code, $data->subdiv_code, $data->cir_code, $data->mouza_pargona_code, $data->lot_no, $data->submitted_by);
        // $lm_note = "( **** টোকা :-  ভূমিলেখ্য সহায়ক --- " . $lm->lm_name . " Dated :-" . date('Y-m-d', strtotime($data->submitted_by));
        $coname = $this->utilityclass->getSelectedCOName($data->dist_code, $data->subdiv_code, $data->cir_code, $data->reviewed_by);
        // $final_report = $lm_note . $final_report . "<br> চক্ৰ বিষয়া :-" . $coname->username . " Dated: " . date('Y-m-d') . ")";
        $sql = "Select max(rmk_line_no)+1 as c from jama_remark WHERE
        dist_code=? and subdiv_code = ? and cir_code=? and mouza_pargona_code = ? and lot_no = ? and 
        vill_townprt_code=? and patta_type_code=? and TRIM(patta_no)=? ";
        $count = $this->db->query($sql,array($data->dist_code,$data->subdiv_code,$data->cir_code,$data->mouza_pargona_code,$data->lot_no,$data->vill_townprt_code,$data->patta_type_code,$data->patta_no));
        if($count->num_rows()> 0){
            $rmk_line_no=$count->row()->c;
        }else{
            $rmk_line_no=1;
        }
        ///////////////////
        $remark = "চক্র বিষয়াৰ হুকুম নং $case_no ,হুকুমমৰ্মে এই পাট্টাৰ অভিভাৱকৰ নাম $data->old_pdar_father ৰ নাম $data->new_pdar_father কৰা হ'ল |<br>";
        $remark .="চক্র বিষয়া : $coname->username ";
        $insert=[
            'dist_code'=> $data->dist_code,
            'subdiv_code'=> $data->subdiv_code,
            'cir_code'=> $data->cir_code,
            'mouza_pargona_code'=> $data->mouza_pargona_code,
            'lot_no'=> $data->lot_no,
            'vill_townprt_code'=> $data->vill_townprt_code,
            'patta_type_code'=> $data->patta_type_code,
            'patta_no'=> $data->patta_no,
            'rmk_line_no'=> $rmk_line_no,
            'remark'=> $remark,
            'user_code'=> $this->session->userdata('user_code'),
            'entry_date'=> date('Y-m-m'),
            'entry_mode'=> 'U',
            'created_on'=> date('Y-m-m H:i:s'),
        ];
        $this->db->insert('jama_remark', $insert);
        if($this->db->affected_rows()==1){
            return true;
        }else{
            log_message('error', "#NGCORJAMA00:".$this->db->last_query());
            return false;
        }
    }
}
?>
