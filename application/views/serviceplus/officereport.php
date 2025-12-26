<script>
    $(function () {
        $('#vp').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal();
                }
            });

        });

    });
</script>
<script>
    $(function () {
        $('form').submit(function (e) {
            var response = confirm("Are you sure you want to register a field mutation case?");
            if (response) {


                var dispute = $('input[name="dispute"]').is(':checked');
                console.log(dispute);
                if (dispute) {
                    $('#myModal .modal-body p').html("Disputed Plots cannot be Mutated!");
                    $('#myModal').modal();
                    e.preventDefault();
                }
            } else {
                e.preventDefault();
            }
        });
    });

</script>
<style>
    input[type='number']{
        width:100%;
    }
</style>

<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"><?php echo $this->lang->line('lm_report') ?> <?php echo $this->lang->line('case_no'); ?>- <?php echo $case_no; ?></h2>
                </div>
                <?php
                            if($this->session->flashdata('message')){
                        ?>
<div class="error_container">
                            <div class="alert alert-warning alert-dismissible show" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                <strong class="text-danger">
                                    <?= $this->session->flashdata('message'); ?>
                                </strong>
                            </div>
  </div>
                        <?php
                            }
                        ?>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                    <div class="row">
                        <div class="col-lg-6"><p class="uni_text"><?php echo "Mutation Area Details" ?></p></div>
                        <div class="col-lg-6"><p class="uni_text text-center">
                            <?php
                            if($petition->application_ref_no){
                                echo "অনলাইনত উল্লেখ নং : ".$petition->application_ref_no;
                            }
                            ?> 
                        </p></div>
                        </div>
                    </div>
                    <div class="panel-body">
                        <form method="post" action="<?php base_url() . "index.php/serviceplus/writeofficereport"; ?>" accept-charset="UTF-8">
                            <input type='hidden' value="<?php echo $dags->dist_code; ?>" name="dist_code"/>
                            <input type='hidden' value="<?php echo $dags->subdiv_code; ?>" name="subdiv_code"/>
                            <input type='hidden' value="<?php echo $dags->cir_code; ?>" name="cir_code"/>
                            <input type='hidden' value="<?php echo $dags->mouza_pargona_code; ?>" name="mouza_pargona_code"/>
                            <input type='hidden' value="<?php echo $dags->lot_no; ?>" name="lot_no"/>
                            <input type='hidden' value="<?php echo $dags->vill_townprt_code; ?>" name="vill_townprt_code"/>
                            <input type='hidden' value="<?php echo $dags->petition_no; ?>" name="petition_no"/>
                            <input type='hidden' value="<?php echo $dags->dag_no; ?>" name="dag_no"/>
                            <input type='hidden' value="<?php echo $dags->dag_area_b; ?>" id="b"/>
                            <input type='hidden' value="<?php echo $dags->dag_area_k; ?>" id="k"/>
                            <input type='hidden' value="<?php echo $dags->dag_area_lc; ?>" id="lc"/>
                            <input type='hidden' value="<?php echo $dags->dag_area_g; ?>" id="g"/>
                            <input type='hidden' value="<?php echo $dags->dag_area_kr; ?>" id="kr"/>
                            <input type='hidden' name='case_no' value="<?php echo $case_no; ?>"/>
                            <input type='hidden' name='mode_of_registration' value="<?php echo $petition->mode_of_registration; ?>"/>
                            <input type='hidden' name='application_ref_no' value="<?php echo $petition->application_ref_no; ?>"/>
                            <input type='hidden' name='applid' value="<?php echo $petition->applid; ?>"/>
                            <fieldset>
                                <h2 class="red">Applicant Details</h2>
                                <table class="table table-bordered  unicode">
                                    <thead>
                                        <tr>
                                            <th><label class="text-danger">Applicant name</label></th>
                                            <?php
                                            $dist_code = $this->session->userdata('dist_code');
                                            if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                            <th><label class="text-danger">B-K-C-G</label></th>
                                        <?php }else{?>
                                            <th><label class="text-danger"><?php echo $this->lang->line('land_area_b_k_l'); ?></label></th>
                                        <?php }?>
                                            <th class="center"><label class="text-danger">Guardian Name</label></th>
                                            <th class="center"><label class="text-danger">Address 1 / Address 2</label></th>
                                        </tr>
                                    </thead>
                                    <?php
                                    foreach ($field_mut_petitioner as $petitioner):
                                        ?>
                                        <tr>
                                            <td><label class="control-label"><?php echo $petitioner->pet_name; ?></label></td>
                                            <?php
                                              $dist_code = $this->session->userdata('dist_code');
                                              if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                            <td><label class="control-label"><?php echo $petitioner->applied_b . " বিঘা " . $petitioner->applied_k . " কঠা " . $petitioner->applied_lc . " ছটাক ". $petitioner->applied_lc." গণ্ডা " ?></label></td>
                                            <?php }else{?>
                                            <td><label class="control-label"><?php echo $petitioner->applied_b . " বিঘা " . $petitioner->applied_k . " কঠা " . $petitioner->applied_lc . " লেছা " ?></label></td>
                                            <?php }?>
                                            <td class="center"><label class="control-label"><?php echo $petitioner->guard_name; ?></label></td>
                                            <td class="center"><label class="control-label"><?php echo $petitioner->add1; ?></label></td>
                                        </tr>
                                        <?php
                                    endforeach;
                                    ?>
                                </table>
                            </fieldset>
                            <hr style="border-bottom: 2px solid #000;">
                            <fieldset>
                                <h2 class="red">In place / Along with Information</h2>
                                <table class='table table-bordered  unicode'>
                                    <thead>
                                        <tr>
                                            <th><label class="text-danger"><?php echo $this->lang->line('petitioner_name'); ?></label></th>
                                            <th><label class="text-danger"><?php echo $this->lang->line('guardian_name'); ?></label></th>
                                            <th><label class="text-danger"><?php echo $this->lang->line('address1'); ?> / <?php echo $this->lang->line('address2'); ?></label></th>
                                            <th><label class="text-danger">In place / Along with</label></th>
                                            <th><label class="text-danger"><?php echo $this->lang->line('address1'); ?> / <?php echo $this->lang->line('address2'); ?></label></th>
                                        </tr>
                                    </thead>
                                    <?php
                                    foreach ($field_mut_pattadar as $pattadars):
                                    //var_dump($pattadars);
                                        ?>
                                        <tr>
                                            <td><label class="control-label"><?php echo $pattadars->pdar_name; ?></label></td>
                                            <td><label class="control-label"><?php echo $pattadars->pdar_guardian; ?></label></td>
                                            <td><label class="control-label"><?php echo $pattadars->pdar_add1; ?></label></td>
                                            <td><label class="control-label">
                                                <select name="inplacAlong[]">
                                                    <option value="<?=$pattadars->striked_out==null
                                                    || $pattadars->striked_out=='0' ? 0:1 ?>"><?=$pattadars->striked_out==null || $pattadars->striked_out=='0' ? 'Along With' : 'In Place Of' ?></option>
                                                    <option value="1">In Place Of</option>
                                                    <option value="0">Along With</option>
                                                </select>
                                                </label></td>
                                            <td><label class="control-label"><?=$pattadars->pdar_add2; ?></label></td>
                                        </tr>
                                        <input type="hidden" name="pattadar[]" value="<?=$pattadars->pdar_id?>">
                                    <?php endforeach; ?>
                                </table>
                            </fieldset>
                            <hr style="border-bottom: 2px solid #000;">
                            <h2 class="red">Land Area Details</h2>
                             <table class='table table-bordered'>
                            <tr>
                                <th> Dag No
                                </th>
                                <th>Patta No</th>
                                <th> Patta Type</th>
                            </tr>
                            <tr>
                               <td><?=$dags->dag_no; ?></td>
                               <td><?=$dags->patta_no; ?></td>
                               <td><?=$this->utilityclass->getPattaType($dags->patta_type_code); ?></td>
                            </tr>
                            </table>
                            <table class='table table-bordered'>
                                <tr>
                                    <td></td><td>Bigha</td><td>Katha</td>
                                    <?php if(in_array($dist_code, json_decode(BARAK_VALLEY))){?>
                                    <td>Chatak</td>
                                    <?php }else{?>
                                         <td>Lessa</td>
                                    <?php }?>
                                    <td>Ganda</td><td>Krantik</td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('total_land_area') ?></td>
                                    <td width="20%">
                                        <input type='number' maxlength="6" name="mut_b" id="b" value="<?php echo $dags->dag_area_b; ?>" />
                                    </td>
                                    <td width="20%">
                                        <input type='number' maxlength="2" name="" id="k" value="<?php echo $dags->dag_area_k; ?>" />
                                    </td>
                                    <td width="20%">
                                        <input type='number' maxlength="5" name="" id="lc" value="<?php echo $dags->dag_area_lc; ?>" />
                                    </td>
                                    <td width="10%">
                                        <input type='number' maxlength="2" name="" id="g" value="<?php echo $dags->dag_area_g; ?>" />
                                    </td>
                                    <td width="10%">
                                        <input type='number' maxlength="2" name="" id="kr" value="<?php echo $dags->dag_area_g; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <!-- To be mutated Area-->
                                    <td><?php echo $this->lang->line('mutated_land_area') ?></td>
                                    <td>
                                        <input type='number' maxlength="6" name="mut_b" id="mut_b" value="<?php echo $dags->m_dag_area_b; ?>" />
                                    </td>
                                    <td>
                                        <input type='number' maxlength="2" name="mut_k" id="mut_k" value="<?php echo $dags->m_dag_area_k; ?>" />
                                    </td>
                                    <td>
                                        <input type='number' maxlength="5" name="mut_lc" id="mut_lc" value="<?php echo $dags->m_dag_area_lc; ?>" />
                                    </td>
                                    <td>
                                        <input type='number' maxlength="2" name="mut_g" id="mut_g" value="<?php echo $dags->m_dag_area_g; ?>" />
                                    </td>
                                    <td>
                                        <input type='number' maxlength="2" name="mut_kr" id="mut_kr" value="0" />
                                    </td>
                                </tr>
                                <?php
                                $mb = $dags->m_dag_area_b;
                                $mk = $dags->m_dag_area_k;
                                $ml = $dags->m_dag_area_lc;
                                $mg = $dags->m_dag_area_g;

                                $dist_code = $this->session->userdata('dist_code');

                                if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                                {
                                $m = $mb * 6400 + $mk * 320 + $ml * 20 + $mg;
                                $sm = $dags->dag_area_b;
                                $sk = $dags->dag_area_k;
                                $slc = $dags->dag_area_lc;
                                $sg = $dags->dag_area_g;
                                //echo $dags->dag_area_lc;
                                $s = $sm * 6400 + $sk * 320 + $slc * 20 + $sg;

                                $rem = $s - $m;

                                $bigha_r = floor($rem / 6400.0);
                                $katha_r = floor(($rem - $bigha_r * 6400.0) / 320.0);
                                $lessa_r = ($rem - $bigha_r * 6400.0 - $katha_r * 320.0)/20.0;
                                $ganda_r = $rem - $bigha_r * 6400.0 - $katha_r * 320.0 - $lessa_r * 20.0;
                                }

                                else
                                {
                                $m = $mb * 100 + $mk * 20 + $ml;
                                $sm = $dags->dag_area_b;
                                $sk = $dags->dag_area_k;
                                $slc = $dags->dag_area_lc;
                                //echo $dags->dag_area_lc;
                                $s = $sm * 100 + $sk * 20 + $slc;

                                $rem = $s - $m;

                                $bigha_r = floor($rem / 100.0);
                                $katha_r = floor(($rem - $bigha_r * 100.0) / 20.0);
                                $lessa_r = $rem - $bigha_r * 100.0 - $katha_r * 20.0;
                                }

                                ?>
                                <tr>
                                    <td><?php echo $this->lang->line('remaining_land_area') ?></td>
                                    <td>
                                        <input type='number' maxlength="6" name="area_left_b" id="area_left_b" value="<?php echo $bigha_r; ?>" />
                                    </td>
                                    <td>
                                        <input type='number' maxlength="2" name="area_left_k" id="area_left_k" value="<?php echo $katha_r; ?>" />
                                    </td>
                                    <td>
                                        <input type='number' maxlength="5" name="area_left_lc" id="area_left_lc" value="<?php echo round($lessa_r, 2); ?>" />
                                    </td>
                                    <?php $dist_code = $this->session->userdata('dist_code');

                                    if(in_array($dist_code, json_decode(BARAK_VALLEY)))
                                    {?>
                                    <td>
                                        <input type='number' maxlength="2" name="area_left_g" id="area_left_g" value="<?php echo $ganda_r ?>" />
                                    </td>
                                <?php }else{?>
                                    <td>
                                        <input type='number' maxlength="2" name="area_left_g" id="area_left_g" value="<?php echo $dags->dag_area_g - $dags->m_dag_area_g; ?>" />
                                    </td>
                                    <?php }?>
                                    <td>
                                        <input type='number' maxlength="2" name="area_left_kr" id="area_left_kr" value="<?php echo $dags->dag_area_kr - $dags->m_dag_area_kr; ?>" />
                                    </td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('transfer_type') ?></td>
                                    <td colspan="3">
                                        <input type="hidden"  value="<?php echo $petition->mut_type; ?>" name="trans_code" style="width:20%;"/>
                                        <input type="text" readonly="" value="<?php echo $this->utilityclass->getTransferType($petition->trans_code); ?>" name="" style="width:20%;"/>
                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td><?php echo $this->lang->line('detailed_report') ?></td>
                                    <td colspan="3">
                                        <textarea rows="5" name='report_on_possession' style="width: 100%" >সকলো  তথ্য় সঠিকলট মন্ডল |</textarea>
                                    </td>
                                    <td colspan="2"></td>
                                </tr>
                                <tr>
                                    <td colspan="11">
                                        If this land is under <?php echo $this->lang->line('dispute') ?>&nbsp;&nbsp;<input type="checkbox" name='dispute' value="y"/>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11">
                                    <?php
                                        echo '<h2 class="red">Other Attachments</h2>';
                                        
                                        foreach ($attachment  as $attachment):
                                        //var_dump($attachment);
                                        ?>
                                        <h6><a href="<?php echo base_url()."index.php/serviceplus/print_pdf?data=".$attachment->path .'&refNo=' . $petition->application_ref_no .'&type='. 4 ; ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;<?php echo $attachment->doc_name;?> (Click to see the attachment)</a></h6>
                                        <?php 
                                        endforeach; 
                                    ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="11" style="text-align: center">
                                        <a target="__blank" href='<?php echo base_url(); ?>index.php/chithareport/generateChitha?case_no=<?php echo $case_no; ?>' class="btn btn-danger"><?php echo $this->lang->line('view_chitha'); ?></a>
                                        <a  id='vp' href='<?php echo base_url(); ?>index.php/officemutation/viewpetition?case_no=<?php echo $case_no; ?>' href='#' class="btn btn-danger"><?php echo $this->lang->line('view_petition'); ?></a>
                                        <button type="submit" class="btn btn-success" id='formsubmit'><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                                        <button type="reset" name="ASTSTEP1Submit" class="btn btn-primary"><i class='fa fa-refresh'></i>&nbsp;<?php echo $this->lang->line('reset'); ?></button>
                                        <a href="<?php echo base_url(); ?>index.php/lmmutation/getPendingOfficeMutationCases" class="btn btn-danger">
                                            <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background: #ccc">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">You Have Selected Office Mutation's LM module </h4>
            </div>
            <hr>
            <div class="modal-body">
                <p></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>