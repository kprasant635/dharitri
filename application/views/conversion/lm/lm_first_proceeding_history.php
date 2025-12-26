<div class="row mt-2">
    <div class="col-md-12">
        <div class="card card-success">
            <div class="card-header text-center">
                <h5>Proceeding History (Case No: <?php echo $case_no; ?>)</h5>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr class="text-bold table-success">
                            <th>Dated</th>
                            <th>CO Order</th>
                            <th>Note on Order</th>
                            <th>Order Given By</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($petition_proceedings as $petition_proceeding): ?>
                            <tr>
                                <td><?php echo date('d-m-Y', strtotime($petition_proceeding->date_entry)); ?></td>
                                <td><?php echo $petition_proceeding->co_order; ?></td>
                                <td><?php echo $petition_proceeding->note_on_order; ?></td>
                                <td><?php echo $petition_proceeding->user_name; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>