<style>
    input[type="text"]{
        width:100% !important;
    }
    select{
        width:100% !important;
    }
    textarea{
        width: 100% !important; 
    }
    label{
        font-weight: normal !important;
        font-size: 12px !important;
    }
</style>
<script>
    $(function(){
        /*$('#ktn_no').change(function(e){
            var val = $(this).val();
            var saveObj = $(this);
           
            $.ajax({
                url:"http://10.177.15.232/dharitree/index.php/Tenants/checkKhatian/"+val,
                success:function(data){
                    var resp  = JSON.parse(data)
                    if(resp===1){
                        alert("This Khatian already exists!!");
                        saveObj.val("");
                    }
                }
            })*/
        });
        
//        $('form').submit(function(e){
//            e.preventDefault();
//            $.ajax({
//               method:'post',
//               data:$('form').serialize(),
//               success:function(data){
//                   var resp = JSON.parse(data);
//                   if(resp){
//                       alert('Saved!');
//                   }
//               }
//            });
//        });
    });
</script>
<div class="row login form-top">
    <div class="col-lg-12 ">

        <div class="panel panel-info panel-form">
            <div class="panel-heading">
                <h3 class="panel-title">Tenant Entry</h3>
            </div>
            <div class="panel-body">
                <form class="form-horizontal" method="post">

                    <div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>Khatian No</label>
                        <div class="col-sm-2">
                            <input type="number" id='ktn_no' name="khatian_no" class="form-control" required <?php if(!$first) echo "readonly";?> <?php if(!$first) echo "value=$khatian_no ";?> />
                        </div>
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>DAG NO</label>
                        <div class="col-sm-2">
                            <?php if($first):?>
                            <select name='dag_no' class="form-control" required>
                                <option selected disabled>Select Dag</option>
                                <?php foreach ($dags as $d): ?>
                                    <option value="<?php echo $d->dag_no; ?>"><?php echo $d->dag_no; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <?php endif;?>
                            <?php if(!$first):?>
                            <input type="text" id='ktn_no' name="dag_no" class="form-control" required <?php if(!$first) echo "readonly";?> <?php if(!$first) echo "value=$dag_no ";?> />
                            <?php endif;?>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>REVENUE</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control"     name="revenue_tenant" id="applicantNam"  <?php if(!$first) echo "readonly";?> <?php if(!$first) echo "value=$revenue ";?>
                                   placeholder="">
                        </div>
                    </div>
                    <div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>Possession Duration</label>
                        <div class="col-sm-4">
                        <textarea class="form-control" name="duration" <?php if(!$first) echo "readonly";?> <?php if(!$first) echo "value=$duration ";?>></textarea>
                        </div>
                    </div>
                    <div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>Payable Cash/Kind</label>
                        <div class="col-sm-4">
                            <textarea rows='5' name='payable_cash_kind'  class="form-control"  <?php if(!$first) echo "readonly";?>   id="applicantNam" ><?php if(!$first) echo "$payable_cash_kind ";?> </textarea>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>Paid Cash/Kind</label>
                        <div class="col-sm-4">
                            <textarea rows='5' name='paid_cash_kind'  class="form-control" <?php if(!$first) echo "readonly";?>      id="applicantNam" ><?php if(!$first) echo "$paid_cash_kind ";?></textarea>
                        </div>
                    </div>
                    <div class="form-group" style="width: 100%;">

                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>Status of Tenant</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  <?php if(!$first) echo "readonly";?> <?php if(!$first) echo "value=$tenant_status ";?>   name="tenant_status" id="applicantNam" 
                                   placeholder="">
                        </div>
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>Special Conditions(*)</label>
                        <div class="col-sm-4">
                            <textarea rows="5" class="form-control" <?php if(!$first) echo "readonly";?>  name='special_conditions'><?php if(!$first) echo "$special_conditions ";?></textarea>
                        </div>
                    </div>
                    <div class="form-group" style="width: 100%;">

                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>Remarks</label>
                        <div class="col-sm-4">
                            <textarea rows="5" <?php if(!$first) echo "readonly";?> class="form-control" name='remarks'><?php if(!$first) echo "$remarks ";?> </textarea>
                        </div>
                        
                    </div>
                    <div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>Dag Area B</label>
                        <div class="col-sm-2">
                            
                            <input type="number" id='ktn_no' name="areab" class="form-control" required <?php if(!$first) echo "readonly";?> <?php if(!$first) echo "value=$areab ";?> />
                        </div>
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label' >Dag Area K</label>
                        <div class="col-sm-2">
                            <input type="number" id='ktn_no' name="areak" class="form-control" required <?php if(!$first) echo "readonly";?> <?php if(!$first) echo "value=$areak ";?>/>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label' >Dag Area L</label>
                        <div class="col-sm-2">
                            <input type="number" id='ktn_no' name="areal" class="form-control" required <?php if(!$first) echo "readonly";?> <?php if(!$first) echo "value=$areal ";?>/>
                        </div>
                    </div>
                    <div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label required" id='applicant_name_label'>TENANT NAME</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"  required   name="tenant_name" id="applicantNam" required
                                   placeholder="">
                        </div>
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>TENANTS FATHER</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"     name="tenants_father" id="applicantNam" required
                                   placeholder="">
                        </div>

                    </div>
                    <div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>TENANTS Address1</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"     name="tenants_add1" id="applicantNam" 
                                   placeholder="">
                        </div>
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>TENANTS Address2</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"     name="tenants_add2" id="applicantNam" 
                                   placeholder="">
                        </div>
                    </div>
                    <div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>TENANTS Address3</label>
                        <div class="col-sm-4">
                            <input type="text" class="form-control"     name="tenants_add3" id="applicantNam" 
                                   placeholder="">
                        </div>
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>TYPE OF TENANT</label>
                        <div class="col-sm-4">
                            <select name="type_of_tenant" class="form-control" required="">
                                <option selected disabled>Select Tenant Type</option>
                                <?php foreach ($tenant_type as $t): ?>
                                    <option value="<?php echo $t->type_code ?>"><?php echo $t->tenant_type; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group" style="width: 100%;">

                       
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>CROP RATE</label>
                        <div class="col-sm-4">
                            <input type="number" class="form-control"     name="crop_rate" id="applicantNam" 
                                   placeholder="">
                        </div>
                    </div>
                    <hr style="border-bottom: 2px solid #000;">
                    <!--<div class="form-group" style="width: 100%;">

                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>Possession Duration(Years)</label>
                        <div class="col-sm-2">
                            <input type="number" class="form-control"    name="possession_duration_years" id="applicantNam" 
                                   placeholder="">
                        </div>
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>Possession Duration(Months)</label>
                        <div class="col-sm-2">
                            <select name='possession_duration_months' class="form-control">
                                <option selected disabled>Number of Months</option>
                                <?php for($i=1;$i<12;$i++):?>
                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                               <?php endfor;?>
                                
                            </select>
                        </div>
                        <label for="inputEmail3" class="col-sm-2 uni_text control-label " id='applicant_name_label'>Possession Duration(Days)</label>
                        <div class="col-sm-2">
                            <select name='possession_duration_days' class="form-control">
                                <option selected disabled>Number of Days</option>
                                <?php for($i=1;$i<30;$i++):?>
                                <option value="<?php echo $i;?>"><?php echo $i;?></option>
                               <?php endfor;?>
                            </select>
                        </div>
                        
                    </div>-->
                   
                    <div class="form-group" style="width: 100%;text-align: center;">
                        <div class="">
                            <button type="submit" class="btn uni_text btn-primary"><i class='fa fa-check'></i><?php echo $this->lang->line('submit_button'); ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>