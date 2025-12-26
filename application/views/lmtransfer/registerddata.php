<div class="panel panel-info">
    <table class="table table-striped">
      <thead>
        <tr>
          <td>Name</td>
          <td>Appointment Order</td>
          <td>Date</td>
          <td>DOA</td>
          <td>DOS</td>
          <td>Prefernece</td>
          <td>Place</td>
          <td>Acknowledgement</td>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td><?=$result['full_name']?></td>
          <td><a target="_blank" href="<?php echo base_url()?>index.php/LmstateCadreTransfer/downloadAppointment/<?=$result['tid']?>">View </a></td>
          <td><?=$result['date_entry']?></td>
          <td><?=$result['doa']?></td>
          <td><?=$result['dos']?></td>
          <td>
            1.<?=$result['prefernece_1']?><br>
            2.<?=$result['prefernece_2']?><br>
            3.<?=$result['prefernece_3']?>
          </td>
          <td>
            District: <?=$result['pp_dist']?><br>
            Circle: <?=$result['pp_circle']?><br>
          </td>
          <td><a target="_blank" href="<?php echo base_url()?>index.php/LmstateCadreTransfer/downloadAcknowledgement/<?=$result['tid']?>">Download </a></td>
          
        </tr>
      </tbody>
    </table>
</div>
