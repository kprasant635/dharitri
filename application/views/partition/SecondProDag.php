<div class="container-fluid login form-top">
    <div class="row ">
        <div class="col-lg-10 panel panel-default panel-body col-lg-offset-1">
            <h2 class="uni_text center"><?php echo $this->lang->line('co_order');?></h2>
            <?php //print_r($values); print_r($patta)?>
            <hr>
            <div class="col-lg-4 uni_text"> <?php echo $this->lang->line('case_no');?> : <?php echo $this->session->userdata('case_no');?> </div>
            <div class="col-lg-4 uni_text"><?php echo $this->lang->line('order_srno')?> : 3  </div>
            <div class="col-lg-4 uni_text"><?php echo $this->lang->line('date')?> : <?php echo date('d-m-Y')?></div>
            <hr>
            <div >
            <p class="uni_text text-center text-danger" style="margin-top: 25px; "> <?php echo $this->lang->line('applicant_dag_dtls')?></p>
            
            <table class="table table-hover table-bordered" style="margin-top: 15px">
                <tr >
                    <td class='alert-new'><?php echo $this->lang->line('dag_no'); ?></td>
                    <td class='alert-new'><?php echo $this->lang->line('applicant_portion'); ?>(B-K-L)</td>
                    <td class='alert-new'><?php echo $this->lang->line('patta_no'); ?></td>
                    <td class='alert-new'><?php echo $this->lang->line('patta_type'); ?></td>
                    <td class='alert-new'><?php echo $this->lang->line('govt_land_type'); ?></td>
                </tr>
                <tr>
                    <td><?php echo $values->dag_no;?></td><td><?php echo $values->m_dag_area_b."-".$values->m_dag_area_k."-".$values->m_dag_area_lc?></td><td><?php echo $values->patta_no;?></td><td><?php echo $patta->patta_type?></td><td><?php echo $this->lang->line('no_data')?></td>
                </tr>
            </table>
            
            </div>
            <form action="<?php echo base_url();?>index.php/partition/CORMKOrder" method="POST">
                <button type="submit" class="btn btn-primary hidden"> << Keep Pending</button>
                <button type="submit" class="btn btn-info col-lg-offset-5 uni_text"><?php echo $this->lang->line('submit_button')?> >></button>
            </form>
        </div>
    </div>
</div>