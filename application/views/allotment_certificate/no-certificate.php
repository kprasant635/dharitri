<style>
    .bg-cross{
        background-image:url('<?php echo base_url(); ?>application/views/images/crossword.png');
    }
    .logo{
        height : 15%!important; 
        width : 15%!important;
        text-align :center!important;
    }
    .logoEmblem{
        height:100%!important;
        width:100%!important;
    }
    .logoBorder{
        border:0px;
    }
</style>

<div class="modal modal-md" id="digital_patta_modal">
    <div class="col-lg-10 offset-1">
        
        <div class="bg-cross" id="print_div">                        
            <div class="panel-body mt-5">  
                <div id="certificate_error_alert" class="alert alert-danger mt-3">
                    <strong>Could not generate certificate.</strong> <?php echo $error?>
                </div>
                <div class="col-md-12 mt-3" style="text-align:center">
                    <button type="button" class="btn btn-danger himanxuNotShowButton" id="modal-close">Close &times; </button>
                </div>
            </div>
        </div>
    </div>
</div>



<script>

    // onload
    $(document).ready(function () {
        var district_id = $("#selectDistrict").val();

        // get districtName 

        // console.log(district_id,"zxczx");

    });
    //function to close modal 
    $(document).on('click', '#modal-close', function () {
        $('#digital_patta_modal').hide('300');
    });
</script>




