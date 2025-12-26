<div id="displayBox" style="display: none;"><img src="<?= base_url(); ?>/assets/process.gif" style="width: 80px;"></div>
<style>
.center {
  text-align: center;
}

.pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid #ddd;
  margin: 0 4px;
}

.pagination a.active {
  background-color: #4CAF50;
  color: white;
  border: 1px solid #4CAF50;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
</style>
<center><mark>Application Rejected Information </mark></center>

<!---------12-04-22, filteration starts here-------->
<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">&nbsp;</div>

<div class="col-md-3 col-sm-6 col-xs-12">
	<div class="info-box bg-red">
		<span class="info-box-icon"><i class="fa fa-file-archive-o"></i></span>
		<div class="info-box-content">
			<span class="info-box-text">Received</span>
			<span class="info-box-number"><kbd id='circle'><?=$total_adc_received?></kbd></span>
		</div>
	</div>
</div>
<div class="col-md-3 col-sm-6 col-xs-12">
	<div class="info-box bg-blue">
		<span class="info-box-icon"><i class="fa fa-file-archive-o"></i></span>
		<div class="info-box-content">
			<span class="info-box-text">Pending</span>
			<span class="info-box-number"><kbd id='circle'><?=$adc_pending?></kbd></span>
		</div>
	</div>
</div>
<div class="col-md-3 col-sm-6 col-xs-12">
	<div class="info-box bg-green">
		<span class="info-box-icon"><i class="fa fa-file-archive-o"></i></span>
		<div class="info-box-content">
			<span class="info-box-text">Approved</span>
			<span class="info-box-number"><kbd id='circle'><?=$adc_revived?></kbd></span>
		</div>
	</div>
</div>
<div class="col-md-3 col-sm-6 col-xs-12">
	<div class="info-box bg-purple">
		<span class="info-box-icon"><i class="fa fa-file-archive-o"></i></span>
		<div class="info-box-content">
			<span class="info-box-text">Final Rejection</span>
			<span class="info-box-number"><kbd id='circle'><?=$adc_rejected?></kbd></span>
		</div>
	</div>
</div>


<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
	<h4>Filter your data</h4><hr>
</div>
<div class="col-lg-12">
	<div class="panel panel-body panel-primary">
	<form class="form-horizontal" id="display_search_order" method="post" >
		<div class="col-md-3 col-lg-3 col-sm-4 col-xs-12">
			<label>Circle</label>
	        <select style="border: 1px solid #000;" class="form-control" 
	        name="cirle_list" id="cirle_list">
	            <option selected disabled value="">Select Circle</option>
	            <option value="All" selected>All</option>
	            <?php foreach($circleList as $r) : ?>
	            	<option value="<?=$r->subdiv_code.','.$r->cir_code?>"><?=$r->loc_name?></option>
	            <?php endforeach;?>
	        </select>
	    </div>
	    <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12">
	    	<label>Status</label>
	        <select style="border: 1px solid #000;" class="form-control" 
	        name="appl_status" id="appl_status">
	            <option disabled>Select Application Status</option>
	            <option value="<?=All_application?>" selected>ALL</option>
	            <option value="<?=Pending_with_ADC?>">Pending with ADC</option>
	            <option value="<?=ADC_has_Approved?>">ADC has Approved</option>
	            <option value="<?=ADC_has_Rejected?>">ADC has Rejected</option>
	        </select>
	    </div>
	    <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12">
	    	<label>Page Size</label>
	        <select style="border: 1px solid #000;" class="form-control" 
	        name="page_size" id="page_size">
	        	<?php
	        		$limit = PAGE_LIMIT;
	        		$start = 0;
	        		$end = PAGE_LIMIT;
	        		$tot = ceil($total_adc_received/$limit);
	        		for($index=1; $index <= $tot; $index++){
	        			if($index==1){
	        				$start = 0;	
	        				$end = $end;	
	        			}
	        			else {
	        				$start = $end + 1;
	        				$end = $end + $limit;
	        			}
	        			echo "<option value='".($index-1)."'>".$start.'-'.$end."</option>";
	        		}
				?>
	        </select>
	    </div>
	    <div class="col-md-3 col-lg-3 col-sm-4 col-xs-12"><br>
	    	<button type="submit" class="btn btn-sm btn-success btnFilter">Filter your Search</button>
	        <input type="hidden" value="<?=$service_code?>" id="service_code">
	    </div>
	</form>
  </div>
	<div class="col-md-12 col-lg-12 col-sm-12 col-xs-12">&nbsp;</div>
	<div class="panel panel-body panel-info">
	<form class="form-horizontal" id="display_search_order_by_case_no" method="post" >
		<div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
			<label><span class="text-blue">Search By Case No</span></label>
	    </div>
	    <div class="col-md-6 col-lg-6 col-sm-6 col-xs-12">
	    	<input type="text" name="application_no" value="" class="form-control"
	    	placeholder="Enter Case No here" id="application_no">
	    	<div id="appl_error"></div>
	    </div>
	    <div class="col-md-3 col-lg-3 col-sm-3 col-xs-12">
	    	<button type="submit" class="btn btn-sm btn-primary btnFilterByCaseNo">Search</button>
	        <input type="hidden" value="<?=$service_code?>" id="service_code">
	    </div>
	</form>
  </div>
	<div class="col-lg-12 col-md-12 col-xs-12 col-sm-12">&nbsp;</div>
</div>
<!---------12-04-22, filteration ends here-------->

<table class="table" id='dataTable1'>
	<thead>
	<tr>
		<th width="12%">Application No</th>
		<th width="10%">Application Date</th>
		<th width="12%"><?=(($service_code==1)?'Circle Name':'Village Name')?></th>
		<th width="25%">Query</th>
		<th width="15%">Action</th>
	</tr>
</thead>
<tbody id="tbl_rejected_list">
</tbody>
</table>
<div id="myModal1" class="modal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        </div>
    </div>
</div>
<!--  -->
<script src="<?php echo base_url(); ?>application/views/js/blockUI.js"></script>
<script type="text/javascript">
	// $(function () {
 //        $('.lmreportmut').click(function (e) {
 //            e.preventDefault();
 //            $.ajax({
 //                url: $(this).attr('href'),
 //                success: function (data) {
 //                    $('.modal-content').html(data);
 //                    $('.modal').modal('show');
 //                    $('body').addClass('bodytest');
 //                }
 //            });
 //        });
 //    });

 	$(document).on('click', '.lmreportmut', function(){

 		
      e.preventDefault();
      $.ajax({
          url: $(this).attr('href'),
          success: function (data) {
              $('.modal-content').html(data);
              $('.modal').modal('show');
              $('body').addClass('bodytest');
          }
      });
  });


	$('#display_search_order').submit(function(e){
		$.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
		e.preventDefault();
		appl_status = $('#appl_status').val();
		service_code = $('#service_code').val();
		pOffset = $('#page_size').val();
		cirle_list = $('#cirle_list').val();
		
		if(cirle_list == 'All'){
			cir_code = cirle_list;
			data = {cir_code:cir_code, appl_status:appl_status, service_code:service_code, pOffset:pOffset}
		}
		else {
			arr = cirle_list.split(',');
			subdiv_code = arr[0];
			cir_code = arr[1];	

			data = {subdiv_code:subdiv_code, cir_code:cir_code, appl_status:appl_status, service_code:service_code, pOffset:pOffset}
		}
		$.ajax({
            url: baseurl + "basundhara/getOrderList/" +service_code ,
            type: 'POST',
            data: data,
            dataType: "json",
            success: function (data) 
            {
            	$.unblockUI();
            	if(data == ''){
            		$('#tbl_rejected_list').html("<span style='color:red; font-size:90%'>No Data Available</span>");	
            	}
            	else{
            		$('#tbl_rejected_list').html(data);	
            	}
            },
            error: function(data){
            	$.unblockUI();
                alert("Unable to Process");
            }
        });
	});
	$('#display_search_order_by_case_no').submit(function(e){
		$.blockUI({
            message: $('#displayBox'),
            css: {
                border:'none',
                backgroundColor:'transparent'
            }
        });
		e.preventDefault();
		application_no = $('#application_no').val();
		service_code = $('#service_code').val();		
		data = {application_no:application_no, service_code:service_code}

		$.ajax({
            url: baseurl + "basundhara/getOrderListByApplication/" +service_code ,
            type: 'POST',
            data: data,
            dataType: "json",
            success: function (data) 
            {
            	$.unblockUI();

            	console.log(data.msg);

            	if(data.msg != null){
            		$('#appl_error').html("<span style='color:red; font-size:100%'>"+data.msg+"</span>");
            	}


            	if(data == ''){
            		$('#tbl_rejected_list').html("<span style='color:red; font-size:100%'>No Data Available</span>");	
            	}
            	else{
            		$('#tbl_rejected_list').html(data);	
            	}
            },
            error: function(data){
            	$.unblockUI();
                alert("Unable to Process");
            }
        });
	});
</script>