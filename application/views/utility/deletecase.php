<style>
    td			 {FONT-FAMILY:ms sans serif;FONT-SIZE:8;COLOR:BLUE}
    .HEADING     { cursor: hand; font-family: Verdana,Arial,San Serif; font-size: 11px; color: #0033FF; 
                   background-color: #DDDDDD; font-weight: none;
                   border: 1px solid #000000;  }
    .SUBHEADING  { cursor: hand; font-family: Verdana,Arial,San Serif; font-size: 11px; color: #AAAAAA; 
                   background-color: lightyellow; font-weight: none; 
                   border: 1px solid #000000;  }               
    .LINKSOFF    { display: none; font-family: Verdana,Arial,San Serif; font-size: 12px; color: #000080 }
    .LINKSON     { display: inline; font-family: Verdana,Arial,San Serif; font-size: 12px; color: #000080 }
</style>
<script language="Javascript">
    function delconfirm() {
        var case_no = $('#case_no').val();
        if (case_no == "") {
            alert("Please enter a Case No.");
            return false;
        }
        var a;
        a = confirm("Are you sure you want to Delete the Case no " + case_no + " Permanently?")
        if (a == true)
            return true;
        else
            return false;
    }

</script>

<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
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
                        <form name='frmDelete' method='post' action='<?php echo base_url() . "index.php/Utility/DeleteCaseFM_OM"; ?>'>
                        <table class='table table-bordered'>
                            <tr>
                                <th width="215"><div align="right"><span class="style10">Select the Case Type to Delete&gt;&gt;</span></div></th>
                                <td width="287">
                                    <select name="cmbcasetype" size="1" tabindex="1" required="">
                                        <option value="1" selected disabled>[Select the Case Type]</option>
                                        <option value="2">Field Mutation/Partition</option>
                                        <option value="3">Office Mutation/Partition etc.</option>
                                    </select>    
                                </td>
                            </tr>
                            <tr>
                                <th scope="row"><div align="right"><span class="style10">Enter Case Year of Case No &gt;&gt; </span></div></th>
                            <td><input type="text" name="txtyear" id="case_no" size="5" tabindex="2"></td>
                            </tr>
                            <tr>
                                <th scope="row"><div align="right"><span class="style10">Enter the Case No&gt;&gt; </span></div></th>
                            <td><input type="text" name="txtcaseno" tabindex="3" size="15">
                                <span class="style12">      (Like 123/2010-11/Fmut etc.) </span></td>
                            </tr>
                        </table>
                        <p style="color:red;" class='center'>Please enter valid Half Done office / field case no.</p>
                        <div class="form-group center">
                            <div class="col-lg-12">
                                <button type="submit" name="del_button" id="sbutton" onclick="return delconfirm()" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button');?></button>
                                <a href="<?php echo base_url(); ?>index.php/utility/misc_utilities" class="btn btn-danger">
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
