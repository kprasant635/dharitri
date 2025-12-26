<th>Zone</th>
<th width="12%">Escalate On

	<select class="form-control input_search" name="zone_status" id="zone_status">
      <option value="">--Select--</option>
      <?php foreach(ESCALATION_ZONE as $row) { 
        $bgcol = '';
        if($row['CODE'] == '1'){ $col = "green";  }
        if($row['CODE'] == '2'){ $col = "orange"; }
        if($row['CODE'] == '3'){ $col = "red";    }
        if($row['CODE'] == '4'){ $col = "black";  }
      ?>
        <option value="<?=$row['CODE']?>" style="color:<?=$col?>; font-weight: bold;"><?=$row['NAME']?></option>
      <?php } ?>     
    </select>

</th>
<!-- 
<script type="text/javascript">
  
  $(document).on('change', '#zone_status', function(){
    
  });
</script> -->