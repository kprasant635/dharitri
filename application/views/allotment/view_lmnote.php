<?php
    ///////////// BARAK VALLEY CODE START HERE ////////////////
    $barak = in_array($this->session->userdata('dist_code'),json_decode(BARAK_VALLEY));
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-info">
                <form class="form-horizontal unicode" >              
                    <div class='panel-body'>
                        <h4 class="center red "><u>LM Report</u></h4>
						<hr>
                        <?php //var_dump($aloteelm);?>
                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-7 control-label ">Whether Allotment certificate is checked and found ok ?</label>
                            <div class="col-lg-2">
                                <?php if (($aloteelm->certificate_ok_not) == 'Y') { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="allotte_k"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="allotte_k"  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                    <?php
                                } else {
                                    ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="allotte_k"  value="Y" >
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="allotte_k"  value="N" checked="">
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-7 control-label ">Whether Applicant is the allottee or legal heir of original allottee ?  </label>

                            <div class="col-lg-5">
                                <?php if (($aloteelm->original_alotee) == 'Y') { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="original_alotee"  value="Y" checked="">
                                        Original Allottee
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="original_alotee"  value="N" >
                                        Legal heir of original allottee
                                    </label>
                                <?php } else { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="original_alotee"  value="Y" >
                                        Original Allottee
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="original_alotee" checked="" value="N" >
                                        Legal heir of original allottee
                                    </label>
                                <?php } ?>
                            </div>

                        </div>
						<div class="form-group ">    
                                <label for="inputEmail" class="col-lg-7 control-label ">Whether Allotment is a recorded tenant ?  </label>
                                <div class="col-lg-2">
									<?php if (($aloteelm->recorded_tenant) == 'Y') { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="allotte_rec" checked value="Y" >
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="allotte_rec"  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                <?php } else { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="allotte_rec"  value="Y" >
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="allotte_rec" checked  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                <?php } ?>
                                    
                                </div>
                                 
						</div>
                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-7 control-label ">Whether under possesion of the applicant ? </label>
                            <div class="col-lg-2">
                                <?php if (($aloteelm->under_possesion) == 'Y') { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="posession_y"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="posession_y"  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                <?php } else { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="posession_y"  value="Y" >
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="posession_y"  value="N" checked="" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                <?php } ?>
                            </div>

                        </div>
                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-7 control-label ">Period of possesion since </label>
                            <div class="col-lg-2">
                                <input type="text" name="p_year" value="<?php echo $aloteelm->under_possesion_yr; ?>" class="form-control " > From which Year
                            </div>

                        </div>
                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-7 required control-label ">Nature of Land Use </label>
                            <div class="col-lg-3">
                                <input class='form-control' name='land_use' value='<?php echo $aloteelm->nature_land; ?>' />

                            </div>
                        </div>
                        <div class="form-group hide">    
                            <label for="inputEmail" class="col-lg-7 control-label ">Whether the allotted area applied for PP falls within 3 KM radius of Town </label>
                            <div class="col-lg-2">
                                <?php if ($aloteelm->three_km_radius == 'Y') { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="three_km"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="three_km"  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                <?php } else { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="three_km"  value="Y" >
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="three_km" checked="" value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                <?php } ?>
                            </div>

                        </div>
                        <div class="form-group hide">    
                            <label for="inputEmail" class="col-lg-7 control-label ">Whether the allotted area applied for PP falls within 10 KM radius of GMC </label>
                            <div class="col-lg-2">
                                <?php if ($aloteelm->ten_km_radius == 'Y') { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="three_km"  value="Y" checked="">
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="three_km"  value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                <?php } else { ?>
                                    <label class="radio-inline">
                                        <input type="radio" name="three_km"  value="Y" >
                                        <?php echo $this->lang->line('consent_yes'); ?>
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="three_km" checked="" value="N" >
                                        <?php echo $this->lang->line('consent_no'); ?>
                                    </label>
                                <?php } ?>
                            </div>

                        </div>
                        <?php
                            ///////////// BARAK VALLEY CODE START HERE ////////////////
                            if($barak){
                        ?>
                            <div class="form-group ">    
                                <label for="inputEmail" class="col-lg-3 required control-label ">Area of Land found under possesion </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" placeholder='Bigha' name="p_bigha" required="" value="<?php echo $aloteelm->area_posession_b; ?>" >
                                    Bigha
                                </div>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" placeholder='Katha' name="p_katha" required="" value="<?php echo $aloteelm->area_posession_k; ?>" >
                                    Katha
                                </div>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" placeholder='Chatak' name="p_lessa" required="" value="<?php echo $aloteelm->area_posession_lc; ?>" >
                                    Chatak
                                </div>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" placeholder='Ganda' name="p_lessa" required="" value="<?php echo $aloteelm->area_posession_g; ?>" >
                                    Ganda
                                </div>
                            </div>
                        <?php } else { ?>
                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-5 required control-label ">Area of Land found under possesion </label>
                            <div class="col-lg-2">
                                <input type="text"  class="form-control" placeholder='Bigha' name="p_bigha" required="" value="<?php echo $aloteelm->area_posession_b; ?>" >
                                Bigha
                            </div>
                            <div class="col-lg-2">
                                <input type="text"  class="form-control" placeholder='Katha' name="p_katha" required="" value="<?php echo $aloteelm->area_posession_k; ?>" >
                                Katha
                            </div>
                            <div class="col-lg-2">
                                <input type="text"  class="form-control" placeholder='Lessa' name="p_lessa" required="" value="<?php echo $aloteelm->area_posession_lc; ?>" >
                                Lessa
                            </div>

                        </div><?php }?>
                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-3 red control-label ">New Dag Proposed </label>
                            <div class="col-lg-2">
                                <input type="text"  class="form-control" placeholder='Dag Number' value='<?php echo $aloteelm->new_dag; ?>' >
                            </div>
                            <label for="inputEmail" class="col-lg-4 red control-label ">New Periodic Patta Proposed </label>
                            <div class="col-lg-2">
                                <input type="text"  class="form-control" value='<?php echo $aloteelm->new_patta; ?>' >
                            </div>
                        </div>
                        <div class="form-group hide">    
                            <label for="inputEmail" class="col-lg-3  control-label ">Existing Dag </label>
                            <div class="col-lg-2">
                                <select class="form-control">
                                    <?php foreach ($dag_patta as $d) { ?>
                                        <option><?php echo $d->dag_no; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label for="inputEmail" class="col-lg-4 control-label ">Existing Patta</label>
                            <div class="col-lg-2">
                                <select class="form-control">
                                    <?php foreach ($dag_patta as $d) { ?>
                                        <option><?php echo $d->patta_no; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
						<div class="form-group ">    
                                <label for="inputEmail" class="col-lg-3 required control-label ">Existing TB Revenue </label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" placeholder='Amount' name="exist_revenue" required="" value="<?=$aloteelm->old_rev?>" >
                                </div>
								<label for="inputEmail" class="col-lg-4 required control-label ">Existing Local Tax</label>
                                <div class="col-lg-2">
                                    <input type="text"  class="form-control" placeholder='Amount' name="exist_local_tax" required="" value="<?=$aloteelm->old_lc?>" >
                                </div>
						</div>
                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-3 required control-label ">Proposed Land Revenue </label>
                            <div class="col-lg-2">
                                <input type="text"  class="form-control" placeholder='Amount' name="revenue" required="" value="<?php echo $aloteelm->l_rev; ?>" >
                            </div>
                            <label for="inputEmail" class="col-lg-4 required control-label ">Proposed Local Tax</label>
                            <div class="col-lg-2">
                                <input type="text"  class="form-control" placeholder='Amount' name="local_tax" required="" value="<?php echo $aloteelm->l_tax; ?>">
                            </div>
                        </div>
                        <?php
                            ///////////// BARAK VALLEY CODE START HERE ////////////////
                            if($barak){
                        ?>
                            <div class="form-group center alert alert-info">
                                <?php 
                                    if($aloteelm->area_fall_under=='ru'){    
                                        echo "i. কথিত মাটি গ্রামীণ এলাকার মাটি ?" ." ঠিক | এই মামলার প্রিমিয়ামের প্রয়োজন নেই |";
                                    }else if($aloteelm->area_fall_under=='rv'){
                                        echo "ii. উল্লিখিত ভূমি রাজস্ব শহর এবং এর প্রান্তিক এলাকা কি জমি? ?" . " ঠিক | এই মামলার প্রিমিয়ামের প্রয়োজন নেই |";
                                    }else if($aloteelm->area_fall_under=='hq'){
                                        echo "iii. হেড কোয়ার্টার, উত্তর গুয়াহাটি, রঙ্গিয়া এবং পলাশবাড়ি শহর ব্যতীত জেলার উল্লিখিত জমির এলাকা কি ?" . " ঠিক | এই মামলার প্রিমিয়ামের প্রয়োজন নেই |";
                                    }else if($aloteelm->area_fall_under=='ot'){
                                        echo "<span class='alert alert-danger'> iv. অন্য বিকল্পটি এই শর্তে নেই " . " ঠিক | এই মামলার প্রিমিয়াম প্রয়োজন</span>";
                                    }
                                ?>
                            </div>
                        <?php } else { ?>
                        <div class="form-group center alert alert-info">
                                <?php 
                                if($aloteelm->area_fall_under=='ru'){    
                                    echo "i. উক্ত মাটি গ্ৰাম্য এলেকা মাটি হয়নে ?" ." হয় | এই কেছটোৰ বাবে প্রিমিয়ামৰ প্ৰয়োজন নাই |";
                                }else if($aloteelm->area_fall_under=='rv'){
                                    echo "ii. উক্ত মাটি ৰাজহ নগৰ আৰু ইয়াৰ প্ৰান্তীয় এলেকা মাটি হয়নে ?" . " হয় | এই কেছটোৰ বাবে প্রিমিয়ামৰ প্ৰয়োজন নাই |";
                                }else if($aloteelm->area_fall_under=='hq'){
                                    echo "iii. উক্ত মাটি জিলাৰ মুৰব্বী কোৱাৰ্টাৰ, উত্তৰ গুৱাহাটী, ৰঙিয়া আৰু পলাশবাৰী চহৰৰ বাহিৰে আন চহৰবোৰৰ পৰিধি অঞ্চল মাটি হয়নে ?" . " হয় | এই কেছটোৰ বাবে প্রিমিয়ামৰ প্ৰয়োজন নাই |";
                                }else if($aloteelm->area_fall_under=='ot'){
                                    echo "<span class='alert alert-danger'> iv. আনবিকল্প বিকল্প এই চৰ্তত নাই " . " হয় | এই কেছটোৰ বাবে প্রিমিয়ামৰ প্ৰয়োজন আছে</span>";
                                }
                                ?>
                        </div>
                    <?php }?>
                        <div class="form-group ">    
                            <label for="inputEmail" class="col-lg-2 required control-label ">Comment </label>
                            <div class="col-lg-10">
                                <textarea class="form-control" rows=5 placeholder='Type here' name="lm_comment" required="" value="" ><?php echo $aloteelm->lm_comment; ?></textarea>
                            </div>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $('#BackHome').click(function () {
        location.href = "<?php echo base_url(); ?>index.php/home";
    });
</script>