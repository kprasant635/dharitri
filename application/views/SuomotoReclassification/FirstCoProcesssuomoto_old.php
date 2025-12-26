<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
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
  /*myCss*/
    .sumoTopHeading{font-family: sans-serif;font-size:22px;font-weight: 600;color:#383838;text-align:left;border-bottom: 3px double #6c6a6a; width:fit-content;padding-bottom: 7px;padding-left: 7px;margin-bottom:30px;}
    .wrapper{padding: 25px !important;background:white;margin-top:25px;border-radius:10px;}
    center>button[type='submit']{padding: 8px 20px;font-weight: bold;outline: 4px solid #ffc10736;font-size: 16px;font-weight: 500;outline: 4px solid #0712ff36;}
    center>button i{font-size:16px;margin-left:8px;}
    .card-header{color: white;font-size: 18px;font-weight: 300;font-family: sans-serif;letter-spacing: 0.5px;text-shadow: #47474757 3px 3px 2px;}
    .card-header.bgFirst{background: linear-gradient(45deg, #33acf2, #2becda);}
    .card-header.bgSecond{background: linear-gradient(45deg, #33acf2, #9a5fee);}
    .card-header.bgThird{background:linear-gradient(45deg, #ea2e97, #ee5f5f);}
    .card-header.bgForth{background:linear-gradient(45deg, #4bc592, #42eacc);}
    .card-header.bgFifth{background:linear-gradient(45deg, #4b8cc5, #428dea);}
    .card-header.bgSixth{background:linear-gradient(45deg, #797b7c, #6e7271);}
    table tbody tr td{font-size:16px;}
    .myrow{
      display: flex;
      width: 100%;
      gap: 30px;
    }
    .one{
      background: red;
      height: 100px;
      flex: 1;
    }
    .two{
      background: blue;
      flex: 1;
    }
</style>
   

<div class="wrapper">
<h2 class="sumoTopHeading"><i class="bi bi-highlights"></i> Suomoto First (1<sup>st</sup>) Proceeding</h2>

<form id='formAjaxPost'>
<div class="container">

  <div class="myrow">
    <div class="one">
      <div class="mycard">
              <div class="card-header bgFirst">
              <strong>Case Details</strong>
              </div>
              <table class="table table-bordered">

                <tr>
                 
                 <th>Dharitree Case No</th>
                 <th>Application Date</th>
            
                </tr>
                <tr>
                 
                 <td><input type="hidden" required="" name="case_no" value="<?=$Pcases->case_no;?>"><?=$Pcases->case_no;?></td>
                 <td><?=$Pcases->lm_date;?></td>
                 <td class="hidden"><input type="hidden" required="" name="proposal_no" value="<?=$Pcases->proposal_no;?>"><?=$Pcases->proposal_no;?></td>
                 
                </tr>
            </table>
            </div>
      
    </div>
    
  </div>
  
    <div class="row my-4">
      <div class="col-md-6">
      
      </div>
      <div class="col-md-6">
      <?php
            if(!empty($Pcases->is_part=='Y'))
                    //var_dump($lmrmk);
            {?>

            <div class="mycard">
              <div class="card-header bgSecond">
              <strong>Partition Details</strong></div>

                <table class="table table-bordered">
                  <th>Partition Area</th>
                  <th>Applicant Details</th>
                   
                         
                 <tr>
                 <td>

                <?= $Pcases->part_area_b.'B-'.$Pcases->part_area_k.'K-'.$Pcases->part_area_lc.'L' ?> &nbsp;
                </td> 
                <td>
                  <?= $part_pattadar[0]->pdar; ?>
                </td>
                
                
                </tr>
               </table>
               
            <?php  }?>
          
            </div>  
            </div>
      </div>

        <div class="row my-5">
          <div class="col-md-12">
          <div class="mycard">
              <div class="card-header bgThird">
              <strong>Location Details</strong>
              </div>

              <table class="table table-bordered">

                <tr>
                 <th>District</th>
                 <th>Subdivision</th>
                 <th>Circle</th>
                 <th>Mouza</th>
                 <th>Lot</th>
                 <th>Village</th>
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
          </div>
        </div>
        
        <div class="row my-5">
          <div class="col-md-12">
          <div class="mycard">
              <div class="card-header bgForth">
              <strong>Dag wise area details</strong>
              </div>

              <table class="table table-bordered">

                <tr>
                 <th>Dag No</th>
                 <th>Patta No</th>
                 <th>Patta Type</th>
                 <th>Chitha area</th>
                 <th>Land Class</th>
                 <th>Proposed Land Class</th>
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
          </div>
        </div>

        <div class="row my-5">
          <div class="col-md-12">
          <div class="mycard">
              <div class="card-header bgFifth">
              <strong>Proceeding  Details</strong></div>
              
                <?php
                if($lmrmk)
                    //var_dump($lmrmk);
                    {?>

                <table class="table table-bordered">
                  <th>Proceeding</th>
                   
                   <th>Date Entry</th>           
                 <tr>
                 <td>

                <?= $lmrmk->co_order ?> &nbsp;
                </td> 
                
                <td>
                <?= $lmrmk->date_entry ?> &nbsp;
                </td> 
                </tr>
               </table>
               
            <?php  }?>
          
            </div>
          </div>
        </div>
        
        <div class="row my-5">
          <div class="col-md-12">
            <div class="mycard">
                <div class="card-header bgSixth">
                  <strong><i class="bi bi-arrow-right-circle"></i> Remark</strong></div>
                <table class="table table-bordered">
                  <textarea class="form-control" id='remark' name='remark' 
                  placeholder="" rows="5">
                  </textarea>
                  <textarea class="hidden" id='' name='user_code' 
                  placeholder="" rows="1"><?php echo $location['user_code']; ?>
                  </textarea>
                  <textarea class="hidden" id='' name='remark_suffix' 
                  placeholder="" rows="1"><?php echo $location['co_name']; ?>
                  </textarea>
                </table>
            </div> 
          </div>
        </div>
            <center>
            <span id='loading'></span><span id='msg'></span>
            <button type="submit" class="btn btn-sm btn-primary">Forward <i class="bi bi-arrow-right-circle"></i></button>
            </center>
            <br>


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

    if($("#remark").val().trim().length < 1)
    {
      alert("Please Enter Your Remark");
      return false; 
    }

    var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'SuomotoReclassification/coProceeding', 
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