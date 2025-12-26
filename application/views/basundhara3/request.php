<center>
    
  <mark>Application Received in Basundhara 3.0</mark>      
  <br>
  <mark>
    <strong style="font-size: 20px;">
      <?php
        if($service == RECLASS_ID)
        {
          echo RECLASS_SERVICE_NAME;
        }
      ?>
    </strong>
  </mark>    
</center>

<table class="datatable table table-stripped" id='datatable'>
    <thead style="font-size:7px">
        <tr>
            <th></th>
            <th></th>
            <th>Occupation
        <select name="occupation" id="occupation" class="form-control input_search" data-column-index="2">
          <option value="">Select</option>
          <option value="SERVICE">SERVICE</option>
          <option value="PRIVSERV">PRIVSERV</option>
          <option value="BUSINESS">BUSINESS</option>
          <option value="PENSIONER">PENSIONER</option>
          <option value="AGRICULTURE">AGRICULTURE</option>
          <option value="HOUSEWIFE">HOUSEWIFE</option>
          <option value="UNEMPLOYED">UNEMPLOYED</option>
        </select>
      </th>
      <th>Applied for</th>
      <th>Flagged in Chitha</th>
            <th>Urban/Rural
        <select class="form-control input_search" name="rural" id="rural" 
          data-column-index="3">
          <option value="">select</option>
          <?php if(isset($selectList->urban_check)){ foreach($selectList->urban_check as $rural){
              ?>
            <option value="<?=$rural->is_urban?>"><?php if($rural->is_urban == 'Y'){echo 'Urban';}else{echo "Rural";}?></option>
          <?php }}?>
        </select>
      </th>
            <th>Name 
        <select class="form-control input_search" name="category" id="category" data-column-index="4">
          <option value="">select</option>
          <?php if(isset($selectList->vill_list)){ foreach($selectList->vill_list as $vill){
              ?>
            <option value="<?=$vill->village_code?>"><?=$this->utilityclass->getVillageName($vill->dist_code, $vill->subdiv_code, $vill->cir_code, $vill->mouza_code, $vill->lot_no, $vill->village_code)?></option>
          <?php }}?>
        </select>
      </th>
            <th>
        <button type="button" class="search_button btn btn-sm btn-success form-control">
          <i class="fa fa-search" aria-hidden="true"></i>Search</button>
      </th>
        </tr>
    </thead>
    <tbody>

    </tbody>
</table>

<style>
  .dataTables_wrapper .dataTables_filter 
  {
    float: right;
    text-align: right;
    visibility: hidden;
  }
 </style>

<script>
  $(document).ready(function ()
  {
    $('#rural, #category, #occupation').change(function()
    {
      var rural = $('#rural').val();
      var category = $('#category').val();
      var occupation = $('#occupation').val();
      $('#datatable').DataTable().destroy();
      load_data(category,rural,occupation);
    });

    load_data();

    function load_data(category,rural,occupation)
    {
      var base_url     = "<?php echo base_url();?>";
      var service_code = <?=$service?>;

      $('#datatable thead th:nth-of-type(1)').each(function () 
      {
        var title = 'Application No';
        $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="0" />');
      });

      $('#datatable thead th:nth-of-type(2)').each(function () 
      {
        var title = 'Application Date';
        $(this).html('<input type="text" class="input_search form-control form-control-sm" placeholder="Search ' + title + '" data-column-index="1" />');
      });
        
      var table = $('#datatable').DataTable({
        'pageLength': 10,
        "processing": true,
        "serverSide": true,
        "ordering"  : false,
        "lengthMenu": [[5, 10, 20, 50, 100], [5, 10, 20, 50, 100]],
        'language'  : {
                        "processing": '<i class="fa fa-spinner fa-spin" style="font-size:24px;color:rgb(75, 183, 245);"></i>'
                      },
        'ajax':{
          url : base_url+'index.php/SettlementMB3Common/paginationAPI',
          type:'POST',
          data: {
            service     : service_code,
            is_category : category,
            rural       : rural,
            occupation  : occupation,
          },
          deferLoading  : 57,
        },
        order           : [[2, 'asc']],
        columnDefs      : [{
            targets     : "_all",
            orderable   : false,
            "className" : "dt-center", "targets":[ 0, 1, 2, 3, 4, 5, 6],
        }],              
      });

      // button search
      $('.search_button').on('click', function () {            
        $('table thead tr th .input_search').each(function(){ 
          table.column($(this).data('columnIndex')).search(this.value);
        });
        table.draw();
      });
    }      
  });

</script>
 