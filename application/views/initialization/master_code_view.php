<div class="row" style="min-height: 500px;">
    <div class="col-lg-12 center-col">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-title">
                    <p class='center bold'><span class="rasid"><u><?php echo $this->lang->line('master_code_details');?></u></span></p>
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-12">
                        <center>
                            <form  name="frm1" method='post' action="<?php echo base_url();?>index.php/initialization/view_table" >
                                <table border="0" cellpadding="1" cellspacing="1" width="700px" style="VISIBILITY: visible"> 
                                    <tr>
                                        <td width="30%"><b><?php echo $this->lang->line('select_a_master_code_table');?></b></td>
                                        <td>
                                            <select name='LRCTables' size='default' style="width:70%;" onChange="Javascript:submt();">
                                                <option selected disabled>-- Select Tables --</option>
                                                <?php foreach($table_result as $tables): ?>
                                                <option value="<?php echo $tables->table_name; ?>"><?php echo $tables->description; ?><?php //echo $tables->table_name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </td>			
                                    </tr>
                                </table>
                                <p><hr width = '700px' color = 'silver'></hr></p>
                            </form>
                            <?php 
                            $user_desig = $this->session->userdata('user_desig_code'); 
                            if (($user_desig == 'ADM')) {
                            ?>
                            [ <a href="<?php echo base_url();?>index.php/initialization/master_code"><?php echo $this->lang->line('home');?></a> ]
                            <?php
                            }
                            ?>
                        </center>
                    </div>
                </div>
             
            </div>
        </div>
    </div>
</div>
<script language="javascript">
function submt()
{
    document.frm1.submit();
}
</script>
