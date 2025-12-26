<style type="text/css">
    .alink{
    background: #2b7c1c;
    padding: 3px;
    color: #fff;
    border-radius: 8px;
    text-decoration: none;
    }

</style>
<?php
$dist_code=$this->session->userdata('dist_code');?>
<?php if(ESCALATION_MODAL_OPEN == 1){ include 'escalation_co.php'; }?>
<?php if(NC_VILLAGE_PORT == 1){ include 'nc_message.php'; }?>


<?php if(CIRCLE_WISE_LAND_CLASS_AND_RATE_CHECK == '1' && $co_block_flag == 'not_updated'): ?>
    <div class="bg-dark text-warning h5 col-lg-10 offset-1 mt-5 text-center p-3">
        LAND CLASS AND RATE UPDATION FOR THIS CIRCLE HAS NOT BEEN COMPLETED. ONCE THE CONVERSION OF LAND CLASSES IS FINISHED, THE REMAINING DHARITREE MODULES WILL BECOME ACCESSIBLE.
    </div>

<?php elseif(EKHAJANA_CO_PENDING_CONTROL == '1' && $ekhajana_pending_co_cases>0 && (!in_array($this->session->userdata('dist_code',EKHAJANA_EXCLUDE_DISTRICT_FROM_EKHAJANA_PROCESS)))): ?>
    <div class="bg-dark text-danger h5 col-lg-10 offset-1 mt-5 text-center p-3">
        NO OF EKHAZANA PENDING CASES (TILL-YESTERDAY): <?=$ekhajana_pending_co_cases?><br>
        AFTER CLEARING THE PENDING CASES, THE REST OF THE DHARITREE MODULES CAN BE ACCESSED. 
    </div>
<?php else: ?>  
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="row">
        <?php

        if(GET_BHUMIPUTRA_STATUS == 1) {

            $class = "col-lg-6 col-md-6 col-sm-6 col-xs-12";

            ?>
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <a href="<?=base_url().'index.php/load-bhumiputra-view'?>" target="_bhumi">
                    <button class="btn btn-xs btn-primary pull-left"><i class="fa fa-search"></i> Get Bhumiputra Status</button>
                </a>
            </div>
        <?php } else { $class = "col-lg-12 col-md-12 col-sm-12 col-xs-12"; } ?>


        <div class="<?=$class?>">
            <a href="<?=base_url().'index.php/searching-data'?>" target="_searching">
                <button class="btn btn-xs btn-danger pull-right"><i class="fa fa-search"></i> Search your cases here</button>
            </a>
        </div>
    </div>
</div>
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div><hr>

