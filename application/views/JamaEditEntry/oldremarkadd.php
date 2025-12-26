<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Old Add Remarks</h2>
                </div>
            </div>
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
						<p class='uni_text'>Old Remarks : <span class='small green'><?=$this->session->userdata('remark');?></span></p>	
                        <div class="col-lg-12 alert alert-warning">
                            <center>
                                <a class="btn btn-danger uni_text" href="<?php echo base_url();?>index.php/jamaeditentry/displaybasic/<?php echo $this->session->userdata('patta_no');?>/<?php echo $this->session->userdata('patta_type_code');?>"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>
                                <a class="btn btn-info uni_text" href="<?php echo base_url(); ?>index.php/jamaeditentry/remarks"><i class='fa fa-edit'></i> Check Old Remark(s)</a>
                            </center>
                        </div>
                        <label class="hide" ><span class="red">Note : Please Check the boxes you want to update.</span></label>
                        <form method='post' enctype="multipart/form-data">
                            <table class='table table-condensed'>
                                <tr>
                                    <th>Please type the correct notes. After CO(s) approval it will reflect on Jamabandi Copy</th>
                                </tr>
                                <tr>
                                    <td class='hide'>
                                        <label class="control-label" > Serial Line No <?php echo $rmk_line_no; ?></label>
                                    </td>
                                    <td>
                                        <textarea rows="5" class="form-control" name="remarks"></textarea>
                                    </td>
                                </tr>
                            </table>
							<div class="col-sm-12">
							<p><mark>Lot Mondal's Note On Action</mark></p>
								<div class="form-group">
										<div class="col-sm-12">
											<textarea name="lm_note" class="form-control" rows="5" readonly>হাতৰ জমাবন্দীৰ তথ্যৰ ভিত্তিত উক্ত জমাবন্দীত উপৰত দিয়া অনুসৰি লিগেচী তথ্যৰ সংশোধনী বিচাৰিছে | উপৰোক্ত সংশোধন কেইটা কৰা হল আৰু চক্ৰ বিষয়াৰ অনুমোদনৰ বাবে দিয়া হল ৷ </textarea>
										</div>
								</div>
							<hr>
							</div>
							<div class="form-group">
                                <label for="inputEmail3" class="col-sm-7 control-label1">Please Upload Hand Chitha/Jama Scan Copy</label>
                                <div class="col-sm-4">
                                    <div class="btn btn-primary btn-sm float-left">
                                        <input type="file" name="file_upload" id="fileupload" required="">
										<span>Only jpg,jpeg,png,doc,docx,pdf,txt type files are allowed</span>
									</div>
                                </div>
							</div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="col-lg-12 alert alert-warning">
                                <center>
                                    <button type="submit" name="submit" class="btn btn-success uni_text"><i class="fa fa-check"></i>&nbsp;Update Remark</button>
                                </center>
                            </div>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>