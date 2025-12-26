<div class="container-fluid form-top login" id="show-prop-report">
    <div class="row" style="margin-top:-6px;">
        <div class="col-lg-12 ">
            <div class="bg-secondary text-white p-2 h4 text-center font-weight-bold shadow-lg">                
                MANUALLY PUSH SIGNED ASSETS IN BULK
            </div>
            <div class="bg-dark text-white p-2 h6 text-center font-weight-bold shadow-lg" style="margin-top:-10px;">                
                DISTRICT:<?=$this->utilityclass->getDistrictName($this->session->userdata('dist_code'))?>, 
                SUB-DIVISION:<?=$this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'))?>, 
                CIRCLE:<?=$this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'))?>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-info panel-form">
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <label class="mx-3">
                                    Asset limit per transaction: ROR = <?= MAX_CHAIN_CREATE ?>, MAP = <?= MAX_CHAIN_UPDATE ?>
                                </label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12 text-center">
                                <div class="panel-body">
                                    <button id="get_dag_btn" class="form-group mb-2 btn btn-sm btn-primary font-weight-bold" onclick="return pushRorData();"><i class="fa fa-arrow-circle-right"></i> ROR Push</button>
                                    <button id="get_dag_btn" class="form-group mb-2 btn btn-sm btn-warning font-weight-bold" onclick="return pushMapData();"><i class="fa fa-arrow-circle-right"></i> MAP Push</button>                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
</script>
<style>
    .disabled {
        cursor: not-allowed;
    }
</style>

<script>
    function rePushToPropChain(case_no){        
        //var win = window.open(baseUrl+'PropChainReport/sendPropChain?case_no='+case_no, '_blank');
        var win = window.open(baseUrl+'PropChainReport/sendPropChain/'+case_no, '_blank');
        if (win) {
            //Browser has allowed it to be opened
            win.focus();
        } else {
            //Browser has blocked it
            alert('Please allow popups for this url');
        }
    }
</script>