<div class="container-fluid">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background-color: #ffffff !important">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
        </ol>
    </nav>
    <?php if ($this->session->flashdata('message')): ?>
        <?php include 'message.php'; ?>
    <?php endif; ?>
    <?php if ($this->session->flashdata('validation_msg')): ?>
        <?php include 'validation.php'; ?>
    <?php endif; ?>
    <div class="dash_content_area">
        <div class="col-lg-12">
            <div class="row"> <!--Second Row Start-->
                <!-- <a href="<?=base_url().'index.php/Rtps/ins_list'?>" target="" style="color: red;">Download recieved application list for Non Individual Entities in this circle</a>
                <a href="<?=base_url().'index.php/Rtps/dlr_list'?>" target="" style="color: red;">Download non settleable application list forwarded by DLRS </a> -->
                <?php if(ESCALATION_ENABLE == 1){ ?>
                    <div class="container-fluid">
                        <h5>Service wise Escalated List (From LM/SK to CO) </h5>
                        <p style="color:red;font-weight: bold;">Note : Revert the cases for taking action as the case has not been passed in the given timeframe</p>
                        <table class="table table-striped table-hover">
                            <tr>
                                <td><a class="alink" href="<?=base_url().'index.php/EscalatedListController/loadEscalatedViewPage?service='.$this->utilityclass->encryptJwtCase(FMUT)?>">Field Mutation</a></td>
                                <td><a class="alink" href="<?=base_url().'index.php/EscalatedListController/loadEscalatedViewPage?service='.$this->utilityclass->encryptJwtCase(OMUT)?>">Office Mutation</a></td>
                                <td><a class="alink" href="<?=base_url().'index.php/EscalatedListController/loadEscalatedViewPage?service='.$this->utilityclass->encryptJwtCase(FPART)?>">Field Partition</a></td>
                                <td><a class="alink" href="<?=base_url().'index.php/EscalatedListController/loadEscalatedViewPage?service='.$this->utilityclass->encryptJwtCase(OPART)?>">Office Partition</a></td>
                                <td><a class="alink" href="<?=base_url().'index.php/EscalatedListController/loadEscalatedViewPage?service='.$this->utilityclass->encryptJwtCase(MINC_SERV)?>">Name Correction</a></td>
                                <td><a class="alink" href="<?=base_url().'index.php/EscalatedListController/loadEscalatedViewPage?service='.$this->utilityclass->encryptJwtCase(RECLASS_SERV)?>">Reclassification</a></td>
                                <td><a class="alink" href="<?=base_url().'index.php/EscalatedListController/loadEscalatedViewPage?service='.$this->utilityclass->encryptJwtCase(ALLOT_SERV)?>">AC to PP</a></td>
                            </tr>
                        </table>
                    
                    </div>
                <?php } ?>
                
                <div class="col-lg-4">
                    <div class="card bg-info text-white">
                        <div class="card-body text-white">
                            <h5 class="card-title"><img src="<?php echo base_url('assets/recieved.png');?>" style="height:22px;width:22px;" alt="New Applications"> New Applications received today
                            </h5>
                        </div>
                        <div class="card-footer">
                            <small class="text-white"> Cases: <span class="" style="font-size: 22px"><?=$all_field?></span> </small>
                        </div>
                        <div class="card-footer">
                            <small class="text-white"></small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <h5 class="card-title"><img src="<?php echo base_url('assets/processing.png');?>" style="height:22px;width:22px;" alt="Pending Applications"> Pending Applications</h5>
                        </div>
                        <div class="card-footer">
                            <small class="text-white">Cases: <span class="" style="font-size: 22px"><?=$pen_field?> </span> </small>
                        </div>
                        <div class="card-footer">
                            <small class="text-white"></small>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <h5 class="card-title"><img src="<?php echo base_url('assets/completed.png');?>" style="height:22px;width:22px;" alt="Completed Applications"> Completed Applications</h5>
                        </div>
                        <div class="card-footer">
                            <small class="text-white">Cases: <span class="" style="font-size: 22px"><?=$del_field?></span> </small>
                        </div>
                        <div class="card-footer">
                            <small class="text-white"></small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!--Second Row End-->
    <p>Detailed breakdown of pending cases:</p>
    <div class="col-lg-12">
        <div class="row ban-min-cards"> <!--Second Row Start-->
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <a href="" title="Click here for a detailed view" class="card-title">Mutation</a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Office: <span class="" style="font-size: 22px"><a href="<?php echo base_url(); ?>index.php/home/MutationCoOM"><?=$o_mut?></span></a></small>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src="<?php echo base_url('assets/fieldnew.png');?>" alt="Field"> Field:<span class="" style="font-size: 22px"><a href="<?php echo base_url(); ?>index.php/cofieldmutation/getPendingFMCases"> <?=$field_mut?></span></a></small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <a href="" title="Click here for a detailed view" class="card-title">Partition</a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Office: <span class="" style="font-size: 22px"><a href="<?php echo base_url(); ?>index.php/home/PartitionCoOP"><?=$o_part?></span></a></small>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src="<?php echo base_url('assets/fieldnew.png');?>" alt="Field"> Field: <span class="" style="font-size: 22px"><a href="<?php echo base_url(); ?>index.php/cofieldmutation/getPendingpartitionCases"><?=$field_part?></span></small></a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <a href="" title="Click here for a detailed view" class="card-title">Conversion</a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases:<span class="" style="font-size: 22px"><a href="<?php echo base_url(); ?>index.php/home/ConversionCo"> <?=$conversion?></span></a></small>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src="" > </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <a href="" title="Click here for a detailed view" class="card-title">Reclassification</a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases:<span class="" style="font-size: 22px"> <a href="<?php echo base_url(); ?>index.php/LandReclassification/GoToRE?pro=1"><?=$reclassification?></span></a></small>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src=""> </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <a href="" title="Click here for a detailed view" class="card-title">Citizen Certificate</a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases:<span class="" style="font-size: 22px"> <a href="<?php echo base_url(); ?>index.php/CitizenController/COStep1"><?=$certificate?></span></a></small>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src=""> </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <a href="" title="Click here for a detailed view" class="card-title">AP Cancellation</a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <span class="" style="font-size: 22px"><a href="<?php echo base_url(); ?>index.php/home/ApcCo"><?=$apcases?></span></a></small>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src=""></small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <a href="" title="Click here for a detailed view" class="card-title">AC to PP</a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <span class="" style="font-size: 22px"><a href="<?php echo base_url(); ?>index.php/home/AcPPCo"><?=$acpp?></span></a></small>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src=""> </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <a href="" title="Click here for a detailed view" class="card-title">Settlement</a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <span class="" style="font-size: 22px"><a href="<?php echo base_url(); ?>index.php/settlement/cofinalpendingcase"><?=$settlement?></span></a></small>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src=""> </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="card">
                    <div class="card-body">
                        <a href="" title="Click here for a detailed view" class="card-title">Misc Case</a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src="<?php echo base_url('assets/officenew.png');?>" alt="Office"> Cases: <span class="" style="font-size: 22px"><a href="<?php echo base_url(); ?>index.php/home/MiscCo"><?=$misccases?></span></a></small>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted"><img src=""> </small>
                    </div>
                </div>
            </div>

        </div>
    </div><!--Second Row End-->
</div>
<?php 
if(ENABLE_SNA_MODULE == 1){
    $dist_code =$this->session->userdata('dist_code');
    $subdiv_code =$this->session->userdata('subdiv_code');
    $cir_code =$this->session->userdata('cir_code');
    $user_code =$this->session->userdata('user_code');
    $checkSnaReportSubmitted = $this->SnaReportModel->checkSnaReportSubmitted($dist_code,$subdiv_code,$cir_code,$user_code);
    if($checkSnaReportSubmitted =="NOT_FOUND"){
        include 'sna_modal.php'; 
    }
}
?>
</div>
</div>
<?php endif ?>

<?php if (!empty($show_mb2_alert) && $show_mb2_alert): ?>
<!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const pendingCount = <?php echo (int)$pending_count; ?>;

    function showPendingAlert() {
        Swal.fire({
            icon: 'warning',
            title: 'Pending MB2 Cases',
            html: `You have <strong style="color: red; font-size: 1.2em;">${pendingCount}</strong> pending MB2 Perpetual and review case(s) in your circle. Please process them first.`,
            confirmButtonText: 'OK'
        });
    }

    // Show immediately
    showPendingAlert();

    // Show again every 10 seconds (for testing; change to 3600000 for 1 hour)
    setInterval(showPendingAlert, 3600000); 
});
</script>

<?php endif; ?>



<?php// include 'sna_modal.php'; ?>