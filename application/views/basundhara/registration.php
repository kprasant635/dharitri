<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
             <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Registration of <kbd>Mutation</kbd>
                        </h3>
                    </div>
                    <div class="panel-body">
                      <table class="table">
                        <!-- <tr>
                          <td>District: <?=$this->utilityclass->getDistrictName($this->session->userdata('dist_code'))?></td><td> Subdivision: <?=$this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'))?></td><td>Circle: <?=$this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'))?></td>
                        </tr>
                        <tr>
                          <td>Mouza: <?=$this->utilityclass->getMouzaName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$this->session->userdata('mouza_pargona_code'))?></td><td>Lot No: <?=$this->utilityclass->getLotName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$this->session->userdata('mouza_pargona_code'),$this->session->userdata('lot_no'))?></td>
                          <td>Village: <?=$this->utilityclass->getVillageName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'),$this->session->userdata('mouza_pargona_code'),$this->session->userdata('lot_no'),$landsched['villcode']);?></td>
                        </tr> -->
                      </table>
                        <form method="POST" action="">
                          <div class="form-row">
                            <div class="form-group col-md-3">
                              <label for="inputCity">Patta Type</label>
                              <input type="text" name='' value="<?=$this->utilityclass->getPattaType($landsched['pattatype'])?>" readonly class="form-control">
                              <input type="hidden" name='pattaType' value="<?=$landsched['pattatype']?>" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                              <label for="inputState">Patta No</label>
                              <input type="text" name='pattaNo' value="<?=$landsched['pattano']?>" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                              <label for="inputState">Dag No</label>
                              <input type="text" value="<?=$landsched['dagno']?>" name='dagNo' readonly class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                              <label for="inputZip">Transfer Type</label>
                              <input type="text" name='' value="<?=$this->utilityclass->getTransferType('03')?>" readonly class="form-control">
                              <input type="hidden" name='transferType' value="03" readonly class="form-control">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="form-group col-md-3">
                              <label for="inputCity">Deed No</label>
                              <input type="text" name='deedNo' value="<?=$deed['deed_no']?>" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-2">
                              <label for="inputState">Deed Value</label>
                              <input type="text" name='deedVal' value="1000" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-2">
                              <label for="inputState">Deed Date</label>
                              <input type="text" name='deedDate' value="<?=$deed['date_of_deed']?>" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                              <label for="inputCity">NOC No</label>
                              <input type="text" name='nocNo' value="<?=$deed['nocno']?>" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-2">
                              <label for="inputState">NOC Date</label>
                              <input type="text" name='nocDate' value="<?=$deed['date_of_deed']?>" readonly class="form-control">
                            </div>
                          </div>
                          <p class="center uni_text"><u>Land Area</u></p>
                          <?php 
                          $landarea=$this->utilityclass->dagLandArea($landsched['distcode'],$landsched['subcode'],$landsched['circode'],$landsched['mouzacode'],$landsched['lotno'],$landsched['villcode'],$landsched['pattano'],$landsched['pattatype'],$landsched['dagno']);
                          //var_dump($landarea) ;
                          ?>
                          <div class="form-row col-lg-12">
                            <div class="col-md-3 uni_text">Total Land Area</div>
                            <div class="form-group col-md-3">
                              <label for="inputCity">Bigha</label>
                              <input type="text" name='dag_area_b' value="<?=$landarea->dag_area_b?>" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                              <label for="inputState">Katha</label>
                              <input type="text" name='dag_area_k' value="<?=$landarea->dag_area_k?>" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                              <label for="inputState">Leassa</label>
                              <input type="text" name='dag_area_lc' value="<?=$landarea->dag_area_lc?>" readonly class="form-control">
                            </div>
                          </div>
                          <div class="form-row col-lg-12">
                            <div class="col-md-3 uni_text">Mutated Land Area</div>
                            <div class="form-group col-md-3">
                              <label for="inputCity">Bigha</label>
                              <input type="text" value="<?=$landsched['bigha']?>" name='m_dag_area_b' readonly class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                              <label for="inputState">Katha</label>
                              <input type="text" value="<?=$landsched['katha']?>" name='m_dag_area_k' readonly class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                              <label for="inputState">Leassa</label>
                              <input type="text" value="<?=$landsched['lessa']?>" name='m_dag_area_lc' readonly class="form-control">
                            </div>
                          </div>
                          <p class="center uni_text"><u>List(s) of Buyer</u></p>
                          <div class="form-row">
                            <?php foreach($buyer as $b){ ?>
                            <div class="form-group col-md-3">
                              <label for="inputCity">Applicant Name</label>
                              <input type="text" value="<?=$b['bnameas']?>" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                              <label for="inputState">Father Name</label>
                              <input type="text" value="<?=$b['bfnameas']?>" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                              <label for="inputState">Mother Name</label>
                              <input type="text" value="<?=$b['bmnameas']?>" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-2">
                              <label for="inputCity">Mobile No</label>
                              <input type="text" value="<?=$b['mobno']?>" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-1">
                              <label for="inputState">Gender</label>
                              <input type="text" value="<?=$b['gender']?>" readonly class="form-control">
                            </div>
                          <?php } ?>
                          </div>
                          <p class="center uni_text"><u>List(s) of Seller</u></p>
                          <?php foreach($seller as $b){ ?>
                          <div class="form-row">
                            <div class="form-group col-md-3">
                              <label for="inputCity">Applicant Name</label>
                              <input type="text" value="<?=$b['pattadarnm']?>" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-3">
                              <label for="inputState">Father Name</label>
                              <input type="text" value="<?=$b['pdarfather']?>" readonly class="form-control">
                            </div>
                            <div class="form-group alert alert-info col-md-3 required">
                             <label for="inputState"><?php echo $this->lang->line('inplace_alongwith') ?></label>
                              <select class="form-control inplace" name="striked_out" required>
                                <option selected disabled><?php echo $this->lang->line('select_inplace_alongwith') ?></option>
                                <option value="1"><?php echo $this->lang->line('inplace') ?></option>
                                <option value="0"><?php echo $this->lang->line('alongwith') ?></option>
                              </select> 
                            </div>
                            <div class="form-group col-md-2">
                              <label for="inputCity">Mobile No</label>
                              <input type="text" value="<?=$b['mobno']?>" readonly class="form-control">
                            </div>
                            <div class="form-group col-md-1">
                              <label for="inputState">Gender</label>
                              <input type="text" value="<?=$b['gender']?>" readonly class="form-control">
                            </div>
                          </div>
                         <?php } ?>
                         <hr>
                        <center><button type="submit" class="btn btn-info">Submit</button></center>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
