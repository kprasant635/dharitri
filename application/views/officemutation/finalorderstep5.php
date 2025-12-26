<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <p class="regular"><?php echo "Select Dag for Along With/Inplace of Details"?>
                            <span class='pull-right'>
                          <?php echo $this->lang->line('case_no')?><?php echo $case_no . "  <span class='badge'>Date:" . date('d-m-y') . "</span>"; ?>
                            </span>
                        </p>
                </div>
                <div class="panel-body">
                    <?php $link = base_url() . "index.php/coofficemutation/finalOrderStep5"; ?>
                    <form method="post" action="<?php echo $link; ?>" class="form-horizontal">
                        <input type='hidden' name='case_no' value='<?php echo $case_no; ?>' />
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
                            <button type="submit" name='show_details' value="pass" class="btn btn-danger"><?php echo $this->lang->line('show_details')?></button>
                        </div>
                    </form>
                </div>
                <hr>



            </div>
        </div>
    </div>
</div>