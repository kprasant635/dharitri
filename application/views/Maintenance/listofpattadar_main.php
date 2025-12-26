<div class="row form-top login">       
    <div class="col-lg-8 col-lg-offset-2 ">
		<div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title red">List of Pattadar Name(s) on Patta No. <kbd> <?=$patta_no?> </kbd></h3>
                </div>
                <div class="panel-body">
				<form action='<?php echo base_url(); ?>index.php/Maintenance/updatepattadarslNew' method='POST'>
				<input type="hidden" name="dist_code" value="<?=$dist_code?>">
				<input type="hidden" name="subdiv_code" value="<?=$subdiv_code?>">
				<input type="hidden" name="cir_code" value="<?=$circle_code?>">
				<input type="hidden" name="mouza_pargona_code" value="<?=$mouza_pargona_code?>">
				<input type="hidden" name="lot_no" value="<?=$lot_no?>">
				<input type="hidden" name="vill_townprt_code" value="<?=$vill_townprtcode?>">
				<input type="hidden" name="patta_type_code" value="<?=$patta_type_code?>">
				<input type="hidden" name="patta_no" value="<?=$patta_no?>">


				<div style="height:400px; overflow-y: scroll;">
				<table class='table'>
				<?php foreach($pdarlist as $p): 
				if($p->p_flag=='1'){
					$class='red';
				}else{
					$class='';
				}
				?>

						<tr>
							<td class='<?=$class?>' name='pdar_id'><?=$p->pdar_id?></td>
							<td class='<?=$class?>' name='pdar_name'><?=$p->pdar_name?></td>
							<td class='<?=$class?>' name='pdar_father'><?=$p->pdar_father?></td>
							<td class='<?=$class?>'><input type='text' class='hide pdar_id' name='pdar_id[]' value=<?=$p->pdar_id?> /></td>
							<td class='<?=$class?>'><input type='text' class='pdar_sl_no' name='pdar_sl_no[<?=$p->pdar_id?>][]' value=<?=$p->pdar_sl_no?> />
							<span class='update'></span>
							</td>
						</tr>
				<?php endforeach; ?>
				</table>
				</div>
				<hr style='border-bottom:1px solid #000'>
				<center><input type='submit' value='Submit' class='btn btn-primary' /></center>
				<form>
				<a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
				
				</div>
		</div>
	</div>
</div>
<script>
//$('.pdar_sl_no').change(function (e) {
        // var pdar_sl_no = $('.pdar_sl_no').val();
        // var pdar_id = $('.pdar_id').val();
		// alert(pdar_sl_no);
		// alert(pdar_id);
        // $.ajax({
            // //url: baseurl + "utility/updatepattadarsl/" + pdar_sl_no + "/" + pdar_id,
            // success: function (data) {
                // if (debug) {
                    // console.log(data);
                // }
               // console.log(data);
               // var lot = JSON.parse(data);
               // console.log(template);
               // $('.update').html(template);
            // }
        // });
    // });
</script>