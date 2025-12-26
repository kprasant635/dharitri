<div class="adc-attached bs-callout bs-callout-danger">
    <strong class="bg bg-info">List Of Lot(s)</strong> <code>(Map User for which Lot(s) he is going to work)</code>
    <div class="" style="padding:20px">
       <p>Selected CO Name: <?=$coname->username?></p>
       <table class="table">
          <thead>
            <th>Sl No</th>
            <th>Location(Mouza Name-Lot Name)</th>
            <th>Action</th>
          </thead>
        <?php $i=1; foreach($dist_head as $disthead) {
          $checkVal  = $disthead['checked'] == 'y' ? 'checked' : ''
          ?>
          <tbody>
            <td><?=$i++?></td>
            <td><?=$disthead['mapping']?></td>
            <td><input  type="checkbox" <?=$checkVal;?> name="allot_lot[]" value="<?=$disthead['loc']?>"></td>
          </tbody>
        <?php } ?>
        </table>
        </div>
    </div>
    </div>