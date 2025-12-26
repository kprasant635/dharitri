<div class="row" style='margin-top:40px'>
    <!-- <!-- <?php
    $user_desig_code = $this->session->userdata('user_desig_code');
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $user_code = $this->session->userdata('user_code');
    if ($this->session->userdata('user_desig_code') == 'AST') {
        $asstt = $this->utilityclass->getSelectedAssttName($dist_code, $subdiv_code, $cir_code, $user_code);
        $name = $asstt->username;
    }
    if ($user_desig_code == 'LM') {
        $mouza_pargona_code = $this->session->userdata('mouza_pargona_code');
        $lot_no = $this->session->userdata('lot_no');
        $lm = $this->utilityclass->getDefinedMondalsName($dist_code, $subdiv_code, $cir_code, $mouza_pargona_code, $lot_no, $user_code);
        $name = $lm->lm_name;
    }
    if ($user_desig_code == 'SK') {
        $sk = $this->utilityclass->getDefinedSKName($dist_code, $subdiv_code, $cir_code, $user_code);
        $name = $sk->username;
    }
    ?>
	 -->

    <?php if($user_desig_code == 'AST'): ?>
        <div class="col-lg-6 col-lg-offset-2">
            <div class="panel casedisplay">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular"> Composite Service</p>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <tr>
                            <td><?php echo $this->lang->line('asstt_ofc_noticegeneration_concerparty'); ?></td>
                            <td></td>
                            <td><a class="pull-right green "
                                   href="<?php echo base_url() . 'index.php/CompositeService/getPendingCases'; ?>"><?php echo $this->lang->line('view') ?></a>
                            </td>
                        </tr>
<!--                        <tr>-->
<!--                            <td>--><?php //echo $this->lang->line('asstt_ofc_actiontakenRpt'); ?><!--</td>-->
<!--                            <td>-->
<!--                                --><?php
//                                if ($paction != '0') {
//                                    echo "<span class=\"badge badge-primary\">$paction</span>";
//                                }
//                                ?>
<!--                            </td>-->
<!--                            <td><a class="pull-right green "-->
<!--                                   href="--><?php //echo base_url() . 'index.php/CompositeService/getPendingCasesForActionTaken'; ?><!--">--><?php //echo $this->lang->line('view') ?><!--</a>-->
<!--                            </td>-->
<!--                        </tr>-->
                        <tr>
                            <td>Regenerate Old Notice's</td>
                            <td>
                            </td>
                            <td><a class="pull-right text-danger"
                                   href="<?php echo base_url() . 'index.php/CompositeService/compServiceOldNotice'; ?>">Regenerate</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Search Composite Service Case</td>
                            <td>
                            </td>
                            <td><a class="pull-right text-danger"
                                   href="<?php echo base_url() . 'index.php/CompositeService/compServiceCaseSearch'; ?>">GO</a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <?php if($user_desig_code == 'CO'): ?>
        <div class="col-lg-6 col-lg-offset-2">
            <div class="panel casedisplay">
                <div class="panel-heading">
                    <div class="panel-title">
                        <p class="regular"> Composite Service ( OMUT / OPART )</p>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <tr>
                            <td>Information on Pending Cases</td>
                            <td>
                                <?php
                                if ($cases_no != '0') {
                                    echo "<span class=\"badge badge-primary\">$cases_no</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="pull-right green " href="<?php echo base_url() . 'index.php/CompositeService/getPendingCasesCO'; ?>"><?php echo $this->lang->line('view') ?></a>
                            </td>
                        </tr>
                        <tr>
                            <td>Search Composite Service Case</td>
                            <td>
                            </td>
                            <td><a class="pull-right text-danger"
                                   href="<?php echo base_url() . 'index.php/CompositeService/compServiceCaseSearch'; ?>">GO</a>
                            </td>
                        </tr>

                        <tr>
                            <td>Final Order</td>
                            <td>
                                <?php
                                if ($casef_no != '0') {
                                    echo "<span class=\"badge badge-primary\">$casef_no</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <a class="pull-right green " href="<?php echo base_url() . 'index.php/CompositeService/getPendingCasesCOFinal'; ?>"><?php echo $this->lang->line('view') ?></a>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
