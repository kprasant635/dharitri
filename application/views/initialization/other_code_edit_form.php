<div class="row" style="min-height: 500px;">
    <div class="col-lg-12 center-col">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid"><u><?php echo $this->lang->line('data_edit_form');?></u></span></p>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <center>
                            <b>The contents of master table - <span style="color: red"><?php echo $datas['table_name']; ?></span> is :</b><br>
                            <br><br>
                            <table class="table table-bordered">
                                <thead style="flex: 1 1 auto; display: block; overflow-y: scroll;">
                                    <tr style='text-align: center; width: 100%;display: table; table-layout: fixed;'>
                                        <td width="40%"><?php echo $datas['table_name']; ?> Code</td>
                                        <td width="40%"><?php echo $datas['table_name']; ?> Name</td>
                                        <td width="20%">Action</td>
                                    </tr>
                                </thead>
                                <tbody style="flex: 1 1 auto; display: block; overflow-y: scroll; height: 200px;">
                                    <?php foreach ($master_result as $m_result): ?>
                                        <tr style='text-align: center; width: 100%;display: table; table-layout: fixed;'>
                                            <td width="40%"><?php echo $m_result->code; ?></td>
                                            <td width="40%"><?php echo $m_result->type; ?></td>
                                            <td width="20%"><a href="<?php echo "?values=" . $m_result->code . "&" . $m_result->type; ?>" class="change_status"><?php echo $this->lang->line('edit');?></a></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </center>
                    </div>

                    <div class="col-lg-6">
                        <center>
                            <form  name="frmLClass" method ="post" action="<?php echo base_url(); ?>index.php/initialization/afterEdit" >
                                <b>You are editing data into <span style="color: red"><?php echo $datas['table_name']; ?></span> Table</b><br>
                                <br><br>
                                <center>
                                    <table border="1" cellpadding="1" cellspacing="2"  style="VISIBILITY: visible" class="table table-bordered">
                                        <tr>
                                            <td width="20%"><b><?php echo $datas['table_name']; ?> Code</b></td>
                                            <td colspan=2><b><input size='default' style="width:40%;" name="Code" id="code" maxLength='7' size='6' readonly></b>
                                                <font color=red>
                                                <?php
                                                $valid_length = 0;
                                                if ($datas['table_name'] == "crop_code" || $datas['table_name'] == "fruit_tree_code" || $datas['table_name'] == "premium_chalan_receipt") {
                                                    echo "<b>*Enter 3 digit code only</b>";
                                                    $valid_length = 3;
                                                } elseif ($datas['table_name'] == "patta_code" || $datas['table_name'] == "landclass_code") {
                                                    echo "<b>*Enter 4 digit code only</b>";
                                                    $valid_length = 4;
                                                } else {
                                                    echo"<b>*Enter 2 digit code only</b>";
                                                    $valid_length = 2;
                                                }
                                                ?>
                                                </font><br>	
                                            </td>
                                        </tr>
                                        <tr><td colspan="3">&nbsp;<input type='hidden' name='valid_length' value="<?php echo $valid_length; ?>"></td></tr>
                                        <tr>
                                            <td width="20%"><b><?php echo $datas['table_name']; ?> Name<br></b></td>
                                            <td colspan="2"><b><input size='default' style="width:70%;" name="Type" id="type" maxLength='45' size='45'></b></td>
                                        </tr>
                                    </table>
                                </center>
                                <input type='hidden' name='table_name' value="<?php echo $datas['table_name']; ?>">
                                <p>&nbsp;</p>
                                <P>&nbsp;</P>
                                <P align = center>
                                    <a href="<?php echo base_url();?>index.php/initialization/master_code_edit" class="btn btn-danger" id=""><< <?php echo $this->lang->line('back');?></a>  || 
                                    <button type="submit" id='submit' name='submit' value="Submit" class="btn btn-danger" onclick="return checkvalidation(frmLClass);" title="Click on Submit to post the entered data"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button');?></button>
                                </P>	
                            </form>
                        </center>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">
    $("a.change_status").click(function () {
        var status_id = $(this).attr('href').split('=');

        var values = status_id[1].split('&');
        //alert(values); 
        $('#code').val(values[0]);
        $('#type').val(values[1]);
        return false;
    });


    function IsNumeric(sText)
    {
        var ValidChars = "0123456789";
        var IsNumber = true;
        var Char;
        for (i = 0; i < sText.length && IsNumber == true; i++)
        {
            Char = sText.charAt(i);
            if (ValidChars.indexOf(Char) == -1)
            {
                IsNumber = false;
            }
        }
        return IsNumber;
    }  //end ISNumeric

    //check the validity of the submitted form!
    function checkvalidation(frmLClass)
    {
        var re = /^\s{1,}$/g;
        if ((frmLClass.Code.value.length == 0) || (frmLClass.Code.value == null) || ((frmLClass.Code.value.search(re)) > -1))
        {
            alert("Please Enter Code ! Code length cannot be zero or contain blank spaces !");
            frmLClass.Code.focus();
            return false;
        }
        if ((frmLClass.Type.value.length == 0) || (frmLClass.Type.value == null) || ((frmLClass.Type.value.search(re)) > -1))
        {
            alert("Type length cannot be zero or contain Blank Spaces !");
            frmLClass.Type.focus();
            return false;
        }
        if (!IsNumeric(frmLClass.Code.value) == true)
        {
            alert("The Code Field should be numeric !");
            frmLClass.Code.focus();
            return false;
        }
        if (!(frmLClass.Code.value.length == frmLClass.valid_length.value) == true)
        {
            alert("The Code Field should be of length " + frmLClass.valid_length.value);
            frmLClass.Code.focus();
            return false;
        }
        return true;
    }//end function
</script>
