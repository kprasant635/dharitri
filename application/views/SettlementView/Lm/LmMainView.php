<style>

  .tab-content .card:hover{
    left: 0;
    right: 0;
    top: 0;
    bottom: 0;
    /* box-shadow: none !important; */
  }
  .tab-content .card:active{
    /* left: 0;
    right: 0;
    top: 0;
    bottom: 0; */
    box-shadow: none !important;
  }

  .wizard {
    margin: 10px auto;
}

.wizard .nav-tabs {
    position: relative;
    margin: 0px auto;
    margin-bottom: 0;
    border-bottom-color: #e0e0e0;
}

.wizard > div.wizard-inner {
    position: relative;
}


.wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
    color: #fff;
    cursor: default;
    border: 0;
    background-color: #005B96 !important;
    text-decoration: none;
}
.wizard li.active{
    background: #005B96;
    padding: 5px;
    box-shadow: 1px 0px 1px 1px;
    
}

.wizard .nav-tabs > li {
    width: 16%;
    border: none;
}

.wizard li:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: #5bc0de;
    transition: 0.1s ease-in-out;
}

.wizard li.active:after {
    content: " ";
    position: absolute;
    left: 45%;
    opacity: 1;
    margin: 0 auto;
    bottom: 0px;
    border: 10px solid transparent;
    border-bottom-color: #ffffff;
}

.wizard .nav-tabs > li a {
    text-align: center;
    /* width: 90%; */
    margin-bottom: 10px;
    /* padding: 0; */
}
.wizard .nav-tabs > li a:hover {
  background-color: transparent !important;
}



/* .wizard .tab-pane {
    position: relative;
    padding-top: 15px;
} */

/* .wizard h3 {
    margin-top: 0;
} */
/* 
@media( max-width : 585px ) {

    .wizard {
        width: 90%;
        height: auto !important;
    }

    span.round-tab {
        font-size: 16px;
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard .nav-tabs > li a {
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 35%;
    }
} */
/* div alternate color */
div.lm-report > div:nth-of-type(odd) {
    background: #f2fdff;
}

</style>

<script>
$(document).ready(function () {
    //Initialize tooltips
    $('.nav-tabs > li a[title]').tooltip();
    
    //Wizard
    $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {

        var $target = $(e.target);
    
        if ($target.parent().hasClass('disabled')) {
            return false;
        }
    });

    $(".next-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        $active.next().removeClass('disabled');
        nextTab($active);

    });
    $(".prev-step").click(function (e) {

        var $active = $('.wizard .nav-tabs li.active');
        prevTab($active);

    });
});

function nextTab(elem) {
    $(elem).next().find('a[data-toggle="tab"]').click();
}
function prevTab(elem) {
    $(elem).prev().find('a[data-toggle="tab"]').click();
}

</script>

