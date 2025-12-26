<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
		<div class="panel panel-info">
				<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<th>Mouza /Village</th>
						<th>Patta Type</th>
						<th>Patta No</th>
						<th>Remark</th>
						<th>Date</th>
						<th>Status</th>
					</thead>
					<tbody>
						<?php  foreach($basic as $b): ?>
						 <tr>
							<td><?=$this->utilityclass->getMouzaName($b->dist_code,$b->subdiv_code,$b->cir_code,$b->mouza_pargona_code);?> / <?=$this->utilityclass->getVillageName($b->dist_code,$b->subdiv_code,$b->cir_code,$b->mouza_pargona_code,$b->lot_no,$b->vill_townprt_code);?></td>
							<td><?=$this->utilityclass->getPattaName($b->patta_type_code);?></td>
							<td><?=$b->patta_no;?>
							<?php
							$lm=$this->utilityclass->getDefinedMondalsName($b->dist_code,$b->subdiv_code,$b->cir_code,$b->mouza_pargona_code,$b->lot_no,$b->user_code);
							echo "<br><span class='red small'>Applied By LM: ".$lm->lm_name ."</span>";
							?>
							<input type='hidden' class='lm_comment<?=$b->id?>' value="<?=$b->lm_comment?>" />
							</td>
							<?php
							$role=$b->fresh_old;
							switch ($role) {
								case 1:
									$val="Fresh Entry";
									$class='success';
									break;
								case 2:
									$val="Edited Old Remarks";
									$class='danger';
									break;
								default:
									$val='Wrong Entry';
									$class='info';
									break;
							}
							//echo "<span class='badge badge-$class'>" .$val."</span>";
							?>
							<td><?="<p class='small' style='font-style: italic;color:#0066cc'  >".$b->remark  ;?>
							<?php
							echo "<span class='badge badge-$class'>" .$val."</span> </p>";
							if($role==2){
							echo "<em class='small font-italic' >".$b->old_remark . "</em>" ;
							}
							?>
							</td>
							<td><?=date('d/m/Y',strtotime($b->entry_date))?></td>
							<td>
							<?php
								$user_desig_code=$this->session->userdata('user_desig_code');
								// $attachment=base_url()."AddRemarks/". $b->attachment;
								$attachment = search_file_location('AddRemarks/'. $b->attachment);
								
								if($user_desig_code=='CO'){
									$btn='hide';
									$link=$Status='';
								}else{
										$link='hide';
										if($b->status=='F'){
											$Status="Approved";
											$btn="btn-success";
										}elseif($b->status=='R'){
											$Status="Rejected";
											$btn="btn-warning";
										}else{
											$Status="Pending";
											$btn="btn-danger";
										}
								}	
							?>
							<button class='btn btn-sm <?=$btn?>'><?=$Status?></button>
							<!--<a href='<?php echo base_url(); ?>index.php/JamaEditEntry/updateremarkorder?id=<?=md5($b->id)?>&sl=<?=$b->id?>' class='btn btn-xs btn-primary <?=$link?>'><i class='fa fa-check'></i> Approve</a> --->
							<a href='#'  data-id="<?=$b->id?>" class='btn btn-sm confirm btn-primary <?=$link?>'><i class='fa fa-check'></i> Approve</a>
							<a href='<?php echo base_url(); ?>index.php/JamaEditEntry/rejectrmkorder?id=<?=md5($b->id)?>&sl=<?=$b->id?>' class='btn btn-sm btn-danger <?=$link?>'><i class='fa fa-times'></i> Reject</a><br>
							<?php if($b->attachment){ ?>
							<a href="javascript:void(0);" data-path='<?=$attachment?>' class='small preview__file' >Download the attachment </a>
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
<!-------------->
<!---------->
	<div id="myModal" class="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	  <div class="modal-dialog">
		<div class="modal-content"> 
			<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Click to Close</span></button>         
			</div>
		  <div class="modal-body">		  
						<?php
						echo form_open('JamaEditEntry/updateremarkorder'); ?>
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
    $('.close').on('click',function(){
    	$('#myModal').modal('hide');
    });
	$('#example').on('click', '.confirm', function(){
		var id=$(this).data('id');-
		$('#bookId').val($(this).data('id'));
		$('#lm_comment').val($('.lm_comment'+ id).val());
		$('#myModal').modal('show');
    });
} );
</script>
