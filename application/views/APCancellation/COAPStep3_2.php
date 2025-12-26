<div class="container-fluid form-top">
    <div class="row login">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center; ">
<!--                        View Petition By Lot Mondal (LM)-->
                    CO's Recommendation (চক্ৰ বিষয়াৰ সন্মতি)
                    </h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?php echo $this->lang->line('case_no');?> : <strong><?php echo $_GET['case_no']; ?></strong>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered" width="100%">
                            <tr class="success">
                                <td class="text-center"><h6><?php echo $this->lang->line('district');?> : <strong><?php echo $namedata[0]->district; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('subdivision');?> : <strong><?php echo $namedata[1]->subdiv; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('circle');?> : <strong><?php echo $namedata[2]->circle; ?></strong></h6></td>
                            </tr>
                            <tr >
                                <td class="text-center"><h6><?php echo $this->lang->line('mouza');?> : <strong><?php echo $namedata[3]->mouza; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('lot_no');?> : <strong><?php echo $namedata[4]->lot_no; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('vill_town');?> : <strong><?php echo $namedata[5]->village; ?></strong></h6></td>
                            </tr>
                            <tr class="success">
                                <td class="text-center"><h6><?php echo $this->lang->line('submission_date');?> : <strong><?php
                                $d = $_GET['submission_date'];
                                echo date("d-m-Y", strtotime($d));
