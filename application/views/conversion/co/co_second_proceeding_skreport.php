<div class="row mt-2">
    <div class="col-md-12 col-lg-12">
        <div class="card card-success">
            <div class="card-header d-flex justify-content-center">
                <h5>SK Report for case no: <?php echo $petition_basic->case_no; ?></h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <input type="hidden" id="baseurl" value="<?php echo base_url(); ?>">
                        <input type="hidden" id="case_no" name="case_no" value="<?php echo $petition_basic->case_no; ?>"/>
                        <input type="hidden" id="dag_no" name="dag_no" value="<?php echo $petition_dag_details->dag_no; ?>"/>
                        <input type="hidden" id="note_no" name="note_no" value="<?php echo $petition_lm_note_details->note_no; ?>"/>
                        <table class="table table-bordered table-striped">
                            <tbody>
                                <tr>
                                    <td><label class="control-label" >১) ভূমিলেখ্য পৰ্যবেক্ষকৰ অন্যান্য তথ্য ও মন্তব্য -</label></td>
                                    <td width="50%"><?php echo $petition_lm_note_details->sk_note; ?></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label" >২) ভূমিলেখ্য পৰ্যবেক্ষকৰ চহী &nbsp;- </label>
                                        <?php if($petition_lm_note_details->sk_sign_yn == 'Y'): ?>
                                            আছে
                                        <?php else: ?>
                                            নাই
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label" >৩) ভূমিলেখ্য পৰ্যবেক্ষকৰ নাম &nbsp;- </label>
                                        <?php echo $sk_details->username; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <label class="control-label" >৪) ভূমিলেখ্য পৰ্যবেক্ষকৰ টোকা লিখাৰ তাৰিখ &nbsp;- </label>
                                        <?php echo date('d-m-Y', strtotime($petition_lm_note_details->sk_note_date)); ?>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

</script>