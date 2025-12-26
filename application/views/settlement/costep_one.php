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

    })

</script>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1 ">
		<?php //var_dump($allotment_certificate);
		//var_dump($allotment_cb);
		//echo $base_path;
						$link="./Certificate/".$allotment_certificate->name_of_certificate;
						//$link=force_download('./Certificate/to/photo.jpg', NULL);
				?>
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
                <form class="form-inline unicode" action="<?php echo base_url()."index.php/Settlement/savecofirstorder" ?>" method="POST"  >              
                <div class='panel-body'>
				<br>
                    <h2 class="text-center" style="top:20px;">চক্র বিষয়াৰ হুকুম </h2>
                    <table class="table_border">
                        <tr>
                            <td class="uni_text">গোচৰ নং : <?php echo $allotment_cb->case_no ;?></td>
                            <td class="uni_text">হুকুম  ক্রমিক নং : 1 </td>
                            <td class="uni_text">তাং : <?php echo date('d-m-Y',strtotime($allotment_cb->date_entry)) ; ?></td>
                        </tr>
                    </table>
                   
                    <hr>
                    <p class='uni_text'>
                        আবেদনকাৰীয়ে আবন্টন পোৱা মাটিৰ পট্টন বিচাৰি কৰা  আৱেদন চোৱা হ'ল । ভূমিলেখ্য সহায়ক  আৰু ভূমিলেখ্য পৰ্যবেক্ষক ই চৰজমিন জোখ মাখ কৰি  বিতং প্রতিবেদন দাখিল কৰিব  |
						 প্রতিবেদন দাখিলৰ পৰবৰ্তী তাৰিখ <input type="text" name="next_date" required  id="popupDatepicker" placeholder="DD/MM/YYYY" class="form-control " style="width: 250px" >   ধাৰ্য্য কৰা হল |
                    </p>
					<input type='text' class='hide' name='proceeding1' value="আবেদনকাৰীয়ে আবন্টন পোৱা মাটিৰ পট্টন বিচাৰি কৰা  আৱেদন চোৱা হ'ল । ভূমিলেখ্য সহায়ক  আৰু ভূমিলেখ্য পৰ্যবেক্ষক ই চৰজমিন জোখ মাখ কৰি  বিতং প্রতিবেদন দাখিল কৰিব  | প্রতিবেদন দাখিলৰ পৰবৰ্তী তাৰিখ  ">
					<input type='text' class='hide' name='proceeding2' value="  ধাৰ্য্য কৰা হল | ">
					<input type='text' class='hide' name='case_no' value='<?php echo $allotment_cb->case_no ?>'>
                   
                     <p class="pull-right hide uni_text">
                        <?php // echo $coname->username; ?><br>
                                                   চক্র বিষয়া ,
                                                   <?php //echo $location['cir']?>
                    </p> 
                    <hr> 
                    <label class="radio-inline hide uni-text col-lg-offset-2">
                        <input type="radio" name="next_hearing" disabled=""  value="F"> অন্তিম হকুম দিয়ক 
                    </label>
                    <label class="radio-inline col-lg-offset-2 uni-text">
                        <input type="radio" name="next_hearing"  value="D"> প্রস্তাৱ খাৰিজ কৰক 
                    </label>
                    <label class="radio-inline uni-text">
                        <input type="radio" name="next_hearing"  value="P" checked=""> প্রক্রিয়া জাৰি ৰাখক 
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
    
    </script>