<script type="text/javascript">
    function ConfDel() {
        if (!confirm('Really want to Modify This Record?'))
            return (false);
        return (true);
    }
</script>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-12 ">
            <?php if ($this->session->flashdata('message')): ?>
                <?php include 'message.php'; ?>
            <?php endif; ?>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;">Modify Patta Numbers (Junk Data) <span class="red">** Optional</span></h2>
                </div>
            </div>
            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info panel-form">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            All Results
                        </h3>
                    </div>
                    <div class="panel-body">
                        <div class="bs-callout bs-callout-info" id="callout-type-b-i-elems"> 
                            <h6 class="red uni_text">NOTE : All Patta number's having any characters like (ক,খ..etc) might be genuine data. Please Cross Check the data in chitha as well as jamabandi before Modifying. </h6>
                        </div>
                        <hr style="border-bottom: 2px solid #000;">
                        <h4 class="center">
                            <code><?php echo $this->lang->line('district'); ?> : <?php echo $location['dist_code']; ?></code>&nbsp;&nbsp;&nbsp;&nbsp;
                            <code><?php echo $this->lang->line('subdivision'); ?> : <?php echo $location['subdiv_code']; ?></code>&nbsp;&nbsp;&nbsp;&nbsp;
                            <code><?php echo $this->lang->line('circle'); ?> : <?php echo $location['cir_code']; ?></code>
                        </h4>
                        <hr style="border-bottom: 2px solid #000;">
                        <table id="example" class="table table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <td class="bold" width="12%">Patta No</td>
                                    <td>Action</td>
                                    <td class="bold" width="15%">Patta Type</td>
                                    <td class="bold">Location details ( Mouza / Lot / Village )</td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                    $i = 1;
                                    foreach ($junk as $key => $row1):
                                    //var_dump($row1);
                                    ?>
                                    <tr>
                                        <td class="center">
                                            <input type="hidden" value="<?php echo $i; ?>" id="id">
                                            <input type="hidden" value="<?php echo $row1['patta_code']; ?>" id="patta_code<?php echo $i; ?>" name="patta_code">
                                            <input type="hidden" value="<?php echo $row1['patta_no']; ?>" id="old_patta_no<?php echo $i; ?>" name="old_patta_no">
                                            <input type="hidden" value="<?php echo $row1['dist_code']; ?>" id="dist_code<?php echo $i; ?>" name="dist_code">
                                            <input type="hidden" value="<?php echo $row1['subdiv_code']; ?>" id="subdiv_code<?php echo $i; ?>" name="subdiv_code">
                                            <input type="hidden" value="<?php echo $row1['cir_code']; ?>" id="cir_code<?php echo $i; ?>" name="cir_code">
                                            <input type="hidden" value="<?php echo $row1['mouza_pargona_code']; ?>" id="mouza_pargona_code<?php echo $i; ?>" name="mouza_pargona_code">
                                            <input type="hidden" value="<?php echo $row1['lot_no']; ?>" id="lot_no<?php echo $i; ?>" name="lot_no">
                                            <input type="hidden" value="<?php echo $row1['vill_townprt_code']; ?>" id="vill_townprt_code<?php echo $i; ?>" name="vill_townprt_code">
                                            <input type="text" value="<?php echo $row1['patta_no']; ?>" id="new_patta_no<?php echo $i; ?>" name="patta_no">
                                        </td>
                                        <td class="center"><button onclick="update(<?php echo $i; ?>);">Update</button></td>
                                        <td class="center"><?php echo $row1['patta_name']; ?></td>
                                        <td class="">
                                            <?php
                                            echo $mouza_pargona_code = $this->utilityclass->getMouzaName($row1['dist_code'], $row1['subdiv_code'], $row1['cir_code'], $row1['mouza_pargona_code']);
                                            echo " / ".$lot_no = $this->utilityclass->getLotName($row1['dist_code'], $row1['subdiv_code'], $row1['cir_code'], $row1['mouza_pargona_code'], $row1['lot_no']);
                                            echo " / ".$vill_townprt_code = $this->utilityclass->getVillageName($row1['dist_code'], $row1['subdiv_code'], $row1['cir_code'], $row1['mouza_pargona_code'], $row1['lot_no'], $row1['vill_townprt_code']);
                                            ?>
                                            <div id="mesg<?php echo $i; ?>" style="float:right"></div>
                                        </td>
                                    </tr>
                                    <?php
                                    $i = $i+1;
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                        <div class="form-group center">
                            <div class="col-lg-12">
                                <a href="<?php echo base_url(); ?>index.php/utility/districtDetails" class="btn btn-danger">
                                    <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu');?>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    //startButton.disabled = true;
    $(document).ready(function () {
        $('#example').DataTable();
    });
    
    function update(e)
    {
        //alert($('#new_patta_no'+e).val());
        var distcode = $('#dist_code'+e).val();
        var subdivcode = $('#subdiv_code'+e).val();
        var circode = $('#cir_code'+e).val();
        var mouza_pargona_code =  $('#mouza_pargona_code'+e).val();
        var lot_no =  $('#lot_no'+e).val();
        var vill_townprt_code =  $('#vill_townprt_code'+e).val();
        var old_patta_no = encodeURIComponent($('#old_patta_no'+e).val());
        var new_patta_no = $('#new_patta_no'+e).val();
        var patta_code = $('#patta_code'+e).val();
        
        var r = confirm("Are You Sure You Want to Update Patta Number!");
        if (r == true) {
            $.ajax({
                url: baseurl + "Utility/update_patta_no/" + distcode + '/' + subdivcode + '/' + circode + '/' + mouza_pargona_code + '/' + lot_no + '/' + vill_townprt_code + '/' + old_patta_no + '/' + new_patta_no + '/' + patta_code,
                success: function (d) {
                    if(d == 1){
                        document.getElementById("mesg"+e).innerHTML = "<label for=\"inputEmail3\"><p style=\" color: #ff0000; align:center\">Updated Successfully.</p></label>";
                    }else{
                        document.getElementById("mesg"+e).innerHTML = "<label for=\"inputEmail3\"><p style=\" color: #ff0000; align:center\">Patta Number Already Exist.</p></label>";
                    }
                }
            });
        } else {
            return false;
        }
    }
</script>


