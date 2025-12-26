     $(function () {
    $('.panel').on('click', '.chainReport', function(e) 
        {
            console.log('MB04:----------CHAIN REPORT PASSED----------')
            e.preventDefault();
            // console.log($(this).attr("case_no"))
            case_no = $(this).attr("case_no");
            dist_code = $(this).attr("dist_code");
            subdiv_code = $(this).attr("subdiv_code");
            circle_code = $(this).attr("cir_code");
            mouza_code = $(this).attr("mouza_pargona_code");
            lot_no = $(this).attr("lot_no");
            vill_code = $(this).attr("vill_townprt_code");


            $('#myModal .modal-content').empty().html(
                '<div class="text-center text-primary"><div class="spinner-grow" role="status"> <span class = "sr-only" > Loading... </span> </div></div><br><p class="text-primary text-center">....Fetching Data From Property Chain. Please Wait....</p>');
            $.ajax({
                url: baseurl + "PropChainReport/getCaseData",
                data: {
                    case_no: $(this).attr("case_no"),
                    vill_code: $(this).attr("vill_townprt_code"),
                },
                type: 'post',
                success: function(data1) {
                    console.log(data1)
                    var obj = JSON.parse(data1)
                    var dag_no = obj.dag_no;
                    var patta_code = obj.patta_no;
                    $.ajax({
                        url: baseurl + "PropChainReport/getPropChainData",
                        type: 'post',
                        data: {
                            case_no: case_no,
                            dist_code: dist_code,
                            subdiv_code: subdiv_code,
                            circle_code: circle_code,
                            mouza_code: mouza_code,
                            lot_no: lot_no,
                            vill_code: vill_code,
                            patta_code: patta_code,
                            dag_no: dag_no,
                        },
                        success: function(data2) {
                            var object = JSON.parse(data2);
                            console.log(object);
                            if (object.result === 0) {
                                console.log('abc');
                                $('#myModal .modal-content').css('background-color', 'red');
                                $('#myModal .modal-content').css('color', 'white');
                                $('#myModal .modal-content').html('<h1 class="text-center">' + object.error_msg + '</h1>');
                                $('#myModal').modal();
                            } else if (object.result === 1) {
                                var property_data = object.property_data
                                var transaction_data = object.transaction_data
                                console.log(property_data);
                                $.ajax({
                                    url: baseurl + "PropChainReport/generatePropertyChain",
                                    // dataType: 'html',
                                    method: 'post',
                                    data: {
                                        property_data: property_data,
                                        transaction_data: transaction_data

                                    },
                                    success: function(data3) {
                                        $('#myModal .modal-content').html(data3);
                                        $('#myModal').modal();
                                    }
                                });
                            } else {
                                $('#myModal .modal-content').css('background-color', 'red');
                                $('#myModal .modal-content').css('color', 'white');
                                $('#myModal .modal-content').html('<h1 class="text-center"><i class="fa fa-warning"></i>Unable to connect to property chain</h1>');
                                $('#myModal').modal();
                            }

                        }
                    });
                }
            })
        });
    });

