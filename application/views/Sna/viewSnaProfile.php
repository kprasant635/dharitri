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
    <li class="breadcrumb-item font-weight-bold active"  aria-current="page">SNA Profile</li>
  </ol>
</nav>
<div class="row" style='margin-top:20px'>				
    <div class="col-lg-8 col-lg-offset-2">
        <div class="panel casedisplay_new shadow-lg p-3 mb-5">                        
            <div class="panel-body">
                <table class="table table-striped table-hover">
                    <div class="" style="background-color:#907E17">
                        <div class="text-center text-white" colspan="3">
                            <h3><i class="fa fa-user-circle-o" aria-hidden="true"></i>
                                SNA PROFILE
                            </h3>
                        </div>
                    </div>
                </table>
            </div>
            <table class="table table-striped table-hover" style="background-color:white!important;">
            <thead >
                <tr>
                    <th class="thead_color" scope="col">NAME</th>
                    <th class="thead_color" scope="col">CIRCLE</th>
                    <th class="thead_color" scope="col">UNIQUE SNA CODE</th>
                    <th class="thead_color" scope="col">UNIQUE USER_ID</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th><?=$sna_details->username?></th>
                    <td><?=$this->utilityclass->getCircleName($dist_code, $subdiv_code,$cir_code)?></td>
                    <td><?=$sna_details->unique_sna_code?></td>
                    <td><?=$sna_details->unique_user_id?></td>
                </tr>
            </tbody>
            <thead >
                <tr>
                    <th class="thead_color" scope="col">DATE OF JOINING</th>
                    <th class="thead_color" scope="col">MOBILE NO</th>
                    <th class="thead_color" colspan="2" scope="col">ADDRESS</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <th><?=$sna_details->phone_no?></th>
                    <td><?=$sna_details->phone_no?></td>
                    <td colspan="2"><?=$sna_details->phone_no?></td>
                </tr>
            </tbody>
            </table>
        </div>
    </div>               
</div>
