<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2 ">
			<div class="panel panel-info">
			<div class="panel-body ">	
				<?php 
					if($insert){	
					echo "<p class='uni_text red'>Already Requested List for Name Removal: </p>";
					foreach($insert as $r):
					//var_dump($elist);
					?>
					<p class='uni_text'>Name : <kbd><?=$r->pdar_name;?></kbd> Gurdian Name: <kbd><?=$r->pdar_father;?></kbd> </p>	
					<?php 
					endforeach;
					} ?>
				<nav class="breadcrumb">
				<h2>Request For Pattadar Removal</h2>
				</nav>
				<form class="form-horizontal" role="form" enctype="multipart/form-data" action='<?= base_url();?>index.php/jamaeditentry/deopdarremove' method="post">
				<div class="form-group">
					<label class="control-label1 col-sm-4"><span class="text-danger">*</span>Pattadar List(s)</label>
					<div class="col-sm-6">
					  <select class='form-control' name='pdar[]' multiple>
							<?php
							foreach($pattadars as $p):
							?>
							<option value=<?=$p->pdar_id?> ><?=$p->pdar_name ." (G : ". $p->pdar_father .")"?></option>
							<?php endforeach; ?>
					  </select>
					</div>
					<hr>
					<div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">File Upload</label>
                                <div class="col-sm-4">
                                    <div class="btn btn-primary btn-sm float-left">
                                        <input type="file" name="file_upload" id="fileupload" required="">
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