<div class="row login form-top">
    <div class="col-lg-10 col-lg-offset-1 ">
        <div class="panel panel-info panel-form">
		<blockquote>
                <center><h2 class="panel-title uni_text"> Name Of Tenant(s) Entry</h2></center>
		</blockquote>
            <div class="panel-body">
                <form class="form-horizontal" method="post">
					<div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-2 required uni_text control-label " >Name</label>
                        <div class="col-sm-4">
                        <input type='text' name='tenant_name' placeholder='Tenant Name' class="form-control" />
						<?php echo form_error('tenant_name', '<p class="red form_error">', '</p>'); ?>
                        </div>
						<label for="inputEmail3" class="col-sm-2 required uni_text control-label">Tenant Gurdian</label>
                        <div class="col-sm-4">
                        <input type='text' name='tenants_father' placeholder='Gurdian Name' class="form-control" />
						<?php echo form_error('tenants_father', '<p class="red form_error">', '</p>'); ?>
                        </div>
                    </div>
					<div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-2 required uni_text control-label">Address</label>
                        <div class="col-sm-4">
                        <textarea class="form-control" placeholder='Type Address' rows=3 name="tenants_add1"></textarea>
						<?php echo form_error('tenants_add1', '<p class="red form_error">', '</p>'); ?>
                        </div>
						<label class="col-sm-2 uni_text control-label">Second Address</label>
                        <div class="col-sm-4">
                        <textarea class="form-control" placeholder='Optional Address' rows=3 name="tenants_add2"></textarea>
						<?php echo form_error('tenants_add2', '<p class="red form_error">', '</p>'); ?>
                        </div>
                    </div>
					<div class="form-group" style="width: 100%;">
                        <label for="inputEmail3" class="col-sm-2 required uni_text control-label " >Tenant Type</label>
                        <div class="col-sm-4">
							<select class='form-control' name='teant_type'>
								<?php foreach($tenant_type as $tp): ?>
								<option value="<?=$tp->type_code?>"><?=$tp->tenant_type;?></option>
								<?php endforeach; ?>
							</select>
                        </div>
                    </div>
					<hr>
                    <div class="form-group" style="width: 100%;text-align: center;">
                        <div class="">
                            <button type="submit" class="btn uni_text btn-primary"><i class='fa fa-check'></i> Add Tenant Details </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>