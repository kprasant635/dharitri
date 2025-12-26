<div class="row login">       
    <div class="col-lg-12 ">
        <div class="col-lg-6 col-lg-offset-3">
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
            <div class="well well-sm mis_report">
                <h3 style="text-align: center; font-size: 28px">Find Location </h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>                        
            <div class="panel panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title"><?php echo $this->lang->line('select_location')?></h3>
                </div>
                <div class="panel-body">                   
                    <form class="form-horizontal unicode" id='myform' name="form" method='post' action="<?php echo base_url() ?>index.php/deletefromchitha/getloc">
						<div class="form-group">
                            <label for="select" class="col-lg-3 control-label">Case Number</label>
                            <div class="col-lg-9">
                                <input type='text' class='form-control case_no' name='case_no'>
                            </div>
                        </div>
						<div class="form-group">
                            <label for="select" class="col-lg-3 control-label">Case Type</label>
                            <div class="col-lg-9">
                                <select class="form-control ntype" name="ntype" required>
                                    <option value=0>Select Option</option>
                                    <option value=1>Field</option>
                                    <option value=2>Office</option>
                                    <option value=3>Misc</option>
                                    <option value=4>Reclass</option>
                                </select>
                            </div> 
                        </div>
						
                        <hr style="border-bottom: 2px solid #000;">
                        <div class="form-group">
                            <div class="col-lg-8 col-lg-offset-3">
                                <button type="submit" name="ASTSTEP1Submit" class=" btn btn-success" ><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                <button type="reset" name="ASTSTEP1Su" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                                <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                </a>
                            </div>
                        </div>
                        <div class="form-group">
                            <?php
								if($data){
									//var_dump($data);
							?>
							
									<table class='table uni_text table_black'>
								<tr class='center'>
									<td>Dist : <?=$this->utilityclass->getDistrictName($data[0]->dist_code);?></td>
									<td>Subdiv :<?=$this->utilityclass->getSubDivName($data[0]->dist_code,$data[0]->subdiv_code);?></td>
									<td>Circle :<?=$this->utilityclass->getCircleName($data[0]->dist_code,$data[0]->subdiv_code,$data[0]->cir_code);?></td>
								</tr>
								<tr class='center'>
									<td>Mouza : <?=$this->utilityclass->getMouzaName($data[0]->dist_code,$data[0]->subdiv_code,$data[0]->cir_code,$data[0]->mouza_pargona_code);?></td>
									<td>Lot No :<?=$this->utilityclass->getLotLocationName($data[0]->dist_code,$data[0]->subdiv_code,$data[0]->cir_code,$data[0]->mouza_pargona_code,$data[0]->lot_no);?></td>
									<td>Village : <?=$this->utilityclass->getVillageName($data[0]->dist_code,$data[0]->subdiv_code,$data[0]->cir_code,$data[0]->mouza_pargona_code,$data[0]->lot_no,$data[0]->vill_townprt_code);?></td>
								</tr>
								<tr>
									<td colspan='3'><?=$data[0]->dist_code ."-". $data[0]->subdiv_code ."-".$data[0]->cir_code."-".$data[0]->mouza_pargona_code."-".$data[0]->lot_no."-".$data[0]->vill_townprt_code?></td>
								</tr>
							</table>
							<?php
								}
							?>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div> 
</div>
<script>

$('.ASTSTEP1Submit').click(function (e) {
	var form=$("#myform");
        //var type = $('.ntype').val();
        //var case_no = $(this).val();
        $.ajax({
            url: baseurl + "deletefromchitha/getloc",
			type: 'post',
			data: form.serialize(),
            success: function (data) {
				console.log(data);
				event.preventDefault();
                if (debug) {
                    console.log(data);
                }
                var obj = JSON.parse(data);
                $('#dist').val(obj[0].subdiv_code);
            }
        });
    });


</script>