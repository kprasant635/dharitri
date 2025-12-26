<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
<style type="text/css">
    .mis_report{
        background:#274472;
        padding-top: 10px;
        border-radius: 20px 20px 0px 0px;
    }
    .cardH {
        padding: 0;
    position: relative;
    display: flex;
    flex-direction: column;
    min-width: 0;
    word-wrap: break-word;
    background-color:#faebd78c;
    background-clip: border-box;
    border-radius:16px;
    box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;;
    transition: all 150ms ease-in-out;
    }

    .col-lg-6{
        margin-bottom: 15px;
    }
    /*my css*/
    .card-title {margin-bottom:20px;font-weight: 600;font-size: x-large;}
    .nHeading{font-weight: 600;text-transform: uppercase;letter-spacing: 1px;
    font-size:18px;text-align:center;color:white;}
    .form-control{border-radius: 0px;background:white;margin-top: 2px;height: 45px;} 
    #page-content-wrapper{background:white}  
    label{font-weight:bold;font-size: 15px;letter-spacing: 0.4px;}         
    .card-body{padding-top:0px;}
    .landAr{display:grid; grid-template-columns:100px 325px; justify-content:space-between;align-items:center}
    .landAr div.three{display: flex;justify-content: end;gap: 15px;}
    .landAr div.three p{margin-bottom:12px;text-align:left;}
    .landAr #landArea{background: aquamarine;width: max-content;padding: 10px;box-sizing: border-box;font-size: 18px;font-weight: bold;height:50px;display: flex;align-items: center;position:relative;z-index: 1;color: darkred;border: 1px solid darkred;border-radius:8px;margin-top: 10px;
    }
    #landArea::after{position: absolute;right:-11px;background:aquamarine;width:20px;height:20px;content:"";z-index: -1;transform:rotate(45deg);border-right:1px solid darkred;border-top: 1px solid darkred;}
    .card-heading{margin-bottom:20px;}
    label{margin-bottom:10px;}
    .otherInfo{display: grid;grid-template-columns: 1fr 1fr;gap:65px;}
    .agril{display: flex;flex-direction: column;background:linear-gradient(45deg, #a3f0b0, #a1f2ed);box-sizing: border-box;box-shadow: rgba(149, 157, 165, 0.2) 0px 8px 24px;padding: 15px;border-radius: 10px;}
    .radio-inline.myradio{display:flex;gap: 35px; font-weight: bold;}
    .radio-inline.myradio div span{margin-left:8px;font-weight:bold;}
    .radio-inline.myradio div input{box-shadow:none;}
    .partition{background:linear-gradient(45deg, #9cefeb, #9fc6f2)}
    .landAreaDetail tbody{font-size:20px !important;}
    .landAreaDetail tbody>tr>td{vertical-align: middle;font-weight:bold;}
    .landAreaDetail tbody>tr>td>input{height:38px;}
    .landAreaDetail th.Theading{background: linear-gradient(45deg, #8aee97, #3cf6c2);
    height: 45px; vertical-align: middle;font-size: 16px;}
    .bg-info {background: linear-gradient(45deg, #4e69ee, #993ce8);border-radius: 8px;color: white;font-weight: 600;letter-spacing: 1px;border-bottom: 3px solid #2826294a;}
    .bg-info button{margin-left: 20px;font-weight: bold; padding: 6px 10px;}
    center>button[type='submit']{padding: 8px 20px;font-size: 15px;font-weight: bold;outline: 4px solid #ffc10736;}
    center>button i{font-size:16px;margin-left:8px;}
    #fieldList button{background: #d64141;border-radius: 5px;width: 100px;margin-top: 35px;}
    #fieldList input{height:auto;}
    
    .wrapper{width:100%;box-sizing:border-box;padding:25px;margin-bottom:40px;}

.SectionDetail{width:100%;display:grid;grid-template-columns:300px 1fr;gap:150px;align-items:center;margin-bottom:50px;padding: 10px 20px;}

.SectionDetail.Dag{width:100%;display:grid;grid-template-columns:1fr 300px;gap:150px;align-items:center;margin-bottom:50px;padding: 10px 20px;}

.SectionDetail.Dag .indecator{background:#fa55f0;right:30px;}

.SectionDetail.Dag .indecator::after{position: absolute;left:-25px;background:#fa55f0;width:50px;height:50px;content:"";z-index: -1;transform:rotate(45deg);}
/* .SectionDetail.Dag .indecator{right:50px;} */

.SectionDetail .dataPart table{margin-top:20px;}
.SectionDetail table tbody>tr>td{padding:10px;}
.SectionDetail table{box-shadow: rgba(0, 0, 0, 0.1) 0px 0px 5px 0px, rgba(0, 0, 0, 0.1) 0px 0px 1px 0px;}
.SectionDetail table tbody>tr:first-child{background: linear-gradient(45deg, #4deaad, #54e6f0);font-weight: 600;font-size: 16px;}

.indecator{width:330px;height:200px;padding: 10px;box-sizing: border-box;display: flex;align-items: center; justify-content:center; position:relative;z-index: 1;border-radius:8px;flex-direction:column}

.indecator::after{position: absolute;right:-25px;width:50px;height:50px;content:"";z-index: -1;transform:rotate(45deg);}

#locationD{background:#7fbcff}
#locationD::after{background:#7fbcff}
#DagD{background:#fa55ae}
#DagD::after{background:#fa55ae}
#paymentD{background:#a4ff7f}
#paymentD::after{background:#a4ff7f}

.indecator span{
  width: 70px;
    height: 70px;
    border: 1px solid black;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    font-size: 30px;
    margin-bottom: 15px;
}

.indecator h3{font-family: sans-serif;}

center button[type='button']{padding: 8px 20px;font-size: 15px;font-weight: bold;outline: 4px solid #0740ff36;}
center button i{font-size:16px;margin-left:8px;}

@media(max-width:768px){
  .SectionDetail{width:100%;display:grid;grid-template-columns:auto;gap:0px;}
  .arrowPart{display:none}
  .SectionDetail.Dag{width:100%;display:grid;grid-template-columns:auto;gap:0px;}
}
    
</style>


<form method="post" action="<?php echo base_url(); ?>index.php/SuomotoReclassification/paymentConfirmP" enctype="multipart/form-data" id="formsubmit">


<div class="row login">
        <div class="cardH col-md-12">
           <div class="well well-sm mis_report">
                <h2 class="nHeading"> Payment Confirmation for Suomoto-reclass cases </h2>
            </div>

            <?php if ($this->session->flashdata('message')): ?>
        <?php include 'message.php'; ?>
    <?php endif; ?>



    <!--start code-->
    <div class="wrapper">
      <div class="SectionDetail">
          <div class="arrowPart" >
            <div class="indecator"id="locationD">
              <span><i class="bi bi-pin-map-fill"></i></span>
              <h3>Location Details</h3>
            </div>
          </div>
          <div class="dataPart">
            <div class="showData">
              <table class="table table-striped table-hover">
                <tbody>
                  <tr style="background:#7fbcff">
                    <td colspan="2">Location Detail</td>
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
                </tbody>
              </table>
            </div>
          </div>
      </div>
      <div class="SectionDetail Dag">
          <div class="dataPart">
            <div class="showData">
              <table class="table table-striped table-hover">
                <tbody>
                  <tr style="background:#fa55ae">
                    <td colspan="2">Dag Details</td>
                  </tr>
                  <tr>
                    <td>Dag Number</td>
                    <td><?=$details->dag_no;?></td>
                  </tr>
                  <tr>
                    <td>Patta Number</td>
                    <td><?=$details->patta_no?></td>
                  </tr>
                  <tr>
                    <td>Patta Type</td>
                    <td><?=$details->patta_type_code?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="arrowPart" >
            <div class="indecator"id="DagD">
              <span><i class="bi bi-clipboard2-check"></i></span>
              <h3>Dag Details</h3>
            </div>
          </div>
      </div>
      <div class="SectionDetail">
          <div class="arrowPart">
            <div class="indecator"id="paymentD">
              <span><i class="bi bi-currency-rupee"></i></span>
              <h3>Payment Details</h3>
            </div>
          </div>
          <div class="dataPart">
            <div class="showData">
              <table class="table table-striped table-hover">
                <tbody>
                  <tr style="background:#a4ff7f">
                    <td colspan="2">Payment Details</td>
                  </tr>
                  <tr>
                    <td>Status</td>
                    <td><?=$details->status=='D'?'Payment Successful':'Payment Not done yet'  ;?></td>
                  </tr>
                  <tr>
                    <td>Amount</td>
                    <td> <?=$details->amount?></td>
                  </tr>
                  <tr>
                    <td>Payment Date</td>
                    <td><?=$details->entry_date?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
      </div>
      <center>
      <span id='loading'></span><span id='msg'></span>
          <button type="button" class="btn btn-sm btn-primary" onclick="showWarningMessage()" 
          >Confirm Payment <i class="bi bi-arrow-right-circle"></i></button>
      </center>
    </div>
    <!--end code-->
    
                
                    
                </div>
            </div>
        </div>
    </div>
</form>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script type="text/javascript">

// function showWarningMessage() {
//     swal.fire({
//       title: "Warning!",
//       text: 'Confirm',
//       icon: 'warning',
//       position: 'top',
//       showConfirmButton: false,
//       timer: 5000,
//       showCancelButton: true
//     });
//   }


function showWarningMessage() {
      Swal.fire({
                    icon: 'info',
                    title: 'Disclaimer',
                    text: 'Are you sure to Confirm the payment?'
                }).then((result) => {
                    if (result.isConfirmed) {
                       $('#formsubmit').submit();
                    }
                });
            }
</script>
