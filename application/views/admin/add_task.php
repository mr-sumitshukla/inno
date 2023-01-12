<?php $this->load->view('admin/template/header', $title);
$id = $this->input->get('id');
$booking_id = $this->input->get('booking_id');
?>
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-center">
                        <h2 class="mb-sm-0 "><?= $title ?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="card">
                        <div class="card-body">
                            <form action="" method="post" enctype="multipart/form-data" name="form_submit">
                                <div class="row">
                                    <div class="col-lg-12 mb-3">
                                        <div class="row">
                                            <label for="example-text-input" class="col-md-3 col-form-label">Title</label>
                                            <div class="col-md-9" id="datepicker1">
                                                <input type="text" class="form-control" data-date-format="dd-mm-yyyy" readonly data-date-container='#datepicker1' data-date-autoclose="true" data-provide="datepicker" name="task_date" value="<?= $task_date == "" ? date('d-m-Y') : $task_date ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-3">
                                        <div class="row">
                                            <label for="example-text-input" class="col-md-3 col-form-label">Task Title</label>
                                            <div class="col-md-9">
                                                <input class="form-control" type="text" name="task_title" required value="<?= $task_title ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 mb-3">
                                        <div class="row">
                                            <label for="example-text-input" class="col-md-3 col-form-label">Task Description</label>
                                            <div class="col-md-9">
                                                <textarea class="form-control" name="task_description" rows="5"><?= $task_description ?></textarea>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="text-center">
                                    <button type="submit" id="save" class="btn btn-primary w-md">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable2" style="width: 100%;" class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>Date</th>
                                        <th>Title</th>
                                        <th>Description</th>
                                        <th>Task Status</th>
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
                                                <td><?= $all['task_date'] ?></td>
                                                <td><?= $all['task_title'] ?></td>
                                                <td><?= $all['task_description'] ?></td>
                                                <td>
                                                    <?php if ($all['task_status'] == '0') {
                                                    ?>
                                                        <span class="badge bg-warning">Pending</span>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <span class="badge bg-success">Complete</span><br>
                                                        <?= date('d-M-Y h:i A', strtotime($all['task_complete_date'])) ?>
                                                    <?php
                                                    } ?>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url("addTask?booking_id=$booking_id&id=$id"); ?>" class="btn btn-success"><i class="fa fa-edit"></i> Edit</a>
                                                    <a onclick="return confirm('Are you want to sure ?')" href="<?= base_url("addTask?booking_id=$booking_id&dID=$id"); ?>" class="btn btn-danger"><i class="fa fa-trash"></i> Delete</a>
                                                </td>
                                            </tr>
                                    <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/template/footer'); ?>

<script>
    $("form[name='form_submit']").validate({
        errorClass: "error fail-alert",
        validClass: "valid success-alert",
        submitHandler: function(form) {
            $("#save").text("").html("Loading.. <i class='fa fa-spin fa-spinner'></i>").attr('disabled', true);
            form.submit();
        }
    });
</script>