var baseurl = baseUrl;
$(document).ready(function (e) {
	$('#dataTable').DataTable({
            "bLengthChange": false,
            "showNEntries": false,
            "bSort": false,
            "bInfo": false,
            "pageLength": 20
        });
		
    $(document).ajaxStart(function(e){
        //console.log("Loading Data");
        $('#aa').modal();
    });

     $(document).ajaxComplete(function(e){
       // console.log("Complete Data");
        $('#aa').modal("hide");


    });

    //window.debug = true;
    //console.log("DOM Ready!Loading Corejs!!");
    // $("#cases").tablesorter();
 
    $('.husband_wife').change(function (e) {
        if (this.checked) {
            $('#applicant_name_label').text("Husband's Name");
            $('#applicant_name_label').css('color', 'red');

        } else {
            $('#applicant_name_label').text("Applicant's Name");

        }

    });

    $('form#submitlandarea').submit(function (e) {
        e.preventDefault();
        if ((parseInt($('input[name="min_revenue"]').val()) === 0) || isNaN($('input[name="min_revenue"]').val())) {
            alert("Revenue Cannot be Zero.");
            return;
        }
        var b = $('dag_area_b').val();
        var k = $('dag_area_k').val();
        var lc = $('dag_area_lc').val();




        var bm = $('#mb').val();
        var km = $('#mutatedk').val();
        var lcm = $('#lm').val();

        var target = parseInt(bm) * 100 + parseInt(km) * 20 + parseFloat(lcm);
        var mut = $('#mut_type').val();
        
        if ((target === 0) && (mut!=='01') && (mut!=='11')) {
            alert("Error in  entering mutation land area");
            return false;
        }

        $.ajax({
            url: baseurl + "lmmutation/saveMutationDagDetails",
            data: $('form#submitlandarea').serialize(),
            method: 'post',
            success: function (d) {
                console.log(d);
                //exit;
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
                        alert("Data Successfully Saved !!");
                        $('form#submitlandarea').find("input[type=text], textarea").val("0");
                        $('.next').removeAttr('disabled');
                        
                    }
                });
                var response = JSON.parse(d);
                console.log(response);
                if(response === false){
                    window.location = baseurl + "lmmutation/pattadardetails"
                }
            }
        });
    });



    /*$('form#submitlandarea').submit(function (e) {
     e.preventDefault();
     if ((parseInt($('input[name="min_revenue"]').val()) === 0) || isNaN($('input[name="min_revenue"]').val())) {
     alert("Revenue Cannot be Zero.");
     return;
     }
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
     $('form#submitlandarea').find("input[type=text], textarea").val("0");
     $('.next').removeAttr('disabled');
     
     }
     });
     }
     });
     });*/





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
        //alert(distCode);
        console.log("aa" + baseurl);
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
                // if (debug) {
                    // console.log(data);
                // }
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
        //alert("asda");
        var subdivcode = $('.subdivselect').val();
        var distcode = $('.districtselect').val();
        var circode = $(this).val();
        $.ajax({
            url: baseurl + "lmmutation/getMouzaJson/" + distcode + '/' + subdivcode + '/' + circode,
            success: function (data) {
                // if (debug) {
                    // console.log(data);
					
                // }
                var mouza = JSON.parse(data);
				console.log(mouza);
				//alert(mouza[0].loc_name);
                var template = "<option selected disabled>Select Mouza</option>";

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
                // if (debug) {
                    // console.log(data);
                // }
                var lot = JSON.parse(data);
                var template = "<option selected disabled>Select Lot</option>";

                if(lot[0].error) {
                    alert(lot[0].error);
                }
                else{
                    for (var i = 0; i < lot.length; i++) {
                        template += "<option value='" + lot[i].lot_no + "'>" + lot[i].loc_name + "</option>";
                    }
                }
                // console.log(template);
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
                // if (debug) {
                    // console.log(data);
                // }
                var lot = JSON.parse(data);
                var template = "<option selected disabled>Select Village</option>";

                if(lot[0].error) {
                    alert(lot[0].error);
                }
                else{
                    for (var i = 0; i < lot.length; i++) {
                        template += "<option value='" + lot[i].vill_townprt_code + "'>" + lot[i].loc_name + "</option>";
                    }
                }
                // console.log(template);
                $('.villageselect').html(template);
            }
        });
    });

    

    //modified by bondita //modified by bondita//modified by bondita//modified by bondita
