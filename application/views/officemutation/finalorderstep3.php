<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular"><?php echo $this->lang->line('select_one_dag_no_to_enter_in_favour_of_details')?></p>
                    </div>
                </div>
                <div class="panel-body">
                    <?php $link = base_url()."index.php/coofficemutation/finalOrderStep3";?>
                    <form method="post" action="<?php echo $link;?>" class="form-horizontal">
                        <div class="form-group">
                            <label for="" class="col-sm-3 uni_text control-label col-sm-offset-2"><?php echo $this->lang->line('dag_no')?> </label>
                           
                            <div class="col-sm-3">
                                <select class="form-control">
                                    <?php foreach ($data as $d): ?>
                                        <option value='<?php echo $d->dag_no; ?>'><?php echo $d->dag_no; ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>
                        </div>
                        <div style="text-align: center;">
                        <button type="submit" name='show_details' value="pass" class="btn btn-primary"><?php echo $this->lang->line('show_details')?></button>
                        </div>
                    </form>
                </div>
                <hr>



            </div>
        </div>
    </div>
</div>