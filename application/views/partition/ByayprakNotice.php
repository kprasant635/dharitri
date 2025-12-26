<div class="container-fluid form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <p class="uni_text center">অসম চৰকাৰ </p>
            <p class="uni_text center">চক্র বিষয়াৰ কাৰ্য্যালয় ,<?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')) ?> </p>
            <div class="col-lg-12" style="margin-top: 30px">
                <p class="uni_text">
                    বাটোৱাৰা গোচৰ নং <?php echo $case->case;?> ৰ আবেদন অনুসৰি সকলো আবেদনকাৰী আৰু সহ-পট্টাদাৰ সকলক নিম্নোলিখিত খৰচ জমা দিবলৈ জাননী জাৰী কৰা হল |
                </p>
                <p class="uni_text" style="margin-top: 20px">
                    ১ . আবেদনকাৰী <?php //echo $this->lang->line('applicants_name')?>:- 
                    <?php
                    //var_dump($byayprak);
                    ?>
                       <?php echo $byayprak->pet_name_add_por;  ?> 
                   
                    দিবলগীয়া খৰচৰ পৰিমাণ <?php echo $this->utilityclass->cassnum(number_format($byayprak->exp_details_total,2)) ; ?> টকা 
                </p>
                <p class="uni_text">
                    ২. সহ-পট্টাদাৰ <?php //echo $this->lang->line('all_copattadar')?> :-
                    <?php echo $byayprak->pdar_name_add ; ?>
                    দিবলগীয়া খৰচৰ পৰিমাণ <?php echo $this->utilityclass->cassnum(number_format($byayprak->copdar_amt_total,2)); ?> টকা 
                </p>
                <div class="col-lg-12" style="margin-top: 50px">
                    <div class="col-lg-4">
                        <p class="uni_text"><?php echo $this->lang->line('date')?> : <?php echo $this->utilityclass->cassnum(date('d-m-Y',strtotime($byayprak->date_entry)));?></p>
                    </div>
                     <div class="col-lg-3 pull-right">
                        <p class="uni_text center">চক্র বিষয়া<?php //echo $this->lang->line('circle_officer')?></p>
                        <p class="uni_text center"><?php echo $this->utilityclass->getCircleName($this->session->userdata('dist_code'),$this->session->userdata('subdiv_code'),$this->session->userdata('cir_code')) ?> , ৰাজহ চক্র <?php //echo $this->lang->line('revenue_circle');?></p>
                    </div>
                    
                </div>
            </div>
            <hr>
			<div class='dontshow'>
			
			<center><button id="mainMenu" disabled class="btn btn-primary " onclick="Redirect();" style=" margin-bottom: 20px " ><?php echo $this->lang->line('back_to_home');?></button> </center>
			<center><button class='btn btn-danger' onclick="myFunction()">Print this page</button> </center>
			</div>
            <div class="btn btn-primary hide col-lg-offset-4 uni_text" ><i class='fa fa-check'></i>&nbsp;<?php echo $this->lang->line('submit_print');?></div>
        </div>
    </div>
</div>
      <script type="text/javascript">
            function Redirect() {
               window.location="<?php echo base_url();?>index.php/home/index";
            }
        
      </script>
	  <script>
    function myFunction() {
		$(".dontshow").hide();
        window.print();
		$(".dontshow").show();
		document.getElementById("mainMenu").disabled = false;
		}
 </script>