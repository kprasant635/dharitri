    <style>
        
        .form-asteric {
  color:red;
}
    </style>
<div class="container-fluid form-top">
    <div class="row">
        <div class="col-lg-8 col-lg-offset-2">

       
        <div class="panel panel-info panel-form">
            <div class="panel-heading">
<!--                <h2 class="panel-title"><?php echo $this->lang->line('basic_details')?>(<?php echo $this->lang->line('column')?> 1-6)</h2>
            
                <h2 class="panel-title"><?php echo $this->lang->line('patta_no').':'.$pattatyps['patta_no'].','.'&nbsp;'. $this->lang->line('patta_type').':'.$pattatyps['pattatype'].','.'&nbsp;'.$this->lang->line('dag_no').':'.$this->session->userdata('dagnum');
                                 ?></h2>-->
            </div>
            <div class="panel-body">
                <form name="form" id="Form1"  class='form-horizontal' method="post" action="<?php echo base_url() . 'index.php/BankController/bank_registration_inserted' ?>">

                    <?php
                  
 
                    $dist_name = $this->session->userdata('distname');
                    $subdiv_name = $this->session->userdata('sub_divname');
                    $cir_name = $this->session->userdata('cir_codename');
                    $mouza_name = $this->session->userdata('mouza_codename');
                    $lot_name = $this->session->userdata('lot_noname');
                    $villname = $this->session->userdata('villname');
                    //echo  $dist_name.'<br>'.$subdiv_code.'<br>'.$cir_code.'<br>'.$mouza_code.'<br>'.$lot_no.'<br>'.$villname;                             
                    ?>
                    <div align="center">
                        <br>
                          <table class="table table-bordered" align="center" width="100%" >
                            <tr>
                                <td align="center">
                                    <?php echo $this->lang->line('district'); ?> 
                                </td>
                                <td align="center">
                                    <?php echo $dist_name; ?> 
                                </td>
                                <td align="center">
                               <?php echo $this->lang->line('subdivision'); ?> 
                                </td>
                                <td align="center">
                                    <?php echo $subdiv_name; ?> 
                                </td>
                                <td align="center">
                                    <?php echo $this->lang->line('circle'); ?> 
                                </td>
                                <td align="center">
                                    <?php echo $cir_name; ?> 
                                </td>
                                <td align="center">
                                    <?php echo $this->lang->line('mouza'); ?> 
                                </td>
                                <td align="center">
                                    <?php echo $mouza_name; ?> 
                                </td>
                                <td align="center">
                                   <?php echo $this->lang->line('lot_no'); ?> 
                                </td>
                                <td align="center">
                                    <?php echo $lot_name; ?> 
                                </td>
                                <td align="center">
                                    <?php echo $this->lang->line('vill_town'); ?> 
                                </td>
                                <td align="center">
                                    <?php echo $villname; ?> 
                                </td>

                            </tr>
                        </table>               
                        <div> 
                              <table class="table table-bordered" align="center" width="50%" >
                                <tr>
                    <td>
                       Enter Bank Name and Branch Name :: <span class="form-asteric">*</span>
                    </td><td>
                              <select class="form-control placeselect" id="selectbank" name="name1" onChange="showData()">
                                        <option disabled selected>Select Bank Name</option>
<?php //foreach ($placenamelist as $Aname): ?>
    <?php
    //$archeocd = $Aname->archeo_hist_code;
   //$archeonme = $Aname->archeo_hist_desc;
  
    ?>
                                            <option value="SBI">SBI</option>
                                             <option value="Apex">Apex</option>
                                               <option value="other">Other Bank,please specify!!! </option>
                                        <?php //endforeach; ?>
                                    </select></td>
                                    <td>
                              <select class="form-control placeselect" id="selectbranch" name="branchname1" onChange="showDatabranch()">
                                        <option disabled selected>Select Branch Name</option>
