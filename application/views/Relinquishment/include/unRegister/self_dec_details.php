<div class="tableCard">
    <table class="table table-bordered">
        <?php foreach ($selfDeclarationDetails[0] as $key => $self) { ?>
            <tr>
                <th><?=$self->name?></th>
                <td>
                    <strong>
                        <?php if ($self->status == "1") {echo "Yes";}?>
                        <?php if ($self->status == "0") {echo "No";}?>
                    </strong>
                </td>
            </tr>
        <?php }?>
    </table>
</div>