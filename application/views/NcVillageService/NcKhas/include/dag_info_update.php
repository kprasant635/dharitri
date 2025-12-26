<div class="modal modal-lg" role="dialog" id="dagDetailsUpdateModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content modal-lg">
            <div class="modal-header text-center" style="background-color: #4FC3F7; color: white">
                <h5 class="modal-title text-center" id="exampleModalLongTitle" style="line-height: 1!important;">
                    Update Dag Related Information
                </h5>
            </div>
            <div class="modal-body" align="center" style="margin-bottom: 20px">
                <input type="hidden" id="select_application_no_update">
                <input type="hidden" id="updated_encroach_id">
                <input type="hidden" id="select_dist_code_update">
                <input type="hidden" id="select_subdiv_code_update">
                <input type="hidden" id="select_cir_code_update">
                <input type="hidden" id="select_mouza_pargona_code_update">
                <input type="hidden" id="select_lot_no_update">
                <input type="hidden" id="select_vill_townprt_code_update">

                <div class="row justify-content-center">
                    <div class="row" style="margin-bottom: 15px;  margin-top: 10px">
                        <div class="col-lg-12 col-md-12 col-sm-12" id="select_location_update" ></div>
                    </div>
                    <hr>
                    <div class="row" style="padding-bottom: 10px; margin-top: 15px">
                        <div align="left" class="col-lg-6 col-md-6 col-sm-6" style="width: 50%">Select Dag Number</div>
                        <div class="col-lg-6 col-md-6 col-sm-6 form-group" style="width: 50%" id="select_dag_update">-</div>
                    </div>
                    <div class="row" style="padding-bottom: 10px">
                        <div align="left" class="col-lg-6 col-md-6 col-sm-6">Select Encroacher</div>
                        <div class="col-lg-6 col-md-6 col-sm-6" id="select_encroacher_update">-</div>
                    </div>
                    <div class="row" style="padding-bottom: 15px; margin-top: 15px">
                        <div align="left" class="col-lg-6 col-md-6 col-sm-6">Area in chitha</div>
                        <div class="col-lg-6 col-md-6 col-sm-6" align="left" id="select_chita_area_update" style="font-weight: bold"></div>
                    </div>
                    <div class="row" style="padding-bottom: 15px; margin-top: 10px">
                        <div align="left" class="col-lg-6 col-md-6 col-sm-6">Enter settlement Homestead area  </div>
                        <div class="col-lg-6 col-md-6 col-sm-6" id="select_area_update">-</div>
                    </div>
                    <div class="row" style="padding-bottom: 15px; margin-top: 10px">
                        <div align="left" class="col-lg-6 col-md-6 col-sm-6">Enter settlement Agriculture area  </div>
                        <div class="col-lg-6 col-md-6 col-sm-6" id="select_area_agri_update">-</div>
                    </div>
                    <div class="row" style="padding-bottom: 15px; margin-top: 10px">
                        <div align="left" class="col-lg-6 col-md-6 col-sm-6">Enter road/river side reservation</div>
                        <div class="col-lg-6 col-md-6 col-sm-6" id="select_roadside_update">-</div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="padding-right: 25px">
                <button type="button" class="rezaButt buttInfo" id="dagDetailsModalUpdate">
                    <i class="fa fa-check-square"></i> Update
                </button>
                <button type="button" class="rezaButt buttDanger" id="dagDetailsUpdateModalNo">
                    <i class="fa fa-times-circle"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>
