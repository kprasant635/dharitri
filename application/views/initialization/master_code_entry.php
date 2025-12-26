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
                    <div class="col-lg-12">
                        <center>
                            <form  name="frmLClass" method='post' action="<?php echo base_url();?>index.php/initialization/LClassTypePlug" >
                                <table border="0" cellpadding="1" cellspacing="1" width="700px" style="VISIBILITY: visible"> 
                                    <tr>
                                        <td width="30%"><b><?php echo $this->lang->line('select_entry_table_for');?></b></td>
                                        <td>
                                            <select name='LRCTables' size='default' style="width:70%;">
                                                <option value="allottees_type_code">Allottees Catagory Codes </option>
                                                <option value="case_type_code">Case Type Codes </option>
                                                <option value="master_field_mut_type">Column 8 Order Type Codes</option>
                                                <option value="crop_code">Crop Codes</option>
                                                <option value="crop_season">Crop Season Codes</option>
                                                <option value="encro_class_code">Encroachers' Class Code</option>
                                                <option value="encro_land_used_for">Encroached Land Used For Codes</option>
                                                <option value="fruit_tree_code">Fruit Plant Codes</option>
                                                <option value="landclass_code">Land Class Codes</option>
                                                <option value="nature_trans_code">Nature Of Transfer(By Way Of)Codes</option>
                                                <option value="ord_on_gl_type_code">Govt Land Type Codes</option>
                                                <option value="master_office_mut_type">31st Column Order Type Codes</option>
                                                <option value="patta_code">Patta Type Codes</option>
                                                <option value="premium_chalan_receipt">Types of Premium Payment Codes</option>
                                                <option value="rmk_content_type">31st Column Remark Content Type Codes</option>
                                                <option value="source_water">Source of Water Codes</option>
                                                <option value="tenant_type">Types of Tenants</option>
                                                <option value="type_of_allotment">Allottment Type Codes</option>
                                                <option value="used_noncrop_type">Non-crop Land Used Type Codes</option>
                                            </select>
                                        </td>			
                                    </tr>
                                </table>
                                <input type='hidden' name='Tcode' value="null">
                                <input type='hidden' name='Exist' value="null" ID="Hidden1">
                                <P align = center>
                                    <button type="submit" id='submit' name='submit' value="Submit" class="btn btn-danger" title="Click on Submit to post the entered data"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button');?></button>
                                </P>
                                <p><hr width = 700px color = silver></hr></p>
                                <font color=red>Note : To query the existing entries in the Master Code tables! You can use the Query link below!</font>	
                                <p><hr width = 700px color = silver></hr></p>
                            </form>
                            [ <a href="<?php echo base_url(); ?>index.php/initialization/master_code_view"><?php echo $this->lang->line('query');?></a> ] || 
                            [ <a href="<?php echo base_url(); ?>index.php/initialization/master_code"><?php echo $this->lang->line('home');?></a> ]
                        </center>
                    </div>
                </div>
             
            </div>
        </div>
    </div>
</div>
