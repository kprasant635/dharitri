<style>
    :root {
        --loader-size: 50px;
        --dot-size: 6px;
        --loader-bg: #e1e6e2;
        --dot-color: black;
    }

    .loader {
        position: fixed;
        display: flex;
        justify-content: center;
        align-items: center;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: rgba(1, 18, 64, 0.2);
        transition: opacity 0.3s ease-out, top 0.3s step-end;
        z-index: 99;
    }

    .loader.trans {
        transition: opacity 0.5s ease-out, top 0.5s step-start;
        opacity: 1;
        top: 0;
    }

    .loader .loaderview {
        position: center;
        display: flex;
        justify-content: center;
        align-items: center;
        width: auto;
        height: auto;
        padding: 10px 40px;
        border-radius: 5px;
        top: 0;
        left: 0;
        z-index: 100;
        flex-flow: column;
        background-color: var(--loader-bg);
    }

    h1 {
        color: var(--dot-color);
        font-size: 1.2em;
        animation: fading 1.5s ease-in-out infinite;
        font-family: "Comfortaa", cursive;
    }

    .Loader-box {
        margin: 20px;
        flex: 0 0 auto;
        height: var(--loader-size);
        width: var(--loader-size);
    }

    .box {
        position: absolute;
        height: var(--loader-size);
        width: var(--loader-size);
        animation: rotating 4s ease-in infinite;
        animation-delay: calc(var(--id) * 0.5s);
    }

    .dot {
        background-color: var(--dot-color);
        height: var(--dot-size);
        width: var(--dot-size);
        border-radius: 100%;
    }

    @keyframes rotating {
        0% {
            opacity: 0;
            transform: rotateZ(0);
        }
        25% {
            opacity: 100%;
            transform: rotateZ(160deg);
        }

        75% {
            opacity: 200%;
            opacity: 100;
        }
        80% {
            transform: rotateZ(300deg);
            opacity: 100;
        }
        100% {
            transform: rotateZ(350deg);
            opacity: 0;
        }
    }

    @keyframes fading {
        0% {
            opacity: 40%;
        }
        50% {
            opacity: 90%;
        }
        100% {
            opacity: 40%;
        }
    }

