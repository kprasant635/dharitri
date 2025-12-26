<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
		<div class="panel panel-info">
				<div class="pull-left hide">
					<a href="<?php echo site_url('chitha_basic_deo/'); ?>" class="btn pull-left btn-success">Click Here Add Records</a> 
				</div>
				<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<th>Mouza</th>
						<th>Village</th>
						<th>Dag No</th>
						<th>Patta</th>
						<th>Patta No</th>
						
						<th>Date</th>
						<th>Status</th>
					</thead>
					<tbody>
						<?php
						//var_dump($basic);
						foreach($basic as $b): ?>
						 <tr>
							<td><?=$this->utilityclass->getMouzaName($b->dist_code,$b->subdiv_code,$b->cir_code,$b->mouza_pargona_code);?></td>
							<td><?=$this->utilityclass->getVillageName($b->dist_code,$b->subdiv_code,$b->cir_code,$b->mouza_pargona_code,$b->lot_no,$b->vill_townprt_code);?></td>
							<td><kbd><?=$b->dag_no;?></kbd><br>
							<small class='red'>Request for Deletion</small>
							</td>
							<td><?=$this->utilityclass->getPattaName($b->patta_type_code);?></td>
							<td><?=$b->patta_no;?>
							<?php
							$lm=$this->utilityclass->getDefinedMondalsName($b->dist_code,$b->subdiv_code,$b->cir_code,$b->mouza_pargona_code,$b->lot_no,$b->user_code);
							echo "<br><span class='red small'>Applied By LM: ".$lm->lm_name ."</span>";
							?>
							<input type='hidden' class='lm_comment<?=$b->id?>' value="<?=$b->lm_comment?>" />
							</td>
							<td><?=date('d/m/Y',strtotime($b->entry_date))?></td>
							<td>
							<?php
								$user_desig_code=$this->session->userdata('user_desig_code');
								$attachment=base_url()."RemoveDag/". $b->attachment;
								if($user_desig_code=='CO'){
									$btn='hide';
									$link='';
									$Status='';
								}else{
										$link='hide';
										if($b->status=='F'){
											$Status="Approve";
											$btn="btn-success";
										}elseif($b->status=='R'){
											$Status="Reject";
											$btn="btn-warning";
										}else{
											$Status="Pending";
											$btn="btn-danger";
										}
								}
							?>
							<button class='btn btn-xs <?=$btn?>'><?=$Status?></button>
							<!---<a href='<?php echo base_url(); ?>index.php/JamaEditEntry/updateddag?id=<?=md5($b->id)?>&sl=<?=$b->id?>' class='btn btn-xs btn-primary <?=$link?>'><i class='fa fa-check'></i> Approve</a>--->
							<a href='#'  data-id="<?=$b->id?>" class='btn btn-xs confirm btn-primary <?=$link?>'><i class='fa fa-check'></i> Approve</a>
							<a href='<?php echo base_url(); ?>index.php/JamaEditEntry/rejectdag?id=<?=md5($b->id)?>&sl=<?=$b->id?>' class='btn btn-xs btn-danger <?=$link?>'><i class='fa fa-times'></i> Reject</a><br>
							<?php if($b->attachment){ ?>
							<a href='<?=$attachment?>' class='small' target='_blank' download >Download the attachment </a>
							<?php } ?>
							</td>
						</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
		</div>
		</div>
	</div>
</div>
<!---------->
	<div id="myModal11" class="modal" data-bs-backdrop="static" data-keyboard="false" role="dialog">
	  <div class="modal-dialog">
		<div class="modal-content"> 
		 <div class="modal-header">
            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">Click to Close</span></button>         
         </div>
		  <div class="modal-body">		  
						<?php
						echo form_open('JamaEditEntry/updateddag'); ?>
						<div class="row" style='margin-top:20px;padding:20px'>            
                                    <div class='col-lg-12'>
										LM Note :<textarea class='form-control' readonly rows=5 id='lm_comment'></textarea>
									</div>
									<hr>
                                    <div class="col-lg-12">
                                      CO's Order  <textarea name="final_report" class="form-control" rows="5">লাঃ মঃৰ প্ৰতিবেদন চোৱা হল ৷  সংশোধনীৰ বাবে অনুমোদন দিয়া হল ৷ </textarea>
                                    </div>
									<div id='sendval'>
									<input type="hidden" name="bookId" id="bookId" value=""/>
									</div>
									<div class="col-lg-12" id="co_block">
                                    <label class="col-sm-12">
                                          <input type="checkbox" disabled checked>
										  <span class='red'> স্বীকাৰোক্তিঃ উল্লেখিত তথ্য সমূহ মোৰ তত্বাৱধানত সংশোধন কৰা হৈছে ৷ তথ্য সমূহৰ সত্যতা প্ৰমাণ নহলে মই দায়ী হ'ম ৷   </span>
                                    </label>
									</div>
									<hr>
									<center><button type="submit" class="btn btn-primary submitBtn" onclick="submitContactForm()">SUBMIT</button></center>
                        </div>
						</form>
		  </div>  
		</div>
	  </div>
	</div>
	<!--------------->
<script>
$(document).ready(function() {
    $('#example').DataTable();
	$('#example').on('click', '.confirm', function(){
		var id=$(this).data('id');
		$('#bookId').val($(this).data('id'));
		$('#lm_comment').val($('.lm_comment'+ id).val());
		$("#myModal11").modal('show');
    });
} );
</script>
