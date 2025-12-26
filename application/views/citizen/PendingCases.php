<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <?php if ($this->session->userdata('message')): ?>
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong><?php
                        echo $this->session->userdata('message');
                        $this->session->unset_userdata('message');
                        ?>
                    </div>
                <?php endif; ?>
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">Verify Citizen Centric Cases</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('pending_cases'); ?>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                            <thead>
                                <th><label class="control-label"><?php echo $this->lang->line('case_no'); ?> / Refference No</label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('certificate_type');?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('submission_date')?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('delivery_date')?></label></th>
                                <th><label class="control-label"><?php echo $this->lang->line('status')?></label></th>
                            </thead>
                            <?php foreach ($cases as $case): ?>
                                <tr>
                                    <td class="center">
                                        <?php 
                                        echo $case->cert_no;
                                        if($case->application_ref_no){
                                            echo "<br>(".$case->application_ref_no.")";
                                        }                                       
                                        ?>
                                        
                                        <span class='small font-italic red'><?php if($case->basundhara){ echo "RTPS:". $case->basundhara ;} ?> </span>

                                    </td>
                                    <td><?php echo $this->utilityclass->getCertName($case->cert_type) ; ?></td>
                                    <td class='center'><i class='fa fa-calendar'></i> Submited On <?php echo date('d-m-Y', strtotime($case->date_entry)); ?></td>
                                    <td class='center'><i class='fa fa-calendar'></i> 
                                        <?php if(date('d-m-Y', strtotime($case->next_due_date)) == '01-01-1970'){
                                                if($case->cert_type=='01'){//if its jamabandi nakal then the expected date should be 5 days
                                                    echo "Expected On ".date('d-m-Y', strtotime($case->date_entry. ' + 5 days'));
                                                } else {
                                                    echo "Not Declared";
                                                }
                                            } else {
                                                echo "Expected On ".date('d-m-Y', strtotime($case->next_due_date));
                                            }
                                            ?>
                                        </td>
                                        <td class="center">
                                            <a class='btn btn-sm btn-danger' href="<?php echo base_url().'index.php/CitizenController/LMStep2' ?>?cert_no=<?php echo $case->cert_no ?>"><?php echo $this->lang->line('write_report');?></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </table>
                            
                            <center>
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> 
