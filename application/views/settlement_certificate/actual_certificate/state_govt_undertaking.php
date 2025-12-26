<style>

    
    * {
        font-family: 'Arial', sans-serif;
        font-size: clamp(12px, 1.5vw, 14px) !important;
    }


    .tnc {
        width: 90%;
        border: 2px solid black;
        margin: auto;
        padding: 20px;
        margin-top: 10px;
    }

    .bg-cross {
        padding: 0px;
        border-radius: 0px;
    }

    .logo {
        height: 15% !important;
        width: 15% !important;
        text-align: center !important;
    }

    .logoEmblem {
        height: 100% !important;
        width: 100% !important;
    }

    .logoBorder {
        border: 0px;
    }

    .certificate-heading {
        font-size: 24px;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
    }

    .certificate-subheading {
        font-size: 18px;
        text-align: center;
        margin-top: 10px;
        font-weight: bold;
    }

    .certificate-table,
    .certificate-table th,
    .certificate-table td {
        border: 1px solid #000;
        border-collapse: collapse;
    }

    .certificate-table th,
    .certificate-table td {
        padding: 10px;
        text-align: left;
    }

    table {
        width: 100%;
    }

    table,
    th,
    td {
        border: 1px solid #000;
        border-collapse: collapse;
    }

    .certificate-footer {
        text-align: center;
        margin-top: 40px;
        font-size: 14px;
    }

    .btn-close {
        background-color: red;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
    }

    .btn-close:hover {
        background-color: darkred;
    }
</style>

<style>
    #digital_patta_modal {
        background-color: white;
        padding: 20px;
        font-size: 10px;
    }

    .certificate-bg {
        background-image: url('<?php echo base_url(); ?>assets/digital_patta/assam.jpg');
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        min-height: 600px;
        padding: 20px;
    }

    .logo-table img {
        height: 100px;
        width: 100px;
    }

    .section-heading {
        text-align: center;
        font-weight: bold;
    }

    .highlight-box {
        background-color: #fde9d9;
        padding: 8px;
    }

    .highlight-pink {
        background-color: #fde9d9;
    }

    .highlight-purple {
        background-color: #fde9d9;
    }

    .highlight-blue {
        background-color: #fde9d9;
    }

    .tnc {
        margin-top: 20px;
    }

    .tnc table {
        width: 100%;
        border-collapse: collapse;
    }

    .tnc th,
    .tnc td {
        border: 1px solid #000;
        padding: 8px;
    }

    .tnc th {
        background-color: #f2f2f2;
    }

     .page-break {
        page-break-before: always;
    }

    
@media print {
    @page {
        margin: 0; /* removes all page margins */
    }

    body {
        margin: 0;
        padding: 0;
    }
}
</style>

