<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<link href="<?php echo base_url(); ?>application/views/css/dataTableButton.css" rel="stylesheet" />
<script>
document.onreadystatechange = function(e)
{
    $.blockUI({ 
        message: $('#displayBox'),
        css: {
            border:'none',
            backgroundColor:'transparent'
        }
    });    
};
window.onload = function(){   
    $.unblockUI();
}
</script>
<style>
.buttons-excel {
  left: 15%;
  background-color: orange;
  color: white!important;
}
.buttons-csv {
  left: 15%;
  background-color: grey;
  color: white!important;
}
.btn-info {
    color: #000;
    background-color: orange;
    border-color: #fff
}
</style>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold"><a href="<?php echo base_url() . 'index.php/EkhajanaReportController/amdaniReportForm'?>">AMDANI-REPORT-FORM</a></li>
    <li class="breadcrumb-item font-weight-bold active" aria-current="page">DOINIK-AMDANI-REPORT</li>
  </ol>
</nav>

<div class="container" style="margin-top:2rem; border: 2px solid;background:white; max-height:500px; overflow-y:scroll">
        <h3 style="text-align:center;margin-top:1rem"><u>দৈনিক আমদানী</u></h3>
        <div class="row" style="margin-bottom:1rem">
            <div class="col-md-3">
                <button class="btn btn-success" onclick="prevPage()">Previous</button>
                <button class="btn btn-success" onclick="nextPage()">Next</button>
            </div>
            <div class="col-md-9"></div>
        </div>
        <form id="amdani_pagination_form" action="<?php echo base_url() . 'index.php/EkhajanaReportController/amdaniReport' ?>" >
            <input type="hidden" value=<?=json_encode($posted_data)?> name="posted_data">
            <input type="hidden" value="<?=$offset?>" name="offset" id="offset"> 
            <input type="hidden" value="<?=$reportDataCount?>" name="totalcount" id="totalcount"> 
            <input type="hidden" value="" name="paginate_form"> 
        </from>
        <span style="font-family:cursive;background-color:yellow;">Displaying results from <span style="color:red"><?=(int)$offset?></span> records to <span style="color:red"><?=$offset+10?></span> out of <?=$reportDataCount?> records</span>
        <div  style="margin-top:2rem;margin-bottom:2rem;overflow-x: scroll;">
        <h6 style="color:black">দৈনিক আমদানী <span style="color:red"><?=$posted_data['start_date']?></span>  তাৰিখৰ পৰা <span  style="color:red"><?=$posted_data['to_date']?></span> তাৰিখৰ লৈকে</h6>
            <table class="table table-striped table-bordered" >
                <thead>
                    <tr>                       
                        <tr style="border-top:1px">
                            <th colspan="1" style="text-align:center;border-bottom:0px"></th>
                            <th colspan="1" style="text-align:center;border-bottom:0px"></th>
                            <th colspan="1" style="text-align:center;border-bottom:0px"></th>
                            <th colspan="2" style="text-align:center;border-bottom:0px">পাট্টা নম্বৰ</th>
                            <th colspan="2" style="text-align:center;border-bottom:0px">আদায় টকা</th>
                        </tr>
                        <tr style="border-top:0px">
                            <th scope="col" style="border-top:0px"></th>
                            <th scope="col" style="border-top:0px">পাট্টাদাৰ নাম আৰু যি মানুহৰ পৰা লোৱা যায় ত‌‍েওঁৰ নাম</th>
                            <th scope="col" style="border-top:0px">গাওঁৰ নাম</th>
                            <th scope="col">একচনা</th>
                            <th scope="col">ম্যাদী</th>
                            <th scope="col" >খাজানা</th>
                            <th scope="col">স্থানীয় কৰ</th>
                        </tr>
                        <tr style="border-top:0px">
                            <th scope="col" style="text-align:center">১</th>
                            <th scope="col" style="text-align:center">২</th>
                            <th scope="col" style="text-align:center">৩</th>
                            <th scope="col" style="text-align:center">৪</th>
                            <th scope="col" style="text-align:center">৫</th>
                            <th scope="col" style="text-align:center">৬</th>
                            <th scope="col" style="text-align:center">৭</th>
                        </tr>     
                    </tr>  
                </thead>
                <tbody>
                <?php $counter = 1;?>    
                <?php foreach ($reportData as $rptData):?>
                    <tr style="text-align:center">
                        <td><?=$counter++?></td>
                        <td><b><?=$rptData->pdar_name?></b></td>
                        <td><?=$this->utilityclass->getVillageName($rptData->dist_code,$rptData->subdiv_code,$rptData->cir_code,$rptData->mouza_pargona_code,$rptData->lot_no,$rptData->vill_townprt_code)?></td>
                        <?php if ($this->EkhajanaReportModel->getPattaInfo($rptData->patta_type_code) != 'a') :?>
                            <td>--</td>
                            <td><?=$rptData->patta_no?></td>
                        <?php else : ?> 
                            <td><?=$rptData->patta_no?></td> 
                            <td>--</td>                   
                        <?php endif ?>
                        <td><b><?=$rptData->due_payment?></b></td>
                        <td><b><?=$rptData->local_tax?></b></td>
                    </tr>
                <?php endforeach;?> 
                </tbody>
            </table>
        </div>
    </div>
<script type="text/javascript">  

    function nextPage(){
        var offset = $("#offset").val();
        var totalcount = $("#totalcount").val();
        //alert(totalcount);
        var new_offset = parseInt(offset) + 10;
        if(new_offset < totalcount){
            $("#offset").val(new_offset);
        }
       else{
             $("#offset").val(NULL);
       }
        $("#offset").val(new_offset);
        $('#amdani_pagination_form').attr('method', 'POST');
        $('#amdani_pagination_form').submit();
    }

    function prevPage(){
        var offset = $("#offset").val();
        var new_offset = parseInt(offset) - 10;
        if(new_offset >= 0){
            $("#offset").val(new_offset);   
        }
        else{
            $("#offset").val(NULL);  
        }
        $("#offset").val(new_offset);
        $('#amdani_pagination_form').attr('method', 'POST');
        $('#amdani_pagination_form').submit();
    }
    
</script>