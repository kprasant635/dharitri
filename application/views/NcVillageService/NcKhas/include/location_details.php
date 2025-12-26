<table class="table">
    <tr>
        <th>District Name</th>
        <td class="warning-color">
            <?=$this->ncutility->getDistrictName($basic->dist_code)?>
        </td>
    </tr>
    <tr>
        <th>Subdivision Name</th>
        <td class="warning-color">
            <?=$this->ncutility->getSubDivName($basic->dist_code, $basic->subdiv_code)?>
        </td>
    </tr>
    <tr>
        <th>Circle Name </th>
        <td class="warning-color">
            <?=$this->ncutility->getCircleName($basic->dist_code, $basic->subdiv_code, $basic->cir_code)?>
        </td>
    </tr>
    <tr>
        <th>Mouza Name </th>
        <td class="warning-color">
            <?=$this->ncutility->getMouzaName($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code)?>
        </td>
    </tr>
    <tr>
        <th>Village Name </th>
        <td class="warning-color">
            <?=$this->utilityclass->getVillageName($basic->dist_code, $basic->subdiv_code, $basic->cir_code, $basic->mouza_pargona_code, $basic->lot_no, $basic->vill_townprt_code)?>
        </td>
    </tr>
</table>