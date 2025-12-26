
$('#d').change(function () {
    var baseurl = $("#base").val();
    var id = $(this).val();
    $.ajax({
        url: baseurl + "index.php/Chithacontrol/subdivisiondetails",
        method: "POST",
        data: {id: id},
        async: true,
        dataType: 'json',
        beforeSend: function () {
            $('#sd').prop('selectedIndex', 0);
            
        },
        success: function (data) {
            $.unblockUI();
            var html = '';
            var i;
            html += '<option value="">Select Subdivision</option>';
            for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].subdiv_code + '>' + data[i].loc_name + '</option>';
            }
            $('#sd').html(html);
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            $('#sd').prop('selectedIndex', 0);
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
    return false;
});
$('#sd').change(function () {
    var baseurl = $("#base").val();
    var dis = $('#d').val();
    var subdiv = $(this).val();
    $.ajax({
        url: baseurl + "index.php/Chithacontrol/circledetails",
        method: "POST",
        data: {dis: dis,subdiv:subdiv},
        async: true,
        dataType: 'json',
        beforeSend: function () {
            $('#c').prop('selectedIndex', 0);
            
        },
        success: function (data) {
            $.unblockUI();
            var html = '';
            var i;
            html += '<option value="">Select Circle</option>';
            for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].cir_code + '>' + data[i].loc_name + '</option>';
            }
            $('#c').html(html);
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            $('#c').prop('selectedIndex', 0);
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
    return false;
});
$('#c').change(function () {
    var baseurl = $("#base").val();
    var dis = $('#d').val();
    var subdiv = $('#sd').val();
    var cir = $(this).val();
    $.ajax({
        url: baseurl + "index.php/Chithacontrol/mouzadetails",
        method: "POST",
        data: {dis: dis,subdiv:subdiv,cir:cir},
        async: true,
        dataType: 'json',
        beforeSend: function () {
            $('#m').prop('selectedIndex', 0);
            
        },
        success: function (data) {
            $.unblockUI();
            var html = '';
            var i;
            html += '<option value="">Select Mouza</option>';
            for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].mouza_pargona_code + '>' + data[i].loc_name + '</option>';
            }
            $('#m').html(html);
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            $('#m').prop('selectedIndex', 0);
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
    return false;
});
$('#m').change(function () {
    var baseurl = $("#base").val();
    var dis = $('#d').val();
    var subdiv = $('#sd').val();
    var cir = $('#c').val();
    var mza = $(this).val();
    $.ajax({
        url: baseurl + "index.php/Chithacontrol/lotdetails",
        method: "POST",
        data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza},
        async: true,
        dataType: 'json',
        beforeSend: function () {
            $('#l').prop('selectedIndex', 0);
            
        },
        success: function (data) {
            $.unblockUI();
            var html = '';
            var i;
            html += '<option value="">Select Lot</option>';
            for (i = 0; i < data.length; i++) {
                html += '<option value=' + data[i].lot_no + '>' + data[i].loc_name + '</option>';
            }
            $('#l').html(html);
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            $('#l').prop('selectedIndex', 0);
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
    return false;
});
$('#l').change(function () {
    var baseurl = $("#base").val();
    var dis = $('#d').val();
    var subdiv = $('#sd').val();
    var cir = $('#c').val();
    var mza = $('#m').val();
    var lot = $(this).val();
    $.ajax({
        url: baseurl + "index.php/Chithacontrol/villagedetails",
        method: "POST",
        data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza,lot:lot},
        async: true,
        dataType: 'json',
        beforeSend: function () {
            $('#v').prop('selectedIndex', 0);
            
        },
        success: function (data) {
            console.log(data['location']);
            $.unblockUI();
            var html = '';
            var i;
            html += '<option value="">Select Village</option>';
            for (i = 0; i < data['test'].length; i++) {
                html += '<option value=' + data['test'][i].vill_townprt_code + '>' + data['test'][i].loc_name + '</option>';
            }
            $('#v').html(html);
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            $('#v').prop('selectedIndex', 0);
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
    return false;
});


/////////////
$('#v').change(function () {
    //console.log("Asds")
    var baseurl = $("#base").val();
    var dis = $('#d').val();
    var subdiv = $('#sd').val();
    var cir = $('#c').val();
    var mza = $('#m').val();
    var lot = $('#l').val();
    var vill=$('#v').val();
    var pattatype= $(this).val();

   
   // $('#dagno').html('');
   
    $.ajax({
        url: baseurl + "index.php/SuomotoReclassification/pattanoDetails",
        method: "POST",
        data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza,lot:lot,vill:vill},
        async: true,
        dataType: 'json',
        beforeSend: function () {
            $('#pattano').prop('selectedIndex', 0);
            
        },
        success: function (data) {
            // console.log(data);
            
            // console.log(data['test']);
            $.unblockUI();
            var html = '';
            var i;
            html += '<option value="">Please select</option>';
            for (i = 0; i < data['test'].length; i++) {
                var dagNo = data['test'][i].dag_no;
                var dag_no_int = data['test'][i].dag_no_int;
                html += '<option value=' + dag_no_int + '>' + dagNo + '</option>';
            }
            $('#dagno').html(html);
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            $('#dagno').prop('selectedIndex', 0);
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
    return false;
});

$('#dagno').change(function () {
    //console.log("Asds")
    var baseurl = $("#base").val();
    var dis = $('#d').val();
    var subdiv = $('#sd').val();
    var cir = $('#c').val();
    var mza = $('#m').val();
    var lot = $('#l').val();
    var vill=$('#v').val();
    var dag_no= $(this).val();

   
   // $('#dagno').html('');
   
    $.ajax({
        url: baseurl + "index.php/SuomotoReclassification/areaDetails",
        method: "POST",
        data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza,lot:lot,vill:vill,dag:dag_no},
        async: true,
        dataType: 'json',
        beforeSend: function () {
            $('#area').prop('selectedIndex', 0);
            
        },
        success: function (data) {
             // console.log(data);
            
            // console.log(data['test']);
            $.unblockUI();
             // var area = JSON.parse(data);
            // console.log(area);

                $("#bigha").val(data.bigha);
                $("#katha").val(data.katha);
                $("#lessa").val(data.lessa);
                $("#ganda").val(data.ganda);
                $("#kranti").val(data.kranti);
                $("#land_type").val(data.land_type);
                $("#land_code").val(data.land_code);

                var html = '';
                var i;
                html += '<option value="">Please select</option>';
                for (i = 0; i < data.land_type_present.length; i++) {
                    var land_type_present = data.land_type_present[i].land_type;
                    var land_type_code = data.land_type_present[i].class_code;
                    html += '<option value=' + land_type_code + '>' + land_type_present + '</option>';
                }
                $('#land_type_present').html(html);

                $('#ispart').prop('checked', false);
                $('#nopart').prop('checked', false);
                $('#partarea').hide();
                $('#selectpattadars').hide();
                $('#showpattadars').hide();
                $('#part_bigha').val('');
                $('#part_katha').val('');
                $('#part_lessa').val('');
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
           // $('#dagno').prop('selectedIndex', 0);
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });

    $.ajax({
        url: baseurl + "index.php/SuomotoReclassification/pattadarDetails",
        method: "POST",
        data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza,lot:lot,vill:vill,dag:dag_no},
        async: true,
        dataType: 'json',
        beforeSend: function () {
            $('#area').prop('selectedIndex', 0);
            
        },
        success: function (data) {
            //console.log('hi');
              console.log(data);
             // $("#pattadars").val(data.pdar_name);

               var table = '';
               var html_list = '';
               $('#pattadarcount').val(data.length);
                for (var i = 0; i <= data.length - 1; i++) {

                    //var pdarname='patta'+i;
                   // var pdarfname='pattaf'+i;
                    // console.log(data[i].pdar_name);
                     table +=                     
                            '<tr>'+
                                '<td><input type="hidden" name="pdarname[]" value="'+data[i].pdar_id+'__'+data[i].pdar_name+'__'+data[i].pdar_father+'">' + data[i].pdar_name + '</td>' +
                                '<td><input type="hidden" name="pdarfname[]" value="'+data[i].pdar_father+'">' + data[i].pdar_father + '</td>' +
                            '</tr>';


                    html_list +=
                    '<label class="list-group-item">' +
                    '<input class="form-check-input me-1 form_input ps-3 list-group-flush uncheckpdar" type="checkbox" value="' +
                    data[i].pdar_id +'__'+data[i].pdar_name+'__'+data[i].pdar_father+
                    '" id="chk_deleted_pattadar"' +
                    data[i].pdar_id +
                    ' name="chk_deleted_pattadar[]"><label for="chk_deleted_pattadar"' +
                    data[i].pdar_id +
                    ">" +
                    data[i].pdar_name +
                    " (" +
                    data[i].pdar_father +
                    ") </label>" +
                    "</label>";
                }

                    //console.log(html_list);
                $('#pattadardetails').html(table);
                $("#deleted_pattadar").html(html_list);
            
        
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
           // $('#dagno').prop('selectedIndex', 0);
           $('#pattadardetails').html('');
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });

    return false;
});



$('#pattatype').change(function () {
    var baseurl = $("#base").val();
    var dis = $('#d').val();
    var subdiv = $('#sd').val();
    var cir = $('#c').val();
    var mza = $('#m').val();
    var lot = $('#l').val();
    var vill=$('#v').val();
    var pattatype= $(this).val();
   // $('#dagno').html('');
    localStorage.setItem("pattatype",pattatype);    
    $.ajax({
        url: baseurl + "index.php/Chithacontrol/pattanoDetails",
        method: "POST",
        data: {dis: dis,subdiv:subdiv,cir:cir,mza:mza,lot:lot,vill:vill,pattatype:pattatype},
        async: true,
        dataType: 'json',
        beforeSend: function () {
            $('#pattano').prop('selectedIndex', 0);
            
        },
        success: function (data) {
            console.log(data['location']);
            console.log(data['test']);
            $.unblockUI();
            var html = '';
            var html1 = '';
            var i;
            html += '<option value="">Please select</option>';
            for (i = 0; i < data['test'][0].length; i++) {
                var pattaNo = data['test'][0][i].patta_no;
                html += '<option value=' + pattaNo + '>' + pattaNo + '</option>';
            }
            $('#pattano').html(html);

            html1 += '<option value="">Please select</option>';
            for (i = 0; i < data['test'][1].length; i++) {
                var dagNo = data['test'][1][i].dag_no;
                html1 += '<option value=' + dagNo + '>' + dagNo + '</option>';
            }
            $('#dagno').html(html1);
        },
        error: function (jqXHR, exception) {
            $.unblockUI();
            $('#pattano').prop('selectedIndex', 0);
            alert('Could not Complete your Request ..!, Please Try Again later..!');
        }
    });
    return false;
});
///////////

$('#pattano').change(function () {
    var pattano= $('#pattano').val();
    localStorage.setItem("pattano",pattano);    
});

$('#searchcriteria').change(function () {
    var searchcriteria= $('#searchcriteria').val();
    localStorage.setItem("searchcriteria",searchcriteria);    
});


$('#searchcriteria').change(function () {
    var searchcriteria= $(this).val();
    //alert(searchcriteria);
    if(searchcriteria=='P')
    {
        $(".pp").show();
        $(".dd").hide();
    }
    if(searchcriteria=='D')
    {
        $(".dd").show();
        $(".pp").hide();
    }
});


function checkloc(){
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/locationSubmit",
        data: $('form').serialize(),
        type: "POST",
        success: function (data) {
            if (data.st == 1) {
                swal("", data.msg, "success")
                    .then((value) => {
                    window.location = baseurl + "index.php/Chithacontrol/dagbasic";
            });
            } else {
                swal("", data.msg, "info");

            }
        }
    });
}

function dagentry(){
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/dagentry",
        data: $('form').serialize(),
        type: 
        "POST",
        success: function (data) {
            if (data.st == 1) {
                swal("", data.msg, "success")
                    .then((value) => {
                    window.location = baseurl + "index.php/Chithacontrol/pattadardet";
            });
            } 
            else {
                swal("", data.msg, "info");

            }
        }
    });
}


function dagamtcal() {
    var dagrev = parseFloat($("#dag_land_revenue").val());
    var ltax = parseFloat(1/4 * dagrev);
    $("#dag_local_tax").val(ltax);
}

function gpattadar() {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/pattadarothdag",
        data: $('form').serialize(),
        type: "POST",
        success: function (data) {
            //if (data.st == 1) {
            //alert(data.msg);
            $("#r1").hide('blind');
            $("#r2").hide('blind');
            $("#r2").show('blind');
            $("#r2").html(data.msg);
            //} else {

            //}
        }
    });
}

function patins(){
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/inserpdarfexit",
        data: $('form').serialize(),
        type: "POST",
        success: function (data) {
            if (data.st == 1) {
                $("#r4").hide('blind');
                $("#r3").show('blind');
                $("#r3").html(data.msg);
            } else {
                //alert(data.msg);
                swal("", data.msg, "info");
            }
        }
    });
}



function pdarentry(is_govt) {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/pdarentry",
        data: $('form').serialize(),
        type: 'POST',
        success: function (data) {
            if (data.st == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.msg,
                }).then((result) => {
                    if (result.isConfirmed)
                {

                    Swal.fire({
                        //title: 'Are you sure?',
                        text: "Do you want to continue entering data for more Pattadar ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                    window.location = baseurl + "index.php/Chithacontrol/pattadardet";
                }
                else
                    {
                        if(is_govt){
                            window.location = baseurl + "index.php/Remark/remarkHome";
                        }else{
                            window.location = baseurl + "index.php/Chithacontrol/orderdet";
                        }
                    }
                });
                }
            });

            } else if (data.st == 0) {
                Swal.fire("", data.msg, "info");

            }
        }
    });
};

