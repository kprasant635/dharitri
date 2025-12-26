<script>
    $(function () {
        $('#acb').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal();
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#lm').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal();
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#cd').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal();
                    $('body').addClass('bodytest');
                }
            });

        });

        $('#sk').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal();
                    $('body').addClass('bodytest');
                }
            });

        });
        $('#cbsic').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal();
                    $('body').addClass('bodytest');
                }
            });

        });
        $('#pr').click(function (e) {
            e.preventDefault();
            $.ajax({
                url: $(this).attr('href'),
                success: function (data) {
                    $('.modal-content').html(data);
                    $('.modal').modal();
                    $('body').addClass('bodytest');
                }
            });

        });

    })

</script>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 ">
            <div class="panel panel-info panel-form">
                <div class="col-lg-12 center" style="margin-top: 10px">
                    <a class="btn btn-primary uni_text" id='acb' href='<?php echo base_url() . 'index.php/Settlement/viewapplication?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp;<?php echo $this->lang->line('see_application_rpt'); ?>
                    </a>

                    <a class="btn btn-success uni_text" target='_blank' href='<?php echo base_url() . 'index.php/Settlement/viewcert?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Settlement Certificate
                    </a>

                   <a class="btn btn-warning hide uni_text" id='cbsic'  href='<?php echo base_url() . 'index.php/ChithaReport/modalgenerateChitha?case_no=2&pro='.$allotment_cb->case_no?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Chitha
                    </a>
                </div>
                <div class="col-lg-12 center" style="margin-top: 10px">
                    <a class="btn btn-success uni_text" id='lm' href='<?php echo base_url() . 'index.php/Settlement/viewlmnote?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View LM Report
                    </a>
                    <a class="btn btn-warning uni_text" id='sk' href='<?php echo base_url() . 'index.php/Settlement/viewsknote?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View SK Report
                    </a>
                    <a class="btn btn-danger uni_text" id='pr' href='<?php echo base_url() . 'index.php/Settlement/viewpro?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View Proceeding Report
                    </a>
                    <a class="btn btn-info hide uni_text" id='co' href='<?php echo base_url() . 'index.php/Settlement/viewsknote?case_no=' . $allotment_cb->case_no ?>'>
                        <i class="fa fa-check-square-o "></i> &nbsp; View CO Report
                    </a>  
                </div>
                <form class="form-horizontal unicode" action="<?php echo base_url()."index.php/Settlement/savecoscondorder" ?>" method="POST"  >              
                <div class='panel-body'>
				<br>
                    <h2 class="text-center" style="top:20px;">চক্র বিষয়াৰ হুকুম </h2>
                    <table class="table_border">
                        <tr>
                            <td class="uni_text">গোচৰ নং : <?php echo $allotment_cb->case_no ;?></td>
                            <td class="uni_text">হুকুম  ক্রমিক নং : 2</td>
                            <td class="uni_text">তাং : <?php echo date('d-m-Y',strtotime($allotment_cb->date_entry)) ; ?></td>
                        </tr>
                    </table>
                   
                    <hr>
					<div class="form-group">    
                    <label for="inputEmail" class="col-lg-2 required control-label ">Comment </label>
                    <div class="col-lg-10">
						<?php
						$i=1;
						$name="";
						foreach($applicant as $ap){
							$mouza=$this->utilityclass->getMouzaName($ap->dist_code,$ap->subdiv_code,$ap->circle_code,$ap->mouza_pargona_code);
							$vill=$this->utilityclass->getVillageName($ap->dist_code,$ap->subdiv_code,$ap->circle_code,$ap->mouza_pargona_code,$ap->lot_no,$ap->vill_townprt_code);
							$name=$name.$i.")".$ap->alotee_name." ";
							$i++;
						}	
						$dag=$lmreport->dag_no;
						$b=$lmreport->alot_area_b;
						$k=$lmreport->alot_area_k;
						$lc=$lmreport->alot_area_lc;
						?>
                        <textarea class="form-control" rows=5 placeholder='Type here' name="co_comment" required="" value="" >  আবেদনকাৰীৰ (নাম / ঠিকনা) ৰ আৱেদন চোৱা হ'ল । ভূমিলেখ্য সহায়ক / ভূমিলেখ্য পৰ্যবেক্ষক ৰ প্রতিবেদন মৰ্মে জনা যায় যে  <?=$name;?> <?=$mouza?> মৌজা  <?=$vill?> গাওঁৰ  <?=$dag?> দাগৰ  <?=$b?> বি: <?=$k?> ক: <?=$lc?> লে: মাটিত আবণ্টন প্রত্ৰ মৰ্মে ভোগ দখল কৰি থকা মাটি হয় ।আবেদনকাৰীয়ে  আবণ্টনৰ চৰ্ত ভংগ কৰা নাই । সেয়েহে আবেদিত মাটিৰ পট্টনৰ প্রস্তাৱ অনুমোদনৰ বাৱে  সহ দাখিল কৰা হ'ল ।</textarea>
                    </div>		
					</div>
					<div class="form-group">    
                    <label for="inputEmail" class="col-lg-2 required control-label ">Next Date of Hearing </label>
                    <div class="col-lg-10">
                        <input type="text" name="next_date" required  id="popupDatepicker" placeholder="DD/MM/YYYY" class="form-control " style="width: 250px" >
						 <input type="text" class='hide' name="case_no" required value='<?php echo $allotment_cb->case_no ;?>'>
                    </div>		
					</div>
                    
                    
                    <hr> 
                    <label class="radio-inline uni-text col-lg-offset-2">
                        <input type="radio" name="next_hearing" value="L"> ভূমিলেখ্য সহায়ক পুন: প্রতিবেদন দিয়ক 
                    </label>
                    <label class="radio-inline uni-text">
                        <input type="radio" name="next_hearing"  value="D"> প্রস্তাৱ খাৰিজ কৰক 
                    </label>
                    <label class="radio-inline uni-text">
                        <input type="radio" name="next_hearing"  value="P" checked=""> উপায়ুক্ত লৈ প্রেৰণ কৰক 
                    </label>
                    
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
<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <img src='<?php echo base_url(); ?>application/views/images/load.gif'>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
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
    var dateToday = new Date(); 
    $(function() {
        $( "#ddmmyy" ).datepicker({
            numberOfMonths: 3,
            showButtonPanel: true,
            minDate: dateToday
        });
    });
    </script>