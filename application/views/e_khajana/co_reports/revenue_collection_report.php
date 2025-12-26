<style>
    .casedisplay_new {
        min-height: 395px !important;
        background-color: #B192E6;
    }
    .thead_color{
        background-color:#292409!important;
        color:white!important;
    }

</style>
<nav aria-label="breadcrumb">
  <ol class="breadcrumb p-3 text-white">
    <li class="breadcrumb-item font-weight-bold active"  aria-current="page">Revenue Collection Report</li>
  </ol>
</nav>
<div class="row" style='margin-top:20px'>				
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel casedisplay_new shadow-lg p-3 mb-5">                        
            <div class="panel-body">
                <div class="row">
                    <div class="" style="background-color:#907E17">
                        <div class="text-center text-white">
                            <h5><i class="fa fa-money" aria-hidden="true"></i>
                                Revenue Collected on Date: '<?=$select_date?>' in the Circle: <?=$this->utilityclass->getCircleName($dist_code, $subdiv_code,$circle_code)?>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-striped table-hover" >
                <tr>
                    <td>Revenue Collected:</td>
                    <td><strong>₹ <?=$revenueData?></strong></td>
                </tr>
                <tr>
                    <td>Circle:</td>
                    <td><?=$this->utilityclass->getCircleName($dist_code, $subdiv_code,$circle_code)?></td>
                </tr>
            </table>
        </div>
    </div>               
</div>


