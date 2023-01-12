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
                                <a href="<?= base_url('assignProductBooking') ?>" class="btn btn-success">Reset</a>
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
                                        <?php
                                        if ($is_assign == 1) {
                                            echo "<th>Store Details</th>";
                                        }
                                        ?>
                                        <th>Payment Mode</th>
                                        <th>Transaction Id</th>
                                        <th>Booking Details</th>
                                        <th>Booking Product</th>
                                        <?php
                                        if ($is_assign == 0) {
                                            echo "<th>Assign Store</th>";
                                        }
                                        ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($all_data) {
                                        $i = 0;
                                        foreach ($all_data as $all) {
                                            $id = encryptId($all['id']);
                                            $get_store = getSingleRowById('stores', "id = '{$all['rental_store_id']}'");
                                    ?>
                                            <tr>
                                                <td><?= ++$i; ?></td>
                                                <td><?= date('d-M-Y h:i A', strtotime($all['create_date'])) ?></td>
                                                <td><?= $all['name'] ?></td>
                                                <td><?= $all['contact_no'] ?></td>
                                                <td><?= $all['city'] ?></td>
                                                <?php if ($is_assign == 1) { ?>
                                                    <td><?= $get_store['name'] ?> <br> <a href="tel:<?= $get_store['contact_no'] ?>"><?= $get_store['contact_no'] ?></a> </td>
                                                <?php } ?>
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
                                                <td><?= $all['transaction_id'] ?></td>
                                                <td>
                                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal<?= $i ?>">
                                                        <i class="fa fa-eye"></i>
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
                                                                                    <h5><strong>Final Amount</strong></h5>
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
                                                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-bs-target="#modal_item<?= $i ?>">
                                                        <i class="fa fa-eye"></i>
                                                        View
                                                    </button>

                                                    <div class="modal fade bs-example-modal-lg" id="modal_item<?= $i ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-lg">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="myLargeModalLabel"><?= $all['name'] ?></h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <table class="table table-bordered">
                                                                        <thead>
                                                                            <tr>
                                                                                <td>Sr. No.</td>
                                                                                <td>Product Name</td>
                                                                                <td>No Of Items</td>
                                                                                <td>Amount</td>
                                                                                <td>Total</td>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php
                                                                            $getItem  = getRowByMoreId('rental_book_item', "book_product_id = '{$all['id']}'");
                                                                            if ($getItem) {
                                                                                $j = 0;
                                                                                foreach ($getItem as $item_list) {
                                                                                    $getProduct = getSingleRowById('rental_product', "id = '{$item_list['product_id']}'");
                                                                            ?>
                                                                                    <tr>
                                                                                        <td><?= ++$j ?></td>
                                                                                        <td><?= $getProduct['product_name'] ?></td>
                                                                                        <td><?= $item_list['no_of_items'] ?></td>
                                                                                        <td>&#8377; <?= $item_list['amount'] ?></td>
                                                                                        <td>&#8377; <?= $item_list['final_amount'] ?></td>
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
                                                </td>

                                                <?php if ($is_assign == 0) { ?>
                                                    <td>
                                                        <button class="btn btn-success viewDetails" datafld="<?= $i ?>" id="<?= $id ?>" type="button">
                                                            <i class="fa fa-eye loader<?= $i ?>"></i>&nbsp;
                                                            View
                                                        </button>
                                                    </td>
                                                <?php } ?>
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
    <div class="modal-dialog  modal-lg modal-dialog-top modal-dialog-scrollable" role="document">
        <div class="modal-content" id="book_service">
            <div class="modal-header">
                <h4>All Store</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="setData">

            </div>
        </div>
    </div>
</div>

<?php $this->load->view('admin/template/footer'); ?>

<script>
    $(document).on('click', '.viewDetails', function() {
        var id = $(this).attr('id');
        var productId = $(this).attr('datafld');
        $('#book_service').modal('show');
        $.ajax({
            type: "GET",
            url: "<?= base_url("getStoreForAssign") ?>",
            data: {
                id: id
            },
            beforeSend: function() {
                $('.loader' + productId).addClass('fa-spinner fa-spin');
            },
            success: function(data) {
                $("#setData").html(data);
                $('.loader' + productId).removeClass('fa-spinner fa-spin');
            }
        });
    });
</script>