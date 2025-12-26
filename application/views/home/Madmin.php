<style>
    .casedisplay {
        min-height: 0px;
    }

    .casedisplay-small {
        min-height: 120px;
    }

    .casedisplay:hover{
        -webkit-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        -moz-box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
        box-shadow: 0px 0px 5px 0px rgba(0,0,0,0.75);
    }
    td{
        font-size: .9em;
    }
</style>
<div class="container-fluid login home" style="min-height:500px;">
    <div class="row">
        <div class="col-lg-12">
            <table class='table' style="color:blue;">
                <tr>
                    <td><label class="regular"><i class="fa fa-tachometer"></i> SUPER ADMIN ( STATE CONSULTANT ) DASHBOARD</label></td>
                    <td><?php //include 'login_alert.php'; ?></td>
                </tr>
            </table>
            <div class="row">
                <div class="col-lg-5">
                    <div class="panel casedisplay">
                        <div class="panel-body">
                            <table class="table table-striped table-hover">
                                <tr>
                                    <td>Manage Menu Bar</td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <a class="pull-right green" href="<?php echo base_url() . 'index.php/initialization/menubarcontrol'; ?>"><?php echo $this->lang->line('view') ?> <i class='fa fa-angle-double-right'></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Chitha Basic Backup For Year Wise Display</td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <a class="pull-right green" href="<?php echo base_url() . 'index.php/initialization/backup_for_chitha'; ?>"><?php echo $this->lang->line('view') ?> <i class='fa fa-angle-double-right'></i></a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Jamabandi Backup For Doul</td>
                                    <td>&nbsp;</td>
                                    <td>
                                        <a class="pull-right green" href="<?php echo base_url() . 'index.php/initialization/backup_for_doul'; ?>"><?php echo $this->lang->line('view') ?> <i class='fa fa-angle-double-right'></i></a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        
    </div>
</div>


