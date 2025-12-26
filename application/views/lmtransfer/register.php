<div class="panel panel-info">
<form class="form-horizontal" method="POST" action="" enctype="multipart/form-data">
<fieldset>
<!-- Form Name -->
<center><legend class="bg bg-info">District transfer of Lot Mandal/ Supervisory Kanongu (LR Staff) under State Cadre
<br> 
</legend></center>
<center><mark>Last date for submission of application 30/11/2023.</mark></center>
<div class="form-group">
  <label class="col-md-4 control-label" for="radios">Which cadre do you want to migrate?</label>
  <div class="col-md-4"> 
    <label class="radio-inline" for="radios-0">
      <input type="radio" name="select_cadre" id="radios-0" value="STATE" checked="checked">
      State Cadre
    </label> 
    <label class="radio-inline hide" for="radios-1">
      <input type="radio" name="select_cadre" id="radios-1" value="DISTRICT">
      District Cadre
    </label> 
   
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Name of Incumbent</label>  
  <div class="col-md-4">
  <input id="textinput" name="full_name" type="text" placeholder="Name of Incumbent" class="uc-uppercase form-control input-md" required="">
  <span class="text-danger"><?php echo form_error('full_name');?></span>
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Mobile</label>  
  <div class="col-md-4">
  <input name="mobile" id='mobile' type="text"  maxlength="10" placeholder="Mobile" class="form-control input-md" required="">
  <span class="text-danger"><?php echo form_error('mobile');?></span> 
  <span id='msg1'></span>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">PAN No</label>  
  <div class="col-md-4">
  <input name="pan_no" id='panidvalidate' type="text" maxlength="10" minlength="10" placeholder="PAN No" class="uc-uppercase form-control" required="">
  <span class="text-danger"><?php echo form_error('pan_no');?></span> 
  <span id='msg'></span>
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Email</label>  
  <div class="col-md-4">
  <input name="email" type="text" placeholder="email-id" class="form-control input-md" required="">
  <span class="text-danger"><?php echo form_error('email');?></span> 
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">DOA (Date of Appointment) </label>  
  <div class="col-md-4">
  <input name="doa" type="text" readonly placeholder="Date of Appointment" class="stdate form-control input-md" required="">
  <span class="text-danger"><?php echo form_error('doa');?></span> 
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Date of Superannuation </label>  
  <div class="col-md-4">
  <input name="dos" type="date" placeholder="Date of Superannuation d-m-Y " class="form-control input-md" required="">
  <span class="text-danger"><?php echo form_error('dos');?></span> 
  </div>
</div>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Present Place of Posting </label>  
  <div class="col-md-3">
  <input id="pp_dist" name="pp_dist" type="text" placeholder="District Name" class="uc-uppercase form-control input-md" required="">
  <span class="text-danger"><?php echo form_error('pp_dist');?></span> 
  </div>
  <div class="col-md-3">
  <input id="pp_circle" name="pp_circle" type="text" placeholder="Circle Name" class="uc-uppercase form-control input-md" required="">
  <span class="text-danger"><?php echo form_error('pp_circle');?></span> 
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label" for="textinput">Permanent Address </label>  
  <div class="col-md-5">
  <textarea class="form-control" required="" name='p_address' rows="5" placeholder="Address"></textarea>
  <span class="text-danger"><?php echo form_error('p_address');?></span> 
  </div>
</div>
<!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="filebutton">Upload Supporting Documents (Appointment Letter)</label>
  <div class="col-md-4">
    <input id="filebutton" required="" name="appointment_copy" accept="application/pdf" class="input-file" type="file">
    <span class="text-danger"><?php echo form_error('appointment_copy');?></span> 
    <span class="help-block text-small">Only PDF file allowed</span> 
  </div>
