<div class="container-fluid login form-top">
    <div class='row'>
        <div class='col-lg-12' style="margin: 0 auto;float: none;">
                <div class="alert alert-danger" role="alert">
                    (Kindly Check Chitha First)  Click on The <kbd>Update Chitha</kbd> button  if  order  isn't  reflected in chitha <kbd>Delete & Pass Again</kbd> will help you to pass it again
                </div>
            <table class='table table-stripped pageshowpage' id='cases'>
                <thead>
                    <tr>
                        <th class='alert-new'><?php echo $this->lang->line('case_no')?></th>
<!--                        <th>Case Type</th>-->
                        <th class='alert-new'><?php echo $this->lang->line('order_date')?></th>
                        <th class='alert-new'><?php echo $this->lang->line('action')?></th>
                    </tr>
                </thead>
                <?php
                foreach ($cases as $case): ?>
                    <tr>
                        <td><?php echo $case->case_no; ?> <br>
                            <span class='small font-italic red'><?php if($case->basundhara){ echo "Basundhara:". $case->basundhara ;} ?> </span></td>
                        <td><?php echo date('d-m-Y',strtotime($case->co_ord_date)); ?></td>
                        <td>
                            <?php $str= $case->dist_code."/".$case->subdiv_code."/".
                                    $case->cir_code."/".$case->mouza_pargona_code."/"
                                    . $case->lot_no."/"
                                    . $case->vill_townprt_code."/".$case->petition_no."/".$case->dag_no;
                                    ;?>
                            <a class="btn btn-success btn-sm" href="<?php echo base_url().'index.php/COFieldMutation/autoupdate/'.$str?>"><i class='fa fa-remove'></i> Update Chitha</a>
                            <a class="btn btn-danger btn-sm" href="<?php echo base_url(); ?>index.php/COFieldMutation/updatePartition_order?case_no=<?php echo $case->case_no ?>"><i class='fa fa-check'></i> Delete & Pass Again</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
            <?php // echo $this->pagination->create_links();?>
        </div>
    </div>
</div>