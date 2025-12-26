<td valign="top" height="409" id=chitha_col_7 width="15%"><!--PATTADAR-->
<?php $count=1;?>
    <?php foreach ($chithainf['pattadars'] as $p): ?>
        
        
        <?php if (($p['new_pdar_name'] == 'N') && ($p['p_flag']=='1')): ?>
            <strike><p style="color:red">  <?php echo utf8_encode($count++).")";?><?php echo $p['pdar_name']; ?></p>
                <p style="color:red;font-style: italic">( <?php echo $this->utilityclass->get_relation($p['pdar_relation'])." ". $p['pdar_father']; ?>)</p></strike>
        <?php elseif (($p['new_pdar_name']) == 'N'  && ($p['p_flag']==null)): ?>
            <p style="color:red;font-style: italic">  <?php echo $count++.")";?><?php echo $p['pdar_name']; ?></p>
            <p style="color:red;font-style: italic">( <?php echo $this->utilityclass->get_relation($p['pdar_relation'])." ". $p['pdar_father']; ?>)</p>
       <?php elseif (($p['new_pdar_name'] == null) && ($p['p_flag']=='1')): ?>
            <strike><p style="color:red;font-style: italic">  <?php echo $count++.")";?><?php echo $p['pdar_name']; ?></p>
                <p style="color:red">( <?php echo $this->utilityclass->get_relation($p['pdar_relation'])." ". $p['pdar_father']; ?>)</p></strike>
         <?php elseif ($p['new_pdar_name'] == 'N'): ?>
            <p style="color:red;font-style: italic">  <?php echo $count++.")";?><?php echo $p['pdar_name']; ?></p>
            <p style="color:red;font-style: italic">( <?php echo $this->utilityclass->get_relation($p['pdar_relation'])." ". $p['pdar_father']; ?>)</p>
      
        <?php elseif ($p['new_pdar_name'] != 'N'): ?>
            <p style="color:blue">  <?php echo $count++.")";?><?php echo $p['pdar_name']; ?></p>
            <p style="color:blue">( <?php echo $this->utilityclass->get_relation($p['pdar_relation'])." ". $p['pdar_father']; ?>)</p>
        <?php endif; ?>
            <p>ঠিকনা (<?php echo $p['pdar_address1'].", ".$p['pdar_address2'];?>)</p>
           
    <?php endforeach; ?>
</td>