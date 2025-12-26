<?php

class uploadDocuments extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $this->user_code = $this->session->userdata('user_code');
        $this->load->library('AES');
    }

    public function uploadSupportiveDocs()
    {
        $val = $this->input->post();
        $case_no = $val['case_no'];
        $flag = $val['flag'];
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        if(($this->input->post('mut_type'))!=null){
            $mut_type=$val['mut_type'];
        }else{
            $mut_type=-1;
        }
        
        $val = explode('/',$case_no);
        $petition_no = $val[3];

        $name = (($flag==1)?'death_cer':(($flag==2)?'noc_file':(($flag==3)?'nok_file':'jama_cer')));
        $sl = (($flag==1)?'1':(($flag==2)?'2':(($flag==3)?'3':'4')));
        $file_name = (($flag==1)?DEATH_CERTIFICATE:(($flag==2)?NOC:(($flag==3)?NOK_CONSENT:JAMABANDI)));

        // if($val[4]=='FMUT'){
        //     $folder = 'fieldmutation/'.$dist_code.'/';
        // }
        // if($val[4]=='FPART'){
        //     $folder = 'fieldpartition/'.$dist_code.'/';
        // }
        // if($val[4]=='OMUT'){
        //     $folder = 'officemutation/'.$dist_code.'/';
        // }
        // if($val[4]=='OPART'){
        //     $folder = 'officepartition/'.$dist_code.'/';
        // }
        if($val[4]=='FMUT'){
            $folder = FMUT_BASE_DIR.$dist_code.UPLOAD_SEPARATOR;
            $petition_no = $this->db->query("SELECT petition_no FROM field_mut_basic WHERE case_no=? ", array($case_no))->row()->petition_no;
        }
        if($val[4]=='FPART'){
            $folder = FPART_BASE_DIR.$dist_code.UPLOAD_SEPARATOR;
            $petition_no = $this->db->query("SELECT petition_no FROM field_mut_basic WHERE case_no=? ", array($case_no))->row()->petition_no;
        }
        if($val[4]=='OMUT'){
            $folder = OMUT_BASE_DIR.$dist_code.UPLOAD_SEPARATOR;
            $petition_no = $this->db->query("SELECT petition_no FROM petition_basic WHERE case_no=? ", array($case_no))->row()->petition_no;
        }
        if($val[4]=='OPART'){
            $folder = OPRAT_BASE_DIR.$dist_code.UPLOAD_SEPARATOR;
            $petition_no = $this->db->query("SELECT petition_no FROM petition_basic WHERE case_no=? ", array($case_no))->row()->petition_no;
        }

        $ext = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);
        $_FILES[$name]['name'] = $petition_no.'_'.$sl.'.'.$ext;

        if(!file_exists( $folder)){
            mkdir($folder, 0777, true);
            $path =  $folder;
        }
        else {
            $path =  $folder;   
        } 
        //echo $path;       
        $config = [
            'upload_path' => $path,
            'allowed_types' => FILE_TYPE,
            'max_size' => MAX_SIZE,
        ];
        $FILES_TYPE_VALIDATION_ARR = explode('|', FILE_TYPE);
        $checkFileExt = false;
        foreach ($FILES_TYPE_VALIDATION_ARR as $file_type) {
            if($ext == $file_type) {
                $checkFileExt = true;
                break;
            }
        }
        $validation=null;
        //log_message('error',json_encode($_FILES[$name]['size']));
        if(!$checkFileExt){
            $validation['error'][] = array('message' => ' Only allowed types ' . FILE_TYPE . '.');
        }
        else if($_FILES[$name]['size'] > (MAX_SIZE * 1024) )
        {
            $validation['error'][] = array('message' => ' Larger file size selected.');
        }
        else
        {   
            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            $count = $this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND
            file_name=? AND user_code=?",array($case_no, $file_name, $this->user_code))->num_rows();

            if($count == 0)
            {
                if ($this->upload->do_upload($name)) 
                {
                    $up = $this->upload->data();
                    $img = [
                        'case_no' => $case_no,
                        'file_name' => $file_name,
                        'user_code' => $this->user_code,
                        'fetch_file_name' => $petition_no.'_'.$sl.$up['file_ext'],
                        'file_type' => $up['file_type'],
                        'file_path' => $path.$petition_no.'_'.$sl.$up['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => $mut_type,
                    ];
                    $ins = $this->db->insert('supportive_document', $img);
                    if($ins == true)
                    {
                        $id=$this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row()->id;
                        $validation['img_upload'] = true;
                        $validation['flag_set'] = $flag;
                        $validation['doc_id'] = $id;
                        $validation['filename'] = $file_name;
                    }
                    else
                    {
                        $validation['img_upload'] = false;
                    }
                }//end do upload
                else{
                    $validation['img_upload'] = false;
                }
            }// end count if

            else { //overwrite previous one

                $file = $this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row()->file_path;
                unlink($file);
                if ($this->upload->do_upload($name)) 
                {
                    $up = $this->upload->data();
                    $overwrite = [
                        'fetch_file_name' => $petition_no.'_'.$sl.$up['file_ext'],
                        'file_type' => $up['file_type'],
                        'file_path' => $path.$petition_no.'_'.$sl.$up['file_ext'],
                        'date_entry' => date('Y-m-d h:i:s'),
                        'mut_type' => (($mut_type=='02')?'02':FIELD_MUT_TYPE),
                    ];
                    $this->db->where(['case_no'=>$case_no, 'file_name'=>$file_name, 'user_code'=>$this->user_code]);
                    $this->db->update('supportive_document', $overwrite);
                    if($this->db->affected_rows() != 1)//if no updation made
                    {
                        $validation['img_upload'] = false;   
                    }
                    else
                    {
                        $id=$this->db->query("SELECT * FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row()->id;
                        $validation['img_upload'] = true;
                        $validation['flag_set'] = $flag;
                        $validation['doc_id'] = $id;
                        $validation['filename'] = $file_name;
                    }
                }
            }
        }
        echo json_encode($validation);        
    }

    public function downloadDocuments($id=null){
        if(isset($id)){  
            $result = $this->db->query("SELECT * FROM supportive_document WHERE id=?", array($id))->row_array();
            //"C:\\xampp\\htdocs\\DharitreeSVN_demo\\"
            
            $content_type = $result['file_type'];
            $file = search_file_location($result['file_path'], false);
            
            if($file){
                $content_type = check_nd_get_content_type($content_type, $file);
                header('Content-Type: '.$content_type);
                header('Content-Length: ' . filesize($file));
                ob_get_clean();
                echo file_get_contents($file);
            }else{
                echo "No such file found";
            }

            // $file = NOK_UPLOAD_PATH.$result['file_path'];
            // log_message("error", 'DOwnloaded file path: '.json_encode($file));
            // $content_type = $result['file_type'];
            // header('Content-Type: '.$content_type);
            // header('Content-Length: ' . filesize($file));
            // ob_clean();
            // echo file_get_contents($file);
        }else{
            echo "No Data Found..";
        }
    }

    public function getDocument(){
        
        $file__path = $this->input->get('file__path');
        $originalString = str_replace(AES_PLUS_REPLACER_STRING,"+",$file__path);
        $enc_file_path        = new AES($originalString, ENCRYPTION_KEY);
        $file_path       = $enc_file_path->decrypt();
        
        if(!empty($file_path)){

            $content_type = 'application/pdf';
            $file = $file_path;

            if(NFS_SERVER_IP != ''){
                $checkNfsName = explode(IP_REPLACER_STRING, $file);
                    //log_message('error','#099 file_path='.$file);
                if(count($checkNfsName) > 1){
                    //log_message('error','#789 file_path='.$file);
                    //$file = '\\' . $file;
                    $file = str_replace(IP_REPLACER_STRING,'\\\\'.NFS_SERVER_IP, $file);
                    //log_message('error','#321 file_path='.$file);
                }
            }
            
            if($file){
                $content_type = check_nd_get_content_type($content_type, $file);

                $file_content = file_get_contents($file);
                header('Content-Type: '.$content_type);
                echo $file_content;
                exit;
                // header('Content-Length: ' . filesize($file));
                // ob_get_clean();

                /*
                $content = base64_encode(file_get_contents($file));
    
                $data = [
                            'content_type' => $content_type,
                            'base64encoded_data' => $content,
                        ];

                return $this->output
                            ->set_status_header('200')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data)); 
                */

                // $file_size_in_bytes = filesize($file);
                // echo $file;
                // die;
                
                // if($file_size_in_bytes > 2097152){
                //     header('Content-Description: File Transfer');
                //     header('Content-Type: application/force-download');
                //     header("Content-Disposition: attachment;");
                //     header('Content-Transfer-Encoding: binary');
                //     header('Expires: 0');
                //     header('Cache-Control: must-revalidate');
                //     header('Pragma: public');
                //     header('Content-Length: ' . $file_size_in_bytes);
                //     ob_clean();
                //     flush();
                //     echo readfile($file); //showing the path to the server where the file is to be download
                //     exit;
                //     // $data = [
                //     //     'content_type' => $content_type,
                //     //     'base64encoded_data' => '',
                //     //     'auto_download' => true
                //     // ];

                //     // return $this->output
                //     //             ->set_status_header('200')
                //     //             ->set_content_type('application/json')
                //     //             ->set_output(json_encode($data)); 

                //     // exit;
                // }else{
                //     // $content = base64_encode(file_get_contents($file));
                //     $content = file_get_contents($file);
    
                //     $data = [
                //                 'content_type' => $content_type,
                //                 'base64encoded_data' => $content,
                //                 'auto_download' => false
                //             ];
    
                //     return $this->output
                //                 ->set_status_header('200')
                //                 ->set_content_type('application/json')
                //                 ->set_output(json_encode($data)); 
                // }

                // echo json_encode([
                //                 'content_type' => $content_type,
                //                 'base64encoded_data' => $content_type,
                //             ]);
            }else{
                $data = [
                    'errors' => [],
                    'message' => 'No such file found'
                ];
                return $this->output
                            ->set_status_header('403')
                            ->set_content_type('application/json')
                            ->set_output(json_encode($data)); 
            }
        }
    }
    
    public function removeSupportiveDocs()
    {
        $location = $this->utilityclass->getLocationFromSession();
        $dist_code = $location['dist_code'];
        $case_no = $this->input->post('case_no');
        $flag = $this->input->post('flag');
        $val = explode('/',$case_no);
        $petition_no = $val[3];        

        $file_name = (($flag==1)?DEATH_CERTIFICATE:(($flag==2)?NOC:(($flag==3)?NOK_CONSENT:JAMABANDI)));
        if($flag==4){ $file_name = JAMABANDI; }

        $getFile = $this->db->query("SELECT id, fetch_file_name, file_path FROM supportive_document WHERE case_no=? AND file_name=?", array($case_no, $file_name))->row();
        $delete = $this->db->query("DELETE FROM supportive_document WHERE id=?", array($getFile->id));
        if($delete == true) {
            unlink($getFile->file_path);
            $validation['flag'] = $flag;
        }
        echo json_encode($validation);
    }
}//end of CI
