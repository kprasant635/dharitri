<?php

class zonalByforcationModel extends CI_Model
{

    function __construct()
    {
        parent::__construct();
    }

    function getZonalDagVillwise($start, $length, $order, $dist_code, $subdiv_code, $cir_code, $village_code)
    {
        $village_code = $village_code;
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }

        $sql = "select * from location where subdiv_code=? and 
                    cir_code=? and mouza_pargona_code!=?
                    and lot_no!=? and vill_townprt_code!=? and nc_btad is null
                     order by subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code limit $length offset $start";
        $query = $this->db->query($sql, array($subdiv_code, $cir_code, '00', '00', '00000'));

        $data['location_details'] = $query->result_array();


        $sql1 = "select * from location where subdiv_code=? and 
                    cir_code=? and mouza_pargona_code!=?
                    and lot_no!=? and vill_townprt_code!=? and nc_btad is null
                     order by subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code";
        $query1 = $this->db->query($sql1, array($subdiv_code, $cir_code, '00', '00', '00000'));


        $data['total_records'] = $query1->num_rows();

        foreach ($data['location_details'] as $val) {

            $sql25 = "SELECT COUNT(*) AS zonal FROM (SELECT DISTINCT dag_no,unique_village_code FROM dagwise_zone_info WHERE unique_village_code=?) AS zonal";
            $count25 = $this->db->query($sql25, array($val['uuid']))->row();

            $sql33 = "SELECT COUNT(*) AS approved FROM (SELECT DISTINCT dag_no,unique_village_code FROM dagwise_zone_info WHERE unique_village_code=? AND flag=?) AS zonal";
            $count33 = $this->db->query($sql33, array($val['uuid'], '1'))->row();


            $sql26 = "Select count(*) as chitha from chitha_basic where subdiv_code=? 
                    and cir_code=? and mouza_pargona_code=?
                    and lot_no=? and vill_townprt_code=? and 
                    (subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code) 
                    in (select subdiv_code,cir_code,mouza_pargona_code, lot_no,vill_townprt_code from 
                    location where (nc_btad is null or TRIM(nc_btad) = '') and subdiv_code=?  
                    and cir_code=? and mouza_pargona_code=? and lot_no=? and  vill_townprt_code=?)";

            $count26 = $this->db->query($sql26, array(
                $val['subdiv_code'], $val['cir_code'],
                $val['mouza_pargona_code'], $val['lot_no'], $val['vill_townprt_code'], $val['subdiv_code'], $val['cir_code'],
                $val['mouza_pargona_code'], $val['lot_no'], $val['vill_townprt_code']
            ))->row();

            $result_data[] = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $val['lot_no'],
                'vill_uuid' => $val['uuid'],
                'vill_townprt_code' => $val['vill_townprt_code'],
                'zonal_dags' => $count25->zonal,
                'chitha_dags' => $count26->chitha,
                'pending_dags' => ($count26->chitha) - ($count25->zonal),
                'approve_dags' => $count33->approved,
            ];
        }
        $data['data_results'] = $result_data;

        return $data;
    }

    public function getVillageUUIDListLocation($dist_code, $subdiv_code, $circle_code)
    {

        $uniqueVill = $this->db->query("select uuid as village_uuid from  location where dist_code ='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code'  group by uuid");
        return $uniqueVill->result();
    }


    // Zonal Village Villagewiise
    function getVillageZonalDetailsVillwise($start, $length, $order, $dist_code, $subdiv_code, $cir_code, $village_code)

    {
        $village_code = $village_code;
        $col = 0;
        $dir = "";
        if (!empty($order)) {
            foreach ($order as $o) {
                $col = $o['column'];
                $dir = $o['dir'];
            }
        }
        if ($dir != "asc" && $dir != 'desc') {
            $dir = 'desc';
        }
        if ($order != null) {
            $this->db->order_by($order, $dir);
        }
        $sql = "select * from location where subdiv_code=? and 
                    cir_code=? and mouza_pargona_code!=?
                    and lot_no!=? and vill_townprt_code!=? and nc_btad is null
                     order by subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code limit $length offset $start";
        $query = $this->db->query($sql, array($subdiv_code, $cir_code, '00', '00', '00000'));

        $data['location_details'] = $query->result_array();

        $sql1 = "select * from location where subdiv_code=? and 
                    cir_code=? and mouza_pargona_code!=?
                    and lot_no!=? and vill_townprt_code!=? and nc_btad is null
                     order by subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code";
        $query1 = $this->db->query($sql1, array($subdiv_code, $cir_code, '00', '00', '00000'));

        $data['total_records'] = $query1->num_rows();

        foreach ($data['location_details'] as $val) {

            $sql29 = "Select count(DISTINCT unique_village_code) as zonal from villagewise_zone_info 
                        where unique_village_code=?";
            $count29 = $this->db->query($sql29, array($val['uuid']))->row();

            $sql34 = "Select count(*) as  flag from villagewise_zone_info 
                        where unique_village_code=? and flag=?";
            $flag34 = $this->db->query($sql34, array($val['uuid'], '1'))->row();

            $result_data[] = [
                'dist_code' => $dist_code,
                'subdiv_code' => $subdiv_code,
                'cir_code' => $cir_code,
                'lot_no' => $val['lot_no'],
                'vill_uuid' => $val['uuid'],
                'vill_townprt_code' => $val['vill_townprt_code'],
                'zonal_village' => $count29->zonal,
                'zonal_village_flag' => $flag34->flag,
            ];
        }
        $data['data_results'] = $result_data;
        return $data;
    }



    // ALternate
    function getZonalDagCirclewiseDc($dist_code)
    {

        $sql = "select subdiv_code,cir_code from location where subdiv_code!=? and 
                    cir_code!=? and mouza_pargona_code=?
                    and lot_no=? and vill_townprt_code=? and nc_btad is null
                     order by subdiv_code,cir_code,mouza_pargona_code,lot_no,vill_townprt_code";
        $query = $this->db->query($sql, array('00', '00', '00', '00', '00000'));

        $data['location_details'] = $query->result_array();

        foreach ($data['location_details'] as $val) {

            $sql25 = "SELECT COUNT(*) AS zonal FROM (SELECT DISTINCT dag_no,unique_village_code FROM dagwise_zone_info where 
                subdiv_code=? and cir_code=? and mouza_pargona_code!=?
                and lot_no!=? and vill_code!=?) AS zonal";

            $count25 = $this->db->query($sql25, array($val['subdiv_code'], $val['cir_code'], '00', '00', '00000'))->row();

            $sql33 = "SELECT COUNT(*) AS approved FROM (SELECT DISTINCT dag_no,unique_village_code FROM dagwise_zone_info where 
                subdiv_code=? and cir_code=? and mouza_pargona_code!=?
                and lot_no!=? and vill_code!=? and flag=?) AS approved";
            $count33 = $this->db->query($sql33, array($val['subdiv_code'], $val['cir_code'], '00', '00', '00000', '1'))->row();


            $sql26 = "Select count(*) as chitha from chitha_basic where 
				subdiv_code=? and cir_code=? and 
				    (subdiv_code,cir_code) 
				    in (select subdiv_code,cir_code from 
				    location where (nc_btad is null or TRIM(nc_btad) = '') and subdiv_code=?  
				    and cir_code=?)";
            $count26 = $this->db->query($sql26, array($val['subdiv_code'], $val['cir_code'], $val['subdiv_code'], $val['cir_code']))->row();


            $result_data[] = [
                'dist_code' => $dist_code,
                'subdiv_code' => $val['subdiv_code'],
                'cir_code' => $val['cir_code'],
                'zonal_dags' => $count25->zonal,
                'chitha_dags' => $count26->chitha,
                'pending_dags' => ($count26->chitha) - ($count25->zonal),
                'approve_dags' => $count33->approved,
            ];
        }
        $data['data_results'] = $result_data;

        return $data;
    }
}
