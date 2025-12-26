<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular">Note of All Officer(s)</p>
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
                                <th class='alert-new'>Created Date</th>
                            </tr>
                            </thead>

                            <tbody>
                            <?php foreach($details as $case):?>
                                <tr>
                                    <td><?php echo $case->proceeding_id;?></td>
                                    <td><?php echo $case->note_on_order;?></td>
                                    <td>
                                        <?php echo $case->note;?>
                                    </td>
                                    <td>
                                        <?php echo date('d-m-Y', strtotime($case->created_date));?>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>