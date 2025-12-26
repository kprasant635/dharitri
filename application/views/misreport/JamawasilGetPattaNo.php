<?php /* Author: Partha Sarathi, Dated-29/08/2018 */ ?>
<style type="text/css">
    .multiselect {
    width:35em;
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
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Generate Jamawasil for Multiple Pattas
                        </h3>
                    </div>
                    <div class="panel-body">
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
                                <label for="inputEmail3" class="uni_text control-label">Select Pattas From Below</label>
                                <div class="multiselect">
                                    <?php
                                    foreach ($result as $value) {
                                        $pattatype = $this->utilityclass->getPattaName($value->patta_type_code);
                                        ?>
                                    <label><input type="checkbox" name="patta_no" value="<?php echo $value->patta_no; ?>" />&nbsp; <span id='<?php echo $value->patta_no; ?>'><?php echo " পট্টা নং : ". $value->patta_no. " /  পট্টা প্ৰকাৰ : ".$pattatype; ?></span></label>
                                        <?php
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-sm-6" style="border-left: 1px solid red;">
                            <form class='form-horizontal' method="post" action="<?php echo base_url()."index.php/MisReportControllerForJamawasil/GenerateJamawasilMultiple";?>">
                                <label for="inputEmail3" class="uni_text control-label">Selected Pattas Listed Below</label>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <input type="hidden" class="form-control" id="show" name="patta_no" required readonly>
                                        <textarea id="showtext" class="form-control" name="pattas" required readonly></textarea>
                                    </div>
                                </div>                                                         
                                <input type='hidden' value='<?= $dist_code ?>' name='dist_code' />
                                <input type='hidden' value='<?= $subdiv_code ?>' name='subdiv_code' />
                                <input type='hidden' value='<?= $cir_code ?>' name='cir_code' />
                                <input type='hidden' value='<?= $mouza_code ?>' name='mouza_pargona_code' />
                                <input type='hidden' value='<?= $lot_code ?>' name='lot_no' />
                                <input type='hidden' value='<?= $village_code ?>' name='vill_townprt_code' />
								<input type='hidden' value='<?= $patta_code ?>' name='patta_code' />
								<input type='hidden' value='<?= $rows ?>' name='rows' />
								<input type='hidden' value='<?= $cir_name ?>' name='circle_name' />
								<input type='hidden' value='<?= $village_name ?>' name='village_name' />
								<input type='hidden' value='<?= $pattatype ?>' name='patta_type_name' />
                                <hr style="border-bottom: 2px solid #000;">   
                                <div class="form-group">
                                    <div class="col-sm-12 center" >
                                        <a href="<?php echo base_url(); ?>index.php/home" class="btn btn-sm btn-danger">
                                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                        </a>
                                        <button type="submit" class="btn btn-sm btn-success"><i class='fa fa-check'></i>&nbsp; Generate Jamawasil</button>
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
                    var checkboxes = document.getElementsByName('patta_no');
                    //alert(checkboxes);
                    
                    var checkboxesChecked = [];
                    var checkboxesTextChecked = [];
                    for (var i=0; i<checkboxes.length; i++) {
                        // And stick the checked ones onto an array...
                        if (checkboxes[i].checked) {
                           var patta = $("#"+checkboxes[i].value).html().split('/');
                           checkboxesChecked.push(checkboxes[i].value);
                           checkboxesTextChecked.push(patta[0]);
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
    

