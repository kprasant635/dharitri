
<!--#PLB0004:Improvement in jamabandi service-->
<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<div class="loader"></div> 
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                 <!--#START PLB-->
                <h2 style="text-align: center;">Upload File for Case No 
                    <?=isset($_GET['application_ref_no'])==null?$_GET['application_no']:$_GET['application_ref_no']?>       
                </h2>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    
                    <div class="panel-body">
                        Note: Upload Pdf file only
                        <form method='post' action='<?=base_url('index.php/Serviceplus/do_upload')?>' enctype="multipart/form-data" id="uploadfile">
                          Select file : <input type='file' name='file' id='file' class='form-control' ><br>
                          <?php if(isset($_GET['application_ref_no'])){?>
                          <input type='hidden' name='application_ref_no' value='<?=$_GET['application_ref_no']?>'>
                          <input type='hidden' name='applid' value='<?=$_GET['applid']?>'>
                          <?php }else{?>
                          <input type='hidden' name='application_no' value='<?=$_GET['application_no']?>'>
                          <?php }?>
                          <input type='hidden' name='type' value='<?=$_GET['type']?>'>
                          <input type='hidden' name='case_no' value='<?=$_GET['case_no']?>'>
                          
                          <input onclick="docupload()"  class='btn btn-info' value='submit' >
                           
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<!--#START PLB-->
 <script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>

<script type="text/javascript">

function docupload()
{
    $('#uploadfile').submit();

    $.blockUI({
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });

}
        
$(window).load(function () {
    $('#loading').hide();
});
function LoadData() {
    $("#loading").show();
    $('#myModal').modal({
        backdrop: 'static',
        keyboard: true,
        show: true
    });
}
</script>
<!--#END PLB-->