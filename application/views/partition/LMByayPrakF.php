<div class="container-fluid form-top">
    <div class="row">
        <div class="col-lg-5 col-lg-offset-3">
            
        <?php
            $lmcode='M117';
            $q="Select * from LM_code WHERE LM_code='$lmcode' ";
            $result=$this->db->query($q)->row();
            $dist_code=$result->dist_code;
            $subdiv_code=$result->subdiv_code;
            $cir_code=$result->cir_code;
            $lot_no=$result->lot_no;
            $mouza_pargona_code=$result->mouza_pargona_code;
            $locationData = array(
            'dist_code' => $result->dist_code,
            'subdiv_code' => $result->subdiv_code,
            'cir_code' => $result->cir_code,
            'lot_no' => $result->lot_no,
            'mouza_pargona_code' => $result->mouza_pargona_code,
            );
            //$locationdata[]= $locationData;
            $this->session->set_userdata($locationData);
            //var_dump($locationData);
            
            $sql="SELECT * FROM Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' "
                    . "and mouza_pargona_code='$mouza_pargona_code' and lot_no='$lot_no' and mut_type='04' and not_fresh='Y' and byayprak_yn is null order by year_no,petition_no";
            $data=$this->db->query($sql)->result();
            //echo sizeof($data);
            foreach($data as $d)
            {
            $vill_townprt_code=$d->vill_townprt_code;
            $year_no=$d->year_no;
            $location=array(
                'vill_townprt_code'=>$vill_townprt_code,
                'year_no'=>$year_no);
           // var_dump($location);
            $this->session->set_userdata($location);
            ?>
                <a href="<?php echo base_url(); ?>index.php/partition/LmByayPrak?petition_no=<?php echo $d->petition_no ?>&case_no=<?php echo $d->case_no ?>" class="uni_text"><?php echo $d->case_no ?> </a>
                <br>
            <?php
            }
        ?>
           total number of pending cases <?php echo sizeof($data);?>     
        </div>
    </div>
</div>

