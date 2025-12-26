<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Composite Service Case Search </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Case Search Utility Module
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form name='frmDelete' method='post' action='<?php echo base_url() . "index.php/CompositeService/compServiceCaseView"; ?>'>
                            <table class="table table-striped table-bordered">
                                <tbody>
                                <tr class="text-bold table-success">
                                    <th width="33%">Case No Search :
                                        <input type="radio" style="width: 15px; height: 15px" name="type" value="C" class="order checkthis" checked required>
                                    </th>
                                    <th width="33%">Deed No Search :
                                        <input type="radio" style="width: 15px; height: 15px" name="type" value="D" class="order" required>
                                    </th>
                                    <th width="34%">NOC No Search :
                                        <input type="radio" style="width: 15px; height: 15px" name="type" value="N" class="order" required>
                                    </th>
                                </tr>
                                <tr>
                                    <th>Enter Case No/ Deed No/ NOC No : </th>
                                    <th colspan="2">
                                        <input type="text" placeholder="Enter Case No/Deed No/NOC No.." name="case_no" required='' class="form-control input-lg"  autocomplete="off">
                                    </th>
                                </tr>
                                </tbody>
                            </table>
                            <hr style="border-bottom: 2px solid #000;">
                            <?php if($this->session->flashdata('message')):?>
                            <div class="red h5 bold center"><?= $this->session->flashdata('message'); ?></div>
                            <?php endif; ?>
                            <div class="form-group center">
                                <div class="col-lg-12">
                                    <button type="submit" name="del_button" id="sbutton" onclick="return delconfirm()" class="btn btn-primary"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