<div id="digital_patta_modal">
    <div class="certificate-bg">

     <!-- Logo Section -->
    <table class="logo-table" style="width: 100%; text-align:center; border:none;">
        <tr>
            <td style="border:none;text-align: left;">
                <img src="<?php echo base_url(); ?>assets/digital_patta/basundhara_white_logo.png">
            </td>
            <td style="border:none;">
                <img src="<?php echo base_url(); ?>assets/digital_patta/emblem.png">
            </td>
            <td style="border:none;text-align: right;">
                <img src="<?php echo $base_64_qr ?>">
            </td>
        </tr>
        <tr>
            <td colspan="3" style="text-align: right; border:none;">
    <strong>DATE OF ISSUE:</strong>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       <?php echo $certificate_data->certificate_date ?>
            </td>
        </tr>
    </table>

     <!-- Land Advisory Info -->
        <table class="highlight-box">
            <thead>
                <tr><h3 style="text-align: center;">OFFICE OF THE DISTRICT COMMISSIONER,<?php echo strtoupper($certificate_data->district_name) ?></h3></tr>
                <tr style="text-align: center;"><h4 style="text-align: center;">SPECIAL PERIODIC PATTA</br>(Issued under Section 40 of Assam Land and Revenue Regulation, 1886)</h4></tr>
            </thead>
            <!-- <tr>
                <th style="text-align:left;">Name of the Instituition</th>
                <td><?php echo $certificate_data->institute_name ?>
                </td>
            </tr>
            <tr>
                <th style="text-align:left;">Category</th>
                <td><?php echo $certificate_data->institute_name ?>
                </td>
            </tr>

            <tr>
                <th style="text-align:left;">Special Perodic Patta No & Date</th>
                <td>
                                                                                                                                                                                                                                                                                                                                                                                                                    <?php echo $certificate_data->certificate_no . ', ' . $certificate_data->certificate_date ?>
                </td>
            </tr> -->
        </table>


        <div class="highlight-blue" style="margin-top:15px; padding:10px;">
         <!-- Institution Details -->
        <table class="highlight-pink" style="margin-top:15px;">
            <tr>
                <th colspan="2" class="section-heading">INSTITUTION/ORGANIZATION DETAILS</th>
            </tr>
            <tr>
                <td><strong>Institution/Entity Name</strong></td>
                <td><?php echo strtoupper($certificate_data->institute_name) ?></td>
            </tr>
            <tr>
                <td><strong>Category</strong></td>
                <td><?php echo strtoupper('NON Government Educational Religious SocioCultural Institutions') ?></td>
            </tr>
            <tr>
                <td><strong>Other Details</strong></td>
                <td><?php echo $certificate_data->other_details ?></td>
            </tr>
        </table>


        <table class="highlight-purple" style="margin-top:15px;">
            <thead>
                <tr>
                    <td colspan="9" class="section-heading">LAND DESCRIPTION</td>
                </tr>
                <tr>
                    <td colspan="9" class="section-heading">LAND SCHEDULE DETAILS</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>District</b></td>
                    <td><?php echo strtoupper($certificate_data->district_name) ?></td>
                    <td><b>Sub-Division</b></td>
                    <td><?php echo strtoupper($certificate_data->subdivision_name) ?></td>
                    <td colspan="2"><b>Circle</b></td>
                    <td colspan="2"><?php echo strtoupper($certificate_data->circle_name) ?></td>
                </tr>
                <tr>
                    <td><b>Mouza</b></td>
                    <td><?php echo strtoupper($certificate_data->mouza_pargona_name) ?></td>
                    <td><b>Lot</b></td>
                    <td><?php echo strtoupper($certificate_data->lot_name) ?></td>
                    <td><b>Village</b></td>
                    <td colspan="2"><?php echo strtoupper($certificate_data->village_name) ?><br>UUID:
                    <span><?php echo strtoupper($certificate_data->village_uuid) ?></span></td>
                </tr>

                  <?php
                      $dagDetails = json_decode($certificate_data->dag_details);
                      if (! is_array($dagDetails)) {
                          // Wrap single object into array
                          $dagDetails = [$dagDetails];
                      }

                      foreach ($dagDetails as $key => $value) {
                      ?>
                <tr>
                    <td><b>Dag No. (old)</b></td>
                    <td><b>Dag No. (new)</b></td>
                    <td colspan="2"><b>Land Class (Use)</b></td>
                    <!-- <td><b>Land Class (Intended)</b></td> -->
                    <td colspan="4" style="text-align:center"><b>Total Area</b></td>
                </tr>
                <tr>
                    <td rowspan=2 style="text-align: center;"><?php echo $value->dag_no_old ?></td>
                    <td rowspan=2 style="text-align: center;"><?php echo $value->dag_no_new ?></td>
                    <td rowspan="2" colspan="2" style="text-align: center;"><?php echo $value->land_class; ?></td>
                    <td style="text-align: center;"><strong>B-K-L / B-K-C-G</strong></td>
                    <td style="text-align: center;"><strong>Hectare</strong></td>
                    <td style="text-align: center;"><strong>Square Meter</strong></td>
                </tr>

               <tr>
                    <td style="text-align: center;"><?php if (in_array($certificate_data->dist_code, json_decode(BARAK_VALLEY))) {
                                                                echo $value->bigha . '-' . $value->katha . '-' . $value->lessa . '-' . $value->ganga;
                                                            } else {
                                                                echo $value->bigha . '-' . $value->katha . '-' . $value->lessa;
                                                            }

                                                        ?></td>
                    </td>
                    <td  style="text-align: center;"><?php echo $value->total_hectare ?></td>


                    <td style="text-align: center;"><?php echo $value->total_square_meter ?></td>


                </tr>
                <?php
                    }
                ?>


            </tbody>
        </table>


     </table>


    <?php
    $dagDetails = json_decode($certificate_data->dag_details);
    $patta      = ! empty($dagDetails[0]->patta_details) ? $dagDetails[0]->patta_details : null;

    $dag_revenue   = $patta->dag_revenue   ?? 0;
    $dag_local_tax = $patta->dag_local_tax ?? 0;
    $old_patta_no  = $patta->old_patta_no  ?? '';
    $patta_no      = $patta->patta_no      ?? '';
    $patta_type    = $patta->patta_type_name ?? '';
