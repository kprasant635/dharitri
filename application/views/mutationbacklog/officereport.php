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
    <div class='row'>
        <div class='col-lg-12 center-col'>
            <div class='panel panel-info'>
                <div class='panel-heading'>
                    <div class='panel-title'>
                        <p class="regular"><?php echo $this->lang->line('lm_report') ?> <?php echo $this->lang->line('case_no'); ?>- <?php echo $case_no; ?></p>
                    </div>
                </div>
                <div class='panel-body'>
                    <div class='row'>
                        <div class='col-lg-12'>
                            <?php
                            $link = base_url() . "index.php/lmmutation/writeofficereport";
                            ?>
                            <form method="post" action="<?php echo $link; ?>" accept-charset="UTF-8">
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
                                <table class='table table-bordered'>
                                    <tr>
                                        <td colspan="11" style="text-align: center">
                                            <a target="__blank" href='<?php echo base_url(); ?>index.php/chithareport/generateChitha?case_no=<?php echo $case_no; ?>' class="btn btn-danger"><?php echo $this->lang->line('view_chitha'); ?></a>
                                            <a  id='vp' href='<?php echo base_url(); ?>index.php/officemutation/viewpetition?case_no=<?php echo $case_no; ?>' href='#' class="btn btn-danger"><?php echo $this->lang->line('view_petition'); ?></a>

                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td>B</td><td>K</td><td>L</td><td>G</td><td>Kr</td>

                                    </tr>
                                    <tr>
                                        <!-- To be mutated Area-->
                                        <td><?php echo $this->lang->line('total_land_area') ?></td>
                                        <td>
                                            <input type='number' maxlength="6" name="mut_b" id="b" 
                                                   value="<?php echo $dags->dag_area_b; ?>" 

                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="" id="k" 
                                                   value="<?php echo $dags->dag_area_k; ?>"

                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="5" name="" id="lc" 
                                                   value="<?php echo round($dags->dag_area_lc); ?>"

                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="" id="g" 
                                                   value="<?php echo $dags->dag_area_g; ?>"

                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="" id="kr"
                                                   value="<?php echo $dags->dag_area_g; ?>"

                                                   />
                                        </td>
                                    </tr>
                                    <tr>
                                        <!-- To be mutated Area-->
                                        <td><?php echo $this->lang->line('mutated_land_area') ?></td>
                                        <td>
                                            <input type='number' maxlength="6" name="mut_b" id="mut_b"
                                                   value="<?php echo $dags->m_dag_area_b; ?>" 

                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="mut_k" id="mut_k"
                                                   value="<?php echo $dags->m_dag_area_k; ?>"

                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="5" name="mut_lc" id="mut_lc"
                                                   value="<?php echo round($dags->m_dag_area_lc); ?>"

                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="mut_g" id="mut_g"
                                                   value="<?php echo $dags->m_dag_area_g; ?>"

                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="mut_kr" id="mut_kr"
                                                   value="0"

                                                   />
                                        </td>
                                    </tr>
                                    <?php
                                    $mb = $dags->m_dag_area_b;
                                    $mk = $dags->m_dag_area_k;
                                    $ml = $dags->m_dag_area_lc;
                                    $m = $mb * 100 + $mk * 20 + $ml;

                                    $sm = $dags->dag_area_b;
                                    $sk = $dags->dag_area_k;
                                    $slc = $dags->dag_area_lc;
                                    $s = $sm * 100 + $sk * 20 + $slc;

                                    $rem = $s - $m;

                                    $bigha_r = floor($rem / 100);
                                    $katha_r = floor(($rem - $bigha_r * 100) / 20);
                                    $lessa_r = $rem - $bigha_r * 100 - $katha_r * 20;
                                    ?>	
                                    <tr>
                                        <td><?php echo $this->lang->line('remaining_land_area') ?></td>
                                        <td>
                                            <input type='number' maxlength="6" name="area_left_b" id="area_left_b"
                                                   value="<?php echo $bigha_r; ?>"
                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="area_left_k" id="area_left_k"
                                                   value="<?php echo $katha_r; ?>"
                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="5" name="area_left_lc" id="area_left_lc"
                                                   value="<?php echo round($lessa_r, 2); ?>"
                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="area_left_g" id="area_left_g"
                                                   value="<?php echo $dags->dag_area_g - $dags->m_dag_area_g; ?>"
                                                   />
                                        </td>
                                        <td>
                                            <input type='number' maxlength="2" name="area_left_kr" id="area_left_kr"
                                                   value="<?php echo $dags->dag_area_kr - $dags->m_dag_area_kr; ?>"
                                                   />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td></td>
                                        <td colspan="3"><?php echo $this->lang->line('detailed_report') ?></td>
                                        <td colspan="2"><?php echo $this->lang->line('dispute') ?></td>
                                    </tr>
                                    <tr>
                                        <td>
                                        <td colspan="3">
                                            <textarea rows="5" name='report_on_possession' style="width: 100%" >সকলো  তথ্য় 
সঠিকলট মন্ডল |</textarea>
                                        </td>
                                        <td colspan="2">
                                            <input type="checkbox" name='dispute' value="y"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="11" style="text-align: center;">
                                            <label><?php echo $this->lang->line('transfer_type') ?></label>
                                            <input type="hidden"  value="<?php echo $petition->mut_type; ?>" name="trans_code" style="width:20%;"/>
                                            <input type="text" readonly="" value="<?php echo $this->utilityclass->getTransferType($petition->trans_code); ?>" name="" style="width:20%;"/>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="11" style="text-align: center">

                                            <button type="submit"  class="btn btn-danger"><?php echo $this->lang->line('submit_report') ?></button>
                                        </td>
                                    </tr>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg ">
        <div class="modal-content login">
            Modal
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