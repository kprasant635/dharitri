<!--<?php var_dump($data);?>-->
<script>
    $(document).ready(function(){
        var fileCount = 1;
        $('#addnewdoc').click(function(){
            var clone = $($('#template').clone());
           
            console.log(clone.find('input').attr('name','userfile'+fileCount));
            clone.insertBefore('#submitbtn');
        });
    });
</script>
<div class="row login">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('case_details') ?></h3>
                </div>
                <div class="panel-body">
                     <form enctype="multipart/form-data" class='form-horizontal' action="<?php echo base_url()."index.php/Appeals/saveAppeal";?>" method="post">
                     <input type="hidden" name="dist_code" value="<?php echo $data->dist_code;?>">
                     <input type="hidden" name="subdiv_code" value="<?php echo $data->subdiv_code;?>">
                     <input type="hidden" name="cir_code" value="<?php echo $data->cir_code;?>">
                     <input type="hidden" name="mouza_pargona_code" value="<?php echo $data->mouza_pargona_code;?>">
                     <input type="hidden" name="lot_no" value="<?php echo $data->lot_no;?>">
                     <input type="hidden" name="vill_townprt_code" value="<?php echo $data->vill_townprt_code;?>">
                     <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 uni_text control-label "><?php  echo "Dist>".$this->utilityclass->getDistrictName($data->dist_code) ?></label>
                                
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo "Circle>".$this->utilityclass->getSubDivName($data->dist_code,$data->subdiv_code) ?></label>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo "Subdiv>".$this->utilityclass->getCircleName($data->dist_code,$data->subdiv_code,$data->cir_code) ?></label>
                               
                               <hr>
                         </div>
                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo $this->lang->line('case_no') ?></label>
                                <div class="col-sm-4">
 
                                    <input value="<?php echo $case_no;?>" type="text" class="form-control" required minlength="3" name="case_no" id="" placeholder="<?php  echo $this->lang->line('case_no') ?>">
                                   
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo $this->lang->line('order_date') ?></label>
                                <div class="col-sm-4">
 
                                    <input value="<?php echo $data->date_of_order;?>" type="text" class="form-control"  name="date_of_order" id="" placeholder="<?php  echo $this->lang->line('case_no') ?>">
                                   
                                </div>
                         </div>
                         <hr>
                          <div class="row">
                                <div class="col-sm-4">
                                    <label style="text-align: left" for="inputEmail3" class="col-sm-12 uni_text control-label "><?php  echo "Order Issuing Authority" ?></label>
                                </div>
                              
                          </div>
                          <hr>
                          <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo $this->lang->line('co') ?></label>
                                <?php $co = $this->utilityclass->getCOName($data->dist_code,$data->subdiv_code,$data->cir_code,$data->add_off_name);
                                        $name = $co[0];

                                    ?>
                                <div class="col-sm-4">
 
                                    <input value="<?php echo $name->username;?>" type="text" class="form-control" required minlength="3" name="co_name" id="" placeholder="<?php  echo $this->lang->line('case_no') ?>">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo $this->lang->line('sdo') ?></label>
                                <div class="col-sm-4">
                                    
                                    <input value="<?php echo $name->username;?>" type="text" class="form-control"  name="sdo_name">
                                   
                                </div>
                         </div>
                         <div class="form-group">

                                <?php echo $lmcode;$co = $this->utilityclass->getDefinedMondalsName($data->dist_code,$data->subdiv_code,$data->cir_code,$data->mouza_pargona_code,$data->lot_no,$lmcode);
                                   
                                    ?>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo $this->lang->line('lm') ?></label>
                                <div class="col-sm-4">
 
                                    <input value="<?php echo $co->lm_name?>" type="text" class="form-control"  name="lm_name" id="" ">
                                   
                                </div>
                         </div>
                         <hr>
                          <div class="row">
                                <div class="col-sm-4">
                                    <label style="text-align: left" for="inputEmail3" class="col-sm-12 uni_text control-label "><?php  echo "1st Party Details" ?></label>
                                </div>
                              
                          </div>
                         <table class="table">
                         <tr>
                            <th>Name</th>
                            <th>Guardian name</th>
                            <th>Dist</th>
                            <th>Circle</th>
                            <th>Mouza</th>
                            <th>Village</th>
                         </tr>
                         <?php foreach ($first as $key => $value):?>
                            <tr>
                                <td><?php echo $value->pet_name;?></td>
                                <td><?php echo $value->guard_name;?></td>
                                <td><?php echo $this->utilityclass->getDistrictName($data->dist_code,$data->subdiv_code);?></td>
                                <td><?php echo $this->utilityclass->getCircleName($data->dist_code,$data->subdiv_code,$data->cir_code);?></td>
                                <td><?php echo $this->utilityclass->getMouzaName($data->dist_code,$data->subdiv_code,$data->cir_code,$data->mouza_pargona_code);?></td>
                                <td><?php echo $this->utilityclass->getVillageName($data->dist_code,$data->subdiv_code,$data->cir_code,$data->mouza_pargona_code,$data->lot_no,$data->vill_townprt_code);?></td>
                            </tr>
                         <?php endforeach;?>
                         </table>
                          <hr>
                          <div class="row">
                                <div class="col-sm-4">
                                    <label style="text-align: left" for="inputEmail3" class="col-sm-12 uni_text control-label "><?php  echo "2nd Party Details" ?></label>
                                </div>
                              
                          </div>
                         <table class="table">
                         <tr>
                            <th>Name</th>
                            <th>Guardian name</th>
                            <th>Dist</th>
                            <th>Circle</th>
                            <th>Mouza</th>
                            <th>Village</th>
                         </tr>
                         <?php foreach ($second as $key => $value):?>
                            <tr>
                                <td><?php echo $value->pdar_name;?></td>
                                <td><?php echo $value->pdar_guardian;?></td>
                                <td><?php echo $this->utilityclass->getDistrictName($data->dist_code,$data->subdiv_code);?></td>
                                <td><?php echo $this->utilityclass->getCircleName($data->dist_code,$data->subdiv_code,$data->cir_code);?></td>
                                <td><?php echo $this->utilityclass->getMouzaName($data->dist_code,$data->subdiv_code,$data->cir_code,$data->mouza_pargona_code);?></td>
                                <td><?php echo $this->utilityclass->getVillageName($data->dist_code,$data->subdiv_code,$data->cir_code,$data->mouza_pargona_code,$data->lot_no,$data->vill_townprt_code);?></td>
                            </tr>
                         <?php endforeach;?>
                         </table>
                         <div class="row">
                            <div class="col-lg-3">
                                <input type="button" class="btn btn-danger" value="Add Another Party">
                            </div>
                         </div>
                         <hr>
                         <div id='another'>
                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo "Applicant Name" ?></label>
                                <?php $co = $this->utilityclass->getCOName($data->dist_code,$data->subdiv_code,$data->cir_code,$data->add_off_name);
                                        $name = $co[0];

                                    ?>
                                <div class="col-sm-4">
 
                                    <input value="" type="text" class="form-control" required minlength="3" name="otherAppName" id="" placeholder="">
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo "Guardian Name" ?></label>
                                <div class="col-sm-4">
                                    
                                    <input value="" type="text" class="form-control"  name="otherGuardianName">
                                   
                                </div>
                         </div>
                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo "District" ?></label>
                                <?php $co = $this->utilityclass->getCOName($data->dist_code,$data->subdiv_code,$data->cir_code,$data->add_off_name);
                                        $name = $co[0];

                                    ?>
                                <div class="col-sm-4">
 
                                    <select name="otherDistrict">
                                        <option value="24">কামৰূপ মহানগৰ</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo "Subdivision" ?></label>
                                <div class="col-sm-4">
                                    <select name="otherSubdivision">
                                         <option value="01">গুৱাহাটী</option>
                                    </select>
                                </div>
                         </div>
                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo "Circle" ?></label>
                                <?php $co = $this->utilityclass->getCOName($data->dist_code,$data->subdiv_code,$data->cir_code,$data->add_off_name);
                                        $name = $co[0];

                                    ?>
                                <div class="col-sm-4">
 
                                    <select name="otherCircle">
                                        <option value="01">আজাৰা</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo "Mouza" ?></label>
                                <div class="col-sm-4">
                                    <select name="otherMouza">
                                        <option value="01">ৰামছাৰাণী</option>
                                    </select>
                                </div>
                         </div>
                         <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo "Lot" ?></label>
                                <?php $co = $this->utilityclass->getCOName($data->dist_code,$data->subdiv_code,$data->cir_code,$data->add_off_name);
                                        $name = $co[0];

                                    ?>
                                <div class="col-sm-4">
 
                                    <select name="otherLot">
                                        <option value="01">01</option>
                                    </select>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo "Village" ?></label>
                                <div class="col-sm-4">
                                    <select name="otherVillage">
                                        <option value="10002">আজাৰা</option>
                                    </select>
                                </div>
                         </div>
                         </div>
                         <hr>
                         <div class="row">
                                <div class="col-sm-4">
                                    <label style="text-align: left" for="inputEmail3" class="col-sm-12 uni_text control-label "><?php  echo "Document Upload" ?></label>
                                </div>
                                <div class="col-sm-4">
                                    <input type="button"  id='addnewdoc' class="btn btn-danger" value="Add Another Document">
                                </div>
                          </div>
                          <hr>
                          <div class="form-group" id='template'>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo "Document Type" ?></label>
                                <div class="col-sm-4">
 
                                    <select name="types[]" class="form-control">
                                        <option>Select Document Category</option>
                                        <option>Type 1</option>
                                        <option>Type 2</option>
                                    </select>
                                   
                                </div>
                                <label for="inputEmail3" class="col-sm-2 uni_text control-label "><?php  echo "Select Document" ?></label>
                                <div class="col-sm-4">
 
                                    <input  type="file" class="form-control"  name="userfiles" id="" placeholder="<?php  echo $this->lang->line('case_no') ?>">
                                   
                                </div>
                         </div>
                          <div class="row" id='submitbtn'>
                               
                                <div class="col-sm-12">
                                    <input type="submit"  id='addnewdoc' class="btn btn-lg btn-primary" value="Save">
                                </div>
                          </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>