<style>
	.text-style {color:red;}
	</style>

<div class="container-fluid form-top login">

    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Land Proposed for Legacy Data Modification / Updations </h2>
                    <h6 style="text-align: center;">NOTE : Insert Dag Number and click the "Generate Dag Details" button. It will Auto Generate All The Details.</h6>
                </div>
                <div class="error_container">
                    <div class="alert alert-warning alert-dismissible error_alert" role="alert" style="display:none;">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <strong class="text-danger err__msgs"></strong>
                    </div>
                </div>
            </div>

            <form class='form-horizontal' id="f1" method="post" action="<?php echo base_url() . 'index.php/LegacyDataUpdation/saveLegacyDataDetails' ?>" enctype="multipart/form-data">

                <div class="col-lg-5 col-lg-offset-1">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Old Legacy Data
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control g_from_d" id="g_from_d" placeholder="Dag No" name="dagno" autocomplete="off">
                                </div>
                                <div class="col-sm-5">
                                    <input type="button" class="btn btn-success btn-block" value="Generate Details" onclick="generate_dag_details()">
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                <div class="col-sm-5">
                                    <select class="form-control patta_code" id="opc" name="patta_type">
                                        <option selected disabled><?php echo $this->lang->line('select_patta_type'); ?></option>
                                    </select>
                                </div>
                               <!--  <div class="col-sm-4">
                                    <input type="checkbox" class="form patta_type" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div> -->
                                <div class="col-sm-4" id="patta_type_div">
                                    <input type="checkbox" class="form patta_type" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div>
                               
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control patta" id="patta" placeholder="Patta No" name="patta_no" readonly>
                                </div>
                                <!-- <div class="col-sm-4">
                                    <input type="checkbox" class="form pattano" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div> -->
                                <div class="col-sm-4" id="pattano_div">
                                    <input type="checkbox" class="form pattano" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('land_class'); ?></label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="land_class">
                                        <option selected disabled><?php echo $this->lang->line('select_land_class'); ?></option>
                                    </select>
                                </div>
                                <!-- <div class="col-sm-4">
                                    <input type="checkbox" class="form land_class" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div> -->
                                <div class="col-sm-4" id="land_class_div">
                                    <input type="checkbox" class="form land_class" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Revenue</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control p_land_revv" id="p_land_revv" name="land_rev" readonly>
                                </div>
                                <!-- <div class="col-sm-4">
                                    <input type="checkbox" class="form land_revenue" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div> -->
                                <div class="col-sm-4" id="land_revenue_div">
                                    <input type="checkbox" class="form land_revenue" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label"><?php echo $this->lang->line('local_tax'); ?></label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control loc_tax" id="loc_tax" name="loc_tax" readonly>
                                </div>
                               <!--  <div class="col-sm-4">
                                    <input type="checkbox" class="form local_tax" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div> -->
                                <div class="col-sm-4" id="local_tax_div">
                                      <input type="checkbox" class="form local_tax" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div>
                            </div>
							
                            <!-- <div class="form-group">
                                <label for="inputEmail3" class="col-sm-8 control-label">Strike/Unstrike Pattadar</label> -->
                             
                               <!--  <div class="col-sm-4">
                                    <input type="checkbox" class="form striked" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div> -->
                                <!-- <div class="col-sm-4" id="striked_div">
                                     <input type="checkbox" class="form striked" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div> -->
                            <!-- </div> -->
							
							
							<!-- <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Striked Pattadar</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control striked" id="striked" name="pdar_strike" readonly>
                                </div>
                                <div class="col-sm-4">
                                    <input type="checkbox" class="form striked" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div>
                            </div> !-->
                            <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Area</label>
                           
                            <div class="col-lg-12">
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" id='b' name='dag_area_b' placeholder="বিঘা" readonly>
                                </div>
                                <div class="col-sm-2" style="margin-left: inherit;">
                                    <input type="text" class="form-control"  id='katha' name='dag_area_k' placeholder="কঠা" readonly>
                                </div>
                                <div class="col-sm-2" style="margin-left: inherit;">
                                    <input type="text" class="form-control"  id='l' name='dag_area_lc' placeholder="লেছা" readonly>
                                </div>

                                 <?php
                                $dist_code = $this->session->userdata('dist_code');
                                if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>

                                <div class="col-sm-2">
                                    <input type="text" class="form-control"  id='g' name='dag_area_g' placeholder="গন্ডা" readonly style="padding: 5px" >
                                </div>
                                 <div class="col-sm-2">
                                    <input type="text" class="form-control"  id='k' name='dag_area_kr' placeholder="ক্ৰান্তি" readonly style="padding: 5px" >
                                </div>

                            <?php }else{?>
                                <div class="col-sm-2">
                                    
                                </div>
                                 <div class="col-sm-2">
                                    
                                </div>
                            <?php }?>
                               <!--  <div class="col-sm-3" style="margin-left: inherit;">
                                    <input type="checkbox" class="form area" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div> -->
                                <div class="col-sm-2" id="area_div" style="margin-left: inherit;">
                                     <input type="checkbox" class="form area" name='' value="Y"> &nbsp; <i class='fa fa-arrow-left'></i>  Tick to Modify
                                </div>
                            </div>
                            </div>
                      </div>
                    </div>
                    </div>
                
                <!--#END PLB-->

                <div class="col-lg-5">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Legacy Data Changes
                            </h3>
                        </div>
                        <div class="panel-body">
                            <div class="form-group sugested_dag_no">
                                <label for="inputEmail3" class="col-sm-5 control-label">Suggested Dag No</label>
                                <div class="col-sm-4">
                                    <input type="text" class="form-control" name="suggested_dag_no" id="suggested_dag_no"autocomplete="off">
                                </div>
                            </div>
                            
                            <div class="form-group sugested_patta_type">
                                <label for="inputEmail3" class="col-sm-5 control-label">Suggested Patta Type</label>
                                <div class="col-sm-5">
                                    <select class="form-control " id="npc" name="suggested_patta_type">
                                        <option selected disabled value=""><?php echo $this->lang->line('select_patta_type'); ?></option>
                                        <?php
                                        foreach ($patta_code as $pc) {
                                            echo "<option value='$pc->type_code'>$pc->patta_type</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group sugested_patta_no">
                                <label for="inputEmail3" class="col-sm-5 control-label">Suggested Patta No</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control suggested_patta_no" name="suggested_patta_no" id="suggested_patta_no">
                                </div>
                                <div class='msg' style="padding: 20px;text-align: center;"></div>
                                <label for="inputEmail3" class="col-sm-12 red">Select the remarks that will be transfered in the new patta.</label>
                                <div class="col-sm-12" id= "remark" style='border: 1px solid red;height:200px;overflow-y:scroll;width:100%;'>
                                </div>
                            </div>

                            <div class="form-group sugested_land_class">
                                <label for="inputEmail3" class="col-sm-5 control-label">Suggested Land Class</label>
                                <div class="col-sm-5">
                                    <select class="form-control" name="suggested_land_class" id="suggested_land_class">
                                        <option selected disabled value=""><?php echo $this->lang->line('select_land_class'); ?></option>
                                        <?php
                                        foreach ($land_class as $lc) {
                                            echo "<option value='$lc->class_code'>$lc->land_type</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group sugested_land_rev">
                                <label for="inputEmail3" class="col-sm-5 control-label">Suggested Revenue</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control" name="suggested_land_rev"  value="" id="suggested_land_rev">
                                </div>
                            </div>
                            <div class="form-group sugested_local_tax">
                                <label for="inputEmail3" class="col-sm-5 control-label">Suggested Local Tax</label>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control loc_tax" name="suggested_loc_tax" id="suggested_loc_tax" value="">
                                </div>
                            </div>
							
							
							  <div class="form-group sugested_striked">
                                <label for="inputEmail3" class="col-sm-3 control-label">Suggested strike</label>
                                <div class="col-sm-5">
                                    <select class="form-control " id="striked" name="suggested_striked[]"  >
                                        <option selected disabled value=""><?php echo $this->lang->line('select_pattadar'); ?></option>
                                        <?php
                                        foreach ($striked_pattadar as $sp) {
                                            echo "<option value='$sp->pdar_id'>$sp->pdar_name</option>";
                                        }
                                        ?>
                                    </select>
									 <h6>* Strike Out Pattadar is shown in Red Colour</h6>
                                </div>
								  
                            </div>
							
                            <div class="form-group alert alert-success sugested_area">
                                <label for="inputEmail3" class="col-sm-3 control-label"><span class="ass-btn">Suggested Area</span></label>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name='suggested_dag_area_b' id="suggested_dag_area_b" placeholder="বিঘা"  value="">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name='suggested_dag_area_k' id='suggested_dag_area_k' placeholder="কঠা"  value="">
                                </div>
                                <div class="col-sm-3">
                                    <input type="text" class="form-control" name='suggested_dag_area_lc' id='suggested_dag_area_lc' placeholder="লেছা"  value="">
                                </div>
                                <!--#START PLB-->
                                <?php
                                $dist_code = $this->session->userdata('dist_code');
                                if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" name='suggested_dag_area_g' id='suggested_dag_area_g' placeholder="গন্ডা"  value="" style="padding: 5px">
                                </div>

                                <?php }?>
                            </div>
                            <hr class="border" style="border-bottom: 2px solid #000;">
                            <h2><mark>Lot Mondal's Note On Action</mark></h2>
                            <div class="form-group">
                                <div class="col-sm-12">
                                <?php
                                $dist_code = $this->session->userdata('dist_code');
                                if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                    <textarea name="lm_note" class="form-control" rows="5">হাতের লেখার তথ্যে উল্লিখিত দাগের তথ্য সংশোধন করে সার্কেল অফিসারের অনুমোদনের জন্য উপরোক্ত সংশোধনগুলি করা হয়েছে।</textarea>
                                <?php }else{?>
                                    <textarea name="lm_note" class="form-control" rows="5">হাতৰ চিঠাৰ তথ্য  ৰ ভিতিত উক্ত দাগত তথ্যৰ সংশোধনী কৰি উপৰোক্ত সংশোধন কেইটা  চক্ৰ বিষয়াৰ অনুমোদনৰ বাবে দিয়া হল ৷</textarea>

                                <?php }?>
                                    
                                    <textarea name="lm_note_suffix" class="form-control hide" rows="5"><?php echo "লাঃ মঃ " . $lm_name->lm_name; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">File Upload</label>
                                <div class="col-sm-4">
                                    <div class="btn btn-primary btn-sm float-left">
                                        <input type="file" name="file_upload" id="fileupload" required>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-11 col-lg-offset-2">
                                    <button type="submit" class="btn btn-success" onclick="return delconfirm()"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                    <button type="reset" name="ASTSTEP1Su" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".sugested_dag_no").hide();
    $(".sugested_patta_no").hide();
    $(".sugested_patta_type").hide();
    $(".sugested_land_class").hide();
    $(".sugested_land_rev").hide();
    $(".sugested_local_tax").hide();
    $(".sugested_striked").hide();
    $(".sugested_area").hide();
    $(".border").hide();

    $(".pattano").click(function () {
        if ($(this).is(":checked")) {
            $(".sugested_patta_no").show();
            $(".border").show();
        } else {
            $(".sugested_patta_no").hide();
            $(".border").hide();
        }
    });

    $(".patta_type").click(function () {
        if ($(this).is(":checked")) {
            $(".sugested_patta_type").show();
            document.getElementById("npc").classList.add("patta_code");
            document.getElementById("opc").classList.remove("patta_code");
            $(".border").show();
        } else {
            $(".sugested_patta_type").hide();
            document.getElementById("opc").classList.add("patta_code");
            document.getElementById("npc").classList.remove("patta_code");
            $(".border").hide();
        }
    });

    $(".land_class").click(function () {
        if ($(this).is(":checked")) {
            $(".sugested_land_class").show();
            $(".border").show();
        } else {
            $(".sugested_land_class").hide();
            $(".border").hide();
        }
    });

    $(".land_revenue").click(function () {
        if ($(this).is(":checked")) {
            $(".sugested_land_rev").show();
            $(".border").show();
        } else {
            $(".sugested_land_rev").hide();
            $(".border").hide();
        }
    });

    $(".local_tax").click(function () {
        if ($(this).is(":checked")) {
            $(".sugested_local_tax").show();
            $(".border").show();
        } else {
            $(".sugested_local_tax").hide();
            $(".border").hide();
        }
    });
	
	
	 $(".striked").click(function () {
        if ($(this).is(":checked")) {
            $(".sugested_striked").show();
            $(".border").show();
        } else {
            $(".sugested_striked").hide();
            $(".border").hide();
        }
    });

    $(".area").click(function () {
        if ($(this).is(":checked")) {
            $(".sugested_area").show();
            $(".border").show();
        } else {
            $(".sugested_area").hide();
            $(".border").hide();
        }
    });
