<style>
    .fa{
        font-size: initial !important;
    }
</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Comparison of Mismatched Dag No in Chitha & Jamabandi according to Patta Type</h2>
                </div>
            </div>
            
            <div class="col-lg-12">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            You Are Checking for Patta Type :<kbd><?= $location['patta'] ?></kbd> for the location below
                        </h3>
                    </div>
                    <div class="panel-body">
                        <form class='form-horizontal' method="post" action="">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">District</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control"  value="<?= $location['dist']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Subdivision</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?= $location['sub']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Circle</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?= $location['cir']; ?>" readonly>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-2 control-label">Mouza</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control"  value="<?= $location['mouza']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Lot No</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?= $location['lot']; ?>" readonly>
                                </div>
                                <label for="inputEmail3" class="col-sm-2 control-label">Village / Town</label>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control" value="<?= $location['village']; ?>" readonly>
                                </div>
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='cases' width="100%">
                            <thead>
                            <th><label class="control-label"><?php echo $this->lang->line('patta_no'); ?></label></th>
                            <th><label class="control-label">All Dags in Chitha</label></th>
                            <th class="center"><label class="control-label">All Dags in Jamabandi</label></th>
                            <th class="center"><label class="control-label">Mismatch</label></th>
                            </thead>
                            <?php
                                $i = 1;
                                $jdd = '';
                                $cdd = '';
                                foreach ($results as $k => $val) {
                                    ?>
                                    <tr>
                                        <td class="center"><?= "<span class=\"badge badge-info\">" . $val['patta_no'] . "</span>" ?></td>
                                        <td><?php
                                            $c = 0;
                                            $jdd = '';
                                            $nd = 0;
                                            $chithadag = [];
                                            foreach ($val['dag_in_chitha'] as $jd) {
                                                // dd($jd->dag_no);
                                                $chithadag[] = $jd->dag_no;
                                                $jdd = $jdd . " " . $jd->dag_no.", ";
                                                if ($c > 10) {
                                                    $jdd = $jdd . "<br>";
                                                    $c = 0;
                                                }
                                                $c++;
                                            }
                                            $nd=$nd+substr_count($jdd, ',');
                                            echo "<span class=\"badge badge-info\">".$nd." No of Dags : </span><small>". $jdd . "</small>";
                                            ?></td>
                                        <td>
                                            <?php
                                            $j = 0;
                                            $cdd = '';
                                            $jnd = 0;
                                            $jamadag = [];
                                            foreach ($val['dag_in_jama'] as $cd) {
                                                $jamadag[] = $cd->dag_no;
                                                $cdd = $cdd . " " . $cd->dag_no.", ";
                                                if ($j > 10) {
                                                    $cdd = $cdd . "<br>";
                                                    $j = 0;
                                                }
                                                $j++;
                                            }
                                            $jnd=$jnd+substr_count($cdd, ',');
                                            echo "<span class=\"badge badge-danger\">".$jnd." No of Dags : </span><small>" . $cdd . "</small>";
                                            ?>
                                        </td>
                                        <td><?php
                                            if (substr_count($cdd, ',') == substr_count($jdd, ',')) {
                                                $result = array_merge(array_diff($chithadag, $jamadag), array_diff($jamadag, $chithadag));
                                                echo "<i class=\"fa green fa-check\" aria-hidden=\"true\"></i>";
                                                foreach ($result as $r) {
                                                    echo "<span class=\"badge badge-primary\">" . $r . "</span>";
                                                }
                                            } else {
                                                if (substr_count($cdd, ',') and substr_count($jdd, ',')) {
                                                    $result = array_merge(array_diff($chithadag, $jamadag), array_diff($jamadag, $chithadag));
                                                    echo "<i class=\"fa red fa-times\" aria-hidden=\"true\"></i>&nbsp&nbsp";
                                                    foreach ($result as $r) {
                                                        echo "<span class=\"badge badge-danger\">" . $r . "</span>&nbsp&nbsp";
                                                    }
                                                   // echo "<a href='#'><i class=\"fa blue fa-edit\" aria-hidden=\"true\"></i></a>";
                                                    
                                                } else {
                                                    echo "<span class=\"badge badge-danger\">Check</span><br>";
                                                }
                                            }
                                            ?></td>
                                    </tr>
                                    <?php
                                    $i++;
                                }
                                ?>
                        </table>
                        <center>
                            <a href="<?php echo base_url(); ?>index.php/LegacyDataUpdation/Updation" class="btn btn-danger">
                                <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                            </a>
                        </center>
                    </div>
                </div>
            </div>
                
            
        </div>
    </div>
</div>