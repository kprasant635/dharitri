<div class="row login">

    <div class="col-lg-12">
        <div class="col-lg-12">
            <div class="well well-sm ">
                <h3 style="text-align: center; font-size: 28px">Generate list of Patta Nos. by Pattadar Names</h3>
                <h2 style="text-align: center; color: #fff; font-size: 34px"></h2>
            </div>

            <div class="panel panel-form">
                <div class="panel-body">
                    <center>
                        <p><font face="Arial"><b><font size="5" color="#0000FF">List of Pattadar having more Patta</font></b></font></p>
                        <b>
                            <table class="table table-bordered">
                                <tr>
                                    <td width="20%" style="font-family: ASBW-TTDurga; font-size: 12pt" align="right">
                                        <font color="#000080"><b>মহকুমা</b></font>
                                    </td>
                                    <td width="21%" style="font-family: ASBW-TTDurga; font-size: 12pt" align="left">
                                        <?php echo $namedata[1]->subdiv; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td width="20%" style="font-family: ASBW-TTDurga; font-size: 12pt" align="right">
                                        <b><font color="#000080">চক্র</font></b>
                                    </td>
                                    <td width="21%" style="font-family: ASBW-TTDurga; font-size: 12pt" align="left">
                                        <?php echo $namedata[2]->circle; ?>
                                    </td>
                                </tr>
                            </table>
                            
                            <table id="example" class="table table-bordered"  width="100%">
                            <thead>
                                <tr>
                                    <td align='center'>
                                        <b>লাট নং</b>
                                    </td>
                                    <td align='center'>
                                        <b>গাওঁ / চহৰ </b>
                                    </td>
                                    <td align='center'>
                                        <b>পট্টাদাৰৰ নং</b>
                                    </td>
                                    <td align='center'>
                                        <b>পট্টাদাৰ নাম</b>
                                    </td>
                                    <td align='center'>
                                        <b>অভিভাৱকৰ নাম</b>
                                    </td>
                                    <td align='center'>
                                        <b>পট্টাৰ নং, পট্টাৰ প্রকাৰ</b>
                                    </td>  
                                    <td align='center'>
                                        <b>দাগ নং আৰু মাটিৰ পৰিমান</b>
                                    </td>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                foreach ($pbyname as $row1):
                                    if ($row1['strikeout'] == '0') {
                                        $pattadar_name = $row1['pattadar_name'];
                                    } else {
                                        $pattadar_name = '<strike style="color:red; height: 1px";>'.$row1['pattadar_name'].'</strike>';
                                    }
                                    ?>
                                    <tr>
                                        <td align='center'><?php echo $row1['lot_no']; ?></td>
                                        <td align='center'><?php echo $row1['vill_townprt_code'][0]->village; ?></td>
                                        <td align='center'><?php echo $row1['pattadarno']; ?></td>
                                        <td align='center'><?php echo $pattadar_name; ?></td>
                                        <td align='center'><?php echo $row1['pattadar_father']; ?></td>
                                        <td align='center'><?php echo $row1['patta_no']; ?>, <?php echo $row1['patta_type']; ?></td>
                                        <td align='center'><?php echo $row1['dag_no']; ?>, <?php echo $row1['dag_area']; ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                                ?>
                                <?php
                                if ($pbyname == null) {
                                    echo "<tr><td class='center danger' colspan='7' style='color:red'>Sorry No Data Found..!!</td></tr>";
                                }
                                ?>

                            </tbody>
                            </table>
                    </center>
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
</script>



