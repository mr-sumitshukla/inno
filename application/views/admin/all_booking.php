<?php $this->load->view('admin/template/header', $title);
$date = $this->input->get('date');
?>
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-4">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h2 class="mb-sm-0 "><?= $title ?></h2>
                    </div>
                </div>
                <div class="col-6">
                    <form action="" method="get">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="input-group" id="datepicker1">
                                    <input type="text" class="form-control" data-date-format="dd-mm-yyyy" data-date-autoclose="true" readonly data-date-container='#datepicker1' data-provide="datepicker" name="date" value="<?= $date ?>">
                                </div>
                            </div>
                            <div class="col-lg-2">
                                <button type="submit" class="btn btn-primary">Search</button>
                            </div>
                            <div class="col-lg-2 mr-2">
                                <a href="<?= base_url('assignPartner') ?>" class="btn btn-success">Reset</a>
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
                                        <th>Transaction Id</th>
                                        <th>Booking Date</th>
                                        <th>Name</th>
                                        <th>Contact Number</th>
                                        <th>City</th>
                                        <th>Service Name</th>
                                        <th>Sub Service Name</th>
                                        <th>User Booking Date</th>
                                        <th>Partner Name</th>
                                        <th>Check In - Check Out</th>
                                        <th>Payment Mode</th>
                                        <th>Booking Status</th>
                                        <th>Booking Details</th>
                                        <th>Check In / Check Out</th>
                                        <th>Task</th>
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
                                                <td><?= $all['transaction_id'] ?></td>
                                                <td><?= date('d-M-Y h:i A', strtotime($all['create_date'])) ?></td>
                                                <td><?= $all['name'] ?></td>
                                                <td><?= $all['contact_no'] ?></td>
                                                <td><?= $all['city'] ?></td>
                                                <td><?= $all['service_name'] ?></td>
                                                <td><?= $all['sub_service_name'] ?></td>
                                                <td><?= $all['booking_date'] . ' ' . $all['booking_time'] ?></td>
                                                <td>
                                                    <?= $all['partner_name'] ?> <br>
                                                    <a href="tel:<?= $all['partner_contact_no'] ?>"><?= $all['partner_contact_no'] ?></a>
                                                </td>
                                                <td><?= $all['check_in_time'] . ' - ' . $all['check_in_time'] ?></td>
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
                                                    <?php
                                                    if ($all['booking_status'] == '1') {
                                                        echo '<span class="badge badge-pill badge-soft-primary font-size-14">Working</span>';
                                                    } else {
                                                        echo '<span class="badge badge-pill badge-soft-success font-size-14">Completed</span>';
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
                                                    <button class="btn btn-success" type="button" data-bs-toggle="modal" data-bs-target="#itemDetails2<?= $i ?>">
                                                        <i class="fa fa-eye"></i>
                                                        View
                                                    </button>

                                                    <div class="modal fade" id="itemDetails2<?= $i ?>" role="dialog" tabindex="-1">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title"><?= $all['name'] ?></h4>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row">
                                                                        <div class="col-lg-12">
                                                                            <table class="table table-bordered">
                                                                                <tr>
                                                                                    <th>Sr. no.</th>
                                                                                    <th>Date</th>
                                                                                    <th>Check In</th>
                                                                                    <th>Check Out</th>
                                                                                </tr>
                                                                                <?php
                                                                                if ($all['booking_status'] != '0') {
                                                                                    $getWork = getRowByMoreId('book_partner_work', "book_partner_id = '{$all['id']}'");
                                                                                    if ($getWork) {
                                                                                        $j = 0;
                                                                                        foreach ($getWork as $item) {
                                                                                ?>
                                                                                            <tr>
                                                                                                <td><?= ++$j; ?></td>
                                                                                                <td><?= date('d-m-Y h:i A', strtotime($item['create_date'])) ?></td>
                                                                                                <td><?= $item['check_in'] ?>
                                                                                                    <br>
                                                                                                    <a href="<?= "https://www.google.com/maps/place/{$item['check_in_lat']},{$item['check_in_long']}" ?>" target="_blank" style="pointer-events: <?= $item['check_in_lat'] == "" ? "none" : '' ?>;"> Location</a>
                                                                                                </td>
                                                                                                <td>
                                                                                                    <?php
                                                                                                    if ($item['check_out'] != "") {
                                                                                                        echo $item['check_out'];
                                                                                                    ?>
                                                                                                        <br>
                                                                                                        <a href="<?= "https://www.google.com/maps/place/{$item['check_out_lat']},{$item['check_out_long']}" ?>" target="_blank" style="pointer-events: <?= $item['check_out_lat'] == "" ? "none" : '' ?>;"> Location</a>
                                                                                                    <?php
                                                                                                    } else {
                                                                                                        echo "-----";
                                                                                                    }
                                                                                                    ?>
                                                                                                </td>
                                                                                            </tr>
                                                                                        <?php
                                                                                        }
                                                                                        ?>
                                                                                <?php
                                                                                    }
                                                                                }
                                                                                ?>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <a href="<?= base_url("addTask?booking_id=$id") ?>" class="btn btn-primary" target="_blank"><i class="fa fa-plus"></i> Add</a>
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