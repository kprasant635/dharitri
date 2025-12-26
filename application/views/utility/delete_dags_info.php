<style>
    A:active     {TEXT-DECORATION: none; COLOR: #0000AA}  
    A:link       {TEXT-DECORATION: none; COLOR: #0000AA}
    A:visited    {TEXT-DECORATION: none; COLOR: #0000AA}
    A:hover      {TEXT-DECORATION: underline; COLOR: #FF0000}
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

<form name='frmDelete' method='post' action='<?php echo base_url() . "index.php/Utility/chithadeletion"; ?>'>

    <div class="row login">

        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm ">
                    <center>
                        <table width="918" cellpadding="2" border="1" bordercolor="#99CCFF" style="border-collapse: collapse" cellspacing="0">
                            <tr>	
                                <td bgcolor="#6699FF" colspan=2 align=center style="border-left-color: #99CCFF; border-left-width: 1; border-right-color: #99CCFF; border-right-width: 1; border-top-color: #99CCFF; border-top-width: 1" width="912">
                                    <p dir="ltr">
                                        <font face="Arial" size="4">Chitha Deletion </font>
                                    <font face="Arial" size="3">(Complete or Columns)</font></td>
                            </tr>	
                            <tr>
                                <td style="font-family:ASBW-TTBidisha; font-size:18pt" align="center" width="100%">
                                    <?php echo $namedata[0]->district; ?>  / 
                                    <?php echo $namedata[1]->subdiv; ?>	/ 
                                    <?php echo $namedata[2]->circle; ?> / 
                                    <?php echo $namedata[3]->mouza; ?> / 
                                    <?php echo $namedata[4]->lot_no; ?> / 
                                    <?php echo $namedata[5]->village; ?>
                                    <font face="Arial" size="3"> (<?php echo $loc['dist_code']; ?> / 
                                    <?php echo $loc['subdiv_code']; ?> / 
                                    <?php echo $loc['cir_code']; ?> / 
                                    <?php echo $loc['lot_no']; ?> / 
                                    <?php echo $loc['vill_code']; ?> / 
                                    <?php echo $loc['mouza_pargona_code']; ?>)</font>
                            </tr>
                        </table>
                    </center>
                </div>

                <div class="panel panel-form">
                    <div class="panel-body">
                        <center>
                            <br />
                            <?php
                            if ($dags == null) {
                                echo '<font face="Arial" color=red size="4"><b><span style="background-color: #FFFFCC">Sorry, This Vilage has no Dags!</span></b></font>
                                            <font face="Arial" size="4"></font>
                                            <br>
                                            <a href="' . base_url() . 'index.php/utility/districtselect">
                                                <button type="button" class="btn btn-danger">
                                                <i class="fa fa-arrow-left"></i>&nbsp;Back to Location Selection
                                                </button>
                                                </a><hr style="border-bottom: 2px solid #000;">';
                            } else {
                                ?>
                                <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                                    <h6 class="red uni_text"><b>Note : When all the boxes are checked <span class="glyphicon glyphicon-ok-circle" aria-hidden="true" style='color: green;'></span> 
                                            then the complete dag gets Deleted. You Can optionally Delete a Particular Component of the dag such as, all the orders or 
                                            remarks of colum 31 or colum 8 or even the pattadars etc., by un-checking the Respective boxe(s) and checking the desired box(s).</b></h6>
                                </div>
                            <span style="color: #8a0e2f; font-size: 14px; font-style: italic; font-weight: bold !important;">In case you want to delete a particular order of 
                                colum 31 or colum 8 or remark of colum 31 or colum 8 or a pattadar than <a href="#">Click This Here</a>.</span>
                                <table style="width:616; border-collapse:collapse" border="1" bordercolor="#6699FF" cellpadding="2" cellspacing="4" bgcolor="#DFE8FF">
                                    <tr>
                                        <td width="50%" class='alert alert-sm alert-success' valign="bottom">
                                            <p align="center"><font size="3" face="Verdana">Dag No.</font><p>
                                        </td>
                                        <td width="50%"  class='alert alert-sm alert-success' valign="bottom">
                                            <select name="Dagno_int" size="1" class="form-control" required>
                                                <option selected disabled>-- Select Dag No --</option>
                                                <?php
                                                foreach ($dags as $dg):
                                                    echo "<option value='$dg->dag_no_int'>$dg->dag_no</option>";
                                                endforeach;
                                                ?>
                                            </select>						
                                        </td>
                                    </tr>
                                </table>
                                <?php
                            }
                            ?>
                            <br>
                            <i>
                                <font color="#6699FF" face="Verdana" size="4">Select Column/Components from below-</font>
                            </i>
                            <b><font face="ms sans serif" color=#6666FF size="2">General Chitha Tables</font><font color="#6666FF">&nbsp;</font></b>
                            <p style="color:red;">check on basic to select all the components</p>
                            <br>
                            <table class='table table-bordered'>
                                <tr>
                                    <td width="25%">
                                        <input type="checkbox" checked="true" name="chitha_basic" value=1 onClick="select_all();">&nbsp;Basic
                                    </td>
                                    <td width="25%">
                                        <input type="checkbox" checked="true" name="chitha_pattadar" value=1>&nbsp;Pattadar
                                    </td>
                                    <td width="25%">
                                        <input type="checkbox" checked="true" name="chitha_occupant" value=1>&nbsp;Occupant(Column 8)
                                    </td>
                                    <td width="25%">
                                        <input type="checkbox" checked="true" name="chitha_Tenant" value=1 onClick="select_sub();">&nbsp;Tenant
                                    </td>
                                </tr>

                                <tr>
                                    <td>
                                        <input type="checkbox" checked="true" name="chitha_subtenant" value=1>&nbsp;Subtenant 
                                    </td>
                                    <td>
                                        <input type="checkbox" checked="true" name="chitha_Mcrop" value=1>&nbsp;MCrop
                                    </td>
                                    <td> 
                                        <input type="checkbox" checked="true" name="chitha_Noncrop" value=1>&nbsp;Noncrop
                                    </td>
                                    <td>
                                        <input type="checkbox" checked="true" name="chitha_fruit" value=1>&nbsp;Fruit
                                    </td>
                                </tr>
                            </table>
                            <br>
                            <b><font face="ms sans serif" color=#6666FF size="4">Chitha Remark Tables</font><font color="#6666FF"></font></b>
                            <br>
                            <table class='table table-bordered'>
                                <tr>
                                    <td width="25%">
                                        <input type="checkbox" checked="true" name="lm_note" value=1>&nbsp;LM Note
                                    </td>
                                    <td width="25%">
                                        <input type="checkbox" checked="true" name="sk_note" value=1>&nbsp;SK Note
                                    </td>
                                    <td width="25%">
                                        <input type="checkbox" checked="true" name="encroacher" value=1>&nbsp;Encroacher details
                                    </td>
                                    <td width="25%">
                                        <input type="checkbox" checked="true" name="direct_paying" value=1>&nbsp;Direct Paying Estate
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="checkbox" checked="true" name="conversion" value=1>&nbsp;Conversion(Myadikaran)
                                    </td>
                                    <td> 
                                        <input type="checkbox" checked="true" name="Allotment" value=1>&nbsp;Allotment
                                    </td>
                                    <td> 
                                        <input type="checkbox" checked="true" name="Mutation" value=1>&nbsp;Mutation(Namjari)
                                    </td>
                                    <td>
                                        <input type="checkbox" checked="true" name="Partition" value=1>&nbsp;Partition(Batowara)
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=4>
                                        <input type="checkbox" checked="true" name="others" value=1>&nbsp;Other Cases
                                    </td>
                                </tr>
                            </table>

                            <table class='table table-bordered'>
                                <input type="hidden" name='Dist_code' value='<?php echo $loc['dist_code']; ?>'>
                                <input type="hidden" name='Subdiv_code' value='<?php echo $loc['subdiv_code']; ?>'>
                                <input type="hidden" name='Cir_code' value='<?php echo $loc['cir_code']; ?>'>
                                <input type="hidden" name='Mouza_Pargona_code' value='<?php echo $loc['mouza_pargona_code']; ?>'>
                                <input type="hidden" name='lot_no' value='<?php echo $loc['lot_no']; ?>'>
                                <input type="hidden" name='Vill_townprt_code' value='<?php echo $loc['vill_code']; ?>'>
                                <tr>
                                    <td align=center>
                                        <input type=submit name="del_button" Value=" Delete !" onClick="return checkvalidation(frmDelete);" style="color: #FF0000; font-weight: bold"> <!--onclick="return _confirm();"-->
                                    </td>
                                </tr>
                            </table>
                            <a href="<?php echo base_url(); ?>index.php/utility/districtselect" class="btn btn-danger" style="color:#ffffff;">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>

            </div>
        </div>

    </div>
</form>

<script language="Javascript">
    function _confirm()
    {
        var a;
        //a = confirm("Do you want to delete this record");
        a = confirm("Are you sure you want to remove the data permanently?")
        if (a == true)
            return true;
        else
            return false;
    }

    //this function is for checking the validation of data entered into various fields
    function checkvalidation(frmDelete)
    {
        if (frmDelete.Dagno.value == "")
        {
            alert("Please Select a Dag No.");
            frmDelete.Dagno.focus();
            return false;
        }
        return _confirm();

        //return true;
    }// end function

    function select_all()
    {
        if (document.frmDelete.chitha_basic.checked == true)
        {
            document.frmDelete.chitha_Mcrop.checked = true;
            document.frmDelete.chitha_Noncrop.checked = true;
            document.frmDelete.chitha_occupant.checked = true;
            document.frmDelete.chitha_pattadar.checked = true;
            document.frmDelete.chitha_subtenant.checked = true;
            document.frmDelete.chitha_Tenant.checked = true;
            document.frmDelete.chitha_fruit.checked = true;
            document.frmDelete.lm_note.checked = true;
            document.frmDelete.sk_note.checked = true;
            document.frmDelete.Allotment.checked = true;
            document.frmDelete.direct_paying.checked = true;
            document.frmDelete.conversion.checked = true;
            document.frmDelete.Mutation.checked = true;
            document.frmDelete.Partition.checked = true;
            document.frmDelete.encroacher.checked = true;
            document.frmDelete.others.checked = true;
        }
        else
        {
            document.frmDelete.chitha_Mcrop.checked = false;
            document.frmDelete.chitha_Noncrop.checked = false;
            document.frmDelete.chitha_occupant.checked = false;
            document.frmDelete.chitha_pattadar.checked = false;
            document.frmDelete.chitha_subtenant.checked = false;
            document.frmDelete.chitha_Tenant.checked = false;
            document.frmDelete.chitha_fruit.checked = false;
            document.frmDelete.lm_note.checked = false;
            document.frmDelete.sk_note.checked = false;
            document.frmDelete.Allotment.checked = false;
            document.frmDelete.direct_paying.checked = false;
            document.frmDelete.conversion.checked = false;
            document.frmDelete.Mutation.checked = false;
            document.frmDelete.Partition.checked = false;
            document.frmDelete.encroacher.checked = false;
            document.frmDelete.others.checked = false;
        }
    }

    function select_sub()
    {
        if (document.frmDelete.chitha_Tenant.checked == true)
            document.frmDelete.chitha_subtenant.checked = true;
        else
            document.frmDelete.chitha_subtenant.checked = false;
    }
</script>
<script language="Javascript">
    document.frmDelete.Dagno.focus();
</script>