//    $('.villageselect').change(function (e) {
//        var subdivcode = $('.subdivselect').val();
//        var distcode = $('.districtselect').val();
//        var circode = $('.circleselect').val();
//        var mouzacode = $('.mouzaselect').val();
//        var lotcode = $('.lotselect').val();
//        var villcode = $(this).val();
//
//        $.ajax({
//            url: baseurl + "JamabandiControllerBondita/getpattaJSON/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode + "/" + villcode,
//            success: function (data) {
//                if (debug) {
//                    console.log(data);
//                }
//                var lot = JSON.parse(data);
//                var template = "<option selected disabled>Select Village</option>";
//
//                for (var i = 0; i < lot.length; i++) {
//                    template += "<option value='" + lot[i].vill_townprt_code + "'>" + lot[i].loc_name + "</option>";
//                }
//                console.log(template);
//                $('.villageselect').html(template);
//            }
//        });
//    });
    $('.pattatype_nmae').change(function (e) {
        var subdivcode = $('.subdivselect').val();
        var distcode = $('.districtselect').val();
        var circode = $('.circleselect').val();
        var mouzacode = $('.mouzaselect').val();
        var lotcode = $('.lotselect').val();
        var villcode = $('.villageselect').val();
        var patta_type = $(this).val();
        $.ajax({
            url: baseurl + "JamabandiControllerBondita/getpattaTypebyname/" + distcode + '/' + subdivcode + '/' + circode + "/" + mouzacode + "/" + lotcode + "/" + villcode+ "/" + patta_type,
            success: function (data) {
                // if (debug) {
                    // console.log(data);
                // }
                //  console.log(data);
               var lot = JSON.parse(data);
                var template = "<option selected disabled>Select Patta Number</option>";

                if(lot[0].error) {
                    alert(lot[0].error);
                }
                else{
                    for (var i = 0; i < lot.length; i++) {
                        template += "<option value='" + lot[i].patta_no + "'>" + lot[i].patta_no + "</option>";
                    }
                }
                // console.log(template);
                $('.pattanoselect').html(template);
            }
        });
    });

    //modified by bondita//modified by bondita//modified by bondita



    $('.mutation-type').change(function (e) {
        var mutationType = $(this).val();
       // alert("mutationType");
        if (mutationType === '02') {
            $('.hideonselect').css('display', 'none');
            $.ajax({
                url: baseurl + "pattacontroller/getPattaType/",
                success: function (data) {
                    // if (debug) {
                        // console.log(data);
                    // }
                    var lot = JSON.parse(data);
                    var template = "<option selected disabled>Select Patta Type</option>";

                    for (var i = 0; i < lot.length; i++) {
                        template += "<option value='" + lot[i].type_code + "'>" + lot[i].patta_type + "</option>";
                    }
                    console.log(template);
                    $('.patta-type').html(template);
                }
            });
        }

        $.ajax({
            url: baseurl + "lmmutation/getTransferTypeJSON",
            success: function (data) {
                // if (debug) {
                    // console.log(data);
                // }
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
                // if (debug) {
                    // console.log(data);
                // }
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

    $('#mb').change(function (e) {
        var mb = $(this).val();
        var tb = $('#b').val();
        console.log(mb);
        console.log(tb);
        var left = tb - mb;
        if (left < 0) {
            alert('Exceeds!');
            $(this).val(0);
            return;
        }
        $('#rb').val(left);
        calculateRemainingLand();
    });

    $('#mutatedk').change(function (e) {      
        var mb = $(this).val();
        var tb = $('#katha').val();
        console.log(mb);
        console.log(tb);
        var left = tb - mb;
        
        $('#rkatha').val(left);
        calculateRemainingLand();
    });

    $('#lm').change(function (e) {
        var mb = $(this).val();
        var tb = $('#l').val();
        console.log(mb);
        console.log(tb);
        var left = tb - mb;
        $('#rl').val(left);
        calculateRemainingLand();
    });

    $('.dag_no').change(function (e) {
        var dag_no = $(this).val();
		//alert(dag_no);
        $.ajax({
            url: baseurl + "lmmutation/getLandAreaJSON/" + dag_no,
            success: function (data) {
                // if (debug) {
                    // console.log(data);
                // }
                //console.log(data);
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


        window.remaininglessa = sourcelessa - targetlessa;
        //alert(remaininglessa);

        var bigha_r = Math.floor(remaininglessa / 100);
        var katha_r = Math.floor((remaininglessa - bigha_r * 100) / 20);
        var lessa_r = remaininglessa - bigha_r * 100 - katha_r * 20;

//        $('#rb').val(remaininglessa/100);
//        $('#rkatha').val(katha - mkatha);
//        $('#rl').val(lessa - mlessa);
//        $('#rg').val(ganda - mg);
//        $('#rk').val(krantik - mk);

        $('#rb').val(bigha_r);
        $('#rkatha').val(katha_r);
        $('#rl').val(lessa_r);
        $('#rg').val(ganda - mg);
        $('#rk').val(krantik - mk);

        if (window.sourcelessa < window.targetlessa) {
            alert('Source Land Area is Less than Mutated Land Area');
             $('#submitlandarea').prop("disabled", false);
          
        }else{
            console.log("here");
            $('#submitlandarea').prop("disabled", false);
        }
         //alert(window.sourcelessa);
    }

    //#START PLB
     function calculateRemainingLandkarim() {
        
        var bigha = $('#b').val();
        var katha = $('#katha').val();
        var lessa = $('#l').val();
        var ganda = $('#g').val();
        var krantik = $('#k').val();
        window.sourcelessa = parseInt(bigha) * 6400 + parseInt(katha) * 320 + parseInt(lessa) * 20 + parseInt(ganda);
        //window.sourcelessa = parseInt(bigha) * 100 + parseInt(katha) * 20 + parseInt(lessa);
        console.log(window.sourcelessa);
        var mbigha = $('#mbk').val();
        var mkatha = $('#mutatedkk').val();
        var mlessa = $('#lmk').val();
        var mg = $('#mgk').val();
        var mk = $('#mkk').val();
        window.targetlessa = parseInt(mbigha) * 6400 + parseInt(mkatha) * 320 + parseInt(mlessa) * 20 +  parseInt(mg);
       // window.targetlessa = parseInt(mbigha) * 100 + parseInt(mkatha) * 20 + parseInt(mlessa);
        console.log(window.targetlessa);
        window.remaininglessa = sourcelessa - targetlessa;
        var bigha_r = Math.floor(remaininglessa / 6400);
        var katha_r = Math.floor((remaininglessa - bigha_r * 6400) / 320);
        var lessa_r = Math.floor((remaininglessa - bigha_r * 6400 - katha_r * 320)/20);
        var ganda_r = remaininglessa - bigha_r * 6400 - katha_r * 320 - lessa_r * 20 ;

        $('#rb').val(bigha_r);

        $('#rkatha').val(katha_r);
        $('#rl').val(lessa_r);
        $('#rg').val(ganda_r);
        //$('#rg').val(ganda - mg);
        $('#rk').val(krantik - mk);
        if (window.sourcelessa < window.targetlessa) {
            alert('Source Land Area is Less than Mutated Land Area');
             $('#submitlandarea').prop("disabled", false);
          
        }else{
            console.log("here");
            $('#submitlandarea').prop("disabled", false);
        }
         //alert(window.sourcelessa);
    }

    //#END PLB



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

    // if (!($('form').hasClass('no-trigger'))) {
    //     $.ajax({
    //         url: baseurl + "officemutation/getPattadars/",
    //         success: function (data) {
    //             var obj = JSON.parse(data);
    //             pattadar_name = obj;
    //             var template = "<option selected disabled>Select Pattadar</option>";

    //             for (var i = 0; i < obj.length; i++) {
    //                 template += "<option value='" + obj[i].pdar_id + "'>" + obj[i].pdar_name + "</option>";
    //             }
    //             console.log(template);
    //             $('.pattadar_name').html(template);
    //             $('#pdar_cron_no').val(pdar_no);
    //         }
    //     });
    // };
	$('.pattadar_name').change(function () {
        var pid = $(this).val();
        var dag = $('#current_dag').val();
        $.ajax({
            url: baseurl + "PattaController/getGuardianName/" + pid+"/"+dag,
            success: function (data) {
                var obj = JSON.parse(data);
                console.log(obj);
                $('#guardian_name').val(obj[0].gaurdian_name);
                $('#pdar_add1').val(obj[0].pdar_add1);
                $('#pdar_add2').val(obj[0].pdar_add2);
                $('#pdar_mother').val(obj[0].pdar_mother);
                $('#pdar_aadhar').val(obj[0].pdar_aadharno);
                $('#pdar_nrc').val(obj[0].pdar_nrcno);
                $('#pdar_mobile').val(obj[0].pdar_mobile);
                $('#pdar_pan').val(obj[0].pdar_pan_no);
                $('#pdar_voterID').val(obj[0].pdar_citizen_no);
              
                var a = obj[0].pdar_mother;
                var d=obj[0].pdar_pan_no;
                console.log(a)
                //alert(a);
                
                if (obj[0].relation == null)
                {
                    var template = "<option value=' '>অভিভাৱক</option>";
                    $('.relation-type').html(template);
                } else if (obj[0].relation === 'f') {
                    var template = "<option selected value='f'>father</option>";
                    $('.relation-type').html(template);
                } else if (obj[0].relation === 'm') {
                    var template = "<option selected value='f'>mother</option>";
                    $('.relation-type').html(template);
                } else {
                    var template = "<option selected value='u'>unknown</option>";
                    $('.relation-type').html(template);
                }
                if (obj[0].pdar_gender == null)
                {
                    var template = "<option value='0'> বাছি লওঁক </option>";
                    template += "<option value='M '> পুৰুষ </option>";
                    template += "<option value='F'> মহিলা </option>";
                    template += "<option value='O'> অন্যান্য </option>";
                    $('.pdar_gender').html(template);
                }else if (obj[0].pdar_gender == 'M'){
                   var template = "<option value='M '> পুৰুষ </option>";
                     $('.pdar_gender').html(template);
                }
                else if (obj[0].pdar_gender == 'F'){
                   var   template = "<option value='F'> মহিলা </option>";
                     $('.pdar_gender').html(template);
                }

            }
        });
    });

    $('.pattadarop').change(function (e) {
        var pid = $(this).val();
        var dag = $('#current_dag').val();
        $.ajax({
            url: baseurl + "PattaController/getGuardianName/" + pid+"/"+dag,
            success: function (data) {
                var obj = JSON.parse(data);
                console.log(obj);
                $('#guardian_name').val(obj[0].gaurdian_name);
                $('#pdar_add1').val(obj[0].pdar_add1);
                $('#pdar_add2').val(obj[0].pdar_add2);
                $('#pdar_mother').val(obj[0].pdar_mother);
                $('#pdar_aadhar').val(obj[0].pdar_aadharno);
                $('#pdar_nrc').val(obj[0].pdar_nrcno);
                $('#pdar_mobile').val(obj[0].pdar_mobile);
                $('#pdar_pan').val(obj[0].pdar_pan_no);
                $('#pdar_voterID').val(obj[0].pdar_citizen_no);
                var a = obj[0].pdar_mother;
                var d=obj[0].pdar_pan_no;
                //console.log(a)
            }
        });
    });

    $('form[name="officemutationpattadardetails"]').submit(function (e) {
        $('.add_moree').attr("disabled", false);
      //  $(".form_block *").attr("disabled", "disabled");
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
            data: $(this).serialize(),
            
        });

        $(this).find('input[type="text"]').val("");
        console.log(pattadar_name);
        var template = "<option selected disabled>Select Pattadar</option>";
        for (var i = 0; i < pattadar_name.length; i++) {
            template += "<option value='" + pattadar_name[i].pdar_id + "'>" + pattadar_name[i].pdar_name + "</option>";
        }
        console.log(template);
        alert("Applicant Name Added Successfully !!");
        $('.pattadar_name').html(template);
        $('#pdar_cron_no').val(++pdar_no);
    });

  $('.add_moree').attr("disabled", true);

    $('#saveMutationPetition').click(function (e) {
        $.ajax({
            url: baseurl + "officemutation/savePetition",
            success: function (data) {
                alert("Saved");
                window.location = baseurl + "home"
            }
        });
    });

    $('#P_land').keyup(function (e) {
        var P_land_rev = $(this).val();
        var loc_tax = 0;
        var tot_rev = 0;
        var total = 0;
        if($.isNumeric(P_land_rev) && P_land_rev >= 0){
            loc_tax = (P_land_rev) / 4;
            tot_rev = $('#tot_rev').val();
            //alert (loc_tax);
            total = parseFloat(loc_tax) + parseFloat(P_land_rev);
        }
        window.sourcelessa = total;
        // console.log(window.sourcelessa);
        //alert (window.sourcelessa);
        $('#p_loc_tax').val(loc_tax);
        $('#rev_diff').val(parseFloat(window.sourcelessa - tot_rev).toFixed(2));
    });

    $('.pdar_info').change(function (e) {
        var pdar_id = parseInt($(this).val());
        //alert(pdar_id);
        if (pdar_id != 0 || pdar_id != null) {
            $.ajax({
                url: baseurl + "NameCorrection/getPdarData/" + pdar_id,
                success: function (data) {
                    var pdardata = JSON.parse(data);
                    //alert(pdardata);
                    for (var i = 0; i < pdardata.length; i++) {
                        $('.pdar_name input').val(pdardata[i].pdar_name);
                        //$('.pdar_id input').val(pdardata[i].pdar_id);
                        $('.pdar_father input').val(pdardata[i].pdar_father);
                        $('.pdar_guard_reln select').val(pdardata[i].pdar_guard_reln);
                        $('.pdar_add1 input').val(pdardata[i].pdar_add1);
                        $('.pdar_add2 input').val(pdardata[i].pdar_add2);
                    }

                }
            });
        }
    });

    $('.pdar_id').change(function (e) {
        var pdar_id = parseInt($(this).val());

        // alert(pdar_id);
        if (pdar_id != 0 || pdar_id != null) {
            $.ajax({
                url: baseurl + "APCancellation/getPdarData/" + pdar_id,
                success: function (data) {

                    var pdardata = JSON.parse(data);


                    for (var i = 0; i < pdardata.length; i++) {

                        $('.pdar_father input').val(pdardata[i].pdar_father);
                        $('.pdar_guard_reln input').val(pdardata[i].pdar_guard_reln);
                        $('.pdar_add1 input').val(pdardata[i].pdar_add1);
                        $('.pdar_add2 input').val(pdardata[i].pdar_add2);

                    }

                }
            });
        }
    });

    //for autocomplete in ASTStep2 for finding correct patta no
    $('.applied_to').change(function (e) {
        var user_code = $(this).val();
        //alert (user_code);
        console.log("Changer");
        $.ajax({
            url: baseurl + "partition/getdesignation/" + user_code,
            success: function (data) {
                console.log(data);
                //alert("da")
                var name = JSON.parse(data);
                var template = "<option  disabled>Select Name</option>"
                for (var i = 0; i < name.length; i++) {
                    template += "<option selected value='" + name[i].user_code + "'>" + name[i].username + "</option>"
                }
                console.log(template);
                $('#ss').html(template);

            }
        });
    });

    $('.cert_code').change(function (e) {
        var cer_code = $(this).val();

        var cer_code = cer_code.split('#');
        var cer_code = cer_code[0];
        console.log(cer_code);
        if (cer_code[0] != '00')
        {
            console.log("Changer");
            $.ajax({
                url: baseurl + "citizencontroller/getfee/" + cer_code,
                success: function (data) {
                    console.log(data);
                    //alert("da")
                    var name = JSON.parse(data);
                    if(name[0].error) {
                        alert(name[0].error);
                    }
                    else{
                        for (var i = 0; i < name.length; i++) {
                            $('.cert_fee input').val(name[i].cert_fees);
                        }
                    }
                }
            });
        }
    });

    $('#pattadar_id').change(function (e) {
        var pdar_id = parseInt($(this).val());
        //alert(pdar_id);
        if (pdar_id != 0 || pdar_id != null) {
            $.ajax({
                url: baseurl + "citizencontroller/getPdarData/" + pdar_id,
                success: function (data) {
                    var pdardata = JSON.parse(data);
                    //alert(pdardata);
                    if(pdardata[0].error) {
                        alert(pdardata[0].error);
                    }
                    else{
                        for (var i = 0; i < pdardata.length; i++) {
                            $('.pdar_name input').val(pdardata[i].pdar_name);
                            $('.pdar_id input').val(pdardata[i].pdar_id);
                            $('.pdar_father input').val(pdardata[i].pdar_father);
                            $('.pdar_guard_reln select').val(pdardata[i].pdar_guard_reln);
                        }
                    }
                }
            });
        }
    });

     // 23.03.2022 DRONA

    $('.deed_value_new').on('keyup', function(){
        var FDeedVal = $('#xyz').val()? $('#xyz').val() : '0';
        var sDeedVal = $('#abc').val()? $('#abc').val() : '0';
        var TDeedVal = $('#pqr').val()? $('#pqr').val() : '0';
        var c = 0;
        if (FDeedVal == null || FDeedVal == '') {
            FDeedVal = 0;
        } else {
            c++;
        }
        if (sDeedVal == null || sDeedVal == '') {
            sDeedVal = 0;
        } else {
            c++;
        }
        if (TDeedVal == null || TDeedVal == '') {
            TDeedVal = 0;
        } else {
            c++;
        }
        var tot = (parseInt(FDeedVal) + parseInt(sDeedVal) + parseInt(TDeedVal)) ;
        tot = tot.toFixed(2);
        //alert(tot);

        $('#TotLandPric').val(tot);
    });

    // $('#xyz').blur(function (e) {
    //     var FDeedVal = parseInt($(this).val()) ? parseInt($(this).val()) : '0';
    //     var sDeedVal = $('#abc').val()? $('#abc').val() : '0';
    //     var TDeedVal = $('#pqr').val()? $('#pqr').val() : '0';
    //     var c = 0;
    //     if (FDeedVal == null || FDeedVal == '') {
    //         FDeedVal = 0;
    //     } else {
    //         c++;
    //     }
    //     if (sDeedVal == null || sDeedVal == '') {
    //         sDeedVal = 0;
    //     } else {
    //         c++;
    //     }
    //     if (TDeedVal == null || TDeedVal == '') {
    //         TDeedVal = 0;
    //     } else {
    //         c++;
    //     }
    //     var tot = (parseInt(FDeedVal) + parseInt(sDeedVal) + parseInt(TDeedVal)) ;
    //     tot = tot.toFixed(2);
    //     //alert(tot);

    //     $('#TotLandPric').val(tot);

    // });
    // $('#abc').blur(function (e) {
    //     var FDeedVal = parseInt($(this).val()) ? parseInt($(this).val()) : '0';
    //     var sDeedVal = $('#xyz').val()? $('#xyz').val() : '0';
    //     var TDeedVal =$('#pqr').val()? $('#pqr').val() : '0';
    //     var c = 0;
    //     if (FDeedVal == null || FDeedVal == '') {
    //         FDeedVal = 0;
    //     } else {
    //         c++;
    //     }
    //     if (sDeedVal == null || sDeedVal == '') {
    //         sDeedVal = 0;
    //     } else {
    //         c++;
    //     }
    //     if (TDeedVal == null || TDeedVal == '') {
    //         TDeedVal = 0;
    //     } else {
    //         c++;
    //     }

    //     var tot = (parseInt(FDeedVal) + parseInt(sDeedVal) + parseInt(TDeedVal)) ;
    //     tot = tot.toFixed(2);
    //     //alert(tot);

    //     $('#TotLandPric').val(tot);

    // });
    // $('#pqr').blur(function (e) {
    //     var FDeedVal = parseInt($(this).val()) ? parseInt($(this).val()) : '0';
    //     var sDeedVal = $('#abc').val() ? $('#abc').val() : '0';
    //     var TDeedVal = $('#xyz').val()? $('#xyz').val() : '0';
    //     var c = 0;
    //     if (FDeedVal == null || FDeedVal == '') {
    //         FDeedVal = 0;
    //     } else {
    //         c++;
    //     }
    //     if (sDeedVal == null || sDeedVal == '') {
    //         sDeedVal = 0;
    //     } else {
    //         c++;
    //     }
    //     if (TDeedVal == null || TDeedVal == '') {
    //         TDeedVal = 0;
    //     } else {
    //         c++;
    //     }
    //     var tot = (parseInt(FDeedVal) + parseInt(sDeedVal) + parseInt(TDeedVal)) ;
    //     tot = tot.toFixed(2);
    //     //alert(tot);
    //     $('#TotLandPric').val(tot);


    // });

    $('#no_year').change(function (e) {
        var nid = parseInt($(this).val());
        //alert(nid);
        if (nid != 0 || nid != null) {
            $.ajax({
                url: baseurl + "CitizenController/getAddYearAfter/" + nid,
                success: function (data) {
                    var year = JSON.parse(data);
                    //console.log(year);
                    for (var i = 0; i < year.length; i++) {
                        $('.display_year input').val(year[i].display_year)
                    }
                }
            });
        }
    });

    $('.desig_on_name').change(function (e) {
        var user_code = $('#n').val();
        //alert (user_code);
        console.log("Changer");
        $.ajax({
            url: baseurl + "AsistantMutationPartha/getDesignationTypeJSON/" + user_code,
            success: function (data) {
                console.log(data);
                var lot = JSON.parse(data);
                $('#designation').val(lot);
            }
        });
    });

    $('.dag_no_sara').change(function (e) {
        var dag_no = $(this).val();

        $.ajax({
            url: baseurl + "lmmutation/getLandAreaJSON/" + dag_no,
            success: function (data) {
                // if (debug) {
                    // console.log(data);
                // }
                var dag = JSON.parse(data);
                $('#b').val(dag[0].dag_area_b);
                $('#katha').val(dag[0].dag_area_k);
                $('#l').val(dag[0].dag_area_lc);
                $('#g').val(dag[0].dag_area_g);
                $('#k').val(dag[0].dag_area_kr);
                $('#b1').val(dag[0].dag_area_b);
                $('#katha1').val(dag[0].dag_area_k);
                $('#l1').val(dag[0].dag_area_lc);
                $('#g1').val(dag[0].dag_area_g);
                $('#k1').val(dag[0].dag_area_kr);
                $('#b2').val(dag[0].dag_area_b);
                $('#katha2').val(dag[0].dag_area_k);
                $('#l2').val(dag[0].dag_area_lc);
                $('#g2').val(dag[0].dag_area_g);
                $('#k2').val(dag[0].dag_area_kr);
                $('#dag_rev').val(dag[0].dag_revenue);
                $.ajax({
                    url: baseurl + "lmmutation/getMutatedLandAreaJSON",
                    success: function (data) {
                        console.log(data);
                        var dag = JSON.parse(data);
                        $('#mb').val(dag[0].bigha);
                        $('#mutatedk').val(dag[0].katha);
                        $('#lm').val(dag[0].lessa);
                        $('#mg').val(0);
                        $('#mk').val(0);
                        calculateRemainingLand();
                    }
                });

            }
        });
    });

    $('#premium').keyup(function (e) {
        var value = $(this).val();
        var bigha = $('#b').val();
        var katha = $('#k').val();
        var lessa = $('#l').val();
        //alert (mb);
        window.sourcelessa = parseInt(bigha) * 100 + parseInt(katha) * 20 + parseInt(lessa);
        console.log(window.sourcelessa);
        //alert (window.sourcelessa);
        $('#rk').val(window.sourcelessa * value / 100);
    });

    $('.new_patta_type').change(function (e) {
        var type_code = $(this).val();
        //alert (type_code);
        console.log("Changer");
        $.ajax({
            url: baseurl + "COconversionPartha/getNewDagPattaTypeJSON/" + type_code,
            success: function (data) {
                console.log(data);
                var lot = JSON.parse(data);
                $('#newDag').val(lot[0].new_dag);
                $('#newPatta').val(lot[0].new_patta);
            }
        });
    });


    $('#openBtn').click(function () {
        location.href = baseurl+"CitizenController/index";
    });
    $('#MainIndex').click(function () {
        location.href = baseurl+"home";
    });

    

    $('#villageselect_office').change(function (e) {
        var vill_code = $(this).val();
        var dist_code = $('.districtselect').val();
        var subdiv_code = $('.subdivselect').val();
        var cir_code = $('.circleselect').val();
        var mouza_pargona_code = $('.mouzaselect').val();
        var lot_no = $('.lotselect').val();
        //alert (user_code);
        console.log("Changer");
        $.ajax({
            url: baseurl + "coofficemutation/getOfficeMutationPetitions/" + dist_code + "/" + subdiv_code + "/" + cir_code + "/" + mouza_pargona_code + "/" + lot_no + "/" + vill_code,
            success: function (data) {
                console.log(data);
                //alert("da")
                var name = JSON.parse(data);
                var template = "<option selected disabled>Select Application no</option>"
                for (var i = 0; i < name.length; i++) {
                    template += "<option value='" + name[i].petition + "-" + name[i].dag + "'>" + name[i].petition + "/" + name[i].dag + "</option>"
                }
                console.log(template);
                $('select.application_no').html(template);

            }
        });
    });

    $('#village_select_field').change(function (e) {
        var vill_code = $(this).val();
        var dist_code = $('.districtselect').val();
        var subdiv_code = $('.subdivselect').val();
        var cir_code = $('.circleselect').val();
        var mouza_pargona_code = $('.mouzaselect').val();
        var lot_no = $('.lotselect').val();
        //alert (user_code);
        console.log("Changer");
        $.ajax({
            url: baseurl + "AjaxController/getFieldMutationPetitions/" + dist_code + "/" + subdiv_code + "/" + cir_code + "/" + mouza_pargona_code + "/" + lot_no + "/" + vill_code,
            success: function (data) {
                console.log(data);
                //alert("da")
                var name = JSON.parse(data);
                var template = "<option selected disabled>Select CO Name</option>"
                for (var i = 0; i < name.length; i++) {
                    template += "<option value='" + name[i].petition + "-" + name[i].dag + "'>" + name[i].petition + "/" + name[i].dag + "</option>"
                }
                console.log(template);
                $('select.application_no').html(template);
            }
        });
    });

    $('.pattadar_name_no_session').change(function (e) {
        var pid = $(this).val();
        var case_no = $('#case').val();
        $.ajax({
            url: baseurl + "pattacontroller/getGuardianNameNoSession/" + pid + "?case_no=" + case_no,
            success: function (data) {
                var obj = JSON.parse(data);
                console.log(obj[0].relation);
                $('#guardian_name').val(obj[0].gaurdian_name);
                $('#pdar_add1').val(obj[0].pdar_add1);

                if (obj[0].relation === null) {
                    var template = "<option selected value='u'>unknown</option>";
                    $('.relation-type').html(template);
                } else if (obj[0].relation === 'f') {
                    var template = "<option selected value='f'>father</option>";
                    $('.relation-type').html(template);
                } else if (obj[0].relation === 'm') {
                    var template = "<option selected value='f'>mother</option>";
                    $('.relation-type').html(template);
                } else {
                    var template = "<option selected value='u'>unknown</option>";
                    $('.relation-type').html(template);
                }
            }
        });
    });
    $("#quantity").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $("#errmsg").html("Number Only").show().fadeOut("slow");
            return false;
        }
    });
    $(".landNumB").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $(".errmsgB").html("Number Only").show().fadeOut("slow");
            return false;
        }
    });
    $(".landNumK").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $(".errmsgK").html("Number Only").show().fadeOut("slow");
            return false;
        }
    });
    $(".landNumL").keypress(function (e) {
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            $(".errmsgL").html("Number Only").show().fadeOut("slow");
            return false;
        }
    });
	$('.dag_no_change').change(function (e) {
        var dag_no = $(this).val();
        console.log("Changer");
        $('#appliedbigha').val('0');
        $('#appliedkatha').val('0');
        $('#appliedlessa').val('0');
        $('#appliedganda').val('0');
        $.ajax({
            url: baseurl + "CitizenController/LMValidation/" + dag_no,
            success: function (data) {
                // if (debug) {
                //     console.log(data);
                // }
                        var dag = JSON.parse(data);
                        $('#appliedbigha').val(dag.bigha);
                        $('#appliedkatha').val(dag.katha);
                        $('#appliedlessa').val(dag.lessa);
                        $('#appliedganda').val(dag.ganda);
            }
        });
    });

    $(window).unload(function () {
        alert("Bye now!");
    });

    $('input[type="number"]').change(function (e) {

    });
	$('#cases').DataTable();
    ///////Basu//////////
       $(".reject").click(function(event){
          event.preventDefault();
          $("#myModal").modal('show');
      });
      $(".query").click(function(event){
              event.preventDefault();
              $("#myModal1").modal('show');
      });
      $('#rejectSubmit').click(function(event){
          event.preventDefault();
          $(this).find("input,textarea,select").removeAttr('required')
          $(this).find("input[type=checkbox], input[type=radio]").removeAttr('required')    
          $('#rejectForm').submit();
      });
      $('#querySend').click(function(event){
          event.preventDefault();
          $("form").each(function(){
                $(this).find(':input').removeAttr('required') //<-- Should return all input elements in that specific form.
            });
         $('#queryRequest').submit();
      });

       $(".revertToLmModal").click(function(event){
              event.preventDefault();
              $("#revertToLmModal").modal('show');
      });

     $(".revertToLmForReport").click(function(event){
              event.preventDefault();
              $("#revertToLmForReport").modal('show');
      });

     //#START PLB
        $(".rejectTM").click(function(event){
                event.preventDefault();
                $("#rejectTM").modal('show');
        });
        $(".rejectTMR").click(function(event){
                event.preventDefault();
                $("#rejectTMR").modal('show');
        });
        $(".revertToLmForReportR").click(function(event){
                event.preventDefault();
                $("#revertToLmForReportR").modal('show');
        });

    //#END PLB
      
      /////////////////
      /////////////////

      ////21-02-22/// Utpal

    // $(document).on('click','.btnFirstApplEditLM', function(){
        // id = $(this).attr('id');
        // $('#editAppl_'+id).modal('show');
    // });
    // $(document).on('click','.btnApplicantCloseModal', function(){
        // id = $(this).attr('id');
        // $('#editAppl_'+id).modal('hide');
    // });    
    // $('.uploadFreshDocumentLM').click(function(){

        // flag = $(this).attr('id');
    
        // var formdata = new FormData();

        // if(flag == 1){
            // formdata.append("death_cer", $('#death_cer')[0].files[0]);
        // }
        // if(flag == 2){
            // formdata.append("noc_file", $('#noc_file')[0].files[0]);
        // }
        // if(flag == 3){
            // formdata.append("nok_file", $('#nok_file')[0].files[0]);
        // }

        // formdata.append("case_no", $('#case_no').val());
        // formdata.append("flag", $(this).attr('id'));
        // formdata.append("dist_code", $('#dist_code').val());

        // console.log(formdata);

        // $.ajax({
            // url: baseurl + "lmmutation/uploadSupportiveDocs/",
            // type: 'POST',
            // enctype: 'multipart/form-data',
            // data: formdata,
            // contentType: false,
            // cache: false,
            // processData:false,
            // dataType: "json",

            // success: function (data) 
            // {
                // console.log(data);
                // if(data.img_upload === true){
                    // alert("File has successfully uploaded..");
                // }
                // if(data.flag_set == '1'){
                    // $('#file_1').html('<a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a>');
                // }
                // if(data.flag_set == '2'){
                    // $('#file_2').html('<a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a>');
                // }
                // if(data.flag_set == '3'){
                    // $('#file_3').html('<a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a>');
                // }

                // if(data.img_upload === false){
                    // alert("File Uploading Failed..");
                // }
                // if(data.error != null)
                // {
                    // $('#alert_message').html('');
                    // var error_message = '';

                    // $.each(data.error, function (index, value) {
                        // $('#alert_message').fadeIn();
                        // error_message += '<li>'+value['message']+'</li>'
                    // });
                    // $('#alert_message')
                        // .html('<div class="bg-gradient-danger p-2 rounded">'+error_message +
                            // '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');
                    // setTimeout(function(){
                        // $('#alert_message').fadeOut();
                    // }, 5000);

                    // return false;
                // }

            // }
        // });
    // });
    // $('#first_applicant_edit').submit(function(e){
        // e.preventDefault();
        // id = $('#pet_id').val();
        // $.ajax({
            // url: baseurl + "lmmutation/firstApplicantEditInfo/",
            // type:'POST',
            // data:$("#first_applicant_edit").serialize(),
            // dataType:'json',
            // success: function (data) {

                // console.log(data);
                // if(data.petitioner_update == 'true')
                // {
                    // alert("Applicant detail has updated successfully");
                    // $('#editAppl_'+id).modal('hide');
                    // var table = '';
                    // $.each(data.detail, function (i, val) { 
                    // i++;

                    // bigha = ((val['applied_b']==null)?'0':val['applied_b']);
                    // katha = ((val['applied_k']==null)?'0':val['applied_k']);
                    // lessa = ((val['applied_lc']==null)?'0':val['applied_lc']);

                    // address2 = ((val['add2']==null)?'':val['add2']);

                    // land = 'B:'+bigha+' / K:'+katha+' / L:'+lessa+' / Kr:0';
                    // table +=                     
                        // '<tr id="pet_"'+val['pet_id']+'>'+
                            // '<td>' + val["pet_id"] + '</td>' +
                            // '<td>' + val["pet_name"] + '</td>' +
                            // '<td>' + val["guard_name"] + '</td>' +
                            // '<td>Add 1: ' + val["add1"] + ' / Add 2: ' +address2+ '</td>' +
                            // '<td>' + land + '</td>' +
                            // '<td><button class="btn btn-sm btn-primary btnFirstApplEditLM" id="'+
                            // val['pet_id']+'">Edit Applicant&nbsp;&nbsp;<i class="fa fa-plus-square"></i></button></td>'+
                        // '</tr>'
                    // });
                    // console.log(table);
                    // $('#field_mut_petitioner').html(table);
                // }
                // if(data.basundhara_ins == 'false')
                // {
                    // alert("Basundhara insertion failed");
                    // return false;
                // }
                // if(data.petitioner_update == 'false')
                // {
                    // alert("Petitioner updation failed");
                    // return false;
                // }
                // if(data.error)
                // {
                    // $.each(data.error, function (index, value) {
                        // $('#alert_'+value['field']).fadeIn();
                        // $('#alert_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        // setTimeout(function(){
                            // $('#alert_'+value['field']).fadeOut();
                        // }, 5000);
                    // });    
                // }
            // }
        // });
    // });


