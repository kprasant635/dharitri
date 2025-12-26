<div class="row login form-top login">
    <div class="col-lg-10 col-lg-offset-1">
        <div class="panel panel-info panel-form">
            <div class='panel-heading'>
                <div class="panel-title">
                    <p class='center bold'><?php echo $this->lang->line('applicant_details'); ?></p>
                </div>
            </div>
            <div class="col-lg-12" style="margin-top: 5px; margin-bottom: 5px" >
                <div class="btn btn-primary uni_text">
                <a class='vp'  href="<?php echo base_url()."index.php/ChithaReport/modalgenerateChitha" ?>?case_no=0" style="color: #fff"  >
                    <i class="fa fa-book"></i>&nbsp;<?php echo $this->lang->line('show_chitha') ?></a></div>
                <div class="btn btn-warning uni_text" >
                    <a class='vp'  href="<?php echo base_url()."index.php/Partition/saveJamabandiByPattano" ?>?case_no=0" style="color: #fff" ><i class="fa fa-book"></i>&nbsp;<?php echo $this->lang->line('show_jamabandi')?></a>
                </div>
				
				<?php 
				//$maplink=MapLink;
				$d=$this->session->userdata('dist_code');							
				$s=$this->session->userdata('subdiv_code');							
				$c=$this->session->userdata('cir_code');							
				$m=$this->session->userdata('mouza_pargona_code');					
				$l=$this->session->userdata('lot_no');							
				$v=$this->session->userdata('vill_code');							
				$dag=$this->session->userdata('dag_no');	
				$giscode=$d."_".$s."_".$c."_".$m."_".$l."_".$v."&plotno=".$dag;
				if($d=='16' or $d=='06'){
				?><div class="btn btn-info uni_text" >
                    <a target='_blank' href="http://10.177.2.27:8080/bhunaksha/PlotImage?state=18&giscode=<?=$giscode;?>" style="color: #fff" ><i class="fa fa-book"></i>&nbsp;Show Trace Map</a>
					</div>
				<?php } ?>
				
               
            </div> 
            <?php
            $patt = $this->session->userdata('pattadar'); //print_r( $patt); ?>
            <div class='panel-body'>
                <div class="form_1" >
                    <fieldset><legend><?php echo $this->lang->line('general_information');?></legend>
                        <table class="table_border">
                            <tr>
                                <td><?php echo $this->lang->line('district'); ?> : <?php echo $location['dist']; ?> </td><td><?php echo $this->lang->line('subdivision'); ?>  : <?php echo $location['sub']; ?></td><td><?php echo $this->lang->line('circle'); ?>  : <?php echo $location['cir']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $this->lang->line('mouza'); ?>  : <?php echo $location['mouza']; ?></td><td><?php echo $this->lang->line('lot_no'); ?> লাট  : <?php echo $location['lot']; ?></td><td><?php echo $this->lang->line('vill_town'); ?>  :<?php echo $location['vill']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $this->lang->line('submission_date');?> : <?php $date = date('d-m-Y');
                                                    echo "$date"; ?></td><td><?php echo $this->lang->line('mutation_type')?> : 
                                <?php if($this->session->userdata('complete_patition_yn')=='Y')
                                {
                                    echo    $this->lang->line('full')  ;
                                }
                                else
                                {
                                    echo  $this->lang->line('partial') ;
                                }
                                ?> </td><td> <?php echo $this->lang->line('user_designation') ?> : <?php 
                                $data = $this->utilityclass->getSelectedCOName($this->session->userdata('dist_code'), $this->session->userdata('subdiv_code'), $this->session->userdata('cir_code'), $this->session->userdata('add_off_name'));
                                //var_dump($data);
                                echo $data->username; //var_dump($this->session->all_userdata()) 
                                ?></td>
                            </tr>
                        </table>  
						
                    </fieldset>
                </div>
                <div class="form_1">
                    <fieldset><legend><?php echo $this->lang->line('applicant_dag_details_information');?></legend>
                        <table class="table table-bordered">
                            <tr class="text-center">
                                <th class="text-center "><?php echo $this->lang->line('dag_no');?></th><th class="text-center "><?php echo $this->lang->line('land_area')."(".$this->lang->line('bigha')."-".$this->lang->line('katha')."-".$this->lang->line('lesa').")" ?></th>
                                <th class="text-center "> Proposed <?php echo $this->lang->line('revenue') ?> per Bigha </th><th class="text-center "><?php echo $this->lang->line('patta_no') ?></th>
                                <th class="text-center "><?php echo $this->lang->line('patta_type') ?></th>
                            </tr>
                            <tr class="text-center">
                                    <td><?php echo $location['dag_no']; ?></td><td> <?php echo $location['bigha']; ?>-<?php echo $location['katha']; ?>-<?php echo $location['lessa']; ?> </td><td><?php echo $location['revenue'] ?>  (Rs/-)</td><td><?php echo $patta_no ?></td><td><?php echo $patta_type; ?></td>
                            </tr>
                        </table>  
                    </fieldset>
                </div>

                <div class="form_1">
                    <fieldset><legend><?php echo $this->lang->line('applicant_information');?></legend>
                        <div class="col-lg-12">
                            <?php
                            $count = 1; 
							$d=$this->session->userdata('dist_code');							
							$s=$this->session->userdata('subdiv_code');							
							$c=$this->session->userdata('cir_code');							
							$m=$this->session->userdata('mouza_pargona_code');					
							$l=$this->session->userdata('lot_no');							
							$v=$this->session->userdata('vill_code');							
							$pn=$this->session->userdata('patta_no');	
							$pc=$this->session->userdata('patta_type_code');			
                            foreach ($pattadar as $p):
                             //  var_dump($p);    
                            ?>
                                <h4>(<?php echo $count;?>)<?php echo $this->lang->line('applicants_name'); ?> : 
								<?=$name=$this->utilityclass->getnameByPdarId($d,$s,$c,$m,$l,$v,$pn,$pc,$p['pdar_name']);
								?></h4>
                                <table class="table" >
                                    <tr>
									<td><?php echo $this->lang->line('guardian_name'); ?>  : <?php echo $p['pdar_guardian']; ?></td>
									<td><?php echo $this->lang->line('relation'); ?>  	: <?=$this->utilityclass->appRelation($p['pdar_rel_guar']);
                                    ; ?></td></tr>
                                    <tr><td><?php echo $this->lang->line('address1'); ?> : <?php echo $p['pdar_add1']; ?> </td><td><?php echo $this->lang->line('address2'); ?> : <?php echo $p['pdar_add2']; ?></td>
							    </tr>
                                    <tr><td><?php echo $this->lang->line('mobile_no'); ?> : <?php echo $p['pdar_mobile']; ?> </td><td><?php echo $this->lang->line('aadhar_no'); ?> : <?php echo $p['pdar_aadharno']  ; ?></td></tr>
                                    <tr><td><?php echo $this->lang->line('pan_no'); ?> : <?php echo $p['pdar_pan_no']; ?> </td><td><?php echo $this->lang->line('voter_no'); ?> : <?php echo $p['pdar_citizen_no']  ; ?></td></tr>
                                    
                                </table>
                            <?php
							$count++;
							endforeach; ?>    
                        </div> 
                        

                    </fieldset>
                </div>
                <form action="<?php echo base_url()."index.php/partition/savePartionAsst " ?>" method="POST" name="">
                    <button type="submit" class="btn btn-info col-lg-offset-4 uni_text" ><i class="fa fa-share"></i> &nbsp;<?php echo $this->lang->line('submit_print') ?> </button>
                </form>
<!--                <div class="btn btn-danger col-lg-offset-5"> <a href="<?php echo base_url() . "index.php/welcome/mutationlogin"; ?>"><i class="fa fa-reply"></i> &nbsp;Cancel </a></div>-->
            </div>
        </div>
    </div>
</div>
<script>
     $(function () {
        $('.vp').click(function (e) {
            e.preventDefault();
            $.ajax({
                url:$(this).attr('href'),
                success:function(data){
                    $('.modal-body').html(data);
                    $('.modal').modal();
                    $('body').addClass('bodytest');
                }
            });
            
        });
    });
</script>
<div class="modal fade bs-example-modal-lg " tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg "  role="document">
        <div class="modal-content  modal-lg ">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
        <div class="modal-body">
        </div>
        <div class="modal-footer">
                <button type="button" class="btn btn-danger btn-xs" data-dismiss="modal">Close</button>
            </div>
    </div>
    </div>
</div>
<style type="text/css">
    .modal{
         overflow-y:auto;
         overflow-x: hidden;
    }
    .bodytest{
         //display: inline-block;
         position: relative;
         padding: 0px !important;
    }
</style>
