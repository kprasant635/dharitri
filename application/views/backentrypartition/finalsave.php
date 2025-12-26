<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">

            <div class="col-lg-12 ">
                <div class="panel panel-info">
                    <div class='row'>
                        <h2 style="text-align: center;" class='red uni_text'>Backlog Entry For Partition Case</h2>
                        <hr>

                        <div class='col-lg-10 col-lg-offset-1'>
                            <h4 class='center uni_text'>All Applicant Details Selected </h4>
                            <table class='table uni_text table_black'>
                                <tr class='center'>
                                    <td>Dist : <?php echo  $this->utilityclass->getDistrictName($this->session->userdata('dist_code')); ?></td>
                                    <td>Subdiv :<?= $this->utilityclass->getSubDivName($this->session->userdata('dist_code'), $this->session->userdata['basic']['subdiv_code']); ?></td>
                                    <td>Circle :<?= $this->utilityclass->getCircleName($this->session->userdata('dist_code'), $this->session->userdata['basic']['subdiv_code'], $this->session->userdata['basic']['circle_code']); ?></td>
                                </tr>
                                <tr class='center'>
                                    <td>Mouza : <?php echo  $this->utilityclass->getMouzaName($this->session->userdata('dist_code'), $this->session->userdata['basic']['subdiv_code'], $this->session->userdata['basic']['circle_code'], $this->session->userdata['basic']['mouza_code']); ?></td>
                                    <td>Lot No :<?= $this->utilityclass->getLotLocationName($this->session->userdata('dist_code'), $this->session->userdata['basic']['subdiv_code'], $this->session->userdata['basic']['circle_code'], $this->session->userdata['basic']['mouza_code'], $this->session->userdata['basic']['lot_no']); ?></td>
                                    <td>Village : <?php echo  $this->utilityclass->getVillageName($this->session->userdata('dist_code'), $this->session->userdata['basic']['subdiv_code'], $this->session->userdata['basic']['circle_code'], $this->session->userdata['basic']['mouza_code'], $this->session->userdata['basic']['lot_no'], $this->session->userdata['basic']['vill_code']); ?></td>
                                </tr>
                            </table>
                            <hr>
                            <h4 class='center red'>Basic Details</h4>
                            <?php //var_dump($this->session->userdata('basic'));?>
                            <table class='table uni_text table_black'>
                                <thead>
                                <td colspan=2>Previous Case : <?php echo  $this->session->userdata['basic']['case_no'] ?></td>
                                <td>Order Date : <?php echo  date('d/m/Y', strtotime($this->session->userdata['basic']['order_date'])) ?></td>

                                </thead>
                                <tr class='hide'>
                                    <td>Issued By :  <?php echo  $basic->issued_officer_desig; ?></td>
                                    <td>Issued Name : <?php echo  $basic->issued_by ?></td>

                                </tr>
                                <tr>
                                    <td>Issued LM :<?php
                                        $lm = $this->utilityclass->getDefinedMondalsName($this->session->userdata('dist_code'), $this->session->userdata['basic']['subdiv_code'], $this->session->userdata['basic']['circle_code'], $this->session->userdata['basic']['mouza_code'], $this->session->userdata['basic']['lot_no'], $this->session->userdata['basic']['lm_code']);
                                        echo $lm->lm_name;
                                        //var_dump($lm);
                                        ?>
                                        <kbd><?= date('d/m/Y', strtotime($this->session->userdata['basic']['lm_date'])) ?></kbd>
                                    </td>
                                    <td>Issued SK :
                                        <?php
                                        $sk = $this->utilityclass->getSKByCode($this->session->userdata('dist_code'), $this->session->userdata['basic']['subdiv_code'], $this->session->userdata['basic']['circle_code'], $this->session->userdata['basic']['sk_code']);
                                        echo $sk->username;
                                        ?>
                                        <kbd><?= date('d/m/Y', strtotime($this->session->userdata['basic']['sk_date'])) ?></kbd>
                                    </td>
                                    <td>Issued CO :
                                        <?php
                                        $sk = $this->utilityclass->getSKByCode($this->session->userdata('dist_code'), $this->session->userdata['basic']['subdiv_code'], $this->session->userdata['basic']['circle_code'], $this->session->userdata['basic']['co_code']);
                                        echo $sk->username;
                                        ?>
                                        <kbd><?= date('d/m/Y', strtotime($this->session->userdata['basic']['co_date'])) ?></kbd>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan='2'>Old Dag No. :  <?php echo  $this->session->userdata['basic']['dag_no']; ?>
                                        <br>
                                        Old Patta No : <?php echo  $this->session->userdata['basic']['patta_no'] ?>
                                        <br>

                                    </td>

                                    <td rowspan='2'>New Dag No. : <span class='red badge'> <?php echo  $this->session->userdata['basic']['new_dag_no']; ?> </span>
                                        <br>
                                        New Patta No : <span class='red badge'><?= $this->session->userdata['basic']['new_patta_no'] ?></span>
                                    </td>
                                    <td>
                                        Total Land Area : <?php echo  $this->session->userdata['basic']['t_bigha'] ?> B-<?= $this->session->userdata['basic']['t_katha'] ?> K-<?= $this->session->userdata['basic']['t_lessa'] ?> L <br>
                                        Applied Land Area : <kbd><?= $this->session->userdata['basic']['p_bigha'] ?> B-<?= $this->session->userdata['basic']['p_katha'] ?> K-<?= $this->session->userdata['basic']['p_lessa'] ?> L </kbd>
                                    </td>
                                </tr>


                            </table>
                            <h4 class='center red'>Applicant Details</h4>
                            <table class='table uni_text table_black'>
                                <?php
                                $fparty = $this->session->userdata('applicant');
                                foreach ($fparty as $fp):
                                    ?>
                                    <thead>
                                    <td>Name <i class='fa fa-user'> :- <span class='red'><?= $fp['name']; ?></span></td>
                                    <td>Gurdian Name <i class='fa fa-user-plus'>: <?php echo  $fp['guard'] ?></td>
                                    <td colspan=2>Relation <i class='fa fa-retweet'>: <?php echo  $this->utilityclass->get_relation($fp['rel']) ?></td>
                                    </thead>

                                <?php endforeach; ?>
                            </table>
                            <input type='checkbox' disabled checked class='squaredTwo' >
                            <span class='uni_text'>হাতৰ চিঠা/জমাবন্দীৰ তথ্যৰ ভিত্তিত উক্ত তথ্যৰ সংশোধনী  কৰাৰ বাবে চক্ৰ বিষয়াৰ মহোদয়লৈ অনুৰোধ কৰা হ'ল ৷  লা.ম. :-
                                <kbd><?php
                                    $user_code = $this->session->userdata('user_code');
                                    $lm = $this->utilityclass->getDefinedMondalsName($this->session->userdata('dist_code'), $this->session->userdata['basic']['subdiv_code'], $this->session->userdata['basic']['circle_code'], $this->session->userdata['basic']['mouza_code'], $this->session->userdata['basic']['lot_no'], $user_code);
                                    echo $lm->lm_name;
                                    //var_dump($lm);
                                    ?>
                                </kbd>
                            </span>
                            <hr>
                            <center><a href='<?php echo base_url() ?>index.php/Backlogpartition/SaveLM' class='btn btn-info'> <i class='fa fa-file'></i> Send Request to CO </a>
                                <a href='' class='btn btn-danger' ><i class='fa fa-times'></i> Cancel Request </a>
                            </center>
                            <hr>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
