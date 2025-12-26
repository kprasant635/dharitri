<style>
    input[type="text"]{
        width:100% !important;
    }
    select{
        width:100% !important;
    }
    textarea{
        width: 100% !important; 
    }
    label{
        font-weight: normal !important;
        font-size: 12px !important;
    }
</style>
<div class="row login form-top">
    <div class="col-lg-10 col-lg-offset-1 ">
        <div class="panel panel-info panel-form">
		<blockquote>
                <center><h2 class="panel-title">Khatian Entry / Check Khatian Exists or Not </h2></center>
		</blockquote>
		<hr>
            <div class="panel-body">
                <form class="form-horizontal" method="post">
                    <div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-3 uni_text control-label required" >Khatian No</label>
                        <div class="col-sm-2">
                            <input type="number" id='ktn_no' name="khatian_no" class="form-control" />
							<?php echo form_error('khatian_no', '<p class="red form_error">', '</p>'); ?>
                        </div>
                        <label for="inputEmail3" class="col-sm-3 uni_text control-label required" >DAG NO</label>
                        <div class="col-sm-2">
                            <select name='dag_no' class="form-control" required>
                                <option selected disabled>Select Dag</option>
                                <?php foreach ($dags as $d): ?>
                                    <option value="<?php echo $d->dag_no; ?>"><?php echo $d->dag_no; ?></option>
                                <?php endforeach; ?>
                            </select>
							<?php echo form_error('dag_no', '<p class="red form_error">', '</p>'); ?>
                        </div>
                    </div>
					<hr>
                    <div class="form-group" style="width: 100%;text-align: center;">
                        <div class="">
                            <button type="submit" class="btn uni_text btn-primary"><i class='fa fa-check'></i> <?php echo $this->lang->line('submit_button'); ?> </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>