</div>
<!-- Select Multiple -->
<div class="form-group">
  <label class="col-md-4 control-label">Option of District for transfer (Preference 1) </label>
  <div class="col-md-5">
    <select name="prefernece_1" required="" class="form-control select-box-value_1" >
      <option value="">Select Option</option>
      <option value="Dhubri">ধুবুৰী ( Dhubri )</option>
      <option value="Goalpara">গোৱালপাৰা ( Goalpara )</option><option value="Barpeta">বৰপেটা  ( Barpeta )</option>
      <option value="Nalbari">নলবাৰী ( Nalbari )</option><option value="Kamrup">কামৰূপ ( Kamrup )</option>
      <option value="Sonitpur">শোণিতপুৰ ( Sonitpur )</option><option value="Lakhimpur">লক্ষীমপূৰ ( Lakhimpur )</option>
      <option value="Bongaigaon">বঙাইগাঁও ( Bongaigaon )</option><option value="Golaghat">গোলাঘাট ( Golaghat )</option>
      <option value="Jorhat">যোৰহাট ( Jorhat )</option><option value="Sibsagar">শিৱসাগৰ ( Sibsagar )</option>
      <option value="Dibrugarh">ডিব্ৰুগড় ( Dibrugarh )</option><option value="Tinsukia">তিনিচুকীয়া ( Tinsukia )</option>
      <option value="Karimganj">করিমগঞ্জ ( Karimganj )</option><option value="KamrupMetro">কামৰূপ মহানগৰ ( Kamrup Metro )</option>
      <option value="Dhemaji">ধেমাজি ( Dhemaji )</option><option value="Morigaon">মৰিগাওঁ ( Morigaon )</option>
      <option value="Nagaon">নগাওঁ ( Nagaon )</option><option value="Majuli">মাজুলী ( Majuli )</option>
      <option value="Biswanath">বিশ্বনাথ ( Biswanath )</option><option value="Hojai">হোজাই ( Hojai )</option>
      <option value="Charaideo">চৰাইদেউ ( Charaideo )</option><option value="SouthSalmara">দক্ষিণ শালমাৰা ( South Salmara )</option>
      <option value="Bajali">বজালী ( Bajali )</option><option value="Darrang">দৰং ( Darrang )</option>
    </select>
    <span class="text-danger"><?php echo form_error('prefernece_1');?></span> 
    <span class="text-danger"><?php echo form_error('prefernece_1');?></span> 
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Option of District for transfer (Preference 2) </label>
  <div class="col-md-5">
    <select name="prefernece_2" required="" class="form-control select-box-value_2" >
      <option value="">Select Option</option>
      <option value="Dhubri">ধুবুৰী ( Dhubri )</option>
      <option value="Goalpara">গোৱালপাৰা ( Goalpara )</option><option value="Barpeta">বৰপেটা  ( Barpeta )</option>
      <option value="Nalbari">নলবাৰী ( Nalbari )</option><option value="Kamrup">কামৰূপ ( Kamrup )</option>
      <option value="Sonitpur">শোণিতপুৰ ( Sonitpur )</option><option value="Lakhimpur">লক্ষীমপূৰ ( Lakhimpur )</option>
      <option value="Bongaigaon">বঙাইগাঁও ( Bongaigaon )</option><option value="Golaghat">গোলাঘাট ( Golaghat )</option>
      <option value="Jorhat">যোৰহাট ( Jorhat )</option><option value="Sibsagar">শিৱসাগৰ ( Sibsagar )</option>
      <option value="Dibrugarh">ডিব্ৰুগড় ( Dibrugarh )</option><option value="Tinsukia">তিনিচুকীয়া ( Tinsukia )</option>
      <option value="Karimganj">করিমগঞ্জ ( Karimganj )</option><option value="KamrupMetro">কামৰূপ মহানগৰ ( Kamrup Metro )</option>
      <option value="Dhemaji">ধেমাজি ( Dhemaji )</option><option value="Morigaon">মৰিগাওঁ ( Morigaon )</option>
      <option value="Nagaon">নগাওঁ ( Nagaon )</option><option value="Majuli">মাজুলী ( Majuli )</option>
      <option value="Biswanath">বিশ্বনাথ ( Biswanath )</option><option value="Hojai">হোজাই ( Hojai )</option>
      <option value="Charaideo">চৰাইদেউ ( Charaideo )</option><option value="SouthSalmara">দক্ষিণ শালমাৰা ( South Salmara )</option>
      <option value="Bajali">বজালী ( Bajali )</option><option value="Darrang">দৰং ( Darrang )</option>
    </select>
    <span class="text-danger"><?php echo form_error('prefernece_2');?></span> 
   
  </div>
</div>
<div class="form-group">
  <label class="col-md-4 control-label">Option of District for transfer (Preference 3) </label>
  <div class="col-md-5">
    <select name="prefernece_3" required="" class="form-control select-box-value_3" >
      <option value="">Select Option</option>
      <option value="Dhubri">ধুবুৰী ( Dhubri )</option>
      <option value="Goalpara">গোৱালপাৰা ( Goalpara )</option><option value="Barpeta">বৰপেটা  ( Barpeta )</option>
      <option value="Nalbari">নলবাৰী ( Nalbari )</option><option value="Kamrup">কামৰূপ ( Kamrup )</option>
      <option value="Sonitpur">শোণিতপুৰ ( Sonitpur )</option><option value="Lakhimpur">লক্ষীমপূৰ ( Lakhimpur )</option>
      <option value="Bongaigaon">বঙাইগাঁও ( Bongaigaon )</option><option value="Golaghat">গোলাঘাট ( Golaghat )</option>
      <option value="Jorhat">যোৰহাট ( Jorhat )</option><option value="Sibsagar">শিৱসাগৰ ( Sibsagar )</option>
      <option value="Dibrugarh">ডিব্ৰুগড় ( Dibrugarh )</option><option value="Tinsukia">তিনিচুকীয়া ( Tinsukia )</option>
      <option value="Karimganj">করিমগঞ্জ ( Karimganj )</option><option value="KamrupMetro">কামৰূপ মহানগৰ ( Kamrup Metro )</option>
      <option value="Dhemaji">ধেমাজি ( Dhemaji )</option><option value="Morigaon">মৰিগাওঁ ( Morigaon )</option>
      <option value="Nagaon">নগাওঁ ( Nagaon )</option><option value="Majuli">মাজুলী ( Majuli )</option>
      <option value="Biswanath">বিশ্বনাথ ( Biswanath )</option><option value="Hojai">হোজাই ( Hojai )</option>
      <option value="Charaideo">চৰাইদেউ ( Charaideo )</option><option value="SouthSalmara">দক্ষিণ শালমাৰা ( South Salmara )</option>
      <option value="Bajali">বজালী ( Bajali )</option><option value="Darrang">দৰং ( Darrang )</option>
    </select>
    <span class="text-danger"><?php echo form_error('prefernece_3');?></span> 
  </div>
