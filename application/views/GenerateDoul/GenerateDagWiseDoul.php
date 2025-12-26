<?php
  //  BRD005: Improvment in Revenue Updation in Doul
?>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Generate Doul / Year Wise Doul For Villages's (Dag's)</h2>
                </div>
            </div>               

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Auto Generated Doul of each Villages's (Dag's)
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr class="hope">
                                <td colspan="2">District : <?php echo $dist_name; ?></td>
                                <td colspan="2">Subdivision : <?php echo $subdiv_name; ?></td>
                                <td colspan="2">Circle : <?php echo $cir_name; ?></td>
                                <td colspan="2">Mouza Pargona : <?php echo $mouza_name; ?></td>
                            </tr>
                            <tr class="hope">
                                <td colspan="2">Lot : <?php echo $lot_name; ?></td>
                                <td colspan="2">Town / Village : <?php echo $village_name; ?></td>
                                <td colspan="2">Patta Type : <?php echo $patta_type; ?></td>
                                <td colspan="2">&nbsp;</td>
                            </tr>
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <table class="table table-bordered">
                                        <?php
                                        if(isset($result)==null)
                                            exit;
                                        foreach ($result as $key=>$value) {
                                            $patta_no = $key;
                                            $no_of_dags =  sizeof($value);
                                            ?>
                                            <tr class="hope">
                                                <td class="text-success" colspan="8">Patta no : <?php echo $key; ?> has total <?php echo $no_of_dags;?> number of Dags.</td>
                                                <td class="active"><span style="float: right; text-align: center;">Expand</span></td>
                                            </tr>
                                            <tr class="block">
                                                    <td>দাগ নং</td>
                                                    <td>পট্টাৰ প্রকাৰ</td>
                                                    <td>মাটিৰ শ্ৰেণী</td>
                                                    <td>বিঘা</td>
                                                    <td>কঠা</td>
                                                    <td>লেচা</td>
                                                    <td>দাগৰ ৰাজহ</td>
                                                    <td>স্হানীয় কৰ</td>
                                                    <td>&nbsp;</td>
                                            </tr>
                                            <?php
                                            foreach ($value as $res) {
                                                //var_dump($res)
                                                ?>
                                                <tr class="block">
                                                    <td><?php echo $res['dag_no']; ?></td>
                                                    <td><?php echo $res['patta_name']; ?></td>
                                                    <td><?php echo $res['land_class_name']; ?></td>
                                                    <td><?php echo $res['bigha']." বি"; ?></td>
                                                    <td><?php echo $res['ktha']." ক"; ?></td>
                                                    <td><?php echo round($res['lessa'],2)." লে"; ?></td>
                                                    <td><input type='text' class='form-control' id="<?php echo $res['dag_no']."dag_revenue"; ?>" value="<?php echo $res['dag_revenue']; ?>" style="width: 100px;"/></td>
                                                    <td><input type='text' class='form-control' id="<?php echo $res['dag_no']."local_tax";?>" value="<?php echo $res['local_tax']; ?>" style="width: 100px;"/></td>
                                                    <td>
                                                        <input type="hidden" class="form-control" id="dist_code" value="<?php echo $dist_code; ?>" readonly>
                                                        <input type="hidden" class="form-control" id="subdiv_code" value="<?php echo $subdiv_code; ?>" readonly>
                                                        <input type="hidden" class="form-control" id="circle_code" value="<?php echo $cir_code; ?>" readonly>
                                                        <input type="hidden" class="form-control" id="mouza_pargona_code" value="<?php echo $mouza_code; ?>" readonly>
                                                        <input type="hidden" class="form-control" id="<?php echo $res['dag_no']."lot_no"; ?>" value="<?php echo $res['lot_no']; ?>" readonly>
                                                        <input type="hidden" class="form-control" id="<?php echo $res['dag_no']."vill_townprt_code"; ?>" value="<?php echo $res['vill_townprt_code']; ?>" readonly>
                                                        <input type="hidden" class="form-control" id="<?php echo $res['dag_no']."patta_type_code"; ?>" value="<?php echo $res['patta_type_code']; ?>" readonly>
                                                        <input type="hidden" class="form-control" id="<?php echo $res['dag_no']."patta_no"; ?>" value="<?php echo $res['patta_no']; ?>" readonly>
                                                        <input type="hidden" class="form-control" id="<?php echo $res['dag_no']."dag_no"; ?>" value="<?php echo $res['dag_no']; ?>" readonly>
                                                        
                                                        <input type="button" class="btn btn-sm btn-success grant_permission"  id="<?php echo $res['dag_no']; ?>" value='Update Details'>
                                                        <a class="btn btn-sm btn-info" target="_blank" href="<?php  echo base_url() . "index.php/LegacyDataUpdation/generateChitha?dist_code=".$res['dist_code'] . "&subdiv_code=" . $res['subdiv_code'] . "&cir_code=" . $res['cir_code'] . "&mouza_pargona_code=" .$res['mouza_code']. "&lot_no=".$res['lot_no']."&vill_townprt_code=".$res['vill_townprt_code']."&patta_type=" .$res['patta_type_code']."&dag_no=" .$res['dag_no']."&patta_no=" .$res['patta_no']; ?>">View Chitha</a>
                                                        <br><span class="badge badge-danger <?php echo $res['dag_no']."blink_me"; ?>" style="margin-top: 10px;"></span>
                                                    </td>
                                                </tr>
                                                <?php
                                            }
                                            ?>
                                            <?php
                                        }
                                        ?>
                                    </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <center>
                            <button id="backButton" class="btn btn-danger"><i class="fa fa-arrow-left"></i>&nbsp;Back To Village Wise Doul</button>
                        </center>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    <style>
        .table>tbody>tr.active>td, 
        .table>tbody>tr>td.active,  
        .table>tfoot>tr.active>td, 
        .table>tfoot>tr>td.active, 
        .table>thead>tr.active>td, 
        .table>thead>tr>td.active{
            background-color: #a99d9d;
            color: #efefef;
            border-bottom: 1px solid red;
            border: 1px solid red;
        }
        
        .table>tbody>tr.block>td, 
        .table>tbody>tr>td.block,  
        .table>tfoot>tr.block>td, 
        .table>tfoot>tr>td.block, 
        .table>thead>tr.block>td, 
        .table>thead>tr>td.block{
            border: 1px solid red;
        }
        
        .table tr.hope {
            font-weight: bold;
            background-color: #fff;
            cursor: pointer;
            -webkit-user-select: none;
            /* Chrome all / Safari all */
            -moz-user-select: none;
            /* Firefox all */
            -ms-user-select: none;
            /* IE 10+ */
            user-select: none;
            /* Likely future */
        }
        
        .table tr.hope:after {
            color: #efefef;
        }

        .table tr:not(.hope) {
            display: none;
          }

        .table .hope td:after {
            content: "\002b";
            position: relative;
            top: 1px;
            display: inline-block;
            font-style: normal;
            font-weight: 400;
            line-height: 1;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            float: right;
            color: #efefef;
            text-align: center;
            padding: 3px;
            transition: transform .25s linear;
            -webkit-transition: -webkit-transform .25s linear;
        }

        .table .hope td {
            content: "\2212";
        }
        
        .block {
            color: #d80808;
        }
    </style>
    <script type="text/javascript">
        document.getElementById("backButton").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/GenerateDoul/VillagePattaWiseDoulGenerate?mouza_code='.$mouza_code.'&patta_type='.$patta_code; ?>";
        };
        
        $(document).ready(function() {
        //Fixing jQuery Click Events for the iPad
        var ua = navigator.userAgent,
          event = (ua.match(/iPad/i)) ? "touchstart" : "click";
        if ($('.table').length > 0) {
          $('.table .hope').on(event, function() {
            $(this).toggleClass("active", "").nextUntil('.hope').css('display', function(i, v) {
              return this.style.display === 'table-row' ? 'none' : 'table-row';
            });
          });
        }
      })

