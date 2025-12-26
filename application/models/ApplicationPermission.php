<?php
class ApplicationPermission extends CI_Model {
    public function store($connection, $user_code, $app_id, $service_id){
        $usercode = $this->session->userdata('user_code');        

                
        $insert_data = [
            'user_code' => $user_code,
            'app_id' => $app_id,
            'service_id' => $service_id,
            'created_by' => $usercode,
            'updated_by' => $usercode
        ];

        $connection->insert('application_permissions', $insert_data);
        $query = $this->db->query("SELECT currval('application_permissions_id_seq') AS last_id");  
        $row = $query->row();
        $insertedID = $row->last_id;

        $update_data = [
            'permission_allowed' => 1,
            'parent_code' => $usercode,
        ];
        $connection->where('user_code', $user_code);
        $connection->update('loginuser_table', $update_data);
        
        $this->create_log($connection, $insertedID);

        if ($connection->trans_status() === FALSE) {
            throw new Exception("Something went wrong!");
        }
    }

    public function revert($connection, $user_code, $app_id, $service_id){
        $app_permission = $connection->where('user_code', $user_code)->where('app_id', $app_id)->get('application_permissions')->row_array();

        $archived_data = [
            'case_no' => "DELETE_PERMISSION",
            'date' => date('Y-m-d H:i:s'),
            'table_name' => "application_permissions",
            'data' => json_encode($app_permission)
        ];
        $this->db->insert('archive_data', $archived_data);

        $this->db->where('user_code', $user_code);
        $this->db->where('app_id', $app_id);
        $this->db->delete('application_permissions');

        $update_data = [
            'permission_allowed' => 0,
            'parent_code' => '',
        ];
        $connection->where('user_code', $user_code);
        $connection->update('loginuser_table', $update_data);

        if ($connection->trans_status() === FALSE) {
            throw new Exception("Something went wrong!");
        }
    }

    public function create_log($connection, $insertedID){
        $app_permission = $connection->where('id', $insertedID)->get('application_permissions')->row_array();
        $insert_data = [
            'application_permission_id' => $insertedID,
            'user_code' => $app_permission['user_code'],
            'app_id' => $app_permission['app_id'],
            'service_id' => $app_permission['service_id'],
            'write' => $app_permission['write'],
            'read' => $app_permission['read'],
            'created_by' => $app_permission['created_by'],
            'updated_by' => $app_permission['updated_by']
        ];

        $connection->insert('application_permission_logs', $insert_data);
    }

    public function getPermission($connection, $user_code, $app_id, $service_id){
        return $connection->where('user_code', $user_code)->where('app_id', $app_id)->where('service_id', $service_id)->get('application_permissions')->row_array();
    }
}
?>