?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('patta_type');?> : <strong><?php echo $landtype->patta_type; ?></strong></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('address_to_the_officer');?> : <strong><?php echo $landtype->add_off_desig; ?></strong></h6></td>
                            </tr>

                        </table>
                        <table class="table table-striped table-bordered" width="100%">
                            <tr class="danger">
                                <td colspan="6">Petition Information (আবেদনকাৰীৰ তথ্য)</td>
                            </tr>
                            <tr class="success">
                                <td class="text-center"><?php echo $this->lang->line('sl_no');?></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('name');?> </h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('guardian_name');?></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('relation');?></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('address1');?></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('address2');?></h6></td>
                            </tr>
                            <?php 
                            $c=1;foreach($petitioninfo AS $petitioner){?>
                            <tr>
                                <td class="text-center"><?php echo $c;?></td>
                                <td class="text-center"><?php echo $petitioner->pet_name;?></td>
                                <td class="text-center"><?php echo $petitioner->guard_name;?></td>
                                <td class="text-center"><?php echo $petitioner->guard_rel;?></td>
                                <td class="text-center"><?php echo $petitioner->add1;?></td>
                                <td class="text-center"><?php echo $petitioner->add2;?></td>
                            </tr>
                            <?php $c++;}?>
                        </table>
                        <table class="table table-striped table-bordered" width="100%">
                            <tr class="danger">
                                <td colspan="4"><?php echo $this->lang->line('pattadar_dag_information');?></td>
                            </tr>
                            <tr class="success">
                                <td class="text-center"><?php echo $this->lang->line('dag_no');?></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('patta_no');?></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('patta_type');?></h6></td>
                                <td class="text-center"><h6><?php echo $this->lang->line('show_chitha');?></h6></td>
                            </tr>
                            <?php foreach($daginfo AS $dag){?>
                            <tr>
                                <td class="text-center"><?php echo $dag->dag_no;?></td>
                                <td class="text-center"><?php echo $dag->patta_no;?></td>
                                <td class="text-center"><?php echo $landtype->patta_type; ?></td>
                                <td class="text-center">
                                    <a href="##" class="btn btn-sm btn-danger">
                                        <i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('show_chitha');?>
                                    </a>
                                </td>
                            </tr>                           
                            <?php }?>
                            <tr>
                                <td colspan="4">
                                    <a href="<?php echo base_url() . "index.php/APCancellation/SKViewPetition"; ?>?submission_date=<?php echo $_GET['submission_date']; ?>&dist_code=<?php echo $_GET['dist_code']; ?>&subdiv_code=<?php echo $_GET['subdiv_code']; ?>&cir_code=<?php echo $_GET['cir_code']; ?>&mouza_pargona_code=<?php echo $_GET['mouza_pargona_code']; ?>&lot_no=<?php echo $_GET['lot_no']; ?>&vill_townprt_code=<?php echo $_GET['vill_townprt_code']; ?>&year_no=<?php echo $_GET['year_no']; ?>&petition_no=<?php echo $_GET['petition_no']; ?>&case_no=<?php echo $_GET['case_no']; ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('view_petition');?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/APCancellation/LMNoteView_by_SK"; ?>?submission_date=<?php echo $_GET['submission_date']; ?>&dist_code=<?php echo $_GET['dist_code']; ?>&subdiv_code=<?php echo $_GET['subdiv_code']; ?>&cir_code=<?php echo $_GET['cir_code']; ?>&mouza_pargona_code=<?php echo $_GET['mouza_pargona_code']; ?>&lot_no=<?php echo $_GET['lot_no']; ?>&vill_townprt_code=<?php echo $_GET['vill_townprt_code']; ?>&year_no=<?php echo $_GET['year_no']; ?>&petition_no=<?php echo $_GET['petition_no']; ?>&case_no=<?php echo $_GET['case_no']; ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('view_lm_note');?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/APCancellation/SKNoteView_by_CO"; ?>?submission_date=<?php echo $_GET['submission_date']; ?>&dist_code=<?php echo $_GET['dist_code']; ?>&subdiv_code=<?php echo $_GET['subdiv_code']; ?>&cir_code=<?php echo $_GET['cir_code']; ?>&mouza_pargona_code=<?php echo $_GET['mouza_pargona_code']; ?>&lot_no=<?php echo $_GET['lot_no']; ?>&vill_townprt_code=<?php echo $_GET['vill_townprt_code']; ?>&year_no=<?php echo $_GET['year_no']; ?>&petition_no=<?php echo $_GET['petition_no']; ?>&case_no=<?php echo $_GET['case_no']; ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('view_sk_note');?>
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                    <a href="<?php echo base_url() . "index.php/APCancellation/CONoteOfHearing"; ?>?submission_date=<?php echo $_GET['submission_date']; ?>&dist_code=<?php echo $_GET['dist_code']; ?>&subdiv_code=<?php echo $_GET['subdiv_code']; ?>&cir_code=<?php echo $_GET['cir_code']; ?>&mouza_pargona_code=<?php echo $_GET['mouza_pargona_code']; ?>&lot_no=<?php echo $_GET['lot_no']; ?>&vill_townprt_code=<?php echo $_GET['vill_townprt_code']; ?>&year_no=<?php echo $_GET['year_no']; ?>&petition_no=<?php echo $_GET['petition_no']; ?>&case_no=<?php echo $_GET['case_no']; ?>" class="btn btn-primary">
                                        <i class='fa fa-check'></i>&nbsp;View CO Note of Hearing
                                    </a>
                                    &nbsp;&nbsp;&nbsp;
                                </td>
                            </tr>
                        </table>
                        <br/><br/>
                        <form class="form-horizontal" method="post" action="<?php echo base_url() . "index.php/APCancellation/SAveCOAPStep3_2"; ?>">                        
                            <?php $dist_code=$_GET['dist_code'];
                        $subdiv_code=$_GET['subdiv_code'];
                        $cir_code=$_GET['cir_code'];
                        $lot_no=$_GET['lot_no'];
                        $vill_townprt_code=$_GET['vill_townprt_code'];
                        $year_no=$_GET['year_no'];
                        $petition_no=$_GET['petition_no'];
                        $case_no=$_GET['case_no'];
                        $mouza_pargona_code=$_GET['mouza_pargona_code'];
                        $submission_date=$_GET['submission_date'];
                        ?>                        
                        <input type="hidden" name="dist_code" value="<?php echo $dist_code;?>"/>
                        <input type="hidden" name="subdiv_code" value="<?php echo $subdiv_code;?>"/>
                        <input type="hidden" name="cir_code" value="<?php echo $cir_code;?>"/>
                        <input type="hidden" name="lot_no" value="<?php echo $lot_no;?>"/>
                        <input type="hidden" name="vill_townprt_code" value="<?php echo $vill_townprt_code;?>"/>
                        <input type="hidden" name="year_no" value="<?php echo $year_no;?>"/>
                        <input type="hidden" name="petition_no" value="<?php echo $petition_no; ?>"/>
                        <input type="hidden" name="case_no" value="<?php echo $case_no;?>"/>
                        <input type="hidden" name="mouza_pargona_code" value="<?php echo $mouza_pargona_code;?>"/>
                        <input type="hidden" name="submission_date" value="<?php echo $submission_date;?>"/>                       
                        <table class="table table-striped table-bordered" width="100%">
                            <tr class="danger">
                                <td>
                                    <input type="checkbox" name="" value="" id="disabledInput" checked="checked"  disabled/> Non Renewal Proceeding
                                </td>
                                <td>
                                     <input type="checkbox" name="" value="" id="disabledInput" checked="checked" disabled/> LM Report
                                </td>
                                <td>
                                     <input type="checkbox" name="" value="" checked="checked" disabled/> SK Report
                                </td>
                                <td>
                                     <input type="checkbox" name="" value="" id="disabledInput" checked="checked" disabled/> Show Cause Notice
                                </td>
                                <td>
                                     <input type="checkbox" name="" value="" disabled/> DC Approval
                                </td>
                                <td>
                                     <input type="checkbox" name="co_recommendation" value="1"/> CO Recommendation
                                </td>
                            </tr>
                            <tr>
                                <td colspan="6" class="text-center">
                                    <input type="submit" name="FormSubmit" value="UPDATE" class="btn btn-primary"/>
                                </td>
                            </tr>
                        </table>
                        </form>
                        <br/><br/>
                        <a href="<?php echo base_url();?>index.php/home/index" class="btn btn-sm btn-danger">
                                    <i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

