<style>
    .reza-card {
        background: #fff;
        border-radius: 2px;
        display: inline-block;
        margin: 1rem;
        position: relative;
        width: 100%;
    }
    .reza-card {
        box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }
    .reza-title{
        font-weight: bold;
        font-size: 18px;
        padding: 20px;
        color: #37474F;
    }
    .reza-body{
        padding-left: 20px;
        padding-right: 20px;
        padding-bottom: 40px;
    }
    .badge{
        padding: 10px;
        font-size: 15px;
    }

    .rezaButt {
        color: #FFF;
        background-color: #03a9f4;
    }
    .rezaButt:hover {
        color: #0c0c0c;
    }
    .rezaButt{
        display: inline-block;
        position: relative;
        cursor: pointer;
        height: 35px;
        min-width: 150px;
        line-height: 35px;
        padding: 0 1.5rem;
        font-size: 15px;
        font-weight: 600;
        font-family: "Roboto", sans-serif;
        letter-spacing: 0.8px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        vertical-align: middle;
        white-space: nowrap;
        outline: none;
        border: none;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
        border-radius: 2px;
        transition: all 0.3s ease-out;
        /*box-shadow: 0 2px 5px 0 rgb(0 0 0 / 23%);*/
    }
    .rezaText {
        font-size: 16px;
    }
    #cases_wrapper {
         margin-top: 0px !important;
    }


</style>
<div class="row" style='padding: 40px 50px 40px 20px'>
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

        <?php if($this->session->flashdata('success')) { ?>

            <div class="success-msg">
                <div class="alert alert-success" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <b><i class="fa fa-check"></i> <?php echo $this->session->flashdata('success') ?></b>
                </div>
            </div>

        <?php } ?>

        <?php if($this->session->flashdata('error')) { ?>
            <div class="alert alert-danger alert-dismissable" style="box-shadow:  0 2px 5px 0 rgba(0,0,0,.16),0 2px 10px 0 rgba(0,0,0,.12);">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                <b><?php echo $this->session->flashdata('error') ?></b>
                <br>
                <b><?php echo $this->session->flashdata('error_code') ?></b>
            </div>
        <?php } ?>


        <!-- <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left">

            <a href="// $_SERVER['HTTP_REFERER']?>">
                <button type="button" class="btn btn-sm btn-danger pull-right">
                    <i class="fa fa-backward"></i>&nbsp;Back to Menu</button>
            </a>

        </div> -->


        <div class="reza-card">
            <div class="reza-title">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12" >
                        <span><?php echo $this->lang->line('sdlacCommittee') ?></span>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-sx-12" align="right">
                        <input type="hidden" id="getBaseURL" value="<?php echo base_url(); ?>index.php">
                        <button class="rezaButt" id="addSdlacComm">
                            <i class="fa fa-plus-circle" aria-hidden="true"></i>
                            <?php echo $this->lang->line('addSdlacCommButt') ?>
                        </button>
                    </div>
                </div>

                <hr>

            </div>

            <div class="reza-body" >

                <?php if ($committeeCount == 0) : ?>
                    <div class="rezaText"><?php echo $this->lang->line('noSdlacCommittee') ?></div>
                <?php else : ?>
                <form id="sdlac_member_update">
                    <table class='table table-striped' id='cases' width="100%">
                        <thead>
                        <tr>
                            <th>SL No.</th>
                            <th>Name</th>
                            <th>Mobile No.</th>
                            <th>Email</th>
                            <th>Set Priority for DLC</th>

                        </tr>
                        </thead>
                        <tbody>
                        <?php
                            $j = 1; $selected = ''; foreach ($committeeList as $member):   ?>
                            <tr>
                                <td><?php echo $j; ?>
                                <input type="hidden" name="user_code[]" id="user_code" value="<?=$member->user_code?>"> </td>
                                <td><?php echo $member->name; ?></td>
                                <td> <?php echo $member->phone; ?></td>
                                <td> <?php echo $member->email; ?></td>
                                <td> 
                                    <select class="form-control" name="priority[]" id="priority">          
                                        <option value="99">--SELECT--</option>       
                                            <?php 
                                             for ($i=1; $i <= sizeof($committeeList); $i++) { 
                                                if($member->dlc_priority == $i){
                                                    $selected = 'selected';
                                                }else{
                                                    $selected = '';
                                                }
                                            ?>
                                            <option value="<?=$i?>" <?=$selected;?>><?=$i?></option>
                                            <?php } ?>
                                    </select>
                                </td>
                                
                            </tr>
                        <?php $j++; endforeach; ?>
                        </tbody>

                    </table>
                </form>
                    <div class="text-center">
                        <button class="btn btn-success" id="update">
                            <i class="fa fa-check"></i>&nbsp;&nbsp;SET PRIORITY ORDER FOR DLC MEMBER
                        </button>
                        
                    </div>
                    
                <?php endif; ?>

            </div>

        </div>


        <!-- Modal Revert to co -->
        <!-- <div class="modal" role="dialog" id="addMoreSdlacCommMember">
            <div class="modal-dialog " role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Add SDLAC Committee Member</h5>
                    </div>
                    <div class="modal-body" align="">
                        <form action="">
                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="w3review" style="font-weight: bold">Name</label>
                                    <input class="form-control" id="name"  required minlength="2" maxlength="69">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="w3review" style="font-weight: bold">Mobile Number </label>
                                    <input class="form-control" id="phone"  required minlength="10" maxlength="10">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="w3review" style="font-weight: bold">Email Id </label>
                                    <input class="form-control" id="email"  required minlength="2" maxlength="69">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="w3review" style="font-weight: bold">Designation </label>
                                    <input class="form-control" id="designation"  required minlength="2" maxlength="69">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="w3review" style="font-weight: bold">Set Username </label>
                                    <input type="text" class="form-control" id="sdlac_username"  required minlength="2" maxlength="69">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="w3review" style="font-weight: bold">Set Password </label>
                                    <input type="text" class="form-control" id="sdlac_password"  required minlength="2" maxlength="69">
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 form-group">
                                    <label for="w3review" style="font-weight: bold">Position </label>
                                    <input type="number" class="form-control" id="sdlac_position" required  min="0">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" 
                            id="addMoreSdlacCommMemberNo">NO</button>
                        <button type="button" class="btn btn-primary" 
                            id="addMoreSdlacCommMemberYes">ADD</button>
                    </div>
                </div>
            </div>
        </div> -->





    </div>
