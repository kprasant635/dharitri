<div class="row login form-top">
    <div class="col-lg-12 ">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">View Tenant List</h3>
                </div>
                <div class="panel-body">
					<a href='<?php echo base_url(); ?>index.php/Tenants/AddBackTenant' class='pull-right btn btn-danger'><i class='fa fa-book'></i> Add Tenant</a>
                    <table class='table table-dark table-hover'>
						<thead class='thead-dark uni_text red text-center'>
							<td>Tenant ID</td>
							<td>Tenant Name</td>
							<td>Gurdian Name</td>
							<td>Address</td>
							<td>Action</td>
						</thead>
						<?php foreach($pattadar as $p){?>
							<tr class='text-center'>
								<td ><?=$p->tenant_id;?></td>
								<td><?php
								if($p->status =='0'){
								echo $p->tenant_name;}
								else{
									echo "<s class='red'>". $p->tenant_name ."</s>";
								}
								?></td>
								<td><?=$p->tenants_father;?></td>
								<td><?=$p->tenants_add1;?></td>
								<td>
								<a href='<?php echo base_url(); ?>index.php/Tenants/PermanenantRTenant?id=<?=$p->tenant_id;?>' class='btn btn-info btn-xs'><i class='fa fa-remove'></i> Delete</a>
								<?php if($p->status =='0'){ ?>
								<a href='<?php echo base_url(); ?>index.php/Tenants/StrikeTenant?id=<?=$p->tenant_id;?>' class='btn btn-success btn-xs'><i class='fa fa-edit'></i> Strike Out</a>
								<?php } else { ?>
								<a href='<?php echo base_url(); ?>index.php/Tenants/UnStrikeTenant?id=<?=$p->tenant_id;?>' class='btn btn-warning btn-xs'><i class='fa fa-edit'></i> Unstrike Out</a>
								<?php } ?>
								</td>
							</tr>
						<?php } ?>
					</table>
                </div>
            </div>
        </div>
    </div>
    
</div>