</style>
<div class="hide loader" id="loader">
    <div class="loaderview">
        <h1>Don't refresh the page until the process is completed...</h1>
        <div class="Loader-box">
            <div class="box" style="--id:1">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:2">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:3">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:4">
                <div class="dot"></div>
            </div>
            <div class="box" style="--id:5">
                <div class="dot"></div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 m-auto">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Junk Dag Deletion. Case No.: <?= $Pcases->case_no; ?> </h2>
                </div>


            <div class="col-lg-12 m-auto px-0">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Location Details
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-striped table-bordered text-bold">
                            <tbody>
                            <tr>
                                <td>District</td>
                                <td><?php echo $location['dist']; ?></td>
                                <td>Subdivision</td>
                                <td><?php echo $location['sub']; ?></td>
                                <td>Circle</td>
                                <td><?php echo $location['cir']; ?></td>
                            </tr>
                            <tr>
                                <td>Mouza</td>
                                <td><?php echo $location['mouza']; ?></td>
                                <td>Lot No</td>
                                <td><?php echo $location['lot']; ?></td>
                                <td>Village / Town</td>
                                <td><?php echo $location['vill']; ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



            <div class="col-lg-6 m-auto pl-0">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Dag Details
                            </h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered text-bold">
                                <tr>
                                    <td width="50%" colspan="2">
                                        <label class="control-label"><?php echo $this->lang->line('dag_no'); ?>
                                        </label>
                                    </td>
                                    <td width="50%" colspan="2"><?php echo $Pcases->dag_no; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="2">
                                        <label for="inputEmail3"
                                               class="control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                    </td>
                                    <td width="50%" colspan="2"><?php echo $Pcases->patta_no; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="2">
                                        <label class="control-label"><?php echo $this->lang->line('patta_type'); ?>
                                        </label>
                                    </td>
                                    <td width="50%" colspan="2"><?php echo $this->utilityclass->getPattaName($Pcases->patta_type_code); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="2">
                                        <label for="inputEmail3"
                                               class="control-label"><?php echo $this->lang->line('land_class'); ?></label>
                                    </td>
                                    <td width="50%" colspan="2"><?php echo $this->utilityclass->getLandClassCode($Pcases->present_land_class); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="2">
                                        <label class="control-label">Revenue
                                        </label>
                                    </td>
                                    <td width="50%" colspan="2"><?php echo round($Pcases->present_land_revenue, 2); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="2">
                                        <label for="inputEmail3"
                                               class="control-label"><?php echo $this->lang->line('local_tax'); ?></label>
                                    </td>
                                    <td width="50%" colspan="2"><?php echo round($Pcases->present_land_localtax, 2); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="25%">Area
                                    </td>
                                    <td width="25%" class="red"><?php echo $Pcases->dag_area_b; ?> বিঘা
                                    </td>
                                    <td width="25%" class="red"><?php echo $Pcases->dag_area_k; ?> কঠা
                                    </td>
                                    <td width="25%" class="red"><?php echo round($Pcases->dag_area_lc, 2); ?> লেছা
                                    </td>
                                </tr>
                            </table>
                            <hr class="border" style="border-bottom: 2px solid #000;">
                            <h2><mark>Lot Mondal's Note</mark></h2>
                            <?php echo $Pcases->lm_note; ?>
                            <hr class="border" style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-lg-12">
                                    <?php
                                    if($Pcases->file_upload){
                                        ?>
                                        <a href="javascript:void(0);" data-path="<?php echo search_file_location('JDDDocs/'. $Pcases->file_upload); ?>" class="preview__file btn btn-info">
                                            <i class="fa fa-paperclip"></i>&nbsp;Verify Uploaded Documents
                                        </a>
                                        <?php
                                    } ?>

                                    <a href="<?php echo base_url() . "index.php/LegacyDataUpdation/generateChitha?dist_code=".$details->dist_code . "&subdiv_code=" . $details->subdiv_code . "&cir_code=" . $details->cir_code . "&mouza_pargona_code=" . $details->mouza_pargona_code . "&lot_no=" . $details->lot_no . "&vill_townprt_code=" . $details->vill_townprt_code . "&dag_no=" . $details->dag_no . "&patta_no=" . $details->patta_no . "&patta_type=" .$details->patta_type_code; ?>" class="btn btn-info" target="_blank">
                                        <i class="fa fa-paperclip"></i>&nbsp;View Chitha
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            <div class="col-lg-6 pr-0">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Pattadar Details
                            </h3>
                        </div>
                        <div class="panel-body" style='height:500px; overflow-y:auto; overflow-x:hidden;'>
                            <p class='uni_text'>Dag No. showing column are the Present Pattadar(s) of that Dag.</p>
                            <table class='table table-stripped'>
                                <thead>
                                <tr>
                                    <td class="center">Dag</td>
                                    <td>Name</td>
                                    <td>Gurdian Name</td>
                                </tr>
                                </thead>
                                <?php if (isset($cp)) {
                                    foreach ($cp as $key => $val) {
                                        $dag = "-----";
                                        $class = "green";
                                        $status = "---------";
                                        $check = 'disabled';
                                        $active = "";
                                        if (isset($cdp)) {
                                            foreach ($cdp as $r) {
                                                if ($r->pdar_id == $val->pdar_id) {
                                                    $class = "red";
                                                    $dag = "<kbd>" . $r->dag_no . "</kbd>";
                                                    $check = "false checked";
                                                    $active = "<span class='small'>Transfer to Allocated Patta </span>";
                                                    if ($r->p_flag == '1') {
                                                        $class = $class;
                                                        //$status = "<strike class='red'>Strike Out</strike>";
                                                    } else {
                                                        $class = $class . ' green ';
                                                        //$status = "Un-Strike Out";
                                                    }
                                                }
                                            }
                                        }
                                        echo "<tr>";
                                        echo "<td class='center'>" . $dag . "</td>";
                                        echo "<td class='$class'>" . $val->pdar_name . "</td>";
                                        echo "<td class='$class'>" . $val->pdar_father . "</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>


            <div class="col-lg-12 m-auto px-0">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Order details associated with dag <kbd> <?php echo $Pcases->dag_no ?> </kbd>
                        </h3>
                    </div>
                    <div class="panel-body">
                        <?php if (isset($chitha_basic)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> CHITHA</td>
                                </tr>
                                <?php foreach ($chitha_basic as $row): ?>
                                    <tr>
                                        <td>Dag No: <?= $row->dag_no ?></td>
                                        <td>Bigha: <?php if (isset($row->dag_area_b)) {
                                                echo $row->dag_area_b;
                                            } ?></td>
                                        <td>Katha: <?php if (isset($row->dag_area_k)) {
                                                echo $row->dag_area_k;
                                            } ?></td>
                                        <td>Lessa: <?php if (isset($row->dag_area_lc)) {
                                                echo $row->dag_area_lc;
                                            } ?></td>
                                        <td>Ganda: <?php if (isset($row->dag_area_g)) {
                                                echo $row->dag_area_g;
                                            } ?></td>
                                        <td>Kranti: <?php if (isset($row->dag_area_kr)) {
                                                echo $row->dag_area_kr;
                                            } ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_rmk_ordbasic)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> OFFICE CASE</td>
                                </tr>
                                <?php foreach ($chitha_rmk_ordbasic as $row): ?>
                                    <tr>
                                        <td>Case No: <?= $row->ord_no ?></td>
                                        <td>Order Date: <?= $row->ord_date ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_col8_order)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> Field Case</td>
                                </tr>
                                <?php foreach ($chitha_col8_order as $row): ?>
                                    <tr>
                                        <td>Case No: <?= $row->case_no ?></td>
                                        <td>Co Order Date: <?= $row->co_ord_date ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_col8_inplace)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> Field Case (Inplace)</td>
                                </tr>
                                <?php foreach ($chitha_col8_inplace as $row): ?>
                                    <tr>
                                        <td>Name: <?= $row->inplace_of_name ?></td>
                                        <td>Cron No: <?= $row->col8order_cron_no ?></td>
                                        <td>Inplace Id: <?= $row->inplace_of_id ?></td>
                                        <td>Bigha: <?php if (isset($row->land_area_b)) {
                                                echo $row->land_area_b;
                                            } ?></td>
                                        <td>Katha: <?php if (isset($row->land_area_k)) {
                                                echo $row->land_area_k;
                                            } ?></td>
                                        <td>Lessa: <?php if (isset($row->land_area_lc)) {
                                                echo $row->land_area_lc;
                                            } ?></td>
                                        <td>Ganda: <?php if (isset($row->land_area_g)) {
                                                echo $row->land_area_g;
                                            } ?></td>
                                        <td>Kranti: <?php if (isset($row->land_area_kr)) {
                                                echo $row->land_area_kr;
                                            } ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_col8_occup)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> Field Case (Occup)</td>
                                </tr>
                                <?php foreach ($chitha_col8_occup as $row): ?>
                                    <tr>
                                        <td>Name: <?= $row->occupant_name ?></td>
                                        <td>Cron No: <?= $row->col8order_cron_no ?></td>
                                        <td>Inplace Id: <?= $row->occupant_id ?></td>
                                        <td>Bigha: <?php if (isset($row->land_area_b)) {
                                                echo $row->land_area_b;
                                            } ?></td>
                                        <td>Katha: <?php if (isset($row->land_area_k)) {
                                                echo $row->land_area_k;
                                            } ?></td>
                                        <td>Lessa: <?php if (isset($row->land_area_lc)) {
                                                echo $row->land_area_lc;
                                            } ?></td>
                                        <td>Ganda: <?php if (isset($row->land_area_g)) {
                                                echo $row->land_area_g;
                                            } ?></td>
                                        <td>Kranti: <?php if (isset($row->land_area_kr)) {
                                                echo $row->land_area_kr;
                                            } ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_rmk_allottee)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> ALLOTMENT (AC-PP)</td>
                                </tr>
                                <?php foreach ($chitha_rmk_allottee as $row): ?>
                                    <tr>
                                        <td>Order no: <?= $row->ord_no ?></td>
                                        <td>Order Date: <?= $row->ord_date ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_rmk_alongwith)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> OFFICE CASE (Alongwith)</td>
                                </tr>
                                <?php foreach ($chitha_rmk_alongwith as $row): ?>
                                    <tr>
                                        <td>Order no: <?= $row->ord_no ?></td>
                                        <td>Order Date: <?= $row->ord_date ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_rmk_convorder)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> OFFICE CASE (Conversion Order)</td>
                                </tr>
                                <?php foreach ($chitha_rmk_convorder as $row): ?>
                                    <tr>
                                        <td>Order Cron no: <?= $row->ord_cron_no ?></td>
                                        <td>Onbehalf Id: <?= $row->ord_onbehalf_id ?></td>
                                        <td>Name: <?= $row->ord_onbehalf_of ?></td>
                                        <td>Bigha: <?php if (isset($row->land_area_b)) {
                                                echo $row->land_area_b;
                                            } ?></td>
                                        <td>Katha: <?php if (isset($row->land_area_k)) {
                                                echo $row->land_area_k;
                                            } ?></td>
                                        <td>Lessa: <?php if (isset($row->land_area_lc)) {
                                                echo $row->land_area_lc;
                                            } ?></td>
                                        <td>Ganda: <?php if (isset($row->land_area_g)) {
                                                echo $row->land_area_g;
                                            } ?></td>
                                        <td>Kranti: <?php if (isset($row->land_area_kr)) {
                                                echo $row->land_area_kr;
                                            } ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_rmk_encro)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> OFFICE CASE (Encro)</td>
                                </tr>
                                <?php foreach ($chitha_rmk_encro as $row): ?>
                                    <tr>
                                        <td>Name: <?= $row->encro_name ?></td>
                                        <td>Guardian Name: <?= $row->encro_guardian ?></td>
                                        <td>Bigha: <?php if (isset($row->encro_land_b)) {
                                                echo $row->encro_land_b;
                                            } ?></td>
                                        <td>Katha: <?php if (isset($row->encro_land_k)) {
                                                echo $row->encro_land_k;
                                            } ?></td>
                                        <td>Lessa: <?php if (isset($row->encro_land_lc)) {
                                                echo $row->encro_land_lc;
                                            } ?></td>
                                        <td>Ganda: <?php if (isset($row->encro_land_g)) {
                                                echo $row->encro_land_g;
                                            } ?></td>
                                        <td>Kranti: <?php if (isset($row->encro_land_kr)) {
                                                echo $row->encro_land_kr;
                                            } ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_rmk_infavor_of)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> OFFICE CASE (Infavor)</td>
                                </tr>
                                <?php foreach ($chitha_rmk_infavor_of as $row): ?>
                                    <tr>
                                        <td>Order No: <?= $row->ord_no ?></td>
                                        <td>Order Date: <?= $row->ord_date ?></td>
                                        <td>Bigha: <?php if (isset($row->land_area_b)) {
                                                echo $row->land_area_b;
                                            } ?></td>
                                        <td>Katha: <?php if (isset($row->land_area_k)) {
                                                echo $row->land_area_k;
                                            } ?></td>
                                        <td>Lessa: <?php if (isset($row->land_area_lc)) {
                                                echo $row->land_area_lc;
                                            } ?></td>
                                        <td>Ganda: <?php if (isset($row->land_area_g)) {
                                                echo $row->land_area_g;
                                            } ?></td>
                                        <td>Kranti: <?php if (isset($row->land_area_kr)) {
                                                echo $row->land_area_kr;
                                            } ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_rmk_inplace_of)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> OFFICE CASE (Inplace)</td>
                                </tr>
                                <?php foreach ($chitha_rmk_inplace_of as $row): ?>
                                    <tr>
                                        <td>Order No: <?= $row->ord_no ?></td>
                                        <td>Order Date: <?= $row->ord_date ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_rmk_lmnote)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> OFFICE CASE (LM NOTE)</td>
                                </tr>
                                <?php foreach ($chitha_rmk_lmnote as $row): ?>
                                    <tr>
                                        <td>Cron No: <?= $row->lm_note_cron_no ?></td>
                                        <td>Hist No: <?= $row->rmk_type_hist_no ?></td>
                                        <td>LM Note No: <?= $row->lm_note_lno ?></td>
                                        <td>LM Note: <?= $row->lm_note ?></td>
                                        <td>Entry Date: <?= $row->date_entry ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_rmk_onbehalf)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> OFFICE CASE (ONBEHALF)</td>
                                </tr>
                                <?php foreach ($chitha_rmk_onbehalf as $row): ?>
                                    <tr>
                                        <td>Order No: <?= $row->ord_no ?></td>
                                        <td>Order Date: <?= $row->ord_date ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_rmk_other_opp_party)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> OFFICE CASE (OTHER OPP PARTY)</td>
                                </tr>
                                <?php foreach ($chitha_rmk_other_opp_party as $row): ?>
                                    <tr>
                                        <td>Order No: <?= $row->ord_no ?></td>
                                        <td>Order Date: <?= $row->ord_date ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>

                        <?php if (isset($chitha_rmk_reclassification)): ?>
                            <table class="table table-striped table-bordered text-bold">
                                <tbody>
                                <tr>
                                    <td colspan="100%" class="center red"> Reclassification</td>
                                </tr>
                                <?php foreach ($chitha_rmk_reclassification as $row): ?>
                                    <tr>
                                        <td>Proposal No: <?= $row->proposal_no ?></td>
                                        <td>Case No: <?= $row->case_no ?></td>
                                        <td>Bigha: <?php if (isset($row->dag_area_b)) {
                                                echo $row->dag_area_b;
                                            } ?></td>
                                        <td>Katha: <?php if (isset($row->dag_area_k)) {
                                                echo $row->dag_area_k;
                                            } ?></td>
                                        <td>Lessa: <?php if (isset($row->dag_area_lc)) {
                                                echo $row->dag_area_lc;
                                            } ?></td>
                                        <td>Ganda: <?php if (isset($row->dag_area_g)) {
                                                echo $row->dag_area_g;
                                            } ?></td>
                                        <td>Kranti: <?php if (isset($row->dag_area_kr)) {
                                                echo $row->dag_area_kr;
                                            } ?></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <form method="post" id="delete_dag">
            <div class="col-lg-12 px-0">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Co Order
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="col-sm-12 pb-3">
                            <label class="control-label col-sm-6" style="display: inline-block;">
                                <input type="radio" name="order_type" value="forward_to_dc" required> Forward to DC / ADC  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            </label>
                            <label class="control-label  col-sm-6" style="display: inline-block;">
                                <center><input type="radio" name="order_type" value="reject" required> Reject Case. ( Write Reason For Rejection Below )</center>
                            </label>
                        </div>
                        <hr class="mt-3">

                        <h2 style="line-height: 1.6"><mark>Circle Officer(s) Note On Action or Reason For Rejection</mark></h2>
                        <div class="form-group">
                            <div class="col-sm-12">
                                <?php
                                echo '<textarea name="final_report" class="form-control final bold" rows="5" required>লাঃ মঃ ৰ প্ৰতিবেদন চোৱা হল ৷  প্ৰতিবেদন অনুসৰি '.$Pcases->dag_no.' নং দাগটো চিঠাৰ পৰা সম্পুৰ্ণৰূপে মচি দিব পাৰি ৷ - '.$location['co_name'] . ", চক্র বিষয়া, " . $location['cir'].'। </textarea>';
                                ?>
                                <textarea name="reject_report" class="form-control reject" rows="5">তথ্য নাই | - <?php echo $location['co_name'] . ", "; ?><?php echo "চক্র বিষয়া, " . $location['cir']; ?></textarea>
                                <input type="hidden" class="form-control" name='case_no' value="<?php echo $Pcases->case_no; ?>" >
                                <input type="hidden" class="form-control" name='proposal_no' value="<?php echo $Pcases->proposal_no; ?>" >
                            </div>
                            <hr>

                            <div class="col-lg-12" id="dc_block">
                                <label class="rasid col-sm-12">
                                    Note : Please Select the Forwarding Officer (Deputy Commissioner / Assistant Deputy Commissioner)
                                </label>
                                <center>
                                    <label class="rasid btn">Please Select DC/ADC &nbsp;&nbsp;</label>
                                    <label class="btn btn-success">
                                        <select class="form-control" name='dc_code' id="dc_code" required>
                                            <?php
                                            echo"<option disabled selected> -- Select --</option>";
                                            foreach ($dc_adc as $dcadc) {
                                                $user_desig_code = $dcadc->user_desig_code;
                                                $username = $dcadc->username . " ( " . $user_desig_code . " )";
                                                $user_code = $dcadc->user_code;
                                                echo"<option value='$user_code'>$username</option>";
                                            }
                                            ?>
                                        </select>
                                    </label>
                                </center>
                                <br>
                            </div>
                            <div class="col-lg-12" id="co_block">
                                <label class="col-sm-12">
                                    <input type="checkbox" name="myCheck" id="myCheck" onclick="myFunction()" required>   স্বীকাৰোক্তিঃ উল্লেখিত তথ্য সমূহ মোৰ তত্বাৱধানত সংশোধন কৰা হৈছে ৷ তথ্য সমূহৰ সত্যতা প্ৰমাণ নহলে মই দায়ী হম ৷
                                </label>
                            </div>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <div id="error_u_message"></div>
                        <div class="form-group">
                            <center>
                                <div class="col-lg-12" id="submit_btn">
                                    <button type="submit" class="btn btn-success" id="change_text1" ><i class='fa fa-check'></i>&nbsp;Submit To Forward Report</button>
                                    <button type="submit" class="btn btn-danger m-2" id="reject_text1" ><i class='fa fa-check'></i>&nbsp; Reject Case
                                    </button>
                                </div>
                            </center>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>


