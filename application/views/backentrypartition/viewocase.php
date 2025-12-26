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
                                    <td>Dist : <?php echo  $this->utilityclass->getDistrictName($col8->dist_code); ?></td>
                                    <td>Subdiv :<?= $this->utilityclass->getSubDivName($col8->dist_code, $col8->subdiv_code); ?></td>
                                    <td>Circle :<?= $this->utilityclass->getCircleName($col8->dist_code, $col8->subdiv_code, $col8->cir_code); ?></td>
                                </tr>
                                <tr class='center'>
                                    <td>Mouza : <?php echo  $this->utilityclass->getMouzaName($col8->dist_code, $col8->subdiv_code, $col8->cir_code, $col8->mouza_pargona_code); ?></td>
                                    <td>Lot No :<?= $this->utilityclass->getLotLocationName($col8->dist_code, $col8->subdiv_code, $col8->cir_code, $col8->mouza_pargona_code, $col8->lot_no); ?></td>
                                    <td>Village : <?php echo  $this->utilityclass->getVillageName($col8->dist_code, $col8->subdiv_code, $col8->cir_code, $col8->mouza_pargona_code, $col8->lot_no, $col8->vill_townprt_code); ?></td>
                                </tr>
                            </table>
                            <hr>
                            <h4 class='center red'>Basic Details</h4>
                            <?php //var_dump($this->session->userdata('basic'));?>
                            <table class='table uni_text table_black'>
                                <thead>
                                <td colspan=2>Previous Case : <?php echo  $col8->case_no ?></td>
                                <td>Order Date : <?php echo  date('d/m/Y', strtotime($col8->ord_date)) ?></td>

                                </thead>
                                <tr>
                                    <td>Issued LM :<?php
                                        $lm = $this->utilityclass->getDefinedMondalsName($col8->dist_code, $col8->subdiv_code, $col8->cir_code, $col8->mouza_pargona_code, $col8->lot_no, $col8->lm_code);
                                        echo $lm->lm_name;
                                        //var_dump($lm);
                                        ?>
                                        <kbd><?= date('d/m/Y', strtotime($col8->lm_sign_date)) ?></kbd>
                                    </td>
                                    <td>Issued SK :
                                        <?php
                                        $sk = $this->utilityclass->getSKByCode($col8->dist_code, $col8->subdiv_code, $col8->cir_code, $col8->sk_code);
                                        echo $sk->username;
                                        ?>
                                        <kbd><?= date('d/m/Y', strtotime($col8->sk_sign_date)) ?></kbd>
                                    </td>
                                    <td>Issued CO :
                                        <?php
                                        $sk = $this->utilityclass->getSKByCode($col8->dist_code, $col8->subdiv_code, $col8->cir_code, $col8->co_code);
                                        echo $sk->username;
                                        ?>
                                        <kbd><?= date('d/m/Y', strtotime($col8->co_ord_date)) ?></kbd>
                                    </td>
                                </tr>
                                <tr>
                                    <td rowspan='2'>Old Dag No. :  <?php echo  $col8->dag_no; ?>
                                        <br>
                                        Old Patta No : <?php echo  $col8occ[0]->patta_no; ?>
                                        <br>

                                    </td>

                                    <td rowspan='2'>New Dag No. : <span class='red badge'> <?php echo  $col8occ[0]->new_dag_no; ?> </span>
                                        <br>
                                        New Patta No : <span class='red badge'><?= $col8occ[0]->new_patta_no; ?></span>
                                    </td>
                                    <td>
                                        New Dag Land Area : <?php echo  $col8->m_dag_area_b ?> B-<?= $col8->m_dag_area_k ?> K-<?= $col8->m_dag_area_lc ?> L <br>
                                        Old Dag Land Area : <kbd><?= $col8->area_left_b ?> B-<?= $col8->area_left_k ?> K-<?= $col8->area_left_lc ?> L </kbd>
                                    </td>
                                </tr>	
                            </table>
                            <h4 class='center red'>Applicant Details</h4>
                            <table class='table uni_text table_black'>
                                <?php
                                foreach ($col8occ as $fp):
                                    $user_code = $col8->ord_passby_desig;
                                    ?>
                                    <thead>
                                    <td>Name <i class='fa fa-user'> :- <span class='red'><?= $fp->infavor_of_name; ?></span></td>
                                    <td>Gurdian Name <i class='fa fa-user-plus'>: <?php echo  $fp->infavor_of_guardian ?></td>
                                    <td colspan=2>Relation <i class='fa fa-retweet'>: <?php echo  $this->utilityclass->get_relation($fp->infav_of_guar_relation) ?></td>
                                    </thead>

                                <?php endforeach; ?>
                            </table>
                            <input type='checkbox' disabled checked class='squaredTwo' >
                            <span class='uni_text'>হাতৰ চিঠা/জমাবন্দীৰ তথ্যৰ ভিত্তিত উক্ত তথ্যৰ সংশোধনী  কৰাৰ বাবে চক্ৰ বিষয়াৰ মহোদয়লৈ অনুৰোধ কৰা হ'ল ৷  লা.ম. :-
                                <kbd><?php
                                    $lm = $this->utilityclass->getDefinedMondalsName($col8->dist_code, $col8->subdiv_code, $col8->cir_code, $col8->mouza_pargona_code, $col8->lot_no, $user_code);
                                    echo $lm->lm_name;
                                    //var_dump($lm);
                                    ?></kbd><br><hr>

                                <input type='checkbox' disabled checked class='squaredTwo' >
                                <span class='uni_text red'> স্বীকাৰোক্তিঃ উল্লেখিত তথ্য সমূহ মোৰ তত্বাৱধানত সংশোধন কৰা হৈছে ৷ তথ্য সমূহৰ সত্যতা প্ৰমাণ নহলে মই দায়ী হ'ম ৷ চ:বি:-  </span>
                                <kbd><?php
                                    $lm = $this->utilityclass->getSKByCode($col8->dist_code, $col8->subdiv_code, $col8->cir_code, $this->session->userdata('user_code'));
                                    echo $lm->username;
                                    //var_dump($lm);
                                    ?>
                                </kbd>
                                <br><hr>
                                <center><a href="<?php echo base_url(); ?>index.php/Backlogpartition/copassorder?type=2&case=<?= $col8->case_no; ?>&p=<?= $col8->petition_no ?>" class='btn btn-info'> <i class='fa fa-file'></i> Approve Request </a>
                                    <a href='<?php echo base_url(); ?>index.php/Backlogpartition/corejectorder?type=2&case=<?= $col8->case_no; ?>&p=<?= $col8->petition_no ?>' class='btn btn-danger' ><i class='fa fa-times'></i> Reject Request </a>
                                </center>
                                <hr>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
                                </div>
