<style>
    .unicode label, tr {
        font-size: 14px !important;
    }
</style>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-12">
                <div class="well well-sm mis_report">
                    <h2 style="text-align: center;">
                        Pending Updation / Modification of Chitha & Jamabandi Pattadar
                    </h2>
                </div>
            </div>
            <div class="col-lg-12">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">Report</h3>
                    </div>
                    <div class="panel-body">
                        <form method="post">
                            <div class="input-group">
                                <input type="text" name="searchKeyword" class="form-control col-sm-6 pull-right" placeholder="Search by patta no " value="<?php echo $searchKeyword; ?>">
                                <div class="input-group-append">
                                    <input type="submit" name="submitSearch" class="btn btn-info" value="Search">
                                    <input type="submit" name="submitSearchReset" class="btn btn-danger" value="Reset">
                                </div>
                            </div>
                        </form>
                        <table class='table table-striped table-bordered tablesorter  pageshowpage unicode' id='example' width="100%">
                            <thead>
                            <th class="center" width="10%"><label class="control-label">Mouza</label></th>
                            <th class="center"><label class="control-label">Lot No</label></th>
                            <th class="center"><label class="control-label">Village</label></th>
                            <th class="center"><label class="control-label">Patta Details</label></th>
                            <th class="center"><label class="control-label"><mark style="background-color: #efff00;">Modification Type</mark></label></th>
                            <th class="center"><label class="control-label">Name</label></th>
                            <th class="center"><label class="control-label">Date</label></th>
                            <th class="center"><label class="control-label">Status</label></th>
                            </thead>
                            <?php
                            //var_dump($cases);
                            foreach ($basic as $case):
                                ?>
                                <tr>
                                    <td class="center">
                                        <?php echo $mouza_pargona_code_name = $this->utilityclass->getMouzaName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code); ?>
                                    </td>
                                    <td>
                                        <?php echo $lot_no_name = $this->utilityclass->getLotName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no); ?>
                                    </td>
                                    <td>
                                        <?php echo $vill_townprt_code_name = $this->utilityclass->getVillageName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->vill_townprt_code); ?>
                                    </td>
                                    <td><?= $this->utilityclass->getPattaName($case->patta_type_code); ?>
                                        <?php echo  "<span class='badge badge-primary'> Patta No : " . $case->patta_no . "</span>";?>
                                        <?php
                                        $lm = $this->utilityclass->getDefinedMondalsName($case->dist_code, $case->subdiv_code, $case->cir_code, $case->mouza_pargona_code, $case->lot_no, $case->user_code);
                                        echo "<br><span class='red small'>Applied By LM: " . $lm->lm_name . "</span>";
                                        ?>  
                                        <input type='hidden' class='lm_comment<?php echo  $case->id ?>' value="<?= $case->lm_comment ?>" />
                                    </td>
                                    <td class="center">
                                        <?php
                                        $role = $case->action;
                                        switch ($role) {
                                            case 0:
                                                $val = "New Name Entry";
                                                $class = 'success';
                                                break;
                                            case 1:
                                                $val = "Remove Pattdar";
                                                $class = 'danger';
                                                break;
                                            case 2:
                                                $val = "Strike Pattdar Name";
                                                $class = 'danger';
                                                break;
                                            case 3:
                                                $val = "Un-Strike Pattdar Name";
                                                $class = 'warning';
                                                break;
                                            case 4:
                                                $val = "Modify Pattadar Name";
                                                $class = 'primary';
                                                break;
                                            default:
                                                $val = 'Wrong Entry';
                                                $class = 'info';
                                                break;
                                        }
                                        echo "<span class='badge badge-$class'>" . $val . "</span>";
                                        ?>
                                    </td>
                                    <td><?= $case->pdar_name . "<br>" . $case->pdar_father; ?>
                                        <br>
                                        <?php echo  "<span class='badge badge-primary'>" . $case->pdar_land_b . " B</span>" ?>
                                        <?php echo  "<span class='badge badge-primary'>" . $case->pdar_land_k . " K</span>" ?>
                                        <?php echo  "<span class='badge badge-primary'>" . $case->pdar_land_lc . " LC</span>" ?>
                                    </td>
                                    <td><span class="badge badge-danger"><i class='fa fa-calendar'></i> <?php echo date('M jS, Y', strtotime($case->entry_date)); ?></span></td>
                                    <td>
                                        <?php
                                        $user_desig_code = $this->session->userdata('user_desig_code');
                                        $attachment = search_file_location('AddPattadar/'. $case->attachment);
                                        if ($user_desig_code == 'CO') {
                                            $btn = 'hide';
                                            $link = $Status = '';
                                        } else {
                                            $link = 'hide';
                                            if ($case->status == 'F') {
                                                $Status = "Approved";
                                                $btn = "btn-success";
                                            } elseif ($case->status == 'R') {
                                                $Status = "Rejected";
                                                $btn = "btn-warning";
                                            } else {
                                                $Status = "Pending";
                                                $btn = "btn-danger";
                                            }
                                        }
                                        ?>
                                        <button class='btn btn-sm <?php echo  $btn ?>'><?= $Status ?></button>
                                        <!---<a href='<?php echo base_url(); ?>index.php/JamaEditEntry/updatedpattadar?id=<?= md5($case->id) ?>&sl=<?= $case->id ?>' class='btn btn-xs btn-primary <?php echo  $link ?>'><i class='fa fa-check'></i> Approve</a>---->
                                        <a href='#'  data-id="<?= $case->id ?>" class='btn btn-sm confirm btn-primary <?php echo  $link ?>'><i class='fa fa-check'></i> Approve</a>
                                        <a href='<?php echo base_url(); ?>index.php/JamaEditEntry/removepattadar?id=<?= md5($case->id) ?>&sl=<?= $case->id ?>' class='btn btn-sm btn-danger <?php echo  $link ?>'><i class='fa fa-times'></i> Reject</a><br>
                                        <?php if ($case->attachment) { ?>
                                            <a href="javascript:void(0)" data-path='<?= $attachment ?>' class='small preview__file' download >Download the attachment </a>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                        <div class="pagination_links"><?=$links?></div>
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

<div id="myModal" class="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content"> 
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">X</span></button>         
            </div>
            <div class="modal-head">
                <h6 style="text-align: center;" class="uni_text red">
                    Confirmation For Updation / Modification of Chitha & Jamabandi Pattadar
                </h6>
            </div>
            <div class="modal-body">
                <hr class="border" style="border-bottom: 2px solid #000;">
                <?php echo form_open('JamaEditEntry/updatedpattadar'); ?>
                <div class="row" style='padding:20px'>            
                    <div class='col-lg-12'>
                        LM Note :<textarea class='form-control' readonly rows=5 id='lm_comment'></textarea>
                    </div>
                    <hr>
                    <div class="col-lg-12">
                        CO's Order<textarea name="final_report" class="form-control" rows="5">লাঃ মঃৰ প্ৰতিবেদন চোৱা হল ৷  সংশোধনীৰ বাবে অনুমোদন দিয়া হল ৷ </textarea>
                    </div>
                    <div id='sendval'>
                        <input type="hidden" name="bookId" id="bookId" value=""/>
                    </div>
                    <div class="col-lg-12" id="co_block">
                        <label class="col-sm-12">
                            <input type="checkbox" disabled checked>
                            <span class='red'> স্বীকাৰোক্তিঃ উল্লেখিত তথ্য সমূহ মোৰ তত্বাৱধানত সংশোধন কৰা হৈছে ৷ তথ্য সমূহৰ সত্যতা প্ৰমাণ নহলে মই দায়ী হ'ম ৷   </span>
                        </label>
                    </div>
                    <hr class="border" style="border-bottom: 2px solid #000;">
                    <center><button type="submit" class="btn btn-md btn-primary" ><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button></center>
                </div>
                </form>
            </div>  
        </div>
    </div>
</div>
<!---------------->
<script>
    $(document).ready(function () {
        $('#example').DataTable();
        $('.close').on('click',function(){
            $('#myModal').modal('hide');
        });
        $('#example').on('click', '.confirm', function () {
            var id = $(this).data('id');
            $('#bookId').val($(this).data('id'));
            $('#lm_comment').val($('.lm_comment' + id).val());
            $('#myModal').modal('show');
        });
    });
</script>
