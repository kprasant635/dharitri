<div class="tableCard">
    <table class="table table-bordered">
        <tr>
            <th style="width: 20%">District</th>
            <td style="width: 30%">
                <?php echo $this->utilityclass->getDistrictName($basic->dist_code);?>
            </td>
            <th style="width: 20%">Sub Division</th>
            <td style="width: 30%">
                <?php echo $this->utilityclass->getSubDivName($basic->dist_code,$basic->subdiv_code);?>
            </td>
        </tr>
        <tr>
            <th style="width: 20%">Circle</th>
            <td style="width: 30%">
                <?php echo $this->utilityclass->getCircleName($basic->dist_code,$basic->subdiv_code,$basic->cir_code);?>
            </td>
            <th style="width: 20%">Mouza</th>
            <td style="width: 30%">
                <?php echo $this->utilityclass->getMouzaName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code);?>
            </td>
        </tr>
        <tr>
            <th style="width: 20%">Lot</th>
            <td style="width: 30%">
                <?php echo $this->utilityclass->getLotLocationName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no);?>
            </td>
            <th style="width: 20%">Village</th>
            <td style="width: 30%">
                <?php echo $this->utilityclass->getVillageName($basic->dist_code,$basic->subdiv_code,$basic->cir_code,$basic->mouza_pargona_code,$basic->lot_no,$basic->vill_townprt_code);?>
            </td>
        </tr>
    </table>
</div>