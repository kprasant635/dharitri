<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <div class="panel-title">
                      <?php echo $this->lang->line('sk_report_for_case_no'); ?> <?=$this->input->get('case_no');?>
                    </div>                   
                </div>
                <?php
                            if($this->session->flashdata('message')){
                        ?>
<div class="error_container">
                            <div class="alert alert-warning alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong class="text-danger">
                                    <?= $this->session->flashdata('message'); ?>
                                </strong>
                            </div>
  </div>
                        <?php
                            }
                        ?>
                <div class="panel-body">
                    <?php  $action = base_url()."index.php/skmutation/writeofficereport";?>
                    <form class="form-horizontal" method="post" action="<?php echo $action;?>">
                        <?php if(ESCALATION_ENABLE == 1){ ?>
                            <!-- <input type="text" name="executionDate" value="<?=date('Y-m-d H:i:s');?>">    -->
                        <?php } ?>
                        
                        <input type="hidden" name="petition_no" value="<?php echo $petition_no;?>"/>
                        <input type="hidden" name="case_no" value="<?php echo $case_no;?>"/>
                        <table class="table table-bordered">
                            <tr>
                                <td><?php echo $this->lang->line('dag_no'); ?></td>
                                <td><?php echo $this->lang->line('detailed_report'); ?></td>
                            </tr>
                            <?php foreach($dags as $d):?>
                            <td><input type="hidden" name="dag_sk_note[]" value="<?php echo $d->dag_no;?>"><?php echo $d->dag_no;?></td>
                            
                            <td><textarea style="width:100%;height: 200px;" name="sk_note[]">লট মন্ডলৰ প্ৰতিবেদন ছোৱা হ'ল | সকলো  তথ্য় সঠিক পোৱা গ'ল  | নামজাৰী কৰিব পাৰে |
</textarea></td>
                            <?php endforeach;?>
                        </table>
                        <?php
                                if(!empty($attachment)){
                                echo '<h2 class="red">Other Attachments</h2>';
                                
                                foreach ($attachment  as $attachment):
                                //var_dump($attachment);
                                ?>
                                <h6><a href="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$attachment->path .'&refNo=' . $pb->application_ref_no .'&type='. 4 ; ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->doc_name;?> (Click to see the attachment)</a></h6>
                                <?php 
                                endforeach; 
                                }
                            ?>
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
                        <div class="form-group" style="text-align: center">
                            <button type="submit" class="btn btn-danger"><?php echo $this->lang->line('submit'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>