</div>
<!-- Button -->
<div class="form-group">
   <center> <button id="singlebutton" name="singlebutton" class="btn btn-primary">Submit </button>
   </center>
</div>
</fieldset>
</form>
</div>
<script>
  const forceKeyPressUppercase = (e) => {
    let el = e.target;
    let charInput = e.keyCode;
    if((charInput >= 97) && (charInput <= 122)) { // lowercase
      if(!e.ctrlKey && !e.metaKey && !e.altKey) { // no modifier key
        let newChar = charInput - 32;
        let start = el.selectionStart;
        let end = el.selectionEnd;
        el.value = el.value.substring(0, start) + String.fromCharCode(newChar) + el.value.substring(end);
        el.setSelectionRange(start+1, start+1);
        e.preventDefault();
      }
    }
  };
  document.querySelectorAll(".uc-uppercase").forEach(function(current) {
    current.addEventListener("keypress", forceKeyPressUppercase);
  });
  $('#mobile').bind('keyup paste', function(){
        this.value = this.value.replace(/[^0-9]/g, '');
  });
  $('#panidvalidate').change(function(e){
    e.preventDefault();
    let panid=$(this).val();
    //alert('hai');
    var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'LmstateCadreTransfer/checkPan', 
            data        : {pan:panid}, 
            dataType    : 'json', 
            encode      : true,
            success: function(data){
              console.log(data);
              if(data.response==1){
                if(data.data!=0){
                  $("#singlebutton").hide();
                  $('#msg').html('<p class="bg bg-danger text-center">PAN No. Already Registered</p>');
                }else{
                  $("#singlebutton").show();
                  $('#msg').html('<p class="bg bg-info text-center">PAN No. Not Registered Yet</p>');
                }
              }
            },
        });
  });
  $('#mobile').change(function(e){
    e.preventDefault();
    let mobile=$(this).val();
    //alert('hai');
    var formData = $(this).serialize();
        $.ajax({
            type        : 'POST', 
            url         : baseurl+'LmstateCadreTransfer/checkMobile', 
            data        : {mobile:mobile}, 
            dataType    : 'json', 
            encode      : true,
            success: function(data){
              console.log(data);
              if(data.response==1){
                if(data.data!=0){
                  $("#singlebutton").hide();
                  $('#msg1').html('<p class="bg bg-danger text-center">Mobile No. Already Registered</p>');
                }else{
                  $("#singlebutton").show();
                  $('#msg1').html('<p class="bg bg-info text-center">Mobile No. Not Registered Yet</p>');
                }
              }
            },
        });
  });
  let last_valid_selection=status = null;
  let selectedvalue = [];
  var flag = 0;
  $("select.select-box-value_1").change(function() {
    // console.log("eee======"+flag);
    if(flag == 1){
      selectedvalue = [];
      flag = 0;
    }
      $.each($(".select-box-value_1 option:selected"), function(){          
          selectedvalue.push($(this).val());
          
      });
      duplicate(selectedvalue) ;
  });
  $("select.select-box-value_2").change(function() {
    // console.log("ddd===="+flag);
    if(flag == 1){
      selectedvalue = [];
      flag = 0;
    }
      $.each($(".select-box-value_2 option:selected"), function(){          
          selectedvalue.push($(this).val());
      });
      duplicate(selectedvalue) ;
  });
  $("select.select-box-value_3").change(function() {
    // console.log("cdd===="+flag);
    if(flag == 1){
      selectedvalue = [];
      flag = 0;
    }
    $.each($(".select-box-value_3 option:selected"), function(){          
        selectedvalue.push($(this).val());
    });
    duplicate(selectedvalue);
  });
  function duplicate(selectedvalue){
    // alert(selectedvalue);
    var recipientsArray = selectedvalue.sort(); 
    let reportRecipientsDuplicate = [];
    for (var i = 0; i < recipientsArray.length - 1; i++) {
        if (recipientsArray[i + 1] == recipientsArray[i]) {
            flag = 1;
            alert ("You have selected same district - " + recipientsArray[i+1]); 
            $('select').find($('option')).attr('selected',false);
            console.log(recipientsArray[i]);
            return recipientsArray[i];
        }
    }
  }
</script>