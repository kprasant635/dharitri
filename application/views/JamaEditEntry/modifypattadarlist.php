<div class="container-fluid login form-top">
	<div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Please select Pattdar Name you want to Modify</h3>
                </div>
				<?php 
					if($existname){	
					echo "<p class='uni_text red'>Already Requested Name(s) pending  for CO's approval </p>"; 
					foreach($existname as $r):
					?>
					<p class='uni_text'>Name : <kbd><?=$r->pdar_name;?></kbd> Gurdian Name: <kbd><?=$r->pdar_father;?></kbd> Old Details : <kbd><?=$r->pdar_old_name ." G :". $r->pdar_old_father;?></kbd> </p>
						
					<?php 
					endforeach;
					} ?>
				
				<a class="btn btn-danger pull-right uni_text" href="<?php echo base_url();?>index.php/jamaeditentry/pattadarlist/"><i class='fa fa-arrow-left'></i> Back to Previous</a>
					<table class='table table-stripped table-hover'>
					<tr>
						<td>Id</td>
						<td>Pattadar Name</td>
						<td>Gurdian Name</td>
						<td>Action</td>
					</tr>
					<?php  foreach($pattadar as $p): ?>
					<tr>
						<td><?=$p->pdar_id?></td>
						<td><span><?=$p->pdar_name;?></span>
						<input type='hidden' class='pdarname<?=$p->pdar_id?>' value="<?=addslashes($p->pdar_name);?>" />
						</td>
						<td><span><?=$p->pdar_father;?></span>
						<input type='hidden' class='pdarfname<?=$p->pdar_id?>' value="<?=$p->pdar_father;?>" />
						</td>
						<td>
						<a href='#' data-id="<?=$p->pdar_id?>" class='btn btn-xs add btn-primary'><i class='fa fa-edit'></i> Modify</a>
						</td>	
					</tr>
					<?php endforeach; ?>
					</table>
					<br>
			</div>
		</div>
	</div>
</div>
<!---------->
	<div id="myModal" class="modal fade" role="dialog">
	  <div class="modal-dialog">
		<div class="modal-content"> 
		<div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">Click to Close</span></button>         
         </div>
		  <div class="modal-body">		  
						<?php
						echo form_open_multipart('JamaEditEntry/modifypattdarUpdate'); ?>
						<div class="row" style='margin-top:20px;padding:20px'>            
                                    <div class="form-group row">
									  <label for="staticEmail" class="red col-sm-5 col-form-label">Old Name</label>
									  <div class="col-sm-7">
										<input type="text" readonly name="oldpdar" id="oldpdar" value=""/>
									  </div>
									  <label for="staticEmail" class="col-sm-5 col-form-label">Suggested Name</label>
									  <div class="col-sm-7">
										<input type="text" id="dSuggest" required='' autocomplete="off" name='pname' placeholder='Write Here' class="form-control-plaintext" >
									  </div>
									    <input type="hidden" name="bookId" id="bookId" value=""/>
									</div>
									<div class="form-group row">
									  <label for="staticEmail" class="col-sm-5 red col-form-label">Old Gurdian Name</label>
									  <div class="col-sm-7">
										<input type="text"  readonly name="oldguard" id="oldguard" value=""/>
									  </div>
									  <label for="staticEmail" class="col-sm-5 col-form-label">Suggested Father Name</label>
									  <div class="col-sm-7">
										<input type="text" autocomplete="off" required='' id='gSuggest' placeholder='Write Here' name='gurdian' class="form-control-plaintext" >
									  </div>
									</div>
									<p><mark>Lot Mondal's Note On Action</mark></p>
									<div class="form-group">
											<div class="col-sm-12">
												<p>আবেদনকাৰী <span id='output'></span> <span id='guardN'></span>  লিগেচী তথ্যৰ সংশোধনী বিচাৰিছে | উপৰোক্ত তথ্য সংশোধন ৰ বাবে আৰু চক্ৰ বিষয়াৰ অনুমোদনৰ বাবে দিয়া হল ৷</p>
												<input type='hidden' name='note_1' value='আবেদনকাৰী' />
												<input type='hidden' name='note_2' value='লিগেচী তথ্যৰ সংশোধনী বিচাৰিছে | উপৰোক্ত তথ্য সংশোধন ৰ বাবে আৰু চক্ৰ বিষয়াৰ অনুমোদনৰ বাবে দিয়া হল ৷' />
											</div>
									</div>
									<hr>
									<div class="form-group">
											<label for="inputEmail3" class="col-sm-5 control-label">Upload Required Documents</label>
											<div class="col-sm-7">
												<div class="btn btn-primary btn-sm float-left">
													<input type="file" name="file_upload" id="fileupload" required="">
													<span>Only jpg,jpeg,png,doc,docx,pdf,txt type files are allowed</span>
												</div>
											</div>
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
	$(".add").click(function(){
		var id=$(this).data('id');
		$('#bookId').val($(this).data('id'));
		$('#oldpdar').val($('.pdarname'+ id).val());
		$('#oldguard').val($('.pdarfname'+ id).val());
		$('#myModal').modal({
			backdrop: 'static',
			keyboard: false
		});
    });
	$('#dSuggest').on("input", function() {
	  var dInput = this.value;
	  console.log(dInput);
	  $('#output').text(dInput);
	});
	$('#gSuggest').on("input", function() {
	  var dInput = this.value;
	  console.log(dInput);
	  $('#guardN').text(dInput);
	});
	
} );
</script>