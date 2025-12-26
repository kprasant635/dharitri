<?php
 class method extends CI_Model {
     

    
     public function insertdata($data)
    {
        //load the database  
        $this->load->database();
        //insert query where students is table name & $data is inserted data array
        $result=$this->db->insert('students',$data);
        return $result;
    }
    public function viewdata(){
        //load the database  
        $this->load->database();
        
        $this->db->order_by("name", "ASC"); 
        
        
        //select data from   table name students
        
        $data=$this->db->get('students');
        //return the result to the controller
        return $data;
    }
    
    public function deletedata($name){
        //load the database  
        $this->load->database();
        //put the where condition
        $this->db->where('sl', $name);
        //delete query
        $result=$this->db->delete('students');
        return $result;
    }
    public function view1data($sl){
        //load the database  
        $this->load->database();
        
        //put the where condition
        $this->db->where('sl', $sl);
        
        
        //select data from   table name students
        $result=$this->db->get('students');
        
        return $result;
        
    }
    public function updatedata($data,$sl){
        
        //load the database  
        $this->load->database();
        
        //put the where condition
        $this->db->where('sl', $sl);
        
        //select data from   table name students
        $result=$this->db->update('students',$data);
        return $result;
    }
    
    public function  searchdata($searchinput){
        //load the database  
        $this->load->database();
        
        $this->db->like('name', $searchinput);
        
        //select data from   table name students
        $result1=$this->db->get('students');
        
        return $result1;
    }
 }
