<?php $this->load->view('admin/template/header', $title);
$date = $this->input->get('date');
?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h3 class="mb-sm-0 "><?= $title ?></h3>
                    </div>
                </div>
                <div class="col-6">
                    <form action="" method="get">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group" id="datepicker1">
                                    <input type="text" class="form-control" data-date-format="dd-mm-yyyy" readonly data-date-container='#datepicker1' data-provide="datepicker" name="date" value="<?= $date ?>">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                            <div class="col-lg-2 mr-2">
                                <a href="<?= base_url('newPartnerBooking') ?>" class="btn btn-success">Reset</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable2" class="table table-bordered nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>Sr no.</th>
                                        <th>Booking Date</th>
                                        <th>Name</th>
                                        <th>Contact Number</th>
                                        <th>City</th>
                                        <th>Service Name</th>
                                        <th>Sub Service Name</th>
                                        <th>User Booking Date</th>
                                        <th>Payment Mode</th>
                                        <th>Booking Details</th>
                                        <th>Assign Partner</th>
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
                                                <td><?= date('d-M-Y h:i A', strtotime($all['create_date'])) ?></td>
                                                <td><?= $all['name'] ?></td>
                                                <td><?= $all['contact_no'] ?></td>
                                                <td><?= $all['city'] ?></td>
                                                <td><?= $all['service_name'] ?></td>
                                                <td><?= $all['sub_service_name'] ?></td>
                                                <td><?= $all['booking_date'] . ' ' . $all['booking_time'] ?></td>
                                                <td>
                                                    <?php
                                                    if ($all['payment_mode'] == '2') {
                                                        echo '<span class="badge badge-pill badge-soft-primary font-size-14">COD</span>';
                                                    } else {
                                                        echo '<span class="badge badge-pill badge-soft-primary font-size-14 mb-2">ONLINE - </span>';
                                                        if ($all['transaction_status'] == '0') {
                                                            echo '<span class="badge badge-pill badge-soft-warning font-size-14">Pending</span>';
                                                        } else if ($all['transaction_status'] == '1') {
                                                            echo '<span class="badge badge-pill badge-soft-success font-size-14">Success</span>';
                                                        } else {
                                                            echo '<span class="badge badge-pill badge-soft-danger font-size-14">Cancel</span>';
                                                        }
                                                    }
                                                    ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal<?= $i ?>">
                                                        <i class="fa fa-eye loader<?= $all['user_id'] ?>"></i>
                                                        View
                                                    </button>

                                                    <div class="modal fade bs-example-modal-lg" id="modal<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="myLargeModalLabel"><?= $all['name'] ?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-6">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>Name</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['name'] ?></h5>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>Phone</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['contact_no'] ?></h5>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>Address</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= str_replace("/", "'", $all['address']) ?></h5>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>Area</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['area'] ?></h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>Pin Code</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['postal_code'] ?></h5>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>State</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['state'] ?></h5>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>City</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['city'] ?></h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <hr>
                                                                        <div class="col-lg-6">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>Service</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['service_name'] ?></h5>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>Booking Date</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['booking_date'] ?></h5>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>Days</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['no_of_days'] ?></h5>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>Final Amount</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['final_amount'] ?></h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>Sub Service</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['sub_service_name'] ?></h5>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>Booking Time</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['booking_time'] ?></h5>
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>Service Amount</strong></h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['amount'] ?></h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <hr style="border: 1px solid #9c9c9c;">
                                                                            <h4 style="text-align: center">
                                                                                <b>Transaction Details</b>
                                                                            </h4>
                                                                        </div>
                                                                        <div class="col-lg-6">
                                                                            <div class="row">
                                                                                <div class="col-lg-6">
                                                                                    <h5><strong>Payment Mode</strong>
                                                                                    </h5>
                                                                                </div>
                                                                                <div class="col-lg-6">
                                                                                    <h5><?= $all['payment_mode'] == '1' ? 'Online' : 'Cash' ?></h5>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <?php
                                                    if ($all['payment_mode'] == '2') {
                                                    ?>
                                                        <button class="btn btn-success viewDetails" datafld="<?= $i ?>" id="<?= $id ?>" type="button">
                                                            <i class="fa fa-eye loader<?= $i ?>"></i>&nbsp;
                                                            View
                                                        </button>
                                                    <?php
                                                    } else  if ($all['payment_mode'] == '1' and $all['transaction_status'] == '1') {
                                                    ?>
                                                        <button class="btn btn-success viewDetails" datafld="<?= $i ?>" id="<?= $id ?>" type="button">
                                                            <i class="fa fa-eye loader<?= $i ?>"></i>&nbsp;
                                                            View
                                                        </button>
                                                    <?php
                                                    } else {
                                                        echo "-----";
                                                    }
                                                    ?>

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


<div class="modal fade" id="book_service" tabindex="-1" role="dialog" aria-labelledby="book_service" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-top modal-dialog-scrollable" role="document">
        <div class="modal-content" id="book_service">
            <div class="modal-header">
                <h4>All Partner</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="post" name="form_submit">
                <div class="modal-body" id="setData">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label>Check In Time</label>
                                <input type="time" class="form-control" required name="check_in_time">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label>Check Out Time</label>
                                <input type="time" class="form-control" required name="check_out_time">
                                <input type="hidden" class="booking_id" name="booking_id">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label>Partner</label>
                                <select name="partner_id" class="form-select" required>
                                    <option value="">Select Partner</option>
                                    <?php
                                    if ($all_partner) {
                                        foreach ($all_partner as $partner_list) {
                                    ?>
                                            <option value="<?= $partner_list['id'] ?>"><?= $partner_list['name'] . "( " . $partner_list['contact_no'] . " )" ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
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
    $(document).on('click', '.viewDetails', function() {
        var id = $(this).attr('id');
        var productId = $(this).attr('datafld');
        $('#book_service').modal('show');
        $('.booking_id').val(id);
        // $.ajax({
        //     type: "GET",
        //     url: "<?= base_url("getPartnerForAssign") ?>",
        //     data: {
        //         id: id
        //     },
        //     beforeSend: function() {
        //         $('.loader' + productId).addClass('fa-spinner fa-spin');
        //     },
        //     success: function(data) {
        //         $("#setData").html(data);
        //         $('.loader' + productId).removeClass('fa-spinner fa-spin');
        //     }
        // });
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