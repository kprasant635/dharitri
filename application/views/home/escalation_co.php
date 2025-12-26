<div class="modal escalation_co" id="escalation_co" data-keyboard="false" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title bg bg-warning" style="padding: 10px;">Important Information Regarding Escalation Matrix</h4>
          <button type="button" id='modal-close' class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <div class="modal-body">
          

          	<h6>Services use Escalation Matrix :</h6>
          	<ul>
          		<li> -->  Field Mutation Inheritance   <span style="color:#ff681d;font-style: italic;">(Auto registration cases will be listed in given link (Process->Field Mutation->Field Mutation Cases First Proceeding ))</span></li>
          		<li> -->  Office Mutation Inheritance  <span style="color:#ff681d;font-style: italic;">(Cases will landed in CO first proceeding as earliar was registered by Assistant)</span></li>
          		<li> -->  Field Mutation Deed          <span style="color:#ff681d;font-style: italic;">(Auto registration cases will be listed in given link (Process->Field Mutation->Field Mutation Cases First Proceeding ))</span></li>
          		<li> -->  Office Mutation Deed         <span style="color:#ff681d;font-style: italic;">(Cases will landed in CO first proceeding as earliar was registered by Assistant)</span></li>
          		<li> -->  Field Partition              <span style="color:#ff681d;font-style: italic;">(Auto registration cases will be listed in given link (Process->Field Partition->Field Partition Cases First Proceeding ))</span></li>
          		<li> -->  Office Partition             <span style="color:#ff681d;font-style: italic;">(Cases will landed in CO first proceeding as earliar was registered by Assistant) </span></li>
          		<li> -->  Reclassification              <span style="color:#ff681d;font-style: italic;">(Auto registration cases will be listed in given link (Process->Reclassification->First Report by LM))</span></li>
          		<li> -->  Name Correction              <span style="color:#ff681d;font-style: italic;">(Auto registration cases will be listed in given link (Process->Miscellaneous Cases->Write Report on Escalated Miscellaneous Cases))</span></li>
          		<li> -->  Name Cancellation <span style="color:#ff681d;font-style: italic;"> (Cases will landed in CO first proceeding as earliar was registered by Assistant)</span></li>
          		<li> -->  AC to PP</li>

          	</ul>
            <h6>Handling below Key Params : </h6>

            <ul>
            	<li> -->  Auto registration will be carried out from RTPS portal Once payment has been Done</li>
            	<li> -->  Escalation Information and Time line is Available on Each listed services for Dharitree Users</li>
            	<li> -->  Cases should be pass in the working timeline once failed, cases will be auto escalated to Upper Officers.LM----->CO
						AST---->CO
									CO---->DC
										ADC---->DC</li>
				<li> -->  Escalation Will not be considered during holidays</li>
				<li> -->  Escalated list is available for all Dharitree users (LM/AST/CO/ADC/DC)</li>
				<li> -->  From Escalated list CO/DC can revert the escalated cases to LM/SK/DA/CO</li>
				<li> -->  User need to write another remark for not passing the order in timeline, once case is escalated to upper officer.</li>
				<li> -->  <span style="color:#ff681d;font-style: italic;">Each and Every time pop up will come in each users for redzone cases, i:e (Which has low remaining days)</span></li>
				<li> -->  For failing order pass in total timeline, case will be out from the escalation Matrix.</li>
				<li> -->  Working Time Line may reshuffle due to low remaining days after escalation (Percentage wise reshuffle from the DC end)</li>
				<li> -->  Dharitree user can see list of cases which has low remaining days.</li>
            </ul>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
  $(window).load(function()
  {
      $('#escalation_co').modal({
        backdrop: 'static',
        keyboard: false
      });
      $("#escalation_co").modal("show"); 
  });
  $('#modal-close').click(function(){
    $('#escalation_co').modal('hide');
  });
</script>



