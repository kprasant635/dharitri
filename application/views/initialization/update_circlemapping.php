<style type="text/css">
  .h4tagging{
    text-align: center;
    background: #ff681d;
    padding: 6px;
    color: #fff;
}
  }
</style>

<div class="adc-attached bs-callout bs-callout-danger">
    <div class="" style="padding:20px">
       <h4 class="h4tagging"> selected ADC Name: <?=$coname->username?><br>
         <b style="font-size: 14px;">(Map User for which Circle(s) he is going to work)</b>
       </h4>
       <table class="table">
          <thead>
            <th>Sl No</th>
            <th>Location(Subdivision Name-Circle Name)</th>
            <th>Action</th>
          </thead>
        <?php $i=1; foreach($dist_head as $disthead) {
          $checkVal  = $disthead['checked'] == 'y' ? 'checked' : ''
          ?>
          <tbody>
            <td><?=$i++?></td>
            <td><?=$disthead['mapping']?></td>
            <td><input  type="checkbox" <?=$checkVal;?> name="allot_circle[]" value="<?=$disthead['loc']?>"></td>
          </tbody>
        <?php } ?>
        </table>
        </div>
    </div>
    </div>