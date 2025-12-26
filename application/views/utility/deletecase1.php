<script language="Javascript">
    $(document).ready(function () {
        var flag = $('#flag').val();
        //2 means co has passed order
        if (flag == 2) 
        {          
            document.getElementById("sbutton").disabled = true;
        }
    });

</script>

<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Office Half Done Case Deletion (Complete)</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Dharitree Utility Module
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>NOTE : Only the Cases that are not passed by Circle Officer can be Deleted using this Module.</b></h6>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <table id="" class="table table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <td>Case No</td>
                                    <td class="center">Reporting Date</td>
                                    <td class="center">Pass by SK ?</td>
                                    <td class="center">Order Pass By CO?</td>
                                    <td>Remarks...</td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td width="18%"><?php echo $results['case_no']; ?></td>
                                    <td width="15%" class="center"><?php echo $results['date']; ?></td>
                                    <td width="13%" class="center"><?php echo $results['sk_report']; ?></td>
                                    <td width="18%" class="center"><?php echo $results['co_report']; ?></td>
                                    <td><?php echo $results['remark']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                        <form  name="form1" method="POST" action="<?php echo base_url() . "index.php/Utility/DeleteCaseFM_OM_save"; ?>">
                            <input name="flag_value" type="hidden" id="flag" value="<?php echo $results['flag']; ?>">
                            <input type="hidden" name="case_no" value="<?php echo $results['case_no']; ?>">
                            <input type="hidden" name="year" value="<?php echo $results['year']; ?>">
                            <input type="hidden" name="type" value="<?php echo $results['type']; ?>">
                            <br />
                            <div class="form-group">
                                <div class="col-lg-8 col-lg-offset-4">
                                    <button type="submit" name="FormSubmit" id="sbutton" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                    <a href="<?php echo base_url(); ?>index.php/utility/deletecase" class="btn btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
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