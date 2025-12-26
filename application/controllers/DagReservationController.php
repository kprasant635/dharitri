<?php 

class DagReservationController extends CI_Controller
 {
     public function __construct() {
        parent::__construct();
    }


public function dag_reservation()
{
    $uuid = '10000000004212';
    $start_range = '100';
    $mid_range = '50';

    // $uuid = $this->input->post('uuid');
    // $start_range = $this->input->post('start_range');
    // $mid_range = $this->input->post('mid_range');

    $loc_code = $this->getLocIdfrumUUID($uuid);

    $this->db->trans_begin();

    $dag_nos = $this->db->query("SELECT dag_no FROM chitha_basic WHERE dist_code=? 
            AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? AND lot_no=? 
            AND vill_townprt_code=? ORDER BY dag_no_int DESC", 
            array($loc_code->dist_code, $loc_code->subdiv_code, $loc_code->cir_code, $loc_code->mouza_pargona_code, 
                $loc_code->lot_no, $loc_code->vill_townprt_code))->row();

    $new_dag = $dag_nos->dag_no;
    $start_dag = $new_dag + $start_range;
    $end_dag = $start_dag + $mid_range;

    $insertArr = [
                'uuid' => $uuid,
                'dag_no'=> $new_dag,
                'start_dag' => $start_dag,
                'end_dag' =>  $end_dag,
                'created_time' => date('Y-m-d G:i:s'),
                //'updated_time' => date('Y-m-d G:i:s')
            ];
            $insertProc = $this->db->insert('dag_reservation_log', $insertArr);
            if($insertProc != 1){
                $this->db->trans_rollback();
                log_message('error', '#ERRCO0004: Insertion failed in dag_reservation_log');
                $json = [
                    'responseType' => 3,
                    'message' => '#ERRCO0004: Failed to insert. Kindly contact System Administrator',
                ];
                echo json_encode($json);
                return false;
            }
       $this->db->trans_commit();      

}

public function getLocIdfrumUUID($uuid) {
        $CI = & get_instance();
        return $this->db->query("SELECT * FROM location WHERE uuid='$uuid'")->row();
    }


public function createTrigger()
{
    $triggerFunctionSQL = "CREATE OR REPLACE FUNCTION check_dag_range_in_reservation()
RETURNS trigger AS $$
DECLARE
    dag_num INTEGER;
    loc_uuid BIGINT;
BEGIN
    -- Convert the new dag_no to integer
    dag_num := NEW.dag_no::INTEGER;

    -- Get the uuid from location table
    SELECT uuid INTO loc_uuid
    FROM location
    WHERE 
        dist_code = NEW.dist_code AND
        subdiv_code = NEW.subdiv_code AND
        cir_code = NEW.cir_code AND
        mouza_pargona_code = NEW.mouza_pargona_code AND
        lot_no = NEW.lot_no AND
        vill_townprt_code = NEW.vill_townprt_code;

    -- If the uuid exists, check dag reservation
    IF EXISTS (
        SELECT 1
        FROM dag_reservation_log
        WHERE uuid = loc_uuid
          AND dag_num BETWEEN start_dag::INTEGER AND end_dag::INTEGER
    ) THEN
        RAISE EXCEPTION 'DAG No % in chitha_basic conflicts with reserved range for this location in dag_reservation_log.', NEW.dag_no;
    END IF;

    RETURN NEW;
END;
$$ LANGUAGE plpgsql;
";


    $createTriggerSQL = "CREATE TRIGGER trg_check_dag_reservation
                BEFORE INSERT OR UPDATE ON chitha_basic
                FOR EACH ROW
                EXECUTE FUNCTION check_dag_range_in_reservation();";


    $this->db->query($triggerFunctionSQL);
    $this->db->query($createTriggerSQL);

    echo "Trigger and trigger function created successfully.";
}

public function removeTrigger(){
    $removetrigger = "DROP TRIGGER IF EXISTS trg_check_dag_reservation ON public.chitha_basic";
    $this->db->query($removetrigger);
    echo "Trigger removed successfully.";
}


public function dag_reservation_new()
{
    $dagData = [
        ['uuid' => '10000000018930', 'dag_range' => '210-211', 'dist_code' => '35'],
        ['uuid' => '10000000019093', 'dag_range' => '117-254', 'dist_code' => '35'],
        // ['uuid' => '10000000015976', 'dag_range' => '402-798', 'dist_code' => '25'],
        // ['uuid' => '10000000016044', 'dag_range' => '249-422', 'dist_code' => '25'],
        // ['uuid' => '10000000016109', 'dag_range' => '528-935', 'dist_code' => '25'],
        // ['uuid' => '10000000016035', 'dag_range' => '214-493', 'dist_code' => '25'],
        // ['uuid' => '10000000015301', 'dag_range' => '258-561', 'dist_code' => '25'],
        // ['uuid' => '10000000015975', 'dag_range' => '1564-1732', 'dist_code' => '25'],
        // ['uuid' => '10000000015300', 'dag_range' => '270-459', 'dist_code' => '25'],
        // ['uuid' => '10000000015483', 'dag_range' => '498-835', 'dist_code' => '25'],
    ];

    foreach ($dagData as $data) {
        $uuid = $data['uuid'];
        $dist_code = $data['dist_code'];
        $start_range = 100;

        // Split and calculate mid_range
        list($range_start, $range_end) = explode('-', $data['dag_range']);
        $mid_range = (int)$range_end - (int)$range_start;

        $mid_range = $mid_range + 2;


        $this->dbswitch($dist_code);  // Make sure this method exists

        // Get location codes from UUID
        $loc_code = $this->getLocIdfrumUUID($uuid);

        $this->db->trans_begin();

        // Get latest dag_no
        $dag_nos = $this->db->query(
            "SELECT dag_no FROM chitha_basic WHERE dist_code=? 
             AND subdiv_code=? AND cir_code=? AND mouza_pargona_code=? 
             AND lot_no=? AND vill_townprt_code=? 
             ORDER BY dag_no_int DESC LIMIT 1",
            array(
                $loc_code->dist_code,
                $loc_code->subdiv_code,
                $loc_code->cir_code,
                $loc_code->mouza_pargona_code,
                $loc_code->lot_no,
                $loc_code->vill_townprt_code
            )
        )->row();

        if (!$dag_nos) {
            $this->db->trans_rollback();
            log_message('error', "No DAG found for UUID: $uuid");
            return;
        }

        $new_dag = (int)$dag_nos->dag_no;
        $start_dag = $new_dag + $start_range;
        $end_dag = $start_dag + $mid_range;

        if($start_dag >= $range_start)
        {
            $this->db->trans_rollback();
            log_message('error', "Not Allowed found for UUID: $uuid");
            return;
        }

        $insertArr = [
            'uuid' => $uuid,
            'dag_no' => $new_dag,
            'start_dag' => $start_dag,
            'end_dag' => $end_dag,
            'created_time' => date('Y-m-d H:i:s'),
        ];

        $insertProc = $this->db->insert('dag_reservation_log', $insertArr);

        if (!$insertProc) {
            $this->db->trans_rollback();
            log_message('error', "#ERRCO0004: Insertion failed for UUID: $uuid");
            return;
        }

        $this->db->trans_commit();
    }

    echo json_encode([
        'responseType' => 1,
        'message' => 'DAG reservation completed for all entries.',
    ]);
}

}