?>
    <table class="certificate-table" style="border:none !important;">
        <thead>
            <tr>
                <td colspan="5" style="text-align:center " class="section-heading">
                    <b>LAND ATTRIBUTES</b>
                </td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="bold" rowspan="3">Patta No</td>
                <td>Old</td>
                <td>New</td>
                <td>Land Revenue</td>
                <td><?php echo $dag_revenue !== null ? number_format((float)$dag_revenue, 2, '.', '') : ''; ?></td>
            </tr>

            <tr>
                <td rowspan="2"><?php echo htmlspecialchars($old_patta_no); ?></td>
                <td rowspan="2"><?php echo htmlspecialchars($patta_no); ?></td>
                <td>Local Rate</td>
                <td><?php echo $dag_local_tax !== null ? number_format((float)$dag_local_tax, 2, '.', '') : ''; ?></td>
            </tr>

            <tr>

                <td>Surcharge</td>
                <td>0</td>
            </tr>

            <tr>
                <td class="bold">Patta Type</td>
                <td class="bold" colspan="2"><?php echo htmlspecialchars($patta_type); ?></td>
                <td>Total</td>
                <td colspan="2"><?php echo number_format((float)($dag_revenue + $dag_local_tax), 2, '.', ''); ?></td>
            </tr>

            <tr>
                <td class="red-text">Tenure</td>
                <td colspan="4">
                    The terminal date of settlement will be 30-09-2028, or as modified by Govt. of Assam.
                </td>
            </tr>
        </tbody>
    </table>

        <table class="certificate-table"
            style="border:none !important; width: 100%;">
            <thead>


                <tr>
                    <td colspan='9' style="text-align:center" class="section-heading">
                        <b>LAND LOCATION DETAILS</b>
                    </td>
                </tr>

                 <?php
                     $dagDetails = json_decode($certificate_data->dag_details);
                     if (! is_array($dagDetails)) {
                         // Wrap single object into array
                         $dagDetails = [$dagDetails];
                     }

                     foreach ($dagDetails as $key => $value) {
                     ?>
                    <tr>
                        <td rowspan="4" style="with:25%"><b> Boundary Description</b></td>
                        <td><b>Dag No. (new)</b></td>
                        <td><b>North</b></td>
                        <td><b>South</b></td>
                        <td><b>East</b></td>
                        <td><b>West</b></td>
                    </tr>

                    <tr>
                        <td rowspan="3" style="text-align: center;"><?php echo $value->dag_no_new ?? '' ?></td>
                        <td><?php echo $value->boundary_description->north ?? 'Undefined' ?></td>
                        <td><?php echo $value->boundary_description->south ?? 'Undefined' ?></td>
                        <td><?php echo $value->boundary_description->east ?? 'Undefined' ?></td>
                        <td><?php echo $value->boundary_description->west ?? 'Undefined' ?></td>

                    </tr>

                    <tr>
                        <td><b>Ulpin/Dag No*</b></td>
                        <td><b>Ulpin/Dag No*</b></td>
                        <td><b>Ulpin/Dag No*</b></td>
                        <td><b>Ulpin/Dag No*</b></td>
                    </tr>
                    <tr>
                        <td><?php echo $certificate_data->ulpin_dag_no_1 ?? '' ?></td>
                        <td><?php echo $certificate_data->ulpin_dag_no_2 ?? '' ?></td>
                        <td><?php echo $certificate_data->ulpin_dag_no_3 ?? '' ?></td>
                        <td><?php echo $certificate_data->ulpin_dag_no_4 ?? '' ?></td>

                    </tr>
                <?php
                    }
                ?>


            </thead>
        </table>


        <!-- Geo Section -->
        <table class="highlight-blue" style="margin-top:15px; text-align:center;">
            <tr>
                <th>ULPIN*/Geo-coordinates</th>
                <th>Land Schedule Sketch (Link)</th>
                <th>Google Location</th>
                <th>Geo Tag Photos</th>
            </tr>
            <tr>
                <td><img src="<?php echo $base_64_qr_geo_cordinates ?>" style="width:100px; height:100px;"></td>
                <td><img src="<?php echo $base_64_qr_sketch ?>" style="width:100px; height:100px;"></td>
                <td><img src="<?php echo $base_64_qr_google ?>" style="width:100px; height:100px;"></td>
                <td><img src="<?php echo $dag_sketch_qr_photos ?>" style="width:100px; height:100px;"></td>
            </tr>

            <tr>
                <td>
                    Encumbrance Details (If any)
                </td>
                <td colspan="3"></td>
            </tr>
        <tr>
                <td colspan="4">
                    Note: This is a system-generated document which does not require any physical signature. The authenticity of this document can be verified by scanning the QR code provided herein.
                </td>
            </tr>
        </table>

        <p style="text-align:right; font-size:13px;">
            <b>Issuing Authority : District Commissioner, <?php echo $certificate_data->district_name; ?></b>

        </p>
                </div>




