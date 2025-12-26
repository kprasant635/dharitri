<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Modify Remarks</h2>
                </div>
            </div>
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
              <?php endif; ?>   
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('patta_no'); ?> : <?php echo $this->session->userdata('patta_no');?></label>
                            <label class="col-sm-4 rasid">&nbsp;</label>
                            <?php 
                            $get_patta_name = $this->utilityclass->getPattaName($this->session->userdata('patta_type_code'));
                            ?>
                            <label class="col-sm-4 rasid"><?php echo $this->lang->line('patta_type'); ?> : <?php echo $get_patta_name;?> </label>
                            <br>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-lg-12 alert alert-warning">
                            <center>
                                <a class="btn btn-danger uni_text" href="<?php echo base_url();?>index.php/jamaeditentry/displaybasic/<?php echo $this->session->userdata('patta_no');?>/<?php echo $this->session->userdata('patta_type_code');?>"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
                                <a class="btn btn-info uni_text" href="<?php echo base_url(); ?>index.php/jamaeditentry/remarkadd"><i class='fa fa-edit'></i> Add New Remark</a>
                            </center>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <label class="" ><span class="red">Note : Please Check the boxes you want to update.</span></label>
                        <form method='post'>
                            <table class='table table-condensed'>
                                <tr>
                                    <th>Jamabandi Remark</th>
                                    <th class=''><span class="red">(Click <i class='fa fa-check'></i> the radio button you want to update)</span></th>
                                </tr>
                                <?php foreach ($remarks as $p): ?>
                                <tr>
                                    <td width="70%">
                                        <?php echo $p->remark; ?>
                                        <textarea rows="5" class="form-control hide" value="<?php echo $p->remark; ?>" readonly name="remarks[<?=$p->rmk_line_no?>]"><?php echo $p->remark; ?></textarea>
                                    </td>
                                    <td class=''>
                                        <label class="control-label" > Serial Line No <?php echo $p->rmk_line_no; ?></label><br>
                                        <input type="radio" class="form" name='remak_line_no' value="<?php echo $p->rmk_line_no; ?>"> &nbsp; <i class='fa fa-arrow-left'></i>  Click this & Update
                                        <button type="submit" name="submit" class="btn btn-success uni_text"><i class="fa fa-check"></i>&nbsp;Update Remarks</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </table>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>