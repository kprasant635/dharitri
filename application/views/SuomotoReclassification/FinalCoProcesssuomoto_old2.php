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
    .wrapper{padding: 25px !important;background:white;margin-top:25px;border-radius:10px;}

    .sumoTopHeading{font-family: sans-serif;font-size:22px;font-weight: 600;color:#383838;text-align:left;border-bottom: 3px double #6c6a6a; width:fit-content;padding-bottom: 7px;padding-left: 7px;margin-bottom:30px;border-radius:10px;}
    table{box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px;}
    table tr{font-size:13px;}
    table th{font-size:16px !important;font-weight: 300;font-family: sans-serif;letter-spacing: 0.5px;}

    section{display:grid;grid-template-columns:minmax(250px, 400px) 1fr;background:#0b4e4a;padding:20px;align-items:center;gap:50px;margin-bottom: 40px;border-radius: 10px;}

    section.locationDetail{display:grid;grid-template-columns:1fr minmax(250px, 400px);background:#274472;}

    section.Dag{background:#4e2b0b}

    section.partition{display:grid;grid-template-columns:1fr minmax(250px, 400px);background:#274472;}

    section.procedding{background:#0d4b52}

    .left{display: flex;justify-content: center;}
    /* .right{background:lightgreen} */
    
    /* .titleHeading{font-family: sans-serif;margin-bottom: 20px;color:white;} */
    center>button[type='submit']{padding: 8px 20px;font-weight: bold;outline: 4px solid #ffc10736;font-size: 16px;font-weight: 500;outline: 4px solid #0712ff36;}
    center>button i{font-size:16px;margin-left:8px;}

    .circle{width:250px;height:250px;border:10px solid white; border-radius:50%;display:flex;align-items:center;justify-content:center;background:linear-gradient(45deg, black, transparent);border:5px solid white}
    .circle h2{text-indent: initial;color:white;text-align: center;font-size: xx-large;}

    .outer{width:100%;display:grid;grid-template-columns:1fr 1fr;align-items: stretch;}
    .firstSection{padding-right:15px}
    .secondSection{border-left: 1px solid #aba7a7;padding-left: 15px;padding-bottom:40px;}
    .updateChittha{
      width: 300px;
    height: 113px;
    outline: 1px solid #ccc;
    margin: 0 auto;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
    }
    @media(max-width:915px){
      .caseDetail{grid-template-columns:auto;}
      .caseDetail .left{display:none}
      .outer{grid-template-columns:auto;}
      .firstSection{padding:0px}
      .secondSection{padding:0px;border-left:0px}
    }
</style>
   

<div class="wrapper">
<h2 class="sumoTopHeading"><i class="bi bi-highlights"></i>
Suomoto Final Chitha Update</h2>

<form id='formAjaxPost'>
<div class="container">

  <!--start new-->
  <div class="outer">
    <div class="firstSection">
    <table class="table table-striped table-hover" width="100%">
        <tbody>
          <tr style="background:linear-gradient(45deg, #e9da4b, #d6ee69)">
            <th colspan="2">Case Deatil</th>
          </tr>
          <tr>
            <td>Dharitree Case Numbar</td>
            <td><input type="hidden" required="" name="case_no" value="<?=$Pcases->case_no;?>"><?=$Pcases->case_no;?></td>
          </tr>
          <tr>
            <td>Application Date</td>
            <td><?=$Pcases->lm_date;?></td>
          <td class="hidden"><input type="hidden" required="" name="proposal_no" value="<?=$Pcases->proposal_no;?>"><?=$Pcases->proposal_no;?></td>
          </tr>
        </tbody>
      </table>
      
      <table class="table table-striped table-hover" width="100%">
          <tbody>
            <tr style="background:linear-gradient(45deg, #7de94b, #d6ee69)">
              <th colspan="2">Location Deatil</th>
            </tr>
            <tr>
              <td>District</td>
              <td><?=$location['dist'];?></td>
            </tr>
            <tr>
              <td>Subdivision</td>
              <td> <?=$location['sub']?></td>
            </tr>
            <tr>
              <td>Circle</td>
              <td><?=$location['cir']?></td>
            </tr>
            <tr>
              <td>Mouza</td>
              <td><?=$location['mouza']?></td>
            </tr>
            <tr>
              <td>Lot</td>
              <td><?=$location['lot']?></td>
            </tr>
            <tr>
              <td>Village</td>
              <td><?=$location['vill']?></td>
            </tr>
            <?php
            if(!empty($Pcases->is_part=='Y'))
              //var_dump($lmrmk);
            {?>
            <tr>
            <td>Partition Area</td>
            <td><?= $Pcases->part_area_b.'B-'.$Pcases->part_area_k.'K-'.$Pcases->part_area_lc.'L' ?> &nbsp;
            </td>
            <td> <?= $part_pattadar[0]->pdar; ?>
            </td>
          </tr>
            <?php  }?>
          </tbody>
        </table>
        <!-- <div class="showData">
          <?php
            if(!empty($Pcases->is_part=='Y'))
                    //var_dump($lmrmk);
            {?>
            <table class="table table-striped table-hover" width="100%">
              <tbody>
                <tr style="background:none">
                  <th colspan="2">Partition Details</th>
                </tr>
                <tr>
                  <td>Partition Area</td>
                  <td><?= $Pcases->part_area_b.'B-'.$Pcases->part_area_k.'K-'.$Pcases->part_area_lc.'L' ?> &nbsp;
                  </td>
                </tr>
              </tbody>
            </table>
          <?php  }?>
        </div> -->
    </div>
    <div class="secondSection">
    <div class="showData">
      <table class="table table-striped table-hover" width="100%">
        <tbody>
          <tr style="background:linear-gradient(45deg, #f45a5a, #f573d9)">
            <th colspan="2">Dag wise area details</th>
          </tr>
          <tr>
            <td>Dag Number</td>
            <td><?= $Pcases->dag_no ?></td>
          </tr>
          <tr>
            <td>Patta Numbar</td>
            <td> <?= $Pcases->patta_no ?></td>
          </tr>
          <tr>
          <td>Patta Type</td>
          <td><?=$this->utilityclass->getPattaType($Pcases->patta_type_code)?></td>
          </tr>
          <tr>
          <td>Chitha area</td>
          <td><?= $Pcases->dag_area_b.'B-'.$Pcases->dag_area_k.'K-'.$Pcases->dag_area_lc.'L' ?></td>
          </tr>
          <tr>
          <td>Land Class</td>
          <td><?=$this->utilityclass->getLandClassCode($Pcases->exist_land_class);?></td>
          </tr>
          <tr>
          <td>Proposed Land Class</td>
          <td><?=$this->utilityclass->getLandClassCode($Pcases->present_land_class);?></td>
          </tr>
        </tbody>
      </table>
      </div><!--end show details-->
      <div class="showData">
    <?php
                if($lmrmk)
                    //var_dump($lmrmk);
                    {?>

                <table class="table table-stripped table-hover">
                  <tr style="background:linear-gradient(45deg, #4faaee, #a6aaff)">
                  <th>Proceeding</th>
                   <th>Date Entry</th> 
                  </tr>
                   
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
    </div>
    
  </div>
  <div class="updateChittha">
      <center>
      <span id='loading'></span><span id='msg'></span>
      <button type="submit" class="btn btn-sm btn-primary"><i class='fa fa-check-square-o'></i> Update Chitha</button>
      </center>
    </div>
  <!--end new-->


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