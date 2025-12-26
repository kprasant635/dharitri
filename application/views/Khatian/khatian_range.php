<style>
    input[type="text"]{
        width:100% !important;
    }
    select{
        width:100% !important;
    }
    textarea{
        width: 100% !important; 
    }
    label{
        font-weight: normal !important;
        font-size: 12px !important;
    }
</style>
<div class="row login form-top">
    <div class="col-lg-10 col-lg-offset-1 ">

        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">Khatian View</h3>
            </div>
            <div class="panel-body">
                <form class="form-inline" method="post">

                    <div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>Khatian No Start</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="start">
                                <option>Khatian No Start</option>
                                <?php foreach($khatians as $k):?>
                                <option value="<?php echo $k->khatian_no;?>"><?php echo $k->khatian_no;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>Khatian No End</label>
                        <div class="col-sm-3">
                            <select class="form-control" name="end">
                                <option>Khatian No End</option>
                                <?php foreach($khatians as $k):?>
                                <option value="<?php echo $k->khatian_no;?>"><?php echo $k->khatian_no;?></option>
                                <?php endforeach;?>
                            </select>
                        </div>

                    </div>
                   
                    <hr style="border-bottom: 2px solid #000;">
                    <div class="form-group" style="width: 100%;text-align: center;">
                        <div class="">
                            <button type="submit" class="btn uni_text btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>