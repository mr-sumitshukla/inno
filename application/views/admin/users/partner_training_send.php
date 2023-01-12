<?php $this->load->view('admin/template/header', $title);
$p = json_decode(sessionId('privileges')); ?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h2 class="mb-sm-0 "><?= $title ?></h2>
                        <button class="btn btn-success btn-sm btn-round ml-2 book_service2" style="float: right;"><i class="feather icon-plus"></i> Send Message</button>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable21" class="table table-bordered  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th><input type="checkbox" class="checked_list"></th>
                                        <th>Registration Date</th>
                                        <th>name</th>
                                        <th>Contact Number</th>
                                        <th>Email</th>
                                        <th>Address</th>
                                        <th>Area</th>
                                        <th>Postal Code</th>
                                        <th>State / City</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($all_data) {
                                        $i = 0;
                                        foreach ($all_data as $all) {
                                            $id = encryptId($all['id']);
                                            $contact_no = $all['id'];
                                    ?>
                                            <tr>
                                                <td><?= ++$i; ?></td>
                                                <td><input type="checkbox" class="check_user" value="<?= $contact_no ?>"></td>
                                                <td><?= date("d-M-Y h:i A", strtotime($all['create_date'])) ?></td>
                                                <td><?= ucwords($all['name']) ?></td>
                                                <td><?= $all['contact_no'] ?></td>
                                                <td><?= $all['email_id'] ?></td>
                                                <td><?= $all['address'] ?></td>
                                                <td><?= $all['area'] ?></td>
                                                <td><?= $all['postal_code'] ?></td>
                                                <td><?= $all['state'] ?> <br> <?= $all['city'] ?></td>
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


<div class="modal fade" id="book_service2" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="post" action="" name="form_submit">
                <div class="modal-header">
                    <h4 class="modal-title" id="exampleModalScrollableTitle">Training</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label>Date</label>
                                <input type="date" name="date" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label>Time</label>
                                <input type="time" name="time" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label>Title</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label>Link</label>
                                <input type="text" name="link" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label>Message</label>
                                <input type="hidden" class="all_user_contact" name="all_contact">
                                <textarea name="message" class="form-control" rows="5" required></textarea>
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
    $(document).ready(function() {

        $('#datatable21').DataTable({
            paging: false,
            scrollX: true,
        });
    });

    $('.book_service2').click(function() {

        let user_contact = [];
        let check_user = 0;
        $(".check_user:checked").each(function() {
            ++check_user;
            user_contact.push($(this).val());
        });

        if (check_user > 0) {
            $('#book_service2').modal('show');
            $('.all_user_contact').val(JSON.stringify(user_contact));
        } else {
            alert('Please Select at least one user');
        }
    });

    $(document).on('click', '.checked_list', function() {
        if ($(this).is(':checked')) {
            $('.check_user').attr('checked', true);
        } else {
            $('.check_user').attr('checked', false);
        }
    });

    $("form[name='form_submit']").validate({
        errorClass: "error fail-alert",
        validClass: "valid success-alert",
        submitHandler: function(form) {
            $(".save").text("").html("Loading..").attr('disabled', true);
            form.submit();
        }
    });
</script>