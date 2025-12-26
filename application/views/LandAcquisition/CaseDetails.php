<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Pending Correction Of NH Affected Lands (Land Acquisition)</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-body">
                        <fieldset>
                            <h2 class="red"><?php echo $this->lang->line('general_information'); ?></h2>
                            <table class='table table-bordered unicode'>
                                <tr>
                                    <td width="35%"><label class="text-danger"><?php echo $this->lang->line('district'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['dist']; ?></label></td>
                                    <td width="30%"><label class="text-danger"><?php echo $this->lang->line('subdivision'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['sub']; ?></label></td>
                                    <td width="35%"><label class="text-danger"><?php echo $this->lang->line('circle'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['cir']; ?></label></td>
                                </tr>
                                <tr>
                                    <td><label class="text-danger"><?php echo $this->lang->line('lot_no'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['lot']; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('mouza'); ?>  : &nbsp;&nbsp;&nbsp;<?php echo $location['mouza']; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('vill_town'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $location['vill']; ?></label></td>
                                </tr>
                                <tr>
                                    <td><label class="text-danger"><?php echo $this->lang->line('dag_no'); ?> : <?php echo $dag_details[0]->dag_no; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('patta_no'); ?> : <?php echo $dag_details[0]->patta_no; ?></label></td>
                                    <td><label class="text-danger">
                                            <?php $patta_type_name = $this->utilityclass->getPattaName($dag_details[0]->patta_type_code); ?>
                                            <?php echo $this->lang->line('patta_type'); ?> : <?php echo $patta_type_name; ?></label>
                                    </td>
                                </tr>
<!--                                <tr>
                                    <td><label class="text-danger"><?php echo $this->lang->line('new_dag_no'); ?> : <?php echo $change_details[0]->new_dag_no; ?></label></td>
                                    <td><label class="text-danger"><?php echo $this->lang->line('new_patta_no'); ?> : <?php echo $change_details[0]->new_patta_no; ?></label></td>
                                    <td><label class="text-danger">
                                <?php echo $this->lang->line('case_no'); ?> : &nbsp;&nbsp;&nbsp;<?php echo $case_details[0]->case_no; ?>
                                <?php $new_patta_type_name = $this->utilityclass->getPattaName($change_details[0]->new_patta_type); ?>
                                <?php echo $this->lang->line('new_patta_type'); ?> : <?php echo $new_patta_type_name; ?></label></td>
                                </tr>-->
                            </table>
                        </fieldset>
                        <hr style="border-bottom: 2px solid #000;">
                        <label class="red">
                            <?php echo $case_details[0]->remarks; ?>
                        </label>
                        <hr style="border-bottom: 2px solid #000;">
                        <h2 class="red">New <?php echo $this->lang->line('dag_details'); ?>  as per Acquisition</h2>
                        <form class='form-horizontal unicode' id='myForm' action="<?php echo base_url() . "index.php/LandAcquisition/Update"; ?>" method="post">
                            <div class="form-group">
                                <div class="col-lg-3">
                                    <label for="select" class="control-label"><?php echo $this->lang->line('new_dag_no'); ?></label>
                                    <input type="text"  class="form-control" value="0" id="newDag" name='new_dag_no'>
                                </div>
                                <div class="col-lg-3">
                                    <label for="select" class="control-label"><?php echo $this->lang->line('new_patta_type'); ?></label>
                                    <select class="form-control" id="new_patta_type" required name="new_patta_type">
                                        <option selected disabled><?php echo $this->lang->line('select_patta_type'); ?></option>
                                        <?php
                                        foreach ($govt_patta_type as $p) {
                                            ?>
                                            <option  value="<?php echo $p->type_code; ?>"><?php echo $p->patta_type; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <label for="select" class="control-label"><?php echo $this->lang->line('new_patta_no'); ?></label>
                                    <input type="number"  class="form-control" value="0" id="newPatta" readonly="" name='new_patta_no' >
                                </div>
                                <div class="col-lg-3">
                                    <label for="select" class="control-label"><?php echo $this->lang->line('new_land_class'); ?></label>
                                    <select class="form-control" id="new_land_class" required name="new_land_class">
                                        <option  selected value="0134">শ্ৰেণী নাই</option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;padding-bottom: inherit;">
                        <div class="col-lg-12" id="co_block">
                            <label class="rasid col-sm-12">
                                <input type="checkbox" id="myCheck" onclick="myFunction()"> চঃ বিঃ – লাঃ মঃৰ প্ৰতিবেদনৰ ভিত্তিত উপৰোক্ত বকেয়া ম্যাদীকৰণ ও নথি সংশোধন অনুমোদন কৰা হ’ল   |
                            </label>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-9 col-lg-offset-4">
                                <button type="submit" id='formsubmit'  class="btn btn-success change_text1"><i class='fa fa-check'></i>&nbsp;Submit & Pass Final Order</button>
                                <a href="<?php echo base_url(); ?>index.php/LandAcquisition/copending" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(".change_text1").attr('disabled', true);
    $('#formsubmit').click(function () {
        var new_patta_type = $('#new_patta_type').val();
        var newDag = $('#newDag').val();
        var newPatta = $('#newPatta').val();
        var new_land_class = $('#new_land_class').val();

        if ((newDag == '') || (newPatta == '')) {
            alert('Please Enter New Dag no / New Patta no..!');
            return false;
        }

        if ((new_patta_type == null)) {
            alert('Please Select New Patta Type!');
            return false;
        }

//        $.ajax({
//            url: baseurl + "BackLogConversion/chech_existing_dag/" + dist_code_new + '/' + subdiv_code_new + '/' + circle_code_new + '/' + mouza_code_new + '/' + lot_no_new + '/' + village_new + '/' +newDag,
//            success: function (data) {
//                console.log(data);
//                var result = JSON.parse(data);
//                if(result == '1')
//                {
//                    alert('Dag Number Already Exist!');
//                    //document.getElementById("msg1").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Dag Number Already Exists</p></label>";
//                    return false;
//                }
//                else
//                {
//                    document.getElementById("myForm").submit();
//                }
//            }
//        });
        //exit();
        document.getElementById("myForm").submit();
    });


    function myFunction() {
        var checkBox = document.getElementById("myCheck");
        if (checkBox.checked == true) {
            $('.change_text1').removeAttr('disabled', false);
        } else {
            $('.change_text1').attr('disabled', true);
        }
    }
</script>