<script>
    $(function () {
        $("#delete_dag").submit(function (e) {
            e.preventDefault();
            if (!confirm('Are you sure want to submit?')) {
                return;
            }
            $.ajax({
                url: baseurl + "JunkDagDelete/SaveCoProcess/",
                type: 'POST',
                data: $('#delete_dag').serialize(),
                dataType: 'json',
                beforeSend: function () {
                    $('.loader').addClass('trans');
                    $('.loader').removeClass('hide');
                    $('#submit_btn').hide();
                },
                success: function (data) {
                    $('.loader').addClass('hide');
                    $('.loader').removeClass('trans');
                    if (data.validation_suceess === true && data.update === true) {
                        $('#error_u_message').html('');
                        $('#error_u_message')
                            .html('<div class="green bold center">' + data.msg +
                                '<br><br>'+
                                '<a href="'+baseurl +'home/index"> <button type="button" class="btn btn-primary">' +
                                '<i class="fa fa-home"></i> Back to Dashboard</button></a>'+
                                '</div>');
                        window.location.href = baseurl + "home/index";
                        return;
                    }
                    else if (data.error != null) {
                        $('#submit_btn').show();
                        $('#error_u_message').html('');
                        var error_message = '';
                        $.each(data.error, function (index, value) {
                            error_message += '<li>' + value['message'] + '</li>'
                        });
                        $('#error_u_message')
                            .html('<div class="bg-gradient-danger p-2 rounded">' + error_message +
                                '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');
                        return;
                    }
                },
                error: function (jqXHR, exception) {
                    $('#submit_btn').show();
                    $('.loader').addClass('hide');
                    alert('Error [JDD10102]: Could not Complete your Request ..!');
                }
            });

        });
    });
