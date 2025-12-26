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
<div class="container-fluid home" style="min-height:500px;">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="panel casedisplay">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular">Chitha Modification Process</p>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <tr>
                            <td>Edit Pattadar Details</td>
                            <td><span class="badge" style="background:red;"></span></td>
                            <td><a href="<?php echo base_url().'index.php/RecordCorrectionController/editPattadars';?>" style='float:right'>GO</a></td>
                        </tr>
                        <tr>
                            <td>Edit Land Area Details</td>
                            <td><span class="badge" style="background:red;"></span></td>
                            <td><a href="#" style='float:right'>GO</a></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>