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
                    <div class="col-lg-12">
                        <center>
                            <form  name="frmLClass" method='post' action="<?php echo base_url();?>index.php/initialization/EditCodePlug" >
                                <table border="0" cellpadding="1" cellspacing="1" width="700px" style="VISIBILITY: visible"> 
                                    <tr>
                                        <td width="30%"><b><?php echo $this->lang->line('select_edit_table_for');?></b></td>
                                        <td>
                                            <select name='LRCTables' size='default' style="width:70%;" required>
                                                <option selected disabled>-- Select Tables --</option>
                                                <?php 
                                                foreach($table_result as $tables): 
                                                if($tables->table_no<>"3" and $tables->table_no<>"4" and $tables->table_no<>"17" and $tables->table_no<>"20"  and $tables->table_no<>"24" and $tables->table_no<>"25" and $tables->table_no<>"26" and $tables->table_no<>"27" and $tables->table_no<>"28" and $tables->table_no<>"29"){
                                                ?>
                                                <option value="<?php echo $tables->table_name; ?>"><?php echo $tables->table_name; ?></option>
                                                <?php
                                                }
                                                endforeach; ?>
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
