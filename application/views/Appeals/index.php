
<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-8 col-lg-offset-2">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('appeal_header') ?></h3>
                </div>
                <div class="panel-body">
                    <form action="<?php echo base_url()."index.php/Appeals";?>" method="post">
                        <div class="input-group">
                            <input type="text" class="form-control" name="case_no" placeholder="Enter Case Number">
                            <div class="input-group-btn">
                                <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>