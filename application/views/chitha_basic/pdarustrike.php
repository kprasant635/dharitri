<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 ">
			<div class="panel panel-info">
			<div class="panel-body ">	
				<?php 
					if($insert){	
					echo "<p class='uni_text Red'>Already Requested List for Pattadar Unstrike: </p>";
					foreach($insert as $r):
					//var_dump($elist);
					?>
					<p class='uni_text'>Name : <kbd><?=$r->pdar_name;?></kbd> Gurdian Name: <kbd><?=$r->pdar_father;?></kbd>Dag No: <kbd><?=$r->dag_no;?></kbd> </p>
						
					<?php 
					endforeach;
					} ?>
				<nav class="breadcrumb">
				<h2>Request For Pattadar Name Un-Strike Out</h2>
				</nav>
				<form class="form-horizontal" enctype="multipart/form-data" role="form" action='<?= base_url();?>index.php/jamaeditentry/deopdarustrike' method="post">
				<div class="form-group">
					<label class="control-label1 col-sm-4"><span class="text-danger">*</span>Pattadar List(s)</label>
					<div class="col-sm-6">
					  <select class='form-control pdar_dag' name='pdar'>
							<option selected>Select Name Of Pattadar</option>
							<?php
							foreach($pattadars as $p):
							?>
							<option value=<?=$p->pdar_id?> ><?=$p->pdar_name ." (G : ". $p->pdar_father .")"?></option>
							<?php endforeach; ?>
					  </select>
					  <span class='green hide'>Please select <i class='red'>Ctrl</i> buttun for multiple pattadar selection </span>
					</div>
					<label class="control-label1 col-sm-4">Dag Number</label>
					<div class=" col-sm-6">
					  <select class='form-control dag' required name='dag_no[]' multiple>
							<option>Select Dag Number</option>
					  </select>
					  <span class='green'>Please Select the Dag number if You want to Un-strike from that Dag also <mark>Use keyboard "Ctrl" button for multiple dag select</mark></span>
					</div>
					<div class="col-sm-12">
					<p><mark>Lot Mondal's Note On Action</mark></p>
                        <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="lm_note" class="form-control" rows="5">হাতৰ জমাবন্দীৰ তথ্যৰ ভিত্তিত উক্ত জমাবন্দীত উপৰত দিয়া অনুসৰি লিগেচী তথ্যৰ সংশোধনী বিচাৰিছে | উপৰোক্ত সংশোধন কেইটা কৰা হল আৰু চক্ৰ বিষয়াৰ অনুমোদনৰ বাবে দিয়া হল ৷ </textarea>
                                </div>
                        </div>
					<hr>
					</div>
					<hr>
					<div class="form-group">
                                <label for="inputEmail3" class="col-sm-7 control-label1">Please Upload Hand Chitha/Jama Scan Copy</label>
                                <div class="col-sm-4">
                                    <div class="btn btn-primary btn-sm float-left">
                                        <input type="file" name="file_upload" id="fileupload" required="">
										<span>Only jpg,jpeg,png,doc,docx,pdf,txt type files are allowed</span>
                                    </div>
                                </div>
                    </div>	
                    <hr>
                    <div style="text-align: center"> 
                            <input type="submit"  value="Submit" class="btn btn-danger"/>
                    </div>
				</div>
				</form>
				<div class="col-lg-12 alert alert-warning">
                    <center>
                        <a class="btn btn-danger uni_text" href="<?php echo base_url();?>index.php/jamaeditentry/pattadarlist/"><i class='fa fa-arrow-left'></i> <?php echo $this->lang->line('back') ?></a>    
                    </center>
                </div>
			</div>
			</div>
		</div>
	</div>
</div>
<script>
$(".pdar_dag").change(function(){
	var selectedVal = $(".pdar_dag option:selected").val();
		$.ajax({
            url: baseurl + "jamaeditentry/getPdarDag/" + selectedVal,
            success: function (data) {
                console.log(data);
                var subdivcode = JSON.parse(data);
                var template = "<option selected disabled>Select Dag Number</option>"
                for (var i = 0; i < subdivcode.length; i++) {
                    template += "<option value='" + subdivcode[i].dag + "'>" + subdivcode[i].dag + "</option>"
                }
                console.log(template);
                $('.dag').html(template);
            }
		})
});

</script>