// $('.uploadDocumentLM').click(function(){

        // flag = $(this).attr('id');
    
        // var formdata = new FormData();

        // if(flag == 1){
            // formdata.append("death_cer", $('#death_cer')[0].files[0]);
        // }
        // if(flag == 2){
            // formdata.append("noc_file", $('#noc_file')[0].files[0]);
        // }
        // if(flag == 3){
            // formdata.append("nok_file", $('#nok_file')[0].files[0]);
        // }

        // formdata.append("case_no", $('#case_no').val());
        // formdata.append("flag", $(this).attr('id'));
        // formdata.append("dist_code", $('#dist_code').val());

        // console.log(formdata);

        // $.ajax({
            // url: baseurl + "lmmutation/uploadSupportiveDocs/",
            // type: 'POST',
            // enctype: 'multipart/form-data',
            // data: formdata,
            // contentType: false,
            // cache: false,
            // processData:false,
            // dataType: "json",

            // success: function (data) 
            // {
                // console.log(data);
                // if(data.img_upload === true){
                    // alert("File has successfully uploaded..");
                // }
                // if(data.flag_set == '1'){
                    // $('#file_11').html('<a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a>');
                // }
                // if(data.flag_set == '2'){
                    // $('#file_12').html('<a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a>');
                // }
                // if(data.flag_set == '3'){
                    // $('#file_13').html('<a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a>');
                // }

                // if(data.img_upload === false){
                    // alert("File Uploading Failed..");
                // }
                // if(data.error != null)
                // {
                    // $('#alert_message').html('');
                    // var error_message = '';

                    // $.each(data.error, function (index, value) {
                        // $('#alert_message').fadeIn();
                        // error_message += '<li>'+value['message']+'</li>'
                    // });
                    // $('#alert_message')
                        // .html('<div class="bg-gradient-danger p-2 rounded">'+error_message +
                            // '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');
                    // setTimeout(function(){
                        // $('#alert_message').fadeOut();
                    // }, 5000);

                    // return false;
                // }

            // }
        // });
    // });
    // $(".btnUpdateApplicantCO").click(function(e){
        // e.preventDefault();
        // id = $(this).attr('id');
        // pet_name = $('#pet_name_'+id).val();
        // pet_gender = $('#pet_gender_'+id).val();
        // guard_name = $('#guard_name_'+id).val();
        // relation_guardian = $('#relation_guardian_'+id).val();
        // add1 = $('#add1_'+id).val();
        // case_no = $('#case_no').val();

        // data = {case_no:case_no, pet_id:id, pet_name:pet_name, pet_gender:pet_gender, guard_name:guard_name, relation_guardian:relation_guardian, add1:add1}

        // $.ajax({
            // url: baseurl + "lmmutation/firstApplicantEditInfo/",
            // type:'POST',
            // data:data,
            // dataType:'json',
            // success: function (data) {

                // console.log(data);
                // if(data.petitioner_update == 'true')
                // {
                    // alert("Applicant detail has updated successfully");
                    // $('#editAppl_'+id).modal('hide');
                    // var table = '';
                    // $.each(data.detail, function (i, val) { 
                    // i++;

                    // bigha = ((val['applied_b']==null)?'0':val['applied_b']);
                    // katha = ((val['applied_k']==null)?'0':val['applied_k']);
                    // lessa = ((val['applied_lc']==null)?'0':val['applied_lc']);

                    // address2 = ((val['add2']==null)?'':val['add2']);

                    // land = 'B:'+bigha+' / K:'+katha+' / L:'+lessa+' / Kr:0';
                    // table +=                     
                        // '<tr id="pet_"'+val['pet_id']+'>'+
                            // '<td>' + val["pet_id"] + '</td>' +
                            // '<td>' + val["pet_name"] + '</td>' +
                            // '<td>' + val["guard_name"] + '</td>' +
                            // '<td>Add 1: ' + val["add1"] + ' / Add 2: ' +address2+ '</td>' +
                            // '<td>' + land + '</td>' +
                            // '<td><button class="btn btn-sm btn-primary btnFirstApplEditLM" id="'+
                            // val['pet_id']+'">Edit Applicant&nbsp;&nbsp;<i class="fa fa-plus-square"></i></button></td>'+
                        // '</tr>'
                    // });
                    // console.log(table);
                    // $('#field_mut_petitioner').html(table);
                // }
                // if(data.basundhara_ins == 'false')
                // {
                    // alert("Basundhara insertion failed");
                    // return false;
                // }
                // if(data.petitioner_update == 'false')
                // {
                    // alert("Petitioner updation failed");
                    // return false;
                // }
                // if(data.error)
                // {
                    // $.each(data.error, function (index, value) {
                        // $('#alert_'+value['field']).fadeIn();
                        // $('#alert_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        // setTimeout(function(){
                            // $('#alert_'+value['field']).fadeOut();
                        // }, 5000);
                    // });    
                // }
            // }
        // });
    // });
	  ////21-02-22/// Utpal
    $(document).on('click','.btnFirstApplEditLM', function(){
        id = $(this).attr('id');
        $('#editAppl_'+id).modal('show');
    });
    $(document).on('click','.btnApplicantCloseModal', function(){
        id = $(this).attr('id');
        $('#editAppl_'+id).modal('hide');
    });
    
    $('.uploadFreshDocumentLM').click(function(){

        flag = $(this).attr('id');
    
        var formdata = new FormData();

        if(flag == 1){
            formdata.append("death_cer", $('#death_cer')[0].files[0]);
        }
        if(flag == 2){
            formdata.append("noc_file", $('#noc_file')[0].files[0]);
        }
        if(flag == 3){
            formdata.append("nok_file", $('#nok_file')[0].files[0]);
        }

        formdata.append("case_no", $('#case_no').val());
        formdata.append("flag", $(this).attr('id'));
        formdata.append("dist_code", $('#dist_code').val());

        console.log(formdata);

        $.ajax({
            url: baseurl + "lmmutation/uploadSupportiveDocs/",
            type: 'POST',
            enctype: 'multipart/form-data',
            data: formdata,
            contentType: false,
            cache: false,
            processData:false,
            dataType: "json",

            success: function (data) 
            {
                console.log(data);
                if(data.img_upload === true){
                    alert("File has successfully uploaded..");
                }

                if(data.flag_set == '1'){
                    $('#file_1').html('<button class="btn btn-sm btn-info"><a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a></button>'+' '+'<button type="button" class="btn btn-sm btn-danger removeFreshReportDocumentLM" id="1">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
                if(data.flag_set == '2'){
                    $('#file_2').html('<button class="btn btn-sm btn-info"><a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a></button>'+' '+'<button type="button" class="btn btn-sm btn-danger removeFreshReportDocumentLM" id="2">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
                if(data.flag_set == '3'){
                    $('#file_3').html('<button class="btn btn-sm btn-info"><a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a></button>'+' '+'<button type="button" class="btn btn-sm btn-danger removeFreshReportDocumentLM" id="3">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
                if(data.img_upload === false){
                    alert("File Uploading Failed..");
                }
                if(data.error != null)
                {
                    $('#alert_message').html('');
                    var error_message = '';

                    $.each(data.error, function (index, value) {
                        $('#alert_message').fadeIn();
                        error_message += '<li>'+value['message']+'</li>'
                    });
                    $('#alert_message')
                        .html('<div class="bg-gradient-danger p-2 rounded">'+error_message +
                            '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');
                    setTimeout(function(){
                        $('#alert_message').fadeOut();
                    }, 5000);

                    return false;
                }

            }
        });
    });


    $(".btnUpdateApplicantCO").click(function(e){
        e.preventDefault();
        id = $(this).attr('id');
        pet_name = $('#pet_name_'+id).val();
        pet_gender = $('#pet_gender_'+id).val();
        guard_name = $('#guard_name_'+id).val();
        relation_guardian = $('#relation_guardian_'+id).val();
        add1 = $('#add1_'+id).val();
        add2 = $('#add2_'+id).val();
        case_no = $('#case_no').val();

        data = {case_no:case_no, pet_id:id, pet_name:pet_name, pet_gender:pet_gender, guard_name:guard_name, relation_guardian:relation_guardian, add1:add1, add2:add2}

        $.ajax({
            url: baseurl + "lmmutation/firstApplicantEditInfo/",
            type:'POST',
            data:data,
            dataType:'json',
            success: function (data) {

                console.log(data);
                if(data.petitioner_update == 'true')
                {
                    alert("Applicant detail has updated successfully");
                    $('#editAppl_'+id).modal('hide');
                    var table = '';
                    $.each(data.detail, function (i, val) { 
                    i++;

                    id = val['pet_id'];

                    bigha = ((val['applied_b']==null)?'0':val['applied_b']);
                    katha = ((val['applied_k']==null)?'0':val['applied_k']);
                    lessa = ((val['applied_lc']==null)?'0':val['applied_lc']);

                    add2 = val['add2'];
                    address2 = ((add2==null)?'':'Add2: '+val['add2']);

                    land = 'B:'+bigha+' / K:'+katha+' / L:'+lessa+' / Kr:0';
                    table +=                     
                        '<tr id="pet_'+id+'"  '+' class="remove_'+val['pet_id']+'">'+
                            '<td>' + val["pet_name"] + '</td>' +
                            '<td>' + val["guard_name"] + '</td>' +
                            '<td>Add 1: ' + val["add1"] + '<br>' + address2 + '</td>' +
                            '<td>' + land + '</td>' +
                            '<td><button class="btn btn-sm btn-primary btnFirstApplEditLM" id="'+
                            val['pet_id']+'"><i class="fa fa-edit"></i></button>'+ '   '+
                            '<button class="btn btn-sm btn-danger btnApplDeleteLM" title="Click to Delete Applicant '+val['pet_name']+' " id="'+
                            val['pet_id']+'"><i class="fa fa-trash"></i></button>'+
                            '</td>'+
                        '</tr>'
                    });
                    //console.log(table);
                    $('#field_mut_petitioner').html(table);
                    // $('#del_arr').val('');
                    // $('#countRow').val('');
                }
                if(data.basundhara_ins == 'false')
                {
                    alert("Basundhara insertion failed");
                    return false;
                }
                if(data.petitioner_update == 'false')
                {
                    alert("Petitioner updation failed");
                    return false;
                }
                if(data.error)
                {
                    $.each(data.error, function (index, value) {
                        $('#alert_'+value['field']).fadeIn();
                        $('#alert_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        setTimeout(function(){
                            $('#alert_'+value['field']).fadeOut();
                        }, 5000);
                    });    
                }
            }
        });
    });


    $(document).on('click', '.btnOMutUpdateApplicantCO', function(e){
        e.preventDefault();
        id = $(this).attr('id');
        pet_name = $('#pet_name_'+id).val();
        pet_gender = $('#pet_gender_'+id).val();
        guard_name = $('#guard_name_'+id).val();
        relation_guardian = $('#relation_guardian_'+id).val();
        add1 = $('#add1_'+id).val();
        add2 = $('#add2_'+id).val();
        case_no = $('#case_no').val();
        pet_no = $('#petition_no').val();

        data = {case_no:case_no, pet_id:id, pet_name:pet_name, pet_gender:pet_gender, guard_name:guard_name, relation_guardian:relation_guardian, add1:add1, pet_no:pet_no, add2:add2}

        $.ajax({
            url: baseurl + "lmmutation/firstApplicantOMutEditInfo/",
            type:'POST',
            data:data,
            dataType:'json',
            success: function (data) {

                console.log(data);
                if(data.petitioner_update == 'true')
                {
                    alert("Applicant detail has updated successfully");
                    $('#editOMAppl_'+id).modal('hide');
                    var table = '';
                    $.each(data.detail, function (i, val) { 
                    i++;

                    id = val['pet_id'];

                    bigha = ((val['applied_b']==null)?'0':val['applied_b']);
                    katha = ((val['applied_k']==null)?'0':val['applied_k']);
                    lessa = ((val['applied_lc']==null)?'0':val['applied_lc']);

                    add2 = val['add2'];
                    address2 = ((add2==null)?'':'Add2: '+val['add2']);

                    land = 'B:'+bigha+' / K:'+katha+' / L:'+lessa+' / Kr:0';
                    table +=                     
                        '<tr id="pet_'+id+'"  '+' class="remove_'+val['pet_id']+'">'+
                            '<td>' + val["pet_name"] + '</td>' +
                            '<td>' + val["guard_name"] + '</td>' +
                            '<td>Add 1: ' + val["add1"] + '<br>' + address2 + '</td>' +
                            '<td>' + land + '</td>' +
                            '<td><button class="btn btn-sm btn-primary btnOMutationFirstApplEditLM" id="'+
                            val['pet_id']+'"><i class="fa fa-edit"></i></button>'+ '   '+
                            '<button class="btn btn-sm btn-danger btnOMutationApplDeleteLM" title="Click to Delete Applicant '+val['pet_name']+' " id="'+
                            val['pet_id']+'"><i class="fa fa-trash"></i></button>'+
                            '</td>'+
                        '</tr>'
                    });
                    $('#petitioner').html(table);
                }
                if(data.basundhara_ins == 'false')
                {
                    alert("Basundhara insertion failed");
                    return false;
                }
                if(data.petitioner_update == 'false')
                {
                    alert("Petitioner updation failed");
                    return false;
                }
                if(data.error)
                {
                    $.each(data.error, function (index, value) {
                        $('#alert_'+value['field']).fadeIn();
                        $('#alert_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        setTimeout(function(){
                            $('#alert_'+value['field']).fadeOut();
                        }, 5000);
                    });    
                }
            }
        });
    });

    $(document).on('click', '.btnOMutUpdateApplicantCONewMulti', function(e){
        e.preventDefault();
        const formEl = $(this).closest('form');
        const formId = formEl.attr('id');
        let formData = new FormData(document.getElementById(formId));
        // id = $(this).attr('id');
        // pet_name = $('#pet_name_'+id).val();
        // pet_gender = $('#pet_gender_'+id).val();
        // guard_name = $('#guard_name_'+id).val();
        // relation_guardian = $('#relation_guardian_'+id).val();
        // add1 = $('#add1_'+id).val();
        // add2 = $('#add2_'+id).val();
        // case_no = $('#case_no').val();
        // pet_no = $('#petition_no').val();

        // data = {case_no:case_no, pet_id:id, pet_name:pet_name, pet_gender:pet_gender, guard_name:guard_name, relation_guardian:relation_guardian, add1:add1, pet_no:pet_no, add2:add2}

        $.ajax({
            url: baseurl + "lmmutation/firstApplicantOMutEditInfoMultiDagGen",
            type:'POST',
            data:formData,
            processData : false, // Don't process the files
            contentType : false, // Set content type to false as jQuery will tell the server its a query string request
            dataType:'json',
            success: function (data) {

                console.log(data);
                if(data.petitioner_update == 'true')
                {
                    Swal.fire({
                        title: "Applicant detail has updated successfully",
                        icon: 'success'
                    });
                    
                    location.reload(true);
                    // return;
                    // $('#editOMAppl_'+id).modal('hide');
                    // var table = '';
                    // $.each(data.detail, function (i, val) { 
                    // i++;

                    // id = val['pet_id'];

                    // bigha = ((val['applied_b']==null)?'0':val['applied_b']);
                    // katha = ((val['applied_k']==null)?'0':val['applied_k']);
                    // lessa = ((val['applied_lc']==null)?'0':val['applied_lc']);

                    // add2 = val['add2'];
                    // address2 = ((add2==null)?'':'Add2: '+val['add2']);

                    // land = 'B:'+bigha+' / K:'+katha+' / L:'+lessa+' / Kr:0';
                    // table +=                     
                    //     '<tr id="pet_'+id+'"  '+' class="remove_'+val['pet_id']+'">'+
                    //         '<td>' + val["pet_name"] + '</td>' +
                    //         '<td>' + val["guard_name"] + '</td>' +
                    //         '<td>Add 1: ' + val["add1"] + '<br>' + address2 + '</td>' +
                    //         '<td>' + land + '</td>' +
                    //         '<td><button class="btn btn-sm btn-primary btnOMutationFirstApplEditLM" id="'+
                    //         val['pet_id']+'"><i class="fa fa-edit"></i></button>'+ '   '+
                    //         '<button class="btn btn-sm btn-danger btnOMutationApplDeleteLM" title="Click to Delete Applicant '+val['pet_name']+' " id="'+
                    //         val['pet_id']+'"><i class="fa fa-trash"></i></button>'+
                    //         '</td>'+
                    //     '</tr>'
                    // });
                    // $('#petitioner').html(table);
                }
                if(data.basundhara_ins == 'false')
                {
                    alert("Basundhara insertion failed");
                    return false;
                }
                if(data.petitioner_update == 'false')
                {
                    alert("Petitioner updation failed");
                    return false;
                }
                if(data.error)
                {
                    $.each(data.error, function (index, value) {
                        $('#alert_'+value['field']).fadeIn();
                        $('#alert_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        setTimeout(function(){
                            $('#alert_'+value['field']).fadeOut();
                        }, 5000);
                    });    
                }
            }
        });
    });


    $('#first_applicant_edit').submit(function(e){
        e.preventDefault();
        id = $('#pet_id').val();
        $.ajax({
            url: baseurl + "lmmutation/firstApplicantEditInfo/",
            type:'POST',
            data:$("#first_applicant_edit").serialize(),
            dataType:'json',
            success: function (data) {

                console.log(data);
                if(data.petitioner_update == 'true')
                {
                    alert("Applicant detail has updated successfully");
                    $('#editAppl_'+id).modal('hide');
                    var table = '';
                    $.each(data.detail, function (i, val) { 
                    i++;

                    bigha = ((val['applied_b']==null)?'0':val['applied_b']);
                    katha = ((val['applied_k']==null)?'0':val['applied_k']);
                    lessa = ((val['applied_lc']==null)?'0':val['applied_lc']);

                    address2 = ((val['add2']==null)?'':val['add2']);

                    land = 'B:'+bigha+' / K:'+katha+' / L:'+lessa+' / Kr:0';
                    table +=                     
                        '<tr id="pet_"'+val['pet_id']+'>'+
                            '<td>' + val["pet_id"] + '</td>' +
                            '<td>' + val["pet_name"] + '</td>' +
                            '<td>' + val["guard_name"] + '</td>' +
                            '<td>Add 1: ' + val["add1"] + ' / Add 2: ' +address2+ '</td>' +
                            '<td>' + land + '</td>' +
                            '<td><button class="btn btn-sm btn-primary btnFirstApplEditLM" id="'+
                            val['pet_id']+'">Edit Applicant&nbsp;&nbsp;<i class="fa fa-plus-square"></i></button></td>'+
                        '</tr>'
                    });
                    console.log(table);
                    $('#field_mut_petitioner').html(table);
                }
                if(data.basundhara_ins == 'false')
                {
                    alert("Basundhara insertion failed");
                    return false;
                }
                if(data.petitioner_update == 'false')
                {
                    alert("Petitioner updation failed");
                    return false;
                }
                if(data.error)
                {
                    $.each(data.error, function (index, value) {
                        $('#alert_'+value['field']).fadeIn();
                        $('#alert_'+value['field']).html('<span style="color:red">'+value['message']+'</span>');
                        setTimeout(function(){
                            $('#alert_'+value['field']).fadeOut();
                        }, 5000);
                    });    
                }
            }
        });
    });


    $('.uploadDocumentLM').click(function(){

        flag = $(this).attr('id');
    
        var formdata = new FormData();

        if(flag == 1){
            formdata.append("death_cer", $('#death_cer')[0].files[0]);
        }
        if(flag == 2){
            formdata.append("noc_file", $('#noc_file')[0].files[0]);
        }
        if(flag == 3){
            formdata.append("nok_file", $('#nok_file')[0].files[0]);
        }

        formdata.append("case_no", $('#case_no').val());
        formdata.append("flag", $(this).attr('id'));
        formdata.append("dist_code", $('#dist_code').val());

        console.log(formdata);

        $.ajax({
            url: baseurl + "lmmutation/uploadSupportiveDocs/",
            type: 'POST',
            enctype: 'multipart/form-data',
            data: formdata,
            contentType: false,
            cache: false,
            processData:false,
            dataType: "json",

            success: function (data) 
            {
                console.log(data);
                if(data.img_upload === true){
                    alert("File has successfully uploaded..");
                }
                if(data.flag_set == '1'){
                    $('#file_11').html('<button class="btn btn-sm btn-info"><a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a></button>'+' '+'<button type="button" class="btn btn-sm btn-danger removeDocumentLM" id="1">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
                if(data.flag_set == '2'){
                    $('#file_12').html('<button class="btn btn-sm btn-info"><a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a></button>'+' '+'<button type="button" class="btn btn-sm btn-danger removeDocumentLM" id="2">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
                if(data.flag_set == '3'){
                    $('#file_13').html('<button class="btn btn-sm btn-info"><a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a></button>'+' '+'<button type="button" class="btn btn-sm btn-danger removeDocumentLM" id="3">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }

                if(data.img_upload === false){
                    alert("File Uploading Failed..");
                }
                if(data.error != null)
                {
                    $('#alert_message').html('');
                    var error_message = '';

                    $.each(data.error, function (index, value) {
                        $('#alert_message').fadeIn();
                        error_message += '<li>'+value['message']+'</li>'
                    });
                    $('#alert_message')
                        .html('<div class="bg-gradient-danger p-2 rounded">'+error_message +
                            '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');
                    setTimeout(function(){
                        $('#alert_message').fadeOut();
                    }, 5000);

                    return false;
                }

            }
        });
    }); 


    //$('.removeDocumentLM').click(function(){
    $(document).on('click','.removeDocumentLM', function(){

        flag = $(this).attr('id');
        case_no = $('#case_no').val();
        data = {flag:flag, case_no:case_no}

        if(flag==1){certificate = 'Death Certificate';}
        if(flag==2){certificate = 'NOC';}
        if(flag==3){certificate = 'NOK';}

        if(confirm("Are you sure to delete " +certificate+ " ?")){

            $.ajax({
                url: baseurl + "lmmutation/removeSupportiveDocs/",
                type: 'POST',
                data: data,
                dataType: "json",

                success: function (data) 
                {
                    console.log(data);
                    if(data.flag == '1'){
                        $('#file_11').html('');
                        $('#div_death').html('');
                    }
                    if(data.flag == '2'){
                        $('#file_12').html('');
                        $('#div_noc').html('');
                    }
                    if(data.flag == '3'){
                        $('#file_13').html('');
                        $('#div_nok').html('');
                    }
                }
            });
        }  
    });

    $(document).on('click','.removeFreshReportDocumentLM', function(){

        flag = $(this).attr('id');
        case_no = $('#case_no').val();
        data = {flag:flag, case_no:case_no}

        if(flag==1){certificate = 'Death Certificate';}
        if(flag==2){certificate = 'NOC';}
        if(flag==3){certificate = 'NOK';}

        if(confirm("Are you sure to delete " +certificate+ " ?")){

            $.ajax({
                url: baseurl + "lmmutation/removeSupportiveDocs/",
                type: 'POST',
                data: data,
                dataType: "json",

                success: function (data) 
                {
                    console.log(data);
                    if(data.flag == '1'){
                        $('#file_1').html('');
                        $('#div_death').html('');
                    }
                    if(data.flag == '2'){
                        $('#file_2').html('');
                        $('#div_noc').html('');
                    }
                    if(data.flag == '3'){
                        $('#file_3').html('');
                        $('#div_nok').html('');
                    }
                }
            });
        }  
    });


    $(document).on('click', '.btnApplDeleteLM', function(){
        id = $(this).attr('id');
        case_no = $('#case_no').val();        
        data = {id:id, case_no:case_no}

        if(confirm("Are you sure to delete petitioner ?")){

            $.ajax({
                url: baseurl + "lmmutation/deleteFMUTrevertCases/",
                type:'POST',
                data:data,
                dataType:'json',
                success: function (data) {
                    console.log(data);

                    if(data.delete === false){
                        alert("All petitioners cannot be deleted");
                        return;
                    }

                    if(data.details)
                    {
                        var table = '';
                        $.each(data.details, function (i, val) { 
                        i++;

                        id = val['pet_id'];

                        bigha = ((val['applied_b']==null)?'0':val['applied_b']);
                        katha = ((val['applied_k']==null)?'0':val['applied_k']);
                        lessa = ((val['applied_lc']==null)?'0':val['applied_lc']);

                        add2 = val['add2'];
                        address2 = ((add2==null)?'':'Add2: '+val['add2']);

                        land = 'B:'+bigha+' / K:'+katha+' / L:'+lessa+' / Kr:0';
                        table +=                     
                            '<tr id="pet_'+id+'"  '+' class="remove_'+val['pet_id']+'">'+
                                '<td>' + val["pet_name"] + '</td>' +
                                '<td>' + val["guard_name"] + '</td>' +
                                '<td>Add 1: ' + val["add1"] + '<br>' + address2 + '</td>' +
                                '<td>' + land + '</td>' +
                                '<td><button class="btn btn-sm btn-primary btnFirstApplEditLM" id="'+val['pet_id']+'"><i class="fa fa-edit"></i></button>'+ '   '+
                                '<button class="btn btn-sm btn-danger btnApplDeleteLM" title="Click to Delete Applicant '+val['pet_name']+' " id="'+
                                val['pet_id']+'"><i class="fa fa-trash"></i></button>'+
                                '</td>'+
                            '</tr>'
                        });
                        //console.log(table);
                        $('#field_mut_petitioner').html(table);
                        // $('#del_arr').val('');
                        // $('#countRow').val('');
                    }
                }
            });
        }  
    });


    $(document).on('click','.btnOMutationFirstApplEditLM', function(){
        id = $(this).attr('id');
        $('#editOMAppl_'+id).modal('show');
    });
    $(document).on('click','.btnOMutApplicantCloseModal', function(){
        id = $(this).attr('id');
        $('#editOMAppl_'+id).modal('hide');
    });

    $(document).on('click','.btnOMutationApplDeleteLM', function(){
        id = $(this).attr('id');
        case_no = $('#case_no').val();        
        data = {id:id, case_no:case_no}

        if(confirm("Are you sure to delete petitioner ?")){

            $.ajax({
                url: baseurl + "lmmutation/deleteOMutationRevertCases/",
                type:'POST',
                data:data,
                dataType:'json',
                success: function (data) {
                    console.log(data);
                    console.log(data.delete);

                    if(data.delete === false)
                    {
                        alert("All petitioner can not be deleted");
                        return;
                    }

                    if(data.details)
                    {
                        var table = '';
                        $.each(data.details, function (i, val) { 
                        i++;

                        id = val['pet_id'];

                        bigha = ((val['applied_b']==null)?'0':val['applied_b']);
                        katha = ((val['applied_k']==null)?'0':val['applied_k']);
                        lessa = ((val['applied_lc']==null)?'0':val['applied_lc']);

                        add2 = val['add2'];
                        address2 = ((add2==null)?'':'Add2: '+val['add2']);

                        land = 'B:'+bigha+' / K:'+katha+' / L:'+lessa+' / Kr:0';
                        table +=                     
                            '<tr id="pet_'+id+'"  '+' class="remove_'+val['pet_id']+'">'+
                                '<td>' + val["pet_name"] + '</td>' +
                                '<td>' + val["guard_name"] + '</td>' +
                                '<td>Add 1: ' + val["add1"] + '<br>' + address2 + '</td>' +
                                '<td>' + land + '</td>' +
                                '<td><button class="btn btn-sm btn-primary btnOMutationFirstApplEditLM" id="'+
                                id+'"><i class="fa fa-edit"></i></button>'+ '   '+
                                '<button class="btn btn-sm btn-danger btnOMutationApplDeleteLM" title="Click to Delete Applicant '+val['pet_name']+' " id="'+
                                id+'"><i class="fa fa-trash"></i></button>'+
                                '</td>'+
                            '</tr>'
                        });
                        $('#petitioner').html(table);
                    }
                }
            });
        }  
    });


    $('.uploadOMutDocumentLM').click(function(){

        flag = $(this).attr('id');
    
        var formdata = new FormData();

        if(flag == 1){
            formdata.append("death_cer", $('#death_cer')[0].files[0]);
        }
        if(flag == 2){
            formdata.append("noc_file", $('#noc_file')[0].files[0]);
        }
        if(flag == 3){
            formdata.append("nok_file", $('#nok_file')[0].files[0]);
        }

        formdata.append("case_no", $('#case_no').val());
        formdata.append("flag", $(this).attr('id'));
        formdata.append("dist_code", $('#dist_code').val());

        console.log(formdata);

        $.ajax({
            url: baseurl + "lmmutation/uploadSupportiveDocs/",
            type: 'POST',
            enctype: 'multipart/form-data',
            data: formdata,
            contentType: false,
            cache: false,
            processData:false,
            dataType: "json",

            success: function (data) 
            {
                console.log(data);
                if(data.img_upload === true){
                    alert("File has successfully uploaded..");
                }

                if(data.flag_set == '1'){
                    $('#file_1').html('<button class="btn btn-sm btn-info"><a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a></button>'+' '+'<button type="button" class="btn btn-sm btn-danger removeOMutReportDocumentLM" id="1">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
                if(data.flag_set == '2'){
                    $('#file_2').html('<button class="btn btn-sm btn-info"><a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a></button>'+' '+'<button type="button" class="btn btn-sm btn-danger removeOMutReportDocumentLM" id="2">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
                if(data.flag_set == '3'){
                    $('#file_3').html('<button class="btn btn-sm btn-info"><a style="color: red; text-decoration: none;" href="'+baseurl+'lmmutation/downloadDocuments/'+data.doc_id+'" target="_blank">VIEW '+data.filename+'</a></button>'+' '+'<button type="button" class="btn btn-sm btn-danger removeOMutReportDocumentLM" id="3">Remove&nbsp;<i class="fa fa-minus-square"></i></button>');
                }
                if(data.img_upload === false){
                    alert("File Uploading Failed..");
                }
                if(data.error != null)
                {
                    $('#alert_message').html('');
                    var error_message = '';

                    $.each(data.error, function (index, value) {
                        $('#alert_message').fadeIn();
                        error_message += '<li>'+value['message']+'</li>'
                    });
                    $('#alert_message')
                        .html('<div class="bg-gradient-danger p-2 rounded">'+error_message +
                            '<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div></div>');
                    setTimeout(function(){
                        $('#alert_message').fadeOut();
                    }, 5000);

                    return false;
                }

            }
        });
    });

    $(document).on('click','.removeOMutReportDocumentLM', function(){

        flag = $(this).attr('id');
        case_no = $('#case_no').val();
        data = {flag:flag, case_no:case_no}

        if(flag==1){certificate = 'Death Certificate';}
        if(flag==2){certificate = 'NOC';}
        if(flag==3){certificate = 'NOK';}

        if(confirm("Are you sure to delete " +certificate+ " ?")){

            $.ajax({
                url: baseurl + "lmmutation/removeSupportiveDocs/",
                type: 'POST',
                data: data,
                dataType: "json",

                success: function (data) 
                {
                    console.log(data);
                    if(data.flag == '1'){
                        $('#file_1').html('');
                        $('#div_death').html('');
                    }
                    if(data.flag == '2'){
                        $('#file_2').html('');
                        $('#div_noc').html('');
                    }
                    if(data.flag == '3'){
                        $('#file_3').html('');
                        $('#div_nok').html('');
                    }
                }
            });
        }  
    });
});