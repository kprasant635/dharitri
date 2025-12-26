<style>
    /* The Close Button */
    .close-edit-area {
      color: #aaaaaa;
      float: right;
      font-size: 28px;
      font-weight: bold;
    }

    .close-edit-area:hover,
    .close-edit-area:focus {
      color: #000;
      text-decoration: none;
      cursor: pointer;
    }
    .reza-title{
      font-weight: bold;
      font-size: 18px;
      margin-bottom: 10px;
      margin-top: 10px;
      background: linear-gradient(to right, #267871, #136a8a);
      color: white;
      text-transform: capitalize;
      text-align: center;
      padding: 8px;
   }
</style>

<input type="hidden" id="case_no" value="<?=$basic['case_no']?>">
<input type="hidden" id="code_service" value="<?=$basic['service_code']?>">
<input type="hidden" id="code_dist" value="<?=$basic['dist_code']?>">
<input type="hidden" id="code_sub" value="<?=$basic['subdiv_code']?>">
<input type="hidden" id="code_cir" value="<?=$basic['cir_code']?>">
<input type="hidden" id="code_mouza" value="<?=$basic['mouza_pargona_code']?>">
<input type="hidden" id="code_lot" value="<?=$basic['lot_no']?>">
<input type="hidden" id="code_vill" value="<?=$basic['vill_townprt_code']?>">
<?php 
  foreach($dags as $r){
      $urban = $r->is_urban;
      break;
  }
?>
<input type="hidden" id="code_rural_urban" value="<?=$urban?>">


<?php

  $service_code = $basic['service_code'];

  if($service_code == SETTLEMENT_KHAS_LAND_ID){
    $max_bigha_home = KHAS_MAX_HOMESTEAD;
    $max_bigha_agri = KHAS_MAX_AGRICULTURE;
  }
  else if($service_code == SETTLEMENT_PGR_VGR_LAND_ID){
    $max_bigha_home = VGR_PGR_MAX_HOME;
  }
  else if($service_code == SETTLEMENT_SPECIAL_CULTIVATORS_ID){
    $max_bigha_agri = CULTIVATION_MAX_APPLIED;
  }
  else if($service_code == SETTLEMENT_TRIBAL_COMMUNITY_ID){
    $max_bigha_home = TRIBAL_MAX_HOMESTEAD;
    $max_bigha_agri = TRIBAL_MAX_AGRICULTURE;
  }
  else {
    $max_bigha_home = MAX_BIGHA;
    $max_bigha_agri = MAX_BIGHA;
  }

?>

<div id="newDagEntryDetails" class="modal">
  <!-- Modal content -->
  <div class="modal-content">
    <div class="row text-right">
      <span class="close-new-dag-entry px-4" style="cursor:pointer;">&times;</span>
    </div><p>
    
    <div class="row">
      <div class="col-md-12 text-center">
        <h5 class="reza-title">
          New Dag Entry Form
        </h5>
      </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

      <div class="form-group col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <label>Choose Dag to be added</label>
        <select class="form-control" id="dag_list">
          <option value="" disabled selected>-- Select Dag --</option>
        </select>
      </div>


      <div class="encroacher_detail">


        <div class="field_reset">
          <span id="natureof_landErr" class="form__input__error__msg"></span>
          <div class="form__div">
            <div class="form__input ps-3">
              <label class="form-check-label"><strong>I am applying for</strong></label> &nbsp;

              <?php if($service_code != SETTLEMENT_SPECIAL_CULTIVATORS_ID ) { ?>
              <div class="form-check form-check-inline">
                <input class="form-check-input natureof_land" type="radio" 
                name="natureof_land" value="<?=HOMESTEAD?>" >
                <label class="form-check-label">Homestead</label>
              </div>
              <?php } if($service_code != SETTLEMENT_PGR_VGR_LAND_ID ) { ?>

              <div class="form-check form-check-inline">
                <input class="form-check-input natureof_land" type="radio" 
                name="natureof_land" value="<?=AGRICULTURAL?>">
                <label class="form-check-label">Agriculture</label>
              </div>
              <?php } ?>

              <?php if($service_code == SETTLEMENT_KHAS_LAND_ID || $service_code == SETTLEMENT_TRIBAL_COMMUNITY_ID) { ?>
                <div class="form-check form-check-inline">
                  <input class="form-check-input natureof_land" type="radio" 
                  name="natureof_land" value="<?=BOTH_LAND?>">
                  <label class="form-check-label">Both</label>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>

        <!--------- homestead starts here ---------->
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 for_homestead" style="display:none">

          <span style="color:green">Area Under HOMESTEAD</span>
          <div class="row">
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
              <span id="hbighaErr" class="form__input__error__msg"></span>
              <div class="form__div">                         
                Bigha <select id="hbigha" 
                class="form-select ps-3">
                  <?php for($i=MIN_VALUE; $i<=$max_bigha_home; $i++) { ?>
                    <option value="<?=$i?>" > <?=$i?> </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
              <span id="hkathaErr" class="form__input__error__msg"></span>
              <div class="form__div" id="home_katha" style="display: none;">
                Katha <select id="hkatha" class="form-select ps-3">
                  <?php for($i=MIN_VALUE; $i<=MAX_KATHA; $i++) { ?>
                    <option value="<?=$i?>" > <?=$i?> </option>
                  <?php } ?>
                </select>
              </div>
              <div class="form__div" id="home_katha_barak" style="display: none;">
                Katha <select id="hkatha_barak" class="form-select ps-3">
                  <?php for($i=MIN_VALUE; $i<=MAX_KATHA_BARAK; $i++) { ?>
                    <option value="<?=$i?>" > <?=$i?> </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
              <span id="hlessaErr" class="form__input__error__msg"></span>
              <span class="lessa_title">Lessa</span>
              <span class="chatak_title">Chatak</span>
              <div class="form__div">
                <input type="text" name="hlessa" max="20" 
                id="hlessa" class="form-control" value="0"
                oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
              </div>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 in_ganda_div" style="display:none">
              <span id="hgandaErr" class="form__input__error__msg"></span>
              Ganda
              <div class="form__div">
                <input type="text" name="hganda" max="20" 
                id="hganda" class="form-control" value="0"
                oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
              </div>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 in_kranti_div" style="display:none">
              <span id="hkrantiErr" class="form__input__error__msg"></span>
              Kranti
              <div class="form__div">
                <input type="text" name="hkranti" max="20" readonly
                id="hkranti" class="form-control" value="0"
                oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
              </div>
            </div>
          </div>
        </div>
        <!--------- homestead ends here ---------->


        <!--------- agriculture starts here ---------->
        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 for_agriculture" style="display:none">
          <span style="color:green">Area Under AGRICULTURE</span>
          <div class="row">
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
              <div class="form__div">
                Bigha <select id="abigha" class="form-select ps-3">
                  <?php for($i=MIN_VALUE; $i<=$max_bigha_agri; $i++) { ?>
                    <option value="<?=$i?>" > <?=$i?> </option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">

              <div class="form__div" id="agri_katha" style="display: none;">
                Katha <select id="akatha" class="form-select ps-3">
                  <?php for($i=MIN_VALUE; $i<=MAX_KATHA; $i++) { ?>
                    <option value="<?=$i?>" > <?=$i?> </option>
                  <?php } ?>
                </select>
              </div>

              <div class="form__div" id="agri_katha_barak" style="display: none;">
                Katha <select id="akatha_barak" class="form-select ps-3">
                  <?php for($i=MIN_VALUE; $i<=MAX_KATHA_BARAK; $i++) { ?>
                    <option value="<?=$i?>" > <?=$i?> </option>
                  <?php } ?>
                </select>
              </div>

            </div>
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12">
              <span id="alessaErr" class="form__input__error__msg"></span>
              <span class="lessa_title">Lessa</span>
              <span class="chatak_title">Chatak</span>
              <div class="form__div">
                <input type="text" name="alessa" max="20" 
                id="alessa" class="form-control" value="0"
                oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
              </div>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 in_ganda_div" style="display:none">
              Ganda
              <div class="form__div" id="">
                <input type="text" name="aganda" max="20" 
                id="aganda" class="form-control" value="0"
                oninput="this.value = this.value.replace(/[^0-9\.]/g,'')">
              </div>
            </div>
            <div class="col-md-2 col-lg-2 col-sm-2 col-xs-12 in_kranti_div" style="display:none">
              <div class="form__div" id="">
                Kranti <select id="akranti" class="form-select ps-3" 
                disabled>
                  <?php for($i=MIN_VALUE; $i<=0; $i++) { ?>
                    <option value="<?=$i?>" > <?=$i?> </option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </div>
        </div>
        <!--------- agriculture ends here ---------->

        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>

        <!--- table starts here --->
        <hr>
        <table class="table appendEncroacherDetail" id="encroacher_list">
          <thead class="thead-warning">
            <tr>
              <th>Occupier Name</th>
              <th>Father Name</th>
              <th style="text-align:center">Possession Since (dd/mm/yyyy)</th>
              <th style="text-align:center">Select</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
        <!--- table ends here --->

        <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12"><hr>&nbsp;</div>

        <!-- list of encroachers-->
        <div class="row" style="display: none;" hidden>
          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">
            <span id="na_encroacherErr" class="form__input__error__msg"></span>
            <label class="form-check-label"><span style="color:red">
              Select if Occupier Name is not Available in above list</span> </label> &nbsp;
            <div class="form-check form-check-inline">
              <input class="form-check-input na_encroacher" 
              type="checkbox" name="na_encroacher" value="-1" >
              <label class="form-check-label"></label>
            </div>
          </div>

          <div class="col-md-12 col-lg-12 col-sm-12 col-xs-12 na_possessionFromDate" 
            style="display:none">
            <span id="na_possessionFromErr" class="form__input__error__msg"></span>

              <label for="na_possessionFrom">Possession Since (dd/mm/yyyy)</label>
              <input type="date" name="na_possessionFrom" value="" 
              id="na_possessionFrom" class="form-control" max="<?php echo date("Y-m-d");?>" >                   
          </div>
        </div><br>


        <input type="hidden" id="new_dag_int" value="0">
        <input type="hidden" id="application_no" value="<?=$basic['applid']?>">
        <input type="hidden" id="tot_bigha" value="0">
        <input type="hidden" id="tot_katha" value="0">
        <input type="hidden" id="tot_lessa" value="0">
        <input type="hidden" id="tot_ganda" value="0">
        <input type="hidden" id="tot_kranti" value="0">
        <input type="hidden" id="encroacher_id" value="0">
        <input type="hidden" id="encroacher_id_available" value="0">

        <div class="row justify-content-center">
          <button type="button" class="btn btn-primary" id="saveDag" data-dismiss="modal">Save New Dag</button>
        </div>

      </div>

      
      
    </div>

  </div>

</div>
