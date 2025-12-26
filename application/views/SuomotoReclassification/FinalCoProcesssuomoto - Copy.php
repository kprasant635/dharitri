<style type="text/css">
  tr td{
    font-size: 1.2em;
  }
  .collapsing {
    -webkit-transition: none;
    transition: none;
    display: none;
  }
  .bg-first{
    background: rgb(35,60,60) !important;
    background: linear-gradient(39deg, rgb(114 171 71) 8%, rgb(26 151 211 / 81%) 62%) !important;

  }
  .bg-second{
    background: rgb(35,60,60)!important;
    background: linear-gradient(39deg, rgba(35,60,60,1) 9%, rgba(231,31,95,0.8071603641456583) 75%)!important;
  }
  .bg-third{
    background: rgb(35,60,60)!important;
    background: linear-gradient(39deg, rgba(35,60,60,1) 9%, rgba(25,143,25,0.8071603641456583) 75%)!important;
  }

  .bg-five{
    background: rgb(35,60,60)!important;
    background: linear-gradient(39deg, rgba(35,60,60,1) 9%, rgb(143 124 25 / 91%) 75%)!important;

  }

  .bg-four{
    background: rgb(35,60,60)!important;
    background: linear-gradient(39deg, rgba(35,60,60,1) 9%, rgb(59 209 218 / 83%) 75%)!important;
  }


 .bg-six{
    /*background: rgb(35,60,60)!important;*/
    background: linear-gradient(39deg, rgb(35 60 60 / 49%) 9%, rgb(113 25 73 / 88%) 75%)!important;
  }


  .bg-seven{
    /*background: rgb(35,60,60)!important;*/
    background: linear-gradient(39deg, rgb(35 55 60 / 75%) 9%, #007bff82 75%)!important;
  }
   /*.table tr:nth-child(odd){
    background: transparent;
    color: white;
  
  }

  .table tr:nth-child(even){
    background: transparent;
    color: white;
  }*/

  .custom-accordion .accordion-item {
  background-color: #f9f9f9;
  margin-bottom: 10px;
  position: relative;
  border-radius: 40px;
  overflow: hidden; }
  .custom-accordion .accordion-item .btn-link {
    display: block;
    width: 100%;
    padding: 15px;
    text-decoration: none;
    text-align: left;
    color: #fff;
    font-size: .6em;
    border: none;
    padding-left: 40px;
    border-radius: 0;
    position: relative;
    background: #fff;
    }
    .custom-accordion .accordion-item .btn-link:before {
      font-family: 'icomoon';
      content: "\25bc";
      position: absolute;
      top: 50%;
      -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
      left: 15px;
      }
    .custom-accordion .accordion-item .btn-link[aria-expanded="true"]:before {
      font-family: 'icomoon';
      content: "\25b2";
      position: absolute;
      color: red;
      top: 50%;
      -webkit-transform: translateY(-50%);
      -ms-transform: translateY(-50%);
      transform: translateY(-50%);
      left: 15px; }
  .custom-accordion .accordion-item.active {
    z-index: 2; }
    .custom-accordion .accordion-item.active .btn-link {
      color: #72c02c; }
  .custom-accordion .accordion-item .accordion-body {
    padding: 20px 20px 20px 20px;
    color: #888; }
</style>
    <style>
        .mycard{width: 100%;background: white;padding: 0px 0px;text-align: center;  
        box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2); transition: 0.3s; margin: 30px 0px;
        color: black;
        }
        .mycard: hover{box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);};
    </style>

<div class="mycard">
<h2 class="my-2 text-center">
Suomoto Final Chitha Update
 
</h2>

<form id='formAjaxPost'>
<div class="container">
  

  <div class="container-fluid">
    <div class="row">

        <div class="col-md-12 mx-auto">
            <div class="mycard">
              <div class="card-header bg-first">
              <strong>Case Details</strong>
            </div>
              <table class="table table-bordered">

                <tr>
                 
                 <td>Dharitree Case No</td>
                 <td>Application Date</td>
            
                </tr>
                <tr>
                 
                 <td><input type="hidden" required="" name="case_no" value="<?=$Pcases->case_no;?>"><?=$Pcases->case_no;?></td>
                 <td><?=$Pcases->lm_date;?></td>
                 <td class="hidden"><input type="hidden" required="" name="proposal_no" value="<?=$Pcases->proposal_no;?>"><?=$Pcases->proposal_no;?></td>
                 
                </tr>
            </table>
            </div>
            <div class="mycard">
              <div class="card-header bg-second">
              <strong>Location Details</strong>
            </div>

              <table class="table table-bordered">

                <tr>
                 <td>District</td>
                 <td>Subdivision</td>
                 <td>Circle</td>
                 <td>Mouza</td>
                 <td>Lot</td>
                 <td>Village</td>
                </tr>
                <tr>
                 <td><?=$location['dist'];?></td>
                 <td> <?=$location['sub']?></td>
                 <td><?=$location['cir']?></td>
                 <td><?=$location['mouza']?></td>
                 <td><?=$location['lot']?></td>
                 <td><?=$location['vill']?></td>
                </tr>

              </table>
            </div>
            
            <div class="mycard">
              <div class="card-header bg-third">
              <strong>Dag wise area details</strong>
            </div>

            <table class="table table-bordered">

                <tr>
                 <td>Dag No</td>
                 <td>Patta No</td>
                 <td>Patta Type</td>
                 <td>Chitha area</td>
                 <td>Land Class</td>
                 <td>Proposed Land Class</td>
                </tr>
                <tr>
                 <td><?= $Pcases->dag_no ?></td>
                 <td> <?= $Pcases->patta_no ?></td>
                 <td><?=$this->utilityclass->getPattaType($Pcases->patta_type_code)?></td>
                 <td><?= $Pcases->dag_area_b.'B-'.$Pcases->dag_area_k.'K-'.$Pcases->dag_area_lc.'L' ?></td>
                 <td><?=$this->utilityclass->getLandClassCode($Pcases->exist_land_class);?></td>
                 <td><?=$this->utilityclass->getLandClassCode($Pcases->present_land_class);?></td>
                </tr>

              </table>
            </div>

            <?php
            if(!empty($Pcases->is_part=='Y'))
                    //var_dump($lmrmk);
            {?>

            <div class="mycard">
              <div class="card-header bg-six">
              <strong>Partition Details</strong></div>

                <table class="table table-bordered">
                  <th>Partition Area</th>
                   
                         
                 <tr>
                 <td>

                <?= $Pcases->part_area_b.'B-'.$Pcases->part_area_k.'K-'.$Pcases->part_area_lc.'L' ?> &nbsp;
                </td> 
                
                
                </tr>
               </table>
               
            <?php  }?>
          
            </div>  

            <div class="mycard">
              <div class="card-header bg-six">
              <strong>Proceeding  Details</strong></div>
              
                <?php
                if($lmrmk)
                    //var_dump($lmrmk);
                    {?>

                <table class="table table-bordered">
                  <th>Proceeding</th>
                   
                   <th>Date Entry</th>  
                  <?php foreach($lmrmk as $rmk): ?>         
                 <tr>
                 <td>

                <?= $rmk->co_order ?> &nbsp;
                </td> 
                
                <td>
                <?= $rmk->date_entry ?> &nbsp;
                </td> 
                </tr>
                <?php endforeach;?>
               </table>
               
            <?php  }?>
          
            </div>

              
            <center>
            <span id='loading'></span><span id='msg'></span>
            <button type="submit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i>Update Chitha</button>&nbsp;
            </center>
            <br>
            <br>


        </div>
    </div>
</div>

</div>
</div>


<script type="text/javascript">
  $(document).ready(function(){
    $(".reject").click(function(event){
            event.preventDefault();
            $("#myModal").modal('show');
            $('#rejectForm').on('submit', function(event){
              event.preventDefault();
              var app=$('#appno').val();
              //alert('hai');
            });
        });
     $(".query").click(function(event){
      event.preventDefault();
            $("#myModal1").modal('show');
      });
    $('#formAjaxPost').on('submit', function(event){
    event.preventDefault();

  

    var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'SuomotoReclassification/SaveLandReclassification', 
            data        : formData, 
            dataType    : 'json', 
            encode      : true,
            beforeSend: function(){
                        $("#loading").html("Validating ...Please wait...");
                        $('.alert').hide();
                        $('.disable_forward').hide();
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