<div class="container-fluid form-top">
    <div class="row">
        <div class="col-lg-5 col-lg-offset-3">
            <?php
            $dist_code=$this->session->userdata('dist_code');
            $subdiv_code=$this->session->userdata('subdiv_code');
            $cir_code=$this->session->userdata('cir_code');
            
            $dist_code='12'; $subdiv_code='01';$cir_code='06';
            $sql="SELECT * FROM Petition_basic WHERE dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' and not_fresh='Y' and sk_comment is null and (not lm_note_date is null) and order_passed is null order by mut_type,Year_no,Petition_no";
            //echo $sql;
            $data=$this->db->query($sql)->result();
            //var_dump($data);                     
            foreach($data as $d)
            {
            ?>
            <a href="<?php echo base_url()?>index.php/partition/SKPartitionRedirect?case_no=<?php echo $d->case_no ?>&vill=<?php echo $d->vill_townprt_code;?>&m=<?php echo $d->mouza_pargona_code?>&l=<?php echo $d->lot_no?>&p=<?php echo $d->petition_no?>&y=<?php echo $d->year_no?>"><?php echo $d->case_no?></a>
            <?php
            }
            ?>
            
        </div>
    </div>
</div>