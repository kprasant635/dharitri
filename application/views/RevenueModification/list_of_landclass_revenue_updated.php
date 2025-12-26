<html>
    <style type="text/css">
        table.center {
            margin-left: auto;
            margin-right: auto;
        }
        //style="
    </style>
    <?php
    /* Author: Bijoy Mazumder, DIO, Bongaigaon, Dated-13/05/2017 */
    $dist_code = $this->session->userdata('dist_code');
    $subdiv_code = $this->session->userdata('subdiv_code');
    $cir_code = $this->session->userdata('cir_code');
    $user_code = $this->session->userdata('user_code');
    $cnt = 0;
    $cyear = date("Y");
    //echo date("Y/m/d");
    echo "<br><br><table class='center' style='border:4px solid black;' width='50%' border='2' align='center'>";
    echo "<tr><td colspan='6' align='center'><font color=red size=5>Land Classes for which Revenue and Local Tax have been updated</font></td></tr>";
    echo "<tr><td style='border:2px solid black;' align='center'><font color=blue>Sl No</font></td><td style='border:2px solid black;' align='center'><font color=blue>Land Class</font></td><td style='border:2px solid black;' align='center'><font color=blue>Revenue Per Bigha</font></td><td style='border:2px solid black;' align='center'><font color=blue>Minimum Revenue</font></td><td style='border:2px solid black;' align='center'><font color=blue>Year</font></td><td style='border:2px solid black;' align='center'><font color=blue>Entry Date</td><td style='border:2px solid black;' align='center'><font color=blue>Rural/Urban</td></font></tr>";
    $sqlstr = $this->db->query("select A.class_code, A.land_type, B.class_code, B.dag_revenue_perbigha, B.dag_local_tax_min, B.year_no, B.date_entry, B.ruralurban from landclass_code A, revenue_land_class_wise B  where A.class_code=B.class_code and dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$cir_code' order by year_no");
    foreach ($sqlstr->result() as $row) {
        $cnt++;
        echo "<tr style='border:1px solid black;'>";
        echo "<td align='center' style='border:2px solid black;'>" . $cnt . "</td>";
        echo "<td align='left' style='border:2px solid black;'>" . $row->land_type . "</td>";
        echo "<td align='center' style='border:2px solid black;'>" . $row->dag_revenue_perbigha . "</td>";
        echo "<td align='center' style='border:2px solid black;'>" . $row->dag_local_tax_min . "</td>";
        echo "<td align='center' style='border:2px solid black;'>" . $row->year_no . "</td>";
        echo "<td align='center' style='border:2px solid black;'>" . date("d/m/Y", strtotime($row->date_entry)) . "</td>";
        echo "<td align='center' style='border:2px solid black;'>" . $row->ruralurban . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    ?>
    <table class="center" style="border:4px solid black;" width="50%" border="2" align="center">
        <tr>
            <td align="center">
                <input type=button value ="CLOSE" onClick="javascript:window.close();" id=button2 name=button2>
            </td>
        </tr>
    </table>
</html>