function getpdarentry() {

    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Chithacontrol/pdarexentry";
}

function pdarexentry(){
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/pdarentrymod",
        data: $('form').serialize(),
        type: "POST",
        success: function (data) {
            if (data.st == 1) {
                swal("", data.msg, "success")
                    .then((value) => {
                    window.location = baseurl + "index.php/Chithacontrol/pattadardetmod";
            });
            } else {
                swal("", data.msg, "info");

            }
        }
    });
}

function gorder(){
    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Chithacontrol/orderdet";
}

function getocuupant(){
    var baseurl = $("#base").val();
    var occupnm = $("#occp_nm").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/checkoccup",
        //data: {p1: dcode, p2: scode, p3: ccode, p4: mcode, p5: lcode, p6: vcode, p7: dagcode, p8: pcode, p9: ptype},
        data: {p1: occupnm},
        type: "POST",
        success: function (data) {

            if (data.length != 0) {
                $("#guardian").val(data[0]);
                $("#relation").val(data[1]);
                $("#bigha").val(data[2]);
                $("#katha").val(data[3]);
                $("#lessa").val(data[4]);
                $("#pdarrel").val(data[5]);
                $("#occupantnm").val(data[6]);
            } /*else {
			    $("#guardian").val("");
				$("#relation").val("");
				$("#bigha").val("");
				$("#katha").val("");
				$("#lessa").val("");
                $("#pdarrel").val("");
			}*/
        }
    });

}