</script>

<script type="text/javascript">
    $("input[name='order_type']").prop('checked', false);
    $("#myCheck").prop('checked', false);
    $('#dc_block').hide();
    $('#co_block').hide();
    $('.forward').hide();
    $('.reject').hide();
    $("#reject_text").attr('disabled', true);
    $("input[name='order_type']").click(function() {
        $("#myCheck").prop('checked', false);
        console.log("value"+$(this).val());
        if ($(this).val()=='forward_to_dc'){
            if (confirm('Are you sure you want to forward it to DC/ADC (S) ?')) {
                $('#dc_block').show();
                $('#co_block').show();
                $('.forward').show();
                $('.final').show();
                $('.reject').hide();
                $('#change_text1').innerHTML = "Submit To Forward Report";
                $("#change_text1").attr('disabled', true);
                $("#reject_text1").attr('disabled', true);
                $("#reject_text").attr('disabled', true);
                console.log("forward complete");
            }
            else
            {
                $("input[name='order_type']").prop('checked', false);
            }
        } else if ($(this).val()=='reject'){
            if (confirm('Are you sure you want to Reject Case ?')) {
                $('#dc_block').hide();
                $('#co_block').hide();
                $('.forward').hide();
                $('.final').hide();
                $('.reject').show();
                $('#change_text1').innerHTML = "Submit To Forward Report";
                $("#change_text1").attr('disabled', true);
                $('#reject_text1').removeAttr('disabled', false);
                $('#reject_text').removeAttr('disabled', false);
                console.log("reject complete");
            }
            else
            {
                $("input[name='order_type']").prop('checked', false);
            }
        }
    });

    $("#change_text1").attr('disabled', true);
    $("#reject_text1").attr('disabled', true);

    function myFunction() {
        var checkBox = document.getElementById("myCheck");
        if (checkBox.checked == true){
            $('#change_text1').removeAttr('disabled', false);
        } else {
            $('#change_text1').attr('disabled', true);
        }
    }
</script>



