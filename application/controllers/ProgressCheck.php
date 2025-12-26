<?php
class ProgressCheck extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();        
    }
    function checkProgressBulkCaseByMeeting()
    {    	
    	if (PROG_MEET_GENERATE != '1' && PROG_MEET_AREA !='1' && PROG_MEET_APPROVE!='1')
    		return  json_encode(array("percent" => 100, "message" => 'Progress disabled'));
    	

    	// The file has JSON type.
		header('Content-Type: application/json');

		// Prepare the file name from the query string.
		// Don't use session_start here. Otherwise this file will be only executed after the process.php execution is done.
		$file = str_replace(".", "", $_GET['file']);

		$file = PROGRESS_DIR . $file . ".txt";
		$this->check($file);
    }
    
    function check($file)
    {
    	// Make sure the file is exist.
		if (file_exists($file)) {
		  // Get the content and echo it.
		  $text = file_get_contents($file);
		  echo $text;

		  // Convert to JSON to read the status.
		  $obj = json_decode($text);
		  // If the process is finished, delete the file.
		  if (isset($obj->percent) && $obj->percent == 100) {
		    unlink($file);
		  }
		}
		else {
		  echo json_encode(array("percent" => null, "message" => null));
		}    
    }    
}
