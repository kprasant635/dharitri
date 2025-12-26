<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> 
                        <?php echo $this->lang->line('sk_report_for_case_no'); ?> <?php echo $case_no;?> <?php echo $this->lang->line('for_dag(s)'); ?> 
                        <?php 
                            // Added by Abhijit -- 2024-05-02
                            $dags_arr = [];
                            foreach($dag_no as $dag){
                                array_push($dags_arr, $dag->dag_no);
                            }
                            echo implode(', ', $dags_arr);


                            // foreach($dag_no as $dag )echo $dag->dag_no.".";
                        ?>
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
            <div class="error_container">
                        <?php
                            if($this->session->flashdata('message')){
                        ?>
                            <div class="alert alert-warning alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong class="text-danger">
                                    <?= $this->session->flashdata('message'); ?>
                                </strong>
                            </div>
                        <?php
                            }
                        ?>
                    </div>
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                             <?php echo $this->lang->line('sk_report_label'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal' action="<?php echo base_url() . "index.php/skmutation/saveReport"; ?>" method="post">
                            <input type="hidden" name='case_no' value="<?php echo $case_no;?>"/>
                            <textarea class='form-control' rows='10' name='sk_note' required="">সকলো  তথ্য় সঠিক পোৱা গ'ল । মন্ডলৰ প্ৰতিবেদন ছোৱা হ'ল | </textarea>
                            <hr style="border-bottom: 2px solid #000;">
                            <?php
                                if($basundharaAttachment){
                                echo '<h2 class="red">Other Attachments</h2>';
                                foreach ($basundharaAttachment  as $attachment):
                                ?>
                                <h6><a href="<?php echo base_url()."index.php/basundhara/document/".$attachment->name  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->name;?> (Click to see the attachment)</a></h6>
                                <?php 
                                endforeach; 
                                }
                            ?>
                            <?php if($basuCase){ ?>
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
                                    echo "<a target='download' href='".base_url() ."index.php/basundhara/document/$q->app_doc_id'><i class='fa fa-paperclip'></i> Download </a> " ;
                                    }
                                ?></td>
                              </tr>
                            
                        <?php } echo "</table>"; } ?>
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" class="fieldmutpart btn btn-success"><i class='fa fa-save'></i>&nbsp;Save Report</button>
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
            <?php
                    if($this->session->flashdata('query_mdl_message')){
                ?>
                    <div class="alert alert-warning alert-dismissible show" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong class="text-danger">
                            <?= $this->session->flashdata('query_mdl_message'); ?>
                        </strong>
                    </div>
                <?php
                    }
            ?>
                <textarea name='query' class="form-control">Please enter your query</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>
<script>
     $(function () {
        <?php
        if($this->session->flashdata('query_mdl_message')){
        ?>
        $('#myModal1').modal('show');
        <?php
            }
        ?>
    });
</script>          
<!--  -->