$("form[id='pmod'] #orddet").click(function (e) {
    e.preventDefault()
    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Chithacontrol/orderdet";
});

function orderent(){
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/orderdetentry",
        data: $('form').serialize(),
        type: "POST",
        success: function (data) {
            if (data.st == 1) {
                swal("", data.msg, "success")
                    .then((value) => {
                    window.location = baseurl + "index.php/Chithacontrol/occupant";
            });
            } else {
                swal("", data.msg, "info");

            }
        }
    });
}


function occupent() {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/occupdetentry",
        data: $('form').serialize(),
        type: 'POST',
        success: function (data) {
            if (data.st == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.msg,
                }).then((result) => {
                    if (result.isConfirmed)
                {

                    Swal.fire({
                        //title: 'Are you sure?',
                        text: "Do you want to enter another occupant ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                    window.location = baseurl + "index.php/Chithacontrol/occupant";
                }
                else
                    {
                        window.location = baseurl + "index.php/Chithacontrol/inplace";
                    }
                });
                }
            });

            } else if (data.st == 0) {
                Swal.fire("", data.msg, "info");

            }
        }
    });
};

function inplacent() {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/inplacentry",
        data: $('form').serialize(),
        type: 'POST',
        success: function (data) {
            if (data.st == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.msg,
                }).then((result) => {
                    if (result.isConfirmed)
                {

                    Swal.fire({
                        //title: 'Are you sure?',
                        text: "Do you want to enter another order ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                    window.location = baseurl + "index.php/Chithacontrol/orderdet";
                }
                else
                    {
                        window.location = baseurl + "index.php/Chithacontrol/tenant";
                    }
                });
                }
            });

            } else if (data.st == 0) {
                Swal.fire("", data.msg, "info");

            }
        }
    });
};

