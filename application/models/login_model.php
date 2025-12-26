<?php

class user_login extends CI_Model{
    
    public function login_check($data)
    {
        $password=$data['pwd'];
        $username=$data['uname'];
    }
}

