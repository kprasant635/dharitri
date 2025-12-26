<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular uni-text"><?php  echo $this->lang->line('cos_order')?></p>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row center">
                        <div class='col-lg-4 uni_text'>
                          <?php  echo $this->lang->line('case_no')?>: <?php echo $case_no;?>
                        </div>
                        <div class='col-lg-4 uni_text'>
                       <?php  echo $this->lang->line('proceeding_no')?>: <?php echo $proceeding_id;?>
                        </div>
                        <div class='col-lg-4 uni_text'>
                          <?php  echo $this->lang->line('date');?>: <?php echo date('d-m-Y');?>
                        </div>
                    </div>
                </div>
                <hr>
                <p class='bold uni_text text-danger text-center'><?php echo $this->lang->line('applicant_dag_details')?></p>
                <table class="table table-border center">
                    <thead>
                        <tr>
                            <th class='alert-new center'><?php echo $this->lang->line('dag_no')?></th>
                            <th class='alert-new center'><?php echo $this->lang->line('dag_area')?></th>
                            <th class='alert-new center'><?php echo $this->lang->line('patta_no')?></th>
                            <th class='alert-new center'><?php echo $this->lang->line('patta_type')?></th>
                            <th class='alert-new center' ><?php echo $this->lang->line('govt_land_type')?></th>
							
                        </tr>
                    </thead>
					
                    <?php foreach($data as $d):?>
					<tr>
                    <td><?php echo $d->dag_no;?></td>
                    <td><?php echo $d->m_dag_area_b."-".$d->m_dag_area_k."-".$d->m_dag_area_lc;?></td>
                    <td><?php echo $d->patta_no;?></td>
                    <td><?php echo $d->patta_type_code;?></td>
					<td>no data</td>
					</tr>
                    <?php endforeach;?>
                   
                </table>
                <?php 
                    $link = base_url()."index.php/coofficemutation/finalOrderStep1";
                ?>
				<hr>
                <form method="post" action="<?php echo $link;?>">
                    <div style="text-align: center;margin-top: 30px; margin-bottom:20px">
                        <input type='hidden' name="case_no" value="<?php echo $case_no;?>"/>
                        <input type='hidden' name="proceeding_id" value="<?php echo $proceeding_id;?>"/>
                        <button type="submit" name='pass' value="pass" class="btn btn-primary"><?php echo $this->lang->line('pass_order')?></button>
                        <button type="submit" name="postpone" value="cancel" class="btn btn-danger"><?php echo $this->lang->line('postpone_order')?></button>
                    </div>
                        
                </form>
				<hr>
            </div>
        </div>
    </div>
</div>