function pdarexupdate(){
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/pdarexupdate",
        data: $('form').serialize(),
        type: "POST",
        success: function (data) {
            if (data.st == 1) {
                swal("", data.msg, "success")
                    .then((value) => {
                    window.location = baseurl + "index.php/Chithacontrol/pattadardetmod";
            });
            } else {
                swal("", data.msg, "info");

            }
        }
    });

}

function newdagchk(){
    var baseurl = $("#base").val();
    var dcode = $("#dcode").val();
    var scode = $("#scode").val();
    var ccode = $("#ccode").val();
    var mcode = $("#mcode").val();
    var lcode = $("#lcode").val();
    var vcode = $("#vcode").val();
    var dagcode = $("#dag_no").val();

    //var ptype = $("#patta_type_code").val();
    // var pcode = $("#patta_no").val();

    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/checknewdag",
        //data: {p1: dcode, p2: scode, p3: ccode, p4: mcode, p5: lcode, p6: vcode, p7: pcode, p8: ptype, p9: dagcode},
        data: {p1: dcode, p2: scode, p3: ccode, p4: mcode, p5: lcode, p6: vcode, p7: dagcode},
        type: "GET",
        success: function (data) {

            if (data.length != 0) {
                $("#dag_area_bigha").val(data[0]);
                $("#dag_area_katha").val(data[1]);
                $("#dag_area_lessa").val(data[2]);
                $("#dag_area_ganda").val(data[3]);
                $("#dag_land_revenue").val(data[4]);
                $("#dag_local_tax").val(data[5]);
                $("#land_class_code").val(data[6]);
                $("#old_dag_no").val(data[7]);
                $("#patta_no").val(data[8]);
                $("#patta_type_code").val(data[9]);
                $("#grant_no").val(data[10]);
                //$("#newpatta").val(data[9]);
                //$("#newpatta").val('N');



                var b = data[0];
                var k = data[1];
                var l = data[2];
                var g = data[3];
                if(b=='') b=0;
                if(k=='') k=0;
                if(l=='') l=0;
                if(g=='') g=0;

                var area_lessa = parseFloat(b)*100 + parseFloat(k)*20 + parseFloat(l);
                var area_ganda = parseFloat(b)*6400 + parseFloat(k)*320 + parseFloat(l)*20+parseFloat(g);

                var area_are   = area_lessa*(100/747.45);
                var area_are_b = area_ganda*(13.37804/6400);

                var total_area_are   = parseFloat(area_are).toFixed(5);
                var total_area_are_b = parseFloat(area_are_b).toFixed(5);

                $("#dag_area_are").val(total_area_are);
                $("#dag_area_are_b").val(total_area_are_b);
            }
            else
            {
                //$("#newpatta").val('Y');
                //alert("Data for the Dag No. does not exist in Chitha");
            }
        }
    });

}



