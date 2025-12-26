<style type="text/css">
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url('<?php echo base_url(); ?>application/views/images/load.gif') 50% 50% no-repeat rgb(249,249,249);
        opacity: .9;
    }
</style>
<div class="loader"></div> 
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Field Mutation
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-body">
                        <div class="col-lg-12">
                            <center><h4><u>Location Details</u></h4></center>
                                <table class="table">
                                        <tr class="table-primary">
                                            <td>District Name: <?=$this->utilityclass->getDistrictName($fmb['dist_code'])?></td>
                                            <td>Subdivision Name: <?=$this->utilityclass->getSubDivName($fmb['dist_code'],$fmb['subdiv_code'])?></td>
                                            <td>Circle Name: <?=$this->utilityclass->getCircleName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'])?></td>
                                        </tr>
                                        <tr class="table-primary">
                                            <td>Mouza Name: <?=$this->utilityclass->getMouzaName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'],$fmb['mouza_pargona_code'])?></td>
                                            <td>Lot Name: <?=$this->utilityclass->getLotName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'],$fmb['mouza_pargona_code'],$fmb['lot_no'])?></td>
                                            <td>Village Name: <?=$this->utilityclass->getVillageName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'],$fmb['mouza_pargona_code'],$fmb['lot_no'],$fmb['vill_townprt_code'])?></td>
                                        </tr>
                                </table>
                                <center><h4><u>First Party Information</u></h4></center>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <td>Applicant Name</td>
                                            <td>Gurdian Name</td>
                                            <td>Relation</td>
                                            <td>Address</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($applicant as $app) :?>
                                        <tr>
                                            <td><?=$app['pet_name']?></td>
                                            <td><?=$app['guard_name']?></td>
                                            <td><?=$this->utilityclass->appRelation($app['guard_rel'])?></td>
                                            <td><?=$app['add1'].$app['add2']?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <center><h4><u>Second Party Information</u></h4></center>
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr class="table-primary">
                                            <td>Applicant Name</td>
                                            <td>Gurdian Name</td>
                                            <td>Inplace/Alongwith</td>
                                            <td>Type</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($seller as $app) :?>
                                        <tr>
                                            <td><?=$app['pdar_name']?></td>
                                            <td><?=$app['pdar_guardian']?></td>
                                            <td><?=$app['inplace']?></td>
                                            <td><?=$this->utilityclass->getTransferType($fmb['trans_code'])?></td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                                <center><h4><u>Land Details</u></h4></center>
                                <table class="table">
                                    <tbody>
                                        <?php foreach ($fmd as $dag) :?>
                                        <tr class="table-primary">
                                            <td>Patta Type: <?=$this->utilityclass->getPattaName($dag['patta_type_code'])?> </td>
                                            <td>Patta No: <?=$dag['patta_no']?></td>
                                            <td>Dag No: <?=$dag['dag_no']?></td>
                                        </tr>
                                        <tr class="table-info">
                                            <td>Applied Bigha: <?= $dag['m_dag_area_b']?> </td>
                                            <td>Applied Katha: <?= $dag['m_dag_area_k']?></td>
                                            <td>Applied Lessa: <?= $dag['m_dag_area_lc']?></td>
                                        </tr>
                                        <tr class="table-warning">
                                            <td>Total Bigha: <?= $dag['dag_area_b']?> </td>
                                            <td>Total Katha: <?=$dag['dag_area_k']?></td>
                                            <td>Total Lessa: <?=number_format($dag['dag_area_lc'],2)?></td>
                                        </tr>
                                        <tr class="table-success">
                                            <td>Rajah Adalat: <?=$fmb['rajah_adalat']=='0' ?'No':'Yes'?> </td>
                                            <td>Dispute: <?=$fmb['dispute_yn']=='0' ?'No':'Yes'?></td>
                                            <td>Possession: <?=$fmb['possession_yn']==null ?'':'Have Possession'; ?></td>
                                        </tr>
                                        <tr class="table-success">
                                            <td colspan="3">Mondal  Note: <?= $dag['remark']?> </td>
                                           </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                        </div>
                        <div class="col-lg-12">
                            <label class="col-sm-4">
                                Mondols Name : <?php $lmName=$this->utilityclass->getDefinedMondalsName($fmb['dist_code'],$fmb['subdiv_code'],$fmb['cir_code'],$fmb['mouza_pargona_code'],$fmb['lot_no'],$fmb['user_code']);
                                echo $lmName->lm_name;
                                ?> </label>
                            <label class="col-sm-4 rasid">
                                Mondal Note Date : <?=$fmb['date_entry']?>
                            </label>
                        </div>
                        <hr>
                        <?php
                                if($basundharaAttachment){
                                echo '<h2 class="red">Basundhara Attachments</h2> <ul>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <li class="uni_text"><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></li>
                                <?php 
                                endforeach; 
                                echo "</ul>";
                                }
                            ?>
                        <hr>
                       <center><a onclick="LoadData();" href="<?php echo base_url(); ?>index.php/COFieldMutation/passOrderNew?case=<?=$fmb['case_no']?>" class="btn btn-sm btn-success">Pass Order</a></center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style type="text/css">
.table-primary> td {
    background-color: #338AFF !important;
    color:#fff; 
}
.table-info>td {
    background-color: #CFBCA3 !important;
    color:#fff; 
}
.table-warning>td {
    background-color: #64856B !important;
    color:#fff; 
}
.table-success>td {
    background-color: #7A7C78 !important;
    color:#fff; 
}
</style>
<script type="text/javascript">
    $(window).load(function() {
         $(".loader").fadeOut();
    });
    $(document).ajaxStart(function(e){
        $(".loader").fadeOut();
    });
    $(document).ajaxComplete(function(e){
       $(".loader").fadeOut();
    });
</script>
<script language="javascript" type="text/javascript">
    $(window).load(function () {
        $('#loading').hide();
    });
    function LoadData() {
        $("#loading").show();
        $('#myModal').modal({
            backdrop: 'static',
            keyboard: true,
            show: true
        });
    }
</script>  
<div class="modal fade modal-transparent" style="margin-top: 250px" id='myModal' >
    <div class="" role="document"> 

        <center>
            <img id="loading-image" style="" width="100px" src= "<?php echo base_url(); ?>application/views/images/load.gif" alt="Loading..." />
            <h2 style="color:#fff   " >Please Wait ! </h2>
            <h5 style="color: #fff   ">The Generation of Chitha Report might take some time. </h5>
        </center>

    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->