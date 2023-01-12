<?php $this->load->view('admin/template/header', $title);
$id = $this->input->get('id');
?>

<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mt-3 mb-sm-0 font-size-18"><?= $title ?> - <?= $partner_details['name'] ?></h4>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="media">
                                <div class="media-body">
                                    <div class="text-muted">
                                        <h5>Payout</h5>
                                    </div>
                                </div>
                                <div class="dropdown ms-2">
                                    <button href="#" class="btn btn-primary btn-sm w-md" data-bs-toggle="modal" data-bs-target="#share">
                                        <i class="fa fa-money"></i> Pay
                                    </button>
                                    <a href="<?= base_url("payOutHistory?id=$id") ?>" class="btn btn-primary btn-sm w-md">History</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body border-top">
                            <div class="text-center">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div>
                                            <div class="font-size-24 text-primary mb-2">
                                                <i class="bx bx-send"></i>
                                            </div>
                                            <p class="text-muted mb-2">Total</p>
                                            <h5>&#8377; <?= $total_amount ?></h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mt-4 mt-sm-0">
                                            <div class="font-size-24 text-primary mb-2">
                                                <i class="bx bx-import"></i>
                                            </div>
                                            <p class="text-muted mb-2">Pay</p>
                                            <h5>&#8377; <?= $total_pay ?></h5>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="mt-4 mt-sm-0">
                                            <div class="font-size-24 text-primary mb-2">
                                                <i class="bx bx-wallet"></i>
                                            </div>
                                            <p class="text-muted mb-2">Remaining</p>
                                            <h5>&#8377; <?= round($total_amount - $total_pay) ?></h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="share" tabindex="-1" aria-labelledby="shareLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form method="post" action="" name="form_submit2">
                <div class="modal-body share">
                    <h3>Pay Partner Amount</h3>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label>Amount</label>
                                <input type="hidden" name="type" value="2">
                                <input type="text" class="form-control" name="amount">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label>Pay Method</label>
                                <select name="pay_type" required class="form-select">
                                    <option value="">Select Pay Method</option>
                                    <option value="Cash">Cash</option>
                                    <option value="Online">Online</option>
                                    <option value="Cheque">Cheque</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label>Remarks</label>

                                <input type="text" class="form-control" name="remark">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary  btn-st1" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success save">Pay</button>
                </div>
            </form>
        </div>
    </div>
</div>


<?php $this->load->view('admin/template/footer'); ?>
<script>
    $("form[name='form_submit2']").validate({
        errorClass: "error fail-alert",
        validClass: "valid success-alert",
        rules: {
            amount: {
                'required': true,
                'number': true,
                'max': <?= $total_amount - $total_pay ?>,
                'min': 1
            },
        },
        submitHandler: function(form) {
            $(".save").text("").html("Loading.. <i class='fa fa-spin fa-spinner'></i>").attr('disabled', true);
            form.submit();
        }
    });
</script>