function tenantentry() {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/tenantentry",
        data: $('form').serialize(),
        type: 'POST',
        success: function (data) {
            if (data.st == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.msg,
                }).then((result) => {
                    if (result.isConfirmed)
                {

                    Swal.fire({
                        //title: 'Are you sure?',
                        text: "Do you want to continue entering data for more Tenant ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                    window.location = baseurl + "index.php/Chithacontrol/tenant";
                }
                else
                    {
                        window.location = baseurl + "index.php/Chithacontrol/subtenant";
                    }
                });
                }
            });

            } else if (data.st == 0) {
                Swal.fire("", data.msg, "info");

            }
        }
    });
};


function subtenantentry() {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/subtenantentry",
        data: $('form').serialize(),
        type: 'POST',
        success: function (data) {
            if (data.st == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.msg,
                }).then((result) => {
                    if (result.isConfirmed)
                {

                    Swal.fire({
                        //title: 'Are you sure?',
                        text: "Do you want to continue entering data for more Subtenant ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                    window.location = baseurl + "index.php/Chithacontrol/subtenant";
                }
                else
                    {
                        window.location = baseurl + "index.php/Chithacontrol/crop";
                    }
                });
                }
            });

            } else if (data.st == 0) {
                Swal.fire("", data.msg, "info");

            }
        }
    });
};


