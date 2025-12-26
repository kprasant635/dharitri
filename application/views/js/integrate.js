window.filter = false;
window.panjeeyanServiceUrl = 'http://10.177.88.81:9090/webservices/webresources/service?jsonp=callme&circle_code=240103000000000';
window.panjeeyaDeedInfoUrl = "http://10.177.88.81:9090/webservices/webresources/deedinfo?jsonp=deedinfo&circle_code=240103000000000&slno=";
window.deedUrl= "http://10.177.15.210:8080/dharitree/index.php/DisplayDeed?slno=";
function callme(data) {
    console.log("here");
    var values = data.messages;
    if (values.length == 0) {
        alert("No Registrations Found for the Specified Range");
        $('#srodata').html("");
    }
    var template="<table class='table table-stripped table-compressed'  id='dt'><thead><th>SL No</th><th>Applicant</th><th>Deed No</th><th>View</th><th>Process</th></thead>";	
    for (var i = 0; i < values.length; i++) {
        template += "<tr id='" + values[i].slno + "' class='case'><td id='" + values[i].deedno + "' class='deedno'>" + values[i].deedno + "</td>" +
                "<td>" + values[i].applicant + "</td><td>" + values[i].slno + "</td><td class=view><a target='_blank' href='"+deedUrl+values[i].slno+"' class='btn btn-info btn-sm'>View</a></td><td class='process'><a href='#' class='btn btn-info btn-sm'>Process</a></td></tr>";
        console.log(template);

    }
    $('#srodata').html(template);
	$('#dt').dataTable();
}

function deedinfo(data) {
    console.log(data.landdetails);
    window.deed = data;
    var deedUrl = "http://10.177.15.210:8080/dharitree/index.php/DisplayDeed/index?slno=" + window.slno;
    var headerP = "<div class=\'panel panel-primary\'><div class=\'panel-heading\'><div class=\'panel-title\'>Applicants</div></div>";
    var headerS = "<div class=\'panel panel-primary\'><div class=\'panel-heading\'><div class=\'panel-title\'>Sellers</div></div>";
    var headerL = "<div class=\'panel panel-primary\'><div class=\'panel-heading\'><div class=\'panel-title\'>landdetails</div></div>";
    var htmlP = "<table class='table'><tr><th>Applicant Name</th><th>Fathers Name</th><th>Address</th></tr>";
    var htmlL = "<table class='table'><tr><th>District</th><th>Circle</th><th>Mouza</th><th>Village</th></tr>";
    var htmlD = "<table class='table'><tr><th>Patta No</th><th>Dag No</th><th>Bigha</th><th>Katha</th><th>Lessa</th></tr>";
    var Purchaser = "";
    var Seller = "";
    var landdetails = "";
    var dagdetails = "";
    $('#myModal .modal-title').html("<p><label class=\'label label-danger\'>Viewing Deed details for Deed # " + window.deedno + " and Sl # " + window.slno + "</label>");
    if (data.party != null) {
        for (var i = 0; i < data.party.length; i++) {
            if (data.party[i].partytype === 'Purchaser')
                Purchaser += "<tr><td>" + data.party[i].nameparty + "</td><td>" + data.party[i].fname + "</td><td>" + data.party[i].address + "</td></tr>"
        }
    }

    Purchaser += "</div></table>";
    if (data.party != null) {
        for (var i = 0; i < data.party.length; i++) {
            if (data.party[i].partytype === 'Seller')
                Seller += "<tr><td>" + data.party[i].nameparty + "</td><td>" + data.party[i].fname + "</td><td>" + data.party[i].address + "</td></tr>"
        }
    }

    Seller += "</div></table>";


    for (var i = 0; i < data.landdetails.length; i++) {
        landdetails += "<tr><td>" + data.landdetails[i].district + "</td><td>" + data.landdetails[i].circle + "</td><td>" + data.landdetails[i].mouza + "</td>" + "<td>" + data.landdetails[i].village + "</td></tr>"
    }
    landdetails += "</hr>";

    for (var i = 0; i < data.landdetails.length; i++) {
        dagdetails += "<tr><td>" + data.landdetails[i].pattano + "</td><td>" + data.landdetails[i].dagno + "</td><td>" + data.landdetails[i].barea + "</td>" + "<td>" + data.landdetails[i].karea + "</td>" + "</td><td>" + data.landdetails[i].larea + "</td></tr>"
    }
    dagdetails += "</div></table>";
    console.log(dagdetails);
    $('#myModal .modal-body').html(headerP + htmlP + Purchaser + headerS + htmlP + Seller + headerL + htmlL + landdetails + htmlD + dagdetails);

    $('#myModal .modal-body').append("<a href=\'" + deedUrl + "'\ target=\'__blank\' class=\'btn btn-primary\'>View Deed</a>")
    $('#myModal').modal();
}



