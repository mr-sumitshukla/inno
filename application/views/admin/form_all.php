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
                                        <th>Registered Name</th>
                                        <th>Name</th>
                                        <th>Relationship</th>
                                        <th>Gender</th>
                                        <th>Language</th>
                                        <th>Medical Condition</th>
                                        <th>Additional Requirement</th>
                                        <th>Level of Mobility</th>
                                        <th>Level of Dependency</th>
                                        <th>Age</th>
                                        <th>Height</th>
                                        <th>Weight</th>
                                        <th>Image</th>
                                        <th>Action</th>
                                        <th>Message</th>
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
                                                <td><?= $item['create_date'] ?> </td>
                                                <td><?= $item['username'] ?> <br><?= $item['user_contact_no'] ?> </td>
                                                <td><?= $item['name'] ?></td>
                                                <td><?= $item['relationship'] ?></td>
                                                <td><?= $item['gender'] ?></td>
                                                <td><?= $item['language'] ?></td>
                                                <td><?= $item['medical_condition'] ?></td>
                                                <td><?= $item['additional_requirement'] ?></td>
                                                <td><?= $item['level_of_mobility'] ?></td>
                                                <td><?= $item['level_of_dependency'] ?></td>
                                                <td><?= $item['age'] ?></td>
                                                <td><?= $item['height'] ?></td>
                                                <td><?= $item['weight'] ?></td>
                                                <td>
                                                    <?php
                                                    if ($item['image'] != "") {
                                                    ?>
                                                        <a href="<?= base_url() . FORM_IMAGE . $item['image'] ?>" class="btn btn-success"><i class="fa fa-eye"></i> View</a>
                                                    <?php
                                                    } else {
                                                        echo "-----";
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <?php if ($item['status'] == '0') { ?>
                                                        <button type="button" class="btn btn-primary waves-effect waves-light verifyReq" id="<?= $id ?>">Accept</button>
                                                    <?php } else {
                                                        echo "-----";
                                                    } ?>
                                                </td>
                                                <td><?= $item['message'] ?></td>
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
                    <h5 class="modal-title" id="exampleModalScrollableTitle">Send Message</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label>Message</label>
                                <input type="hidden" name="id" class="id">
                                <textarea name="message" rows="5" class="form-control"></textarea>
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

<?php $this->load->view('admin/template/footer'); ?>
<script>
    $(document).on('click', '.verifyReq', function() {
        var id = $(this).attr('id');
        $('#verifyReq').modal('show');
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
</script>