function cropentry() {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/cropentry",
        data: $('form').serialize(),
        type: 'POST',
        success: function (data)
        {
            if (data.st == 1)
            {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.msg,
                }).then((result) =>
                {
                    if (result.isConfirmed)
                {
                    Swal.fire({
                        //title: 'Are you sure?',
                        text: "Do you want to continue entering data for more Crop ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                    window.location = baseurl + "index.php/Chithacontrol/crop";
                }
                else
                    {
                        window.location = baseurl + "index.php/Chithacontrol/noncrop";
                    }
                });
                }
            });

            }

            else if (data.st == 0)
            {
                Swal.fire("", data.msg, "info");

            }

        }
    });
};


function noncropentry() {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/noncropentry",
        data: $('form').serialize(),
        type: 'POST',
        success: function (data) {
            if (data.st == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.msg,
                }).then((result) => {
                    if (result.isConfirmed)
                {

                    Swal.fire({
                        //title: 'Are you sure?',
                        text: "Do you want to continue entering data for more Noncrop ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                    window.location = baseurl + "index.php/Chithacontrol/noncrop";
                }
                else
                    {
                        window.location = baseurl + "index.php/Chithacontrol/fruit";
                    }
                });
                }
            });

            } else if (data.st == 0) {
                Swal.fire("", data.msg, "info");

            }
        }
    });
};



function fruitentry() {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/fruitentry",
        data: $('form').serialize(),
        type: 'POST',
        success: function (data) {
            if (data.st == 1) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: data.msg,
                }).then((result) => {
                    if (result.isConfirmed)
                {

                    Swal.fire({
                        //title: 'Are you sure?',
                        text: "Do you want to continue entering data for more Fruit ?",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes',
                        cancelButtonText: 'No'
                    }).then((result) => {
                        if (result.isConfirmed) {
                    window.location = baseurl + "index.php/Chithacontrol/fruit";
                }
                else
                    {
                        window.location = baseurl + "index.php/remark/remarkhome";
                    }
                });
                }
            });

            } else if (data.st == 0) {
                Swal.fire("", data.msg, "info");

            }
        }
    });
};

$("#select_patta_type").change(function (e) {
    var baseurl = $("#base").val();
    var patta_type_code = $(this).val();

    $.ajax({
        url: baseurl + "index.php/ChithaReport/getDags/" + patta_type_code,
        success: function (d) {
            var object = JSON.parse(d);
            var template = "<option disabled selected>Select</option>";
            for (var i = 0; i < object.length; i++) {
                template += "<option value='" + object[i].dag_no_int + "'>" + object[i].dag + "</option>";
            }
            $("select[name='dag_no_lower']").html(template);
            //$("select[name='dag_no_upper']").html(template);
        }
    });
});
$("#select_patta_type2").change(function (e) {
    var baseurl = $("#base").val();
    var patta_type_code = $(this).val();

    $.ajax({
        url: baseurl + "index.php/SplittedReportController/getDags/" + patta_type_code,
        success: function (d) {
            var object = JSON.parse(d);
            var template = "<option disabled selected>Select</option>";
            for (var i = 0; i < object.length; i++) {
                template += "<option value='" + object[i].dag_no_int + "'>" + object[i].dag + "</option>";
            }
            $("select[name='dag_no_lower']").html(template);
            //$("select[name='dag_no_upper']").html(template);
        }
    });
});