function call(data) {
    alert(data);
}


$(function () {

    $('#filter').click(function (e) {
        window.filter = true;
        e.preventDefault();
        var start = $('#s').val();
        var end = $('#e').val();

        $.ajax({
            url: window.panjeeyanServiceUrl + "&s=" + end + "&e=" + start,
            dataType: 'jsonp',
            type: 'GET'
        })

    })

    $('#sro').on('click', 'tr td.view', function () {
        console.log($(this));
        var slno = $(this).parent().attr('id');
        var deedno = $(this).parent().find('.deedno').attr('id');
        $.ajax({
            url: '/kamrupmetro/index.php/login/getCurrentDistrict',
            success: function (data) {
                var obj = JSON.parse(data);
                console.log(obj.d);
                console.log(slno + " " + deedno);
                window.slno = slno;
                window.deedno = deedno;
                $.ajax({
                    url: window.panjeeyaDeedInfoUrl + slno,
                    dataType: 'jsonp',
                    type: 'GET'
                })
            }
        })
    });

    $('#sro').on('click', 'tr td.process', function () {
        var deed = window.deed;
        var deedString = "";
        var purchaser = "";
        var seller = "";
        var landdetails = "";
        for (var i = 0; i < deed.deed.length; i++) {
            console.log(deed.deed[i]);
            deedString += "sl=" + deed.deed[i].slno + "&no=" + deed.deed[i].deedno + "&app=" + deed.deed[i].applicant + "&amount=" + deed.deed[i].amount + "&office=" + deed.deed[i].office;
        }
        console.log(deedString);
        console.log(deed);
        $.ajax({
            url: 'http://10.177.15.210:8080/dharitree/index.php/HoldFromAjax/recvDeed',
            data: deedString,
            success: function (data) {
                console.log(data);
            }
        })

        for (var i = 0; i < deed.party.length; i++) {
            if (deed.party[i].partytype === 'Purchaser') {
                purchaser = "address=" + deed.party[i].address + "&fname=" + deed.party[i].deedno + "&nameparty=" + deed.party[i].nameparty + "&srocode=" + deed.party[i].srocode + "&state=" + deed.party[i].state;
                $.ajax({
                    url: 'http://10.177.15.210:8080/dharitree/index.php/HoldFromAjax/recvPurchase',
                    data: purchaser,
                    type: 'POST',
                    success: function (data) {
                        console.log(data);
                    }
                });
            }
        }

        for (var i = 0; i < deed.party.length; i++) {
            if (deed.party[i].partytype === 'Seller') {
                seller = "address=" + deed.party[i].address + "&fname=" + deed.party[i].fname + "&nameparty=" + deed.party[i].nameparty + "&srocode=" + deed.party[i].sroCode + "&state=" + deed.party[i].state;
                $.ajax({
                    url: 'http://10.177.15.210:8080/dharitree/index.php/HoldFromAjax/recvSeller',
                    data: seller,
                    type: 'POST',
                    success: function (data) {
                        console.log(data);
                    }
                });
            }
        }

        for (var i = 0; i < deed.landdetails.length; i++) {

            landdetails = "barea=" + deed.landdetails[i].address + "&chatakarea=" + deed.landdetails[i].chatakarea + "&dagno=" + deed.landdetails[i].dagno + "&larea=" + deed.landdetails[i].larea + "&pattano=" + deed.landdetails[i].pattano + "&villcode=" + deed.landdetails[i].villcode;
            $.ajax({
                url: 'http://10.177.15.210:8080/dharitree/index.php/HoldFromAjax/recvLand',
                data: landdetails,
                type: 'POST',
                success: function (data) {
                    console.log(data);
                }
            });


        }
    });

    var requestUrl = window.panjeeyanServiceUrl;
    var baseUrl = "/kamrupmetro/index.php/home/";
    console.log(window.location.pathname);
    console.log(baseUrl);
    console.log(window.location.pathname === baseUrl + "home/index");

    $.ajax({
        url: requestUrl,
        dataType: 'jsonp',
        type: 'GET'

    });

//    $.ajax({
//        url: 'http://10.177.15.231/kamrupmetro/index.php/chithareport/generateChithaRegistration?distcode=24&subdivcode=01&circlecode=03&lotno=01&villcode=20001&dagno=15&mousacode=01&pattatype=0201',
//        type: 'GET',
//        success:function(data){
//            console.log(data);
//            var d = JSON.parse(data);
//            $('body').append(d.d);
//        }
//        
//    });

 
})