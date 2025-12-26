<div class="container-fluid form-top login">
    <div class='row'>
        <?php //var_dump($fieldmp); ?>
        <div class='col-lg-10 panel panel-default panel-body' style="margin: 0 auto;float: none;">
           <table class="table table-striped table-hover">
                        <tr class="success">
                            <td><?php echo $this->lang->line('district'); ?> :<?php  echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code')); ?></td>
                            <td><?php echo $this->lang->line('subdivision'); ?> :<?php  echo $this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code')); ?></td>
                            <td><?php echo $this->lang->line('circle'); ?> :<?php  echo $this->utilityclass->getDistrictName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')); ?></td>
                        </tr>
                        <tr class="warning">
                            <td><?php echo $this->lang->line('mouza'); ?> :<?php  echo $this->utilityclass->getMouzaName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$fieldmb->mouza_pargona_code); ?></td>
                            <td><?php echo $this->lang->line('lot_no'); ?> :<?php  echo $this->utilityclass->getLotName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$fieldmb->mouza_pargona_code,$fieldmb->lot_no); ?></td>
                            <td><?php echo $this->lang->line('vill_town'); ?> :<?php  echo $this->utilityclass->getVillageName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$fieldmb->mouza_pargona_code,$fieldmb->lot_no,$fieldmb->vill_townprt_code); ?></td>
                        </tr>
                        <tr class="info">
                        <td><?php echo $this->lang->line('dag_no'); ?> :<?php  echo $fieldmb->dag_no; ?></td>
                        <td><?php echo $this->lang->line('patta_no'); ?> :<?php  echo $fieldOb->dag_no; ?></td>
                        <td></td>
                        </tr>
                        <tr class="warning">
                        <td><?php echo $this->lang->line('case_no'); ?> :<?php  echo $fieldOb->objection_case_no; ?></td>
                        <td><?php echo $this->lang->line('previous_case'); ?> :<?php  echo $fieldmb->case_no; ?></td>
                        <td></td>
                        </tr>
                    </table>
            <div class="row">
                <h2 class="text-active"style="text-align: center">Information About Pattadar(s)</h2>
                <hr>
            <div class="col-lg-12">
                
               
                    
                                <?php foreach($fieldmp as $mp)
                                {               echo "<div class='col-lg-6 text-active' >";
                                                echo "<h4 style='color: #000; '>Name  of the Occupant(s) : ".$mp->pet_name."</h4>";
                                                echo "<p style='color: #000'>Name  of the Guardian(s) : ".$mp->guard_name."</p>";
                                                echo "<p style='color: #000'>Address  :".  $mp->add1."&nbsp-&nbsp".$mp->add2. "</p>";
                                                echo "</div>";
                                }
                                ?>
              
                    
            </div>
                <hr>
                <div class="col-lg-12">
                    <div class="alert text-active">
                        <?php 
                                               echo "<h4 >Name  of the Applicant : ".$fieldOb->obj_name."</h4>";
                                               echo "<p>Address  :".$fieldOb->obj_add. "</p>";
                                               echo "<p> Reason for Objection : ".$fieldOb->reason_for_objection."</p>    ";
                             
                                    ?>
                    </div>
                </div>
            </div>
            <form class="form-horizontal alert alert-info" method="POST" action="<?php echo base_url()."index.php/Objection/Cofinalorder"?>">
                
                <div class="form-group">
                    <label class="col-lg-4 control-label" style="color: #000;">Order </label>
                    <div class="col-lg-5" style="color: #000;">
                        <label>
                            <input type="radio" class="radion-inline" name="order" id="optionsRadios1" value="0" checked="">
                            Pass Order
                        </label>
                        <label>
                            <input type="radio" class="radion-inline"  name="order" id="optionsRadios2" value="1">
                            Reject Order
                        </label>

                    </div>
                </div>
                <div class="form-group" id="remarks">
                    <div class="col-lg-8 col-lg-offset-4">
                        <textarea name="remarks" rows="4" cols="50" class="form-control"></textarea>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-4">
                        <input type="hidden" value="<?php  echo $fieldOb->objection_case_no; ?>" name='case_no' />
                        <input type="hidden" value="<?php echo $fieldOb->patta_no  ?>" name="patta_no" />
                        <button type="submit" class="btn btn-danger"><?php echo $this->lang->line('submit_button'); ?></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    // Initially hide the remarks box
    $("#remarks").hide();

    // Add click listener to radio buttons
    $(".radion-inline").click(function() {
        var selectedVal = $("input[name='order']:checked").val();
        if (selectedVal == "1") {
            $("#remarks").show();
        } else {
            $("#remarks").hide();
        }
    });
</script>

