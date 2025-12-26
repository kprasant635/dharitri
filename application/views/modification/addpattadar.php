<div class="row login">


    <div class="col-lg-12 ">
        <div class="col-lg-10" style="margin: 0 auto;float: none;">
            <div class='row'>
                <div class="panel panel-info panel-form">
                    <div class='panel-heading'>
                        <div class="panel-title">
                            <p class='center bold'>Pattadar Modifications</p>
                        </div>
                    </div>
                    <div class='panel-body'>
                        <form class='form-horizontal' action="<?php echo base_url() . "index.php/officemutation/mutationapplicantDetails"; ?>" method="post">
                            <p class="uni_text">Existing Pattadars</p>
                            <?php foreach($pattadars as $p):?>
                            <div class="row">
                                <div class="col-lg-6"><p class="uni_text"><?php echo $p->pdar_name;?></p></div>
                                <div class="col-lg-6">
                                    <a class="btn btn-danger">Delete</a>
                                    <a class="btn btn-danger">Edit</a>
                                </div>
                            </div>
                            <hr>
                            <?php endforeach;?>
                            <div class="row">
                                <div class="col-lg-6">
                                   <a href='#' class="btn btn-info">Add Pattadar</a>
                                </div>
                               
                            </div>
                            <hr>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label required">Pattadar Name</label>
                                <div class="col-sm-6">
                                    <input type="text" class="form-control" maxlength='10' name="pdar_mobile" required id="applicantNam" required">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-3" style="margin: 0 auto;float: none;margin-top: 20px;margin-bottom: 20px;">
                                    <button type="submit" id="submit" class="btn btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button') ?></button>
                                    <a href='<?php echo base_url() . "index.php/officemutation/pattadarDetails"; ?> '  class="btn btn-danger"><i class='fa fa-check'></i><?php echo $this->lang->line('next') ?></a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




