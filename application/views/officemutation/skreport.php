<div class="container-fluid login form-top">
    <div class='row'>
        <div class='col-lg-12' style="margin: 0 auto;float: none;">
           
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular"><?php echo $this->lang->line('sk_report')?>(<?php echo $this->lang->line('case_no');?> -<?php echo $case_no;?>)</p>
                    </div>
                </div>
                <div class="panel-body">
                    <table class='table table-striped table-bordered tablesorter' id='cases' style="text-align: center;">
                        <thead>
                            <tr>
                                <th class='alert-new'><?php echo $this->lang->line('dag_no')?></th>
                                <th class='alert-new'><?php echo $this->lang->line('sk_report')?></th>
                            </tr>
                        </thead>
                        <tr>
                            <td><?php echo $dag->dag_no;?></td>
                            <td><?php echo $note->sk_note;?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>