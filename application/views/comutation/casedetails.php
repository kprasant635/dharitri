<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        <?php echo $this->lang->line('co_order_confirm');?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('case_no'); ?> : <?php echo $case_no; ?></label>
                            <label class="col-sm-4 rasid">&nbsp;</label>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('date'); ?> : <?php echo date('d-m-Y'); ?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter' id='cases'>
                            <thead>
                                 <tr>
                                    <th class="center"><?php echo $this->lang->line('dag_no');?></th>
                                    <th class="center"><?php echo $this->lang->line('land_area');?></th>
                                    <th class="center"><?php echo $this->lang->line('patta_no');?></th>
                                    <th class="center"><?php echo $this->lang->line('patta_type');?></th>
                                </tr>
                            </thead>
                            <?php foreach ($dag_details as $d):?>
                                <tr>
                                <td class="center"><?php echo $d->dag_no; ?></td>
                                <td class="center"><?php echo $d->dag_area_b . "-" . $d->dag_area_k . "-" . $d->dag_area_lc; ?></td>
                                <td class="center"><?php echo $d->patta_no; ?></td>
                                <td class="center"><?php echo $d->patta_type; ?></td>
                                </tr>
                            <?php endforeach;?>
                        </table>
                       <hr>
                        <?php
                                if(isset($basundharaAttachment)){
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
                        <div>
                    <?php if(isset($basuCase)){ ?>
                    <button class="btn query btn-sm pull-right btn-success"><i class='fa fa-hand-paper-o'></i>Query to Applicant(s)</button>
                    <?php } ?>                           
                            <?php
                             if($query){
                          echo "<center class='uni_text text-danger'>All Query</center>";
                          echo "<table class='table'>";
                          echo "<th><tr class='bg-primary'><td>Submited Date</td><td>Your Query</td><td>Reply Date</td><td>Reply By User</td></tr></th>";
                          foreach($query as $q){
                            ?>
                              <tr>
                                <td><?=$q->date_of_query?></td>
                                <td><?=$q->query_text?></td>
                                <td><?=$q->date_of_reply?></td>
                                <td><?=$q->reply_text;
                                  if($q->app_doc_id){ 
                                    echo "<br>";
                                    echo "<a target='download' href='document/$q->app_doc_id'><i class='fa fa-paperclip'></i> Download </a> " ;
                                    }
                                ?></td>
                              </tr>
                            
                        <?php } echo "</table>"; } ?>
                        </div>
                        <?php if(isset($sup_doc) && sizeof($sup_doc)>0) { ?>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
                            <center class='text-danger text-bold'><b>View Supportive Document</b></center>
                            <table class="table table-striped table-bordered">
                                <tbody>
                                    <?php foreach($sup_doc as $doc) { ?>
                                    <tr>
                                        <td><span class="text-bold"><?=$doc->file_name?></span></td>
                                        <td>
                        <a style="color: red; text-decoration: none;" href="<?=base_url()?>index.php/lmmutation/downloadDocuments/<?=$doc->id?>" target="_blank">Click to View</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } ?> 
                        <center>
                            <a href='<?php echo base_url() . "index.php/COFieldMutation/coorder?case_no=" . $case_no . "&dist_code=" . $dist_code . "&subdiv_code=" . $subdiv_code . "&cir_code=" . $cir_code . "&mouza_pargona_code=" . $mouza_pargona_code . "&lot_no=" . $lot_no . "&vill_townprt_code=" . $vill_townprt_code; ?>' class="btn btn-success">
                                <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('pass_order');?>
                            </a>
                            <a href="#" class="hide btn btn-danger"><?php echo $this->lang->line('postpone_order');?></a>
                            <a href="<?php echo base_url(); ?>index.php/home/index/" class="btn btn-danger">
                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                            <button class="btn btn-warning" id='backtoLists'><i class="fa fa-arrow-left"></i> Back To Previous Case List(s)</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src='<?php echo base_url(); ?>application/views/images/load.gif'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
<!-- Modal HTML -->
<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/basundhara/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$basuCase?>">
            <div class="modal-body">
                <textarea name='query' class="form-control">Please enter your query</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#backtoLists').click(function(e){
        e.preventDefault();
        window.location.href=baseurl +'cofieldmutation/getPendingFMCases';
    });
</script>