<?php //foreach ($placenamelist as $Aname): ?>
    <?php
    //$archeocd = $Aname->archeo_hist_code;
   //$archeonme = $Aname->archeo_hist_desc;
  
    ?>
                                            <option value="tezpur">tezpur</option>
                                             <option value="kamrup">kamrup</option>
                                                 <option value="other">Other Branch, please specify!!!</option>
                                        <?php //endforeach; ?>
                              </select></td></tr>
                                    
                             <tr>
                                   <td></td>
                        <td><nosctipt><input type="text" name="name2" id="nme" style="display:none;" /></noscript></td>
                         <td> <input type="text" name="branchname2" id="nme123" style="display:none;"/> </td> 
             </tr>
                </tr>
                    <tr>
                    <td>
                        Contact Name and Number ::<span class="form-asteric">*</span>
                    </td>
                    <td>
                        <input type="text" name="Contactnme" id="Contactname" placeholder="Name" onFocus="this.value='';" required/> </td>
                    <td>
                        <input type="text" name="phnum" id="phnum" placeholder="Phonenumber"  maxlength="10" onFocus="this.value='';" required/> </td>
                </tr>
                 <tr>
                    <td>
                        Designation ::<span class="form-asteric">*</span>
                    </td>
                    <td>
                        <input type="text" name="designation" id="designation" placeholder="Designation" onFocus="this.value='';" required/> </td>
                   
                </tr>
                <tr>
                    <td>
                        Date Of Registration (DD/MM/YYYY) ::<span class="form-asteric">*</span>
                    </td><td>
                        <input type="text" name="date" id="popupDatepicker" required/> </td>
                </tr>
                  <tr>
                    <td>
                        IFSC Code ::<span class="form-asteric">*</span>
                    </td><td>
                        <input type="text" name="ifsc"  required/> </td>
                </tr>
                <tr>
                    <td>
                        Email id ::<span class="form-asteric">*</span>
                    </td><td>
                        <input type="email" name="mail" id="loginId" required > </td>
                </tr>
                <tr>
                    <td>
                        Do you want your email id to be same as login id ::
                    </td><td>
                        yes:<input type="radio"  value="yes" name="aa" id="y" onClick="check()"> no:<input type="radio" checked value="no" name="aa" id="n" > </td>

                </tr>
                <tr>
                    <td>
                        Login id ::<span class="form-asteric">*</span>
                    </td><td>
                        <input type="text" name="login" id="id"  required > </td>
                </tr>
                <tr>
                    <td>
                        Password ::<span class="form-asteric">*</span>
                    </td>
                    <td>
                        <input type="password"  id="new_pass" name='new_pass' required>
                    </td>
                </tr>
                
                <tr>
                    <td>
                        Confirm Password ::<span class="form-asteric">*</span>
                    </td>
                    <td>
                        <input type="password"  name='re_type_pass' onKeyUp="CheckPassword();" required>
                    </td>
                </tr>
                <tr>
                    <td colspan="2"><div id="msg"></div></td>
                </tr>
                <tr>
                    <td>
                        Hint Question::
                    </td><td>
                        <select name="question" value="hintquestion" required>
                            <option>Select Question Type</option>
                            <option value="brtcity">Birthcity</option>
                            <option value="petnme">Petname</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>
                        Hint Answer::
                    </td><td>
                        <input type="text" name="answer" id="" required> </td>
                </tr>
                <tr>
                    <td>
                        Captcha::  <img src="<?php echo base_url() . 'application/views/bank/captcha.php'?>"/><span class="form-asteric">*</span>
                    </td>
                    <td>
                        <input type="text" name="cap" id="" required>
                    </td>

                </tr>
                  <tr>
                    <td>
                        <input type="hidden" name="hashedpwd" value="" /></td>
<!--               <td> <input type="hidden" name="salt" value="<?php //echo $salt ?>" /></td>-->
                </tr>
                <br>
                <tr>
                    <td>
                        <a href="back.php"><input type="button" value="BACK" name="back" /> </a>
                    </td>
                    <td><input type="submit" value="submit" name="Submit" onClick="hashWithMD5(this.form);" />
                    </td>

                </tr>
              
                              </table>
                        </div>
                    </div>
      
</form> 
            
           
            </div>
        </div>
    </div>

    <hr>
</div>
</div>

<script type="text/javascript">
    function check()
    {

        if (document.getElementById('y').checked) {

            var login = $('#loginId').val();
            //alert (val);
            $('#id').val(login);
        }
    }


    function CheckPassword()
    {
        //alert("dasd");
        var paswd=  /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{7,15}$/;  
        var new_pwd = document.form.new_pass.value;
        var retype_pwd = document.form.re_type_pass.value;
        if (new_pwd === retype_pwd)
        {
            document.getElementById("msg").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Password  Matched(!! This Password Must Be Used At the time of login to the System & keep it SECRET!!).</p></label>";
            
        }
        else
        {
            document.getElementById("msg").innerHTML = "<label for=\"inputEmail3\" class=\"col-sm-12 control-label\"><p style=\" color: #ff0000; align:center\">Password Does Not Match.</p></label>";
        }
    }
    
    
        $('#phnum').keyup(function(){
        var val = $('#phnum').val();
        console.log(val);
       
        var conv = parseInt(val);
        
        if(isNaN(conv)){
            alert("Please enter valid numeric number");
          
        }
       
    });
    
      
                function hashWithMD5(form) {
                    var pwd = form.elements['new_pass'].value;
                   // var salt = form.elements['salt'].value;
                    var pwd_salt =  pwd;
                    var hashedpwd = hex_md5(pwd_salt);
                    form.elements['hashedpwd'].value = hashedpwd ;
                    form.elements['new_pass'].value = "*****";
                    form.elements['salt'].value = "*******";
                    //alert("pwd=" + pwd + ", md5=" + hashedpwd);
                }
                
                
//                function activate(field){
//                field.disabled=false;
//                if(document.stylSheets)field.style.visibility = 'visible';
//                field.focus();
//                }
//                    
//                    
//                function process_choice(selection,textfield){
//                    
//                    if(last_choice(selection)){
//                        
//                        activate(textfield);
//                    }
//                    else{
//                        
//                        textfield.disabled= true;
//                        if(document.stylsheet)textfield.style.visibility ='hidden';
//                        textfield.value='';}}
//                
//                function check_choice(){
//                    if(!last_choice(document.form.menu)){
//                        
//                        document.form.name.blur();
//                        alert('please check your menu selection first');
//                        document.form.menu.focus();
//                    }
//                    }
//                
//              disa='disabled';
//              if(last_choice(document.form.menu)) disa='';
//              document.write('<input type="text" name="name" '+disa+' id="nme" onfocus="check_choice()"/>');
//              if(disa && document.stylsheet)
//                  document.form.name.style.visibility= 'hidden';
                
       
       
       
       function showData(){
           var selected = $('#selectbank').val();
           if(selected === 'other'){
           $('#nme').css('display','block');
           }
       }
       
        function showDatabranch(){
           var selectedbranch = $('#selectbranch').val();
           if(selectedbranch === 'other'){
           $('#nme123').css('display','block');
           }
       }
</script>