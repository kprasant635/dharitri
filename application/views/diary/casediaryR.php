<div class="container-fluid login">
    <div class="row" >
        <div class="col-sm-12" >  
            <div class="alert alert-dismissible alert-warning"><h2 class="uni_text">
                Case Diary for a particular period
                <?php echo $this->lang->line('from');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('sdate'))) ?> <?php echo $this->lang->line('to');?> <?php echo date('d-m-Y',  strtotime($this->session->userdata('edate'))) ?></h2> </div>
             <?php  //var_dump($loc); 
            $i=0;
            foreach($loc as $l){
            ?>
             <h4 class="text-danger center">Circle Name : <?php echo $l->loc_name; ?></h4>
            <table width="100%" class="table table-bordered table-hover" border="1">
                <tr>
                    <td class="alert-teal" rowspan="3"><div align="center"><?php echo $this->lang->line('sl_no');?></div></td>
                    <td class="alert-teal" rowspan="3"><div align="center"><?php echo $this->lang->line('mutation_type');?></div></td>
                    <td class="alert-teal" colspan="8"><div align="center">Case Diary For a Particular Period</div></td>
                </tr>
                <tr>

                    <td style="background:#6B8E23; color: #fff; text-align: center" colspan="4"><p align="center"><?php echo $this->lang->line('during_this_period');?></p>
                        <p align="center"><span class="badge badge-danger"><?php echo date('d-m-Y',  strtotime($this->session->userdata('sdate'))) ?></span>  <?php echo $this->lang->line('to');?> <span class="badge badge-danger"><?php echo date('d-m-Y',  strtotime($this->session->userdata('edate'))) ?></span></p></td>
                </tr>
                <tr>
                  
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('registration'); ?> </td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('orderpassed'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('disposed'); ?></td>
                    <td style="background:#6B8E23; color: #fff; text-align: center"><?php echo $this->lang->line('pending'); ?></td>
                </tr>
                <tr class="active">
                    <td><div align="center">1</div></td>
                    <td><div align="center"><?php echo $this->lang->line('field_mutation');?></div></td>
                  
                    <td><div align="center"><?php echo $fieldmut[$i]['regomut']  ; ?></div></td>
                      <td><div align="center"><?php echo $fieldmut[$i]['deliverfmut']  ; ?></div></td>
                    <td><div align="center"><?php echo $fieldmut[$i]['disomut']  ; ?></div></td>
                    <?php
                    $this->session->userdata('user_desig_code');
                    $user_desig_code = $this->session->userdata('user_desig_code');
                     if ( ($user_desig_code == 'CO') ) {
                    $action=base_url()."index.php/CentralDiary/PendingCaseMut?type=01&sub=";
                   }else{
                     $action=base_url()."index.php/CentralDiary/casediaryR";
                  }
                    
                    ?>
                    
                    
                    
                    <td><div align="center"><span class="badge badge-danger"><?php echo $fieldmut[$i]['penomut']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/CentralDiary/PendingCaseMut?type=01" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                </tr>
                <tr>
                    <td><div align="center">2</div></td>
                    <td><div align="center"><?php echo $this->lang->line('field_partition');?></div></td>
                    
                    <td><div align="center"><?php echo $fieldpart[$i]['regopart']  ; ?></div></td>
                    <td><div align="center"><?php echo $fieldpart[$i]['deliverfpart']  ; ?></div></td>
                    <td><div align="center"><?php echo $fieldpart[$i]['disopart']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $fieldpart[$i]['penopart']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/CentralDiary/PendingCaseField?type=02" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">3</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_mutation');?></div></td>
                    <td><div align="center"><?php echo $officemut[$i]['regomut']  ; ?></div></td>
                    <td><div align="center"><?php echo $officemut[$i]['delivermut']  ; ?></div></td>
                    <td><div align="center"><?php echo $officemut[$i]['disomut']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officemut[$i]['penomut']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/CentralDiary/PendingCaseOMut?type=03" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                </tr>
                <tr>
                    <td><div align="center">4</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_partition');?></div></td>
                    
                    <td><div align="center"><?php echo $officepart[$i]['regopart']  ; ?></div></td>
                    <td><div align="center"><?php echo $officepart[$i]['deliverpart']  ; ?></div></td>
                    <td><div align="center"><?php echo $officepart[$i]['disopart']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officepart[$i]['penopart']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/CentralDiary/PendingCaseOPart?type=04" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                </tr>
                <tr class="active">
                    <td><div align="center">5</div></td>
                    <td><div align="center"><?php echo $this->lang->line('office_conversion');?></div></td>
                    
                    <td><div align="center"><?php echo $officecon[$i]['regocon']  ; ?></div></td>
                    <td><div align="center"><?php echo $officecon[$i]['delivercon']  ; ?></div></td>
                    <td><div align="center"><?php echo $officecon[$i]['disocon']  ; ?></div></td>
                    <td><div align="center"><span class="badge badge-danger"><?php echo $officecon[$i]['penocon']  ; ?></span><br><a href="<?php echo base_url() ?>index.php/CentralDiary/PendingCaseOCon?type=01" class="text-dec"> <?php echo $this->lang->line('view');?></a></div></td>
                </tr>

            </table>
              <?php
            $i++;
            
            }?>
            <center><button id="backButton" class="btn btn-danger"><i class="fa fa-home"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button></center>
        </div>
    </div>
</div>
<script type="text/javascript">
    document.getElementById("backButton").onclick = function () {
       window.history.back();
    };
</script>
