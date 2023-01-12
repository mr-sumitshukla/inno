<table id="datatable" class="table table-bordered nowrap w-100">
    <thead>
        <tr>
            <th>Sr no.</th>
            <th>Name</th>
            <th>Contact Number</th>
            <th>State</th>
            <th>City</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($all_data) {
            $i = 0;
            foreach ($all_data as $all) {
                $id = encryptId($all['id']);
        ?>
                <tr>
                    <td><?= ++$i; ?></td>
                    <td><?= $all['name'] ?></td>
                    <td><?= $all['contact_no'] ?></td>
                    <td><?= $all['state'] ?></td>
                    <td><?= $all['city'] ?></td>
                    <td>
                        <a href="<?= base_url("getPartnerForAssign?partner_id=$id&booking_id=$booking_id"); ?>" class="btn btn-success">Assign</a>
                    </td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>