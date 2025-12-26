<?php
class EscalationHolidayModel extends CI_Model {

  public function __construct() {
    parent::__construct();
  }

  public function getHoliday($date, $db)
  {
    // check if execute day is holiday
    $query = $db->query("SELECT holiday_date FROM holiday_details WHERE holiday_date=?", array($date));

    if($query->num_rows() == 1)
    {
      $executeDate = $query->rows()->holiday_date;


    }
  }


}
?>