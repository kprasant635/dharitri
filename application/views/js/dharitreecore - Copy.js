/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function (e) {
    window.baseurl = "http://localhost/dharitreecode/index.php/";
    window.debug = true;
    console.log("DOM Ready!Loading Corejs!!");
   // $("#cases").tablesorter();

    $('.husband_wife').change(function (e) {
        if (this.checked) {
            $('#applicant_name_label').text("Husband's Name");
            $('#applicant_name_label').css('color', 'red');

        }
        else {
            $('#applicant_name_label').text("Applicant's Name");

        }

    });

    $('form#submitlandarea').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: baseurl + "lmmutation/saveMutationDagDetails",
            data: $('form#submitlandarea').serialize(),
            method: 'post',
            success: function (d) {
                $.ajax({
                    url: baseurl + "lmmutation/getDagsByPattaNoPattaTypeJSON/",
                    success: function (data) {
                        var obj = JSON.parse(data);
                        var template = "<option>Select Dag</option>";
                        console.log(obj);
                        for (var i = 0; i < obj.length; i++) {
                            template += "<option value='" + obj[i].dag_no + "'>" + obj[i].dag_no + "</option>";
                        }
                        console.log(template);
                        $('#dag_no').html(template);
                        $('form#submitlandarea').find("input[type=text], textarea").val("");
                        $('.next').removeAttr('disabled');

                    }
                });
            }
        });
    });
    
    
    
    $('form#submitlandarea').submit(function (e) {
        e.preventDefault();
        $.ajax({
            url: baseurl + "lmmutation/savePartition",
            data: $('form#submitlandarea').serialize(),
            method: 'post',
            success: function (d) {
                $.ajax({
                    url: baseurl + "lmmutation/getDagsByPattaNoJSON/",
                    success: function (data) {
                        var obj = JSON.parse(data);
                        var template = "<option>Select Dag</option>";
                        console.log(obj);
                        for (var i = 0; i < obj.length; i++) {
                            template += "<option value='" + obj[i].dag_no + "'>" + obj[i].dag_no + "</option>";
                        }
                        console.log(template);
                        $('#dag_no').html(template);
                        $('form#submitlandarea').find("input[type=text], textarea").val("");
                        $('.next').removeAttr('disabled');

                    }
                });
            }
        });
    });
    
    
    
    

