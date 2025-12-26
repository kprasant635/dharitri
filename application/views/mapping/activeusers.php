<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Porting Users</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            List of Users left for porting Single Sign 
                        </h3>
                    </div>
                    <div class="panel-body">
                        <hr style="border-bottom: 2px solid #000;">	
						<table id="" class="table table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <td>Name</td>
                                    <td>Dharitree User Name</td>
                                    <td>Action</td>
                                </tr>
                            </thead>
                            <tbody>
                               <?php 
								$i=0;
								foreach($dharitree as $d): ?>
								<tr>
										<td>
										<?php
											$dist_code=$d->dist_code;
											$subdiv_code=$d->subdiv_code;
											$cir_code=$d->cir_code;
											$mouza_pargona_code=$d->mouza_pargona_code;
											$lot_no=$d->lot_no;
											$user_code=$d->user_code;
										    $type=substr($user_code,0,1);
											//$role=$d;
											if($type=='M'){
											$lm=$this->utilityclass->getDefinedMondalsName($dist_code,$subdiv_code,$cir_code,$mouza_pargona_code,$lot_no,$user_code);
											echo $name=$lm->lm_name;
											}else{
											$name=$this->utilityclass->getSelectedAssttName($dist_code,$subdiv_code,$cir_code,$user_code);	
											echo $name->username;
											//var_dump($name);
											}
										?>
										
										</td>
										<td><span ><?=$d->use_name?></span></td>
										<td>
										<a href="<?php echo base_url(); ?>index.php/singleSignMapping/userport/<?=$d->use_name?>/<?=$type?>/<?=$dist_code?>/<?=$subdiv_code?>/<?=$cir_code?>/<?=$mouza_pargona_code?>/<?=$lot_no?>" class='btn btn-xs btn-primary'><i class='fa fa-check'></i> Port User</a>
										<!-- <?php if ($d->nocuser) { ?>
										<a href="<?php echo base_url(); ?>index.php/singleSignMapping/unmapped/<?=$d->use_name?>" class='btn btn-xs btn-primary'><i class='fa fa-lock'></i> Unmapped User</a>
										<input type='hidden' value='<?=$d->use_name?>' class='<?=$i?>'  >
										<?php } else{ ?> -->
										<!-- <input type='button' class="btn btn-info btn-xs nocmodal" id='<?=$i?>' value='Map User' data-toggle="modal" data-target="#myModal" />
										<input type='hidden' value='<?=$d->use_name?>' class='<?=$i?>'  > -->
										<!-- <?php } ?> -->
										</td>
								</tr>
								<?php $i++; endforeach; ?>	
                            </tbody>
                        </table>
                    </div>
                    <p align='center' class="uni_text">
                        [ <a href="<?php echo base_url(); ?>index.php/home"><?php echo $this->lang->line('home'); ?></a> ]
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

 <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
	  <form action='<?php echo base_url(); ?>index.php/singleSignMapping/userMappingUpdate' method='post' >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Mapping User NOC and Dharitree</h4>
        </div>
        <div class="modal-body">
		  <input type='text' id='user' readonly name='useNameD' />
          <select name='nocUname'>
			<?php foreach($noc as $n):?>
					<option value='<?=$n->usnm?>'><?=$n->nameoff ." - ". $n->usnm ?></option>
			<?php endforeach; ?>	
			</select> 
        </div>
        <div class="modal-footer">
         <center> <button type="submit" class="btn btn-default btn-primary"> <i class='fa fa-lock'></i> Click Here for Map</button></center>
        </div>
      </div>
	  </form>
    </div>
  </div> 
</div>
<script type="text/javascript">
		
    $(document).ready(function () {
        //$('#example').DataTable();
		$('.nocmodal').click(function (e) {
			 e.preventDefault();
			 var id = $(this).attr('id');
			 var t = $('.'+id).val();
			 $('#user').val(t);
		});
     });
	function test(str){
		$('#text').html($('#'+str).val());
	}
</script>