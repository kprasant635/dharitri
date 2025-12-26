<style type="text/css">
    input[type=text] {
        border: 1px solid #000;
    }
</style>

<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">

            <?php if($this->session->flashdata('message')):?>
                <div class="col-lg-12 ">
                    <div class="alert alert-warning alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <strong class="rasid" style="color:red !important"><?php echo $this->session->flashdata('message');?></strong>
                    </div>
                </div>
            <?php endif;?>

            <div class="panel panel-info">
                <div class="panel-body">
                    <h3>Circle Officer`s Order for Field Partition</h3><br>
                    <form class="form-horizontal" method='post' action="<?=base_url().'index.php/Partition/finalOrderFieldPartitionCOSave'?>">
                        <?php if(!empty($app->basundhara)){ ?>
                            <input type="hidden" class="form-control" name='application_no' 
                            value="<?= $app->basundhara ?>">
                        <?php } ?>

                        <div class="row">
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">
                                <!----- General Information ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">General Information</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="15%">Case No:</td>
                                            <td width="20%">
                                                <span class="text-danger">
                                                    <?=$this->input->get('case_no')?>
                                                    <input type="hidden" name="case_no"
                                                    value="<?=$this->input->get('case_no')?>">
                                                </span>
                                            </td>
                                            <td width="15%">Submission Date:</td>
                                            <td width="20%">
                                                <?=date('d-m-Y')?>
                                            </td>       
                                        </tr>

                                        <tr>
                                            <td>Old Patta No:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?=$dag_details->patta_no?>
                                                    <input type="hidden" name="old_patta"
                                                    value="<?= $dagapply->patta_no?>">
                                                </span>
                                            </td>
                                            <td>Patta Type:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?=$dag_details->patta_type?>
                                                    <input type="hidden" name="patta_code" 
                                                    value="<?=$dag_details->patta_type_code?>"/>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Old Dag No:</td>
                                            <td>
                                                <span class="text-danger">
                                                    <?=$dag_details->dag_no?>
                                                    <input type="hidden" name="old_dag" 
                                                    value="<?= $dagapply->dag_no ?>">
                                                </span>
                                            </td>
                                            <td>Actual Land Area:</td>
                                            <td>
                                                <span class="text-danger">
                                                    B:<?=$dag_details->dag_area_b?>, K:<?=$dag_details->dag_area_k?>, L:<?=$dag_details->dag_area_lc?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Order Type:</td>
                                            <td>
                                                <span class="text-danger">Field Partition</span>
                                                <input type="hidden" class="form-control" 
                                                name="orderType" value='Partition' >
                                            </td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!----- Order Primary Details ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="4">Basic Details</th>
                                    </thead>
                                    <tbody>                                        
                                        <tr>
                                            <td width=15%>Mondols Name:</td>
                                            <td width=20%>
                                                <span class="text-danger">
                                                    <?php 
                                                        $lms = $this->utilityclass->getDefinedMondalsName($details->dist_code, $details->subdiv_code, $details->cir_code, $details->mouza_pargona_code, $details->lot_no,$details->lm_code);?>
                                                    <?= $lms->lm_name ?>
                                                </span>
                                                <input type="hidden" value="<?=$details->lm_code?>" name="lm_code"/>
                                            </td>
                                            <td width=15%>Sign Date:</td>
                                            <td width=20%>
                                                <?= date('d-m-Y', strtotime($details->date_entry))?>
                                                <input type="hidden" name="lm_date" 
                                                value ='<?= $details->date_entry ?>'/>
                                                <input type="hidden" name='lm_sign_yn' value="y">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>CO Name:</td>
                                            <td>
                                                <?php $coname = $this->utilityclass->getCOCode($details->dist_code, $details->subdiv_code, $details->cir_code,$this->session->userdata('user_code')); ?>
                                                <span class="text-danger"><?= $coname->username ?></span>
                                                <input type="hidden" value="<?= $coname->user_code ?>" name="co_code"/>
                                            </td>
                                            <td>Sign Date:</td>
                                            <td>
                                                <input type="hidden" name="co_ord_date" 
                                                value ='<?= date('d-m-Y') ?>'/>
                                                <?= date('d-m-Y',strtotime(date('d-m-Y'))) ?>
                                                <input type="hidden" name='co_sign_yn' value="y">
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!----- Check this box if Deed Data Exists ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <tbody>
                                        <tr>
                                            <td width="21.5%">Mondal Note:</td>
                                            <td><span class="text-danger"><?= $remark->remark ?></span></td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!----- Applicant Details ----->
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="9">Applicant Details</th>
                                    </thead>
                                    <thead style="white-space:nowrap; width:100%">
                                        <tr class="text-bold table-success">
                                            <th>#</th>
                                            <th>Applicant Name</th>
                                            <th>Guardian Name</th>
                                            <th>Relation</th>
                                            <th>Land Share(B-K-L)</th>
                                        </tr>
                                    </thead>
                                    <tbody id="applicant_list">
                                        <?php 
                                            $i=1;
                                            foreach($petitioner as $row): 
                                        ?>
                                            <tr>
                                                <td><?=$i?></td>
                                                <td><?=$row->pdar_name?></td>
                                                <td><?=$row->pdar_guardian?></td>
                                                <td><?=$this->utilityclass->get_relation($row->pdar_rel_guar)?>
                                                </td>
                                                <td><?=$row->pdar_dag_por_b.'-'.$row->pdar_dag_por_k.'-'.$row->pdar_dag_por_lc?></td>
                                            </tr>
                                        <?php $i++; endforeach;?>
                                    </tbody>
                                </table>

                                <!----- Notes ----->
                                <?php
                                    if (($check[0]->count == '0') && ($land_area_check == '0')) {
                                        echo "<span class='text-red text-bold'>Since All the Pattadars are the Applicants for Partition so the dag no will remain same and patta no will be Changed.</span>";
                                    } else {
                                        echo "<span class='text-red text-bold'>This is a Partial Partition so the dag no and patta no will be Changed.</span>";
                                    }
                                ?><br><br>

                                <!----- Land Details ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="9">Land Details</th>
                                    </thead>
                                    <thead style="white-space:nowrap; width:100%">
                                        <tr class="text-bold table-success">
                                            <th width="25%"></th>
                                            <th style="text-align: center">Bigha</th>
                                            <th style="text-align: center">Katha</th>
                                            <th style="text-align: center">Lessa</th>
                                            <th style="text-align: center">Ganda</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="text-red">Applied Land For Partition</td>
                                            <td style="text-align: center">
                                                <?= $dagapply->m_dag_area_b?>
                                                <input type="hidden" name="bigha_applied" 
                                                value="<?= $dagapply->m_dag_area_b ?>">
                                            </td>
                                            <td style="text-align: center">
                                                <?= $dagapply->m_dag_area_k?>
                                                <input type="hidden" name="katha_applied" 
                                                value="<?=$dagapply->m_dag_area_k?>">
                                            </td>
                                            <td style="text-align: center">
                                                <?= $dagapply->m_dag_area_lc?>
                                                <input type="hidden" name="lessa_applied" 
                                                value="<?=$dagapply->m_dag_area_lc?>">
                                            </td>
                                            <td style="text-align: center">0</td>
                                        </tr>
                                        <tr>
                                            <td class="text-red">Land Description in Chitha</td>
                                            <td style="text-align: center">
                                                <?=$areaFromChitha->dag_area_b?>
                                                <input type="hidden" name="bigha" 
                                                value="<?=$areaFromChitha->dag_area_b?>">
                                            </td>
                                            <td style="text-align: center">
                                                <?=$areaFromChitha->dag_area_k?>
                                                <input type="hidden" name="katha" 
                                                value="<?= $areaFromChitha->dag_area_k ?>">
                                            </td>
                                            <td style="text-align: center">
                                                <?=$areaFromChitha->dag_area_lc?>
                                                <input type="hidden" name="lessa" 
                                                value="<?= $areaFromChitha->dag_area_lc ?>">
                                            </td>
                                            <td style="text-align: center">0</td>
                                        </tr>
                                    </tbody>
                                </table>

                                <!----- New Dag Details ----->
                                <table class="table table-striped table-bordered text-bold">
                                    <thead>
                                        <th style="background-color: #136a6f; color: #fff" colspan="9">New Dag Details</th>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="15%">Dag Revenue:</td>
                                            <td width="20%">
                                                <input type="text" class="form-control" 
                                                id="P_land" name="dag_revenue" 
                                                value="<?= $revenue = null? $revenue: 10 ?>">
                                            </td>
                                            <td width="15%">Dag local tax:</td>
                                            <td width="20%">
                                                <input type="text" class="form-control" 
                                                id="p_loc_tax" name="dag_local_tax" 
                                                value="<?= $local_taxecho = 0 ? $local_taxecho: 2 ?>">
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="15%">Suggested New Dag No:</td>
                                            <td width="20%">
                                                <?php if (($land_area_check == '0')) { ?>
                                                    <input type="text" class="form-control" 
                                                    name="sugg_dag_no" readonly
                                                    value="<?= $dagapply->dag_no ?>">
                                                <?php } else { ?>
                                                    <input type="text" class="form-control" 
                                                    name="sugg_dag_no" value="<?= $new_dag ?>">
                                                <?php } ?>
                                            </td>
                                            <td width="15%">Check Existing Dags:</td>
                                            <td width="20%">
                                                <select style="width:100%">
                                                    <option disabled selected>-- Verify Old Dags --</option>
                                                    <?php foreach ($dags_all as $d): ?>
                                                        <option value="<?= $d->dag_no ?>"><?= $d->dag_no ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td width="15%">Suggested New Patta No:</td>
                                            <td width="20%">
                                                <input type="text" class="form-control"
                                                name="sugg_patta_no" value="<?= $new_patta ?>">
                                            </td>
                                            <td width="15%">Check Existing Patta:</td>
                                            <td width="20%">
                                                <select style="width: 100%">
                                                    <option disabled selected>-- Verify Old Patta --</option>
                                                    <?php foreach ($patta_all as $p): ?>
                                                        <option value="<?= $p->patta_no ?>"><?= $p->patta_no ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-lg-12 col-xs-12 col-sm-12 col-md-12">&nbsp;<hr></div>

                            <div class="col-lg-12">
                                <center>
                                    <input type="hidden" name="dist_code" 
                                    value="<?= $dagapply->dist_code ?>">
                                    <input type="hidden" name="subdiv_code" 
                                    value="<?= $dagapply->cir_code ?>">
                                    <input type="hidden" name="cir_code" 
                                    value="<?= $dagapply->subdiv_code ?>">
                                    <input type="hidden" name="mouza_pargona_code" 
                                    value="<?= $dagapply->mouza_pargona_code ?>">
                                    <input type="hidden" name="lot_no"
                                    value="<?= $dagapply->lot_no ?>">
                                    <input type="hidden" name="vill_townprt_code" 
                                    value="<?= $dagapply->vill_townprt_code ?>">
                                    <button type="submit" id='formsubmit' class="btn btn-primary uni_text btn-sm"><i class='fa fa-check'></i>&nbsp;Submit</button>
                                </center>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
 <div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">
    $(document).on('click','.btnEditDagArea', function(e){
        e.preventDefault(e);
        $('#DagArea').modal('show');
    });
</script>