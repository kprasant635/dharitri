<?php if($proceedings){ ?>
    <div class="tableCard" style="margin-top: 20px">
        <table class="table table-bordered">
            <tr>
                <th style="width: 200px">Remark Date</th>
                <th style="width: 200px">Remark Time</th>
                <th style="width: 200px">Remark from</th>
                <th>Remark</th>
            </tr>
            <?php foreach($proceedings as $pro):  ?>
                <tr>
                    <td>
                        <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;
                        <?= date ("d-M-Y",strtotime($pro->date_entry)) ?>
                    </td>
                    <td style="text-transform: uppercase">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>&nbsp;
                        <?= date ("h:i a",strtotime($pro->date_entry)) ?>
                    </td>
                    <td>
                        <i class="fa fa-user" aria-hidden="true"></i>&nbsp;
                        <?=$pro->office_from;?>
                    </td>
                    <td><?=$pro->note_on_order;?></span></td>
                </tr>
            <?php endforeach;?>
        </table>
    </div>
    <br><br>
<?php } ?>