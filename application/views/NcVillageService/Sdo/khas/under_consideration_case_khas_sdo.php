<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }

    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left" style="padding-bottom: 5px; padding-top: 10px">
            Process / <?php echo $this->lang->line('ncSidebar') ?> /
            <a href="<?= base_url()?>index.php/NcKhasLandSdo/NcKhasLandLandingPageSdo">
                <?php echo $this->lang->line('ncKhasLink') ?>
            </a> / Under Consideration List

            <a href="<?= base_url()?>index.php/NcKhasLandSdo/NcKhasLandLandingPageSdo">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu
                </button>
            </a>

            <?php if($this->session->flashdata('success')) { ?>
                <br>
                <div class="success-msg">
                    <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                    </div>
                </div>

            <?php } ?>

            <?php if($this->session->flashdata('error')) { ?>
                <br>
                <br>
                <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><?php echo $this->session->flashdata('error') ?></b>
                    <br>
                    <b><?php echo $this->session->flashdata('error_code') ?></b>
                </div>
            <?php } ?>
        </div>

        <div class="reza-card">
            <div class="reza-title">
                <span><?php echo $this->lang->line('ncKhasLandTitle') ?></span>
                <hr>
                <span><?php echo $this->lang->line('allSDLAConsideration') ?></span>
            </div>

            <div class="reza-body">

                <?php if ($pendingCaseCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('zeroCase') ?></div>
                <?php else : ?>
                    <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                        <thead>
                        <tr>
                            <th>SL No.</th>
                            <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?></label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('submission_date'); ?></label></th>
                            <th class="center"><label class="control-label">Consideration Reason</label></th>
                            <th class="center"><label class="control-label"><?php echo $this->lang->line('write_report'); ?></label></th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 0; foreach ($cases as $case):  $i++ ?>
                            <tr>
                                <td><?php echo $i ?> </td>
                                <td>
                                    <?php echo $case->case_no; ?><br>
                                    <span class='small font-italic red'>
                                        <?php if ($case->applid) {  echo "Basundhara:" . $case->applid;} ?>
                                    </span>
                                </td>
                                <td>
                                    <?php foreach(json_decode(PUT_UNDER_CONSIDERATION) as $cons){ ?>
                                        <?php if($cons->CODE == $case->consideration_code){ ?>
                                            <?php echo $cons->NAME  ?>
                                        <?php } ?>
                                    <?php } ?>
                                </td>

                                <td class="center"><i class='fa fa-calendar'></i> Submitted On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                <td class="center">
                                    <a class="btn btn-success" href="<?php echo base_url(); ?>index.php/NcKhasLandSdo/getNcKhasApplicationDetailsSdo/?case=<?php echo $case->case_no; ?>">
                                        <?php echo $this->lang->line('viewApp'); ?>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                        </tbody>

                    </table>
                <?php endif; ?>

            </div>

        </div>





    </div>
</div>