</div>

<link rel="stylesheet" href="<?php echo base_url(); ?>application/css/sweetalert2.min.css">
<script src="<?php echo base_url(); ?>application/views/js/sweetalert2/sweetalert2.all.min.js"></script>
<script>

    var BASE_URL = $("#getBaseURL").val();
    function showSuccessMessage(text) {
        swal.fire({
            title: "Success !",
            text: text,
            icon: 'success',
            position: 'top',
            showConfirmButton: true,
            timer: 5000,
        });

    }

    function showErrorMessage(text) {
        swal.fire({
            title: "Error!",
            text: text,
            icon: 'error',
            position: 'top',
            showConfirmButton: false,
            timer: 5000,
            showCancelButton: true
        });
    }
    $(document).on('click','#update',function (event){
        event.preventDefault();
        $.ajax({
            url: BASE_URL + "/ReclassSuiteCommonDc/updateMemberPriority",
            type: "POST",
            data:$("#sdlac_member_update").serialize(),
            success: function (data) {
                data = JSON.parse(data);
                if (data.responseType == 1)
                {
                    showErrorMessage(data.message);
                    return;
                }else if(data.responseType == 3)
                {
                    showErrorMessage(data.message);
                    return;
                }
                else if(data.responseType == 2)
                {

                    Swal.fire({
                        text: data.message,
                        icon: 'success',
                        position: 'top',
                        confirmButtonText: 'OK',
                        customClass: {
                            actions: 'my-actions',
                            confirmButton: 'order-2',
                        }
                      }).then((result) => {
                          if (result.isConfirmed) {
                          location.reload();
                      }
                    });
                }
            },

        });
    });


    $(document).on('click','#addSdlacComm',function (){
        // $('#addMoreSdlacCommMember').modal('show');
        location.href = BASE_URL+"/initialization/useraccount";
    });

    // $(document).on('click','#addMoreSdlacCommMemberNo',function ()
    // {
    //     $('#addMoreSdlacCommMember').modal('hide');
    // });
    // $(document).on('click','#addMoreSdlacCommMemberYes',function ()
    // {
    //     var name  = $("#name").val();
    //     var phone = $("#phone").val();
    //     var email = $("#email").val();
    //     var designation = $("#designation").val();
    //     var username = $("#sdlac_username").val();
    //     var password = $("#sdlac_password").val();
    //     var position = $("#sdlac_position").val();
    //     if(name == '')
    //     {
    //         showErrorMessage("Kindly Enter Member Name !");
    //         return;
    //     }
    //     if(phone == '')
    //     {
    //         showErrorMessage("Kindly Enter Member Mobile Number !");
    //         return;
    //     }
    //     if(email == '')
    //     {
    //         showErrorMessage("Kindly Enter Member Email Id !");
    //         return;
    //     }
    //     if(designation == '')
    //     {
    //         showErrorMessage("Kindly Enter Member Designation !");
    //         return;
    //     }
    //     if(username == '')
    //     {
    //         showErrorMessage("Kindly set a Username !");
    //         return;
    //     }
    //     if(password == '')
    //     {
    //         showErrorMessage("Kindly set a Password !");
    //         return;
    //     }
    //     if(position == '')
    //     {
    //         showErrorMessage("Kindly Enter Position !");
    //         return;
    //     }
    //     const member = {
    //         name        : name,
    //         phone       : phone,
    //         email       : email,
    //         designation : designation,
    //         username    : username,
    //         password    : password,
    //         position    : position ,
    //     };
    //     $.ajax({
    //         url: BASE_URL + "/SettlementCommonDc/addNewSdlacMember",
    //         type: "post",
    //         dataType: "json",
    //         contentType: "application/json",
    //         success: function (data) {
    //             $('#addMoreSdlacCommMember').modal('hide');
    //             if (data.responseType == 1)
    //             {
    //                 showErrorMessage("There is some problem, Please try again");
    //             }
    //             else
    //             {
    //                 showSuccessMessage("SDLAC/CDLAC Member Successfully Added ");
    //                 window.location = window.location;
    //             }
    //         },
    //         data: JSON.stringify(member)

    //     });

    // });

    // var array = [];
    // var totalSdlac = [];
    // var setIdArray = [];
    // var master = [];
    // var tot = "<?php echo $committeeCount; ?>";
    // for (var p = 1; p <= tot; p++) {
    //     totalSdlac.push(p);
    //     master.push(p);
    // }
    // function setPriority(setId,str) {
    //     if(str != 0){
    //         array.push(str);
    //         setIdArray.push(setId);
    //         for (var i = 0; i < totalSdlac.length; i++) {
    //             for (var j = 0; j < array.length; j++) {
    //                 if(totalSdlac[i] == array[j]){
    //                 const index = totalSdlac.indexOf(totalSdlac[i]);
    //                     if (index > -1) {
    //                       totalSdlac.splice(index, 1); 
    //                     }
    //                 }
    //             }
    //         }
    //     }else{
    //         array=[];
    //         setIdArray = [];
    //     } 
    
    //     var template ="<option value='0'>--SELECT--</option>" ;
    //     for (var k = 0; k< totalSdlac.length; k++) {
    //         template +=
    //             "<option value='" +
    //             totalSdlac[k] +
    //             "'>" +
    //             totalSdlac[k] +"</option>";
    //     }
    //     // var nextselc = parseFloat(setId) + 1;
    //     // $("#priority"+nextselc).html(template);
    //     for (var i = 0; i < master.length; i++) {
    //         for (var j = 0; j < setIdArray.length; j++) {
    //             if(master[i] == setIdArray[j]){
    //                 const index = master.indexOf(master[i]);
    //                 if (index > -1) {
    //                   master.splice(index, 1); 
    //                 }
    //             }
    //         }
            
    //     }
    //     console.log("SELECTED ARRAY ---"+array);
    //     console.log("SDLC" + totalSdlac);
    //     console.log("SET SELECTED BOX ---" + setIdArray);
    //     console.log("MASTER FOR REST SHOW ---" + master);
    //     for (var i = 0; i < master.length; i++) {
    //        $("#priority"+master[i]).html(template);
    //     }
        
     

    // }

    

</script>