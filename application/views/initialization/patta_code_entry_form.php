<div class="row" style="min-height: 500px;">
    <div class="col-lg-12 center-col">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid"><u><?php echo $this->lang->line('data_entry_form');?></u></span></p>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-6">
                        <center>
                            
                            <form  name="frmLClass" method ="post" action="<?php echo base_url();?>index.php/initialization/afterEntry_pattacode" >
                                <b>You are entering data into <span style="color: red"><?php echo $datas['table_name']; ?></span> Table</b><br>
                                <br><br>
                                <center>
                                    <table border="1" cellpadding="1" cellspacing="2"  style="VISIBILITY: visible" class="table table-bordered">
                                        <tr>
                                            <td width="20%"><b><?php echo $this->lang->line('signal');?></b></td>
                                            <td colspan=2><b><input size='default' style="width:40%;" name="type_code"  maxLength=7 size=6></b>
                                            <font color=red>
                                                <?php
                                                $valid_length = 0;
                                                if ($datas['table_name'] == "Crop_code" || $datas['table_name'] == "fruit_tree_code" || $datas['table_name'] == "premium_chalan_receipt") {
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
                                            <td width="20%"><b><?php echo $this->lang->line('description');?></b></td>
                                            <td colspan="2"><b><input size='default' style="width:70%;" name="patta_type" maxLength=45 size=45></b></td>
                                        </tr>
                                        <tr>
                                            <td width="20%"><b>নামজাৰী গোচৰত প্রয়োজ্য হ'বনে : </b></td>
                                            <td colspan="2">
                                                <font face="ASBW-TTDurgaEN" color="#000080" style="font-size: 14pt; font-weight: 700"><input type="radio" value="a" name="mutation"></font>
                                                <font face="ASBW-TTDurgaEN" color="#009900" style="font-size: 17pt">যি কোনো সুত্রে</font><br>
                                                <font face="ASBW-TTDurgaEN" color="#000080" style="font-size: 14pt; font-weight: 700"><input type="radio" value="i" name="mutation" ></font>
                                                <font face="ASBW-TTDurgaEN" color="#0000FF" style="font-size: 17pt">কেবল উত্তৰাধিকাৰ / উঃ দঃ সুত্রে</font><br>
                                                <font face="ASBW-TTDurgaEN" color="#000080" style="font-size: 14pt; font-weight: 700"><input type="radio" value="n" name="mutation"></font>
                                                <font style="font-size: 17pt" face="ASBW-TTDurgaEN" color="#FF0000">নহ'ব</font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%"><b>ম্যাদীকৰণ গোচৰত প্রয়োজ্য হ'বনে :</b></td>
                                            <td colspan="2">
                                                <font face="ASBW-TTDurgaEN" color="#000080" style="font-size: 14pt; font-weight: 700"><input type="radio" value="y" name="conversion"></font>
                                                <font style="font-size: 17pt" face="ASBW-TTDurgaEN" color="#008000">হ'ব</font><br>
                                                <font face="ASBW-TTDurgaEN" color="#000080" style="font-size: 14pt; font-weight: 700"><input type="radio" value="n" name="conversion"></font>
                                                <font style="font-size: 17pt" face="ASBW-TTDurgaEN" color="#FF0000">নহ'ব</font>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%"><b>জমাবন্দীত প্রয়োজ্য হ'বনে :</b></td>
                                            <td colspan="2">
                                                <font face="ASBW-TTDurgaEN" color="#000080" style="font-size: 14pt; font-weight: 700"><input type="radio" value="y" name="jamabandi"></font>
                                                <font style="font-size: 17pt" face="ASBW-TTDurgaEN" color="#008000">হ'ব</font><br>
                                                <font face="ASBW-TTDurgaEN" color="#000080" style="font-size: 14pt; font-weight: 700"><input type="radio" value="n" name="jamabandi" checked></font>
                                                <font style="font-size: 17pt" face="ASBW-TTDurgaEN" color="#FF0000">নহ'ব</font>
                                            </td>
                                        </tr>
                                    </table>
                                </center>
                                <input type='hidden' name='table_name' value="<?php echo $datas['table_name']; ?>">
                                <p>&nbsp;</p>
                                <P>&nbsp;</P>
                                <P align = center>
                                    <a href="<?php echo base_url();?>index.php/initialization/master_code_entry" class="btn btn-danger"><< <?php echo $this->lang->line('back');?></a>  || 
                                    <button type="submit" id='submit' name='submit' value="Submit" class="btn btn-danger" onclick="return checkvalidation(frmLClass);" title="Click on Submit to post the entered data"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button');?></button>
                                </P>	
                            </form>
                            
                        </center>
                    </div>
                    
                    <div class="col-lg-6">
                        <center>
                            <b>The contents of master table - <span style="color: red"><?php echo $datas['table_name']; ?></span> is :</b><br>
                            <br><br>
                            <table class="table">
                                <tr style='text-align: center; color:#0000cc;'>
                                    <td><b>Code</b></td>
                                    <td><b>Patta Name</b></td>
                                    <td><b>Mut</b></td>
                                    <td><b>Conv</b></td>
                                    <td><b>Jamabandi</b></td>
                                    <td><b>Apcancellation</b></td>
                                </tr>
                                <?php foreach($master_result as $m_result): ?>
                                <tr style='text-align: center;'>
                                    <td><?php echo $m_result->type_code; ?></td>
                                    <td><?php echo $m_result->patta_type; ?></td>
                                    <td><?php echo $m_result->mutation; ?></td>
                                    <td><?php echo $m_result->conversion; ?></td>
                                    <td><?php echo $m_result->jamabandi; ?></td>
                                    <td><?php echo $m_result->apcancellation; ?></td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </center>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<script language="javascript" type="text/javascript">
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
        if ((frmLClass.type_code.value.length == 0) || (frmLClass.type_code.value == null) || ((frmLClass.type_code.value.search(re)) > -1))
        {
            alert("Please Enter Code ! Code length cannot be zero or contain blank spaces !");
            frmLClass.type_code.focus();
            return false;
        }
        if ((frmLClass.patta_type.value.length == 0) || (frmLClass.patta_type.value == null) || ((frmLClass.patta_type.value.search(re)) > -1))
        {
            alert("Type length cannot be zero or contain Blank Spaces !");
            frmLClass.patta_type.focus();
            return false;
        }
        if (!IsNumeric(frmLClass.type_code.value) == true)
        {
            alert("The Code Field should be numeric !");
            frmLClass.type_code.focus();
            return false;
        }
        if (!(frmLClass.type_code.value.length == frmLClass.valid_length.value) == true)
        {
            alert("The Code Field should be of length "+frmLClass.valid_length.value);
            frmLClass.type_code.focus();
            return false;
        }
        return true;
    }//end function
</script>
