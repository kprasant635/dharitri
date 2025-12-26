<script type="text/javascript">
    function ConfDel() {
        if (!confirm('Really want to Delete This Record?'))
            return (false);
        return (true);
    }
</script>

<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Quick Delete a Case No for Office Mutation(Order not Passed by CO)</h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Dharitree Utility Module
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text"><b>NOTE : || ALL HALF DONE CASES || 
                                    If you want to Delete any particular Case than click on the <span class="glyphicon glyphicon-remove-circle" aria-hidden="true" style='color: red;'></span> button. </b></h6>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <mark class='uni_text'>List of Pending Cases : (Click the Case No to Delete)</mark>
                        <table id="example" class="table table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <td rowspan="2" align='center' class="bold">Delete</td>
                                    <td rowspan="2" align='center' class="bold">Case No</td>
                                    <td rowspan="2" align='center' class="bold">Submission Date</td>
                                    <td colspan="3" align='center' class="bold">Location Code</td>
                                </tr>
                                <tr>
                                    <td align='center' class="bold">Mouza</td>
                                    <td align='center' class="bold">Lot</td>
                                    <td align='center' class="bold">Village / Town</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($Omute as $f):
                                    $mouza_pargona_code = $this->utilityclass->getMouzaName($f->dist_code, $f->subdiv_code, $f->cir_code, $f->mouza_pargona_code);
                                    $lot_no = $this->utilityclass->getLotName($f->dist_code, $f->subdiv_code, $f->cir_code, $f->mouza_pargona_code, $f->lot_no);
                                    $vill_townprt_code = $this->utilityclass->getVillageName($f->dist_code, $f->subdiv_code, $f->cir_code, $f->mouza_pargona_code, $f->lot_no,$f->vill_townprt_code);
                                    ?>
                                    <tr>
                                        <td align='center'><a onClick="return ConfDel()" href="<?php echo base_url(); ?>index.php/Utility/DeleteCaseOM?CaseNo=<?php echo $f->case_no."&mouza_pargona_code=".$f->mouza_pargona_code."&lot_no=".$f->lot_no."&village=".$f->vill_townprt_code; ?>" title="Delete record"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true" style='color: red;'></span></a></td>
                                        <td><a onClick="return ConfDel()" href="<?php echo base_url(); ?>index.php/Utility/DeleteCaseOM?CaseNo=<?php echo $f->case_no."&mouza_pargona_code=".$f->mouza_pargona_code."&lot_no=".$f->lot_no."&village=".$f->vill_townprt_code; ?>"><font style="color:red;"><?php echo $f->case_no; ?></font></a></td>
                                        <td align='center'><?php echo date('d-m-Y', strtotime($f->date_entry)); ?></td>
                                        <td align='center'><?php echo $mouza_pargona_code; ?></td>
                                        <td align='center'><?php echo $lot_no; ?></td>
                                        <td align='center'><?php echo $vill_townprt_code; ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                                ?>

                            </tbody>
                        </table>
                        <div class="form-group center">
                            <div class="col-lg-12">
                                <a href="<?php echo base_url(); ?>index.php/utility/misc_utilities" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //startButton.disabled = true;
    $(document).ready(function () {
        $('#example').DataTable();
    });
</script>