<?php

define('ENABLE_REPLICATION_DB', 1); // 1: ENABLE, 0: DISABLE

class DataBaseSwitchModel extends CI_Model {

  public function __construct() {
    parent::__construct();
  }

  // switch dharitree database
  public function dharDbSwitch($distCode, $refDb = null)
  {
    // var_dump($distCode);die;
    if($distCode == "02")         
    {
      $refDb = $this->load->database('dha3', TRUE);   // Dhubri
    } 
    else if($distCode == "03") 
    {
      $refDb = $this->load->database('dha8', TRUE);   // Goalpara
    }
    else if($distCode == "05") 
    {
      $refDb = $this->load->database('dha1', TRUE);   // Barpeta
    } 
    else if($distCode == "06") 
    {
      $refDb = $this->load->database('dha11', TRUE);  // Nalabar
    }
    else if($distCode == "07") 
    {
      $refDb = $this->load->database('dha7', TRUE);   // Kamrup
    } 
    else if($distCode == "08") 
    {
      $refDb = $this->load->database('dha19', TRUE);  // Darrang
    }
    else if($distCode == "10") 
    {
      $refDb = $this->load->database('dha24', TRUE);  // Chirang
    } 
    else if($distCode == "11") 
    {
      $refDb = $this->load->database('dha12', TRUE);  // Sonitpur
    }
    else if($distCode == "12") 
    {
      $refDb = $this->load->database('dha13', TRUE);  // Lakhimpur
    }
    else if($distCode == "13") 
    {
      $refDb = $this->load->database('dha2', TRUE);   // Bongaigaon
    }  
    else if($distCode == "14") 
    {
      $refDb = $this->load->database('dha6', TRUE);   // Golaghat
    } 
    else if($distCode == "15") 
    {
      $refDb = $this->load->database('dha5', TRUE);   // Jorhat
    } 
    else if($distCode == "16") 
    {
      $refDb = $this->load->database('dha14', TRUE); // Sivsagar
    }
    else if($distCode == "17") 
    {
      $refDb = $this->load->database('dha4', TRUE);   // Dibrugarh
    } 
    else if($distCode == "18") 
    {
      $refDb = $this->load->database('dha9', TRUE);   // Tinsukia
    } 
    else if($distCode == "21") 
    {
      $refDb = $this->load->database('dha18', TRUE); // Karimganj
    }  
    else if($distCode == "24") 
    {
      $refDb = $this->load->database('dha10', TRUE);   // Kamrup Metro
    } 
    else if($distCode == "25") 
    {
      $refDb = $this->load->database('dha23', TRUE);   // Dhemaji
    }
    else if($distCode == "32") 
    {
      $refDb = $this->load->database('dha15', TRUE);   // Morigaon
    } 
    else if($distCode == "33") 
    {
      $refDb = $this->load->database('dha16', TRUE);   // Nagaon
    } 
    else if($distCode == "34") 
    {
      $refDb = $this->load->database('dha17', TRUE);   // Majuli
    }
    else if($distCode == "35") 
    {
      $refDb = $this->load->database('dha20', TRUE);   // Biswanath
    } 
    else if($distCode == "36") 
    {
      $refDb = $this->load->database('dha21', TRUE);   // Hojai
    } 
    else if($distCode == "37") 
    {
      $refDb = $this->load->database('dha22', TRUE);   // Saraideo
    } 
    else if ($distCode == "38")
    {
      $refDb = $this->load->database('dha25', true);   // South Salmara
    }
    else if ($distCode == "39")
    {
      $refDb = $this->load->database('dha39', true);   // Bajali
    }  
    else if ($distCode == "22")
    {
      $refDb = $this->load->database('dha41', true);   // Bajali
    }    
    // echo "I am in main database";
    return $refDb;
  }

  // for replication
  public function dharReplDbSwitch($distCode, $refDb = null)
  {
    if(ENABLE_REPLICATION_DB == 0) // if replication disabled, switch to main DB
    {
      $refDb = $this->dharDbSwitch($distCode);
    }
    else
    {
      if($distCode == "02")         
      {
        $refDb = $this->load->database('dha3', TRUE);   // Dhubri
      } 
      else if($distCode == "03") 
      {
        $refDb = $this->load->database('dha8', TRUE);   // Goalpara
      }
      else if($distCode == "05") 
      {
        $refDb = $this->load->database('dha1', TRUE);   // Barpeta
      } 
      else if($distCode == "06") 
      {
        $refDb = $this->load->database('dha11', TRUE);  // Nalabar
      }
      else if($distCode == "07") 
      {
        $refDb = $this->load->database('dha7', TRUE);   // Kamrup
      } 
      else if($distCode == "08") 
      {
        $refDb = $this->load->database('dha19', TRUE);  // Darrang
      }
      else if($distCode == "10") 
      {
        $refDb = $this->load->database('dha24', TRUE);  // Chirang
      } 
      else if($distCode == "11") 
      {
        $refDb = $this->load->database('dha12', TRUE);  // Sonitpur
      }
      else if($distCode == "12") 
      {
        $refDb = $this->load->database('dha13', TRUE);  // Lakhimpur
      }
      else if($distCode == "13") 
      {
        $refDb = $this->load->database('dha2', TRUE);   // Bongaigaon
      }  
      else if($distCode == "14") 
      {
        $refDb = $this->load->database('dha6', TRUE);   // Golaghat
      } 
      else if($distCode == "15") 
      {
        $refDb = $this->load->database('dha5', TRUE);   // Jorhat
      } 
      else if($distCode == "16") 
      {
        $refDb = $this->load->database('dha14', TRUE);   // Sivsagar
      }
      else if($distCode == "17") 
      {
        $refDb=$this->load->database('dha4', TRUE);     // Dibrugarh
      } 
      else if($distCode == "18") 
      {
        $refDb = $this->load->database('dha9', TRUE);   // Tinsukia
      } 
      else if($distCode == "21") 
      {
        $refDb = $this->load->database('dha18', TRUE);   // Karimganj
      }  
      else if($distCode == "24") 
      {
        $refDb = $this->load->database('dha10', TRUE);   // Kamrup Metro
      } 
      else if($distCode == "25") 
      {
        $refDb = $this->load->database('dha23', TRUE);   // Dhemaji
      }
      else if($distCode == "32") 
      {
        $refDb = $this->load->database('dha15', TRUE);   // Morigaon
      } 
      else if($distCode == "33") 
      {
        $refDb = $this->load->database('dha16', TRUE);   // Nagaon
      } 
      else if($distCode == "34") 
      {
        $refDb = $this->load->database('dha17', TRUE);   // Majuli
      }
      else if($distCode == "35") 
      {
        $refDb = $this->load->database('dha20', TRUE);   // Biswanath
      } 
      else if($distCode == "36") 
      {
        $refDb = $this->load->database('dha21', TRUE);   // Hojai
      } 
      else if($distCode == "37") 
      {
        $refDb = $this->load->database('dha22', TRUE);   // Saraideo
      } 
      else if ($distCode == "38")
      {
        $refDb = $this->load->database('dha25', true);   // South Salmara
      }
      else if ($distCode == "39")
      {
        $refDb = $this->load->database('dha39', true);   // Bajali
      }
      // echo "I am in replicaton database";
      return $refDb;
    }    
  }

}