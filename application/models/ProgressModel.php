<?php
class ProgressModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }
    
    function saveBulkCasesByMeetingProgress($row_count, $total, $file)
    {
        if (PROG_MEET_GENERATE != '1' && PROG_MEET_AREA !='1' && PROG_MEET_APPROVE!='1')
            return json_encode(array("percent" => 100, "message" => 'Progress disabled'));
        
        if ($total > 0)
        {
            $percent = intval($row_count/$total * 100);        
            $arr_content['percent'] = $percent;
            $arr_content['message'] = 'Processed: '. $row_count . " of " . $total;        
            file_put_contents($file, json_encode($arr_content));
        }
    }
}