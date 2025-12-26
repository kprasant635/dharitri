<?php
class AddProccedings extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Add proceeding with required case_no and optional overrides
     *
     * @param string $case_no
     * @param array $overrides Optional values to override default data
     * @return int|bool Inserted ID or false
     */
   public function quickAddSP(string $case_no, array $overrides = [])
    {
        $defaultData = [
            'case_no' => $case_no,
            'date_of_hearing' => date('Y-m-d H:i:sP'),
            'co_order' => 'N/A',
            'note_on_order' => 'N/A',
            'next_date_of_hearing' => date('Y-m-d H:i:sP', strtotime('+30 days')),
            'status' => 'Pending',
            'user_code' => $this->session->userdata('user_code') ?? 'SYS',
            'date_entry' => date('Y-m-d H:i:sP'),
            'operation' => 'AD',
            'ip' => $this->input->ip_address(),
            'office_from' => 'SYSTEM',
            'office_to' => 'SYSTEM',
            'proceeding_id' => null,
            'task' => 'Auto Entry',
            'minutes_proposal_id' => null,
            'note_type' => 'Auto-generated',
        ];

        // Merge, then override protected fields with system defaults
        $data = array_merge($defaultData, $overrides);

        // Force override protected fields
        $data['date_of_hearing'] = $defaultData['date_of_hearing'];
        $data['co_order'] = $defaultData['co_order'];
        $data['user_code'] = $defaultData['user_code'];
        $data['date_entry'] = $defaultData['date_entry'];
        $data['operation'] = $defaultData['operation'];
        $data['ip'] = $defaultData['ip'];
        $data['proceeding_id'] = $defaultData['proceeding_id'];

        // Insert into DB
        $inserted = $this->db->insert('settlement_proceeding', $data);
        return $inserted ? $this->db->insert_id() : false;
    }

}