$("#selectlw").change(function (e) {
    var baseurl = $("#base").val();
    patta_type_code = $('#select_patta_type').val();
    selectlw = $(this).val();
    //  alert(patta_type_code);
    //alert(selectlw);
    $.ajax({
        url: baseurl + "index.php/ChithaReport/getDagslower/" + selectlw + "/" + patta_type_code,
        success: function (d) {
            var object = JSON.parse(d);
            var template = "";
            for (var i = 0; i < object.length; i++) {
                template += "<option value='" + object[i].dag_no_int + "'>" + object[i].dag + "</option>";
            }
            //$("select[name='dag_no_lower']").html(template);
            $("select[name='dag_no_upper']").html(template);
        }
    });
});
$("#selectlw2").change(function (e) {
    var baseurl = $("#base").val();
    patta_type_code = $('#select_patta_type').val();
    selectlw = $(this).val();
    //  alert(patta_type_code);
    //alert(selectlw);
    $.ajax({
        url: baseurl + "index.php/SplittedReportController/getDagslower/" + selectlw + "/" + patta_type_code,
        success: function (d) {
            var object = JSON.parse(d);
            var template = "";
            for (var i = 0; i < object.length; i++) {
                template += "<option value='" + object[i].dag_no_int + "'>" + object[i].dag + "</option>";
            }
            //$("select[name='dag_no_lower']").html(template);
            $("select[name='dag_no_upper']").html(template);
        }
    });
});
function ordexit(){
    var baseurl = $("#base").val();
    Swal.fire({
        //title: 'Are you sure?',
        text: "Do you want to continue entering dag for the same village ?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes',
        cancelButtonText: 'No'
    }).then((result) => {
        if (result.isConfirmed) {
        window.location = baseurl + "index.php/Chithacontrol/dagbasic";
    }
else
    {
        window.location = baseurl + "index.php/Chithacontrol/index";
    }
});
}

function tntentry(){
    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Chithacontrol/tenant";
}
function subtentry(){
    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Chithacontrol/subtenant";
}
function crpentry(){
    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Chithacontrol/crop";
}
function ncrpentry(){
    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Chithacontrol/noncrop";
}
function frtentry(){
    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Chithacontrol/fruit";
}
function rmkentry(){
    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Remark/remarkhome";
}

function edittenant(){
    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Chithacontrol/tenantedit";
}



function tenantmodfy() {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/tenantmodentry",
        data: $('form').serialize(),
        type: "POST",
        success: function (data) {
            if (data.st == 1) {
                Swal.fire("", data.msg, "success")


            } else {
                Swal.fire("", data.msg, "info");

            }
        }
    });

}


// newly by Masud 11/05/2022

function subTenantList(){
    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Chithacontrol/editSubTenantList";
}

function subTenantModify() {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/updateSubTenantDetails",
        data: $('form').serialize(),
        type: "POST",
        success: function (data) {
            if (data.st == 1) {
                Swal.fire("", data.msg, "success")


            } else {
                Swal.fire("", data.msg, "info");

            }
        }
    });

}


function cropList() {
    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Chithacontrol/editCropList";
}

function updateCropDetails() {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/updateCropDetailsData",
        data: $('form').serialize(),
        type: "POST",
        success: function (data) {
            if (data.st == 1) {
                Swal.fire("", data.msg, "success")


            } else {
                Swal.fire("", data.msg, "info");

            }
        }
    });
}


function nonCropList() {
    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Chithacontrol/editNonCropList";
}

function updateNonCropDetails() {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/updateNonCropDetailsData",
        data: $('form').serialize(),
        type: "POST",
        success: function (data) {
            if (data.st == 1) {
                Swal.fire("", data.msg, "success")

            } else {
                Swal.fire("", data.msg, "info");

            }
        }
    });
}


function fruitList() {
    var baseurl = $("#base").val();
    window.location = baseurl + "index.php/Chithacontrol/editFruitList";
}

function fruitDetailsUpdate() {
    var baseurl = $("#base").val();
    $.ajax({
        dataType: "json",
        url: baseurl + "index.php/Chithacontrol/updateFruitDetailsData",
        data: $('form').serialize(),
        type: "POST",
        success: function (data) {
            if (data.st == 1) {
                Swal.fire("", data.msg, "success")

            } else {
                Swal.fire("", data.msg, "info");

            }
        }
    });
}




// 22/05/2022 new code by Masud Reza for Jamabandi


function setLocationForJamabandi() {

}


