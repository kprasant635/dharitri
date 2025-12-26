<?php //var_dump($details); ?>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular"><?php echo $this->lang->line('cases_for_notice_generation');?></p>
                    </div>
                </div>
                <div class="panel-body">
                    <form method="post">
                        <input type="hidden" name="case_no" value="<?php echo $case_no;?>"/>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class='alert-new'><?php echo $this->lang->line('serial_number');?></th>
                                    <th class='alert-new'><?php echo $this->lang->line('order_and_signature_of_officer');?></th>
                                    <th class='alert-new'><?php echo $this->lang->line('note_of_action_taken_on_order');?></th>
                                </tr>
                            </thead>
                            
                            <tbody>
                                <?php foreach($details as $case):?>
                                <tr>
                                    <td><?php echo $case->proceeding_id;?></td>
                                    <td><?php echo $case->co_order;?></td>
                                    <td>
                                        <textarea rows="5" readonly cols="50" name="note[<?php echo $case->proceeding_id;?>]"><?php echo $case->note_on_order;?></textarea>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>

                        </table>
                        <!--<div class="form-group " style="text-align: center;">
                            <button type="submit" class="btn btn-danger"><?php echo $this->lang->line('submit_button');?></button>
                        </div>-->
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>