<div class='container-fluid login form-top'>
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th><?php echo $this->lang->line('case_no')?></th>
                        <th><?php echo $this->lang->line('entry_date')?></th>
                        <th><?php echo $this->lang->line('action')?></th>
                    </tr>
                    <?php foreach($cases as $case):?>
                    <tr>
                        <td><?php echo $case->case_no;?></td>
                        <td><?php echo date('d-m-Y',strtotime($case->date_entry));?></td>
                        <td>
                            <?php 
                                $link = base_url()."index.php"."/lmmutation/takeconsent?case_no=".base64_encode($case->case_no);
                            ?>
                            <a href='<?php echo $link;?>' class="btn btn-sm btn-success">
                                <i class='fa fa-check'></i><?php echo $this->lang->line('take_consent')?></a>
                        </td>
                    </tr>
                    <?php endforeach;?>
                </thead>
            </table>
             <?php echo($this->pagination->create_links());?>
        </div>
    </div>
</div>