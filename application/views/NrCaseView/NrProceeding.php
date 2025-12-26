<style>
    .dt-button {
        background-color: #00e676 !important;
        padding: 5px 20px !important;
        border-radius: 5px;
    }
body {
	background-color: hsl(0, 0%, 90%);
}

.row {
	padding-left: 10px;
	padding-right: 10px;
}
.card {
	/* regular */
	box-shadow: 0px 1px 4px 0 rgba(0, 0, 0, 0.14);
	border-radius: .375rem;
	z-index: -1 !important;
}


.card-wrapper {
	margin-top: 20px;
	/* margin-bottom: 40px; */
	display: flex;
	flex-direction: column;
}
.card-body {
	padding-top: 40px;
}

.card-label {
	/* background: linear-gradient(to bottom,  hsl(220, 65%, 25%), hsl(220, 65%, 20%)); */
	color: white;
	font-weight: 500;	
	border: none;
	outline: none;
	box-shadow: 0px 1px 4px 0 rgba(0, 0, 0, 0.14);
	border-radius: .375rem;
	display: inline-block;
	font-size: 1.1rem;
	margin-left: 10px;
		margin-right: auto;
	text-align: center;
	line-height: 2.5rem;
	margin-bottom: -25px;
	padding-left: 10px;
	padding-right: 10px;
}

.label-color1{
	background: linear-gradient(to bottom,  hsl(220, 65%, 25%), hsl(220, 65%, 20%));
}
.label-color2{
	background: linear-gradient(to right,  #2C3E50, #0575E6);
}.label-color3{
	background: linear-gradient(to right,  #0F2027, #203A43, #2C5364);
}.label-color4{
	background: linear-gradient(to right,  #56ab2f, #a8e063);
}




</style>

<div class="row">
    <div class="card-label label-color1 center mt-2 mb-2 align-items-center justify-content-center">Proceeding Details for case number : <?=$case_no?>  
        </div>


    <div class="col-12 col-md-12">
        <div class="card-wrapper">

      
                <table class="table">
                    <thead>
                    <tr>
                        <td width="20%">Designation</td>
                        <td width="30%">Remark</td>
                        <td width="20%">Date of Action</td>
                    </tr>
                    </thead>
                    <tbody>
                      <?php foreach($co_order as $case) {?>

                      <tr>
                          
                          <td width="50%"><small>CO</small></td>
                          <td width="50%"><small><?=$case->co_order?></small></td>
                          <td width="50%"><small><?=$case->date_entry?></small></td>
                      </tr>
                     <?php } ?>

                     <?php foreach($dc_order as $dccase) {?>

                      <tr>
                          
                          <td width="50%"><small>DC</small></td>
                          <td width="50%"><small><?=$dccase->dc_order?></small></td>
                          <td width="50%"><small><?=$dccase->dc_approval_date?></small></td>
                      </tr>
                      <?php } ?>
                    <!-- <tr>
                        
                        <td width="50%"><small>CO</small></td>
                        <td width="50%"><small>আবেদনকাৰীৰ আবেদন চোৱা হল । আবেদনকাৰীয়ে মাজুলী জিলাৰ কমলাবাৰী মৌজাৰ চিলাকলা কৈৰ্ৱত্ত গাঁওৰ 341 নং একচনা পট্টাৰ 341 নং দাগৰ “পট্টা ৰদ” বিচাৰিছে । সহায়কে অসম ৰাজহ আইনৰ ৫২ নং ধাৰা মতে উভয় পক্ষৰ ওপৰত জাননী জাৰি কৰাৰ ব্যৱস্হা ল'ব । 2021-02-11 তাৰিখ শুনানি আৰু আপত্তি দাখিলৰ বাবে ধাৰ্য্য কৰা হ'ল ।</small></td>
                        <td width="50%"><small>2021-02-05</small></td>
                    </tr>

                    <tr>
                        
                        <td width="50%"><small>CO</small></td>
                        <td width="50%"><small>যিহেতু সহায়কে মাজুলী জিলাৰ কমলাবাৰী মৌজাৰ চিলাকলা কৈৰ্ৱত্ত গাঁওৰ ৩৪১ নং একচনা পট্টাৰ ৩৪১ নং দাগৰ সকলো পট্টাদাৰক পট্টা ৰদ বাবে জাননী জাৰী কৰিছে, সেয়ে এই MAJ/MAJ/2020-21/6/NR/SM নং গোচৰটো উপায়ুক্ত মহোদয়ৰ অনুমোদনৰ বাবে প্রেৰণ কৰা হল ।</small></td>
                        <td width="50%"><small>2021-06-14</small></td>
                    </tr>

                   
                    

                    <tr>
                        
                        <td width="50%"><small>DC</small></td>
                        <td width="50%"><small>যিহেতু মাজুলী জিলাৰ কমলাবাৰী মৌজাৰ চিলাকলা কৈৰ্ৱত্ত গাঁওৰ 341 নং একচনা পট্টাৰ 341 নং দাগটো “পট্টা ৰদ” বাবে আবেদন কৰা এই MAJ/MAJ/2020-21/6/NR/SM নং গোচৰটো চক্ৰ বিষয়াই প্রস্তাৱ আগবঢ়াইছে জনাইছে, সেয়ে ইয়াৰ লগত সম্বন্ধ থকা সকলো নথি-পত্ৰ সঠিক হোৱা বাবে আজি 2021-09-30 তাৰিখত মই এই 341 নং দাগটো “পট্টা ৰদ” কৰাৰ বাবে অনুমোদন জনাইছো ।</small></td>
                        <td width="50%"><small>2021-09-30</small></td>
                    </tr> -->

                    

                    </tbody>
                </table>
                
        </div>
    </div>

    <!-- <div class="mb-2">
    <a href="<?php echo base_url()."assets/1440632/RTPS_1440632_MUTD_deed_doc_file.pdf"  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;Deed Copy</a>
    <a href="<?php echo base_url()."assets/1440632/RTPS_1440632_MUTD_lrr_doc_file.pdf"  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;Land Revenue Receipt Copy</a>
    <a href="<?php echo base_url()."assets/1440632/RTPS_1440632_MUTD_noc_doc_file.pdf"  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;NOC Copy</a>
    <a href="<?php echo base_url()."assets/1440632/RTPS_1440632_MUTD_self_declaration_doc_file.pdf"  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;Self Declaration Copy</a>
    </div>       -->      


    <!-- <div class="col-12 col-md-12">
        <div class="card-wrapper">
            <div class="card-label label-color3">
                Document Details
            </div>
            <div class="card" >
                <div class="card-body">
                <a href="<?php echo base_url()."assets/1440632/RTPS_1440632_MUTD_deed_doc_file.pdf"  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;Deed Copy</a>
                <a href="<?php echo base_url()."assets/1440632/RTPS_1440632_MUTD_deed_doc_file.pdf"  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;Deed Copy</a>
                <a href="<?php echo base_url()."assets/1440632/RTPS_1440632_MUTD_deed_doc_file.pdf"  ?>" class="red" target="_blank"><i class='fa fa-paperclip'></i>&nbsp;&nbsp;Deed Copy</a></li>
                                

                
                </div>
            </div>
        </div>
    </div> -->
</div>




