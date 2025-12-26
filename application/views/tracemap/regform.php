<style type="text/css">
  .mmm{
    padding-top: 5px;
    padding-right: 30px;
    padding-bottom: 10px;
    padding-left: 30px;
}
  }
</style>
<form id='formAjaxPost'>

<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
             <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading" style=" background-color: #448AFF">
                        <span style="padding: 10px; font-weight: bolder; font-size: 17px">
                          Registration of Trace Map Service 
                        </span> 
                    </div>
                    <div class="panel-body">

                      <input type="hidden" class="form-control" name='application_no' value="">
                          <input type="hidden" class="form-control" name='patta_type' value="">
                          <input type="hidden" class="form-control" name='patta_no' value="">
                          <input type="hidden" class="form-control" name='dag_revenue' value="">
                          <input type="hidden" class="form-control" name='dag_local_tax' value="">
                       <!--    <input type="hidden" class="form-control" name='land_class_code' value="<?=$pattaNo->land_class_code?>"> -->


                        <div class="row">
                          <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                              <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class="control-label"><?php echo $this->lang->line('district'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                   <input type="hidden" name="dist_code" class="districtselect" value="<?php echo $this->session->userdata('dist_code'); ?>"/>
                                    <input type="text" name="dist" class="form-control " readonly="readonly" value="<?=$this->utilityclass->getDistrictName($this->session->userdata('dist_code'))?>"/>
                                 </div>
                              </div>
                          </div>  

                          <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>

                            <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('subdivision'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <input type="hidden" name="subdiv_code" class="subdivselect" value="<?php echo $this->session->userdata('subdiv_code') ?>"/>
                                    <input type="text" name="subd" class="form-control " readonly="readonly" value="<?=$this->utilityclass->getSubDivName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'))?>"/>
                                 </div>
                              </div>
                          </div> 

                          <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                              <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('circle'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                  <input type="hidden" name="cir_code" class="circleselect" value="<?php echo $this->session->userdata('subdiv_code') ?>"/>
                                    <input type="text" name="subd" class="form-control " readonly="readonly" value="<?=$this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code'))?>"/>
                                 </div>
                              </div>
                          </div>  



                          <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>

                            <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('mouza'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                  <select class="form-control mouzaselect" id="select" required name="mouza_code">
                                        <option disabled selected><?php echo $this->lang->line('select_mouza'); ?></option>
                                        <?php foreach ($mouzalist AS $m) { ?>
                                            <option value="<?php echo $m->mouza_code; ?>"><?php echo $m->mouza; ?></option>
                                        <?php } ?>
                                    </select>
                                 </div>
                              </div>
                          </div>   

                          <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                              <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class="control-label"><?php echo $this->lang->line('lot_no'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                   <select class="form-control lotselect" id="select" required name="lot_no">
                                        <option disabled selected><?php echo $this->lang->line('select_lot_no'); ?></option>
                                    </select>
                                 </div>
                              </div>
                          </div>  

                          <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>

                            <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('vill_town'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <select class="form-control villageselect" id="select" required name="vill_code">
                                        <option disabled selected><?php echo $this->lang->line('select_vill_town'); ?> </option>
                                    </select>
                                 </div>
                              </div>
                          </div>

                        </div>


                        <div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>


                        
                            <h2 style="color: #448AFF; padding-left: 15px"><?php echo $this->lang->line('select_patta_information'); ?></h2>
                            
                            <div class="row">
                              <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                                <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('patta_type'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                     <select class="form-control pattatype_nmae" name="patta_type_code" required >
                                        <option value="" selected><?php echo $this->lang->line('select_patta_type');?></option>
                                        <?php foreach ($patta AS $patta) { ?>
                                            <option value="<?php echo $patta->type_code; ?>"><?php echo $patta->patta_type; ?></option>
                                        <?php } ?>
                                    </select>
                                 </div>
                              </div>
                            </div>
                              <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                                <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('patta_no'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                     <select class="form-control pattanoselect" id="backlog_patta_type" name="patta_no">
                                        <option>Select Patta No</option>
                                    </select>
                                 </div>
                              </div>
                            </div>

                             <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>

                            <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label"><?php echo $this->lang->line('dag_no'); ?></label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <select class="form-control get_dag_no_sara" id="dag_no" name="dag_no">
                                        <option><?php echo $this->lang->line('select_dag_no'); ?></option>
                                    </select>
                                 </div>
                              </div>
                          </div>
              </div><div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>
              <br/>
                  
                <div class="row">
                <div class="form-group" style="padding-left: 15px">
                  <label for="select" class="col-lg-2 control-label">Area</label>
                  <div class="col-sm-2">
                   
                      <input type="text" name="bigha" class="form-control " readonly="readonly"
                        placeholder="<?php echo $this->lang->line('bigha'); ?>" id="bigha">
                      
                    
                  </div>
                  <div class="col-sm-2">
                    
                      <input type="text" name="katha" class="form-control " readonly="readonly"
                        placeholder="<?php echo $this->lang->line('katha'); ?>" id="katha">
                      
                    
                  </div>
                  <div class="col-sm-2">
                    
                      <input type="text" name="lessa" class="form-control " readonly="readonly"
                        placeholder="<?php echo $this->lang->line('lessa'); ?>" id='lessa'>
                      
                    
                  </div>

                  <div class="col-sm-2">
                    
                      <input type="text" name="ganda" class="form-control " readonly="readonly" placeholder="Ganda" id='ganda'>
                      
                    
                  </div>

                  <div class="col-sm-2">
                    
                      <input type="text" name="kranti" class="form-control " readonly="readonly" placeholder="Kranti" id='kranti'>
                      
                    </div>
                  
                </div>
              </div>

                <div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>
                <h2 style="color: #448AFF; padding-left: 15px">Applicant Details</h2>
                <div class="row">
                              <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                                <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label">Applicant Name</label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                     <input type="text" name="applname" class="form-control" value=""/>
                                 </div>
                              </div>
                            </div>
                              <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                                <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label">Father's Name</label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <input type="text" name="fathername" class="form-control" value=""/>
                                 </div>
                              </div>
                            </div>
                            <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12 mmm'>
                                <div class="row">
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <label for="inputEmail" class=" control-label">Mobile</label>
                                 </div>
                                 <div class='col-lg-6 col-md-6 col-sm-6 col-xs-12'>
                                    <input type="number" name="mobile" class="form-control" value=""/>
                                 </div>
                              </div>
                            </div>
                <div class='col-lg-12 col-md-12 col-sm-12 col-xs-12 mmm'>
                   <div class="row">
                                 <div class='col-lg-3 col-md-3 col-sm-3 col-xs-12'>
                                    <label for="inputEmail" class=" control-label">Remark</label>
                                 </div>
                                 <div class='col-lg-9 col-md-9 col-sm-9 col-xs-12' style="padding: 0">
                                     <textarea name="astremark" class="form-control" rows="5"> </textarea>
                                 </div>
                    </div>
                </div>        
           </div>

                 
 <div style="height: 1px; background-color: #2979FF; margin-bottom: 10px; margin-top: 10px">&nbsp;</div>
 <br/>
          
            <div class="form-group">
                <div class="col-lg-8 col-lg-offset-4">
                    <button type="submit" class="btn btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button'); ?></button>
                    <button type="reset" name="" class="btn btn-primary"><i class='fa fa-refresh'>&nbsp;</i><?php echo $this->lang->line('reset'); ?></button>
                    <a href="<?php echo base_url(); ?>index.php/home/index" class="btn btn-danger">
                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                    </a>
                </div>
            </div>
          </div>


    </div>
  </div>
</div>
</div>

</form>

<div id="myModal" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Rejection Reason</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='rejectForm' action="<?php echo base_url() ?>index.php/basundhara/RejectOrder" method="post">
            <div class="modal-body">
              <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
                <textarea name='order' class="form-control">Reason of Rejection</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='rejectSubmit' class="btn reject btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>
<!--  -->
<!-- Modal HTML -->
<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Type Your Query</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id='queryRequest' action="<?php echo base_url() ?>index.php/basundhara/queryRequest" method="post">
               <input type="hidden" class="form-control" name='application_no' value="<?=$app->application_no?>">
            <div class="modal-body">
                <textarea name='query' class="form-control">Please enter your query</textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id='querySend' class="btn query btn-primary">Save</button>
            </div>
          </form>
        </div>
    </div>
</div>

<script type="text/javascript">
  $("#backlog_patta_type").change(function (e) {
        //alert('sda');
        var distcode = $('.districtselect').val();
        var subdivcode = $('.subdivselect').val();
        var circode = $('.circleselect').val();
        var mouzacode = $('.mouzaselect').val();
        var lotcode = $('.lotselect').val();
        var villcode = $('.villageselect').val();
        var patta_type_code = $('.pattatype_nmae').val();
        var patta_no = $(this).val();
        //alert(distcode+" "+subdivcode+" "+circode+" "+mouzacode+" "+lotcode+" "+villcode+" "+patta_type_code);
        $.ajax({
            url: baseurl + "Utility/getDagsbacklog/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode + "/" + villcode + "/" + patta_type_code + "/" + patta_no,
            success: function (d) {
                var object = JSON.parse(d);
                //alert (object[i].dag_no_int);
                var template = "<option disabled selected>Select</option>";
                for (var i = 0; i < object.length; i++) {

                    template += "<option value='" + object[i].dag_no_int + "'>" + object[i].dag + "</option>";
                }
                $("select[name='dag_no']").html(template);
                //$("select[name='dag_no_upper']").html(template);
            }
        });
    });

  $(document).ready(function(){
  $('#formAjaxPost').on('submit', function(event){
    event.preventDefault();
    var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'Tracemap/regformPost', 
            data        : formData, 
            dataType    : 'json', 
            encode      : true,
            beforeSend: function(){
                        $("#loading").html("Validating ...Please wait...");
                        $('.alert').hide();
                         $('.bhide').hide();
                    },
            success: function(data){
              console.log(data);
              if(data.success!=null){
                //alert('hai');
                $("#loading").hide();
                $('#msg').html('<div class="alert alert-info text-center">' + data.success + '</div>');
                window.location.href = data.redirect_url;
              }else if(data.error!=null){
                $("#loading").hide();
                $('.btn-block').show();
                $('#msg').html('<div class="alert alert-danger text-center">' + data.error + '</div>');
              }
            },
        });
    });
});
</script>
<script type="text/javascript">
  $(document).ready(function(){
   $('.get_dag_no_sara').change(function (e) {
        var distcode = $('.districtselect').val();
        var subdivcode = $('.subdivselect').val();
        var circode = $('.circleselect').val();
        var mouzacode = $('.mouzaselect').val();
        var lotcode = $('.lotselect').val();
        var villcode = $('.villageselect').val();
        var patta_type_code = $('.pattatype_nmae').val();
        var patta_no = $('.pattanoselect').val();
        var dag_no = $(this).val();
        //alert(dag_no);
        $.ajax({
            url: baseurl + "Utility/getLandAreaJSON/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode + "/" + villcode + "/" + patta_type_code + "/" + patta_no + "/" + dag_no,
            success: function (data) {
                // if (debug) {
                //     console.log(data);
                // }
                var dag = JSON.parse(data);
                console.log(dag);
                $('#bigha').val(dag[0].dag_area_b);
                $('#katha').val(dag[0].dag_area_k);
                $('#lessa').val(dag[0].dag_area_lc);
                $('#ganda').val(dag[0].dag_area_g);
                $('#kranti').val(dag[0].dag_area_kr);
                $('#b1').val(dag[0].dag_area_b);
                $('#katha1').val(dag[0].dag_area_k);
                $('#l1').val(dag[0].dag_area_lc);
                $('#g1').val(dag[0].dag_area_g);
                $('#k1').val(dag[0].dag_area_kr);
                $('#b2').val(dag[0].dag_area_b);
                $('#katha2').val(dag[0].dag_area_k);
                $('#l2').val(dag[0].dag_area_lc);
                $('#g2').val(dag[0].dag_area_g);
                $('#k2').val(dag[0].dag_area_kr);
                $('#dag_rev').val(dag[0].dag_revenue);
                $.ajax({
                    url: baseurl + "lmmutation/getMutatedLandAreaJSON",
                    success: function (data) {
                        console.log(data);
                        var dag = JSON.parse(data);
                        $('#mb').val(dag[0].bigha);
                        $('#mutatedk').val(dag[0].katha);
                        $('#lm').val(dag[0].lessa);
                        $('#mg').val(0);
                        $('#mk').val(0);
                        $('#rb').val(0);
                        $('#rkatha').val(0);
                        $('#rl').val(0);
                        calculateRemainingLand();
                    }
                });

            }
        });
        });
    });
</script>



