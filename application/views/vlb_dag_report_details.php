<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12">
         
            <div class="">
                <div class="panel-heading">
                    <h3 class="panel-title">Dag details of &nbsp;&nbsp;&nbsp; Mouza: <kbd><?=$mouza_name;?></kbd> &nbsp;&nbsp;&nbsp; Lot : <kbd><?=$lot_name;?></kbd> &nbsp;&nbsp;&nbsp; Village : <kbd><?=$vill_name?></kbd><h3>
                </div>


                <div class="" >
                        <div style="max-height: 350px;overflow-x: scroll;">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr style="background-color:#f2ff2f">
                                    <th>Sl no</th>
                                    <th>Dag No.</th>
                                    <th>Dag area</th>
                                    <th>Nature of Reservation</th>
                                    <th>Whether Encroached (Yes/No)</th>
                                    <th>No.of Encroacher</th>
                                    <th>Status</th>
                                </tr>
                                <?php $cnt = 1; foreach ($dags as $key => $value) {?>
                                   <tr>
                                       <td class="bg bg-warning" ><?=$cnt++;?></td>
                                       <td><?=$value->dag_no;?></td>
                                       <td>(বি : <?=$value->en_area_b;?> ক : <?=$value->en_area_k;?> লে : <?=$value->en_area_lc;?>)</td>
                                       <td><?php foreach (json_decode(LB_NATURE_OF_RESERVATION) as $nor):?>
                                       <?php if($value->nature_of_reservation == $nor->CODE){ ?>
                                        <?=$nor->NAME?>
                                       <?php } ?>
                                        
                                        <?php endforeach;?></td>
                                       <td><?=$value->whether_encroached == 'Y' ? "Yes" : ($value->whether_encroached == 'I' ? "Institution" : "No")?></td>
                                       <td><?=$value->no_of_encroacher?></td>
                                       <td><span class="badge badge-danger"><?=$value->status == 'P' ? "Pending with CO" : ($value->status == 'C' ? "Pending With DC" : ($value->status == 'A' ? "Approved" : "N/A"))?></span></td>
                                   </tr>
                                <?php } ?>
                            </table>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

