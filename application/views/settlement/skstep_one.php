<script>
    $(function () {
        $('#acb').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modala .modal-body').html(data);
                    $('#modala').modal('show');
                    $('#modala .modal-body').addClass('bodytest');
                }
            });

        });

        $('#cd').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modalb .modal-body').html(data);
                    $('#modalb').modal('show');
                    $('#modalb .modal-body').addClass('bodytest');
                }
            });

        });

        $('#cbsic').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modalc .modal-body').html(data);
                    $('#modalc').modal('show');
                    $('#modalc .modal-body').addClass('bodytest');
                }
            });

        });
		
		$('#lmn').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('#modald .modal-body').html(data);
                    $('#modald').modal('show');
                    $('#modald .modal-body').addClass('bodytest');
                }
            });

        });

    })

</script>
<div id="modala" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>
<div id="modalb" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>
<div id="modalc" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>
<div id="modald" class="modal bs-example-modal-lg" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            
            <div class="modal-body">
           </div>
        </div>
    </div>
</div>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 ">
            <div class="panel panel-info panel-form">
				<div class="col-lg-12 center" style="margin-top: 10px">
                    <a class="btn btn-primary uni_text" id='acb' href='<?php echo base_url() . 'index.php/Settlement/viewapplication?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp;<?php echo $this->lang->line('see_application_rpt'); ?>
                    </a>

<!-- <a class="btn btn-success uni_text" target='_blank' href='<?php echo base_url() . 'index.php/Settlement/viewcert?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Allotment Certificate
                    </a> -->
                    <?php
                        if($allotment_certificate->name_of_certificate){
                    ?>
                            <a href="javascript:void(0)" data-path="<?php echo search_file_location('STPPDocs/' . $allotment_certificate->name_of_certificate); ?>" class="preview__file btn btn-success" target="_blank">
                                <i class="fa fa-paperclip"></i>&nbsp;View Settlement Certificate
                            </a>
                    <?php
                        } else {
                            echo '<h6> No Documents Uploaded</h6>';
                        }
                    ?>



					<a class="btn btn-warning hide uni_text" id='lmn'  href='<?php echo base_url() . 'index.php/ChithaReport/modalgenerateChitha?case_no=2&pro='.$allotment_cb->case_no?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Chitha
                    </a>
					<a class="btn btn-info uni_text" id='cbsic'  href='<?php echo base_url() . 'index.php/Settlement/viewlmnote?case_no='.$allotment_cb->case_no?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View LM Report
                    </a>
                </div>
                <?php
                    if($this->session->flashdata('message')){
                  ?>
                  <br><br><br>
                      <div class="error_container">
                        <div class="alert alert-warning alert-dismissible show" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                            <strong class="text-danger">
                              <?= $this->session->flashdata('message'); ?>
                            </strong>
                          </div>
                        </div>
                  <?php
                    }
                  ?>
               
				<br><br><br>
                <form class="form-horizontal  unicode" action="<?php echo base_url()."index.php/Settlement/sk_submit" ?>" method="POST"  >              
                <div class='panel-body'>
				
				<div class="form-group">    
                    <label for="inputEmail" class="col-lg-2 required control-label ">Comment </label>
                    <div class="col-lg-10">
                        <textarea class="form-control" rows=5 placeholder='Type here' name="sk_comment" required="" value="" >আবেদনকাৰীৰ আবেদন /  লা:ম ৰ প্রতিবেদন আৰু সংশ্লিস্ট নাম পৰীক্ষা কৰা হ'ল । পট্টনৰ প্রস্তাৱ অনুমোদনৰ বাৱে উপায়ুত্ত মহোদয়লৈ পঠিয়াব পৰা যায় । </textarea>
						<input class="form-control hide" type="text" placeholder="Type Here" value="<?php echo $cases->case_no; ?>"  required name="case_no" />
                    </div>		
                </div>
                </div>

				
                <div class="panel-footer">
                    
                    <div class="btn btn-info col-lg-offset-4 uni_text" id="BackHome" ><i class="fa fa-reply "></i> &nbsp;<?php echo $this->lang->line('back_to_home'); ?></div>
                     <button type="submit" name="submit" class="btn btn-primary uni_text"><i class="fa fa-share "></i> &nbsp;<?php echo $this->lang->line('submit_button') ?></button>
                   
<!--                 <div class="btn btn-primary" ><i class="fa fa-share "></i> &nbsp;  </div>-->
                </div>
                </form>
                
            </div>
         </div>
        
    </div>
    </div>    
</div>


<!-- <div class="modal bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src='<?php echo base_url(); ?>application/views/images/load.gif'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div> -->
<style type="text/css">
    .modal{
        overflow-y:auto;
        overflow-x: hidden;
    }
    .bodytest{
        position: relative;
        padding: 0px !important;
    }
</style>
<script>
    $('#BackHome').click(function(){
	location.href = "<?php echo base_url(); ?>index.php/home";
    });
    
    </script>