//    $('form#pattadardetails').submit(function(e){
//        e.preventDefault();
//        $('#pdar_cron_no').val(pdar_no++);
//        $.ajax({
//            url: baseurl + "lmmutation/savePattadarDetails",
//            data: $('form#pattadardetails').serialize(),
//            method: 'post',
//            success: function (d) {
//                $.ajax({
//                    url: baseurl + "lmmutation/getPattadarFilteredJSON/",
//                    success: function (data) {
//                        var obj = JSON.parse(data);
//                        var template = "<option>Select Dag</option>";
//                        console.log(obj);
//                        for (var i = 0; i < obj.length; i++) {
//                            template += "<option value='" + obj[i].pdar_id + "'>" + obj[i].padr_name + "</option>";
//                        }
//                        console.log(template);
//                        $('#pdar_name').html(template);
//                        $('form#pattadardetails').find("input[type=text], textarea").val("");
//                        $('.next').removeAttr('disabled');
//                    }
//                });
//            }
//        });
//    });


    $('.districtselect').change(function (e) {
        var distCode = $(this).val();
        $.ajax({
            url: baseurl + "lmmutation/getSubdivJson/" + distCode,
            success: function (data) {
                console.log(data);
                var subdivcode = JSON.parse(data);
                var template = "<option selected disabled>Select Sub Division</option>"
                for (var i = 0; i < subdivcode.length; i++) {
                    template += "<option value='" + subdivcode[i].subdiv_code + "'>" + subdivcode[i].loc_name + "</option>"
                }
                console.log(template);
                $('.subdivselect').html(template);
            }
        });
    });
    $('.subdivselect').change(function (e) {
        var subdivcode = $(this).val();
        var distcode = $('.districtselect').val();
        $.ajax({
            url: baseurl + "lmmutation/getCirCodeJson/" + distcode + '/' + subdivcode,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var circode = JSON.parse(data);
                var template = "<option selected disabled>Select Circle</option>";

                for (var i = 0; i < circode.length; i++) {
                    template += "<option value='" + circode[i].cir_code + "'>" + circode[i].loc_name + "</option>";
                }
                console.log(template);
                $('.circleselect').html(template);
            }
        });
    });

    $('.circleselect').change(function (e) {
        var subdivcode = $('.subdivselect').val();
        var distcode = $('.districtselect').val();
        var circode = $(this).val();
        $.ajax({
            url: baseurl + "lmmutation/getMouzaJson/" + distcode + '/' + subdivcode + '/' + circode,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var mouza = JSON.parse(data);
                var template = "<option selected disabled>Select Circle</option>";

                for (var i = 0; i < mouza.length; i++) {
                    template += "<option value='" + mouza[i].mouza_pargona_code + "'>" + mouza[i].loc_name + "</option>";
                }
                console.log(template);
                $('.mouzaselect').html(template);
            }
        });
    });

    $('.mouzaselect').change(function (e) {
        var subdivcode = $('.subdivselect').val();
        var distcode = $('.districtselect').val();
        var circode = $('.circleselect').val();
        var mouzacode = $(this).val();
        $.ajax({
            url: baseurl + "lmmutation/getLotNoJSON/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var lot = JSON.parse(data);
                var template = "<option selected disabled>Select Lot</option>";

                for (var i = 0; i < lot.length; i++) {
                    template += "<option value='" + lot[i].lot_no + "'>" + lot[i].lot_no + "</option>";
                }
                console.log(template);
                $('.lotselect').html(template);
            }
        });
    });


    $('.lotselect').change(function (e) {
        var subdivcode = $('.subdivselect').val();
        var distcode = $('.districtselect').val();
        var circode = $('.circleselect').val();
        var mouzacode = $('.mouzaselect').val();
        var lotcode = $(this).val();
        $.ajax({
            url: baseurl + "lmmutation/getVillageCodeJSON/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var lot = JSON.parse(data);
                var template = "<option selected disabled>Select Lot</option>";

                for (var i = 0; i < lot.length; i++) {
                    template += "<option value='" + lot[i].vill_townprt_code + "'>" + lot[i].loc_name + "</option>";
                }
                console.log(template);
                $('.villageselect').html(template);
            }
        });
    });

    $('.villageselect').change(function (e) {
        var subdivcode = $('.subdivselect').val();
        var distcode = $('.districtselect').val();
        var circode = $('.circleselect').val();
        var mouzacode = $('.mouzaselect').val();
        var lotcode = $('.lotselect').val();
        var villagecode = $('.villageselect').val();
        var mutationclass = $('#mutationclass').val();
        
        var functionToCall = "";
        if(mutationclass === 'office'){
            functionToCall = "coofficemutation/getOfficeMutationPetitions";
        }else if(mutationclass === 'field'){
            functionToCall = "cofieldmutation/getFieldMutationPetitions";
        }
        $.ajax({
            url: baseurl +functionToCall+"/" + distcode + '/' + subdivcode + '/' + circode + "/" +
                    mouzacode + "/" + lotcode + "/" + villagecode,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var petition = JSON.parse(data);
                var template = "<option selected disabled>Select </option>";

                for (var i = 0; i < petition.length; i++) {
                    template += "<option value='" + petition[i].petition + "-" + petition[i].dag + "'>" + petition[i].petition + "/" + petition[i].dag + "</option>";
                }
                console.log(template);
                $('.application_no').html(template);
            }
        });
    });

    $('.mutation-type').change(function (e) {
        var mutationType = $(this).val();
        console.log("Changered");
        $.ajax({
            url: baseurl + "lmmutation/getTransferTypeJSON",
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var lot = JSON.parse(data);
                var template = "<option selected disabled>Select Transfer Type</option>";

                for (var i = 0; i < lot.length; i++) {
                    template += "<option value='" + lot[i].trans_code + "'>" + lot[i].trans_desc_as + "</option>";
                }
                console.log(template);
                $('.transfer-type').html(template);
            }
        });
    });

    $('.transfer-type').change(function (e) {
        var transferType = $(this).val();
        console.log("Changer");
        $.ajax({
            url: baseurl + "pattacontroller/getPattaType/" + transferType,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var lot = JSON.parse(data);
                var template = "<option selected disabled>Select Patta Type</option>";

                for (var i = 0; i < lot.length; i++) {
                    template += "<option value='" + lot[i].type_code + "'>" + lot[i].patta_type + "</option>";
                }
                console.log(template);
                $('.patta-type').html(template);
            }
        });
    });

    $('#mb').change(function(e){
       var mb = $(this).val();
       var tb = $('#b').val();
       console.log(mb);
       console.log(tb);
       var left = tb-mb;
       if(left<0){
           alert('Exceeds!');
           $(this).val(0);
           return;
       }
       $('#rb').val(left);
    });
    
    $('#mutatedk').change(function(e){
       var mb = $(this).val();
       var tb = $('#katha').val();
       console.log(mb);
       console.log(tb);
       var left = tb-mb;
       $('#rkatha').val(left);
    });
    
    
    $('#lm').change(function(e){
       var mb = $(this).val();
       var tb = $('#l').val();
       console.log(mb);
       console.log(tb);
       var left = tb-mb;
       $('#rl').val(left);
    });

    $('.dag_no').change(function (e) {
        var dag_no = $(this).val();

        $.ajax({
            url: baseurl + "lmmutation/getLandAreaJSON/" + dag_no,
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var dag = JSON.parse(data);
                $('#b').val(dag[0].dag_area_b);
                $('#katha').val(dag[0].dag_area_k);
                $('#l').val(dag[0].dag_area_lc);
                $('#g').val(dag[0].dag_area_g);
                $('#k').val(dag[0].dag_area_kr);
                $.ajax({
                    url: baseurl + "lmmutation/getMutatedLandAreaJSON",
                    success: function (data) {
                        console.log(data);
                        var dag = JSON.parse(data);
                        $('#mb').val(dag.bigha);
                        $('#mutatedk').val(dag.katha);
                        $('#lm').val(dag.lessa);
                        $('#mg').val(0);
                        $('#mk').val(0);
                        calculateRemainingLand();
                    }
                });

            }
        });
    });
    
    $('.applicantNam').change(function (e) {
        alert("select land type");
        console.log("Changer");
        $.ajax({
            url: baseurl + "AsistantMutationPartha/getConvertionPattaTypeJSON",
            success: function (data) {
                if (debug) {
                    console.log(data);
                }
                var lot = JSON.parse(data);
                var template = "<option selected disabled>Select Patta Type</option>";

                for (var i = 0; i < lot.length; i++) {
                    template += "<option value='" + lot[i].type_code + "'>" + lot[i].patta_type + "</option>";
                }
                console.log(template);
                $('.patta-type_conv').html(template);
            }
        });
    });

    function calculateRemainingLand() {
        var bigha = $('#b').val();
        var katha = $('#katha').val();
        var lessa = $('#l').val();
        var ganda = $('#g').val();
        var krantik = $('#k').val();

        window.sourcelessa = parseInt(bigha) * 100 + parseInt(katha) * 20 + parseInt(lessa);
        console.log(window.sourcelessa);
        var mbigha = $('#mb').val();
        var mkatha = $('#mutatedk').val();
        var mlessa = $('#lm').val();
        var mg = $('#mg').val();
        var mk = $('#mk').val();

        window.targetlessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseInt(mlessa);
        console.log(window.targetlessa);
        $('#rb').val(bigha - mbigha);
        $('#rkatha').val(katha - mkatha);
        $('#rl').val(lessa - mlessa);
        $('#rg').val(ganda - mg);
        $('#rk').val(krantik - mk);

        if (window.sourcelessa < window.targetlessa) {
            alert('Source Land Area is Less than Mutated Land Area');
//          $('#form').find("input[type=text], textarea").val("");
//          $("#dag_no option[value='Select Dag']").prop('selected', true);
        }
    }


    $('.pattadar_name').change(function (e) {
        var pid = $(this).val();
        $.ajax({
            url: baseurl + "pattacontroller/getGuardianName/" + pid,
            success: function (data) {
                var obj = JSON.parse(data);
                console.log(obj[0].relation);
                $('#guardian_name').val(obj[0].gaurdian_name);
                if (obj[0].relation === null) {
                    var template = "<option selected value='u'>unknown</option>";
                    $('.relation-type').html(template);
                } else if (obj[0].relation === 'f') {
                    var template = "<option selected value='f'>father</option>";
                    $('.relation-type').html(template);
                } else if (obj[0].relation === 'm') {
                    var template = "<option selected value='f'>mother</option>";
                    $('.relation-type').html(template);
                }
            }
        })
    });
                


    $('.lmreport').click(function (e) {
        var case_no = $(this).attr('id');
        $.ajax({
            url: baseurl + "skmutation/getLMReport?case_no=" + case_no,
            success: function (d) {
                console.log(d);
            }
        });
    });

    var pattadar_name;
    var pdar_no = 1;


    if (!$('#pattadardetails').hasClass('no-trigger')) {
        $.ajax({
            url: baseurl + "officemutation/getPattadars/",
            success: function (data) {
                var obj = JSON.parse(data);
                pattadar_name = obj;
                var template = "<option selected disabled>Select Pattadar</option>";

                for (var i = 0; i < obj.length; i++) {
                    template += "<option value='" + obj[i].pdar_id + "'>" + obj[i].pdar_name + "</option>";
                }
                console.log(template);
                $('.pattadar_name').html(template);
                $('#pdar_cron_no').val(pdar_no);
            }
        });
    }

    $('.pattadar_name').change(function (e) {
        
        var pid = $(this).val();
        $.ajax({
            url: baseurl + "pattacontroller/getGuardianName/" + pid,
            success: function (data) {
                var obj = JSON.parse(data);
                console.log(obj[0].relation);
                $('#guardian_name').val(obj[0].gaurdian_name);
                $('#pdar_add1').val(obj[0].pdar_add1);
                if (obj[0].relation === null) {
                    var template = "<option selected value='u'>unknown</option>";
                    $('.relation-type').html(template);
                }
                
                

            }
        });
    });


    $('form[name="officemutationpattadardetails"]').submit(function (e) {
        e.preventDefault();
        var data = $(this).serialize();
        var selected_pattadar = $("#pdar_name").val();
        console.log(selected_pattadar);
        console.log(data);
        for (var i = 0; i < pattadar_name.length; i++) {
            if (pattadar_name[i].pdar_id === selected_pattadar) {
                pattadar_name.splice(i, 1);
            }
        }

        $.ajax({
            method: 'post',
            data: $(this).serialize()
        });

        $(this).find('input[type="text"]').val("");
        console.log(pattadar_name);
        var template = "<option selected disabled>Select Pattadar</option>";
        for (var i = 0; i < pattadar_name.length; i++) {
            template += "<option value='" + pattadar_name[i].pdar_id + "'>" + pattadar_name[i].pdar_name + "</option>";
        }
        console.log(template);
        $('.pattadar_name').html(template);
        $('#pdar_cron_no').val(++pdar_no);
    });

    $('#saveMutationPetition').click(function (e) {
        $.ajax({
            url: baseurl + "officemutation/savePetition",
            success: function (data) {
                alert("Saved");
            }
        });
    });
    var count=2;
    $('#addmore').click(function(e){
        console.log('clicked');
        var $html = $('.notification').clone();
        $($html).attr('class','row notification1');
        $($html).find('.name input').attr('name',"notification["+count+"][name]");
        $($html).find('.address1 input').attr('name',"notification["+count+"][address1]");
        $($html).find('.address2 input').attr('name',"notification["+count+"][address2]");
        $('#notificationform').append($html);
        count++;
    });
});