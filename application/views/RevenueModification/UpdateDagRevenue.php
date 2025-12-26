<?php /* Author: Partha Sarathi, Dated-29/08/2018 */ ?>
<style type="text/css">
    .multiselect {
    
    height:20em;
    border:solid 1px #c0c0c0;
    overflow:auto;
}
 
.multiselect label {
    display:block;
}
 
.multiselect-on {
    color:#ffffff;
    background-color:#000099;
}
</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Update Revenue & Local Tax </h2>
                </div>
            </div>               

            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Update Utility
                        </h3>
                    </div>
                    <div class="panel-body">
                        <h2 class="red">Update Revenue & Local Tax of Particular Village Dag</h2>
                        <table class="table table-bordered">
                            <tr class="hope">
                                <td colspan="2">District : <?php echo $dist_name; ?></td>
                                <td colspan="2">Subdivision : <?php echo $subdiv_name; ?></td>
                                <td colspan="2">Circle : <?php echo $cir_name; ?></td>
                            </tr>
                            <tr class="hope">
                                <td colspan="2">Mouza Pargona : <?php echo $mouza_name; ?></td>
                                <td colspan="2">Lot : <?php echo $lot_name; ?></td>
                                <td colspan="2">Town / Village : <?php echo $village_name; ?></td>
                            </tr>
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="inputEmail3" class="uni_text control-label">Select Dags From Below</label>
                                <div class="multiselect">
                                    <?php
                                    foreach ($result as $value) {
                                        $class = $this->utilityclass->getLandClassCode($value->land_class_code);
                                        ?>
                                    <label><input type="checkbox" name="dag_no" value="<?php echo $value->dag_no_int; ?>" />&nbsp; <span id='<?php echo $value->dag_no_int; ?>'><?php echo " দাগ নং : ". $value->dag_no. " /  শ্ৰেণী : ".$class; ?></span></label>
                                        <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6" style="border-left: 1px solid red;">
                            <form class='form-horizontal' method="post" action="<?php echo base_url()."index.php/ControllerForRevenueUpdate/SaveDagRevenue";?>">
                                <label for="inputEmail3" class="uni_text control-label">Selected Dags Listed Below</label>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="hidden" class="form-control" id="show" name="dag_no_int" required readonly>
                                        <textarea id="showtext" class="form-control" name="dags" required readonly></textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-8 uni_text control-label required" id='landclass'>Rural/Urban/Nisphi-Kheraj:</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="RuralUrban" required>
                                            <option value="Rural">Rural</option>
                                            <option value="Urban">Urban</option>
                                            <option value="NisphiKheraj">Nisphi Kheraj</option>
                                        </select>
                                    </div>  
                                </div>
                                <font color=red size=4><b>(Confirm it before submission)</b></font>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-8 uni_text control-label">Revenue Per Bigha<font color=red size=4>&nbsp;(in Rs):</font></label>
                                    <div class="col-sm-4"> 
                                        <input type="text" class="form-control" title="Enter Per Bigha Land Revenue" name="revenuebigha" required >
                                    </div>
                                </div>
                                <font color=red size=3><b>(0 if minimum revenue is not considered)</b></font>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-8 uni_text control-label">Minimum Revenue <font color=red size=4>&nbsp;(in Rs):</font></label>
                                    <div class="col-sm-4">   
                                        <input type="text" class="form-control" title="Enter 0 if Minimum Revenue is not considered" name="minRevenue" required value="0" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-8 uni_text control-label" style="color:red">Proportunate Calculation Required?</label>
                                    <div class="col-sm-12">
                                        <input type="checkbox" name="proportunate" value="1">&nbsp&nbsp&nbsp<font color=blue size=4>[Check it, if fractional calculation is required for land area less than 1 Bigha]</font>	
                                    </div>
                                </div>
                                <input type='hidden' value='<?= $dist_code ?>' name='dist_code' />
                                <input type='hidden' value='<?= $subdiv_code ?>' name='subdiv_code' />
                                <input type='hidden' value='<?= $cir_code ?>' name='cir_code' />
                                <input type='hidden' value='<?= $mouza_code ?>' name='mouza_pargona_code' />
                                <input type='hidden' value='<?= $lot_code ?>' name='lot_no' />
                                <input type='hidden' value='<?= $village_code ?>' name='vill_townprt_code' />
                                <hr style="border-bottom: 2px solid #000;">   
                                <div class="form-group">
                                    <div class="col-sm-12 center" >
                                        <a href="<?php echo base_url(); ?>index.php/home" class="btn btn-sm btn-danger">
                                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                        </a>
                                        <button type="submit" class="btn btn-sm btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button') ?> & Save</button>
                                    </div>
                                </div>
                                <hr style="border-bottom: 2px solid #000;">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $(".multiselect").multiselect();
    });
    
    jQuery.fn.multiselect = function() {
        $(this).each(function() {
            var checkboxes = $(this).find("input:checkbox");
            checkboxes.each(function() {
                var checkbox = $(this);
                // Highlight pre-selected checkboxes
                if (checkbox.prop("checked"))
                    checkbox.parent().addClass("multiselect-on");

                // Highlight checkboxes that the user selects
                checkbox.click(function() {
                    var checkboxes = document.getElementsByName('dag_no');
                    //alert(checkboxes);
                    
                    var checkboxesChecked = [];
                    var checkboxesTextChecked = [];
                    for (var i=0; i<checkboxes.length; i++) {
                        // And stick the checked ones onto an array...
                        if (checkboxes[i].checked) {
                           var dag = $("#"+checkboxes[i].value).html().split('/');
                           checkboxesChecked.push(checkboxes[i].value);
                           checkboxesTextChecked.push(dag[0]);
                        }
                     }
                     document.getElementById("show").value = checkboxesChecked;
                     document.getElementById("showtext").value = checkboxesTextChecked;
                     
                    if (checkbox.prop("checked"))
                        checkbox.parent().addClass("multiselect-on");
                    else
                        checkbox.parent().removeClass("multiselect-on");
                });
            });
        });
    };

</script>
    

