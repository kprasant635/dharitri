<!--<?php // KKB0007: Improvement of Land Share Details 
    ?> -->
<!-- land share details view modal  at CO Side-->
<div class="modal" id="land_share_view_details_modal" role="dialog">
    <form method="post" id="land_share_view_details_form_co">
        <input type="hidden" value="" id="lb_view_form_dag_no" name="lb_view_form_dag_no">
        <input type="hidden" value="" id="lb_view_form_vill_code" name="lb_view_form_vill_code">
        <div class="modal-dialog" style="max-width:90%">
            <div class="modal-content">
                <div class="modal-header text-white text-bold text-center bg-primary">
                    <h5 class="modal-title w-100">
                        <?php echo $this->lang->line('mouza') ?> :
                        <span class="text-white" id="lb_view_mouza_name_co_header"></span>,
                        <?php echo $this->lang->line('vill_town') ?> :
                        <span class="text-white" id="lb_view_village_name_co_header"></span>,
                        <?php echo $this->lang->line('land_bank_table_header_dag_no'); ?> Dag No:
                        <span class="text-white" id="lb_view_dag_no_co_header"></span>
                        <p>[
                            <span>Total Dag Area:</span>
                            <span class="text-white" id="lb_co_view_dag_area_b_header"></span> Bigha,
                            <span class="text-white" id="lb_co_view_dag_area_k_header"></span> Katha,
                            <span class="text-white" id="lb_co_view_dag_area_lc_header"></span> Lessa
                            ]
                        </p>
                    </h5>
                </div>
                <div class="modal-body">
                    <div id="land_bank_view_form_area_insert_div" style="display: none">

                    </div>

                    <div class="form-group mb-5 col-lg-12 col-sm-12 col-md-12">
                        <div class="text-center bg-secondary text-white p-1">
                            <h5 class="mb-0">Land Area Share Indivisual details</h5>
                        </div>
                        <div class="table table-responsive">
                            <table class="table table-striped table-bordered" id="indivisual_view_details_table">
                                <thead>
                                    <tr>
                                        <td width="15%">Pattadar Name</td>
                                        <td width="15%">Pattadar Name in English</td>
                                        <td width="15%">Father's Name</td>
                                        <td width="15%">Father's Name in English</td>
                                        <td width="8%">Date Of Birth</td>
                                        <td width="10%">Gender</td>
                                        <td width="3%">Area(Bigha)</td>
                                        <td width="10%">Area(Katha)</td>
                                        <td width="10%">Area(Lessa)</td>
                                    </tr>
                                </thead>
                                <tbody id="TextBoxContainerViewForm">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row" align="center" style="padding:10px;">
                    <div class="col-lg-12" align="center">
                        <button type="button" class="btn btn-sm btn-danger" onclick="land_share_view_details_modal_close()">
                            <i class="glyphicon glyphicon-remove-sign"></i>
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>