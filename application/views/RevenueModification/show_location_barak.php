<?php /* Author: Bijoy Mazumder, DIO, Bongaigaon, Dated-13/05/2017 */ ?>
<div class="container-fluid form-top login">
    <div class="row">
        <div class="col-lg-12 ">
            <div class="col-lg-10 col-lg-offset-1">
                <div class="well well-sm">
                    <h2 style="text-align: center;"> Update Revenue & Local Tax </h2>
                </div>
            </div>               

            <div class="col-lg-10 col-lg-offset-1">
                <div class="panel panel-info">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            Update Utility
                        </h3>
                    </div>
                    <div class="panel-body">
                        <label><font color=blue size=4>Sequence to be followed for updating Land Revenue :</font></label><br>
                        <label>1) First Update Revenue Circle Wise.</label><br>
                        <!--<label>2) Use the Village wise module to update Land Revenue for a particular village (if necessary).</label>&nbsp;&nbsp;
                        <a href="<?php echo base_url(); ?>index.php/ControllerForRevenueUpdate/SelectLocationsVill" class="green"> <label>[ Click Here to Update Particular Village ]</label> </a><br>-->
                        <label>2) Use the Dag wise module to update Land Revenue of a particular Dag no (if necessary).</label>&nbsp;&nbsp;
                        <a href="<?php echo base_url(); ?>index.php/ControllerForRevenueUpdate/SelectLocationsDag" class="green"> <label>[ Click Here to Update Particular Dag ]</label> </a><br>
                        <label><font color=red size=4>User must follow the above mentioned sequences to update Revenue. Use point 2 and 3 only if necessary.</font></label>
                        <hr style="border-bottom: 2px solid #000;">
                        <h2 class="red">Update Revenue & Local Tax Based on Land Class</h2>
                        <form class='form-horizontal' method="post" action="">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('district') ?> </label>
                                <div class="col-sm-4">
                                    <select class="form-control districtselect" id="LmMutationSelectDistrict" name="dist_code" required>
                                        <option value="<?php echo $datas['dist_code']; ?>"><?php echo $datas['dist_name']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('subdivision') ?></label>
                                <div class="col-sm-4">
                                    <select class="form-control subdivselect" id="select" name="subdiv_code" required>
                                        <option value="<?php echo $datas['subdiv_code']; ?>"><?php echo $datas['sub_div_name']; ?></option>
                                    </select>
                                </div>

                                <label for="inputEmail3"><a href="<?php echo base_url(); ?>index.php/ControllerForRevenueUpdate/VerifyOldRevenue" target="_blank"><font color=blue size=5 style="background: #99CCFF" ><b>Check Recent Updates</b></font></a></label>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label"><?php echo $this->lang->line('circle') ?> </label>
                                <div class="col-sm-4">                  
                                    <select class="form-control circleselect" id="select" required name="circle_code">
                                        <option value="<?php echo $datas['cir_code']; ?>"><?php echo $datas['cir_name']; ?></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label required" id='landclass'>Land Class Code:</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="land_class_code" required>
                                        <option value="" selected disabled> -- Select Land Class -- </option>
                                        <?php foreach ($land_classes as $pt): ?>
                                            <option value="<?php echo $pt->class_code; ?>"><?php echo $pt->land_type; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>                            
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label">Revenue Per Bigha<font color=red size=4>&nbsp;(in Rs):</font></label>
                                <div class="col-sm-4"> 
                                    <input type="text" class="form-control" title="Enter Per Bigha Land Revenue" name="revenuebigha" required ></div><font color=red size=4><b>(Confirm it before submission)</b></font></div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label">Minimum Revenue <font color=red size=4>&nbsp;(in Rs):</font></label>
                                <div class="col-sm-4">   
                                    <input type="text" class="form-control" title="Enter 0 if Minimum Revenue is not considered" name="minRevenue" required value="0" ></div><font color=red size=3><b>(0 if minimum revenue is not considered)</b></font>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label required" id='landclass'>Rural/Urban/Nisphi-Kheraj:</label>
                                <div class="col-sm-4">
                                    <select class="form-control" name="RuralUrban" required>
                                        <option value="Rural">Rural</option>
                                        <option value="Urban">Urban</option>
                                        <option value="NisphiKherajR">Nisphi Kheraj (Rural)</option>
                                        <option value="NisphiKherajU">Nisphi Kheraj (Urban)</option>
                                    </select>
                                </div>                            
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 uni_text control-label" style="color:red"> Proportionate Calculation Required?</label>
                                <div class="col-sm-8">
                                    <input type="checkbox" name="proportunate" value="1">&nbsp&nbsp&nbsp<font color=blue size=4>[Check it, if fractional calculation is required for land area less than 1 Bigha]</font>	
                                </div>
                            </div>
                            <?php
                            if ($this->input->server('REQUEST_METHOD') == 'POST') { //First Braket
                                $cdt = date("Y/m/d");
                                $cyr = date("Y");
                                $usercode = $this->session->userdata('user_code');
                                $RevenuePerBigha = $this->input->post('revenuebigha');
                                $minRevenue = $this->input->post('minRevenue');
                                $dist_code = $this->input->post('dist_code');
                                $subdiv_code = $this->input->post('subdiv_code');
                                $circle_code = $this->input->post('circle_code');
                                $land_class_code = $this->input->post('land_class_code');
                                $LessaAmount = ($RevenuePerBigha / 6400);
                                $RuralUrban = $this->input->post('RuralUrban');
                                $HalfOfRev = ($minRevenue) / 2;
                                $OneFourthRev = ($minRevenue) / 4;
                                $ThreeFourthRev = ($minRevenue) * (3 / 4);
                                $HalfOneFourth = ($minRevenue / 2) * (3 / 4);
                                $fractional = $this->input->post('proportunate');

                                if (is_numeric($RevenuePerBigha) == FALSE || is_numeric($minRevenue) == FALSE) {
                                    echo "<p align=center><u><font size=4 color=red>SORRY!!!Only Numeric Value accepted.</font></u></p>";
                                } else { //First Else Part
                                    if ($RevenuePerBigha <= 0 || $minRevenue < 0) {
                                        echo "<p align=center><u><font size=4 color=blue>Revenue and Local Tax Should Not Smaller than 0</font></u></p>";
                                    } else { //Starting of 2nd Else Part
                                        /* ------------------------------------------------------- */
                                       $q = $this->db->query("SELECT count(*) as c1 FROM revenue_land_class_wise where dist_code='$dist_code' and subdiv_code='$subdiv_code' and 
									       cir_code='$circle_code' and class_code='$land_class_code' and year_no='$cyr' and ruralurban='$RuralUrban'");
                                            foreach ($q->result() as $row) {
                                                $cntRow = $row->c1;
                                        }
                                        //---------------------------
                                        if ($cntRow > 0) { //If the Record is already there, than update.
                                        $this->db->query("UPDATE revenue_land_class_wise set dag_revenue_perbigha='$RevenuePerBigha', dag_local_tax_min='$minRevenue' where 
										dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and class_code='$land_class_code' and year_no='$cyr' and 
										ruralurban='$RuralUrban'");
                                        } else { //Insert a new record in revenue_land_class_wise table.
                                        $this->db->query("INSERT INTO revenue_land_class_wise (dist_code, subdiv_code, cir_code, class_code, year_no, dag_revenue_perbigha, 
										dag_local_tax_min, user_code, date_entry, ruralurban) VALUES ('$dist_code', '$subdiv_code', '$circle_code', '$land_class_code', 	
										'$cyr','$RevenuePerBigha', '$minRevenue' ,'$usercode', '$cdt', '$RuralUrban')");

                                        }
                                        /* ------------------------------------------------------- */

                                        if ($RuralUrban == 'Rural') {
                                            $sqlRural="Select cb.vill_townprt_code  from location lc join chitha_basic cb
                                            on cb.dist_code=lc.dist_code and cb.subdiv_code=lc.subdiv_code and 
                                            cb.mouza_pargona_code=lc.mouza_pargona_code and cb.lot_no=lc.lot_no and cb.vill_townprt_code=lc.vill_townprt_code
                                            where cb.dist_code='$dist_code' and cb.subdiv_code='$subdiv_code' and cb.cir_code='$circle_code' and lc.rural_urban='R' 
                                            group by cb.dist_code,cb.subdiv_code,cb.cir_code,cb.mouza_pargona_code,cb.lot_no,cb.vill_townprt_code  ";
                                            $this->db->query("UPDATE chitha_basic set dag_revenue=(dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount, dag_local_tax = ((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/4 where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and land_class_code='$land_class_code' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)>6400 and vill_townprt_code in ($sqlRural) ");                                            
                                            $this->db->query("UPDATE jama_dag set dag_revenue=(dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount, dag_localtax = ((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/4 where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and dag_class_code='$land_class_code' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)>6400 and vill_townprt_code in ($sqlRural) ");
                                            //IF LAND AREA IS LESS THAN or EQUAL TO 1 BIGHA
                                            if (empty($fractional)) {
                                                $this->db->query("UPDATE chitha_basic set dag_revenue='$minRevenue' , dag_local_tax = '$OneFourthRev' where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and land_class_code='$land_class_code' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)<=6400 and vill_townprt_code in ($sqlRural) ");

                                                $this->db->query("UPDATE jama_dag set dag_revenue='$minRevenue', dag_localtax = '$OneFourthRev' where dist_code='$dist_code' and patta_type_code!='0208' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and dag_class_code='$land_class_code' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g) <= 6400 and vill_townprt_code in ($sqlRural) ");
                                            } else {
                                                $this->db->query("UPDATE chitha_basic set dag_revenue=(dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount, dag_local_tax = ((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/4 where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and land_class_code='$land_class_code' and patta_type_code<>'0208' and  (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)<=6400 and vill_townprt_code in ($sqlRural) ");
                                                
                                                $this->db->query("UPDATE jama_dag set dag_revenue=(dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount, dag_localtax = ((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/4 where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and dag_class_code='$land_class_code'  and patta_type_code<>'0208' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)<=6400 and vill_townprt_code in ($sqlRural) ");
                                            }
                                        } else if ($RuralUrban == 'Urban') {
                                            // if Land Area is more than 1 Bigha 
                                            $sqlRural="Select cb.vill_townprt_code  from location lc join chitha_basic cb
                                            on cb.dist_code=lc.dist_code and cb.subdiv_code=lc.subdiv_code and 
                                            cb.mouza_pargona_code=lc.mouza_pargona_code and cb.lot_no=lc.lot_no and cb.vill_townprt_code=lc.vill_townprt_code
                                            where cb.dist_code='$dist_code' and cb.subdiv_code='$subdiv_code' and cb.cir_code='$circle_code' and lc.rural_urban='U' 
                                            group by cb.dist_code,cb.subdiv_code,cb.cir_code,cb.mouza_pargona_code,cb.lot_no,cb.vill_townprt_code  ";
                                            $this->db->query("UPDATE chitha_basic set dag_revenue=(dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount, dag_local_tax = ((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/4 where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and land_class_code='$land_class_code' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 + dag_area_g) >6400 and vill_townprt_code in ($sqlRural) ");
                                            $this->db->query("UPDATE jama_dag set dag_revenue=(dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount, dag_localtax = ((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/4 where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and dag_class_code='$land_class_code' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g) > 6400 and vill_townprt_code in ($sqlRural)");
                                            //IF LAND AREA IS LESS THAN and EQUAL TO  1 BIGHA
                                            if (empty($fractional)) {
                                                $this->db->query("UPDATE chitha_basic set dag_revenue='$minRevenue' , dag_local_tax = '$OneFourthRev' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and land_class_code='$land_class_code' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)<=6400 and vill_townprt_code in ($sqlRural) ");
                                                $this->db->query("UPDATE jama_dag set dag_revenue='$minRevenue', dag_localtax = '$OneFourthRev' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and dag_class_code='$land_class_code' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g) <= 6400 and vill_townprt_code in ($sqlRural)");
                                            } else {
                                                $this->db->query("UPDATE chitha_basic set dag_revenue=(dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount, dag_local_tax = ((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/4 where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and land_class_code='$land_class_code' and patta_type_code<>'0208' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)<=6400 and vill_townprt_code in ($sqlRural) ");
                                                $this->db->query("UPDATE jama_dag set dag_revenue=(dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount, dag_localtax = ((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/4 where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and dag_class_code='$land_class_code'  and patta_type_code<>'0208' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)<=6400 and vill_townprt_code in ($sqlRural)");
                                            }
                                        } else if ($RuralUrban == 'NisphiKherajR') {
                                            $sqlRural="Select cb.vill_townprt_code  from location lc join chitha_basic cb
                                            on cb.dist_code=lc.dist_code and cb.subdiv_code=lc.subdiv_code and 
                                            cb.mouza_pargona_code=lc.mouza_pargona_code and cb.lot_no=lc.lot_no and cb.vill_townprt_code=lc.vill_townprt_code
                                            where cb.dist_code='$dist_code' and cb.subdiv_code='$subdiv_code' and cb.cir_code='$circle_code' and lc.rural_urban='R' 
                                            group by cb.dist_code,cb.subdiv_code,cb.cir_code,cb.mouza_pargona_code,cb.lot_no,cb.vill_townprt_code  ";
                                            //*******For the Nisphi Kheraj-0208 -------IF LAND AREA IS  MORE THAN 1 Bigha
                                            $this->db->query("UPDATE chitha_basic set dag_revenue=((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/2, dag_local_tax = (((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/2 *  0.75) where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and land_class_code='$land_class_code' and patta_type_code='0208' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g) > 6400 and vill_townprt_code in ($sqlRural) ");
                                            $this->db->query("UPDATE jama_dag set dag_revenue=((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/2, dag_localtax = (((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/2 * 0.75) where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and dag_class_code='$land_class_code' and patta_type_code='0208' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g) > 6400 and vill_townprt_code in ($sqlRural) ");
                                            // if Land Area is equal and less than 1 Bigha 
                                            $this->db->query("UPDATE chitha_basic set dag_revenue='$minRevenue', dag_local_tax = '$ThreeFourthRev' where dist_code='$dist_code' and subdiv_code='$subdiv_code' 	and cir_code='$circle_code' and land_class_code='$land_class_code' and 	patta_type_code='0208' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g) <= 6400 and vill_townprt_code in ($sqlRural)");
                                            $this->db->query("UPDATE jama_dag set dag_revenue='$minRevenue', dag_localtax = '$ThreeFourthRev' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and dag_class_code='$land_class_code' and patta_type_code='0208' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g) <= 6400 and vill_townprt_code in ($sqlRural)");
                                        }else if ($RuralUrban == 'NisphiKherajU') {
                                            $sqlurban="Select cb.vill_townprt_code  from location lc join chitha_basic cb
                                            on cb.dist_code=lc.dist_code and cb.subdiv_code=lc.subdiv_code and 
                                            cb.mouza_pargona_code=lc.mouza_pargona_code and cb.lot_no=lc.lot_no and cb.vill_townprt_code=lc.vill_townprt_code
                                            where cb.dist_code='$dist_code' and cb.subdiv_code='$subdiv_code' and cb.cir_code='$circle_code' and lc.rural_urban='U' 
                                            group by cb.dist_code,cb.subdiv_code,cb.cir_code,cb.mouza_pargona_code,cb.lot_no,cb.vill_townprt_code  ";
                                            //*******For the Nisphi Kheraj-0208 -------IF LAND AREA IS  MORE THAN 1 Bigha
                                            $this->db->query("UPDATE chitha_basic set dag_revenue=((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/2, dag_local_tax = (((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/2 *  0.75) where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and land_class_code='$land_class_code' and patta_type_code='0208' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g) > 6400 and vill_townprt_code in ($sqlurban)");
                                            $this->db->query("UPDATE jama_dag set dag_revenue=((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/2, dag_localtax = (((dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g)* $LessaAmount)/2 * 0.75) where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and dag_class_code='$land_class_code' and patta_type_code='0208' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g) > 6400 and vill_townprt_code in ($sqlurban)");
                                            // if Land Area is equal and less than 1 Bigha 
                                            $this->db->query("UPDATE chitha_basic set dag_revenue='$minRevenue', dag_local_tax = '$ThreeFourthRev' where dist_code='$dist_code' and subdiv_code='$subdiv_code'  and cir_code='$circle_code' and land_class_code='$land_class_code' and  patta_type_code='0208' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g) <= 6400 and vill_townprt_code in ($sqlurban)");
                                            $this->db->query("UPDATE jama_dag set dag_revenue='$minRevenue', dag_localtax = '$ThreeFourthRev' where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and dag_class_code='$land_class_code' and patta_type_code='0208' and (dag_area_b * 6400 + dag_area_k * 320 + dag_area_lc *20 +dag_area_g) <= 6400 and vill_townprt_code in ($sqlurban)");
                                        }
                                        // For La Kheraj and Govt. Land the Revenue have to be set to 0 ------------
                                        $this->db->query("UPDATE chitha_basic set dag_revenue=0, dag_local_tax = 0 where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and  (patta_type_code='0209'  or patta_type_code='0205') ");
                                        $this->db->query("UPDATE jama_dag set dag_revenue=0, dag_localtax = 0 where dist_code='$dist_code' and subdiv_code='$subdiv_code' and cir_code='$circle_code' and  (patta_type_code='0209'  or patta_type_code='0205') ");
                                        /* ------------------------------------------------------- */
                                        $sqlstr = $this->db->query("select land_type from landclass_code where class_code='$land_class_code'");
                                        foreach ($sqlstr->result() as $row) { //This part is just to display which land class has been updated.
                                            echo "<p align=center><u><font size=4 color=blue>Revenue and Local Tax  & Updated for &nbsp;</font><font size=4 color=red>" . $row->land_type . "</font></u></p>";
                                        }
                                    }// End of the 2nd else Part
                                } //First Else If Loop
                            } //Last Braket
                            ?>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group" align="center">
                                <label for="inputEmail3"><font color=red size=4>IMPORTANT:</font><font color=blue size=4>This action will update class wise</font> <font color="#FF0000"> Land Revenue & Local Tax </font> <font color=blue size=4>in all</font><font color="#FF0000"> Chitha and Jamawandi of the Circle</font>. <font color=blue size=4>So, no frequent use of this module is necessary. </font></label>
                            </div>
                            <hr style="border-bottom: 2px solid #000;">
                            <div class="form-group">
                                <div class="col-sm-12 center" >
                                    <a href="<?php echo base_url(); ?>index.php/home" class="btn btn-sm btn-danger">
                                        <i class="fa fa-arrow-left"></i>&nbsp;<?php echo $this->lang->line('back_to_main_menu'); ?>
                                    </a>
                                    <?php if(ENABLED_BLOCKCHAIN == 1 && in_array($this->session->userdata('dist_code'),json_decode(ENABLED_BLOCKCHAIN_FOR_DIST)))
                                    {?>
                                    You cannot procced as dag no is pending for property chain update... &nbsp;&nbsp; | &nbsp;&nbsp;
                                    <?php }else{?>
                                     <button type="submit" class="btn btn-sm btn-success"><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_button') ?> & Save</button> &nbsp;&nbsp; | &nbsp;&nbsp;

                                     <a href="<?php echo base_url(); ?>index.php/ControllerForRevenueUpdate/SelectLocationsDag" class="btn btn-sm btn-info"><i class='fa fa-link'></i>&nbsp;Click Here to Update Revenue of a Particular Village Dag</a>

                                    <?php }?>
                                </div>
                            </div>
                        </form>
                        <hr style="border-bottom: 2px solid #000;">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

