<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Generate Doul / Year Wise Doul For Mouza's </h2>
                </div>
            </div>               

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Auto Generated Doul of each mouza's
                        </h3>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered">
                            <tr class="hope">
                                <td colspan="2">District : <?php echo $dist_name; ?></td>
                                <td colspan="2">Subdivision : <?php echo $subdiv_name; ?></td>
                                <td colspan="2">Circle : <?php echo $cir_name; ?></td>
                                <td colspan="2">Year : <?php echo $year; ?></td>
                            </tr>
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <form method="post" action="<?php echo base_url()."index.php/GenerateDoul/EditReport";?>">
                        <table class="table table-bordered">
                            <tr class="hope">
                                <td >Mouza Pargona</td>
                                <td >No Of Patta</td>
                                <td>Revenue</td>
                                <td>Local Tax</td>
                                <td>Bigha</td>
                                <td>Katha</td>
                                <td>Lessa</td>
                            </tr>
                            <?php
                            foreach ($result as $value) {
                                ?>
                                <tr class="hope">
                                    <td class="text-success"><?php echo $value['mouza_name']; ?></td>
                                    <td ><input type="text" class="form-control" name="total_patta[]" value="<?php echo $value['total_patta']; ?>" readonly></td>
                                    <td><input type="text" class="form-control" name="total[]" value="<?php echo $value['total']; ?>" readonly></td>
                                    <td><input type="text" class="form-control" name="local_tax[]" value="<?php echo $value['local_tax']; ?>" readonly></td>
                                    <td><input type="text" class="form-control" name="bigha[]" value="<?php echo $value['bigha']; ?>" readonly></td>
                                    <td><input type="text" class="form-control" name="ktha[]" value="<?php echo $value['ktha']; ?>" readonly></td>
                                    <td><input type="text" class="form-control" name="lessa[]" value="<?php echo $value['lessa']; ?>" readonly></td>
                                </tr>
                                <?php
                            }
                            ?>
                        </table>
                        <hr style="border-bottom: 2px solid #000;">
                        <button id="backButton" class="btn btn-sm btn-danger"><i class="fa fa-check-circle"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?></button>
                        <input type="hidden" class="form-control" name="dist_code" value="<?php echo $dist_code; ?>" readonly>
                        <input type="hidden" class="form-control" name="subdiv_code" value="<?php echo $subdiv_code; ?>" readonly>
                        <input type="hidden" class="form-control" name="cir_code" value="<?php echo $cir_code; ?>" readonly>
                        <input type="hidden" class="form-control" name="year" value="<?php echo $year; ?>" readonly>
                        <button id="submit" class="btn btn-sm btn-success"><i class="fa fa-check-circle"></i>&nbsp;Edit Doul</button>
                        </form>
                    </div>
                </div>


                </form>
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


        document.getElementById("backButton").onclick = function () {
            location.href = "<?php echo base_url() . 'index.php/MisReport/DoulReport' ?>";
        };
    </script>