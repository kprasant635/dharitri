<style>
    hr{
        margin: 2px 0 !important;
        padding: 2px 0 !important;
    }
    label{
        font-size: 1em !important;
        font-weight: normal;
        text-transform: capitalize
    }
</style>
<div class="container-fluid login form-top">
    <div class="row">
        <div class="col-lg-10 col-lg-offset-1">
            <div class="panel panel-info panel-form">
                <div class="panel-heading">
                    <h3 class="panel-title">Details Of Patta No <kbd><?=$this->session->userdata('patta_no')?></kbd></h3>
                </div>
				<p class='uni_text red'> Select the checkbox you want to remove dag(s). It will remove from patta only. Please check hand Chitha & Jamabandi Copy before applying</p>
                <div class="panel-body">
                    <a class="btn btn-danger" href="<?php echo base_url();?>index.php/jamaeditentry/displaybasic/<?php echo $this->session->userdata('patta_no');?>/<?php echo $this->session->userdata('patta_type_code');?>">Jamabandi Home</a>
                    <hr>
					<form method='post' enctype="multipart/form-data">
                    <table class="table table-striped table-bordered table-dark">
                        <tr class='center' >
                            <td>Dag No</td>
                            <td>Land Class Code</td>
                            <td colspan="3">Area</td>
                            <td>Revenue</td>
                            <td>Local Tax</td>
                            <td>Action</td>
                        </tr>
                        <tr class='center'>
                            <td></td>
                            <td></td>
                            <td >Bigha</td>
                            <td >Katha</td>
                            <td >Lessa</td>
                            <td>(in Rs/-)</td>
                            <td>(in Rs/-)</td>
							<td></td>
                        </tr>
                        <?php foreach ($dags as $key => $value): ?>
                            <tr class='center'>
                                <td class='active'><?php echo $value->dag_no; ?><br>
								</td>
                                <td>
                                    <?php echo $this->utilityclass->getLandClassCode($value->dag_class_code); ?>
                                </td>
                                <td><?php echo $value->dag_area_b; ?></td>
                                <td><?php echo $value->dag_area_k; ?></td>
                                <td><?php echo $value->dag_area_lc; ?></td>
                                <td><?php echo number_format($value->dag_revenue,2) ; ?></td>
                                <td><?php echo number_format($value->dag_localtax,2); ?></td>
                                <td>
									<input type='checkbox' class="termsChkbx" value="<?=$value->dag_no;?>" name='dagsremove[]' />
									<input type='hidden' value="1" name='remove' />
                                </td>
                            </tr>	
                        <?php endforeach; ?>
                    </table>
					<hr>
					<div class="col-sm-12">
					<p><mark>Lot Mondal's Note On Action</mark></p>
                        <div class="form-group">
                                <div class="col-sm-12">
                                    <textarea name="lm_note" class="form-control" rows="5">আবেদনকাৰীয়ে জমাবন্দীত উপৰত দিয়া অনুসৰি লিগেচী তথ্যৰ সংশোধনী বিচাৰিছে | উপৰোক্ত সংশোধন কেইটা কৰা হল আৰু চক্ৰ বিষয়াৰ অনুমোদনৰ বাবে দিয়া হল ৷ </textarea>
                                </div>
                        </div>
					<hr>
					</div>
					<div class="form-group">
						<label for="inputEmail3" class="col-sm-4 control-label">Upload Hand Chitha/Jama Scan Copy</label>
						<div class="col-sm-4">
							<div class="btn btn-primary btn-sm float-left">
								<input type="file" name="file_upload" id="fileupload" required="">
							</div>
						</div>
						<span>Only jpg,jpeg,png,doc,docx,pdf,txt type files are allowed</span>
                    </div>	
                    <hr>
					<center><input type='submit' id='sub1' disabled="disabled" name='submit' class='btn btn-primary' /></center>
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function(){
    $('.termsChkbx').click(function() {
        if ($(this).is(':checked')) {
            $('#sub1').removeAttr('disabled');
        } else {
            $('#sub1').attr('disabled', 'disabled');
        }
    });
});
</script>