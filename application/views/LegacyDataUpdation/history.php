
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Date</th>
            <th>Note</th>
        </tr>
    </thead>
    <tbody>
        <?php if(count($logs)): ?>
            <?php foreach($logs as $log): ?>
                <tr>
                    <td><?= date('d/m/Y', strtotime($log['date_entry'])); ?></td> 
                    <td>
                        <?= $log['co_order']; ?>
                        <?php if(!empty($log['additional_notes'])): ?>
                            <br>
                            <?= $log['additional_notes']; ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr class="text-center">
                <td colspan="2">No Data found</td>
            </tr>
        <?php endif; ?>

    </tbody>
    
</table>