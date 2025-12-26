
        <div class="container-fluid form-top login">
        <div class='row'>
            <?php //var_dump($data);?>
            <div class='col-lg-12' style="margin: 0 auto;float: none;">
                    <div class="panel panel-primary panel-form">
                    <p class="text-center uni_text">আবেদন পঞ্জীকৰণ ফৰ্ম<?php //echo $this->lang->line('citizen_apply_form')?>  </p>
                    <div class="row" style="margin-top: 15px">
                        <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('sr_no')?>:<?php echo $this->session->userdata('cert_no'); ?> </p></div>
                        <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('apply_date')?>:<?php echo date('d-m-Y', strtotime($this->session->userdata('apply_date')));  ?> </p></div>
                        <div class="col-lg-4"><p class="uni_text text-center"><?php echo $this->lang->line('delivery_date')?> :<?php echo date('d-m-Y', strtotime($this->session->userdata('next_due_date')));  ?> </p></div>
                    </div>
                    <hr>
                    <div class="">
                        <div class="col-lg-offset-3 btn btn-primary uni_text" id="jamabandiRedirect"><i class="fa fa-book"></i> <?php echo $this->lang->line('jamabandi_for_patta');?></div>
                        <div class="btn btn-warning uni_text" id="PageRedirect"><i class="fa fa-book"></i> <?php echo $this->lang->line('chitha_for_patta');?></div>
                    </div>
                    <hr>
                    <p class="uni_text text-center">Total Land Area of a Particular Dag</p>
                    <form class="form-inline" action="<?php echo base_url(); ?>index.php/CitizenController/LmStep4"  method="post">
                        <p id='showdata'  class="text-danger uni_text col-lg-offset-1" role="alert" ></p>
                        <div>
                            <?php echo $this->lang->line('dag_no'); ?> : 
                            <select class="form-control dag_no_change" required="" id='dag_no_change' name='dag'>
                                <option><?php echo $this->lang->line('select_dag'); ?></option>
                                <?php foreach ($dags as $d): ?>
                                    <option value="<?php echo $d->dag_no; ?>"><?php echo $d->dag_no; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php echo $this->lang->line('bigha'); ?>: <input type="text" readonly="" class="form-control input-width"  id="appliedbigha"  value="0" />
                            <?php echo $this->lang->line('katha'); ?> : <input type="text" readonly=""  class="form-control input-width" id="appliedkatha"  value="0" /> 
                            <?php echo $this->lang->line('lesa'); ?>: <input type="text"  readonly="" class="form-control input-width" id="appliedlessa" value="0" /> 
                            <?php if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){?>
                            <?php echo $this->lang->line('ganda'); ?>: <input type="text"  readonly="" class="form-control input-width" id="appliedganda" value="0" />   
                        <?php }?>
                        </div>
                        <hr>
                        <div class="container row col-lg-12">
                            <h4 class='red center uni_text'>Type Pattadar Land Portion Here :</h4>
                            <div id="itemRows" class='row  center'>
                                <span class="rasid col-lg-2">Dag : <input type="text" class="form-control" required name="dag[]" /></span>
                                <span class="rasid col-lg-2">Bigha : <input type="text" class="form-control" required name="bigha[]" /></span>
                                <span class="rasid col-lg-2">Katha : <input type="text" class="form-control" required name="katha[]" /></span> 
                                <span class="rasid col-lg-2">Lessa : <input type="text" name="lessa[]" required class="form-control" /></span>
                                <?php if(in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY))){?>
                                <span class="rasid col-lg-2">Ganda : <input type="text" name="ganda[]" required class="form-control" /></span> 
                                <?php } ?>
                                <span class="rasid col-lg-2"><input onclick="addRow(this.form);" type="button" class="btn btn-info btn-sm" value="Add More" /></span>
                            </div>
                            <span class='center uni_text'>Note :If there is more than one dag please click add more button</span>
                        </div>
                        <hr>
                        <?php if ($this->session->flashdata('message')): ?>
                        <?php 
                            echo '<div class="col-lg-10 col-lg-offset-1">
                                <p style="color:red;">'.$this->session->flashdata('message').'</p>
                            </div>';
                        ?>
                        <?php endif; ?>
                        <center>
                            <button  class="btn btn-sm btn-success" type="submit"> <?php echo $this->lang->line('submit_button');?></button>
                        </center>
                     </form>
                     <br>
                    </div>
            </div>
        </div>
    </div>
        
    <style type="text/css">
        input[type='text']{
            max-width: 90px !important;
        }
    </style>
    <script>
    $('#PageRedirect').click(function(){
       //location.href="";
       window.open("<?php echo base_url(); ?>index.php/CitizenController/ChithaSelectPatta", "MsgWindow", "width=1000,height=900")
    });
    $('#jamabandiRedirect').click(function(){
        window.open("<?php echo base_url();?>index.php/CitizenController/saveJamabandiByPattano?case_no=<?php echo $this->session->userdata('cert_no'); ?>", "MsgWindow", "width=1000,height=900")
       //location.href="<?php echo base_url();?>index.php/CitizenController/saveJamabandiByPattano?case_no=<?php echo $this->session->userdata('cert_no'); ?>";
    });
        var rowNum = 0;
        function addRow(frm) {
            rowNum++;
            var row = '<div style="margin-top:20px" id="rowNum' + rowNum + '"><span class="rasid col-lg-2">Dag : <input type="text" class="form-control" name="dag[]"  value=""></span><span class="rasid col-lg-2">Bigha : <input type="text" class="form-control" name="bigha[]"  value=""></span><span class="rasid col-lg-2">Katha :<input type="text" class="form-control" name="katha[]" value=""></span><span class="rasid col-lg-2">Lessa : <input type="text" class="form-control" name="lessa[]" value=""></span><span class="rasid col-lg-2"><input type="button" class="btn btn-danger btn-sm" value="Remove" onclick="removeRow(' + rowNum + ');"></span></div>';
            jQuery('#itemRows').append(row);
            frm.add_name.value = '';
            frm.add_1.value = '';
            frm.add_2.value = '';
           // alert(rowNum);
        }
       function removeRow(rnum) {
            jQuery('#rowNum' + rnum).remove();
        }

    </script>