$('.grant_permission').click(function (e) {
        var id = $(this).attr("id");
        var dist_code = $('#dist_code').val();
        var subdiv_code = $('#subdiv_code').val();
        var circle_code = $('#circle_code').val();
        var mouza_pargona_code = $('#mouza_pargona_code').val();
        var lot_no = $('#'+id+'lot_no').val();
        var vill_townprt_code = $('#'+id+'vill_townprt_code').val();
        var patta_type_code = $('#'+id+'patta_type_code').val();
        var patta_no = $('#'+id+'patta_no').val();
        var dag_no = $('#'+id+'dag_no').val();
        var dag_revenue = $('#'+id+'dag_revenue').val();
        var local_tax = $('#'+id+'local_tax').val();
        //alert(dist_code+'-'+subdiv_code+'-'+circle_code+'-'+mouza_pargona_code+'-'+lot_no+'-'+vill_townprt_code+'-'+patta_type_code+'-'+patta_no+'-'+dag_no);
        
        $.ajax({
            url: baseurl + "GenerateDoul/UpdateDagRevenue/",
            type: 'post',
            dataType: 'json',
            data: {dist_code: dist_code,
                subdiv_code: subdiv_code ,
                circle_code: circle_code ,
                mouza_pargona_code: mouza_pargona_code ,
                lot_no: lot_no ,
                vill_townprt_code: vill_townprt_code ,
                patta_type_code: patta_type_code ,
                patta_no: patta_no ,
                dag_no: dag_no,
                dag_revenue: dag_revenue,
                local_tax: local_tax },
            success: function (data) {
                $('.'+id+'blink_me').html(data.success);
            },error: function (error) {
                alert('Something went wrong.');
            }
        });
    });

    </script>