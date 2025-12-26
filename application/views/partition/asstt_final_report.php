<div class="contanier form-top" style=" margin-top: 10px ">
    <div class="col-lg-10 col-lg-offset-1" id="printdiv" style=" margin-bottom: 10px; background: #fff">
                <?php
				//var_dump($this->session->all_userdata());
				$db=  $this->session->userdata('db');
                $pattadar = $this->session->userdata('appdet');
                $dist_code=$this->session->userdata('dist_code');
                $subdiv_code=$this->session->userdata('subdiv_code');
                $cir_code=$this->session->userdata('cir_code');
                $mouza_pargona_code=$this->session->userdata('mouza_pargona_code');
                $vill_code=$this->session->userdata('vill_code');
                $lot_no=$this->session->userdata('lot_no');
                $dag_no=$this->session->userdata('dag_no');
                $patta_no=$this->session->userdata('patta_no');
                $patta_type=$this->session->userdata('patta_type_code');
                $location = $this->utilityclass->getLocationFromSession();
                $cir_name = $this->utilityclass->getCircleName($dist_code, $subdiv_code, $cir_code);
                foreach ($pattadar as $p) {
                        $pdar_id = $p['pdar_name'];
                        $q = "select p.pdar_id,p.pdar_name,p.pdar_father,p.pdar_guard_reln from  chitha_pattadar p join 
                         chitha_dag_pattadar d on p.dist_code = d.dist_code and p.subdiv_code = d.subdiv_code and p.cir_code = d.cir_code 
                        and p.lot_no = d.lot_no and p.vill_townprt_code = d.vill_townprt_code and p.mouza_pargona_code = d.mouza_pargona_code and
                        p.pdar_id = d.pdar_id where p.dist_code='$dist_code' and p.subdiv_code='$subdiv_code' and p.cir_code='$cir_code' and
                        p.mouza_pargona_code='$mouza_pargona_code' and p.vill_townprt_code='$vill_code' 
                        and d.lot_no='$lot_no' and d.dag_no='$dag_no' and trim(p.patta_no)=trim('$patta_no') 
                        and p.patta_type_code='$patta_type' and d.pdar_id='$pdar_id'";
                        $data = $this->db->query($q)->result();
                        //var_dump($data);
                ?>
        <h2 class="text-center uni_text ">অসম চৰকাৰ </h2> 
        <p class="text-center uni_text" style=" margin-top: -15px; margin-bottom: 20px">চক্র বিষয়াৰ কাৰ্য্যালয়  ,<?php echo $cir_name ?></p>
        <span class="report_txt uni_text">এই  আবেদন ১) <span class="text-info"><?php echo $data[0]->pdar_name; ?>  <?php echo  $this->utilityclass->get_relation($data[0]->pdar_guard_reln) ?>  <?php echo $data[0]->pdar_father; ?> </span>  ৰ পৰা গ্রহণ কৰা হ’ল । এই বাটোৱাৰা গোচৰ নং <?php  echo $this->session->userdata('case_no'); ?>  শুনানিৰ জাননী জাৰীকাৰকৰ হতুৱাই জাৰী কৰা হ’ৱ ।</span>
        <p class="uni_text">তাৰিখঃ  : <?php echo date('d/m/Y') ?> </p>
        <div class="pull-right" style="margin-top: 10px">
            <p class="text-center uni_text"> চক্র বিষয়া<br>
                <?php echo $cir_name ?>, ৰাজহ চক্র
            </p>
        </div>
       <hr>
        <div>
        <p class="text-center text-danger uni_text">(প্রথম পক্ষ একেৰাহে তিনিটা শুনানিত অনুপস্হিত থাকিলে গোচৰ খাৰিজ কৰা হ’ৱ )</p>
		
        </div>
        <?php
                }
        ?>
       <hr>
	   
        
    </div>
	<hr>
	<div class='dontshow'>
		<span class='small green text-center'>Case Has been Successfully Registered with the following  Case Number ##<?php  echo $this->session->userdata('case_no'); ?> </span>
		<center><button id="mainMenu" disabled class="btn btn-primary " style=" margin-bottom: 20px " >Click Here to Print Acknowledgement Report</button> </center>
    <center><button class='btn btn-danger' onclick="myFunction()">Print this page</button> </center>
	</div>
</div>
<script type="text/javascript">
     $(function(){
        $('#mainMenu').on('click',function(){
           window.location.href = "<?php echo base_url(); ?>index.php/Partition/applicant_receipet";
        });
       });

</script>
<script>
    function myFunction() {
		$(".dontshow").hide();
		
        window.print();
		$(".dontshow").show();
		document.getElementById("mainMenu").disabled = false;
		}
 </script>
   