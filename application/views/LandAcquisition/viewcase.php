<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            
            <div class="col-lg-12 ">
                <div class="panel panel-info">
					<div class='row'>
						<h2 style="text-align: center;" class='red uni_text'>Backlog Entry For Partition Case</h2>
						<hr>

						<div class='col-lg-10 col-lg-offset-1'>
							<h4 class='center uni_text'>All Applicant Details </h4>
							<table class='table uni_text table_black'>
								<tr class='center'>
									<td>Dist : <?=$this->utilityclass->getDistrictName($col8->dist_code);?></td>
									<td>Subdiv :<?=$this->utilityclass->getSubDivName($col8->dist_code,$col8->subdiv_code);?></td>
									<td>Circle :<?=$this->utilityclass->getCircleName($col8->dist_code,$col8->subdiv_code,$col8->cir_code);?></td>
								</tr>
								<tr class='center'>
									<td>Mouza : <?=$this->utilityclass->getMouzaName($col8->dist_code,$col8->subdiv_code,$col8->cir_code,$col8->mouza_pargona_code);?></td>
									<td>Lot No :<?=$this->utilityclass->getLotLocationName($col8->dist_code,$col8->subdiv_code,$col8->cir_code,$col8->mouza_pargona_code,$col8->lot_no);?></td>
									<td>Village : <?=$this->utilityclass->getVillageName($col8->dist_code,$col8->subdiv_code,$col8->cir_code,$col8->mouza_pargona_code,$col8->lot_no,$col8->vill_townprt_code);?></td>
								</tr>
							</table>
							<hr>
							<h4 class='center red'>Basic Details</h4>
							<?php //var_dump($this->session->userdata('basic'));?>
							<table class='table uni_text table_black'>
								<thead>
									<td colspan=2>Previous Case : <?=$col8->case_no?></td>
									<td>Order Date : <?php echo date('d/m/Y',strtotime($col8->date_of_order))?></td>
									
								</thead>
								<tr>
									<td>Issued LM :<?php 
										$lm=$this->utilityclass->getLmByCode($col8->lm_code);
										echo $lm->lm_name;
										//var_dump($lm);
									?>
									<kbd><?=date('d/m/Y',strtotime($col8->lm_note_date))?></kbd>
									</td>
									<td>Issued SK :
									<?php
									$sk=$this->utilityclass->getSKByCode($col8->dist_code,$col8->subdiv_code,$col8->cir_code,$col8->sk_code);
									echo $sk->username;
									?>
									<kbd><?=date('d/m/Y',strtotime($col8->sk_note_date))?></kbd>
									</td>
									<td>Issued CO :
									<?php
									$sk=$this->utilityclass->getSKByCode($col8->dist_code,$col8->subdiv_code,$col8->cir_code,$col8->co_code);
									echo $sk->username;
									?>
									<kbd><?=date('d/m/Y',strtotime($col8->co_ord_date))?></kbd>
									</td>
								</tr>
								<tr>
									<td rowspan='2'>Old Dag No. :  <?=$col8occ[0]->old_dag_no;?>
									<br>
									Old Patta No : <?=$col8occ[0]->old_patta_no;?>
									<br>
									
									</td>
								
									<td rowspan='2'>New Dag No. : <span class='red badge'> <?=$col8occ[0]->new_dag_no;?> </span>
									<br>
									New Patta No : <span class='red badge'><?=$col8occ[0]->new_patta_no;?></span>
									</td>
									<td>
									Total Land Area : <?=$col8->mut_land_area_b?> B-<?=$col8->mut_land_area_k?> K-<?=$col8->mut_land_area_lc?> L <br>
									Applied Land Area : <kbd><?=$col8->land_area_left_b?> B-<?=$col8->land_area_left_k?> K-<?=$col8->land_area_left_lc?> L </kbd>
									</td>
								</tr>	
							</table>
							<h4 class='center red'>Applicant Details</h4>
							<table class='table uni_text table_black'>
								<?php
								foreach($col8occ as $fp):
								$user_code=$fp->occupant_add3;
								?>
								<thead>
									<td>Name <i class='fa fa-user'> :- <span class='red'><?=$fp->occupant_name;?></span></td>
									<td>Gurdian Name <i class='fa fa-user-plus'>: <?=$fp->occupant_fmh_name?></td>
									<td colspan=2>Relation <i class='fa fa-retweet'>: <?=$this->utilityclass->get_relation($fp->occupant_fmh_flag)?></td>
								</thead>
								
								<?php endforeach; ?>
							</table>
							<input type='checkbox' disabled checked class='squaredTwo' >
							<span class='uni_text'>হাতৰ চিঠা/জমাবন্দীৰ তথ্যৰ ভিত্তিত উক্ত তথ্যৰ সংশোধনী  কৰাৰ বাবে চক্ৰ বিষয়াৰ মহোদয়লৈ অনুৰোধ কৰা হ'ল ৷  লা.ম. :-
							<kbd><?php 
										$lm=$this->utilityclass->getDefinedMondalsName($col8->dist_code,$col8->subdiv_code,$col8->cir_code,$col8->mouza_pargona_code,$col8->lot_no,$user_code);
										echo $lm->lm_name;
										//var_dump($lm);
							?></kbd><br><hr>
							
							<input type='checkbox' disabled checked class='squaredTwo' >
							<span class='uni_text red'> স্বীকাৰোক্তিঃ উল্লেখিত তথ্য সমূহ মোৰ তত্বাৱধানত সংশোধন কৰা হৈছে ৷ তথ্য সমূহৰ সত্যতা প্ৰমাণ নহলে মই দায়ী হ'ম ৷ চ:বি:- </span>
							<kbd class='pull-right'><?php 										
										$lm=$this->utilityclass->getSKByCode($col8->dist_code,$col8->subdiv_code,$col8->cir_code,$this->session->userdata('user_code'));
										echo $lm->username;
										//var_dump($lm);
							?>
							</kbd>
							<br><hr>
							<center><a href="<?php echo base_url(); ?>index.php/Backlogpartition/copassorder?type=01&case=<?=$col8->case_no;?>&p=<?=$col8->petition_no?>" class='btn btn-info'> <i class='fa fa-file'></i> Approve Request </a>
							<a href='<?php echo base_url(); ?>index.php/Backlogpartition/corejectorder?type=1&case=<?=$col8->case_no;?>&p=<?=$col8->petition_no?>' class='btn btn-danger' ><i class='fa fa-times'></i> Reject Request </a>
							</center>
							<hr>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
</div>
