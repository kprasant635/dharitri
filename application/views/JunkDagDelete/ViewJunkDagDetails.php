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
                <h2 style="text-align: center;"> Details Of the Dag No <?php echo $basic_details->dag_no ?> </h2>
            </div>


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
                                <td><?php echo $location['dist_code']; ?></td>
                                <td>Subdivision</td>
                                <td><?php echo $location['subdiv_code']; ?></td>
                                <td>Circle</td>
                                <td><?php echo $location['cir_code']; ?></td>
                            </tr>
                            <tr>
                                <td>Mouza</td>
                                <td><?php echo $location['mouza_pargona_code']; ?></td>
                                <td>Lot No</td>
                                <td><?php echo $location['lot_no']; ?></td>
                                <td>Village / Town</td>
                                <td><?php echo $location['vill_townprt_code']; ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

                <div class="col-lg-6 m-auto pl-0">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <h3 class="panel-title">
                                Basic Dag details
                            </h3>
                        </div>
                        <div class="panel-body" style='height:380px; overflow-y:auto; overflow-x:hidden;'>
                            <table class="table table-bordered text-bold">
                                <tr>
                                    <td width="50%" colspan="2">
                                        <label class="control-label"><?php echo $this->lang->line('dag_no'); ?>
                                        </label>
                                    </td>
                                    <td width="50%" colspan="2"><?php echo $basic_details->dag_no; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="2">
                                        <label for="inputEmail3"
                                               class="control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                    </td>
                                    <td width="50%" colspan="2"><?php echo $basic_details->patta_no; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="2">
                                        <label class="control-label"><?php echo $this->lang->line('patta_type'); ?>
                                        </label>
                                    </td>
                                    <td width="50%" colspan="2"><?php echo $location['patta_name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="2">
                                        <label for="inputEmail3"
                                               class="control-label"><?php echo $this->lang->line('land_class'); ?></label>
                                    </td>
                                    <td width="50%" colspan="2"><?php echo $location['land_class_name']; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="2">
                                        <label class="control-label">Revenue
                                        </label>
                                    </td>
                                    <td width="50%" colspan="2"><?php echo round($basic_details->dag_revenue, 2); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50%" colspan="2">
                                        <label for="inputEmail3"
                                               class="control-label"><?php echo $this->lang->line('local_tax'); ?></label>
                                    </td>
                                    <td width="50%" colspan="2"><?php echo round($basic_details->dag_local_tax, 2); ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="25%">Area
                                    </td>
                                    <td width="25%" class="red"><?php echo $basic_details->dag_area_b; ?> বিঘা
                                    </td>
                                    <td width="25%" class="red"><?php echo $basic_details->dag_area_k; ?> কঠা
                                    </td>
                                    <td width="25%" class="red"><?php echo round($basic_details->dag_area_lc, 2); ?> লেছা
                                    </td>
                                </tr>
                            </table>
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
                        <div class="panel-body" style='height:380px; overflow-y:auto; overflow-x:hidden;'>
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
        </div>

        <div class="col-lg-10 m-auto">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Order details associated with dag <kbd> <?php echo $basic_details->dag_no ?> </kbd>
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


        <div class="col-lg-10 m-auto">
            <form class='form-horizontal' method="post" id="delete_dag" enctype="multipart/form-data">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            LM Note
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label required">Upload File</label>
                            <div class="col-sm-9">
                                <input type="file" name="file_upload" class="form-control" readonly required>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label required">LM Remark</label>
                            <div class="col-sm-9">
                                <?php $lm_name = $this->utilityclass->getDefinedMondalsName($basic_details->dist_code,
                                    $basic_details->subdiv_code,$basic_details->cir_code,
                                    $basic_details->mouza_pargona_code,
                                    $basic_details->lot_no,$this->session->userdata('user_code'))->lm_name; ?>
                            <textarea name="lm_note" class="form-control" placeholder="Enter LM Remark"
                                      required>হাতৰ চিঠাৰ তথ্যৰ ভিতিত উক্ত দাগটো চিঠাৰ পৰা আতৰাই দিব লাগে।  চক্ৰ বিষয়াৰ অনুমোদনৰ বাবে দিয়া হল ৷ লাঃ মঃ <?php echo $lm_name; ?></textarea>
                                     <div class="red">
                                        <b><strong>This process will delete the dag completely and cannot be recovered. So, do it carefully.</strong></b>
                                    </div>
                            </div>
                        </div>
                        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
                        <div class='form-group'>
                            <div class="col-lg-12 center">
                                <input type='hidden' value='<?= $basic_details->dist_code ?>' name='dist_code'
                                       required/>
                                <input type='hidden' value='<?= $basic_details->subdiv_code ?>' name='subdiv_code'
                                       required/>
                                <input type='hidden' value='<?= $basic_details->cir_code ?>' name='cir_code' required/>
                                <input type='hidden' value='<?= $basic_details->mouza_pargona_code ?>'
                                       name='mouza_pargona_code' required/>
                                <input type='hidden' value='<?= $basic_details->lot_no ?>' name='lot_no' required/>
                                <input type='hidden' value='<?= $basic_details->vill_townprt_code ?>'
                                       name='vill_townprt_code' required/>
                                <input type='hidden' value='<?= $basic_details->dag_no ?>' name='dag_no' required/>
                                <input type='hidden' value='<?= $basic_details->patta_no ?>' name='patta_no' required/>
                                <input type='hidden' value='<?= $basic_details->patta_type_code ?>'
                                       name='patta_type_code' required/>
                                <input type="hidden" name="land_class" value="<?php echo $basic_details->land_class_code; ?>" readonly>
                                <input type="hidden" name="land_rev" value="<?php echo round($basic_details->dag_revenue, 2); ?>" readonly>
                                <input type="hidden" name="loc_tax" value="<?php echo round($basic_details->dag_local_tax, 2); ?>" readonly>
                                <input type="hidden" name="dag_area_b"  value="<?php echo $basic_details->dag_area_b; ?>" readonly>
                                <input type="hidden" name="dag_area_k" value="<?php echo $basic_details->dag_area_k; ?>" readonly>
                                <input type="hidden" name="dag_area_lc" value="<?php echo round($basic_details->dag_area_lc, 2); ?>" readonly>
                                <input type="hidden" name="dag_area_g" value="<?php echo $basic_details->dag_area_g; ?>" readonly>
                                <input type="hidden" name="dag_area_kr"  value="<?php echo $basic_details->dag_area_kr; ?>" readonly>
                                <div id="error_u_message"></div>
                                <button type='submit' class='btn btn-primary' id="submit_btn"><i class="fa fa-save"></i> Submit</button>
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
            var formdata = new FormData(this);
            $.ajax({
                url: baseurl + "JunkDagDelete/deleteDagSubmitByLM/",
                type: 'POST',
                data: formdata,
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                beforeSend: function () {
                    $('.loader').addClass('trans');
                    $('.loader').removeClass('hide');
                    $('#submit_btn').hide();
                },
                success: function (data) {
                    $('.loader').addClass('hide');
                    $('.loader').removeClass('trans');
                    if (data.validation_suceess === true && data.insert === true) {
                        $('#error_u_message').html('');
                        $('#error_u_message')
                            .html('<div class="green bold"> Registered Successfully. Case No: ' + data.case_no +
                                '. Forwarded to Circle Officer. ' +
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
                    alert('Error [JDD10101]: Could not Complete your Request ..!');
                }
            });

        });
    });
</script>