</div>

    <!-- Terms & Conditions -->
    <div class="page-break" style="padding: 10px; margin-top:15px;">
  <table style="margin-top:15px;" class="tnc-table" >
    <thead>
        <tr>
            <th style="width:5%;">Sl. No</th>
            <th>Terms And Conditions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>During the change in usage or class of land of the total land or any part thereof with due permission from authority on payment of premium or penalty as the case may be wherever applicable, the revenue and local taxes now assessed may be changed by the State Government in accordance with law or rules in force and that shall be payable by the Lease-holder in prescribed time.</td>
        </tr>
        <tr>
            <td>2</td>
            <td>If upon the expiry of the lease, the lease-holder does not intend to extend or get issued a fresh lease the State Government may at any time after the lease period annul the lease or settle the land with any other person as the case may be.</td>
        </tr>
        <tr>
            <td>3</td>
            <td>In case of any public path or Government. institutions found on any land held by the lease-holder, the authority will have the right to take action as per Section 10 of Assam Land Revenue Regulation 1886, treating the said land deemed to have been relinquished by the lease-holder.</td>
        </tr>
        <tr>
            <td>4</td>
            <td>The Lease-holder shall have a transferable right, subject to prior approval of the Government.</td>
        </tr>
        <tr>
            <td>5</td>
            <td>The Lease-holder shall have a transferable right of use and occupancy in the land subject to the reservation in favour of the State Government of all quarries and of all mines, minerals and mineral oils, and of all buried treasure, with full liberty to search for and work the same, paying to the leaseholder only compensation for the surface damage as estimated by the District Commissioner.</td>
        </tr>
        <tr>
            <td>6</td>
            <td>The Lease-holder shall conform to pay the annual land revenue and any local rates or cesses etc. from time to time assessed on the said land by itself , payable under any law or rules for the time being in force.</td>
        </tr>
        <tr>
            <td>7</td>
            <td>The terms and conditions of this lease shall be binding on the said lease-holder in the interest of the State Government and the Lease-holder in all cases.</td>
        </tr>
        <tr>
            <td>8</td>
            <td>This settlement of land shall be cancelled if it is established at any later stage that such beneficiaries resorted to submission of fraudulent supporting documents &amp; information including affidavits and in case of settlement of land on realization of premium, amount of premium shall be forfeited in addition to any other legal action for submission of fraudulent documents &amp; information,false affidavits etc.</td>
        </tr>
        <tr>
            <td>9</td>
            <td>Violation of any of the above conditions may result in annulment of the settlement by cancellation of Patta.</td>
        </tr>
    </tbody>
</table>


<p style="text-align:right; font-size:13px;">
          <b>Issuing Authority : District Commissioner, <?php echo $certificate_data->district_name; ?></b>

      </p>
    </div>
</div>