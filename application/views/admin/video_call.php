<?php $this->load->view('admin/template/header', $title); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h2 class="mb-sm-0 "><?= $title ?></h2>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable2" class="table table-bordered nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sr No.</th>
                                        <th>Date</th>
                                        <th>Name</th>
                                        <?php if ($id_pending == '0') {
                                            echo "<th>Video Url</th>";
                                            echo "<th>Status</th>";
                                            echo "<th>Cancel Message</th>";
                                        } else {
                                            echo "<th>Status</th>";
                                            echo "<th>Action</th>";
                                        } ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($all_data) {
                                        $i = 0;
                                        foreach ($all_data as $item) {
                                            $i = $i + 1;
                                            $id = encryptId($item['id']);
                                    ?>
                                            <tr>
                                                <td><?= $i ?></td>
                                                <td><?= date('d-M-Y h:i A', strtotime($item['create_date'])) ?></td>
                                                <td><?= ucwords($item['name']) ?> <br> <a href="tel:<?= $item['contact_no'] ?>"><?= $item['contact_no'] ?></a> </td>
                                                <?php if ($id_pending == '0') {
                                                ?>
                                                    <td><?= $item['video_url'] == "" ? '-----' : $item['video_url'] ?> <br> Date - <?= $item['date'] ?> </td>
                                                    <td>
                                                        <?php
                                                        if ($item['status'] == '1') {
                                                            echo "<span class='badge bg-success'>Accept</span>";
                                                        } else {
                                                            echo "<span class='badge bg-danger'>Cancel</span>";
                                                        }
                                                        ?>
                                                    </td>
                                                    <td><?= $item['message'] == "" ? '-----' : $item['message'] ?></td>
                                                <?php
                                                } else {
                                                ?>
                                                    <td>
                                                        <span class='badge bg-success'>Pending</span>
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary waves-effect waves-light verifyReq" id="<?= $id ?>">Verify</button>
                                                        <button type="button" class="btn btn-danger waves-effect waves-light cancelReq" id="<?= $id ?>">Cancel</button>
                                                    </td>
                                                <?php
                                                } ?>
                                            </tr>
                                    <?php
                                        }
                                    } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="verifyReq" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="" name="form_submit">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Accept Video Call Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3" id="datepicker1">
                                <label>Date</label>
                                <input type="text" class="form-control" required name="date" readonly placeholder="dd-mm-yyyy" data-date-format="dd-mm-yyyy" data-date-container='#datepicker1' value="<?= date('d-m-Y') ?>" data-provide="datepicker" data-date-autoclose="true">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3" id="timepicker-input-group1">
                                <label>Time</label>
                                <input type="text" class="form-control" required name="time" placeholder="Enter Time">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label>Video Link</label>
                                <input type="hidden" name="id" class="id">
                                <input type="hidden" name="type" value="1">
                                <textarea name="link" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="cancelReq" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="" name="form_submit2">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalScrollableTitle1">Reject Video Call Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label>Cancel Message</label>
                                <textarea name="cancel_message" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <input type="hidden" name="type" value="2">
                        <input type="hidden" name="id" class="id">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary save">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->load->view('admin/template/footer'); ?>

<script>
    $(document).on('click', '.verifyReq', function() {
        var id = $(this).attr('id');
        $('#verifyReq').modal('show');
        $('.id').val(id);
    });

    $(document).on('click', '.cancelReq', function() {
        var id = $(this).attr('id');
        $('#cancelReq').modal('show');
        $('.id').val(id);
    });


    $("form[name='form_submit']").validate({
        errorClass: "error fail-alert",
        validClass: "valid success-alert",
        submitHandler: function(form) {
            $(".save").text("").html("Loading.. <i class='fa fa-spin fa-spinner'></i>").attr('disabled', true);
            form.submit();
        }
    });
    $("form[name='form_submit2']").validate({
        errorClass: "error fail-alert",
        validClass: "valid success-alert",
        submitHandler: function(form) {
            $(".save").text("").html("Loading.. <i class='fa fa-spin fa-spinner'></i>").attr('disabled', true);
            form.submit();
        }
    });
</script>