</script>

<script type="text/javascript">

    // function generate_dag_details() {
    //     event.preventDefault();
    //     $('.err__msgs').html('');
    //     $('.error_alert').hide();

    //     $("#patta_type_div").show();
    //     $("#pattano_div").show();
    //     $("#land_class_div").show();
    //     $("#land_revenue_div").show();
    //     $("#local_tax_div").show();
    //     $("#striked_div").show();
    //     $("#area_div").show();

    //     $(".patta_type").prop('checked', false);
    //     $(".pattano").prop('checked', false);
    //     $(".land_class").prop('checked', false);
    //     $(".land_revenue").prop('checked', false);
    //     $(".local_tax").prop('checked', false);
    //     $(".striked").prop('checked', false);
    //     $(".area").prop('checked', false);

    //     $("#suggested_dag_no").val(''); 
    //     $("#npc").prop('selectedIndex', 0);
    //     $("#sugested_patta_no").val('');
    //     $("#sugested_land_class").prop('selectedIndex', 0);
    //     $("#suggested_land_rev").val('');
    //     $("#suggested_loc_tax").val('');
    //     $("#striked").val('');
    //     $("#suggested_dag_area_b").val('');
    //     $("#suggested_dag_area_k").val('');
    //     $("#suggested_dag_area_lc").val('');
    //     var dag_no = $('#g_from_d').val();
    //     var dag_no=encodeURIComponent(dag_no);
    //     if (dag_no == '')
    //     {
    //         alert("Please Enter a Dag No..");
    //         exit();
    //     }
    //     $.ajax({
    //         url: baseurl + "LegacyDataUpdation/getDagDetJSON/" + dag_no,
    //         success: function (data) {
    //             var dag = JSON.parse(data);
    //             $('#patta').val(dag[0].patta_no);
    //             $('#b').val(dag[0].dag_area_b);
    //             $('#katha').val(dag[0].dag_area_k);
    //             $('#l').val(parseFloat(dag[0].dag_area_lc));
    //             $('#g').val(parseFloat(dag[0].dag_area_g));
    //             $('#k').val(dag[0].dag_area_kr);
    //             var land_rev = dag[0].dag_revenue;
    //             var l_tax = dag[0].dag_local_tax;
    //             var total = parseFloat(land_rev) + parseFloat(l_tax);
    //             $('#p_land_revv').val(parseFloat(land_rev).toFixed(2));
    //             $('#loc_tax').val(parseFloat(l_tax).toFixed(2));
    //             $('#tot_rev').val(parseFloat(total).toFixed(2));
    //             var patta_code = dag[0].patta_type_code;
    //             $.ajax({
    //                 url: baseurl + "LegacyDataUpdation/getPattaNameJSON/" + patta_code,
    //                 success: function (data) {
    //                     var lot = JSON.parse(data);
    //                     var template = "<option selected disabled>Select Patta Type</option>";
    //                     for (var i = 0; i < lot.length; i++) {
    //                         template += "<option value='" + lot[i].type_code + "' selected>" + lot[i].patta_type + "</option>";
    //                     }
    //                     // console.log(template);
    //                     $('select[name="patta_type"]').html(template);
    //                     if((dag[0].patta_no == '0') && (lot[0].mutation == 'n'))
    //                     {
    //                         $("#patta_type_div").show();
    //                         $("#pattano_div").show();
    //                         $("#land_class_div").show();
    //                         $("#land_revenue_div").show();
    //                         $("#local_tax_div").show();
    //                         $("#striked_div").hide();
    //                         $("#area_div").show();
    //                     }
    //                 }
    //             });
    //             var land_class_code = dag[0].land_class_code;
    //             $.ajax({
    //                 url: baseurl + "LegacyDataUpdation/getLandClassNameJSON/" + land_class_code,
    //                 success: function (data) {
    //                     // if (debug) {
    //                     //     console.log(data);
    //                     // }
    //                     var lot = JSON.parse(data);
    //                     var template = "<option selected disabled>Select Land Class</option>";
    //                     for (var i = 0; i < lot.length; i++) {
    //                         template += "<option value='" + lot[i].class_code + "' selected>" + lot[i].land_type + "</option>";
    //                     }
    //                     // console.log(template);
    //                     $('select[name="land_class"]').html(template);
    //                 }
    //             });
    //             var patta_no = dag[0].patta_no;
    //             $.ajax({
    //                 url: baseurl + "LegacyDataUpdation/getRemarksJSON/" + patta_no + "/" + patta_code,
    //                 success: function (data) {
    //                     // if (debug) {
    //                     //     console.log(data);
    //                     // }
    //                     var rmk = JSON.parse(data);
    //                     var template = "";
    //                     for (var i = 0; i < rmk.length; i++) {
    //                         template += '<label class="block-label" for="radio-1"><input type="checkbox" id="checkbox" name="remark[]" value="'+rmk[i].rmk_line_no+'" />&nbsp;&nbsp;'+rmk[i].remark+'</label><hr style="border-bottom: 1px solid #000;">';
    //                     }
    //                     // console.log(template);
    //                     $('#remark').html(template);
    //                 }
    //             });+
				
	// 			//   var patta_no = dag[0].patta_no;
             
				
	// 			 $.ajax({
    //                 url: baseurl + "LegacyDataUpdation/getPattadarJSON/" + dag_no + "/" + patta_no + "/" + patta_code,
					
    //                 success: function (data) {
    //                     var ps = JSON.parse(data);
						
	// 					var template = "<option selected disabled>Select Pattadar Name</option>";
	// 					var count='0';
	// 					for(var i= 0; i< ps.length ; i++){
							
	// 						if(ps[i].p_flag=='1')
	// 						count = parseInt(count) + 1;
							
	// 					}
						
						
    //                     for (var i = 0; i < ps.length; i++) {
							
							
	// 						if((ps[i].p_flag=='0')&&((ps.length-count)=='1')){
    //                         template += "<option value='" + ps[i].p_flag +"_"+ ps[i].pdar_id +"_"+ps[i].pdar_name +  "' disabled >" + ps[i].pdar_name + "</option>";
	// 						alert('Cannot strike out pattadar because there is only one unstriked pattadar left but you can unstrike pattadar');
	// 						}
							
	// 						else if((ps[i].p_flag=='0')&&((ps.length-count)!='1')){
	// 							 template += "<option value='" + ps[i].p_flag +"_"+ ps[i].pdar_id +"_"+ps[i].pdar_name +  "'  >" + ps[i].pdar_name + "</option>";
	// 						}
							
	// 						else{
								
	// 							  template += "<option value='" + ps[i].p_flag +"_"+ ps[i].pdar_id +"_"+ ps[i].pdar_name + "' class='text-style'>" + ps[i].pdar_name + "</option>";
								
	// 						}
    //                     }
						
						
    //                     // console.log(template);
    //                     $('select[name="suggested_striked[]"]').html(template);
    //                 }
    //             });
				
				
    //         },
    //         error: function(errorData){
    //             if(errorData.status){
    //                 const errorMsg = errorData.responseJSON.errors;
    //                 $('.err__msgs').html(errorMsg);
    //                 $('.error_alert').show();
    //                 document.getElementById("f1").reset();
    //                 $('select[name="patta_type"]').html('<option value="" selected disabled>Select Patta Type</option>');
    //                 $('select[name="land_class"]').html('<option value="" selected disabled>Select Land Class</option>');
    //             }
    //         }
    //     });
    // }
    function generate_dag_details() {
        event.preventDefault();

        // Reset errors
        $('.err__msgs').html('');
        $('.error_alert').hide();

        // Show all divs
        $("#patta_type_div, #pattano_div, #land_class_div, #land_revenue_div, #local_tax_div, #striked_div, #area_div").show();

        // Reset checkboxes
        $(".patta_type, .pattano, .land_class, .land_revenue, .local_tax, .striked, .area").prop('checked', false);

        // Reset fields
        $("#suggested_dag_no").val('');
        $("#npc").prop('selectedIndex', 0);
        $("#sugested_patta_no").val('');
        $("#sugested_land_class").prop('selectedIndex', 0);
        $("#suggested_land_rev").val('');
        $("#suggested_loc_tax").val('');
        $("#striked").val('');
        $("#suggested_dag_area_b").val('');
        $("#suggested_dag_area_k").val('');
        $("#suggested_dag_area_lc").val('');

        var dag_no = $('#g_from_d').val().trim();

        // Input validation
        if (dag_no === '') {
            alert("Please Enter a Dag No..");
            return;
        }

        // First AJAX: Get Dag Details
        $.ajax({
            url: baseurl + "LegacyDataUpdation/getDagDetJSON",
            type: "POST",
            data: { dag_no: dag_no },

            success: function (data) {
                var dag = JSON.parse(data);

                // Fill Dag Details
                $('#patta').val(dag[0].patta_no);
                $('#b').val(dag[0].dag_area_b);
                $('#katha').val(dag[0].dag_area_k);
                $('#l').val(parseFloat(dag[0].dag_area_lc));
                $('#g').val(parseFloat(dag[0].dag_area_g));
                $('#k').val(dag[0].dag_area_kr);

                var land_rev = parseFloat(dag[0].dag_revenue);
                var l_tax = parseFloat(dag[0].dag_local_tax);
                var total = land_rev + l_tax;

                $('#p_land_revv').val(land_rev.toFixed(2));
                $('#loc_tax').val(l_tax.toFixed(2));
                $('#tot_rev').val(total.toFixed(2));

                var patta_code = dag[0].patta_type_code;
                var patta_no = dag[0].patta_no;
                var land_class_code = dag[0].land_class_code;

                // AJAX 2: Get Patta Type Name
                $.ajax({
                    url: baseurl + "LegacyDataUpdation/getPattaNameJSON",
                    type: "POST",
                    data: { patta_code: patta_code },

                    success: function (data) {
                        var lot = JSON.parse(data);
                        var template = "<option selected disabled>Select Patta Type</option>";

                        for (var i = 0; i < lot.length; i++) {
                            template += `<option value="${lot[i].type_code}" selected>${lot[i].patta_type}</option>`;
                        }

                        $('select[name="patta_type"]').html(template);

                        if (patta_no == '0' && lot[0].mutation == 'n') {
                            $("#striked_div").hide(); // don't show strikeout
                        }
                    }
                });

                // AJAX 3: Get Land Class Name
                $.ajax({
                    url: baseurl + "LegacyDataUpdation/getLandClassNameJSON",
                    type: "POST",
                    data: { land_class_code: land_class_code },

                    success: function (data) {
                        var lot = JSON.parse(data);
                        var template = "<option selected disabled>Select Land Class</option>";

                        for (var i = 0; i < lot.length; i++) {
                            template += `<option value="${lot[i].class_code}" selected>${lot[i].land_type}</option>`;
                        }

                        $('select[name="land_class"]').html(template);
                    }
                });

                // AJAX 4: Get Remarks
                $.ajax({
                    url: baseurl + "LegacyDataUpdation/getRemarksJSON",
                    type: "POST",
                    data: { patta_no: patta_no, patta_code: patta_code },

                    success: function (data) {
                        var rmk = JSON.parse(data);
                        var template = "";

                        for (var i = 0; i < rmk.length; i++) {
                            template += `
                                <label class="block-label">
                                    <input type="checkbox" name="remark[]" value="${rmk[i].rmk_line_no}"/>
                                    &nbsp;&nbsp;${rmk[i].remark}
                                </label>
                                <hr/>
                            `;
                        }

                        $('#remark').html(template);
                    }
                });

                // AJAX 5: Get Pattadar List
                $.ajax({
                    url: baseurl + "LegacyDataUpdation/getPattadarJSON",
                    type: "POST",
                    data: { dag_no: dag_no, patta_no: patta_no, patta_code: patta_code },

                    success: function (data) {
                        var ps = JSON.parse(data);

                        var template = "<option selected disabled>Select Pattadar Name</option>";
                        var activeCount = ps.filter(p => p.p_flag == '1').length;

                        for (var i = 0; i < ps.length; i++) {

                            if (ps[i].p_flag == '0' && (ps.length - activeCount) == 1) {
                                template += `<option value="${ps[i].p_flag}_${ps[i].pdar_id}_${ps[i].pdar_name}" disabled>
                                                ${ps[i].pdar_name}
                                             </option>`;
                                alert('Cannot strike out pattadar because only one unstriked pattadar is left.');
                            }
                            else {
                                template += `<option value="${ps[i].p_flag}_${ps[i].pdar_id}_${ps[i].pdar_name}">
                                                ${ps[i].pdar_name}
                                             </option>`;
                            }
                        }

                        $('select[name="suggested_striked[]"]').html(template);
                    }
                });

            },

            error: function (errorData) {
                if (errorData.status) {
                    const errorMsg = errorData.responseJSON.errors;
                    $('.err__msgs').html(errorMsg);
                    $('.error_alert').show();

                    document.getElementById("f1").reset();

                    $('select[name="patta_type"]').html('<option value="" selected disabled>Select Patta Type</option>');
                    $('select[name="land_class"]').html('<option value="" selected disabled>Select Land Class</option>');
                }
            }
        });
    }

    $(".suggested_patta_no").blur(function () {
        var pp = $(".patta_code option:selected").val();
        var p = $('.suggested_patta_no').val();
        $.ajax({
            url: baseurl + "LegacyDataUpdation/existPattaNo/" + p + "/" + pp,
            success: function (data) {
                // if (debug) {
                //     console.log(data);
                // }
                var data = JSON.parse(data);
                if (data['val'] == '') {
                    $(".msg").show();
                    var template = "<label class='red'>এই পট্টা নং নতুন পট্টা হয় |</label>";
                    $(".msg").html(template);
                }
                if (data['val'] != '') {
                    $(".msg").show();
                    var template = "<label class='red'>"+data['val']+"</label>";
                    $(".msg").html(template);
                }

            }
        });
    });
</script>