<div class="container">
  <div class="row">
    <section>
      <div class="wizard">
        <div class="wizard-inner">
          <div class="connecting-line"></div>
          <ul class="nav nav-tabs shadow" role="tablist">
            <li role="presentation" class="active">
              <a
                class="test"
                href="#step1"
                data-toggle="tab"
                aria-controls="step1"
                role="tab"
                title="Step 1"
              >
                <span class="round-tab">
                  <strong>Application</strong>
                </span>
              </a>
            </li>

            <li role="presentation" class="disabled">
              <a
                href="#step2"
                data-toggle="tab"
                aria-controls="step2"
                role="tab"
                title="Step 2"
              >
                <span class="round-tab">
                  <strong>Lot Mondal</strong>
                </span>
              </a>
            </li>
            <li role="presentation" class="disabled">
              <a
                href="#step3"
                data-toggle="tab"
                aria-controls="step3"
                role="tab"
                title="Step 3"
              >
                <span class="round-tab">
                  <strong>Circle Officer</strong>
                </span>
              </a>
            </li>

            <li role="presentation" class="disabled">
              <a
                href="#step4"
                data-toggle="tab"
                aria-controls="step4"
                role="tab"
                title="step 4"
              >
                <span class="round-tab">
                  <strong>Additional Deputy Commissioner</strong>
                </span>
              </a>
            </li>
            <li role="presentation" class="disabled">
              <a
                href="#step5"
                data-toggle="tab"
                aria-controls="step5"
                role="tab"
                title="step 5"
              >
                <span class="round-tab">
                  <strong>Deputy Commissioner</strong>
                </span>
              </a>
            </li>
            <li role="presentation" class="disabled">
              <a
                href="#complete"
                data-toggle="tab"
                aria-controls="complete"
                role="tab"
                title="Complete"
              >
                <span class="round-tab">
                  <strong>Department</strong>
                </span>
              </a>
            </li>
          </ul>
        </div>

        <form role="form">
          <div class="tab-content">
            <div class="tab-pane active" role="tabpanel" id="step1">
              <h5 class="bg-info p-2 text-white shadow">
                Registration of Settlement of PGR VGR land (
                <span class="bg-warning"><?=$_GET['app']?></span> )
              </h5>
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Address Information</h5>
                  <p class="card-text">
                   <table class="table table-bordered">
                    <tr>
                      <th>District Name:</th>
                      <td class="text-warning">
                        <strong class="alert-warning">
                          <input type="text" name="dist_name" class="form-control" value="Jayanta Sonowal">
                        </strong></td>
                      <th>Subdivision Name:</th>
                      <td class="text-warning">
                        <strong class="alert-warning"> 
                          <input type="text" name="subdiv_name" class="form-control" value="Guwahati Sub div">
                        </strong>
                      </td>
                    </tr>
                    <tr>
                      <th>Circle Name: </th>
                      <td class="text-warning">
                        <strong class="alert-warning">
                          <input type="text" name="circle_name" value="Dibrugarh" class="form-control">
                        </strong></td>
                      <th>Mouza Name: </th>
                      <td class="text-warning">
                        <strong class="alert-warning">
                          <input type="text" name="mouza_name" class="form-control" value="Sivsagar">
                        </strong>
                      </td>
                    </tr>
                    <tr>
                      <th>Dag Number: </th>
                      <td class="text-warning">
                        <strong class="alert-warning">
                          <input type="text" name="dag_number" value="554" class="form-control">
                        </strong>
                      </td>
                      <th>Village Name: </th>
                      <td class="text-warning">
                        <strong class="alert-warning">
                          <input type="text" name="village_name" value="Kalyani Nagar" class="form-control">
                        </strong>
                      </td>
                    </tr>
                    <tr>
                      <th>Patta Number: </th>
                      <td class="text-warning">
                        <strong class="alert-warning">
                          <input type="text" name="patta_number" class="form-control" value="10">
                        </strong>
                      </td>
                      <th>Patta type: </th>
                      <td class="text-warning">
                        <strong class="alert-warning">
                          <input type="text" name="patta_type" value="test" class="form-control">
                        </strong>
                      </td>
                    </tr>

                   </table>
                  </p>

                  <h5 class="card-title"><u>Self declaration details</u></h5>
                  <p class="card-text">
                    <table class="table table-bordered">
                      <tr>
                        <th>Are You a Citizen of India ?</th>
                        <td>
                          <input type="radio" name="citizen_india" id="citizen_india1" value="Yes" class="form-check-input">
                          <label for="Yes">Yes</label>        
                          
                          <input type="radio" name="citizen_india" id="citizen_india2" value="No" class="form-check-input">
                          <label for="Yes">No</label>
                        </td>
                      </tr>
                      <tr>
                        <th>Whether any case pending in Foreigners Tribunal ?</th>
                        <td>
                          <input type="radio" name="pending_foreign_tribunal" value="Yes" class="form-check-input">
                          <label for="foreign">Yes</label>
                          
                          <input type="radio" name="pending_foreign_tribunal" value="No" class="form-check-input">
                          <label for="foreign">No</label>
                        </td>
                      </tr>
                      <tr>
                        <th>Whether any case pending with Border Branch of Assam Police under Foreigners Act, 1946 ?</th>
                        <td>
                          <input type="radio" name="case_pending_assam_police" value="Yes" class="form-check-input">
                          <label for="foreign">Yes</label>
                
                          <input type="radio" name="case_pending_assam_police" value="No" class="form-check-input">
                          <label for="foreign">No</label>
                        </td>
                      </tr>
                      <tr>
                        <th>Are you an Indigenous people of Assam ?</th>
                        <td>
                          <input type="radio" name="indigenous_people" value="Yes" class="form-check-input">
                          <label for="foreign">Yes</label>
                      
                          <input type="radio" name="indigenous_people" value="No" class="form-check-input">
                          <label for="foreign">No</label>
                        </td>
                      </tr>
                      <tr>
                        <th>Whether SC/ST/OBC ?</th>
                        <td>
                          <input type="radio" name="whether_st" value="Yes" class="form-check-input">
                          <label for="foreign">Yes</label>
                      
                          <input type="radio" name="whether_st" value="No" class="form-check-input">
                          <label for="foreign">No</label>
                        </td>
                      </tr>
                      <tr>
                        <th>Whether erosion affected ?</th>
                        <td>
                          <input type="radio" name="whether_erosion" value="Yes" class="form-check-input">
                          <label for="foreign">Yes</label>
                       
                          <input type="radio" name="whether_erosion" value="No" class="form-check-input">
                          <label for="foreign">No</label>
                        </td>
                      </tr>
                      <tr>
                        <th>Whether landless as per land policy 2019 ?</th>
                        <td>
                          <input type="radio" name="whether_landless" value="Yes" class="form-check-input">
                          <label for="foreign">Yes</label>
                       
                          <input type="radio" name="whether_landless" value="No" class="form-check-input">
                          <label for="foreign">No</label>
                        </td>
                      </tr>
                      <tr>
                        <th>Do you agree to the access of your information from publicly available database ?</th>
                        <td>
                          <input type="radio" name="agree_information_public_db" value="Yes" class="form-check-input">
                          <label for="foreign">Yes</label>
                        
                          <input type="radio" name="agree_information_public_db" value="No" class="form-check-input">
                          <label for="foreign">No</label>
                        </td>
                      </tr>
                    </table>
                  </p>
                 
                  <h5 class="card-title"><u>First Party Information/Applicant details</u></h5>
                  <p class="card-text">
                    <table class="table table-bordered">
                      <tr>
                        <th>#</th>
                        <th>Name </th>
                        <th>Gurdian </th>
                        <th>Relation </th>
                        <th>Gender </th>
                        <th>Mobile </th>
                        <th>Individual land share</th>
                      </tr>
                        <td>1</td>
                        <td>
                          <input type="text" name="applicant_name" value="Jayanta Sonowal" class="form-control">
                        </td>
                        <td>
                          <input type="text" name="gurdian_name" value="Abhijit Pathak" class="form-control">
                        </td>
                        <td>
                          <input type="text" value="Father" name="relation" class="form-control">
                        </td>
                        <td>
                          <input type="text" name="gender" class="form-control" value="Male">
                        </td>
                        <td>
                          <input type="text" name="phone_no" value="7002516530" class="form-control">
                        </td>
                        <td>
                          <label for="Bigha">Bigha</label> 
                          <strong><input type="text" value="5" name="total_bigha" class="form-control">
                          </strong> 
                          <label for="katha">katha</label>
                          <strong><input type="text" value="2.5" name="total_katha" class="form-control">
                          </strong> 
                          <label for="Lessa">Lessa</label> 
                          <strong><input type="text" name="total_lessa" value="1" class="form-control">
                          </strong> 
                          <label for="Ganda">Ganda</label>
                          <strong><input type="text" name="total_ganda" value="0" class="form-control">
                          </strong> 
                          <label for="Kranti">Kranti</label> 
                          <strong><input type="text" value="2" name="total_kranti" class="form-control">
                          </strong>
                        </td>
                      <tr>
                      </tr>
                        <td>2</td>
                        <td>Bidyut Deori</td>
                        <td>Abhijit Pathak</td>
                        <td>Father</td>
                        <td>Male</td>
                        <td>7002516530</td>
                        <td>
                          <label for="Bigha">Bigha</label> 
                          <strong><input type="text" value="5" name="individual_bigha" class="form-control">
                          </strong> 
                          <label for="katha">katha</label>
                          <strong><input type="text" value="2.5" name="individual_katha" class="form-control">
                          </strong> 
                          <label for="Lessa">Lessa</label> 
                          <strong><input type="text" name="individual_lessa" value="1" class="form-control">
                          </strong> 
                          <label for="Ganda">Ganda</label>
                          <strong><input type="text" name="individual_ganda" value="0" class="form-control">
                          </strong> 
                          <label for="Kranti">Kranti</label> 
                          <strong><input type="text" value="2" name="individual_kranti" class="form-control">
                          </strong>
                        </td>
                      <tr>

                      </tr>
                    </table>
                  </p>

                  <h5 class="card-title"><u>Application Details</u></h5>
                  <p class="card-text">
                    <table class="table table-bordered">
                        <tr>
                          <th>Aadhaar Verified</th>
                          <td>
                            <input type="text" name="aadhar_verified" value="Yes" class="form-control" disabled>
                          </td>
                        </tr>
                        <tr>
                          <th>Period of Possession</th>
                          <td>
                            <input type="text" name="period_possession" class="form-control" value="2021-03-21">
                          </td>
                        </tr>
                        <tr>
                          <th>Occupation or Profession of the applicant</th>
                          <td>
                            <input type="text" name="occupation_applicant" value="Service" class="form-control">
                          </td>
                        </tr>
                        <tr>
                          <th>Nature of occupation over the land</th>
                          <td>
                            <input type="text" value="Agricultural" name="nature_occupation" class="form-control">
                          </td>
                        </tr>
                    </table>
                  </p>
                  <h5 class="card-title"><u>Area Details</u></h5>
                  <p class="card-text">
                    <table class="table table-bordered">
                        <tr>
                          <th>Description</th>
                          <th>Bigha</td>
                          <th>Katha</td>
                          <th>Lessa</td>
                          <th>Ganda</td>
                          <th>Kranti</td>
                        </tr>
                        <tr>
                          <th>Total Land Area in Selected Dag</th>
                          <td>
                            <input type="text" name="total_bigha" class="form-control" value="0">
                          </td>
                          <td>
                            <input type="text" name="total_katha" value="1" class="form-control">
                          </td>
                          <td>
                            <input type="text" name="total_lessa" class="form-control" value="2">
                          </td>
                          <td>
                            <input type="text" value="-" class="form-control" name="total_ganda">
                          </td>
                          <td>
                            <input type="text" value="-" class="form-control" name="total_kranti">
                          </td>
                        </tr>
                 
                    </table>
                  </p>

                  <h5 class="card-title"><u>Next of Kin details</u></h5>
                  <p class="card-text">
                    <table class="table">
                      <tr>
                        <th>Next of KIN name</th>
                        <th>Relation with KIN</th>
                        <th>Address of KIN</th>
                        <th>Mobile number</th>
                      </tr>
                      <tr>
                        <td>
                          <input type="text" name="kin_name" value="Jayanta Sonowal" class="form-control">
                        </td>
                        <td>
                          <input type="text" name="kin_relation" value="Father" class="form-control">
                        </td>
                        <td>
                          <input type="text" class="form-control" value="Dibrugarh" name="kin_address">
                        </td>
                        <td>
                          <input type="text" name="kin_contact_no" value="8403903066" class="form-control">
                        </td>
                      </tr>
                    </table>
                  </p>

                  <h5 class="card-title"><u>Supporting Documents</u></h5>
                  <p class="card-text">
                    <table class="table">
                      <tr>
                        <th>
                          <a href="#">Bedakhali Jorimona details</a> 
                          <input type="hidden" value="link">
                        </th>
                      </tr>
                      <tr>
                        <th><a href="#"> Caste Certificate</a></th>
                        <input type="hidden" value="link">
                      </tr>
                      <tr>
                        <th><a href="#"> Citizenship Certificate</a></th>
                        <input type="hidden" value="link">
                      </tr>
                    </table>
                  </p>

            <!-- <a href="#lm_report" onclick="lm()" class="btn btn-primary text-white">Go to LM report</a> -->
                </div>
              </div>

         




              <ul class="list-inline pull-right">
                <li>
                  <button type="button" class="btn btn-primary next-step">
                    Save and continue
                  </button>
                </li>
              </ul>
            </div>

            <!-- LM reporting starts here -->

            <div class="tab-pane" role="tabpanel" id="step2">
              <h5 class="bg-info p-2 text-white shadow">
                LM(A) reporting for Settlement of Khas and ceiling Surplus land (
                <span class="bg-warning"><?=$_GET['app']?></span> )
              </h5>

              <div class="card">
                <div class="card-body lm-report">
                  <h5 class="card-title">
                    <u>LM Reporting format</u>
                  </h5>
                  <p class="card-text mt-3">
                    <form action="#">
                      <?php 
                        $sl_count = 1; 
                        $service_code = 14;
                          if($service_code == 13){
                            include("SettlementOccupancy.php");
                          }elseif($service_code == 14){
                            include("SettlementApTransferred.php");
                          }elseif($service_code == 15){
                            include("SettlementTribalCommunity.php");
                          }elseif($service_code == 16){
                            include("SettlementKhasland.php");
                          }elseif($service_code == 17){
                            include("SettlementPgrVgr.php");
                          }elseif($service_code == 18){
                            include("SettlementCultivators.php");
                          }
                       ?>
                    </form>
                  </p>
                </div>
              </div>


              <ul class="list-inline pull-right">
                <li>
                  <button type="button" class="btn btn-default prev-step">
                    Previous
                  </button>
                </li>
                <li>
                  <button type="button" class="btn btn-primary next-step">
                    Save and continue
                  </button>
                </li>
              </ul>
            </div>
            <div class="tab-pane" role="tabpanel" id="step3">
              <h3>Step 3</h3>
              <p>This is step 3</p>
              <ul class="list-inline pull-right">
                <li>
                  <button type="button" class="btn btn-default prev-step">
                    Previous
                  </button>
                </li>
                <li>
                  <button type="button" class="btn btn-default next-step">
                    Skip
                  </button>
                </li>
                <li>
                  <button
                    type="button"
                    class="btn btn-primary btn-info-full next-step"
                  >
                    Save and continue
                  </button>
                </li>
              </ul>
            </div>
            <div class="tab-pane" role="tabpanel" id="complete">
              <h3>Complete</h3>
              <p>You have successfully completed all steps.</p>
            </div>
            <div class="clearfix"></div>
          </div>
        </form>
      </div>
    </section>
  </div>
</div>
