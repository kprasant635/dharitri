<script language="Javascript">
    function delconfirm() {
        var case_no = $('#search').val();
        if (case_no == "") {
            alert("Please enter a Case No.");
            return false;
        }
        var a;
        a = confirm("Are you sure you want to Generate Notice for Case no " + case_no + ".")
        if (a == true)
            return true;
        else
            return false;
    }

</script>

<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Regenerate Old Notice's ( First Proceeding Notice / Premium Notice )</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Notice Generation Utility Module
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>NOTE : Please select which notice you want to regenerate by clicking on the radio buttons below.</b></h6>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <form name='frmDelete' method='post' action='<?php echo base_url() . "index.php/AsistantMutationPartha/regenerate_notice_result"; ?>'>
                            <div class="row">
                                <h4 style="text-align: center; font-weight: bold !important;">Select the type of Notice</h4>
                                <hr>
                                <div class="col-lg-7">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="checkbox-inline"><input type="radio" checked  name="category" value="1">Notice Generation for Petitioners and Concerned Parties</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-5">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <label class="checkbox-inline"><input type="radio"  name="category" value="0">Notice Generation for payment of Premium</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <p style="color:red; font-weight: bold !important; font-size: 18px;" class='center'>Please enter valid Office Conversion case no.</p>
                            <div class="row">
                                <div class="col-lg-8 col-lg-offset-3">
                                    <div class="form-group">
                                        <div class="col-sm-9">
                                            <input type="text" placeholder="Enter Case Number Here" name="case_no" id="search" class="form-control" >
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group center">
                                <div class="col-lg-12">
                                    <button type="submit" name="del_button" id="sbutton" onclick="return delconfirm()" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-tabs li{
        background:#3bafda;
        color:#fff;
    }
    .nav-tabs > li.active > a, .nav-tabs > li.active{
        background:#800000 !important;
        color:#fff;
    }
    .nav-tabs li a{
        color:#fff;
        font-size:19px;
        font-weight:bold;
    }


</style>    