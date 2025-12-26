<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Back Log Entry</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Back Log Entry
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b><p style="font-size: 1.5em;">Please make sure that Offline and 
                                        Online Dharitree Data is matching before Proceeding. If not, use backlog entry module to update data.</p>
                                </b></h6>
                        </div>
                        <center>
                            <table class="table table-condensed">
                                <tr>
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/utility/BackEntryLandConversion">Back Log Entry For Land Conversion</a></td>
                                </tr>
                                <tr>
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/utility/BackEntryReclassification">Back Log Entry For Land Reclassification</a></td>
                                </tr>
                                <tr class='hide'>
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/utility/BackEntryNameCorrection">Back Log Entry For Name Correction</a></td>
                                </tr>
                                <tr class='hide'>
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/mutationbacklog/mutation/1">Back Log Entry For Field Mutation/Partition</a></td>
                                </tr>
                                <tr class='hide'>
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/mutationbacklog/mutation/2">Back Log Entry For Office Mutation</a></td>
                                </tr>
                                <tr>
                                    <td>&gt;&gt;<a href="<?php echo base_url(); ?>index.php/Backlogpartition/index">Back Log Entry For Partition(Office)</a></td>
                                </tr>
                            </table>
                        </center>

                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-5">
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
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
<script>
    $(document).ready(function () {
        $(".delJR").mouseover(function () {
            $(".panel").fadeToggle("slow");
        });
    });
</script>